<?php
namespace Controllers;

use Models\User;
use Models\Customer;
use Models\Mechanic;

/**
 * AuthController.php
 * ------------------
 * Επεξεργασία φόρμας εγγραφής, login & logout.
 * Προσθήκη back-end validation και διατήρησης τιμών σε περίπτωση σφάλματος.
 */
class AuthController {
    private \PDO $pdo;
    private User $userModel;
    private Customer $custModel;
    private Mechanic $mechModel;

    public function __construct(\PDO $pdo) {
        // Αποθηκεύουμε το PDO και δημιουργούμε τα μοντέλα
        $this->pdo        = $pdo;
        $this->userModel  = new User($pdo);
        $this->custModel  = new Customer($pdo);
        $this->mechModel  = new Mechanic($pdo);
    }

    /**
     * Εμφανίζει τη φόρμα εγγραφής.
     */
    public function registerForm(): void {
        $token = generateCsrfToken();
        include __DIR__ . '/../../views/register.php';
    }

    /**
     * Διαχειρίζεται το POST αίτημα εγγραφής.
     * Σε περίπτωση σφάλματος αποθηκεύει τα πεδία σε $_SESSION['old'].
     */
    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'
            || !verifyCsrfToken($_POST['_csrf'] ?? '')
        ) {
            http_response_code(400);
            exit('Invalid request');
        }

        // Αποθηκεύουμε όλα τα POST δεδομένα σε περίπτωση σφάλματος
        $_SESSION['old'] = [
            'username'        => trim($_POST['username'] ?? ''),
            'first_name'      => trim($_POST['first_name'] ?? ''),
            'last_name'       => trim($_POST['last_name'] ?? ''),
            'identity_number' => trim($_POST['identity_number'] ?? ''),
            'role'            => $_POST['role'] ?? '',
            'tax_id'          => $_POST['tax_id'] ?? '',
            'address'         => $_POST['address'] ?? '',
            'specialty'       => $_POST['specialty'] ?? ''
        ];

        // 1) Έλεγχος ότι τα βασικά πεδία υπάρχουν
        $required = [
            'username',
            'password',
            'first_name',
            'last_name',
            'identity_number',
            'role'
        ];
        foreach ($required as $field) {
            if (empty(trim($_POST[$field] ?? ''))) {
                $_SESSION['error'] = "Το πεδίο «{$field}» είναι υποχρεωτικό.";
                header('Location: register.php');
                exit;
            }
        }

        // 2) Έλεγχος ρόλου
        $role = $_POST['role'];
        if (!in_array($role, ['customer','mechanic'], true)) {
            $_SESSION['error'] = 'Μη έγκυρος ρόλος.';
            header('Location: register.php');
            exit;
        }

        // 3) Extra πεδία ανάλογα με το role
        if ($role === 'customer') {
            if (empty(trim($_POST['tax_id'] ?? '')) || empty(trim($_POST['address'] ?? ''))) {
                $_SESSION['error'] = 'Τα πεδία «Tax ID» και «Address» είναι υποχρεωτικά για πελάτη.';
                header('Location: register.php');
                exit;
            }
        }
        if ($role === 'mechanic') {
            if (empty(trim($_POST['specialty'] ?? ''))) {
                $_SESSION['error'] = 'Το πεδίο «Specialty» είναι υποχρεωτικό για μηχανικό.';
                header('Location: register.php');
                exit;
            }
        }

        // 4) Έλεγχος username: τουλάχιστον 4 χαρακτήρες, μόνο αλφαριθμητικά
        $username = trim($_POST['username']);
        if (strlen($username) < 4 || !ctype_alnum($username)) {
            $_SESSION['error'] = 'Το username πρέπει να έχει τουλάχιστον 4 χαρακτήρες και μόνο λατινικούς/αριθμούς.';
            header('Location: register.php');
            exit;
        }
        // Έλεγχος μοναδικότητας username
        $existingUser = $this->userModel->findByUsername($username);
        if ($existingUser) {
            $_SESSION['error'] = 'Το username είναι ήδη κατειλημμένο.';
            header('Location: register.php');
            exit;
        }

        // 5) Έλεγχος identity_number: 2 γράμματα + 6 ψηφία
        $identity = trim($_POST['identity_number']);
        if (!preg_match('/^[A-Za-z]{2}\d{6}$/', $identity)) {
            $_SESSION['error'] = 'Ο Αριθμός Ταυτότητας πρέπει να αποτελείται από 2 γράμματα ακολουθούμενα από 6 ψηφία.';
            header('Location: register.php');
            exit;
        }
        // Έλεγχος μοναδικότητας identity_number
        $stmtId = $this->pdo->prepare("
            SELECT COUNT(*) AS cnt
            FROM `user`
            WHERE identity_number = :identity
        ");
        $stmtId->execute([':identity' => $identity]);
        $rowId = $stmtId->fetch(\PDO::FETCH_ASSOC);
        if ($rowId && (int)$rowId['cnt'] > 0) {
            $_SESSION['error'] = 'Ο συγκεκριμένος Αριθμός Ταυτότητας υπάρχει ήδη.';
            header('Location: register.php');
            exit;
        }

        // 6) Έλεγχος password policy: min 8 χαρακτήρες, 1 γράμμα, 1 αριθμός
        $pw = $_POST['password'];
        if (strlen($pw) < 8
            || !preg_match('/[A-Za-z]/', $pw)
            || !preg_match('/\d/', $pw)
        ) {
            $_SESSION['error'] = 'Το password πρέπει να έχει τουλάχιστον 8 χαρακτήρες, ένα γράμμα και έναν αριθμό.';
            header('Location: register.php');
            exit;
        }

        // 7) Αν role = customer, έλεγχος tax_id: ακριβώς 9 ψηφία
        if ($role === 'customer') {
            $taxId = trim($_POST['tax_id']);
            if (!preg_match('/^\d{9}$/', $taxId)) {
                $_SESSION['error'] = 'Το Tax ID (ΑΦΜ) πρέπει να αποτελείται από 9 ψηφία.';
                header('Location: register.php');
                exit;
            }
            // Έλεγχος μοναδικότητας tax_id στον πίνακα customer
            $stmtTax = $this->pdo->prepare("
                SELECT COUNT(*) AS cnt
                FROM `customer`
                WHERE tax_id = :taxId
            ");
            $stmtTax->execute([':taxId' => $taxId]);
            $rowTax = $stmtTax->fetch(\PDO::FETCH_ASSOC);
            if ($rowTax && (int)$rowTax['cnt'] > 0) {
                $_SESSION['error'] = 'Το Tax ID (ΑΦΜ) υπάρχει ήδη καταχωρημένο.';
                header('Location: register.php');
                exit;
            }
        }

        // 8) Όλα τα validations πέρασαν → δημιουργούμε τον χρήστη
        try {
            $userId = $this->userModel->create([
                'username'        => $username,
                'password'        => $pw,
                'first_name'      => trim($_POST['first_name']),
                'last_name'       => trim($_POST['last_name']),
                'identity_number' => $identity,
                'role'            => $role
            ]);

            if ($role === 'customer') {
                $this->custModel->create([
                    'user_id' => $userId,
                    'tax_id'  => $taxId,
                    'address' => trim($_POST['address'])
                ]);
            } else { // role = mechanic
                $this->mechModel->create([
                    'user_id'   => $userId,
                    'specialty' => trim($_POST['specialty'])
                ]);
            }

            // Καθαρίζουμε το old data αφού όλα πέτυχαν
            unset($_SESSION['old']);

            $_SESSION['success'] = 'Έγινε εγγραφή! Περιμένετε έγκριση από γραμματέα.';
            header('Location: login.php');
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Σφάλμα κατά την εγγραφή: ' . $e->getMessage();
            header('Location: register.php');
        }

        exit;
    }

    /**
     * Εμφανίζει τη φόρμα login.
     */
    public function loginForm(): void {
        $token = generateCsrfToken();
        include __DIR__ . '/../../views/login.php';
    }

    /**
     * Διαχειρίζεται το POST αίτημα login.
     */
    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'
            || !verifyCsrfToken($_POST['_csrf'] ?? '')
        ) {
            http_response_code(400);
            exit('Invalid request');
        }

        $user = $this->userModel->findByUsername($_POST['username'] ?? '');
        if (!$user || !password_verify($_POST['password'] ?? '', $user['password'])) {
            $_SESSION['error'] = 'Λάθος στοιχεία σύνδεσης.';
            header('Location: login.php');
            exit;
        }
        if (!$user['is_active']) {
            $_SESSION['error'] = 'Ο λογαριασμός δεν έχει ενεργοποιηθεί ακόμα.';
            header('Location: login.php');
            exit;
        }

        // Επιτυχής login
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role']    = $user['role'];
        header('Location: dashboard.php');
        exit;
    }

    /**
     * Διαχειρίζεται το logout.
     */
    public function logout(): void {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}

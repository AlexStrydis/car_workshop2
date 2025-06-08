<?php
namespace Controllers;

use Models\User;
use Models\Customer;
use Models\Mechanic;

class UsersController {
    private \PDO $pdo;
    private User $userModel;

    public function __construct(\PDO $pdo) {
        $this->pdo       = $pdo;
        $this->userModel = new User($pdo);
    }

    /**
     * Εμφάνιση φόρμας δημιουργίας νέου χρήστη (μόνο για secretary)
     */
    public function createForm(): void {
        requireLogin();
        requireRole('secretary');

        $token = generateCsrfToken();
        include __DIR__ . '/../../views/user_create.php';
    }

    /**
     * Δημιουργία νέου χρήστη (POST)
     */
    public function create(): void {
        requireLogin();
        requireRole('secretary');

        if (!verifyCsrfToken($_POST['_csrf'] ?? '')) {
            http_response_code(400);
            exit('Invalid CSRF');
        }

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

        $required = ['username','password','first_name','last_name','identity_number','role'];
        foreach ($required as $f) {
            if (empty(trim($_POST[$f] ?? ''))) {
                $_SESSION['errors'][$f] = 'Απαιτείται.';
            }
        }

        $role = $_POST['role'] ?? '';
        if (!in_array($role, ['customer','mechanic','secretary'], true)) {
            $_SESSION['errors']['role'] = 'Μη έγκυρος ρόλος';
        }

        if ($role === 'customer') {
            if (empty(trim($_POST['tax_id'] ?? '')) || !preg_match('/^\d{9}$/', trim($_POST['tax_id']))) {
                $_SESSION['errors']['tax_id'] = 'Απαιτείται ΑΦΜ 9 ψηφίων';
            }
            if (empty(trim($_POST['address'] ?? ''))) {
                $_SESSION['errors']['address'] = 'Απαιτείται διεύθυνση';
            }
        }
        if ($role === 'mechanic') {
            if (empty(trim($_POST['specialty'] ?? ''))) {
                $_SESSION['errors']['specialty'] = 'Απαιτείται ειδικότητα';
            }
        }

        $username = trim($_POST['username'] ?? '');
        if ($username === '' || strlen($username) < 4 || !ctype_alnum($username)) {
            $_SESSION['errors']['username'] = 'Μη έγκυρο username';
        } elseif ($this->userModel->findByUsername($username)) {
            $_SESSION['errors']['username'] = 'Το username χρησιμοποιείται';
        }

        $identity = trim($_POST['identity_number'] ?? '');
        if (!preg_match('/^[A-Za-z]{2}\d{6}$/', $identity)) {
            $_SESSION['errors']['identity_number'] = 'Μη έγκυρη ταυτότητα';
        }

        $pw = $_POST['password'] ?? '';
        if (strlen($pw) < 8 || !preg_match('/[A-Za-z]/', $pw) || !preg_match('/\d/', $pw)) {
            $_SESSION['errors']['password'] = 'Σύνθετος κωδικός τουλάχιστον 8 χαρακτήρες';
        }

        if (!empty($_SESSION['errors'])) {
            header('Location: create_user.php');
            exit;
        }

        try {
            $uid = $this->userModel->create([
                'username'        => $username,
                'password'        => $pw,
                'first_name'      => trim($_POST['first_name']),
                'last_name'       => trim($_POST['last_name']),
                'identity_number' => $identity,
                'role'            => $role,
                'is_active'       => 1
            ]);
            if ($role === 'customer') {
                $custModel = new \Models\Customer($this->pdo);
                $custModel->create([
                    'user_id' => $uid,
                    'tax_id'  => trim($_POST['tax_id']),
                    'address' => trim($_POST['address'])
                ]);
            } elseif ($role === 'mechanic') {
                $mechModel = new \Models\Mechanic($this->pdo);
                $mechModel->create([
                    'user_id'   => $uid,
                    'specialty' => trim($_POST['specialty'])
                ]);
            }

            unset($_SESSION['old']);
            $_SESSION['success'] = 'Ο χρήστης δημιουργήθηκε.';
            header('Location: users.php');
            return;
        } catch (\Exception $e) {
            $_SESSION['errors']['general'] = 'Σφάλμα: ' . $e->getMessage();
            header('Location: create_user.php');
            return;
        }
    }

    /**
     * 1. List & Search users
     */
    public function list(): void {
        requireLogin();
        requireRole('secretary');

        // Διαβάζουμε φίλτρα από GET
        $criteria = [];
        if (!empty($_GET['username'])) {
            $criteria['username'] = trim($_GET['username']);
        }
        if (!empty($_GET['last_name'])) {
            $criteria['last_name'] = trim($_GET['last_name']);
        }
        if (!empty($_GET['identity_number'])) {
            $criteria['identity_number'] = trim($_GET['identity_number']);
        }
        if (!empty($_GET['role'])) {
            $criteria['role'] = trim($_GET['role']);
        }
        if (isset($_GET['status']) && $_GET['status'] !== '') {
            $criteria['is_active'] = (int)$_GET['status'];
        }

        $mode = $_GET['mode'] ?? 'all';
        if ($mode === 'pending') {
            $users = $this->userModel->getPending();
        } else {
            $users = $this->userModel->search($criteria);
        }

        include __DIR__ . '/../../Views/users.php';
    }

    /**
     * 2. Show edit form
     */
    public function editForm(): void {
        requireLogin();
        requireRole('secretary');

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: users.php');
            exit;
        }

        $user = $this->userModel->findById($id);
        if (!$user) {
            $_SESSION['success'] = 'User not found.';
            header('Location: users.php');
            exit;
        }

        include __DIR__ . '/../../Views/user_form.php';
    }

    /**
     * 3. Process edit submission
     */
    public function update(): void {
        requireLogin();
        requireRole('secretary');

        if (!verifyCsrfToken($_POST['_csrf'] ?? '')) {
            http_response_code(400);
            exit('Invalid CSRF');
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            header('Location: users.php');
            exit;
        }

        $data = [
            'username'        => trim($_POST['username'] ?? ''),
            'first_name'      => trim($_POST['first_name'] ?? ''),
            'last_name'       => trim($_POST['last_name'] ?? ''),
            'identity_number' => trim($_POST['identity_number'] ?? ''),
            'role'            => trim($_POST['role'] ?? ''),
            'is_active'       => isset($_POST['is_active']) && $_POST['is_active'] === '1' ? 1 : 0,
        ];

        $ok = $this->userModel->update($id, $data);
        $_SESSION['success'] = $ok ? 'User updated.' : 'Update failed.';
        header('Location: users.php');
        exit;
    }

    /**
     * 4. Activate pending user
     */
    public function activate(): void {
        requireLogin();
        requireRole('secretary');

        if (!verifyCsrfToken($_POST['_csrf'] ?? '')) {
            http_response_code(400);
            exit('Invalid CSRF');
        }

        $id = (int)($_POST['user_id'] ?? 0);
        if ($id > 0) {
            $ok = $this->userModel->activate($id);
            $_SESSION['success'] = $ok ? 'User activated.' : 'Activation failed.';
        }
        header('Location: users.php?mode=pending');
        exit;
    }

    /**
     * 5. Delete user
     */
    public function delete(): void {
        requireLogin();
        requireRole('secretary');

        if (!verifyCsrfToken($_POST['_csrf'] ?? '')) {
            http_response_code(400);
            exit('Invalid CSRF');
        }

        $id = (int)($_POST['user_id'] ?? 0);
        if ($id > 0) {
            $ok = $this->userModel->delete($id);
            $_SESSION['success'] = $ok ? 'User deleted.' : 'Delete failed.';
        }
        header('Location: users.php');
        exit;
    }
}

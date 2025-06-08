<?php
namespace Controllers;

use Models\Car;
use Models\Customer;
use Models\User;

class CarController {
    private \PDO     $pdo;
    private Car      $carModel;
    private User     $userModel;
    private Customer $custModel;

    public function __construct(\PDO $pdo) {
        $this->pdo       = $pdo;
        $this->carModel  = new Car($pdo);
        $this->userModel = new User($pdo);
        $this->custModel = new Customer($pdo);
    }

    /**
     * Λίστα αυτοκινήτων
     */
    public function list(): void {
        requireLogin();
        $criteria = [];
        if ($_SESSION['role'] === 'customer') {
            $criteria['owner_id'] = $_SESSION['user_id'];
        } else {
            requireRole('secretary','mechanic');
        }
        if (!empty($_GET['serial'])) {
            $criteria['serial'] = trim($_GET['serial']);
        }
        if (!empty($_GET['model'])) {
            $criteria['model'] = trim($_GET['model']);
        }
        if (!empty($_GET['brand'])) {
            $criteria['brand'] = trim($_GET['brand']);
        }
        $page   = isset($_GET['page']) && ctype_digit($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $cars       = $this->carModel->search($criteria, $limit, $offset);
        $totalCount = $this->carModel->countAll($criteria);
        $totalPages = (int)ceil($totalCount / $limit);

        // Μετατροπή owner_id σε owner_name
        foreach ($cars as &$c) {
            $u = $this->userModel->findById($c['owner_id']);
            $c['owner_name'] = $u ? $u['last_name'].' '.$u['first_name'] : 'Unknown';
        }
        unset($c);

        $token = generateCsrfToken();
        include __DIR__ . '/../../views/cars.php';
    }

    /**
     * Φόρμα για νέο αυτοκίνητο
     */
    public function createForm(): void {
        requireLogin();
        requireRole('secretary','customer');

        $token = generateCsrfToken();

        // --- μόνο customers, όχι όλοι οι users ---
       if ($_SESSION['role'] === 'secretary') {
    $users = $this->custModel->search();  // τώρα το ονομάζουμε users
} else {
    $users = [];
}

include __DIR__ . '/../../views/car_form.php';

    }

    /**
     * Δημιουργία νέου αυτοκινήτου (POST)
     */
    public function create(): void {
        requireLogin();
        requireRole('secretary','customer');

        if (!verifyCsrfToken($_POST['_csrf'] ?? '')) {
            http_response_code(400);
            exit('Invalid CSRF');
        }

        // Αποθήκευση old data
        $_SESSION['old_car'] = [
            'serial_number'   => $_POST['serial_number']   ?? '',
            'model'           => $_POST['model']           ?? '',
            'brand'           => $_POST['brand']           ?? '',
            'type'            => $_POST['type']            ?? '',
            'drive_type'      => $_POST['drive_type']      ?? '',
            'door_count'      => $_POST['door_count']      ?? '',
            'wheel_count'     => $_POST['wheel_count']     ?? '',
            'production_date' => $_POST['production_date'] ?? '',
            'acquisition_year'=> $_POST['acquisition_year']?? '',
        ];

        $serial = trim($_SESSION['old_car']['serial_number']);

        // Έλεγχος duplicate serial
        if ($this->carModel->findBySerial($serial)) {
            $_SESSION['error'] = "Το serial number «{$serial}» υπάρχει ήδη.";
            header('Location: create_car.php');
            exit;
        }

        // Validation limits ανά τύπο
        $type   = $_POST['type'] ?? '';
        $doors  = (int)($_POST['door_count'] ?? 0);
        $wheels = (int)($_POST['wheel_count'] ?? 0);
        $limits = [
            'passenger'=>['doors_max'=>7,'wheels_min'=>4,'wheels_max'=>4],
            'truck'    =>['doors_max'=>4,'wheels_min'=>4,'wheels_max'=>18],
            'bus'      =>['doors_max'=>3,'wheels_min'=>4,'wheels_max'=>8],
        ];
        if (!isset($limits[$type])) {
            $_SESSION['error'] = 'Άγνωστος τύπος οχήματος.';
            header('Location: create_car.php');
            exit;
        }
        $cfg = $limits[$type];
        if ($doors < 1 || $doors > $cfg['doors_max']
         || $wheels < $cfg['wheels_min'] || $wheels > $cfg['wheels_max']) {
            $_SESSION['error'] = "Για $type: πόρτες έως {$cfg['doors_max']} και ρόδες {$cfg['wheels_min']}–{$cfg['wheels_max']}.";
            header('Location: create_car.php');
            exit;
        }

        // Υπολογισμός owner_id
        $ownerId = ($_SESSION['role'] === 'secretary')
                 ? (int)($_POST['owner_id'] ?? 0)
                 : $_SESSION['user_id'];

        // Έλεγχος ότι ο owner είναι πραγματικός πελάτης
        if (!$this->custModel->findByUserId($ownerId)) {
            $_SESSION['error'] = 'Ο επιλεγμένος ιδιοκτήτης δεν υπάρχει ως πελάτης.';
            header('Location: create_car.php');
            exit;
        }

        // Προετοιμασία δεδομένων
        $data = [
            'serial_number'   => $serial,
            'model'           => trim($_SESSION['old_car']['model']),
            'brand'           => trim($_SESSION['old_car']['brand']),
            'type'            => $type,
            'drive_type'      => $_POST['drive_type'] ?? '',
            'door_count'      => $doors,
            'wheel_count'     => $wheels,
            'production_date' => $_SESSION['old_car']['production_date'] ?: null,
            'acquisition_year'=> $_SESSION['old_car']['acquisition_year']?: null,
            'owner_id'        => $ownerId,
        ];

        try {
            $ok = $this->carModel->create($data);
            unset($_SESSION['old_car']);
            $_SESSION['success'] = $ok ? 'Car created.' : 'Creation failed.';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }

        header('Location: cars.php');
        exit;
    }

    /**
     * Φόρμα επεξεργασίας αυτοκινήτου
     */
    public function editForm(): void {
        requireLogin();
        requireRole('secretary','customer');

        $serial = $_GET['serial'] ?? '';
        $car    = $this->carModel->findBySerial($serial);
        if (!$car) {
            http_response_code(404);
            exit('Not found');
        }

        $token = generateCsrfToken();
        if ($_SESSION['role'] === 'secretary') {
            $owners = $this->custModel->search();
        } else {
            $owners = [];
        }

        include __DIR__ . '/../../views/car_form.php';
    }

    /**
     * Ενημέρωση αυτοκινήτου (POST)
     */
    public function edit(): void {
        requireLogin();
        requireRole('secretary','customer');

        if (!verifyCsrfToken($_POST['_csrf'] ?? '')) {
            http_response_code(400);
            exit('Invalid CSRF');
        }

        $serial  = $_POST['serial'] ?? '';
        $ownerId = $_SESSION['role'] === 'secretary'
                 ? (int)($_POST['owner_id'] ?? 0)
                 : $_SESSION['user_id'];

        if (!$this->custModel->findByUserId($ownerId)) {
            $_SESSION['error'] = 'Ο επιλεγμένος ιδιοκτήτης δεν υπάρχει ως πελάτης.';
            header("Location: edit_car.php?serial={$serial}");
            exit;
        }

        $data = [
            'model'           => trim($_POST['model'] ?? ''),
            'brand'           => trim($_POST['brand'] ?? ''),
            'type'            => $_POST['type'] ?? '',
            'drive_type'      => $_POST['drive_type'] ?? '',
            'door_count'      => (int)($_POST['door_count'] ?? 0),
            'wheel_count'     => (int)($_POST['wheel_count'] ?? 0),
            'production_date' => $_POST['production_date'] ?? null,
            'acquisition_year'=> $_POST['acquisition_year'] ?? null,
            'owner_id'        => $ownerId,
        ];

        try {
            $ok = $this->carModel->update($serial, $data);
            $_SESSION['success'] = $ok ? 'Car updated.' : 'No changes.';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }

        header('Location: cars.php');
        exit;
    }

    /**
     * Διαγραφή αυτοκινήτου
     */
    public function delete(): void {
        requireLogin();
        requireRole('secretary','customer');

        if (!verifyCsrfToken($_POST['_csrf'] ?? '')) {
            http_response_code(400);
            exit('Invalid CSRF');
        }

        $serial = $_POST['serial'] ?? '';
        try {
            $ok = $this->carModel->delete($serial);
            $_SESSION['success'] = $ok ? 'Car deleted.' : 'Delete failed.';
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
        }

        header('Location: cars.php');
        exit;
    }
}

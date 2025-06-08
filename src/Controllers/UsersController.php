<?php
namespace Controllers;

use Models\User;

class UsersController {
    private User $userModel;

    public function __construct(\PDO $pdo) {
        $this->userModel = new User($pdo);
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

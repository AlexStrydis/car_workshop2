<?php
require __DIR__ . '/../config/app.php';
require __DIR__ . '/../config/db.php';

requireLogin();

// Αφαιρούμε το flash-μήνυμα success (αν υπάρχει)
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}

// Φόρτωση User model για να βρούμε το όνομα
require_once __DIR__ . '/../src/Models/User.php';
use Models\User;

$userModel = new User($pdo);
$user      = $userModel->findById((int)$_SESSION['user_id']);

if ($user) {
    $username = $user['first_name'] . ' ' . $user['last_name'];
} else {
    $username = $_SESSION['username'] ?? 'Χρήστης';
}

$role = $_SESSION['role'];

// 1. Φόρτωμα επερχόμενων ραντεβού (για secretary), με try/catch
$appointmentsByDate = [];
if ($role === 'secretary') {
    try {
        $stmt = $pdo->prepare("SELECT id, appointment_date FROM appointment WHERE appointment_date >= CURDATE()");
        $stmt->execute();
        $apps = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($apps as $a) {
            $appointmentsByDate[$a['appointment_date']][] = $a;
        }
    } catch (PDOException $e) {
        // Πίνακας appointments δεν υπάρχει ή άλλο σφάλμα – αγνοούμε
        $appointmentsByDate = [];
    }
}

// ─── ΕΔΩ ΞΕΚΙΝΑΝΕ ΟΙ ΑΛΛΑΓΕΣ ΓΙΑ ROLE-BACKED VIEWS ───

// Ανάλογα με το role, ορίζουμε τον τίτλο και το view
if ($role === 'secretary') {
    $pageTitle = 'Admin Dashboard';
    $viewFile  = __DIR__ . '/../Views/dashboard.php';
}
elseif ($role === 'customer') {
    $pageTitle = 'Dashboard Πελάτη';
    $viewFile  = __DIR__ . '/../Views/customer_dashboard.php';
}
elseif ($role === 'mechanic') {
    $pageTitle = 'Dashboard Μηχανικού';
    $viewFile  = __DIR__ . '/../Views/mechanic_dashboard.php';
}
else {
    // Άγνωστο role: στέλνουμε στο login
    header('Location: /login.php');
    exit;
}

// Το view θα εμφανίσει το κοινό header και footer
include $viewFile;

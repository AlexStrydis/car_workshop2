<?php
// public/edit_appointment.php

// 1) Φορτώνουμε helpers & db
require __DIR__ . '/../config/app.php';   // περιέχει requireLogin(), κλπ.
require __DIR__ . '/../config/db.php';    // βγάζει $pdo

// 2) Αυτόματος Loader για src/Controllers & src/Models
spl_autoload_register(function (string $class) {
    $file = __DIR__ . '/../src/' . str_replace('\\','/',$class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// 3) Δημιουργούμε τον controller
$ctrl = new Controllers\AppointmentController($pdo);

// 4) Αν είναι POST, κάνουμε reschedule και τερματίζουμε
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctrl->reschedule();
    exit;
}

// 5) Διαφορετικά (GET), εμφανίζουμε τη φόρμα editForm και τερματίζουμε
$ctrl->editForm();
exit;

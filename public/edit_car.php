<?php
// public/edit_car.php
require __DIR__ . '/../config/app.php';
$pdo = require __DIR__ . '/../config/db.php';

require __DIR__ . '/../src/Controllers/CarController.php';
use Controllers\CarController;

$controller = new CarController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->edit();      // ← from update() to edit()
} else {
    $controller->editForm();
}


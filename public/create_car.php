<?php
// public/create_car.php

require __DIR__ . '/../config/bootstrap.php';
require __DIR__ . '/../config/db.php';

// Autoloader
spl_autoload_register(function(string $class) {
    $path = __DIR__ . '/../src/' . str_replace('\\','/',$class) . '.php';
    if (file_exists($path)) require $path;
});

$ctrl = new Controllers\CarController($pdo);

// Αν είναι POST, τρέχουμε create(), αλλιώς createForm()
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctrl->create();
} else {
    $ctrl->createForm();
}

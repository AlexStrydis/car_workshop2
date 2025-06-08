<?php
// public/cars.php
require __DIR__ . '/../config/app.php';
$pdo = require __DIR__ . '/../config/db.php';

require __DIR__ . '/../src/Controllers/CarController.php';
use Controllers\CarController;

$controller = new CarController($pdo);
$controller->list();

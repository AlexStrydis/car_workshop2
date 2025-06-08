<?php
require __DIR__ . '/../config/app.php';
$pdo = require __DIR__ . '/../config/db.php';
require __DIR__ . '/../src/Controllers/UsersController.php';
use Controllers\UsersController;

$ctl = new UsersController($pdo);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctl->create();
} else {
    $ctl->createForm();
}

<?php
// public/edit_user.php

// 1) Φόρτωσε το config/app (session + PSR-4 autoload για src/)  
require __DIR__ . '/../config/app.php';

// 2) Φόρτωσε το PDO instance  
$pdo = require __DIR__ . '/../config/db.php';

// 3) Φόρτωσε απευθείας τον UsersController  
require __DIR__ . '/../src/Controllers/UsersController.php';
use Controllers\UsersController;

// 4) Κάνε instantiate και κλήση ανάλογα με GET/POST
$ctl = new UsersController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctl->update();        // διαχείριση του POST της φόρμας
} else {
    $ctl->editForm();      // εμφάνιση της φόρμας με τα δεδομένα του χρήστη
}

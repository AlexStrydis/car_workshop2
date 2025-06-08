<?php
// config/bootstrap.php

// 1) Ξεκίνα session  
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2) Φόρτωσε τις global helpers (requireLogin, requireRole, κλπ)
require __DIR__ . '/app.php';

// 3) Σύνδεση στη βάση  
require __DIR__ . '/db.php';

// 4) Autoload για src/  
spl_autoload_register(function (string $class) {
    $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

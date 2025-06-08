<?php
session_start();
$lang = $_GET['lang'] ?? 'el';
if (!in_array($lang, ['el','en'], true)) {
    $lang = 'el';
}
$_SESSION['lang'] = $lang;
$ref = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header('Location: ' . $ref);
exit;

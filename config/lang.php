<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$lang = $_SESSION['lang'] ?? 'el';
if (!in_array($lang, ['el','en'], true)) {
    $lang = 'el';
}
$translations = include __DIR__ . '/../lang/' . $lang . '.php';
function t(string $key): string {
    global $translations;
    return $translations[$key] ?? $key;
}

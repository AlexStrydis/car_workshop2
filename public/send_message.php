<?php
require __DIR__ . '/../config/app.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

if (!verifyCsrfToken($_POST['_csrf'] ?? '')) {
    http_response_code(400);
    exit('Invalid CSRF');
}

$name    = trim($_POST['name']    ?? '');
$email   = trim($_POST['email']   ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

$errors = [];
if ($name === '')    { $errors[] = 'Όνομα απαιτείται.'; }
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Μη έγκυρο email.'; }
if ($subject === '') { $errors[] = 'Θέμα απαιτείται.'; }
if ($message === '') { $errors[] = 'Μήνυμα απαιτείται.'; }

if ($errors) {
    $_SESSION['error'] = implode(' ', $errors);
    header('Location: contact.php');
    exit;
}

$log = sprintf("%s | %s | %s | %s\n", date('c'), $name, $email, $subject);
file_put_contents(__DIR__ . '/../messages.log', $log, FILE_APPEND);

$_SESSION['success'] = 'Το μήνυμά σας καταχωρήθηκε.';
header('Location: contact.php');
exit;
?>

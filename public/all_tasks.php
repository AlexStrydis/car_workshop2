<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../config/app.php';
require __DIR__ . '/../config/db.php';

// Autoload…
spl_autoload_register(fn($c)=>file_exists(__DIR__."/../src/".str_replace('\\','/',$c).".php")
    ? require __DIR__."/../src/".str_replace('\\','/',$c).".php" : null);

requireLogin();
requireRole('mechanic');

use Models\Task;

$taskModel  = new Task($pdo);
$mechId     = (int)$_SESSION['user_id'];

// Παίρνουμε τα φίλτρα από GET
$filters = [
    'from'          => $_GET['from']          ?? '',
    'to'            => $_GET['to']            ?? '',
    'serial'        => $_GET['serial']        ?? '',
    'model'         => $_GET['model']         ?? '',
    'brand'         => $_GET['brand']         ?? '',
    'customer_last' => $_GET['customer_last'] ?? '',
];

// Page & pagination
$page   = max(1, (int)($_GET['page'] ?? 1));
$limit  = 10;
$offset = ($page - 1) * $limit;

// Φορτώνουμε δεδομένα
$totalTasks = $taskModel->countByMechanicWithFilters($mechId, $filters);
$totalPages = (int)ceil($totalTasks / $limit);
$tasks      = $taskModel->getByMechanicWithFilters($mechId, $filters, $limit, $offset);

// Title & header
$pageTitle = 'Όλες οι Εργασίες Μου';
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php include __DIR__ . '/inc/header.php'; ?>
<?php include __DIR__ . '/../Views/all_tasks.php'; ?>
<?php include __DIR__ . '/inc/footer.php'; ?>
</body>
</html>

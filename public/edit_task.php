<?php
// public/edit_task.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../config/app.php';
require __DIR__ . '/../config/db.php';
spl_autoload_register(fn($c)=>file_exists(__DIR__."/../src/".str_replace('\\','/',$c).".php")
    ? require __DIR__."/../src/".str_replace('\\','/',$c).".php" : null);

requireLogin();
requireRole('mechanic');

use Models\Task;

// Φορτώνουμε το μοντέλο
$taskModel = new Task($pdo);

// Παίρνουμε το ID από το query string
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: all_tasks.php');
    exit;
}

// Αν έγινε POST, αποθηκεύουμε
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'description'     => $_POST['description']     ?? '',
        'materials'       => $_POST['materials']       ?? '',
        'completion_time' => $_POST['completion_time'] ?? '',
        'cost'            => $_POST['cost']            ?? 0,
    ];
    if ($taskModel->update($id, $data)) {
        $_SESSION['success'] = "Η εργασία #{$id} ενημερώθηκε επιτυχώς.";
    } else {
        $_SESSION['error'] = "Δεν έγινε καμία αλλαγή ή προέκυψε σφάλμα.";
    }
    header('Location: all_tasks.php');
    exit;
}

// GET: φέρνουμε τα υπάρχοντα δεδομένα για να προ–γεμίσουμε το form
$task = $taskModel->findById($id);
if (!$task) {
    $_SESSION['error'] = "Η εργασία #{$id} δεν βρέθηκε.";
    header('Location: all_tasks.php');
    exit;
}

// Τίτλος & header
$pageTitle = "Επεξεργασία Εργασίας #{$id}";
include __DIR__ . '/inc/header.php';

// Εμφάνιση του form (από κάτω)
?>
<h1><?= $pageTitle ?></h1>
<?php if (!empty($_SESSION['error'])): ?>
  <p style="color:red;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form method="post" action="">
  <div>
    <label>Περιγραφή:</label><br>
    <textarea name="description" rows="4" cols="50"><?= htmlspecialchars($task['description']) ?></textarea>
  </div>
  <div>
    <label>Υλικά:</label><br>
    <textarea name="materials" rows="2" cols="50"><?= htmlspecialchars($task['materials']) ?></textarea>
  </div>
  <div>
    <label>Ημ/νία & Ώρα Ολοκλήρωσης:</label><br>
    <input type="datetime-local" name="completion_time"
      value="<?= date('Y-m-d\TH:i', strtotime($task['completion_time'])) ?>">
  </div>
  <div>
    <label>Κόστος:</label><br>
    <input type="number" step="0.01" name="cost" value="<?= htmlspecialchars($task['cost']) ?>">
  </div>
  <br>
  <button type="submit">Αποθήκευση Αλλαγών</button>
  <a href="all_tasks.php" style="margin-left:1em;">Άκυρο / Επιστροφή</a>
</form>
<?php


<?php
// public/new_task.php

// Εμφάνιση όλων των errors για debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../config/app.php';
require __DIR__ . '/../config/db.php';

// Autoload classes
spl_autoload_register(fn($c) => 
    file_exists(__DIR__ . "/../src/".str_replace('\\','/',$c).".php")
      ? require __DIR__ . "/../src/".str_replace('\\','/',$c).".php" 
      : null
);

requireLogin();
requireRole('mechanic');

use Models\Task;

// Φόρτωμα appointments για dropdown
$stmt = $pdo->prepare("
    SELECT 
      a.id, a.appointment_date, a.appointment_time,
      c.serial_number AS serial,
      u.last_name, u.first_name
    FROM `appointment` a
    JOIN `car` c  ON a.car_serial   = c.serial_number
    JOIN `user` u ON a.customer_id   = u.id
    WHERE a.mechanic_id = :mid
      AND a.appointment_date >= CURDATE()
    ORDER BY a.appointment_date, a.appointment_time
");
$stmt->execute(['mid' => $_SESSION['user_id']]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Προετοιμασία για POST
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId   = (int)($_POST['appointment_id']   ?? 0);
    $description     = trim($_POST['description']     ?? '');
    $materials       = trim($_POST['materials']       ?? '');
    $completionTime  = trim($_POST['completion_time'] ?? '');
    $cost            = trim($_POST['cost']            ?? '');

    // validation
    if ($appointmentId <= 0) {
        $errors['appointment_id'] = 'Επίλεξε ένα ραντεβού.';
    }
    if ($description === '') {
        $errors['description'] = 'Γράψε περιγραφή.';
    }
    if ($completionTime === '') {
        $errors['completion_time'] = 'Καταχώρησε ημερομηνία/ώρα ολοκλήρωσης.';
    }
    if ($cost === '' || !is_numeric($cost)) {
        $errors['cost'] = 'Καταχώρησε έγκυρο κόστος.';
    }

    if (empty($errors)) {
        $taskModel = new Task($pdo);
        $newId = $taskModel->create([
            'appointment_id'  => $appointmentId,
            'description'     => $description,
            'materials'       => $materials,
            'completion_time' => date('Y-m-d H:i:s', strtotime($completionTime)),
            'cost'            => (float)$cost,
        ]);
        $_SESSION['success'] = "Δημιουργήθηκε νέα εργασία #{$newId}.";
        header('Location: all_tasks.php');
        exit;
    }
}

// τίτλος & header
$pageTitle = 'Νέα Εργασία';
include __DIR__ . '/inc/header.php';
?>

<h1>Νέα Εργασία</h1>

<form method="post" action="" style="max-width:600px; margin-top:1em;">
  <div>
    <label for="appointment_id"><strong>Επιλέξτε Ραντεβού</strong></label><br>
    <select name="appointment_id" id="appointment_id">
      <option value="">-- επιλέξτε --</option>
      <?php foreach ($appointments as $a): ?>
        <option value="<?= $a['id'] ?>"
          <?= (isset($appointmentId) && $appointmentId===$a['id']) ? 'selected':'' ?>>
          <?= date('d/m/Y', strtotime($a['appointment_date'])) ?>
          <?= $a['appointment_time'] ?> —
          <?= htmlspecialchars($a['last_name'].' '.$a['first_name']) ?> —
          <?= htmlspecialchars($a['serial']) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <?php if(isset($errors['appointment_id'])): ?>
      <p style="color:red;"><?= $errors['appointment_id'] ?></p>
    <?php endif; ?>
  </div>

  <div style="margin-top:1em;">
    <label for="description"><strong>Περιγραφή Εργασίας</strong></label><br>
    <textarea name="description" id="description" rows="4" cols="60"><?= 
      htmlspecialchars($description ?? '') ?></textarea>
    <?php if(isset($errors['description'])): ?>
      <p style="color:red;"><?= $errors['description'] ?></p>
    <?php endif; ?>
  </div>

  <div style="margin-top:1em;">
    <label for="materials"><strong>Υλικά</strong></label><br>
    <textarea name="materials" id="materials" rows="2" cols="60"><?= 
      htmlspecialchars($materials ?? '') ?></textarea>
  </div>

  <div style="margin-top:1em;">
    <label for="completion_time"><strong>Ημ/νία &amp; Ώρα Ολοκλήρωσης</strong></label><br>
    <input type="datetime-local" name="completion_time" id="completion_time"
      value="<?= isset($completionTime)
           ? date('Y-m-d\TH:i', strtotime($completionTime))
           : date('Y-m-d\TH:i') ?>">
    <?php if(isset($errors['completion_time'])): ?>
      <p style="color:red;"><?= $errors['completion_time'] ?></p>
    <?php endif; ?>
  </div>

  <div style="margin-top:1em;">
    <label for="cost"><strong>Κόστος (€)</strong></label><br>
    <input type="number" step="0.01" name="cost" id="cost"
      value="<?= htmlspecialchars($cost ?? '') ?>">
    <?php if(isset($errors['cost'])): ?>
      <p style="color:red;"><?= $errors['cost'] ?></p>
    <?php endif; ?>
  </div>

  <div style="margin-top:1.5em;">
    <button type="submit">Δημιουργία Εργασίας</button>
    <button type="button" onclick="history.back()">Άκυρο/Επιστροφή</button>
  </div>
</form>


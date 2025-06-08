<?php
require __DIR__ . '/../config/app.php';
require __DIR__ . '/../config/db.php';
// Autoload…
spl_autoload_register(fn($c)=>file_exists(__DIR__."/../src/".str_replace('\\','/',$c).".php")
    ? require __DIR__."/../src/".str_replace('\\','/',$c).".php" : null);

// Σιγουρεύουμε login και φέρνουμε το role
requireLogin();
$role = $_SESSION['role'] ?? '';

// Αν δεν είναι ούτε secretary ούτε customer, δεν μπαίνει
if (!in_array($role, ['secretary', 'customer'], true)) {
    header('Location: /login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8">
  <title>Νέα Προσθήκη</title>
</head>
<body>
  <p><a href="dashboard.php">← Επιστροφή στο Dashboard</a></p>
  <h1>Νέα Προσθήκη</h1>

  <ul>
    <?php if ($role === 'secretary'): ?>
    <li>
      <a href="register.php">➤ Προσθήκη Νέου Χρήστη</a>
    </li>
    <?php endif; ?>

    <li>
      <a href="create_car.php">➤ Προσθήκη Νέου Αυτοκινήτου</a>
    </li>
    <li>
      <a href="create_appointment.php">➤ Προσθήκη Νέου Ραντεβού</a>
    </li>
  </ul>
</body>
</html>

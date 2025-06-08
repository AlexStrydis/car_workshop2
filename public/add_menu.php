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
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title><?= t('add_menu.title') ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php include __DIR__ . '/inc/header.php'; ?>
  <section class="hero-background">
    <div class="container">
      <p><a href="dashboard.php"><?= t('add_menu.back_dashboard') ?></a></p>
      <h1><?= t('add_menu.heading') ?></h1>

      <ul>
        <?php if ($role === 'secretary'): ?>
        <li>
          <a href="create_user.php">➤ <?= t('add_menu.add_user') ?></a>
        </li>
        <?php endif; ?>

        <li>
          <a href="create_car.php">➤ <?= t('add_menu.add_car') ?></a>
        </li>
        <li>
          <a href="create_appointment.php">➤ <?= t('add_menu.add_appt') ?></a>
        </li>
      </ul>
    </div>
  </section>
  <?php include __DIR__ . '/inc/footer.php'; ?>
</body>
</html>

<?php
// views/customer_dashboard.php
// Το public/dashboard.php έχει ήδη συμπεριλάβει το header
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php include __DIR__ . '/../public/inc/header.php'; ?>
  <section class="hero-background">
    <div class="hero-overlay"></div>
    <div class="container">
      <h3 class="welcome-message"><?= sprintf(t('dashboard.welcome'), htmlspecialchars($username)) ?></h3>
      <div class="dashboard-actions-box">
        <button onclick="location.href='cars.php'"><?= t('dashboard.manage_cars') ?></button>
        <button onclick="location.href='appointments.php'"><?= t('dashboard.manage_appointments') ?></button>
        <button onclick="location.href='add_menu.php'"><?= t('dashboard.add_new') ?></button>
      </div>
    </div>
  </section>
  <?php include __DIR__ . '/../public/inc/footer.php'; ?>
</body>
</html>





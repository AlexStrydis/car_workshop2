<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pageTitle) ?></title>
</head>
<body>
  <?php include __DIR__ . '/../public/inc/header.php'; ?>
  <section class="hero-background">
    <div class="hero-overlay"></div>
    <div class="container">
      <h3 class="welcome-message"><?= sprintf(t('dashboard.welcome'), htmlspecialchars($username)) ?></h3>
      <div class="dashboard-actions-box">
        <button onclick="location.href='appointments_mechanic.php'"><?= t('dashboard.manage_appointments') ?></button>
        <button onclick="location.href='all_tasks.php'"><?= t('dashboard.my_tasks') ?></button>
        <button onclick="location.href='new_task.php'"><?= t('dashboard.new_task') ?></button>
      </div>
    </div>
  </section>
  <?php include __DIR__ . '/../public/inc/footer.php'; ?>
</body>
</html>

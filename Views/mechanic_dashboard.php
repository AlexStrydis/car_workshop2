<!DOCTYPE html>
<html lang="el">
<head>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="UTF-8">
  <title>Dashboard Μηχανικού</title>
</head>
<body>
  <?php include __DIR__ . '/../public/inc/header.php'; ?>
  <section class="hero-background">
    <div class="hero-overlay"></div>
    <div class="container">
      <h3 class="welcome-message">Καλωσήρθες, <?= htmlspecialchars($username) ?>!</h3>
      <div class="dashboard-actions-box">
        <button onclick="location.href='appointments_mechanic.php'">Διαχείριση Ραντεβού</button>
        <button onclick="location.href='all_tasks.php'">Εργασίες Μου</button>
        <button onclick="location.href='new_task.php'">Νέα Εργασία</button>
      </div>
    </div>
  </section>
  <?php include __DIR__ . '/../public/inc/footer.php'; ?>
</body>
</html>

<?php
// views/customer_dashboard.php
// Το public/dashboard.php έχει ήδη συμπεριλάβει το header
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Πελάτη</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php include __DIR__ . '/../public/inc/header.php'; ?>
  <section class="hero-background dashboard-hero">
    <div class="hero-overlay"></div>
    <div class="container">
      <h3 class="welcome-message">Καλώς ήρθες, <?= htmlspecialchars($username) ?>!</h3>
      <div class="dashboard-actions-box">
        <button onclick="location.href='cars.php'">Διαχείριση Αυτοκινήτων</button>
        <button onclick="location.href='appointments.php'">Διαχείριση Ραντεβού</button>
        <button onclick="location.href='add_menu.php'">Νέα Προσθήκη</button>
      </div>
    </div>
  </section>
  <?php include __DIR__ . '/../public/inc/footer.php'; ?>
</body>
</html>





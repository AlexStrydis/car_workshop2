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
  <section class="hero-background dashboard-hero">
    <div class="hero-overlay"></div>

    <div class="dashboard-container">
    <aside class="dashboard-sidebar">
      <button onclick="location.href='cars.php'">Διαχείριση Αυτοκινήτων</button>
      <button onclick="location.href='appointments.php'">Διαχείριση Ραντεβού</button>
      <button onclick="location.href='add_menu.php'">Νέα Προσθήκη</button>
    </aside>

    <main class="dashboard-main">
      <div class="welcome-message">
        <h3>Καλώς ήρθες, <?= htmlspecialchars($username) ?>!</h3>
      </div>
    </main>
  </div>
  </section>
</body>
</html>





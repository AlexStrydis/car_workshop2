<!DOCTYPE html>
<html lang="el">
<head>
  <link rel="stylesheet" href="css/style.css">

  <meta charset="UTF-8">
  <title>Dashboard Μηχανικού</title>
</head>
<body>
  <section class="hero-background dashboard-hero">
    <div class="hero-overlay"></div>
  </section>

  <div class="dashboard-container">
    <aside class="dashboard-sidebar">
      <button onclick="location.href='appointments_mechanic.php'">Διαχείριση Ραντεβού</button>
      <button onclick="location.href='all_tasks.php'">Εργασίες Μου</button>
      <button onclick="location.href='new_task.php'">Νέα Εργασία</button>
    </aside>

    <main class="dashboard-main">
      <div class="welcome-message">
        <h3>Καλωσήρθες, <?= htmlspecialchars($username) ?>!</h3>
      </div>
    </main>
  </div>

</body>
</html>

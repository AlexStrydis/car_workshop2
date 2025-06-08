<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Car Workshop</title>
  <!-- Φόρτωση του γενικού CSS -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Προαιρετικά: Google Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap"
    rel="stylesheet"
  >
</head>
<body>

  <!--==============================
    =         HERO SECTION         =
  ==============================-->
  <section class="hero-section">
    <!-- Overlay κάτω από το φόντο -->
    <div class="hero-overlay"></div>

    <!-- Κεντρικό πλαίσιο φόρμας Login -->
    <div class="hero-content auth-container">
      <!-- Τίτλος -->
      <h1 style="color: #f1c40f; margin-bottom: 20px; text-align: center;">
        Σύνδεση Χρήστη
      </h1>

      <!-- Εμφάνιση τυχόν μηνυμάτων λάθους ή επιτυχίας -->
      <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-error">
          <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>


      <!-- Η ίδια η φόρμα Login -->
      <form method="post" action="login.php" novalidate>
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($token) ?>">

        <!-- Username -->
        <div class="form-group">
          <label for="login_username">Username</label>
          <input
            id="login_username"
            name="username"
            type="text"
            required
          >
        </div>

        <!-- Password -->
        <div class="form-group">
          <label for="login_password">Password</label>
          <input
            id="login_password"
            type="password"
            name="password"
            required
          >
        </div>

        <!-- Κουμπί Login -->
        <div style="text-align: center; margin-top: 20px;">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </section>
</body>
</html>

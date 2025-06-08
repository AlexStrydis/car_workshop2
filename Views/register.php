<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | Car Workshop</title>
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

    <!-- Κεντρικό πλαίσιο φόρμας -->
    <div class="hero-content auth-container">
      <!-- Τίτλος -->
      <h1 style="color: #f1c40f; margin-bottom: 20px; text-align: center;">
        Εγγραφή Νέου Χρήστη
      </h1>

      <!-- Εμφάνιση τυχόν μηνύματος λάθους -->
      <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-error">
          <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <!-- Η ίδια η φόρμα Εγγραφής -->
      <form method="post" action="register.php" novalidate>
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars($token) ?>">

        <!-- Username -->
        <div class="form-group">
          <label for="username">Username</label>
          <input
            id="username"
            name="username"
            type="text"
            minlength="4"
            pattern="[A-Za-z0-9]+"
            title="Τουλάχιστον 4 χαρακτήρες. Μόνο λατινικοί χαρακτήρες και αριθμοί."
            required
            value="<?= htmlspecialchars($_SESSION['old']['username'] ?? '') ?>"
          >
        </div>

        <!-- Password -->
        <div class="form-group">
          <label for="password">Password</label>
          <input
            id="password"
            type="password"
            name="password"
            minlength="8"
            pattern="(?=.*[A-Za-z])(?=.*\d).{8,}"
            title="Τουλάχιστον 8 χαρακτήρες, με τουλάχιστον ένα γράμμα και έναν αριθμό."
            required
          >
        </div>

        <!-- First Name -->
        <div class="form-group">
          <label for="first_name">First name</label>
          <input
            id="first_name"
            name="first_name"
            type="text"
            minlength="1"
            required
            value="<?= htmlspecialchars($_SESSION['old']['first_name'] ?? '') ?>"
          >
        </div>

        <!-- Last Name -->
        <div class="form-group">
          <label for="last_name">Last name</label>
          <input
            id="last_name"
            name="last_name"
            type="text"
            minlength="1"
            required
            value="<?= htmlspecialchars($_SESSION['old']['last_name'] ?? '') ?>"
          >
        </div>

        <!-- Identity Number -->
        <div class="form-group">
          <label for="identity_number">Identity no.</label>
          <input
            id="identity_number"
            name="identity_number"
            type="text"
            pattern="[A-Za-z]{2}[0-9]{6}"
            title="2 γράμματα (A–Z) ακολουθούμενα από 6 ψηφία."
            required
            value="<?= htmlspecialchars($_SESSION['old']['identity_number'] ?? '') ?>"
          >
        </div>

        <!-- Role -->
        <div class="form-group">
          <label for="role">Role</label>
          <select id="role" name="role" required>
            <option value="">-- Επιλέξτε --</option>
            <option value="customer"
              <?= (($_SESSION['old']['role'] ?? '') === 'customer') ? 'selected' : '' ?>>
              Customer
            </option>
            <option value="mechanic"
              <?= (($_SESSION['old']['role'] ?? '') === 'mechanic') ? 'selected' : '' ?>>
              Mechanic
            </option>
          </select>
        </div>

        <!-- Extra πεδία (φορούν είτε customer, είτε mechanic) -->
        <div id="extra-fields">
          <?php if (($_SESSION['old']['role'] ?? '') === 'customer'): ?>
            <!-- Tax ID -->
            <div class="form-group">
              <label for="tax_id">Tax ID</label>
              <input
                id="tax_id"
                name="tax_id"
                type="text"
                pattern="\d{9}"
                title="Ακριβώς 9 ψηφία."
                required
                value="<?= htmlspecialchars($_SESSION['old']['tax_id'] ?? '') ?>"
              >
            </div>
            <!-- Address -->
            <div class="form-group">
              <label for="address">Address</label>
              <input
                id="address"
                name="address"
                type="text"
                minlength="1"
                required
                value="<?= htmlspecialchars($_SESSION['old']['address'] ?? '') ?>"
              >
            </div>
          <?php elseif (($_SESSION['old']['role'] ?? '') === 'mechanic'): ?>
            <!-- Specialty -->
            <div class="form-group">
              <label for="specialty">Specialty</label>
              <input
                id="specialty"
                name="specialty"
                type="text"
                minlength="1"
                required
                value="<?= htmlspecialchars($_SESSION['old']['specialty'] ?? '') ?>"
              >
            </div>
          <?php endif; ?>
        </div>

        <!-- Κουμπί Register -->
        <div style="text-align: center; margin-top: 20px;">
          <button type="submit" class="btn btn-primary">Register</button>
          <button type="button" onclick="history.back()">Cancel</button>
        </div>
      </form>

      <?php
        // Καθαρίζουμε το old data για να μην μένει στο session
        unset($_SESSION['old']);
      ?>
    </div>
  </section>

  <!-- Λίγο JavaScript για να φορτώνουμε δυναμικά τα πεδία extra -->
  <script>
    const extra = document.getElementById('extra-fields');
    const roleSelect = document.getElementById('role');

    function updateExtraFields() {
      extra.innerHTML = '';
      if (roleSelect.value === 'customer') {
        extra.innerHTML = `
          <div class="form-group">
            <label for="tax_id">Tax ID</label>
            <input
              id="tax_id"
              name="tax_id"
              type="text"
              pattern="\\d{9}"
              title="Ακριβώς 9 ψηφία."
              required
              value="${<?= json_encode($_SESSION['old']['tax_id'] ?? '') ?>}"
            >
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input
              id="address"
              name="address"
              type="text"
              minlength="1"
              required
              value="${<?= json_encode($_SESSION['old']['address'] ?? '') ?>}"
            >
          </div>
        `;
      } else if (roleSelect.value === 'mechanic') {
        extra.innerHTML = `
          <div class="form-group">
            <label for="specialty">Specialty</label>
            <input
              id="specialty"
              name="specialty"
              type="text"
              minlength="1"
              required
              value="${<?= json_encode($_SESSION['old']['specialty'] ?? '') ?>}"
            >
          </div>
        `;
      }
    }

    roleSelect.addEventListener('change', updateExtraFields);
    updateExtraFields();
  </script>
</body>
</html>

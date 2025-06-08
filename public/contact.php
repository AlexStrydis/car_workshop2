<?php
// public/contact.php
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <title>Car Workshop | Επικοινωνία</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Κοινό CSS -->
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <!-- Εισαγωγή Header -->
  <?php include __DIR__ . '/inc/header.php'; ?>

  <!-- Contact Section -->
  <section class="container contact-section">
    <h2>Επικοινωνία</h2>
    <p class="lead">
      Συμπλήρωσε τη φόρμα παρακάτω ή χρησιμοποίησε τα στοιχεία μας για να επικοινωνήσεις άμεσα.
    </p>

    <div class="contact-grid">
      <!-- Αριστερή στήλη: Στοιχεία Εταιρείας -->
      <div class="contact-info">
        <h4>Διεύθυνση</h4>
        <p>Οδός Παράδειγμα 123, Αθήνα</p>
        <h4>Τηλέφωνο</h4>
        <p>210 1234567</p>
        <h4>Email</h4>
        <p><a href="mailto:info@carworkshop.gr">info@carworkshop.gr</a></p>
        <h4>Ωράριο</h4>
        <p>Δευτέρα – Παρασκευή: 08:00 – 18:00<br />Σάββατο: 09:00 – 14:00</p>
        <h4>Βρες μας στο χάρτη</h4>
        <p><a href="#" target="_blank">Google Maps</a></p>
      </div>

      <!-- Δεξιά στήλη: Φόρμα Επικοινωνίας -->
      <div class="contact-form-wrapper">
        <form class="contact-form" method="post" action="send_message.php">
          <!-- CSRF token (εφόσον έχεις αντίστοιχο helper) -->
          <!-- <input type="hidden" name="_csrf" value="<?= htmlspecialchars($token) ?>"> -->

          <div class="form-group">
            <label for="name">Όνομα:</label>
            <input type="text" id="name" name="name" required placeholder="Το όνομά σας" />
          </div>

          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="your@email.com" />
          </div>

          <div class="form-group">
            <label for="subject">Θέμα:</label>
            <input type="text" id="subject" name="subject" required placeholder="Θέμα μηνύματος" />
          </div>

          <div class="form-group">
            <label for="message">Μήνυμα:</label>
            <textarea id="message" name="message" rows="5" required placeholder="Περιγράψτε το ερώτημα ή το σχόλιό σας"></textarea>
          </div>

          <button type="submit" class="btn-primary">Αποστολή Μηνύματος</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Εισαγωγή Footer -->
  <?php include __DIR__ . '/inc/footer.php'; ?>
</body>
</html>

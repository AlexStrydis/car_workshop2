<?php
// public/services.php
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <title>Car Workshop | Υπηρεσίες</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Κοινό CSS -->
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <!-- Εισαγωγή Header -->
  <?php include __DIR__ . '/inc/header.php'; ?>

  <!-- Services Section -->
  <section class="services-section">
    <div class="container">
      <h2>Οι Υπηρεσίες μας</h2>
      <p class="lead">
        Καλύπτουμε οποιαδήποτε ανάγκη συντήρησης ή επισκευής αυτοκινήτου, από
        αλλαγή λαδιών έως και πλήρη ανακατασκευή κινητήρα.
      </p>

      <div class="services-grid">
        <div class="service-card">
          <!-- Αντί για εικόνα, βάλε ένα εικονίδιο (τοποθέτησε το κατάλληλο PNG/SVG στον φάκελο images/) -->
          <img src="images/icon-oil.png" alt="Αλλαγή Λαδιών" />
          <h4>Αλλαγή Λαδιών</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-brake.png" alt="Επισκευή Φρένων" />
          <h4>Επισκευή Φρένων</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-engine.png" alt="Επισκευή Κινητήρα" />
          <h4>Επισκευή Κινητήρα</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-ac.png" alt="Σέρβις Κλιματισμού" />
          <h4>Σέρβις Κλιματισμού</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-battery.png" alt="Μπαταρίες & Ηλεκτρικά" />
          <h4>Μπαταρίες &amp; Ηλεκτρικά</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-inspection.png" alt="Διαγνωστικός Έλεγχος" />
          <h4>Διαγνωστικός Έλεγχος</h4>
        </div>
      </div>

  </section>

  <!-- Εισαγωγή Footer -->
  <?php include __DIR__ . '/inc/footer.php'; ?>
</body>
</html>

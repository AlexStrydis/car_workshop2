<?php
// public/index.php
require __DIR__ . '/../config/lang.php';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8" />
  <title>Car Workshop | Αρχική</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap"
    rel="stylesheet"
  />
  <style>
    .btn-primary {
      font-size: 0.7rem;
      padding: 4px 8px;
      border-radius: 6px;
      background-color: #f1c40f;
      color: #fff;
      text-decoration: none;
      display: inline-block;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <!--==============================
    =            HEADER            =
  ==============================-->
  <?php include __DIR__ . '/inc/header.php'; ?>

  <!--==============================
    =         HERO SECTION         =
  ==============================-->
  <section class="hero-section hero-background">
    <div class="hero-content container">
      <h2 class="hero-title"><?= t('index.tagline') ?></h2>
      <p class="hero-subtitle">
        <?= t('index.subtitle') ?>
      </p>
      <div class="hero-cta">
        <a href="register.php" class="btn-register"><?= t('index.register_now') ?></a>
        <a href="login.php" class="btn-login"><?= t('index.login') ?></a>
      </div>
    </div>
  </section>

  <!--==============================
    =        ABOUT SECTION         =
  ==============================-->
  <section class="about-section hero-background">
    <div class="container">
      <h2><?= t('index.about_title') ?></h2>
      <p class="lead">
        <?= t('index.about_text1') ?>
      </p>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">🛠️</div>
          <h3><?= t('index.feature.mechanics') ?></h3>
          <p>
            Όλοι οι μηχανικοί μας είναι ASE-Certified και εκπαιδευμένοι στις
            τελευταίες τεχνολογίες.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">⏱️</div>
          <h3><?= t('index.feature.quick') ?></h3>
          <p>
            Στόχος μας η άμεση επίλυση, χωρίς να θυσιάζουμε την ποιότητα.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">💯</div>
          <h3><?= t('index.feature.guarantee') ?></h3>
          <p>
            Όλες οι εργασίες μας συνοδεύονται από 1 έτος / 10.000χλμ εγγύηση.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!--==============================
    =       SERVICES SECTION       =
  ==============================-->
  <section class="services-section hero-background">
    <div class="container">
      <h2><?= t('index.services_title') ?></h2>
      <p class="lead">
        Καλύπτουμε οποιαδήποτε ανάγκη συντήρησης ή επισκευής αυτοκινήτου, από
        αλλαγή λαδιών έως και πλήρη ανακατασκευή κινητήρα.
      </p>
      <div class="services-grid">
        <div class="service-card">
          <img src="images/icon-oil.png" alt="Oil Change" />
          <h4>Αλλαγή Λαδιών</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-brake.png" alt="Brake Repair" />
          <h4>Επισκευή Φρένων</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-engine.png" alt="Engine Repair" />
          <h4>Επισκευή Κινητήρα</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-ac.png" alt="A/C Service" />
          <h4>Σέρβις Κλιματισμού</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-battery.png" alt="Battery Service" />
          <h4>Μπαταρίες & Ηλεκτρικά</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-inspection.png" alt="Diagnostics" />
          <h4>Διαγνωστικός Έλεγχος</h4>
        </div>
      </div>
      <div class="text-center mt-10">
        <a href="services.php" class="btn-primary"><?= t('index.services_link') ?></a>
      </div>
    </div>
  </section>

  <!--==============================
    =       CONTACT / FOOTER        =
  ==============================-->
  <?php include __DIR__ . '/inc/footer.php'; ?>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const loginButton = document.querySelector('.btn-login');
      const registerButton = document.querySelector('.btn-register');

      if (loginButton) loginButton.style.display = 'none';
      if (registerButton) registerButton.style.display = 'none';
    });
  </script>
</body>
</html>

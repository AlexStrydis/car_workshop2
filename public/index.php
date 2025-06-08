<?php
// public/index.php
require __DIR__ . '/../config/lang.php';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8" />
  <title>Car Workshop | <?= t('nav.home') ?></title>
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
          <p><?= t('index.feature.mechanics_desc') ?></p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">⏱️</div>
          <h3><?= t('index.feature.quick') ?></h3>
          <p><?= t('index.feature.quick_desc') ?></p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">💯</div>
          <h3><?= t('index.feature.guarantee') ?></h3>
          <p><?= t('index.feature.guarantee_desc') ?></p>
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
        <?= t('index.services_paragraph') ?>
      </p>
      <div class="services-grid">
        <div class="service-card">
          <img src="images/icon-oil.png" alt="<?= t('index.service.oil') ?>" />
          <h4><?= t('index.service.oil') ?></h4>
        </div>
        <div class="service-card">
          <img src="images/icon-brake.png" alt="<?= t('index.service.brake') ?>" />
          <h4><?= t('index.service.brake') ?></h4>
        </div>
        <div class="service-card">
          <img src="images/icon-engine.png" alt="<?= t('index.service.engine') ?>" />
          <h4><?= t('index.service.engine') ?></h4>
        </div>
        <div class="service-card">
          <img src="images/icon-ac.png" alt="<?= t('index.service.ac') ?>" />
          <h4><?= t('index.service.ac') ?></h4>
        </div>
        <div class="service-card">
          <img src="images/icon-battery.png" alt="<?= t('index.service.battery') ?>" />
          <h4><?= t('index.service.battery') ?></h4>
        </div>
        <div class="service-card">
          <img src="images/icon-inspection.png" alt="<?= t('index.service.inspection') ?>" />
          <h4><?= t('index.service.inspection') ?></h4>
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

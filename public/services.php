<?php
// public/services.php
require_once '../config/lang.php';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8" />
  <title>Car Workshop | <?= t('nav.services') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Κοινό CSS -->
  <link rel="stylesheet" href="css/style.css" />
  <style>
    .services-section {
      padding: 15px;
      border-radius: 5px;
      box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    }

    .service-card {
      position: relative;
      overflow: hidden;
      border-radius: 8px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 8px;
    }

    .service-card:hover {
      transform: scale(1.05);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    }

    .service-card img {
      width: auto;
      max-width: 100%;
      height: auto;
      max-height: 70px;
      display: block;
      margin: 0 auto;
      border-bottom: 2px solid #f1c40f;
    }

    .service-card h4 {
      text-align: center;
      color: #f1c40f;
      margin: 4px 0;
      font-size: 0.9rem;
    }

    .service-card .details {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0, 0, 0, 0.8);
      color: #ffffff;
      padding: 6px;
      transform: translateY(100%);
      transition: transform 0.3s ease, opacity 0.3s ease;
      opacity: 0;
      font-size: 0.8rem;
    }

    .service-card:hover .details {
      transform: translateY(0);
      opacity: 1;
    }
  </style>
</head>
<body>
  <!-- Εισαγωγή Header -->
  <?php include __DIR__ . '/inc/header.php'; ?>

  <!-- Services Section -->
  <section class="hero-background">
    <div class="container services-section" style="background-color: rgba(0, 0, 0, 0.8);">
      <h2 style="color: #f1c40f; text-align: center; margin-bottom: 15px;"><?= t('services.title') ?></h2>
      <p class="lead" style="color: #ffffff; margin-bottom: 15px;">
        <?= t('index.services_paragraph') ?>
      </p>
      <div class="services-grid">
        <div class="service-card">
          <img src="images/icon-oil.png" alt="<?= t('index.service.oil') ?>" />
          <h4><?= t('index.service.oil') ?></h4>
          <div class="details"><?= t('services.oil_detail') ?></div>
        </div>
        <div class="service-card">
          <img src="images/icon-brake.png" alt="<?= t('index.service.brake') ?>" />
          <h4><?= t('index.service.brake') ?></h4>
          <div class="details"><?= t('services.brake_detail') ?></div>
        </div>
        <div class="service-card">
          <img src="images/icon-engine.png" alt="<?= t('index.service.engine') ?>" />
          <h4><?= t('index.service.engine') ?></h4>
          <div class="details"><?= t('services.engine_detail') ?></div>
        </div>
        <div class="service-card">
          <img src="images/icon-ac.png" alt="<?= t('index.service.ac') ?>" />
          <h4><?= t('index.service.ac') ?></h4>
          <div class="details"><?= t('services.ac_detail') ?></div>
        </div>
        <div class="service-card">
          <img src="images/icon-battery.png" alt="<?= t('index.service.battery') ?>" />
          <h4><?= t('index.service.battery') ?></h4>
          <div class="details"><?= t('services.battery_detail') ?></div>
        </div>
        <div class="service-card">
          <img src="images/icon-inspection.png" alt="<?= t('index.service.inspection') ?>" />
          <h4><?= t('index.service.inspection') ?></h4>
          <div class="details"><?= t('services.inspection_detail') ?></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
   <?php include __DIR__ . '/inc/footer.php'; ?>

</body>
</html>

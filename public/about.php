<?php
// public/about.php
require_once '../config/app.php';
require_once '../config/lang.php';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8" />
  <title>Car Workshop | <?= t('nav.about') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <!-- Header -->
  <?php include __DIR__ . '/inc/header.php'; ?>

  <!-- Main Content -->
  <section class="hero-background">
    <div class="container about-section" style="background-color: rgba(0, 0, 0, 0.8); padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);">
      <h2 style="color: #f1c40f; text-align: center; margin-bottom: 20px;"><?= t('about.title') ?></h2>
      <p class="lead" style="color: #ffffff; margin-bottom: 20px;">
        <?= t('about.p1') ?>
      </p>
      <ul style="color: #ffffff; margin-bottom: 20px;">
        <li><?= t('about.li1') ?></li>
        <li><?= t('about.li2') ?></li>
        <li><?= t('about.li3') ?></li>
        <li><?= t('about.li4') ?></li>
      </ul>
      <p style="color: #ffffff;">
        <?= t('about.p2') ?>
      </p>
    </div>
  </section>


  <!-- Footer -->
   <?php include __DIR__ . '/inc/footer.php'; ?>
   
</body>
</html>

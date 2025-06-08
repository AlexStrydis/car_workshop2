<?php
// public/inc/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../config/lang.php';
?>
<!-- Reusable Header -->
<header class="site-header">
  <div class="container header-container">
    <div class="logo" style="display: flex; align-items: center; justify-content: center; height: 100px; margin-top: 10px;">
      <img src="images/logo.png" alt="Car Workshop Logo" style="max-height: 80px; width: auto;">
    </div>
    <nav class="site-nav" style="margin: 0 auto; display: flex; align-items: center; justify-content: flex-end;">
      <?php if (!empty($_SESSION['user_id'])): ?>
      <a href="dashboard.php"><?= t('nav.dashboard') ?></a>
      <?php endif; ?>
      <a href="index.php"><?= t('nav.home') ?></a>
      <a href="about.php"><?= t('nav.about') ?></a>
      <a href="services.php"><?= t('nav.services') ?></a>
      <a href="contact.php"><?= t('nav.contact') ?></a>
      <?php if (empty($_SESSION['user_id'])): ?>
      <a href="register.php" class="btn-register" style="font-size: 0.7rem; padding: 4px 8px; margin-left: 100px; border-radius: 6px;"><?= t('nav.register') ?></a>
      <a href="login.php" class="btn-login" style="font-size: 0.7rem; padding: 4px 8px; margin-left: 10px; border-radius: 6px;"><?= t('nav.login') ?></a>
      <?php endif; ?>
      <select id="lang-select" class="lang-select" style="margin-left:20px;">
        <option value="el" <?= $lang === 'el' ? 'selected' : '' ?>>Ελληνικά</option>
        <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>English</option>
      </select>
    </nav>
    <div class="workshop-title" style="position: absolute; right: 20px; top: 15px;">
      <?php if (!empty($_SESSION['user_id'])): ?>
      <a href="logout.php" class="btn btn-danger" style="font-size: 0.7rem; padding: 4px 8px; margin-right: 10px; border-radius: 6px;">
        <?= t('nav.logout') ?>
      </a>
      <?php endif; ?>
      <h1 style="font-size: 1.5rem; color: #f1c40f; display: inline-block;">
        <?= t('header.title') ?>
      </h1>
    </div>
  </div>
</header>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var select = document.getElementById('lang-select');
  if (select) {
    select.addEventListener('change', function() {
      select.classList.add('animate-lang');
      setTimeout(function() {
        window.location.href = 'change_language.php?lang=' + select.value;
      }, 200);
    });
  }
});
</script>

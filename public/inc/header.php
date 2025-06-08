<?php
// public/inc/header.php
?>
<header class="site-header dashboard-header">
  <div class="header-top header-container">
    <div class="logo">
      <h1>Car Workshop</h1>
    </div>

    <div class="dash-title">
      <!-- Θα το γεμίσουμε από το dashboard.php -->
      <h2><?= $pageTitle ?? '' ?></h2>
    </div>

    <div class="header-actions">
      <a href="logout.php" class="btn btn-danger">Logout</a>
      <button class="btn btn-primary btn-lang">EN/EL</button>
    </div>
  </div>
</header>

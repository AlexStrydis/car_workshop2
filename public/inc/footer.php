<?php
// public/inc/footer.php
require_once __DIR__ . '/../../config/lang.php';
?>
<section class="site-footer hero-background">
    <div class="container footer-container">
      <div class="footer-col">
        <h4><?= t('footer.contact') ?></h4>
        <p>
          📍 Οδός Γοργύρας, Κτήριο Λυμπέρη, Νέο Καρλόβασι<br />
          📞 Κλήση: 2273082200<br />
          ✉️ Email: gramicsd@icsd.aegean.gr
        </p>
        <p>Ωράριο: Δευτέρα‐Σάββατο</p>
        <p>08:00–16:00</p>
      </div>
      <div class="footer-col">
        <h4><?= t('footer.quick_links') ?></h4>
        <ul>
          <li><a href="index.php"><?= t('nav.home') ?></a></li>
          <li><a href="about.php"><?= t('nav.about') ?></a></li>
          <li><a href="services.php"><?= t('nav.services') ?></a></li>
          <li><a href="contact.php"><?= t('nav.contact') ?></a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4><?= t('footer.follow_us') ?></h4>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Instagram</a></li>
          <li><a href="#">LinkedIn</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom text-center">
      <?= t('footer.all_rights') ?>
    </div>
  </section>

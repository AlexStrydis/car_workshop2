<?php
// public/about.php
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <title>Car Workshop | Σχετικά</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <!-- Χρησιμοποιούμε το ίδιο header -->
  <?php include __DIR__ . '/inc/header.php'; ?>
  
  <!-- Main Content -->
  <section class="container about-section">
    <h2>Σχετικά με το Car Workshop</h2>
    <p class="lead">
      Το Car Workshop ιδρύθηκε το 2015 με όραμα την ποιοτική και γρήγορη εξυπηρέτηση
      των πελατών μας. Από την πρώτη μέρα, στόχος μας είναι να προσφέρουμε:
    </p>
    <ul>
      <li>100% αυθεντικά ανταλλακτικά</li>
      <li>Άμεση διάγνωση βλαβών</li>
      <li>Ισχυρές εγγυήσεις για κάθε εργασία</li>
      <li>Συνεχή εκπαίδευση προσωπικού σε νέες τεχνολογίες</li>
    </ul>
    <p>
      Ελάτε να γνωριστούμε από κοντά, να δείτε τον χώρο μας, και να βεβαιωθείτε ότι
      το αυτοκίνητό σας είναι σε καλά χέρια.
    </p>
  </section>

  <!-- Footer -->
  <?php include __DIR__ . '/inc/footer.php'; ?>
</body>
</html>

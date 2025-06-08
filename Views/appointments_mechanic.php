<!DOCTYPE html>
<html lang="el">
<head>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="UTF-8"><title>Τα Ραντεβού μου</title></head>
<body>
  <?php include __DIR__ . '/../public/inc/header.php'; ?>
  <section class="hero-background">
    <div class="container">
      <h1>Ραντεβού Μηχανικού</h1>

  <?php if(!empty($_SESSION['success'])): ?>
    <p style="color:green"><?=htmlspecialchars($_SESSION['success'])?></p>
    <?php unset($_SESSION['success']); endif; ?>
  <?php if(!empty($_SESSION['error'])): ?>
    <p style="color:red"><?=htmlspecialchars($_SESSION['error'])?></p>
    <?php unset($_SESSION['error']); endif; ?>

  <form method="get">
    <label for="date">Ημερομηνία:</label>
    <input type="date" name="date" value="<?= htmlspecialchars($_GET['date'] ?? '') ?>">
    <button type="submit">Φιλτράρισμα</button>
  </form>
  
  <table class="data-table">
    <tr>
      <th>Ημερομηνία</th><th>Ώρα</th><th>Κατάσταση</th>
      <th>Πελάτης</th><th>Αυτοκίνητο</th><th>Ενέργεια</th>
    </tr>
    <?php foreach($appts as $a): ?>
      <tr>
        <td><?= htmlspecialchars($a['appointment_date']) ?></td>
        <td><?= htmlspecialchars($a['appointment_time']) ?></td>
        <td><?= htmlspecialchars($a['status']) ?></td>
        <td><?= htmlspecialchars($a['cust_last']) ?> <?= htmlspecialchars($a['cust_first']) ?></td>
        <td><?= htmlspecialchars($a['brand']) ?> <?= htmlspecialchars($a['model']) ?></td>
        <td>
          <?php if ($a['status'] !== 'CANCELLED' && $a['status'] !== 'COMPLETED'): ?>
            <form method="post" action="change_status.php" style="display:inline">
              <input type="hidden" name="_csrf" value="<?= htmlspecialchars($token) ?>">
              <input type="hidden" name="id" value="<?= $a['id'] ?>">
              <select name="status">
                <?php foreach(['IN_PROGRESS','COMPLETED','NO_SHOW'] as $s): ?>
                  <option value="<?= $s ?>"><?= $s ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit">Αλλαγή</button>
            </form>
          <?php else: ?>
            -
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>

  <button type="button" onclick="history.back()">Επιστροφή</button>
    </div>
  </section>
  <?php include __DIR__ . '/../public/inc/footer.php'; ?>
</body>
</html>

<?php
// views/all_tasks.php
// Υπάρχουν στο scope: $tasks, $filters, $page, $totalPages, $totalTasks

// βοηθητική συνάρτηση για pagination links
function buildQuery(array $overrides = []): string {
    global $filters;
    $params = array_merge($filters, $overrides);
    return http_build_query($params);
}
?>

<h1>Όλες οι Εργασίες Μου</h1>

<form method="get" action="" style="margin-bottom:1em;">
  <fieldset>
    <legend>Φίλτρα</legend>
    Από: <input type="date" name="from" value="<?= htmlspecialchars($filters['from']) ?>">
    Έως: <input type="date" name="to"   value="<?= htmlspecialchars($filters['to']) ?>"><br>

    Serial: <input type="text" name="serial"        value="<?= htmlspecialchars($filters['serial']) ?>">
    Model:  <input type="text" name="model"         value="<?= htmlspecialchars($filters['model']) ?>"><br>

    Brand:  <input type="text" name="brand"         value="<?= htmlspecialchars($filters['brand']) ?>">
    Επώνυμο Πελάτη: <input type="text" name="customer_last"
                 value="<?= htmlspecialchars($filters['customer_last']) ?>"><br>

    <button type="submit">Εφαρμογή</button>
    <?php if (array_filter($filters)): ?>
      <a href="all_tasks.php" style="margin-left:1em;">Clear All</a>
    <?php endif; ?>
  </fieldset>
</form>

<p>Βρέθηκαν συνολικά <?= $totalTasks ?> εργασίες.</p>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>ID</th><th>Ημ/νία</th><th>Ώρα</th>
      <th>Serial</th><th>Brand</th><th>Model</th><th>Πελάτης</th>
      <th>Περιγραφή</th><th>Υλικά</th><th>Κόστος</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($tasks): foreach ($tasks as $t): ?>
    <tr>
      <td><?= htmlspecialchars($t['id']) ?></td>
      <td><?= date('d/m/Y', strtotime($t['appt_date'])) ?></td>
      <td><?= htmlspecialchars($t['appointment_time']) ?></td>
      <td><?= htmlspecialchars($t['serial']) ?></td>
      <td><?= htmlspecialchars($t['brand']) ?></td>
      <td><?= htmlspecialchars($t['model']) ?></td>
      <td><?= htmlspecialchars($t['cust_last'] . ' ' . $t['cust_first']) ?></td>
      <td><?= htmlspecialchars($t['description']) ?></td>
      <td><?= htmlspecialchars($t['materials']) ?></td>
      <td><?= htmlspecialchars($t['cost']) ?></td>
      <td><a href="edit_task.php?id=<?= $t['id'] ?>">Επεξεργασία</a></td>
    </tr>
    <?php endforeach; else: ?>
      <tr><td colspan="10"><em>Δεν βρέθηκαν εργασίες.</em></td></tr>
    <?php endif; ?>
  </tbody>
</table>

<div class="actions">
      <a href="dashboard.php"><button type="button">Επιστροφή</button></a>
    </div>

<?php if ($totalPages > 1): ?>
  <div style="margin-top:1em;">
    <?php if ($page > 1): ?>
      <a href="?<?= buildQuery(['page' => $page-1]) ?>">← Προηγούμενη</a>
    <?php endif; ?>

    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
      <?php if ($p === $page): ?>
        <strong><?= $p ?></strong>
      <?php else: ?>
        <a href="?<?= buildQuery(['page' => $p]) ?>"><?= $p ?></a>
      <?php endif; ?>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
      <a href="?<?= buildQuery(['page' => $page+1]) ?>">Επόμενη →</a>
    <?php endif; ?>
  </div>
<?php endif; ?>

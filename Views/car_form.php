<!DOCTYPE html>
<html lang="el">
<head>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="UTF-8">
  <title>New Car</title>
</head>
<body>
  <p><button type="button" onclick="history.back()">← Επιστροφή</button></p>

  <?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= htmlspecialchars($_SESSION['error']) ?></p>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <form method="post" action="create_car.php">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($token) ?>">

    <!-- Serial Number -->
    <label>Serial Number:
      <input name="serial_number" type="text" required>
    </label><br>

    <!-- Model -->
    <label>Model:
      <input name="model" type="text" required>
    </label><br>

    <!-- Brand -->
    <label>Brand:
      <input name="brand" type="text" required>
    </label><br>

    <!-- Type -->
    <label>Type:
      <select name="type" id="type" required>
        <option value="">-- Επιλέξτε --</option>
        <?php foreach (['passenger','truck','bus'] as $t): ?>
          <option value="<?= $t ?>"><?= ucfirst($t) ?></option>
        <?php endforeach; ?>
      </select>
    </label><br>

    <!-- Drive Type -->
    <label>Drive Type:
      <select name="drive_type" required>
        <option value="">-- Επιλέξτε --</option>
        <?php foreach (['electric','diesel','gas','hybrid'] as $d): ?>
          <option value="<?= $d ?>"><?= ucfirst($d) ?></option>
        <?php endforeach; ?>
      </select>
    </label><br>

    <!-- Door Count -->
    <label>Door Count:
      <input name="door_count" type="number" min="1" max="7" value="1" required>
    </label><br>

    <!-- Wheel Count -->
    <label>Wheel Count:
      <input name="wheel_count" type="number" min="4" max="18" value="4" required>
    </label><br>

    <!-- Production Date -->
    <label>Production Date:
      <input name="production_date" type="date" max="<?= date('Y-m-d') ?>" required>
    </label><br>

    <!-- Acquisition Year -->
    <label>Acquisition Year:
      <input name="acquisition_year" type="number" min="1900" max="<?= date('Y') ?>" value="<?= date('Y') ?>" required>
    </label><br>

    <!-- Owner: dropdown μόνο για secretary -->
    <?php if (!empty($users)): ?>
      <label>Owner:
        <select name="owner_id" required>
          <option value="">-- Επιλέξτε --</option>
          <?php foreach ($users as $u): ?>
            <option value="<?= (int)$u['user_id'] ?>">
              <?= htmlspecialchars($u['last_name'].' '.$u['first_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label><br>
    <?php else: ?>
      <input type="hidden" name="owner_id" value="<?= (int)$_SESSION['user_id'] ?>">
    <?php endif; ?>

    <button type="submit">Create Car</button>
    <button type="button" onclick="history.back()">Cancel</button>
  </form>
</body>
</html>

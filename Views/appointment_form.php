<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8">
  <title><?= isset($appt) ? 'Edit Appointment' : 'New Appointment' ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php include __DIR__ . '/../public/inc/header.php'; ?>
  <section class="hero-background">
    <div class="container">
      <p>
        <button type="button" onclick="history.back()">← Επιστροφή</button>
      </p>

  <?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= htmlspecialchars($_SESSION['error']) ?></p>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>
  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

      <form method="post"
        action="<?= isset($appt) ? 'edit_appointment.php' : 'create_appointment.php' ?>"
        class="appointment-form">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars($token) ?>">
    <?php if (isset($appt)): ?>
      <input type="hidden" name="id" value="<?= (int)$appt['id'] ?>">
    <?php endif; ?>

    <!-- Date -->
    <label>
      Date:
      <input
        type="date"
        name="appointment_date"
        required
        min="<?= date('Y-m-d') ?>"
        value="<?= htmlspecialchars(
          $_SESSION['old_appt']['appointment_date']
          ?? ($appt['appointment_date'] ?? '')
        ) ?>">
    </label>
    <br>

    <!-- Time slots -->
    <label>
      Time:
      <select name="appointment_time" required>
        <?php
          $fixedSlots = ['08:00','10:00','12:00','14:00'];
          $current = $_SESSION['old_appt']['appointment_time']
                     ?? (isset($appt['appointment_time'])
                         ? substr($appt['appointment_time'],0,5)
                         : '');
        ?>
        <?php foreach ($fixedSlots as $slot): ?>
          <option
            value="<?= $slot ?>"
            <?= $current === $slot ? 'selected' : '' ?>>
            <?= $slot ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    <br>

    <!-- Reason -->
    <label>
      Reason:
      <select name="reason" id="reason" required>
        <option value="">-- Επιλέξτε --</option>
        <option value="repair"
          <?= ((($_SESSION['old_appt']['reason'] ?? '') === 'repair')
            || (!isset($_SESSION['old_appt']['reason'])
               && isset($appt) && $appt['reason'] === 'repair'))
              ? 'selected' : '' ?>>
          Repair
        </option>
        <option value="service"
          <?= ((($_SESSION['old_appt']['reason'] ?? '') === 'service')
            || (!isset($_SESSION['old_appt']['reason'])
               && isset($appt) && $appt['reason'] === 'service'))
              ? 'selected' : '' ?>>
          Service
        </option>
      </select>
    </label>
    <br>

    <!-- Problem Description -->
    <label>
      Problem description:
      <textarea
        name="problem_description"
        id="problem_description"
        rows="3" cols="40"
        <?= ((($_SESSION['old_appt']['reason'] ?? '') === 'repair')
            || (!isset($_SESSION['old_appt']['reason'])
               && isset($appt) && $appt['reason'] === 'repair'))
             ? 'required' : '' ?>><?= htmlspecialchars(
               $_SESSION['old_appt']['problem_description']
               ?? ($appt['problem_description'] ?? '')
             ) ?></textarea>
    </label>
    <br>

    <!-- Car -->
    <label>
      Car:
      <select name="car_serial" required>
        <option value="">-- Επιλέξτε --</option>
        <?php foreach ($cars as $c): ?>
          <option
            value="<?= htmlspecialchars($c['serial_number']) ?>"
            <?= ((($_SESSION['old_appt']['car_serial'] ?? '') === $c['serial_number'])
               || (!isset($_SESSION['old_appt']['car_serial'])
                  && isset($appt) && $appt['car_serial'] === $c['serial_number']))
               ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['serial_number']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    <br>

    <!-- Customer: μόνο για γραμματέα -->
    <?php if ($_SESSION['role'] === 'secretary'): ?>
      <label>
        Customer:
        <select name="customer_id" required>
          <option value="">-- Επιλέξτε --</option>
          <?php foreach ($customers as $cu): ?>
            <option
              value="<?= (int)$cu['user_id'] ?>"
              <?= ((($_SESSION['old_appt']['customer_id'] ?? '') === $cu['user_id'])
                 || (!isset($_SESSION['old_appt']['customer_id'])
                    && isset($appt) && $appt['customer_id'] === $cu['user_id']))
                 ? 'selected' : '' ?>>
              <?= htmlspecialchars($cu['first_name'] . ' ' . $cu['last_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
      <br>
    <?php else: ?>
      <input type="hidden"
             name="customer_id"
             value="<?= (int)$_SESSION['user_id'] ?>">
    <?php endif; ?>

    <!-- Mechanic -->
    <label>
      Mechanic:
      <select name="mechanic_id" required>
        <option value="">-- Επιλέξτε --</option>
        <?php foreach ($mechanics as $m): ?>
          <option
            value="<?= (int)$m['user_id'] ?>"
            <?= ((($_SESSION['old_appt']['mechanic_id'] ?? '') === $m['user_id'])
               || (!isset($_SESSION['old_appt']['mechanic_id'])
                  && isset($appt) && $appt['mechanic_id'] === $m['user_id']))
               ? 'selected' : '' ?>>
            <?= htmlspecialchars($m['first_name'] . ' ' . $m['last_name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    <br>

    <button type="submit">
      <?= isset($appt) ? 'Update Appointment' : 'Create Appointment' ?>
    </button>
    <button type="button" onclick="history.back()">Cancel</button>
  </form>

      <script>
    const reasonEl = document.getElementById('reason');
    const problemEl = document.getElementById('problem_description');
    function updateProblemRequirement() {
      if (reasonEl.value === 'repair') {
        problemEl.setAttribute('required', 'required');
      } else {
        problemEl.removeAttribute('required');
      }
    }
    reasonEl.addEventListener('change', updateProblemRequirement);
    updateProblemRequirement();
  </script>

  <?php unset($_SESSION['old_appt']); ?>
    </div>
  </section>
  <?php include __DIR__ . '/../public/inc/footer.php'; ?>
</body>
</html>

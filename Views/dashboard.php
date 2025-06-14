<?php
// Fallsafe για username και calendar fn
if (!isset($username) || empty($username)) {
    $username = 'Χρήστης';
}
if (!function_exists('renderCalendar')) {
    function renderCalendar(array $appointmentsByDate) {
        // (όπως πριν)
        $year = date('Y');
        $month = date('n');
        $firstDay = mktime(0,0,0,$month,1,$year);
        $daysInMonth = date('t', $firstDay);
        $dayOfWeek = date('w', $firstDay);
        $weekDays = [t('cal.sun'), t('cal.mon'), t('cal.tue'), t('cal.wed'), t('cal.thu'), t('cal.fri'), t('cal.sat')];
        $html  = '<table class="calendar-table"><thead><tr>';
        foreach ($weekDays as $wd) {
            $html .= "<th>{$wd}</th>";
        }
        $html .= '</tr></thead><tbody><tr>';
        for ($i=0; $i<$dayOfWeek; $i++) {
            $html .= '<td></td>';
        }
        for ($day=1; $day<=$daysInMonth; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $has = isset($appointmentsByDate[$date]);
            $cell  = $has
                ? "<a href=\"appointments.php?date={$date}\" class=\"cal-day has-app\">{$day}</a>"
                : "<span class=\"cal-day\">{$day}</span>";
            $html .= "<td>{$cell}</td>";
            if ((($day + $dayOfWeek) % 7) === 0 && $day !== $daysInMonth) {
                $html .= '</tr><tr>';
            }
        }
        $endBlanks = (7 - (($daysInMonth + $dayOfWeek) % 7)) % 7;
        for ($i=0; $i<$endBlanks; $i++) {
            $html .= '<td></td>';
        }
        $html .= '</tr></tbody></table>';
        return $html;
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?></title>
</head>
<body>
  <?php include __DIR__ . '/../public/inc/header.php'; ?>

  <section class="hero-background">
    <div class="hero-overlay"></div>
    <div class="container">
      <h3 class="welcome-message"><?= sprintf(t('dashboard.welcome'), htmlspecialchars($username)) ?></h3>
      <div class="dashboard-actions-box">
        <button onclick="location.href='users.php'"><?= t('dashboard.manage_users') ?></button>
        <button onclick="location.href='cars.php'"><?= t('dashboard.manage_cars') ?></button>
        <button onclick="location.href='appointments.php'"><?= t('dashboard.manage_appointments') ?></button>
        <button onclick="location.href='add_menu.php'"><?= t('dashboard.add_new') ?></button>
      </div>
      <div class="calendar-container">
        <?= renderCalendar($appointmentsByDate) ?>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/../public/inc/footer.php'; ?>
</body>
</html>

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
        $weekDays = ['Κυρ','Δευ','Τρι','Τετ','Πεμ','Παρ','Σαβ'];
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
<html lang="el">
<head>
  <link rel="stylesheet" href="css/style.css">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=htmlspecialchars($pageTitle)?></title>
  
</head>
<body>

  <!-- Hero Image -->
  <section class="hero-background dashboard-hero">
    <div class="hero-overlay"></div>
  </section>

  <!-- Δίπτυχος Layout: Sidebar αριστερά, Main δεξιά -->
  <div class="dashboard-container">

    <!-- SIDEBAR κουτί με τα μεγάλα κουμπιά -->
    <aside class="dashboard-sidebar">
      <button onclick="location.href='users.php'">Διαχείριση Χρηστών</button>
      <button onclick="location.href='cars.php'">Διαχείριση Αυτοκινήτων</button>
      <button onclick="location.href='appointments.php'">Διαχείριση Ραντεβού</button>
      <!-- Νέο -->
  <button onclick="location.href='add_menu.php'">
    Νέα Προσθήκη
  </button>
    </aside>

    <!-- ΚΕΝΤΡΙΚΟ ΠΕΡΙΕΧΟΜΕΝΟ -->
    <main class="dashboard-main">
      <div class="welcome-message">
        <h3>Καλωσήρθες, <?=htmlspecialchars($username)?>!</h3>
      </div>
      <div class="calendar-container">
        <?= renderCalendar($appointmentsByDate) ?>
      </div>
    </main>

  </div>

</body>
</html>

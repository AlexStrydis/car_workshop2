<?php
// views/customer_dashboard.php
// Υποθέτουμε ότι πριν από εδώ έχεις κάνει include του inc/header.php
// και έχει οριστεί $username, $appointmentsByDate κλπ.
?>

<h3>Καλώς ήρθες, <?= htmlspecialchars($username) ?>!</h3>

<!-- nav buttons, σαν του admin αλλά μόνο με τα 3 δικά σου -->
<div class="dashboard-nav" style="margin: 1em 0;">
    <a href="cars.php"><button>Διαχείριση Αυτοκινήτων</button></a>
    <a href="appointments.php"><button>Διαχείριση Ραντεβού</button></a>
    <a href="add_menu.php"><button>Νέα Προσθήκη</button></a>
</div>





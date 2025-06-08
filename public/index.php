<?php
// public/index.php
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <meta charset="UTF-8" />
  <title>Car Workshop | Αρχική</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Φόρτωση του γενικού CSS -->
  <link rel="stylesheet" href="css/style.css" />
  <!-- Προαιρετικά: Google Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap"
    rel="stylesheet"
  />
</head>
<body>
  <!--==============================
    =            HEADER            =
  ==============================-->
  <header class="site-header">
    <div class="container header-container">
      <div class="logo">
        <!-- Αν έχεις λογότυπο, βάλε <img src="images/logo.png" alt="Car Workshop"> 
             αλλιώς απλά γράψε το όνομα: -->
        <h1>Car Workshop</h1>
      </div>
      <nav class="site-nav">
        <a href="index.php">Αρχική</a>
        <a href="about.php">Σχετικά</a>
        <a href="services.php">Υπηρεσίες</a>
        <a href="contact.php">Επικοινωνία</a>
        <a href="register.php" class="btn-register ml-10">Εγγραφή</a>
        <a href="login.php" class="btn-login ml-10">Login</a>
      </nav>
    </div>
  </header>

  <!--==============================
    =         HERO SECTION         =
  ==============================-->
  <section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content container">
      <h2 class="hero-title">Βρες τον καλύτερο μηχανικό για το αυτοκίνητό σου</h2>
      <p class="hero-subtitle">
        Εξειδικευμένες υπηρεσίες service &amp; καθαρισμού, αξιόπιστα ανταλλακτικά
        και προσωπική εξυπηρέτηση.
      </p>
      <div class="hero-cta">
        <a href="register.php" class="btn-register">Εγγραφή Τώρα</a>
        <a href="login.php" class="btn-login">Login</a>
      </div>
    </div>
  </section>

  <!--==============================
    =        ABOUT SECTION         =
  ==============================-->
  <section class="about-section">
    <div class="container">
      <h2>Για εμάς</h2>
      <p class="lead">
        Στο Car Workshop, πάνω από 10 χρόνια εμπειρίας στην επισκευή και την
        συντήρηση αυτοκινήτων. Είμαστε ΑΣΕ πιστοποιημένοι μηχανικοί που
        νοιαζόμαστε πραγματικά για την ασφάλειά σας στο δρόμο. Κάθε όχημα
        αντιμετωπίζεται σαν να ήταν δικό μας. 
      </p>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">🛠️</div>
          <h3>Έμπειροι Μηχανικοί</h3>
          <p>
            Όλοι οι μηχανικοί μας είναι ASE-Certified και εκπαιδευμένοι στις
            τελευταίες τεχνολογίες.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">⏱️</div>
          <h3>Γρήγορη Εξυπηρέτηση</h3>
          <p>
            Στόχος μας η άμεση επίλυση, χωρίς να θυσιάζουμε την ποιότητα.
          </p>
        </div>
        <div class="feature-card">
          <div class="feature-icon">💯</div>
          <h3>Εγγύηση Εργασίας</h3>
          <p>
            Όλες οι εργασίες μας συνοδεύονται από 1 έτος / 10.000χλμ εγγύηση.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!--==============================
    =       SERVICES SECTION       =
  ==============================-->
  <section class="services-section">
    <div class="container">
      <h2>Οι Υπηρεσίες μας</h2>
      <p class="lead">
        Καλύπτουμε οποιαδήποτε ανάγκη συντήρησης ή επισκευής αυτοκινήτου, από
        αλλαγή λαδιών έως και πλήρη ανακατασκευή κινητήρα.
      </p>
      <div class="services-grid">
        <div class="service-card">
          <img src="images/icon-oil.png" alt="Oil Change" />
          <h4>Αλλαγή Λαδιών</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-brake.png" alt="Brake Repair" />
          <h4>Επισκευή Φρένων</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-engine.png" alt="Engine Repair" />
          <h4>Επισκευή Κινητήρα</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-ac.png" alt="A/C Service" />
          <h4>Σέρβις Κλιματισμού</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-battery.png" alt="Battery Service" />
          <h4>Μπαταρίες &amp; Ηλεκτρικά</h4>
        </div>
        <div class="service-card">
          <img src="images/icon-inspection.png" alt="Diagnostics" />
          <h4>Διαγνωστικός Έλεγχος</h4>
        </div>
      </div>
      <div class="text-center mt-10">
          <a href="services.php" class="btn btn-primary">Δες Όλες τις Υπηρεσίες</a>
      </div>
    </div>
  </section>

  <!--==============================
    =       CONTACT / FOOTER        =
  ==============================-->
  <footer class="site-footer">
    <div class="container footer-container">
      <div class="footer-col">
        <h4>Επικοινωνία</h4>
        <p>
          📍 Οδός Γοργύρας, Κτήριο Λυμπέρη, Νέο Καρλόβασι<br />
          📞 Κλήση: 2273082200<br />
          ✉️ Email: gramicsd@icsd.aegean.gr
        </p>
        <p>Ωράριο: Δευτέρα‐Σάββατο</p>
        <p>08:00–16:00</p>
      </div>
      <div class="footer-col">
        <h4>Γρήγοροι Σύνδεσμοι</h4>
        <ul>
          <li><a href="index.php">Αρχική</a></li>
          <li><a href="about.php">Σχετικά</a></li>
          <li><a href="services.php">Υπηρεσίες</a></li>
          <li><a href="contact.php">Επικοινωνία</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Ακολούθησε Μας</h4>
        <p>
          <a href="#">Facebook</a><br />
          <a href="#">Instagram</a><br />
          <a href="#">LinkedIn</a>
        </p>
      </div>
    </div>
    <div class="footer-bottom text-center">
      &copy; 2025 Car Workshop – All Rights Reserved.
    </div>
  </footer>
</body>
</html>

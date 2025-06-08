<?php
// Views/user_form.php
// Προϋποθέτει ότι session_start() έχει γίνει νωρίτερα
// και ότι $user είναι το associative array με τα πεδία του χρήστη.
// Η helper function generateCsrfToken() πρέπει να είναι διαθέσιμη.

?>
<!DOCTYPE html>
<html lang="el">
<head>
  <link rel="stylesheet" href="css/style.css">

  <meta charset="UTF-8">
  <title>Edit User #<?php echo htmlspecialchars($user['id']); ?></title>
  <style>
    form label { display: block; margin-bottom: 0.5em; }
    form input[type="text"],
    form select { width: 300px; padding: 0.3em; }
    .actions { margin-top: 1em; }
  </style>
</head>
<body>
  <?php include __DIR__ . '/../public/inc/header.php'; ?>
  <section class="hero-background">
    <div class="container">
      <p><button type="button" onclick="history.back()">← Επιστροφή</button></p>

      <h1>Edit User #<?php echo htmlspecialchars($user['id']); ?></h1>

  <?php if (!empty($_SESSION['success'])): ?>
    <p style="color:green;"><?php echo htmlspecialchars($_SESSION['success']); ?></p>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <form method="post" action="edit_user.php">
    <!-- CSRF token -->
    <input type="hidden" name="_csrf" value="<?php echo htmlspecialchars(generateCsrfToken()); ?>">

    <!-- User ID -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

    <label>
      Username:
      <input
        type="text"
        name="username"
        required
        value="<?php echo htmlspecialchars($user['username']); ?>"
      >
    </label>

    <label>
      First Name:
      <input
        type="text"
        name="first_name"
        required
        value="<?php echo htmlspecialchars($user['first_name']); ?>"
      >
    </label>

    <label>
      Last Name:
      <input
        type="text"
        name="last_name"
        required
        value="<?php echo htmlspecialchars($user['last_name']); ?>"
      >
    </label>

    <label>
      Identity Number:
      <input
        type="text"
        name="identity_number"
        required
        value="<?php echo htmlspecialchars($user['identity_number']); ?>"
      >
    </label>

    <label>
      Role:
      <select name="role" required>
        <?php foreach (['customer','mechanic','secretary'] as $r): ?>
          <option
            value="<?php echo $r; ?>"
            <?php echo ($user['role'] === $r) ? 'selected' : ''; ?>
          ><?php echo ucfirst($r); ?></option>
        <?php endforeach; ?>
      </select>
    </label>

    <label>
      Active:
      <select name="is_active">
        <option value="1"<?php echo ($user['is_active'] == 1) ? ' selected' : ''; ?>>Yes</option>
        <option value="0"<?php echo ($user['is_active'] == 0) ? ' selected' : ''; ?>>No</option>
      </select>
    </label>

    <div class="actions">
      <button type="submit">Save Changes</button>
      <button type="button" onclick="history.back()">Cancel</button>
    </div>
  </form>
    </div>
  </section>
  <?php include __DIR__ . '/../public/inc/footer.php'; ?>
</body>
</html>

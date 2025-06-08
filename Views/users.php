<?php
// Views/users.php
// Υποθέτω ότι session_start() έχει γίνει στον controller
// και ότι $users έχει φορτωθεί εκεί πριν φτάσουμε στο view.

// Build a dynamic filter label from the incoming GET parameters
$filters = [];

// Username filter
if (!empty($_GET['username'])) {
    $filters[] = 'Username: ' . $_GET['username'];
}

// Last name filter
if (!empty($_GET['last_name'])) {
    $filters[] = 'Last name: ' . $_GET['last_name'];
}

// ID number filter
if (!empty($_GET['identity_number'])) {
    $filters[] = 'ID No: ' . $_GET['identity_number'];
}

// Role filter
if (!empty($_GET['role'])) {
    $filters[] = ucfirst($_GET['role']);
}

// Status filter
if (isset($_GET['status']) && $_GET['status'] !== '') {
    $filters[] = ($_GET['status'] === '1') ? 'Active' : 'Inactive';
}

// If we have any filters, join them; otherwise default to "All"
$filterLabel = !empty($filters)
    ? implode(', ', $filters)
    : 'All';
?>
<!DOCTYPE html>
<html lang="el">
<head>
  <link rel="stylesheet" href="css/style.css">

  <meta charset="UTF-8">
  <title>Users (<?php echo htmlspecialchars($filterLabel); ?>)</title>
  <style>
    form.inline { display: inline; }
    form.search-form label { margin-right: 1em; }
  </style>
</head>
<body>
  <?php include __DIR__ . '/../public/inc/header.php'; ?>
  <section class="hero-background">
    <div class="container">
      <h1>Users (<?php echo htmlspecialchars($filterLabel); ?>)</h1>

      <p><a href="dashboard.php">Dashboard</a></p>

  <?php if (!empty($_SESSION['success'])): ?>
    <p style="color:green"><?php echo htmlspecialchars($_SESSION['success']); ?></p>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <form method="get" action="users.php" class="search-form">
    <label>Username:
      <input name="username" value="<?php echo htmlspecialchars($_GET['username'] ?? ''); ?>">
    </label>
    <label>Last name:
      <input name="last_name" value="<?php echo htmlspecialchars($_GET['last_name'] ?? ''); ?>">
    </label>
    <label>ID No:
      <input name="identity_number" value="<?php echo htmlspecialchars($_GET['identity_number'] ?? ''); ?>">
    </label>
    <label>Role:
      <select name="role">
        <option value=""<?php echo (($_GET['role'] ?? '') === '') ? ' selected' : ''; ?>>All</option>
        <?php foreach (['customer','mechanic','secretary'] as $r): ?>
          <option value="<?php echo $r; ?>"<?php echo (($_GET['role'] ?? '') === $r) ? ' selected' : ''; ?>>
            <?php echo ucfirst($r); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>Status:
      <select name="status">
        <option value=""<?php echo (!isset($_GET['status']) || $_GET['status'] === '') ? ' selected' : ''; ?>>All</option>
        <option value="1"<?php echo (isset($_GET['status']) && $_GET['status'] === '1') ? ' selected' : ''; ?>>Active</option>
        <option value="0"<?php echo (isset($_GET['status']) && $_GET['status'] === '0') ? ' selected' : ''; ?>>Inactive</option>
      </select>
    </label>
    <button type="submit">Search</button>
    <button type="button" onclick="window.location='users.php';">Clear All Filters</button>
  </form>
  
  <table class="data-table">
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>ID No</th>
      <th>Role</th>
      <th>Active</th>
      <th>Created At</th>
      <th>Actions</th>
    </tr>
    <?php foreach($users as $u): ?>
      <tr>
        <td><?php echo htmlspecialchars($u['id']); ?></td>
        <td><?php echo htmlspecialchars($u['username']); ?></td>
        <td><?php echo htmlspecialchars($u['first_name']); ?></td>
        <td><?php echo htmlspecialchars($u['last_name']); ?></td>
        <td><?php echo htmlspecialchars($u['identity_number']); ?></td>
        <td><?php echo htmlspecialchars($u['role']); ?></td>
        <td><?php echo $u['is_active'] ? 'Yes' : 'No'; ?></td>
        <td><?php echo htmlspecialchars($u['created_at']); ?></td>
        <td>
          <a href="edit_user.php?id=<?php echo $u['id']; ?>">Edit</a>
          <form method="post" action="delete_user.php" class="inline" onsubmit="return confirm('Delete user?');">
            <input type="hidden" name="_csrf" value="<?php echo htmlspecialchars(generateCsrfToken()); ?>">
            <input type="hidden" name="user_id" value="<?php echo $u['id']; ?>">
            <button type="submit">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
    </div>
  </section>
  <?php include __DIR__ . '/../public/inc/footer.php'; ?>
</body>
</html>

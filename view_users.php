<?php
// view_users.php

// Bring in the existing connection
require_once __DIR__ . '/config.php';
// config.php defines $connection

// Fetch all users from the lowercase table name
$sql = "SELECT id, first_name, last_name, email, phone 
        FROM users 
        ORDER BY last_name, first_name";
$result = $connection->query($sql);

if (!$result) {
    die("Database error: " . $connection->error);
}
?>

<div class="mt-4">
  <h2>Users List</h2>
  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>User ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($user = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['first_name']) ?></td>
            <td><?= htmlspecialchars($user['last_name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['phone']) ?></td>
            <td>
              <a href="admin.php?edit_user=<?= $user['id'] ?>" class="btn btn-warning btn-sm">
                Edit
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="6" class="text-center">No users found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

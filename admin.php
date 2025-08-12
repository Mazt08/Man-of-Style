<?php
// Turn on full error reporting during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: azul-login.html");
    exit();
}
    
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php"); // Redirect to a different page if not an admin
    exit();
}

// Single source-of-truth DB connection
require_once __DIR__ . '/config.php';
$connection = $conn;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="admin.css">
  <link rel="icon" href="Azul.ico" type="image/x-icon">
  <style>
    select#category { width:150px; height:33px; font-size:16px; padding:5px; }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-md">
  <a class="navbar-brand" href="#"><img src="azul-logo.png" alt="Logo" class="logo"></a>
</nav>

<div class="container mt-4">
  <div class="card">
    <div class="card-header text-white"><h3>Manage Details</h3></div>
    <div class="card-body d-flex flex-column">
      <div class="d-flex align-items-center mb-3">
        <div class="text-center me-4">
          <a href="admin.php"><img src="Azul.ico" alt="Admin" class="logo"></a>
          <h5>Admin Profile</h5>
        </div>
        <div>
          <a href="admin.php?insert_product" class="btn btn-outline-primary m-1">Insert Products</a>
          <a href="admin.php?view_categories" class="btn btn-outline-primary m-1">View Categories</a>
          <a href="admin.php?view_users" class="btn btn-outline-primary m-1">View Users</a>
        </div>
      </div>
      <div>
        <a href="index.php" class="btn btn-success me-2">View Dashboard</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

<div class="container mt-4">
  <?php
  // Module includes
  if (isset($_GET['insert_product']))  include 'insert_products.php';
  if (isset($_GET['view_categories'])) include 'view_categories.php';
  if (isset($_GET['view_users']))      include 'view_users.php';

  //
  // EDIT USER
  //
  if (isset($_GET['edit_user'])) {
    $id = (int)$_GET['edit_user'];
    $stmt = $connection->prepare("SELECT id, first_name, last_name, email, phone FROM users WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
      echo "<p class='alert alert-warning'>User not found.</p>";
    } else {
      if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['update_user'])) {
        $stmt = $connection->prepare(
          "UPDATE users SET first_name=?, last_name=?, email=?, phone=? WHERE id=?"
        );
        $stmt->bind_param(
          'ssssi',
          $_POST['first_name'],
          $_POST['last_name'],
          $_POST['email'],
          $_POST['phone'],
          $id
        );
        if ($stmt->execute()) {
          header('Location: admin.php'); exit;
        } else {
          echo "<div class='alert alert-danger'>Error: ".$stmt->error."</div>";
        }
      }
      // Edit User Form
      ?>
      <h2>Edit User</h2>
      <form method="POST" class="mb-5">
        <div class="mb-3"><label>First Name</label>
          <input name="first_name" class="form-control" value="<?=htmlspecialchars($user['first_name'])?>" required>
        </div>
        <div class="mb-3"><label>Last Name</label>
          <input name="last_name" class="form-control" value="<?=htmlspecialchars($user['last_name'])?>" required>
        </div>
        <div class="mb-3"><label>Email</label>
          <input type="email" name="email" class="form-control" value="<?=htmlspecialchars($user['email'])?>" required>
        </div>
        <div class="mb-3"><label>Phone</label>
          <input name="phone" class="form-control" value="<?=htmlspecialchars($user['phone'])?>" required>
        </div>
        <button name="update_user" class="btn btn-primary">Update User</button>
      </form>
      <?php
    }
    exit();
  }

  //
  // EDIT PRODUCT
  //
  if (isset($_GET['edit_product'])) {
    $id = (int)$_GET['edit_product'];
    $stmt = $connection->prepare("SELECT * FROM products WHERE ProductID=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if (!$product) {
      echo "<p class='alert alert-warning'>Product not found.</p>";
    } else {
      if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['update_product'])) {
        $stmt = $connection->prepare("
          UPDATE products
          SET ProductName=?, Category=?, Subcategory=?, Quantity=?, Price=?, Status=?
          WHERE ProductID=?
        ");
        $stmt->bind_param(
          'siiidsi',
          $_POST['product_name'],
          $_POST['category'],
          $_POST['subcategory'],
          $_POST['quantity'],
          $_POST['price'],
          $_POST['status'],
          $id
        );
        if ($stmt->execute()) {
          header('Location: admin.php'); exit;
        } else {
          echo "<div class='alert alert-danger'>Error: ".$stmt->error."</div>";
        }
      }

      // Dropdown data
      $cats = $connection->query("SELECT CategoryID,CategoryName FROM categories ORDER BY CategoryName");
      $subs = $connection->query("SELECT subcategoryID,subcategory FROM subcategories ORDER BY subcategory");

      // Edit Product Form
      ?>
      <h2>Edit Product</h2>
      <form method="POST" class="mb-5">
        <div class="mb-3"><label>Product Name</label>
          <input name="product_name" class="form-control" value="<?=htmlspecialchars($product['ProductName'])?>" required>
        </div>
        <div class="mb-3"><label>Category</label>
          <select name="category" class="form-control" required>
            <?php while($c=$cats->fetch_assoc()): ?>
              <option value="<?=$c['CategoryID']?>" <?=$c['CategoryID']==$product['Category']?'selected':''?>>
                <?=htmlspecialchars($c['CategoryName'])?>
              </option>
            <?php endwhile;?>
          </select>
        </div>
        <div class="mb-3"><label>Subcategory</label>
          <select name="subcategory" class="form-control" required>
            <?php while($s=$subs->fetch_assoc()): ?>
              <option value="<?=$s['subcategoryID']?>" <?=$s['subcategoryID']==$product['Subcategory']?'selected':''?>>
                <?=htmlspecialchars($s['subcategory'])?>
              </option>
            <?php endwhile;?>
          </select>
        </div>
        <div class="mb-3"><label>Quantity</label>
          <input type="number" name="quantity" class="form-control" value="<?=htmlspecialchars($product['Quantity'])?>" required>
        </div>
        <div class="mb-3"><label>Price</label>
          <input name="price" class="form-control" value="<?=htmlspecialchars($product['Price'])?>" required>
        </div>
        <div class="mb-3"><label>Status</label>
          <select name="status" class="form-control">
            <option value="Available"   <?=$product['Status']=='Available'  ?'selected':''?>>Available</option>
            <option value="Out of Stock"<?=$product['Status']=='Out of Stock'?'selected':''?>>Out of Stock</option>
          </select>
        </div>
        <button name="update_product" class="btn btn-primary">Update Product</button>
      </form>
      <?php
    }
    exit();
  }

  //
  // DEFAULT: Product Listing with Filter
  //
  $cats = $connection->query("SELECT CategoryID,CategoryName FROM categories ORDER BY CategoryName");
  $selected = $_POST['category'] ?? '';

  // Build query
  if ($selected) {
    $stmt = $connection->prepare("SELECT * FROM products WHERE Category=? ORDER BY ProductID ASC");
    $stmt->bind_param('i',$selected);
  } else {
    $stmt = $connection->prepare("SELECT * FROM products ORDER BY ProductID ASC");
  }
  $stmt->execute();
  $result = $stmt->get_result();
  ?>

  <h1 class="mt-4">E-Cart Product Listing</h1>
  <form method="POST" class="mb-3">
    <select name="category" id="category">
      <option value="">All Categories</option>
      <?php
      $cats->data_seek(0);
      while($c=$cats->fetch_assoc()){
        $sel = $c['CategoryID']==$selected?'selected':'';
        echo "<option value='{$c['CategoryID']}' {$sel}>{$c['CategoryName']}</option>";
      }
      ?>
    </select>
    <button class="btn btn-info btn-sm">Filter</button>
  </form>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th><th>Name</th><th>Cat</th><th>Sub</th>
        <th>Qty</th><th>Price</th><th>Status</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if($result->num_rows):
        while($p=$result->fetch_assoc()): ?>
          <tr>
            <td><?= $p['ProductID'] ?></td>
            <td><?= htmlspecialchars($p['ProductName']) ?></td>
            <td><?= $p['Category'] ?></td>
            <td><?= $p['Subcategory'] ?></td>
            <td><?= $p['Quantity'] ?></td>
            <td>₱<?= number_format($p['Price'],2) ?></td>
            <td><?= htmlspecialchars($p['Status']) ?></td>
            <td>
              <a href="admin.php?edit_product=<?= $p['ProductID'] ?>"
                 class="btn btn-warning btn-sm">Edit</a>
            </td>
          </tr>
        <?php endwhile;
      else: ?>
        <tr><td colspan="8">No products found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</div>

<?php $connection->close(); ?>

</body>
</html>

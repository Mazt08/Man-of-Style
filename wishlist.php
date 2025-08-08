<?php
// Include the database connection file
include('config.php');

// Start the session to get the logged-in user's ID
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Wishlist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=0.5" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="Azul.ico">
</head>
<body>
<nav class="navbar navbar-expand-md">
    <a class="navbar-brand" href="index.php"><img src="azul-logo.png" alt="Logo" class="logo" /></a>
    <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="main-navigation">
            <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                <!-- Admin is logged in -->
                <li class="nav-item">
                    <a class="nav-link" href="admin.php" title="Admin Panel">
                        <i class="fa-solid fa-database fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php" title="Cart">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wishlist.php" title="Wishlist">
                        <i class="fa-solid fa-heart fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" title="Logout">
                        <i class="fa-solid fa-sign-out-alt fa-2xl"></i>
                    </a>
                </li>
            
            <?php elseif (isset($_SESSION['user_id'])): ?>
                <!-- Regular user logged in -->
                <li class="nav-item">
                    <a class="nav-link" href="cart.php" title="Cart">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wishlist.php" title="Wishlist">
                        <i class="fa-solid fa-heart fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" title="Logout">
                        <i class="fa-solid fa-sign-out-alt fa-2xl"></i>
                    </a>
                </li>
            
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php" title="Cart">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="wishlist.php" title="Wishlist">
                        <i class="fa-solid fa-heart fa-2xl"></i>
                    </a>
                </li>
                <!-- Not logged in -->
                <li class="nav-item">
                    <a class="nav-link" href="azul-login.html" title="Login">
                        <i class="fa-solid fa-user fa-2xl"></i>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h2>Your Wishlist</h2>

    <?php
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Fetch user's wishlist items
        $wishlistQuery = "SELECT w.WishlistID, p.ProductName, p.Price, p.ProductImages FROM wishlist w JOIN products p ON w.ProductID = p.ProductID WHERE w.UserID = ?";
        if ($stmt = $conn->prepare($wishlistQuery)) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            echo '<table class="table table-striped">';
            echo '<thead><tr><th>Product Name</th><th>Price</th><th>Action</th></tr></thead>';
            echo '<tbody>';

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['ProductName']) . '</td>';
                    echo '<td>₱' . htmlspecialchars(number_format($row['Price'], 2)) . '</td>';
                    echo '<td><a href="remove_from_wishlist.php?id=' . htmlspecialchars($row['WishlistID']) . '" class="btn btn-danger btn-sm">Remove</a></td>'; // Link to remove item from wishlist
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">Your wishlist is empty.</td></tr>';
            }

            echo '</tbody></table>';
        } else {
            echo "Error preparing the query.";
        }
    } else {
        echo '<script>
            alert("You are not currently logged in.");
            window.location.href = "azul-login.html";
        </script>';
        exit();
    }

    // Check if product_id is set in POST request
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];

        // Prepare insert statement
        $insertQuery = "INSERT INTO wishlist (UserID, ProductID) VALUES (?, ?)";
        if ($stmt = $conn->prepare($insertQuery)) {
            $stmt->bind_param("ii", $userId, $productId);
            if ($stmt->execute()) {
                echo "<script>alert('Item added to your wishlist.'); window.location.href='wishlist.php';</script>";
            } else {
                echo "Error adding item to wishlist.";
            }
        }
    }

    // Close the database connection
    $conn->close();
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
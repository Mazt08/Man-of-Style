<?php
session_start();
include("config.php");

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    echo "Please log in to add items to your wishlist.";
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['user_email'];

// Check if product_id is posted
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Validate product exists
    $product_stmt = $conn->prepare("SELECT ProductID FROM products WHERE ProductID = ?");
    $product_stmt->bind_param("i", $product_id);
    $product_stmt->execute();
    $product_result = $product_stmt->get_result();

    if ($product_result->num_rows > 0) {
        // Check if already in wishlist
        $check_stmt = $conn->prepare("SELECT * FROM wishlist WHERE UserID = ? AND ProductID = ?");
        $check_stmt->bind_param("ii", $user_id, $product_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "Product is already in your wishlist.";
        } else {
            // Add to wishlist
            $insert_stmt = $conn->prepare("INSERT INTO wishlist (UserID, ProductID, Email) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("iis", $user_id, $product_id, $email);
            if ($insert_stmt->execute()) {
                echo "Product added to wishlist!";
            } else {
                echo "Error adding to wishlist.";
            }
            $insert_stmt->close();
        }

        $check_stmt->close();
    } else {
        echo "Product not found.";
    }

    $product_stmt->close();
} else {
    echo "Product ID is required.";
}

$conn->close();
?>

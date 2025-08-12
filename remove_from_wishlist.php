<?php
// Include the database connection file
include('config.php');

// Start session
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Check if WishlistID is set in GET request
    if (isset($_GET['id'])) {
        $wishlistId = $_GET['id'];

        // Prepare delete statement
        $deleteQuery = "DELETE FROM wishlist WHERE WishlistID = ? AND UserID = ?";
        if ($stmt = $conn->prepare($deleteQuery)) {
            $stmt->bind_param("ii", $wishlistId, $userId);
            if ($stmt->execute()) {
                echo "<script>alert('Item removed from your wishlist.'); window.location.href='wishlist.php';</script>";
            } else {
                echo "Error removing item from wishlist.";
            }
        }
        $stmt->close();
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Please log in to manage your wishlist."; // Error message if not logged in
}

$conn->close();
?>
<?php
// Include database connection
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure the user is logged in
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Prepare query to delete all products in the cart for the current user
        $query = "DELETE FROM cart WHERE UserID = ?";
        
        if ($stmt = $conn->prepare($query)) {
            // Bind the parameter and execute the query
            $stmt->bind_param("i", $userId);
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }
}

$conn->close();
?>

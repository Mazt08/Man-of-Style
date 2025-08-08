<?php
// Include database connection
include('config.php');

// Start session
session_start();

$response = ["success" => false];

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Query to remove all cart items for the user
    $query = "DELETE FROM cart WHERE UserID = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $userId);
        if ($stmt->execute()) {
            $response["success"] = true;
        }
        $stmt->close();
    }
}

echo json_encode($response);
?>

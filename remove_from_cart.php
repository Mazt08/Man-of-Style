<?php
// Include database connection
include('config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $cartId = $data['cartId'];

    // Ensure the user is logged in
    if (isset($_SESSION['user_id']) && isset($cartId)) {
        $userId = $_SESSION['user_id'];

        // Prepare query to delete product from the cart
        $query = "DELETE FROM cart WHERE CartID = ? AND UserID = ?";
        
        if ($stmt = $conn->prepare($query)) {
            // Bind parameters and execute the query
            $stmt->bind_param("ii", $cartId, $userId);
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

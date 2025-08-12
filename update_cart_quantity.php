<?php
// Include the database connection file
include('config.php');

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Decode the JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate inputs
        if (isset($data['cartId'], $data['quantity']) && $data['quantity'] > 0) {
            $cartId = intval($data['cartId']);
            $quantity = intval($data['quantity']);

            // Update the quantity in the cart
            $query = "UPDATE cart SET Quantity = ?, Price = (SELECT Price FROM products WHERE products.ProductID = cart.ProductID) * ? WHERE CartID = ? AND UserID = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("iiii", $quantity, $quantity, $cartId, $userId);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Quantity updated successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update quantity.']);
                }
                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to prepare query.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();

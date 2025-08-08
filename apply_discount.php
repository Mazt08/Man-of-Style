<?php
// Include database connection
include('config.php');

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Decode JSON request body
        $data = json_decode(file_get_contents('php://input'), true);

        // Validate discount code
        if (isset($data['discountCode'])) {
            $discountCode = $data['discountCode'];

            // Define your discount logic
            $discountAmount = 0;
            if ($discountCode === 'LESS100') {
                $discountAmount = 100; // Flat discount of ₱100
            } elseif ($discountCode === 'MORON5') {
                $discountAmount = 50; // Flat discount of ₱50
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid discount code.']);
                exit;
            }

            // Update cart prices with discount for the logged-in user
            $query = "UPDATE cart 
                      SET Price = GREATEST((Price / Quantity) - ?, 0) * Quantity 
                      WHERE UserID = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("ii", $discountAmount, $userId);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Discount applied successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to apply discount.']);
                }
                $stmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to prepare query.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Discount code not provided.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();

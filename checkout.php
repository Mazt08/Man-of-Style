<?php
// Include database connection
include('config.php');

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Fetch cart items for the user
        $query = "SELECT c.ProductID, c.Quantity, p.Quantity AS Stock 
                  FROM cart c
                  JOIN products p ON c.ProductID = p.ProductID
                  WHERE c.UserID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Begin transaction
            $conn->begin_transaction();

            try {
                // Update product stock and remove items from cart
                while ($row = $result->fetch_assoc()) {
                    $productId = $row['ProductID'];
                    $cartQuantity = $row['Quantity'];
                    $stockQuantity = $row['Stock'];

                    if ($stockQuantity < $cartQuantity) {
                        throw new Exception("Insufficient stock for product ID: $productId");
                    }

                    // Update stock in the products table
                    $updateStockQuery = "UPDATE products SET Quantity = Quantity - ? WHERE ProductID = ?";
                    $updateStockStmt = $conn->prepare($updateStockQuery);
                    $updateStockStmt->bind_param("ii", $cartQuantity, $productId);
                    $updateStockStmt->execute();

                    // Remove item from cart
                    $removeCartQuery = "DELETE FROM cart WHERE UserID = ? AND ProductID = ?";
                    $removeCartStmt = $conn->prepare($removeCartQuery);
                    $removeCartStmt->bind_param("ii", $userId, $productId);
                    $removeCartStmt->execute();
                }

                // Commit transaction
                $conn->commit();
                echo json_encode(['success' => true, 'message' => 'Checkout completed successfully.']);
            } catch (Exception $e) {
                // Rollback transaction in case of error
                $conn->rollback();
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Cart is empty.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();

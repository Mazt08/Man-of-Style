<?php
include('config.php');
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    $userId = $_SESSION['user_id'];
    $email = $_SESSION['user_email'];

    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        $query = "SELECT Quantity FROM cart WHERE ProductID = ? AND UserID = ? AND Email = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("iis", $productId, $userId, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            $productQuery = "SELECT Price FROM products WHERE ProductID = ?";
            $productStmt = $conn->prepare($productQuery);
            $productStmt->bind_param("i", $productId);
            $productStmt->execute();
            $productResult = $productStmt->get_result();

            if ($productResult->num_rows > 0) {
                $product = $productResult->fetch_assoc();
                $productPrice = $product['Price'];

                if ($result->num_rows > 0) {
                    $cartItem = $result->fetch_assoc();
                    $newQuantity = $cartItem['Quantity'] + $quantity;
                    $newTotalPrice = $productPrice * $newQuantity;

                    $updateQuery = "UPDATE cart SET Quantity = ?, Price = ? WHERE ProductID = ? AND UserID = ? AND Email = ?";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bind_param("idiss", $newQuantity, $newTotalPrice, $productId, $userId, $email);
                    $updateStmt->execute();
                    $updateStmt->close();

                    echo "<script>alert('Product quantity updated in your cart.'); window.location.href='cart.php';</script>";
                } else {
                    $totalPrice = $productPrice * $quantity;

                    $insertQuery = "INSERT INTO cart (UserID, Email, ProductID, Quantity, Price) VALUES (?, ?, ?, ?, ?)";
                    $insertStmt = $conn->prepare($insertQuery);
                    $insertStmt->bind_param("isiid", $userId, $email, $productId, $quantity, $totalPrice);
                    $insertStmt->execute();
                    $insertStmt->close();

                    echo "<script>alert('Product added to your cart.'); window.location.href='cart.php';</script>";
                }
            } else {
                echo "Product not found.";
            }

            $productStmt->close();
            $stmt->close();
        } else {
            echo "Database error: Failed to prepare SELECT statement.";
        }
    } else {
        echo "Please provide a valid product ID.";
    }
} else {
    echo '<script>
        alert("You are not currently logged in.");
        window.location.href = "azul-login.html";
    </script>';
    exit();
}

$conn->close();
?>

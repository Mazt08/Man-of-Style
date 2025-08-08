<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name']);
    $category = intval($_POST['category']);
    $subcategory = intval($_POST['subcategory']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    $status = trim($_POST['status']);

    $stmt = $conn->prepare("INSERT INTO products (ProductName, Category, Subcategory, Quantity, Price, Status) VALUES (?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Prepare failed: " . $connection->error);
    }

    $stmt->bind_param("siiids", $product_name, $category, $subcategory, $quantity, $price, $status);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error inserting product: " . $stmt->error;
    }

    $stmt->close();
}

$category_result = $connection->query("SELECT CategoryID, CategoryName FROM categories");
if (!$category_result) {
    die("Category query failed: " . $connection->error);
}

$subcategory_result = $connection->query("SELECT subcategoryID, subcategory FROM subcategories");
if (!$subcategory_result) {
    die("Subcategory query failed: " . $connection->error);
}
?>


<style>
    select#category, select#subcategory {
        width: 210px; 
        height: 30px; 
        font-size: 16px;
        padding: 5px; 
    }

    select#status{
        width: 210px; 
        height: 30px; 
        font-size: 16px;
        padding: 5px; 
        margin-bottom: 5px;
    }
</style>

<h2>Insert Product</h2>

<form action="insert_products.php" method="POST">
    <div class="insert-products">
        <div class="col1">
            <label for="product_name">Product Name:</label><br>
            <input type="text" id="product_name" name="product_name" required><br><br>

            <label for="category">Category:</label><br>
            <select name="category" id="category" required>
                <?php if ($category_result && $category_result->num_rows > 0): ?>
                    <?php while ($row = $category_result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['CategoryID']) ?>">
                            <?= htmlspecialchars($row['CategoryName']) ?>
                        </option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="">No categories found</option>
                <?php endif; ?>
            </select><br>

            <label for="subcategory">Subcategory:</label><br>
            <select name="subcategory" id="subcategory" required>
                <?php if ($subcategory_result && $subcategory_result->num_rows > 0): ?>
                    <?php while ($row = $subcategory_result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($row['subcategoryID']) ?>">
                            <?= htmlspecialchars($row['subcategory']) ?>
                        </option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="">No subcategories found</option>
                <?php endif; ?>
            </select><br>
        </div>

        <div class="col2">
            <label for="quantity">Quantity:</label><br>
            <input type="number" id="quantity" name="quantity" min="0" required><br><br>

            <label for="price">Price:</label><br>
            <input type="number" step="0.01" min="0" id="price" name="price" required><br><br>

            <label for="status">Status:</label><br>
            <select id="status" name="status" required>
                <option value="Available">Available</option>
                <option value="Out of Stock">Out of Stock</option>
            </select><br>
        </div>
    </div>
    <button type="submit" class="admin-buttons">Add Product</button>
</form>



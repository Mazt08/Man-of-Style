<?php
require 'config.php';

// Query to fetch all categories
$category_sql = "SELECT CategoryID, CategoryName FROM categories ORDER BY CategoryID";
$result1 = $connection->query($category_sql);

// Query to fetch all subcategories
$subcategory_sql = "SELECT subcategoryID, subcategory FROM subcategories ORDER BY subcategoryID";
$result2 = $connection->query($subcategory_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Categories and Subcategories</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>

<h2>Categories List</h2>
<table>
    <thead>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result1 && $result1->num_rows > 0) {
            while ($category = $result1->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($category['CategoryID']) . "</td>
                        <td>" . htmlspecialchars($category['CategoryName']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No categories found.</td></tr>";
        }
        ?>
    </tbody>
</table>

<h2>Subcategories List</h2>
<table>
    <thead>
        <tr>
            <th>Subcategory ID</th>
            <th>Subcategory Name</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result2 && $result2->num_rows > 0) {
            while ($subcategory = $result2->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($subcategory['subcategoryID']) . "</td>
                        <td>" . htmlspecialchars($subcategory['subcategory']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No subcategories found.</td></tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>

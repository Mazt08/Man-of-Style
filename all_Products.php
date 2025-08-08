<?php
// Include database configuration
include 'config.php';

// Function to fetch products grouped by category
function fetchProductsByCategory($conn) {
    // Build the query to fetch products along with category names
    $sql = "
        SELECT p.ProductID, p.ProductName, p.Price, p.ProductImages, p.Category, c.CategoryName
        FROM products p
        LEFT JOIN categories c ON p.Category = c.CategoryID
        ORDER BY c.CategoryID, p.ProductID
    ";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all results as an associative array
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch products grouped by category
$products = fetchProductsByCategory($conn);

// Group products by category
$groupedProducts = [];
foreach ($products as $product) {
    $groupedProducts[$product['Category']][] = $product;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azul Cosmetics</title>
    <!--Bootstraps-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!--CSS-->
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="Azul.ico">
</head>
<body>
    <nav class="navbar navbar-expand-md">
        <a class="navbar-brand" href="index.php"><img src="azul-logo.png" alt="Logo" class="logo"></a>
        <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-navigation">
            <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                <!-- Admin is logged in -->
                <li class="nav-item">
                    <a class="nav-link" href="admin.php" title="Admin Panel">
                        <i class="fa-solid fa-database fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php" title="Cart">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wishlist.php" title="Wishlist">
                        <i class="fa-solid fa-heart fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" title="Logout">
                        <i class="fa-solid fa-sign-out-alt fa-2xl"></i>
                    </a>
                </li>
            
            <?php elseif (isset($_SESSION['user_id'])): ?>
                <!-- Regular user logged in -->
                <li class="nav-item">
                    <a class="nav-link" href="cart.php" title="Cart">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wishlist.php" title="Wishlist">
                        <i class="fa-solid fa-heart fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" title="Logout">
                        <i class="fa-solid fa-sign-out-alt fa-2xl"></i>
                    </a>
                </li>
            
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php" title="Cart">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="wishlist.php" title="Wishlist">
                        <i class="fa-solid fa-heart fa-2xl"></i>
                    </a>
                </li>
                <!-- Not logged in -->
                <li class="nav-item">
                    <a class="nav-link" href="azul-login.html" title="Login">
                        <i class="fa-solid fa-user fa-2xl"></i>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
    </nav>
    

    <!--Suggested Products-->
   <div class="category-container" style="margin-top: 100px">
     <?php foreach ($groupedProducts as $categoryId => $categoryProducts): ?>
        <div class="suggested-products" style="margin-top: 3%;">
            <div class="sug-pos">
                <h2 class="sug-title"><?php echo htmlspecialchars($categoryProducts[0]['CategoryName']); ?></h2>
            </div>
            <div class="suggested-grid">
                <div class="suggested-container swiper">
                    <div class="suggested-wrapper">
                        <ul class="suggested-list swiper-wrapper">
                            <?php foreach ($categoryProducts as $product): ?>
                                <li class="suggested-card swiper-slide">
                                    <button class="add-to-wishlist2" type="button"><i class="fa-regular fa-heart"></i></button>
                                    <a href="product-page copy.php?product_id=<?php echo $product['ProductID']; ?>" class="suggested-link">
                                        <img src="products/<?php echo htmlspecialchars($product['ProductImages']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>" class="suggested-image">
                                        <p class="badge"><?php echo htmlspecialchars($product['CategoryName']); ?></p>
                                        <h2 class="suggested-title"><?php echo htmlspecialchars($product['ProductName']); ?></h2>
                                        <h3 class="suggested-price">₱<?php echo number_format($product['Price'], 2); ?></h3>
                                        <form method="POST" action="add_to_cart.php">
                                            <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>">
                                            <div class="endorsement-buttons">
                                                <button type="submit" class="buy-now-btn">Buy Now</button>
                                                <button type="submit" class="add-to-cart-btn">
                                                    <i class="fa-solid fa-cart-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

   </div>
    <!--Page Footer-->
    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <h6 class="text-uppercase font-weight-bold">About Azul:</h6>
                    <p>At Azul, we believe beauty begins with confidence. We are a proudly local beauty shop offering a wide range of high-quality cosmetics and self-care products for every personality and style. From eye-catching eyeliners to nourishing skincare, bold lip colors to everyday hair essentials, Azul is your one-stop destination for everything beauty.</p>
                    <p>Our curated collections are designed to help you express yourself freely and feel beautiful in your own skin every day, any time. Whether you're perfecting your brows, adding a pop of blush, or simply caring for your skin, Azul is here to glow with you.</p>
                    <p>Explore beauty. Embrace confidence. Only at Azul.</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <h6 class="text-uppercase font-weight-bold">Contact</h6>
                    <p>936a R-6, Project 3, Quezon City, 1014 Metro Manila<br /> azulcosmetics@gmail.com
                        <br /> +63 915 048 2884<br /> +63 995 100 6601</p>
                </div>
            </div>
        </div>
        <div class="footer-copyright text-center">
            © 2025 Copyright: azulcosmetics.com
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="main.js"></script>
</body>
</html>

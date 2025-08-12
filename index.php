<?php
// Include database configuration
include 'config.php';
session_start();
// Define arrays of product IDs for the rows
$row1ProductIds = [1, 2, 3, 7, 8, 10, 12, 26, 28]; // Product IDs for the first row
$row2ProductIds = [4, 5, 6, 9, 11, 24, 25, 27, 29]; // Product IDs for the second row
$row3ProductIds = [3, 23, 22]; // Endorsement - Laptop
$row4ProductIds = [18, 20];
// Function to fetch products based on product IDs
function fetchProducts($conn, $productIds) {
    // Check if the array is empty
    if (empty($productIds)) {
        return [];
    }

    // Convert the array to a comma-separated string for SQL
    $productIdsPlaceholder = implode(',', array_fill(0, count($productIds), '?'));

    // Build the query
    $sql = "
        SELECT p.ProductID, p.ProductName, p.Price, p.ProductImages, p.Category, c.CategoryName
        FROM products p
        LEFT JOIN categories c ON p.Category = c.CategoryID
        WHERE p.ProductID IN ($productIdsPlaceholder)
    ";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the product ID values dynamically
    $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all results as an associative array
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch products for each row
$row1Products = fetchProducts($conn, $row1ProductIds);
$row2Products = fetchProducts($conn, $row2ProductIds);
$row3Products = fetchProducts($conn, $row3ProductIds);
$row4Products = fetchProducts($conn, $row4ProductIds);  // ENDORSEMENT - Desktops

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azul Cosmetics</title>
    <!--Bootstraps-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!--CSS-->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="homepage.css">
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
    <!--This is the intro header-->
    <div class="title" style="margin-top: 50px;">
    <div>
    <section class="slide-container">
        <div class="slide-wrapper">
    <div class="slider">
    <a href="lipstick.php" class="slider-item">
        <img id="slide1" src="images/Lips.png" alt="">
    </a>
    <a href="all_Products.php" class="slider-item">
        <img id="slide2"  src="images/Perfume Banner.png" alt="">
    </a>
    <a href="concealer.php" class="slider-item">
        <img id="slide3" src="images/Skin Banner.png" alt="">
    </a>
    </div>
        <div class="slider-nav">
            <a href="#slide1"></a>
            <a href="#slide2"></a>
            <a href="#slide3"></a>
        </div>
        </div>
    </div>
                <h2>PRODUCT CATEGORIES</h2>
            </div>
            <div class="gradient-underline"></div>
        </div>
    </div>

    <!--This is the product carousel-->
    <div class="product-grid">
        <div class="product-container swiper">
            <div class="product-wrapper">
                <ul class="product-list swiper-wrapper">
                    <li class="product-card swiper-slide">
                        <a href="eyeliner.php" class="product-link">
                            <img src="products/eyes/11/1.png" alt="Azul Eyeliner" class="product-image">
                            <p class="badge">Eyeliner</p>
                            <h2 class="product-title">AZUL EYELINERS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="eyeshadow.php" class="product-link">
                            <img src="products/eyes/12/6.png" alt="Azul Eye Shadow" class="product-image">
                            <p class="badge">Eye Shadow</p>
                            <h2 class="product-title">AZUL EYE SHADOWS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="contactlense.php" class="product-link">
                            <img src="products/eyes/13/11.png" alt="Azul Contact Lense" class="product-image">
                            <p class="badge">Contact Lense</p>
                            <h2 class="product-title">AZUL CONTACT LENSES</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="eyelash.php" class="product-link">
                            <img src="products/eyes/14/17.png" alt="Azul Eyelast" class="product-image">
                            <p class="badge">Eyelash</p>
                            <h2 class="product-title">AZUL EYE LASHES</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="eyebrow.php" class="product-link">
                            <img src="products/eyes/15/21.png" alt="Azul Eyebrow" class="product-image">
                            <p class="badge">Eyebrow</p>
                            <h2 class="product-title">AZUL EYEBROWS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="blush.php" class="product-link">
                            <img src="products/face/22/31.jpg" alt="Azul Blush" class="product-image">
                            <p class="badge">Blush</p>
                            <h2 class="product-title">AZUL BLUSHES</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="concealer.php" class="product-link">
                            <img src="products/face/23/36.jpg" alt="Azul Concealer" class="product-image">
                            <p class="badge">Concealer</p>
                            <h2 class="product-title">AZUL CONCEALERS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="contour.php" class="product-link">
                            <img src="products/face/24/41.jpg" alt="Azul Contour" class="product-image">
                            <p class="badge">Contour</p>
                            <h2 class="product-title">AZUL CONTOURS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="foundation.php" class="product-link">
                            <img src="products/face/21/26.jpg" alt="Azul Foundation" class="product-image">
                            <p class="badge">Foundation</p>
                            <h2 class="product-title">AZUL FOUNDATIONS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="primer.php" class="product-link">
                            <img src="products/face/25/46.jpg" alt="Azul Primer" class="product-image">
                            <p class="badge">Primer</p>
                            <h2 class="product-title">AZUL PRIMERS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="haircolor.php" class="product-link">
                            <img src="products/hair/41/76.png" alt="Azul Hair Colors" class="product-image">
                            <p class="badge">Hair Color</p>
                            <h2 class="product-title">AZUL HAIR COLORS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="conditioner.php" class="product-link">
                            <img src="products/hair/42/81.png" alt="Azul Hair Condtioner" class="product-image">
                            <p class="badge">Hair Conditioner</p>
                            <h2 class="product-title">AZUL HAIR CONDITIONERS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="hairextension.php" class="product-link">
                            <img src="products/hair/43/86.png" alt="Azul Hair Extension/Wig" class="product-image">
                            <p class="badge">Hair Extension/Wig</p>
                            <h2 class="product-title">AZUL HAIR EXTENSION/WIG</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="shampoo.php" class="product-link">
                            <img src="products/hair/44/91.png" alt="Azul Hair Shampoo" class="product-image">
                            <p class="badge">Hair Shampoo</p>
                            <h2 class="product-title">AZUL SHAMPOOS</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="straightener.php" class="product-link">
                            <img src="products/hair/45/96.png" alt="Azul Straighteners" class="product-image">
                            <p class="badge">Straightener</p>
                            <h2 class="product-title">AZUL STRAIGHTENERS</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="lipbalm.php" class="product-link">
                            <img src="products/lips/32/56.jpg" alt="Azul Lip Balm" class="product-image">
                            <p class="badge">Lip Balm</p>
                            <h2 class="product-title">AZUL LIP BALMS</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="lipgloss.php" class="product-link">
                            <img src="products/lips/31/51.jpg" alt="Azul Lip Gloss" class="product-image">
                            <p class="badge">Lip Gloss</p>
                            <h2 class="product-title">AZUL LIP GLOSSES</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="lipliner.php" class="product-link">
                            <img src="products/lips/35/71.jpg" alt="Azul Lip Liner" class="product-image">
                            <p class="badge">Lip Liner</p>
                            <h2 class="product-title">AZUL LIP LINERS</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="liptint.php" class="product-link">
                            <img src="products/lips/34/66.jpg" alt="Azul Lip Tint" class="product-image">
                            <p class="badge">Lip Tint</p>
                            <h2 class="product-title">AZUL LIP TINTS</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="lipstick.php" class="product-link">
                            <img src="products/lips/33/61.jpg" alt="Azul Lipstick" class="product-image">
                            <p class="badge">Lipstick</p>
                            <h2 class="product-title">AZUL LIPSTICKS</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="cleanser.php" class="product-link">
                            <img src="products/skin/51/101.png" alt="Azul Cleanser" class="product-image">
                            <p class="badge">Cleanser</p>
                            <h2 class="product-title">AZUL CLEANSERS</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="facewash.php" class="product-link">
                            <img src="products/skin/52/106.png" alt="Azul Face Wash" class="product-image">
                            <p class="badge">Face Wash</p>
                            <h2 class="product-title">AZUL FACE WASH</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="lotionmoisturizer.php" class="product-link">
                            <img src="products/skin/53/111.png" alt="Azul Lotion & Moisturizer" class="product-image">
                            <p class="badge">Lotion & Moisturizer</p>
                            <h2 class="product-title">AZUL LOTIONS & MOISTURIZERS</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="sunscreenblock.php" class="product-link">
                            <img src="products/skin/54/116.png" alt="Azul Sun Screen & Sun Block" class="product-image">
                            <p class="badge">Sun Screen & Block</p>
                            <h2 class="product-title">AZUL SUN SCREENS & BLOCKS</h2>
                        </a>
                    </li>
                    <li class="product-card swiper-slide">
                        <a href="toner.php" class="product-link">
                            <img src="products/skin/55/121.png" alt="Azul Toner" class="product-image">
                            <p class="badge">Toner</p>
                            <h2 class="product-title">AZUL TONERS</h2>
                        </a>
                    </li>
                </ul>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </div>    

    <!--This is for the product endorsement-->
    <div class="endorsement-grid">
        <div class="endorsement-header">
            <div class="endorsement-container1">
                <div class="endoresement-overlay"></div>
                <div class="endoresement-text">
                <!-- DESKTOP -->
                <h1>EYELINER</h1>
                </div>
                <div class="endorsement-wrapper swiper">
                    <ul class="endorsement-list swiper-wrapper">
                        <?php foreach ($row4Products as $row): ?>
                        <li class="endorsement-card swiper-slide">
                           
                            <a href="product-page copy.php?product_id=<?php echo $row['ProductID']; ?>" class="endorsement-link">
                                <img src="products/<?php echo htmlspecialchars($row['ProductImages']); ?>" alt="<?php echo htmlspecialchars($row['ProductName']); ?>" class="endorsement-image">
                                <p class="badge"><?php echo htmlspecialchars($row['CategoryName']); ?></p>
                                <h2 class="endorsement-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                                <h3 class="product-price">₱<?php echo number_format($row['Price'], 2); ?></h3>
                                <form method="POST" action="add_to_cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
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
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
            <!-- LAPTOPS -->
            <div class="endorsement-container2">
                <div class="endoresement-overlay"></div>
                <div class="endoresement-text">
                <h1>LIPSTICK</h1>
                </div>
                <div class="endorsement-wrapper swiper">
                    <ul class="endorsement-list swiper-wrapper">
                    <?php foreach ($row3Products as $row): ?>
                        <li class="endorsement-card swiper-slide">
                           
                            <a href="product-page copy.php?product_id=<?php echo $row['ProductID']; ?>" class="endorsement-link">
                                <img src="products/<?php echo htmlspecialchars($row['ProductImages']); ?>" alt="<?php echo htmlspecialchars($row['ProductName']); ?>" class="endorsement-image">
                                <p class="badge"><?php echo htmlspecialchars($row['CategoryName']); ?></p>
                                <h2 class="endorsement-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                                <h3 class="product-price">₱<?php echo number_format($row['Price'], 2); ?></h3>
                                <form method="POST" action="add_to_cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
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
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>

<!--Suggested Products-->
<div class="suggested-products">
    <div class="sug-pos">
        <h2 class="sug-title">Suggested Products</h2>
    </div>
    <div class="suggested-products">
        <div class="suggested-grid">
            <div class="suggested-container swiper">
                <div class="suggested-wrapper">
                    <ul class="suggested-list swiper-wrapper">
                    <?php foreach ($row1Products as $row): ?>
                        <li class="suggested-card swiper-slide">
                            <form method="POST" action="wishlist.php" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
                                <button class="add-to-wishlist2" type="submit" title="Add to Wishlist">
                                    <i class="fa-regular fa-heart fa-2xl"></i>
                                </button>
                            </form>
                            <a href="product-page copy.php?product_id=<?php echo $row['ProductID']; ?>" class="suggested-link">
                                <img src="products/<?php echo htmlspecialchars($row['ProductImages']); ?>" alt="<?php echo htmlspecialchars($row['ProductName']); ?>" class="suggested-image">
                                <p class="badge"><?php echo htmlspecialchars($row['CategoryName']); ?></p>
                                <h2 class="suggested-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                                <h3 class="suggested-price">₱<?php echo number_format($row['Price'], 2); ?></h3>
                                <form method="POST" action="add_to_cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
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
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="suggested-products">
        <div class="suggested-grid">
            <div class="suggested-container swiper">
                <div class="suggested-wrapper">
                    <ul class="suggested-list swiper-wrapper">
                    <?php foreach ($row2Products as $row): ?>
                        <li class="suggested-card swiper-slide">
                            <form method="POST" action="wishlist.php" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
                                <button class="add-to-wishlist2" type="submit" title="Add to Wishlist">
                                    <i class="fa-regular fa-heart fa-2xl"></i>
                                </button>
                            </form>
                            <a href="product-page copy.php?product_id=<?php echo $row['ProductID']; ?>" class="suggested-link">
                                <img src="products/<?php echo htmlspecialchars($row['ProductImages']); ?>" alt="<?php echo htmlspecialchars($row['ProductName']); ?>" class="suggested-image">
                                <p class="badge"><?php echo htmlspecialchars($row['CategoryName']); ?></p>
                                <h2 class="suggested-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                                <h3 class="suggested-price">₱<?php echo number_format($row['Price'], 2); ?></h3>
                                <form method="POST" action="add_to_cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
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
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
</div>

    
    
    <!--This is the page footer-->
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
<?php
// Include database configuration
include 'config.php';

// Function to fetch products for a specific category (e.g., category ID 1)
function fetchProductsByCategory($conn, $categoryId) {
    // Build the query to fetch products along with category names, filtering by CategoryID
    $sql = "
        SELECT p.ProductID, p.ProductName, p.Price, p.ProductImages, p.Category, c.CategoryName
        FROM products p
        LEFT JOIN categories c ON p.Category = c.CategoryID
        WHERE p.Category = ? 
        ORDER BY p.ProductID
    ";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    // Bind the category ID to the query
    $stmt->bind_param("i", $categoryId); // 'i' is the type for integer
    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all results as an associative array
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fetch products for category ID 1
$categoryId = 7; // Example: Category ID 1
$products = fetchProductsByCategory($conn, $categoryId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC Case</title>
    <!--Bootstrap and other resources-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="Azul.ico">
</head>
<body>
    <nav class="navbar navbar-expand-md">
        <a class="navbar-brand" href="index.php"><img src="Astrogear black cropped.png" alt="Logo" class="logo"></a>
        <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main-navigation">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping fa-2xl"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa-solid fa-heart fa-2xl"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="astrogear-login.html"><i class="fa-solid fa-user fa-2xl"></i></a>
                </li>
            </ul>
        </div>
    </nav>

  
</div>
    <!--Suggested Products-->
    <div class="category-container" style="margin-top: 7%;">
        <h2 style="color: black; text-align:center;  font-family: 'Poppins', sans-serif; font-weight:bold; margin-bottom:2%;">Categories</h2>
        <hr>
        <div class="product-container swiper">
            <div class="product-wrapper">
                <ul class="product-list swiper-wrapper">
                    <li class="product-card swiper-slide">
                        <a href="processors.php" class="product-link">
                            <img src="productImages/processors/ryzen77800x.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Processors</p>
                            <h2 class="product-title">PROCESSORS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="motherboard.php" class="product-link">
                            <img src="productImages/motherboards/gigabyteBB550m.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Motherboards</p>
                            <h2 class="product-title">MOTHERBOARDS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="gpu.php" class="product-link">
                            <img src="productImages/gpu/rx7900xtx.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Graphics Cards</p>
                            <h2 class="product-title">GRAPHICS CARDS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="memory.php" class="product-link">
                            <img src="productImages/memory/gskillRam1.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Memory</p>
                            <h2 class="product-title">MEMORY</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="ssd.php" class="product-link">
                            <img src="productImages/solidStateDrive/samsung990pro.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Solid State Drives</p>
                            <h2 class="product-title">SSD</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="psu.php" class="product-link">
                            <img src="productImages/powerSupply/seasonicPsu.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Power Supply</p>
                            <h2 class="product-title">POWER SUPPLY</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="case.php" class="product-link">
                            <img src="productImages/case/lianliCase.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Pc Case</p>
                            <h2 class="product-title">PC CASE</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="laptop.php" class="product-link">
                            <img src="productImages/laptop/rogZyphyrusG14Square.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Laptops</p>
                            <h2 class="product-title">LAPTOPS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="monitor.php" class="product-link">
                            <img src="productImages/monitor/msiMonitor.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Monitors</p>
                            <h2 class="product-title">Monitors</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="keyboard.php" class="product-link">
                            <img src="productImages/keyboard/wooting60he.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Keyboards</p>
                            <h2 class="product-title">KEYBOARDS</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="mouse.php" class="product-link">
                            <img src="productImages/mouse/lamzuAtlantis.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Mouse</p>
                            <h2 class="product-title">MOUSE</h2>
                        </a>
                    </li>

                    <li class="product-card swiper-slide">
                        <a href="headphones.php" class="product-link">
                            <img src="productImages/headset/logitechGproX.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Headphones</p>
                            <h2 class="product-title">HEADPHONES</h2>
                        </a>
                    </li>

                      <li class="product-card swiper-slide">
                        <a href="Desktop.php" class="product-link">
                            <img src="productImages/prebuilt/beast.png" alt="Ryzen 7" class="product-image">
                            <p class="badge">Desktop</p>
                            <h2 class="product-title">DESKTOPS</h2>
                        </a>
                    </li>

                </ul>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
        <hr>
           <div class="suggested-products" style="margin-top: 3%;">
            <div class="sug-pos">
                <h2 class="sug-title"><?php echo htmlspecialchars($products[0]['CategoryName']); ?></h2>
            </div>
            <div class="suggested-grid">
                <div class="suggested-container">
                    <div class="suggested-wrapper">
                        <ul class="suggested-list swiper-wrapper">
                            <?php foreach ($products as $product): ?>
                                <li class="suggested-card ">
                                    <button class="add-to-wishlist2" type="button"><i class="fa-regular fa-heart"></i></button>
                                    <a href="product-page copy.php?product_id=<?php echo $product['ProductID']; ?>" class="suggested-link">
                                        <img src="productImages/<?php echo htmlspecialchars($product['ProductImages']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>" class="suggested-image">
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
    </div>
       
    </div>
     

      <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <h6 class="text-uppercase font-weight-bold">Additional Information</h6>
                    <p>AstroGear is set to make a big impact in the e-commerce industry by offering computer hardware customers a focused, streamlined, and specialized online purchasing experience. AstroGear has the ability to revolutionize the way computer fans make online purchases because of its wide range of products and dedication to customer happiness.</p>
                    <p>AstroGear specializes in computer components, offering products such as CPUs, GPUs, motherboards, memory, SSDs, power supplies, and software. In addition to hardware, the company provides consumer electronics like laptops, mobile phones, and accessories, along with desktop furniture. AstroGear also offers specialized services including custom computer building, cleaning for residential and commercial spaces, and repair services for various devices.</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <h6 class="text-uppercase font-weight-bold">Contact</h6>
                    <p>1870 Antipolo, Maia Alta, Rizal<br /> astrogear@gmail.com
                        <br /> +63 923 567 8841<br /> +63 992 567 8834</p>
                </div>
            </div>
        </div>
        <div class="footer-copyright text-center">
            © 2024 Copyright: astrogear.com
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="main.js"></script>
</body>
</html>

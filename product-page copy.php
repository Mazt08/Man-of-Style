<?php
session_start();
include("config.php");

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to add items to the cart.'); window.location.href='azul-login.html';</script>";
    exit();
}

$user_id = $_SESSION['user_id']; // Safe to use now

// Check if the product ID is passed
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Query to get the product details
    $product_query = "SELECT * FROM products WHERE ProductID = $product_id";
    $product_result = mysqli_query($conn, $product_query);
    $product = mysqli_fetch_assoc($product_result);

    if ($product) {
        $available_stock = $product['Quantity']; // Available stock
        $productName = htmlspecialchars($product['ProductName']);
        $productImage = htmlspecialchars($product['ProductImages']);
        $productPrice = htmlspecialchars($product['Price']);
        $category = htmlspecialchars($product['Category']);
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Product ID is required.";
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="product-style.css" />
        <link rel="stylesheet" href="products.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap"
            rel="stylesheet"
        />
        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
        />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        />
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap"
        />
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Sora:wght@100..800&display=swap"
        />
        <link rel="icon" type="image/x-icon" href="Azul.ico" />
        <title>Product Page</title>
        <link rel="icon" type="image/x-icon" href="Azul.ico">
        <style>
            /* Set a specific height for carousel images */
            .carousel-item img {
                width: 100%;
                /* Make the carousel image responsive */
                height: 500px;
                /* Set a specific height */
                object-fit: cover;
                /* Ensure the image covers the area without distortion */
            }

            /* Optional: Adjust carousel size on smaller screens */
            @media (max-width: 576px) {
                .carousel-item img {
                    height: 300px;
                    /* Smaller height on mobile devices */
                }
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-md">
            <a class="navbar-brand" href="index.php"
                ><img src="azul-logo.png" alt="Logo" class="logo"
            /></a>
            <button
                class="navbar-toggler navbar-dark"
                type="button"
                data-toggle="collapse"
                data-target="#main-navigation"
            >
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

        <section class="product-page py-5">
            <div class="container">
                <div class="row">
                    <!-- Product Image Carousel Section -->
                    <div class="col-md-6">
                        <div
                            id="productCarousel"
                            class="carousel slide"
                            data-ride="carousel"
                        >
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                <img 
                                    src="products/<?php echo $productImage; ?>" 
                                    alt="<?php echo $productName; ?>" 
                                    class="d-block"
                                />
                                </div>
                                <div class="carousel-item">
                                    <img
                                        src="Azul.ico"
                                        alt="Product Image 2"
                                        class="d-block"
                                    />
                                </div>
                            </div>
                            <a
                                class="carousel-control-prev"
                                href="#productCarousel"
                                role="button"
                                data-slide="prev"
                            >
                                <span
                                    class="carousel-control-prev-icon"
                                    aria-hidden="true"
                                ></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a
                                class="carousel-control-next"
                                href="#productCarousel"
                                role="button"
                                data-slide="next"
                            >
                                <span
                                    class="carousel-control-next-icon"
                                    aria-hidden="true"
                                ></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
 


                    <!-- Form to add a product to the cart -->

                    <!-- Product Details Section -->
                    <div class="col-md-6">
                    <h2 style="font-weight: bold" id="product_name">
                        <?= $product['ProductName']; ?>
                    </h2>
                    <h2 id="category"><?= $product['Category']; ?></h2>
                    <h2 id="status"></h2>
                    <hr />
                    <h4 id="price">₱<?= number_format($product['Price'], 2); ?></h4>
                
                    <p class="product-description">
                        The
                        <span id="productHighlight"><?= $product['ProductName']; ?></span>
                        is a premium cosmetic product from Azul Cosmetics, designed to deliver smooth, long-lasting coverage.
                        It offers comfort and adds confidence, making it ideal for sensitive skin and everyday use.
                    </p>
                    <hr />
                    <p id="priceHighlight"><?= $product['Quantity'] > 0 ? 'In stock' : 'Out of stock'; ?></p>
                    
                    <!-- Form to Add to Cart -->
                    <form method="POST" action="add_to_cart.php">
                        <div class="quantity mb-3">
                            <label for="quantity" class="font-weight-bold">Quantity:</label>
                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                min="1"
                                max="<?= $available_stock; ?>"
                                value="1"
                                class="form-control w-25"
                            />
                        </div>
                        <!-- Hidden input for the product ID -->
                        <form class="product-form" action="" method="POST" id="product-form-<?php echo $product['ProductID']; ?>">
                    <!-- Hidden input to store product_id -->
                    <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>">

                    <!-- Display product details -->
                    <div class="container">
            <button type="submit" class="btn btn-lg btn-block mb-3 CART-button2">
                <span>Add to Cart</span>
            </button>
        </div>
                </form>

                <!-- AJAX Script to Handle Form Submission Without Page Reload -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        // Intercept form submission to use AJAX
                        $('.product-form').submit(function(e) {
                            e.preventDefault(); // Prevent normal form submission

                            var form = $(this);
                            var productId = form.find('input[name="product_id"]').val();

                            $.ajax({
                                url: '', // This is the same page, so leave it empty
                                type: 'POST',
                                data: form.serialize(), // Serialize form data for sending
                                success: function(response) {
                                    alert('Product added to cart!');
                                    form.find('.add-to-cart-btn').text('Added').prop('disabled', true); // Disable button after adding
                                },
                                error: function(xhr, status, error) {
                                    alert('An error occurred: ' + error); // Show error message
                                }
                            });
                        });
                    });
                </script>

                <?php
                // Handle Add to Cart Logic (Same page PHP)
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
                    $product_id = $_POST['product_id'];

                    // Query to get the product details for adding to cart
                    $product_query = "SELECT * FROM products WHERE ProductID = $product_id";
                    $product_result = mysqli_query($conn, $product_query);

                    if ($product = mysqli_fetch_assoc($product_result)) {
                        // Add the product to the cart (using session to store cart)
                        $_SESSION['cart'][] = $product; // Add the product to the session cart
                        echo "Product added to cart!"; // Response message to be handled by AJAX
                    } else {
                        echo "Product not found!";
                    }
                }
                ?>
                        <div class="container">
                            <form method="POST" action="add_to_wishlist.php" class="wishlist-form">
                                <input type="hidden" name="product_id" value="<?= $product['ProductID']; ?>">
                                <button type="submit" class="btn btn-outline-secondary btn-lg btn-block CART-button" style="background-color: #FF6262">
                                    <span>Add to Wishlist</span>
                                </button>
                            </form>

                            <script>
                            $(document).ready(function() {
                                // Intercept wishlist form submission to use AJAX
                                $('.product-form').submit(function(e) {
                                    e.preventDefault(); // Prevent normal form submission
                                    var form = $(this);
                                    
                                    $.ajax({
                                        url: 'add_to_wishlist.php', // URL for adding to wishlist
                                        type: 'POST',
                                        data: form.serialize(), // Serialize form data for sending
                                        dataType: 'json', // Expect JSON response
                                        success: function(response) {
                                            if (response.status === 'success') {
                                                alert(response.message); // Show success message
                                                window.location.href = 'wishlist.php'; // Redirect to wishlist page
                                            } else {
                                                alert(response.message); // Show error message
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            alert('An error occurred: ' + error); // Show error message
                                        }
                                    });
                                });
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </form>
        </div>



                        

                <!-- Payment Options Section -->
                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <h5
                            style="text-decoration: underline"
                            class="product-description"
                        >
                            Payment Options
                        </h5>
                        <div
                            class="paymentOptions d-flex justify-content-around"
                        >
                            <img
                                style="width: 900px; height: auto"
                                src="payment_options.png"
                                alt=""
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="additional-info py-5 bg-light">
            <div class="container">
                <h3 class="mb-4">Product Details</h3>
                <div class="specs">
                    <ul>
                        <li><strong>Certification:</strong> FDA-approved / Dermatologically tested</li>
                        <li>
                            <strong>Safety Standards</strong> Complies with global cosmetic safety regulations
                        </li>
                        <li>
                            <strong>Skin Compatibility:</strong> Suitable for all skin types (including sensitive skin)
                        </li>
                        <li>
                            <strong>Free From:</strong> Parabens, sulfates, and harmful chemicals
                        </li>
                        <li>
                            <strong>Cruelty-Free:</strong> Not tested on animals
                        </li>
                        <li>
                            <strong>Packaging:</strong> Recyclable and eco-conscious materials
                        </li>
                    </ul>
                </div>

                <p>
                Azul Cosmetics produces high-quality products that prioritize 
                safety, skin compatibility, and ethical standards. All items 
                are FDA-approved, dermatologically tested, and free from harmful 
                ingredients like parabens and sulfates—making them ideal for all 
                skin types, even sensitive skin. With up to 24 months of shelf life 
                and cruelty-free, eco-friendly packaging, Azul offers beauty solutions 
                you can trust for everyday use.
                </p>
            </div>
        </section>

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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script
            src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"
        ></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"
        ></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="main.js"></script>
    </body>
</html>

<?php
include 'db_connect.php'; // database connection ($conn)

// Backend API for fetching products
if (isset($_GET['action']) && $_GET['action'] === 'getProducts') {
   $sql = "SELECT p.product_id, p.product_name, p.price, p.old_price, p.image, 
               p.badge, p.rating, p.description, c.category_name AS category
        FROM products p
        JOIN categories c ON p.category_id = c.category_id";
    $result = $conn->query($sql);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            "id" => (int)$row["product_id"],
            "name" => $row["product_name"],
            "price" => (float)$row["price"],
            "oldPrice" => $row["old_price"] !== null ? (float)$row["old_price"] : null,
            "image" => $row["image"],
            "badge" => $row["badge"],
            "rating" => (float)$row["rating"],
            "description" => $row["description"],
            "category" => $row["category"] // now category_name from categories table
        ];
    }
    echo json_encode($products);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details | Man of Style</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="template.css">
</head>
<body>
     <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-gray-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="img/logo.png" alt="Man of Style Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Shop.html">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.html">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.html"><i class="fas fa-shopping-cart"></i> <span class="cart-count">0</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Product Section -->
    <section class="product-details my-5 pt-5">
        <div class="container">
            <div id="singleProductCard">
                <div class="row mt-5">
                    <!-- Product Images -->
                    <div class="col-lg-5 col-md-12 col-12">
                        <img id="mainProductImg" src="" class="img-fluid w-100 pb-1" alt="Product Image">
                    </div>

                    <!-- Product Info -->
                    <div class="col-lg-6 col-md-12 col-12">
                        <h6 class="breadcrumb" id="productBreadcrumb">Home / Shop</h6>
                        <h1 class="product-title py-4" id="productName">Product Name</h1>
                        <h2 class="product-price" id="productPrice">₱0.00</h2>
                        <div class="product-rating mb-3" id="productRating"></div>

                        <div class="quantity-selector mb-4">
                            <input type="number" id="productQuantity" value="1" min="1">
                            <button class="btn-add-to-cart" id="addToCartBtn">Add To Cart</button>
                        </div>

                        <h4 class="section-title">Product Details</h4>
                        <p class="product-description" id="productDescription">
                            Product description will be loaded here.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="related-products bg-gray-ultralight py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h3 class="section-title">Related Products</h3>
                <hr class="divider mx-auto">
            </div>
            <div class="row" id="relatedProductsContainer">
                <!-- Related products will be dynamically inserted here -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-darker text-light pt-5 pb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5 class="text-uppercase mb-4">Man of Style</h5>
                    <p>Curated second-hand fashion with a minimalist aesthetic and sustainable values.</p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-light me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <h5 class="text-uppercase mb-4">Join Our Mailing List</h5>
                    <p>Get exclusive offers and style tips delivered to your inbox</p>
                    <form class="d-flex">
                        <input type="email" class="form-control me-2" placeholder="Your email address">
                        <button class="btn btn-gray-dark" type="submit">Subscribe</button>
                    </form>
                </div>
                
                <div class="col-md-3 mb-4">
                    <h5 class="text-uppercase mb-4">Store Info</h5>
                    <address>
                        <p><i class="fas fa-map-marker-alt me-2"></i> 123 Ave, Manila, PH</p>
                        <p><i class="fas fa-phone me-2"></i> (123) 456-7890</p>
                        <p><i class="fas fa-envelope me-2"></i> info@manofstyle.com</p>
                        <p><i class="fas fa-clock me-2"></i> Mon-Sat: 10AM - 8PM</p>
                    </address>
                </div>
            </div>
            
            <hr class="my-4 bg-gray-medium">
            
            <div class="row align-items-center">
                <div class="col-md-6 mb-3">
                    <p class="mb-0">&copy; 2025 Man of Style. All rights reserved.</p>
                </div>
                <div class="col-md-6 mb-3 text-md-end">
                    <img src="img/payment.png" alt="Payment Methods" class="img-fluid payment-methods">
                </div>
            </div>
        </div>
    </footer>

    <!-- Notification -->
    <div class="notification" id="notification">
        Product added to cart!
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="template.js"></script>
</body>
</html>
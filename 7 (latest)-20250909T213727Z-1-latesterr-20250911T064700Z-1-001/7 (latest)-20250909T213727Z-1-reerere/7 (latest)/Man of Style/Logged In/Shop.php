<?php
include 'db_connect.php';

// ---------------- GET PRODUCTS ----------------
if (isset($_GET['action']) && $_GET['action'] === 'getProducts') {
    $sql = "SELECT p.product_id, p.product_name, p.price, p.old_price, p.image, 
                   c.category_name, p.badge, p.rating
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
            "category" => strtolower($row["category_name"]),
            "badge" => $row["badge"],
            "rating" => (float)$row["rating"]
        ];
    }
    echo json_encode($products);
    exit;
}

// ---------------- CART API ----------------

// Fetch cart items
if (isset($_GET['action']) && $_GET['action'] === 'getCart') {
    $sql = "SELECT c.cart_id, c.quantity, 
                   p.product_id, p.product_name, p.price, p.image
            FROM cart c
            JOIN products p ON c.product_id = p.product_id";
    $result = $conn->query($sql);

    $cart = [];
    while ($row = $result->fetch_assoc()) {
        $cart[] = [
            "cartId" => (int)$row["cart_id"],
            "productId" => (int)$row["product_id"],
            "name" => $row["product_name"],
            "price" => (float)$row["price"],
            "image" => $row["image"],
            "quantity" => (int)$row["quantity"]
        ];
    }
    echo json_encode($cart);
    exit;
}

// Add to cart
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_GET['action'] === 'addToCart') {
    $data = json_decode(file_get_contents("php://input"), true);
    $productId = (int)$data["productId"];
    $quantity = (int)$data["quantity"];

    // Check if product already in cart
    $check = $conn->prepare("SELECT cart_id, quantity FROM cart WHERE product_id = ?");
    $check->bind_param("i", $productId);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newQty = $row["quantity"] + $quantity;
        $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
        $update->bind_param("ii", $newQty, $row["cart_id"]);
        $update->execute();
    } else {
        $insert = $conn->prepare("INSERT INTO cart (product_id, quantity) VALUES (?, ?)");
        $insert->bind_param("ii", $productId, $quantity);
        $insert->execute();
    }

    echo json_encode(["success" => true]);
    exit;
}

// Remove from cart
if ($_SERVER["REQUEST_METHOD"] === "POST" && $_GET['action'] === 'removeFromCart') {
    $data = json_decode(file_get_contents("php://input"), true);
    $cartId = (int)$data["cartId"];

    $delete = $conn->prepare("DELETE FROM cart WHERE cart_id = ?");
    $delete->bind_param("i", $cartId);
    $delete->execute();

    echo json_encode(["success" => true]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Urban Thrift - Shop</title>
  <link rel="icon" type="image/png" href="img/logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Shop.css">
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="log index.html">
        <img src="img/logo.png" alt="Man of Style Logo" class="logo" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="hamburger-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="log index.html">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="#">Shop</a></li>
          <li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
          <li class="nav-item">
            <div class="search-container">
              <form class="search-form" id="searchForm" onsubmit="return false;">
                <input type="text" class="search-input" id="searchInput" placeholder="Search products...">
                <button type="button" class="search-button"><i class="fas fa-search"></i></button>
              </form>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.html" id="cart-link">
              <i class="fas fa-shopping-cart"></i>
              <span class="cart-count">0</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../login.html" onclick="logoutUser()">
              <img src="img/user/user.webp" alt="User" class="user-icon" />
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Filter & Products Section -->
  <section class="product-section py-5">
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
          <div class="filter-sidebar p-4">
            <h5 class="mb-4">Filter Products</h5>
            <div class="filter-group mb-4">
              <h6>Categories</h6>
              <button class="filter-btn active" data-filter="all">All Products</button>
              <button class="filter-btn" data-filter="tshirt">Tshirt</button>
              <button class="filter-btn" data-filter="jacket">Jacket</button>
              <button class="filter-btn" data-filter="pants">Pants</button>
              <button class="filter-btn" data-filter="shoes">Shoes</button>
              <button class="filter-btn" data-filter="accessories">Accessories</button>
            </div>
            <div class="filter-group mb-4">
              <h6>Sort By</h6>
              <select class="form-select" id="sortSelect">
                <option value="recommended" selected>Recommended</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="newest">Newest First</option>
                <option value="rating">Highest Rated</option>
              </select>
            </div>
            <button class="btn btn-gray w-100" id="applyFilters">Apply Filters</button>
            <button class="btn btn-outline-secondary w-100 mt-2" id="resetFilters">Reset Filters</button>
          </div>
        </div>

        <!-- Product Listing -->
        <div class="col-lg-9">
          <div class="row" id="productContainer">
          </div>
          <div class="row d-none" id="noResults">
            <div class="col-12 text-center py-5">
              <i class="fas fa-search fa-3x mb-3 text-muted"></i>
              <h3>No products found</h3>
              <p class="text-muted">Try adjusting your filters or search term</p>
              <button class="btn btn-gray mt-2" id="resetSearch">Reset all filters</button>
            </div>
          </div>
        </div>
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
        </div>
        <div class="col-md-6 mb-4">
          <h5 class="text-uppercase mb-4">Join Our Mailing List</h5>
          <form class="d-flex">
            <input type="email" class="form-control me-2" placeholder="Your email address">
            <button class="btn btn-gray-dark" type="submit">Subscribe</button>
          </form>
        </div>
        <div class="col-md-3 mb-4">
          <h5 class="text-uppercase mb-4">Store Info</h5>
          <p><i class="fas fa-phone me-2"></i> 0912 345 6789</p>
          <p><i class="fas fa-envelope me-2"></i> info@manofstyle.com</p>
          <p><i class="fas fa-clock me-2"></i> Mon-Sat: 10AM - 8PM</p>
        </div>
      </div>
      <hr class="my-4 bg-gray-medium">
      <div class="row align-items-center">
        <div class="col-md-6 mb-3">
          <p class="mb-0">&copy; 2023 Urban Thrift. All rights reserved.</p>
        </div>
        <div class="col-md-6 mb-3 text-md-end">
          <img src="img/payment.png" alt="Payment Methods" class="img-fluid payment-methods">
        </div>
      </div>
    </div>
  </footer>

  <!-- Notification -->
  <div class="notification" id="notification">Product added to cart!</div>
  <script>if (elements.resetFiltersBtn) {
  elements.resetFiltersBtn.addEventListener("click", () => {
    console.log("Reset clicked");
    resetAllFilters();
  });
}</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="ShopScript.js"></script>
</body>
</html>
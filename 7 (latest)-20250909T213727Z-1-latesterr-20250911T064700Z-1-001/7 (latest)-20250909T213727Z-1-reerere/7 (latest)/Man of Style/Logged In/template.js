let products = [];

// Fetch products from PHP
document.addEventListener("DOMContentLoaded", () => {
  fetch("Shop.php?action=getProducts")
    .then(res => res.json())
    .then(data => {
      products = data;
      loadProduct();
      updateCartCount();

      // Safe to attach Add to Cart here since elements are ready
      if (elements.addToCartBtn) {
        elements.addToCartBtn.addEventListener("click", function() {
          const productId = getProductIdFromUrl();
          addToCart(productId);
        });
      }
    })
    .catch(err => console.error(err));
});

// DOM Elements
const elements = {
    mainProductImg: document.getElementById('mainProductImg'),
    productBreadcrumb: document.getElementById('productBreadcrumb'),
    productName: document.getElementById('productName'),
    productPrice: document.getElementById('productPrice'),
    productRating: document.getElementById('productRating'),
    productQuantity: document.getElementById('productQuantity'),
    productDescription: document.getElementById('productDescription'),
    addToCartBtn: document.getElementById('addToCartBtn'),
    relatedProductsContainer: document.getElementById('relatedProductsContainer'),
    notification: document.getElementById('notification')
};

// Get product ID from URL
function getProductIdFromUrl() {
    const urlParams = new URLSearchParams(window.location.search);
    return parseInt(urlParams.get('id'));
}

// Load product data
function loadProduct() {
  const productId = getProductIdFromUrl();
  if (!productId) {
    window.location.href = "template.php";
    return;
  }

  const product = products.find(p => p.id === productId);
  if (!product) {
    window.location.href = "template.php";
    return;
  }

  // Update page title
  document.title = `${product.name} | Man of Style`;

  // Update product details
  document.title = `${product.name} | Man of Style`;

  // Update product details (no overwriting #singleProductCard!)
  elements.mainProductImg.src = product.image;
  elements.mainProductImg.alt = product.name;
  elements.productBreadcrumb.textContent = `Home / ${product.category}`;
  elements.productName.textContent = product.name;
  elements.productPrice.innerHTML = `
    <span class="price">₱${Number(product.price).toFixed(2)}</span>
    ${product.oldPrice ? `<span class="old-price">₱${Number(product.oldPrice).toFixed(2)}</span>` : ""}
  `;
  elements.productRating.innerHTML = product.rating ? renderRating(product.rating) : "";
  elements.productDescription.textContent = product.description || "No description available.";

  // ✅ Product card (same format as your forEach loop)
  const col = document.createElement("div");
  col.className = "col-xl-3 col-lg-4 col-md-6 mb-4";
  col.dataset.category = product.category || "";
  col.dataset.price = product.price || 0;

  col.innerHTML = `
    <div class="product-card">
      ${product.badge ? `<div class="product-badge">${product.badge}</div>` : ""}
      <div class="product-thumb">
        <a href="template.php?id=${product.id}">
          <img src="${product.image}" class="img-fluid" alt="${escapeHtml(product.name)}">
        </a>
      </div>
      <div class="product-details">
        <h4><a href="template.php?id=${product.id}">${escapeHtml(product.name)}</a></h4>
        <div class="product-rating">${product.rating ? renderRating(product.rating) : ""}</div>
        <div class="product-price">
          <span class="price">₱${Number(product.price).toFixed(2)}</span>
          ${product.oldPrice ? `<span class="old-price">₱${Number(product.oldPrice).toFixed(2)}</span>` : ""}
        </div>
        <div class="product-links d-flex gap-2">
          <button class="btn btn-gray add-to-cart" data-id="${product.id}">Add to Cart</button>
          <a href="template.php?id=${product.id}" class="btn btn-outline-dark btn-view">View</a>
        </div>
      </div>
    </div>`;

  // Add to Cart button
  elements.addToCartBtn.addEventListener("click", function () {
    addToCart(productId);
  });

  // Load related products
  loadRelatedProducts(product.category, product.id);
}

// Load related products
function loadRelatedProducts(category, currentProductId) {
  const relatedProducts = products
    .filter(p => p.category === category && p.id !== currentProductId)
    .slice(0, 4);

  if (relatedProducts.length === 0) {
    elements.relatedProductsContainer.innerHTML = '<p class="text-center">No related products found.</p>';
    return;
  }

  elements.relatedProductsContainer.innerHTML = '';

  relatedProducts.forEach(product => {
    const col = document.createElement('div');
    col.className = 'col-lg-3 col-md-6 mb-4';

    col.innerHTML = `
      <div class="product-card">
        ${product.badge ? `<div class="product-badge">${product.badge}</div>` : ''}
        <div class="product-thumb">
          <a href="template.php?id=${product.id}">
            <img src="${product.image}" class="img-fluid" alt="${product.name}">
          </a>
        </div>
        <div class="product-details">
          <h4><a href="template.php?id=${product.id}">${product.name}</a></h4>
          <div class="product-rating">${renderRating(product.rating)}</div>
          <div class="product-price">
            <span class="price">₱${product.price.toFixed(2)}</span>
            ${product.oldPrice ? `<span class="old-price">₱${product.oldPrice.toFixed(2)}</span>` : ""}
          </div>
          <button class="btn-add-to-cart" data-id="${product.id}">Add To Cart</button>
        </div>
      </div>
    `;

    elements.relatedProductsContainer.appendChild(col);
  });

  // Add event listeners for related product Add to Cart buttons
  document.querySelectorAll('.product-details .btn-add-to-cart').forEach(btn => {
    btn.addEventListener('click', function() {
      const productId = parseInt(this.getAttribute('data-id'));
      addToCart(productId);
    });
  });
}

// Render star rating
function renderRating(rating) {
  let stars = '';
  const fullStars = Math.floor(rating);
  const hasHalfStar = rating % 1 >= 0.5;

  for (let i = 0; i < fullStars; i++) {
    stars += '<i class="fas fa-star"></i>';
  }
  if (hasHalfStar) {
    stars += '<i class="fas fa-star-half-alt"></i>';
  }
  for (let i = fullStars + (hasHalfStar ? 1 : 0); i < 5; i++) {
    stars += '<i class="far fa-star"></i>';
  }

  return stars;
}

// Add to cart
function addToCart(productId) {
  const product = products.find(p => p.id === productId);
  if (!product) return;

  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const quantity = productId === getProductIdFromUrl()
    ? parseInt(elements.productQuantity.value)
    : 1;

  const existing = cart.find(item => item.id === product.id);
  if (existing) {
    existing.quantity += quantity;
  } else {
    cart.push({
      id: product.id,
      name: product.name,
      price: product.price,
      image: product.image,
      category: product.category,
      quantity: quantity
    });
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  showNotification(`${product.name} added to cart!`);
  updateCartCount();
}

// Show notification
function showNotification(message) {
  elements.notification.textContent = message;
  elements.notification.classList.add('show');
  setTimeout(() => {
    elements.notification.classList.remove('show');
  }, 2000);
}

// Update cart count
function updateCartCount() {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
  document.querySelectorAll(".cart-count").forEach(el => {
    el.textContent = totalItems;
  });
}
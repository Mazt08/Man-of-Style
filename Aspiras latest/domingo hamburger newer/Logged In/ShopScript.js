// ==========================
// Enhanced Product Filtering System
// ==========================

// Product Data
const products = [
  {
    id: 1,
    name: "Classic Denim Jacket",
    category: "Jacket",
    price: 200,
    oldPrice: 400,
    image: "img/jackets/1.jpg",
    rating: 4.5,
    badge: "Best Seller",
    link: "1.html",
  },
  {
    id: 2,
    name: "Urban Hoodie Jacket",
    category: "Jacket",
    price: 200,
    image: "img/jackets/2.jpg",
    rating: 5,
    link: "2.html",
  },
  {
    id: 3,
    name: "Minimalist Sweater",
    category: "Jacket",
    price: 200,
    image: "img/jackets/3.jpg",
    rating: 4,
    badge: "New",
    link: "3.html",
  },
  {
    id: 4,
    name: "Graphic Print Hoodie",
    category: "Jacket",
    price: 200,
    image: "img/jackets/4.jpg",
    rating: 5,
    link: "4.html",
  },
  {
    id: 5,
    name: "White Mixed Red jacket",
    category: "Jacket",
    price: 250,
    oldPrice: 300,
    image: "img/jackets/5.jpg",
    rating: 4.5,
    badge: "Sale",
    link: "5.html",
  },
  {
    id: 6,
    name: "Premium Sweatpants",
    category: "pants",
    price: 150,
    image: "img/pants/6.jpg",
    rating: 4.5,
    link: "6.html",
  },
  {
    id: 7,
    name: "Tailored Slim Pants",
    category: "pants",
    price: 150,
    image: "img/pants/7.jpg",
    rating: 4,
    badge: "Trending",
    link: "7.html",
  },
  {
    id: 9,
    name: "Men Joggers",
    category: "pants",
    price: 150,
    image: "img/pants/9.jpg",
    rating: 5,
    link: "8.html",
  },
  {
    id: 10,
    name: "BK Jeans",
    category: "pants",
    price: 150,
    image: "img/pants/10.jpg",
    rating: 4,
    badge: "Trending",
    link: "login.html",
  },
  {
    id: 11,
    name: "Classic Black Trouser",
    category: "pants",
    price: 150,
    image: "img/pants/8.jpg",
    rating: 5,
    link: "login.html",
  },
  {
    id: 12,
    name: "AirFlex Runner",
    category: "shoes",
    price: 400,
    image: "img/shoes/18.jpg",
    rating: 4.5,
    badge: "Trending",
    link: "login.html",
  },
  {
    id: 13,
    name: "Urban Street Kicks",
    category: "shoes",
    price: 250,
    oldPrice: 300,
    image: "img/shoes/19.jpg",
    rating: 5,
    badge: "Sale",
    link: "login.html",
  },
  {
    id: 14,
    name: "Retro High-Tops",
    category: "shoes",
    price: 100,
    image: "img/shoes/20.jpg",
    rating: 4.5,
    badge: "New",
    link: "login.html",
  },
  {
    id: 15,
    name: "Midnight Runners",
    category: "shoes",
    price: 250,
    oldPrice: 300,
    image: "img/shoes/21.jpg",
    rating: 5,
    badge: "Sale",
    link: "login.html",
  },
  {
    id: 16,
    name: "StreetFlow Sneakers",
    category: "shoes",
    price: 250,
    image: "img/shoes/22.jpg",
    rating: 4.5,
    badge: "New",
    link: "login.html",
  },
  {
    id: 17,
    name: "HypeFlex 23",
    category: "shoes",
    price: 250,
    image: "img/shoes/23.jpg",
    rating: 4.5,
    badge: "New",
    link: "login.html",
  },
  {
    id: 18,
    name: "PrimeCourt Classics",
    category: "shoes",
    price: 250,
    oldPrice: 300,
    image: "img/shoes/24.jpg",
    rating: 5,
    badge: "Sale",
    link: "login.html",
  },
  {
    id: 19,
    name: "Canvas Low Riders",
    category: "shoes",
    price: 250,
    oldPrice: 300,
    image: "img/shoes/25.jpg",
    rating: 5,
    badge: "Sale",
    link: "login.html",
  },
  {
    id: 20,
    name: "Snapback Street Cap",
    category: "Accessories",
    price: 350,
    image: "img/cap/1.jpg",
    rating: 5,
    badge: "New",
    link: "login.html",
  },
  {
    id: 21,
    name: "Classic Baseball Cap",
    category: "Accessories",
    price: 350,
    image: "img/cap/2.jpg",
    rating: 5,
    badge: "New",
    link: "login.html",
  },
  {
    id: 22,
    name: "Flat Brim Cap",
    category: "Accessories",
    price: 350,
    image: "img/cap/3.jpg",
    rating: 5,
    badge: "Trending",
    link: "login.html",
  },
  {
    id: 23,
    name: "Vintage Trucker Cap",
    category: "Accessories",
    price: 350,
    image: "img/cap/4.jpg",
    rating: 5,
    badge: "Sale",
    link: "login.html",
  },
  {
    id: 24,
    name: "Street Art Tee",
    category: "Tshirt",
    price: 150,
    image: "img/clothes/1.jpg",
    rating: 4,
    badge: "Trending",
    link: "login.html",
  },
  {
    id: 25,
    name: "Classic Black Trouser",
    category: "Tshirt",
    price: 150,
    image: "img/clothes/2.jpg",
    rating: 5,
    link: "login.html",
  },
  {
    id: 26,
    name: "Graphic Street Tee",
    category: "Tshirt",
    price: 400,
    image: "img/clothes/3.jpg",
    rating: 4.5,
    badge: "Trending",
    link: "login.html",
  },
  {
    id: 27,
    name: "Black plain Tee",
    category: "Tshirt",
    price: 250,
    oldPrice: 300,
    image: "img/clothes/4.jpg",
    rating: 5,
    badge: "Sale",
    link: "login.html",
  },
  {
    id: 28,
    name: "Casual Blue Tee",
    category: "Tshirt",
    price: 100,
    image: "img/clothes/11.jpg",
    rating: 4.5,
    badge: "New",
    link: "login.html",
  },
  {
    id: 29,
    name: "Colorful liner tee",
    category: "Tshirt",
    price: 250,
    oldPrice: 300,
    image: "img/clothes/12.jpg",
    rating: 5,
    badge: "Sale",
    link: "login.html",
  },
  {
    id: 30,
    name: "Discovery Expedition Tee",
    category: "Tshirt",
    price: 250,
    image: "img/clothes/13.jpg",
    rating: 4.5,
    badge: "New",
    link: "login.html",
  },
  {
    id: 31,
    name: "Nirvana Tee",
    category: "Tshirt",
    price: 250,
    image: "img/clothes/14.jpg",
    rating: 4.5,
    badge: "New",
    link: "login.html",
  },
  {
    id: 32,
    name: "Cotton Tee",
    category: "Tshirt",
    price: 250,
    oldPrice: 300,
    image: "img/clothes/15.jpg",
    rating: 5,
    badge: "Sale",
    link: "login.html",
  },
];

// DOM Elements
const elements = {
  productContainer: document.getElementById("productContainer"),
  filterButtons: document.querySelectorAll(".filter-btn"),
  priceRange: document.getElementById("priceRange"),
  priceRangeValue: document.getElementById("priceRangeValue"),
  searchInput: document.getElementById("searchInput"),
  searchResultsHeader: document.getElementById("searchResultsHeader"),
  searchResultsText: document.getElementById("searchResultsText"),
  clearSearchBtn: document.getElementById("clearSearchBtn"),
  sortSelect: document.getElementById("sortSelect"),
  resetFiltersBtn: document.getElementById("resetFiltersBtn"),
};

//User Icon Logout
function logoutUser() {
  alert("You have been logged out.");
}

// State Management
let state = {
  currentFilter: "all",
  currentSearchTerm: "",
  currentSort: "recommended",
  maxPrice: 500,
};

// ==========================
// Initialize Page
// ==========================
document.addEventListener("DOMContentLoaded", () => {
  initializePage();
  setupEventListeners();
  adjustSpacing();
});

function initializePage() {
  // Set initial price range value
  if (elements.priceRange && elements.priceRangeValue) {
    elements.priceRange.max = state.maxPrice;
    elements.priceRange.value = state.maxPrice;
    elements.priceRangeValue.textContent = `₱${state.maxPrice}`;
  }
  // Render all products initially
  renderProducts(products);
}

// ==========================
// Event Listeners Setup
// ==========================
function setupEventListeners() {
  // Category Filter
  elements.filterButtons.forEach((btn) => {
    btn.addEventListener("click", () => handleCategoryFilter(btn));
  });

  // Price Filter with debouncing
  if (elements.priceRange) {
    elements.priceRange.addEventListener(
      "input",
      debounce(() => {
        if (elements.priceRangeValue) {
          elements.priceRangeValue.textContent = `₱${elements.priceRange.value}`;
        }
        state.currentFilter = "all"; // Reset category filter when price changes
        applyFilters();
      }, 300)
    );
  }

  // Search with debouncing
  if (elements.searchInput) {
    elements.searchInput.addEventListener(
      "input",
      debounce(() => {
        state.currentSearchTerm = elements.searchInput.value
          .toLowerCase()
          .trim();
        applyFilters();
        updateSearchHeader();
      }, 300)
    );
  }

  // Clear Search
  if (elements.clearSearchBtn) {
    elements.clearSearchBtn.addEventListener("click", (e) => {
      e.preventDefault();
      clearSearch();
    });
  }

  // Sort Products
  if (elements.sortSelect) {
    elements.sortSelect.addEventListener("change", () => {
      state.currentSort = elements.sortSelect.value;
      applyFilters();
    });
  }

  // Reset All Filters
  if (elements.resetFiltersBtn) {
    elements.resetFiltersBtn.addEventListener("click", (e) => {
      e.preventDefault();
      resetAllFilters();
    });
  }

  // View Product
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("btn-view")) {
      e.preventDefault();
      const link = e.target.getAttribute("data-link") || e.target.href;
      window.location.href = link;
    }
  });

  // Window resize for responsive adjustments
  window.addEventListener("resize", debounce(adjustSpacing, 250));
}

// ==========================
// Filter Handlers
// ==========================
function handleCategoryFilter(btn) {
  elements.filterButtons.forEach((b) => b.classList.remove("active"));
  btn.classList.add("active");
  state.currentFilter = btn.dataset.filter.toLowerCase(); // case-insensitive
  applyFilters();
}

function clearSearch() {
  state.currentSearchTerm = "";
  if (elements.searchInput) elements.searchInput.value = "";
  applyFilters();
  if (elements.searchResultsHeader)
    elements.searchResultsHeader.style.display = "none";
}

function resetAllFilters() {
  // Reset category filter
  state.currentFilter = "all";
  elements.filterButtons.forEach((btn) => {
    if (btn.dataset.filter === "all") {
      btn.classList.add("active");
    } else {
      btn.classList.remove("active");
    }
  });

  // Reset price filter
  if (elements.priceRange) {
    elements.priceRange.value = state.maxPrice;
    if (elements.priceRangeValue) {
      elements.priceRangeValue.textContent = `₱${state.maxPrice}`;
    }
  }

  // Reset search
  clearSearch();

  // Reset sort
  if (elements.sortSelect) {
    elements.sortSelect.value = "recommended";
    state.currentSort = "recommended";
  }

  // Reapply filters to show all products
  applyFilters();
}

// ==========================
// Apply All Filters
// ==========================
function applyFilters() {
  let filtered = [...products];

  // Category Filter
  if (state.currentFilter !== "all") {
    filtered = filtered.filter(
      (p) => p.category.toLowerCase() === state.currentFilter
    );
  }

  // Price Filter
  if (elements.priceRange) {
    const maxPrice = parseInt(elements.priceRange.value);
    filtered = filtered.filter((p) => p.price <= maxPrice);
  }

  // Search Filter (case-insensitive)
  if (state.currentSearchTerm) {
    filtered = filtered.filter(
      (p) =>
        p.name.toLowerCase().includes(state.currentSearchTerm) ||
        p.category.toLowerCase().includes(state.currentSearchTerm)
    );
  }

  // Sort Products
  filtered = sortProducts(filtered, state.currentSort);

  // Render filtered products
  renderProducts(filtered);
  updateSearchHeader(filtered.length);
}

// ==========================
// Sort Products
// ==========================
function sortProducts(products, sortBy) {
  switch (sortBy) {
    case "price-low":
      return [...products].sort((a, b) => a.price - b.price);
    case "price-high":
      return [...products].sort((a, b) => b.price - a.price);
    case "newest":
      return [...products].sort((a, b) => b.id - a.id);
    case "rating":
      return [...products].sort((a, b) => b.rating - a.rating);
    case "recommended":
    default:
      return [...products]; // Default order
  }
}

// ==========================
// Render Products
// ==========================
function renderProducts(productsList) {
  if (!elements.productContainer) return;

  // Show message if no products found
  if (productsList.length === 0) {
    elements.productContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                <h4>No products found</h4>
                <p>Try adjusting your search or filters</p>
                <button class="btn btn-gray mt-3" id="resetSearch">Reset all filters</button>
            </div>`;

    // Add event listener to reset button
    const resetBtn = document.getElementById("resetSearch");
    if (resetBtn) {
      resetBtn.addEventListener("click", resetAllFilters);
    }
    return;
  }

  // Clear container
  elements.productContainer.innerHTML = "";

  // Create product cards
  productsList.forEach((product) => {
    const col = document.createElement("div");
    col.className = "col-xl-3 col-lg-4 col-md-6 mb-4";
    col.dataset.category = product.category;
    col.dataset.price = product.price;

    col.innerHTML = `
            <div class="product-card">
                ${
                  product.badge
                    ? `<div class="product-badge">${product.badge}</div>`
                    : ""
                }
                <div class="product-thumb">
                    <a href="${product.link}">
                        <img src="${product.image}" class="img-fluid" alt="${
      product.name
    }" loading="lazy">
                    </a>
                </div>
                <div class="product-details">
                    <h4><a href="${product.link}">${product.name}</a></h4>
                    <div class="product-rating">${renderRating(
                      product.rating
                    )}</div>
                    <div class="product-price">
                        <span class="price">₱${product.price.toFixed(2)}</span>
                        ${
                          product.oldPrice
                            ? `<span class="old-price">₱${product.oldPrice.toFixed(
                                2
                              )}</span>`
                            : ""
                        }
                    </div>
                    <div class="product-links d-flex gap-2">
                        <button class="btn btn-gray add-to-cart" data-id="${
                          product.id
                        }">Add to Cart</button>
                        <a href="${product.link}" data-link="${
      product.link
    }" class="btn btn-outline-dark btn-view">View</a>
                    </div>
                </div>
            </div>`;

    elements.productContainer.appendChild(col);
  });
}

// ==========================
// Helper Functions
// ==========================
function renderRating(rating) {
  let stars = "";
  const fullStars = Math.floor(rating);
  const hasHalfStar = rating % 1 >= 0.5;

  // Full stars
  for (let i = 0; i < fullStars; i++) {
    stars += '<i class="fas fa-star"></i>';
  }

  // Half star
  if (hasHalfStar) {
    stars += '<i class="fas fa-star-half-alt"></i>';
  }

  // Empty stars
  const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
  for (let i = 0; i < emptyStars; i++) {
    stars += '<i class="far fa-star"></i>';
  }

  return stars;
}

function updateSearchHeader(count = null) {
  if (!elements.searchResultsHeader || !elements.searchResultsText) return;

  if (state.currentSearchTerm === "") {
    elements.searchResultsHeader.style.display = "none";
  } else {
    const resultCount =
      count !== null ? count : elements.productContainer.children.length;
    elements.searchResultsHeader.style.display = "block";
    elements.searchResultsText.textContent = `Showing ${resultCount} results for "${state.currentSearchTerm}"`;
  }
}

// Add to cart function
function addToCart(productId) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const product = products.find((p) => p.id === productId);

  if (!product) return;

  const existing = cart.find((item) => item.id === product.id);
  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push({ ...product, quantity: 1 });
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  showNotification(`${product.name} added to cart!`);

  // Update cart count on navbar
  updateCartCount();
}

function updateCartCount() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
  document
    .querySelectorAll(".cart-count")
    .forEach((el) => (el.textContent = totalItems));
}

document.addEventListener("click", (e) => {
  if (e.target.classList.contains("add-to-cart")) {
    const productId = parseInt(e.target.dataset.id);
    addToCart(productId);
  }
  if (e.target.classList.contains("btn-view")) {
    e.preventDefault();
    const link = e.target.getAttribute("data-link");
    window.location.href = link;
  }
});

function showNotification(message) {
  // Create notification element if it doesn't exist
  let notification = document.getElementById("notification");
  if (!notification) {
    notification = document.createElement("div");
    notification.id = "notification";
    notification.className = "notification";
    document.body.appendChild(notification);
  }

  // Set message and show
  notification.textContent = message;
  notification.classList.add("show");

  // Hide after 2 seconds
  setTimeout(() => {
    notification.classList.remove("show");
  }, 2000);
}

// ==========================
// Utility Functions
// ==========================
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

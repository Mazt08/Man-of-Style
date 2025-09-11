let products = []; // filled from PHP

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
  resetFiltersBtn: document.getElementById("resetFilters")
};

let state = {
  currentFilter: "all",
  currentSearchTerm: "",
  currentSort: "recommended",
  maxPrice: 500
};

// ---------- Initialization ----------
document.addEventListener("DOMContentLoaded", () => {
  setupEventListeners();   // attach UI handlers immediately
  initializePage();        // set initial control values
  fetchProducts();         // load products from PHP and render
});

function fetchProducts() {
  fetch("Shop.php?action=getProducts")
    .then(res => {
      if (!res.ok) throw new Error("Network response was not ok");
      return res.json();
    })
    .then(data => {
      products = data || [];
      console.log("Products from PHP:", products);
      renderProducts(products);
      updateCartCount();
      updateSearchHeader(products.length);
    })
    .catch(err => console.error("Fetch error:", err));
}

function initializePage() {
  if (elements.priceRange && elements.priceRangeValue) {
    elements.priceRange.max = state.maxPrice;
    elements.priceRange.value = state.maxPrice;
    elements.priceRangeValue.textContent = `₱${state.maxPrice}`;
  }

  // ensure dropdown default matches state
  if (elements.sortSelect) {
    // Make sure HTML <option> for recommended has value="recommended"
    elements.sortSelect.value = state.currentSort;
  }
}

// ---------- Event listeners ----------
function setupEventListeners() {
  // Category buttons
  if (elements.filterButtons?.length) {
    elements.filterButtons.forEach(btn => {
      btn.addEventListener("click", () => handleCategoryFilter(btn));
    });
  }

  // Price input with debounce
  if (elements.priceRange) {
    elements.priceRange.addEventListener(
      "input",
      debounce(() => {
        if (elements.priceRangeValue) {
          elements.priceRangeValue.textContent = `₱${elements.priceRange.value}`;
        }
        // When price changes, reset category selection visually if desired:
        state.currentFilter = "all";
        applyFilters();
      }, 300)
    );
  }

  // Search input
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

  // Clear search (if you have a clear button)
  if (elements.clearSearchBtn) {
    elements.clearSearchBtn.addEventListener("click", (e) => {
      e.preventDefault();
      clearSearch();
    });
  }

  // Sort select
  if (elements.sortSelect) {
    elements.sortSelect.addEventListener("change", () => {
      state.currentSort = elements.sortSelect.value;
      applyFilters();
    });
  }

  // Reset all filters button
  if (elements.resetFiltersBtn) {
    elements.resetFiltersBtn.addEventListener("click", (e) => {
      e.preventDefault();
      resetAllFilters();
    });
  }

// Delegate add-to-cart and view clicks
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("add-to-cart")) {
      const productId = parseInt(e.target.dataset.id);
      addToCart(productId);
    } 
    if (e.target.classList.contains("btn-view")) {
    e.preventDefault();
    const link = e.target.getAttribute("href");
    window.location.href = link;
    }
  });

  // window resize adjustments
  window.addEventListener("resize", debounce(adjustSpacing, 250));
}

// ---------- Handlers (global) ----------
function handleCategoryFilter(btn) {
  elements.filterButtons.forEach(b => b.classList.remove("active"));
  btn.classList.add("active");
  state.currentFilter = normalizeCategory(btn.dataset.filter || "all"); 
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
  // Category
  state.currentFilter = "all";
  elements.filterButtons.forEach((btn) => {
    if (btn.dataset.filter === "all") {
      btn.classList.add("active");
    } else {
      btn.classList.remove("active");
    }
  });

  // Reset Price
  if (elements.priceRange) {
    elements.priceRange.value = state.maxPrice;
    if (elements.priceRangeValue) {
      elements.priceRangeValue.textContent = `₱${state.maxPrice}`;
    }
  }

  // Search
  clearSearch();

  // Sort
  if (elements.sortSelect) {
    elements.sortSelect.value = "recommended";
    state.currentSort = "recommended";
  }

  // Re-render
  applyFilters();
}

function normalizeCategory(str) {
  return (str || "").toLowerCase().replace(/[\s-]/g, "");
}

// ---------- Apply filters and render ----------
function applyFilters() {
  let filtered = [...products];

  // Category Filter
  if (state.currentFilter && state.currentFilter !== "all") {
    filtered = filtered.filter(
      p => normalizeCategory(p.category || "") === state.currentFilter
    );
  }

  // Price Filter
  if (elements.priceRange) {
    const max = parseInt(elements.priceRange.value);
    filtered = filtered.filter((p) => p.price <= max);
  }

  // Search Filter
  if (state.currentSearchTerm) {
  filtered = filtered.filter(
    (p) =>
      p.name.toLowerCase().includes(state.currentSearchTerm) ||
      p.category.toLowerCase().includes(state.currentSearchTerm)
    );
  }

  // Sort
  filtered = sortProducts(filtered, state.currentSort);

  // Render final list
  renderProducts(filtered);
  updateSearchHeader(filtered.length);
}

// ---------- Sorting ----------
function sortProducts(arr, sortBy) {
  const list = [...arr];
  switch (sortBy) {
    case "price-low":
      return list.sort((a, b) => a.price - b.price);
    case "price-high":
      return list.sort((a, b) => b.price - a.price);
    case "newest":
      return list.sort((a, b) => (b.id || 0) - (a.id || 0));
    case "rating":
      return list.sort((a, b) => (b.rating || 0) - (a.rating || 0));
    case "recommended":
    default:
      return list;
  }
}

// ---------- Render ----------
function renderProducts(productsList) {
  if (!elements.productContainer) return;

  // ✅ Clear old products before rendering
  elements.productContainer.innerHTML = "";

  if (!productsList || productsList.length === 0) {
    elements.productContainer.innerHTML = `
      <div class="col-12 text-center py-5">
        <i class="fas fa-search fa-3x mb-3 text-muted"></i>
        <h4>No products found</h4>
        <p>Try adjusting your search or filters</p>
        <button class="btn btn-gray mt-3" id="resetSearch">Reset all filters</button>
      </div>`;
    const resetBtn = document.getElementById("resetSearch");
    if (resetBtn) resetBtn.addEventListener("click", resetAllFilters);
    return;
  }

  productsList.forEach(p => {
    const col = document.createElement("div");
    col.className = "col-xl-3 col-lg-4 col-md-6 mb-4";
    col.dataset.category = p.category || "";
    col.dataset.price = p.price || 0;

    col.innerHTML = `
      <div class="product-card">
        ${p.badge ? `<div class="product-badge">${p.badge}</div>` : ""}
        <div class="product-thumb">
          <a href="template.php?id=${p.id}">
            <img src="${p.image}" class="img-fluid" alt="${escapeHtml(p.name)}">
          </a>
        </div>
        <div class="product-details">
          <h4><a href="template.php?id=${p.id}">${escapeHtml(p.name)}</a></h4>
          <div class="product-rating">${p.rating ? rating(p.rating) : ""}</div>
          <div class="product-price">
            <span class="price">₱${Number(p.price).toFixed(2)}</span>
            ${p.oldPrice ? `<span class="old-price">₱${Number(p.oldPrice).toFixed(2)}</span>` : ""}
          </div>
          <div class="product-links d-flex gap-2">
            <button class="btn btn-gray add-to-cart" data-id="${p.id}">Add to Cart</button>
            <a href="template.php?id=${p.id}" class="btn btn-outline-dark btn-view">View</a>
          </div>
        </div>
      </div>`;

    elements.productContainer.appendChild(col);
  });
}

  

// ---------- Utilities ----------
function rating(ratingVal) {
  let stars = "";
  const r = Number(ratingVal) || 0;
  const full = Math.floor(r);
  const half = r % 1 >= 0.5;
  for (let i = 0; i < full; i++) stars += '<i class="fa-solid fa-star"></i>';
  if (half) stars += '<i class="fa-solid fa-star-half-stroke"></i>';
  const empty = 5 - full - (half ? 1 : 0);
  for (let i = 0; i < empty; i++) stars += '<i class="fa-regular fa-star"></i>';
  return stars;
}

function escapeHtml(str) {
  if (!str) return "";
  return String(str)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;");
}

function updateSearchHeader(count = null) {
  if (!elements.searchResultsHeader || !elements.searchResultsText) return;
  if (!state.currentSearchTerm) {
    elements.searchResultsHeader.style.display = "none";
  } else {
    const resultCount = count !== null ? count : elements.productContainer.children.length;
    elements.searchResultsHeader.style.display = "block";
    elements.searchResultsText.textContent = `Showing ${resultCount} results for "${state.currentSearchTerm}"`;
  }
}

function addToCart(productId) {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const product = products.find(p => p.id === productId);
  if (!product) return;

  const existing = cart.find(i => i.id === productId);
  if (existing) { 
    existing.quantity += 1;
  }
  else {
    cart.push({...product, quantity: 1});
  }
  
  localStorage.setItem("cart", JSON.stringify(cart));
  showNotification(`${product.name} added to cart!`);
  updateCartCount();
}

function updateCartCount() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
  document
    .querySelectorAll(".cart-count")
    .forEach((el) => (el.textContent = totalItems));
}

function showNotification(msg) {
  const el = document.getElementById("notification");
  if (!el) return;
  el.textContent = msg;
  el.classList.add("show");
  setTimeout(() => el.classList.remove("show"), 1800);
}

function debounce(fn, wait = 200) {
  let t;
  return (...args) => {
    clearTimeout(t);
    t = setTimeout(() => fn(...args), wait);
  };
}

document.getElementById("applyFilters")?.addEventListener("click", (e) => {
  e.preventDefault();
  applyFilters();
});

function adjustSpacing() { /* your responsive adjustments (optional) */ }
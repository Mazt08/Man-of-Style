// Product Data
const products = [
    {
        id: 1,
        name: "Classic Denim Jacket",
        category: "tops",
        price: 200,
        oldPrice: 400,
        image: "img/jackets/1.jpg",
        rating: 4.5,
        badge: "Best Seller",
        link: "1.html"
    },
    {
        id: 2,
        name: "Urban Hoodie Jacket",
        category: "tops",
        price: 200,
        oldPrice: null,
        image: "img/jackets/2.jpg",
        rating: 5,
        badge: null,
        link: "2.html"
    },
    {
        id: 3,
        name: "Minimalist Sweater",
        category: "tops",
        price: 200,
        oldPrice: null,
        image: "img/jackets/3.jpg",
        rating: 4,
        badge: "New",
        link: "3.html"
    },
    {
        id: 4,
        name: "Graphic Print Hoodie",
        category: "tops",
        price: 200,
        oldPrice: null,
        image: "img/jackets/4.jpg",
        rating: 5,
        badge: null,
        link: "4.html"
    },
    {
        id: 5,
        name: "Premium Sweatpants",
        category: "pants",
        price: 150,
        oldPrice: null,
        image: "img/pants/6.jpg",
        rating: 4.5,
        badge: null,
        link: "5.html"
    },
    {
        id: 6,
        name: "Tailored Slim Pants",
        category: "pants",
        price: 150,
        oldPrice: null,
        image: "img/pants/7.jpg",
        rating: 4,
        badge: "Trending",
        link: "6.html"
    },
    {
        id: 7,
        name: "Classic Black Trouser",
        category: "pants",
        price: 150,
        oldPrice: null,
        image: "img/pants/8.jpg",
        rating: 5,
        badge: null,
        link: "7.html"
    },
    {
        id: 8,
        name: "Urban Korean Tee",
        category: "tops",
        price: 100,
        oldPrice: 150,
        image: "img/clothes/4.jpg",
        rating: 4.5,
        badge: "Sale",
        link: "8.html"
    }
];

// DOM Elements
const productContainer = document.getElementById('productContainer');
const filterButtons = document.querySelectorAll('.filter-btn');
const priceRange = document.getElementById('priceRange');
const searchForm = document.getElementById('searchForm');
const searchInput = document.getElementById('searchInput');
const searchResultsHeader = document.getElementById('searchResultsHeader');
const searchResultsText = document.getElementById('searchResultsText');
const clearSearchBtn = document.getElementById('clearSearchBtn');

let currentFilter = 'all';
let currentSearchTerm = '';

// Initialize the page
function initializePage() {
    renderProducts(products);
    setupEventListeners();
    
    // Initialize price range display
    if (priceRange) {
        priceRange.value = priceRange.max;
    }
}

// Set up event listeners
function setupEventListeners() {
    // Filter buttons
    if (filterButtons) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.dataset.filter;
                applyFilters();
            });
        });
    }

    // Price range filter
    if (priceRange) {
        priceRange.addEventListener('input', applyFilters);
    }

    // Search form
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            currentSearchTerm = searchInput.value.toLowerCase().trim();
            applyFilters();
            updateSearchResultsHeader();
        });
    }

    // Clear search
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearSearch();
        });
    }

    // Add to cart buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('add-to-cart')) {
            const productId = e.target.dataset.id;
            addToCart(productId);
        }
    });
}

// Apply all active filters
function applyFilters() {
    let filteredProducts = [...products];
    
    // Apply category filter
    if (currentFilter !== 'all') {
        filteredProducts = filteredProducts.filter(
            product => product.category === currentFilter
        );
    }
    
    // Apply price filter
    if (priceRange) {
        const maxPrice = parseInt(priceRange.value);
        filteredProducts = filteredProducts.filter(
            product => product.price <= maxPrice
        );
    }
    
    // Apply search filter
    if (currentSearchTerm) {
        filteredProducts = filteredProducts.filter(product => 
            product.name.toLowerCase().includes(currentSearchTerm) ||
            product.category.toLowerCase().includes(currentSearchTerm)
        );
    }
    
    renderProducts(filteredProducts);
}

// Update search results header
function updateSearchResultsHeader() {
    if (!searchResultsHeader || !searchResultsText) return;
    
    if (currentSearchTerm === '') {
        searchResultsHeader.style.display = 'none';
    } else {
        const filteredCount = document.querySelectorAll('#productContainer .col-lg-3').length;
        searchResultsText.textContent = `Showing ${filteredCount} results for "${currentSearchTerm}"`;
        searchResultsHeader.style.display = 'block';
    }
}

// Clear search functionality
function clearSearch() {
    if (searchInput) searchInput.value = '';
    currentSearchTerm = '';
    applyFilters();
    if (searchResultsHeader) searchResultsHeader.style.display = 'none';
}

// Render products to the page
function renderProducts(productsToRender) {
    if (!productContainer) return;
    
    productContainer.innerHTML = '';
    
    if (productsToRender.length === 0) {
        productContainer.innerHTML = `
            <div class="col-12 text-center py-5">
                <h4>No products found</h4>
                <p>Try adjusting your search or filters</p>
            </div>
        `;
        return;
    }
    
    productsToRender.forEach(product => {
        const productCard = document.createElement('div');
        productCard.className = 'col-lg-3 col-md-6 mb-4';
        productCard.dataset.category = product.category;
        
        productCard.innerHTML = `
            <div class="product-card">
                ${product.badge ? `<div class="product-badge">${product.badge}</div>` : ''}
                <div class="product-thumb">
                    <a href="${product.link}">
                        <img src="${product.image}" class="img-fluid" alt="${product.name}">
                    </a>
                </div>
                <div class="product-details">
                    <h4><a href="${product.link}">${product.name}</a></h4>
                    <div class="product-rating">
                        ${renderRating(product.rating)}
                    </div>
                    <div class="product-price">
                        <span class="price">₱${product.price.toFixed(2)}</span>
                        ${product.oldPrice ? `<span class="old-price">₱${product.oldPrice.toFixed(2)}</span>` : ''}
                    </div>
                    <div class="product-links d-flex gap-2">
                        <button class="btn btn-gray add-to-cart" data-id="${product.id}">Add to Cart</button>
                        <a href="${product.link}" class="btn btn-outline-dark">View</a>
                    </div>
                </div>
            </div>
        `;
        
        productContainer.appendChild(productCard);
    });
}

// Helper function to render star ratings
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
    
    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    for (let i = 0; i < emptyStars; i++) {
        stars += '<i class="far fa-star"></i>';
    }
    
    return stars;
}

// Example cart functionality
function addToCart(productId) {
    console.log(`Added product ${productId} to cart`);
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        cartCount.textContent = parseInt(cartCount.textContent) + 1;
    }
    showNotification(`Item added to cart`);
}

// Show notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initializePage);
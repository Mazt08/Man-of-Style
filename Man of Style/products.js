document.addEventListener('DOMContentLoaded', function() {
    // Sample product data
    const products = [
        {
            id: 1,
            name: "Classic Denim Jacket",
            price: "₱200.00",
            oldPrice: "₱400.00",
            category: "Tops",
            image: "img/jackets/1.jpg",
            badge: "Best Seller",
            rating: 4.5
        },
        {
            id: 2,
            name: "Urban Hoodie Jacket",
            price: "₱200.00",
            category: "Tops",
            image: "img/jackets/2.jpg",
            rating: 5
        },
        {
            id: 3,
            name: "Minimalist Sweater",
            price: "₱200.00",
            category: "Tops",
            image: "img/jackets/3.jpg",
            rating: 4
        },
        {
            id: 4,
            name: "Graphic Print Hoodie",
            price: "₱200.00",
            category: "Tops",
            image: "img/jackets/4.jpg",
            rating: 5
        },
        {
            id: 5,
            name: "Premium Sweatpants",
            price: "150.00",
            category: "Pants",
            image: "img/pants/6.jpg",
            rating: 4.5
        },
        {
            id: 6,
            name: "Tailored Slim Pants",
            price: "₱150.00",
            category: "Pants",
            image: "img/pants/7.jpg",
            badge: "Trending",
            rating: 4
        },
        {
            id: 7,
            name: "Classic Black Trouser",
            price: "₱150.00",
            category: "Pants",
            image: "img/pants/8.jpg",
            rating: 5
        },
        {
            id: 8,
            name: "Urban Korean Tee",
            price: "₱100.00",
            oldPrice: "₱150.00",
            category: "Tops",
            image: "img/clothes/4.jpg",
            badge: "Sale",
            rating: 4.5
        },
        // Add more products here...
    ];

    // Render products
    function renderProducts(filter = 'all') {
        const productGrid = document.querySelector('.product-grid .row');
        productGrid.innerHTML = '';
        
        products.forEach(product => {
            if (filter === 'all' || product.category === filter) {
                const productCard = document.createElement('div');
                productCard.className = 'col-lg-3 col-md-4 col-6 mb-4';
                productCard.setAttribute('data-category', product.category);
                
                productCard.innerHTML = `
                    <div class="product-card">
                        ${product.badge ? `<div class="product-badge">${product.badge}</div>` : ''}
                        <div class="product-thumb">
                            <a href="product-detail.html">
                                <img src="${product.image}" class="img-fluid" alt="${product.name}">
                            </a>
                        </div>
                        <div class="product-details">
                            <h4><a href="product-detail.html">${product.name}</a></h4>
                            <div class="product-rating">
                                ${renderRating(product.rating)}
                            </div>
                            <div class="product-price">
                                <span class="price">${product.price}</span>
                                ${product.oldPrice ? `<span class="old-price">${product.oldPrice}</span>` : ''}
                            </div>
                            <div class="product-links d-flex gap-2">
                                <button class="btn btn-gray add-to-cart" data-id="${product.id}">Add to Cart</button>
                                <a href="product-detail.html" class="btn btn-outline-dark">View</a>
                            </div>
                        </div>
                    </div>
                `;
                
                productGrid.appendChild(productCard);
            }
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
        
        const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
        for (let i = 0; i < emptyStars; i++) {
            stars += '<i class="far fa-star"></i>';
        }
        
        return stars;
    }

    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            
            // Update active state
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            button.classList.add('active');
            
            // Filter products
            renderProducts(filter);
        });
    });

    // Initial render
    renderProducts();
});
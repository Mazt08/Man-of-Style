document.addEventListener('DOMContentLoaded', function() {
    // Cart functionality
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    updateCartCount();

    // Add to cart buttons
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', addToCart);
    });

    // Category filter
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;

            // Update active state
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            filterProducts();
        });
    });

    // Price filter
    const priceRange = document.getElementById('priceRange');
    priceRange.addEventListener('input', filterProducts);

    function filterProducts() {
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
        const maxPrice = parseFloat(priceRange.value);

        document.querySelectorAll('[data-category]').forEach(product => {
            const category = product.dataset.category;
            const price = parseFloat(
                product.querySelector('.price').textContent.replace('₱', '')
            );

            const categoryMatch = (activeFilter === 'all' || category === activeFilter);
            const priceMatch = (price <= maxPrice);

            if (categoryMatch && priceMatch) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    }

    function addToCart(e) {
        const button = e.target;
        const productCard = button.closest('.product-card');
        const productId = button.getAttribute('data-id');
        const productName = productCard.querySelector('h4 a').textContent;
        const productPrice = parseFloat(productCard.querySelector('.price').textContent.replace('₱', ''));
        const productImage = productCard.querySelector('img').src;

        // Check if product already in cart
        const existingItem = cart.find(item => item.id === productId);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: 1
            });
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        showNotification('Item added to cart!');
    }

    function updateCartCount() {
        const cartCount = document.querySelector('.cart-count');
        const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
        cartCount.textContent = totalItems;
    }

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
});

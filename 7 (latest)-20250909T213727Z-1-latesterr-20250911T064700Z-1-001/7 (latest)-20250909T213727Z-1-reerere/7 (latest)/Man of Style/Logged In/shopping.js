document.addEventListener("DOMContentLoaded", () => {
    const cartCount = document.querySelector(".cart-count");
    const addToCartButtons = document.querySelectorAll(".btn-add-to-cart");

    // Load cart from localStorage or start empty
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Update cart count in navbar
    function updateCartCount() {
        let totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        cartCount.textContent = totalItems;
    }

    // Add product to cart
    function addToCart(product) {
        let existing = cart.find(item => item.name === product.name);
        if (existing) {
            existing.quantity += product.quantity;
        } else {
            cart.push(product);
        }
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCount();
    }

    // Attach event listeners
    addToCartButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const productCard = btn.closest(".product-card") || btn.closest(".col-lg-6");

            // --- handle Classic Denim Jacket (product details section) ---
            if (productCard.classList.contains("col-lg-6")) {
                const name = productCard.querySelector(".product-title").textContent;
                const priceText = productCard.querySelector(".product-price").textContent;
                const price = parseFloat(priceText.replace(/[₱,]/g, ""));
                const image = document.getElementById("MainImg").src;
                const qtyInput = productCard.querySelector("input[type='number']");
                const quantity = qtyInput ? parseInt(qtyInput.value) : 1;

                const product = { name, price, image, quantity };
                addToCart(product);
                return; // stop here so it won’t run the “related products” code
            }

            // --- handle related products ---
            const name = productCard.querySelector("h4, .product-title").textContent;
            const priceText = productCard.querySelector(".product-price").textContent;
            const price = parseFloat(priceText.replace(/[₱,]/g, ""));
            const image = productCard.querySelector("img").src;
            const qtyInput = productCard.querySelector("input[type='number']");
            const quantity = qtyInput ? parseInt(qtyInput.value) : 1;

            const product = { name, price, image, quantity };
            addToCart(product);
        });
    });

    // Initialize count on page load
    updateCartCount();
});
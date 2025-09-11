// ============================
// CART LOGIC - FIXED VERSION
// ============================

let cart = JSON.parse(localStorage.getItem("cart")) || [];
const cartTableBody = document.getElementById("cart-table-body");
const cartSubtotal = document.getElementById("cart-subtotal");
const cartTotal = document.getElementById("cart-total");
const cartShipping = document.getElementById("cart-shipping");
const shippingCost = 100;
const checkoutBtn = document.getElementById("checkout-btn");

// Save cart to localStorage
function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Update navbar cart count
function updateCartCount() {
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    document.querySelectorAll(".cart-count").forEach(el => {
        el.textContent = count;
    });
}

// Render cart table
function renderCart() {
    if (!cartTableBody) return;
    
    cartTableBody.innerHTML = "";

    if (cart.length === 0) {
        cartTableBody.innerHTML = `<tr><td colspan="6" class="text-center py-4">Your cart is empty.</td></tr>`;
        cartSubtotal.textContent = '₱0';
        cartShipping.textContent = '₱0';
        cartTotal.textContent = '₱0';
    } else {
        cart.forEach((item, index) => {
            const row = document.createElement("tr");
            row.classList.add("cart-item");

            // Create a fallback image in case the product image is missing
            const imageUrl = item.image || 'img/placeholder-product.jpg';
            const productName = item.name || 'Unknown Product';
            const productPrice = item.price || 0;

            row.innerHTML = `
                <td class="align-middle">
                    <input type="checkbox" class="select-item form-check-input" checked>
                </td>
                <td class="align-middle">
                    <div class="d-flex align-items-center">
                        <img src="${imageUrl}" alt="${productName}" class="me-3 cart-item-image">
                        <span>${productName}</span>
                    </div>
                </td>
                <td class="align-middle">₱${productPrice.toLocaleString()}</td>
                <td class="align-middle">
                    <input type="number" class="form-control qty" style="width:80px;" min="1" value="${item.quantity}">
                </td>
                <td class="align-middle subtotal">₱${(productPrice * item.quantity).toLocaleString()}</td>
                <td class="align-middle">
                    <button class="btn btn-sm btn-outline-danger remove-item">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            cartTableBody.appendChild(row);

            // Quantity change
            row.querySelector(".qty").addEventListener("change", (e) => {
                let newQty = parseInt(e.target.value);
                if (isNaN(newQty) || newQty < 1) newQty = 1;
                e.target.value = newQty;

                cart[index].quantity = newQty;
                saveCart();
                row.querySelector(".subtotal").textContent = `₱${(productPrice * newQty).toLocaleString()}`;
                updateTotals();
                updateCartCount();
            });

            // Remove item
            row.querySelector(".remove-item").addEventListener("click", () => {
                cart.splice(index, 1);
                saveCart();
                renderCart();
                updateCartCount();
            });

            // Checkbox change
            row.querySelector(".select-item").addEventListener("change", () => {
                updateTotals();
                toggleCheckoutButton();
            });
        });
    }

    updateTotals();
    toggleCheckoutButton();
}

// Update subtotal and total
function updateTotals() {
    let subtotal = 0;
    const rows = document.querySelectorAll(".cart-item");

    rows.forEach((row, index) => {
        const checkbox = row.querySelector(".select-item");
        if (checkbox && checkbox.checked) {
            const priceText = row.querySelector("td:nth-child(3)").textContent;
            const price = parseFloat(priceText.replace('₱', '').replace(/,/g, ''));
            const qty = parseInt(row.querySelector(".qty").value);
            subtotal += price * qty;
        }
    });

    cartSubtotal.textContent = `₱${subtotal.toLocaleString()}`;
    cartShipping.textContent = `₱${subtotal > 0 ? shippingCost : 0}`;
    cartTotal.textContent = `₱${(subtotal > 0 ? subtotal + shippingCost : 0).toLocaleString()}`;
}

// Enable/disable checkout button
function toggleCheckoutButton() {
    if (!checkoutBtn) return;
    
    const hasCheckedItems = document.querySelector(".select-item:checked") !== null;
    checkoutBtn.disabled = !hasCheckedItems;
}

// Proceed to checkout
function proceedToCheckout() {
    const rows = document.querySelectorAll(".cart-item");
    let selectedItems = [];

    rows.forEach((row, index) => {
        const checkbox = row.querySelector(".select-item");
        if (checkbox && checkbox.checked && index < cart.length) {
            selectedItems.push(cart[index]);
        }
    });

    if (selectedItems.length === 0) {
        alert("⚠️ Please select at least one item to checkout.");
        return;
    }

    // Check for bulk items (max 9 allowed)
    const bulkItem = selectedItems.find(item => item.quantity >= 10);
    if (bulkItem) {
        alert(`⚠️ You cannot checkout ${bulkItem.quantity}x "${bulkItem.name}". Maximum 9 items per product.`);
        return;
    }

    localStorage.setItem("checkoutCart", JSON.stringify(selectedItems));
    window.location.href = 'checkout.html';
}

// Initialize cart on page load
document.addEventListener("DOMContentLoaded", () => {
    // Make sure cart is properly formatted
    cart = cart.map(item => {
        return {
            id: item.id || 0,
            name: item.name || 'Unknown Product',
            price: item.price || 0,
            image: item.image || 'img/placeholder-product.jpg',
            quantity: item.quantity || 1,
            category: item.category || 'Unknown'
        };
    });
    
    renderCart();
    updateCartCount();

    // Bind checkout button
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", proceedToCheckout);
    }
});
let cart = JSON.parse(localStorage.getItem("cart")) || [];
const cartTableBody = document.getElementById("cart-table-body");
const cartSubtotal = document.getElementById("cart-subtotal");
const cartTotal = document.getElementById("cart-total");
const shippingCost = 100;
const checkoutBtn = document.getElementById("checkout-btn");

// Save cart back to localStorage
function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Update navbar cart count
function updateCartCount() {
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    document.querySelector(".cart-count").textContent = count;
}

// Render cart with checkboxes
function renderCart() {
    cartTableBody.innerHTML = "";

    if (cart.length === 0) {
        cartTableBody.innerHTML = `<tr><td colspan="6" class="text-center">Your cart is empty.</td></tr>`;
    } else {
        cart.forEach((item, index) => {
            const row = document.createElement("tr");
            row.classList.add("cart-item");

            row.innerHTML = `
                <td class="align-middle"><input type="checkbox" class="select-item" checked></td>
                <td class="align-middle">
                    <div class="d-flex align-items-center">
                        <img src="${item.image}" alt="${item.name}" class="me-3" style="width: 80px; height: auto;">
                        <span>${item.name}</span>
                    </div>
                </td>
                <td class="align-middle">₱${item.price.toLocaleString()}</td>
                <td class="align-middle">
                    <input type="number" value="${item.quantity}" min="1" class="form-control qty" style="width:80px;">
                </td>
                <td class="align-middle subtotal">₱${(item.price * item.quantity).toLocaleString()}</td>
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
                if (newQty < 1) newQty = 1;

                cart[index].quantity = newQty;
                saveCart();

                row.querySelector(".subtotal").textContent =
                    `₱${(cart[index].price * cart[index].quantity).toLocaleString()}`;

                updateTotals();
                updateCartCount();
            });

            // Remove item
            row.querySelector(".remove-item").addEventListener("click", () => {
                cart.splice(index, 1);
                saveCart();
                renderCart();
            });

            // Checkbox change
            row.querySelector(".select-item").addEventListener("change", () => {
                updateTotals();
                toggleCheckoutButton();
            });
        });
    }

    updateTotals();
    updateCartCount();
    toggleCheckoutButton();
}

// Compute totals only for checked items
function updateTotals() {
    let subtotal = 0;
    const rows = document.querySelectorAll(".cart-item");

    rows.forEach((row, index) => {
        const checkbox = row.querySelector(".select-item");
        if (checkbox && checkbox.checked) {
            subtotal += cart[index].price * cart[index].quantity;
        }
    });

    cartSubtotal.textContent = `₱${subtotal.toLocaleString()}`;
    cartTotal.textContent = `₱${(subtotal > 0 ? subtotal + shippingCost : 0).toLocaleString()}`;
}

// Enable/disable checkout button
function toggleCheckoutButton() {
    const anyChecked = document.querySelector(".select-item:checked");
    checkoutBtn.disabled = !anyChecked;
}

// Checkout
function proceedToCheckout() {
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    const rows = document.querySelectorAll(".cart-item");

    let selectedItems = [];
    rows.forEach((row, index) => {
        const checkbox = row.querySelector(".select-item");
        if (checkbox && checkbox.checked) {
            selectedItems.push(cart[index]);
        }
    });

    if (selectedItems.length === 0) {
        alert("⚠️ Please select at least one item to checkout.");
        return;
    }

    // Bulk rule
    const bulkItem = selectedItems.find(item => item.quantity >= 10);
    if (bulkItem) {
        alert(`⚠️ You cannot checkout ${bulkItem.quantity}x "${bulkItem.name}". 
There is a limit per item. Please contact the seller for bulk orders.`);
        return;
    }

    // Save selected items to checkoutCart
    localStorage.setItem("checkoutCart", JSON.stringify(selectedItems));

    window.location.href = 'checkout.html';
}

// Logout function
function logoutUser() {
    localStorage.removeItem('user');
    window.location.href = '../login.html';
}

// Initialize cart on page load
document.addEventListener('DOMContentLoaded', function() {
    renderCart();
});


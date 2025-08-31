// =====================
// CART SCRIPT
// =====================

let cart = JSON.parse(localStorage.getItem("cart")) || [];
const cartTableBody = document.getElementById("cart-table-body");
const cartSubtotal = document.getElementById("cart-subtotal");
const cartTotal = document.getElementById("cart-total");
const shippingCost = 100;
const checkoutBtn = document.getElementById("checkout-btn");

// ---------------------
// Save cart & update badge
// ---------------------
function saveCart() {
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
}

// ---------------------
// Update navbar cart count badge
// ---------------------
function updateCartCount() {
    const counter = document.querySelector(".cart-count");
    if (!counter) return;

    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    counter.textContent = count;
}

// ---------------------
// Add item to cart (call this on button click)
// ---------------------
function addToCart(item) {
    const existing = cart.find(i => i.id === item.id);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({ ...item, quantity: 1 });
    }
    saveCart(); // updates localStorage and badge
}

// ---------------------
// Render cart table
// ---------------------
function renderCart() {
    if (!cartTableBody) return; // only runs on cart page

    cartTableBody.innerHTML = "";

    if (cart.length === 0) {
        cartTableBody.innerHTML = `<tr><td colspan="6" class="text-center">Your cart is empty.</td></tr>`;
        toggleCheckoutButton();
        updateTotals();
        return;
    }

    cart.forEach((item, index) => {
        const row = document.createElement("tr");
        row.classList.add("cart-item");

        row.innerHTML = `
            <td class="align-middle"><input type="checkbox" class="select-item" checked></td>
            <td class="align-middle">
                <div class="d-flex align-items-center">
                    <img src="${item.image}" alt="${item.name}" class="me-3" style="width:80px; height:auto;">
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
            if (isNaN(newQty) || newQty < 1) newQty = 1;

            cart[index].quantity = newQty;
            saveCart();
            row.querySelector(".subtotal").textContent = `₱${(item.price * newQty).toLocaleString()}`;
            updateTotals();
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

    updateTotals();
    toggleCheckoutButton();
}

// ---------------------
// Update subtotal & total
// ---------------------
function updateTotals() {
    if (!cartSubtotal || !cartTotal) return;

    let subtotal = 0;
    document.querySelectorAll(".cart-item").forEach((row, index) => {
        const checkbox = row.querySelector(".select-item");
        if (checkbox && checkbox.checked) {
            subtotal += cart[index].price * cart[index].quantity;
        }
    });

    cartSubtotal.textContent = `₱${subtotal.toLocaleString()}`;
    cartTotal.textContent = `₱${(subtotal > 0 ? subtotal + shippingCost : 0).toLocaleString()}`;
}

// ---------------------
// Enable/disable checkout button
// ---------------------
function toggleCheckoutButton() {
    if (!checkoutBtn) return;
    const anyChecked = document.querySelector(".select-item:checked");
    checkoutBtn.disabled = !anyChecked;
}

// ---------------------
// Proceed to checkout
// ---------------------
function proceedToCheckout() {
    const selectedItems = [];
    document.querySelectorAll(".cart-item").forEach((row, index) => {
        const checkbox = row.querySelector(".select-item");
        if (checkbox && checkbox.checked) selectedItems.push(cart[index]);
    });

    if (selectedItems.length === 0) {
        alert("⚠️ Please select at least one item to checkout.");
        return;
    }

    const bulkItem = selectedItems.find(item => item.quantity >= 10);
    if (bulkItem) {
        alert(`⚠️ You cannot checkout ${bulkItem.quantity}x "${bulkItem.name}". Limit per item reached.`);
        return;
    }

    localStorage.setItem("checkoutCart", JSON.stringify(selectedItems));
    window.location.href = "checkout.html";
}

// ---------------------
// Logout
// ---------------------
function logoutUser() {
    localStorage.removeItem("user");
    window.location.href = '../login.html';
}

// ---------------------
// Initialize
// ---------------------
document.addEventListener("DOMContentLoaded", () => {
    renderCart();
    updateCartCount();
});

// ---------------------
// Sync cart across tabs/pages
// ---------------------
window.addEventListener("storage", (e) => {
    if (e.key === "cart") {
        cart = JSON.parse(localStorage.getItem("cart")) || [];
        renderCart();
        updateCartCount();
    }
});
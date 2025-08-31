document.addEventListener("DOMContentLoaded", () => {
    const cartTableBody = document.querySelector(".cart-table tbody");
    const cartSubtotal = document.getElementById("cart-subtotal");
    const cartTotal = document.getElementById("cart-total");
    const shippingCost = 100;

    // Load cart items from localStorage
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    function renderCart() {
        cartTableBody.innerHTML = "";

        if (cart.length === 0) {
            cartTableBody.innerHTML = `<tr><td colspan="5" class="text-center">Your cart is empty.</td></tr>`;
        } else {
            cart.forEach((item, index) => {
                const row = document.createElement("tr");
                row.classList.add("cart-item");

                row.innerHTML = `
                    <td><img src="${item.image}" alt="${item.name}" class="me-2" style="width:50px;height:50px;"> ${item.name}</td>
                    <td>₱${item.price.toLocaleString()}</td>
                    <td><input type="number" value="${item.quantity}" min="1" class="form-control qty" style="width:80px;"></td>
                    <td class="subtotal">₱${(item.price * item.quantity).toLocaleString()}</td>
                    <td><button class="btn btn-sm btn-outline-danger remove-item"><i class="fas fa-trash"></i></button></td>
                `;

                cartTableBody.appendChild(row);

                // Handle quantity change
                row.querySelector(".qty").addEventListener("change", (e) => {
                    let newQty = parseInt(e.target.value);
                    if (newQty < 1) newQty = 1;

                    cart[index].quantity = newQty;
                    saveCart();

                    // 🔹 Update row subtotal immediately
                    row.querySelector(".subtotal").textContent = 
                        `₱${(cart[index].price * cart[index].quantity).toLocaleString()}`;

                    updateTotals();
                });

                // Handle remove
                row.querySelector(".remove-item").addEventListener("click", () => {
                    cart.splice(index, 1);
                    saveCart();
                    renderCart();
                });
            });
        }

        updateTotals();
    }

    function updateTotals() {
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.price * item.quantity;
        });

        cartSubtotal.textContent = `₱${subtotal.toLocaleString()}`;
        cartTotal.textContent = `₱${(subtotal + shippingCost).toLocaleString()}`;
    }

    function saveCart() {
        localStorage.setItem("cart", JSON.stringify(cart));
    }

    renderCart();
});
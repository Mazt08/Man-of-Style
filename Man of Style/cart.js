document.addEventListener("DOMContentLoaded", () => {
    const qtyInputs = document.querySelectorAll(".qty");
    const cartSubtotal = document.getElementById("cart-subtotal");
    const cartTotal = document.getElementById("cart-total");
    const shippingCost = 100;

    function updateTotals() {
        let subtotal = 0;
        document.querySelectorAll(".cart-item").forEach(row => {
            const price = parseFloat(row.cells[1].textContent.replace(/[₱,]/g, ''));
            const qty = parseInt(row.querySelector(".qty").value);
            const itemTotal = price * qty;
            row.querySelector(".subtotal").textContent = `₱${itemTotal.toLocaleString()}`;
            subtotal += itemTotal;
        });
        cartSubtotal.textContent = `₱${subtotal.toLocaleString()}`;
        cartTotal.textContent = `₱${(subtotal + shippingCost).toLocaleString()}`;
    }

    qtyInputs.forEach(input => {
        input.addEventListener("change", updateTotals);
    });

    document.querySelectorAll(".remove-item").forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.target.closest("tr").remove();
            updateTotals();
        });
    });

    updateTotals();
});

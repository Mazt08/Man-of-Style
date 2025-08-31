document.addEventListener('DOMContentLoaded', function() {
    // Load checkout cart items from localStorage (only checked items)
    let checkoutCart = JSON.parse(localStorage.getItem("checkoutCart")) || [];
    
    // Render checkout items
    renderCheckoutItems(checkoutCart);
    
    // Initialize checkout functionality
    initCheckout(checkoutCart);
});

function renderCheckoutItems(checkoutCart) {
    const checkoutTableBody = document.querySelector('.checkout-table tbody');
    
    if (!checkoutTableBody || checkoutCart.length === 0) {
        // If no items to checkout, redirect back to cart
        window.location.href = 'cart.html';
        return;
    }
    
    // Clear existing rows
    checkoutTableBody.innerHTML = '';
    
    // Add checkout items to checkout table
    checkoutCart.forEach(item => {
        const row = document.createElement('tr');
        
        row.innerHTML = `
            <td>
                <div class="d-flex">
                    <div class="me-3">
                        <img src="${item.image}" alt="${item.name}" class="product-img" width="60">
                    </div>
                    <div>
                        <p class="mb-0 store-name">Man of Style</p>
                        <p class="mb-0 fw-bold product-title">${item.name}</p>
                        ${item.variation ? `<p class="mb-0 text-muted small product-variation">Variation: ${item.variation}</p>` : ''}
                    </div>
                </div>
            </td>
            <td class="price">₱${item.price.toLocaleString()}</td>
            <td class="quantity">${item.quantity}</td>
            <td class="price">₱${(item.price * item.quantity).toLocaleString()}</td>
        `;
        
        checkoutTableBody.appendChild(row);
    });
    
    // Update order summary with checkout cart data
    updateOrderSummaryWithCart(checkoutCart);
}

function updateOrderSummaryWithCart(checkoutCart) {
    if (checkoutCart.length === 0) {
        window.location.href = 'cart.html';
        return;
    }
    
    // Calculate totals from checkout cart (only checked items)
    let merchandiseSubtotal = 0;
    let totalItems = 0;
    
    checkoutCart.forEach(item => {
        merchandiseSubtotal += item.price * item.quantity;
        totalItems += item.quantity;
    });
    
    // Get shipping cost
    const shippingCostElement = document.getElementById('shipping-cost');
    let shippingCost = 36; // Default shipping cost
    
    if (shippingCostElement) {
        shippingCost = parseFloat(shippingCostElement.textContent.replace('₱', ''));
    }
    
    // Get discount amount
    const discountElement = document.getElementById('discount-amount');
    let discountAmount = 5; // Default discount
    
    if (discountElement) {
        const discountText = discountElement.textContent;
        discountAmount = parseFloat(discountText.replace('-₱', '')) || 0;
    }
    
    // Calculate total payment
    const totalPayment = merchandiseSubtotal + shippingCost - discountAmount;
    
    // Update DOM elements
    const itemCountElement = document.querySelector('.d-flex.justify-content-between.mb-2 span:first-child');
    if (itemCountElement) {
        itemCountElement.textContent = `Order Total (${totalItems} ${totalItems === 1 ? 'Item' : 'Items'}):`;
    }
    
    const orderTotalElement = document.querySelector('.d-flex.justify-content-between.mb-2 span:last-child');
    if (orderTotalElement) {
        orderTotalElement.textContent = `₱${totalPayment.toLocaleString()}`;
    }
    
    const merchandiseSubtotalElement = document.getElementById('merchandise-subtotal');
    if (merchandiseSubtotalElement) {
        merchandiseSubtotalElement.textContent = `₱${merchandiseSubtotal.toLocaleString()}`;
    }
    
    const totalPaymentElement = document.getElementById('total-payment');
    if (totalPaymentElement) {
        totalPaymentElement.textContent = `₱${totalPayment.toLocaleString()}`;
    }
}

function initCheckout(checkoutCart) {
    // Initialize all checkout functionality
    setupAddressChange();
    setupVoucherSelection();
    setupPaymentMethodChange();
    setupShippingOptions();
    setupPlaceOrderButton(checkoutCart);
    updateOrderSummary();
}

// Address Change Functionality
function setupAddressChange() {
    const changeAddressBtn = document.getElementById('change-address-btn');
    
    if (changeAddressBtn) {
        changeAddressBtn.addEventListener('click', function() {
            openAddressModal();
        });
    }
}

function openAddressModal() {
    // In a real application, this would fetch saved addresses from a server
    const addresses = [
        {
            id: 1,
            name: "Luis Espino",
            phone: "(+63) 9609119434",
            address: "470 Tubo Guinayang San Mateo Rizal, Guinayang, San Mateo, South Luzon, Rizal 1850",
            isDefault: true
        },
        {
            id: 2,
            name: "Luis Espino",
            phone: "(+63) 9609119434",
            address: "123 Another Address, Some City, Some Province, 1000",
            isDefault: false
        }
    ];
    
    // Create modal for address selection
    const modalHtml = `
        <div class="modal fade" id="addressModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Delivery Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="address-list">
                            ${addresses.map(address => `
                                <div class="card mb-3 address-card ${address.isDefault ? 'border-primary' : ''}">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="selectedAddress" 
                                                id="address-${address.id}" value="${address.id}" 
                                                ${address.isDefault ? 'checked' : ''}>
                                            <label class="form-check-label w-100" for="address-${address.id}">
                                                <p class="mb-1"><strong>${address.name}</strong> ${address.phone}</p>
                                                <p class="mb-0 text-muted">${address.address}</p>
                                                ${address.isDefault ? '<span class="badge bg-primary mt-2">Default</span>' : ''}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                        <button class="btn btn-outline-primary mt-3" id="add-new-address">
                            <i class="fas fa-plus me-1"></i>Add New Address
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="save-address-btn">Save Address</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const addressModal = new bootstrap.Modal(document.getElementById('addressModal'));
    addressModal.show();
    
    // Set up save address button
    document.getElementById('save-address-btn').addEventListener('click', function() {
        const selectedAddressId = document.querySelector('input[name="selectedAddress"]:checked').value;
        const selectedAddress = addresses.find(addr => addr.id == selectedAddressId);
        
        if (selectedAddress) {
            updateAddressDisplay(selectedAddress);
            addressModal.hide();
            
            // Remove modal from DOM after hiding
            setTimeout(() => {
                document.getElementById('addressModal').remove();
            }, 500);
        }
    });
    
    // Add new address button
    document.getElementById('add-new-address').addEventListener('click', function() {
        alert('In a complete implementation, this would open a form to add a new address.');
    });
}

function updateAddressDisplay(address) {
    const addressDisplay = document.querySelector('.card-body .d-flex.justify-content-between');
    addressDisplay.innerHTML = `
        <div>
            <p class="mb-1"><strong>${address.name}</strong> ${address.phone}</p>
            <p class="mb-0 text-muted">${address.address}</p>
        </div>
        ${address.isDefault ? '<span class="badge bg-primary">default</span>' : ''}
    `;
}

// Voucher Selection Functionality
function setupVoucherSelection() {
    const voucherSelect = document.getElementById('voucher-select');
    const changeVoucherLink = document.getElementById('change-voucher');
    
    if (voucherSelect) {
        voucherSelect.addEventListener('change', function() {
            applyVoucher(this.value);
        });
    }
    
    if (changeVoucherLink) {
        changeVoucherLink.addEventListener('click', function(e) {
            e.preventDefault();
            openVoucherModal();
        });
    }
}

function applyVoucher(voucherType) {
    let discount = 0;
    let discountText = '-₱0';
    
    // Calculate merchandise subtotal from checkout cart
    const merchandiseSubtotalElement = document.getElementById('merchandise-subtotal');
    const merchandiseSubtotal = parseFloat(merchandiseSubtotalElement.textContent.replace('₱', '').replace(',', '')) || 0;
    
    switch(voucherType) {
        case 'freeShipping':
            discount = 36; // Free shipping worth ₱36
            discountText = '-₱36';
            break;
        case '10percent':
            discount = merchandiseSubtotal * 0.1; // 10% of merchandise total
            discountText = `-₱${discount.toFixed(2)}`;
            break;
        default:
            discount = 5; // Default discount from HTML
            discountText = '-₱5';
    }
    
    // Update display
    document.getElementById('voucher-discount').textContent = discountText;
    document.getElementById('discount-amount').textContent = discountText;
    
    // Update order summary
    updateOrderSummary();
}

function openVoucherModal() {
    // In a real application, this would fetch available vouchers from a server
    const vouchers = [
        {
            id: 'freeShipping',
            name: 'Free Shipping Voucher',
            description: 'Get free shipping on your order',
            value: 'Free Shipping'
        },
        {
            id: '10percent',
            name: '10% Off Voucher',
            description: 'Get 10% off your entire order',
            value: '10% Off'
        },
        {
            id: '5pesos',
            name: '₱5 Off Voucher',
            description: 'Get ₱5 off your order',
            value: '₱5 Off'
        }
    ];
    
    // Create modal for voucher selection
    const modalHtml = `
        <div class="modal fade" id="voucherModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Voucher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="voucher-list">
                            ${vouchers.map(voucher => `
                                <div class="card mb-3 voucher-card">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="selectedVoucher" 
                                                id="voucher-${voucher.id}" value="${voucher.id}">
                                            <label class="form-check-label w-100" for="voucher-${voucher.id}">
                                                <h6 class="mb-1">${voucher.name}</h6>
                                                <p class="mb-0 text-muted small">${voucher.description}</p>
                                                <span class="badge bg-success mt-2">${voucher.value}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="apply-voucher-btn">Apply Voucher</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const voucherModal = new bootstrap.Modal(document.getElementById('voucherModal'));
    voucherModal.show();
    
    // Set up apply voucher button
    document.getElementById('apply-voucher-btn').addEventListener('click', function() {
        const selectedVoucher = document.querySelector('input[name="selectedVoucher"]:checked');
        
        if (selectedVoucher) {
            applyVoucher(selectedVoucher.value);
            voucherModal.hide();
            
            // Remove modal from DOM after hiding
            setTimeout(() => {
                document.getElementById('voucherModal').remove();
            }, 500);
        } else {
            alert('Please select a voucher to apply.');
        }
    });
}

// Payment Method Functionality
function setupPaymentMethodChange() {
    const changePaymentLink = document.getElementById('change-payment');
    
    if (changePaymentLink) {
        changePaymentLink.addEventListener('click', function(e) {
            e.preventDefault();
            openPaymentMethodModal();
        });
    }
}

function openPaymentMethodModal() {
    const paymentMethods = [
        {
            id: 'cod',
            name: 'Cash on Delivery',
            description: 'Pay with cash when your order is delivered'
        },
        {
            id: 'card',
            name: 'Credit/Debit Card',
            description: 'Pay securely with your credit or debit card'
        },
        {
            id: 'gcash',
            name: 'GCash',
            description: 'Pay using your GCash wallet'
        },
        {
            id: 'paypal',
            name: 'PayPal',
            description: 'Pay using your PayPal account'
        }
    ];
    
    // Create modal for payment method selection
    const modalHtml = `
        <div class="modal fade" id="paymentModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Payment Method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="payment-methods-list">
                            ${paymentMethods.map(method => `
                                <div class="card mb-3 payment-method-card">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="selectedPaymentMethod" 
                                                id="payment-${method.id}" value="${method.id}" 
                                                ${method.id === 'cod' ? 'checked' : ''}>
                                            <label class="form-check-label w-100" for="payment-${method.id}">
                                                <h6 class="mb-1">${method.name}</h6>
                                                <p class="mb-0 text-muted small">${method.description}</p>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="save-payment-method-btn">Save Payment Method</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    paymentModal.show();
    
    // Set up save payment method button
    document.getElementById('save-payment-method-btn').addEventListener('click', function() {
        const selectedPayment = document.querySelector('input[name="selectedPaymentMethod"]:checked');
        
        if (selectedPayment) {
            const selectedMethod = paymentMethods.find(method => method.id === selectedPayment.value);
            updatePaymentMethodDisplay(selectedMethod);
            paymentModal.hide();
            
            // Remove modal from DOM after hiding
            setTimeout(() => {
                document.getElementById('paymentModal').remove();
            }, 500);
        }
    });
}

function updatePaymentMethodDisplay(paymentMethod) {
    const paymentDisplay = document.querySelector('.payment-method .d-flex.justify-content-between span:first-child');
    paymentDisplay.textContent = paymentMethod.name;
}

// Shipping Options Functionality
function setupShippingOptions() {
    const shippingOptions = document.querySelectorAll('input[name="shippingOption"]');
    
    shippingOptions.forEach(option => {
        option.addEventListener('change', function() {
            updateShippingCost(this.value);
        });
    });
}

function updateShippingCost(option) {
    let cost = 36; // Default standard local shipping
    
    if (option === 'expressLocal') {
        cost = 80; // Express delivery costs more
    }
    
    // Update shipping cost display
    document.getElementById('shipping-cost').textContent = `₱${cost}`;
    document.getElementById('shipping-subtotal').textContent = `₱${cost}`;
    
    // Update order summary
    updateOrderSummary();
}

// Order Summary Calculations
function updateOrderSummary() {
    // Get values from the page
    const merchandiseSubtotal = parseFloat(document.getElementById('merchandise-subtotal').textContent.replace('₱', '').replace(',', '')) || 0;
    const shippingSubtotal = parseFloat(document.getElementById('shipping-subtotal').textContent.replace('₱', '')) || 0;
    const discountText = document.getElementById('discount-amount').textContent;
    const discountAmount = parseFloat(discountText.replace('-₱', '')) || 0;
    
    // Calculate total
    const total = merchandiseSubtotal + shippingSubtotal - discountAmount;
    
    // Update total display
    document.getElementById('total-payment').textContent = `₱${total.toLocaleString()}`;
    
    // Update order total in the summary card
    const orderTotalElement = document.querySelector('.d-flex.justify-content-between.mb-2 span:last-child');
    if (orderTotalElement) {
        orderTotalElement.textContent = `₱${total.toLocaleString()}`;
    }
}

// Place Order Functionality
function setupPlaceOrderButton(checkoutCart) {
    const placeOrderBtn = document.getElementById('place-order-btn');
    
    if (placeOrderBtn) {
        placeOrderBtn.addEventListener('click', function() {
            // Check for bulk purchase (10 or more of the same item)
            const bulkItem = checkoutCart.find(item => item.quantity >= 10);
            if (bulkItem) {
                alert(`⚠️ Warning: You cannot checkout ${bulkItem.quantity}x "${bulkItem.name}". 
    There is a limit per item. For bulk or reselling orders, please contact the seller. Thank you!`);
                return; // stop checkout immediately
            }

            // Validate form before submission
            if (validateCheckoutForm()) {
                // Show loading state
                const btn = document.getElementById('place-order-btn');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                btn.disabled = true;
                
                // Simulate order processing
                setTimeout(() => {
                    // Remove only the checked items from the main cart
                    removeCheckedItemsFromCart(checkoutCart);
                    
                    // Clear checkout cart after successful order
                    localStorage.removeItem('checkoutCart');
                    
                    // Simulate successful order placement
                    showOrderConfirmation();
                    
                    // Reset button state (though page would typically redirect)
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 2000);
            }
        });
    }
}

// Remove only the checked items from the main cart
function removeCheckedItemsFromCart(checkoutCart) {
    let mainCart = JSON.parse(localStorage.getItem("cart")) || [];
    
    // Filter out items that were in the checkout
    const updatedCart = mainCart.filter(mainItem => {
        return !checkoutCart.some(checkoutItem => 
            checkoutItem.id === mainItem.id && 
            checkoutItem.quantity === mainItem.quantity
        );
    });
    
    // Save the updated cart back to localStorage
    localStorage.setItem("cart", JSON.stringify(updatedCart));
}

// Validate checkout form
function validateCheckoutForm() {
    // Add your form validation logic here
    // For example, check if address is selected, payment method is chosen, etc.
    return true; // Return true if form is valid
}

// Show order confirmation
function showOrderConfirmation() {
    // In a real application, this would redirect to a confirmation page
    alert('Order placed successfully!');
    window.location.href = 'order-confirmation.html';
}
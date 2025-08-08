<?php
// Include database connection
include('config.php');
// Start session to track the logged-in user
session_start();
?>

<!DOCTYPE html>
<html>
<title>Cart</title>

<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=0.5" />
   <link rel="stylesheet" href="cart_final.css" />
   <link rel="stylesheet" href="style.css" />
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet" />
   <link rel="stylesheet" href="BuyNow.js">
   <link rel="preconnect" href="https://fonts.googleapis.com" />
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
   <link rel="icon" type="image/x-icon" href="Azul.ico">
</head>

<body>
   <nav class="navbar navbar-expand-md">
      <a class="navbar-brand" href="index.php"><img src="azul-logo.png" alt="Logo" class="logo" /></a>
      <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="main-navigation">
            <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                <!-- Admin is logged in -->
                <li class="nav-item">
                    <a class="nav-link" href="admin.php" title="Admin Panel">
                        <i class="fa-solid fa-database fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php" title="Cart">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wishlist.php" title="Wishlist">
                        <i class="fa-solid fa-heart fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" title="Logout">
                        <i class="fa-solid fa-sign-out-alt fa-2xl"></i>
                    </a>
                </li>
            
            <?php elseif (isset($_SESSION['user_id'])): ?>
                <!-- Regular user logged in -->
                <li class="nav-item">
                    <a class="nav-link" href="cart.php" title="Cart">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="wishlist.php" title="Wishlist">
                        <i class="fa-solid fa-heart fa-2xl"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" title="Logout">
                        <i class="fa-solid fa-sign-out-alt fa-2xl"></i>
                    </a>
                </li>
            
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php" title="Cart">
                        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="wishlist.php" title="Wishlist">
                        <i class="fa-solid fa-heart fa-2xl"></i>
                    </a>
                </li>
                <!-- Not logged in -->
                <li class="nav-item">
                    <a class="nav-link" href="azul-login.html" title="Login">
                        <i class="fa-solid fa-user fa-2xl"></i>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
   </nav>

   <div>
      <div class="maincart-container">
         <h3 style="font-family: 'Poppins', sans-serif; text-align: center; margin: 10px 0px 0px 0px;">
            YOUR CART
         </h3>
         <hr />
         <div class="cart-items">
         
      <?php
      $totalAmount = 0;
      if (isset($_SESSION['user_id'])) {
          $userId = $_SESSION['user_id'];

          // Query to get the cart items for the logged-in user, including ProductImages
          $query = "SELECT c.CartID, p.ProductName, p.Price, c.Quantity, (p.Price * c.Quantity) AS Total, p.ProductID, s.subcategory, p.Quantity AS Stock, p.ProductImages
                    FROM cart c
                    JOIN products p ON c.ProductID = p.ProductID
                    JOIN subcategories s ON p.Subcategory = s.subcategoryID 
                    WHERE c.UserID = ?";

          // Prepare the statement
          if ($stmt = $conn->prepare($query)) {
              // Bind the UserID parameter to the prepared statement
              $stmt->bind_param("i", $userId);

              // Execute the query
              $stmt->execute();

              // Get the result
              $result = $stmt->get_result();

              // Check if there are any items in the cart
              if ($result->num_rows > 0) {
                  // Loop through and display each cart item
                  while ($row = $result->fetch_assoc()) {
                      echo "<div class='cartproduct-container' style='width:90%;'>
                          <div class='cartproduct-img'>
                              <!-- Displaying product image dynamically -->
                              <img src='products/{$row['ProductImages']}' alt='" . htmlspecialchars($row['ProductName']) . "' />
                          </div>

                          <div class='cartproduct-details'>
                              <h3 id='productName'>" . htmlspecialchars($row['ProductName']) . "</h3>
                              <p id='Subcategory'>" . htmlspecialchars($row['subcategory']) . "</p>
                          </div>

                          <div class='order-details'>
                              <div class='cartproduct-price'>
                                  <h4 id='priceLabel'>Price</h4>
                                  <p id='productInitialPrice'>₱" . number_format($row['Price'], 2) . "</p>
                              </div>

                              <div class='quantity'>
                                  <p id='priceLabel' style='margin: 0%'>Quantity</p>
                                <input type='number' class='quantity-input'
                                    data-price='" . htmlspecialchars($row['Price']) . "' 
                                    value='" . htmlspecialchars($row['Quantity']) . "' min='1' 
                                    max='" . htmlspecialchars($row['Stock']) . "' />
                              </div>

                              <div class='cartproduct-price'>
                                  <h4 id='priceLabel'>TOTAL</h4>
                                  <p style='margin: 0%' class='total-price'>₱" . number_format($row['Total'], 2) . "</p>
                              </div>

                              <div class='checkout-check'>
                                
                              </div>

                              <div class='remove'>
                                  <button id='remove-product' data-cart-id='" . htmlspecialchars($row['CartID']) . "'>Remove</button>
                              </div>
                          </div>
                      </div>";
                  }

              } else {
                  // If the cart is empty
                  echo "<p>Your cart is empty.</p>";
              }

              // Close the statement
              $stmt->close();
          } else {
              echo "Error preparing the query.";
          }

      } else {
        echo '<script>
            alert("You are not currently logged in.");
            window.location.href = "azul-login.html";
        </script>';
        exit();
      }

      // Close the database connection
      $conn->close();
      ?>

            <div class="checkout"></div>

            <div class="sticky-container">
                <div class="cartproduct-container2" style="background-color: transparent; box-shadow: none;">
                    <div class="cartproduct-img2">
                        
                        <input id="PromoCode" type="text" placeholder="Code for Discount" 
                        style="
                          border: 2px solid #ff910093;
                          color : orange;
    border-radius: 7px;
    height: 50px;
    width: 160px;
                        
                        "
                        
                        
                        />
                         <input id="Payment" type="number" placeholder="Enter Payment"  
                         style="
                          border: 2px solid #5372F0;
                          color : #5372F0;
    border-radius: 7px;
    height: 50px;
    width: 160px;
    margin-left:10px;
                        
                        "/>

                        
                    </div>
                    

                        
                       

                    <div class="PaymentBox">
                       
                       
                          <button id="checkoutButton">Checkout</button>
                           
                    </div>
                    <div class="order-details">
                        
                        <div class="cartproduct-price">
                            <h4 id="priceLabel">Total Items</h4>
                            <p>The total items are: <span id="totalItemsDisplay">0</span></p>
                        </div>

                        <div class="cartproduct-price">
                            <h4 id="priceLabel">Total Amount</h4>
                            <p style="margin: 0%" id="totalAmountDisplay">₱0.00</p>
                        </div>

                        <div class="cartproduct-price">
                            <h4 id="priceLabel">Discount</h4>
                            <p>The discount is: <span id="discountDisplay">₱0.00</span></p>
                        </div>

                        <div class="cartproduct-price">
                            <h4 id="priceLabel" style="font-weight: bolder; color: #1f299c;">Final Amount</h4>
                            <p style="margin: 0%" id="finalAmountDisplay">₱0.00</p>
                        </div>

                        <div class="remove">
                            <button id="remove-all-products">Remove All</button>
                        </div>
                    </div>
                </div>
            </div>
         </div>
      </div>
   </div>
</body>

</html>

<script>
   document.addEventListener('DOMContentLoaded', function () {
    // Listen for changes on the quantity input
    document.querySelectorAll('.quantity-input').forEach(function (input) {
        input.addEventListener('input', function () {
            var price = parseFloat(input.getAttribute('data-price'));
            var quantity = parseInt(input.value) || 1;
            var maxStock = parseInt(input.getAttribute('max')); // Get the max stock from the input attribute

            // If quantity exceeds max stock, set it back to max
            if (quantity > maxStock) {
                input.value = maxStock;
                quantity = maxStock; // Set to max stock
            }

            // Update the total price for this product
            var total = price * quantity;
            input.closest('.order-details').querySelector('.total-price').innerText = '₱' + total.toFixed(2);

            // Recalculate the total items and total amount
            updateCartSummary();
        });
    });

    // The rest of your code remains unchanged...


    let discount = 0; // Placeholder for discount calculation
    const promoCode = document.getElementById('PromoCode');
    promoCode.addEventListener('input', function () {
        // Check for different discount codes
        switch (promoCode.value) {
            case 'LESS100':
                discount = 100; // ₱100 discount for LESS100
                break;
            case 'MORON5':
                discount = 1000; // ₱1000discount for MORON5
                break;
            case 'SIRRYANPOGI':
                discount = 50000; // POGI MO SIR PLS 100 PPO KAMI UWIIIII ~~BUENA
                break;
            default:
                discount = 0; // No discount for any other code
        }

        // Recalculate the cart summary including the discount
        updateCartSummary();
    });

    // Function to update the total items and total amount
    function updateCartSummary() {
        var totalItems = 0;
        var totalAmount = 0;
        document.querySelectorAll('.quantity-input').forEach(function (input) {
            var quantity = parseInt(input.value) || 1;
            totalItems += quantity;
            var price = parseFloat(input.getAttribute('data-price'));
            totalAmount += price * quantity;
        });

        // Update the summary
        document.getElementById('totalItemsDisplay').innerText = totalItems;
        document.getElementById('totalAmountDisplay').innerText = '₱' + totalAmount.toFixed(2);

        // Update the final amount including the discount
        updateFinalAmount(totalAmount);
    }

    // Function to update the final amount after discount
    function updateFinalAmount(totalAmount = 0) {
        // Ensure that the final amount doesn't go negative
        const finalAmount = totalAmount - discount > 0 ? totalAmount - discount : 0;

        // Update the discount display and final amount
        document.getElementById('discountDisplay').innerText = '₱' + discount.toFixed(2); // Display discount
        document.getElementById('finalAmountDisplay').innerText = '₱' + finalAmount.toFixed(2); // Display final amount
    }

    // Initialize the cart summary on page load
    updateCartSummary();

});


</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle removing a single product
    document.querySelectorAll('#remove-product').forEach(function (button) {
        button.addEventListener('click', function () {
            const cartId = button.getAttribute('data-cart-id');

            // Confirm before deletion
            if (confirm('Are you sure you want to remove this item?')) {
                fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ cartId: cartId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the product element from the DOM
                        button.closest('.cartproduct-container').remove();
                        // Update the cart summary
                        updateCartSummary();
                        alert('Product removed successfully!');
                    } else {
                        alert('Failed to remove product.');
                    }
                })
              
            }
        });
    });
    const removeAllButton = document.getElementById('remove-all-products');
    removeAllButton.addEventListener('click', function () {
        // Confirm before removing all items
        if (confirm('Are you sure you want to remove all items from the cart?')) {
            fetch('remove_all_from_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove all product elements from the DOM
                    document.querySelectorAll('.cartproduct-container').forEach(function (product) {
                        product.remove();
                    });
                    // Update the cart summary
                    updateCartSummary();
                    alert('All items removed successfully!');
                } else {
                    alert('Failed to remove all items.');
                }
            });
        }
    });
});
</script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
    // Listen for changes on the quantity input fields
    document.querySelectorAll('.quantity-input').forEach(function (input) {
        input.addEventListener('input', function () {
            const cartId = input.closest('.order-details').querySelector('#remove-product').getAttribute('data-cart-id');
            const newQuantity = parseInt(input.value) || 1;

            // Make sure quantity is within valid range
            const maxStock = parseInt(input.getAttribute('max'));
            if (newQuantity > maxStock) {
                input.value = maxStock;
            }

            // Update the total price for this product
            const price = parseFloat(input.getAttribute('data-price'));
            const total = price * newQuantity;
            input.closest('.order-details').querySelector('.total-price').innerText = '₱' + total.toFixed(2);

            // Send the updated quantity to the server
            fetch('update_cart_quantity.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ cartId: cartId, quantity: newQuantity }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Optionally update cart summary here
                        updateCartSummary();
                        console.log(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error updating quantity:', error);
                });
        });
    });

    // Existing functions like updateCartSummary can remain unchanged...
});

    </script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const promoCodeInput = document.getElementById('PromoCode');
    const applyDiscountButton = document.getElementById('checkoutButton');

    applyDiscountButton.addEventListener('click', function () {
        const discountCode = promoCodeInput.value;

        // Send the discount code to the server
        fetch('apply_discount.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ discountCode: discountCode }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message);
                    // Refresh the cart to show updated prices
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch((error) => {
                console.error('Error applying discount:', error);
            });
    });
});


 </script>

 <script>
    document.addEventListener('DOMContentLoaded', function () {
    const paymentInput = document.getElementById('Payment');
    const checkoutButton = document.getElementById('checkoutButton');
    const finalAmountDisplay = document.getElementById('finalAmountDisplay');

    checkoutButton.addEventListener('click', function () {
        const payment = parseFloat(paymentInput.value);
        const finalAmount = parseFloat(finalAmountDisplay.innerText.replace('₱', '').replace(',', ''));

        if (isNaN(payment) || payment < finalAmount) {
            alert('Insufficient payment. Please enter a valid amount.');
            return;
        }

        const change = payment - finalAmount;
        alert(Transaction successful! Change: ₱${change.toFixed(2)});

        // Send a request to the server to process the checkout
        fetch('checkout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ payment: payment }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert('Checkout successful! Items have been removed from your cart.');
                    // Reload the page or redirect
                    location.reload();
                } else {
                    alert('Failed to process checkout: ' + data.message);
                }
            })
            .catch((error) => {
                console.error('Error during checkout:', error);
            });
    });
});

</script>
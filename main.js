$(document).ready(function () {
    $('.header').height($(window).height());
})

// $(document).ready(function(){
//     $('.endorsement-container1, .endorsement-container2').height($('.endorsement-header').height());
// })


new Swiper('.product-wrapper', {
    slidesPerView: 1, // Show 1 product at a time
    slidesPerGroup: 1, // Move only 1 product per button click
    spaceBetween: 10, // Adjust space between slides
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 1,
        },
        1024: {
            slidesPerView: 2,
        },
    },
});

new Swiper('.endorsement-wrapper', {
    slidesPerView: 1, // Show 1 product at a time
    slidesPerGroup: 1, // Move only 1 product per button click
    spaceBetween: 10, // Adjust space between slides
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 1,
        },
        1024: {
            slidesPerView: 2,
        },
    },
});

new Swiper('.suggested-wrapper', {
    slidesPerView: 1, // Show 1 product at a time
    slidesPerGroup: 1, // Move only 1 product per button click
    spaceBetween: 10, // Adjust space between slides
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 1,
        },
        1024: {
            slidesPerView: 2,
        },
    },
});

new Swiper('.endorsement-wrapper', {
    slidesPerView: 1, // Show 1 product at a time
    slidesPerGroup: 1, // Move only 1 product per button click
    spaceBetween: 10, // Adjust space between slides
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 1,
        },
        1024: {
            slidesPerView: 2,
        },
    },
});

new Swiper('.suggested-wrapper', {
    slidesPerView: 1, // Show 1 product at a time
    slidesPerGroup: 1, // Move only 1 product per button click
    spaceBetween: 10, // Adjust space between slides
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 1,
        },
        1024: {
            slidesPerView: 2,
        },
    },
}); new Swiper('.endorsement-wrapper', {
    slidesPerView: 1, // Show 1 product at a time
    slidesPerGroup: 1, // Move only 1 product per button click
    spaceBetween: 10, // Adjust space between slides
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 1,
        },
        1024: {
            slidesPerView: 2,
        },
    },
});

new Swiper('.suggested-wrapper', {
    slidesPerView: 1, // Show 1 product at a time
    slidesPerGroup: 1, // Move only 1 product per button click
    spaceBetween: 10, // Adjust space between slides
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    breakpoints: {
        0: {
            slidesPerView: 1,
        },
        768: {
            slidesPerView: 1,
        },
        1024: {
            slidesPerView: 2,
        },
    },
});

// Log current slidesPerView
console.log('Current slidesPerView:', swiper.params.slidesPerView);

// Wishlist 
const wishlistButtons = document.querySelectorAll('.add-to-wishlist2');

wishlistButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default link behavior
        event.stopPropagation(); // Prevent event from bubbling to parent elements
        button.classList.toggle('active'); // Toggle active class
    });
});

// Document ready function
document.addEventListener('DOMContentLoaded', function () {
    // Select all wishlist buttons
    const wishlistButtons = document.querySelectorAll('.add-to-wishlist2');

    // Add click event listener to each button
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default link behavior
            
            // Toggle the active class on the button
            this.classList.toggle('active');

            // Get the icon element within the clicked button
            const icon = this.querySelector('i');

            // Toggle between fa-regular and fa-solid classes based on active state
            if (this.classList.contains('active')) {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            } else {
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
            }
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const cartButtons = document.querySelectorAll(".add-to-cart-btn");

    cartButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default action
            
            const productId = this.getAttribute("data-id"); // Get the product ID from the button
            const quantity = 1; // Default quantity for simplicity

            // Use URLSearchParams to format the request body correctly
            const formData = new URLSearchParams();
            formData.append("product_id", productId);
            formData.append("quantity", quantity);

            // Send data using Fetch API
            fetch("add_to_cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: formData.toString(), // Data to send
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Log server response for debugging
                alert("Product successfully added to your cart!");
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Failed to add product to cart. Please try again.");
            });
        });
    });
});







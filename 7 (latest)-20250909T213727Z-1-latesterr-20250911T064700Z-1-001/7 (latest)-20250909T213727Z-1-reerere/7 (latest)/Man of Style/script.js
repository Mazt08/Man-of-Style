// ================================
// HERO SECTION ANIMATIONS
// ================================
document.addEventListener('DOMContentLoaded', () => {
    const heroContent = document.querySelector('.hero-content');
    heroContent.style.opacity = 0;
    heroContent.style.transform = 'translateY(50px)';

    setTimeout(() => {
        heroContent.style.transition = 'all 1s ease-out';
        heroContent.style.opacity = 1;
        heroContent.style.transform = 'translateY(0)';
    }, 500);

    // Hero button glow effect
    const heroBtn = document.querySelector('.hero-content .btn-primary');
    heroBtn.addEventListener('mouseenter', () => {
        heroBtn.style.boxShadow = '0 0 20px rgba(255,255,255,0.6)';
    });
    heroBtn.addEventListener('mouseleave', () => {
        heroBtn.style.boxShadow = 'none';
    });
});

// ================================
// HERO PARALLAX BACKGROUND
// ================================
const heroOverlay = document.querySelector('.hero-overlay');
window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    heroOverlay.style.backgroundPositionY = `${scrollY * 0.5}px`;
});

// ================================
// SMOOTH SCROLL FOR NAVBAR LINKS
// ================================
document.querySelectorAll('a.nav-link[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(link.getAttribute('href'));
        if (target) {
            window.scrollTo({
                top: target.offsetTop - 70,
                behavior: 'smooth'
            });
        }
    });
});

// ================================
// SCROLL-TRIGGERED FADE-IN FOR SECTIONS
// ================================
const sections = document.querySelectorAll('section');

function fadeInOnScroll() {
    const triggerBottom = window.innerHeight * 0.85;
    sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;
        if (sectionTop < triggerBottom) {
            section.style.opacity = 1;
            section.style.transform = 'translateY(0)';
            section.style.transition = 'all 1s ease-out';
        }
    });
}

// Initial setup
sections.forEach(section => {
    section.style.opacity = 0;
    section.style.transform = 'translateY(50px)';
});

window.addEventListener('scroll', fadeInOnScroll);
fadeInOnScroll();

// ================================
// PRODUCT CARD HOVER EFFECT
// ================================
document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-10px)';
        card.style.boxShadow = '0 10px 20px rgba(0,0,0,0.2)';
        card.style.transition = 'all 0.3s ease';
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)';
        card.style.boxShadow = '0 0 0 rgba(0,0,0,0)';
    });
});

// Select all "Add to Cart" buttons
const addToCartButtons = document.querySelectorAll('.add-to-cart');

// Add click event to each button
addToCartButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault(); // prevent default action
        alert("Please log in before adding to cart");
        // Optionally, redirect to login page
        window.location.href = "login.html";
    });
});

        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('inputPassword');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
 function openCart(event) {
    event.preventDefault(); // stop default link

    if (localStorage.getItem("isLoggedIn") === "true") {
      // ✅ user is logged in → go to cart page
      window.location.href = "cart.html"; // change to your cart page
    } else {
      // ❌ not logged in → show warning then redirect
      alert("⚠️ Please log in first before accessing the cart.");
      window.location.href = "login.html"; // redirect to login page
    }
  }
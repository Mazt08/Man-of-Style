// ================================
// SCROLL-TRIGGERED FADE-IN
// ================================
const animateItems = document.querySelectorAll('.animate-on-scroll');

function fadeInOnScroll() {
    const triggerBottom = window.innerHeight * 0.85;

    animateItems.forEach(item => {
        const itemTop = item.getBoundingClientRect().top;
        if (itemTop < triggerBottom) {
            item.style.opacity = 1;
            item.style.transform = 'translateY(0)';
            item.style.transition = 'all 0.8s ease-out';
        }
    });
}

// Initial setup
animateItems.forEach(item => {
    item.style.opacity = 0;
    item.style.transform = 'translateY(30px)';
});

window.addEventListener('scroll', fadeInOnScroll);
fadeInOnScroll();

// ================================
// CONTACT OPTION HOVER EFFECT
// ================================
document.querySelectorAll('.contact-option').forEach(option => {
    option.addEventListener('mouseenter', () => {
        option.style.transform = 'translateY(-5px)';
        option.style.boxShadow = '0 8px 20px rgba(0,0,0,0.15)';
        option.style.transition = 'all 0.3s ease';
    });
    option.addEventListener('mouseleave', () => {
        option.style.transform = 'translateY(0)';
        option.style.boxShadow = '0 0 0 rgba(0,0,0,0)';
    });
});

// ================================
// BUTTON HOVER GLOW EFFECT
// ================================
document.querySelectorAll('.contact-option .btn').forEach(button => {
    button.addEventListener('mouseenter', () => {
        button.style.boxShadow = '0 0 15px rgba(0,0,0,0.3)';
    });
    button.addEventListener('mouseleave', () => {
        button.style.boxShadow = 'none';
    });
});

// ================================
// SMOOTH SCROLL FOR NAVBAR LINKS (if any anchors)
// ================================
document.querySelectorAll('a.nav-link[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(link.getAttribute('href'));
        if (target) {
            window.scrollTo({
                top: target.offsetTop - 70, // adjust for fixed navbar
                behavior: 'smooth'
            });
        }
    });
});

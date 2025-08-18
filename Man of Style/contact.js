
document.addEventListener('DOMContentLoaded', function() {
  // Animation on scroll
  const animateElements = document.querySelectorAll('.animate-on-scroll');
  
  const animateOnScroll = () => {
    animateElements.forEach(element => {
      const elementPosition = element.getBoundingClientRect().top;
      const windowHeight = window.innerHeight;
      
      if (elementPosition < windowHeight - 100) {
        element.classList.add('visible');
      }
    });
  };
  
  // Run once on load
  animateOnScroll();
  
  // Run on scroll
  window.addEventListener('scroll', animateOnScroll);
});
    
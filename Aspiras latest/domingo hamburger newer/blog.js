    // Scroll animation functionality
    document.addEventListener('DOMContentLoaded', function () {
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

      // Run on load and scroll
      animateOnScroll();
      window.addEventListener('scroll', animateOnScroll);
    });
new Swiper('.product-wrapper', {
    slidesPerView: 1, // Number of slides visible at a time
    slidesPerGroup: 1, // Moves one slide per click
    spaceBetween: 20, // Space between slides
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
            slidesPerView: 2, // Shows 2 slides at a time for larger screens
        },
    },
});

  
  // Log current slidesPerView
  console.log('Current slidesPerView:', swiper.params.slidesPerView);
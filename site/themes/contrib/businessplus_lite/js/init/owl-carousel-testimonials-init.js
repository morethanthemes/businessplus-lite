(function ($, Drupal, drupalSettings, once) {
  Drupal.behaviors.mtowlCarouselTestimonials = {
    attach: function (context, settings) {
      once('mtowlCarouselTestimonialsInit', ".mt-carousel-testimonials", context).forEach(function(item) {
        $(item).owlCarousel({
          items: 1,
          responsive:{
            0:{
              items:1,
            },
            480:{
              items:1,
            },
            768:{
              items:2,
            },
            992:{
              items:2,
            },
            1200:{
              items:3,
            },
            1680:{
              items:4,
            }
          },
          autoplay: true,
          autoplayTimeout: 5000,
          nav: true,
          dots: false,
          loop: true,
          navText: false
        });
      });
    }
  };
})(jQuery, Drupal, drupalSettings, once);

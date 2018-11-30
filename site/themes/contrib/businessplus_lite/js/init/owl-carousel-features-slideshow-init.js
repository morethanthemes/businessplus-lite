(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.mtowlCarouselFeaturesSlideshow = {
    attach: function (context, settings) {
      $(context).find('.mt-features-slideshow').once('mtowlCarouselFeaturesSlideshowInit').each(function() {
        $(this).owlCarousel({
          items: 1,
          responsive:{
            0:{
              items:1,
            },
            480:{
              items:1,
            },
            768:{
              items:1,
            },
            992:{
              items:1,
            },
            1200:{
              items:1,
            },
            1680:{
              items:1,
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
})(jQuery, Drupal, drupalSettings);

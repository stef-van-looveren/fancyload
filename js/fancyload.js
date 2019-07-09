/**
 * @file
 * Provides lazy load behaviours.
 */

(function ($, Drupal) {

  'use strict';
  Drupal.behaviors.fancyload = {
    attach: function (context) {
      $(".fancyload").once().responsivelazyloader({
        distance: -100,
      });
    }
  };

})(jQuery, Drupal);

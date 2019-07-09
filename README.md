Fancyload
=====================

This lightweight module will automatically provide lazyloading of images on your website in a pinterest-style color scheme. It fetches the main color of your image and serves it until your image is loaded.

![alt](https://www.drupal.org/files/project-images/fancyload_screenshot_0.jpg)

The module is great for performance and SEO, since it only loads images that are actually viewed in the viewport. Especially on mobile devices this results in faster loading of your pages.

### Usage
* __Do not use this Github code, only the official module code at [drupal.org/project/fancyload](https://www.drupal.org/project/fancyload)__
* Download the [reponsive lazy loader library](https://github.com/jetmartin/responsive-lazy-loader).
* Place the folder inside the libraries folder so that jquery.responsivelazyloader.js and jquery.responsivelazyloader.min.js are found in libraries/responsive-lazy-loader/js
* Run `composer require drupal/fancyload`
* Enable the module
* Clear the cache of your website

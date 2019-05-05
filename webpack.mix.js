const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/frontend/js')
   .copyDirectory('resources/assets/frontend/css', 'public/frontend/css')
   .copyDirectory('resources/assets/frontend/js', 'public/frontend/js')
   .copyDirectory('resources/assets/frontend/fonts', 'public/frontend/fonts')
   .copyDirectory('resources/assets/frontend/images', 'public/frontend/images')
   .copyDirectory('resources/assets/frontend/vendor', 'public/frontend/vendor')
   .copyDirectory('node_modules/font-awesome', 'public/frontend/vendor/font-awesome')
   .copyDirectory('node_modules/font-awesome', 'public/frontend/vendor/font-awesome')
   .copyDirectory('node_modules/bootstrap/', 'public/frontend/vendor/bootstrap')
   .copyDirectory('node_modules/plyr/', 'public/frontend/vendor/plyr')
   .version();

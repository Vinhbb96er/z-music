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
   .copyDirectory('node_modules/sweetalert/', 'public/frontend/vendor/sweetalert')
   .copyDirectory('node_modules/bootstrap-tagsinput/', 'public/frontend/vendor/bootstrap-tagsinput')
   .copyDirectory('resources/assets/admin/css', 'public/admin/css')
   .copyDirectory('resources/assets/admin/js', 'public/admin/js')
   .copyDirectory('resources/assets/admin/fonts', 'public/admin/fonts')
   .copyDirectory('resources/assets/admin/img', 'public/frontend/img')
   .copy('node_modules/jquery-validation/dist/jquery.validate.min.js', 'public/admin/vendor/jquery-validation')
   .version();

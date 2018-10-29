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

mix.setPublicPath('./').js('resources/js/app-product-builder.js', 'js');
mix.setPublicPath('./').sass('resources/sass/product-builder/style.scss', 'css/app-product-builder.css').options({processCssUrls: false}).sourceMaps();
// mix.browserSync({
//     proxy: 'http://dev.cmsmart.net:3001'
// });
mix.disableNotifications();
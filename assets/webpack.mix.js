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

mix.setPublicPath('./')
    .sass('src/sass/modern.scss', 'css/modern.css').options({processCssUrls: false});
// mix.browserSync({
//     proxy: 'http://dev.cmsmart.net:3001'
// });
mix.disableNotifications();

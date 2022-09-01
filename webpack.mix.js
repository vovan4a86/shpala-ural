let mix = require('laravel-mix');

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
mix.sourcemaps = false;
mix.browserSync({
    proxy: 'shpala-ural'
});
mix.js([
        'static/js--sources/main.js',
    ], 'public/js/all.js')

    .styles([
        'resources/assets/css/magnific-popup.css',
        'resources/assets/css/styles.css',
        'resources/assets/css/custom.css',
    ], 'public/css/all.css')
    .version();

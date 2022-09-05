var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */
elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.browserSync({
        proxy: 'shpala-ural.test'
    });

    mix.scripts([
        'jquery-2.2.4.min.js',
        'jquery.magnific-popup.min.js',
        'jquery.maskedinput.min.js',
        'reframe.min.js',
        'aos.js',
        'hc-sticky.js',
        'slick.min.js',
        'blazy.min.js',
        'svg4everybody.min.js',
        'datepicker.min.js',
        'main.js',
        'maps.js',
        'interface.js',
    ]);

    mix.styles([
        'magnific-popup.css',
        'aos.css',
        'slick.css',
        'slick-theme.css',
        'datepicker.css',
        'main.css',
        'styles.css',
    ]);

});

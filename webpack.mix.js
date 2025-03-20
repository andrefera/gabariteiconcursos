const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/scss/main.scss', 'public/assets/css').options({
    processCssUrls: false
});

mix.sass('resources/scss/header.scss', 'public/assets/css').options({
    processCssUrls: false
});

mix.sass('resources/scss/home.scss', 'public/assets/css').options({
    processCssUrls: false
});

mix.sass('resources/scss/detail.scss', 'public/assets/css').options({
    processCssUrls: false
});

mix.sass('resources/scss/list.scss', 'public/assets/css').options({
    processCssUrls: false
});

mix.sass('resources/scss/cart.scss', 'public/assets/css').options({
    processCssUrls: false
});

const partytown = require('@builder.io/partytown/utils');

mix.copy(partytown.libDirPath(), 'public/~partytown');

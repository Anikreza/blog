const mix = require('laravel-mix');
const path = require('path');
let config = require('./webpack.config');
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

mix.js('resources/js/app.js', 'public/js/admin/index.js')
    .vue()
    .version();

mix.sass('resources/sass/admin/index.scss', 'public/css/admin.css')
    .sass('resources/sass/website/index.scss', 'public/css')
    .copyDirectory('resources/assets/', 'public/')
    .version();

mix.webpackConfig(config);

mix.options({
    processCssUrls: false,
    postCss: [],
    terser: {},
    autoprefixer: {},
    legacyNodePolyfills: false
});

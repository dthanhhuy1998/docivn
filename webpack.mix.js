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

const buildPath = 'public/build';

mix.setPublicPath(buildPath);

const buildJs = (files) => {
    files.forEach((file) => {
        mix.js(file, file.replace(/^resources\/js\//, 'js/'));
    });
};

const buildCss = (files) => {
    files.forEach((file) => {
        mix.postCss(file, file.replace(/^resources\/css\//, 'css/'));
    });
};

const cssFiles = [];

const jsFiles = [];

buildCss([
    'resources/css/app.css',
    ...cssFiles,
]);

buildJs([
    'resources/js/app.js',
    ...jsFiles,
]);

mix.version();
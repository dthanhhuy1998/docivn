const mix = require('laravel-mix');
const path = require('path');

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

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});

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

const jsFiles = [
    // Frontend Files


    // Backend Files
    'resources/js/admin/product/index.js'
];

buildCss([
    'resources/css/app.css',
    ...cssFiles,
]);

buildJs([
    'resources/js/app.js',
    ...jsFiles,
]);

mix.copy('node_modules/video.js/dist/video.min.js', 'public/build/vendor/videojs/video.min.js');
mix.copy('node_modules/video.js/dist/video-js.min.css', 'public/build/vendor/videojs/video-js.min.css');
mix.copyDirectory('node_modules/video.js/dist/font', 'public/build/vendor/videojs/font');

mix.version();

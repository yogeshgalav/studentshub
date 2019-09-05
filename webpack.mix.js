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

mix.js('resources/js/Guest/app.js', 'public/js/app.js')
.js('resources/js/Student/app.js', 'public/js/studentApp.js')
    .sass('resources/sass/app.scss', 'public/css')  
    // .webpackConfig({
    //     plugins: {
    //         "window.Quill": "quill/dist/quill.js",
    //         Quill: "quill/dist/quill.js"
    //     },
    //   });    
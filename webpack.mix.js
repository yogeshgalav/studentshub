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

mix.js('resources/js/guest/app.js', 'public/js/app.js')
.js('resources/js/seeker/app.js', 'public/js/seekerApp.js')
.js('resources/js/student/app.js', 'public/js/studentApp.js')
.js('resources/js/student-register/app.js', 'public/js/studentRegisterApp.js')
    .sass('resources/sass/app.scss', 'public/css') ;
    // mix.extend('foo',new class{
    //     webpackPlugins(){
    //         return new webpack.ProvidePlugin({
    //             "window.Quill": "quill/dist/quill.js",
    //             Quill: "quill/dist/quill.js"
    //     });
    //     }
    // });    
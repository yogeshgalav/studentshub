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

mix.js('resources/js/app/guest/app.js', 'public/js/app.js')
.js('resources/js/app/seeker/app.js', 'public/js/seekerApp.js')
.js('resources/js/app/explore/app.js', 'public/js/exploreApp.js')
.js('resources/js/app/student/app.js', 'public/js/studentApp.js')
.js('resources/js/app/create-post/app.js', 'public/js/createPostApp.js')
.js('resources/js/app/student-register/app.js', 'public/js/studentRegisterApp.js')
    .sass('resources/sass/guest.scss', 'public/css/guest.css') 
    .sass('resources/sass/seeker.scss', 'public/css/seekerApp.css') 
    .sass('resources/sass/explore.scss', 'public/css/exploreApp.css') 
    .sass('resources/sass/student.scss', 'public/css/studentApp.css') 
    .sass('resources/sass/create-post.scss', 'public/css/createPostApp.css') 
    .sass('resources/sass/student-register.scss', 'public/css/studentRegisterApp.css') ;
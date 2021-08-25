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

mix
.extract(['vue','vue-router','vue-axios','axios','vue-sweetalert2'], 'public/js/vue.js')
.extract(['chart.js'], 'public/js/chart.js')
.js('resources/js/app/guest/app.js', 'public/js/app.js')
.js('resources/js/app/seeker/app.js', 'public/js/seekerApp.js')
.js('resources/js/app/student/app.js', 'public/js/studentApp.js')
.js('resources/js/app/profile/app.js', 'public/js/profileApp.js')
.js('resources/js/app/create-post/app.js', 'public/js/createPostApp.js')
.js('resources/js/app/student-register/app.js', 'public/js/studentRegisterApp.js')
.js('resources/js/app/student-classroom/app.js', 'public/js/studentPanelApp.js')
.js('resources/js/app/teacher-classroom/app.js', 'public/js/classroomApp.js')
.js('resources/js/app/institute/app.js', 'public/js/instituteApp.js')
    .sass('resources/sass/app.scss', 'public/css/app.css');

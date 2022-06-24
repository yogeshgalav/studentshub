const path = require('path');
const process = require('process');
const mix = require('laravel-mix');
// const cssImport = require('postcss-import')
// const cssNesting = require('postcss-nesting')
const webpackConfig = require('./webpack.config');

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
	.js('resources/js/app.js', 'public/js')
	.sass('resources/sass/app.scss', 'public/css')
// .vue({ runtimeOnly: (process.env.NODE_ENV || 'production') === 'production' })
	.webpackConfig(webpackConfig)
	.sourceMaps()
	// .options({
	// 	hmrOptions: {
	// 		host: 'localhost',
	// 		port: 8001
	// 	}
	// })
	.disableNotifications();

if (process.env.APP_ENV!=='local') {
	mix.version();
	// mix.extract([
	//    'vue',
	//    'vuex',
	//    'bootstrap',
	//    'sweetalert2',
	//    '@fortawesome/vue-fontawesome',
	//    '@fortawesome/fontawesome-svg-core'
	// ]);
} 
if (process.env.BROWSER_SYNC === true) {
	mix.browserSync(process.env.APP_URL);
}
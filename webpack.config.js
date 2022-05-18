const path = require('path');
var webpack = require('webpack');
const Dotenv = require('dotenv-webpack');

// https://stefanbauer.me/tips-and-tricks/autocompletion-for-webpack-path-aliases-in-phpstorm-when-using-laravel-mix
module.exports = {
	output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
	plugins: [
		new Dotenv(),
		new webpack.optimize.SplitChunksPlugin('common.js'),
		new webpack.optimize.AggressiveMergingPlugin()
	],
	resolve: {
		alias: {
			'@': path.resolve('./resources/js'),
		},
		extensions: ['.js', '.vue', '.json'],
	},
	devServer: {
		allowedHosts: 'all',
	},
};
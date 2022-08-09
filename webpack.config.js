const path = require('path');
var webpack = require('webpack');
const Dotenv = require('dotenv-webpack');
const CompressionPlugin = require('compression-webpack-plugin');

// https://stefanbauer.me/tips-and-tricks/autocompletion-for-webpack-path-aliases-in-phpstorm-when-using-laravel-mix
module.exports = {
	output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
	plugins: [
		new Dotenv(),
		new webpack.optimize.SplitChunksPlugin('common.js'),
		new webpack.optimize.AggressiveMergingPlugin(),
		new CompressionPlugin(),
	],
	resolve: {
		alias: {
			'@': path.resolve('./resources/js'),
		},
		extensions: ['.js', '.vue', '.json'],
		fallback: {
			'fs': false,
			'tls': false,
			'net': false,
			'path': false,
			'zlib': false,
			'http': false,
			'https': false,
			'stream': false,
			'crypto': false,
		 } 
	},
	devServer: {
		allowedHosts: 'all',
	},
};
const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const devMode = process.env.NODE_ENV !== 'production';
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
 
module.exports = {
    entry : './app.js',
    output : {
        filename : 'bundle.js',
        path : path.resolve(__dirname, 'css')
    },
	watch: devMode ? true : false,
	//watch: true,
	watchOptions: {
		aggregateTimeout: 300,
		poll: 1000
	},
    module : {
        rules : [
            {
                test: /\.s?[ac]ss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    //devMode ? 'style-loader' : MiniCssExtractPlugin.loader,
                    { loader: 'css-loader', options: { url: false, sourceMap: true, minimize: devMode ? false : true } },
                    { loader: 'sass-loader', options: { sourceMap: true } }
                ],
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: "babel-loader"
            }
        ]
    },
    devtool: 'source-map', //This option controls if and how source maps are generated.
    plugins: [
        new MiniCssExtractPlugin({
            filename: devMode ? 'modern.css' : 'modern.min.css',
			chunkFilename: devMode ? '[id].css' : '[id].min.css',
        }),
		
		function() {
            this.plugin('watch-run', function(watching, callback) {
                console.log('Begin compile at ' + new Date());
                callback();
            })
        }
        
    ],
    mode : devMode ? 'development' : 'production'
};
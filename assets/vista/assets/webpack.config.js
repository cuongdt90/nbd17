const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const devMode = process.env.NODE_ENV !== "production";
module.exports = {
	mode: devMode ? "development" : "production",
	entry: "./src/sass/vista.scss",
	output: {
		filename: "vista.min.css",
		path: path.resolve(__dirname, "css")
	},
    module: {
        rules: [{
            test: /\.(sa|sc)ss$/,
            use: [{
                loader: MiniCssExtractPlugin.loader
            }, {
                loader: "sass-loader"
            }]
        }]
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "vista.min.css"
        })
    ]
}
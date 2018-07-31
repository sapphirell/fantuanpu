const path = require('path');
module.exports = {
	entry : "./app/main.js",
	output : {
		path : path.resolve(__dirname,"dist"),
		filename : "all.js"
	},
	module: {
		rules: [{
			test: /\.js$/,
			exclude: /(node_modules|bower_components)/,
			use: {
			loader: 'babel-loader',
			options: {
					presets: ['es2015','react']
				}
			}
		}
		,{
			test: /\.css$/,
			loader: 'style-loader!css-loader'
		}
		,{
			test: /\.(eot|woff|woff2|svg|ttf)([\?]?.*)$/,
				loader: "file-loader"
		}
		]
	},
    	watch:true //热更新
}
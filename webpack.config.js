const webpack = require("webpack");

let mode, i = process.argv.indexOf("--mode");
if (i > -1) {
    mode = process.argv[i + 1];
}

let watch = true;
let devtool = "source-map";

if (mode === 'production') {
    watch = false;
    devtool = "none";
}

module.exports = {
    entry: {
        "index": './resources/js/index.js',
        "admin": './resources/js/admin.js',
        "list-partners": './resources/js/list-partners.js',
        "promo": './resources/js/promo.js',
        "front": './resources/js/front.js',
    },
    output: {
        path: `${__dirname}/public/js`,
        filename: '[name].js',
    },
    watch: watch,
    mode: mode,
    devtool: devtool,
    module: {
        rules: [
            {
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.scss$/,
                use: [
                    'css-loader',
                    'sass-loader',
                ]
            },
            {
                test: /\.css$/,
                use: [
                    'css-loader',
                ]
            },
        ]
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
            Cookies: "js-cookie/src/js.cookie.js",
        }),
    ]
}

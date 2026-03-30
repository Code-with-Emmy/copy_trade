const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js").webpackConfig({
    resolve: {
        fallback: {
            fs: false,
            tls: false,
            net: false,
            path: require.resolve("path-browserify"),
            zlib: require.resolve("browserify-zlib"),
            http: require.resolve("stream-http"),
            https: require.resolve("https-browserify"),
            stream: require.resolve("stream-browserify"),
            crypto: require.resolve("crypto-browserify"),
            constants: require.resolve("constants-browserify"),
            vm: require.resolve("vm-browserify"),
            log4js: false,
        },
    },
});

if (mix.inProduction()) {
    mix.version();
}

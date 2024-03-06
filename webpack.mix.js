const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .sourceMaps()
    .browserSync({
        host: "ecommerce.test",
        injectChanges: true,
        open: false,
        proxy: "http://ecommerce.test",
        https: {
            key: 'C:/laragon/etc/ssl/laragon.key',
            cert: 'C:/laragon/etc/ssl/laragon.crt'
        },
        files: [
            'app/**/*',
            'resources/views/**/*',
            'resources/lang/**/*',
            'routes/**/*'
        ],
        watchOptions: {
            usePolling: true,
            interval: 500,
        },
    })
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),

    ]);

if (mix.inProduction()) {
    mix.version();
}

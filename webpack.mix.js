const path = require('path');
const mix = require('laravel-mix');
const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix.config.vue.esModule = true

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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')

    .sourceMaps()
    //.disableNotifications()

if (mix.inProduction()) {
    mix.version()

    mix.extract([
        'vue',
        'vform',
        'axios',
        'vuex',
        'jquery',
        'popper.js',
        'vue-i18n',
        'vue-meta',
        'js-cookie',
        'bootstrap',
        'bootstrap-vue',
        'vue-router',
        'sweetalert2',
        'vuex-router-sync',
        '@fortawesome/fontawesome',
        '@fortawesome/vue-fontawesome',
        'vuetable-2',
        'glyphicons-only-bootstrap',
        'snotify'
    ])
}

mix.webpackConfig({
    plugins: [
        new BundleAnalyzerPlugin()
    ],
    resolve: {
        extensions: ['.js', '.json', '.vue'],
        alias: {
            '~': path.join(__dirname, './resources/js')
        }
    },
    output: {
        chunkFilename: 'js/[name].[chunkhash].js',
        publicPath: mix.config.hmr ? '//localhost:8080' : '/'
    }
})

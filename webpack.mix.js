const mix = require('laravel-mix')

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

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .copyDirectory('resources/assets/semantic/dist/themes', 'public/css/themes')
   .copy('resources/assets/semantic/dist/components', 'public/css/components')
   .copy('resources/assets/semantic/dist/*.css', 'public/css')

mix.browserSync('localhost:8000')

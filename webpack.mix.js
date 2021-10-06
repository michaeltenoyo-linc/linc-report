const mix = require('laravel-mix');

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

mix.setPublicPath('public');
mix.setResourceRoot('../');

mix
  .js('resources/js/app.js', 'public/js')
  .js('resources/js/auth/auth.js', 'public/js')
  .js('resources/js/admin/admin.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .options({
    postCss: [
      require('postcss-import'),
      require('tailwindcss'),
      require('postcss-nested'),
      require('autoprefixer'),
    ]
  })

if (mix.inProduction()) {
  mix
    .version();
}

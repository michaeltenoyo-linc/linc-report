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
  .js('resources/js/smart/smart.js', 'public/js')
  .js('resources/js/ltl/ltl.js', 'public/js')
  .js('resources/js/pkg/pkg.js', 'public/js')
  .js('resources/js/third-party/third-party.js', 'public/js')
  .js('resources/js/loa/loa.js', 'public/js')
  .js('resources/js/greenfields/greenfields.js', 'public/js')
  .js('resources/js/sales/sales.js', 'public/js')
  .js('resources/js/master/master.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .options({
    postCss: [
      require('postcss-import'),
      require('tailwindcss'),
      require('postcss-nested'),
      require('autoprefixer'),
    ]
  })
  .webpackConfig({
    stats: {
        children: true,
    },
  });

if (mix.inProduction()) {
  mix
    .version();
}

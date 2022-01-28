const mix = require('laravel-mix');

mix
  .js('resources/js/app.js', 'public/js')
  .scripts('resources/js/resources/*.js', 'public/js/resources.js')
  .scripts('resources/js/resources/index/*.js', 'public/js/resources.index.js')
  .scripts('resources/js/resources/edit/*.js', 'public/js/resources.edit.js')
  .scripts('resources/js/resources/show/*.js', 'public/js/resources.show.js')
  .postCss('resources/css/app.css', 'public/css', [
    require('tailwindcss'),
  ]);

if (mix.inProduction()) {
  mix
    .version();
}

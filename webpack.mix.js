let mix = require('laravel-mix');

mix.copy('resources/fonts/*', 'public/fonts');
mix.copy('resources/fonts/hk-grotesk/*', 'public/fonts/hk-grotesk');

mix.styles([
    'resources/css/grid.min.css',
    'resources/css/app.css',
    'resources/css/main.css',
],'public/css/all.css')

mix.js('resources/js/app.js', 'public/js').vue();

let mix = require('laravel-mix');

mix.copyDirectory('resources/css/', 'public/css');
mix.sass('resources/scss/all.scss', 'public/css');
mix.copyDirectory('resources/js/', 'public/js');
mix.copyDirectory('resources/fonts/', 'public/fonts');
mix.copyDirectory('resources/asset/', 'public/asset');
mix.copyDirectory('resources/json/', 'public/json');

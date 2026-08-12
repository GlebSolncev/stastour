let mix = require('laravel-mix');
const path = require('path');

// mix.copyDirectory('resources/css/', 'public/css');
// mix.sass('resources/scss/all.scss', 'public/css');
// mix.js('resources/js/app.js', 'public/js')
//     .vue({ version: 3 });
// mix.copyDirectory('resources/js/', 'public/js');
// mix.copyDirectory('resources/fonts/', 'public/fonts');
// mix.copyDirectory('resources/asset/', 'public/asset');
// mix.copyDirectory('resources/json/', 'public/json')
//     .alias({
//         // ПРАВИЛЬНО: Используем __dirname для указания пути к корню проекта
//         'vue': path.resolve(__dirname, 'node_modules/vue/dist/vue.esm-bundler.js')
//     });
// mix.webpackConfig({
//     resolve: {
//         alias: {
//             vue: 'vue/dist/vue.esm-bundler.js',
//         },
//     },
// });


// Только компилируем точку входа. Webpack сам найдет все импорты и соберет их в один файл
mix.js('resources/js/app.js', 'public/js')
    .vue({ version: 3 });

mix.sass('resources/scss/all.scss', 'public/css');

// Копируем только статику (шрифты, картинки, json), но НЕ сырой JS!
mix.copyDirectory('resources/css/', 'public/css');
mix.copyDirectory('resources/fonts/', 'public/fonts');
mix.copyDirectory('resources/asset/', 'public/asset');
mix.copyDirectory('resources/json/', 'public/json');

mix.webpackConfig({
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js'
        }
    }
});

mix.options({
    processCssUrls: false
});

mix.browserSync({
    proxy: '127.0.0.1:4038',
    open: false,
    port: 3000,
});
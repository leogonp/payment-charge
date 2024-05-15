const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .babelConfig({
        presets: [
            [
                '@babel/preset-env',
                {
                    targets: 'last 2 versions',
                    useBuiltIns: 'usage',
                    corejs: 3
                }
            ]
        ]
    })
    .react()
    .sass('resources/sass/app.scss', 'public/css');

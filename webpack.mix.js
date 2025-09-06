const mix = require('laravel-mix');

    mix.js('resources/js/app.js', 'public/js')
    .vue() // Ensure this is included
    .sass('resources/sass/app.scss', 'public/css');

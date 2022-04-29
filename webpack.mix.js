const mix = require('laravel-mix');

mix.js([
    'resources/js/admin.js',
    'resources/js/prefect-scrollbar.js',
    'resources/js/off-canvas.js',
    'resources/js/hoverable-collapse.js',
    'resources/js/template.js',
], 'public/js/admin.js')
    .vue()

mix.styles([
        'resources/css/vendor.bundle.base.css',
        'resources/css/style.css',
    ], 'public/css/admin.css')

if (mix.inProduction()) {
    mix.version();
}

// mix.browserSync();
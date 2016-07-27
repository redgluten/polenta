var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

var paths = {
    'public': 'public/',
    'assets': 'resources/assets/',
    'jquery': 'node_modules/jquery/',
    'bootstrap': 'node_modules/bootstrap-sass/',
    'select2': 'node_modules/select2/',
    'editor': 'node_modules/wysihtml/',
    'fontawesome': 'node_modules/font-awesome/',
    'clipboard': 'node_modules/clipboard/',
    'espacefine': 'node_modules/espacefine/'
}

elixir(function(mix) {
    mix.sass('app.scss');
    mix.sass('admin.scss');
    mix.sass('editor.scss');

    // App
    mix.scripts(
        [
            paths.jquery + 'dist/jquery.js',
            paths.bootstrap + 'assets/javascripts/bootstrap.js',
            paths.clipboard + 'dist/clipboard.js',
            paths.espacefine + 'src/espacefine.js',
            'resources/assets/js/app.js'
        ], 'public/js/app.js', './'
    );

    // Admin
    mix.scripts(
        [
            paths.select2 + 'dist/js/select2.js',
            paths.editor + 'dist/wysihtml-toolbar.js',
            paths.editor + 'parser_rules/advanced_and_extended.js',
            'resources/assets/js/admin.js'
        ], 'public/js/admin.js', './'
    );

    // Fonts
    mix.copy(paths.fontawesome + 'fonts', paths.public + 'fonts/font-awesome');

    // Calling Gulp task images
    mix.task('images');
});


/*
 |--------------------------------------------------------------------------
 | Traditionnal gulp tasks
 |--------------------------------------------------------------------------
 |
 */

var gulp     = require('gulp');
var imagemin = require('gulp-imagemin');

// Images
gulp.task('images', function() {
    var customImages   = [paths.assets + 'images/*.{png,gid,jpg,gif}'];

    gulp.src(customImages)
        .pipe(imagemin())
        .pipe(gulp.dest(paths.public + '/images'))
    ;
});

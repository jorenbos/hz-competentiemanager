const elixir = require('laravel-elixir');
const scsslint = require('gulp-scss-lint');

require('laravel-elixir-vue-2');

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
elixir(mix => {
    mix.sass('app.scss')
    .webpack('app.js');
});

gulp.task('test', function() {
    return gulp.src('./resources/assets/sass/**/*.scss')
        .pipe(scsslint())
        .pipe(scsslint.failReporter());
});

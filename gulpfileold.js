'use strict';

var elixir = require('laravel-elixir');
var gulp = require('gulp');
var gutil = require('gulp-util');
var sass = require('gulp-sass');
var plumber = require('gulp-plumber');
var tap = require('gulp-tap');
var source = require('vinyl-source-stream');
var babelify = require('babelify');
var watchify = require('watchify');
var exorcist = require('exorcist');
var browserify = require('browserify');
var browserSync = require('browser-sync');
var domain = require('domain');
var nodemon = require('nodemon');

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

var bowerDir = './resources/assets/vendor/';

elixir.config.sourcemaps = false;

var lessPaths = [
    bowerDir,
    bowerDir + "bootstrap/less/",
    bowerDir + "font-awesome/less/",
    bowerDir + "bootstrap-select/less/",
    bowerDir + "eonasdan-bootstrap-datetimepicker/src/less/",
    bowerDir + "toastr/",
];

elixir.config.js.browserify.options.debug = true;
elixir.config.js.browserify.watchify.options.debug = true;

// set browserify config directly
elixir.config.js.browserify.transformers =
    [
        { name: 'babelify', options: {  presets: ['es2015', 'react'],     sourceMapRelative: 'app' } },
        { name: 'partialify' }
    ];

console.log(elixir.config.js.browserify.options);

elixir(function(mix) {

    mix.less('app.less', 'public/css', { paths: lessPaths })
        .styles(['style.css'], 'public/build/css/style.css', 'public/css')
        .styles([bowerDir+'toastr/toastr.css'],  'public/css/')
        .scripts(['custom.js'],'public/js/custom.js','public/js/')
        .scripts([
            'jquery/dist/jquery.min.js',
            'moment/moment.js',
            'bootstrap/dist/js/bootstrap.min.js',
            'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
            'bootstrap-select/dist/js/bootstrap-select.min.js',
        ], 'public/js/app.js', bowerDir)
        .scripts([bowerDir+'toastr/toastr.js',],'public/js/')
        .copy(bowerDir + 'font-awesome/fonts', 'public/build/fonts')
        .copy('public/fonts', 'public/build/fonts')
        .copy('public/images', 'public/build/images')
        .version([
            'css/app.css',
            'css/style.css',
            'css/all.css',
            'js/app.js',
            'js/custom.js',
            'js/all.js'
        ])
        .browserify('./chat/client/app.js','public/js/bundle.js')
        .browserSync({
            proxy: 'public_chat'
        });
});

// Browsersync Reload
var reload = browserSync.reload;

// Input file.
watchify.args.debug = true;
// let bundler = watchify(browserify('client/client.js', watchify.args));
var bundler = browserify('chat/client/app.js', watchify.args);

// Babel transform
bundler.transform(babelify.configure({
    sourceMapRelative: 'app'
}));

// On updates recompile
bundler.on('update', bundle);

function bundle() {

    gutil.log('Compiling JS...');
    return bundler.bundle()
        .on('error', function(err) {
            gutil.log(gutil.colors.red("Browserify compile error:"), err.message);
            gutil.beep();
            browserSync.notify('Browserify Error!');
            this.emit('end');
        })
        .pipe(exorcist('public_chat/assets/js/bundle.js.map'))
        .pipe(source('bundle.js'))
        .pipe(gulp.dest('public_chat/assets/js'))
        .pipe(browserSync.stream({once: true}));
}

/**
 * Gulp task alias
 */
gulp.task('bundle', ['styles'], function () {
    return bundle();
});

/**
 * First bundle, then serve from the public_chat directory
 */
gulp.task('default', ['bundle'], function () {
    browserSync.init({
        server: 'public_chat'
    });

    // nodemon({
    //   script: 'server/app'
    // });
});

gulp.task('styles', function () {
    return gulp.src('chat/client/stylesheets/*.scss')
        .pipe(plumber())
        // .pipe($.sourcemaps.init())
       // .pipe(sass.sync({
       //     outputStyle: 'expanded',
       //     precision: 10,
       //     includePaths: ['.']
        //}).on('error', sass.logError))
        // .pipe($.autoprefixer({browsers: ['last 1 version']}))
        // .pipe($.uncss({
        //   html: ['client/*.html']
        // }))
        // .pipe($.sourcemaps.write())
        .pipe(gulp.dest('public_chat/assets/stylesheets'))
        .pipe(bundle());
    // .pipe(reload({stream: true}));
});

gulp.task('watch', ['default'], function () {

    gulp.watch('chat/client/stylesheets/**/*.scss', ['styles']);
    gulp.watch('chat/client/**/*.js', ['bundle']);
    gulp.watch('public_chat/**/*.html', ['bundle']);

});

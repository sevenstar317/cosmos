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
var uglify = require('gulp-uglify');
var ext = require('gulp-ext-replace');
var minify = require('gulp-minify');


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


elixir.config.js.browserify.options.debug = false;
elixir.config.js.browserify.watchify.options.debug = false;

// set browserify config directly
elixir.config.js.browserify.transformers =
    [
        { name: 'babelify', options: {  presets: ['es2015'],     sourceMapRelative: false } },
        { name: 'partialify' }
    ];

elixir.config.js.uglify.options.mangle = false;
elixir.config.js.uglify.options.properties = false;
elixir.config.js.uglify.options.loops = false;
elixir.config.js.uglify.options.sequences = false;

var Task = elixir.Task;


elixir.extend('uglify', function(sourceFile, outputFolder)
{
    new Task('uglify', function()
    {
        return gulp.src(sourceFile)
            // Initialize
            .pipe(uglify({
                mangle: false,
                output: {
                    beautify: false,
                    comments: false
                }
            }))
            // Add .min extension to file
            .pipe(ext('.min.js'))
            // Output minified js
            .pipe(gulp.dest(outputFolder))
            // Write and Output minified js mapping file
    })
});


elixir(function(mix) {

    mix.less('app.less', 'public/css', { paths: lessPaths })
        .styles(['style.css'], 'public/build/css/style.css', 'public/css')
        .styles([bowerDir+'toastr/toastr.css'],  'public/css/')
        .scripts([
            'jquery/dist/jquery.min.js',
            'bootstrap/dist/js/bootstrap.min.js',
            'moment/min/moment.min.js',
            'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
            'bootstrap-select/dist/js/bootstrap-select.min.js',
            'bootstrap3-typeahead/bootstrap3-typeahead.min.js',
            'toastr/toastr.min.js',
            'jquery.countdown/dist/jquery.countdown.min.js'
        ], 'public/js/all.js', bowerDir)
        .copy(bowerDir + 'font-awesome/fonts', 'public/build/fonts')
        .copy('public/fonts', 'public/build/fonts')
        .copy('public/images', 'public/build/images')
    //    .scripts(['./chat/client/app.js'],'./chat/client/bundle_temp.js')
        .browserify('./chat/client/app.js','public/js/bundle.js')
        .uglify(
            'public/js/bundle.js', 		// File to uglify
            "public/js/"				// Output path
        )
        .uglify(
            'public/js/custom.js', 		// File to uglify
            "public/js/"				// Output path
        )
        .version([
            'css/app.css',
            'css/style.css',
            'css/all.css',
            'css/style_mobile.css',
            'js/custom.js',
            'js/custom.min.js',
            'js/all.js',
            'js/bundle.min.js',
        ])
});


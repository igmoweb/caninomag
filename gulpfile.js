var gulp = require('gulp');
var clean = require('gulp-clean');
var $    = require('gulp-load-plugins')();
var concat = require("gulp-concat-js");
var babel = require('gulp-babel');

var sassPaths = [
  'bower_components/foundation-sites/scss',
  'bower_components/motion-ui/src'
];

gulp.task('sass', function() {
  return gulp.src('scss/app.scss')
    .pipe($.sass({
      includePaths: sassPaths,
      outputStyle: 'compressed' // if css compressed **file size**
    })
      .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie >= 9']
    }))
    .pipe(gulp.dest('css'));
});

gulp.task('default', ['sass'], function() {
  gulp.watch(['scss/**/*.scss'], ['sass']);
});

gulp.task( 'clear-build', function() {
    return gulp.src('./build/', {read: false})
        .pipe(clean());
});

gulp.task( 'files', function() {
    // Tale only needed JS
    gulp.src(
        [
            './bower_components/foundation-sites/js/foundation.core.js',
            './bower_components/foundation-sites/js/foundation.util.mediaQuery.js',
            './bower_components/foundation-sites/js/foundation.sticky.js'
        ]
    )
        .pipe(concat({
            "target": "foundation.min.js" // Name to concatenate to
        }))
        .pipe(gulp.dest('./js'));
});

gulp.task('build', ['sass','files','clear-build'], function() {

    // Copy JS
    gulp.src(
        [
            './**/*',
            '!node_modules/**',
            '!node_modules/',
            '!scss/**',
            '!scss/',
            '!*.md',
            '!*.json',
            '!gulpfile.js',
            '!pasos-migracion'
        ]
    )
        .pipe(gulp.dest('./build/'));


    // Copy CSS
});
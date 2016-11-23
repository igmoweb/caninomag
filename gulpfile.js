var gulp = require('gulp');
var clean = require('gulp-clean');
var $    = require('gulp-load-plugins')();
var concat = require("gulp-concat");
var babel = require('gulp-babel');
var uglify = require('gulp-uglify');

var sassPaths = [
  'bower_components/foundation-sites/scss',
  'bower_components/motion-ui/src'
];

var js_files = [
    'bower_components/foundation-sites/js/foundation.core.js',
    './bower_components/foundation-sites/js/foundation.util.mediaQuery.js',
    'bower_components/foundation-sites/js/foundation.sticky.js',
    'bower_components/foundation-sites/js/foundation.dropdownMenu.js',
    'bower_components/foundation-sites/js/foundation.responsiveToggle.js',
    'bower_components/foundation-sites/js/foundation.util.touch.js'
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

/**
 * Concat needed JS Files
 */
gulp.task( 'javascript', function() {
    // Tale only needed JS
    return gulp.src(js_files)
        .pipe(babel())
        .pipe(concat('foundation.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./js'));
});

gulp.task('build', ['sass','javascript','clear-build'], function() {

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

});
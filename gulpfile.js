var gulp = require('gulp');
var clean = require('gulp-clean');
var image = require('gulp-image');

gulp.task( 'clear-build', function() {
    return gulp.src('./build/', {read: false})
        .pipe(clean());
});

gulp.task('compress', function () {
        gulp.src('./images/*')
          .pipe(image())
          .pipe(gulp.dest('./images'));
});
gulp.task('build', ['clear-build', 'compress'], function() {

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
            '!phpcs.ruleset.xml',
            '!webpack.config.js',
            '!todo.txt',
            '!pasos-migracion',
            '!bower_components/cookie-law-info/**',
            '!bower_components/cookie-law-info/',
            '!bower_components/safe-report-comments/**',
            '!bower_components/safe-report-comments/',
            '!mu-plugins/**',
            '!bin/**/*',
            '!vendor/**/*'
        ],
      { nodir: true }
    )
        .pipe(gulp.dest('./build/'));

});

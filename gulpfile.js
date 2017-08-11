var gulp = require('gulp');
var clean = require('gulp-clean');
var $    = require('gulp-load-plugins')();
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var uglifyCSS = require( 'gulp-uglifycss' );

gulp.task( 'clear-build', function() {
    return gulp.src('./build/', {read: false})
        .pipe(clean());
});

gulp.task( 'cookie-law-info-js', function() {
    var cookieFiles = [
        'bower_components/cookie-law-info/js/cookielawinfo.js'
    ];
    return gulp.src(cookieFiles)
        .pipe(uglify())
        .pipe(gulp.dest('./plugins/cookie-law-info/js'));
});

gulp.task( 'cookie-law-info-css', function() {
    var cookieFiles = [
        'bower_components/cookie-law-info/css/cli-style.css'
    ];
    return gulp.src(cookieFiles)
        .pipe(uglifyCSS())
        .pipe(gulp.dest('./plugins/cookie-law-info/css'));
});

gulp.task( 'cookie-law-info-img', function() {
    var cookieFiles = [
        'bower_components/cookie-law-info/images'
    ];
    return gulp.src(cookieFiles)
        .pipe(uglifyCSS())
        .pipe(gulp.dest('./plugins/cookie-law-info/'));
});


gulp.task( 'safe-reports-comments-js', function() {
    var cookieFiles = [
        'bower_components/safe-report-comments/js/ajax.js'
    ];
    return gulp.src(cookieFiles)
        .pipe(uglify())
        .pipe(gulp.dest('./plugins/safe-report-comments/js'));
});

gulp.task('build', ['cookie-law-info-js', 'cookie-law-info-css', 'cookie-law-info-img', 'safe-reports-comments-js','clear-build'], function() {

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
            '!webpack.config.js',
            '!todo.txt',
            '!pasos-migracion',
            '!bower_components/cookie-law-info/**',
            '!bower_components/cookie-law-info/',
            '!bower_components/safe-report-comments/**',
            '!bower_components/safe-report-comments/'
        ]
    )
        .pipe(gulp.dest('./build/'));

});
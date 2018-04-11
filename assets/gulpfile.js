var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var rtlcss = require('gulp-rtlcss');
var rename = require('gulp-rename');
var plumber = require('gulp-plumber');
var gutil = require('gulp-util');
var cssnano = require('gulp-cssnano');
var gcmq = require('gulp-group-css-media-queries');
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync').create();
var minifyCSS = require('gulp-minify-css');
var reload = browserSync.reload;

var onError = function (err) {
    console.log('An error occurred:', gutil.colors.magenta(err.message));
    gutil.beep();
    this.emit('end');
};

gulp.task('frontstyle', function() {
    return gulp.src('./src/sass/modern.scss')
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gcmq())
        .pipe(minifyCSS())
        .pipe(gulp.dest('./css/'))
});




gulp.task('watch', function() {
	gulp.watch('src/sass/**/*.scss', ['frontstyle']);
});

gulp.task('default', ['front']);

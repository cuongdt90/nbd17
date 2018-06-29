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
var uglify = require('gulp-uglify');
var reload = browserSync.reload;

var onError = function (err) {
    console.log('An error occurred:', gutil.colors.magenta(err.message));
    gutil.beep();
    this.emit('end');
};

gulp.task('main_style', function() {
    return gulp.src('./src/sass/vista.scss')
        .pipe(plumber({ errorHandler: onError }))
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gcmq())
        .pipe(minifyCSS())
        .pipe(gulp.dest('./css/'))
});

// gulp.task('vista_js', function() {
//     return gulp.src(['./js/library/*.js'])
//         .pipe(jshint())
//         .pipe(jshint.reporter('default'))
//         .pipe(rename({suffix: '.min'}))
//         .pipe(uglify())
//         .pipe(gulp.dest('./js/bundle-vista1'));
// });

gulp.task('right_to_left', function() {
    return gulp.src('./src/sass/rtl.scss')
        .pipe(plumber({errorHandler: onError}))
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gcmq())
        .pipe(minifyCSS())
        .pipe(rename('vista-rtl.css'))
        .pipe(gulp.dest('./css/'));
});


gulp.task('watch', function() {
    gulp.watch('src/sass/**/*.scss', ['main_style']);
    // gulp.watch('js/library/*.js', ['vista_js']);
});

gulp.task('default', ['frontstyle']);

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const rename = require('gulp-rename');

function styles() {
    return gulp.src('assets/scss/style.scss')
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(rename('style.css'))
        .pipe(gulp.dest('assets/css'));
}

function watch() {
    gulp.watch('assets/scss/**/*.scss', styles);
}

exports.styles = styles;
exports.watch = watch;

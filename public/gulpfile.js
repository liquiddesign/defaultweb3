const { src, dest, series } = require('gulp');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const gulp = require('gulp');
const sass = require('gulp-sass');
const cleanCSS = require('gulp-clean-css');
const merge = require('merge-stream');


function minifyJs() {
    return src(['js/*.js', '!js/*.min.js'])
        .pipe(rename({ suffix: '.min' }))
        .pipe(uglify())
        .pipe(dest('js'));
}

function convertScssToCss() {
    let firstPath = gulp.src(['css/*.scss'])
        .pipe(sass()) // Using gulp-sass
        .pipe(gulp.dest('css'));

    let secondPath = gulp.src(['admin/css/*.scss'])
        .pipe(sass()) // Using gulp-sass
        .pipe(gulp.dest('admin/css'));

    return merge(firstPath, secondPath);
}

function minifyCSS() {
    let firstPath = gulp.src(['css/*.css', '!css/*.min.css'])
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('css'));

    let secondPath = gulp.src(['admin/css/*.css', '!admin/css/*.min.css'])
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('admin/css'));

    return merge(firstPath, secondPath);
}

const build = gulp.series(minifyJs, convertScssToCss, minifyCSS);

exports.default = build;

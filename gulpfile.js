'use strict';

require('dotenv').config();

let gulp = require('gulp');
let sass = require('gulp-sass');
let browserSync = require('browser-sync').create();
let autoprefixer = require('gulp-autoprefixer');
let cleanCSS = require('gulp-clean-css');
let sassGlob = require('gulp-sass-glob');
let del = require('del');
let sourcemaps = require('gulp-sourcemaps');
let uglify = require('gulp-uglify');
let rename = require("gulp-rename");
let merge = require('merge-stream');
let webpackStream = require('webpack-stream');
const webpack = require('./webpack.config');

const config = {
    hostName: process.env.HOST_NAME,
    browser: process.env.BROWSER,
    watch: {
        sass: [
            "./resources/sass/**/*.sass",
            "./resources/sass/**/*.scss",
            "./templates/**/**/**/**/**/*.scss",
        ],
        js: [
            './resources/js/**/**/*.js',
            "./templates/**/**/**/**/**/*.js",
        ],
        twig: [
            "./templates/**/**/**/*.twig",
        ],
        php: [
            `*.php`,
            "./src/Controller/*.php",
        ],
    },
    path: {
        sass: {
            src: [
                './resources/sass/index.scss',
                './resources/sass/admin.scss'
            ],
            dest: './public/css'
        },
    },
    cleanDel: [
        "./public/js",
        "./public/css"
    ],
};

gulp.task('browser-sync', (done) => {
    browserSync.init({
        browser: config.browser,
        open: 'external',
        host: config.hostName,
        proxy: config.hostName,
        port: 3000
    });
    done();
});

gulp.task('watch', (done) => {
    gulp.watch(config.watch.sass, gulp.series('sass', 'reload-browser'));
    gulp.watch(config.watch.js, gulp.series('webpack'));
    gulp.watch(config.watch.twig, gulp.series('reload-browser'));
    gulp.watch(config.watch.php, gulp.series('reload-browser'));
    gulp.watch(config.watch.js, gulp.series('reload-browser'));
});

gulp.task('sass', (done) => {
    return gulp
        .src(config.path.sass.src)
        .pipe(sourcemaps.init())
        .pipe(sassGlob())
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(cleanCSS())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(config.path.sass.dest));
});

gulp.task('webpack', (done) => {
    return gulp.src('./resources/js/index.js')
        .pipe(webpackStream(webpack))
        .pipe(gulp.dest('./public/js'));
});

gulp.task('reload-browser', (done) => {
    browserSync.reload({
        ghostMode: {
            clicks: false,
            forms: false,
            scroll: false,
            location: false,
        }
    });
    done();
});

gulp.task('clean', (done) => {
    return del(config.cleanDel);
});

gulp.task('default', gulp.parallel('watch', 'browser-sync'));
gulp.task('build', gulp.series('clean', 'sass', 'webpack'));

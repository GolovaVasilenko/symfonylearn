'use strict';

var gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    browserSync = require('browser-sync'),
    cssnano = require('gulp-cssnano'),
    del = require('del'),
    imagemin = require('gulp-imagemin'),
    rigger = require('gulp-rigger'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    typescript = require('gulp-typescript'),
    uglify = require('gulp-uglify'),
    uncss = require('gulp-uncss'),
    reload = browserSync.reload;

var path = {
    build: {
        html: 'build',
        js: 'build/js',
        ts: 'src/js/ts',
        css: 'build/css/',
        img: 'build/assets/img',
        video: 'build/assets/video',
        fonts: 'build/fonts/'
    },
    src: {
        html: 'src/*.html',
        js: 'src/js/main.js',
        ts: 'src/ts/tscript.ts',
        css: 'src/css/style.scss',
        img: 'src/assets/img/**/*.*',
        video: 'src/assets/video/**/*.*',
        fonts: 'src/fonts/**/*.*'
    },
    watch: {
        html: 'src/**/*.html',
        js: 'src/js/**/*.js',
        ts: 'src/ts/**/*.ts',
        css: 'src/css/**/*.scss',
        img: 'src/assets/img/**/*.*',
        video: 'src/assets/video/**/*.*',
        fonts: 'src/fonts/**/*.*'
    },
    clean: {
        build: 'build/**',
        ts: 'src/js/ts/**'
    }
        
};

var config = {
    server: {
        baseDir: "./build"
    },
    logPrefix: "My Awesome Project"
};

gulp.task('html:build', function () {
    gulp.src(path.src.html)
        .pipe(rigger())
        .pipe(gulp.dest(path.build.html))
        .pipe(reload({
            stream: true
        }));
});

gulp.task('ts:build', function () {
    return gulp.src(path.src.ts)
//        .pipe(rigger())
//        .pipe(sourcemaps.init())
//        .pipe(typescript({
//            noImplicitAny: true
//        }))
//        .pipe(sourcemaps.write())
//        .pipe(gulp.dest(path.build.ts));
});

gulp.task('js:build', function () {
    gulp.src(path.src.js)
        .pipe(rigger())
        .pipe(sourcemaps.init())
        .pipe(sourcemaps.write())
        .pipe(uglify())
        .pipe(gulp.dest(path.build.js))
        .pipe(reload({
            stream: true
        }));
});

gulp.task('css:build', function () {
    gulp.src(path.src.css)
        .pipe(rigger())
        .pipe(sass())
//        .pipe(uncss({
//            html: ['build/index.html']    
//        }))
        .pipe(autoprefixer({
            browsers: ['last 2 versions', '> 1%']
        }))
        .pipe(cssnano())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(path.build.css))
        .pipe(reload({
            stream: true
        }));
});

gulp.task('img:build', function () {
    gulp.src(path.src.img)
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            interlaced: true
        }))
        .pipe(gulp.dest(path.build.img))
        .pipe(reload({stream: true}));
});

gulp.task('fonts:build', function() {
    gulp.src(path.src.fonts)
        .pipe(gulp.dest(path.build.fonts))
});

gulp.task('build', [
    'html:build',
//    'ts:build',
    'css:build',
    'fonts:build',
    'js:build',
    'img:build'
])

gulp.task('watch', function(){
    gulp.watch([path.watch.html], ['html:build']);
    gulp.watch([path.watch.css], ['css:build']);
//    gulp.watch([path.watch.ts], ['ts:build', 'js:build']);
    gulp.watch([path.watch.js], ['js:build']);
    gulp.watch([path.watch.img], ['img:build']);
    gulp.watch([path.watch.fonts], ['fonts:build']);    
});

gulp.task('webserver', function () {
    browserSync(config);
});

gulp.task('clean', function () {
    del([path.clean.build, path.clean.ts]);
});

gulp.task('default', ['build', 'webserver', 'watch']);
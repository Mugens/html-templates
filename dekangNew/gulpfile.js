// Sass configuration
const gulp = require('gulp');
const sass = require('gulp-sass');
const cleanCss = require('gulp-clean-css');

gulp.task('sass', function(cb) {
  gulp
    .src('*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(
      gulp.dest(function(f) {
        return f.base;
      })
    );
  cb();
});

gulp.task(
  'default',
  gulp.series('sass', function(cb) {
    gulp.watch('*.scss', gulp.series('sass'));
    cb();
  })
);
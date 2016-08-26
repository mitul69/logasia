var gulp   = require('gulp');
var concat = require('gulp-concat');
 
gulp.task('scripts', function() {
  return gulp.src(['src/TransportBundle/Resources/public/js/app/*.js'])
    .pipe(concat('all.js'))
    .pipe(gulp.dest('web/js/'));
});


gulp.task('default', ['scripts']);"gulp.task('default');" 

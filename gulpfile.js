// To enable JS minifier change this to "true"
var production = false;


var gulp = require('gulp');
var uglify = require('gulp-uglify');
var pump = require('pump');
var $    = require('gulp-load-plugins')();

var sassPaths = [
  'bower_components/foundation-sites/scss',
  'bower_components/motion-ui/src'
];

gulp.task('sass', function() {
  return gulp.src('src/scss/app.scss')
    .pipe($.sass({
      includePaths: sassPaths,
      outputStyle: 'compressed' // if css compressed **file size**
    })
      .on('error', $.sass.logError))
    .pipe($.autoprefixer({
      browsers: ['last 4 versions', 'ie >= 9']
    }))
    .pipe(gulp.dest('css'));
});


gulp.task('js-compress', function (cb) {
  if(production){
      pump([gulp.src('src/js/**/*.js'), uglify(), gulp.dest('js')], cb);
  }else{
      pump([gulp.src('src/js/**/*.js'), gulp.dest('js')], cb);
  }
    
});


gulp.task('default', ['sass', 'js-compress'], function() {
  gulp.watch(['src/scss/**/*.scss'], ['sass']);
  gulp.watch(['src/js/**/*.js'], ['js-compress']);
});

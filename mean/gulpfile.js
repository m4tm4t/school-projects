'use strict';

var gulp     = require( 'gulp'        );
var gutil    = require( 'gulp-util'   );
var coffee   = require( 'gulp-coffee' );
var haml     = require( 'gulp-haml'   );
var concat   = require( 'gulp-concat' );
var server   = require( 'gulp-express');

var config = {
  bowerDir: './bower_components'
}

gulp.task( 'default',
  [ 'build', 'watch', 'serve']
)

gulp.task( 'build',
  [ 'js_vendor', 'img', 'css', 'coffee', 'haml' ]
)

/**
 * Start app
 */
gulp.task('serve', function () {
  server.run([
    'dist/backend/main.js'
  ])
});

/**
 * VENDOR
 */
gulp.task( 'js_vendor', function() {
  gulp.src(
    [
      config.bowerDir + '/bootsrap/dist/js/bootstrap.min.js',
      config.bowerDir + '/angular/angular.min.js',
      config.bowerDir + '/angular-route/angular-route.min.js',
      config.bowerDir + '/angular-resource/angular-resource.min.js',
      config.bowerDir + '/angular-messages/angular-messages.min.js',
      config.bowerDir + '/angular-bootstrap/angular-ui.min.js',
      config.bowerDir + '/angular-bootstrap/ui-bootstrap-tpls.min.js',
      'src/js/**/*.js',
    ])
    .pipe( concat('vendor.js') )
    .pipe( gulp.dest( 'dist/public/js' ) )
});

/**
 * COFFEE
 */
gulp.task( 'coffee', function() {
  gulp.src('src/backend/**/*.coffee')
      .pipe( coffee( { bare:true } ).on( 'error', gutil.log ) )
      .pipe( gulp.dest( 'dist/backend/' ) )

  gulp.src('src/angular/**/*.coffee')
      .pipe( coffee( { bare:true } ).on( 'error', gutil.log ) )
      .pipe( concat('app.js') )
      .pipe( gulp.dest( 'dist/public/angular/' ) )
});

/**
 * HAML
 */
gulp.task( 'haml', function() {
  gulp.src( 'src/**/*.haml' )
      .pipe( haml( { ext: '.html' } ) )
      .pipe( gulp.dest('dist/public/html'));
});

/**
 * CSS
 */
gulp.task( 'css', function() {
  gulp.src( [
    config.bowerDir + '/bootstrap/dist/css/bootstrap.min.css',
	config.bowerDir + '/angular/angular-csp.css',
    'src/**/*.css'
  ] )
      .pipe( concat( 'style.css' ))
      .pipe( gulp.dest('dist/public/css/'));
});

/**
 * IMG
 */
gulp.task( 'img', function() {
  gulp.src( ['src/**/*.jpg', 'src/**/*.gif', 'src/**/*.png'] )
      .pipe( gulp.dest('dist/public'));
});

gulp.task( 'watch', function() {
  gulp.watch( 'src/**/*.coffee', [ 'coffee', server.run ] );
  gulp.watch( 'src/**/*.haml',   [ 'haml'   ] );
  gulp.watch( 'src/**/*.css',    [ 'css'    ] );
});

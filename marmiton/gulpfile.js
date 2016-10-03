var exec   = require('child_process').exec;

var gulp   = require( 'gulp'        );
var gutil  = require( 'gulp-util'   );
var concat = require( 'gulp-concat' );
var coffee = require( 'gulp-coffee' );
var uglify = require( 'gulp-uglify' );
var sass   = require( 'gulp-sass'   );
var haml   = require( 'gulp-haml'   );
var bower  = require( 'gulp-bower'  );
var inject = require( 'gulp-inject-string' );

var config = {
  bowerDir: './bower_components'
}

gulp.task( 'default', ['watch', 'bower', 'bower_css', 'haml', 'angular_templates',
                       'coffee', 'sass', 'js_vendor', 'css_vendor', 'server' ] );

/**
 * BOWER
 */
gulp.task( 'bower', function() {
  return bower().pipe( gulp.dest( config.bowerDir ) );
});

gulp.task( 'bower_css', function() {
  gulp.src( 'app/assets/sass/**/*.scss' )
      .pipe( sass({
        includePaths: [
          config.bowerDir + '/bootstrap-sass/assets/stylesheets/'
        ]
      }))
      .pipe( concat('vendor.css') )
      .pipe( gulp.dest( 'public/css' ))
});

/**
 * VENDOR
 */
gulp.task( 'js_vendor', function() {
  gulp.src(
      [
        config.bowerDir + '/jquery/dist/jquery.js',
        config.bowerDir + '/underscore/underscore-min.js',
        config.bowerDir + '/bootstrap-sass/assets/javascripts/bootstrap.min.js',
        config.bowerDir + '/angular/angular.min.js',
        config.bowerDir + '/angular-bootstrap/ui-bootstrap-tpls.min.js',
        config.bowerDir + '/angular-ui-router/release/angular-ui-router.min.js',
        config.bowerDir + '/typeahead.js/dist/bloodhound.js',
        config.bowerDir + '/typeahead.js/dist/typeahead.jquery.js',
        config.bowerDir + '/angular-typeahead/angular-typeahead.js',
        'app/assets/vendors/js/**/*.js',
      ])
      .pipe( concat('vendor.js') )
      .pipe( gulp.dest( 'public/js' ) )
});

gulp.task( 'css_vendor', function() {
  gulp.src( 'app/assets/vendors/css/**/*.css' )
      .pipe( concat('vendor2.css') )
      .pipe( gulp.dest( 'public/css' ) )
});

/**
 * COFFEE
 */
gulp.task( 'coffee', function() {
  gulp.src('app/assets/coffee/**/*.coffee')
      .pipe( coffee( { bare:true } ).on( 'error', gutil.log ) )
      // .pipe( uglify() )
      .pipe( concat('app.js') )
      .pipe( gulp.dest( 'public/js' ) )
});

/**
 * SASS
 */
gulp.task( 'sass', function() {
  gulp.src( 'app/assets/sass/**/*.sass' )
      .pipe( sass().on( 'error', gutil.log ) )
      .pipe( concat( 'app.css' ) )
      .pipe( gulp.dest( 'public/css' ) )
});



/**
 * Angular templates
 */
gulp.task( 'angular_templates', function() {
  gulp.src( 'app/assets/coffee/angular/views/**/*.haml' )
      .pipe( haml() )
      .pipe( concat('templates.html') )
      .pipe( gulp.dest('public'));
});

/**
 * Run php server
 */
gulp.task( 'server', function( cb ) {
  server = exec( 'php -S 0.0.0.0:4242 -t public' )

  server.stdout.on('data', function(data) {
    console.log(data);
  });

  server.stderr.on('data', function(data) {
    console.log(data);
  });
});

gulp.task( 'watch', function() {
  gulp.watch( 'app/assets/coffee/**/*.coffee', [ 'coffee' ] );
  gulp.watch( 'app/assets/sass/**/*.sass',     [ 'sass'   ] );
  gulp.watch( 'app/views/**/*.haml',           [ 'haml'   ] );
  gulp.watch( 'app/assets/coffee/angular/views/**/*.haml', [ 'angular_templates' ] );
});

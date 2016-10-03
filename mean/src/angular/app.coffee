@app = angular.module('app', [
  'ngRoute'
  'ngMessages'
  'ngResource'
  'ui.bootstrap'
])

@app.config ($routeProvider) ->
  $routeProvider.when('/signup',
    templateUrl: '/html/angular/views/user/signup.html'
    controller: 'signUpCtrl'
  )
  $routeProvider.when('/signin',
    templateUrl: '/html/angular/views/user/signin.html'
    controller: 'signInCtrl'
  )
  $routeProvider.when('/post:id',
    templateUrl: '/html/angular/views/post/show.html',
    controller: 'PostDetailController'
  )
  $routeProvider.when('/admin',
    templateUrl: '/html/angular/views/admin/index.html'
    controller:  'adminIndexCtrl'
  )
  $routeProvider.when('/admin/posts/create',
    templateUrl: '/html/angular/views/admin/post/create.html'
    controller:  'adminCreateCtrl'
  )
  $routeProvider.when('/',
    templateUrl: '/html/angular/views/home.html'
  )
  .otherwise redirectTo: '/'

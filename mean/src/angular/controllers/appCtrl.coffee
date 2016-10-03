@app.controller 'appCtrl', ( $scope, $rootScope, $http, $location, Session ) ->
  $rootScope.currentUser = null

  Session.get ( user ) ->
    $rootScope.currentUser = user

  $scope.logout = ->
    Session.delete ->
      $rootScope.currentUser = null
      $location.path '/'

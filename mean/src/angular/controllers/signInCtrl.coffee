@app.controller 'signInCtrl', ( $scope, $rootScope, $http, $location ) ->
  $scope.alerts = []

  $scope.submit = ->
    $scope.alerts = []

    $http.post '/sign_in', $scope.user
      .success ( data ) ->
        $rootScope.currentUser = data.user
        $location.path '/'
      .error ( data ) ->
        $scope.alerts.push type: 'danger', msg: 'Wrong username or password!'

@app.controller 'signUpCtrl', ( $scope, $rootScope, $http, $location ) ->
  $scope.alerts = []

  # $scope.user   =
  #   username:        "foo"
  #   email:           "bar@foo.com"
  #   password:        "password"
  #   passwordConfirm: "password"

  $scope.submit = ->
    $scope.alerts = []

    $http.post '/sign_up', $scope.user
      .success ( data ) ->
        $rootScope.currentUser = data.user
        $location.path '/'
      .error ( data ) ->
        if data.errors
          for k,v of data.errors
            $scope.alerts.push type: 'danger', msg: v.message
        else
          $scope.alerts.push type: 'danger', msg: data.message

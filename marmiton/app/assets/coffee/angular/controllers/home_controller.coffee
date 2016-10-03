@app.controller 'homeCtrl', ( $rootScope, $scope, $http, $templateCache ) ->

  $http.get '/recipes'
    .success (data) ->
      $scope.recipes = data

  $scope.foo = ->
    $rootScope.$state.go 'searchRecipe', term: $scope.searchTerm

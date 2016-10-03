@app.controller 'showRecipeCtrl', ( $scope, $rootScope, $http, $modal, $templateCache ) ->

  $http.get "/recipes/#{$rootScope.$stateParams.recipeId}"
    .success (data) ->
      $scope.recipe = data
    .error (data) ->
      console.log data


  $scope.addComment = ->
    modalInstance = $modal.open(
      animation:  true
      template:   $templateCache.get( 'add_comment.html' )
      controller: 'modalCommentCtrl',
      resolve:
        recipe: -> $scope.recipe
    )

    modalInstance.result.then ( result ) ->
      $scope.recipe.comments.push result

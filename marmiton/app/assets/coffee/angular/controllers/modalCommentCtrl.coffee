@app.controller 'modalCommentCtrl', ( $scope, $modalInstance, $http, recipe ) ->

  $scope.comment =
    username: ""
    body: ""
    note: 0
  $scope.comment.recipe_id = recipe.id

  $scope.add = ->
    $http.post "/comments", $scope.comment
      .success (data) ->
        $modalInstance.close( data )

  $scope.cancel = ->
    $modalInstance.dismiss 'cancel'

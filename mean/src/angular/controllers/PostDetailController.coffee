@app.controller 'PostDetailController', [
  '$scope'
  ($scope) ->
    $scope.filename = "kittens_1.jpg"
    $scope.title = 'My post title'
    $scope.tags = 'Red White Brown Blue-eyes'
    $scope.description = 'My post description'
    $scope.author = 'Dimitri'
    $scope.datetime = '11/04/2015'
    return
]

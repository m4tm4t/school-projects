@app.controller 'PostController', [
  '$scope'
  ($scope) ->
    posts = [
        { id: 1, filename: "kittens_1.jpg" }
        { id: 2, filename: "sweets_1.jpg" }
        { id: 3, filename: "kittens_2.jpg" }
        { id: 4, filename: "sweets_2.jpg" }
        { id: 5, filename: "kittens_3.jpg" }
        { id: 6, filename: "sweets_3.jpg" }
        { id: 7, filename: "kittens_4.jpg" }
        { id: 8, filename: "sweets_4.jpg" }
        { id: 9, filename: "kittens_5.jpg" }
        { id: 10, filename: "sweets_5.jpg" }
    ]

    $scope.posts = posts
    return
]

@app.factory 'Post', ( $resource ) ->
  $resource('/posts/:id')

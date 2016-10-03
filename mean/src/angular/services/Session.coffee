@app.factory 'Session', ( $resource ) ->
  $resource('/session')

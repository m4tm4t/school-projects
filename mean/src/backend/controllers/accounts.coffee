module.exports =

  # POST /sign_up
  create: ( req, res ) ->
    User = global.models.User

    User.register( new User( { username: req.body.username, email: req.body.email } ), req.body.password, ( err, user ) ->
      if err
        res.status( 400 ).json( err )
      else
        req.logIn user, ( err ) ->
          res.json err if err
          res.json( user: user )
    )

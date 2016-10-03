passport = require 'passport'

module.exports =

  # GET /sign_in
  index: ( req, res ) ->
    res.send('sessions#index')

  # POST /sign_in
  create: ( req, res ) ->
    User = global.models.User
    passport.authenticate( 'local', ( err, user ) ->
      if user
        req.logIn user, ( err ) ->
          res.json err if err
          res.json( user: user )
      else
        res.status( 401 ).json('kitties are evil')
    )( req, res )

Post = require('../models/post')()

module.exports =

  # GET /posts
  index: ( req, res ) ->
    Post.find ( err, posts ) ->
      if err
        res.status( 500 ).json( err )
      else
        res.json( posts )

  # GET /posts/:id
  show: ( req, res ) ->
    Post.findOne req.id, ( err, post ) ->
      if post
        res.json( post )
      else
        res.sendStatus( 404 )

  # POST /posts
  create: ( req, res ) ->
    post = new Post( req.body )
    post.save ( err ) ->
      if err
        res.status( 500 ).json( error: err )
      else
        res.json( post )

  # PUT /posts/:id
  update: ( req, res ) ->
    Post.where( _id: req.id ).update req.body, ( err, post ) ->
      if err
        res.json( error: err )
      else
        res.json post

  # DELETE /posts/:id
  destroy: ( req, res ) ->
    res.send("Posts#delete ( #{ req.params.id } )")

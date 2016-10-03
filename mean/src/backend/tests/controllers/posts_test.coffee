require '../spec_helper'

Post = null

describe "Posts controller", ->
  before ->
    Post  = @mongoose.model('Post')
    @post =
      title:       "Hello kitties"
      description: "Description"
      author:      "foo"

  describe "GET /posts", ->
    beforeEach ( done ) ->
      Post.create @post, -> done()

    it "Should respond success", ( done ) ->
      @request( @server )
        .get '/posts'
        .expect( 200, done )

    it "Should return a list of posts", ( done )->
      @request( @server )
        .get '/posts'
        .end ( err, res ) =>
          @assert.equal 1, res.body.length
          @assert.equal "Hello kitties", res.body[0].title
          done()

  describe "GET /posts/:id", ->
    it "Should respond success", ( done ) ->
      @request( @server )
        .get '/posts/42'
        .expect( 404, done )

    it "Should return post by id", ( done ) ->
      Post.create @post, ( err, post ) =>
        @request( @server )
          .get "/posts/#{ post.id }"
          .end ( err, res ) =>
            @assert.equal "Hello kitties", res.body.title
            done()

  describe "POST /posts", ->
    it "Should respond success", ( done ) ->
      @request( @server )
        .post '/posts'
        .send( @post )
        .expect( 200, done )

    it "Should save post", ( done ) ->
      @request( @server )
        .post '/posts'
        .send( @post )
        .end ( err, res ) =>
          @assert.equal @post.title, res.body.title
          @assert.equal @post.description, res.body.description
          @assert.equal @post.author, res.body.author
          done()

  describe "PUT /posts/:id", ->
    it "Should respond success", ( done ) ->
      @request( @server )
        .put '/posts/42'
        .expect( 200, done )

    it "should update post", ( done ) ->
      Post.create @post, ( err, post ) =>
        @post.title = "Hi kitties"

        @request( @server )
          .put "/posts/#{ @post.id }"
          .send( @post )
          .end ( err, res ) =>
            @assert.equal @post.title, res.body.title
            done()

  describe "DELETE /posts/42", ->
    it "Should respond success", ( done ) ->
      @request( @server )
        .delete '/posts/42'
        .expect( 200, done )

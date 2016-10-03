app  = require '../main'

beforeEach ( done ) ->
  @request = require 'supertest'
  @server  = app.server
  @mongoose = app.mongoose
  @assert  = require 'assert'
  app.mongoose.connection.db.dropDatabase (err, res) ->
    done()

afterEach ->
  @server.close

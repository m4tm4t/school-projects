mongoose = require 'mongoose'

module.exports = ->
  Post = new mongoose.Schema
    title:       String
    description: String
    file:        String
    author:      String

  return mongoose.model 'Post', Post

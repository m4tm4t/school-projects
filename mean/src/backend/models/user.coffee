mongoose              = require 'mongoose'
uniqueValidator       = require 'mongoose-unique-validator'
passportLocalMongoose = require 'passport-local-mongoose'

module.exports = ->
  User = new mongoose.Schema
    username: String
    password: String
    email:
      type:     String
      unique:   true
      # required: true
    is_admin: Boolean

  opts =
    saltlen:    10
    iterations: 10
    keylen:     10

  User.plugin( passportLocalMongoose, opts )
  User.plugin( uniqueValidator )

  return mongoose.model 'User', User

express  = require 'express'
mongoose = require 'mongoose'
path     = require 'path'

passport      = require  'passport'
localStrategy = require( 'passport-local' ).Strategy
cookieParser  = require 'cookie-parser'
bodyParser    = require 'body-parser'

config   = require './config'

app = express()
mongoose.connect('mongodb://127.0.0.1/mean')

global.models = require './models'


app.use( cookieParser() )

session = require 'express-session'
mongoStore = require('connect-mongo')(session)
store =  new mongoStore
  mongooseConnection: mongoose.connection

app.use session(
  key:    'session'
  secret: 'Kitties will take over the world'
  resave: true
  saveUninitialized: true
  store: store
)
app.use bodyParser.json()
app.use bodyParser.urlencoded(extended: false)

app.use( passport.initialize() )
app.use( passport.session() )

User = global.models.User

# Find or create admin user
User.findOne username: 'admin', ( err, doc ) ->
  unless doc
    User.register( new User( {
      username: "admin",
      email: "admin",
      is_admin: true }
    ), "password", ( err, user ) ->
      unless err
        console.log 'Successfully created admin'
    )

passport.use( new localStrategy( User.authenticate() ) )
passport.serializeUser( User.serializeUser() )
passport.deserializeUser( User.deserializeUser() )

# Little hack because static is a coffeescript reserved word...
foo = "static"
app.use( express[foo](__dirname + '/../public') )

app.get '/', ( req, res ) ->
  res.sendFile( path.join __dirname, '..', 'public/html/views/front.html' )

app.use '/', config.routes

server = app.listen config.env.port, ->
  console.log "Running server on #{ config.env.port }"

module.exports =
  server:   server
  mongoose: mongoose

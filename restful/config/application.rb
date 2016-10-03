require 'rubygems'
require 'bundler/setup'

# Require gems
Bundler.require :default, ENV['RACK_ENV']

# Load environment configuration
Dotenv.load

if ENV['RACK_ENV'] == 'test'
  ENV['DB_NAME'] = ENV['DB_NAME'] + "_test"
end

# Include API classes
Dir[ File.expand_path( "../../api/**/*.rb", __FILE__ ) ].each do |file|
  require file
end

# Include the grape configuration
require File.expand_path( "../api", __FILE__ )

# Database connection
$DB = Sequel.connect(
  adapter:  :mysql2,
  database: ENV['DB_NAME'],
  user:     ENV['DB_USER'],
  password: ENV['DB_PASSWORD']
)

# Include Models
Dir[ "./models/*.rb" ].each do |file|
  require file
end

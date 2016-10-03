require File.expand_path('../config/environment', __FILE__)
require File.expand_path('../config/rack_app', __FILE__)
run Restful::App.new

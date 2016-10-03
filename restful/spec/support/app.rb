module App
  def app
    Restful::API
  end
end

RSpec.configure do |config|
  config.include App
end

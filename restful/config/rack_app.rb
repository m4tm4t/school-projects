module Restful
  class App
    def call( env )
      Restful::API.call( env )
    end
  end
end

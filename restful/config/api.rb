require 'active_support/json'

module PrettyJSON
  def self.call(object, env)
    JSON.pretty_generate(JSON.parse(object.to_json))
  end
end

module Restful
  class API < Grape::API
    format    :json
    formatter :json, PrettyJSON

    rescue_from :all

    # Helpers
    helpers do
      def current_user
        @current_user ||= User.find( email: request.env['REMOTE_USER'] )
      end

      def admin_required!
        unless current_user.role == "admin"
          error!( { status: 403, message: "Unauthorized" }, 403 )
        end
      end
    end

    # Basic Auth
    http_basic do |email,password|
      user = User.find( email: email )
      hashed_password = Digest::SHA1.hexdigest( password )

      if user && user.password == hashed_password
        true
      else
        error!( { status: 401, message: "Authentication failed" }, 401 )
      end
    end

    mount Restful::GetUser
    mount Restful::SearchUsers
    mount Restful::CreateUser
    mount Restful::DeleteUser
    mount Restful::UpdateUser

    add_swagger_documentation mount_path: '/'

    # Return a JSON formatted 404 error if url was not found
    # This configuration should be a the end of this class !!
    route :any, '*path' do
      error!( { message: "not found", status: 404 }, 404 )
    end
  end
end

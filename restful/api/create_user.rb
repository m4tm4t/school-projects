require 'digest'

module Restful
  class CreateUser < Grape::API
    before { admin_required! }

    params do
      requires :email,     type: String
      requires :firstname, type: String
      requires :lastname,  type: String
      requires :password,  type: String
      requires :role,      type: String
    end

    post '/users' do
      # Hash password
      params[ :password ] = Digest::SHA1.hexdigest( params[ :password ] )

      user = User.new( params )

      if user.valid? && user.save
        return { id: user.id }
      elsif user.errors.length
        return user.errors
      else
        return error!("Something went wrong")
      end

    end
  end
end

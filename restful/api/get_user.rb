module Restful
  class GetUser < Grape::API
    get '/users/:id' do

      users = $DB[:user]
      user  = users[ id: params[ :id ] ]

      if user

        if user[ :role ] == "admin" && current_user.role != "admin"
          return error!( { status: 401, message: 'Unauthorized' }, 401 )
        end

        # Remove password from object
        user.delete( :password )

        return user
      else
        return error!( { status: 404, message: 'not found' }, 404 )
      end
    end
  end
end

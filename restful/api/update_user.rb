module Restful
  class UpdateUser < Grape::API
    put '/users/:id' do
      if current_user.role == "admin"
        user = User.find( id: params[ :id ] )

        if !user
          return error!( { status: 404, message: 'not found' }, 404 )
        end

        # Remove id from params
        params.delete( :id )

        user.update(params)

        return { id: user.id }
      else
        return error!( { status: 404, message: 'Unauthorized' }, 401 )
      end

    end
  end
end

module Restful
  class DeleteUser < Grape::API
    delete '/users/:id' do

      if current_user.role == "admin"

        user = User.find(id: params[ :id])

        if !user
          return error!( { status: 404, message: 'not found' }, 404 )
        end

        User.where(:id => params[ :id ]).delete

        return { status: 200, message: "Success" }
      else
        return error!( { status: 401, message: 'Unauthorized' }, 401 )
      end
    end
  end
end

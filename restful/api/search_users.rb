module Restful
  class SearchUsers < Grape::API
    params do
      requires :q, type: String
    end

    get '/search/users' do
      search_term = params[ :q ].downcase
      user_table  = $DB[:user]
      columns     = ( user_table.columns - [:password] ) # Remove password from query

      results = user_table
        .select( *columns )
        .where(
          Sequel.like( :email,     "%#{search_term}%" ) |
          Sequel.like( :firstname, "%#{search_term}%" ) |
          Sequel.like( :lastname,  "%#{search_term}%" )
        )

      unless results.empty?
        return results.to_a
      else
        return error!( { status: 404, message: 'not found' }, 404 )
      end
    end
  end
end

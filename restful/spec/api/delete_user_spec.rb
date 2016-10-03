require 'spec_helper'

describe Restful::DeleteUser do
  context "With admin user" do

    it 'should deleted user' do
      authorize( $admin_user.email, 'pass' )

      random_email = "#{rand(0..424242)}@mail.fr"
      user         = User.create( email: random_email )

      delete "/users/#{user.id}"

      expect( User.find(email: user.email) ).to be_nil
    end
  end

  context "With normal user" do

    it 'should return a 401 code' do

      authorize( $normal_user.email, 'pass' )

      delete '/users/42'
      expect( last_response.status ).to eq( 401 )
      expect( last_response.body ).to have_node( :message ).with( "Unauthorized" )

    end
  end
end

require 'spec_helper'

describe Restful::UpdateUser do

  context "Updating as normal user" do

    it "should return a 401 response" do
      authorize( $normal_user.email, 'pass' )
      put "/users/#{ $normal_user.id }", firstname: "plop"
      expect( last_response.status ).to eq( 401 )
      expect( last_response.body ).to have_node( :message ).with( "Unauthorized" )
    end
  end

  context "Updating as admin user" do

    it "should update the user" do
      authorize( $admin_user.email, 'pass' )

      put "/users/#{ $normal_user.id }",
        firstname: "foo",
        lastname:  "bar"

      expect( last_response.status ).to eq( 200 )
      expect( last_response.body ).to have_node( :id ).with( $normal_user.id )

      get "/users/#{ $normal_user.id }"

      expect( last_response.body ).to have_node( :firstname ).with( "foo" )
      expect( last_response.body ).to have_node( :lastname ).with( "bar" )
    end

  end

end

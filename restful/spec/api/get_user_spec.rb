require 'spec_helper'

describe Restful::GetUser do

    before :each do
      authorize( $normal_user.email, 'pass' )
    end

    context "With existing user" do
      it 'should return a user' do
        get '/users/42'
        expect( last_response.body ).to have_node( :id ).with( 42 )
      end
    end

    context "With unknown id" do
      it "should return a 404 response" do
        get '/users/4242'
        expect( last_response.status ).to eq( 404 )
        expect( last_response.body ).to have_node( :message ).with( "not found" )
      end
    end

    context "When access admin id as normal user" do
      it "should return a 401 response" do
        get "/users/#{ $admin_user.id }"
        expect( last_response.status ).to eq( 401 )
      end
    end

    context "When access admin id as admin user" do
      it 'should return a user' do
        authorize( $admin_user.email, 'pass' )

        get "/users/#{ $admin_user.id }"
        expect( last_response.body ).to have_node( :id ).with( $admin_user.id )
      end
    end
end

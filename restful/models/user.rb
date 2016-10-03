class User < Sequel::Model( :user )
  plugin :validation_helpers

  def validate
    super
    validates_unique :email
  end
end

<?php 
class UserModel extends ApplicationModel
{
  static $tableName = 'users',
         $className = 'UserModel';

  public $passwordConfirmation = null;

  /*
   * Validations
   */
  protected $validations = array(
    'username' => array('presence', 'uniqueness'),
    'email'    => array('presence', 'uniqueness', 'valid_email'),
    'password' => array('presence', 'confirmation')
  );

  public function feeds()
  {
    $results = array();
    $rawQuery = "SELECT * FROM user_feeds WHERE user_id = '".$this->id."'";
    $query = self::$db->query($rawQuery);

    while ($result = $query->fetch(PDO::FETCH_ASSOC))
      $results[] = FeedModel::find($result['feed_id']);

    return $results;
  }

  public function addFeed($feed)
  {
    $rawQ = "SELECT * FROM user_feeds WHERE feed_id = :feed_id AND user_id = :user_id LIMIT 1";
    $query = self::$db->prepare($rawQ);
    $query->execute(array(':feed_id' => $feed->id, ':user_id' => $this->id));

    if (!$query->rowCount()) {
      $userId = $this->id;
      $feedId = $feed->id;
      
      $rawQuery = "INSERT INTO user_feeds (user_id, feed_id) VALUES ('$userId', '$feedId')";
      $query = self::$db->query($rawQuery);
    }
  }

  /*
   * Callbacks
   */
  protected function before_save()
  {
    if ($this->passwordConfirmation)
      $this->password = sha1($this->password);
  }

  /*
   * Static methods
   */
  public static function findAuth($email, $password)
  {
    $rawQuery = "SELECT * FROM users 
                 WHERE email = :email AND password = :password";
    $query = self::$db->prepare($rawQuery);
    $query->bindValue(':email', $email);
    $query->bindValue(':password', SHA1($password));
    $query->execute();

    $auth = $query->fetch(PDO::FETCH_ASSOC);
    if ($auth) {
      $user = new UserModel($auth);
      return $user;
    }
    else {
      return false;
    }
  }
}
?>
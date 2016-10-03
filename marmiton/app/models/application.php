<?php
class ApplicationModel extends DataMapper
{
  static $tableName  = '',
         $primaryKey = 'id',
         $className  = '';

  protected $columns     = array(),
            $validations = array(),
            $errors      = array();

  const FIELD_INVALID = 1;
  const FIELD_TAKEN   = 2;
  const FIELD_EMPTY   = 3;
  const FIELD_CONFIRM = 4;

  /**
   * Build object attributes by using sql attributes
   */
  function __construct($data = array()) {

    $queryString = "SELECT column_name, data_type, character_maximum_length
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE table_name = '".static::$tableName."';";

    $query = self::$db->query($queryString);

    $this->columns = $query->fetchAll( PDO::FETCH_COLUMN );

    foreach ($this->columns as $col)
      $this->$col = isset($data[$col]) ? $data[$col] : NULL;
  }

  public function isValid()
  {
    foreach ($this->validations as $field => $types) {
      foreach ($types as $type) {
        if ($type == 'presence') {
          if (empty($this->$field))
            $this->setError($field, self::FIELD_EMPTY);
        }
        elseif ($type == 'uniqueness') {
          $className = static::$className;
          $find = $className::findBy($field, $this->$field);
          if (count($find) > 0)
            $this->setError($field, self::FIELD_TAKEN);
        }
        elseif ($type == 'confirmation') {
          $confirm = $field.'Confirmation';
          if ($this->$confirm != $this->$field)
            $this->setError($field, self::FIELD_CONFIRM);
        }
        elseif ($type == 'valid_email') {
          $valid = filter_var($this->$field, FILTER_VALIDATE_EMAIL);
          if (!$valid)
            $this->setError($field, self::FIELD_INVALID);
        }
      }
    }

    return(count($this->errors) < 1);
  }

  // Save object
  public function save()
  {
    if ($this->isValid()) {
      $rawQuery   = "";
      $afterQuery = "";

      // Kick ID from columns list
      $columns = $this->columns;
      array_shift($columns);

      // Insert
      if ($this->newRecord()) {
        $rawQuery .= "INSERT INTO ".static::$tableName."(";
        $rawQuery .= join(',', $columns);
        $rawQuery .= ") ";
        $rawQuery .= "VALUES(";
        $rawQuery .= join(',', array_map(function($col) { return ":$col"; }, $columns));
        $rawQuery .= ")";

        $this->created_at = $this->updated_at = date("Y-m-j H:i:s");
      }
      // Update
      else
      {
        $cols = array();
        $rawQuery .= "UPDATE ".static::$tableName." SET ";

        foreach ($columns as $col)
          $cols[] = "$col = :$col";

        $rawQuery .= join(', ', $cols);

        $rawQuery .= " WHERE id = $this->id";

        $this->updated_at = date("Y-m-j H:i:s");
      }

      $query = self::$db->prepare($rawQuery);

      foreach ($columns as $col)
        $query->bindValue(":$col", $this->$col);

      if (is_callable(array($this, 'before_save')))
        $this->before_save();

      $sequenceName = static::$tableName."_id_seq";

      if ($query->execute()) {
        if ($this->newRecord())
          $this->id = self::$db->lastInsertId($sequenceName);
        return true;
      }
      else
        return false;
    }
    else
      return false;
  }

  public function destroy()
  {
    $rawQuery = "DELETE FROM ".static::$tableName." WHERE id = :id;";
    $query    = self::$db->prepare( $rawQuery );
    return $query->execute(array(':id' => $this->id));
  }

  // Dynamic setter
  public function __set($property, $value)
  {
    $this->$property = $value;
  }

  // Dynamic getter
  public function __get($property)
  {
    return $this->$property;
  }

  // Check if object is a new record
  public function newRecord()
  {
    return $this->id === NULL;
  }

  // Set errors
  public function setError($field, $type)
  {
    if ($type == self::FIELD_INVALID)
      $msg = 'est invalide';
    else if ($type == self::FIELD_EMPTY)
      $msg = 'doit être rempli(e)';
    else if ($type == self::FIELD_TAKEN)
      $msg = "n'est pas disponible";
    else if ($type == self::FIELD_CONFIRM)
      $msg = "ne concorde pas avec la confirmation";

    $this->errors[$field][] = $msg;
  }

  /*
   * Static functions
   */
  public static function getAll() {
    $results = array();
    $rawQuery = "SELECT * FROM ".static::$tableName." ORDER BY id DESC";
    $query = self::$db->query($rawQuery);

    if ($query)
      while ($result = $query->fetch(PDO::FETCH_ASSOC))
        $results[] = new static::$className($result);
    return $results;
  }

  public static function find( $attributes )
  {
    if (!is_array($attributes))
      $attributes = array("id" => (int)$attributes);

    $conditions = [];
    $rawQuery = "SELECT * FROM ".static::$tableName." WHERE ";
    foreach ( $attributes as $key => $value )
      $conditions[] = "$key = :$key";

    $rawQuery .= join(' AND ', $conditions);

    $rawQuery .= " LIMIT 1";

    // if (array$attributes["id"])
    //   var_dump($rawQuery);

    $query = self::$db->prepare($rawQuery);

    foreach ( $attributes as $key => $value )
      $query->bindValue(":$key", $value);

    $results = array();
    if ($query->execute())
      $result = $query->fetch(PDO::FETCH_ASSOC);
    return new static::$className($result);
  }

  public static function findBy($field, $value)
  {
    $rawQuery = "SELECT * FROM ".static::$tableName." WHERE $field = :value";
    $query = self::$db->prepare($rawQuery);
    $query->bindValue(':value', $value);
    $results = array();

    if ($query->execute()) {
      while ($result = $query->fetch(PDO::FETCH_ASSOC))
        $results[] = new static::$className($result);
    }

    return $results;
  }

  public static function findOrCreate( $attributes = array() )
  {
    $rawQuery = "SELECT * FROM ".static::$tableName." WHERE ";
    $conditions = [];

    foreach ( $attributes as $key => $value )
      $conditions[] = "$key = :$key";


    $rawQuery .= join(' AND ', $conditions);

    $rawQuery .= " LIMIT 1";

    $query = self::$db->prepare($rawQuery);

    foreach ( $attributes as $key => $value )
      $query->bindValue(":$key", $value);

    $results = array();
    if ($query->execute()) {
      while ($result = $query->fetch(PDO::FETCH_ASSOC))
        $results[] = new static::$className($result);
    }

    // Check if exists
    if (count($results) == 0) {
      $item = new static::$className($attributes);
      if ($item->save())
      {
        return $item;
      }
    }
    else
      return $results[0];
  }

}


?>

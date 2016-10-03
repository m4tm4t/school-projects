<?php
class IngredientModel extends ApplicationModel
{
  static $tableName = 'ingredients',
         $className = 'IngredientModel';


  /**
   * ingredients()
   * @return a list of ingredients
   */
  public function ingredients()
  {
  }

  public static function search($term)
  {
    $rawQuery = "SELECT * FROM ingredients WHERE UNACCENT(name) ILIKE UNACCENT(:term)";


    $query = self::$db->prepare( $rawQuery );
    $query->execute(array(':term' => "%$term%"));

    $results = [];
    while ( $result = $query->fetch( PDO::FETCH_ASSOC ) )
      $results[] = new static::$className($result);

    // Return term term search then create it client side
    if ( count($results) == 0 )
      $results[] = new IngredientModel(array('name' => $term));

    return $results;
  }
}

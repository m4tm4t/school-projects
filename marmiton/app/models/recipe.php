<?php

class RecipeModel extends ApplicationModel
{
  static $tableName = 'recipes',
         $className = 'RecipeModel';

   public static function search($term)
   {
     $rawQuery = "SELECT * FROM recipes WHERE UNACCENT(name) ILIKE UNACCENT(:term)";


     $query = self::$db->prepare( $rawQuery );
     $query->execute(array(':term' => "%$term%"));

     $results = [];
     while ( $result = $query->fetch( PDO::FETCH_ASSOC ) )
       $results[] = new static::$className($result);

     return $results;
   }

  public static function findForExisting($ingredientIds, $all=false)
  {
    $nullCount = 0;
    $percentage = 0;

    foreach ($ingredientIds as $ing ) {
      if ($ing === null)
        $nullCount++;
    }

    if (!$all && count(array_filter($ingredientIds)) <= 1) {
      return false;
    }
    $ingredients = join(',', array_filter($ingredientIds));

    $rawQuery = "SELECT
        recipe_id,
        count(ingredient_id) AS similar_count,
        ( SELECT COUNT(*) FROM recipe_ingredients WHERE recipe_id = t.recipe_id ) AS total_count
      FROM recipe_ingredients AS t
      WHERE t.ingredient_id IN ($ingredients)
      GROUP BY t.recipe_id";

    $query = self::$db->query( $rawQuery );

    $results = [];

    while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
      if ($all) {
        $results[] = RecipeModel::find($result['recipe_id']);
      }
      else {
        $percentage = ($result['similar_count'] / (count($ingredientIds)+$nullCount) )*100;
        if ( $percentage >= 80 )
          return RecipeModel::find($result['recipe_id']);
      }
    }
    if ($all)
      return $results;
    else
      return false;
  }

  public function getIngredients()
  {
    $rawQuery = "SELECT * FROM recipe_ingredients WHERE recipe_id = :recipe_id";
    $query = self::$db->prepare( $rawQuery );
    $query->execute( array(':recipe_id' => $this->id) );

    $results = array();
    while ( $result = $query->fetch( PDO::FETCH_ASSOC ))
    {
      $ing = new RecipeIngredientModel($result);
      $results[] = $ing;
    }

    return $results;
  }

  public function getComments()
  {
    $rawQuery = "SELECT * FROM comments WHERE recipe_id = :recipe_id";
    $query = self::$db->prepare( $rawQuery );
    $query->execute( array(':recipe_id' => $this->id) );

    $results = array();
    while ( $result = $query->fetch( PDO::FETCH_ASSOC ))
    {
      $ing = new CommentModel($result);
      $results[] = $ing;
    }

    return $results;
  }
  public function getSteps()
  {
    $rawQuery = "SELECT * FROM steps WHERE recipe_id = :recipe_id";
    $query = self::$db->prepare( $rawQuery );
    $query->execute( array(':recipe_id' => $this->id) );

    $results = array();
    while ( $result = $query->fetch( PDO::FETCH_ASSOC ))
    {
      $step = new StepModel($result);
      $results[] = $step;
    }

    return $results;
  }

  public function findIngredient($ingredients, $id)
  {
    array_search($id, $ingredients);
  }

  public function setIngredients( $ingredients = array() )
  {
    $ingredientIds = array_map( function($ingredient) {
      return $ingredient->ingredient_id;
    }, $ingredients);

    // First retrieve current ingredient and compare with provided array
    // If don't exist, create it
    // If exist in db but not present in array, delete it
    // Else, do nothing
    $currentIngredientsIds = $this->getIngredients();

    if ( count($currentIngredientsIds) == 0 ) {
      foreach ($ingredientIds as $ingredientId)
      {
        $ing = $this->findIngredient( $ingredients, $ingredientId);
        var_dump($ing);
        $this->addIngredient($ingredientId);
      }
      return;
    }


    $additions = array_diff( $ingredientIds, $currentIngredientsIds );
    $deletions = array_diff( $currentIngredientsIds, $ingredientIds );

    // Insert
    foreach ($additions as $ingredientId)
      $this->addIngredient($ingredientId);

    // Delete
    foreach ($deletions as $ingredientId)
      $this->deleteIngredient($ingredientId);
  }

  public function addIngredient($ri)
  {
    // var_dump($ri);
    $rawQuery = "INSERT INTO recipe_ingredients(recipe_id,ingredient_id, unit_type, unit, unit_value)";
    $rawQuery .= "VALUES($this->id, $ri->ingredient_id, $ri->unit_type->unit_type, $ri->unit_type->unit, $ri->unit_type->value);";
    $query    = self::$db->query($rawQuery);
  }

  public function deleteIngredient($ingredientId)
  {
    $rawQuery = "DELETE FROM recipe_ingredients WHERE recipe_id = :recipe_id AND ingredient_id = :ingredient_id";
    $query    = self::$db->prepare( $rawQuery );

    $query->execute(array(
      ':recipe_id'     => $this->id,
      ':ingredient_id' => $ingredientId
    ));
  }
}

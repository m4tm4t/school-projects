<?php
class Recipe_ingredientsController extends ApplicationController
{
  public function index()
  {
    $recipe = RecipeModel::find(array('id' => $this->params["recipe_id"] ));
    $this->addVar( 'json', $recipe->getIngredients() );
  }

  public function show( $params )
  {
    $ingredient = RecipeIngredientModel::find(array(
      'recipe_id'     => $params['recipeId'],
      'ingredient_id' => $params['ingredientId']
    ));
    $this->addVar( 'json', $ingredient );
  }

  public function create()
  {
    $ingredient = RecipeIngredientModel::findOrCreate(
      array( 'name' => $this->data->name )
    );

    if ($ingredient->newRecord())
      $ingredient->save();

    $this->addVar( 'json', $ingredient );
  }

  public function search( $params )
  {
    $ingredients = RecipeIngredientModel::search( urldecode($params['term']) );
    $this->addVar( 'json', $ingredients );
  }

}

<?php
class IngredientsController extends ApplicationController
{
  public function index()
  {
    $ingredients = IngredientModel::getAll();
    $this->addVar( 'json', $ingredients );
  }

  public function show( $params )
  {
    $ingredient = IngredientModel::find( $params['id'] );
    $this->addVar( 'json', $ingredient );
  }

  public function create()
  {
    $ingredient = IngredientModel::findOrCreate(
      array( 'name' => $this->data->name )
    );

    if ($ingredient->newRecord())
      $ingredient->save();

    $this->addVar( 'json', $ingredient );
  }

  public function search( $params )
  {
    $ingredients = IngredientModel::search( urldecode($params['term']) );
    $this->addVar( 'json', $ingredients );
  }

}

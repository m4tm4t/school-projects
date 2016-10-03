<?php
class RecipesController extends ApplicationController
{

  public function search( $params )
  {
    $recipes = RecipeModel::search( $params['term'] );
    $this->addVar('json', $recipes);
  }

  public function search2( $params )
  {
    $ingredientIds = split(",", $params["term"]);
    $results = RecipeModel::findForExisting( $ingredientIds, true );
    $this->addVar( 'json', $results );
  }

  public function index()
  {
    $recipes = RecipeModel::getAll();

    foreach ( $recipes as $recipe )
      $recipe->ingredients = [ 1, 2 ];

    $this->addVar( 'json', $recipes );
  }

  public function show( $params )
  {
    $recipe = RecipeModel::find($params["id"]);
    $recipe_ingredients = $recipe->getIngredients();
    $recipe->comments = $recipe->getComments();

    foreach ($recipe_ingredients as $ri)
      $ri->ingredient = IngredientModel::find( $ri->ingredient_id );

    $recipe->recipe_ingredients = $recipe_ingredients;
    $recipe->steps = $recipe->getSteps();

    $this->addVar( 'json', $recipe );
  }

  public function check_exists( $params )
  {
    $ingredientIds = array_map(function($ing) {
      return $ing->ingredient_id;
    }, $this->data->recipe_ingredients );

    $result = RecipeModel::findForExisting( $ingredientIds );
    $this->addVar( 'json', array('result' => $result) );
  }


  public function create()
  {
    // Test if exist
    $ingredientIds = array_map(function($ing) {
      return $ing->ingredient_id;
    }, $this->data->recipe_ingredients );
    $result = RecipeModel::findForExisting( $ingredientIds );

    if ($result)
    {
      $this->addVar('json', array('result' => false));
      return false;
    }

    $recipe = new RecipeModel;
    $recipe->name        = $this->data->name;
    $recipe->description = $this->data->description;
    $recipe->username    = $this->data->username;
    $recipe->email       = $this->data->email;
    $recipe->category_id = $this->data->category_id;

    if ($recipe->save()) {
      if (isset($this->data->steps)) {

        foreach ($this->data->steps as $step) {
          $dbStep = StepModel::findOrCreate(array(
            'recipe_id' => $recipe->id
          ));

          $dbStep->title = $step->title;
          $dbStep->body = $step->body;

          $dbStep->save();
        }

      }

      if (isset($this->data->recipe_ingredients)) {
        $recipeIngredients = [];

        foreach ($this->data->recipe_ingredients as $ri) {
          $unitType = $ri->unit_type;
          $unitVal  = $ri->unit_value;
          if (isset($ri->unit)) {
            $unit = $ri->unit;
          } else {
            $unit = null;
          }

          // Find or create ingredient
          $ingredient = IngredientModel::findOrCreate(array(
            'name' => $ri->ingredient->name
          ));

          $dbRi = RecipeIngredientModel::findOrCreate(array(
            'recipe_id'     => $recipe->id,
            'ingredient_id' => $ingredient->id
          ));
          $dbRi->unit_type  = $unitType;
          $dbRi->unit_value = $unitVal;
          $dbRi->unit       = $unit;
          $dbRi->save();
        }
      }

      $this->addVar( 'json', $recipe );
    }
  }

  public function update( $params )
  {
    $recipe = RecipeModel::find( $params["id"] );

    $recipe->name        = $this->data->name;
    $recipe->description = $this->data->description;
    $recipe->username    = $this->data->username;
    $recipe->email       = $this->data->email;
    $recipe->category_id       = $this->data->category_id;

    if ($recipe->save())
    {
      if (isset($this->data->image)) {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $this->data->image));
        $filePath = $_SERVER['DOCUMENT_ROOT'] . "/recipe-$recipe->id.jpg";
        $file = fopen($filePath, 'w');
        fwrite($file, $data);
        fclose($file);
      }

      if (isset($this->data->steps)) {

        foreach ($this->data->steps as $step) {

          if (isset($step->id)) {
            $dbStep = StepModel::find(array(
              'id'        => $step->id,
              'recipe_id' => $recipe->id
            ));
          }
          else {
            $dbStep = new StepModel(array(
              'recipe_id' => $recipe->id
            ));
          }


          $dbStep->title = $step->title;
          $dbStep->body = $step->body;
          // $dbStep->duration = $step->duration;

          $dbStep->save();
        }

      }

      if (isset($this->data->recipe_ingredients)) {
        $recipeIngredients = [];

        foreach ($this->data->recipe_ingredients as $ri) {
          $unitType = $ri->unit_type;
          $unitVal  = $ri->unit_value;
          if (isset($ri->unit)) {
            $unit = $ri->unit;
          } else {
            $unit = null;
          }

          if ($ri->ingredient_id) {
            $ingredient = IngredientModel::find($ri->ingredient_id);
          }
          else {
            $ingredient = IngredientModel::findOrCreate(array(
              'name' => $ri->ingredient->name
            ));
          }
          // Find or create ingredient
          if ($ingredient->newRecord())
            $ingredient->save();

          $dbRi = RecipeIngredientModel::findOrCreate(array(
            'recipe_id'     => $recipe->id,
            'ingredient_id' => $ingredient->id
          ));
          $dbRi->unit_type  = $unitType;
          $dbRi->unit_value = $unitVal;
          $dbRi->unit       = $unit;
          $dbRi->save();
        }
      }
    }
    $this->addVar( 'json', $recipe );
  }

  public function destroy( $params )
  {
    $recipe = RecipeModel::find( $params["id"] );
    $recipe->destroy();
  }
}

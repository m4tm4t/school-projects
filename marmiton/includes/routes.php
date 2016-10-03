<?php
$router = new Router;

// Main page
$router->get('/', function() { routeTo('home', 'index'); });

// Categories
$router->get('/categories', function() { routeTo('categories', 'index'); });

// comments
$router->post('/comments', function() { routeTo('comments', 'create'); });


// Recipes
$router->get('/recipes', function() { routeTo('recipes', 'index'); });
$router->post('/recipes', function() { routeTo('recipes', 'create'); });
$router->post('/recipes/check_exists', function() { routeTo('recipes', 'check_exists'); });
$router->get('/recipes/(\d+)', function( $id ) {
  routeTo( 'recipes', 'show', array( 'id' => $id ) );
});
$router->put('/recipes/(\d+)', function( $id ) {
  routeTo( 'recipes', 'update', array( 'id' => $id ) );
});
$router->delete('/recipes/(\d+)', function( $id ) {
  routeTo( 'recipes', 'destroy', array( 'id' => $id ) );
});
$router->get('/recipes/search/(.+)', function( $term ) {
  routeTo( 'recipes', 'search', array( 'term' => $term ) );
});
$router->get('/recipes/search2/(.+)', function( $term ) {
  routeTo( 'recipes', 'search2', array( 'term' => $term ) );
});

// RecipeIngredients
$router->get('/recipe_ingredients', function() { routeTo('recipe_ingredients', 'index'); });
$router->post('/recipes/(\d+)/ingredient', function() { routeTo('recipe_ingredients', 'create'); });
$router->get('/recipes/(\d+)/ingredient/(\d+)', function( $recipeId, $ingredientId ) {
  routeTo( 'recipe_ingredients', 'show', array( 'recipeId' => $recipeId, 'ingredientId' => $ingredientId ) );
});
$router->put('/recipes/(\d+)/ingredient/(\d+)', function( $recipeId, $ingredientId ) {
  routeTo( 'recipe_ingredients', 'update', array( 'recipeId' => $recipeId, 'ingredientId' => $ingredientId ) );
});
$router->delete('/recipes/(\d+)/ingredient/(\d+)', function( $recipeId, $ingredientId ) {
  routeTo( 'recipe_ingredients', 'destroy', array( 'recipeId' => $recipeId, 'ingredientId' => $ingredientId ) );
});

// Ingredients
$router->get('/ingredients', function() { routeTo('ingredients', 'index'); });
$router->post('/ingredients', function() { routeTo('ingredients', 'create'); });
$router->get('/ingredients/search/(.+)', function( $term ) {
  routeTo( 'ingredients', 'search', array( 'term' => $term ) );
});

$router->get('/ingredients/(\d+)', function( $id ) {
  routeTo( 'ingredients', 'show', array( 'id' => $id ) );
});
$router->put('/ingredients/(\d+)', function( $id ) {
  routeTo( 'ingredients', 'show', array( 'id' => $id ) );
});

// 404
$router->set404(function() {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
  echo '404, route not found !';
});

$router->run();

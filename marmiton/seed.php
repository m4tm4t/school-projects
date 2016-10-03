<?php
// Seed ingredients
ini_set('display_errors', 1);
ini_set('date.timezone', 'UTC');

define('ROOT_PATH', __DIR__);

require 'includes/bootstrap.php';

// Seed ingredients
$ingredients = json_decode(file_get_contents('ingredients.json'));
foreach ($ingredients as $ingredient) {
  IngredientModel::findOrCreate(array(
    'name' => $ingredient
  ));
}

// Seed categories
$categories = array(
  'Entrée',
  'Plat principal',
  'Dessert'
);
foreach ($categories as $category) {
  CategoryModel::findOrCreate(array(
    'name' => $category
  ));
}

DELETE FROM recipes;
DELETE FROM ingredients;
DELETE FROM recipe_ingredients;

INSERT INTO recipes VALUES (42, 'foo','bar');

INSERT INTO ingredients VALUES (1, 'hello');
INSERT INTO ingredients VALUES (2, 'world');

INSERT INTO recipe_ingredients VALUES (42, 2);
INSERT INTO recipe_ingredients VALUES (42, 1);

-- LEFT JOIN recipe_ingredients ON recipes.id = recipe_ingredients.recipe_id
-- SELECT ingredients.id, ingredients.name FROM recipes
--   LEFT JOIN recipe_ingredients ON recipe_ingredients.recipe_id     = recipes.id
--   LEFT JOIN ingredients        ON recipe_ingredients.ingredient_id = ingredients.id

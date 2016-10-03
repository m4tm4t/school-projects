--
-- Extensions
--
CREATE EXTENSION IF NOT EXISTS unaccent;

--
-- users
--
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id         SERIAL PRIMARY KEY,
  username   varchar(255) NOT NULL,
  email      varchar(255) NOT NULL,
  password   varchar(255) NOT NULL,
  created_at timestamp(0) NOT NULL,
  updated_at timestamp(0) NOT NULL
);

--
-- recipes
--
DROP TABLE IF EXISTS recipes;
CREATE TABLE recipes (
  id          SERIAL PRIMARY KEY,
  name        varchar(255) NOT NULL,
  username    varchar(255),
  email       varchar(255),
  description text,
  category_id integer NOT NULL,
  created_at  timestamp(0) NOT NULL,
  updated_at  timestamp(0) NOT NULL
);

--
-- ingredients
--
DROP TABLE IF EXISTS ingredients;
CREATE TABLE ingredients (
  id         SERIAL PRIMARY KEY,
  name       varchar(255) NOT NULL,
  created_at timestamp(0) NOT NULL,
  updated_at timestamp(0) NOT NULL
);

--
-- comments
--
DROP TABLE IF EXISTS comments;
CREATE TABLE comments (
  id         SERIAL PRIMARY KEY,
  recipe_id  integer      NOT NULL,
  note       integer      NOT NULL,
  username   varchar(255) NOT NULL,
  body       text         NOT NULL,
  created_at timestamp(0) NOT NULL,
  updated_at timestamp(0) NOT NULL
);
CREATE INDEX index_recipe_id_on_comments ON comments(recipe_id);

--
-- recipe_ingredients join table
--
DROP TABLE IF EXISTS recipe_ingredients;
CREATE TABLE recipe_ingredients (
  id            SERIAL,
  recipe_id     integer NOT NULL,
  ingredient_id integer NOT NULL,
  unit_type     integer,
  unit          integer,
  unit_value    varchar(255),
  CONSTRAINT recipe_ingredients_pkey PRIMARY KEY ( recipe_id, ingredient_id )
);
CREATE INDEX index_recipe_id_ingredient_id ON recipe_ingredients(recipe_id, ingredient_id);

--
-- steps
--
DROP TABLE IF EXISTS steps;
CREATE TABLE steps (
  id         SERIAL PRIMARY KEY,
  recipe_id  integer NOT NULL,
  title      varchar(255),
  body       text,
  duration   integer,
  created_at timestamp(0) NOT NULL,
  updated_at timestamp(0) NOT NULL
);
CREATE INDEX index_recipe_id ON steps(recipe_id);

--
-- categories
--
DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  id         SERIAL PRIMARY KEY,
  name       varchar(255),
  created_at timestamp(0) NOT NULL,
  updated_at timestamp(0) NOT NULL
);

--
-- tags
--
DROP TABLE IF EXISTS tags;
CREATE TABLE tags (
  id         SERIAL PRIMARY KEY,
  name       varchar(255),
  created_at timestamp(0) NOT NULL,
  updated_at timestamp(0) NOT NULL
);

--
-- recipe_tags
--
DROP TABLE IF EXISTS recipe_tags;
CREATE TABLE recipe_tags (
  id         SERIAL,
  name       varchar(255),
  recipe_id  integer NOT NULL,
  tag_id     integer NOT NULL,
  created_at timestamp(0) NOT NULL,
  updated_at timestamp(0) NOT NULL,
  CONSTRAINT recipe_tags_pkey PRIMARY KEY ( recipe_id, tag_id )
);
CREATE INDEX index_recipe_id_tag_id ON recipe_tags(recipe_id, tag_id);

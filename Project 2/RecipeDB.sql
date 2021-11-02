DROP DATABASE IF EXISTS RecipeDB;

CREATE DATABASE RecipeDB;
USE RecipeDB;

DROP TABLE IF EXISTS mega_recipe;
CREATE TABLE IF NOT EXISTS mega_recipe(
	recipeID					INT	UNIQUE,
    recipe_name					VARCHAR(100),
    authorID					INT UNIQUE,
    author_name					VARCHAR(50),
    cook_time					VARCHAR(10),
    prep_time					VARCHAR(10),
    total_time					VARCHAR(10),
    date_published				DATETIME,
    recipe_description			VARCHAR(400),
    image_url					VARCHAR(100),
    recipe_category				VARCHAR(20),
    keywords					VARCHAR(400),
    recipe_ingredient_quantity	VARCHAR(400),
    recipe_ingredient_parts		VARCHAR(400),
    aggregated_rating			DECIMAL(10, 2),
    review_count				INT,
    calories					DECIMAL(10, 2),
    fat_content					DECIMAL(10, 2),
    saturated_fat				DECIMAL(10, 2),
    cholesterol					DECIMAL(10, 2),
    sodium						DECIMAL(10, 2),
    carbohydrate				DECIMAL(10, 2),
    fiber						DECIMAL(10, 2),
    sugar						DECIMAL(10, 2),
    protein						DECIMAL(10, 2),
    recipe_servings				INT,
    recipe_yield				VARCHAR(200),
    recipe_instructions			VARCHAR(5000),
	PRIMARY KEY(recipeID)
) ENGINE = INNODB;


LOAD DATA LOCAL INFILE '/Users/austin/Downloads/recipes.csv'
INTO TABLE mega_recipe
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;


SELECT *
FROM mega_recipe;

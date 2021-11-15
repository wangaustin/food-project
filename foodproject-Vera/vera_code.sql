-- Project 2 Databse code
-- Food.com dataset
-- Name: Austin Wang, Mengyu Yang

DROP DATABASE IF EXISTS RecipeDB;
CREATE DATABASE IF NOT EXISTS RecipeDB;

USE RecipeDB;

-- create the recipe megatable for recipes.csv
DROP TABLE IF EXISTS recipe_mega;
CREATE TABLE IF NOT EXISTS recipe_mega(
	recipe_id					INT,
    recipe_name					VARCHAR(100),
    author_id					INT,
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
    recipe_instructions			VARCHAR(5000)
) ENGINE = INNODB;

-- load data into recipe_mega
LOAD DATA INFILE 'recipes.csv'
INTO TABLE recipe_mega
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;

-- delete invalid rows from the recipe_mega table 
SET SQL_SAFE_UPDATES = 0;
DELETE FROM recipe_mega
WHERE recipe_id = 0;
SET SQL_SAFE_UPDATES = 1;

-- create the review megatable for reviews.csv
DROP TABLE IF EXISTS review_mega;
CREATE TABLE IF NOT EXISTS review_mega (
	review_id INT,
    recipe_id INT,
    author_id INT,
    author_name VARCHAR(50),
    rating TINYINT,
    review VARCHAR(1000),
    date_submitted DATETIME,
    date_modified DATETIME
) ENGINE = INNODB;

-- load data into review_mega
LOAD DATA INFILE 'reviews.csv' 
INTO TABLE review_mega
FIELDS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
IGNORE 1 LINES;

-- first 100 rows of recipe_mega
SELECT *
FROM recipe_mega
LIMIT 100;

-- first 100 rows of review_mega
SELECT *
FROM review_mega
LIMIT 100;

-- modify a problematic instance in recipe_mega where the same author has two names
SET SQL_SAFE_UPDATES = 0;
UPDATE recipe_mega
SET author_name = 'Bokenpop aka Madele'
WHERE author_name LIKE 'Bokenpop aka Mad%';
SET SQL_SAFE_UPDATES = 1;

-- delete reviews on nonexistent recipes
SET SQL_SAFE_UPDATES = 0;
DELETE FROM review_mega
WHERE recipe_id IN (194165, 371545, 424301, 432898);
SET SQL_SAFE_UPDATES = 1;

-- create author subtable that contains info about recipe and review authors
DROP TABLE IF EXISTS author;
CREATE TABLE IF NOT EXISTS author (
	author_id INT AUTO_INCREMENT,
    author_name VARCHAR(50),
    PRIMARY KEY(author_id)
) ENGINE = INNODB;

-- create recipe subtable
DROP TABLE IF EXISTS recipe;
CREATE TABLE IF NOT EXISTS recipe (
	recipe_id					INT AUTO_INCREMENT,
    recipe_name					VARCHAR(100) NOT NULL,  -- a recipe must be provided with a name
    author_id					INT NOT NULL,  -- author_id must be provided
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
    PRIMARY KEY(recipe_id),
    CONSTRAINT recipe_author_fk FOREIGN KEY(author_id)
		REFERENCES author(author_id)
) ENGINE = INNODB;

-- create review subtable
DROP TABLE IF EXISTS review;
CREATE TABLE IF NOT EXISTS review (
	review_id INT AUTO_INCREMENT,
    recipe_id INT NOT NULL,  -- not null because review must be made on existing recipes
    author_id INT NOT NULL,  -- author_id must be provided
    rating TINYINT,
    review VARCHAR(1000),
    date_submitted DATETIME,
    date_modified DATETIME,
    PRIMARY KEY(review_id),
    CONSTRAINT review_recipe_fk FOREIGN KEY(recipe_id)
		REFERENCES recipe(recipe_id),
    CONSTRAINT review_author_fk FOREIGN KEY(author_id)
		REFERENCES author(author_id)
) ENGINE = INNODB;

-- populate the author table from recipe_mega
INSERT INTO author
	SELECT DISTINCT author_id, author_name
    FROM recipe_mega;
    
-- populate the author table from review_mega
INSERT INTO author
	SELECT DISTINCT author_id, author_name
    FROM review_mega
    WHERE author_id NOT IN
		(SELECT author_id
         FROM recipe_mega);
    
-- populate the recipe table
INSERT INTO recipe 
	SELECT DISTINCT recipe_id, recipe_name, author_id, cook_time, prep_time,
					total_time, date_published, recipe_description, image_url, 
                    recipe_category, keywords, recipe_ingredient_quantity, 
                    recipe_ingredient_parts, aggregated_rating, review_count,
                    calories, fat_content, saturated_fat, cholesterol, sodium, 
                    carbohydrate, fiber, sugar, protein, recipe_servings, 
                    recipe_yield, recipe_instructions
	FROM recipe_mega;
    
-- populate the review table
INSERT INTO review
	SELECT DISTINCT review_id, recipe_id, author_id, rating, review, date_submitted,
					date_modified
	FROM review_mega;
   
-- cardinalities of tables
SELECT COUNT(*) FROM recipedb.recipe AS count_recipe; -- 522517
SELECT COUNT(*) FROM recipedb.review AS count_review; -- 1401860
SELECT COUNT(*) FROM recipedb.author AS count_author; -- 299880

--
    


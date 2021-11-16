USE recipedb;

-- stored procedure that shows adds an author to the database
DROP PROCEDURE IF EXISTS add_author;
DELIMITER //
CREATE PROCEDURE add_author(IN author_name_in VARCHAR(50))
BEGIN

DECLARE authorID INT;
DECLARE author_id_str VARCHAR(50);

INSERT INTO author(author_name)
VALUES (author_name_in);

SET authorID = 
	(SELECT MAX(author_id)
	 FROM author);

SET author_id_str = CAST(authorID AS CHAR(50));
     
SELECT CONCAT("Author successfully added. Your userid is ", author_id_str) AS message;

END//
DELIMITER ;


-- trigger that truncates the new author name to 50 characters before insert
DROP TRIGGER IF EXISTS author_before_insert
DELIMITER //
CREATE TRIGGER author_before_insert
BEFORE INSERT
ON author
FOR EACH ROW
BEGIN
IF LENGTH(NEW.author_name) > 50 THEN
	SET NEW.author_name = CONVERT(New.author_name, CHAR(50));
END IF;

END //
DELIMITER ;

CALL add_author('Vera'); -- 2002901951
SELECT * FROM author ORDER BY author_id DESC;
DELETE FROM author WHERE author_id = 2002901949;


-- transaction and stored procedure that add a recipe to the database
-- default values will be passed in front-end code
DROP PROCEDURE IF EXISTS add_recipe;
DELIMITER //
CREATE PROCEDURE add_recipe(IN recipe_name_in VARCHAR(50),  -- NOT NULL
						   IN author_id_in INT,  -- NOT NULL
                           IN cook_time_in VARCHAR(10), 
                           IN prep_time_in VARCHAR(10),					
                           IN total_time_in VARCHAR(10), 
                           -- date_published_in, this attribute does not need user input
                           IN recipe_description_in VARCHAR(400), -- NOT NULL
                           IN image_url_in VARCHAR(1000), 
						   IN recipe_category_in VARCHAR(20), 
                           IN keywords_in VARCHAR(1000), 
                           IN recipe_ingredient_quantity_in VARCHAR(1000), 
						   IN recipe_ingredient_parts_in VARCHAR(1000), 
                           -- aggregated_rating, this attribute does not need user input
                           -- review_count, this attribute does not need user input
						   IN calories_in DECIMAL(10, 2), 
                           IN fat_content_in DECIMAL(10, 2), 
                           IN saturated_fat_in DECIMAL(10, 2), 
                           IN cholesterol_in DECIMAL(10, 2), 
                           IN sodium_in DECIMAL(10, 2), 
						   IN carbohydrate_in DECIMAL(10, 2), 
                           IN fiber_in DECIMAL(10, 2), 
                           IN sugar_in DECIMAL(10, 2), 
                           IN protein_in DECIMAL(10, 2), 
                           IN recipe_servings_in INT, 
						   IN recipe_yield_in VARCHAR(200), 
                           IN recipe_instructions_in VARCHAR(5000))
BEGIN

	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;
	-- START TRANSACTION;

	INSERT INTO recipe(recipe_name, author_id, cook_time, prep_time,
						total_time, date_published, recipe_description, image_url, 
						recipe_category, keywords, recipe_ingredient_quantity, 
						recipe_ingredient_parts, aggregated_rating, review_count, 
                        calories, fat_content, saturated_fat, 
						cholesterol, sodium, carbohydrate, fiber, sugar, protein, 
						recipe_servings, recipe_yield, recipe_instructions)
	VALUES (recipe_name_in, author_id_in, cook_time_in, prep_time_in,
			total_time_in, CONVERT(NOW(), DATETIME), recipe_description_in, image_url_in, 
			recipe_category_in, keywords_in, recipe_ingredient_quantity_in, 
			recipe_ingredient_parts_in, 0.0, 0, calories_in, fat_content_in, saturated_fat_in, 
			cholesterol_in, sodium_in, carbohydrate_in, fiber_in, sugar_in, protein_in, 
			recipe_servings_in, recipe_yield_in, recipe_instructions_in);
	
	IF sql_error = FALSE THEN
	-- COMMIT;
	SELECT 'Recipe successfully added!';
	ELSE 
	-- ROLLBACK;
	SELECT 'Recipe not added. Please check the info you entered. ';
	END IF;

END//
DELIMITER ;


SELECT aggregated_rating FROM recipe LIMIT 100;
SELECT CONVERT(NOW(), DATETIME) FROM recipe LIMIT 10;

-- Sample call to add_recipe
CALL add_recipe ('Xiaomianbao', 2002901951, '', '', '', 'Feichang Haochi de Xiaomianbao', 
				 '', '', '', '', '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 1, '', '');
                 
SELECT recipe_id, recipe_name, author_id FROM recipe ORDER BY recipe_id DESC;
SELECT *, COUNT(*) FROM recipe WHERE recipe_name = 'Xiaomianbao';
DELETE FROM recipe WHERE recipe_name = 'Xiaomianbao';


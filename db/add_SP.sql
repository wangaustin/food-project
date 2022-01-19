USE recipedb;

-- stored procedure that adds an author to the database
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
     
SELECT CONCAT("Author successfully added. Your user ID is ", author_id_str, '.') AS message;

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

-- -- Sample calls to add_author and queries for testing
-- CALL add_author('Vera');
-- CALL add_author('Austin');
-- SELECT * FROM author ORDER BY author_id DESC;
-- DELETE FROM author WHERE author_id = 2002901949;


-- stored procedure that adds a recipe to the database
DROP PROCEDURE IF EXISTS add_recipe;
DELIMITER //
CREATE PROCEDURE add_recipe(IN recipe_name_in VARCHAR(50),  -- NOT NULL
						   IN author_id_in INT,  -- NOT NULL fk
                           IN cook_time_in VARCHAR(10), 
                           IN prep_time_in VARCHAR(10),					
                           IN total_time_in VARCHAR(10), 
                           -- date_published_in, this attribute does not need user input
                           IN recipe_description_in VARCHAR(5000), 
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
	SELECT 'Recipe successfully added!';
	ELSE 
	SELECT 'Recipe not added. Please check the info you entered. ';
	END IF;

END//
DELIMITER ;


-- -- Sample call to add_recipe and queries for testing
-- CALL add_recipe ('Little Bun Mengyu', 2002901941, 'Long Time', 'Time', 'Time', 'Very very good taste', 
-- 				 '', '', '', '', '', 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 0.0, 1, '', '');
--                  
-- SELECT recipe_id, recipe_name, author_id FROM recipe ORDER BY recipe_id DESC;  
-- SELECT *, COUNT(*) FROM recipe WHERE recipe_name = 'Little Bun Mengyu'; 
-- DELETE FROM recipe WHERE recipe_name = 'Little Bun Mengyu';


-- transaction and stored procedure that adds a review to the database
DROP PROCEDURE IF EXISTS add_review;
DELIMITER //
CREATE PROCEDURE add_review(IN recipe_id_in INT, -- entered at front-end, NOT NULL fk
                            IN author_id_in INT, -- NOT NULL fk
                            IN rating_in TINYINT, 
                            IN review_in VARCHAR(5000)
                            -- date_submitted, this attribute does not need user input
					        -- date_modified, this attribute does not need user input
                            )
BEGIN

	DECLARE total_rating INT;
    DECLARE num_rating INT;
	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;
    START TRANSACTION;
    
	INSERT INTO review(recipe_id, author_id, rating, 
					   review, date_submitted, date_modified)
	VALUES (recipe_id_in, author_id_in, rating_in, review_in, 
            CONVERT(NOW(), DATETIME), CONVERT(NOW(), DATETIME));
        
	-- increment review_count in recipe table
	UPDATE recipe
    SET review_count = review_count + 1
    WHERE recipe_id = recipe_id_in;
    
    -- update aggregated_rating in recipe table
    SET total_rating = 
		(SELECT SUM(rating)
         FROM review
         WHERE recipe_id = recipe_id_in);
         
	SET num_rating =
		(SELECT COUNT(rating)
         FROM review
         WHERE recipe_id = recipe_id_in);
    
    -- round average rating to the nearest 0.5
    UPDATE recipe
    SET aggregated_rating = ROUND(CEILING(FLOOR((total_rating / num_rating) * 4) / 2)/2, 2)
    WHERE recipe_id = recipe_id_in;
            
	IF sql_error = FALSE THEN
    COMMIT;
	SELECT 'Review successfully added!';
	ELSE 
    ROLLBACK;
	SELECT 'Review not added. Please check the info you entered. ';
	END IF;

END//
DELIMITER ;

-- -- Sample call to add_review and queries for testing
-- CALL add_review(541387, 2002901941, 4, 'Soooo good!');
-- CALL add_review(541386, 2002901952, 3, 'Soooo good!');
-- CALL add_review(54138600, 2002901952, 4, 'Soooo good!');  -- should fail, fk recipe_id
-- CALL add_review(541386, 200290195200, 4, 'Soooo good!');  -- should fail, fk author_id
-- CALL add_review(541386, 2002901952, 6, 'Soooo good!'); -- should fail, CHECK CONSTRAINT for rating
-- SELECT * FROM review ORDER BY review_id DESC LIMIT 100;
-- DELETE FROM review WHERE recipe_id = 541386;
-- SELECT recipe_id, recipe_name, author_id, aggregated_rating, review_count
-- FROM recipe WHERE recipe_id = 541387;
-- UPDATE recipe SET review_count = 1 WHERE recipe_id = 541386;

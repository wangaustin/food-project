USE recipedb;

-- stored procedure that updates a recipe in the database
-- default values will be passed in front-end code
DROP PROCEDURE IF EXISTS update_recipe;
DELIMITER //
CREATE PROCEDURE update_recipe(IN recipe_id_in INT,
						   IN cook_time_in VARCHAR(10), 
                           IN prep_time_in VARCHAR(10),					
                           IN total_time_in VARCHAR(10), 
                           IN recipe_description_in VARCHAR(5000), 
                           IN image_url_in VARCHAR(1000), 
						   IN recipe_category_in VARCHAR(20), 
                           IN keywords_in VARCHAR(1000), 
                           IN recipe_ingredient_quantity_in VARCHAR(1000), 
						   IN recipe_ingredient_parts_in VARCHAR(1000), 
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
    START TRANSACTION;

	UPDATE recipe
    SET cook_time = cook_time_in,
		prep_time = prep_time_in,
        total_time = total_time_in,
        recipe_description = recipe_description_in,
        image_url = image_url_in,
        recipe_category = recipe_category_in,
        keywords = keywords_in,
        recipe_ingredient_quantity = recipe_ingredient_quantity_in,
        recipe_ingredient_parts = recipe_ingredient_parts_in,
        calories = calories_in,
        fat_content = fat_content_in,
        saturated_fat = saturated_fat_in,
        cholesterol = cholesterol_in,
        sodium = sodium_in,
        carbohydrate = carbohydrate_in,
        fiber = fiber_in,
        sugar = sugar_in,
        protein = protein_in,
        recipe_servings = recipe_servings_in,
        recipe_yield = recipe_yield_in,
        recipe_instructions = recipe_instructions_in
    WHERE recipe_id = recipe_id_in;
	
	IF sql_error = FALSE THEN
    COMMIT;
	SELECT 'Recipe successfully updated!';
	ELSE 
    ROLLBACK;
	SELECT 'Recipe not updated. Please check the info you entered. ';
	END IF;

END//
DELIMITER ;

-- Sample call to update_recipe
CALL update_recipe(541383, 'COOK', 'PREP', 'TOTOAL', 'MY_DESCRIPTION', 'URL', 
				   'CATEG', 'KEYWO', 'INGRE_QUANT', 'INGRE_PART', 1.1, 2.2, 
                   3.3, 4.4, 5.5, 6.6, 7.7, 8.8, 9.9, 100, 'YIELD', 'INSTRUCT');
SELECT * FROM recipe ORDER BY recipe_id DESC;


-- stored procedure that updates a review in the database
DROP PROCEDURE IF EXISTS update_review;
DELIMITER //
CREATE PROCEDURE update_review(IN review_id_in INT,
						   IN rating_in TINYINT, 
                           IN review_in VARCHAR(5000))
BEGIN

	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;
    START TRANSACTION;

	UPDATE review
    SET rating = rating_in,
		review = review_in,
        date_modified = CONVERT(NOW(), DATETIME)
    WHERE review_id = review_id_in;
	
	IF sql_error = FALSE THEN
    COMMIT;
	SELECT 'Review successfully updated!';
	ELSE 
    ROLLBACK;
	SELECT 'Review not updated. Please check the info you entered. ';
	END IF;

END//
DELIMITER ;

-- Sample call to update_review
CALL update_review(2090347, 4, 'Not that good');
SELECT * FROM review ORDER BY review_id DESC;

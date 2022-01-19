USE recipedb;

-- stored procedure that deletes a review from the database
DROP PROCEDURE IF EXISTS delete_review;
DELIMITER //
CREATE PROCEDURE delete_review(IN review_id_in INT)
BEGIN
	
    DECLARE cur_recipe_id INT;
    DECLARE total_rating INT;
    DECLARE num_rating INT;
    DECLARE review_nonexist INT DEFAULT FALSE;
	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;
    
    -- check if the review_id exists
    IF review_id_in NOT IN 
		(SELECT review_id FROM review) THEN
    SET review_nonexist = TRUE;
    END IF;
    
    SET cur_recipe_id = 
		(SELECT recipe_id
         FROM review
         WHERE review_id = review_id_in);
    
	DELETE FROM review
    WHERE review_id = review_id_in;
         
	-- decrement review_count in recipe table
	UPDATE recipe
    SET review_count = review_count - 1
    WHERE recipe_id = cur_recipe_id;
    
    -- update aggregated_rating in recipe table
    SET total_rating = 
		(SELECT SUM(rating)
         FROM review
         WHERE recipe_id = cur_recipe_id);
         
	SET num_rating =
		(SELECT COUNT(rating)
         FROM review
         WHERE recipe_id = cur_recipe_id);
    
    -- round average rating to the nearest 0.5
    UPDATE recipe
    SET aggregated_rating = ROUND(CEILING(FLOOR((total_rating / num_rating) * 4) / 2)/2, 2)
    WHERE recipe_id = cur_recipe_id;
            
	IF sql_error = FALSE AND review_nonexist = TRUE THEN
    SELECT 'Review does not exist.';
	ELSEIF sql_error = FALSE AND review_nonexit = FALSE THEN
	SELECT 'Review successfully deleted.';
	ELSE 
	SELECT 'Action failed. Cannot delete review.';
	END IF;

END//
DELIMITER ;

-- -- Sample call to delete_review and queries for testing
-- CALL delete_review(1124704);
-- SELECT * FROM review ORDER BY review_id DESC LIMIT 100;
-- SELECT * FROM review WHERE review_id = 1124704;
-- SELECT recipe_id, recipe_name, author_id, aggregated_rating, review_count
-- FROM recipe WHERE recipe_id = 541387;


-- trigger that deletes reviews on a recipe before the recipe itself is deleted 
DROP TRIGGER IF EXISTS recipe_before_delete;
DELIMITER //
CREATE TRIGGER recipe_before_delete
BEFORE DELETE
ON recipe
FOR EACH ROW
BEGIN
	
    SET SQL_SAFE_UPDATES = 0;
    DELETE FROM recipedb.review
    WHERE recipe_id = OLD.recipe_id;
    SET SQL_SAFE_UPDATES = 1;

END //
DELIMITER ;

-- stored procedure that deletes a recipe from the database
DROP PROCEDURE IF EXISTS delete_recipe;
DELIMITER //
CREATE PROCEDURE delete_recipe(IN recipe_id_in INT)
BEGIN
	
    DECLARE recipe_nonexist INT DEFAULT FALSE;
	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;
    
    -- check if the recipe_id exists
	IF recipe_id_in NOT IN 
		(SELECT recipe_id FROM recipe) THEN
	SET recipe_nonexist = TRUE;
	END IF;
    
    DELETE FROM recipe
    WHERE recipe_id = recipe_id_in;
    
	IF sql_error = FALSE AND recipe_nonexist = TRUE THEN
    SELECT 'Recipe does not exist.';
	ELSEIF sql_error = FALSE AND recipe_nonexit = FALSE THEN
	SELECT 'Recipe successfully deleted.';
	ELSE 
	SELECT 'Action failed. Cannot delete recipe.';
	END IF;
    

END//
DELIMITER ;

-- -- Sample call to delete_recipe and queries for testing
-- CALL delete_recipe(541386);
-- SELECT recipe_id, recipe_name, author_id, aggregated_rating, review_count
-- FROM recipe WHERE recipe_id = 541386;
-- SELECT * FROM review WHERE recipe_id = 541386;
-- CALL delete_recipe(541386);


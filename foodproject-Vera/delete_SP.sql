-- stored procedure that deletes a review from the database
DROP PROCEDURE IF EXISTS delete_review;
DELIMITER //
CREATE PROCEDURE delete_review(IN review_id_in INT)
BEGIN
	
    DECLARE cur_recipe_id INT;
    DECLARE total_rating INT;
    DECLARE num_rating INT;
	DECLARE sql_error INT DEFAULT FALSE;
	DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET sql_error = TRUE;
    START TRANSACTION;
    
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
            
	IF sql_error = FALSE THEN
    COMMIT;
	SELECT 'Review successfully deleted.';
	ELSE 
    ROLLBACK;
	SELECT 'Action failed. Cannot delete review. ';
	END IF;

END//
DELIMITER ;


-- Sample call to delete_review
CALL delete_review(2090361);
SELECT * FROM review ORDER BY review_id DESC;
SELECT recipe_id, recipe_name, author_id, aggregated_rating, review_count
FROM recipe WHERE recipe_id = 541386;

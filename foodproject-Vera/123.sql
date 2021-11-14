USE recipedb;

DROP PROCEDURE IF EXISTS showbytime;

DELIMITER //
CREATE PROCEDURE showbytime(IN ordering INT, IN num_rows INT)
BEGIN

IF ordering = 1 THEN
	SELECT *
	FROM recipe 
	ORDER BY date_published
	LIMIT num_rows;
ELSEIF ordering = 0 THEN
	SELECT *
	FROM recipe 
	ORDER BY date_published
	LIMIT num_rows;
END IF;

END//
DELIMITER ;

DROP PROCEDURE IF EXISTS showbycalories;

DELIMITER //
CREATE PROCEDURE showbycalories(IN ordering INT, IN num_rows INT)
BEGIN

IF ordering = 1 THEN
	SELECT *
	FROM recipe 
	ORDER BY calories
	LIMIT num_rows;
ELSEIF ordering = 0 THEN
	SELECT *
	FROM recipe 
	ORDER BY calories DESC
	LIMIT num_rows;
END IF;

END//
DELIMITER ;

DROP PROCEDURE IF EXISTS showreviews;

DELIMITER //
CREATE PROCEDURE showreviews(IN current_recipe_id INT)
BEGIN

SELECT *
FROM review
WHERE recipe_id = current_recipe_id;

END//
DELIMITER ;

CALL showbytime(1, 5);
CALL showbycalories(0, 10);
CALL showreviews(38);

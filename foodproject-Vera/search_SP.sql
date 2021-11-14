USE recipedb;

-- stored procedure that shows the recipe search results by time in ASC/DESC order
DROP PROCEDURE IF EXISTS showbytime;
DELIMITER //
CREATE PROCEDURE showbytime(IN keyword VARCHAR(50), IN ordering INT, IN num_rows INT)
BEGIN

IF ordering = 1 THEN
	SELECT *
	FROM recipe 
    WHERE recipe_name LIKE CONCAT('%', keyword, '%')
	ORDER BY date_published
	LIMIT num_rows;
ELSEIF ordering = 0 THEN
	SELECT *
	FROM recipe 
    WHERE recipe_name LIKE CONCAT('%', keyword, '%')
	ORDER BY date_published
	LIMIT num_rows;
END IF;

END//
DELIMITER ;


-- stored procedure that shows the recipe search results by calories in ASC/DESC order
DROP PROCEDURE IF EXISTS showbycalories;
DELIMITER //
CREATE PROCEDURE showbycalories(IN keyword VARCHAR(50), IN ordering INT, IN num_rows INT)
BEGIN

IF ordering = 1 THEN
	SELECT *
	FROM recipe 
    WHERE recipe_name LIKE CONCAT('%', keyword, '%')
	ORDER BY calories
	LIMIT num_rows;
ELSEIF ordering = 0 THEN
	SELECT *
	FROM recipe 
    WHERE recipe_name LIKE CONCAT('%', keyword, '%')
	ORDER BY calories DESC
	LIMIT num_rows;
END IF;

END//
DELIMITER ;


-- stored procedure that shows the reviews on a particular recipe
DROP PROCEDURE IF EXISTS showreviews;
DELIMITER //
CREATE PROCEDURE showreviews(IN current_recipe_id INT)
BEGIN

SELECT *
FROM review
WHERE recipe_id = current_recipe_id;

END//
DELIMITER ;

-- stored procedure that search by author name
DROP PROCEDURE IF EXISTS showforauthor;
DELIMITER //
CREATE PROCEDURE showforauthor(IN author_name VARCHAR(50))
BEGIN

SELECT *
FROM recipe r
	JOIN author a ON r.author_id = a.author_id
WHERE a.author_name LIKE CONCAT('%', author_name, '%');

END//
DELIMITER ;

CALL showbytime('Blueberry', 1, 5);
CALL showbycalories('Blueberry', 0, 10);
CALL showreviews(38);
CALL showforauthor('Sue M.');

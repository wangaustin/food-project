USE recipedb;

-- stored procedure that shows the recipe search results by time in ASC/DESC order
DROP PROCEDURE IF EXISTS show_by_time;
DELIMITER //
CREATE PROCEDURE show_by_time(IN keyword VARCHAR(50), IN ordering INT, IN num_rows INT)
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
	ORDER BY date_published DESC
	LIMIT num_rows;
END IF;

END//
DELIMITER ;


-- stored procedure that shows the recipe search results by calories in ASC/DESC order
DROP PROCEDURE IF EXISTS show_by_calories;
DELIMITER //
CREATE PROCEDURE show_by_calories(IN keyword VARCHAR(50), IN ordering INT, IN num_rows INT)
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
DROP PROCEDURE IF EXISTS show_reviews;
DELIMITER //
CREATE PROCEDURE show_reviews(IN current_recipe_id INT)
BEGIN

SELECT r.review_id, r.recipe_id, a.author_id, a.author_name, 
	   r.rating, r.review, r.date_submitted, r.date_modified
FROM review r
	JOIN author a ON r.author_id = a.author_id
WHERE r.recipe_id = current_recipe_id;

END//
DELIMITER ;

-- stored procedure that search by author name
DROP PROCEDURE IF EXISTS show_for_author;
DELIMITER //
CREATE PROCEDURE show_for_author(IN author_name_in VARCHAR(50))
BEGIN

SELECT *
FROM recipe r
	JOIN author a ON r.author_id = a.author_id
WHERE a.author_name LIKE CONCAT('%', author_name_in, '%');

END//
DELIMITER ;

CALL show_by_time('Blueberry', 1, 5);
CALL show_by_calories('Blueberry', 0, 10);
CALL show_reviews(27430);
CALL show_for_author('Sue M.');


-- view that shows the trending recipes (highly-rated or mostly-reviewed)
DROP VIEW IF EXISTS trending_recipe;
CREATE VIEW trending_recipe AS
WITH highly_rated AS (
	 SELECT rp.recipe_name, a.author_name, rp.recipe_description, 
		    rp.aggregated_rating AS average_rating, rp.calories
     FROM author a
		JOIN recipe rp ON a.author_id = rp.author_id
	 WHERE rp.review_count >= 5
     ORDER BY rp.aggregated_rating DESC
	 LIMIT 50
), mostly_reviewed AS (
	SELECT rp.recipe_name, a.author_name, rp.recipe_description, 
		   rp.aggregated_rating AS average_rating, rp.calories
    FROM author a
		JOIN recipe rp ON a.author_id = rp.author_id
	WHERE rp.aggregated_rating >= 4.5
    ORDER BY rp.review_count DESC
    LIMIT 50
), union_tb AS (
	SELECT * FROM highly_rated
    UNION
    SELECT * FROM mostly_reviewed
)
SELECT * FROM union_tb
ORDER BY recipe_name;

-- Sample select from view trending_recipes
SELECT * FROM trending_recipe;


-- view that shows the top authors 
DROP VIEW IF EXISTS top_author;
CREATE VIEW top_author AS
SELECT author_name 

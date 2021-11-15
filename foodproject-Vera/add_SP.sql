USE recipedb;

-- stored procedure that shows adds an author to the database
DROP PROCEDURE IF EXISTS addauthor;
DELIMITER //
CREATE PROCEDURE addauthor(IN author_name_in VARCHAR(50))
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


DELETE FROM author WHERE author_id = 2002901948;

CALL addauthor('Vera');

CALL addauthor('Veraaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');

SELECT * FROM author ORDER BY author_id DESC;



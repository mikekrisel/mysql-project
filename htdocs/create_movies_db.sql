/**
 * Mike Krisel
 * Insert statements, procedures, functions, cursors, views and triggers
 * @procedue add_account
 * @procedue get_account_movies
 * @function totals_loss_gain
 * @function with cursor category_list
 * @view all_movies
 * @view all_account_movies
 * @trigger before_delete_customer
 * @trigger before_delete_movies
 */

-- create database Movies and insert test data
DROP database IF EXISTS Movies;
CREATE DATABASE Movies;
USE Movies;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS accounts_movies;
DROP TABLE IF EXISTS accounts;

CREATE TABLE movies (
	ID  INT NOT NULL AUTO_INCREMENT
	, Title	VARCHAR(100) NOT NULL
	, Description TEXT
	, MovieYear	YEAR NOT NULL
	, Category	VARCHAR(100) NOT NULL
	, Director	VARCHAR(100) NOT NULL
	, Writers	VARCHAR(250) NOT NULL
	, Stars	VARCHAR(250) NOT NULL
	, Cost DECIMAL(9,2) NOT NULL
	, SoldPrice DECIMAL(9,2) NULL
	, Image	VARCHAR(100) NOT NULL
	, MovieAdded DATE NOT NULL
	, MovieSold DATE NULL
	, PRIMARY KEY (ID)
);
INSERT INTO movies VALUES 
(1, 'Heat', 'A group of professional bank robbers start to feel the heat from police when they unknowingly leave a clue at their latest heist.', '1995', 'Action, Crime, Drama', 'Michael Mann', 'Michael Mann', 'Al Pacino, Robert De Niro, Val Kilmer', 9.99, 4.99, 'heat.jpg', '2013-04-22', '2013-05-06')
, (2, 'The Departed', 'An undercover state cop who infiltrated a Mafia clan and a mole in the police force working for the same mob race to track down and identify each other before being exposed to the enemy, after both sides realize their outfit has a rat.', '2006', 'Crime, Thriller', 'Martin Scorsese', 'William Monahan, Alan Mak, Felix Chong', 'Leonardo DiCaprio, Matt Damon, Jack Nicholson', 11.99, null, 'departed.jpg', '2013-04-22', null)
, (3, 'Rashomon', 'A heinous crime and its aftermath are recalled from differing points of view.', '1950', 'Crime, Drama', 'Akira Kurosawa', 'Ryunosuke Akutagawa, Akira Kurosawa, Shinobu Hashimoto', 'Toshiro Mifune, Machiko Kyo, Masayuki Mori', 5.99, 7.99, '', '2013-04-22', '2013-05-06')
, (4, 'The Big Lebowski', '"Dude" Lebowski, mistaken for a millionaire Lebowski, seeks restitution for his ruined rug and enlists his bowling buddies to help get it.', '1998', 'Comedy, Crime', 'Joel Coen', 'Ethan Coen, Joel Coen', 'Jeff Bridges, John Goodman, Julianne Moore', 8.99, null, 'the-big-lebowski.jpg', '2013-05-11', null)
, (5, 'Heat', 'A successful career criminal considers getting out of the business after one last score, while an obsessive cop desperately tries to put him behind bars in this intelligent thriller.', '1995', 'Crime, Action, Drama', 'Michael Mann', 'Michael Mann', 'Al Pacino, Robert De Niro, Val Kilmer', 10.99, null, 'heat.jpg', '2013-05-20', null);

CREATE TABLE accounts_movies (
	ID INT NOT NULL	AUTO_INCREMENT
	, AccountID INT NOT NULL
	, MovieID INT NOT NULL
	, PRIMARY KEY (ID)
	, INDEX (AccountID)
);
INSERT INTO accounts_movies VALUES
(1, 1, 1)
, (2, 1, 2)
, (3, 2, 3)
, (4, 1, 4)
, (5, 2, 5);

CREATE TABLE accounts (
	ID INT NOT NULL AUTO_INCREMENT
	, UserName VARCHAR(32) NOT NULL
	, FirstName VARCHAR(30) NOT NULL
	, LastName VARCHAR(30) NOT NULL
	, Email VARCHAR(100) NOT NULL
	, Password CHAR(40) NOT NULL
	, Salt INT NOT NULL
	, AccountDescription TEXT
	, AccountAdded DATE NOT NULL
	, PRIMARY KEY (ID)
	, INDEX (UserName, Password)
);
INSERT INTO accounts VALUES
(1, 'mkrisel', 'Mike', 'Krisel', 'michaelkrisel@gmail.com', SHA1('mymovies!60'), 60, 'Mike Krisel\'s collection of movies', '2013-04-22')
, (2, 'dpalermo', 'David', 'Palermo', 'davidpalermo59@hotmail.com', SHA1('password40'), 40, 'David Palermo\'s collection of movies', '2013-04-22');

-- End of insert statements section and Start of procedures, functions, cursors, views and triggers section

DROP PROCEDURE IF EXISTS add_account;

-- stored procedure to add an account
delimiter //
CREATE PROCEDURE add_account(
	IN user_name VARCHAR(32)
	, IN first_name VARCHAR(30)
	, IN last_name VARCHAR(30)
	, IN email VARCHAR(100)
	, IN password CHAR(40)
	, IN account_description TEXT
	, OUT error VARCHAR(100)
) SQL SECURITY DEFINER
BEGIN
	DECLARE user_name_count INT DEFAULT 0;
	DECLARE salt INT DEFAULT 0;
	DECLARE password_hash CHAR(40) DEFAULT NOT NULL;
	
	-- concatenate the user's password with salt
  SET salt = FLOOR(1+RAND()*60);
  SET password_hash = SHA1(CONCAT(password, salt));

  -- check to make sure the username doesn't already exist
	SELECT COUNT(*) INTO user_name_count from accounts where UserName = user_name;
	if user_name_count then 
	  SET error = 'That User Name already exists.';
	else
	  INSERT INTO accounts VALUES
		(DEFAULT, user_name, first_name, last_name, email, password_hash, salt, account_description, CURDATE());
		SELECT ID FROM accounts WHERE UserName = user_name;
  end if;
END
//
delimiter ;

DROP PROCEDURE IF EXISTS get_account_movies;

-- stored procedure to get all movies owned by account
delimiter //
CREATE PROCEDURE get_account_movies(IN TheUserName VARCHAR(32), OUT error VARCHAR(100)) SQL SECURITY DEFINER
BEGIN
	DECLARE UserNameCount INT default 0;

  -- check to make sure the username exists
	SELECT COUNT(*) INTO UserNameCount from accounts where UserName = TheUserName;
	if !UserNameCount then 
	  SET error = 'User does not exist';
	else
	  SELECT m.Title,
			m.Description,
			m.MovieYear,
			m.Director
			FROM accounts AS a
			RIGHT JOIN accounts_movies AS am ON a.ID = am.AccountID
			RIGHT JOIN movies AS m ON am.MovieID = m.ID
			WHERE
			a.UserName = TheUserName;
  end if;
END
//
delimiter ;

-- Function to get the total loss or gain when/if a movie from an account was sold
delimiter //
CREATE FUNCTION totals_loss_gain(cost DECIMAL(9,2), sold_price DECIMAL(9,2))
RETURNS DECIMAL(9,2) DETERMINISTIC
BEGIN

	RETURN cost - sold_price;

END
//
delimiter ;

DROP FUNCTION IF EXISTS category_list;

-- Function to get list of all first listed categories in movies
delimiter //
CREATE FUNCTION category_list
(account_id INT)
RETURNS VARCHAR(255)
BEGIN

	DECLARE finished INTEGER DEFAULT 0;
	DECLARE category_name VARCHAR(50) DEFAULT "";
	DECLARE categories_list VARCHAR(255) DEFAULT "";
	DECLARE category_cur CURSOR FOR SELECT SUBSTRING_INDEX(m.Category, ',', 1) 
		AS main_category FROM accounts_movies AS a
		INNER JOIN movies AS m ON a.MovieID = m.ID
		WHERE a.AccountID = account_id
		GROUP BY main_category;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
	
	OPEN category_cur;
	
	get_category: LOOP
		FETCH category_cur INTO category_name;
		IF finished THEN
			LEAVE get_category;
		END IF;
		SET categories_list = CONCAT(categories_list,", ",category_name);
	END LOOP get_category;
	
	CLOSE category_cur;
	
	RETURN SUBSTR(categories_list, 3);

END
//
delimiter ;

-- view to select all movies
CREATE OR REPLACE 
	ALGORITHM = MERGE 
	VIEW all_movies AS 
	SELECT Title,
		Description,
		MovieYear,
		Director,
		Writers,
		Stars
		FROM movies
		GROUP BY Title;

-- view to select all movies owned by a user
CREATE OR REPLACE 
	ALGORITHM = MERGE 
	VIEW all_account_movies (AccountID, ID, Title, Description, MovieYear, Category, Director, Writers, Stars, Cost, SoldPrice, Image, MovieAdded, MovieSold) AS 
	SELECT a.ID,
		m.ID,
		m.Title,
		m.Description,
		m.MovieYear,
		m.Category,
		m.Director,
		m.Writers,
		m.Stars,
		m.Cost,
		m.SoldPrice,
		m.Image,
		m.MovieAdded,
		m.MovieSold
		FROM accounts AS a
		RIGHT JOIN accounts_movies AS am ON a.ID = am.AccountID
		RIGHT JOIN movies AS m ON am.MovieID = m.ID;

-- trigger to delete record linking movies with user
delimiter //
CREATE TRIGGER before_delete_customer BEFORE DELETE ON accounts
FOR EACH ROW
BEGIN
	
	DELETE a, m FROM accounts_movies as a
		INNER JOIN movies as m
		WHERE
		a.AccountID = OLD.ID
		AND m.ID = a.MovieID;
	
END
//
delimiter ;

-- trigger to delete record linking user with movie
delimiter //
CREATE TRIGGER before_delete_movies BEFORE DELETE ON movies
FOR EACH ROW
BEGIN

	DELETE FROM accounts_movies
		WHERE
		MovieID = OLD.ID;

END
//
delimiter ;

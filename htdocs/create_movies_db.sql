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
	, Cost DECIMAL(9,2) NULL
	, SoldPrice DECIMAL(9,2) NULL
	, Image	VARCHAR(100) NOT NULL
	, MovieAdded DATE NOT NULL
	, MovieSold DATE NULL
	, PRIMARY KEY (ID)
);
INSERT INTO movies VALUES 
(1, 'Heat', 'A group of professional bank robbers start to feel the heat from police when they unknowingly leave a clue at their latest heist.', '1995', 'Action, Crime, Drama', 'Michael Mann', 'Michael Mann', 'Al Pacino, Robert De Niro, Val Kilmer', 9.99, 4.99, 'heat.jpg', '2013-04-22', '2013-05-06')
, (2, 'The Departed', 'An undercover state cop who infiltrated a Mafia clan and a mole in the police force working for the same mob race to track down and identify each other before being exposed to the enemy, after both sides realize their outfit has a rat.', '2006', 'Crime, Thriller', 'Martin Scorsese', 'William Monahan, Alan Mak, Felix Chong', 'Leonardo DiCaprio, Matt Damon, Jack Nicholson', 11.99, NULL, 'departed.jpg', '2013-04-22', NULL)
, (3, 'Rashomon', 'A heinous crime and its aftermath are recalled from differing points of view.', '1950', 'Crime, Drama', 'Akira Kurosawa', 'Ryunosuke Akutagawa, Akira Kurosawa, Shinobu Hashimoto', 'Toshiro Mifune, Machiko Kyo, Masayuki Mori', 5.99, 7.99, '', '2013-04-22', '2013-05-06')
, (4, 'The Big Lebowski', '"Dude" Lebowski, mistaken for a millionaire Lebowski, seeks restitution for his ruined rug and enlists his bowling buddies to help get it.', '1998', 'Comedy, Crime', 'Joel Coen', 'Ethan Coen, Joel Coen', 'Jeff Bridges, John Goodman, Julianne Moore', 8.99, 11, 'the-big-lebowski.jpg', '2013-05-11', '2013-06-02')
, (5, 'Heat', 'A successful career criminal considers getting out of the business after one last score, while an obsessive cop desperately tries to put him behind bars in this intelligent thriller.', '1995', 'Crime, Action, Drama', 'Michael Mann', 'Michael Mann', 'Al Pacino, Robert De Niro, Val Kilmer', 10.99, NULL, 'heat.jpg', '2013-05-20', NULL)
, (6, 'Full Metal Jacket', 'A pragmatic U.S. Marine observes the dehumanizing effects the Vietnam War has on his fellow Marine recruits from their brutal boot camp training to the bloody street fighting set in 1968 in Hue, Vietnam.', '1987', 'Drama, War', 'Stanley Kubrick', 'Gustav Hasford, Stanley Kubrick', 'Matthew Modine, Adam Baldwin, Vincent D\'Onofrio', 8.99, NULL, 'full-metal-jacket.jpg', '2013-06-04', NULL)
, (7, 'Blade Runner', 'Deckard, a blade runner, has to track down and terminate 4 replicants who hijacked a ship in space and have returned to Earth seeking their maker.', '1982', 'Drama, Sci-Fi, Thriller', 'Ridley Scott', 'Hampton Fancher, David Webb Peoples', 'Harrison Ford, Rutger Hauer, Sean Young', 7.99, NULL, 'blade-runner.jpg', '2013-06-04', NULL)
, (8, 'Fear and Loathing in Las Vegas', 'An oddball journalist and his psychopathic lawyer travel to Las Vegas for a series of psychedelic escapades.', '1998', 'Adventure, Comedy', 'Terry Gilliam', 'Hunter S. Thompson, Terry Gilliam', 'Johnny Depp, Benicio Del Toro, Tobey Maguire', 10.99, NULL, 'fear-and-loathing-in-las-vegas.jpg', '2013-06-04', NULL)
, (9, 'Out for Justice', 'Brooklyn cop Gino Felino is about to go outside and play catch with his son Tony when he receives a phone call alerting him that his best friend Bobby Lupo has been shot dead in broad daylight on 18th Avenue in front of his wife Laurie Lupo and his two kids by drug kingpin Richie Madano, who has been Gino and Bobby\'s enemy since childhood. As Gino is hunting Madano down, Gino discovers the motive behind Bobby\'s murder. This is when Gino\'s hunt for Madano leads to the showdown of a lifetime.', '1991', 'Action, Thriller, Crime', 'John Flynn', 'David Lee Henry', 'Steven Seagal, William Forsythe, Jerry Orbach', 6.99, NULL, 'out-for-justice.jpg', '2013-06-04', NULL)
,	(10, 'The Hustler', 'An up-and-coming pool player plays a long-time champion in a single high-stakes match.', '1961', 'Drama, Sport', 'Robert Rossen', 'Sydney Carroll, Robert Rossen', 'Paul Newman, Jackie Gleason, Piper Laurie', 5.99, NULL, 'the-hustler.jpg', '2013-06-04', NULL)
, (11, 'Gran Torino', 'Disgruntled Korean War vet Walt Kowalski sets out to reform his neighbor, a young Hmong teenager, who tried to steal Kowalski\'s prized possession: his 1972 Gran Torino.', '2008', 'Drama', 'Clint Eastwood', 'Nick Schenk, Dave Johannson', 'Clint Eastwood, Christopher Carley, Bee Vang', 9.95, NULL, 'gran-torino.jpg', '2013-06-05', NULL)
, (12, 'Inception', 'A skilled extractor is offered a chance to regain his old life as payment for a task considered to be impossible.', '2010', 'Action, Adventrue, Mystery', 'Christopher Nolan', 'Christopher Nolan', 'Leonardo DiCaprio, Joseph Gordon-Levitt, Ellen Page', 6.40, NULL, 'inception.jpg', '2013-06-05', NULL)
, (13, 'Insomnia', 'Two Los Angeles homicide detectives are dispatched to a northern town where the sun doesn\'t set to investigate the methodical murder of a local teen.', '2002', 'Crime, Mystery, Thriller', 'Christopher Nolan', 'Hillary Seitz, Nikolaj Frobenius', 'Al Pacino, Martin Donovan, Hilary Swank', 5.70, NULL, 'insomnia.jpg', '2013-06-05', NULL)
, (14, 'Reservoir Dogs', 'After a simple jewelery heist goes terribly wrong, the surviving criminals begin to suspect that one of them is a police informant.', '1992', 'Crime, Thriller', 'Quentin Tarantino', 'Quentin Tarantino, Roger Avary', 'Harvey Keitel, Tim Roth, Michael Madsen', 8.99, NULL, 'reservoir-dogs.jpg', '2013-06-05', NULL)
, (16, 'Cool Hand Luke', 'A man refuses to conform to life in a rural prison.', '1967', 'Crime, Drama', 'Stuart Rosenberg', 'Donn Pearce, Frank Pierson', 'Paul Newman, George Kennedy, J.D. Cannon', 7.45, NULL, 'cool-hand-luke.jpg', '2013-06-05', NULL)
,	(17, 'The Thing from Another World', 'Scientists and American Air Force officials fend off a blood-thirsty alien organism while at a remote arctic outpost.', '1951', 'Horror, Scir-Fi', 'Christian Nyby', 'Charles Lederer, John W. Campbell Jr.', 'Margaret Sheridan, Kenneth Tobey, Robert Cornthwaite', 3.60, NULL, 'the-thing-from-another-world.jpg', '2013-06-05', NULL)
,	(18, 'Stand by Me', 'After the death of a friend, a writer recounts a boyhood journey to find the body of a missing boy.', '1986', 'Adventure, Drama', 'Rob Reiner', 'Stephen King, Raynold Gideon', 'Wil Wheaton, River Phoenix, Corey Feldman', 5.70, 6.80, 'stand-by-me.jpg', '2013-06-05', '2013-06-05')
,	(19, 'Sneakers', 'Complex but lighthearted thriller about computers and cryptography, government and espionage, secrets and deception and betrayal.', '1992', 'Comedy, Crime, Drama', 'Phil Alden Robinson', 'Phil Alden Robinson, Lawrence Lasker', 'Jo Marr, Robert Redford, Sidney Poitier', 6.99, NULL, 'sneakers.jpg', '2013-06-05', NULL)
,	(20, 'Wolf Creek', 'Stranded backpackers in remote Australia fall prey to a murderous bushman who offers to fix their car, then takes them captive.', '2005', 'Horror', 'Greg Mclean', 'Greg Mclean', 'John Jarratt, Cassandra Magrath, Kestie Morassi', 9.99, NULL, 'wolf-creek.jpg', '2013-06-05', NULL)
, (21, 'Star Wars', 'Luke Skywalker, a spirited farm boy, joins rebel forces to save Princess Leia from the evil Darth Vader, and the galaxy from the Empire\'s planet-destroying Death Star.', '1977', 'Action, Adventure, Fantasy', 'George Lucas', 'George Lucas', 'Mark Hamill, Harrison Ford, Carrie Fisher', 7.99, NULL, 'star-wars.jpg', '2013-06-05', NULL)
, (22, '1984', 'George Orwell\'s novel of a totalitarian future society in which a man whose daily work is rewriting history tries to rebel by falling in love.', '1984', 'Drama, Romance, Sci-Fi', 'Michael Radford', 'George Orwell, Michael Radford', 'John Hurt, Richard Burton, Suzanna Hamilton', 5.78, NULL, '1984.jpg', '2013-06-05', NULL)
, (23, 'The Shawshank Redemption', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', '1994', 'Crime, Drama', 'Frank Darabont', 'Stephen King, Frank Darabont', 'Tim Robbins, Morgan Freeman, Bob Gunton', 9.99, NULL, 'the-shawshank-redemption.jpg', '2013-06-05', NULL)
, (24, 'Sin City', 'A film that explores the dark and miserable town, Basin City, and tells the story of three different people, all caught up in violent corruption.', '2005', 'Crime, Thriller', 'Frank Miller, Robert Rodriguez', 'Frank Miller', 'Jessica Alba, Clive Owen, Mickey Rourke', 7.68, NULL, 'sin-city.jpg', '2013-06-05', NULL)
, (25, 'Apocalypse Now', 'During the U.S.-Viet Nam War, Captain Willard is sent on a dangerous mission into Cambodia to assassinate a renegade colonel who has set himself up as a god among a local tribe.', '1979', 'Drama, War', 'Francis Ford Coppola', 'John Milius, Francis Ford Coppola', 'Marlon Brando, Martin Sheen, Robert Duvall', 4.59, NULL, 'apocalypse-now.jpg', '2013-06-05', NULL)
, (26, 'Casino Royale', 'Armed with a license to kill, Secret Agent James Bond sets out on his first mission as 007 and must defeat a weapons dealer in a high stakes game of poker at Casino Royale, but things are not what they seem.', '2006', 'Action, Crime, Thriller', 'Martin Campbell', 'Neal Purvis, Robert Wade', 'Daniel Craig, Eva Green, Judi Dench', 11.99, NULL, 'casino-royale.jpg', '2013-06-05', NULL);

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
, (5, 2, 5)
,	(6, 1, 6)
,	(7, 1, 7)
, (8, 1, 8)
,	(9, 1, 9)
,	(10, 1, 10)
, (11, 1, 11)
,	(12, 1, 12)
,	(13, 1, 13)
, (14, 1, 14)
, (16, 1, 16)
, (17, 1, 17)
,	(18, 1, 18)
,	(19, 1, 19)
,	(20, 1, 20)
, (21, 1, 21)
, (22, 1, 22)
, (23, 1, 23)
, (24, 1, 24)
, (25, 1, 25)
, (26, 1, 26);

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
(1, 'mkrisel', 'Mike', 'Krisel', 'michaelkrisel@gmail.com', SHA1('mymovies!60'), 60, 'Mike Krisel\'s collection of movies.', '2013-04-22')
, (2, 'dpalermo', 'David', 'Palermo', 'davidpalermo59@hotmail.com', SHA1('password40'), 40, 'David Palermo\'s collection of movies.', '2013-04-22');

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
	RETURN sold_price - cost;
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
	
	DELETE a FROM accounts_movies as a
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
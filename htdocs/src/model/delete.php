<?php

include "../db/mysqli.php";

if (isset($_POST['movieID'])) {
	$movieID = trim($_POST['movieID']);
	if (!preg_match("([^0-9]+|^$)", $movieID)) {
		$db = new db\mysqli('localhost', 'root', 'password', 'movies');	
		// using the before_delete_movies trigger
		$query = $db->query("DELETE 
			FROM movies
			WHERE ID = '".$movieID."';");
	} else {
		echo "There was a problem removiing the movie.";
	}
}

?>
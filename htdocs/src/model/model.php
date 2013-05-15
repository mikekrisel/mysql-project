<?php

/**
 * @namespace model
 **/
namespace model;
use movie;

class Model {
	public function getMovieList()
	{
		// here goes some hardcoded values to simulate the database
		return array(
			"Jungle-Movie" => new movie\Movie("Jungle-Movie", "R. Kipling", "A classic movie."),
			"Moonwalker" => new movie\Movie("Moonwalker", "J. Walker", ""),
			"PHP-for-Dummies" => new movie\Movie("PHP-for-Dummies", "Some Smart Guy", "")
		);
	}
	
	public function getMovie($title)
	{
		// we use the previous function to get all the movies and then we return the requested one.
		// in a real life scenario this will be done through a db select command
		$allMovies = $this->getMovieList();
		return $allMovies[$title];
	}
	
	
}

?>
<?php

/**
 * @namespace model_movie
 **/
namespace model_movie;
use movie;

class Model
{

	/**
   * ID
   * @var string
   **/
	public $ID;
	
	/**
   * title
   * @var string
   **/
	public $movie;
	
	/**
   * db
   * @var string
   **/
	public $db;
	
	public function getMovieList ($db, $ID)
	{
		$this->db = $db;
		$this->ID = $ID;
		// using the all_account_movies view
		$query = $this->db->query("SELECT
		* 
		FROM all_account_movies 
		WHERE AccountID = '".$this->ID."';");
		$result = $query;
		$movies = [];
		foreach ($result as $key => $values) {
			$n = array("'", "\"", "_", ",", " ", ".", "!", ":", "#", "*");
			$r = array("", "", "", "", "-", "", "", "", "", "");
			$URL = str_replace($n, $r, $values['Title']);
			$movies[$URL] = new movie\Movie($URL, $values['Title'], $values['Description'], $values['MovieYear'], $values['Category'], $values['Director'], $values['Writers'], $values['Stars'], $values['Cost'], $values['SoldPrice'], $values['Image'], $values['MovieAdded'], $values['MovieSold']);
		}
		return $movies;
	}

	public function getMovie ($db, $ID, $movie)
	{
		$this->db = $db;
		$this->ID = $ID;
		$this->movie = $movie;
		// we use the previous function to get all the movies and then we return the requested one.
		// in a real life scenario this will be done through a db select command
		$allMovies = $this->getMovieList($this->db, $this->ID);
		return $allMovies[$this->movie];
	}
}

?>
<?php

/**
 * @namespace movie
 **/
namespace movie;

class Movie
{
	public $ID;
	public $URL;
	public $title;
	public $description;
	public $movieYear;
	public $category;
	public $director;
	public $writers;
	public $stars;
	public $cost;
	public $soldPrice;
	public $image;
	public $movieAdded;
	public $movieSold;
	
	public function __construct ($ID, $URL, $title, $description, $movieYear, $category, $director, $writers, $stars, $cost, $soldPrice, $image, $movieAdded, $movieSold)  
    {  
      $this->ID = $ID;
      $this->URL = $URL;
      $this->title = $title;
	    $this->description = $description;
	    $this->movieYear = $movieYear;
	    $this->category = $category;
	    $this->director = $director;
	    $this->writers = $writers;
	    $this->stars = $stars;
	    $this->cost = $cost;
	    $this->soldPrice = $soldPrice;
	    $this->image = $image;
	    $this->movieAdded = $movieAdded;
	    $this->movieSold = $movieSold;
    } 
}

?>
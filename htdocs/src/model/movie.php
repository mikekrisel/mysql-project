<?php

/**
 * @namespace movie
 **/
namespace movie;

class Movie
{
	public $URL;
	public $title;
	public $description;
	public $movieYear;
	
	public function __construct ($URL, $title, $description, $movieYear)  
    {  
      $this->URL = $URL;
      $this->title = $title;
	    $this->description = $description;
	    $this->movieYear = $movieYear;
    } 
}

?>
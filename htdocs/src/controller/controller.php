<?php

/**
 * @namespace controller
 **/
namespace controller;
use model;

class Controller {
	public $model;
	
	public function __construct()  
    {  
        $this->model = new model\Model();

    } 
	
	public function invoke()
	{
		if (!isset($_GET['movie']))
		{
			// no special movie is requested, we'll show a list of all available movies
			$movies = $this->model->getMovieList();
			include 'src/view/movie-list.php';
		}
		else
		{
			// show the requested movie
			$movie = $this->model->getMovie($_GET['movie']);
			include 'src/view/view-movie.php';
		}
	}
}

?>
<?php

/**
 * @namespace controller
 **/
namespace controller;
use model_movie;
use model_account;
use db;
use user;

class Controller
{

	/**
   * model
   * @var string
   **/
	public $model_movie;
	
	/**
   * account
   * @var string
   **/
	public $model_account;
	
	/**
   * database connection
   * @var string
   **/
	public $db;
	
	public function __construct ()  
    {  
			$this->db = new db\mysqli('localhost', 'root', 'password', 'movies');	
      $this->model_movie = new model_movie\Model();
      $this->model_account = new model_account\Model();

    } 
	public function invoke ()
	{
		if (!isset($_SESSION['username'])) {
			if (isset($_GET['action']) && $_GET['action'] == "about") {
				// show the about content
				include "src/view/about.php";
				include "src/view/main.php";
			} else {
				// show the login page
				include "src/view/login.php";
			}
		}
		else {
			if (!isset($_GET['action'])) {
				if (isset($_GET['debug']) && $_GET['debug'] == 1) {
					$action = "debug";
				} else if (isset($_GET['metrics']) && $_GET['metrics'] == 1) {
					$action = "metrics";
				} else {
					$action = "main";
				}
			} else {
				$action = $_GET['action'];
			}
			switch ($action) {
				case "about":
					// show the about content
					include "src/view/about.php";
					include "src/view/main.php";
				break;
				case "add-movie":
					// add a movie
					include "src/view/movie-add.php";
				break;
				case "debug":
					// show some debug info
					include "src/view/debug.php";
				break;
				case "logout":
					// kill the session
					session_destroy();
					header('Location: /');
				break;
				case "main":
					// show the main page
					$account = $this->model_account->getAccount($this->db, $_SESSION['ID'], $_SESSION['username']);
					include "src/view/main.php";
				break;
				case "metrics":
					// show some debug info
					include "src/view/metrics.php";
				break;
				case "modify-account":
					// show the main page
					$account = $this->model_account->getAccount($this->db, $_SESSION['ID'], $_SESSION['username']);
					include "src/view/account-modify.php";
				break;
				case "movie":
					// show the requested movie
					$movie = $this->model_movie->getMovie($this->db, $_SESSION['ID'], $_GET['movie']);
					include "src/view/view-movie.php";
				break;
				case "movie-list":
					// no special movie is requested, we'll show a list of all available movies
					$movies = $this->model_movie->getMovieList($this->db, $_SESSION['ID']);
					include "src/view/movie-list.php";
				break;
				default:
					// nothing else, so show the main page
					$account = $this->model_account->getAccount($this->db, $_SESSION['ID'], $_SESSION['username']);
					include "src/view/main.php";
			}
		}
	}
}

?>
<?php

/**
 * @namespace controller
 **/
namespace controller;
use model_movie;
use model_account;
use db;
use user;
		
session_start();

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
				$content = '<h2>About MySQL Project</h2>
					<p>This is the final project for WEBLAMP 443: MySQL Design, Development and Administration. Project requirements were creating a web page using PHP that works with a MySQL database. The webpage must use client side JavaScript (do some client side validation or use Ajax to get some data into the browser). The following actions/
					components are required to be part of the project:</p>
					<ul>
						<li>Query/modify the database</li>
						<li>Use transactions</li>
						<li>Use triggers</li>
						<li>Use functions</li>
						<li>Use stored procedure</li>
						<li>Use cursors</li>
						<li>Use views</li>
						<li>Provide debugging abilities (when sending a parameter like debug=1, add some debugging info to the webpage – queries being executed, latency of the queries…)</li>
						<li>Provides metrics (when sending a parameter like metrics=1 shows some metrics)</li>
					</ul>
					<p>A repository of the project can be found at <a href="https://github.com/mikekrisel/mysql-project/tree/master/htdocs">github.com/mikekrisel/mysql-project</a></p>';
				include "src/view/main.php";
			} else {
				include "src/view/login.php";
			}
		}
		else {
			if (!isset($_GET['action'])) {
				$action = "main";
			} else {
				$action = $_GET['action'];
			}
			switch ($action) {
				case "about":
					$content = '<h2>About MySQL Project</h2>
						<p>This is the final project for WEBLAMP 443: MySQL Design, Development and Administration. Project requirements were creating a web page using PHP that works with a MySQL database. The webpage must use client side JavaScript (do some client side validation or use Ajax to get some data into the browser). The following actions/
						components are required to be part of the project:</p>
						<ul>
							<li>Query/modify the database</li>
							<li>Use transactions</li>
							<li>Use triggers</li>
							<li>Use functions</li>
							<li>Use stored procedure</li>
							<li>Use cursors</li>
							<li>Use views</li>
							<li>Provide debugging abilities (when sending a parameter like debug=1, add some debugging info to the webpage – queries being executed, latency of the queries…)</li>
							<li>Provides metrics (when sending a parameter like metrics=1 shows some metrics)</li>
						</ul>
						<p>A repository of the project can be found at <a href="https://github.com/mikekrisel/mysql-project/tree/master/htdocs">github.com/mikekrisel/mysql-project</a></p>';
					include "src/view/main.php";
				break;
				case "add-movie":
					include "src/view/movie-add.php";
				break;
				case "logout":
					// kill the session
					session_destroy();
					header('Location: /');
				break;
				case "main":
					$account = $this->model_account->getAccount($this->db, $_SESSION['ID'], $_SESSION['username']);
					include "src/view/main.php";
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
					$account = $this->model_account->getAccount($this->db, $_SESSION['ID'], $_SESSION['username']);
					include "src/view/main.php";
			}
		}
	}
}

?>
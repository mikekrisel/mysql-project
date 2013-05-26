<?php

/**
 * @namespace db
 **/
namespace db;

/**
 * mysqli connection class
 **/
class mysqli {
	
	/**
   * hostname
   * @var string
   **/
	private $hostname;
	
	/**
   * username
   * @var string
   **/
	private $username;
	
	/**
   * password
   * @var string
   **/
	private $password;
	
	/**
   * database
   * @var string
   **/
	private $database;
	
	/**
   * result
   * @var string
   **/
	protected $result;
	
	/**
   * values
   * @var string
   **/
	protected $values;
	
	/**
   * __constructor
	 * open a database connection
	 * @param string hostname
	 * @param string username
	 * @param string password
	 * @param string database
   **/
	public function __construct($hostname, $username, $password, $database) {
		$this->hostname = $hostname;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
		$this->mysqli = new \mysqli($this->hostname, $this->username, $this->password, $this->database);
		if ($this->mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
		}
	}
	
	/**
   * __destruct
	 * close open database connection
   **/
	public function __destruct() {
		mysqli_close($this->mysqli);
	}
	
	/**
   * query
	 * query database with paramaters
	 * @param string statement to run
   **/
	public function query($statement) {
		$this->result = $this->mysqli->query($statement);
		$this->values = [];
		if (is_object($this->result)) {
			foreach($this->result as $key => $values) {
				$this->values[$key] = $values;
			}
			return $this->values;
		} else {
			return $this->result;
		}
	}
	
	public function escape_string($string) {
		return $this->mysqli->real_escape_string(trim($string));
	}
	
	public function prepare($statement) {
		/* bind parameters for markers example is: "SELECT District FROM City WHERE Name=?"*/
		$stmt->bind_param("s", $city);

		/* execute query */
		$stmt->execute();

		/* bind result variables */
		$stmt->bind_result($district);

		/* fetch value */
		$stmt->fetch();

		return array("%s is in district %s\n", $city, $district);

		/* close statement */
		$stmt->close();
	}
	
}

?>
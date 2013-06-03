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
   * @var array
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
	 * @return values or results
   **/
	public function query($statement) {
		// run query
		$this->result = $this->mysqli->query($statement);
		$this->values = [];
		// errors
		if ($this->mysqli->errno) {
			echo "Failed to make QUERY to MySQL: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
		}
		// return values or result
		if (is_object($this->result)) {
			foreach ($this->result as $key => $values) {
				$this->values[] = $values;
			}
			return $this->values;
		} else {
			return $this->result;
		}
	}
	
	/**
   * query
	 * query database with paramaters
	 * @param array statements
	 * @return values or result
   **/
	public function transaction($statements) {
		$this->result = [];
		$this->values = [];
		// set autocommit to off
		$this->mysqli->autocommit(FALSE);
		// run query
		foreach ($statements as $key => $statement) {
			$this->result[] = $this->mysqli->query($statement);
		}
		// commit transaction
		$this->mysqli->commit();
		// errors
		if ($this->mysqli->errno) {
			echo "Failed to make QUERY TRANSACTION to MySQL: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
		}
		// return values or result
		foreach ($this->result as $key => $result) {
			if (is_object($result)) {
				foreach($result as $key => $values) {
					$this->values[] = $values;
				}
			} else {
				$this->values[] = $result;
			}
		}
		return $this->values;
		
	}
	
	/**
   * escape_string
	 * takes in a string value and trims/escapes
	 * @param string statement to trim/escape
	 * @return string
   **/
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
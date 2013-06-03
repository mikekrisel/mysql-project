<?php

/**
 * @namespace model_account
 **/
namespace model_account;
use account;

class Model
{

	/**
   * ID
   * @var string
   **/
	public $ID;
	
	/**
   * userName
   * @var string
   **/
	public $userName;
	
	/**
   * db
   * @var string
   **/
	public $db;
	
	public function getAccountDetails ()
	{
		// query database for account information
		$query = $this->db->query("SELECT
			FirstName,
			LastName,
			Email,
			AccountDescription		
			FROM accounts
			WHERE ID = '".$this->ID."' 
			AND UserName = '".$this->userName."';");
		$result = $query[0];
		$account = new account\Account($this->ID, $this->userName, $result['FirstName'], $result['LastName'], $result['Email'], $result['AccountDescription']);
		return $account;
	}

	public function getAccount ($db, $ID, $userName)
	{
		$this->db = $db;
		$this->ID = $ID;
		$this->userName = $userName;
		// we use the previous function to get all the movies and then we return the requested one.
		// in a real life scenario this will be done through a db select command
		$accountDetails = $this->getAccountDetails();
		return $accountDetails ;
	}
}

?>
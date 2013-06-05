<?php

/**
 * @namespace user
 */
namespace account;

class Account
{
	public $ID;
	public $userName;
	public $firstName;
	public $lastName;
	public $email;
	public $accountDescription;
	
	public function __construct ($ID, $userName, $firstName, $lastName, $email, $accountDescription)  
    {
	    $this->ID = $ID;
	    $this->userName = $userName;
	    $this->firstName = $firstName;
	    $this->lastName = $lastName;
			$this->email = $email;
			$this->accountDescription = $accountDescription;
    } 
}

?>
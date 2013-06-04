<?php

	session_start();
	
	require_once 'bootstrap.php';

	$controller = new controller\Controller();
	$controller->invoke();

?>
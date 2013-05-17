<?php 
	
	$template = new template\Template();
	$template->showHead("MySQL Project");
	
	$content = 'Please login or Signup';
	
	$template->showBodyThird($content);
	$template->showFooter();

?>
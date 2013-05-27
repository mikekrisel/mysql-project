<?php
	
	$template = new template\Template();
	$template->showHead($movie->title);
	
	$content  = '<img src="/images/shawshank-redemption.jpg" width="200" align="left" />';
	$content .= "Title: ".$movie->title."<br/>\n";
	$content .= "Description: ".$movie->description."<br/>\n";
	$content .= "Year Released: ".$movie->movieYear."<br/>";
	
	$template->showBodyTwoThird($content);
	
	$template->showFooter();

?>
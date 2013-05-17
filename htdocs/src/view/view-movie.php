<?php
	
	$template = new template\Template();
	$template->showHead($movie->title);
	
	$content  = '<img src="/images/shawshank-redemption.jpg" width="200" align="left" />';
	$content .= "\t\tTitle:" . $movie->title . "<br/>\n";
	$content .= "\t\tAuthor:" . $movie->author . "<br/>\n";
	$content .= "\t\tDescription:" . $movie->description . "<br/>";
	
	$template->showBodyTwoThird($content);
	
	$template->showFooter();

?>
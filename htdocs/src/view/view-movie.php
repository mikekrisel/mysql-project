<?php
	
	$template = new template\Template();
	echo $template->showHead($movie->title);
	
	echo 'Title:' . $movie->title . '<br/>';
	echo 'Author:' . $movie->author . '<br/>';
	echo 'Description:' . $movie->description . '<br/>';
	
	echo $template->showFooter();

?>
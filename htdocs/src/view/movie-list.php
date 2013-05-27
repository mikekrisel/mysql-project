<?php 
	
	$template = new template\Template();
	$template->showHead("My Movies");
	
	$content = "";
	foreach ($movies as $title => $movie)
	{
		$content .= '<a href="/'.$_SESSION['username'].'/movie/'.$movie->URL.'/">'.$movie->title.'</a></td><td>'.$movie->description.'</td><td>'.$movie->movieYear.'<br />';
	}
	
	$template->showBodyThird($content);
	$template->showFooter();

?>
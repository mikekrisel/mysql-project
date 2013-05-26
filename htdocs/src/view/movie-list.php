<?php 
	
	$template = new template\Template();
	$template->showHead("My Movies");
	
	$content = "";
	foreach ($movies as $title => $movie)
	{
		$content .= '<a href="/'.$_SESSION['username'].'/movie/'.$movie->title.'/">'.$movie->title.'</a></td><td>'.$movie->author.'</td><td>'.$movie->description.'<br />';
	}
	
	$template->showBodyThird($content);
	$template->showFooter();

?>
<?php 
	
	$template = new template\Template();
	echo $template->showHead("MySQL Project");
	
	echo "<table>";
	foreach ($movies as $title => $movie)
	{
		echo '<tr><td><a href="movie/'.$movie->title.'/">'.$movie->title.'</a></td><td>'.$movie->author.'</td><td>'.$movie->description.'</td></tr>';
	}
	echo "</table>";
	
	echo $template->showFooter();

?>
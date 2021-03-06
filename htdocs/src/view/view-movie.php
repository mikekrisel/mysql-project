<?php
	
	$template = new template\Template();
	$template->showHead($movie->title);
	
	$content  = ($movie->image == "" ? '' : '<img class="movieimg" src="/images/users/'.$_SESSION['username'].'/'.$movie->image.'" width="200" />').'
		<div id="showmovie">
			<div class="title">'.$movie->title.' ('.$movie->movieYear.')</div>
			<div class="category">'.$movie->category.'</div>
			<div class="description">'.$movie->description.'</div>
			<div><span class="legend">Director</span><span class="value">'.$movie->director.'</span></div>
			<div><span class="legend">Writers</span><span class="value">'.$movie->writers.'</span></div>
			<div><span class="legend">Stars</span><span class="value">'.$movie->stars.'</span></div>
			<div><span class="legend">Purchased</span><span class="value price">'.$movie->cost.'</span></div>
			'.($movie->movieSold != NULL ? '<div><span class="legend">Sold</span><span class="value price">'.$movie->soldPrice.'</span></div>' : '').'
		</div>';
			
	$template->showBodyThird($content);
	
	$template->showFooter();

?>
<?php 
	
	$template = new template\Template();
	$template->showHead("My Movies");
	
	$content = "<h2>My Movies</h2>";
	$data = "";
	foreach ($movies as $title => $movie)
	{
		$data .= '<tr>
			<td><a href="/'.$_SESSION['username'].'/movie/'.$movie->URL.'/">'.$movie->title.'</a></td>
			<td>'.$movie->movieYear.'</td>
			<td>'.$movie->category.'</td>
			<td>'.$movie->director.'</td>
			<td>'.$movie->writers.'</td>
			<td>'.$movie->stars.'</td>
			<td>$'.$movie->cost.'</td>
			<td>'.($movie->movieSold != NULL ? '$' : '').$movie->soldPrice.'</td>
		</tr>';
	}
	
	$content .= '<table cellpadding="0" cellspacing="0" border="0" class="display" id="movie">
	<thead>
		<tr>
			<th width="150">Title</th>
			<th>Release</th>
			<th>Category</th>
			<th>Director</th>
			<th>Writers</th>
			<th>Stars</th>
			<th>Cost</th>
			<th>Sold</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Title</th>
			<th>Release</th>
			<th>Category</th>
			<th>Director</th>
			<th>Writers</th>
			<th>Stars</th>
			<th>Cost</th>
			<th>Sold</th>
		</tr>
	</tfoot>
	<tbody>
		'.$data.'
	</tbody>
</table>';

	$template->showBodyThird($content);
	
	$script = '<script type="text/javascript" language="javascript" src="/scripts/jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$(\'#movie\').dataTable( {
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				} );
			} );
		</script>';
	$template->showFooter($script);

?>
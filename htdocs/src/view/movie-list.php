<?php 
	
	$template = new template\Template();
	$template->showHead("My Movies");
	
	$content = "<h2>My Movies</h2>";
	$data = "";
	foreach ($movies as $title => $movie)
	{
		$data .= '<tr >
			<td><a href="/'.$_SESSION['username'].'/movie/'.$movie->URL.'/" title="View '.$movie->title.'">'.$movie->title.'</a></td>
			<td>'.$movie->movieYear.'</td>
			<td>'.$movie->category.'</td>
			<td>'.$movie->director.'</td>
			<td>'.$movie->writers.'</td>
			<td>'.$movie->stars.'</td>
			<td>$'.$movie->cost.'</td>
			<td>'.($movie->soldPrice != NULL ? '$'.$movie->soldPrice : '').'</td>
			<td class="delete_wrapper"><a href="JavaScript:void(0);" class="delete" onClick="deleteMovie('.$movie->ID.', this);" title="Delete '.$movie->title.'">X</a>'.($movie->NetGainLoss != NULL ? ($movie->NetGainLoss <= 0 ? '<span class="red">$'.$movie->NetGainLoss.'</span>' : '$'.$movie->NetGainLoss) : '').'</td>
		</tr>';
	}
	function isPositive($number) {
    return is_numeric($number) && ($number >= 0);
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
			<th>Gain/Loss</th>
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
			<th>Gain/Loss</th>
		</tr>
	</tfoot>
	<tbody>
		'.$data.'
	</tbody>
</table>';

	$template->showBodyThird($content);
	
	$script = '<script type="text/javascript" language="javascript" src="/scripts/jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			var oTable = "";
			$(document).ready(function() {
				oTable = $(\'#movie\').dataTable( {
					"bJQueryUI": true,
					"sPaginationType": "full_numbers"
				} );
			} );
			function deleteMovie(ID, obj) {
				oTable.fnDeleteRow(oTable.fnGetPosition(obj.parentNode.parentNode));
				$.post(\'/src/model/delete.php\', { movieID: ID });
			};
		</script>';
	$template->showFooter($script);

?>
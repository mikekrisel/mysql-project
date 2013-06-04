<?php
	
	echo '<!DOCTYPE html>
<html>
<title>Metrics</title>
<style type="text/css">
	#debug{color:#000; width:100%;margin:1em 0;}
	#debug th {background:#CCC; border:1px #FFF solid; padding:5px 10px; white-space:nowrap; text-align: left;}
	#debug td {background:#E2E4FF; border:1px #FFF solid; padding:5px 10px; text-align: left; vertical-align:text-top;}
</style>
<body>';
	
	$content  = '<h2>Metrics</h2>';
	// using metrics
	$statements = array (
		"performance_metrics" => "SELECT * FROM information_schema.innodb_metrics;"
	);
	$metrics = array();
	foreach ($statements as $key => $statement) {
		$query = $this->db->query($statement);
		$result = $query;
		$metrics[$key] = $result;
	}
	$content .= '<table cellpadding="0" cellspacing="0" border="0" id="debug">
		<tr>
			<th>Name</th>
			<th>Sub System</th>
			<th>Count</th>
			<th>Max Count</th>
			<th>Min Count</th>
			<th>Avg Count</th>
			<th>Count Reset</th>
			<th>Max Count Reset</th>
			<th>Min Count Reset</th>
			<th>Avg Count Reset</th>
			<th>Time Enabled</th>
			<th>Time Disabled</th>
			<th>Time Elapsed</th>
			<th>Time Reset</th>
			<th>Comment</th>
			<th>Type</th>
			<th>Comment</th>
		</tr>';
	foreach ($metrics['performance_metrics'] as $key => $metric) {
		$content .= '<tr>
			<td>'.$metric['NAME'].'</td>
			<td>'.$metric['SUBSYSTEM'].'</td>
			<td>'.$metric['COUNT'].'</td>
			<td>'.$metric['MAX_COUNT'].'</td>
			<td>'.$metric['MIN_COUNT'].'</td>
			<td>'.$metric['AVG_COUNT'].'</td>
			<td>'.$metric['COUNT_RESET'].'</td>
			<td>'.$metric['MAX_COUNT_RESET'].'</td>
			<td>'.$metric['MIN_COUNT_RESET'].'</td>
			<td>'.$metric['AVG_COUNT_RESET'].'</td>
			<td>'.$metric['TIME_ENABLED'].'</td>
			<td>'.$metric['TIME_DISABLED'].'</td>
			<td>'.$metric['TIME_ELAPSED'].'</td>
			<td>'.$metric['TIME_RESET'].'</td>
			<td>'.$metric['STATUS'].'</td>
			<td>'.$metric['TYPE'].'</td>
			<td>'.$metric['COMMENT'].'</td>
		</tr>';
	}
	$content .= '</table>';
	
	echo $content;
	echo '</body>
	</html>';
?>
<?php
	
	echo '<!DOCTYPE html>
<html>
<title>Debug</title>
<style type="text/css">
	#debug{color:#000; width:100%;margin:1em 0;}
	#debug th {background:#CCC; border:1px #FFF solid; padding:5px 10px; white-space:nowrap; text-align: left;}
	#debug td {background:#E2E4FF; border:1px #FFF solid; padding:5px 10px; text-align: left; vertical-align:text-top;}
</style>
<body>';
	
	$content  = '<h2>Debug</h2>';
	// using debug profiles
	$statements = array (
		"profiling_start" => "set profiling = 1;",
		"query_1" => "SELECT category_list('".$_SESSION['ID']."') AS Categories;",
		"show_profile_1" => "show profile for query 1;",
		"query_2" => "SELECT
	FirstName,
	LastName,
	Email,
	AccountDescription		
	FROM accounts
	WHERE ID = '".$_SESSION['ID']."' 
	AND UserName = '".$_SESSION['username']."';",
		"show_profile_2" => "show profile for query 2;",
		"query_3" => "SELECT 
	ID,
	Title,
	Description,
	MovieYear,
	Category,
	Director,
	Writers,
	Stars,
	Cost, 
	SoldPrice,
	Image,
	MovieAdded,
	MovieSold,
	totals_loss_gain(Cost, SoldPrice) AS NetGainLoss
	FROM all_account_movies
	WHERE AccountID = '".$_SESSION['ID']."';",
		"show_profile_3" => "show profile for query 3;",
		"query_4" => "SELECT 
	ID, 
	COUNT(UserName) AS count 
	FROM accounts;",
		"show_profile_4" => "show profile for query 4;",
		"query_5" => "SELECT
	COUNT(Title) AS count
	FROM all_account_movies 
	WHERE AccountID = '".$_SESSION['ID']."'
	AND Title = 'title';",
		"show_profile_5" => "show profile for query 5;",
		"all_profiles" => "show profiles;",
		"profile_unset" => "set profiling = 0;"
	);
	$profiles = [];
	foreach ($statements as $key => $statement) {
		$query = $this->db->query($statement);
		$result = $query;
		$profiles[$key] = $result;
	}
	$content .= '<table cellpadding="0" cellspacing="0" border="0" id="debug">
		<tr>
			<th>Query_ID</th>
			<th>Duration</th>
			<th>Query</th>
		</tr>';
	foreach ($profiles['all_profiles'] as $key => $profile) {
		$content .= '<tr>
			<td>'.$profile['Query_ID'].'</td>
			<td>'.$profile['Duration'].'</td>
			<td><pre>'.$profile['Query'].'</pre></td>
		</tr>';
	}
	$content .= '</table>';
	
	echo $content;
	echo '</body>
	</html>';
?>
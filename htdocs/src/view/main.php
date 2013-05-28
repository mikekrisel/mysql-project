<?php 

	$template = new template\Template();
	$template->showHead("MySQL Project");
	
	if (!isset($content)) {
		$content = '<h2>'.$account->firstName.' '.$account->lastName.'</h2>
			<p>'.$account->accountDescription.'</p>';
		
		// using the category_list() Function
		$query = $this->db->query("SELECT category_list('".$_SESSION['ID']."') AS Categories");
		$result = $query[0];
		$categories = explode(", ", $result['Categories']);
		if (count($categories) > 1) {
			$content .= '<h4>Popular Categories</h4><p>';
			foreach($categories as $category) {
				$content .= '<span class="badge">'.$category.'</span>';
			}
		}
		$content .= '</p>';
	}
	
	$template->showBodyThird($content);
	$template->showFooter();

?>
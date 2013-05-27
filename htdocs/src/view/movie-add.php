<?php 

	$template = new template\Template();
	$template->showHead("Add a Movie Title");
	
	$content = "";
	$form = '<form id="myForm" name="create" method="POST">
		<div><label>Title</label><input type="text" class="required" name="title" value="'.(isset($_POST['title']) ? $_POST['title'] : "").'" /></div>
		<div><label>Year Released</label><input type="text" class="required" name="movieYear" value="'.(isset($_POST['movieYear']) ? $_POST['movieYear'] : "").'" /></div>
		<div><label>Category(s)</label><input type="text" class="required" name="category" value="'.(isset($_POST['category']) ? $_POST['category'] : "").'" /></div>
		<div><label>Director</label><input type="text" class="required" name="director" value="'.(isset($_POST['director']) ? $_POST['director'] : "").'" /></div>
		<div><label>Writer(s)</label><input type="text" class="required" name="writers" value="'.(isset($_POST['writers']) ? $_POST['writers'] : "").'" /></div>
		<div><label>Star(s)</label><input type="text" class="required" name="stars" value="'.(isset($_POST['stars']) ? $_POST['stars'] : "").'" /></div>
		<div><label>Cost</label><input type="text" class="required" name="cost" value="'.(isset($_POST['cost']) ? $_POST['cost'] : "").'" /></div>
		<div><label>Image</label><input type="file" name="image" value="'.(isset($_POST['image']) ? $_POST['image'] : "").'" /></div>
		<div><label>Description</label><textarea name="description">'.(isset($_POST['description']) ? $_POST['description'] : "").'</textarea><br />
		<input type="submit" value="submit" />
	</form>';
	
	if (isset($_POST['title'])) {
		$title = $this->db->escape_string($_POST['title']);
		if (!preg_match("([^A-Za-z0-9-_'\", .!:#*]+|^$)", $title)) {
			// trim and escape the string for insert
			$description = $this->db->escape_string($_POST['description']);
			// enforce numbers
			if (!preg_match("([^0-9]+)", $_POST['movieYear'])) {
				$movieYear = $this->db->escape_string($_POST['movieYear']);
			} else {
				$error .= '<span class="error">&raquo; The Movie Year can only use numbers.</span><br />';
			}
			$category = $this->db->escape_string($_POST['category']);
			$director = $this->db->escape_string($_POST['director']);
			$writers = $this->db->escape_string($_POST['writers']);
			$stars = $this->db->escape_string($_POST['stars']);
			// enforce numbers
			if (!preg_match("([^0-9,.£\$]+)", $_POST['cost'])) {
				$cost = $this->db->escape_string($_POST['cost']);
			} else {
				$error .= '<span class="error">&raquo; The Cost can only use numbers.</span>';
			}
			$image = $this->db->escape_string($_POST['image']);
			
			if (isset($error)) {
				$content .= $error.$form;
			} else {
				// using a transaction and commit
				$statements = array (
					"INSERT INTO movies VALUES 
						(DEFAULT, '".$title."', '".$description."', '".$movieYear."', '".$category."', '".$director."', '".$writers."', '".$stars."', '".$cost."', DEFAULT, '".$image."', CURDATE(), DEFAULT);",
					"INSERT INTO accounts_movies VALUES
						(DEFAULT, '".$_SESSION['ID']."', LAST_INSERT_ID());"
					);
				$insert = $this->db->transaction($statements);
				foreach ($insert as $key => $values) {
					if ($values != 1) {
						$status = '<span class="error">&raquo; There was an error in adding "'.$title.'". Please try submitting again.</span>';
					} else {
						$status = '<span class="success">"'.$title.'" has been successfully added.</span>';
					}
				}
				$content = $status.'</span>'.$form;
			}
		} else {
			$content .= '<span class="error">&raquo; The Title contains a bad character.</span>'.$form;
		}
	} else {
		$content = $form;
	}
	
	$template->showBodyThird($content);
	$template->showFooter();

?>
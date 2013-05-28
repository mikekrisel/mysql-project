<?php 

	$template = new template\Template();
	$template->showHead("Add a Movie Title");
	
	$content = "";
	$status = "";
	$error = "";
	$form = '<fieldset>
		<form id="myForm" enctype="multipart/form-data" name="create" method="POST">
			<div><label>Title</label><input type="text" class="required" name="title" value="'.(isset($_POST['title']) ? $_POST['title'] : "").'" /></div>
			<div><label>Year Released</label><input type="text" class="required" name="movieYear" value="'.(isset($_POST['movieYear']) ? $_POST['movieYear'] : "").'" /></div>
			<div><label>Category(s)</label><input type="text" class="required" name="category" value="'.(isset($_POST['category']) ? $_POST['category'] : "").'" /></div>
			<div><label>Director</label><input type="text" class="required" name="director" value="'.(isset($_POST['director']) ? $_POST['director'] : "").'" /></div>
			<div><label>Writer(s)</label><input type="text" class="required" name="writers" value="'.(isset($_POST['writers']) ? $_POST['writers'] : "").'" /></div>
			<div><label>Star(s)</label><input type="text" class="required" name="stars" value="'.(isset($_POST['stars']) ? $_POST['stars'] : "").'" /></div>
			<div><label>Cost</label><input type="text" class="required" name="cost" value="'.(isset($_POST['cost']) ? $_POST['cost'] : "").'" /></div>
			<div><label>Image</label><input type="file" name="image" value="'.(isset($_FILES['image']['name']) ? $_FILES['image']['name'] : "").'" /></div>
			<div><label>Description</label><textarea name="description">'.(isset($_POST['description']) ? $_POST['description'] : "").'</textarea><br />
			<input type="submit" value="submit" />
		</form>
	</fieldset>';
	
	if (isset($_POST['title'])) {
		$titleDisplay = trim($_POST['title']);
		if (!preg_match("([^A-Za-z0-9-_'\", .!:#*]+|^$)", $titleDisplay)) {
			// trim and escape the string for insert
			$title = $this->db->escape_string($titleDisplay);
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
			if (!preg_match("([^0-9,.]+)", $_POST['cost'])) {
				$cost = $this->db->escape_string($_POST['cost']);
			} else {
				$error .= '<span class="error">&raquo; The Cost can only use numbers.</span><br />';
			}
			$image = $this->db->escape_string($_FILES['image']['name']);
			
			// check to see if the title already exists using stored procedure view
			$query = $this->db->query("SELECT
				COUNT(Title) AS count
				FROM all_account_movies 
				WHERE AccountID = 1
				AND Title = '".$titleDisplay."';");
			$result = $query[0];
			if ($result['count'] == 1) {
				// show error message
				$error .= '<span class="error">&raquo; You\'re being silly. You already have that movie.</span><br />';
			}
			
			if ($error != "") {
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
				// include image upload processing
				include "src/upload/upload.php";
				
				foreach ($insert as $key => $values) {
					if ($values != 1) {
						$error = TRUE;
					} else {
						$error = FALSE;
					}
				}
				if ($error) {
					$status .= '<span class="error">&raquo; There was an error in adding "'.$title.'". Please try submitting again.</span><br />';
				} else {
					$status .= '<span class="success">Movie "'.$titleDisplay.'" has been successfully added.</span><br />';
				}
				$content = $status.$form;
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
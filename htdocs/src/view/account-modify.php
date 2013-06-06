<?php 
	
	$template = new template\Template();
	$template->showHead("Modify Account");
	
	$content = '<h2 class="fieldset">Modify Account</h2>';
	$formDelete = '<fieldset>
		<form id="myForm" name="create" method="POST">
			<p>You\'re about to delete your account. Select <i>Yes</i> to confirm, or <i>No</i> to go back.</p>
			<div><label>User Name</label><input type="hidden" name="ID" value="'.$account->ID.'" /><input type="text" name="setusername" value="'.(isset($_POST['setusername']) ? $_POST['setusername'] : $account->userName).'" readonly="readonly" /></div>
			<div><label>Yes</label><input type="radio" name="confirm" value="yes" /></div>
			<div><label>No</label><input type="radio" name="confirm" value="no" checked="checked" /></div>
			<input type="submit" name="delete" class="delete" value="delete" />
		</form>
	</fieldset>';
	$form = '<fieldset>
		<form id="myForm" name="create" method="POST">
			<div><label>User Name</label><input type="hidden" name="ID" value="'.$account->ID.'" /><input type="text" name="setusername" value="'.(isset($_POST['setusername']) ? $_POST['setusername'] : $account->userName).'" readonly="readonly" /></div>
			<div><label>Password</label><input type="password" name="password" /></div>
			<div><label>First Name</label><input type="text" name="firstname" value="'.(isset($_POST['firstname']) ? $_POST['firstname'] : $account->firstName).'" /></div>
			<div><label>Last Name</label><input type="text" name="lastname" value="'.(isset($_POST['lastname']) ? $_POST['lastname'] : $account->lastName).'" /></div>
			<div><label>Email</label><input type="text" class="required email" name="email" value="'.(isset($_POST['email']) ? $_POST['email'] : $account->email).'" /></div>
			<div><label>Description</label><textarea name="description">'.(isset($_POST['description']) ? $_POST['description'] : $account->accountDescription).'</textarea><br />
			<input type="submit" value="update" />
			<input type="submit" name="delete" class="delete" value="delete" />
		</form>
  </fieldset>';
	
	if (isset($_POST['setusername'])) {
		$userName = trim($_POST['setusername']);
		if ($_SESSION['ID'] == $_POST['ID'] && $_SESSION['username'] == $userName) {
			$ID = $this->db->escape_string($_POST['ID']);
			if (isset($_POST['delete'])) {
				$content = '<h2 class="fieldset">Delete Account</h2>'.$formDelete;
				if (isset($_POST['confirm']) && $_POST['confirm'] == "yes") {
					// query users movies, to remove those records after having been unjoined from accounts and accounts_movies
					$query = $this->db->query("SELECT 
						ID
						FROM all_account_movies
						WHERE AccountID = '".$ID."';");
					$result = $query;
					// using the before_delete_customer trigger
					$delete = $this->db->query("DELETE 
						FROM accounts 
						WHERE ID = '".$ID."'
						AND UserName = '".$_SESSION['username']."';");
					// delete their movies from the database
					foreach ($result as $movie) {
						$delete = $this->db->query("DELETE 
							FROM movies 
							WHERE ID = '".$movie['ID']."';");
					}
					// kill the session
					session_destroy();
					header('Location: /');
				} 
				if (isset($_POST['confirm']) && $_POST['confirm'] == "no") {
					unset($_POST);
					header('Location: /'.$_SESSION['username'].'/modify-account/');
				}
			} else {
				// trim and escape the string for update
				$firstName = $this->db->escape_string($_POST['firstname']);
				$lastName = $this->db->escape_string($_POST['lastname']);
				$email = $this->db->escape_string($_POST['email']);
				$password = $this->db->escape_string($_POST['password']);
				$description = $this->db->escape_string($_POST['description']);
				// update the database
				if ($password != "") {
					$password = "Password = SHA1(CONCAT('".$password."', salt)),";
				} else {
					$password = "";
				}
				// using a update the database
				$update = $this->db->query("UPDATE
					accounts
					SET
					FirstName = '".$firstName."',
					LastName = '".$lastName."',
					Email = '".$email."',
					".$password."
					AccountDescription = '".$description."'
					WHERE ID = '".$ID."'
					AND UserName = '".$_SESSION['username']."';");
				$content .= $form;
			}
		} else {
					$content .= '<span class="error">&raquo; Update failed.</span>'.$form;
		}
	} else {
		$content .= $form;
	}
	
	$template->showBodyThird($content);
	$template->showFooter();

?>
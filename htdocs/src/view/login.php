<?php 
	
	$template = new template\Template();
	$template->showHead("MySQL Project", false);
	
	$content = "";
	$form = '<form name="login" method="POST">
	<label>User Name</label><input type="text" name="username" /><br />
	<label>Password</label><input type="password" name="password" /><br />
	<input type="submit" value="submit" />
</form>
<br />
<a href="JavaScript:void(0);">Get a Username</a>
<div id="showform">
	<form name="create" method="POST">
		<label>User Name</label><input type="text" name="setusername" /><br />
		<label>Password</label><input type="password" name="password" /><br />
		<label>First Name</label><input type="text" name="firstname" /><br />
		<label>Last Name</label><input type="text" name="lastname" /><br />
		<label>Email</label><input type="text" name="email" /><br />
		<label>About</label><textarea name="about"></textarea><br />
		<input type="submit" value="submit" />
	</form>
</div>';
	
	if (isset($_POST['username'])) {
		$userName = trim($_POST['username']);
		$password = trim($_POST['password']);
		if (!preg_match("([^A-Za-z0-9-_]+|^$)", $userName)) {
			// query the database
			$query = $this->db->query("SELECT 
				ID, 
				COUNT(UserName) AS count 
				FROM accounts 
				WHERE UserName = '".$userName."' 
				AND Password = SHA1(CONCAT('".$password."', salt))");
			$result = $query[0];
			if ($result['count'] == 1) {
				$_SESSION['ID'] = $result['ID'];
				$_SESSION['username'] = $userName;
				header('Location: /'.$_SESSION['username'].'/');			
			} else {
			// show error message
			$content = '<span class="error">&raquo; The User Name or Password you entered is incorrect.</span>'.$form;
			}
		} else {
			$content = '<span class="error">&raquo; The User Name or Password you entered is incorrect.</span>'.$form;
		}
	} else if (isset($_POST['setusername'])) {
		$userName = trim($_POST['setusername']);
		if (!preg_match("([^A-Za-z0-9-_]+)", $userName)) {
			// trim and escape the string for insert
			$firstName = $this->db->escape_string($_POST['firstname']);
			$lastName = $this->db->escape_string($_POST['lastname']);
			$email = $this->db->escape_string($_POST['email']);
			$password = $this->db->escape_string($_POST['password']);
			$about = $this->db->escape_string($_POST['about']);
			// using the add_account stored procedure
			$insert = $this->db->query("call add_account('".$userName."', '".$firstName."', '".$lastName."', '".$email."', '".$password."', '".$about."', @error)");
			$id = $insert[0];
			$query = $this->db->query("select @error");
			$error = $query[0];
			if ($error) {
				foreach($error as $value) {
					$content .= '<span class="error">&raquo; '.$value.'</span>'.$form;
				}
			} else {
				$id = $insert[0];
				$_SESSION['ID'] = $id;
				$_SESSION['username'] = $userName;
				header('Location: /'.$_SESSION['username'].'/');
			}
		} else {
			header('Location: /');
		}
	} else {
		$content = $form;
	}
	
	$template->showBodyThird($content);
	$template->showFooter();

?>
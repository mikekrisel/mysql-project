<?php 
	
	$template = new template\Template();
	$template->showHead("MySQL Project", false);
	
	$content = '<h2 class="fieldset">Login</h2>';
	$specialCSS = '<style tpye="text/css">#showform{display:block;}</style>';
	$form = '<fieldset>
		<form name="login" method="POST">
			<label>User Name</label><input type="text" name="username" value="'.(isset($_POST['username']) ? $_POST['username'] : "").'" /><br />
			<label>Password</label><input type="password" name="password" /><br />
			<input type="submit" value="submit" />
		</form>
	</fieldset>
<br />
<a href="JavaScript:void(0);" id="show">Create an Account &raquo;</a>
<div id="showform">
	<fieldset>
		<form id="myForm" name="create" method="POST">
			<div><label>User Name</label><input type="text" class="required" name="setusername" value="'.(isset($_POST['setusername']) ? $_POST['setusername'] : "").'" /></div>
			<div><label>Password</label><input type="password" class="required" name="password" /></div>
			<div><label>First Name</label><input type="text" class="required" name="firstname" value="'.(isset($_POST['firstname']) ? $_POST['firstname'] : "").'" /></div>
			<div><label>Last Name</label><input type="text" class="required" name="lastname" value="'.(isset($_POST['lastname']) ? $_POST['lastname'] : "").'" /></div>
			<div><label>Email</label><input type="text" class="required email" name="email" value="'.(isset($_POST['email']) ? $_POST['email'] : "").'" /></div>
			<div><label>Description</label><textarea name="description">'.(isset($_POST['description']) ? $_POST['description'] : "").'</textarea><br />
			<input type="submit" value="submit" />
		</form>
  </fieldset>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(\'#show\').click(function() {
			$(\'#showform\').toggle();
		});
	});
</script>';
	
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
				AND Password = SHA1(CONCAT('".$password."', salt));");
			$result = $query[0];
			if ($result['count'] == 1) {
				$_SESSION['ID'] = $result['ID'];
				$_SESSION['username'] = $userName;
				header('Location: /'.$_SESSION['username'].'/');			
			} else {
			// show error message
			$content = $content.'<span class="error">&raquo; The User Name or Password you entered is incorrect.</span>'.$form;
			}
		} else {
			$content = $content.'<span class="error">&raquo; The User Name or Password you entered is incorrect.</span>'.$form;
		}
	} else if (isset($_POST['setusername'])) {
		$userName = trim($_POST['setusername']);
		if (!preg_match("([^A-Za-z0-9-_]+|^$)", $userName)) {
			// trim and escape the string for insert
			$firstName = $this->db->escape_string($_POST['firstname']);
			$lastName = $this->db->escape_string($_POST['lastname']);
			$email = $this->db->escape_string($_POST['email']);
			$password = $this->db->escape_string($_POST['password']);
			$description = $this->db->escape_string($_POST['description']);
			// using the add_account stored procedure
			$insert = $this->db->query("call add_account('".$userName."', '".$firstName."', '".$lastName."', '".$email."', '".$password."', '".$description."', @error);");
			$ID = $insert[0]['ID'];
			// check for errors
			$query = $this->db->query("select @error;");
			$error = $query[0];
			if ($error) {
				foreach($error as $value) {
					$content .= '<span class="error">&raquo; '.$value.'</span>'.$specialCSS.$form;
				}
			} else {
				$_SESSION['ID'] = $ID;
				$_SESSION['username'] = $userName;
				header('Location: /'.$_SESSION['username'].'/');
			}
		} else {
					$content .= '<span class="error">&raquo; The User Name can only use letters (a-z), numbers, underscors and hyphens.</span>'.$specialCSS.$form;
		}
	} else {
		$content .= $form;
	}
	
	$template->showBodyThird($content);
	$template->showFooter();

?>
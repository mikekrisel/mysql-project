<?php

// error_reporting(E_ALL);

// we first include the upload class, as we will need it here to deal with the uploaded file
include "class_upload.php";

// set variables
// works $dir_dest = (isset($_POST['dir']) ? $_POST['dir'] : 'src/upload/test');
$dir_dest = (isset($_POST['dir']) ? $_POST['dir'] : 'images/users/'.$_SESSION['username']);
$dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $dir_dest);

if (isset($_FILES['image']['name'])) {

	// ---------- SIMPLE UPLOAD ----------

	// we create an instance of the class, giving as argument the PHP object
	// corresponding to the file field from the form
	// All the uploads are accessible from the PHP object $_FILES
	$handle = new Upload($_FILES['image']);

	// then we check if the file has been uploaded properly
	// in its *temporary* location in the server (often, it is /tmp)
	if ($handle->uploaded) {

		// yes, the file is on the server
		// below are some example settings which can be used if the uploaded file is an image.
		$handle->image_resize            = true;
		$handle->image_ratio_y           = true;
		$handle->image_x                 = 300;

		// now, we start the upload 'process'. That is, to copy the uploaded file
		// from its temporary location to the wanted location
		// It could be something like $handle->Process('/home/www/my_uploads/');
		$handle->Process($dir_dest);
		
	// we check if everything went OK
	if ($handle->processed) {
		// everything was fine !
		$status .= '<span class="success">Image uploaded "<a href="/'.$dir_pics.'/' . $handle->file_dst_name . '" target="_blank">' . $handle->file_dst_name . '</a>" (' . round(filesize($handle->file_dst_pathname)/256)/4 . 'KB)</span><br />';
	} else {
		// one error occured
		$status .= '<span class="error">Image not uploaded. ' . $handle->error . '</span><br />';
	}

	// we delete the temporary files
	$handle-> Clean();

	} else {
		// if we're here, the upload file failed for some reasons
		// i.e. the server didn't receive the file
		$status .= '<span class="error">Image not uploaded. ' . $handle->error . '</span><br />';
	}
}

?>

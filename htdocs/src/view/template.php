<?php

/**
 * @namespace template
 **/
namespace template;

class Template {
	public $title;
	
	public function showHead($title) {
		$this->title = $title;
		$html = "<!DOCTYPE html>
<html>
	<head>
		<title>".$this->title."</title>
		<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/style.css\">
	</head>
	<body>
		<h1>".$this->title."</h1>";
		return $html;
	}
	
	public function showFooter() {
		$html = "	</body>
</html>";
		return $html;
	}
	
}

?>
<?php

/**
 * @namespace template
 **/
namespace template;

class Template {
	public $title;
	public $content;
	
	public function showHead($title, $menu=true) {
		$this->title = $title;
		$html = '<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<title>'.$this->title.'</title>
<meta charset="iso-8859-1">
<link rel="stylesheet" href="/styles/table_jui.css" type="text/css">
<link rel="stylesheet" href="/styles/jquery-ui-1.8.4.custom.css" type="text/css">
<link rel="stylesheet" href="/styles/layout.css" type="text/css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
</head>
<body>
<div class="wrapper row1">
  <header id="header" class="clear">
    <hgroup>
      <h1><a href="/'.(isset($_SESSION['username']) ? $_SESSION['username'] : '').'">MySQL Project</a></h1>
      <h2>A Movie Database</h2>
    </hgroup>
    <nav>
      <ul>
        <li><a href="/'.(isset($_SESSION['username']) ? $_SESSION['username'] : '').'">Home</a></li>
        <li><a href="/about">About</a></li>
				'.($menu == false ||  !isset($_SESSION['username']) ? '' : '
        <li><a href="/'.$_SESSION['username'].'/movie-list/">My Movies</a></li>
        <li><a href="/'.$_SESSION['username'].'/add-movie/">Add Movies</a></li>
        <li><a href="/logout/">Log Out</a></li>').'
      </ul>
    </nav>
    <div class="clear"></div>
  </header>
</div>';
		echo $html;
	}
	
	public function showBodyTwoThird($content) {
		$this->content = $content;
		$html = '<div class="wrapper row2">
	<div id="container">
		<section class="clear">
			<div class="one_third">
				<h2>'.$this->title.'</h2>
				<p></p>
			</div>
			<div class="two_third lastbox">
				<p>'.$this->content.'</p>
			</div>
		</section>
	</div>
</div>';
		echo $html;
	}
	
	public function showBodyThird($content) {
		$this->content = $content;
		$html = '<div class="wrapper row2">
	<div id="container">
		<section class="last clear">
			<div class="three_third">
				'.$this->content.'
			</div>
		</section>
	</div>
</div>';
		echo $html;
	}

	public function showFooter($script="") {
		$html = '<div class="wrapper row3">
  <footer id="footer">
    <p class="fl_right">Template by <a href="http://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
    <div class="clear"></div>
  </footer>
</div>
<script src="/scripts/validate.js"></script>'.$script.'
</body>
</html>';
		echo $html;
	}
	
}

?>
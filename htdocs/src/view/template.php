<?php

/**
 * @namespace template
 **/
namespace template;

class Template {
	public $title;
	public $content;
	
	public function showHead($title) {
		$this->title = $title;
		$html = '<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<title>'.$this->title.'</title>
<meta charset="iso-8859-1">
<link rel="stylesheet" href="/styles/layout.css" type="text/css">
</head>
<body>
<div class="wrapper row1">
  <header id="header" class="clear">
    <hgroup>
      <h1><a href="/">MySQL Project</a></h1>
      <h2>A Movie Database</h2>
    </hgroup>
    <nav>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="/movie-list/">My Movies</a></li>
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
				<h2>'.$this->title.'</h2>
				<p>'.$this->content.'</p>
			</div>
		</section>
	</div>
</div>';
		echo $html;
	}

	public function showFooter() {
		$html = '<div class="wrapper row3">
  <footer id="footer">
    <p class="fl_right">Template by <a href="http://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
    <div class="clear"></div>
  </footer>
</div>
</body>
</html>';
		echo $html;
	}
	
}

?>
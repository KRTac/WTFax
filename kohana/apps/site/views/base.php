<?php

echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>'.$title.'</title>
	<link type="text/css" rel="stylesheet" media="all" href="/static/css/main.css" />';

$onload = $inline = false;

foreach ($scripts as $script) {
	switch ($script['type']) {
	case 'file':
		echo '
	<script type="text/javascript" src="'.$script['script'].'"></script>';
		break;

	case 'onload':
		$onload .= "\n".$script['script']."\n";
		break;

	case 'inline':
		$inline .= "\n".$script['script']."\n";
		break;
	}
}

if ($inline || $onload) {
	echo '
	<script type="text/javascript">
	//<![CDATA[
		'.$inline.
		($onload ? '
		$(document).ready(function () {'.$onload.'
		});' : false).'
	//]]>
	</script>';
}

echo '
</head>
<body>
<div id="container">
	<div id="header">
		<div class="logo">
			<h1><a href="/">WTFax</a></h1>
		</div>
		<form class="search" action="/trazi" method="get">
			<div>
				<input type="text" name="q" value="'.$search_query.'" />
				<input type="submit" value="" />
			</div>
		</form>
	</div>
	<ul id="nav">'.($user
		? '
		<li><a href="/moje"'.($active_menu_item == 'my' ? ' class="active"' : '').'>Moje obavijesti</a></li>'
		: '').'
		<li><a href="/sve"'.($active_menu_item == 'all' ? ' class="active"' : '').'>Sve obavijesti</a></li>
	</ul>
	<div id="content"'.($sidebar ? '' : ' class="no_sidebar"').'>'.$sidebar.$content.'
		<div class="clear_both"></div>
	</div>
</div>
</body>
</html>';

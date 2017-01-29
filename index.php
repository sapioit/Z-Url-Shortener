<?php
/*--=----|----=----|----=----|----=----|----=----|----=--*/
/* App: link shortner */
require_once("api.php");

echo '
<!DOCTYPE html>
<html>
	<head>
		<title>.$settings->title().</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<form action="" method="get">
			<a href=".$settings->homepage()." class="logo-big"></a>
			<input type="text" name="_url" placeholder="URL to shorten"/ enctype="application/x-www-form-urlencoded">
			<input type="submit" name="_do" value="Shorten!"/>
		</form>
		'.prettyGet().'
	</body>
</html>
';


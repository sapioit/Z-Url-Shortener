<?php
/*--=----|----=----|----=----|----=----|----=----|----=--*/
/* App: link shortner */
require_once ("config.php");

/* If there's a DB name's prefix, it's added, with a _ before */
if( strlen($db_prefix)>0 ) $db_prefix .= "_";

/* connecting to the database */
$db_connection = mysqli_connect(
	$db_host, $db_user, $db_pass, $db_table );

/* checking the connection for failure */
if (mysqli_connect_errno()) {
	echo "Connection to the DB failed. Error "
		. mysqli_connect_errno()
		. mysqli_connect_error();
	die();
}


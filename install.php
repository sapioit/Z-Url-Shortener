<?php
/*--=----|----=----|----=----|----=----|----=----|----=--*/
/* App: link shortner */
require_once("db.php");

/*foreach ($GLOBALS as $var => $val)
	echo "var: <pre>".var_dump($var)."</pre><br/>
	val:<pre>".var_dump($val)."</pre><br/>";*/


/* the querry for creating the table for links */
$query = "CREATE TABLE IF NOT EXISTS `"
	. $db_prefix . "links` (
	id int NOT NULL AUTO_INCREMENT COLLATE utf8_bin,
	code varchar(32) NOT NULL COLLATE utf8_bin,
	link text(32) NOT NULL COLLATE utf8_bin,
	PRIMARY KEY (id)
	);";
/* executing the query */
$processed_query = mysqli_query ($db_connection, $query);
/* checkig the executed query for errors */
if(!$processed_query) {
	echo "Table `" . $db_prefix . "links` could not be created.<br/> Error ".mysqli_errno($db_connection) . " : " .
		mysqli_error($db_connection) . "<br/><br/>";
	die();
} else {
	echo "Table `" . $db_prefix . "links` successfully created.<br/><br/>";
}


/* the query for creating the table for settings */
$query = "CREATE TABLE IF NOT EXISTS `"
	. $db_prefix . "settings` (
	name varchar(32) NOT NULL COLLATE utf8_bin,
	value text(1024) NOT NULL COLLATE utf8_bin,
	PRIMARY KEY (name),
	UNIQUE KEY (name)
	);";
/* executing the query */
$processed_query = mysqli_query ($db_connection, $query);
/* checkig the executed query for errors */
if(!$processed_query) {
	echo "Table `" . $db_prefix . "settings` could not be created.<br/> Error ".mysqli_errno($db_connection) . " : " .
		mysqli_error($db_connection) . "<br/><br/>";
	die();
} else {
	echo "Table `" . $db_prefix . "settings` successfully created.<br/><br/>";
}




/**
 * generating a random key for the links
 * @return String random code, probably unique
 */
function rand_key($code_length = 13){
	static $rand_chars_options = "0123456789"
		."abcdefghijklmnopqrstuvwxyz"
		."ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$to_return = "";
	for($i=0;$i<$code_length;$i++){
		$max_length =
			strlen($rand_chars_options)-1;
		$char_position = mt_rand(0, $max_length);
		$new_char = $rand_chars_options[ $char_position ];
		$to_return = $to_return . $new_char;
	}
	return $to_return;
}
/* query for inserting example/demo links */
$query = "INSERT INTO `". $db_prefix . "links`
	(code, link) VALUES
	(\"".rand_key()."\", \"http://sapioit.com\"),
	(\"".rand_key()."\", \"http://sapioit.com/youtube\"),
	(\"".rand_key()."\", \"http://sapioit.com/fb\"),
	(\"".rand_key()."\", \"http://devforum.ro\")
	;";
/* executing the query */
$processed_query = mysqli_query ($db_connection, $query);
/* checkig the executed query for errors */
if(!$processed_query) {
	echo "Query failed. <pre>" . $query . "</pre><br/> Error ".mysqli_errno($db_connection) . " : " .
		mysqli_error($db_connection) . "<br/><br/>";
	die();
} else {
	echo "Table `" . $db_prefix . "links` successfully polulated.<br/><br/>";
}




/* query for inserting default settings */
$query = "INSERT IGNORE INTO `". $db_prefix . "settings`
	(name, value) VALUES
	(\"title\", \"Zaldinka\"),
	(\"subtitle\", \"For those who don't know who's Link and who's Zelda!\"),
	(\"admin_mail\", \"sapioit@gmail.com\"),
	(\"admin_name\", \"Suicider\"),
	(\"allow_new_links\", \"true\"),
	(\"allow_new_users\", \"true\"),
	(\"link_length\", \"3\")
	;";
/* executing the query */
$processed_query = mysqli_query ($db_connection, $query);
/* checkig the executed query for errors */
if(!$processed_query) {
	echo "Query failed. <pre>" . $query . "</pre><br/> Error ".mysqli_errno($db_connection) . " : " .
		mysqli_error($db_connection) . "<br/><br/>";
	die();
} else {
	echo "Table `" . $db_prefix . "settings` successfully populated.<br/><br/>";
}

<?php
/*--=----|----=----|----=----|----=----|----=----|----=--*/
/* App: link shortner */
require_once("db.php");

/* Handles encrypting/encoding and decrypting/decoding */
function data_enc_html($something){
	return htmlentities($something);
}
function data_dec_html($something){
	return html_entity_decode($something);
}
function data_enc_url($something){
	return rawurlencode($something);
	return urlencode($something);
}
function data_dec_url($something){
	return rawurldecode($something);
	return urldecode($something);
}

/**
 * Returns the link to the current page
 * @param  string $asked [null, 'full','domain','file','query']
 * @return array|string string if specified, array otherwise
 */
function getURL($asked = null){
	$link = [];
	$link['full'] = "https://" . $_SERVER['HTTP_HOST'] . "<font color='#cc0000'>" . $_SERVER['PHP_SELF'] . "</font>?" . $_SERVER['QUERY_STRING'];
	$link['domain'] = "https://" . $_SERVER['HTTP_HOST'];
	$link['file'] = $_SERVER['PHP_SELF'];
	$link['query'] = $_SERVER['QUERY_STRING'];
	if($asked === "full")
		return $link['full'];
	if($asked === "domain")
		return $link['domain'];
	if($asked === "file")
		return $link['file'];
	if($asked === "query")
		return $link['query'];
	return $link;
}

class api{
	function __construct(){
		global $db_connection, $db_prefix;
		$settings = [];
	}
	/**
	 * Obtains the settings
	 * @param array $settingname containing settings' name and value
	 * @return array containing settings' name and value
	 */
	function getSettings($settingname){ /* Returns the list of settings */
		global $db_connection, $db_prefix;
		//$settingname = data_enc_html($settingname);
		$processed_query = mysqli_query ($db_connection, 'select * from '.$db_prefix.'settings;');
		while($processed_query_row = mysqli_fetch_assoc($processed_query)){
			$settings[$processed_query_row['name']] = $processed_query_row['value'];
			/**/
			echo "<br/>". $processed_query_row['name'] . " : <font color='#cc0000'>". $processed_query_row['value'] . "</font>";
			return $settings;
		}
	}
	/**
	 * Updates the settings
	 * @param Array $new=[] Contains settings' name and value to update
	 */
	function setSettings($new=[]){ /* Updates the list of settings */
		global $db_connection, $db_prefix;
		// takes each of the settings
		foreach ($settings as $name => $value){
			// updates it
			$querry = 'UPDATE `'.$db_prefix.'settings` SET `value`="'.$value.'" WHERE name="'.$name.'";';
			// runs the query
			$processed_query = mysqli_query($db_connection, $query);
			//checks for failure
			if (! $processed_query) {
				die("Updating the ".$name." failed!");
			}
		}
	}
	/**
	 * Obtains the list of links.
	 */
	function getLinks(){ /* Returns the list of links */
		$processed_query = mysqli_query ($db_connection, 'select * from '.$db_prefix.'links;');
		echo "Affected rows: " . mysqli_affected_rows($db_connection);
		echo "<br/>Selected rows: ". mysqli_num_rows($processed_query);
		while($processed_query_row = mysqli_fetch_assoc($processed_query)){
			echo "<br/><font color='#cc0000'>" . $processed_query_row['id'] . "</font> : ". $processed_query_row['code'] . " : <font color='#cc0000'>". $processed_query_row['link'] . "</font>";
		}
	}
};

$a = new api;


// REDIRECTING TO A PAGE

//$to_redirect = "http://localhost/_test/_scripts/01/api.php?_url=http%3A%2F%2Ffuck.it%2Fon%25%2633%3Dz%3F3&_do=Shorten%21&@e=1&!t&~q=t&fd645wefa4v65w";
//$to_redirect = "http://google.RO";
if(isset($to_redirect)){
	header('Location: '.$to_redirect);
	echo '<meta http-equiv="refresh" content="0; url='.$to_redirect.'" />
	<script type="text/javascript">window.location.assign("'.$to_redirect.'");</script>';
}


/**
 * Contains one GET querry
 */
class GetQuerry{
	private $queryKey =null;
	private $queryValue =null;
	/**
	 * Constructs the query from a key/name and a value
	 */
	function __construct($key=null, $value=null){
		$this->queryKey = $key;
		$this->queryValue = $value;
	}
	/**
	 * Checks if this query is a command
	 * @return true if this query is a command
	 * @return false if this querry is NOT a command
	 */
	function isCommand(){
		$queryKey = $this->queryKey;
		if ($queryKey[0]==='_' || $queryKey[0]==='~' || $queryKey[0]==='!' || $queryKey[0]==='-' || $queryKey[0]==='@')
			return true;
		return false;
	}
	/**
	 * Returns the command
	 * @return string the command, if there is one
	 * @return false if there is no command to begin with
	 */
	function command(){
		if (isCommand())
			return $this->queryValue[0];
		return null;
	}
	/**
	 * Returns the query's key
	 * @return string the key/name
	 */
	function key(){
		return $this->queryKey;
	}
	/**
	 * Returns the query's key
	 * @return string the key/name
	 */
	function name(){
		return $this->queryKey;
	}
	/**
	 * Returns the query's value
	 * @return string the value
	 */
	function value(){
		return $this->queryValue;
	}
	/**
	 * Returns the querry's key/name AND value
	 * @return array with the headers 'key' and 'value'
	 */
	function query(){
		$querry = ['key' => $this->queryKey, 'value' => $this->queryValue];
		return $query;
	}
}
/**
 * Returns the GET/URL querries
 * @return array of GetQuerry
 */
function getQuerries($cond = null){
	$querries = [];
	foreach($_GET as $key => $val){
		if(strlen(trim($val))>0){
			$querries[] = new GetQuerry($key, $val);
		}
		else
			$querries[] = new GetQuerry($key);
	}
	if($cond !== null){
		if($cond===''){
			foreach($querries as $query){
				if ($querries[$query]->isCCommand())
					unset($querries[$querries]);
			}
		} else {
			foreach($querries as $query){
				if ($cond !== $querries[$query]->command())
					unset($querries[$querries]);
			}
		}
	}
	return $querries;
}
$querries = getQuerries();
function unshrink($var = []){
	$querries = getQuerries();
	if (count($querries) == 1) {
		// redirect
	} elseif (count($querries)<1){
		// 404
	} elseif (count($querries)>1){
		foreach ($querries as $key => $value){
			// open popups
		}
	}
}


// GET THE SENT DAT
function prettyGet(){
	echo '<pre>';
	echo getURL('full');
	foreach($_GET as $key => $val){
		echo "<br/><br/><b>Name</b>:  <font color='#cc0000'>" . $key . "</font><br/>";
		/* var_dump($key); */
		if(strlen(trim($val))>0){
			echo "<b>Value</b>: <font color='#cc0000'>".$val."</font><br/>";
		}
		/* if(strlen(trim($val))>0)
			 var_dump($val); */
		/* todo: Separate the command type from the name of the command */
		if ($key[0]==='_' || $key[0]==='~' || $key[0]==='!' || $key[0]==='-' || $key[0]==='@')
			echo "<i>Command</i> <font color='#cc0000'>".$key[0]."</font><br/>";
		else
			echo "<i><font color='#cc0000'>NO</font> Command</i> <br/>";
	} // api.php?_url=http%3A%2F%2Ffuck.it%2Fon%25%2633%3Dz%3F3&_do=Shorten%21&@e=1&!t&~q=t&fd645wefa4v65w
	echo '</pre>';
}
function plainGet(){
	echo "<pre>";
	$b=getQuerries();
	foreach($b as $a){
		var_dump( $a->name() );
		var_dump( $a->value() );
		echo "<br/>";
	}
	echo "</pre>";
}


<?php
	//using code implementation from 
	//http://beski.wordpress.com/2009/11/20/jquery-php-mysql-ajax-autocomplete/
	
	require_once "config.php";
	$q = strtolower($_GET["q"]);
	if (!$q) return;
	
	$query = "select DISTINCT skill
?>
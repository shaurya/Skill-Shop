<?php
	session_start();
	$_SESSION = array();
	session_unset(); 
	session_destroy();
	header( 'Location: index.php' ) ;
	//echo "You have successfully logged out!";
?>
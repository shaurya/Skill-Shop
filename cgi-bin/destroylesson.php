<?php
	if($_GET["lessonID"])
	{
		$link = mysql_connect('mysql-user-master.stanford.edu', 'ccs147meseker', 'ceivohng');
		mysql_select_db('c_cs147_meseker');
		$lessonID = mysql_real_escape_string($_GET["lessonID"]);
		$result = mysql_query("DELETE FROM Lessons WHERE lessonID='" . $lessonID . "'");
		header( 'Location: profile.php' );
	}
?>
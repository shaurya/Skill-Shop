<?php
session_start();
if(!isset($_SESSION['logged_in']))
{
	//die("To access this page, you need to <a href='index.php'>LOGIN</a>");
	$_SESSION['login_results'] = "<p class='error'> You need to Login to view this page </p>";
	header( 'Location: index.php' ) ;
}
?>
<html>
<head>
	<?php include 'head.php'?>
</head>
<body>
<?php
	include 'header.php';
?>
<br/>
<br/>
<br/>
<div id="inbox">
	<?php
	require_once 'config.php';
	$link = mysql_connect('mysql-user-master.stanford.edu', 'ccs147meseker', 'ceivohng');
	mysql_select_db('c_cs147_meseker');
	$userID = mysql_real_escape_string($_SESSION['userID']);
	$MAX_MESSAGES = 10;
	/*
	 *Who has the conch for speaking next (like who should speak next!)
	 */
	$threads_in = mysql_query("SELECT * FROM threads WHERE UserIDConch='$userID' ORDER BY timestamp DESC LIMIT $MAX_MESSAGES") or die(mysql_error());
	$threads_out = mysql_query("SELECT * FROM threads WHERE ( (initUserID='$userID' OR receiverUserID='$userID') AND UserIDConch != '$userID') ORDER BY timestamp DESC LIMIT $MAX_MESSAGES") or die(mysql_error());
	echo "<ul data-role='listview' data-inset='true' class='ui-listview ui-listview-inset ui-corner-all ui-shadow'>";
	echo "<li data-role='list-divider' role='heading' class='ui-li ui-li-divider ui-bar-d'>Inbox</li>";
	if (mysql_num_rows($threads_in) == 0) {
		echo "<li data-corners='false' data-shadow='false' data-iconshadow='true' data-theme='d' class='ui-btn'> No incoming messages </li>";
	}
	else{

	//Display all "incoming messages"
	while ($threads_in !=null && $threadrow = mysql_fetch_assoc($threads_in)) {
		$threadID = $threadrow['threadID'];
		//get the freshest message
		$message = mysql_fetch_array(mysql_query("SELECT * from Mail where threadID='$threadID' ORDER BY timestamp DESC LIMIT 1"));
		//Make the li element
		echo "<li data-corners='false' data-shadow='false' data-iconshadow='true' data-wrapperels='div' data-icon='back' data-iconpos='right' data-theme='d' class='ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-up-d'>";
		echo "<a href='messagedisplay.php?thread_id=".$threadID."'>";
		$from_user = mysql_fetch_array(mysql_query("SELECT * FROM Users WHERE userID='".$message['EmailFrom']."'"));
    	echo "<h2 class='ui-li-heading-mail'> From ".$from_user['name']."</h2>";
    	echo "<p class='ui-li-desc-mail'>".$message['Subject']."</p>";
		echo "</a></li>";
		}
	}
	echo "<li data-role='list-divider' role='heading' class='ui-li ui-li-divider ui-bar-d'>Outbox</li>";
	//Display all the "outgoing messages"
	if (mysql_num_rows($threads_out) == 0 ){
		echo "<li data-corners='false' data-shadow='false' data-iconshadow='true' data-theme='d' class='ui-btn'> No outgoing messages </li></ul>";
	}
	else{
	while ($threads_out !=null && $threadrow = mysql_fetch_assoc($threads_out)) {
		$threadID = $threadrow['threadID'];
		//grab the freshest memory, to them, it will be
		$message = mysql_fetch_array(mysql_query("SELECT * from Mail where threadID='$threadID' ORDER BY timestamp DESC LIMIT 1"));
		//Make the li element
		echo "<li data-corners='false' data-shadow='false' data-iconshadow='true' data-wrapperels='div' data-icon='back' data-iconpos='right' data-theme='d' class='ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-btn-up-d'>";
		echo "<a href='messagedisplay.php?thread_id=".$threadID."'>";
		$from_user = mysql_fetch_array(mysql_query("SELECT * FROM Users WHERE userID='".$message['EmailTo']."'"));
		//it's to that user
    	echo "<h2 class='ui-li-heading' style='{color:darkblue;}'> To ".$from_user['name']."</h2>";
    	echo "<p class='ui-li-desc'>".$message['Subject']."</p>";
		echo "</a></li>";
		}
	echo "</ul>";
	}
	?>
</div>
</body>
</html>
<?php
/*Just add the new message and update the timestamp*/
	session_start();
	if(!isset($_SESSION['logged_in']))
	{
		$_SESSION['message'] = "<p class='error'> You need to Login to view this page </p>";
		header( 'Location: index.php' ) ;
	}
	require_once 'config.php';
	$is_ajax = $_REQUEST['is_ajax'];
	if($is_ajax)
	{	
		$reply_message = $_REQUEST['reply_message'];
		$thread_id = $_REQUEST['thread_id'];
		$receiverUserID = $_REQUEST['user_to'];
		$subject = $_REQUEST['subject_reply'];
		$accept_lesson = $_REQUEST['accept_lesson'];
		mysql_query("UPDATE threads SET UserIDConch='$receiverUserID' WHERE threadID='$thread_id'")or die(mysql_error());;
		$thread = mysql_fetch_array(mysql_query("SELECT * FROM threads WHERE threadID='$thread_id'"));
		if( intval($accept_lesson) && $thread['receiverUserID'] == $_SESSION['userID'] ){
			mysql_query("UPDATE threads SET lessonAcceptedTeacher='$accept_lesson' WHERE threadID='$thread_id'")or die(mysql_error());;
		}else 
		if( intval($accept_lesson) )
		{
			mysql_query("UPDATE threads SET lessonAcceptedStudent='$accept_lesson' WHERE threadID='$thread_id'")or die(mysql_error());;			
		}
		mysql_query("INSERT INTO Mail (EmailFrom, EmailTo, Message, Subject, threadID) VALUES ('".$_SESSION['userID']."', '$receiverUserID', '$reply_message', '$subject', '$thread_id')")or die(mysql_error());;
		echo "success";
	}
	else
		$_SESSION['message'] = "<p class='error'> Sorry, we couldn't send that, try again. </p>";
		echo "success";
?>
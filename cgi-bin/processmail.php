<?
if($_POST)
{
	require_once 'config.php';
	//grab the IDs
	$senderID = mysql_real_escape_string($_REQUEST['sender']);
	$receiverID = mysql_real_escape_string($_REQUEST['receiver']);
	//grab the subject and message
	$subject = mysql_real_escape_string($_REQUEST['subject']);
	$message = mysql_real_escape_string($_REQUEST['message']);
	$past_page = mysql_real_escape_string($_REQUEST['past_page']);
	$lesson_id = mysql_real_escape_string($_REQUEST['lesson_id']);
	//put a new thread in
	mysql_query("INSERT INTO threads (initUserID, receiverUserID, UserIDConch, lessonID) VALUES ('$senderID','$receiverID','$receiverID','$lesson_id')") or die(mysql_error());  ;
	$thread = mysql_fetch_array(mysql_query("SELECT * FROM threads WHERE initUserID='$senderID' AND receiverUserID='$receiverID'")) or die(mysql_error());  
	//get the threadID so we can reference it later in with emails
	$threadID = $thread['threadID'];
	//add first mail item
	$query = "INSERT INTO Mail (EmailFrom, EmailTo, Message, Subject, threadID) VALUES ('$senderID', '$receiverID', '$message', '$subject', '$threadID')";
	if(mysql_query($query))
	{
		$_SESSION['message'] = "<p class='success'> Message sent! </p>";
	}
	else
	{
		$_SESSION['message'] = "<p class='error'> I'm sorry, your message was not able to be sent. Try to resend.</p>"; 
	}
	
	header( "Location: " . $past_page );
}
?>

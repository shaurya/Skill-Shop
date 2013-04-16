<?php
	session_start();
	if(!isset($_SESSION['logged_in']))
	{
		//die("To access this page, you need to <a href='index.php'>LOGIN</a>");
		$_SESSION['message'] = "<p class='error'> You need to Login to view this page </p>";
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
	require_once 'config.php';
?>
<br><br>
<?php
	//We're going to do this the same way as in teacher_profile. On top though make sure they are logged in
	if($_GET['thread_id']){
		$thread = mysql_fetch_array(mysql_query("SELECT * FROM threads WHERE threadID='".$_GET['thread_id']."'"));
		//now the magic begins with this threads
		$first_displayed = 0;
		$MAX_MESSAGES = 10;
		//display from the current user that is logged into system
		//we will have to change this in the case that they didn't initiate and are responding
		$userFrom = mysql_fetch_assoc(mysql_query("SELECT * FROM Users WHERE userID='".$thread['initUserID']."'"));
		$userTo = mysql_fetch_assoc(mysql_query("SELECT * FROM Users WHERE userID='".$thread['receiverUserID']."'"));
		if($userFrom['userID'] != $_SESSION['userID'])
		{
			//swap them both
			$temp = $userTo;
			$userTo = $userFrom;
			$userFrom = $temp;
		}
		$_SESSION['name'];
		$messages = mysql_query("SELECT * FROM Mail WHERE threadID='".$_GET['thread_id']."' ORDER BY timestamp DESC LIMIT ".$MAX_MESSAGES."");
		//enumarete through all the messages for that thread and display the top MAX_MESSAGES recent one
		while( $message = mysql_fetch_assoc($messages) ){
			//we are going to display them all with a listview that is static and nonclickable. At the top will be the reply
			if($first_displayed == 0){
				echo "<ul data-role='listview' class='ui-listview'>";
				//display what it is from and to
				echo "<li class='ui-li ui-li-static ui-btn-up-c ui-first-child' data-role='list-divider'>";
				echo "<h2 class='ui-li-heading'> From:".$userFrom['name']."</h2>";
				echo "<p class='ui-li-desc'> Subject: ".$message['Subject']."</p></li>";
				//now add the reply functionality
				echo "<li data-role='fieldcontain' class='ui-field-contain ui-body ui-li ui-li-static'>";
				echo "<form id='accept_form' name='accept_form' action='reply_message.php' method='post'>";
				echo "<input type='hidden' name='accept_thread_id' id='accept_thread_id' value='".$_GET['thread_id']."'>";
				echo "<input type='hidden' name='accept_user_to' id='accept_user_to' value='".$userTo['userID']."'>";
				echo "<input type='hidden' name='accept_subject_reply' id='accept_subject_reply' value='".$message['Subject']."'>";
				echo "<input type='hidden' name='accept_accept_lesson' id='accept_accept_lesson' value='1'>";
				$lesson = mysql_fetch_assoc(mysql_query("SELECT * FROM Lessons WHERE lessonID='".$thread['lessonID']."'"));
				if( $lesson['userID'] == $_SESSION['userID'] ){
					echo "<input type='hidden' name='accept_reply_message' id='subject_reply' value='I accept you as my student'>";
					echo "<input type='submit' id='accept' name='accept' value='Accept Student'></input></form>";
				}else {
					echo "<input type='hidden' name='accept_reply_message' id='subject_reply' value='I accept you as my teacher'>";
					echo "<input type='submit' id='accept' name='accept' value='Accept Teacher'></input></form>";
				}
				echo "<br/><br/>";
				echo "<form id='reply_form' name='reply_form' action='reply_message.php' method='post'>";
				echo "<input type='hidden' name='thread_id' id='thread_id' value='".$_GET['thread_id']."'>";
				echo "<input type='hidden' name='user_to' id='user_to' value='".$userTo['userID']."'>";
				echo "<input type='hidden' name='subject_reply' id='subject_reply' value='".$message['Subject']."'>";
				echo "<input type='hidden' name='accept_lesson' id='accept_lesson' value='0'>";
				echo "<label for='textarea' class='ui-input-text'>";
				echo "<textarea cols='60' rows='8' name='reply_message' id='reply_message' class='ui-input-text ui-body-c ui-shadow-inset'></textarea>";
				echo "<input type='submit' id='reply' name='reply' value='Reply'></input></form>";
				$first_displayed = 1;
			}
			//now go ahead and display the rest of the messages in order by timestamp
			echo "<li class='ui-li ui-li-static ui-btn-up-c'>";
			//put the user logged in name on the left and the to on the right
			echo "<p><b>".$_SESSION['name']."</b></p>";
			//still display the actual message
			echo "<p class='ui-li-desc'>".$message['Message']."</p>";
			//and the timestamp
			echo "<p class='ui-li-aside'>".$message['timestamp']."</p></li>";
		}
		//in the case we fetch back an empty message list (idk how possible too, but possible)
		if($first_displayed == 1)
			echo "</ul>";
	}
	else{
		//they just went here without a valid email
		$_SESSION['message'] = "";
		header( 'Location: mail.php' );
	}

	?>

</div>


<script type="text/javascript">
$(function(){	
	$("#reply").click(function() {
		var action = $("#reply_form").attr("action");
		var form_data = {
			reply_message: $("#reply_message").val(),
			thread_id: $("#thread_id").val(),
			user_to: $("#user_to").val(),
			subject_reply: $("#subject_reply").val(),
			accept_lesson: $("#accept_lesson").val(),
			is_ajax: 1
		};
		console.log("we submitted a reply fo sure");
		$.ajax({
				type: "POST",
				url: action,
				data: form_data,
				success: function(response) {
					if( response == "success")
					{
						location.reload();
					}
					else
					{
						location.reload();
					}
				}
			});
		$(this).popup('close');
		return false;
	});
	$("#accept").click(function() {
		var action = $("#accept_form").attr("action");
		var form_data = {
			reply_message: $("#accept_reply_message").val(),
			thread_id: $("#accept_thread_id").val(),
			user_to: $("#accept_user_to").val(),
			subject_reply: $("#accept_subject_reply").val(),
			accept_lesson: $("#accept_accept_lesson").val(),
			is_ajax: 1
		};
		$.ajax({
				type: "POST",
				url: action,
				data: form_data,
				success: function(response) {
					if( response == "success")
					{
						location.reload();
					}
					else
					{
						location.reload();
					}
				}
			});
		$(this).popup('close');
		return false;
	});
});
</script>
</body>
</html>
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
<?php
$link = mysql_connect('mysql-user-master.stanford.edu', 'ccs147meseker', 'ceivohng');
mysql_select_db('c_cs147_meseker');
$user = mysql_fetch_array(mysql_query("SELECT * FROM Users WHERE userID='" . $_SESSION['userID'] . "'"));

$lessons = mysql_query("SELECT * FROM Lessons WHERE userID='" . $user['userID'] . "'");

$all_inmail = mysql_query("SELECT * FROM Mail WHERE EmailTo='" . $user['email'] . "'");
$num_messages = mysql_num_rows($all_inmail);
?>
<br/>
<br/>
<br/>
	<div id="profile_wrapper">
		<div class="notice_top">
			<?php
			if(isset($_SESSION['notice']))
			{
				echo $_SESSION['notice'];
				unset($_SESSION['notice']);
			} else echo "&nbsp;";
			?>
		</div>
		<div id="second_layer_profile">
			<!--<div id="user_pic_container"><img src="user.png" id="user_pic" /></div>-->
			<!--<div id="personal_info_container">

			</div> -->
			<br/>
			<div class="lesson_info">
					<div class="profile_name_header">I'M TEACHING</div><br/>
					<?php
					if(mysql_num_rows($lessons) >= 1)
					{					
						while($row = mysql_fetch_array($lessons))
						{
							$skill = mysql_fetch_array(mysql_query("SELECT * FROM skills WHERE skillId='" . $row["skillID"] . "'"));
							echo "<div class='profile_lesson_header'>SKILL</div>";
							echo $skill["skillName"] . "<br/><br/>";
							echo "<div class='profile_lesson_header'>Lesson</div>";
							echo $row['lesson_description'] . "<br/><br/>";
							echo "<div class='profile_lesson_header'>Experience</div>";
							echo $row['experience'] . "<br/><br/>";
							echo "<div class='profile_lesson_header'>Cost</div>";
							echo $row['cost'] . "<br/>";
							echo "<form action='editprofile.php' method='post'>";
							echo "<input type='hidden' name='lessonID' value='" . $row['lessonID'] ."'>";
							echo "<input type='hidden' name='dont_update' value='dont_update'>";
							echo "<br/>";
							echo "<div style='float:left;'>";
							echo "<button type='submit'>Edit</button>";
							echo "</div>";
							echo "<div style='float:right;padding-right:20px;'>";
							echo "<a href='destroylesson.php?lessonID=" . $row["lessonID"] . "' data-role='button'>Delete</a>";
							echo "</div>";
							echo "</form>";
							echo "<br/><br/><br/><hr noshade size=1><br/><br/><br/>";
						}
					}
					else
					{
						echo "<br/>Not teaching anything.<br/><br/><br/>";
					}
					?>
				</div>
			<br/>
		</div>

		<div id="third_layer_profile">
			<!--<div class="lesson_info_container">
				
			</div>-->
		<!--<div class="profile_footer">

				<br/>
				<div class="lesson_info">
					<div class="profile_name_header">I'M LEARNING</div><br/>
				</div>
				</table>
		</div>-->
		</div>
</body>
<footer>
<?php
/*$lessons = mysql_query("SELECT * FROM Lessons WHERE userID='" . $user['userID'] . "'");
while($row = mysql_fetch_array($lessons))
{
	echo "<div data-role='popup' id='popupDelete_" . $row["lessonID"] . "' data-overlay-theme='b' data-theme='a' class='ui-corner-all' data-position-to='window' data-dismissable='false'>";
	echo "<div data-role='header' data-theme='a' class='ui-corner-top'>";
	echo "<h1>End Lesson?</h1>";
	echo "</div>";
	echo "<div data-role='content' data-theme='d' class='ui-corner-bottom ui-content'>";
	echo "<h3 class='ui-title'>Are you sure you want to discontinue this lesson?</h3>";
	echo "<p>This action cannot be undone.</p>";
	echo "<a href='#' data-role='button' data-inline='true' data-theme='c' data-rel='back'>Cancel</a>";
	echo "<div style='float:right;'>";
	echo "<a href='#' data-role='button' data-inline='true' data-rel='back' data-transition='flow' data-theme='b'>Delete</a>";  
	echo "</div>";
	echo "</div>";
	echo "</div>";
}*/
?>
</footer>
</html>
<?php
session_start();
if(!isset($_SESSION['logged_in']))
{
	//die("To access this page, you need to <a href='index.php'>LOGIN</a>");
	$_SESSION['login_results'] = "<p class='error'> You need to Login to view this page </p>";
	header( 'Location: index.php' ) ;
}

if($_POST && !$_POST['dont_update'])
{
	require_once 'config.php';
	
	$userID = mysql_real_escape_string($_SESSION['userID']);
	$lessonID = mysql_real_escape_string($_POST['lessonID']);
	
	$skillName = mysql_real_escape_string($_POST['skillName']);
	$skill = mysql_fetch_array(mysql_query("SELECT skillID FROM skills WHERE skillName='" . $skillName . "'"));
	//$skillID = NULL;
	if(!$skill)
	{
		mysql_query("INSERT INTO skills (skillName) VALUES ('" . $skillName . "')");
		$skill = mysql_fetch_array(mysql_query("SELECT skillID FROM skills WHERE skillName='" . $skillName . "'"));
	}
	$skillID = $skill['skillID'];
	$lesson_description = mysql_real_escape_string($_POST['lesson_description']);
	$experience = mysql_real_escape_string($_POST['experience']);
	$cost = mysql_real_escape_string($_POST['cost']);
	if(mysql_query("UPDATE Lessons SET lesson_description='{$lesson_description}',experience='{$experience}',cost='{$cost}',skillID='{$skillID}' WHERE lessonID='{$lessonID}'"))
	{
		$_SESSION['notice'] = "<p class='success'>Lesson updated!</p>";
		header( 'Location: profile.php' );
	} else {
		$_SESSION['notice'] = "<p class='error'>You messed up somewhere</p>";
	}
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

$lessonID = mysql_real_escape_string($_POST['lessonID']);
$lesson = mysql_fetch_array(mysql_query("SELECT * FROM Lessons WHERE lessonID='{$lessonID}'"));
$skill = mysql_fetch_array(mysql_query("SELECT * FROM skills WHERE skillId='" . $lesson['skillID'] . "'"));

//$all_inmail = mysql_query("SELECT * FROM Mail WHERE EmailTo='" . $user['email'] . "'");
//$num_messages = mysql_num_rows($all_inmail);
?>

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
	<div id="second_layer_edit_profile">
<form action="#" method="post">
	<div style="padding:10px 20px;">
		<div class="profile_name_header">EDIT LESSON</div>
		<br/>
		<input type="hidden" name="lessonID" value="<?php echo $lessonID ?>" />
        <div class="profile_lesson_header">Skill</div>
        <input type="text" name="skillName" id="sk" value="<?php echo $skill['skillName'] ?>" />
		<br />
		<div class="profile_lesson_header">Lesson Description</div>
        <textarea cols="40" rows="8" name="lesson_description" id="ld"><?php echo $lesson['lesson_description'] ?></textarea>
        <br />
		<div class="profile_lesson_header">Experience</div>
        <textarea cols="40" rows="8" name="experience" id="exp"><?php echo $lesson['experience'] ?></textarea>
		<br />
		<div class="profile_lesson_header">Cost</div>
        <input type="text" name="cost" id="cst" value="<?php echo $lesson['cost'] ?>" />
		<br />
		<button type="submit">UPDATE</button>
	</div>
</form>
</div>
<br/>
<br/>

</body>
</html>
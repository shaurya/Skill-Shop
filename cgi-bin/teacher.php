<?php
	session_start();
?>
<html>
<head>
	<?php include 'head.php'?>
</head>
<body>
<?php
	include 'header.php';
?>
<br><br>
<?php
	require_once 'config.php';
	$is_ajax = $_REQUEST['is_ajax'];
	if(isset($is_ajax) && $is_ajax)
	{	
		$teacherID = $_REQUEST['teacherID'];
		$teacher_array = mysql_query("SELECT * FROM Users WHERE userID='$teacherID'");
		$teacher = mysql_fetch_array($teacher_array);
		echo "<div id='teacher_pic' src="$
	}
?>
</div>
</body>
</html>
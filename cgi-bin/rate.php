<?php
/*Just set the rating for the user*/
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
		console.log("I actually got here!");
		$teacher = $_REQUEST['teacher'];
		$rating_stars = $_REQUEST['rating_stars'];
		$rating_text = $_REQUEST['rating_text'];
		$user = $_SESSION['userID'];
		console.log("And the vars = $teacher, $rating_stars, $rating_text, $user");
		mysql_query("INSERT INTO Ratings (starRating, ratingContent, student, teacher) VALUES ('$rating_stars', '$rating_text', '$user', '$teacher')");
		$_SESSION['message'] = "<p class='success'> Sweet looking rating! </p>";
		echo "success";
	}
	else
		$_SESSION['message'] = "<p class='error'> Sorry, we couldn't... rate that! But actually, try to re-rate. </p>";
		echo "success";
?>
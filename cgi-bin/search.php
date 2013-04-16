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
<br>
<center>
<div id="message">
<?
	/*In the case we have any sort of user feedback on logging in, registering, creating listing, etc*/
	if(isset($_SESSION['message'])) 
		{
			echo $_SESSION['message'];
			unset($_SESSION['message']);
		}
?>
	</div>
</center>
<div id="search_content">
<center>
<form action="search.php" method="post" id="search_results_search_bar">
	<div data-role="fieldcontain">
		<input type="search" name="skill_search" id="skill_search" value="" placeholder="Search..."/>
		<br/>
		<center>
		<!-- <button type="submit" data-theme="b">Search</button> -->
		</center>
	</div>
</form>
</center>
<?php 
	//now the fun part of constructing out all the elements
	$search_value = "";
	$max_rows = 10;
	
	if( empty($_POST['skill_search']))
	{
		//again, here, I need to scrub the input, but we will lack that out for now 
		//and worry about that later
		$search_value = $_GET['target'];
	}
	else
		{
			$search_value = $_POST['skill_search'];
		}
	
	$link = mysql_connect('mysql-user-master.stanford.edu', 'ccs147meseker', 'ceivohng');
	mysql_select_db('c_cs147_meseker');
	$query = "SELECT * FROM skills WHERE skillName SOUNDS LIKE '".$search_value."'"; 
	$skill = mysql_query($query);


	$skill_row = mysql_fetch_assoc($skill);
	
	$query = "SELECT * FROM Lessons WHERE skillID='".$skill_row["skillId"]."' LIMIT ".$max_rows;
	$lessons = mysql_query($query);
	//construct list header
	if( mysql_num_rows($lessons) == 0 )
	{
		echo "<center><p><h2> No results found</h2> </p></center>";
	}
	else
	{
		echo "<ul data-role='listview' class='ui=listview'>";
		//construct list rows
		
		while($row = mysql_fetch_assoc($lessons))
		{
			$query = "SELECT * FROM Users WHERE userID='".$row['userID']."'";
			$user = mysql_query($query);
			$user_row = mysql_fetch_assoc($user);
			//now create the output! :D
			echo "<li data-theme='c' class='ui-btn ui-btn-icon-right ui-li ui-btn-up-c'>";
			echo "<div class='ui-btn-inner ui-li'>";
			echo "<div class='ut-btn-text'>";
			echo "<a href=teacherprofile.php?teacher_userID=".$row['userID']."&lessonID=".$row['lessonID'].">";
			$skill = mysql_fetch_array( mysql_query("SELECT * FROM skills where skillId=".$row['skillID']));
			echo "<h3 class='ui-li-heading'>".$skill['skillName']."</h3>";
			echo "<p class='ui-li-desc'>".$user['name']."</p>";
			echo "<p class='ui-li-desc'>Self-Experience Rating : ".$row['experience']."% </p>";
			echo "<p class='ui-li-aside'>".$row['lesson_description']."</p>";
			echo "<p class='ui-li-aside ui-li-desc'><strong>";
			echo "$".$row['cost']." per hour </strong></p>";
			echo "</a></div></div></li>";
		}
	}
?>
</div>

<div data-role="popup" id="login_popup" data-overlay-theme="b" data-theme="a" class="ui-corner-all" data-position-to="window" data-dismissable="false">
	    <form id="login_form" name="login_form" action="login.php" method="post">
		<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" style=" float:left;">Close</a>
		<div style="padding:10px 20px;">
			<h3>Please sign in</h3>
		    <label for="email" class="ui-hidden-accessible">Username:</label>
		    <input type="text" name="email" id="email" id="un" placeholder="user@email.com" data-theme="a" />

	        <label for="password" class="ui-hidden-accessible">Password:</label>
	        <input type="password" name="password" id="password"  placeholder="password" data-theme="a" />

	    	<input type="submit" id="login" name="login" value="Login"></input>
		</div>
	</form>
</div>


<script type="text/javascript">
$(function(){	
	$("#login").click(function() {
		var action = $("#login_form").attr("action");
		var form_data = {
			email: $("#email").val(),
			password: $("#password").val(),
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
	$("#logout").click(function() {
		var action = $("#logout_button").attr("action");
		$.ajax({
				type: "POST",
				url: action,
				data: 0,
				success: function(response){
					$("$message").html("<p class='success'> You have logged out successfully! </p>");
				}
				});
		return false;
	});
});
</script>

</body>
</html>
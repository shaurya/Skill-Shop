<?php
	if( !isset($_COOKIE['user']) )
	{
		//set the cookie for 20 years
		setcookie(
				"user",
				"true",
				time() + (20 * 365 * 24 * 60 * 60)
		);
		
		session_start();
		/* Check to see if the user is logged in first, and that the cookie doesn't exist*/
		if (!isset($_SESSION['logged_in']) ){
			echo "<script> function showIntro(){ $( '#userIntro').popup( 'open') } </script>";
			echo "<script> setTimeout(showIntro, 1222); </script>";
		}
		else{
			echo "<script> $.mobile.changePage( 'home.php', {}); </script>";
		}
	}
	else
	{
		if( isset($_SESSION['logged_in']) ){
			echo "<script> $.mobile.changePage( 'home.php', {}); </script>";
		}
		session_start();
	}
?>
<html>
<head>
	<?php include 'head.php'?>
	
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
						window.location.replace("home.php");
					}
					else
					{
						window.location.replace("home.php");
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

</head>
<body>
<?php
	include 'header.php';
?>
<br> <br>

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

<div id="home_options_container">
	<div id="home_options">
	<center>
	Search for a new skill
	<form action="search.php" method="post">
		<div data-role="fieldcontain" style='height:auto !important;'>
			<input type="search" name="skill_search" id="skill_search" value="" placeholder="Search..." />
		</div>
	</form>
	<img src='icons/homepage-middle-part.png'/><br/>
	<a href='createprofile.php' data-transition='slideup'><img src='icons/new-account-chalk.png'/></a>
	<br/>
	<a href="#login_popup" data-rel="popup"><img src="icons/login-chalk.png"/></a>
	</center>
	</div>
</div>

<div data-role="popup" id="login_popup" data-overlay-theme="b" data-theme="a" class="ui-corner-all" data-position-to="window" data-dismissable="false">
	    <form id="login_form" name="login_form" action="login.php" method="post">
			<a href="#" data-rel="back" data-role="button" data-theme="a" data-icon="delete" data-iconpos="notext" style=" float:left;">Close</a>
		      <div style="padding:10px 20px;">
			  <h3>Please sign in</h3>
		      <label for="email" class="ui-hidden-accessible">Username:</label>
		      <input type="text" name="email" id="email" id="un" style='color:white !important;'placeholder="user@email.com" data-theme="a" />

	          <label for="password" class="ui-hidden-accessible">Password:</label>
	          <input type="password" style='color:white !important;' name="password" id="password"  placeholder="password" data-theme="a" />

	    	  <input type="submit" id="login" name="login" value="Login"></input>
			</div>
		</form>
</div>


<div data-role="popup" id="userIntro" class="userIntro">
<p>
	<p>Register and get access to high quality students and teachers today!</p>
	<span><a href="#" data-rel="back" data-role="button" data-theme="a">No thanks!</a>
	<a href='register.php' data-transition='flip' data-theme="b" data-role='button'> Register </a></span>	
</p>
</div>


</body>
</html>
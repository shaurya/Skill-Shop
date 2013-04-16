<?php
	session_start();
?>
<html>
<head>
	<?php include 'head.php';
	?>
</head>
<body>
<?php
	include 'header.php';
?>
<br><br>
<div id="content">
	<form id='register' action='createprofile.php' method='post' accept-charset='UTF-8'>
	<fieldset >
		<legend><div style="color: white !important; text-align: center;">
		Register below!
		</div></legend>
		<input type='hidden' name='submitted' id='submitted' value='1'/>
		<label for='first_name' >First name: </label>
		<input type='text' name='first_name' id='first_name' maxlength="50" />
		<label for='first_name' >Last name: </label>
		<input type='text' name='last_name' id='last_name' maxlength="50" />
		<label for='email' >Email Address*:</label>
		<input type='text' name='email' id='email' maxlength="50" />
		<label for='password' >Password*:</label>
		<input type='password' name='password' id='password' maxlength="50" />
		<label for='confirm_password' >Verify Password*:</label>
		<input type='password' name='confirm_password' id='confirm_password' maxlength="50" />
		<input type='image' name='Submit' alt='submit' src='icons/create-chalk.png' value='Submit' id='create_button' class='create_button'/>
	</fieldset>
</form>
<?php
	//add the validator
	require_once "formvalidator.php";
	$validator = new FormValidator();
	$validator->addValidation('password','eqelmnt=confirm_password','Your passwords do not match!');
	$validator->addValidation('mail','email','The input for Email should be a valid email value');
	$validator->addValidation('email','req','Please fill in an Email, this will be your username');	
	
	if($_POST){
		mysql_connect('mysql-user-master.stanford.edu', 'ccs147meseker', 'ceivohng');
		mysql_select_db('c_cs147_meseker');
	
		$name = sanitize($_POST['first_name'])." ".sanitize($_POST['last_name']);
		$user_name = sanitize($_POST['username']);
		$email = sanitize($_POST['email']);
		$password = sanitize($_POST['password']);
	
		$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		$hash = crypt($password,$salt);
		$user = mysql_fetch_array( mysql_query("SELECT * FROM Users WHERE email='" . $email . "'"));
	
		if (!($fetch = mysql_fetch_array( mysql_query("SELECT email FROM Users WHERE email='$email'")))){
			mysql_query("INSERT INTO Users (name, password,salt,email) VALUES ('$name', '$hash', '$salt', '$email')") or die(mysql_error());
			$new_user = mysql_fetch_array(mysql_query("SELECT * FROM Users WHERE email='{$email}'"));
			$_SESSION['name'] = $new_user['name'];
			$_SESSION['logged_in'] = "YES";
			$_SESSION['userID'] = $new_user['userID'];
			$_SESSION['message'] = "<p class='success'>Welcome ".$new_user['name']."!</p>";
			echo "<script> $.mobile.changePage( 'index.php', { transition: 'slideup'} ); </script>";
		}
		else{
			echo "Sorry! $email is already in the base";
			//go ahead and show an error, get them to resubmit
		}
	}
	
	function sanitize($query){
		return mysql_real_escape_string($query);
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
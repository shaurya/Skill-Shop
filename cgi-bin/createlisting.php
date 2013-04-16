<?php
session_start();
if(!isset($_SESSION['logged_in']))
{
	$_SESSION['message'] = "<p class='error'> You need to Login to view this page </p>";
	header( 'Location: index.php' ) ;
}
?>

<html>
<head>
<?php include 'head.php';?>
<script>
	$("input[type='radio']").attr("checked",true).checkboxradio("refresh");
</script>
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
<br>
<form action="createlisting.php" method="post">
	<div style="padding:10px 20px;">
		<div class="profile_name_header" style='color:white !important;'>Create Listing</div>
        <label for="sk" class="ui-hidden-accessible">Skill*:</label>
        <input type="text" name="skillName" id="sk" value="" placeholder="Skill" />
		<br />
		<label for="ld" class="ui-hidden-accessible">Lesson Description*:</label>
        <textarea cols="40" rows="8" name="lesson_description" id="ld" value="" placeholder="Describe your lessons . . ."></textarea>
        <br />
		<select name="category" id="category">
			<option style='color:black !important;' value="sports">Sports</option>
			<option style='color:black !important;' value="music">Music</option>
			<option style='color:black !important;' value="writing">Art</option>
			<option style='color:black !important;' value="academics">Academics</option>
			<option style='color:black !important;' value="crafts">Crafts</option>
			<option style='color:black !important;' value="miscellaneous">Miscellaneous</option>
		</select>
		<br/>
		<div data-role="fieldcontain">
			<fieldset  data-role="controlgroup"  class="ui-grid-b" data-type="horizontal" data-role="fieldcontain">
				<!--<legend><div style="font-family:Helvetica;font-size:17px;color:#8A0808;padding-top:7px;padding-left:5px;">Experience</div></legend>-->
				<input type="radio" name="experience_value" id="experience_value-1" value="1" />
				<label for="experience_value-1">Beginner</label>

				<input type="radio" name="experience_value" id="experience_value-2" value="2" checked="checked"  />
				<label for="experience_value-2">Intermediate</label>

				<input type="radio" name="experience_value" id="experience_value-3" value="3"  />
				<label for="experience_value-3">Expert</label>
			</fieldset>
		</div>
		<textarea cols="40" rows="8" name="experience" value="experience" id="experience" placeholder="Describe your experience . . ."></textarea>
		<br/>
		<label for="cst" class="ui-hidden-accessible">Cost Per Hour*:</label>
        <input type="text" name="cost" id="cst" value="" placeholder="Cost Per Hour"  />
		<br />
		<center>
		<input type='image' name='Submit' alt='submit' src='icons/create-chalk.png' value='Submit' id='create_button' class='create_button'/>
		</center>
	</div>
</form>

<?php
if($_POST)
{
	require_once "formvalidator.php";
	$validator = new FormValidator();
	$validator->addValidation('skillName','req','Fill in a skillname so we know what you\'re teaching!');
	$validator->addValidation('cost','req','Are you free? Then just put in 0 so students can know!');
	$validator->addValidation('lesson_description','req','Surely you must have something to say about what your skill...');
	//make sure that form is ok to send
	if(!$validator->ValidateForm())
	{
		$message = "<B>Validation Errors:</B>";
		$error_hash = $validator->GetErrors();
		foreach($error_hash as $inpname => $inp_err)
		{
			$message.="<p>$inpname : $inp_err</p>\n";
		}
		echo "<div data-role='popup' id='popupMessage'>".$message."</div>";
		echo "<script>$('#popupMessage').popup();</script>";
	}
	else{
	require_once 'config.php';

	//grab the email and the user associated with it
	$userID = $_SESSION['userID'];

	//grab the skill they are posting, along with the category they are choosing
	$skillName = mysql_real_escape_string($_POST['skillName']);
	$skillRows = mysql_query("SELECT * FROM skills WHERE skillName='$skillName'");
	$category_text = mysql_real_escape_string($_POST['category']);
	$category = mysql_fetch_array(mysql_query("Select * from categories where categoryName='$category_text'"));
	$categoryID = $category['categoryID'];

	$skill = mysql_fetch_array($skillRows);
	//make sure that the skill will exists
	if(!(mysql_num_rows($skillRows) > 0 ))
	{
		mysql_query("INSERT INTO skills (skillName,categoryID) VALUES ('$skillName','$categoryID')");
	}

	//else, we want to use the skillid we found
	$skill = mysql_fetch_array(mysql_query("SELECT skillId FROM skills WHERE skillName='$skillName'"));
	$skillID = $skill['skillId'];
	$lesson_description = mysql_real_escape_string($_POST['lesson_description']);
	$experience = $_POST['experience'];
	$cost = mysql_real_escape_string($_POST['cost']);
	//insert into the database
	$insert_query = "INSERT INTO Lessons (userID, lesson_description, experience, skillID, cost, categoryID) VALUES ('$userID','$lesson_description','$experience','$skillID','$cost','$categoryID')";
	mysql_query($insert_query) or die(mysql_error());
	$_SESSION['message'] = "<p class='success'>Listing created!</p>";
	echo "<script> $.mobile.changePage( 'home.php', { transition: 'slideup'} ); </script>";
	}
}
?>

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
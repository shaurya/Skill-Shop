<div data-role="header" class="ui-header ui-bar-a header_extra_style" >
	<a data-role="button" data-direction="reverse" data-rel="back" data-icon="arrow-l" data-iconpos="left">
            Back
    </a>
	<center>
		Skill Shop
	</center>
<?php
if(isset($_SESSION['logged_in']))
{	
	echo "<a href='logout.php' class='logout_button' action='logout.php'>";
    echo "Logout";
	echo "</a>";
}
?>

</div>

<!--This div will be responsible for holding the username/logout, or the login_in if they are not logged in-->
<?php
if( isset($_SESSION['logged_in'])){
#container { text-align: center; }
#div-1 { float: left; }
#div-2 { display: inline; }
#div-3 { float: right; }
	echo '<div  class="ui-grid-b" style="padding-top: 10px !important; text-align: center;">';
	echo '<a href="home.php" id="home" style="float:left;"><img src="icons/home-chalk.png"/></a>';
	require_once "config.php";
	$messages = mysql_query("SELECT * FROM threads WHERE UserIDConch='".$_SESSION['userID']."'");
	echo "<a href='mail.php' id='email' style='display : inline;'><img src='icons/mail-chalk.png'/> ";
	echo "</a>";
	echo "<a href='profile.php' style='float:right;' id='profile'>";
	echo "<img src='icons/profile-chalk.png'/></a>";
	echo "</div>";
	}
?>
<?php
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>

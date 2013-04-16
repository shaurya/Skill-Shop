
<?php
	session_start();
	require_once 'config.php';
	$is_ajax = $_REQUEST['is_ajax'];
	if($is_ajax)
	{	
		$email = $_REQUEST['email'];
		$password = $_REQUEST['password'];
			
		$user_rows = mysql_query("SELECT * FROM Users WHERE email='$email'")or die(mysql_error());
		if( mysql_num_rows( $user_rows ) > 0 )
		{
			
			$user = mysql_fetch_array($user_rows);
			
			$salt = $user['salt'];
	
			$hashedPW = crypt($password,$salt);
		
			if($user['password'] == $hashedPW )
			{
				$_SESSION['name'] = $user['name'];
				$_SESSION['logged_in'] = true;
				$_SESSION['userID'] = $user['userID'];
				$_SESSION['message'] = "<center> <img src='icons/signedin-text.png' />";
				echo "success";
			} 
			else
				{
					$_SESSION['message'] = "<center> <img src='icons/signedin-text.png' />";
					echo "failure";
				}
		}
		else
			{
				$_SESSION['message'] = "<p class='error'> Wrong username/password </p>";
				echo "failure";
			}
	}
	else
		echo "failure";
?>
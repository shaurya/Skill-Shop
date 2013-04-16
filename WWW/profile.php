<?php
$link = mysql_connect('mysql-user-master.stanford.edu', 'ccs147meseker', 'ceivohng');
mysql_select_db('c_cs147_meseker');

$result = mysql_query("SELECT * FROM Users WHERE Name='meseker'");

while($row = mysql_fetch_array($result))
{
		echo "Name: " . $row['Name'] . ", Password: " . $row['Password'];
		echo "<br />";
}

mysql_close($link);
?>

<h1>praise HIM!</h1>
<?php
$mysqli = new mysqli("localhost", "root", "Girzim74", "users");
if ($mysqli->connect_errno){
	echo "failed to connect";
	exit();
}
//echo $mysqli->host_info . "\n";

if(!empty($_POST['user']))
{
	if ($result = $mysqli->query("SELECT * FROM UserName where userName = '$_POST[user]' AND pass = '$_POST[pass]'")){
if ($result->num_rows==1)
{ 	
	header("refresh:5;url=steamProfile.php");
	die("Sucessful Login being Redirected");
}
else
{   
	header("refresh:5;url=sign-up.html");
        die("unsucessful Login being Redirected to registration page if enter wrong password goto login page again");
	exit();
}

       $result->close();
}
}
else
  "please enter something"
?>


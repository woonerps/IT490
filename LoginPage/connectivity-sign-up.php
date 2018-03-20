<?php
$mysqli = new mysqli("localhost", "root", "Girzim74", "users");
if ($mysqli->connect_errno){
        printf( "failed to connect\n");
        exit();
}
	
if(isset($_POST['submit']))
{
printf("checking if user exists\n");
if(!empty($_POST['user']))
{	
	       if ($result = $mysqli->query("SELECT * FROM UserName where userName = '$_POST[user]' AND pass = '$_POST[pass]'")){

		if ($result->num_rows==1)
		{
  			header("refresh:5;url=signin.html");
        		die("Already in Database being redirected to login page");
			
		}
		else
		{	
     			printf("making new user\n");
		        $userName = $_POST['user'];
  		      $password =  $_POST['pass'];
        if ($result = $mysqli->query("INSERT INTO UserName(userName,pass) VALUES ('$userName','$password')")){
        		header("refresh:5;url=signin.html");
        		die("YOUR REGISTRATION IS COMPLETED... being redirected to login page\n");
        }

		}	
	}
	else{
		printf("say sometjing\n");
	}
		
}
else
{
	printf("please enter something\n");
	}
}


?>




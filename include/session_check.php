<?php
session_start();

//check if user is logged in
if(!isset($_SESSION['login_status']))
{

	header("Location:http://chanakya.lab/login.php");
}
else
{
	if($_SESSION['login_status']!="logedin")
	{
		header("Location:http://chanakya.lab/login.php");
	}
}

//check if user has permission--execution comes here only if user is logged in

if(!isset($_SESSION['user_role']))
{
	die("You don't have permission to access this section");
}
else
{
	
		$permission=$_SESSION['user_role'];
	
}
date_default_timezone_set('Asia/Kolkata');
?>
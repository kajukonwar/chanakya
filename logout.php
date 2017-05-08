<?php
session_start();
//if(isset($_SESSION['login_status']))
$_SESSION=array();

session_destroy();
header("Location:http://chanakya.lab/login.php");

?>
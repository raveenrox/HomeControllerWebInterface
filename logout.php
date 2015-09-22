<?php
	require_once('global.php');
	
	session_start();
	session_check();
if(isset($_SESSION['auth']))
$_SESSION['auth']=false;
session_destroy();
session_unset();
echo 'Current PHP version: ' . phpversion();
//header("Location: index.html");
echo "<meta http-equiv=\"refresh\" content=\"0; url=./login.php\" />";
?>
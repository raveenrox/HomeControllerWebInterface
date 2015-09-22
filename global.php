<?php
	$path="";
	$host=gethostbyname("localhost");
	$port=27015;
	
	function session_check(){
		session_start();
		if(!isset($_SESSION['username']) || !isset($_SESSION['password'])){
			header("Location: login.php");
			die();
		}
		else if(!isset($_SESSION['auth']) || $_SESSION['auth']==false)
		{	header("Location: login.php");
		die();
	}
	}

?>
<?php
	require_once('global.php');
	$usrbin="";
	$default_login_enabled=true;
	
			$ufile=fopen("user.bin","r");
	
	while(!feof($ufile))
		$usrbin=$usrbin. fgets($ufile) ;
	
	fclose($ufile);
	$usrbin=base64_decode($usrbin);
	$xml=simplexml_load_string($usrbin) or die("Error: Cannot create object");

	$username=$xml->username;
	$password=$xml->password;
	$password=base64_decode($password);
	
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		if($_SESSION['username']==$username && $_SESSION['password']==$password)
			header("Location :main.php");
		else {
			
			echo "<script>alert('Please enter username and password correctly');</script>";
			echo "<meta http-equiv=\"refresh\" content=\"0; url=./logout.php\" />";
		}
	}
	else {
		//echo "<script>alert('Please enter username and password correctly');</script>";
		echo "<meta http-equiv=\"refresh\" content=\"0; url=./index.html\" />";
	}
	
	
	if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username']!="" && $_POST['password']!=""){
		
		
		if(!strcmp($_POST['username'],$username) && !strcmp($_POST['password'],$password)){
			set_session($_POST['username'],$_POST['password']);
			header("Location: main.php");
		
		}
		else if($default_login_enabled==true)
			default_login($_POST['username'],$_POST['password']);
		
		else{
			echo "<script>alert('Invalid Username or Password');</script>";
			echo "<meta http-equiv=\"refresh\" content=\"0; url=./index.html\" />";
			die();
		}
	}
	else {
		
		echo "<script>alert('Please Login to Continue');</script>";
		echo "<meta http-equiv=\"refresh\" content=\"0; url=./index.html\" />";
	}
	
	function default_login($un,$pp){
		if($un=="admin" && $pp=="admin123"){
			set_session($un,$pp);
			header("Location: main.php");
		}
	}
	function set_session($un,$pp){
		session_start();
		$_SESSION['username']=$un;
		$_SESSION['password']=$pp;
		$_SESSION['auth']=true;
	}
?>
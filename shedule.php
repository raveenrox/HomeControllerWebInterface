<?php
	require_once('global.php');
	session_check();
	$auth_str="username=".$_SESSION['username']."&password=".$_SESSION['password'];
	
$name=time();
$date=$_GET['date'];
$time=$_GET['time'];
$msg=$_GET['state'];
$time=$time.":00";
if (isset($_GET['date']) && isset($_GET['time']) && isset($_GET['state']) && $_GET['date']!='' & $_GET['time']!=''){
$xmllikedata="setTask:<newtask><name>".$name."</name><date>".$date."</date><time>".$time."</time><msg>".$msg."</msg></newtask>";
header("Location:message.php?".$auth_str."&message=".$xmllikedata."&room=".$_GET['room']."");
echo $xmllikedata;
}
else{
	echo "<script>alert('Plese Fill all teh fields correctly');</script>";
	$room=$_GET['room'];
	echo "<meta http-equiv=\"refresh\" content=\"0; url=./room.php?room=".$room."\" />";
	
}
?>
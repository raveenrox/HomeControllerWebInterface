<?php	
	$host    = "127.0.0.1";
	$port    = 27015;
	//test
	if (isset($_POST['message']) && isset($_POST['username']) && isset($_POST['password']))
	{
		$msg=$_POST['message']."@".$_POST['username'].":".$_POST['password'];
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n"); 
		socket_write($socket, $msg, strlen($msg)) or die("Could not send data to server\n");
		$line = socket_read ($socket, 1024) or die("Could not read server response\n");
		socket_close($socket);
	}
	sleep(2);
	$msg=" ";
	if (isset($_POST['username']) && isset($_POST['password']))
	{
		$msg="ping@".$_POST['username'].":".$_POST['password'];
	}
	$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
	$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n"); 
	socket_write($socket, $msg, strlen($msg)) or die("Could not send data to server\n");
	$line = socket_read ($socket, 1024) or die("Could not read server response\n");
	socket_close($socket);
	if($line=="Incorrect")
	{
		echo "INCORRECT";
	}else if($line=="")
	{
		echo "FAILED";
	}else
	{
		echo $line;
	}
?>
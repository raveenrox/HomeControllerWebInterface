<?php	
	require_once('global.php');
	session_check();

	if (isset($_GET['message']) && isset($_GET['username']) && isset($_GET['password']))
	{
		$msg=$_GET['message']."@".$_GET['username'].":".$_GET['password'];
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n"); 
		socket_write($socket, $msg, strlen($msg)) or die("Could not send data to server\n");
		$line = socket_read ($socket, 1024) or die("Could not read server response\n");
		socket_close($socket);
		
		if($_GET['from']=='taskList'){
			echo "<meta http-equiv=\"refresh\" content=\"0; url=taskList.php?username=raveen&password=1234\" />";
			die();
		}
	}
	
	//header("Content-type: text/xml");
	//echo $line;
	?>
	 <meta charset="UTF-8">
        <title>Untitled Document</title>
				<link rel="stylesheet" href="styles.css" type="text/css" />
				
			</head>
			
			
	<?php
	sleep(2);
	$msg=" ";
	if (isset($_GET['username']) && isset($_GET['password']))
	{
		$msg="ping@".$_GET['username'].":".$_GET['password'];
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
		//echo $line;
		
		echo "<script>alert(\"Request Sucessfull<br/>".$line."\");</script>";
		sleep(2);
		//header('Location:main.php');
		$room=$_GET['room'];
		echo "<meta http-equiv=\"refresh\" content=\"0; url=./room.php?room=".$room."\" />";
	}
?>
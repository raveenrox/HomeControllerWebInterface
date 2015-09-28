<?php	
require_once('global.php');
	
	if (isset($_GET['username']) && isset($_GET['password']))
	{
		$msg="getTaskList@".$_GET['username'].":".$_GET['password'];
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n"); 
		socket_write($socket, $msg, strlen($msg)) or die("Could not send data to server\n");
		$line = socket_read ($socket, 10240) or die("Could not read server response\n");
		socket_close($socket);
	}
	//header("Content-type: text/xml");
	//echo $line;
	
	$xml=simplexml_load_string($line) or die("Error: Cannot create object");
	
	echo "<table>";
	foreach($xml->task as $task) {
		echo "<tr><td>".$task->name."</td><td>".$task->date."</td><td>".$task->time."</td>";
		
		echo "<td>";
		foreach ($task->commands[0]->children() as $command) {
			//echo "<li>".$command->no." ";
			//echo " ".$command->state."</li>";
			$xmldata=simplexml_load_file("db.xml");
			$cn=$command->no;
			$str="//room/child/command[.='".$cn."']/parent::*";
			
				$nodes = $xmldata->xpath($str);
			
			$status="";
			if($command->state=="true"){
				if($nodes[0]->type=="gate" || $nodes[0]->type=="door")
					$status="Open";
				else
					$status="Turn On";
			}
			else if($command->state=="false"){
				
				if($nodes[0]->type=="gate" || $nodes[0]->type=="door")
					$status="Close";
				else
					$status="Turn Off";
			}
			else {
				$status=$command->state;
			}
						
			echo $nodes[0]->childname[0];
			echo ":".$status."<br/>";
		}
		echo "</td>";
		echo "<td><a href='message.php?username=raveen&password=1234&message=removeTask:".$task->name."&from=taskList'>Deelete Task</a></td>";
		echo "</tr>";
	} 
	echo "</table>";

	?>
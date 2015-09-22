<?php
	require_once('global.php');
	session_check();

	
	$auth_str="username=".$_SESSION['username']."&password=".$_SESSION['password'];
	
	if(!isset($_REQUEST['room'])){
		header("Location: main.php");
		die();

	}
	else
	$room=$_REQUEST['room'];
	$str="//room/name[.='".$room."']/parent::*";
	$xml=simplexml_load_file($path."db.xml") or die("Error: Cannot create object");
	$nodes = $xml->xpath($str);


	
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home Control System</title>
				<link rel="stylesheet" href="styles.css" type="text/css" />
				
    </head>
	
    <body>
		<?php
		echo "<table class='roomtable'>";
		$rows=sizeof($nodes[0]->child)+1;
		echo "<tr><th class ='roomth'rowspan='".$rows."' style='background-color:#".$nodes[0]->color."';><img class='contextimage' src='" . $path.$nodes[0]->image . "' onMouseDown='shadedown(this)' onMouseUp='shadeup(this)'/><br/><br/><p class='roomh'>".$_GET['room']."</p><br/><hr/><br/><a href=\"#\" onclick=\"window.open( 'taskList.php?".$auth_str."', 'name', 'location=no,scrollbars=yes,status=no,toolbar=no,resizable=yes' )\">Sheduled Events</a><br/><br/><a class='back' href='main.php'><p>Go Back</p></a></th></tr>";
		
	for($i=0;$i<sizeof($nodes[0]->child);$i++){
		//echo "<pre>";
		//print_r($nodes[0]->child[$i]);
		//echo "</pre>";
		//echo "<br/>";
		$command=$nodes[0]->child[$i]->command;
		$con="X".$command."Y1Z";
		$coff="X".$command."Y0Z";
		
		$object_type=$nodes[0]->child[$i]->type;
		$object_name=$nodes[0]->child[$i]->childname;
		$object_type=strtolower($object_type);
		
		$on_message="Turn On";
		$off_message="Turn Off";
		if($object_type=='door' || $object_type=='gate'){
				$on_message="Open";
				$off_message="Close";
			}
		
		
		
		echo "<tr>";
		echo "<td><image class='icon' src='icons\\".$object_type.".png'></img></td>";
		echo "<td><b>".$object_name."</b><br/>Use following buttons to  Interact with object<br/>";
		echo "<a class ='switch' href='message.php?".$auth_str."&message=".$con."&room=".$_GET['room']."'>".$on_message."</a><a class='switch' href='message.php?".$auth_str."&message=".$coff."&room=".$_GET['room']."'>".$off_message."</a></td>";
		echo "<td><b>Shedule</b><br/><form action='shedule.php' method='get'>Date <input type='date' name='date' placeholder='MM/DD/YYYY'><br/>Time <input type='time' name='time' placeholder='HH:MM AM'><br/><input type='radio' name='state' value='".$con."'' checked='true'>".$on_message."<input type='radio' name='state' value='".$coff."'>".$off_message."<input type='hidden' name='room' value='".$_GET['room']."'><br/><input type='submit'  class ='switch' value='Add to Shedule'/></form><br/>
			</td>";
		echo "</tr>";
		}
		//echo "<tr ><td colspan='3'></td></tr>";
		echo "<table>";
		
		?>
    </body>
</html>
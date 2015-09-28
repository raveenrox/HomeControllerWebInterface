<?php 
	require_once('global.php');
	session_check();
?>

<html>
	<header>
		<link rel="stylesheet" href="styles.css" type="text/css" />
		<script src="scripts.js" type="text/javascript" ></script>
				
	</header>
	
	<body class="mainbody">
	
		<div class="grid">
			<?php             
                $xml=simplexml_load_file($path."db.xml") or die("Error: Cannot create object");
                foreach($xml->room as $room) { 
						
                        echo "<div class='container' style='background-color:".$room->color.";' >";
						echo "<a href='room.php?room=".$room->name."'>";
                        echo "<img class='contextimage' src='" . $path."images/".$room->image . "' onMouseDown='shadedown(this)' onMouseUp='shadeup(this)'/>";
						echo "<p class='contextheading'>" . $room->name . "</p>";echo "</a>";
                        echo "</div>";
						
                    } 
                
            ?>
		</div>
		<br/>
		<h2 style="text-align:center;color:#ffffff;size:22px;"><a href='logout.php'>Logout</a></h2>
		
	</body>
</html>
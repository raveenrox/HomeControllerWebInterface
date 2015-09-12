<?php
	if (isset($_POST['devid']))
	{
		$message=$_POST['devid'];
		$file=fopen('devicelist','a+');
		while(! feof($file)) {
			if($message==fgets($file)) {
				echo "EXIST";
				die();
			}
		}	
		fwrite($file, "\n".$message);
		echo "REGISTERED";
	}
?>
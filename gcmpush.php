<?php

if (isset($_GET['type']) && isset($_GET['title']) && isset($_GET['msg']))
{
	$apiKey = "AIzaSyDJ7jB6LgBNvTJs6wfV6Re5o_mrdV-bXsY";
	$devices = file('devicelist', FILE_SKIP_EMPTY_LINES);
	$message = "The message to send";

	$gcpm = new GCMPushMessage($apiKey);
	$gcpm->setDevices($devices);
	$response = $gcpm->send($message, array('type' => $_GET['type'], 'title' => $_GET['title'], 'msg' => $_GET['msg']));
}

class GCMPushMessage {

	var $url = 'https://android.googleapis.com/gcm/send';
	var $serverApiKey = "AIzaSyDJ7jB6LgBNvTJs6wfV6Re5o_mrdV-bXsY";
	var $devices = array();
	
	function GCMPushMessage($apiKeyIn){
		$this->serverApiKey = $apiKeyIn;
	}

	function setDevices($deviceIds){
	
		if(is_array($deviceIds)){
			$this->devices = $deviceIds;
		} else {
			$this->devices = array($deviceIds);
		}
	
	}

	function send($message, $data = false){
		
		if(!is_array($this->devices) || count($this->devices) == 0){
			$this->error("No devices set");
		}
		
		if(strlen($this->serverApiKey) < 8){
			$this->error("Server API Key not set");
		}
		
		$fields = array(
			'registration_ids'  => $this->devices,
			'data'              => array( "message" => $message ),
		);
		
		if(is_array($data)){
			foreach ($data as $key => $value) {
				$fields['data'][$key] = $value;
			}
		}

		$headers = array( 
			'Authorization: key=' . $this->serverApiKey,
			'Content-Type: application/json'
		);

		$ch = curl_init();
		
		curl_setopt( $ch, CURLOPT_URL, $this->url );
		
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$result = curl_exec($ch);
		
		curl_close($ch);
		
		return $result;
	}
	
	function error($msg){
		echo "Android send notification failed with error:";
		echo "\t" . $msg;
		exit(1);
	}
} ?>

<html>
	<body>
	<form method="GET">
		<table>
			<tr>
				<td>Type</td>
				<td>
				<select name='type'>
					<option value="toast">Toast</option>
					<option value="custom">Custom Notification</option>
					<option value="near">Near Home</option>
				</select>
				</td>
			<tr>
			<tr>
				<td>Title</td>
				<td><input type='text' name='title'/></td>
			<tr>
			<tr>
				<td>Message</td>
				<td><input type='text' name='msg'/></td>
			<tr>
			<tr>
				<td><input type='submit'/></td>
			</tr>
		</table>
	</form>
	</body>
</html>
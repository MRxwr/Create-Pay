<?php
if ( isset($sRef) && !empty($sRef) ){
	$sql = "SELECT * FROM `firebase` WHERE `sRef` LIKE '".$sRef."' ";
	$result = $dbconnect->query($sql);
	while($row = $result->fetch_assoc() ){
		$to = $row["token"];
		$title = "Successful payment";
		$body = "Your account has been credited with " . $price . "KD";
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>'{
				"to" : "'.$to.'",
				"notification" : {
					"title": "'.$title.'",
					"body" : "'.$body.'",
					"sound": "default",
					"badge" : "1"
				},
				"data" : {
					"title": "'.$title.'",
					"body" : "'.$body.'",
					"content_available":"true",
					"priority":"high",
					"click_action":"FLUTTER_NOTIFICATION_CLICK",
					"sound": "default"
				}
			}',
			CURLOPT_HTTPHEADER => array(
					'Authorization: key=AAAAoNHb8QE:APA91bEhs2weltPu2RqIXKmMdHcUtdf7p7LUuYWwHRgYbSJUsaxfTnbpQdfDR-pQXyPDgI1fkHO0ifV8yfDYADQJ2Rl0sEw2Wvh7bYPiq5uynHlksfUxN-36JFvb0dP2cbQBU3zJaF-L',
					'Content-Type: application/json'
				),
			)
		);
		$response = curl_exec($curl);
		curl_close($curl);
	}
}

?>
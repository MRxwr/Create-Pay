<?php
$_GET["status"] = "checkout.php?status=success";
if ( strstr($_GET["status"],'fail') === false ){
	echo "fail";
}else{
	echo "success";
}

/*
$to = "c7M5hh4QQNOIHKYZtMOeyE:APA91bH1-LhCNhZjuB0m0Fp9F1whqD9OepE5U2BAX3-gls2B3uCg-eZ3gMXPmftkjcYLHf8YxWT75a_gL7jpCxDh2ioCwGVqkCUfngR2ps9c1No2fERJRDpNxvI1kvOtywGqZiHrsWOX";
$title = "New Payment";
$body = "Invoice 123456789 has been paid successfully";

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
echo $response;
*/
?>
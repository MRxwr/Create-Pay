<?php
$to = $email;
$subject = "New Password - Createpay";
$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n" . 'From:noreply@createpay.link';
$msg = '<html><body><center>
		<img src="https://createpay.link/assets/images/05.png" style="width:200px;height:200px">
		<p>&nbsp;</p>
		<p>Dear '.$email.',</p>
		<p>Please use the below information carefully. <strong> <a href="https://createpay.link/">Createpay.link</a></strong>.</p>
		<p>Your new temprory password is:<br>
		</p>
		<p style="font-size: 50px; color: red"><strong>'.$randomPass.'</strong></p>
		<p>Best regards,<br>
		<strong>Createpay.link</strong></p>
		</center></body></html>';
$message = html_entity_decode($msg);
mail($to, $subject, $msg, $headers);
?>
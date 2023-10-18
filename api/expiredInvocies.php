<?php
require('constants.php');
$onlyDate2 = date('Y-m-d', strtotime($onlyDate .' - 2 days'));

$sql = "UPDATE `invoices`
		SET
		`status` = '4'
		WHERE `id` IN (
			SELECT `id`
			FROM `invoices`
			WHERE
			`date` < '".$onlyDate2."'
			AND
			(`status` LIKE '0'
			OR
			`status` LIKE '2')
		)
		";
$result = $dbconnect->query($sql);

?>
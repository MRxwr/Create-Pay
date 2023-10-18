<?php
$sql = "UPDATE `clients` 
        SET 
        `hidden`= '1',
        `email`= CONCAT('**',`email`,'**')
        WHERE `id` LIKE '".$id."'
        ";
$result = $dbconnect->query($sql);

?>
<?php

require 'mysql.php';

mysqli_query($mysqli, "START TRANSACTION;");

$sql = "SELECT * FROM `ikan` LIMIT 1 FOR UPDATE";
$result = mysqli_query($mysqli, $sql);
$fetch_result = mysqli_fetch_all($result, MYSQLI_ASSOC);
$new_name = $fetch_result[0]['nama'] . "A";

$sql = "UPDATE `ikan` SET `nama` = '$new_name' WHERE `ikan`.`id` = 1;";
mysqli_query($mysqli, $sql);
sleep(30);
mysqli_query($mysqli, "COMMIT");

$sql = "SELECT * FROM `ikan` LIMIT 1";
$result = mysqli_query($mysqli, $sql);
$fetch_result = mysqli_fetch_all($result, MYSQLI_ASSOC);
echo $fetch_result[0]['nama'];
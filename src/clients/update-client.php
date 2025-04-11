<?php

require "../db.php";
require "../security.php";

$id = $_POST["cli-id"];
$img = $_POST["cli-img"];
$idNum = $_POST["cli-id-num"];
$name = $_POST["cli-name"];
$company = $_POST["cli-company"];
$address = $_POST["cli-address"];
$city = $_POST["cli-city"];
$country = $_POST["cli-country"];
$phoneNum = $_POST["cli-phone-num"];

$SQL= "UPDATE client SET identification_number = ?,name = ?,company = ?,address = ?,city = ?,country = ?,phone_number=?,img_src = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("ssssssssi",$idNum,$name,$company,$address,$city,$country,$phoneNum,$img,$id);
$res->execute();

header("Location: clients-list.php");
exit();

?>
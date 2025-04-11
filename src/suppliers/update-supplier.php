<?php

require "../db.php";

$img = $_POST["supp-img"];
$id = $_POST["supp-id"];
$name = $_POST["supp-name"];
$company = $_POST["supp-company"];
$address = $_POST["supp-address"];
$city = $_POST["supp-city"];
$country = $_POST["supp-country"];
$phoneNum = $_POST["supp-phone"];
$iban = $_POST["supp-iban"];

$SQL= "UPDATE supplier SET name = ?,company = ?,address = ?,city = ?,country = ?,phone_number = ?,iban = ?,img_src = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("ssssssssi",$name,$company,$address,$city,$country,$phoneNum,$iban,$img,$id);
$res->execute();

header("Location: suppliers-list.php");
exit();

?>
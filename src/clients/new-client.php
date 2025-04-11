<?php

require "../db.php";
require "../security.php";

$img = $_POST["cli-img"];
$idNum = $_POST["cli-id-num"];
$name = $_POST["cli-name"];
$company = $_POST["cli-company"];
$address = $_POST["cli-address"];
$city = $_POST["cli-city"];
$country = $_POST["cli-country"];
$phoneNum = $_POST["cli-phone-num"];

$SQL= "INSERT INTO client(identification_number,name,company,address,city,country,phone_number,img_src) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$res = $mysqli->prepare($SQL);
$res->bind_param("ssssssss",$idNum,$name,$company,$address,$city,$country,$phoneNum,$img);
$res->execute();

header("Location: clients-list.php");
exit();

?>
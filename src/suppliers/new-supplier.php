<?php

require "../db.php";
require "../security.php";

$img = $_POST["supp-img"];
$name = $_POST["supp-name"];
$company = $_POST["supp-company"];
$address = $_POST["supp-address"];
$city = $_POST["supp-city"];
$country = $_POST["supp-country"];
$phoneNum = $_POST["supp-phone"];
$iban = $_POST["supp-iban"];

$SQL= "INSERT INTO supplier(name,company,address,city,country,phone_number,iban,img_src) VALUES (?,?,?,?,?,?,?,?)";
$res = $mysqli->prepare($SQL);
$res->bind_param("ssssssss",$name,$company,$address,$city,$country,$phoneNum,$iban,$img);
$res->execute();

header("Location: suppliers-list.php");
exit();

?>
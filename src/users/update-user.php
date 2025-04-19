<?php

require "../db.php";
require "../security.php";

$id = $_POST["usr-id"];
$username = $_POST["usr-username"];
$name = $_POST["usr-name"];
$surnames = $_POST["usr-surnames"];
$rol = $_POST["usr-rol"];

$SQL= "UPDATE users SET username = ?, name = ?, surnames = ?, rol = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("ssssi",$username,$name,$surnames,$rol,$id);
$res->execute();

header("Location: users-list.php");
exit();

?>
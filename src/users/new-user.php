<?php

require "../db.php";
require "../security.php";

$username = $_POST["usr-username"];
$name = $_POST["usr-name"];
$surnames = $_POST["usr-surnames"];
$rol = $_POST["usr-rol"];
$password = $_POST["usr-password"];

$hash = password_hash($password, PASSWORD_BCRYPT);

$SQL= "INSERT INTO users(username,name,surnames,password,rol) VALUES (?, ?, ?, ?, ?)";
$res = $mysqli->prepare($SQL);
$res->bind_param("sssss",$username,$name,$surnames,$hash,$rol);
$res->execute();

header("Location: users-list.php");
exit();

?>
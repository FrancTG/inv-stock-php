<?php

require "../db.php";
require "../security.php";

$id = $_POST["usr-id"];

$SQL= "DELETE FROM users WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

header("Location: users-list.php");
exit();

?>
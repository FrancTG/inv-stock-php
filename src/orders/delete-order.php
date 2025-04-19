<?php

require "../db.php";
require "../security.php";

$id = $_POST["ord-id"];

$SQL= "DELETE FROM order_line WHERE id_order = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

$SQL= "DELETE FROM orders WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

header("Location: orders-list.php");
exit();

?>
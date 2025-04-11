<?php

require "../db.php";
require "../security.php";

$id = $_POST["prod-id"];

$SQL= "DELETE FROM product WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

header("Location: products-list.php");
exit();

?>
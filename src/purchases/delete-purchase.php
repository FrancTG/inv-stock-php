<?php

require "../db.php";
require "../security.php";

$id = $_POST["pur-id"];

$SQL= "DELETE FROM purchase_line WHERE id_purchase = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

$SQL= "DELETE FROM purchase WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

header("Location: purchases-list.php");
exit();

?>
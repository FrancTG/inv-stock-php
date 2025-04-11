<?php

require "../db.php";
require "../security.php";

$id = $_POST["supp-id"];

$SQL= "DELETE FROM supplier WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

header("Location: suppliers-list.php");
exit();

?>
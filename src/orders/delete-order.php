<?php

require "../db.php";
require "../security.php";

$id = $_POST["id"];

$SQL= "DELETE FROM document_line WHERE id_doc = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

$SQL= "DELETE FROM document WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

header("Location: orders-list.php");
exit();

?>
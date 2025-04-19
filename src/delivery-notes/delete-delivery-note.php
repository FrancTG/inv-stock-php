<?php

require "../db.php";
require "../security.php";

$id = $_POST["dnote-id"];

$SQL= "DELETE FROM delivery_note_line WHERE id_delivery_note = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

$SQL= "DELETE FROM delivery_note WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

header("Location: delivery-notes-list.php");
exit();

?>
<?php

require "../db.php";
require "../security.php";

$id = $_POST["cli-id"];

$SQL= "DELETE FROM client WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

header("Location: clients-list.php");
exit();

?>
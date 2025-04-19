<?php

require "../db.php";
require "../security.php";

$id = $_POST["invoice-id"];

$SQL= "DELETE FROM invoice_line WHERE id_invoice = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

$SQL= "DELETE FROM invoice WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("i",$id);
$res->execute();

header("Location: invoices-list.php");
exit();

?>
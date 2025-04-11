<?php

require "../db.php";
require "../security.php";

$client = $_POST["invoice-client"];
$date = $_POST["invoice-date"];
$description = $_POST["invoice-desc"];
$prodIds = $_POST["invoice-prodid"];
$discounts = $_POST["invoice-discount"];
$quantitys = $_POST["invoice-quantity"];

$notSent = "NOT_SENT";

$SQL= "SELECT MAX(id) FROM delivery_note;";
$result = $mysqli->query($SQL);
$row = $result->fetch_assoc();
$invoiceID = $row["MAX(id)"];
$invoiceID = $invoiceID + 1;

$SQL = "INSERT INTO invoice(id,id_client,date,description,status) VALUES (?,?,?,?,?);";
$res = $mysqli->prepare($SQL);
$res->bind_param("iisss",$invoiceID,$client,$date,$description,$notSent);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "INSERT INTO invoice_line(id_invoice,id_product,discount,quantity) VALUES (?,?,?,?);";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("iiid",$invoiceID,$prodIds[$i],$discounts[$i],$quantitys[$i]);
    $res->execute();
}

header("Location: invoices-list.php");
exit();

?>
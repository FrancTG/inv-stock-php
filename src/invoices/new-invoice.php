<?php

require "../db.php";
require "../security.php";

$client = $_POST["client"];
$date = $_POST["date"];
$description = $_POST["desc"];
$prodIds = $_POST["prodid"];
$discounts = $_POST["discount"];
$quantitys = $_POST["quantity"];

$status = "NOT_SENT";
$docType = "invoice";

$SQL= "SELECT MAX(id) FROM document;";
$result = $mysqli->query($SQL);
$row = $result->fetch_assoc();
$docId = $row["MAX(id)"];
$docId = $docId + 1;

$SQL = "INSERT INTO document(id,id_client,docType,date,description,status) VALUES (?,?,?,?,?,?);";
$res = $mysqli->prepare($SQL);
$res->bind_param("iissss",$docId,$client,$docType,$date,$description,$status);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "INSERT INTO document_line(id_doc,id_product,discount,quantity) VALUES (?,?,?,?);";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("iiid",$docId,$prodIds[$i],$discounts[$i],$quantitys[$i]);
    $res->execute();
}

header("Location: invoices-list.php");
exit();

?>
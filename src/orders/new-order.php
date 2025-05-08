<?php

require "../db.php";
require "../security.php";

$client = $_POST["client"];
$date = $_POST["date"];
$prodIds = $_POST["prodid"];
$quantitys = $_POST["quantity"];

$status = "NOT_SENT";
$docType = "order";

$SQL= "SELECT MAX(id) FROM document;";
$result = $mysqli->query($SQL);
$row = $result->fetch_assoc();
$docId = $row["MAX(id)"];
$docId = $docId + 1;

$SQL = "INSERT INTO document(id,id_client,docType,date,status) VALUES (?,?,?,?,?);";
$res = $mysqli->prepare($SQL);
$res->bind_param("iisss",$docId,$client,$docType,$date,$status);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "INSERT INTO document_line(id_doc,id_product,quantity) VALUES (?,?,?);";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("iii",$docId,$prodIds[$i],$quantitys[$i]);
    $res->execute();
}

header("Location: orders-list.php");
exit();

?>
<?php

require "../db.php";
require "../security.php";

$id = $_POST["id"];
$date = $_POST["date"];
$supplier = $_POST["supplier"];
$prodIds = $_POST["prodid"];
$quantitys = $_POST["quantity"];
$cPrices = $_POST["cprice"];

$docType = 'purchase';

$SQL= "SELECT MAX(id) FROM document;";
$result = $mysqli->query($SQL);
$row = $result->fetch_assoc();
$docId = $row["MAX(id)"];
$docId = $docId + 1;

$SQL = "INSERT INTO document(id,id_supplier,docType,date) VALUES (?,?,?,?);";
$res = $mysqli->prepare($SQL);
$res->bind_param("iiss",$docId,$supplier,$docType,$date);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "INSERT INTO document_line(id_doc,id_product,quantity,custom_price) VALUES (?,?,?,?);";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("iiid",$docId,$prodIds[$i],$quantitys[$i],$cPrices[$i]);
    $res->execute();
}

header("Location: purchases-list.php");
exit();

?>
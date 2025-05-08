<?php

require "../db.php";
require "../security.php";

$client = $_POST["client"];
$date = $_POST["date"];
$idOrder = $_POST["idorder"];
$prodIds = $_POST["prodid"];
$discounts = $_POST["discount"];
$quantitys = $_POST["quantity"];

$status = "NOT_SENT";
$docType = "delivery-note";

$SQL= "SELECT MAX(id) FROM document;";
$result = $mysqli->query($SQL);
$row = $result->fetch_assoc();
$docID = $row["MAX(id)"];
$docID = $docID + 1;

$SQL = "INSERT INTO document(id,id_order,id_client,docType,date,status) VALUES (?,?,?,?,?,?);";
$res = $mysqli->prepare($SQL);
$res->bind_param("iiisss",$docID,$idOrder,$client,$docType,$date,$status);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "INSERT INTO document_line(id_doc,id_product,quantity,discount) VALUES (?,?,?,?);";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("iiid",$docID,$prodIds[$i],$quantitys[$i],$discounts[$i]);
    $res->execute();
}

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "UPDATE product SET stock = stock - ? WHERE id = ?";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("ii",$quantitys[$i],$prodIds[$i]);
    $res->execute();
}

header("Location: delivery-notes-list.php");
exit();

?>
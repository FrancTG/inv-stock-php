<?php

require "../db.php";
require "../security.php";

$client = $_POST["dnote-client"];
$date = $_POST["dnote-date"];
$idOrder = $_POST["dnote-idorder"];
$prodIds = $_POST["dnote-prodid"];
$discounts = $_POST["dnote-discount"];
$quantitys = $_POST["dnote-quantity"];

$notSent = "NOT_SENT";

$SQL= "SELECT MAX(id) FROM delivery_note;";
$result = $mysqli->query($SQL);
$row = $result->fetch_assoc();
$dnID = $row["MAX(id)"];
$dnID = $dnID + 1;

$SQL = "INSERT INTO delivery_note(id,id_order,id_client,date,status) VALUES (?,?,?,?,?);";
$res = $mysqli->prepare($SQL);
$res->bind_param("iiiss",$dnID,$idOrder,$client,$date,$notSent);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "INSERT INTO delivery_note_line(id_delivery_note,id_product,discount,quantity) VALUES (?,?,?,?);";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("iidi",$dnID,$prodIds[$i],$discounts[$i],$quantitys[$i]);
    $res->execute();
}

header("Location: delivery-note-list.php");
exit();

?>
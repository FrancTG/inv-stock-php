<?php

require "../db.php";
require "../security.php";

$client = $_POST["ord-client"];
$date = $_POST["ord-date"];
$prodIds = $_POST["ord-prodid"];
$quantitys = $_POST["ord-quantity"];

$notSent = "NOT_SENT";

$SQL= "SELECT MAX(id) FROM orders;";
$result = $mysqli->query($SQL);
$row = $result->fetch_assoc();
$orderID = $row["MAX(id)"];
$orderID = $orderID + 1;

$SQL = "INSERT INTO orders(id,id_client, date) VALUES (?,?,?);";
$res = $mysqli->prepare($SQL);
$res->bind_param("iis",$orderID,$client,$date);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "INSERT INTO order_line(id_order,id_product,quantity,status) VALUES (?,?,?,?);";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("iiis",$orderID,$prodIds[$i],$quantitys[$i],$notSent);
    $res->execute();
}

header("Location: orders-list.php");
exit();

?>
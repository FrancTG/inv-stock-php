<?php

require "../db.php";
require "../security.php";

$id = $_POST["pur-id"];
$date = $_POST["pur-date"];
$supplier = $_POST["pur-supplier"];
$prodIds = $_POST["pur-prodid"];
$quantitys = $_POST["pur-quantity"];
$buyPrices = $_POST["pur-buyprice"];
$profits = $_POST["pur-profit"];
$cPrices = $_POST["pur-cprice"];

$SQL= "SELECT MAX(id) FROM purchase;";
$result = $mysqli->query($SQL);
$row = $result->fetch_assoc();
$purchaseID = $row["MAX(id)"];
$purchaseID = $purchaseID + 1;

$SQL = "INSERT INTO purchase(id,id_supplier, date) VALUES (?,?,?);";
$res = $mysqli->prepare($SQL);
$res->bind_param("iis",$purchaseID,$supplier,$date);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "INSERT INTO purchase_line(id_purchase,id_product,quantity,buy_price,profit,custom_price) VALUES (?,?,?,?,?,?);";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("iiiddd",$purchaseID,$prodIds[$i],$quantitys[$i],$buyPrices[$i],$profits[$i],$cPrices[$i]);
    $res->execute();
}

header("Location: purchases-list.php");
exit();

?>
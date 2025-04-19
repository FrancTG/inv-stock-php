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

$SQL = "UPDATE purchase SET id_supplier = ?, date = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("isi",$supplier,$date,$id);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "UPDATE purchase_line SET quantity = ?, buy_price = ?, profit = ?, custom_price = ? WHERE id_purchase = ? and id_product = ?";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("idddii",$quantitys[$i],$buyPrices[$i],$profits[$i],$cPrices[$i],$id,$prodIds[$i]);
    $res->execute();
}

header("Location: purchases-list.php");
exit();

?>
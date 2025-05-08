<?php

require "../db.php";
require "../security.php";

$id = $_POST["id"];
$date = $_POST["date"];
$supplier = $_POST["supplier"];
$prodIds = $_POST["prodid"];
$quantitys = $_POST["quantity"];
$cPrices = $_POST["cprice"];

$SQL = "UPDATE document SET id_supplier = ?, date = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("isi",$supplier,$date,$id);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "UPDATE document_line SET quantity = ?, custom_price = ? WHERE id_doc = ? and id_product = ?";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("idii",$quantitys[$i],$cPrices[$i],$id,$prodIds[$i]);
    $res->execute();
}

header("Location: purchases-list.php");
exit();

?>
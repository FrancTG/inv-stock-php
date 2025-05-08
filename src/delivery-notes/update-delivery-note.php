<?php

require "../db.php";
require "../security.php";

$id = $_POST["id"];
$client = $_POST["client"];
$date = $_POST["date"];
$idOrder = $_POST["idorder"];
$prodIds = $_POST["prodid"];
$discounts = $_POST["discount"];
$quantitys = $_POST["quantity"];

$SQL= "UPDATE document SET id_order = ?, id_client = ?, date = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("iisi",$idOrder,$client,$date,$id);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL= "UPDATE document_line SET discount = ?, quantity = ? WHERE id_doc = ? and id_product = ?";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("diii",$discounts[$i], $quantitys[$i], $id, $prodIds[$i]);
    $res->execute();
}

header("Location: delivery-notes-list.php");
exit();

?>
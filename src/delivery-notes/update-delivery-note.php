<?php

require "../db.php";
require "../security.php";

$id = $_POST["dnote-id"];
$client = $_POST["dnote-client"];
$date = $_POST["dnote-date"];
$idOrder = $_POST["dnote-idorder"];
$prodIds = $_POST["dnote-prodid"];
$discounts = $_POST["dnote-discount"];
$quantitys = $_POST["dnote-quantity"];

$SQL= "UPDATE delivery_note SET id_order = ?, id_client = ?, date = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("iisi",$idOrder,$client,$date,$id);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL= "UPDATE delivery_note_line SET discount = ?, quantity = ? WHERE id_delivery_note = ? and id_product = ?";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("diii",$discounts[$i], $quantitys[$i], $id, $prodIds[$i]);
    $res->execute();
}

header("Location: delivery-notes-list.php");
exit();

?>
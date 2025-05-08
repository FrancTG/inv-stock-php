<?php

require "../db.php";
require "../security.php";

$id = $_POST["id"];
$client = $_POST["client"];
$date = $_POST["date"];
$description = $_POST["desc"];
$prodIds = $_POST["prodid"];
$discounts = $_POST["discount"];
$quantitys = $_POST["quantity"];


$SQL = "UPDATE document SET id_client = ?, date = ?, description = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("issi",$client,$date,$description,$id);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "UPDATE document_line SET quantity = ?, discount = ? WHERE id_doc = ? and id_product = ?";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("idii",$quantitys[$i],$discounts[$i],$id,$prodIds[$i]);
    $res->execute();
}

header("Location: invoices-list.php");
exit();

?>
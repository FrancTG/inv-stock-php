<?php

require "../db.php";
require "../security.php";

$id = $_POST["invoice-id"];
$client = $_POST["invoice-client"];
$date = $_POST["invoice-date"];
$description = $_POST["invoice-desc"];
$prodIds = $_POST["invoice-prodid"];
$discounts = $_POST["invoice-discount"];
$quantitys = $_POST["invoice-quantity"];


$SQL = "UPDATE invoice SET id_client = ?, date = ?, description = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("issi",$client,$date,$description,$id);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "UPDATE invoice_line SET quantity = ?, discount = ? WHERE id_invoice = ? and id_product = ?";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("idii",$quantitys[$i],$discounts[$i],$id,$prodIds[$i]);
    $res->execute();
}

header("Location: invoices-list.php");
exit();

?>
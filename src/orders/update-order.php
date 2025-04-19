<?php

require "../db.php";
require "../security.php";

$id = $_POST["ord-id"];
$client = $_POST["ord-client"];
$date = $_POST["ord-date"];
$prodIds = $_POST["ord-prodid"];
$quantitys = $_POST["ord-quantity"];

$SQL = "UPDATE orders SET id_client = ?, date = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("isi",$client,$date,$id);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "UPDATE order_line SET quantity = ? WHERE id_order = ? and id_product = ?";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("iii",$quantitys[$i],$id,$prodIds[$i]);
    $res->execute();
}

header("Location: orders-list.php");
exit();

?>
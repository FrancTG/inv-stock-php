<?php

require "../db.php";
require "../security.php";

$id = $_POST["id"];
$client = $_POST["client"];
$date = $_POST["date"];
$prodIds = $_POST["prodid"];
$quantitys = $_POST["quantity"];

$SQL = "UPDATE document SET id_client = ?, date = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("isi",$client,$date,$id);
$res->execute();

for ($i = 0; $i < sizeof($prodIds); $i++) {
    $SQL = "UPDATE document_line SET quantity = ? WHERE id_doc = ? and id_product = ?";
    $res = $mysqli->prepare($SQL);
    $res->bind_param("iii",$quantitys[$i],$id,$prodIds[$i]);
    $res->execute();
}

header("Location: orders-list.php");
exit();

?>
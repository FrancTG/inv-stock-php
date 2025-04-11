<?php

require "../db.php";

$id = $_POST["prod-id"];
$img = $_POST["prod-img"];
$ean = $_POST["prod-ean"];
$name = $_POST["prod-name"];
$stock = $_POST["prod-stock"];
$weight = $_POST["prod-weight"];
$volume = $_POST["prod-volume"];
$category = $_POST["prod-category"];
$iva = $_POST["prod-iva"];
$price = $_POST["prod-price"];
$discount = $_POST["prod-img"];
$description = $_POST["prod-description"];

$SQL= "UPDATE product SET ean = ?,name = ?,stock = ?,weight = ?,volume = ?,category = ?,iva = ?,price = ?,discount = ?,description = ?,img_src = ? WHERE id = ?";
$res = $mysqli->prepare($SQL);
$res->bind_param("isiddsdddssi",$ean,$name,$stock,$weight,$volume,$category,$iva,$price,$discount,$description,$img,$id);
$res->execute();

header("Location: products-list.php");
exit();

?>
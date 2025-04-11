<?php

require "../db.php";
require "../security.php";

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

$SQL= "INSERT INTO product(ean,name,stock,weight,volume,category,iva,price,discount,description,img_src) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$res = $mysqli->prepare($SQL);
$res->bind_param("isiddsdddss",$ean,$name,$stock,$weight,$volume,$category,$iva,$price,$discount,$description,$img);
$res->execute();

header("Location: products-list.php");
exit();

?>
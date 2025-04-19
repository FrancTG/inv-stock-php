<?php
require "../security.php";
require "../db.php";

function parseToXML($htmlStr)
{
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    return $xmlStr;
}

$ean = '%'. $_POST["ean"] . '%';

$SQL= "SELECT id, name, stock, price, img_src FROM product WHERE ean LIKE ?";
$stmt = $mysqli->prepare($SQL);
$stmt->bind_param("s", $ean);
$stmt->execute();
$res = $stmt->get_result();

header('Content-Type: text/xml');
echo "<products>";

if ($res->num_rows > 0) {
    while($row = $res->fetch_assoc()) {

        echo "<product>";
        echo "<id>". $row["id"] ."</id>";
        echo "<img>" . parseToXML($row["img_src"]) . "</img>";
        echo "<name>" . $row["name"] . "</name>";
        echo "<price>" . $row["price"] . "</price>";
        echo "<stock>". $row["stock"] . "</stock>";
        echo "</product>";
    }
} else {
    echo "0 results";
}
echo "</products>";

?>
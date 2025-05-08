<?php
require "security.php";
require "db.php";

function parseToXML($htmlStr)
{
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    return $xmlStr;
}

$docType = $_POST["docType"];

if (empty($_POST["data"])) {
    $SQL = "SELECT doc.id,doc.date,doc.reference,c.company as ccompany,c.name as cname,sup.name as sname,sup.company as scompany, (SELECT SUM(p.price * dl.quantity - p.price * dl.quantity * dl.discount) FROM document_line as dl INNER JOIN product AS p ON dl.id_product = p.id WHERE dl.id_doc = doc.id) as total FROM document as doc LEFT JOIN client as c ON doc.id_client IS NOT NULL and doc.id_client = c.id LEFT JOIN supplier as sup ON doc.id_supplier IS NOT NULL and sup.id = doc.id_supplier WHERE doc.docType = ?";
    $stmt = $mysqli->prepare($SQL);
    $stmt->bind_param("s", $docType);
} else {
    $data = '%'. $_POST["data"] . '%';
    $SQL = "SELECT doc.id,doc.date,doc.reference,c.company as ccompany,c.name as cname,sup.name as sname,sup.company as scompany, (SELECT SUM(p.price * dl.quantity - p.price * dl.quantity * dl.discount) FROM document_line as dl INNER JOIN product AS p ON dl.id_product = p.id WHERE dl.id_doc = doc.id) as total FROM document as doc LEFT JOIN client as c ON doc.id_client IS NOT NULL and doc.id_client = c.id LEFT JOIN supplier as sup ON doc.id_supplier IS NOT NULL and sup.id = doc.id_supplier WHERE doc.docType = ? and (doc.id = ? or doc.date LIKE ? or doc.reference LIKE ?)";
    $stmt = $mysqli->prepare($SQL);
    $stmt->bind_param("ssss", $docType, $data, $data, $data);
}
$stmt->execute();
$res = $stmt->get_result();

header('Content-Type: text/xml');
echo "<documents>";

if ($res->num_rows > 0) {
    while($row = $res->fetch_assoc()) {
        echo "<document>";
        echo "<id>". $row["id"] ."</id>";
        echo "<date>" . $row["date"] . "</date>";
        echo "<ref>" . $row["reference"] . " </ref>";
        if (isset($row["cname"])) {
            echo "<company>" . $row["ccompany"] . "</company>";
            echo "<client-name>" . $row["cname"] . "</client-name>";
        } else {
            echo "<company>" . $row["scompany"] . "</company>";
            echo "<client-name>" . $row["sname"] . "</client-name>";
        }
        
        echo "<total>" . round($row["total"],2) . "</total>";
        echo "</document>";
    }
} else {
    echo "0 results";
}
echo "</documents>";

?>
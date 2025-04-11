<?php

require "../security.php";
require "../db.php";
require "../../assets/fpdf.php";

$id = $_POST["invoice-id"];
$date = $_POST["invoice-date"];
$idClient = $_POST["invoice-client"];
$desc = $_POST["invoice-desc"];
$prodIDs = $_POST["invoice-prodid"];
$discount = $_POST["invoice-discount"];
$quantity = $_POST["invoice-quantity"];

$SQL= "SELECT identification_number,name,company,address,city,country,phone_number FROM client WHERE id = ?";

$stmt = $mysqli->prepare($SQL);
$stmt->bind_param("i",$idClient);
$stmt->execute();
$res = $stmt->get_result();
$clientData = $res->fetch_assoc();


/*$SQL= "SELECT invoice_line.quantity,product.id,product.name,product.iva,product.price,invoice_line.discount FROM invoice_line INNER JOIN product ON invoice_line.id_product = product.id WHERE invoice_line.id_invoice = ?";

$stmt = $mysqli->prepare($SQL);
$stmt->bind_param("i",$_GET["id"]);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    while($row = $res->fetch_assoc()) {

    }
}*/


// Creación del objeto de la clase heredada
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',24);
$pdf->Cell(0,10,'Invoice',0,1);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Client data',0,1);
$pdf->SetFont('Times','',8);
$pdf->Cell(0,5,'Id. Num: '. $clientData["identification_number"],0,1);
$pdf->Cell(0,5,'Company: '. $clientData["company"],0,1);
$pdf->Cell(0,5,'Address: '. $clientData["address"],0,1);
$pdf->Cell(0,5,'City: '. $clientData["city"] . ", " . $clientData["country"],0,1);
$pdf->Cell(0,5,'Phone: '. $clientData["phone_number"],0,1);


$pdf->Output();
?>
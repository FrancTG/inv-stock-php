<?php

require "../security.php";
require "../db.php";
require "../../assets/fpdf.php";
require "../settings.php";

$id = $_POST["id"];
$date = $_POST["date"];
$idClient = $_POST["client"];
$desc = $_POST["desc"];
$prodIDs = $_POST["prodid"];
$discount = $_POST["discount"];
$quantity = $_POST["quantity"];

$SQL= "SELECT identification_number,name,company,address,city,country,phone_number FROM client WHERE id = ?";

$stmt = $mysqli->prepare($SQL);
$stmt->bind_param("i",$idClient);
$stmt->execute();
$res = $stmt->get_result();
$clientData = $res->fetch_assoc();


$SQL= "SELECT product.id,product.name,product.description,product.iva,product.price FROM document_line INNER JOIN product ON document_line.id_product = product.id WHERE document_line.id_doc = ?";

$stmt = $mysqli->prepare($SQL);
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();

// Creación del objeto de la clase heredada
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',24);
$pdf->Cell(0,20,'Invoice',0,1);
$pdf->SetFont('Times','',8);
$pdf->Cell(0,5,'Invoice ID: '.$id,0,1);
$pdf->Cell(0,5,'Date: '.$date,0,1);
$pdf->Cell(10,5,'',0,1);
$pdf->SetFont('Times','',12);
$pdf->Cell(95,5,'From',0,0);
$pdf->Cell(95,5,'Client',0,1);
$pdf->SetFont('Times','',8);
$pdf->Cell(95,5,$COMPANY_NAME,0,0);
$pdf->Cell(95,5,$clientData["company"],0,1);
$pdf->Cell(95,5,'Id. Num: '. $COMPANY_ID,0,0);
$pdf->Cell(95,5,'Id. Num: '. $clientData["identification_number"],0,1);
$pdf->Cell(95,5,'Address: '. $COMPANY_ADDRESS,0,0);
$pdf->Cell(95,5,'Address: '. $clientData["address"],0,1);
$pdf->Cell(95,5,'City: '. $COMPANY_CITY . ", " . $COMPANY_COUNTRY,0,0);
$pdf->Cell(95,5,'City: '. $clientData["city"] . ", " . $clientData["country"],0,1);
$pdf->Cell(95,5,'Phone: '. $COMPANY_PHONE_NUM,0,0);
$pdf->Cell(95,5,'Phone: '. $clientData["phone_number"],0,1);

$pdf->Cell(0,10,'',0,1); //Espacio en los datos y la tabla


// Tabla
$header = array('Id', 'Name', 'IVA (%)', 'Price','Discount (%)','Quantity',"Subtotal","Total");

// Colores, ancho de línea y fuente en negrita
$pdf->SetFillColor(17,42,168);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.3);
$pdf->SetFont('','B');
// Cabecera
$w = array(20, 60, 15, 15, 20, 20, 20, 20);
for($i=0;$i<count($header);$i++)
    $pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
$pdf->Ln();
// Restauración de colores y fuentes
$pdf->SetFillColor(224,235,255);
$pdf->SetTextColor(0);
$pdf->SetFont('');
$fill = false;

$index = 0;
$ttotal = 0;
if ($res->num_rows > 0) {
    while($row = $res->fetch_assoc()) {

        $subtotal = $row["price"] * $quantity[$index];
        $total = $subtotal - (($discount[$index] / 100) * $subtotal);
        $ttotal = $ttotal + $total;
    
        $pdf->Cell($w[0],6,$row["id"],'LR',0,'C',$fill);
        $pdf->Cell($w[1],6,$row["name"].", ".$row["description"],'LR',0,'L',$fill);
        $pdf->Cell($w[2],6,$row["iva"],'LR',0,'C',$fill);
        $pdf->Cell($w[3],6,$row["price"],'LR',0,'C',$fill);
        $pdf->Cell($w[4],6,$discount[$index],'LR',0,'C',$fill);
        $pdf->Cell($w[5],6,$quantity[$index],'LR',0,'C',$fill);
        $pdf->Cell($w[6],6,$subtotal,'LR',0,'C',$fill);
        $pdf->Cell($w[7],6,$total,'LR',0,'C',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $index = $index + 1;
    }
}
$pdf->Cell(array_sum($w),0,'','T');
$pdf->Ln();
$pdf->Cell($w[0],6,"Total",'LR',0,'C',$fill);
$pdf->Cell($w[1],6,"",'LR',0,'C',$fill);
$pdf->Cell($w[2],6,"",'LR',0,'C',$fill);
$pdf->Cell($w[3],6,"",'LR',0,'C',$fill);
$pdf->Cell($w[4],6,"",'LR',0,'C',$fill);
$pdf->Cell($w[5],6,"",'LR',0,'C',$fill);
$pdf->Cell($w[6],6,"",'LR',0,'C',$fill);
$pdf->Cell($w[7],6,$ttotal,'LR',0,'C',$fill);
$pdf->Ln();

// Línea de cierre
$pdf->Cell(array_sum($w),0,'','T');
$pdf->Ln();

$pdf->Cell(0,10,'',0,1);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Description',0,1);
$pdf->SetFont('Times','',8);
$pdf->Cell(0,10,$desc,0,1);

$pdf->Output('I','invoice.pdf',false);
?>
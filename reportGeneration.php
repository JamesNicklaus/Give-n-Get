<?php

require('serverconnect.php');



require('fpdf.php');

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('images/logo2.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',20);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Your 2022 Donations',0,0,'C');
        // Line break
        $this->Ln(20);
    }
}

$userid = $_GET['userid'];
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Ln();

$query = "SELECT * FROM donations WHERE userId = '$userid' AND status = 'Complete';";
$queryResults = mysqli_query($mysqli, $query);

while ($row = mysqli_fetch_array($queryResults)) {
    $query2 = "SELECT * FROM food_banks WHERE ein_number = '$row[1]';";
    $queryResults2 = mysqli_query($mysqli, $query2);
    $row2 = mysqli_fetch_array($queryResults2);
    $donoTable = "dono_" . $row[0] . "";
    $newDate = date("m/d/Y", strtotime($row[4]));

    $pdf->SetFont('Times', 'BU', 15);
    $pdf->Cell(0,10,'You donated the following items to '.$row2[1].' on '.$newDate ,0,1,'C');
    //$pdf->Ln();
    $pdf->SetFont('Times', 'B', 13);
    $pdf->Cell(64,10,'Item Name',1,0,'C');
    $pdf->Cell(64,10,'Item Type',1,0,'C');
    $pdf->Cell(64,10,'Quantity',1,1,'C');

    $query3 = "SELECT * FROM `$donoTable`;";
    $queryResults3 = mysqli_query($mysqli, $query3);

    
    while ($row3 = mysqli_fetch_array($queryResults3)) {
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(64,10,''.$row3[0].'',1,0,'C');
        $pdf->Cell(64,10,''.$row3[1].'',1,0,'C');
        $pdf->Cell(64,10,''.$row3[2].'',1,1,'C');
    }
    $pdf->Ln();
    $pdf->Ln();
}

$pdf->Output();

$query2 = "SELECT `COLUMN_NAME` 
FROM `INFORMATION_SCHEMA`.`COLUMNS` 
WHERE `TABLE_SCHEMA`='foodBank_db' 
AND `TABLE_NAME`='donations';";

$header = mysqli_query($mysqli, $query2);
$row = mysqli_fetch_array($header);

for ($i = 0; $i < count($row); $i++) {
    
    //$pdf->Cell(40,10,$row[$i]);
    

}


//$pdf->Output();

?>
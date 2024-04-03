<?php

require('rounded_rect2.php');


$pdf=new PDF('L','mm',[170,215]);
$pdf->SetFont('Arial','B',10);
$pdf->setMargins(5, 5, 10);
$pdf->AddPage();
$pdf->SetFillColor(255);
$pdf->RoundedRect(3, 3, 208, 154, 5, '80', 'DF');
$pdf->Cell(140  ,5,'NORTHERN ARROW LUBES CORPORATION',0,1,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(125  ,5,'Km. 102 Maharlika Highway Brgy. Magpapalayok ',0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60  ,5,'TYPE OF BOOKING ',0,1,'R');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(130  ,5,'San Leonardo, Nueva Ecija, 3102 ',0,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(60  ,5,'________  Telebook ',0,1,'L');
$pdf->Cell(130  ,5,' ',0,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(60  ,7,'________  Actual Visit ',0,1,'L');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60  ,5,'SALES ORDER FORM',0,1,'L');
$pdf->SetFillColor(255);
$pdf->RoundedRect(5, 32, 128, 125, 5, '80', 'DF');
$pdf->SetFillColor(255);
$pdf->RoundedRect(134, 32, 77, 125, 5, '80', 'DF');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(128 ,5,'CUSTOMER NAME :',1,0,'L');
$pdf->Cell(78 ,5,'   DATE :',1,1,'L');
$pdf->Cell(128 ,5,'ADDRESS :',1,0,'L');
$pdf->Cell(78 ,5,'   DSR :',1,1,'L');
$pdf->Cell(40,10,'PARTICULARS',1,0,'C');
$pdf->Cell(30,5,'QUANTITY',1,0,'C');
$pdf->Cell(27,5,'UNIT',1,0,'C');
$pdf->Cell(31,5,'TOTAL',1,0,'C');
$pdf->Cell(78,10,'ACCOUNT STATUS',1,0,'C');
$pdf->Cell(0,5,'',0,1); 
$pdf->Cell(40,0,'',0,0);
$pdf->Cell(15,5,'CARTON',1,0);
$pdf->Cell(15,5,'LITER',1,0,'C');
$pdf->Cell(27,5,'PRICE',1,0,'C');
$pdf->Cell(31,5,'AMOUNT',1,1,'C');


$pdf->Output();
    
?>
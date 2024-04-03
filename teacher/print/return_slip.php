<?php

include('config.php');

$inv = $_GET['ID'];


$sql = mysqli_query($conn,"SELECT * from s_return where id= '$inv' ");

		
while ($row = mysqli_fetch_assoc($sql)) {
 	
 $cname = 	$row['rto'];
 $invoice = $row['invoice'];
 $date1 = $row['date_r'];
 $qty = $row['qty'];
 $liters = $row['liters'];
 $price = $row['price'];
 $pname = $row['p_name'];
  $series = 	$row['series'];
 } 



?>


<?php



								?>

<?php

require('rounded_rect2.php');

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm



$pdf = new PDF('P','mm',[250,200]);

$pdf->AddPage();
//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',10);
$pdf->setMargins(4, 4, 10);
//Cell(width , height , text , border , end line , [align] )
$pdf->SetFillColor(255);
$pdf->RoundedRect(3, 3, 190, 150, 5, '80', 'DF');
$pdf->Cell(190	,5,'NORTHERN ARROW LUBES CORPORATION',0,1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(190	,5,'Km. 102 Maharlika Highway Brgy. Magpapalayok, San Leonardo, Nueva Ecija',0,1,'C');
$pdf->Cell(190	,5,'Tel. #(044)940-3039',0,1,'C');
$pdf->Cell(190	,5,'VAT REG TIN:039-374-533-000',0,1,'C');
//set font to arial, bold, 14pt
$pdf->Cell(189	,5,'',0,1);
$pdf->Cell(80	,10,'RETURN SLIP',1,0,'C');
$pdf->SetFont('Arial','',14);
$pdf->Cell(50	,10,$series,0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60	,10,'Date:      '.$date1,0,1,'L');
$pdf->Cell(58	,10,'   ',0,0,'L');

$pdf->SetFont('Arial','',12);
$pdf->Cell(150	,4,'',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(188,10,'RTO NAME:  '.$cname,1,1); //vertically merged cell

//Cell(width , height , text , border , end line , [align] )
$pdf->Cell(10,2,'',0,1);
//normal row height=5.
$pdf->Cell(10,10,'QTY',1,0,'C');
$pdf->Cell(112,10,'PARTICULAR',1,0,'C'); //normal height, but occupy 4 columns (horizontally merged)
$pdf->Cell(34,10,'LITERS',1,0,'C'); //vertically merged cell
$pdf->Cell(32,10,'AMOUNT',1,1,'C'); //dummy line ending, height=5(normal row height) width=09 should be invisible 


//second line(row)

$pdf->Cell(10,5,$qty,1,0,'C'); 
$pdf->Cell(112,5,$pname,1,0,'C');
$pdf->Cell(34,5,$liters,1,0,'C');
$pdf->Cell(32,5,$price,1,1,'C');


//data rows
$pdf->Cell(10,15,'',0,1);
$pdf->Cell(10,5,'',0,0,'C'); 
$pdf->Cell(112,5,'',0,0,'C');
$pdf->SetFont('Arial','',6);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(32,5,'',0,1,'L');
$pdf->Cell(10,5,'',0,0,'C'); 
$pdf->Cell(112,5,'',0,0,'C');
$pdf->SetFont('Arial','',6);
$pdf->Cell(34,4,'',0,1);
$pdf->Cell(10,5,'',0,0,'C'); 
$pdf->Cell(112,5,'',0,0,'C');
$pdf->SetFont('Arial','',6);

$pdf->Cell(10,5,'',0,0,'C'); 
$pdf->Cell(112,5,'',0,0,'C');
$pdf->SetFont('Arial','',6);

$pdf->Cell(10,5,'',0,0,'C'); 
$pdf->Cell(112,5,'',0,0,'C');
$pdf->SetFont('Arial','',6);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(55,3,'',0,1,'C');

$pdf->Cell(88,5,'',0,1,'C');


$pdf->SetFont('Arial','B',7);
$pdf->Cell(47,8,'Prepared By:',1,0);
$pdf->Cell(47,8,'Approved By:',1,0);
$pdf->Cell(47,8,'Released BY:',1,0);
$pdf->Cell(47,8,'Delivered BY:',1,1);

$pdf->Cell(39,8,'REFERENCE#:'.$invoice,0,1);
$pdf->Cell(39,8,'REMARKS:',0,1);
$pdf->Output();
?>

<?php

include('config.php');

$id = $_GET['ID'];
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$th = $_GET['hours'];
$lname = $_GET['lname'];
$fname = $_GET['fname'];
$sql = mysqli_query($conn,"SELECT * from tbl_barcodesummary where empID='$id' and datein between '$date1' and '$date2' ");





?>


<?php



								?>

<?php

require('rounded_rect2.php');

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm



$pdf = new PDF('P','mm',[115,115]);

$pdf->AddPage();
//set font to arial, bold, 14pt

$pdf->SetTopMargin(2);
$pdf->SetFillColor(255);
$pdf->RoundedRect(1, 1, 113, 98, 2, '80', 'DF');
$pdf->setMargins(2, 1, 5);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(39,1,'',0,1);
$pdf->SetFont('Arial','',6);
$pdf->Cell(112,5,$lname.',  '.$fname,1,1,'C');
$pdf->Cell(15,3,'Date',1,0,'C');
$pdf->Cell(15,3,'Day',1,0,'C'); //normal height, but occupy 4 columns (horizontally merged)
$pdf->Cell(15,3,'In',1,0,'C'); //vertically merged cell
$pdf->Cell(15,3,'Out',1,0,'C');
$pdf->Cell(8,3,'RH',1,0,'C');
$pdf->Cell(8,3,'ROT',1,0,'C');
$pdf->Cell(8,3,'SOT',1,0,'C');
$pdf->Cell(8,3,'SHOT',1,0,'C');
$pdf->Cell(20,3,'REMARKS',1,1,'C'); //dummy line ending, height=5(normal row height) width=09 should be invisible 


//second line(row)
while ($row = mysqli_fetch_array($sql)) {
 	
		 

  
$pdf->Cell(15,3,$row['datein'],1,0,'C'); 
$pdf->Cell(15,3,$row['day'],1,0,'C');
$pdf->Cell(15,3,$row['emp_in'],1,0,'C');
$pdf->Cell(15,3,$row['emp_out'],1,0,'C');
$pdf->Cell(8,3,$row['Hours'],1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(20,3,'',1,1,'C');
}


$pdf->Cell(30,3,'ADJUSTMENTS:',1,0,'C');
$pdf->Cell(15,3,'',1,0,'C');
$pdf->Cell(15,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(20,3,'',1,1,'C');


$pdf->Cell(15,3,'',1,0,'C'); 
$pdf->Cell(15,3,'',1,0,'C');
$pdf->Cell(15,3,'',1,0,'C');
$pdf->Cell(15,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(20,3,'',1,1,'C');
//data rows

$pdf->Cell(30,3,'TOTAL:',1,0,'C');
$pdf->Cell(15,3,$th,1,0,'C');
$pdf->Cell(15,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(8,3,'',1,0,'C');
$pdf->Cell(20,3,'',1,1,'C');


$pdf->Output();
?>

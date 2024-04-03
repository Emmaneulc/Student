<?php
include('../includes/config.php');



  $renew_id = $_GET['ID'];
$selectQuery = "SELECT * FROM renew WHERE  id = '$renew_id' ";
$result = $conn->query($selectQuery);
  //$cnt=1;
  
  while($row=$result->fetch_assoc())
      {
  $mysqlDateTime = $row['date_created'];
   //trim timestamp to date
  $selectQuery1 = "SELECT * FROM members WHERE  id = '".$row['member_id']."' ";
  $result1 = $conn->query($selectQuery1); 
  $memberData = $result1->fetch_assoc();

   $selectQuery2 = "SELECT * FROM violation WHERE  id = '".$row['violation_id']."' ";
  $result2 = $conn->query($selectQuery2); 
  $vioData = $result2->fetch_assoc();
      }

?>
<?php



								?>

<?php


require('rounded_rect2.php');

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm




$pdf = new PDF('P','mm',[215.9,279.4]);

$pdf->AddPage();
//set font to arial, bold, 14pt

//Cell(width , height , text , border , end line , [align] )



$pdf->Image('Letter.JPG',0,0,210);
$pdf->SetXY(5, 55);

$datet = date_format(date_create($mysqlDateTime),"F j, Y");
$pdf->SetXY(35, 22);
$pdf->SetFont('Arial','',12);
$pdf->Cell(25,10,$datet,0,'L');
$pdf->SetXY(41, 42);
$pdf->SetFont('Arial','',12);
$pdf->Cell(25,10,$memberData['address'],0,0,'L');
$pdf->SetXY(43, 66);
$pdf->SetFont('Arial','',12);
$pdf->Cell(65,10,'MR/MS/MRS.  '.$memberData['student_guard'].', ',0,0,'L');
$pdf->SetXY(62, 80);
$pdf->SetFont('Arial','',12);
$pdf->Cell(40,10,$vioData['violation'],0,0,'L');
$pdf->Cell(35,10,$vioData['offense'],0,0,'L');

//set font to arial, bold, 14pt


$pdf->Output();
?>

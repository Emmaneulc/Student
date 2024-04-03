<?php

include('config.php');

$id = $_GET['ID'];
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];

$sql = mysqli_query($conn,"SELECT * from payroll_date where id='$id' ");





?>

<?php



								?>

<?php

require('rounded_rect2.php');

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm



$pdf = new PDF('L','mm',[140,80]);

$pdf->AddPage();
//set font to arial, bold, 14pt
$pdf->SetFillColor(255);
$pdf->RoundedRect(1, 1, 138, 78, 2, '80', 'DF');
$pdf->SetFillColor(255);
$pdf->RoundedRect(3, 15, 134, 60, 2, '80', 'DF');
$pdf->setMargins(2, 1, 2);
$pdf->SetTopMargin(0);
$pdf->SetLeftMargin(4);


while ($row = mysqli_fetch_array($sql)) {
    $idnum = $row['id'];
    $id_num = $row['employeeID'];
	$fname =  $row['fname'];
	$lname =  $row['lname'];
	$canteen =  $row['canteen'];
	$rice =  $row['rice_vale'];
	$cash =  $row['cash_ad'];
	$other =  $row['other_d'];
	$gross =  $row['gross'];
	$net =  $row['net_salary'];
	$allowance =  $row['allowance'];
		$adjust =  $row['adjustment'];
	$total_d = $row['total_d'];
	$total_h = $row['t_hours']; 


$query1 = mysqli_query($conn,"select * from tbl_employeeinfo1 where employeeID='$id_num'  ");

while($row1 = mysqli_fetch_array($query1)){
	
	$rate =  $row1['emp_rate'];
	$sss =  $row1['SSS_pay'];
	$pagibig =  $row1['pagibig_pay'];
	$phil =  $row1['phil_pay'];
	$c_loan =  $row1['company_loan'];


				


}



$pdf->SetFont('Arial','B',8);
$pdf->Cell(39,1,'',0,1);
$pdf->SetFont('Arial','',6);
$pdf->Cell(112,5,$date1.' - '.$date2,0,1,'L');
$pdf->Cell(15,5,'Rates',0,0,'C');
$pdf->Cell(25,5,'',0,0,'C');
$pdf->Cell(15,5,'Deductions',0,0,'C');
$pdf->Cell(30,5,'',0,0,'C');
$pdf->Cell(15,5,'Other Deductions',0,1,'C');
$pdf->Cell(15,4,'Firstname:',1,0,'C');
$pdf->Cell(15,4,$fname,1,0,'C');
$pdf->Cell(12,5,'',0,0,'C');
$pdf->Cell(16,4,'SSS:',1,0,'C');
$pdf->Cell(15,4,$sss,1,0,'C');
$pdf->Cell(12,5,'',0,0,'C');
$pdf->Cell(15,4,'Canteen vale:',1,0,'C');
$pdf->Cell(15,4,$canteen,1,1,'C');
$pdf->Cell(15,4,'Lastname:',1,0,'C');
$pdf->Cell(15,4,$lname,1,0,'C');
$pdf->Cell(12,5,'',0,0,'C');
$pdf->Cell(16,4,'Pag-Ibig:',1,0,'C');
$pdf->Cell(15,4,$pagibig,1,0,'C');
$pdf->Cell(12,5,'',0,0,'C');
$pdf->Cell(15,4,'Rice Vale:',1,0,'C');
$pdf->Cell(15,4,$rice,1,1,'C');
$pdf->Cell(15,4,'Total W/Hours:',1,0,'C');
$pdf->Cell(15,4,$total_h,1,0,'C');
$pdf->Cell(12,5,'',0,0,'C');
$pdf->Cell(16,4,'Philhealth:',1,0,'C');
$pdf->Cell(15,4,$phil,1,0,'C');
$pdf->Cell(12,5,'',0,0,'C');
$pdf->Cell(15,4,'Cash Advance:',1,0,'C');
$pdf->Cell(15,4,$cash,1,1,'C');
$pdf->Cell(15,4,'Rate/Hour:',1,0,'C');
$pdf->Cell(15,4,$rate,1,0,'C');
$pdf->Cell(12,5,'',0,0,'C');
$pdf->Cell(16,4,'Company Loan',1,0,'C');
$pdf->Cell(15,4,$c_loan,1,0,'C');
$pdf->Cell(12,5,'',0,0,'C');
$pdf->Cell(15,4,'Others:',1,0,'C');
$pdf->Cell(15,4,$other,1,1,'C');
$pdf->Cell(15,4,'Adjustment:',1,0,'C');
$pdf->Cell(15,4,$adjust,1,1,'C');
$pdf->Cell(15,4,'Allowance:',1,0,'C');
$pdf->Cell(15,4,$allowance,1,1,'C');
$pdf->Cell(85,1,'',0,1,'C');
$pdf->Cell(85,5,'',0,0,'C');
$pdf->Cell(18,4,'Gross Income',1,0,'C');
$pdf->Cell(18,4,$gross,1,1,'C');
$pdf->Cell(85,5,'',0,0,'C');
$pdf->Cell(18,4,'Total Deductions',1,0,'C');
$pdf->Cell(18,4,$total_d,1,1,'C');
$pdf->Cell(85,5,'',0,0,'C');
$pdf->Cell(18,4,'Net Income',1,0,'C');
$pdf->Cell(18,4,$net,1,1,'C');
 //normal height, but occupy 4 columns (horizontally merged)
 //dummy line ending, height=5(normal row height) width=09 should be invisible 
  

}



$pdf->Output();
?>

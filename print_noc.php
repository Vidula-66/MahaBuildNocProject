<?php
include("db.php");
require('fpdf/fpdf.php');

if (!isset($_GET['id'])) die("No application specified.");

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM applicants WHERE id=$id");

if ($result->num_rows == 0) die("Application not found.");

$row = $result->fetch_assoc();
$name = strtoupper($row['name']);
$address = $row['address'];
$certificate_date = date("d-m-Y");
$noc_id = "NOC-" . str_pad($row['id'], 5, "0", STR_PAD_LEFT);

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();

// Border
$pdf->SetLineWidth(1.5);
$pdf->Rect(5, 5, 200, 287);

// Logo
if (file_exists('images/logo.png')) $pdf->Image('images/logo.png', 15, 10, 25);

$pdf->SetFont('Arial','B',20);
$pdf->SetTextColor(0,0,128);
$pdf->Cell(0,15,'GOVERNMENT OF MAHARASHTRA',0,1,'C');

$pdf->SetFont('Arial','B',16);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(0,10,'MAHABUILD NOC – BUILDING PERMISSION CERTIFICATE',0,1,'C');

$pdf->SetDrawColor(0,0,128);
$pdf->SetLineWidth(0.8);
$pdf->Line(20, 45, 190, 45);

$pdf->Ln(15);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'CERTIFICATE OF BUILDING PERMISSION',0,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','',12);
$text = "This is to certify that Mr./Ms. $name, residing at $address, has been granted official permission for construction as per the Building Permission rules of the Government of Maharashtra. The application has been verified by the Admin and approved by the designated Officer. This certificate serves as an official proof for proceeding with construction in compliance with applicable regulations.";
$pdf->MultiCell(0,7,$text,0,'L');

$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(224,235,255);
$pdf->Cell(0,8,"Certificate ID: $noc_id",0,1,'L',true);
$pdf->Cell(0,8,"Date of Issue: $certificate_date",0,1,'L',true);

$pdf->Ln(25);
$pdf->SetFont('Arial','B',12);
$pdf->SetY(230);
$pdf->Cell(0,10,'Authorized Officer Signature',0,1,'R');

if (file_exists('images/signature.png')) $pdf->Image('images/signature.png', 150, 209, 45);

$pdf->Ln(25);
$pdf->SetFont('Arial','I',10);
$pdf->SetTextColor(100,100,100);
$pdf->Cell(0,10,'This is a digitally generated certificate issued by MahaBuildNOC Portal, Government of Maharashtra.',0,1,'C');

$pdf->SetDrawColor(0,0,128);
$pdf->Line(20, 275, 190, 275);

$pdf->Output(); // displays in browser / allows download
?>

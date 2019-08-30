<?php
include_once ('../api/Connection.php');
require_once ('../api/FPDF/fpdf.php');
define('FPDF_FONTPATH', '../api/FPDF/font/');

$db = new connection_database;
$connect = $db->db_connection();

$pdf = new FPDF;
$pdf->AddPage();

$pdf->setFont('Arial', 'B', 16);
$pdf->Cell(0,5, 'PT TRANS BERJAYA KHATULISTIWA', '0', '1', 'C', false);
$pdf->SetFont('Arial', 'i', 8);
$pdf->Cell(0,5,'Alamat : Jl. Pesantren - Komp. Taman Bumi Prima Blok P7, Cibabat, Cimahi Utara, Jawa Barat', '0', '1', 'C', false);
$pdf->Ln(3);
$pdf->Cell(190,0.6,'','0','1','C',true);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',20);
$pdf->Cell(50,5,'Data Divisi','0','1','L',false);
$pdf->Ln(6);

$pdf->SetFont('Arial','B',16);
$pdf->Cell(12,8,'No',1,0,'C');
$pdf->Cell(35,8,'ID DIVISI',1,0,'C');
$pdf->Cell(50,8,'NAMA DIVISI',1,0,'C');
$pdf->Ln(0);

$query = "SELECT * FROM tb_divisi ORDER BY id_divisi ";
$statement = $connect->prepare($query);
$statement->execute();

$no = 0;
   while($data = $statement->fetch(PDO::FETCH_ASSOC)){
     $no++;
    $pdf->Ln(8);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(12,8,$no.".",1,0,'C');
    $pdf->Cell(35,8,$data['id_divisi'],1,0,'C');
    $pdf->Cell(50,8,$data['nama_divisi'],1,0,'C');
 }



$pdf->Output();


?>
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

$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,5,'Laporan Data Pegawai','0','1','L',false);
$pdf->Ln(3);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(8,6,'No',1,0,'C');
$pdf->Cell(20,6,'NIP',1,0,'C');
$pdf->Cell(37,6,'NAMA',1,0,'C');
$pdf->Cell(50,6,'ALAMAT',1,0,'C');
$pdf->Cell(35,6,'NO TELP',1,0,'C');
$pdf->Cell(30,6,'DIVISI',1,0,'C');
$pdf->Ln(2);

$query = "SELECT tb_pegawai.nip, tb_pegawai.nama, tb_pegawai.alamat, tb_pegawai.no_telp, tb_pegawai.gaji,
         tb_divisi.nama_divisi FROM tb_pegawai INNER JOIN tb_divisi ON tb_pegawai.id_divisi = tb_divisi.id_divisi
         ORDER BY tb_pegawai.nip";
$statement = $connect->prepare($query);
$statement->execute();

$no = 0;
   while($data = $statement->fetch(PDO::FETCH_ASSOC)){
     $no++;
    $pdf->Ln(4);
    $pdf->SetFont('Arial','',7);
    $pdf->Cell(8,4,$no.".",1,0,'C');
    $pdf->Cell(20,4,$data['nip'],1,0,'C');
    $pdf->Cell(37,4,$data['nama'],1,0,'C');
    $pdf->Cell(50,4,$data['alamat'],1,0,'C');
    $pdf->Cell(35,4,$data['no_telp'],1,0,'C');
    $pdf->Cell(30,4,$data['nama_divisi'],1,0,'C');
 }



$pdf->Output();


?>
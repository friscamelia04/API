<?php
include_once ('../api/models/ModelKaryawan.php');
require_once ('../api/FPDF/fpdf.php');
define('FPDF_FONTPATH', '../api/FPDF/font/');

$lib = new Karyawan;
$row = $lib->fetch_datapegawai();

// class PDF extends FPDF{

//     function Header(){
//         $this->Image('tiketux.png',1,1,2.25); //logo
//         $this->SetTextColor(128,0,0); //warna text
//         $this->SetFont('Arial', 'B', '12'); //Font yang digunakan Arial Bold ukuran 12
//         $this->Cell(19,1,'LAPORAN DATA PEGAWAI TIKETUX',0,0,'C'); //membuat cell dengan panjang 19 dan align center 'C'
//         $this->Ln(); //baris baru
//         $this->SetFont('Arial', 'B', '9');
//         $this->SetFillColor(192,192,192); //Warna isi
//         $this->SetTextColor(0,0,0); //Warna Text untuk TH
//         $this->Cell(6);
//         $this->Cell(1,1,'NO','TB',0,'L',1); //cell dengan panjang 1
//         $this->Cell(2,1,'NIP','TB',0,'L',1); //cell dengan panjang 2
//         $this->Cell(4,1,'NAMA','TB',0,'L',1); //cell dengan panjang 4
//         $this->Cell(6,1,'ALAMAT','TB',0,'L',1); //cell dengan panjang 6
//         $this->Cell(3,1,'NO TELP','TB',0,'L',1); //cell dengan panjang 3
//         $this->Cell(3,1,'DIVISI','TB',0,'L',1); //cell dengan panjang 3
//         $this->Ln();
//     }

//     function Footer(){
//         $this->SetY(-2,5);
//         $this->Cell(0,1,$this->PageNo(),0,0,'C');
//     }
// }

// $pdf= new PDF('P', 'cm', 'A4');
// $pdf->AddPage();

// $pdf->SetFont('Arial', '', '8');
// //Perulangan untuk membuat tabel
// $pdf->Cell(6);
// $pdf->Cell(1,1,$row['nip'],'B',0,'C');
// $pdf->Cell(2,1,$row['nip'],'B',0,'C');
// $pdf->Cell(4,1,$row['nama'],'B',0,'C');
// $pdf->Cell(6,1,$row['alamat'],'B',0,'C');
// $pdf->Cell(3,1,$row['no_telp'],'B',0,'C');
// $pdf->Cell(3,1,$row['divisi'],'B',0,'C');
// $pdf->Ln();

// $pdf->Output();

$pdf = new FPDF('P','mm',array(210,297)); //L For Landscape / P For Portrait
$pdf->AddPage();

    // $pdf->Image('ttx.png',20,5,-100);
    // $pdf->Cell(60);
    // $pdf->SetFont('Times','B',13);
    // $pdf->Cell(30,20,'PT. TRANSBERJAYA KHATULISTIWA',0,0,false);
    // $pdf->Ln();
    // $pdf->Cell(60);
    // $pdf->SetFont('Times','',10);
    // $pdf->Cell(0,0,'Jl. Pesantren - Komp. Taman Bumi Prima Blok P7, Cibabat, Cimahi Utara, Jawa Barat',0,0,false);
    // $pdf->Ln();

    $pdf->Image('ttx.png',20,3,-150);
    $pdf->SetFont('Times', 'B', 10);
    $pdf->Cell(43);
    $pdf->Cell(0,3,'PT. TRANS BERJAYA KHATULISTIWA','0','1',false);
    $pdf->SetFont('Times','',5);
    $pdf->Cell(43);
    $pdf->Cell(0,3,'Jl. Pesantren - Komp. Taman Bumi Prima Blok P7, Cibabat, Cimahi Utara, Jawa Barat','0','1',false );
    $pdf->SetFont('Times','',5);
    $pdf->Cell(43);
    $pdf->Cell(0,3,'Telp : +62 22 06 11 404 | Email : info@tiketux.com | www.tiketux.com','0','1',false);
    $pdf->Ln(3);

    $pdf->SetFont('Times','u',19);
    $pdf->Cell(3);
    $pdf->Cell(0,15,'FORM SURAT PERINTAH LEMBUR','0','0',false);
    $pdf->Ln();

    $pdf->SetFont('Times','',14);
    $pdf->Cell(3);
    $pdf->Cell(0,0,'Perusahaan dengan ini menugaskan kepada :','0','1',false);
    $pdf->SetFont('Times','',14);
    $pdf->Cell(3);
    $pdf->Cell(0,12,'NAMA                       :','0','1',false);
    $pdf->SetFont('Times','',14);
    $pdf->Cell(3);
    $pdf->Cell(0,2,'DIVISI                       :','0','1',false);
    $pdf->Ln();

    $pdf->SetFont('Times','',14);
    $pdf->Cell(3);
    $pdf->Cell(0,15,'Untuk melaksanakan pekerjaan lembur sebagai berikut :','0','1',false);
    $pdf->SetFont('Times','',14);
    $pdf->Cell(3);
    $pdf->Cell(0,0,'HARI                         :','0','1',false);
    $pdf->SetFont('Times','',14);
    $pdf->Cell(3);
    $pdf->Cell(0,14,'TANGGAL                :','0','1',false);
    $pdf->SetFont('Times','',14);
    $pdf->Cell(3);
    $pdf->Cell(0,2  ,'JAM                           :','0','1',false);
    $pdf->Ln();
    $pdf->Cell(3);
    $pdf->Cell(0,10  ,'PEKERJAAN            :','0','1',false);
    $pdf->Ln();

    



$pdf->Output();



?>
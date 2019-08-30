<?php
include_once ('../api/models/ModelPengajuan.php');

$lib = new Pengajuan;

$data = $lib->fetch_datapengajuan();

// $awal = date_create($data['tanggal']);
// $akhir = date_create($data['tanggal_selesai']);

$awal = new DateTime($data['jam_mulai']);
$akhir = new DateTime($data['jam_selesai']);
$diff = $akhir->diff($selesai);

//$diff = date_diff($awal,$akhir);

echo 'Selisih waktu';
echo $diff->h . 'jam';
echo $diff->i . 'menit';

?>
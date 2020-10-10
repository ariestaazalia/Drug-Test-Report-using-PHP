<?php
ob_start();
include '../config/conn.php';
session_start();
if (!$_SESSION['login']) {
		echo "<script> alert('Anda Belum Login, Silahkan Login') </script>";
   		echo "<script> window.location.href='login.php' </script>";
	}

$id=$_GET['id'];
$db=mysqli_query($con, "SELECT tb_pemohon.*, tb_hasilpemeriksaan.* FROM tb_pemohon JOIN tb_hasilpemeriksaan ON tb_hasilpemeriksaan.id_pemohon = tb_pemohon.id_pemohon where tb_pemohon.id_pemohon='$id'");
$data= mysqli_fetch_assoc($db);


	$hari = array('1' => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu' );
	$bln = array('1' => 'I', 
				'2' => 'II', 
				'3' => 'III',
				'4' => 'IV',
				'5' => 'V', 
				'6' => 'VI',
				'7' => 'VII', 
				'8' =>'VIII', 
				'9' =>'IX', 
				'10' => 'X', 
				'11' => 'XI', 
				'12' => 'XII' );

function tanggalIndo($tanggal){
	$bulan = array('1' => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober','November', 'Desember' );
	$split = explode('-', $tanggal);
	return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
}

date_default_timezone_set('Asia/Jakarta');
// Bulan Romawi
	$month= date('m');
	$romawi=  $bln[ (int)$month ];

// Bulan Huruf


$year= date('Y');
$dob= $data['tanggal_lahir'];
$diff = ($year - date('Y',strtotime($dob)));

?>
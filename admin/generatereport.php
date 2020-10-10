<?php
ob_start();
	include '../config/conn.php';
	require 'pdf/fpdf.php';
	session_start();
	$db=new PDO('mysql:host=localhost; dbname=bnny3498_bnnk', 'bnny3498_bnn', 'MzrpvrOWkNa8');
	if (!$_SESSION['login']) {
		echo "<script> alert('Anda Belum Login, Silahkan Login') </script>";
   		echo "<script> window.location.href='login.php' </script>";
	}

	if ($_SESSION['status']!=1) {
	    echo "<script> alert('Anda Tidak Memiliki Hak Akses') </script>";
	    echo "<script> window.location.href='index.php' </script>";
	}

	class myPDF extends FPDF
	{		
		function header(){
			$this-> Image('../img/LogoBNNK.png', 10, 10, -150);
			$this-> SetFont('Arial', 'B', 20);
			$this-> Ln(15);
			$this-> Cell(150, 5, 'LAPORAN TAHUNAN SKHPN',0, 0, 'C');
			$this-> Ln();
			$this-> SetFont('Times', '', 12);
			$this-> Ln();
			$this-> Cell(150, 5, 'Kalikabong, Kalimanah, Kalikabong, Kec. Purbalingga', 0, 0, 'C');
			$this-> Ln();
			$this-> Cell(150,5, 'Kabupaten Purbalingga, Jawa Tengah 53321', 0, 0, 'C');
			$this-> Ln(20);
			$this->SetLineWidth(0);
			$this->Line(10,56,200,56);
			$this->SetLineWidth(0);
			$this->Line(10,57,200,57);
			$this->Ln();
		}

		function footer(){
	    	$this->setY(-15);
	    	$this->SetFont('Arial','B','8');
	    	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    	}

		function headerTable(){
    		$this->Ln(20);
	    	$this->SetFont('Arial','B',12);
	    	$this->Cell(10,10,'No.',1,0,'C');
	    	$this->Cell(30,10,'Tahun',1,0,'C');
	    	$this->Cell(90,10,'Jumlah SKHPN yang Diterbitkan',1,0,'C');
	    	$this->Ln();
	    }

	    function viewTable($db){
    	$this->setFont('Arial','',12);
    	$stmt=$db->query("SELECT COUNT(status_permohonan) AS stat, YEAR(tanggal_periksa) AS year FROM tb_pemohon JOIN tb_hasilpemeriksaan on tb_pemohon.id_pemohon = tb_hasilpemeriksaan.id_pemohon WHERE status_permohonan='2' GROUP BY YEAR(tanggal_periksa)");
    	$data=$stmt->fetch(PDO::FETCH_OBJ);
    	    	
    	$num=0; do{
    		$num++;
    		$this->Cell(10,10,$num,1,0,'C');
    		$this->Cell(30,10,$data->year,1,0,'C');
	    	$this->Cell(90,10,$data->stat,1,0,'C');
	    	$this->Ln();    	
    	} while ($data=$stmt->fetch(PDO::FETCH_OBJ));
    	}
	}

	$pdf= new myPDF();
	$pdf-> AliasNbPages();
	$pdf-> SetLeftMargin(40);
	$pdf-> AddPage('P', 'A4', 0);
	$pdf-> headerTable();
	$pdf-> viewTable($db);
	$pdf-> Output();
?>
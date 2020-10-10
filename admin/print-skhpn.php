<?php 
	ob_start();
	include '../config/conn.php';
	require( "./pdf/fpdf.php" );
	require './extentionfpdf.php';
	session_start();
	if (!$_SESSION['login']) {
		echo "<script> alert('Anda Belum Login, Silahkan Login') </script>";
	    echo "<script> window.location.href='login.php' </script>";
	}

	if ($data['status_permohonan']!=2) {
	  echo "<script> 
	      alert('SKHPN Belum Diproses');
	      window.location.href='skhpn.php';
	    </script>";
	}
	
	$upnama=strtoupper($data['nama_pemohon']);
	$upjenisk=strtoupper($data['jenis_kelamin']);

	$path = './img/uploads/';
	$filename = $data['foto_identitas'];
	$filepath = $path.$filename;

	// If a physical file is not available then create it
	// If the DB data is fresher than the file then make a new file
	if(!is_file($filepath))
	{
	    $result = file_put_contents($filepath, $data['foto_identitas']);
	    if($result === FALSE){
	        die(__FILE__.'<br>Error - Line #'.__LINE__.': Could not create '.$filepath);
	    }
	}
// Start
$pdf = new FPDF( 'P', 'mm', array(210,330) );
$pdf-> AliasNbPages();

// Surat Keterangan Hasil Pemeriksaan Narkotika
	$pdf->AddPage();
	$pdf-> SetLeftMargin(15);
	
	// Heading
		$pdf->Image('../img/LogoBNNK.png', 10, 8, 32, 40);
		$pdf->SetFont('Arial','B','25');
		$pdf-> Cell(200, 10, 'BADAN NARKOTIKA NASIONAL',0, 0, 'C');
		$pdf->Ln();
		$pdf-> Cell(200, 10, 'KABUPATEN PURBALINGGA',0, 0, 'C');
		$pdf->Ln();
		$pdf->SetFont('Arial', '', '13');
		$pdf-> Cell(200, 5, 'Jalan Soekarno-Hatta No. 20B Kelurahan Kalikabong - Purbalingga',0,0,'C');
		$pdf->Ln();
		$pdf-> Cell(200, 5, 'Telp : (0281) 896076, 6597091 Fax : (0281) 894330',0,0,'C');
		$pdf->Ln();
		$pdf->SetFont('Arial', '', '12');
		$pdf-> Cell(80, 5, 'email : ',0,0,'C');
		$pdf-> SetFont('Arial', 'I', '12');
		$pdf-> Cell(55, 5, 'bnnkpurbalingga@yahoo.co.id; bnnkab_purbalingga@bnn.go.id',0,0,'C');

		$pdf->SetLineWidth(0);
		$pdf->Line(10,48,200,48);
		$pdf->SetLineWidth(0);
		$pdf->Line(10,49,200,49);

	// Body
		$pdf->Ln(10);
		$pdf->SetFont('Arial', 'BU', '12');
		$pdf-> Cell(180, 5, 'SURAT KETERANGAN HASIL PEMERIKSAAN NARKOTIKA',0,0,'C');
		$pdf-> Ln();
		$pdf->SetFont('Arial', 'B', '12');
		$pdf-> Cell(180, 5, 'Nomor : R/'.$data['no_surat'].'-SKHPN/'.$romawi.'/ka/rh.00/'.$year.'BNNK-PBG' ,0,0,'C');
		$pdf->Ln(8);
	

	$pdf->SetFont('Arial','','12');
	
		$pdf->MultiCell(177.5,5,'Yang bertanda tangan di bawah ini menerangkan bahwa pada hari '. $hari[date('N', strtotime($data['tanggal_periksa']))] .', Tanggal '. tanggalIndo($data['tanggal_periksa']) . ' pukul '.date('H:i', strtotime($data['jam_periksa'])). ' WIB. Bertempat di Klinik Pratama BNNK PURBALINGGA atas permintaan dari '.$upnama.' dengan nomor surat : SKET/'.$data['no_surat'].'/'.$romawi.'/SKHPN/'.$year.' telah dilakukan pemeriksaan terhadap:',0);
		$pdf->Ln(3);

	$start_x=$pdf->GetX(); //initial x (start of column position)
	$current_y = $pdf->GetY();
	$current_x = $pdf->GetX();

		$pdf->MultiCell(60,5,'Nama / Jenis Kelamin',0);
			$current_x+=60;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(5,5,' : ',0);
	    	$current_x+=5;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->SetFont('Arial', 'B', '11.5');
	    $pdf->MultiCell(125,5,$upnama .' / '. $upjenisk,0);
	    	$current_x+=125;     
	    $pdf-> Ln();

	$current_x=$start_x;                       //set x to start_x (beginning of line)
	$current_y+=5; 
	$pdf->SetXY($current_x, $current_y);
	    $pdf->SetFont('Arial','','11.5');
		$pdf->MultiCell(60,5,'Tempat, Tanggal Lahir / Umur',0);
			$current_x+=60;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(5,5,' : ',0);
	    	$current_x+=5;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(125,5,$data['tempat_lahir'] .', '. tanggalIndo($data['tanggal_lahir']) .' / '.$diff.' Tahun.' ,0);
	    	$current_x+=125;     
	    $pdf-> Ln();

	$current_x=$start_x;                       //set x to start_x (beginning of line)
	$current_y+=5; 
	$pdf->SetXY($current_x, $current_y);

	    $pdf->MultiCell(60,5,'Alamat',0);
	    	$current_x+=60;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(5,5,' : ',0);
	   		$current_x+=5;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(110,5,$data['alamat_pemohon'],0);
	    	$current_x+=110;     
	    $pdf-> Ln();

	$current_x=$start_x;                       //set x to start_x (beginning of line)
	$current_y+=10; 
	$pdf->SetXY($current_x, $current_y);

	    $pdf->MultiCell(60,5,'Pekerjaan',0);
		    $current_x+=60;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(5,5,' : ',0);
	    	$current_x+=5;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(110,5,$data['pekerjaan_pemohon'],0);
	    $pdf-> Ln(2);

	    $pdf->Write(5,'A. Hasil Wawancara dan Pemeriksaan Fisik');
	    $pdf->Ln();
	    
	    	$pdf->Cell(5);
		    $pdf->Cell(90,5, '1. Kesadaran',0,0,'L');
		    $pdf->Cell(5,5, ':',0,0,'L');
		    if ($data['hp_kesadaran'] == 'Baik') {
		    	$pdf->Cell(40,5, $data['hp_kesadaran'] . ' / Terganggu' ,0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(127,120.5,147.5,120.5);
		    }elseif ($data['hp_kesadaran'] == 'Terganggu') {
		    	$pdf->Cell(40,5, 'Baik / ' . $data['hp_kesadaran'], 0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(116,120.5,124,120.5);
		    }
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '2. Kesadaran Umum',0,0,'L');
		    $pdf->Cell(5,5, ':',0,0,'L');
		    if ($data['hp_kesadaranumum'] == 'Baik') {
		    	$pdf->Cell(40,5, $data['hp_kesadaranumum'] . ' / Cukup / Kurang' ,0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(126.5,125.5,139.5,125.5);
				$pdf->SetLineWidth(0);
				$pdf->Line(141.5,125.5,156.5,125.5);
		    }elseif ($data['hp_kesadaranumum'] == 'Cukup') {
		    	$pdf->Cell(40,5, 'Baik / ' . $data['hp_kesadaranumum'] . ' / Kurang', 0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(116,125.5,124,125.5);
				$pdf->SetLineWidth(0);
				$pdf->Line(142,125.5,156.5,125.5);
		    }elseif ($data['hp_kesadaranumum'] == 'Kurang') {
		    	$pdf->Cell(40,5, 'Baik  / Cukup / ' . $data['hp_kesadaranumum'] ,0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(116,125.5,124,125.5);
		    	$pdf->SetLineWidth(0);
				$pdf->Line(127.5,125.5,140.5,125.5);
		    }
		    $pdf->Ln();

		    $pdf->Cell(10);
		    $pdf->Cell(85,5, 'Tekanan Darah',0,0,'L');
		    $pdf->Cell(5,5, ':',0,0,'L');
		    $pdf->Cell(40,5, $data['hp_tekanandarah'].' mmHg.' ,0,0,'L');
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '3. Nadi',0,0,'L');
		    $pdf->Cell(5,5, ':',0,0,'L');
		    $pdf->Cell(40,5, $data['hp_nadi']. ' X/Menit.' ,0,0,'L');
		    $pdf->Ln();


	    $pdf->Ln(1);
		$pdf->Write(5,'B. Riwayat Penggunaan Obat-obatan dalam Seminggu Terakhir');
		$pdf->Ln(1);

		$start_x=$pdf->GetX(); //initial x (start of column position)
		$current_y = $pdf->GetY();
		$current_x=$start_x;                       //set x to start_x (beginning of line)
		$current_y+=5;
		$pdf->SetXY($current_x, $current_y);

			$pdf->Cell(5);
		    $pdf->MultiCell(90,5, '1. Penggunaan Obat-obatan dalam Seminggu ini (Bila ada, lanjut ke pertanyaan selanjutnya)',0);
		    $current_x+=95;     
			$pdf->SetXY($current_x, $current_y);

		    $pdf->MultiCell(5,5, ':',0);
		    $current_x+=5;     
			$pdf->SetXY($current_x, $current_y);

		    if ($data['hp_riwayatobat'] == 'Ada') {
		    	$pdf->MultiCell(40,5, $data['hp_riwayatobat'] . ' / Tidak Ada' ,0);
		    	$pdf->SetLineWidth(0);
				$pdf->Line(127,147.5,145.5,147.5);
		    }elseif ($data['hp_riwayatobat'] == 'Tidak ada') {
		    	$pdf->MultiCell(40,5, 'Ada / ' . $data['hp_riwayatobat'], 0);
		    	$pdf->SetLineWidth(0);
				$pdf->Line(115.5,147.5,123.5,147.5);
		    }
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '2. Jenis Obat yang Digunakan',0);
		    $pdf->Cell(5,5, ':',0,0,'L');
		    $pdf->Cell(40,5, $data['hp_jenisobat'] ,0,0,'L');
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '3. Asal Obat',0);
		    $pdf->Cell(5,5, ':',0,0,'L');
		    $pdf->Cell(40,5, $data['hp_asalobat'] ,0,0,'L');
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '4. Terakhir Minum',0);
		    $pdf->Cell(5,5, ':',0,0,'L');
		    $pdf->Cell(40,5, $data['hp_terakhirminum'] ,0,0,'L');
		    $pdf->Ln();


	    $pdf->Ln(1);

	    $pdf->SetLeftMargin(15);
	    $pdf->Write(5,'C. Hasil Tes Urin / Rambut oleh:');
	    $pdf->Ln();

	    	$pdf->Cell(5);
	    	$pdf->Cell(155, 5, 'Pemeriksaan Urin dengan metode : Rapid Test merk :' . $data['hp_merktest'] . ' Parameter 7 (Sesuai yang digunakan)',0,0,'L');
	    	$pdf->Ln();

	    	$pdf->Cell(5);
		    $pdf->Cell(90,5, '1. Amphetamine',0);
		    $pdf->Cell(5,5, ':',0,0,'L');
		    if ($data['hp_amphetamine'] == 'Positif') {
		    	$pdf->Cell(40,5, $data['hp_amphetamine'] . ' / Negatif' ,0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(130,183.5,143.5,183.5);
		    }elseif ($data['hp_amphetamine'] == 'Negatif') {
		    	$pdf->Cell(40,5, 'Positif / ' . $data['hp_amphetamine'], 0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(116,183.5,127,183.5);
		    }
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '2. Methamphetamine',0);
		    $pdf->Cell(5,5, ':',0,0,'L');
		    if ($data['hp_methamphetamine'] == 'Positif') {
		    	$pdf->Cell(40,5, $data['hp_methamphetamine'] . ' / Negatif' ,0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(130,188.5,143.5,188.5);
		    }elseif ($data['hp_methamphetamine'] == 'Negatif') {
		    	$pdf->Cell(40,5, 'Positif / ' . $data['hp_methamphetamine'], 0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(116,188.5,127,188.5);
		    }
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '3. Cocaine',0);
		    $pdf->Cell(5,5, ':',0,0,'L');
		    if ($data['hp_cocaine'] == 'Positif') {
		    	$pdf->Cell(40,5, $data['hp_cocaine'] . ' / Negatif' ,0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(130,193.5,143.5,193.5);
		    }elseif ($data['hp_cocaine'] == 'Negatif') {
		    	$pdf->Cell(40,5, 'Positif / ' . $data['hp_cocaine'], 0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(116,193.5,127,193.5);
		    }
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '4. Opioid',0);
		    $pdf->Cell(5,5, ':',0,0,'L');
		    if ($data['hp_opioid'] == 'Positif') {
		    	$pdf->Cell(40,5, $data['hp_opioid'] . ' / Negatif' ,0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(130,198.5,143.5,198.5);
		    }elseif ($data['hp_opioid'] == 'Negatif') {
		    	$pdf->Cell(40,5, 'Positif / ' . $data['hp_opioid'], 0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(116,198.5,127,198.5);
		    }
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '5. Tetrahydrocannabinol',0);
		    $pdf->Cell(5,5, ':',0,0,'L');
		    if ($data['hp_tetrahydrocannabinol'] == 'Positif') {
		    	$pdf->Cell(40,5, $data['hp_tetrahydrocannabinol'] . ' / Negatif' ,0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(130,203.5,143.5,203.5);
		    }elseif ($data['hp_tetrahydrocannabinol'] == 'Negatif') {
		    	$pdf->Cell(40,5, 'Positif / ' . $data['hp_tetrahydrocannabinol'], 0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(116,203.5,127,203.5);
		    }
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '6. Benzodiazepine',0);
		    $pdf->Cell(5,5, ':',0,0,'L');
		    if ($data['hp_benzodiazepine'] == 'Positif') {
		    	$pdf->Cell(40,5, $data['hp_benzodiazepine'] . ' / Negatif' ,0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(130,208.5,143.5,208.5);
		    }elseif ($data['hp_benzodiazepine'] == 'Negatif') {
		    	$pdf->Cell(40,5, 'Positif / ' . $data['hp_benzodiazepine'], 0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(116,208.5,127,208.5);
		    }
		    $pdf->Ln();

		    $pdf->Cell(5);
		    $pdf->Cell(90,5, '7. K2',0);
		    $pdf->Cell(5,5, ':',0,0,'L');
		    if ($data['hp_k2'] == 'Positif') {
		    	$pdf->Cell(40,5, $data['hp_k2'] . ' / Negatif' ,0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(130,213.5,143.5,213.5);
		    }elseif ($data['hp_k2'] == 'Negatif') {
		    	$pdf->Cell(40,5, 'Positif / ' . $data['hp_k2'], 0,0,'L');
		    	$pdf->SetLineWidth(0);
				$pdf->Line(116,213.5,127,213.5);
		    }
		    $pdf->Ln();

		$pdf->Write(5,'Dapat Disimpulkan bahwa yang terperiksa tersebut diatas ');
		$pdf->SetFont('Arial', 'B', '11.5');
		if ($data['hp_indikasi'] == 'Terindikasi') {
			$pdf->Write(5, $data['hp_indikasi'] . ' / Tidak Terindikasi');
			$pdf->SetLineWidth(0);
			$pdf->Line(146,218.5,179,218.5);
		}elseif ($data['hp_indikasi'] == 'Tidak Terindikasi') {
			$pdf->Write(5, 'Terindikasi / ' . $data['hp_indikasi']);
			$pdf->SetLineWidth(0);
			$pdf->Line(121,218.5,143,218.5);
		}
		
		$pdf->SetFont('Arial', '', '11.5');
		$pdf->Write(5, ' mengkonsumsi Narkotika.' );
		$pdf->Ln();

		$pdf->Write(5,'Hasil pemeriksaan tes urin narkotika ');
		$pdf->SetFont('Arial', 'B', '11.5');
		$pdf->Write(5, 'hanya berlaku');
		$pdf->SetFont('Arial', '', '11.5');
		$pdf->Write(5, ' saat dilakukan pemeriksaan urin. Demikian Surat Hasil Keterangan Pemeriksaan Narkotika ini dibuat guna untuk '.$data['keperluan'].'.' );
		$pdf->Ln(8);

		$pdf->Cell(175,0, 'Purbalingga, '. tanggalIndo($data['tanggal_periksa']) , 0, 0, 'R' );
		$pdf->Ln(3);
		$pdf->Cell(100,5,'Petugas Pemeriksa Urin',0,0,'C');
	    $pdf->Cell(75,5,'Dokter Pemeriksa',0,0,'C');
	    $pdf->Ln(15);

	    $pdf->SetFont('Arial','BU','11.5');
	    $pdf->Cell(100,5,$data['petugas_pemeriksa'] ,0,0,'C');
	    $pdf->Cell(75,5,$data['dokter_pemeriksa'] ,0,0,'C');
	    $pdf->Ln();
	    $pdf->SetFont('Arial','','11.5');

	    if ($data['petugas_pemeriksa']=="Laela Agustin Kurniasih, AMK.") {
	    	$pdf->Cell(100,5,'SIP : 503/DPMPTSP/04/SIPP/024/I/2019',0,0,'C');
	    }

	    if ($data['dokter_pemeriksa']=="dr. Esa Dhiandani.") {
	    	$pdf->Cell(75,5,'SIP :3303.53371/DU/03/449.1/I/003/2019');
	    }

	    $pdf->Ln(5);
	    $pdf->Cell(180,5,'Mengetahui,',0,0,'C');
	    $pdf->Ln(5);
	    if ($data['penanggung_jawab']=="Bu Kasi") {
	    	$pdf->Cell(180,5,'a.n Kepala Seksi Rehabilitasi',0,0,'C');
	    } elseif($data['penanggung_jawab']=="Sudirman, S.Ag., M.Si"){
	    	$pdf->Cell(180,5,'a.n Kepala Badan Narkotika Nasional',0,0,'C');
	    }
	    $pdf->Ln(5);
	    $pdf->Cell(180,5,'Kabupaten Purbalingga',0,0,'C');
	    $pdf->Ln(15);

	    $pdf->SetFont('Arial','BU','11.5');
	    $pdf->Cell(180,5,$data['penanggung_jawab'],0,0,'C');
	    $pdf->Ln();
	    $pdf->SetFont('Arial','','11.5');
	    if ($data['penanggung_jawab']=="Bu Kasi") {
	    	$pdf->Cell(180,5,'NIP. 19639291 3883 2 001',0,0,'C');
	    } elseif($data['penanggung_jawab']=="Sudirman, S.Ag., M.Si"){
	    	$pdf->Cell(180,5,'NIP. 19710208 200501 1 001',0,0,'C');
	    }



// Ends of First Page (Surat Keterangan Hasil Pemeriksaan Narkotika)


// Surat Permohonan SKHPN
	
	$pdf-> AddPage();
	$pdf-> SetTopMargin(20);
	
	// Heading
		$pdf-> SetFont('Arial', 'BU', 15);
		$pdf-> Cell(0, 15, 'PERMOHONAN SURAT KETERANGAN HASIL PEMERIKSAAN NARKOTIKA',0, 0, 'C');
		$pdf-> Ln(0.5);
		$pdf-> SetFont('Arial', 'B', 12);
		$pdf-> Ln();
		$pdf-> Cell(0,0, 'SPM/'. $data['no_surat'] . '/'. $romawi .'/SKHPN/'. $year,0 ,0,'C');
		$pdf-> Ln(15);
		
	
	// Body
		$pdf-> SetFont('Arial', '', 12);
		$pdf-> Write(6, 'Saya yang bertanda tangan di bawah ini :');
		$pdf-> Ln(15);

	$start_x=$pdf->GetX(); //initial x (start of column position)
	$current_y = $pdf->GetY();
	$current_x = $pdf->GetX();

		$pdf->SetFont('Arial','',12);
	    $pdf->MultiCell(50,5,'Nama',0);
	    	$current_x+=50;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(10,5,' : ',0);
	    	$current_x+=10;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(120,5,$data['nama_pemohon'],0);
	    	$current_x+=120;     
	    $pdf-> Ln();

	$current_x=$start_x;                       //set x to start_x (beginning of line)
	$current_y+=5; 
	$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(50,5,'Tempat, Tanggal Lahir',0);
	    	$current_x+=50;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(10,5,' : ',0);
	    	$current_x+=10;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(120,5, $data['tempat_lahir'] . ', ' . tanggalIndo($data['tanggal_lahir']) ,0);
	    	$current_x+=120;     
	    $pdf-> Ln();

	$current_x=$start_x;                       //set x to start_x (beginning of line)
	$current_y+=5; 
	$pdf->SetXY($current_x, $current_y);   

	    $pdf->MultiCell(50,5,'Alamat',0);
		    $current_x+=50;     
			$pdf->SetXY($current_x, $current_y);

	    $pdf->MultiCell(10,5,' : ',0);
		    $current_x+=10;     
			$pdf->SetXY($current_x, $current_y);

	    $pdf->MultiCell(120,5,$data['alamat_pemohon'] ,0);
	   		$current_x+=120;     
	    $pdf-> Ln();

	$current_x=$start_x;                       //set x to start_x (beginning of line)
	$current_y+=10; 
	$pdf->SetXY($current_x, $current_y);

	    $pdf->MultiCell(50,5,'Pekerjaan',0);
	    	$current_x+=50;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(10,5,' : ');
	    	$current_x+=10;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(120,5,$data['pekerjaan_pemohon'] ,0);
	    	$current_x+=120;     
	    $pdf-> Ln();

	$current_x=$start_x;                       //set x to start_x (beginning of line)
	$current_y+=5; 
	$pdf->SetXY($current_x, $current_y);

	    $pdf->MultiCell(50,5,'Kartu Identitas',0);
	    	$current_x+=50;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(10,5,' : ',0);
	    	$current_x+=10;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(120,5,$data['jenis_identitas'],0);
	    	$current_x+=120;     
	    $pdf-> Ln();

	$current_x=$start_x;                       //set x to start_x (beginning of line)
	$current_y+=5; 
	$pdf->SetXY($current_x, $current_y);

	    $pdf->MultiCell(50,5,'Nomor Identitas',0);
	    	$current_x+=50;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(10,5,' : ',0);
	    	$current_x+=10;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(120,5,$data['no_identitas'],0);
	    $pdf-> Ln();

	$current_x=$start_x;                       //set x to start_x (beginning of line)
	$current_y+=5; 
	$pdf->SetXY($current_x, $current_y);

	    $pdf->MultiCell(50,5,'Nomor Telepon',0);
	    	$current_x+=50;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(10,5,' : ',0);
	    	$current_x+=10;     
			$pdf->SetXY($current_x, $current_y);
	    $pdf->MultiCell(120,5,$data['no_hp'],0);
	    $pdf-> Ln(15);

	// Closing
		$pdf-> Write(6, 'Bersama ini bermaksud untuk ');
		$pdf-> SetFont('Arial','B',12);
		$pdf-> Write(6, 'Surat Keterangan Hasil Pemeriksaan Narkotika ');
		$pdf-> SetFont('Arial','',12);
		$pdf-> Write(6, '(SKHPN) yang akan digunakan untuk ' .$data['keperluan']. '.' );
		$pdf-> Ln();
		$pdf-> SetFont('Arial','',12);
		$pdf-> Write(6, 'Demikian surat permohonan saya buat. Atas perhatiannya diucapkan terima kasih.');

	// TTD
		$pdf->Ln(40);
		$pdf->Cell(175,0, 'Purbalingga, '. tanggalIndo($data['tanggal_permohonan']) , 0, 0, 'R' );
		$pdf->Ln(5);
		$pdf->Cell(165, 0, 'Hormat Saya,', 0, 0, 'R' );
		$pdf-> Ln(30);
		$pdf->Cell(140);
		$pdf->Cell(20, 0, '('.$data['nama_pemohon'] .')', 0, 0, 'C' );

// Ends of Second Page (Permohonan SKHPN)

// Surat Persetujuan Pengambilan Urine

	$pdf-> AddPage();
	// Heading
		$pdf->Image('../img/LogoBNNK.png', 10, 10, 32, 40);
		$pdf->SetFont('Arial', 'B', '14');
		$pdf-> Ln(5);
		$pdf->Cell(0,0,'KLINIK PRATAMA BNNK PURBALINGGA',0,0,'C');
		$pdf->Ln(5);
		$pdf->SetFont('Arial', '', '12');
		$pdf->Cell(0,0, 'Jalan Soekarno - Hatta No. 20-B', 0, 0, 'C');
		$pdf->Ln(5);
		$pdf->Cell(0,0, 'Kelurahan Kalikabong, Purbalingga', 0, 0, 'C');
		$pdf-> Ln(20);
		$pdf->SetLineWidth(0);
		$pdf->Line(10,49,200,49);
		$pdf->SetLineWidth(0);
		$pdf->Line(10,50,200,50);
		$pdf->Ln();

	// Body
		$pdf->SetFont('Arial', 'B', '12');
		$pdf->Cell(0,0,'SURAT PERNYATAAN', 0, 0, 'C');
		$pdf->Ln(15);
		$pdf->SetFont('Arial', '', '12');
		$pdf->Write(6, 'Saya yang bertanda tangan di bawah ini :');
		$pdf->Ln();

		$pdf->Cell(50,10,'Nama',0,0,'L');
	    $pdf->Cell(10,10,' : ',0,0,'C');
	    $pdf->Cell(130,10,$data['nama_pemohon'],0,0,'L');
	    $pdf-> Ln();

	    $pdf->Cell(50,10,'Umur',0,0,'L');
	    $pdf->Cell(10,10,' : ',0,0,'C');
	    $pdf->Cell(130,10,$diff,0,0,'L');
	    $pdf-> Ln();

	    $pdf->Cell(50,10,'Jenis Kelamin',0,0,'L');
	    $pdf->Cell(10,10,' : ',0,0,'C');
	    $pdf->Cell(130,10,$data['jenis_kelamin'],0,0,'L');
	    $pdf-> Ln();
		
		$pdf->Cell(50,10,'Alamat',0,0,'L');
	    $pdf->Cell(10,10,' : ',0,0,'C');
	    $pdf->MultiCell(110,10,$data['alamat_pemohon'],0);
	    $pdf-> Ln(15);
		
	// Closing
	    $pdf->MultiCell(180, 6,'Menyatakan bahwa dalam pelaksanaan asesmen medis yang dilaksanakan di Klinik Pratama BNNK Purbalingga tidak dipungut biaya.',0);
	    $pdf->MultiCell(180, 6,'Demikian surat pernyataan ini dibuat sebenar - benarnya, apabila terjadi pungutan biaya bukan merupakan tanggung jawab Seksi Rehabilitasi BNNK Purbalingga sebagai pelaksana',0);
	    $pdf-> Ln(20);

	// TTD
	    $pdf->Cell(100,0,'Jam : '. date('H:i', strtotime($data['jam_permohonan'])) . ' WIB', 0, 0, 'L' );
	    $pdf->Cell(75,0,'Purbalingga, '. tanggalIndo($data['tanggal_permohonan']), 0, 0, 'C' );
	    $pdf->Ln(8);

	    $pdf->Cell(100,0,'Nama Jelas dan Tanda Tangan',0,0,'C');
	    $pdf->Cell(75,0,'Nama Jelas dan Tanda Tangan',0,0,'C');
	    $pdf->Ln(5);
	    $pdf->Cell(100,0,'Saksi',0,0,'C');
	    $pdf->Cell(75,0,'Pemohon',0,0,'C');
	    $pdf-> Ln(30);

	    $pdf->Cell(100,0,'(.................................)',0,0,'C');
	    $pdf->Cell(75,0,'(' .$data['nama_pemohon'].')' ,0,0,'C');
	    $pdf->Ln(15);

	    $pdf->Cell(180,0,'Nama Jelas dan Tanda Tangan',0,0,'C');
	    $pdf->Ln(5);
	    $pdf->Cell(180,0,'Petugas',0,0,'C');
	    $pdf->Ln(30);
	    $pdf->Cell(180,0,'(.................................)',0,0,'C');

// Ends of Third Page (Pernyataan)


// Surat Persetujuan Pengambilan Urine
	// Heading
	    $pdf->AddPage();
	    $pdf->SetFont('Arial', 'B', '14');
	    $pdf->Cell(0,0,'SURAT PERSETUJUAN PENGAMBILAN URINE',0,0,'C');
	    $pdf->Ln(20);

	// Body
	    $pdf->SetFont('Arial', '', '12');
	    $pdf->Write(6, 'Saya yang bertanda tangan di bawah ini :');
	    $pdf-> Ln();

	    $pdf->Cell(50,10,'Nama',0,0,'L');
	    $pdf->Cell(10,10,' : ',0,0,'C');
	    $pdf->Cell(130,10,$data['nama_pemohon'],0,0,'L');
	    $pdf-> Ln();

	    $pdf->Cell(50,10,'Umur',0,0,'L');
	    $pdf->Cell(10,10,' : ',0,0,'C');
	    $pdf->Cell(130,10,$diff,0,0,'L');
	    $pdf-> Ln();

	    $pdf->Cell(50,10,'Jenis Kelamin',0,0,'L');
	    $pdf->Cell(10,10,' : ',0,0,'C');
	    $pdf->Cell(130,10,$data['jenis_kelamin'],0,0,'L');
	    $pdf-> Ln();

	    $pdf->Cell(50,10,'Alamat',0,0,'L');
	    $pdf->Cell(10,10,' : ',0,0,'C');
	    $pdf->MultiCell(110,10,$data['alamat_pemohon'],0);
	    $pdf-> Ln(15);

	// Closing
	    $pdf->MultiCell(180,6, 'Menyatakan bahwa dengan sesungguhnya memberikan persetujuan kepada Klinik Pratama BNNK Purbalingga untuk melakukan tindakan pengambilan urine tanpa menuntut kepada pihak Klinik Pratama BNNK Purbalingga atau dokter atau paramedis atau petugas yang bersangkutan apabila terjadi akibat yang timbul dari tindakan tersebut',0);
	    $pdf->Ln(30);

	   	$pdf->Cell(100,0,'Jam : '. date('H:i', strtotime($data['jam_permohonan'])) . ' WIB' , 0, 0, 'L' );
	    $pdf->Cell(75,0,'Purbalingga, '. tanggalIndo($data['tanggal_permohonan']), 0, 0, 'C' );
	    $pdf->Ln(8);

	    $pdf->Cell(100,0,'Nama Jelas dan Tanda Tangan',0,0,'C');
	    $pdf->Cell(75,0,'Nama Jelas dan Tanda Tangan',0,0,'C');
	    $pdf->Ln(5);
	    $pdf->Cell(100,0,'Saksi',0,0,'C');
	    $pdf->Cell(75,0,'Pemohon',0,0,'C');
	    $pdf-> Ln(30);

	    $pdf->Cell(100,0,'(.................................)',0,0,'C');
	    $pdf->Cell(75,0,'(' .$data['nama_pemohon'].')' ,0,0,'C');
	    $pdf->Ln(15);

// Ends of Fourth Page (Surat Persetujuan Pengambilan Urine)

// Foto Identitas Diri
	    $pdf->AddPage();
		$pdf->Image($filepath, 60,100,90,50);

// Ends of 5th Page (Identitas Diri)

$pdf-> Output();
?>
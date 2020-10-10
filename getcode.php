<?php
ob_start();
	include './config/conn.php';
	include './config/phpqrcode/qrlib.php';
?>

<!DOCTYPE html>
<html>

<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/form-style.css">
	<link rel="stylesheet" type="text/css" href="./css/skhpn.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
	<div class="holder">
		<!-- Navigation Bar -->
		<header>
			<img src="./img/Logo_BNN.png" class="logo">
			<nav class="stroke">
				<ul>
					<li><a href="timeline.html">Alur Pengajuan</a></li>
					<li><a href="index.php">Pendaftaran Online</a></li>
				</ul>
			</nav>
		</header>

		<!-- Container -->
		<div class="container">
			<h1>Pengajuan SKHPN</h1>
			<br>
			<center><legend>QR Code Anda</legend></center>

			<br>

			<?php 
				function checkKeys($con, $randStr){
					$sql= "SELECT * FROM tb_pemohon";
					$result= mysqli_query($con, $sql);

					while ($row=mysqli_fetch_assoc($result)) {
						if ($row['unique_code'] == $randStr) {
							$keyExists= true;
							break;
						}else{
							$keyExists= false;
						}
					}

					return $keyExists;
				}

				function generateKey($con){
					$keyLength= 8;
					$str= "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ$";
					$randStr= substr(str_shuffle($str), 0, $keyLength);

					$checkKeys= checkKeys($con, $randStr);

					while ($checkKeys==true) {
						$randStr= substr(str_shuffle($str), 0, $keyLength);
						checkKeys($con, $randStr);
					}

					return $randStr;
				}
					
				if (isset($_POST['submit'])) {
					$captcha = $_POST['g-recaptcha-response'];
					date_default_timezone_set('Asia/Jakarta');
					$date= date('Y-m-d');
					$time= date('H:i:s');
					$nama= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['nama'])));
					$jenis_identitas= mysqli_real_escape_string($con, $_POST['jenis_identitas']);
					$no_identitas= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['no_identitas'])));
					$jenis_kelamin= mysqli_real_escape_string($con, $_POST['jenis_kelamin']);
					$tempat_lahir= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['tempat_lahir'])));
					$tanggal_lahir= mysqli_real_escape_string($con, $_POST['tanggal_lahir']);
					$alamat= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['alamat'])));
					$pekerjaan= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['pekerjaan'])));
					$no_hp= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['no_hp'])));
					$keperluan= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['keperluan'])));
					$status_permohonan= mysqli_real_escape_string($con, $_POST['status_permohonan']);
					$foto_id= mysqli_real_escape_string($con, $_FILES['foto_id']['name']);
					move_uploaded_file($_FILES['foto_id']['tmp_name'], "./admin/img/uploads/". $foto_id);

					if (!$captcha) {
					  	echo "<script> alert('Anda Belum Mengecek ReCaptcha') </script>";
					} else {
					  $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeqguYUAAAAACpSNHelYA2AnYVpT9jio-TX0dlK&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
						if ($response == true )  {
							$key= generateKey($con);
							$query= mysqli_query($con, "INSERT INTO tb_pemohon (unique_code, tanggal_permohonan, jam_permohonan, nama_pemohon, jenis_identitas, no_identitas, jenis_kelamin, tempat_lahir, tanggal_lahir, alamat_pemohon, pekerjaan_pemohon, no_hp, keperluan, status_permohonan, foto_identitas) VALUES ('$key' , '$date', '$time', '$nama',  '$jenis_identitas','$no_identitas', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$pekerjaan', '$no_hp', '$keperluan', '$status_permohonan', '$foto_id')");
							
							$sql= mysqli_query($con, "INSERT INTO tb_hasilpemeriksaan (id_pemohon) SELECT id_pemohon FROM tb_pemohon where id_pemohon= LAST_INSERT_ID()");	
						    
							$que= mysqli_query($con, "SELECT * FROM tb_pemohon where id_pemohon = LAST_INSERT_ID()");

							$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;

							$PNG_WEB_DIR = 'temp/';

							if (!file_exists($PNG_TEMP_DIR))
							    mkdir($PNG_TEMP_DIR);


						   	$filename = $PNG_TEMP_DIR.'label.png';


						   	while ($row = mysqli_fetch_assoc($que)){
						   		$filename = $PNG_TEMP_DIR.'label'.$row['unique_code'].'.png';

						       	QRcode::png($row['unique_code'], $filename, QR_ECLEVEL_H, 8);  
								?>
							    <center>
							    	<p> <?php echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" />';}?></p>
							    </center>
						<?php
							
							if(!$query){
						    	echo "<script>alert('Failed!');</script>";
						    }
				    	}
				   	}
				}
			?>

			<br>

			<center><a href="index.php"><button class="btn-submit">Kembali ke Form</button></a></center>

		</div>
	</div>
</body>
</html>

<?php 
	include './config/conn.php';
	include './config/phpqrcode/qrlib.php';
?>

<!DOCTYPE html>
<html>

<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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

		<!-- Form Starter -->
  <form class="form-style" method="POST" action="getcode.php" enctype="multipart/form-data">
    <fieldset>
    <center><legend>Masukkan Identitas Anda </legend></center>

    <input type="hidden" name="date">
    <input type="hidden" name="time">
    <input type="hidden" name="status_permohonan" value="1">
    
    
	<div class="input">
		<label>Nama:</label>
			<input class="effect" type="text" id="nama" name="nama" placeholder="Masukkan Nama Lengkap Anda" pattern="[a-zA-z].{4,}" title="Anda Perlu Memasukkan Nama Lengkap Anda (Minimal 5 Karakter)" required>
		<span class="focus-border"></span>
	</div>
    	
   	
		<div class="input">
			<label>Jenis Identitas:</label><br>
   			<label for="ktp" class="radio_btn">
			<input type="radio" name="jenis_identitas" id="ktp" class="radio_btn-input" value="KTP" required>
			<div class="radio_btn-circle"></div>KTP
 		</label>

 		<label for="sim" class="radio_btn">
			<input type="radio" name="jenis_identitas" class="radio_btn-input" value="SIM" id="sim">
			<div class="radio_btn-circle"></div>SIM
		</label>
		</div>

	<div class="input">
		<label>Nomor Identitas:</label>
		<input type="text" class="effect" id="no_identitas" name="no_identitas" placeholder="Masukkan Nomor Identitas Anda" pattern="[0-9].{11,15}" title="Anda Perlu Memasukkan Nomor Identitas yang Valid" required>
		<span class="focus-border"></span>
	</div>
		
	<div class="input">
		<label>Jenis Kelamin:</label><br>
		<label for="perempuan" class="radio_btn">
			<input type="radio" name="jenis_kelamin" id="perempuan" class="radio_btn-input" value="Perempuan" required>
			<div class="radio_btn-circle"></div>
			Perempuan
		</label>
		<label for="laki" class="radio_btn">
			<input type="radio" name="jenis_kelamin" class="radio_btn-input" value="Laki-laki" id="laki">
			<div class="radio_btn-circle"></div>
			Laki-laki
		</label>
	</div>

	<label>Tempat, Tanggal Lahir:</label>
		<div class="input">
			<input type="text" class="effect" name="tempat_lahir" placeholder="Masukkan Tempat Lahir Anda" pattern="[a-zA-z].{3,}" title="Anda Perlu Memasukkan Tempat Lahir Anda (Minimal 3 Karakter)" required> 
		   	<span class="focus-border"></span>
		</div>
	   	<div class="input">
	   		<input type="date" class="effect" name="tanggal_lahir" placeholder="Masukkan Tanggal Lahir Anda" title="Anda Perlu Memasukkan Tanggal Lahir Anda" required>
	   		<span class="focus-border"></span>
	   	</div>

	<div class="input">
		<label>Alamat:</label>
    		<input type="text" class="effect" name="alamat" placeholder="Masukkan Alamat Lengkap Anda" pattern="[a-zA-z0-9].{2,}" title="Anda Perlu Memasukkan Alamat Anda (Minimal 3 Karakter)" required>
    		<span class="focus-border"></span>
	</div>

	<div class="input">
		<label>Pekerjaan:</label>
    		<input type="text" class="effect" name="pekerjaan" placeholder="Masukkan Pekerjaan Anda" pattern="[a-zA-z0-9].{2,}" title="Anda Perlu Memasukkan Pekerjaan Anda (Minimal 3 Karakter)" required>
    		<span class="focus-border"></span>
	</div>

    <div class="input">
    	<label>Nomor HP:</label>
			<input type="text" class="effect" name="no_hp" placeholder="Masukkan Nomor Anda yang Dapat Dihubungi" pattern="[0].{1}[0-9].{9,12}" title="Anda Perlu Memasukkan Nomor yang Sesuai (Minimal 10 Angka)" required>
			<span class="focus-border"></span>
    </div>

    
    <div class="input">
    	<label>Keperluan Membuat SKHPN:</label>
    		<input type="text" class="effect" name="keperluan" placeholder="Masukkan Keperluan Anda" pattern="[a-zA-z0-9].{2,}" title="Anda Perlu Memasukkan Keperluan Anda (Minimal 3 Karakter)" required>
    		<span class="focus-border"></span>

    </div>
    
	<div class="input">
		<label>Upload Foto Scan Identitas (JPG/PNG)</label><br>	
			<input type="file" class="effect" name="foto_id" accept="image/x-png,image/jpeg,image/jpg" title="Anda Perlu Memasukkan File Foto/Scan Identitas Anda (JPG/PNG)" required>
	</div>
	
	<div class="input">
		<label>Klik untuk Membuktikan Anda bukan Robot</label><br><br>
			<div class="g-recaptcha" data-sitekey="6LeqguYUAAAAAKFQ_y4J4d1eIJcgtUQHQB0_KF2v"></div>
	</div>

    <div class="input">
    	<input type="checkbox" required><span id="checklist"> Identitas yang Tertera Tersebut adalah Benar</span> <br>
    	<input type="checkbox" required><span id="checklist"> Saya Memberikan Persetujuan kepada Pihak BNN Purbalingga untuk Pengambilan Urin</span> <br>
    </div>
    
    <div class="input">
    	<input type="submit" id="submit" name="submit" value="Ajukan"/>
    </div>
    
  </form>
</div>
	

<script>
  	window.onload = function() {
    var $recaptcha = document.querySelector('#g-recaptcha-response');
	    if($recaptcha) {
	        $recaptcha.setAttribute("required", "required");
	    }
	};
</script>
</body>
</html>

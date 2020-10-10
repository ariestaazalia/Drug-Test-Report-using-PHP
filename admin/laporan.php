<?php
ob_start();
	include '../config/conn.php';
	session_start();
	if (!$_SESSION['login']) {
		echo "<script> alert('Anda Belum Login, Silahkan Login') </script>";
    echo "<script> window.location.href='login.php' </script>";
	}
	
	if ($_SESSION['status']!=1) {
	    echo "<script> alert('Anda Tidak Memiliki Hak Akses') </script>";
	    echo "<script> window.location.href='index.php' </script>";
	}
	
	$query= mysqli_query($con, "SELECT COUNT(status_permohonan) as stat , YEAR(tanggal_periksa) as year FROM tb_pemohon JOIN tb_hasilpemeriksaan on tb_pemohon.id_pemohon = tb_hasilpemeriksaan.id_pemohon WHERE status_permohonan='2' GROUP BY YEAR(tanggal_periksa)");
	$data= mysqli_num_rows($query);
	
?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="./css/tablesort.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/table-style.css">
    <link rel="stylesheet" href="./css/button-style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

  </head>

  <body>
    <section class="sidemenu">
      <nav>
        <img src="../img/Logo_BNN.png"> <br> <br>
        <a href="index.php"><i class="fa fa-home"></i> Beranda</a>
        <a href="user-profile.php"><i class="fa fa-user"></i> Profil</a>
        <a href="skhpn.php"><i class="fa fa-sticky-note"></i> SKHPN</a>
        <a href="laporan.php" class="active"><i class="fa fa-file" aria-hidden="true"></i> Laporan</a>
        <a href="signout.php"><i class="fa fa-sign-out"></i> Keluar</a>
      </nav>
    </section>

    <header>
      <div class="search-area">
          
      </div> 
      <div class="date">
        <p id="datetime"></p>
      </div>
    </header>

    <section class="content-area">
      <div class="heading">
        <h1>Laporan Penerbitan SKHPN</h1>
        <p>Laporan Penerbitan SKHPN per Tahun</p>
        <a href="generatereport.php"><button class="btn btn-print">Cetak</button></a>
      </div>

      <div style="overflow-x: auto;">
        <table id="table-id">
        <thead>
          <th>No.</th>
          <th>Tahun</th>
          <th>Jumlah SKHPN yang Diterbitkan</th>
        </thead>

        <tbody>
          <!-- Numbering -->
          <?php if ($data>0) {
            $dat= mysqli_fetch_assoc($query);
            $num=0; do{
            $num++;?>
          <tr>
            <td><?= $num; ?></td>
            <td><?= $dat['year']; ?></td>
            <td><?= $dat['stat']; ?></td>
          </tr>
          <?php } while($dat= mysqli_fetch_assoc($query)); } ?>
        </tbody>
      </table>
      </div>
      
  </section>

  <div class="footer">
      <p>
        Copyright &copy; <?= date('Y') ?> by Ariesta Salwa Azalia
      </p>
    </div>

  <script src="./js/datetime.js"></script>
  <script src='./js/tablesort.min.js'></script>
  <script src='./js/tablesort.number.js'></script>
  <script src='./js/tablesort.date.js'></script>
  <script>
    new Tablesort(document.getElementById('table-id'));
  </script>
</body>
</html>

          
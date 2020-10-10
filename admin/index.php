<?php 
ob_start();
  include '../config/conn.php';
  session_start();
    if (!$_SESSION['login']) {
      echo "<script> alert('Anda Belum Login, Silahkan Login') </script>";
      echo "<script> window.location.href='login.php' </script>";
    }

$query=mysqli_query($con, "SELECT * FROM tb_user ");
$data=mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="./css/tablesort.css">
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

  </head>

  <body>
    <section class="sidemenu">
      <nav>
        <img src="../img/Logo_BNN.png"> <br> <br>
        <a href="index.php" class="active"><i class="fa fa-home"></i> Beranda</a>
        <a href="user-profile.php"><i class="fa fa-user"></i> Profil</a>
        <a href="skhpn.php"><i class="fa fa-sticky-note"></i> SKHPN</a>
        <?php if ($_SESSION['status']==1){ ?>
            <a href="laporan.php"><i class="fa fa-file" aria-hidden="true"></i> Laporan</a>
        <?php }
        ?>
        <a href="signout.php"><i class="fa fa-sign-out"></i> Keluar</a>
      </nav>
    </section>

    <header>
      <div class="navbar">
        <h1>Selamat Datang!</h1>
      </div>
      <div class="date">
        <p id="datetime"></p>
      </div>
    </header>

    <section class="content-area">
      <div class="heading">
        <h1>Beranda</h1>
        <p>Selamat Datang di Sistem Informasi Penerbitan Surat Keterangan Hasil Permeriksaan Narkotika (SKHPN) Badan Narkotika Nasional Kabupaten Purbalingga</p>
      </div>

      
      <div class="cards">
        <a href="user-profile.php">
        <div class="card">
          <p> Anda Login Sebagai: </p>
          <span class="user-name"> <?= $_SESSION['username']; ?></span>
          <hr>
          <div class="user-img"></div>
        </div>
      </a>

      <a href="skhpn.php">
        <div class="card">
          <p>Jumlah Pengajuan SKHPN: </p>
          <br>
          <hr>
          <div class="task-img">
            <?php 
              $total=mysqli_query($con, "SELECT COUNT(status_permohonan) FROM tb_pemohon");
              $dat= mysqli_fetch_assoc($total);
            ?>
            <span class="total"><?= $dat['COUNT(status_permohonan)']; ?></span>
          </div>
        </div>
      </a>
      </div>
    </section>

    <div class="footer">
      <p>
        Copyright &copy; <?= date('Y') ?> by Ariesta Salwa Azalia
      </p>
    </div>

    <script src="./js/datetime.js"></script>

  </body>

</html>

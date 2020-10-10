<?php 
ob_start();
  include '../config/conn.php';
  session_start();
    if (!$_SESSION['login']) {
      echo "<script> alert('Anda Belum Login, Silahkan Login') </script>";
      echo "<script> window.location.href='login.php' </script>";
    }
    
if(isset($_POST['submit'])){
          $search = $_POST['search'];
          $query = mysqli_query($con, "SELECT * FROM tb_pemohon JOIN tb_hasilpemeriksaan on tb_pemohon.id_pemohon = tb_hasilpemeriksaan.id_pemohon where 
                    unique_code like '%$search%' OR
                    nama_pemohon like '%$search%' OR 
                    tanggal_permohonan like '%$search%' ORDER BY tb_pemohon.id_pemohon DESC");
          $data= mysqli_num_rows($query);
        }else {
          $query=  mysqli_query($con, "SELECT tb_pemohon.*, tb_hasilpemeriksaan.* FROM tb_pemohon JOIN tb_hasilpemeriksaan on tb_pemohon.id_pemohon = tb_hasilpemeriksaan.id_pemohon ORDER BY tb_pemohon.id_pemohon DESC"); 
          $data= mysqli_num_rows($query);
        }
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
        <a href="skhpn.php" class="active"><i class="fa fa-sticky-note"></i> SKHPN</a>
        <?php if($_SESSION['status']==1){ ?>
            <a href="laporan.php"><i class="fa fa-file" aria-hidden="true"></i> Laporan</a>
        <?php } ?>
        <a href="signout.php"><i class="fa fa-sign-out"></i> Keluar</a>
      </nav>
    </section>

    <header>
      <div class="search-area">
        <form method="post">
          <input type="text" name="search" placeholder="Cari Disini..."><button type="submit" name="submit" id="submit"></button>
        </form>
          
      </div> 
      <div class="date">
        <p id="datetime"></p>
      </div>
    </header>

    <section class="content-area">
      <div class="heading">
        <h1>Pengelolaan SKHPN</h1>
        <p>Selamat Datang di Pengelolaan SKHPN</p>
      </div>
      
      <div style="overflow-x: auto;">
              <table id="table-id">
      <thead>
        <th>No.</th>
        <th>Kode Unik</th>
        <th>Tanggal Pengajuan</th>
        <th>Nama</th>
        <th>Status</th>
        <th colspan="3">Aksi</th>
      </thead>

      <tbody>
      <!-- Numbering -->
      <?php 
      if ($data > 0){
        $row=mysqli_fetch_assoc($query);
          $num=0; do{
          $num++;?>
            <tr>
              <td><?= $num; ?>.</td>
              <td><?= $row['unique_code'];?></td>
              <td><?= date('d-m-Y', strtotime($row['tanggal_permohonan'])) ; ?></td>
              <td style="word-break:break-all; width: 28%;"><?= $row['nama_pemohon']; ?></td>
             
              <!-- Status Permohonan (1: Waiting, 2: Finished) -->
              <td>
                <?php 
                  if ($row['status_permohonan']=='1') {?>
                     <p class="tx tx-wait">Waiting...</p>
                <?php }else if ($row['status_permohonan']=='2') {?>
                     <p class="tx tx-fin">Finished</p>
                <?php } ?>   
              </td>

          <!-- Edit -->
            <?php if ($row['status_permohonan']==2) { ?>
              <td><a href="edit-skhpn.php?id=<?= $row['id_pemohon']; ?>"><button class="btn btn-edit"><i class="fa fa-edit"></i></button></a></td>
            <?php }elseif ($row['status_permohonan']==1) { ?>
              <td colspan="2" style="width: 10%"><a href="edit-skhpn.php?id=<?= $row['id_pemohon']; ?>"><button class="btn btn-edit"><i class="fa fa-edit"></i></button></a></td>
            <?php } ?>
              
          <!-- Print -->
            <?php if ($row['status_permohonan']==2) { ?>
              <td><a href="print-skhpn.php?id=<?= $row['id_pemohon']; ?>"><button class="btn btn-print"><i class="fa fa-print" aria-hidden="true"></i></button></a></td>
            <?php } ?>
              
          <!-- Delete -->
            <?php if ($row['status_permohonan']==2) { ?>
              <td><a onclick='javascript:confirmationDelete($(this));return false;' href="delete-skhpn.php?id=<?=$row['id_pemohon'];?>" class="delete"><button class="btn btn-delete"><i class="fa fa-trash"></i></button></a></td>
            <?php } elseif ($row['status_permohonan']==1) { ?>
              <td colspan="2" style="width: 10%"><a onclick='javascript:confirmationDelete($(this));return false;' href="delete-skhpn.php?id=<?=$row['id_pemohon'];?>" class="delete"><button class="btn btn-delete"><i class="fa fa-trash"></i></button></a></td>
            <?php } ?>
              

            </tr>
        <?php } while ($row=mysqli_fetch_assoc($query));}
       elseif(empty($data)){
        echo "Tidak Ada Data yang Ditemukan";
       }?>
       <!-- End of Numbering -->
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
    <script src="./js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript">
      function confirmationDelete(anchor)
      {
         var conf = confirm('Apakah Anda Yakin Ingin Menghapus Data Ini?');
         if(conf)
            window.location=anchor.attr("href");
      }
    </script>
   
  </body>
</html>
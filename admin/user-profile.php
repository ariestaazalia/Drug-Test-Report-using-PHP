<?php 
ob_start();
  include '../config/conn.php';
  session_start();
    if (!$_SESSION['login']) {
      echo "<script> alert('Anda Belum Login, Silahkan Login') </script>";
      echo "<script> window.location.href='login.php' </script>";
    }

$query=mysqli_query($con, "SELECT * FROM tb_user where id_user");
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
    <link rel="stylesheet" href="./css/table-style.css">
    <link rel="stylesheet" href="./css/button-style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

  </head>

  <body>
    <section class="sidemenu">
      <nav>
        <img src="../img/Logo_BNN.png"> <br> <br>
        <a href="index.php"><i class="fa fa-home"></i> Beranda</a>
        <a href="user-profile.php" class="active"><i class="fa fa-user"></i> Profil</a>
        <a href="skhpn.php"><i class="fa fa-sticky-note"></i> SKHPN</a>
       <?php if($_SESSION['status']==1){ ?>
            <a href="laporan.php"><i class="fa fa-file" aria-hidden="true"></i> Laporan</a>
        <?php } ?>
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
        <h1>Profil</h1>
        <p>Info</p>
        <?php if($_SESSION['status']==1){ ?>
            <a href="add-user.php"><button class="btn btn-add">Tambah User</button></a>
        <?php } ?>
        
      </div>

      <div class="cards">
        <div class="card-user">
          <p> Anda Login Sebagai: <b><?= $_SESSION['username']; ?></b></p><hr>
         <?php $id= $_SESSION['id_user'];
            $que= mysqli_query($con, "SELECT * FROM tb_user where id_user= '$id' ");
            $dat= mysqli_fetch_assoc($que) 
          ?>
          <div class="info" style="overflow-x: auto;">
            <table style="width: 100%; border:0; ">
              <tr>
                <td>Nama </td>
                <td>:</td>
                <td><?= $dat['nama_user']; ?></td>
              </tr>
                <td>Jenis Kelamin </td>
                <td>:</td>
                <td>
                  <?php if ($dat['jenis_kelamin']=="L") {
                        echo "Laki-laki";
                      }elseif ($dat['jenis_kelamin']=="P") {
                        echo "Perempuan";
                      }
                  ?>
               </td>
              </tr>
              <tr>
                <td>Jabatan </td>
                <td>:</td>
                <td><?= $dat['jabatan'] ?></td>
              </tr>
              <tr>
                <td>Terakhir Login</td>
                <td>:</td>
                <td><?= date('d M Y / H:i', strtotime($dat['last_activity'])); ?></td>
              </tr>

              <tr>
                <?php if ($_SESSION['status']==1) { ?>
                  <td> <a href="edit-userprofile.php?id=<?= $_SESSION['id_user']; ?>"><button class="btn btn-edit-profile"></i> Edit Profil</button></a></td>
                <?php }elseif ($_SESSION['status']==2) {?>
                  <td> <a href="edit-userprofile.php?id=<?= $_SESSION['id_user']; ?>"><button class="btn btn-edit-profile"></i> Edit Profil</button></a></td>
                <?php } ?>
              </tr>
            </table>

          </div>
        </div>
      </div>

    
    <?php if($_SESSION['status']==1){ ?>
      <div style="overflow-x: auto;">
        <table id="table-id" >
        <thead>
          <th>No.</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Jabatan</th>
          <th>Login Terakhir</th>
          <th colspan="2">Aksi</th>
        </thead>

        <tbody>
        <?php $num=0; do{
            $num++;?>
          <tr>
            <td><?= $num ?>.</td>
            <td><?= $data['nama_user']; ?></td>
            <td><?= $data['username']; ?></td>
            <td><?= $data['jabatan']; ?></td>
            <td><?= $data['last_activity']; ?></td>
            <td><a href="edit-userprofile.php?id=<?= $data['id_user']; ?>"><button class="btn btn-edit"><i class="fa fa-edit"></i></button></a></td>
            <td><a onclick='javascript:confirmationDelete($(this));return false;' href="delete-user.php?id=<?= $data['id_user']; ?>" class="delete"><button class="btn btn-delete"><i class="fa fa-trash"></i></button></a></td>
          </tr> 
        <?php } while ($data=mysqli_fetch_assoc($query));?>      
        </tbody>
    </table>
    <?php } ?>
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

<?php 
ob_start();
  include '../config/conn.php';
  session_start();
    if (!$_SESSION['login']) {
      echo "<script> alert('Anda Belum Login, Silahkan Login') </script>";
      echo "<script> window.location.href='login.php' </script>";
    }

    if ($_SESSION['status']==1) {
        $id= $_GET['id'];
        $ids= $_SESSION['id_user'];

        if (isset($_POST['update'])) {
            $password= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['password'])));
            $jabatan= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['jabatan'])));
            $jenis= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['jenis_kelamin'])));
            $status= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['status'])));

            $query=mysqli_query($con, "UPDATE tb_user set password='$password', jabatan= '$jabatan', jenis_kelamin='$jenis', status='$status' where id_user= '$id'");
            
            if ($query) {
                echo '<script>alert("Berhasil Mengubah Data");</script>';
                echo "<script>window.location.href='user-profile.php'</script>";
            }
        }elseif (isset($_POST['cancel'])) {
            header('location: user-profile.php');
        }

            $query= mysqli_query($con, "SELECT * FROM tb_user where id_user= '$id'");
            $data= mysqli_fetch_assoc($query);

    }elseif ($_SESSION['status']==2){
        $ids= $_SESSION['id_user'];
        
        if (isset($_POST['update'])){
            $password= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['password'])));
            $jabatan= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['jabatan'])));
            $jenis= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['jenis_kelamin'])));
            
            $query=mysqli_query($con, "UPDATE tb_user set password='$password', jabatan= '$jabatan', jenis_kelamin='$jenis' where id_user= '$ids'");

            if ($query) { 
                echo '<script>alert("Berhasil Mengubah Data");</script>';
                echo "<script>window.location.href='user-profile.php'</script>";
            }
        }elseif (isset($_POST['cancel'])) {
            header('location: user-profile.php');
        }
        $query = mysqli_query($con, "SELECT * FROM tb_user where id_user= '$ids'");
        $data= mysqli_fetch_assoc($query);

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
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.1/build/pure-min.css" integrity="sha384-oAOxQR6DkCoMliIh8yFnu25d7Eq/PHS21PClpwjOTeU2jRSq11vu66rf90/cZr47" crossorigin="anonymous">

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
      <div class="date">
        <p id="datetime"></p>
      </div>
    </header>

    <section class="content-area">
        <div class="heading">
            <h1>Profil</h1>
            <p>Edit Profil</p>
        </div>

    <div class="cards">
        <div class="card-user">
            <form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data">
                <?php if ($_SESSION['status']==2) { ?>
                <fieldset>
                    <legend>Edit Profil: <strong> <?= $_SESSION['username']; ?> </strong></legend>

                    <div class="pure-g">
                        <div class="pure-u-1">
                            <label for="nama">Nama</label>
                            <input name="nama" class="pure-u-1" type="text" disabled value="<?= $data['nama_user']; ?>" required>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="username">Username</label>
                            <input name="username" class="pure-u-23-24" type="text" disabled value="<?= $data['username']; ?>" required>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="password">Password</label>
                            <input name="password" id="pw" class="pure-u-1" type="password" value="<?= $data['password']; ?>" pattern=".{7,}" title="Harus Mengandung Minimal 8 Karakter" required>
                            <input type="checkbox" onclick="myFunction()"> Lihat Password
                            <br><br>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="jabatan">Jabatan</label>
                            <input name="jabatan" class="pure-u-23-24" type="text" value="<?= $data['jabatan']; ?>" pattern="[A-Za-z0-9].{2,19}" title="Isi dengan Minimal 3 Karakter dan Maksimal 20 Karakter" required>
                        </div>

                         <div class="pure-u-1-2">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="pure-u-1" required>
                                <option></option>
                                <option value="L" <?php if ($data['jenis_kelamin']=="L"){echo "selected";}?>>Laki-Laki</option>
                                <option value="P" <?php if ($data['jenis_kelamin']=="P"){echo "selected";}?>>Perempuan</option>
                            </select>
                        </div>
                    </div>

                         <br><br>
                    <center>
                        <button type="submit" class="btn btn-cancel" name="cancel" formnovalidate>Cancel</button>
                        <button type="submit" class="btn btn-submit" name="update">Update</button>
                    </center>
                </fieldset>
                <?php }

                elseif ($_SESSION['status']==1) { ?>
                    <fieldset>
                        <legend>Edit Profil: <strong> <?= $data['username']; ?> </strong></legend>

                    <div class="pure-g">
                        <div class="pure-u-1">
                            <label for="nama">Nama</label>
                            <input name="nama" class="pure-u-1" type="text" disabled value="<?= $data['nama_user']; ?>" required>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="username">Username</label>
                            <input name="username" class="pure-u-23-24" type="text" disabled value="<?= $data['username']; ?>" required>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="password">Password</label>
                            <input name="password" id="pw" class="pure-u-1" type="password" value="<?= $data['password']; ?>" pattern=".{7,}" title="Harus Mengandung Minimal 8 Karakter" required>
                            <input type="checkbox" onclick="myFunction()"> Lihat Password
                            <br><br>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="jabatan">Jabatan</label>
                            <input name="jabatan" class="pure-u-23-24" type="text" value="<?= $data['jabatan']; ?>" pattern="[A-Za-z0-9].{2,19}" title="Isi dengan Minimal 3 Karakter dan Maksimal 20 Karakter" required>
                        </div>

                         <div class="pure-u-1-3">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="pure-u-23-24" required>
                                <option></option>
                                <option value="L" <?php if ($data['jenis_kelamin']=="L"){echo "selected";}?>>Laki-Laki</option>
                                <option value="P" <?php if ($data['jenis_kelamin']=="P"){echo "selected";}?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="status">Status</label>
                            <select name="status" class="pure-u-1" required>
                                <option></option>
                                <option value="1" <?php if ($data['status']=="1"){echo "selected";}?>>Admin</option>
                                <option value="2" <?php if ($data['status']=="2"){echo "selected";}?>>Pegawai</option>
                            </select>
                        </div>
                        
                    </div>

                    <br><br>
                <center>
                    <button type="submit" class="btn btn-cancel" name="cancel" formnovalidate>Batal</button>
                    <button type="submit" class="btn btn-submit" name="update">Ubah</button>
                </center>
                    </fieldset>
                <?php } ?>


                    
            </form>

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
            function myFunction() {
              var x = document.getElementById("pw");
              if (x.type === "password") {
                x.type = "text";
              } else {
                x.type = "password";
              }
            }
        </script>


  </body>

</html>
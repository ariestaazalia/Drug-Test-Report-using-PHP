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
    echo "<script> window.location.href='user-profile.php' </script>";
}

$usernameError= '';
if (isset($_POST['tambah'])) {
	$nama= htmlspecialchars(trim($_POST['nama']));
	$username= htmlspecialchars(trim($_POST['username']));
	$password= htmlspecialchars(trim($_POST['password']));
	$jabatan= htmlspecialchars(trim($_POST['jabatan']));
	$jenis= $_POST['jenis-kelamin'];
	$status= $_POST['status'];

    $que= mysqli_query($con, "SELECT * FROM tb_user where username = '$username'");
    if (mysqli_num_rows($que) > 1) {
      $usernameError = "Username sudah Terpakai";  
    }else{
        $query=mysqli_query($con, "INSERT INTO tb_user (nama_user, username, password, jabatan, jenis_kelamin, status) VALUES ('$nama', '$username', '$password', '$jabatan', '$jenis', '$status')");

        if ($query) {
            echo "<script> alert('Berhasil Menambahkan Data') </script>";
            echo "<script> window.location.href='user-profile.php' </script>";
        }
    }
}elseif (isset($_POST['cancel'])) {
	header('location: user-profile.php'); 
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
        <a href="laporan.php"><i class="fa fa-file" aria-hidden="true"></i> Laporan</a>
        <a href="signout.php"><i class="fa fa-sign-out"></i> Keluar</a>
      </nav>
    </section>

     <header>
      <div class="navbar">
      </div>
      <div class="date">
        <p id="datetime"></p>
      </div>
    </header>

     <section class="content-area">
        <div class="heading">
            <h1>Profil</h1>
            <p>Tambah User Baru</p>
        </div>

    <div class="cards">
        <div class="card-user">
            <form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend> Tambah User </strong></legend>

                    <div class="pure-g">
                        <div class="pure-u-1">
                            <label for="nama">Nama</label>
                        <input name="nama" class="pure-u-1" type="text" pattern="[A-Za-z].{,40}" title="Nama Maksimum 40 Karakter" required>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="username">Username</label>
                            <input name="username" class="pure-u-23-24" type="text"  pattern="[A-Za-z0-9].{2,19}" title="Isi Username dengan Minimal 3 Karakter dan Maksimal 20 Karakter" required>
                            <span style="color: red;"><?= $usernameError ?> </span>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="password">Password</label>
                            <input name="password" class="pure-u-1" type="password" pattern=".{7,}" id="pw" title="Password Harus Mengandung Minimal 8 Karakter" required>
                            <input type="checkbox" onclick="myFunction()"> Lihat Password
                            <br><br>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="jabatan">Jabatan</label>
                            <input name="jabatan" class="pure-u-23-24" pattern="[A-Za-z0-9].{2,19}" title="Isi dengan Minimal 3 Karakter dan Maksimal 20 Karakter" type="text" required>
                        </div>

                         <div class="pure-u-1-3">
                            <label for="jenis-kelamin">Jenis Kelamin</label>
                            <select name="jenis-kelamin" class="pure-u-23-24" required>
                                <option>Jenis Kelamin</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="status">Status</label>
                            <select name="status" class="pure-u-23-24" required>
                                <option>Status</option>
                                <option value="1">Admin</option>
                                <option value="2">Pegawai</option>
                            </select>
                        </div>
                    </div>

                    <br><br>
                <center>
                    <button type="submit" class="btn btn-cancel" name="cancel" formnovalidate>Batal</button>
                    <button type="submit" class="btn btn-submit" name="tambah">Tambah</button>
                </center>
                </fieldset>
            </form>

    </section>

    <div class="footer">
      <p>
        Copyright &copy; <?= date('Y') ?> by Ariesta Salwa Azalia
      </p>
    </div>

        <script src="./js/datetime.js"></script>
        <script src='./js/tablesort.min.js'></script>
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
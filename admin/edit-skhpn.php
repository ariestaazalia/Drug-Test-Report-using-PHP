<?php
ob_start();
include '../config/conn.php';
session_start();
    if (!$_SESSION['login']) {
      echo "<script> alert('Anda Belum Login, Silahkan Login') </script>";
      echo "<script> window.location.href='login.php' </script>";
    }

 $id= $_GET['id'];
 $noSuratErr= '';
    if (isset($_POST['update'])) {
       $nama_pemohon= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['nama_pemohon'])));
       $jenis_id= mysqli_real_escape_string($con, $_POST['jenis_id']);
       $no_id= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['no_id'])));
       $jenis_kelamin= mysqli_real_escape_string($con, $_POST['jenis_kelamin']);
       $tempat_lahir= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['tempat_lahir'])));
       $tanggal_lahir= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['tanggal_lahir'])));
       $alamat_pemohon= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['alamat_pemohon'])));
       $pekerjaan_pemohon= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['pekerjaan_pemohon'])));
       $no_hp= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['no_hp'])));
       $keperluan= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['keperluan'])));

       $no_surat= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['no_surat'])));
       $tgl_periksa= mysqli_real_escape_string($con, $_POST['tgl_periksa']);
       $jam_periksa= mysqli_real_escape_string($con, $_POST['jam_periksa']);
       $hp_kesadaran= mysqli_real_escape_string($con, $_POST['kesadaran']);
       $hp_kesadaranumum= mysqli_real_escape_string($con, $_POST['kesadaran_um']);
       $hp_tekanandarah= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['tekanan_darah'])));
       $hp_nadi= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['nadi'])));

       $hp_riwayatobat= mysqli_real_escape_string($con, $_POST['riwayatobat']);
       $hp_jenisobat= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['jenis_obat'])));
       $hp_asalobat= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['asal_obat'])));
       $hp_terakhirminum= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['terakhir_minum'])));

       $hp_merktest= mysqli_real_escape_string($con, htmlspecialchars(trim($_POST['hp_merktest'])));
       $hp_amphetamine= mysqli_real_escape_string($con, $_POST['hs_test1']);
       $hp_methamphetamine= mysqli_real_escape_string($con, $_POST['hs_test2']);
       $hp_cocaine= mysqli_real_escape_string($con, $_POST['hs_test3']);
       $hp_opioid= mysqli_real_escape_string($con, $_POST['hs_test4']);
       $hp_tetrahydrocannabinol= mysqli_real_escape_string($con, $_POST['hs_test5']);
       $hp_benzodiazepine= mysqli_real_escape_string($con, $_POST['hs_test6']);
       $hp_k2= mysqli_real_escape_string($con, $_POST['hs_test7']);

       $hp_indikasi= mysqli_real_escape_string($con, $_POST['hp_indikasi']);

       $petugas_pemeriksa= mysqli_real_escape_string($con, $_POST['petugas_pemeriksa']);
       $dokter_pemeriksa= mysqli_real_escape_string($con, $_POST['dokter_pemeriksa']);
       $penanggung_jawab= mysqli_real_escape_string($con, $_POST['penanggung_jawab']);

       $que= mysqli_query($con, "SELECT * FROM tb_hasilpemeriksaan where no_surat= '$no_surat'");
       if (mysqli_num_rows($que) > 1) {
          $noSuratErr = "Nomor Surat sudah Terpakai";  
        }else{
        $query= mysqli_query($con, "UPDATE tb_hasilpemeriksaan set no_surat= '$no_surat', tanggal_periksa= '$tgl_periksa', jam_periksa= '$jam_periksa', hp_kesadaran= '$hp_kesadaran', hp_kesadaranumum= '$hp_kesadaranumum', hp_tekanandarah= '$hp_tekanandarah', hp_nadi= '$hp_nadi', hp_riwayatobat= '$hp_riwayatobat', hp_jenisobat= '$hp_jenisobat', hp_asalobat= '$hp_asalobat', hp_terakhirminum= '$hp_terakhirminum', hp_merktest= '$hp_merktest', hp_amphetamine= '$hp_amphetamine', hp_methamphetamine= '$hp_methamphetamine', hp_cocaine= '$hp_cocaine', hp_opioid= '$hp_opioid', hp_tetrahydrocannabinol=  '$hp_tetrahydrocannabinol', hp_benzodiazepine= '$hp_benzodiazepine', hp_k2= '$hp_k2', hp_indikasi= '$hp_indikasi', petugas_pemeriksa='$petugas_pemeriksa', dokter_pemeriksa='$dokter_pemeriksa', penanggung_jawab='$penanggung_jawab' where id_pemohon= '$id'");

           if ($query) {
            $sql= mysqli_query($con, "UPDATE tb_pemohon set status_permohonan='2' where id_pemohon='$id'");
            echo "<script> alert('Data Berhasil Diubah') </script>";
            echo "<script> window.location.href='skhpn.php' </script>";
           }elseif (!$query) {
            echo "<script> alert('Gagal!') </script>";
            echo "<script> window.location.href='skhpn.php' </script>";
           }
        }
       
    } elseif (isset($_POST['cancel'])) {
    	echo "<script> window.location.href='skhpn.php' </script>";
    }

$query= mysqli_query($con, "SELECT tb_pemohon.*, tb_hasilpemeriksaan.* FROM tb_pemohon JOIN tb_hasilpemeriksaan ON tb_hasilpemeriksaan.id_pemohon = tb_pemohon.id_pemohon where tb_pemohon.id_pemohon='$id'");
$data= mysqli_fetch_assoc($query);

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
      <nav id="navbar">
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
      <div class="date">
        <p id="datetime"></p>
      </div>
    </header>

    <section class="content-area">
        <div class="heading">
            <h1>SKHPN</h1>
            <p>Edit SKHPN</p>
        </div>

        <div class="cards">
        <div class="card-user">
            <form class="pure-form pure-form-stacked" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend>Kelola Data SKHPN untuk <strong> <?= $data['nama_pemohon']; ?> </strong></legend>

                    <div class="pure-g">
                        <div class="pure-u-1-2">
                            <label for="nama_pemohon">Nama</label>
                            <input name="nama_pemohon" class="pure-u-23-24" type="text" value="<?=$data['nama_pemohon'];?>" readonly>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <input name="jenis_kelamin" class="pure-u-1" type="text" value="<?=$data['jenis_kelamin'];?>" readonly>
                        </div>

                        <div class="pure-u-1-4">
                            <label for="jenis_id">Jenis Identitas</label>
                            <input name="jenis_id" class="pure-u-23-24" type="text" value="<?=$data['jenis_identitas'];?>" readonly>
                        </div>

                        <div class="pure-u-3-4">
                            <label for="no_id">Nomor Identitas</label>
                            <input name="no_id" class="pure-u-1" type="text" value="<?= $data['no_identitas']; ?>" readonly>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input name="tempat_lahir" class="pure-u-23-24" type="text" value="<?=$data['tempat_lahir'];?>" readonly>
                        </div>

                         <div class="pure-u-1-2">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="pure-u-1" value="<?=$data['tanggal_lahir'];?>" readonly>
                        </div>

						            <div class="pure-u-1">
                            <label for="alamat_pemohon">Alamat</label>
                           	<input type="text" name="alamat_pemohon" class="pure-u-1" value="<?= $data['alamat_pemohon'];?>" readonly>
                        </div>   

                        <div class="pure-u-1-2">
                            <label for="pekerjaan_pemohon">Pekerjaan</label>
                           	<input type="text" name="pekerjaan_pemohon" class="pure-u-23-24" value="<?= $data['pekerjaan_pemohon']; ?>" readonly>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="no_hp">No. Handphone</label>
                           	<input type="text" name="no_hp" class="pure-u-1" value="<?= $data['no_hp']; ?>" readonly>
                        </div>

                        <div class="pure-u-1">
                            <label for="keperluan">Keperluan</label>
                           	<input type="text" name="keperluan" class="pure-u-1" value="<?= $data['keperluan']; ?>" readonly>
                        </div>

                        <div class="pure-u-1">
                            <label for="foto_id">Foto Identitas</label>
                            <?php $photo= $data['foto_identitas']; 
                            
                            	echo '<img src="./img/uploads/'.$photo.'" style= "width:300px;height:200px" />';

                            ?>
                           	
                        </div>

                    </div>

                    <br><br>
               
                </fieldset>


                <!-- -------------------------------------------------- -->
                <fieldset>
                    <legend>Hasil Pemeriksaan SKHPN</legend>
                    	<p>Hasil Wawancara dan Pemeriksaan Fisik</p><br>
                    <div class="pure-g">
                        <div class="pure-u-1-3">
                            <label for="no_surat">Nomor Surat</label> 
                            <input name="no_surat" class="pure-u-23-24" type="text" value="<?= $data['no_surat']; ?>" required="">
                            <span style="color: red;"><?= $noSuratErr ?></span>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="tgl_periksa">Tanggal Pemeriksaan</label>
                             <input type="date" name="tgl_periksa" class="pure-u-23-24" value="<?= $data['tanggal_periksa']; ?>" required>                           
                        </div>

                        <div class="pure-u-1-3">
                            <label for="jam_periksa">Jam Pemeriksaan</label>
                            <input name="jam_periksa" class="pure-u-1" type="time" value="<?= $data['jam_periksa']; ?>" required="">
                        </div>

                        <div class="pure-u-1-2">
                            <label for="kesadaran">Kesadaran</label>
                            <select name="kesadaran" class="pure-u-23-24" required="">
                                <option> </option>
                                <option value="Baik" <?php if ($data['hp_kesadaran']=="Baik"){echo "selected";}?>>Baik</option>
                                <option value="Terganggu" <?php if ($data['hp_kesadaran']=="Terganggu"){echo "selected";}?>>Terganggu</option>
                            </select>
                        </div>

                         <div class="pure-u-1-2">
                            <label for="kesadaran_um">Kesadaran Umum</label>
                            <select name="kesadaran_um" class="pure-u-1" required="">
                                <option> </option>
                                <option value="Baik" <?php if ($data['hp_kesadaranumum']=="Baik"){echo "selected";}?>>Baik</option>
                                <option value="Cukup" <?php if ($data['hp_kesadaranumum']=="Cukup"){echo "selected";}?>>Cukup</option>
                                <option value="Kurang" <?php if ($data['hp_kesadaranumum']=="Kurang"){echo "selected";}?>>Kurang</option>
                            </select>
                        </div>

						<div class="pure-u-1-2">
                            <label for="tekanan_darah">Tekanan Darah (mmHg)</label>
                           	<input type="text" name="tekanan_darah" class="pure-u-23-24" value="<?= $data['hp_tekanandarah']; ?>" required="">
                        </div>   

                        <div class="pure-u-1-2">
                            <label for="nadi">Nadi (per Menit)</label>
                           	<input type="text" name="nadi" class="pure-u-1" value="<?= $data['hp_nadi']; ?>" required="">
                        </div>
                    </div>
                </fieldset>

                <!-- --------------------------------------------------- -->

                <fieldset>
                	<br>
                	<p>Riwayat Penggunaan Obat (Seminggu Terakhir)</p> <br>
                	<div class="pure-g">
                        <div class="pure-u-1-2">
                            <label for="riwayatobat">Penggunaan Obat-obatan dalam seminggu ini</label>
                           	<select name="riwayatobat" class="pure-u-23-24" required="">
                                <option> </option>
                                <option value="Ada" <?php if ($data['hp_riwayatobat']=="Ada"){echo "selected";}?>>Ada</option>
                                <option value="Tidak ada" <?php if ($data['hp_riwayatobat']=="Tidak ada"){echo "selected";}?>>Tidak Ada</option>
                            </select>
                        </div>

                        <div class="pure-u-1-2">
                            <label for="jenis_obat">Jenis Obat (Isi "-" Jika Tidak Ada)</label>
                              <input type="text" name="jenis_obat" class="pure-u-1" value="<?= $data['hp_jenisobat'];?>">
                        </div>

                        <div class="pure-u-1-2">
                            <label for="asal_obat">Asal Obat (Isi "-" Jika Tidak Ada)</label>
                           	<input type="text" name="asal_obat" class="pure-u-23-24" value="<?= $data['hp_asalobat']; ?>">
                        </div>

                        <div class="pure-u-1-2">
                            <label for="terakhir_minum">Terakhir Minum (Isi "-" Jika Tidak Ada)</label>
                           	<input type="text" name="terakhir_minum" class="pure-u-1" value="<?= $data['hp_terakhirminum']; ?>">
                        </div>

                    </div>

                </fieldset>


                <fieldset>
                	<br>
                	<p>Hasil Tes Urin</p><br>
                	<div class="pure-g">
                		<div class="pure-u-1">
                            <label for="hp_merktest">Merk Rapid Test</label>
                           	<input type="text" name="hp_merktest" class="pure-u-1" value="<?= $data['hp_merktest']; ?>" required="">
                        </div>

                        <div class="pure-u-1-3">
                            <label for="hs_test1">Amphetamine</label>
                           	<select name="hs_test1" class="pure-u-23-24" required="">
                                <option></option>
                                <option value="Positif" <?php if ($data['hp_amphetamine']=="Positif"){echo "selected";}?>>Positif</option>
                                <option value="Negatif" <?php if ($data['hp_amphetamine']=="Negatif"){echo "selected";}?>>Negatif</option>
                            </select>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="hs_test2">Methamphetamine</label>
                           	<select name="hs_test2" class="pure-u-23-24" required="">
                                <option> </option>
                                <option value="Positif" <?php if ($data['hp_methamphetamine']=="Positif"){echo "selected";}?>>Positif</option>
                                <option value="Negatif" <?php if ($data['hp_methamphetamine']=="Negatif"){echo "selected";}?>>Negatif</option>
                            </select>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="hs_test3">Cocaine</label>
                           	<select name="hs_test3" class="pure-u-1" required="">
                                <option> </option>
                                <option value="Positif" <?php if ($data['hp_cocaine']=="Positif"){echo "selected";}?>>Positif</option>
                                <option value="Negatif" <?php if ($data['hp_cocaine']=="Negatif"){echo "selected";}?>>Negatif</option>
                            </select>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="hs_test4">Opioid</label>
                           	<select name="hs_test4" class="pure-u-23-24" required="">
                                <option> </option>
                                <option value="Positif" <?php if ($data['hp_opioid']=="Positif"){echo "selected";}?>>Positif</option>
                                <option value="Negatif" <?php if ($data['hp_opioid']=="Negatif"){echo "selected";}?>>Negatif</option>
                            </select>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="hs_test5">Tetrahydrocannabinol</label>
                           	<select name="hs_test5" class="pure-u-23-24" required="">
                                <option> </option>
                                <option value="Positif" <?php if ($data['hp_tetrahydrocannabinol']=="Positif"){echo "selected";}?>>Positif</option>
                                <option value="Negatif" <?php if ($data['hp_tetrahydrocannabinol']=="Negatif"){echo "selected";}?>>Negatif</option>
                            </select>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="hs_test6">Benzodiazepine</label>
                           	<select name="hs_test6" class="pure-u-1" required="">
                                <option> </option>
                                <option value="Positif" <?php if ($data['hp_benzodiazepine']=="Positif"){echo "selected";}?>>Positif</option>
                                <option value="Negatif" <?php if ($data['hp_benzodiazepine']=="Negatif"){echo "selected";}?>>Negatif</option>
                            </select>
                        </div>

                        <div class="pure-u-1-3">
                            <label for="hs_test7">K2</label>
                           	<select name="hs_test7" class="pure-u-23-24" required="">
                                <option> </option>
                                <option value="Positif" <?php if ($data['hp_k2']=="Positif"){echo "selected";}?>>Positif</option>
                                <option value="Negatif" <?php if ($data['hp_k2']=="Negatif"){echo "selected";}?>>Negatif</option>
                            </select>
                        </div>
                	</div>

                	
                </fieldset>

                <fieldset>
                	<p>Hasil Pemeriksaan Keseluruhan</p>
                	<div class="pure-g">
                		<div class="pure-u-1">
                            <label for="hp_indikasi">Indikasi</label>
                           	<select name="hp_indikasi" class="pure-u-1" required="">
                                <option> </option>
                                <option value="Terindikasi" <?php if ($data['hp_indikasi']=="Terindikasi"){echo "selected";}?>>Terindikasi</option>
                                <option value="Tidak Terindikasi" <?php if ($data['hp_indikasi']=="Tidak Terindikasi"){echo "selected";}?>>Tidak Terindikasi</option>
                            </select>
                        </div>
                	</div>
                </fieldset>

                <fieldset>
                  <p>Pemeriksa dan Penanggungjawab</p>
                  <div class="pure-g">
                    <div class="pure-u-1-3">
                          <label for="petugas_pemeriksa">Petugas Pemeriksa Urin</label>
                          <select name="petugas_pemeriksa" class="pure-u-23-24" required="">
                              <option></option>
                              <option value="Laela Agustin Kurniasih, AMK." <?php if ($data['petugas_pemeriksa']=="Laela Agustin Kurniasih, AMK."){echo "selected";}?>>Laela Agustin Kurniasih, AMK.</option>
                          </select>
                    </div>

                    <div class="pure-u-1-3">
                          <label for="dokter_pemeriksa">Dokter Pemeriksa</label>
                          <select name="dokter_pemeriksa" class="pure-u-23-24" required="">
                              <option></option>
                              <option value="dr. Esa Dhiandani." <?php if ($data['dokter_pemeriksa']=="dr. Esa Dhiandani."){echo "selected";}?>>dr. Esa Dhiandani.</option>
                          </select>
                    </div>

                    <div class="pure-u-1-3">
                          <label for="penanggung_jawab">Penanggung Jawab</label>
                          <select name="penanggung_jawab" class="pure-u-1" required="">
                              <option></option>
                              <option value="Sudirman, S.Ag., M.Si" <?php if ($data['penanggung_jawab']=="Sudirman, S.Ag., M.Si"){echo "selected";}?>>Sudirman, S.Ag., M.Si</option>
                              <option value="Bu Kasi" <?php if ($data['penanggung_jawab']=="Bu Kasi"){echo "selected";}?>>Bu Kasi</option>
                          </select>
                    </div>
                  </div>




                	<br><br>
                	<center>
	                    <button type="submit" class="btn btn-cancel" name="cancel" formnovalidate>Batal</button>
	                    <button type="submit" class="btn btn-submit" name="update">Ubah</button>
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
        <script src='./js/tablesort.number.js'></script>
        <script src='./js/tablesort.date.js'></script>
  </body>

</html>
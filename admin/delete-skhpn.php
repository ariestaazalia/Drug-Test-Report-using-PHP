<?php
    ob_start();
	include '../config/conn.php';
	session_start();
	
    if (!$_SESSION['login']) {
      echo "<script> alert('Anda Belum Login, Silahkan Login') </script>";
      echo "<script> window.location.href='login.php' </script>";
    }else{
    	$id= $_GET['id'];
		$query= mysqli_query($con, "DELETE tb_hasilpemeriksaan.*, tb_pemohon.* FROM tb_hasilpemeriksaan JOIN tb_pemohon ON tb_hasilpemeriksaan.id_pemohon = tb_pemohon.id_pemohon where tb_hasilpemeriksaan.id_pemohon='$id'");

			if ($query) {
				echo "<script>alert('Berhasil Menghapus Data')</script>";
				echo "<script> 
						window.location.href='skhpn.php'; 
					</script>";
			}else{
				echo "<script>alert('Gagal')</script>";
			}
    }
?>
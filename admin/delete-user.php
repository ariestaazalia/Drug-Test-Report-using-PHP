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
	}else{
		$id= $_GET['id'];
		$query= mysqli_query($con, "DELETE FROM tb_user where id_user='$id'");
	
		if ($query) {
		echo "<script>alert('Berhasil Menghapus Data')</script>";
		echo "<script> 
				window.location.href='user-profile.php'; 
			</script>";
		}
	}

	
?>
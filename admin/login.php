<?php 
ob_start();
session_start();
	include('../config/conn.php');

	$errorMsg= '';
	if (isset($_POST['Login'])) {
		$username= $_POST['username'];
		$password= $_POST['password'];

		$query= mysqli_query($con, "SELECT * FROM tb_user where username='$username' and password='$password'");
		$data= mysqli_fetch_assoc($query);

		if (mysqli_num_rows($query)){
			date_default_timezone_set('Asia/Jakarta');
			$update= mysqli_query($con, "UPDATE tb_user SET last_activity = CURTIME() where username='$username'");
			session_start();

			$_SESSION['id_user']=$data['id_user'];
			$_SESSION['username'] = $data['username'];
			$_SESSION['password'] = $data['password'];
			$_SESSION['nama_user'] = $data['nama_user'];
			$_SESSION['jenis_kelamin'] = $data['jenis_kelamin'];
			$_SESSION['jabatan'] = $data['jabatan'];
			$_SESSION['last_activity'] = $data['last_activity'];
			$_SESSION['status'] = $data['status'];
			$_SESSION['login']= true;
			
			echo "<script> 
					alert('Berhasil Login');
					window.location.href='index.php'; 
				</script>";
		} else{
			$errorMsg= 'Username atau Password Salah!';
		}			
	}

	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<link rel="stylesheet" type="text/css" href="./css/login.css">
</head>

<body>
	<h1>SISTEM PENERBITAN SKHPN</h1>
	<br>
<!-- Login Section -->
	<div class="container" id="container">
		<div>
			<br>
			<form method="POST" action="">
				<img src="../img/Logo_BNN.png">
				<br>

				<input type="text" placeholder="Username" name="username" required/> 
				<input type="password" placeholder="Password" name="password" id="pw" required />
				<div class="kick">
					<input type="checkbox" onclick="myFunction()" > Lihat Password
				</div>
				<br> <span class="error"><?= $errorMsg ?> </span> <br>
					<br>
					<button type="submit" name="Login">Login</button> <br>
			</form>
		</div>
	</div>
		

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
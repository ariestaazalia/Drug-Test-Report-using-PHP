<!-- templatemo 379 catalog -->
<!-- 
Catalog Template 
http://www.templatemo.com/preview/templatemo_379_catalog 
-->
<?php
	session_start();
	$conn=mysqli_connect("localhost","root","","sistem_perpus");
	$kate=mysqli_query($conn,"SELECT * FROM kategori_buku ");
	$pen=mysqli_query($conn,"SELECT * FROM datapenulis ");
	if(isset($_POST['edit'])){
		$id=$_POST['edit'];
		$kata=mysqli_query($conn,"SELECT data_buku.id_buku,data_buku.jumlah,
		data_buku.letak,data_buku.kodebuku,data_buku.judul,data_buku.cover,data_buku.Deskripsi,data_buku.cover,data_buku.id_penulis,data_buku.id_kategori,datapenulis.nama as pen,kategori_buku.kategori_bk as kategori FROM data_buku INNER JOIN datapenulis on  data_buku.id_penulis=datapenulis.id_penulis INNER JOIN kategori_buku on  data_buku.id_kategori=kategori_buku.id_kategori where data_buku.id_buku='$id'");	
		$katalog=mysqli_fetch_assoc($kata);
		$av=$katalog['id_kategori'];
		$asd=$katalog['id_penulis'];
		$j=mysqli_query($conn,"select * from kategori_buku where not id_kategori='$av'");
		$bsd=mysqli_query($conn,"select * from datapenulis where not id_penulis='$asd'");
	}			

		if (isset($_POST['submit'])){
			$target="images/".basename($_FILES['image']['name']);
			$image=$_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'], $target);
			$id=$_POST['id_buku'];
			$letak=$_POST['letak'];
			$jumlah=$_POST['jumlah'];
			$kode=$_POST['kode'];
			$judul=$_POST['judul'];
			$kategori=$_POST['kategori'];
			$pen=$_POST['pen'];
			$desk=$_POST['deskripsi'];

			$query1=mysqli_query($conn,"UPDATE data_buku set judul='$judul',Deskripsi='$desk',cover='$image',id_kategori='$kategori',id_penulis='$pen',letak='$letak',kodebuku='$kode',jumlah='jumlah' where id_buku='$id'")or die(mysqli_error($conn));

			header("location:listbuku.php");
		}		
		
?>
<!DOCTYPE html>
<html>
<head>		
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Perpus Yosda</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet" type="text/css">
	<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="datatable/datatables.min.css"/>
	<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<!-- Custom styles for this template -->
	<link href="http://getbootstrap.com/examples/offcanvas/offcanvas.css" rel="stylesheet">
	<link href="coba.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="tinymce/jquery.tinymce.min.js"></script>
	<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
	<script>
		tinymce.init({
			  selector: 'textarea',
			  height: 300,
			  menubar: true,
			  plugins: [
			    'advlist autolink lists link image charmap print preview anchor textcolor',
			    'searchreplace visualblocks code fullscreen',
			    'insertdatetime media table contextmenu paste code help wordcount'
			  ],
			  toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
			  content_css: [
			    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			    '//www.tinymce.com/css/codepen.min.css']
		});
	 </script>
	<!-- HTML 5 shim for IE backwards compatibility -->
		<!-- [if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js">
		</script>
		<![endif]-->
	</head>
	<body>
		<header>
			<div class="container logo">
				<div class="row">
					<div class="col-md-12"><a href="index.php"><img src="images/yoshda.png" width="430" height="110"alt="catalog" style="padding-bottom: 5px"></a></div>
				</div>
			</div>
			<nav class="navbar navbar-default" role="navigation"> 
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>					
				</div>

				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li><a href="index.php">Beranda</a></li>
						<?php 
							if(isset($_SESSION['user'])){
								if($_SESSION['id_kat']==2){
									header("location:index.php");
								}
								else {
								?>
								<li><a href="conta.php">Kontak</a></li>
								<li><a href="distribusibuku.php">Distribusi Buku</a></li>
								<li class="active"><a href="listbuku.php">Daftar Buku</a></li>
								<li><a href="absensi.php">Absensi</a></li>
								<li><a href="logout.php">Log Out</a></li>
								<?php }
							}else { ?>
						
						<li style="padding-left: 290px;"><a href="registrasi.php">Registrasi</a></li>
						<li><a href="login.php">Log In</a></li>
					<?php }?>
					</ul>
					<form class="navbar-form navbar-right" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Pencarian">
						</div>
						<button type="submit" class="btn btn-default"><img style= " height: 16px; width: 16px"src="images/search_47686.png"></button>
					</form>					
				</div><!-- /.navbar-collapse -->
			</nav>
		</header>
		<div class="container">
			<div class="row" id="preview">
				<div class="row">
					<div class="col-md-12" id="img_preview">
							<h3 style="text-align: center; font-size: 40px;">Edit <?php echo $katalog["judul"];?></h3>
							<form action="edit.php" method="POST" enctype = "multipart/form-data">
				<input type="hidden" name="id_buku" value="<?php echo $katalog["id_buku"];?>"">
				Judul : <input type="text" name="judul" style="width: 300px;" value="<?php echo $katalog["judul"];?>"></br>
				Letak : <input type="text" name="letak" style="width: 50px;" value="<?php echo $katalog["letak"];?>"></br>
				Jumlah : <input type="number" name="jumlah" style="width: 30px;" value="<?php echo $katalog["jumlah"];?>" ></br>
				Kode Buku : <input type="text" name="kode" style="width:200px;" value="<?php echo $katalog["kodebuku"];?>"></br>
				Kategori: <SELECT name="kategori">

					<option value="<?php echo $katalog['id_kategori']?>" selected><?php echo $katalog["kategori"];?></option>
					<?php while($b=mysqli_fetch_assoc($j)){?>
					<option value="<?php echo $b['id_kategori']?>"><?php echo $b["kategori_bk"];?></option><?php $_SESSION['id_katbar']=$b['id_kategori']; }?>
					</SELECT>

				Penulis : <SELECT name="pen" style="margin-left: 10px;">
					<option value="<?php echo $katalog['id_penulis']?>" selected><?php echo $katalog["pen"];?></option>
					<?php 
					while($p=mysqli_fetch_assoc($bsd)){?>
					<option value="<?php echo $p['id_penulis']?>"><?php echo $p["nama"];?></option><?php $_SESSION['id_penbar']=$p['id_penulis']; }?>
					</SELECT></br>

				Deskripsi : <textarea name="deskripsi"><?php echo $katalog["Deskripsi"];?></textarea></br>

				<label>
	    			Foto : 
	  			</label><br>
	  			<img src="images/<?php echo $katalog['cover'];?>" style="height:380px;width:240px;">
	  			</br><input type = "file" name = "image" ></br>

				<button class="btn btn-primary" role="button" type="submit" name="submit">Edit Buku</button></div>
			</form><br>
					</div>
				</div>

		</div> <!-- container -->
		<footer class="container">
			<div class="credit">
				<p id="templatemo_cr_bar" style="font-size: 24px">
					<img style= " height: 32px; width: 32px" src="images/location_47717.png"> Jl. Jenderal Soedirman No. 16 Kec. Purbalingga <img style= " height: 32px; width: 32px" src="images/whatsapp-logo.png"> 085421563456
				</p>
			</div>
		</footer>

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
	    <!-- 
		http://masonry.desandro.com/
	    http://desandro.mit-license.org/ 
		http://stackoverflow.com/questions/17767130/masonry-js-error-uncaught-typeerror-object-object-object-has-no-method-imag
		Align items in center: https://github.com/desandro/isotope/issues/20
	    Hiding text overflow: http://stackoverflow.com/questions/15308061/how-to-avoid-text-overflow-in-twitter-bootstrap
		-->
		<script src="js/masonry.pkgd.min.js"></script>
		<script src="js/imagesloaded.pkgd.min.js"></script>   
		<script>

			$(document).ready(function(){
				init_masonry();
			});

			function init_masonry(){
				var $container = $('.item_container');
				$container.imagesLoaded( function(){
					$container.masonry({
						itemSelector : '.item',
						"gutter": 10,
						isFitWidth: true
					});
				});

				var $fcontainer = $('.preview_footer_container');

				$fcontainer.masonry({
					itemSelector : '.footer_item',
					"gutter": 10,
					isFitWidth: true
				});
			}
			
		</script>	
		<script type="text/javascript" src="datatable/datatables.min.js"></script>
		<script type="text/javascript">
			$(document).ready( function () {
	            $('#table_id').DataTable();
	        } );
		</script>	
	</body>
</html>
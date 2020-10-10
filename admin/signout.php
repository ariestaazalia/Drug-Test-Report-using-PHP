<?php
ob_start();
session_start();
	unset($_SESSION['status']);
	unset($_SESSION['login']);
	session_unset();
session_destroy();
header('location: login.php');

?>
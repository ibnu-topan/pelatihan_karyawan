<?php
session_start();
require_once('../Connections/connection.php');

$username = $_POST['username'];
$password = $_POST['password'];
 
$query = mysql_query("select * from karyawan where username='$username' and password='$password'");
$cek = mysql_num_rows($query);

echo $cek; 

// cek apakah username dan password di temukan pada database
if($cek > 0){
 
	$data = mysql_fetch_assoc($query);
	
	echo $data['username'];
 	echo $data['access_level'];
	$_SESSION['username'] = $data['username'];
	$_SESSION['nama'] = $data['nama'];
	
	// cek level akses
	if($data['access_level']=="Manager"){
		$_SESSION['access_level'] = "Manager";
			header("location:dashboard.php");
			echo("<script>console.log('anda manager , ini log nya');</script>");
	}
	else if($data['access_level']=="Employee"){
		$_SESSION['access_level'] = "Employee";
			header("location:dashboard.php");
			echo("<script>console.log('anda employee , ini log nya');</script>");
	}
	else if($data['access_level']=="HR"){
		$_SESSION['access_level'] = "HR";
			header("location:dashboard.php");
			echo("<script>console.log('anda HR , ini log nya');</script>");
	}
	else if($data['access_level']=="HC"){
		$_SESSION['access_level'] = "HC";
			header("location:dashboard.php");
			echo("<script>console.log('anda HC , ini log nya');</script>");
	}
	else{
		echo("<script>console.log('error di level');</script>");
		header("location:../index.php?pesan=gagal");
	}	
}else{
	echo("<script>console.log('error di cke');</script>");
	header("location:../index.php?pesan=gagal");
}
?>
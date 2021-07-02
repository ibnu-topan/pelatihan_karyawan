<?php require_once('../Connections/connection.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_connection, $connection);
$query_karyawan = "SELECT * FROM karyawan";
$karyawan = mysql_query($query_karyawan, $connection) or die(mysql_error());
$row_karyawan = mysql_fetch_assoc($karyawan);
$totalRows_karyawan = mysql_num_rows($karyawan);

$test = 1;
$query_list = "CALL `list_peserta`($test)";
$list = mysql_query($query_list,$connection) ;
$row_list = mysql_fetch_assoc($list);
$totalRows_list = mysql_num_rows($list);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<table border="1">
  <tr>
    <td>id_karyawan</td>
    <td>nama</td>
    <td>alamat</td>
    <td>tanggal lahir</td>
    <td>unit</td>
    <td>posisi</td>
    <td>username</td>
    <td>password</td>
    <td>access_level</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_karyawan['id_karyawan']; ?></td>
      <td><?php echo $row_karyawan['nama']; ?></td>
      <td><?php echo $row_karyawan['alamat']; ?></td>
      <td><?php echo $row_karyawan['tanggal lahir']; ?></td>
      <td><?php echo $row_karyawan['unit']; ?></td>
      <td><?php echo $row_karyawan['posisi']; ?></td>
      <td><?php echo $row_karyawan['username']; ?></td>
      <td><?php echo $row_karyawan['password']; ?></td>
      <td><?php echo $row_karyawan['access_level']; ?></td>
    </tr>
    <?php } while ($row_karyawan = mysql_fetch_assoc($karyawan)); ?>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table border="1">
  <tr>
  	<td>Pelatihan Ke</td>
    <td>ID karyawan</td>
    <td>Nama</td>
    <td>Nama Training</td>
    <td>Tanggal Training</td>
  </tr>
  <?php do { ?>
    <tr>
    	<td><?php echo $row_list['pelatihan_ke']; ?></td>
      <td><?php echo $row_list['id_karyawan']; ?></td>
      <td><?php echo $row_list['nama']; ?></td>
      <td><?php echo $row_list['nama_training']; ?></td>
      <td><?php echo $row_list['tanggal_training']; ?></td>
    </tr>
    <?php } while ($row_list = mysql_fetch_assoc($list)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($karyawan);
?>

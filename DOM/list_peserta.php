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

$index_peserta_list_peserta = -1;
if (isset($_GET['index_proposal'])) {
  $index_peserta_list_peserta = $_GET['index_proposal'];
}

mysql_select_db($database_connection, $connection);
$query_list_peserta = sprintf("SELECT training_list.pelatihan_ke,     karyawan.id_karyawan,     karyawan.nama,     training_list.nama_training, 	training_list.tanggal_training FROM training_list INNER JOIN karyawan ON karyawan.id_karyawan = training_list.id_karyawan WHERE training_list.pelatihan_ke = %s", GetSQLValueString($index_peserta_list_peserta, "int"));
$list_peserta = mysql_query($query_list_peserta, $connection) or die(mysql_error());
$row_list_peserta = mysql_fetch_assoc($list_peserta);
$totalRows_list_peserta = mysql_num_rows($list_peserta);
?>

<div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Peserta</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="../DOM/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="../DOM/dashboard.php?page=daftar_proposal">Daftar Proposal</a></li>
            <li class="breadcrumb-item active">Daftar Peserta</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Peserta
            </div>
            <div class="card-body">
                <!-- <div class="d-grid gap-2 pb-3">
                    <button class="btn btn-primary block">Tambah Data</button>
                </div> -->
                <table id="datatablesSimple">
                    <thead class="text-center">
                        <tr>
                          <td>ID Peserta</td>
                          <td>Nama Peserta</td>
                          <td>Nama Training</td>
                          <td>Jadwal Training</td>
                          <!-- <td>TOOLS</td> -->
                        </tr>
                    </thead>
                    <tfoot class="text-center">
                        <tr>
                          <td>ID Peserta</td>
                          <td>Nama Peserta</td>
                          <td>Nama Training</td>
                          <td>Jadwal Training</td>
                          <!-- <td>TOOLS</td> -->
                        </tr>
                    </tfoot>
                    <tbody class="text-center">
                          <?php do { ?>
                            <tr>
                              <td><?php echo $row_list_peserta['id_karyawan']; ?></td>
                              <td><?php echo $row_list_peserta['nama']; ?></td>
                              <td><?php echo $row_list_peserta['nama_training']; ?></td>
                              <td><?php echo $row_list_peserta['tanggal_training']; ?></td>
                            </tr>
                          <?php } while ($row_list_peserta = mysql_fetch_assoc($list_peserta)); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
mysql_free_result($list_peserta);
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO training_list (id_pelatihan, pelatihan_ke, id_karyawan, nama_training, tanggal_training, biaya_training) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_pelatihan'], "int"),
                       GetSQLValueString($_POST['pelatihan_ke'], "int"),
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['nama_training'], "text"),
                       GetSQLValueString($_POST['tanggal_training'], "date"),
                       GetSQLValueString($_POST['biaya_training'], "int"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());

  $insertGoTo = "dashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script>window.location='../DOM/dashboard.php?page=daftar_pelatihan';</script>";
}

mysql_select_db($database_connection, $connection);
$query_pelatihan = "SELECT * FROM training_list";
$pelatihan = mysql_query($query_pelatihan, $connection) or die(mysql_error());
$row_pelatihan = mysql_fetch_assoc($pelatihan);
$totalRows_pelatihan = mysql_num_rows($pelatihan);
?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Tambah Data Pelatihan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="../DOM/dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="../DOM/dashboard.php?page=daftar_pelatihan">Daftar Pelatihan</a></li>
    <li class="breadcrumb-item active">Tambah Data Pelatihan</li>
  </ol>

  <div class="border d-flex align-items-center justify-content-center" style="padding : 5%">

  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">

      <div class="row align-items-center">
        <div class="col">

          <div class="mb-3">
            <label for="id_pelatihan" class="form-label">ID Pelatihan</label>
            <input disabled type="int" class="form-control" id="id_pelatihan" name="id_pelatihan" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="pelatihan_ke" class="form-label">Index Pada Proposal</label>
            <input type="int" class="form-control" id="pelatihan_ke" name="pelatihan_ke" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="id_karyawan" class="form-label">ID Karyawan</label>
            <input type="int" class="form-control" id="id_karyawan" name="id_karyawan" aria-describedby=""
              value="" size="32">
          </div>

          </div>
          <div class="col">

          <div class="mb-3">
            <label for="nama_training" class="form-label">nama_training</label>
            <input type="text" class="form-control" id="nama_training" name="nama_training" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="tanggal_training" class="form-label">tanggal_training</label>
            <input type="date" class="form-control" id="tanggal_training" name="tanggal_training" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="biaya_training" class="form-label">biaya_training</label>
            <input type="text" class="form-control" id="biaya_training" name="biaya_training" aria-describedby=""
              value="" size="32">
          </div>

        </div>

        <input class="btn btn-primary" type="submit" value="Tambah Data" />

      </div>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
  </div>
</div>


<?php
mysql_free_result($pelatihan);
?>

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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE karyawan SET nama=%s, alamat=%s, `tanggal lahir`=%s, unit=%s, posisi=%s, username=%s, password=%s, access_level=%s WHERE id_karyawan=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['tanggal_lahir'], "date"),
                       GetSQLValueString($_POST['unit'], "text"),
                       GetSQLValueString($_POST['posisi'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['access_level'], "text"),
                       GetSQLValueString($_POST['id_karyawan'], "int"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($updateSQL, $connection) or die(mysql_error());

  $updateGoTo = "dashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script>window.location='../DOM/dashboard.php?page=daftar_karyawan';</script>";
}

$colname_karyawan = "-1";
if (isset($_GET['id_karyawan'])) {
  $colname_karyawan = $_GET['id_karyawan'];
}
mysql_select_db($database_connection, $connection);
$query_karyawan = sprintf("SELECT * FROM karyawan WHERE id_karyawan = %s", GetSQLValueString($colname_karyawan, "int"));
$karyawan = mysql_query($query_karyawan, $connection) or die(mysql_error());
$row_karyawan = mysql_fetch_assoc($karyawan);
$totalRows_karyawan = mysql_num_rows($karyawan);
?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Edit Data Karyawan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="../DOM/dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="../DOM/dashboard.php?page=daftar_karyawan">Daftar Karyawan</a></li>
    <li class="breadcrumb-item active">Edit Data Karyawan</li>
  </ol>

  <div class="border d-flex align-items-center justify-content-center" style="padding : 5%">

    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">

      <!-- <div class="row  align-items-center">
    <div class="mb-3">
      <label for="id_karyawan" class="form-label">ID Karyawan</label>
      <input type="text" class="form-control" id="id_karyawan" aria-describedby="" value=<?php echo $row_karyawan['id_karyawan'];?> disabled>
    </div>
  </div> -->

      <div class="row  align-items-center">
        <div class="col-6">

          <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" aria-describedby=""
              value="<?php echo htmlentities($row_karyawan['nama'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" aria-describedby=""
              value="<?php echo htmlentities($row_karyawan['alamat'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" aria-describedby=""
              value="<?php echo htmlentities($row_karyawan['tanggal lahir'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" class="form-control" id="unit" name="unit" aria-describedby=""
              value="<?php echo htmlentities($row_karyawan['unit'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

        </div>

        <div class="col-6">

          <div class="mb-3">
            <label for="posisi" class="form-label">Posisi</label>
            <input type="text" class="form-control" id="posisi" name="posisi" aria-describedby=""
              value="<?php echo htmlentities($row_karyawan['posisi'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" aria-describedby=""
              value="<?php echo htmlentities($row_karyawan['username'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" aria-describedby=""
              value="<?php echo htmlentities($row_karyawan['password'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="access_level" class="form-label">Access Level</label>
            <select class="form-select" id="access_level" name="access_level">
              <option selected value=<?php echo $row_karyawan['access_level']; ?> hidden>
                <?php echo $row_karyawan['access_level']; ?></option>
              <option value="HR">HR</option>
              <option value="HC">HC</option>
              <option value="Manager">Manager</option>
              <option value="Employee">Employee</option>
            </select>
            <!-- <input type="text" class="form-control" id="access_level" name="access_level" aria-describedby="" value=<?php echo $row_karyawan['access_level']; ?>> -->
          </div>

        </div>

        <input class="btn btn-primary" type="submit" value="Update Data" />

      </div>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="id_karyawan" value="<?php echo $row_karyawan['id_karyawan']; ?>" />
    </form>
  </div>
</div>

<?php
mysql_free_result($karyawan);
?>
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
  $insertSQL = sprintf("INSERT INTO karyawan (nama, alamat, `tanggal lahir`, unit, posisi, username, password, access_level) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)",
                      //  GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['tanggal_lahir'], "date"),
                       GetSQLValueString($_POST['unit'], "text"),
                       GetSQLValueString($_POST['posisi'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['access_level'], "text"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());

  $insertGoTo = "list_karyawan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script>window.location='../DOM/dashboard.php?page=daftar_karyawan';</script>";
}
?>

<!-- <form method="post" name="form1" action="<?php //echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Nama:</td>
      <td><input type="text" name="nama" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Alamat:</td>
      <td><input type="text" name="alamat" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tanggal lahir:</td>
      <td><input type="text" name="tanggal_lahir" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Unit:</td>
      <td><input type="text" name="unit" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Posisi:</td>
      <td><input type="text" name="posisi" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Username:</td>
      <td><input type="text" name="username" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Password:</td>
      <td><input type="text" name="password" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Access_level:</td>
      <td><input type="text" name="access_level" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form> -->

<div class="container-fluid px-4">
  <h1 class="mt-4">Edit Data Karyawan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="../DOM/dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="../DOM/dashboard.php?page=daftar_karyawan">Daftar Karyawan</a></li>
    <li class="breadcrumb-item active">Edit Data Karyawan</li>
  </ol>

  <div class="border d-flex align-items-center justify-content-center" style="padding : 5%">

  <form method="post" name="form1" action="<?php echo $editFormAction; ?>">

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
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" class="form-control" id="unit" name="unit" aria-describedby=""
              value="" size="32">
          </div>

        </div>

        <div class="col-6">

          <div class="mb-3">
            <label for="posisi" class="form-label">Posisi</label>
            <input type="text" class="form-control" id="posisi" name="posisi" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="access_level" class="form-label">Access Level</label>
            <select class="form-select" id="access_level" name="access_level">
              <option selected hidden>Pilih Level Akses</option>
              <option value="HR">HR</option>
              <option value="HC">HC</option>
              <option value="Manager">Manager</option>
              <option value="Employee">Employee</option>
            </select>
            <!-- <input type="text" class="form-control" id="access_level" name="access_level" aria-describedby="" value=<?php echo $row_karyawan['access_level']; ?>> -->
          </div>

        </div>

        <input class="btn btn-primary" type="submit" value="Tambah Data" />

      </div>
      <input type="hidden" name="MM_insert" value="form1">
    </form>
  </div>
</div>

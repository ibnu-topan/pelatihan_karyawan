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
  $updateSQL = sprintf("UPDATE training_list SET pelatihan_ke=%s, id_karyawan=%s, nama_training=%s, tanggal_training=%s, biaya_training=%s WHERE id_pelatihan=%s",
                       GetSQLValueString($_POST['pelatihan_ke'], "int"),
                       GetSQLValueString($_POST['id_karyawan'], "int"),
                       GetSQLValueString($_POST['nama_training'], "text"),
                       GetSQLValueString($_POST['tanggal_training'], "date"),
                       GetSQLValueString($_POST['biaya_training'], "int"),
                       GetSQLValueString($_POST['id_pelatihan'], "int"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($updateSQL, $connection) or die(mysql_error());

  $updateGoTo = "dashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script>window.location='../DOM/dashboard.php?page=daftar_pelatihan';</script>";
}

$colname_pelatihan = "-1";
if (isset($_GET['id_pelatihan'])) {
  $colname_pelatihan = $_GET['id_pelatihan'];
}
mysql_select_db($database_connection, $connection);
$query_pelatihan = sprintf("SELECT * FROM training_list WHERE id_pelatihan = %s", GetSQLValueString($colname_pelatihan, "int"));
$pelatihan = mysql_query($query_pelatihan, $connection) or die(mysql_error());
$row_pelatihan = mysql_fetch_assoc($pelatihan);
$totalRows_pelatihan = mysql_num_rows($pelatihan);

?>


<div class="container-fluid px-4">
  <h1 class="mt-4">Edit Data Pelatihan</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="../DOM/dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="../DOM/dashboard.php?page=daftar_pelatihan">Daftar Pelatihan</a></li>
    <li class="breadcrumb-item active">Edit Data Pelatihan</li>
  </ol>

  <div class="border d-flex align-items-center justify-content-center" style="padding : 5%">

  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">

      <!-- <div class="row  align-items-center">
    <div class="mb-3">
      <label for="id_karyawan" class="form-label">ID Karyawan</label>
      <input type="text" class="form-control" id="id_karyawan" aria-describedby="" value=<?php echo $row_karyawan['id_karyawan'];?> disabled>
    </div>
  </div> -->

      <div class="row align-items-center">
        <div class="col">

          <div class="mb-3">
            <label for="id_pelatihan" class="form-label">ID Pelatihan</label>
            <input disabled type="int" class="form-control" id="id_pelatihan" name="id_pelatihan" aria-describedby=""
              value="<?php echo htmlentities($row_pelatihan['id_pelatihan'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="pelatihan_ke" class="form-label">Index Pada Proposal</label>
            <input type="int" class="form-control" id="pelatihan_ke" name="pelatihan_ke" aria-describedby=""
              value="<?php echo htmlentities($row_pelatihan['pelatihan_ke'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="id_karyawan" class="form-label">ID Karyawan</label>
            <input type="int" class="form-control" id="id_karyawan" name="id_karyawan" aria-describedby=""
              value="<?php echo htmlentities($row_pelatihan['id_karyawan'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          </div>
          <div class="col">

          <div class="mb-3">
            <label for="nama_training" class="form-label">nama_training</label>
            <input type="text" class="form-control" id="nama_training" name="nama_training" aria-describedby=""
              value="<?php echo htmlentities($row_pelatihan['nama_training'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="tanggal_training" class="form-label">tanggal_training</label>
            <input type="date" class="form-control" id="tanggal_training" name="tanggal_training" aria-describedby=""
              value="<?php echo htmlentities($row_pelatihan['tanggal_training'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="biaya_training" class="form-label">biaya_training</label>
            <input type="text" class="form-control" id="biaya_training" name="biaya_training" aria-describedby=""
              value="<?php echo htmlentities($row_pelatihan['biaya_training'], ENT_COMPAT, 'utf-8'); ?>" size="32">
          </div>

        </div>

        <input class="btn btn-primary" type="submit" value="Update Data" />

      </div>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="id_pelatihan" value="<?php echo $row_pelatihan['id_pelatihan']; ?>" />
    </form>
  </div>
</div>

<!-- ini -->

<!-- 
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_pelatihan:</td>
      <td><?php //echo $row_pelatihan['id_pelatihan']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Pelatihan_ke:</td>
      <td><input type="text" name="pelatihan_ke" value="<?php //echo htmlentities($row_pelatihan['pelatihan_ke'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_karyawan:</td>
      <td><input type="text" name="id_karyawan" value="<?php //echo htmlentities($row_pelatihan['id_karyawan'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama_training:</td>
      <td><input type="text" name="nama_training" value="<?php //echo htmlentities($row_pelatihan['nama_training'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tanggal_training:</td>
      <td><input type="text" name="tanggal_training" value="<?php //echo htmlentities($row_pelatihan['tanggal_training'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Biaya_training:</td>
      <td><input type="text" name="biaya_training" value="<?php //echo htmlentities($row_pelatihan['biaya_training'], ENT_COMPAT, ''); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_pelatihan" value="<?php echo $row_pelatihan['id_pelatihan']; ?>" />
 -->

  <?php
mysql_free_result($pelatihan);
?>
</form>
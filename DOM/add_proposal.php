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

$todayDate =  date("m/d/Y"); 

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO proposal (id_proposal, tanggal_dikirim, pelatihan_ke, approvedby_HRD, approvedby_HC) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_proposal'], "int"),
                       GetSQLValueString($_POST['tanggal_dikirim'],  "date"),
                       GetSQLValueString($_POST['pelatihan_ke'], "int"),
                       GetSQLValueString($_POST['approvedby_HRD'], "text"),
                       GetSQLValueString($_POST['approvedby_HC'], "text"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());

  $insertGoTo = "dashboard.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo "<script>window.location='../DOM/dashboard.php?page=daftar_proposal';</script>";
}

mysql_select_db($database_connection, $connection);
$query_proposal = "SELECT * FROM proposal";
$proposal = mysql_query($query_proposal, $connection) or die(mysql_error());
$row_proposal = mysql_fetch_assoc($proposal);
$totalRows_proposal = mysql_num_rows($proposal);
?>

<div class="container-fluid px-4">
  <h1 class="mt-4">Tambah Data Proposal</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="../DOM/dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="../DOM/dashboard.php?page=daftar_Proposal">Daftar Proposal</a></li>
    <li class="breadcrumb-item active">Tambah Data Proposal</li>
  </ol>

  <div class="border d-flex align-items-center justify-content-center" style="padding : 5%">

  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">

      <div class="row align-items-center">
        <div class="col">

          <div class="mb-3">
            <label for="id_proposal" class="form-label">id_proposal</label>
            <input disabled type="int" class="form-control" id="id_proposal" name="id_proposal" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3">
            <label for="tanggal_dikirim" class="form-label">tanggal_dikirim</label>
            <input type="date" class="form-control" id="tanggal_dikirim" name="tanggal_dikirim" aria-describedby=""
              value="<?php echo date('Y-m-d'); ?>" size="32">
          </div>

          <div class="mb-3">
            <label for="pelatihan_ke" class="form-label">pelatihan_ke</label>
            <input type="int" class="form-control" id="pelatihan_ke" name="pelatihan_ke" aria-describedby=""
              value="" size="32">
          </div>

          <div class="mb-3" hidden>
            <label for="approvedby_HRD" class="form-label">approvedby_HRD</label>
            <input  type="text" class="form-control" id="approvedby_HRD" name="approvedby_HRD" aria-describedby=""
              value="On Review" size="32">
          </div>

          <div class="mb-3" hidden>
            <label for="approvedby_HC" class="form-label">approvedby_HC</label>
            <input type="text" class="form-control" id="approvedby_HC" name="approvedby_HC" aria-describedby=""
              value="On Review" size="32">
          </div>

        </div>

        <input class="btn btn-primary" type="submit" value="Tambah Data" />

      </div>
      <input type="hidden" name="MM_insert" value="form1" />
    </form>
  </div>
</div>

<?php
mysql_free_result($proposal);
?>

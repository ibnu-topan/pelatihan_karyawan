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
$query_recordset_karyawan = "SELECT * FROM karyawan";
$recordset_karyawan = mysql_query($query_recordset_karyawan, $connection) or die(mysql_error());
$row_recordset_karyawan = mysql_fetch_assoc($recordset_karyawan);
$totalRows_recordset_karyawan = mysql_num_rows($recordset_karyawan);

if ($_SESSION['access_level'] == "Manager"){
    $ActionButton = "hidden";
}
else if ($_SESSION['access_level'] == "HR"){
    $ActionButton = "";
}
else if ($_SESSION['access_level'] == "HC"){
    $ActionButton = "hidden";
}
else if ($_SESSION['access_level'] == "Employee"){
    $ActionButton = "hidden";
}

?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Daftar Karyawan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="../DOM/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Daftar Karyawan</li>
        </ol>
        <!-- <div class="card mb-4">
            <div class="card-body">
                DataTables is a third party plugin that is used to generate the demo table below. For more information
                about DataTables, please visit the
                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                .
            </div>
        </div> -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Karyawan
            </div>
            <div class="card-body">
                <!-- <div class="d-grid gap-2 pb-3">
                    <button class="btn btn-primary block">Tambah Data</button>
                </div> -->
                <table id="datatablesSimple">
                    <thead class="text-center">
                        <tr>
                            <td>ID</td>
                            <td>Nama</td>
                            <td>Alamat</td>
                            <td>Tanggal Lahir</td>
                            <td>Unit</td>
                            <td>Posisi</td>
                            <td>Username</td>
                            <!-- <td>Password</td> -->
                            <td>Access Level</td>
                            <td <?php echo $ActionButton?> >Actions</td>
                        </tr>
                    </thead>
                    <tfoot class="text-center">
                        <tr>
                            <td>ID</td>
                            <td>Nama</td>
                            <td>Alamat</td>
                            <td>Tanggal Lahir</td>
                            <td>Unit</td>
                            <td>Posisi</td>
                            <td>Username</td>
                            <!-- <td>Password</td> -->
                            <td>Access Level</td>
                            <td <?php echo $ActionButton?> >Actions</td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php do { ?>
                        <tr>
                            <td class="text-center"><?php echo $row_recordset_karyawan['id_karyawan']; ?></td>
                            <td><?php echo $row_recordset_karyawan['nama']; ?></td>
                            <td><?php echo $row_recordset_karyawan['alamat']; ?></td>
                            <td><?php echo $row_recordset_karyawan['tanggal lahir']; ?></td>
                            <td><?php echo $row_recordset_karyawan['unit']; ?></td>
                            <td><?php echo $row_recordset_karyawan['posisi']; ?></td>
                            <td><?php echo $row_recordset_karyawan['username']; ?></td>
                            <!-- <td><?php //echo $row_recordset_karyawan['password']; ?></td> -->
                            <td><?php echo $row_recordset_karyawan['access_level']; ?></td>
                            <td class="text-center" <?php echo $ActionButton?>>
                                <a class="btn btn-primary m-1" href="../DOM/dashboard.php?page=edit_karyawan&id_karyawan=<?php echo $row_recordset_karyawan['id_karyawan']; ?>">Edit</a>
                                <a class="btn btn-danger m-1" href="../DOM/delete_karyawan.php?id_karyawan=<?php echo $row_recordset_karyawan['id_karyawan']; ?>">Delete</a>
                            </td>
                        </tr>
                        <?php } while ($row_recordset_karyawan = mysql_fetch_assoc($recordset_karyawan)); ?>
                    </tbody>
                </table>
                <div class="d-grid gap-2 pt-3">
                    <a <?php echo $ActionButton?> class="btn btn-primary block" href="../DOM/dashboard.php?page=tambah_karyawan">Tambah Data</a>
                </div>
            </div>
        </div>
    </div>

<?php
mysql_free_result($recordset_karyawan);
?>
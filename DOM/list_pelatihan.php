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

$maxRows_List = 10;
$pageNum_List = 0;
if (isset($_GET['pageNum_List'])) {
  $pageNum_List = $_GET['pageNum_List'];
}
$startRow_List = $pageNum_List * $maxRows_List;

$index_pelatihan_List = "";
mysql_select_db($database_connection, $connection);
// $query_List = sprintf("SELECT * FROM training_list where pelatihan_ke = %s", GetSQLValueString($index_pelatihan_List, "int"));
$query_List = sprintf("SELECT * FROM training_list");
$query_limit_List = sprintf("%s LIMIT %d, %d", $query_List, $startRow_List, $maxRows_List);
$List = mysql_query($query_limit_List, $connection) or die(mysql_error());
$row_List = mysql_fetch_assoc($List);

if (isset($_GET['totalRows_List'])) {
  $totalRows_List = $_GET['totalRows_List'];
} else {
  $all_List = mysql_query($query_List);
  $totalRows_List = mysql_num_rows($all_List);
}
$totalPages_List = ceil($totalRows_List/$maxRows_List)-1;


if ($_SESSION['access_level'] == "Manager"){
    $ActionButton = "";
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
        <h1 class="mt-4">Daftar Pelatihan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="../DOM/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Daftar Pelatihan</li>
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
                Daftar Pelatihan
            </div>
            <div class="card-body">
                <!-- <div class="d-grid gap-2 pb-3">
                    <button class="btn btn-primary block">Tambah Data</button>
                </div> -->
                <table id="datatablesSimple">
                    <thead class="text-center">
                        <tr>
                            <td>ID Pelatihan</td>
                            <td>Index Proposal</td>
                            <!-- <td>id_karyawan</td> -->
                            <td>Nama Pelatihan</td>
                            <td>Waktu Pelatihan</td>
                            <td>Biaya / Peserta (Rupiah)</td>
                            <td <?php echo $ActionButton?> >Actions</td>
                        </tr>
                    </thead>
                    <tfoot class="text-center">
                        <tr>
                            <td>ID Pelatihan</td>
                            <td>Index Proposal</td>
                            <!-- <td>id_karyawan</td> -->
                            <td>Nama Pelatihan</td>
                            <td>Waktu Pelatihan</td>
                            <td>Biaya / Peserta (Rupiah)</td>
                            <td <?php echo $ActionButton?> >Actions</td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 

                        function rupiah($angka){
	
                            $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                            return $hasil_rupiah;
                         
                        }
                        do { ?>
                            <tr>
                                <td class="text-center"><?php echo $row_List['id_pelatihan']; ?></td>
                                <td class="text-center"><?php echo $row_List['pelatihan_ke']; ?></td>
                                <!-- <td><?php //echo $row_List['id_karyawan']; ?></td> -->
                                <td><?php echo $row_List['nama_training']; ?></td>
                                <td class="text-center"><?php echo $row_List['tanggal_training']; ?></td>
                                <td class="text-end"><?php echo rupiah($row_List['biaya_training']); ?>,-</td>
                                <td class="text-center" <?php echo $ActionButton?> >
                                    <a class="btn btn-primary m-1" href="../DOM/dashboard.php?page=edit_pelatihan&id_pelatihan=<?php echo $row_List['id_pelatihan']; ?>">Edit</a>
                                    <a class="btn btn-danger m-1" href="../DOM/delete_pelatihan.php?id_pelatihan=<?php echo $row_List['id_pelatihan']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php } while ($row_List = mysql_fetch_assoc($List)); ?>
                    </tbody>
                </table>
                <div class="d-grid gap-2 pt-3">
                    <a <?php echo $ActionButton?> class="btn btn-primary block" href="../DOM/Dashboard.php?page=tambah_pelatihan" >Tambah Data</a>
                </div>
            </div>
        </div>
    </div>

<?php
mysql_free_result($List);
?>
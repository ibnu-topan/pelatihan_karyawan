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

$maxRows_Detail_Proposal = 10;
$pageNum_Detail_Proposal = 0;
if (isset($_GET['pageNum_Detail_Proposal'])) {
  $pageNum_Detail_Proposal = $_GET['pageNum_Detail_Proposal'];
}
$startRow_Detail_Proposal = $pageNum_Detail_Proposal * $maxRows_Detail_Proposal;

$index_proposal_Detail_Proposal = $_GET['index_proposal'];
mysql_select_db($database_connection, $connection);
$query_Detail_Proposal = sprintf("SELECT 	proposal.id_proposal,     proposal.tanggal_dikirim,     proposal.pelatihan_ke,     sum(training_list.biaya_training) as total_biaya,     proposal.approvedby_HRD,     proposal.approvedby_HC from 	proposal INNER JOIN training_list ON proposal.pelatihan_ke = training_list.pelatihan_ke WHERE 	proposal.pelatihan_ke = %s", GetSQLValueString($index_proposal_Detail_Proposal, "int"));
$query_limit_Detail_Proposal = sprintf("%s LIMIT %d, %d", $query_Detail_Proposal, $startRow_Detail_Proposal, $maxRows_Detail_Proposal);
$Detail_Proposal = mysql_query($query_limit_Detail_Proposal, $connection) or die(mysql_error());
$row_Detail_Proposal = mysql_fetch_assoc($Detail_Proposal);

if (isset($_GET['totalRows_Detail_Proposal'])) {
  $totalRows_Detail_Proposal = $_GET['totalRows_Detail_Proposal'];
} else {
  $all_Detail_Proposal = mysql_query($query_Detail_Proposal);
  $totalRows_Detail_Proposal = mysql_num_rows($all_Detail_Proposal);
}
$totalPages_Detail_Proposal = ceil($totalRows_Detail_Proposal/$maxRows_Detail_Proposal)-1;
?>

<div class="container-fluid px-4">
        <h1 class="mt-4">Detail Proposal</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="../DOM/dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="../DOM/dashboard.php?page=daftar_proposal">Daftar Proposal</a></li>
            <li class="breadcrumb-item active">Detail Proposal</li>
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
                        <td>ID Proposal</td>
                        <td>Tanggal Diajukan</td>
                        <td>Termin</td>
                        <td>Total Biaya</td>
                        <td>Status at HRD</td>
                        <td>Status at HC</td>
                      </tr>
                    </thead>
                    <tfoot class="text-center">
                      <tr>
                        <td>ID Proposal</td>
                        <td>Tanggal Diajukan</td>
                        <td>Termin</td>
                        <td>Total Biaya</td>
                        <td>Status at HRD</td>
                        <td>Status at HC</td>
                      </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                        function rupiah($angka){
	
                            $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
                            return $hasil_rupiah;
                         
                        }
                        do { ?>
                            <tr class="text-center">
                                <td><?php echo $row_Detail_Proposal['id_proposal']; ?></td>
                                <td><?php echo $row_Detail_Proposal['tanggal_dikirim']; ?></td>
                                <td><?php echo $row_Detail_Proposal['pelatihan_ke']; ?></td>
                                <td class="text-end"><?php echo rupiah($row_Detail_Proposal['total_biaya']); ?></td>
                                <td><?php echo $row_Detail_Proposal['approvedby_HRD']; ?></td>
                                <td><?php echo $row_Detail_Proposal['approvedby_HC']; ?></td>
                                </td>
                            </tr>
                        <?php } while ($row_List = mysql_fetch_assoc($Detail_Proposal)); ?>
                    </tbody>
                </table>
                <div class="d-grid gap-2 pt-3">
                    <button class="btn btn-primary block">Tambah Data</button>
                </div>
            </div>
        </div>
    </div>

<?php
mysql_free_result($Detail_Proposal);
?>

<?php 
	session_start();
	if(isset($_GET['pesan'])){
		if($_GET['pesan']=="limited"){
			echo "<script> alert('Anda tidak berhak akses');</script>";
		}
	}
    
	if($_SESSION['access_level']==""){
		header("location:../index.php?pesan=notloggin");
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Pelatihan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous">
    </script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="../DOM/dashboard.php">Sistem Pelatihan</a>

        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>

        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group" hidden>
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                    aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                        class="fas fa-search"></i></button>
            </div>
        </form>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <a class="btn btn-danger" href="../DOM/logoutDOM.php">Logout</a>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="../DOM/dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Data Tables</div>
                        <a class="nav-link" href="../DOM/dashboard.php?page=daftar_karyawan">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                           Daftar Karyawan
                        </a>
                        <a class="nav-link" href="../DOM/dashboard.php?page=daftar_pelatihan">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                           Daftar Pelatihan 
                        </a>
                        <a class="nav-link" href="../DOM/dashboard.php?page=daftar_proposal">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                           Daftar Proposal 
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION['nama']; ?> (<?php echo $_SESSION['access_level']; ?>)
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
				<?php
                    $access = $_SESSION['access_level'];

					if(isset($_GET['page'])){
						$page = $_GET['page'];

							switch ($page) {

                                case 'daftar_karyawan'  : 
                                    if ($access == "Employee"){
                                        echo "<script> alert('Anda tidak berhak buka halaman tersebut');</script>";
                                    }
                                    else{
                                       include "../DOM/list_karyawan.php"; 
                                    }
                                    break;
                                    
								case 'edit_karyawan' : include '../DOM/edit_karyawan.php';
                                    break;

                                case 'edit_pelatihan' : include '../DOM/edit_pelatihan.php';
                                    break;

                                case 'tambah_karyawan' : include '../DOM/add_karyawan.php';
                                    break;
                                
                                case 'tambah_pelatihan' : include '../DOM/add_pelatihan.php';
                                    break;

                                case 'tambah_proposal' : include '../DOM/add_proposal.php';
                                    break;

                                case 'daftar_pelatihan' : include '../DOM/list_pelatihan.php';
                                    break;

                                case 'daftar_peserta' : include '../DOM/list_peserta.php';
                                    break;

                                case 'daftar_proposal' : include '../DOM/list_proposal.php';
                                    break;
                                    
                                case 'detail_proposal' : include '../DOM/detail_proposal.php';
                                    break;

								default :
									echo "masuk ke else else gaiiss";
								break;
							}
						} 
						else{
							include "../DOM/main_page.php";
						}
				?>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Sistem Pelatihan 2021</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>
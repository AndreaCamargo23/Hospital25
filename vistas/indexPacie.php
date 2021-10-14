
<?php 
    session_start();
    if($_SESSION['user']==null){
        header('Location:../login.php');
    }
    
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="./img/hospital.ico" rel="icon" type="ico">
    <title>Principal</title>

    <!-- Custom fonts for this template -->
    <link href="../librerias/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">
	
	<!--Bootstrap a nivel local-->
    <link rel="stylesheet" href="../librerias/bootstrap/css/bootstrap.min.css">
   
    <!-- Custom styles for this page -->
    <link href="../librerias/Datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet">
	<!--ICONOS-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
    <link href="../librerias/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<!--Notificaciones-->
	<link rel="stylesheet" href="../librerias/swa2/dist/sweetalert2.min.css">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
			

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
					<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
						<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
							<div class="sidebar-brand-icon rotate-n-0">
								<i class="fas fa-hospital-user"></i>
							</div>
							<div class="sidebar-brand-text mx-3">Hospital</div>
						</a>
					</form>
                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar de buscar -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Buscar..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">1+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['user']; ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Salir
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
				<div class="row">
					<div class="">
                            <div class="card shadow mb-2">
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 15rem;" src="img/undraw_welcome_cats_thqn.svg" alt="...">
									</div>
                                </div>
                            </div>
                    </div>
						
                </div>
                <!-- Begin Page Content -->
                <div class="container-fluid">
					<div class="row">
							<!-- Content Column -->
							<div class="col-lg-6 mb-4">
								<!-- Color System -->
								<div class="row">
								<br>
									<div class="col-lg-6 mb-4">
										<div class="card bg-primary text-white shadow">
											<div class="card-body">
											 <i class="fas fa-download text-white"></i>
												<a href="#">Ver Historia clinica</a>
												<div class="text-white-50 small">Obtenga su historia clinica</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 mb-4">
										<div class="card bg-success text-white shadow">
											<div class="card-body">
											<i class="fas fa-file text-white"></i>
												Generar Factura
												<div class="text-white-50 small">Factura de servicios</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 mb-4">
										<div class="card bg-info text-white shadow">
											<div class="card-body">
												Ver historia clinica
												<div class="text-white-50 small">#36b9cc</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6 mb-4">
										<div class="card bg-warning text-white shadow">
											<div class="card-body">
												Eliminar usuario
												<div class="text-white-50 small">El usuario quedara bloqueado, a menos que el administrador lo desbloquee</div>
											</div>
										</div>
									</div>									
								</div>
							</div>
							<div class="col-lg-6 mb-4">
								<div class="card shadow mb-4">
									<div class="card-body">
										<div class="text-center">
											<img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_attached.svg" alt="...">
										</div>
									</div>
								</div>
							</div>
					</div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quiere salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Seleccione "Salir" si desea cerrar sesion.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../baseDatos/logout.php">Salir</a>
                </div>
            </div>
        </div>
    </div>
    <!--modal historia-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"></div>
                      <!--FORMULARIO DE INSCRIPCION DE ALUMNOS-->
        <form id="formIngreso">      
            <div class="modal-body">
            <div class="row">            
                
                <div class="col-lg-6">
                  <div class="form-group">
                      <label class="col-form-label">Fecha de Nacimiento</label>
                      <input type="date" class="form-control" id="starDate" disabled="true">
                  </div> 
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-form-label">Paciente</label>
                    <input type="text" class="form-control" id="starDate" disabled="true">
                  </div> 
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                      <label class="col-form-label" id="passwd1">Descripción</label> 
					  <textarea name="textarea" rows="3" class="form-control" cols="30" id="descripcion" placeholder="Ingrese la descripcion" disabled="true"></textarea>
                  </div> 
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-form-label">Id Ingreso</label>
                    <input type="number" class="form-control" id="starDate" disabled="true">
                  </div> 
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                      <label class="col-form-label">Fecha Ingreso</label>
                      <input type="date" class="form-control" id="starDate" disabled="true">
                  </div> 
                </div>
                <div class="col-lg-3">
                  <div class="form-group">
                    <label class="col-form-label">Habitacion</label>
                    <input type="number" class="form-control" id="starDate" disabled="true">
                  </div> 
                </div>
				<div class="col-lg-3">
                  <div class="form-group">
                    <label class="col-form-label">Cama</label>
                    <input type="number" class="form-control" id="starDate" disabled="true">
                  </div> 
                </div>
					<div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-form-label">Servicio Principal</label>
                    <input type="text" class="form-control" id="starDate" disabled="true">
                  </div> 
                </div>
				<div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-form-label">Empleado que atiende</label>
                    <input type="text" class="form-control" id="starDate" disabled="true">
                  </div> 
                </div>					
            </div>
            </div>
        
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<button type="submit" id="btnGuardar" class="btn btn-primary">Crear Ingreso</button>
			</div>
        </form>

    
                    <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <!-- Bootstrap core JavaScript-->
    <script src="../librerias/jquery/jquery.min.js"></script>
    <script src="../librerias/bootstrap/js/bootstrap.bundle.min.js"></script>    

    <!-- Core plugin JavaScript-->
    <script src="../librerias/jquery/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
	<script src="../librerias/DataTables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../librerias/DataTables/js/dataTables.bootstrap4.min.js"></script> 
    <script type="text/javascript" src="../librerias/DataTables/datatables.min.js"></script>  

    <!-- main del java scrip -->
    <script src="./js/funcion.js"></script>
	<!--Notificaciones-->
	<script src="../librerias/swa2/dist/sweetalert2.min.js"></script>
	
	<!-- Page level plugins -->
    <script src="./js/Chart.min.js"></script>
    <script src="./js/data-pacientes.js"></script>

    <!-- Page level custom scripts -->
    <script src="./js/demo/chart-area-demo.js"></script>
    <script src="./js/demo/chart-pie-demo.js"></script>

</body>

</html>
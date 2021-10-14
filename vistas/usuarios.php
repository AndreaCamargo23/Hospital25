<?php
function codigo(){
	return $codigo=rand();
}

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
    <title>Usuarios Hospital</title>

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

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-0">
                    <i class="fas fa-hospital-user"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Hospital</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="indexAdmi.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Principal</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Administracion
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-users-cog"></i>
                    <span>Usuarios</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Agregar:</h6>
                        <?php 
                            if($_SESSION['rol']==1){                            
                        ?>
                        <a class="collapse-item" href="usuarios.php">Usuario</a>
                        <a class="collapse-item" href="empleado.php">Empleado</a>
                        <a class="collapse-item" href="paciente.php">Paciente</a>
                        <?php }else{

                        ?>
                        <a class="collapse-item" href="paciente.php">Paciente</a><?php }?>
                    </div>
                </div>
            </li>
			<li class="nav-item">
                <a class="nav-link" href="servicios.php">
                    <i class="fas fa-fw fa-stethoscope"></i>
                    <span>Servicios</span></a>
            </li>
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="facturas.php">
                    <i class="fas fa-fw fa-file-invoice-dollar"></i>
                    <span>Facturas</span></a>
            </li>
			<!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="ingreso.php">
                    <i class="fas fa-fw fa-book-medical"></i>
                    <span>Ingreso</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="camas.php">
                    <i class="fas fa-fw fa-procedures"></i>
                    <span>Camas</span></a>
            </li>
			<li class="nav-item">
                <a class="nav-link" href="habitacion.php">
                    <i class="fas fa-fw fa-hospital"></i>
                    <span>Habitacion</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
			<div class="sidebar-heading">
                Gestion
            </div>
			<li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInformes" aria-expanded="true" aria-controls="collapseInformes">
                    <i class="fas fa-fw fa-info-circle"></i>
                    <span>Informes</span>
                </a>
                <div id="collapseInformes" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestionar:</h6>
                        <a class="collapse-item" href="infoCamas.php">Camas</a>
                        <a class="collapse-item" href="infoFact.php">Facturacion</a>
                        <a class="collapse-item" href="infoServicio.php">Servicios</a>
                    </div>
                </div>
            </li>
			<hr class="sidebar-divider d-none d-md-block">

            <!-- Divider 
            <hr class="sidebar-divider">-->

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Configuracion</span>
                </a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

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
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['user'];?></span>
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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Usuarios</h1>
                    <p class="mb-4">En el siguiente apartado se muestran todos los usuarios creados, agregar un nuevo usuario; o editar los usuarios ya creados</p>
                
                    <!--boton para agregar registro-->
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" id="btnAgregar" class="btn btn-info" data-toggle="modalAgregar">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-user-plus"></i>
                                        </span>
                                        <span class="text">Agregar Usuario</span>                                    
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-8">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Consulta Usuarios</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                   <table id="tablaUsuarios" class="table table-bordered">
									  <thead class="text-center"> 
										<tr>
										  <th>ID</th>
										  <th>USUARIO</th>
										  <th>EMAIL</th>
										  <th>ROL</th>
										  <th>ESTADO</th>
										  <th>ACCIONES</th>
										</tr>
									  </thead>
									  <tfoot class="text-center">
									  <tr>
										  <th>ID</th>
										  <th>USUARIO</th>
										  <th>EMAIL</th>
										  <th>ROL</th>
										  <th>ESTADO</th>
										  <th>ACCIONES</th>
										</tr>
									  </tfoot>
									  <tbody>
										<tr>
										</tr>
									  </tbody>
								</table>
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
                        <span>Copyright &copy; Your Website 2020</span>
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

    <!-- Modal Salir-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
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
    <!-- Modal Agregar usuario-->

 <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuario" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUsuario"></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
        </button>
      </div>
      <!--FORMULARIO DE INSCRIPCION DE ALUMNOS-->
        <form id="formUsuario">      
            <div class="modal-body">
            <div class="row">            
                <div class="col-lg-6">
                  <div class="form-group">
                      <label class="col-form-label">Email</label>
                      <input type="email" class="form-control" placeholder="ejemplo@gmail.com" id="email" required>
                  </div> 
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                      <label class="col-form-label" id="passwd1">Contraseña</label>
                      <input type="password" class="form-control" placeholder="" maxlength="40" minlength="8" id="passwd" required>
                  </div> 
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                      <label class="col-form-label">Nombre de Usuario</label>
                      <input type="text" class="form-control" placeholder="" id="nomUsua" pattern="[A-Za-z0-9]+" title="Solo seleccione letras y números, no se aceptan caracteres especiales" maxlength="50" minlength="10" required>
                  </div> 
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-form-label">Rol</label>
                      <select class="form-select" id="rol" aria-label="Default select example">
                        <option selected>Seleccione una opción</option>
                        <option value="1">Administrador</option>
                        <option value="2">Empleado</option>
                        <option value="3">Paciente</option>
                      </select>
                  </div> 
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label class="col-form-label">Estado</label>
                      <select class="form-select" id="estado" aria-label="Default select example">
                        <option selected>Seleccione una opción</option>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                        <option value="3">Bloqueado</option>
                      </select>
                  </div> 
                </div>
				<div class="col-lg-6">
                  <div class="form-group">                    
						<div id="" class="ax_default heading_3" data-label="codigo">
						  <div></div>
						  <div>
						  <?php $codigo=codigo();?>
							<label class="col-form-label" style="font-weight: bold;">Codigo de recuperación</label>
							 <input type="text" class="form-control" value='<?php echo rand()?>' id="codigo" disabled="true" required>
						  </div>
						</div>
                  </div> 
                </div>
				
            </div>
            </div>
        
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button type="submit" id="btnGuardar" class="btn btn-primary">Crear Usuario</button>
        </div>
        </form>
      </div>
    </div>
  </div>

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
	<script src="./js/data-usuarios.js"></script>
    <!--Notificaciones-->
	<script src="../librerias/swa2/dist/sweetalert2.min.js"></script>

</body>

</html>
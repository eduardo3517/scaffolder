
	
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="generator" content="Mobirise v4.9.6, mobirise.com">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="shortcut icon" href="assets/images/summanuevo-116x100.png" type="image/x-icon">
	<meta name="description" content="">
	
	<title>Scaffolder2</title>
	<link rel="stylesheet" href="../assets/web/assets/mobirise-icons/mobirise-icons.css">
	<link rel="stylesheet" href="../assets/tether/tether.min.css">
	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap-reboot.min.css">
	<link rel="stylesheet" href="../assets/socicon/css/styles.css">
	<link rel="stylesheet" href="../assets/dropdown/css/style.css">
	<link rel="stylesheet" href="../assets/theme/css/style.css">
	<link rel="stylesheet" href="../assets/mobirise/css/mbr-additional.css?v=2" >
	<link rel="stylesheet" href="../assets/fonts/stylesheet.css">
	<link rel="stylesheet" href="../assets/css/propio.css">
	<link rel="stylesheet" href="../assets/datatable/css/addons/datatables.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined">

</head>
<body>
	<section class="menu cid-rxW6zLzRKl" once="menu" id="menu1-2">

	<nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm">
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<div class="hamburger">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>
		</button>
		<div class="menu-logo">
			<div class="navbar-brand">
				<span class="navbar-logo">
					<img src="../assets/images/icono.png" alt="Mobirise" title="" style="height: 3.8rem;">
				</span>
				<span class="navbar-caption-wrap">
					<a class="navbar-caption text-white display-4" >
						Scaffolder2<br>
					</a>
				</span>
			</div>
		</div>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav nav-dropdown nav-right" data-app-modern-menu="true">
				
			<?php 
			if(isset($UsuarioLogueado)){

				echo '
				<li class="nav-item dropdown open"> 
					<a class="nav-link link text-white dropdown-toggle display-4" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
						<span class="mobi-mbri mobi-mbri-add-submenu mbr-iconfont mbr-iconfont-btn"></span>
						Menú
					</a>
					<div class="dropdown-menu">
					
					
						
								<a class="text-white dropdown-item display-4" href="../ct/ProyectoController.php">
									Proyecto
								</a>
								<a class="text-white dropdown-item display-4" href="../ct/TipoCampoController.php">
									Tipos de Campos
								</a>
			
							
			
							</div>
						</li>';

					if($UsuarioLogueado->getTipoUsuario()==1){
						echo '
						<li class="nav-item dropdown "> 
							<a class="nav-link link text-white dropdown-toggle display-4" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
								<span class="mobi-mbri mobi-mbri-lock mbr-iconfont mbr-iconfont-btn"></span>
								Seguridad
							</a>
							<div class="dropdown-menu">
								<a class="text-white dropdown-item display-4" href="../ct/UsuarioController.php">
									Usuarios
								</a>
								<a class="text-white dropdown-item display-4" href="../ct/TipoUsuarioController.php">
									Tipos de Usuarios
								</a>
								<a class="text-white dropdown-item display-4" href="../ct/SeguridadController.php">
									Definición de permisos
								</a>
								<a class="text-white dropdown-item display-4" href="../ct/EntidadSeguridadController.php">
									Pantallas
								</a>
								<a class="text-white dropdown-item display-4" href="../ct/AccionSeguridadController.php">
									Acciones de seguridad
								</a>
							</div>
						</li>';
					}

					echo '
						<li class="nav-item dropdown open"> 
							<a class="nav-link link text-white dropdown-toggle display-4" href="#"  data-toggle="dropdown-submenu"  aria-expanded="true">
								<span class="mbri-user mbr-iconfont mbr-iconfont-btn"></span>'
								.$UsuarioLogueado->getNombre().'
							</a>
							<div class="dropdown-menu">
								<a class="text-white dropdown-item display-4" href="#" onclick="accionModal(\''.$UsuarioLogueado->getId().'\', \'u\', \'Usuario\')" data-toggle="modal" data-target="#modal">
									Mi perfil
								</a>
								<a class="text-white dropdown-item display-4"  onclick="accionModal(\'\', \'cs\', \'Access\')" aria-expanded="false">
									Cerrar Sesión
								</a>
							</div>
						</li>
					';
					
					
					
				} else {
					echo '
					<li class="nav-item">
						<a class="nav-link link text-white display-4" href="user.php">
							<span class="mbri-user mbr-iconfont mbr-iconfont-btn"></span>
							Login
						</a>
					</li>';
				} 
				?>
			</ul>
		</div>
	</nav>
</section>

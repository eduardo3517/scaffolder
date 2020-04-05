<?php

	function agregar_zip($dir, $zip) {
		if (is_dir($dir)) {
			if ($da = opendir($dir)) {
				while (($archivo = readdir($da)) !== false) {

					if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
						echo "<strong>Creando directorio: $dir$archivo</strong><br/>";
						agregar_zip($dir . $archivo . "/", $zip);

					} elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
						echo "Agregando archivo: $dir$archivo <br/>";
						$zip->addFile($dir . $archivo, $dir . $archivo);
					}
				}
				closedir($da);
			}
		}
	}

	session_start();
	$id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
    if ( null==$id ) {
        header("Location: index.php");
    }
    include 'database.php';
    $pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM Proyecto WHERE ID = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	$ProyectoId = $data['id'];
	$NombreProyecto = $data['Nombre'];
	$servidor = $data['NombreServidor'];
	$baseDatos = $data['NombreBaseDatos'];
	$usuario = $data['UsuarioBaseDatos'];
	$contrasena = $data['ContrasenaBaseDatos'];
	Database::disconnect();
	
	$carpetaScaffoldUser = "Generacion/".$_SESSION['USUARIO'].$ProyectoId;
	


	/*Generación de la estructura del proyecto*/
	@mkdir( $carpetaScaffoldUser );
	
	function full_copy( $source, $target ) {
		if ( is_dir( $source ) ) {
			@mkdir( $target );
			$d = dir( $source );
			while ( FALSE !== ( $entry = $d->read() ) ) {
				if ( $entry == '.' || $entry == '..' ) {
					continue;
				}
				$Entry = $source . '/' . $entry; 
				if ( is_dir( $Entry ) ) {
					full_copy( $Entry, $target . '/' . $entry );
					continue;
				}
				copy( $Entry, $target . '/' . $entry );
			}
	
			$d->close();
		}else {
			copy( $source, $target );
		}
	}

	full_copy("assets/", $carpetaScaffoldUser."/assets");
	full_copy("ct/", $carpetaScaffoldUser."/ct");
	full_copy("md/", $carpetaScaffoldUser."/md");
	full_copy("vw/", $carpetaScaffoldUser."/vw");
	full_copy("util/", $carpetaScaffoldUser."/util");


    /*Generación del index del proyecto*/

    $contenidoIndexProy = '<?php 

header ("location: ct/SeguridadController.php?c=lgv");

?>
	';

	if(!file_exists($carpetaScaffoldUser)){
		mkdir($carpetaScaffoldUser, 0777);
	}
	
	$fileConfig = fopen($carpetaScaffoldUser."/index.php", "w");
	fwrite($fileConfig, $contenidoIndexProy. PHP_EOL);
	fclose($fileConfig);

	/*generación del archivo de configuración de base de datos*/
	
	
	$contenidoConfig='<?php
class Database{

    private static $dbName = "'.$baseDatos.'" ;
    private static $dbHost = "'.$servidor.'" ;
    private static $dbUsername = "'.$usuario.'";
    private static $dbUserPassword = "'.$contrasena.'";
     
    private static $cont  = null;
     
    public function __construct() {
        die("Init function is not allowed");
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont ){     
			try{
				self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
			}
			catch(PDOException $e){
				die($e->getMessage()); 
			}
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>';
	if(!file_exists($carpetaScaffoldUser)){
		mkdir($carpetaScaffoldUser, 0777);
	}
	$fileConfig = fopen($carpetaScaffoldUser."/md/database.php", "w");
	fwrite($fileConfig, $contenidoConfig . PHP_EOL);
	fclose($fileConfig);


	
	


	//Recorrer las entidades del proyecto

	$sql = "SELECT * FROM Entidad where Proyecto = ?";
	$q = $pdo->prepare($sql);
	$q->execute(array($ProyectoId));
	$resultadoEntidad = $q->fetchAll();
	$contenidoMenu='
	
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="generator" content="Mobirise v4.9.6, mobirise.com">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="shortcut icon" href="assets/images/summanuevo-116x100.png" type="image/x-icon">
	<meta name="description" content="">
	
	<title>'.$NombreProyecto.'</title>
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
						'.$NombreProyecto.'<br>
					</a>
				</span>
			</div>
		</div>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav nav-dropdown nav-right" data-app-modern-menu="true">
				
			<?php 
			if(isset($UsuarioLogueado)){

				echo \'
				<li class="nav-item dropdown open"> 
					<a class="nav-link link text-white dropdown-toggle display-4" href="#" data-toggle="dropdown-submenu" aria-expanded="false">
						<span class="mobi-mbri mobi-mbri-add-submenu mbr-iconfont mbr-iconfont-btn"></span>
						Menú
					</a>
					<div class="dropdown-menu">
					
					
						';
	$contenidoSQL='';
	$contadorEntidades = 1;
	$insertEntidades ='';
	$scriptsDataTables = '
$(document).ready(function () {
	';
	foreach ($resultadoEntidad as $row) {
		$nombreModelo = $row['Nombre'];
		if(!file_exists($carpetaScaffoldUser."/vw/".$nombreModelo)){
			mkdir($carpetaScaffoldUser."/vw/".$nombreModelo, 0777);
		}
		
		
		//Recorrer los campos de la entidad
		
		$sql = "SELECT * FROM Campo where Entidad = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($row['id']));
		$resultadoCampo = $q->fetchAll();
		
		/*generación del archivo index*/
		$comilla = "\'";
		$contenidoIndex='
	<?php
		include "../vw/Templates/header.php";
	?>
		<div class="container">
			<br>
			<div class="btn-group" role="group" aria-label="Acciones de Ventana">
				<?php
					if (in_array(2, $Permiso)) {
						echo \'<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal" onclick="accionModal('.$comilla.$comilla.', '.$comilla.'c'.$comilla.', '.$comilla.$nombreModelo.$comilla.')"><i class="material-icons">add</i>Agregar</button>\';
					}
				?>
			</div>
			<br>
			<br>
			<?php
				if($mensaje != "") {
					echo \'
					<div class="alert alert-info">
					  	<strong>¡Atención!</strong> \'.$mensaje.\'
					</div>\';
				}
				include "../vw/'.$nombreModelo.'/list.php";
			?>
			
		</div> <!-- /container -->

	<?php
		include "../vw/Templates/footer.php";
	?>
		
		';




		$fileIndex = fopen($carpetaScaffoldUser."/vw/".$nombreModelo."/index.php", "w");
		fwrite($fileIndex, $contenidoIndex . PHP_EOL);
		fclose($fileIndex);


		/*fin generación del archivo index*/
		
		/*inicio generación del archivo listado*/
		
 		$contenidoListado ='

 			<h3 class="display-6" id="tableDesc">Listado de '.$nombreModelo.'</h3>
			<br>
			
			<table id="dt'.$nombreModelo.'" class="table table-striped table-bordered table-sm" aria-describedby="tableDesc">
				
				<thead class="thead-light">
					<tr>';
					$tamCol = 100/(sizeof($resultadoCampo)+1);
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo['EsVisible'] == 1){
				$contenidoListado.='
						<th scope="col" style="width:'.$tamCol.'%">
							'.$rowCampo['Nombre'].'
						</th>';
			}
			
		}
		$word = '$this';
		$contenidoListado.='
						<th scope="col" style="width:'.$tamCol.'%">
							Acciones
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
					

					$'.$nombreModelo.'s = $this->list();
					foreach ($'.$nombreModelo.'s as $row) {
						echo \'<tr>\';';
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo['EsVisible'] == 1){
				if (is_null($rowCampo['RelacionEntidad'])){
					$contenidoListado.='
						echo \'<td scope="col" style="width:'.$tamCol.'%">\'. $row->get'.$rowCampo['Nombre'].'() . \'</td>\';';
				} else {
					$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sqlEnt = "SELECT * FROM Entidad WHERE id = ?";
					$qEnt = $pdo->prepare($sqlEnt);
					$qEnt->execute(array($rowCampo['RelacionEntidad']));
					$rowEnt = $qEnt->fetch(PDO::FETCH_ASSOC);
					Database::disconnect();
					$contenidoListado.='
						include_once \'../md/'.$rowEnt['Nombre'].'Model.php\';
						$'.$rowEnt['Nombre'].' = new '.$rowEnt['Nombre'].'Model();
						$Encontrado = $'.$rowEnt['Nombre'].'->read($row->get'.$rowCampo['Nombre'].'());
						echo \'<td scope="col" style="width:'.$tamCol.'%"><a data-toggle="modal" data-target="#modal" onclick="accionModal('.$comilla.'\'.$Encontrado->getId().\''.$comilla.', '.$comilla.'r'.$comilla.', '.$comilla.$rowEnt['Nombre'].$comilla.')" >\'.$Encontrado->get'.$rowCampo['RelacionEntidadCampo'].'() .\'</a></td>\';';
				}
			}
		}
		$contenidoListado.='
						echo \'<td scope="col" style="width:'.$tamCol.'%">
							<div class="btn-group" role="group" aria-label="Basic example">\';

						echo in_array(1, $Permiso)?\'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal('.$comilla.'\'.$row->getId().\''.$comilla.', '.$comilla.'r'.$comilla.', '.$comilla.$nombreModelo.$comilla.')" ><i class="material-icons">remove_red_eye</i></button>\':\'\'; 
						echo in_array(4, $Permiso)?\'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal('.$comilla.'\'.$row->getId().\''.$comilla.', '.$comilla.'u'.$comilla.', '.$comilla.$nombreModelo.$comilla.')" ><i class="material-icons">create</i></button>\':\'\'; 
						echo in_array(3, $Permiso)?\'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-danger btn-sm" onclick="accionModal('.$comilla.'\'.$row->getId().\''.$comilla.', '.$comilla.'d'.$comilla.', '.$comilla.$nombreModelo.$comilla.')" ><i class="material-icons">delete</i></button>\':\'\'; 
						echo \'</div>
							</td>
						</tr>\';
					}
				?>
				</tbody>
			</table>
			
		';

		$fileCreate= fopen($carpetaScaffoldUser."/vw/".$nombreModelo."/list.php", "w");
		fwrite($fileCreate, $contenidoListado . PHP_EOL);
		fclose($fileCreate);

		

		/*generación del archivo create*/
		
		$contenidoCreate='
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Agregar '.$nombreModelo.'</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class ="col">
			</div>
			<div class ="col-10">
				<h4 class="display-6">Llena todos los campos requeridos.</h4>
				<br>
				<form action="'.$nombreModelo.'Controller.php" method="post" enctype="multipart/form-data">
					<input class="form-control" name="c" type="hidden" value="g" >';
						
		foreach ($resultadoCampo as $rowCampo) {
			if (is_null($rowCampo['RelacionEntidad'])){
				$tipo = "";
				$mensaje = "";
				switch ($rowCampo['Tipo']){

					case 'Numero':
					$tipo = "number";
					$mensaje = "Este campo es sólo números.";
					break;

					case 'Fecha':
					$tipo = "date";
					$mensaje = "Este campo es sólo tipo fecha.";
					break;

					case 'Correo':
					$tipo = "email";
					$mensaje = "Este campo es sólo tipo correo electrónico.";
					break;

					case 'Hora':
					$tipo = "time";
					$mensaje = "Este campo es sólo tipo hora.";
					break;

					case 'Contrasena':
					$tipo = "password";
					$mensaje = "Este campo es de tipo contraseña.";
					break;

					default:
					$tipo = "text";
					$mensaje = "Este campo es sólo números o letras.";
					break;
				}
				if ($rowCampo['Tipo'] == 'Imagen'){
					$contenidoCreate.='
					<label for="uploadedFile">'.$rowCampo['Nombre'].'</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="uploadedFile" type="file" required>
						</div>
					</div>';
				} else {
					$contenidoCreate.='
					<label for="'.$rowCampo['Nombre'].'">'.$rowCampo['Nombre'].'</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="'.$rowCampo['Nombre'].'" type="'.$tipo.'" title="'.$mensaje.'" required>
						</div>
					</div>';
				}
				
			

			} else {
				$sqlEnt = "SELECT * FROM Entidad WHERE id = ?";
				$qEnt = $pdo->prepare($sqlEnt);
				$qEnt->execute(array($rowCampo['RelacionEntidad']));
				$rowEnt = $qEnt->fetch(PDO::FETCH_ASSOC);
		
		
				$NombreEntidad = $rowEnt["Nombre"];
				$NombreCampo = $rowCampo["RelacionEntidadCampo"];
				$contenidoCreate.='
					<label for="'.$rowCampo['Nombre'].'">'.$rowCampo['Nombre'].'</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="'.$rowCampo['Nombre'].'" required>
								<?php
									include "../md/'.$NombreEntidad.'Model.php";
									$'.$NombreEntidad.' = new '.$NombreEntidad.'Model();
									$'.$NombreEntidad.'s = $'.$NombreEntidad.'->list();

									foreach ($'.$NombreEntidad.'s as $Fila){
										echo \'<option value="\'.$Fila->getId().\'">\'.$Fila->get'.$NombreCampo.'().\'</option>\';
									}
								?>
							</select>
						</div>
					</div>';

			}	
			
			
				
		}
		
		$contenidoCreate.='
					<div class="modal-footer">
						<button type="submit" class="btn btn-outline-primary">Guardar</button>
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
					</div>
				</form>
				</div>
				<div class ="col">
				</div>
			</div>
		</div>';
		$fileCreate= fopen($carpetaScaffoldUser."/vw/".$nombreModelo."/create.php", "w");
		fwrite($fileCreate, $contenidoCreate . PHP_EOL);
		fclose($fileCreate);
		/*fin generación del archivo create*/
		
		

		/* generación del archivo read*/
		$contenidoRead='
	<?php
		$'.$nombreModelo.' = $this->read($_POST[\'id\']);
	?>
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Detalle de '.$nombreModelo.'</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<div class="modal-body">
		<div class="col-sm-10 offset-md-1">';

			foreach ($resultadoCampo as $rowCampo) {
				if (is_null($rowCampo['RelacionEntidad'])){
					$contenidoRead.='
			<div class="card border-light">
				<div class="card-header">'.$rowCampo['Nombre'].'</div>
				<div class="card-body">
					<p class="card-text"><?php echo $'.$nombreModelo.'->get'.$rowCampo['Nombre'].'();?></p>
				</div>
			</div>';
				} else {
					$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$sqlEnt = "SELECT * FROM Entidad WHERE id = ?";
					$qEnt = $pdo->prepare($sqlEnt);
					$qEnt->execute(array($rowCampo['RelacionEntidad']));
					$rowEnt = $qEnt->fetch(PDO::FETCH_ASSOC);
					Database::disconnect();
					$contenidoRead.='
			<div class="card border-light">
				<div class="card-header">'.$rowCampo['Nombre'].'</div>
				<div class="card-body">
					<p class="card-text"> 
					<?php
						include_once \'../md/'.$rowEnt['Nombre'].'Model.php\';
						$'.$rowEnt['Nombre'].' = new '.$rowEnt['Nombre'].'Model();
						$Encontrado = $'.$rowEnt['Nombre'].'->read($'.$nombreModelo.'->get'.$rowCampo['Nombre'].'());
						echo $Encontrado->get'.$rowCampo['RelacionEntidadCampo'].'();
					?>
					</p>
				</div>
			</div>';
				}
				
			}
			
			$contenidoRead.='
		</div> 
	</div> 
	<div class="modal-footer">
		<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Atrás</button>
	</div>';
		$fileRead= fopen($carpetaScaffoldUser."/vw/".$nombreModelo."/read.php", "w");
		fwrite($fileRead, $contenidoRead . PHP_EOL);
		fclose($fileRead);
		/*fin generación del archivo read*/




		/*generación del archivo update*/
		
		$contenidoUpdate='
	<?php
		$'.$nombreModelo.' = $this->read($_POST[\'id\']);
	?>
	<form action="'.$nombreModelo.'Controller.php" method="post" enctype="multipart/form-data">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Modificar '.$nombreModelo.'</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class = "row">
				<div class ="col">
				</div>
				<div class ="col-10">
					<h4 class="display-12">Llena todos los campos requeridos.</h4>
					<br>
					<input class="form-control" name="c" type="hidden" value="a" >
					<input class="form-control" name="id" type="hidden" value="<?php echo $'.$nombreModelo.'->getId();?>" >';

						
		foreach ($resultadoCampo as $rowCampo) {

			if (is_null($rowCampo['RelacionEntidad'])){
				$tipo = "";
				$mensaje = "";
				switch ($rowCampo['Tipo']){
					

					case 'Numero':
					$tipo = "number";
					$mensaje = "Este campo es sólo números.";
					break;

					case 'Fecha':
					$tipo = "date";
					$mensaje = "Este campo es sólo tipo Fecha.";
					break;

					case 'Correo':
					$tipo = "email";
					$mensaje = "Este campo es sólo tipo correo electrónico.";
					break;

					case 'Hora':
					$tipo = "time";
					$mensaje = "Este campo es sólo tipo hora.";
					break;

					case 'Contrasena':
					$tipo = "password";
					$mensaje = "Este campo es de tipo contraseña.";
					break;

					default:
					$tipo = "text";
					$mensaje = "Este campo es sólo números o letras.";
					break;
				}
				
				if($rowCampo['Tipo']=='Imagen'){
					$contenidoUpdate.='
					<label for="uploadedFile">'.$rowCampo['Nombre'].'</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="uploadedFile" type="file">
						</div>
					</div>';
				} else {
					$contenidoUpdate.='

					<label for="NumeroId">'.$rowCampo['Nombre'].'</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="'.$rowCampo['Nombre'].'" type="'.$tipo.'" title="'.$mensaje.'" <?php echo \'value="\'.$'.$nombreModelo.'->get'.$rowCampo['Nombre'].'().\'"\'?>  required>
						</div>
					</div>';

				}
				
			} else {
				$sqlEnt = "SELECT * FROM Entidad WHERE id = ?";
				$qEnt = $pdo->prepare($sqlEnt);
				$qEnt->execute(array($rowCampo['RelacionEntidad']));
				$rowEnt = $qEnt->fetch(PDO::FETCH_ASSOC);
		
		
				$NombreEntidad = $rowEnt["Nombre"];
				$NombreCampo = $rowCampo["RelacionEntidadCampo"];
				$contenidoUpdate.='

					<label for="NumeroId">'.$rowCampo['Nombre'].'</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="'.$rowCampo['Nombre'].'" required>
								<?php
									include "../md/'.$NombreEntidad.'Model.php";
									$'.$NombreEntidad.' = new '.$NombreEntidad.'Model();
									$'.$NombreEntidad.'s = $'.$NombreEntidad.'->list();

									foreach ($'.$NombreEntidad.'s as $Fila){
										$selected = $'.$nombreModelo.'->get'.$rowCampo['Nombre'].'()==$Fila->getId()?\'" selected="selected">\':\'" >\';
										echo \'<option value="\'.$Fila->getId().$selected.$Fila->get'.$NombreCampo.'().\'</option>\';
									}
								?>
							</select>
						</div>
					</div>';

			}
				
		}
		
		$contenidoUpdate.='
				</div>
				<div class ="col">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-outline-primary btn-sm">Actualizar</button>
			<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancelar</button>
		</div>
	</form>
';

		$fileUpdate= fopen($carpetaScaffoldUser."/vw/".$nombreModelo."/update.php", "w");
		fwrite($fileUpdate, $contenidoUpdate . PHP_EOL);
		fclose($fileUpdate);
		/*fin generación del archivo update*/

/*generación del archivo delete*/
  
  $contenidoDelete='
	<form class="form-horizontal" action="'.$nombreModelo.'Controller.php" method="post">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Eliminar '.$nombreModelo.'</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class = "row">
				<div class ="col">
				</div>
				<div class ="col-10">
					<input type="hidden" name="c" value="b"/>
					<input type="hidden" name="id" value="<?php echo htmlspecialchars($_POST["id"]);?>"/>
					<p class="alert alert-error">¿Está seguro de eliminar este registro?</p>
					
				</div>
				<div class ="col">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
			<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancelar</button>
		</div>

	</form>';
  
	$fileDelete= fopen($carpetaScaffoldUser."/vw/".$nombreModelo."/delete.php", "w");
	fwrite($fileDelete, $contenidoDelete . PHP_EOL);
	fclose($fileDelete);
	/*fin generación del archivo delete*/

	/*Generación de controlador de acceso*/
  		

	$accessControllerFile = '
<?php
include \'../md/UsuarioModel.php\';
include_once \'../util/Messages.php\';

class AccessController{
	
	private $UsuarioModel;
	private const SESSION_TAG = "IDUSUARIOSISTEMA'.$carpetaScaffoldUser.'";
	
	public function __CONSTRUCT(){
		$this->UsuarioModel = new UsuarioModel();
		if(!isset($_SESSION)) { 
			session_start();
		}
	}

	public function direccionar($c, $mensaje){
		
		switch ($c){
			case "lg":

				$idUsuario = $this->UsuarioModel->loggin($_REQUEST["CorreoElectronico"], $_REQUEST["Contrasena"]);
				
				if($idUsuario==-1){
					$mensaje = Messages::ERROR_LOGIN;
					require_once "../vw/Templates/header.php";
					require_once "../vw/login.php";
					require_once "../vw/Templates/footer.php";
				}else{
					if(!isset($_SESSION)) { 
						session_start();
					}
					$_SESSION[$this::SESSION_TAG]=$idUsuario;
					header("Location: UsuarioController.php");
				}

			break;

			case "cs":
				if(!isset($_SESSION)) { 
					session_start();
				}
				//se destruyen todas las variables de sesión usadas en algun módulo del sistema
				unset($_SESSION[$this::SESSION_TAG]); 
				session_destroy(); 
				//se redirecciona a la página principal.
				header ("Location: ../index.php");
			break;
		} 
	}
}
 
$controladorAccess = new AccessController();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controladorAccess->direccionar($c, "");

?>';
	
	$fileAccessController= fopen($carpetaScaffoldUser."/ct/AccessController.php", "w");
	fwrite($fileAccessController, $accessControllerFile . PHP_EOL);
	fclose($fileAccessController);

	/*Fin generación del controlador de acceso*/

  $scriptFileSaving = '
  			//realiza la operación de insertado
			
			if (isset($_FILES[\'uploadedFile\']) && $_FILES[\'uploadedFile\'][\'error\'] === UPLOAD_ERR_OK) {
				// get details of the uploaded file
				$fileTmpPath = strval($_FILES[\'uploadedFile\'][\'tmp_name\']);
				$fileName = $_FILES[\'uploadedFile\'][\'name\'];
				$fileinfo = @getimagesize($_FILES["uploadedFile"]["tmp_name"]);
				$width = $fileinfo[0];
				$height = $fileinfo[1];
				$fileNameCmps = explode(".", $fileName);
				$fileExtension = strtolower(end($fileNameCmps));
				// sanitize file-name
				$newFileName = $Compania->Nombre. \'.\' . $fileExtension;
				$Icono = $newFileName;
				// check if file has one of the following extensions
				$allowedfileExtensions = array(\'png\');
				if (in_array($fileExtension, $allowedfileExtensions)) {
					
					// directory in which the uploaded file will be moved
					$uploadFileDir = \'../assets/images/iconos/\';
					$dest_path = $uploadFileDir . $newFileName;
					if(!move_uploaded_file($fileTmpPath, $dest_path)) {
						$message = Messages::UPLOAD_GENERIC_ERROR;
					}
					
				} else {
					$message = Messages::UPLOAD_EXT_ERROR  . implode(\',\', $allowedfileExtensions);
				}
			} else {
				
				$message = Messages::UPLOAD_GENERIC_ERROR_2;
			}
		
			if($message==""){
				$'.$nombreModelo.'->Icono = $Icono;
				$'.$nombreModelo.'->update();
				$this->direccionar("i", Messages::CREATE_SUCCESS);
			} else {
				$'.$nombreModelo.'->delete($'.$nombreModelo.'->id);
				$this->direccionar("i", Messages::GENERIC_ERROR.$message);
			}
  ';

  	

	

	$updateFileScript='
	if (isset($_FILES[\'uploadedFile\']) && $_FILES[\'uploadedFile\'][\'error\'] === UPLOAD_ERR_OK) {
		// get details of the uploaded file
		$fileTmpPath = strval($_FILES[\'uploadedFile\'][\'tmp_name\']);
		$fileName = $_FILES[\'uploadedFile\'][\'name\'];
		$fileinfo = @getimagesize($_FILES["uploadedFile"]["tmp_name"]);
		$width = $fileinfo[0];
		$height = $fileinfo[1];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
		// sanitize file-name
		$newFileName = $id . \'.\' . $fileExtension;
		$Icono = $newFileName;
		// check if file has one of the following extensions
		$allowedfileExtensions = array(\'png\');
		if (in_array($fileExtension, $allowedfileExtensions)) {
			
			if(($width!=  $height) || ($width<400)){
				$message = Messages::ICON_UPLOAD_ERROR;
			} else {
				// directory in which the uploaded file will be moved
				$uploadFileDir = \'../assets/images/iconos/\';
				$dest_path = $uploadFileDir . $newFileName;
				if(!move_uploaded_file($fileTmpPath, $dest_path)) {
					$message =  Messages::UPLOAD_GENERIC_ERROR;
				} 
			}
			
		} else {
			$message = Messages::UPLOAD_EXT_ERROR . implode(\',\', $allowedfileExtensions);
		}
	} else {
		$Icono = $this->read($id)->Icono;
	}

	$Compania = new CompaniaModel($id, $Nombre, $Icono);

	if($message==""){
		$message = $Compania->update();
		if ($message==23000){
			$this->direccionar("i", Messages::DUPLICATED_UPDATE_ERROR);
		} else if($message != ""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::UPDATE_SUCCESS);
		}
	}
	$this->direccionar("i", Messages::GENERIC_ERROR.$message);';

	  $contenidoController='<?php';
	  if($row['TieneSeguridadUsuario']!=1){
		  $contenidoController.='
  
include \'../md/'.$nombreModelo.'Model.php\';';
	  }
	  $contenidoController.='
include \'../md/UsuarioModel.php\';
include_once \'../util/Messages.php\';

class '.$nombreModelo.'Controller{
    
	private $'.$nombreModelo.'Model;
	private const SESSION_TAG = "IDUSUARIOSISTEMA'.$carpetaScaffoldUser.'";
    
	public function __CONSTRUCT(){
		$this->'.$nombreModelo.'Model = new '.$nombreModelo.'Model();
		if(!isset($_SESSION)) { 
			session_start();
		}
	}

	public function direccionar($c, $mensaje){
		if(!isset($_SESSION[$this::SESSION_TAG])'.($row['TieneSeguridadUsuario']==1?' && $c!=\'lg\'':'').'){
			require_once "../vw/Templates/header.php";
			require_once "../vw/login.php";
			require_once "../vw/Templates/footer.php";
		} else {';
			if($row['TieneSeguridadUsuario']!=1){
				$contenidoController.='
			$UsuarioModel = new UsuarioModel();';
			}
			$contenidoController.='
			$UsuarioLogueado = $'.($row['TieneSeguridadUsuario']==1?'this->':'').'UsuarioModel->read($_SESSION[$this::SESSION_TAG]);
			$Permiso = $'.($row['TieneSeguridadUsuario']==1?'this->':'').'UsuarioModel->getPermissions($_SESSION[$this::SESSION_TAG], '.$contadorEntidades.');

			if ($Permiso==-1){
				require_once "../vw/Templates/header.php";
				require_once "../vw/PaginaError.php";
				require_once "../vw/Templates/footer.php";
				
			} else {

				switch ($c){
					case "c":
						require_once "../vw/'.$nombreModelo.'/create.php";
					break;

					case "i":
						if (in_array(5, $Permiso)){
							
							require_once "../vw/'.$nombreModelo.'/index.php";
						}
					break;

					case "r":
						require_once "../vw/'.$nombreModelo.'/read.php";
					break;

					case "d":
						require_once "../vw/'.$nombreModelo.'/delete.php";
					break;

					case "u":
						require_once "../vw/'.$nombreModelo.'/update.php";
					break;

					case "b":
						$this->delete();
					break;

					case "g":
						$this->create();
					break;

					case "a":
						$this->update();
					break;

					default:
						header ("location: ../index.php");
					break;
					
				} 
			}
		}
	}
	
    
	public function list(){

        return $this->'.$nombreModelo.'Model->list();
        
	}

	public function read($id){

        return $this->'.$nombreModelo.'Model->read($id);
        
	}


	public function create(){
      
		';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoController.='
		$'.$rowCampo['Nombre'].' = trim($_REQUEST["'.$rowCampo['Nombre'].'"]);';
		
      	}
		$contenidoController.='
		
		$'.$nombreModelo.' = new '.$nombreModelo.'Model("", ';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoController.='$'.$rowCampo['Nombre'].', ';
		
      	}
      	//elimina la ultima coma
      	$contenidoController = substr($contenidoController, 0, -2);
		$contenidoController.=');
		$message = $'.$nombreModelo.'->create(); 
		if ($message==23000){
			$this->direccionar("i",  Messages::DUPLICATED_CREATE_ERROR);
		} else if ($message != ""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			';
			if($rowCampo['Tipo']=='Image'){
				$contenidoController.=$scriptFileSaving.$scriptFileCreateDiff;
			} else {
				$contenidoController.='
			$this->direccionar("i", Messages::CREATE_SUCCESS);';
			}
			
			
			$contenidoController.='
		}
		
	}
                                    
	public function update(){

		$id = trim($_REQUEST["id"]);';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoController.='
		$'.$rowCampo['Nombre'].' = '.(($rowCampo['Tipo']=='Image')?'':'trim($_REQUEST["'.$rowCampo['Nombre'].'"]);');
		
			$tieneArchivo=false;
			if($rowCampo['Tipo']=='Image'){
				$tieneArchivo=true;
			}
			
			
		}
		$contenidoController.='
		$'.$nombreModelo.' = new '.$nombreModelo.'Model($id, ';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoController.='$'.$rowCampo['Nombre'].', ';
		
      	}
		//elimina la ultima coma
		$contenidoController = substr($contenidoController, 0, -2);
		$contenidoController.=');
		';

		if($tieneArchivo){
			$contenidoController.=$updateFileScript;
		}
		else{
			$contenidoController.='
		$message = $'.$nombreModelo.'->update(); //realiza la operación de actualizado
		if ($message==23000){
			$this->direccionar("i", Messages::DUPLICATED_UPDATE_ERROR);
		} else if($message != ""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::UPDATE_SUCCESS);
		}';
			
		}
			
		
			
		$contenidoController.='
	}
    
	public function delete(){
		$id = trim($_REQUEST["id"]);
		$message = $this->'.$nombreModelo.'Model->delete($id);
		if ($message==23000){
			$this->direccionar("i", Messages::RELATED_REG_DELETE_ERROR);
		} else if ($message!=""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::DELETE_SUCCESS);
		}
	}

	
}
 
$controlador'.$nombreModelo.' = new '.$nombreModelo.'Controller();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controlador'.$nombreModelo.'->direccionar($c, "");

?>';

		$fileController= fopen($carpetaScaffoldUser."/ct/".$nombreModelo."Controller.php", "w");
		fwrite($fileController, $contenidoController . PHP_EOL);
		fclose($fileController);



		/*Fin generación del archivo controlador */


		/*Generación del archivo model */

		$ScriptSiUsuario = '';

		if($row['TieneSeguridadUsuario']==1){
			$ScriptSiUsuario = '

	

	function loggin($usuario, $Contrasena){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "Select id, TipoUsuario, Contrasena from ".$this->db.".Usuario WHERE CorreoElectronico = ?";
		$q = $pdo->prepare($sql); 
		$q->execute(array($usuario));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		if($q->rowCount()>0){
			if (password_verify($Contrasena, $row["Contrasena"])) {
				Database::disconnect();
				return $row["id"]."/".$row["TipoUsuario"];
			}
			Database::disconnect();
			return -1;
		}
		Database::disconnect();
		return -1;
	}

	function getPermissions($id, $pagina){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "Select S.AccionSeguridad FROM ".$this->db.".Usuario U INNER JOIN ".$this->db.".TipoUsuario TU ON U.TipoUsuario = TU.id INNER JOIN ".$this->db.".Seguridad S ON S.TipoUsuario = TU.id WHERE U.id = ? and S.EntidadSeguridad = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id, $pagina));
		if($q->rowCount()>0){
			$permisos = array();
			foreach ($q->fetchAll() as $row) {
				array_push ($permisos, $row[0]);
			}
			Database::disconnect();
			return $permisos;
		}
		Database::disconnect();
		return -1;
	}

	';

		}

		$contenidoModel='<?php
	include_once "database.php";

Class '.$nombreModelo.'Model {

	private $id;';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.='
	private $'.$rowCampo['Nombre'].';';
		 }
	 
	

  	$contenidoModel.='
	private	$db;

	function __construct ($id = "", ';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.='$'.$rowCampo['Nombre'].' = "", ';
		
      	}
      	//elimina la ultima coma
      	$contenidoModel = substr($contenidoModel, 0, -2);
		$contenidoModel.='){

    	$this->id=$id;';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.='
		$this->'.$rowCampo['Nombre'].'=$'.$rowCampo['Nombre'].';';
			
     	}

	  $contenidoModel.='
	  	$this->db="'.$baseDatos.'";
    	
	}

	public function getId(){
		return $this->id;
	}

	';
	foreach ($resultadoCampo as $rowCampo) {
		$contenidoModel.='
	public function get'.$rowCampo['Nombre'].'(){
		return $this->'.$rowCampo['Nombre'].';
	}

	public function set'.$rowCampo['Nombre'].'($'.$rowCampo['Nombre'].'){
		$this->'.$rowCampo['Nombre'].' = $'.$rowCampo['Nombre'].';
	}

	';
	}
	$contenidoModel.='
  
	function create() {
    	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO ".$this->db.".'.$nombreModelo.' (';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.=$rowCampo['Nombre'].', ';
		
      	}
      	//elimina la ultima coma
      	$contenidoModel = substr($contenidoModel, 0, -2);
		$contenidoModel.=') values(';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.='?, ';
		
      	}
      	//elimina la ultima coma
      	$contenidoModel = substr($contenidoModel, 0, -2);
		$contenidoModel.=')";
		$q = $pdo->prepare($sql);
 		try {
			$q->execute(array(';
		foreach ($resultadoCampo as $rowCampo) {
			if ($rowCampo['Tipo'] == 'Contrasena'){
				$contenidoModel.='password_hash($this->'.$rowCampo['Nombre'].', PASSWORD_DEFAULT), ';
			} else {
				$contenidoModel.='$this->'.$rowCampo['Nombre'].', ';
			}
		
      	}
      	//elimina la ultima coma
      	$contenidoModel = substr($contenidoModel, 0, -2);
		$contenidoModel.='));
			$this->id = $pdo->lastInsertId();
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			
			Database::disconnect();
			return $e->getCode();	
		}
	}


	function list(){

		$pdo = Database::connect();
		$'.$nombreModelo.'s = array();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".'.$nombreModelo.'";
		$q = $pdo->prepare($sql);
		$q->execute();
		$results = $q->fetchAll();
		foreach ($results as $row) {
			array_push ($'.$nombreModelo.'s, new '.$nombreModelo.'Model($row["id"], ';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.='$row["'.$rowCampo['Nombre'].'"], ';
		
      	}
      	//elimina la ultima coma
      	$contenidoModel = substr($contenidoModel, 0, -2);
		$contenidoModel.='));
		}
		Database::disconnect();
		return $'.$nombreModelo.'s;
	}

	function read($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".'.$nombreModelo.' WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		return new '.$nombreModelo.'Model($row["id"], ';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.='$row["'.$rowCampo['Nombre'].'"], ';
		
      	}
      	//elimina la ultima coma
      	$contenidoModel = substr($contenidoModel, 0, -2);
		$contenidoModel.=');
	}

	function delete($id){

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM ".$this->db.".'.$nombreModelo.' WHERE ID = ?";
		$q = $pdo->prepare($sql);
		try{
			$q->execute(array($id));
			Database::disconnect();
			return "";
		 } catch (Exception $e){
		 	Database::disconnect();
			return $e->getCode();
		}
		 
	}

	function update() {

    	$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE ".$this->db.".'.$nombreModelo.' SET ';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.=$rowCampo['Nombre'].'=?, ';
		
      	}
      	//elimina la ultima coma
      	$contenidoModel = substr($contenidoModel, 0, -2);
		$contenidoModel.=' WHERE id = ?";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array(';
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.='$this->'.$rowCampo['Nombre'].', ';
		
      	}
      	//elimina la ultima coma
		$contenidoModel.='$this->id));
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			Database::disconnect();
			return $e->getCode();	
		}
	}'.$ScriptSiUsuario.'


}
?>';

		$fileModel= fopen($carpetaScaffoldUser."/md/".$nombreModelo."Model.php", "w");
		fwrite($fileModel, $contenidoModel . PHP_EOL);
		fclose($fileModel);


		/*Generación del archivo model */


		/*generación del archivo sql*/
	  	$contenidoSQL.='
CREATE TABLE IF NOT EXISTS `'.$nombreModelo.'` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	';
	    foreach ($resultadoCampo as $rowCampo) {
	   		$nulidad = "NOT NULL";
	   		if($rowCampo['EsNull'] == 1){
				$nulidad = "NULL";
			}

			$tipoParentesisTamano = " ";
			if($rowCampo['Tipo'] == "Numero"){
				$tipoParentesisTamano = 'INT ';
			} else if($rowCampo['Tipo'] =="Fecha"){
				$tipoParentesisTamano = 'DATE ';
			} else if($rowCampo['Tipo'] =="TimeStamp"){
				$tipoParentesisTamano = 'TIMESTAMP ';
			} else if($rowCampo['Tipo'] == "Entidad") {
				$tipoParentesisTamano = 'INT ';
			} else if($rowCampo['Tipo'] == "Imagen") {
				$tipoParentesisTamano = 'VARCHAR(2500) ';
			}else {
				$tipoParentesisTamano = 'VARCHAR('.$rowCampo['Longitud'].') ';
			}
			
			$contenidoSQL.='`'.$rowCampo['Nombre'].'` '.$tipoParentesisTamano.$nulidad.', 
		';
	  	}
	  
	  	$contenidoSQL.='PRIMARY KEY (`id`)
);';

		
		
		
		 /*fin generación del archivo sql*/


		/*Generación del archivo menú*/
		if($contadorEntidades>5){ // Las primero 5 entidades ya están ingresadas en otro menú de seguridad.
			$contenidoMenu.='
								<a class="text-white dropdown-item display-4" href="../ct/'.$nombreModelo.'Controller.php">
									'.$nombreModelo.'
								</a>
			';
		}

		/*fin generación del archivo menú*/
		 echo 'Archivos generados '.$nombreModelo.'... <br>
		 ';
		 $insertEntidades.="
	Insert Into EntidadSeguridad (Codigo, Nombre) Values ('".$contadorEntidades."', '".$nombreModelo."');";
		$scriptsDataTables.='
	$(\'#dt'.$nombreModelo.'\').DataTable({
		"pagingType": "full_numbers" 
	});';
		 $contadorEntidades++;
	} //fin ciclo de entidades

	$contenidoMenu.='
							</div>
						</li>\';

					if($UsuarioLogueado->getTipoUsuario()==1){
						echo \'
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
						</li>\';
					}

					echo \'
						<li class="nav-item dropdown open"> 
							<a class="nav-link link text-white dropdown-toggle display-4" href="#"  data-toggle="dropdown-submenu"  aria-expanded="true">
								<span class="mbri-user mbr-iconfont mbr-iconfont-btn"></span>\'
								.$UsuarioLogueado->getNombre().\'
							</a>
							<div class="dropdown-menu">
								<a class="text-white dropdown-item display-4" href="#" onclick="accionModal(\\\'\'.$UsuarioLogueado->getId().\'\\\', \\\'u\\\', \\\'Usuario\\\')" data-toggle="modal" data-target="#modal">
									Mi perfil
								</a>
								<a class="text-white dropdown-item display-4"  onclick="accionModal(\\\'\\\', \\\'cs\\\', \\\'Access\\\')" aria-expanded="false">
									Cerrar Sesión
								</a>
							</div>
						</li>
					\';
					
					
					
				} else {
					echo \'
					<li class="nav-item">
						<a class="nav-link link text-white display-4" href="user.php">
							<span class="mbri-user mbr-iconfont mbr-iconfont-btn"></span>
							Login
						</a>
					</li>\';
				} 
				?>
			</ul>
		</div>
	</nav>
</section>';


	$fileMenu= fopen($carpetaScaffoldUser."/vw/Templates/header.php", "w");
	fwrite($fileMenu, $contenidoMenu . PHP_EOL);
	fclose($fileMenu);
	echo 'Generado Menú <br>';

	$contenidoSQL.= '
	ALTER TABLE `Seguridad`
		ADD UNIQUE KEY `TipoUsuario` (`TipoUsuario`,`EntidadSeguridad`,`AccionSeguridad`),
  		ADD KEY `Seguridad_ibfk_1` (`AccionSeguridad`),
  		ADD KEY `Seguridad_ibfk_2` (`EntidadSeguridad`),
		ADD CONSTRAINT `Seguridad_ibfk_1` FOREIGN KEY (`AccionSeguridad`) REFERENCES `AccionSeguridad` (`id`),
		ADD CONSTRAINT `Seguridad_ibfk_2` FOREIGN KEY (`EntidadSeguridad`) REFERENCES `EntidadSeguridad` (`id`),
		ADD CONSTRAINT `Seguridad_ibfk_3` FOREIGN KEY (`TipoUsuario`) REFERENCES `TipoUsuario` (`id`);

	ALTER TABLE `Usuario`
		ADD UNIQUE KEY `CorreoElectronico` (`CorreoElectronico`),
  		ADD KEY `Usuario_ibfk_1` (`TipoUsuario`),
		ADD CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`TipoUsuario`) REFERENCES `TipoUsuario` (`id`);

	'.$insertEntidades.'

	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(1, \'001\', \'Leer\');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(2, \'002\', \'Registrar\');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(3, \'003\', \'Eliminar\');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(4, \'004\', \'Actualizar\');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(5, \'005\', \'Listar\');

	INSERT INTO `TipoUsuario` (`id`, `Nombre`, `Descripcion`) VALUES(1, \'Analista de seguridad\', \'Administra la seguridad de usuario\');

	INSERT INTO `Usuario` (`id`, `Nombre`, `Apellido`, `CorreoElectronico`, `Contrasena`, `TipoUsuario`) VALUES(1, \'Eduardo\', \'Campo Herrera\', \'eduardo3517@gmail.com\', \'$2y$10$pGIQr2OzX7VMmqOqAdENpO3QzIdW64pDbkDHwiq0IWEfdV17zv2iO\', 1);

	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 1, 1);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 1, 2);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 1, 3);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 1, 4);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 1, 5);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 2, 1);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 2, 2);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 2, 3);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 2, 4);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 2, 5);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 3, 1);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 3, 2);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 3, 3);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 3, 4);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 3, 5);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 4, 1);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 4, 2);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 4, 3);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 4, 4);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 4, 5);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 5, 1);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 5, 2);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 5, 3);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 5, 4);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 5, 5);

	
	';
	$fileSQL= fopen($carpetaScaffoldUser."/SQL_SCRIPT.sql", "w");
	fwrite($fileSQL, $contenidoSQL . PHP_EOL);
	fclose($fileSQL);
	echo 'Completado Generación Script SQL<BR>';

	$scriptsDataTables.='
	$(\'.dataTables_length\').addClass(\'bs-select\');
});';
	$fileSQL= fopen($carpetaScaffoldUser."/assets/js/datatable.js", "w");
	fwrite($fileSQL, $scriptsDataTables . PHP_EOL);
	fclose($fileSQL);
	echo 'Completado Script Javascript para datatables SQL<BR>';

	$zip = new ZipArchive();
	$dir = $carpetaScaffoldUser.'/';
	$rutaFinal = "Generacion";

	if(!file_exists($rutaFinal)){
		mkdir($rutaFinal);
	}
	$archivoZip = $NombreProyecto.".zip";

	if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
		agregar_zip($dir, $zip);
		$zip->close();

		rename($archivoZip, "$rutaFinal/$archivoZip");
		
		if (file_exists($rutaFinal. "/" . $archivoZip)) {
			echo "Proceso Finalizado!! <br/><br/>
			Descargar: <a href='$rutaFinal/$archivoZip'>$archivoZip</a>";
		} else {
			echo "Error, archivo zip no ha sido creado!!";
		}
	}

?>
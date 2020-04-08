<?php
	include_once "database.php";
	include_once "Model.php";
	include_once "Controller.php";
	include_once "View.php";
	include_once "Menu.php";
	include_once "Config.php";

Class ProyectoModel {

	private $id;
	private $Nombre;
	private $FechaCreacion;
	private $NombreServidor;
	private $NombreBaseDatos;
	private $UsuarioBaseDatos;
	private $ContrasenaBaseDatos;
	private $FechaUltimaModificacion;
	private $Usuario;
	private	$db;

	function __construct (){

		$this->db=Database::$dbName;
    	
	}

	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id= $id;
	}
	
	public function getNombre(){
		return $this->Nombre;
	}

	public function setNombre($Nombre){
		$this->Nombre = $Nombre;
	}

	
	public function getFechaCreacion(){
		return $this->FechaCreacion;
	}

	public function setFechaCreacion($FechaCreacion){
		$this->FechaCreacion = $FechaCreacion;
	}

	
	public function getNombreServidor(){
		return $this->NombreServidor;
	}

	public function setNombreServidor($NombreServidor){
		$this->NombreServidor = $NombreServidor;
	}

	
	public function getNombreBaseDatos(){
		return $this->NombreBaseDatos;
	}

	public function setNombreBaseDatos($NombreBaseDatos){
		$this->NombreBaseDatos = $NombreBaseDatos;
	}

	
	public function getUsuarioBaseDatos(){
		return $this->UsuarioBaseDatos;
	}

	public function setUsuarioBaseDatos($UsuarioBaseDatos){
		$this->UsuarioBaseDatos = $UsuarioBaseDatos;
	}

	
	public function getContrasenaBaseDatos(){
		return $this->ContrasenaBaseDatos;
	}

	public function setContrasenaBaseDatos($ContrasenaBaseDatos){
		$this->ContrasenaBaseDatos = $ContrasenaBaseDatos;
	}

	
	public function getFechaUltimaModificacion(){
		return $this->FechaUltimaModificacion;
	}

	public function setFechaUltimaModificacion($FechaUltimaModificacion){
		$this->FechaUltimaModificacion = $FechaUltimaModificacion;
	}

	
	public function getUsuario(){
		return $this->Usuario;
	}

	public function setUsuario($Usuario){
		$this->Usuario = $Usuario;
	}

	
  
	function create() {
    	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO ".$this->db.".Proyecto (Nombre, NombreServidor, NombreBaseDatos, UsuarioBaseDatos, ContrasenaBaseDatos, Usuario) values(?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array($this->Nombre, $this->NombreServidor, $this->NombreBaseDatos, $this->UsuarioBaseDatos, $this->ContrasenaBaseDatos, $this->Usuario));
			$this->id = $pdo->lastInsertId();
			$this->generarSeguridad($this->id);
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			
			Database::disconnect();
			return $e->getCode();	
		}
	}

	function list(){

		$pdo = Database::connect();
		$Proyectos = array();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".Proyecto";
		$q = $pdo->prepare($sql);
		$q->execute();
		$results = $q->fetchAll();
		
		foreach ($results as $row) {
			$Proyecto = new ProyectoModel();
			$Proyecto->setId($row["id"]);
			$Proyecto->setNombre($row["Nombre"]);
			$Proyecto->setFechaCreacion($row["FechaCreacion"]);
			$Proyecto->setNombreServidor($row["NombreServidor"]);
			$Proyecto->setNombreBaseDatos($row["NombreBaseDatos"]);
			$Proyecto->setUsuarioBaseDatos($row["UsuarioBaseDatos"]);
			$Proyecto->setContrasenaBaseDatos($row["ContrasenaBaseDatos"]);
			$Proyecto->setFechaUltimaModificacion($row["FechaUltimaModificacion"]);
			$Proyecto->setUsuario($row["Usuario"]);
			array_push ($Proyectos, $Proyecto);
		}
		Database::disconnect();
		return $Proyectos;
	}

	function read($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".Proyecto WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		$Proyecto = new ProyectoModel();
		$Proyecto->setId($row["id"]);
		$Proyecto->setNombre($row["Nombre"]);
		$Proyecto->setFechaCreacion($row["FechaCreacion"]);
		$Proyecto->setNombreServidor($row["NombreServidor"]);
		$Proyecto->setNombreBaseDatos($row["NombreBaseDatos"]);
		$Proyecto->setUsuarioBaseDatos($row["UsuarioBaseDatos"]);
		$Proyecto->setContrasenaBaseDatos($row["ContrasenaBaseDatos"]);
		$Proyecto->setFechaUltimaModificacion($row["FechaUltimaModificacion"]);
		$Proyecto->setUsuario($row["Usuario"]);
		return $Proyecto;
	}

	function delete($id){

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM ".$this->db.".Proyecto WHERE ID = ?";
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
		$sql = "UPDATE ".$this->db.".Proyecto SET Nombre=?, NombreServidor=?, NombreBaseDatos=?, UsuarioBaseDatos=?, ContrasenaBaseDatos=?, FechaUltimaModificacion=CURRENT_TIMESTAMP WHERE id = ?";
		$q = $pdo->prepare($sql);
		print_r(array($this->Nombre, $this->NombreServidor, $this->NombreBaseDatos, $this->UsuarioBaseDatos, $this->ContrasenaBaseDatos, $this->Usuario));
 		
		try {
			$q->execute(array($this->Nombre, $this->NombreServidor, $this->NombreBaseDatos, $this->UsuarioBaseDatos, $this->ContrasenaBaseDatos,  $this->id));
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			Database::disconnect();
			return $e->getCode();	
		}
	}

	

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
					$this->full_copy( $Entry, $target . '/' . $entry );
					continue;
				}
				copy( $Entry, $target . '/' . $entry );
			}
	
			$d->close();
		}else {
			copy( $source, $target );
		}
	}

	function generarSeguridad($idProyecto){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Entidad Tipo Usuario

        $sql = "INSERT INTO ".$this->db.".Entidad (Nombre, Relacion, Proyecto, TieneSeguridadUsuario, Comentario) values(?, ?, ?, ?, ?)";
		
		$q = $pdo->prepare($sql);
        $q->execute(array('TipoUsuario', 0, $idProyecto, 0,  'Esta entidad es creada automáticamente por el sistema para controlar la seguridad de acceso.'));
        $idEntidadTipoUsuario = $pdo->lastInsertId();
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('Nombre', 50, 0, 1, 1, '', $idEntidadTipoUsuario,  'El nombre del tipo de Usuario', NULL, NULL));
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('Descripcion', 500, 1, 1, 1, '', $idEntidadTipoUsuario,  'Una descripción opcional para el tipo de Usuario', NULL, NULL));
       
        //Entidad Usuario

        $sql = "INSERT INTO ".$this->db.".Entidad (Nombre, Relacion, Proyecto, TieneSeguridadUsuario, Comentario) values(?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array('Usuario', 0, $idProyecto, 1,  'Esta entidad es creada automáticamente por el sistema para controlar la seguridad de acceso.'));
        $idEntidad = $pdo->lastInsertId();
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('Nombre', 50, 0, 1, 1, '', $idEntidad,  'El nombre del Usuario', NULL, NULL));
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('Apellido', 50, 0, 1, 1, '', $idEntidad,  'El apellido del Usuario', NULL, NULL));
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('CorreoElectronico', 50, 1, 1, 1, '', $idEntidad,  'El correo electrónico', NULL, NULL));
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('Contrasena', 500, 0, 6, 1, '', $idEntidad,  'Contraseña del usuario', NULL, NULL));
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('TipoUsuario', 0, 0, 8, 1, '', $idEntidad,  'Tipo Usuario se conecta con la entidad de seguridad', $idEntidadTipoUsuario, 'Nombre'));
        

        //Entidad EntidadSeguridad
        
        $sql = "INSERT INTO ".$this->db.".Entidad (Nombre, Relacion, Proyecto, TieneSeguridadUsuario, Comentario) values(?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array('EntidadSeguridad', 0, $idProyecto, 0,  'Esta entidad es creada automáticamente por el sistema para controlar la seguridad de acceso.'));
        $idEntidadEntidadSeguridad = $pdo->lastInsertId();
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('Codigo', 20, 0, 1, 1, '', $idEntidadEntidadSeguridad,  'El código de la entidad ', NULL, NULL));
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('Nombre', 200, 0, 1, 1, '', $idEntidadEntidadSeguridad,  'Una descripción opcional para el tipo de Usuario', NULL, NULL));

        //Entidad AccionSeguridad
        
        $sql = "INSERT INTO ".$this->db.".Entidad (Nombre, Relacion, Proyecto, TieneSeguridadUsuario, Comentario) values(?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array('AccionSeguridad', 0, $idProyecto, 0,  'Esta entidad es creada automáticamente por el sistema para controlar la seguridad de acceso.'));
        $idEntidadAccionSeguridad = $pdo->lastInsertId();
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('Codigo', 20, 0, 1, 1, '', $idEntidadAccionSeguridad,  'El codigo para la acción de seguridad', NULL, NULL));
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('Nombre', 200, 0, 1, 1, '', $idEntidadAccionSeguridad,  'El nombre de la acción de seguridad', NULL, NULL));

        //Entidad Seguridad

        $sql = "INSERT INTO ".$this->db.".Entidad (Nombre, Relacion, Proyecto, TieneSeguridadUsuario, Comentario) values(?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array('Seguridad', 0, $idProyecto, 0,  'Esta entidad es creada automáticamente por el sistema para controlar la seguridad de acceso.'));
        $idEntidadSeguridad = $pdo->lastInsertId();
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('TipoUsuario', 0, 0, 8, 1, '', $idEntidadSeguridad,  'El nombre del tipo de Usuario', $idEntidadTipoUsuario, 'Nombre'));
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('EntidadSeguridad', 0, 1, 8, 1, '', $idEntidadSeguridad,  'Relación a la entidad de seguridad', $idEntidadEntidadSeguridad, 'Nombre'));
        $sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, Comentarios, RelacionEntidad, RelacionEntidadCampo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";     
        $q = $pdo->prepare($sql);
        $q->execute(array ('AccionSeguridad', 0, 1, 8, 1, '', $idEntidadSeguridad,  'Relación a la entidad de seguridad', $idEntidadAccionSeguridad, 'Nombre'));
       
        Database::disconnect();
    }

	function build($id){

		$Proyecto = $this->read($id);
		$ProyectoId = $Proyecto->getId();

		$carpetaScaffoldUser = "U".$Proyecto->getUsuario()."P".$ProyectoId;
		@mkdir($carpetaScaffoldUser);

		//copia de los archivos de estructura
		$this->full_copy("structure/assets/", $carpetaScaffoldUser."/assets");
		$this->full_copy("structure/ct/", $carpetaScaffoldUser."/ct");
		$this->full_copy("structure/md/", $carpetaScaffoldUser."/md");
		$this->full_copy("structure/vw/", $carpetaScaffoldUser."/vw");
		$this->full_copy("structure/util/", $carpetaScaffoldUser."/util");

		$contenidoIndexProy = '<?php 

header ("location: ct/SeguridadController.php");

?>
	';
		$this->writeFile($carpetaScaffoldUser, 'index.php', $contenidoIndexProy);
		include_once 'EntidadModel.php';
		$Entidades = (new EntidadModel())->list($Proyecto->getId());
		$contenidoSQL='CREATE DATABASE '.$Proyecto->getNombreBaseDatos().";
USE ".$Proyecto->getNombreBaseDatos().";
";
		$model= new Model();
		$controller = new Controller();
		$view = new View();
		$menu = new Menu();
		$config= new Config();

		$contenidoMenu = $menu->generateMenu1($Proyecto->getNombre());
		$contadorEntidades = 1;
		$insertEntidades ='';
		$scriptsDataTables = '
	$(document).ready(function () {
		';
		//Recorre


		foreach($Entidades as $entity){
			
			$nombreModelo = $entity->getNombre();
			echo "<strong>Generada Entidad ".$nombreModelo."</strong><br>";
			if(!file_exists($carpetaScaffoldUser."/vw/".$nombreModelo)){
				mkdir($carpetaScaffoldUser."/vw/".$nombreModelo, 0777);
			}
			include_once 'CampoModel.php';
			$Campos = (new CampoModel())->list($entity->getId());
			

			$this->writeFile($carpetaScaffoldUser, 
			"vw/".$nombreModelo."/index.php", 
			$view->generateIndex($nombreModelo));
			echo "Generado index<br>";

			$this->writeFile($carpetaScaffoldUser, 
			"vw/".$nombreModelo."/list.php", 
			$view->generateList($nombreModelo, $Campos));
			echo "Generado list<br>";

			$this->writeFile($carpetaScaffoldUser, 
			"vw/".$nombreModelo."/create.php", 
			$view->generateCreate($nombreModelo, $Campos));
			echo "Generado create<br>";

			$this->writeFile($carpetaScaffoldUser, 
			"vw/".$nombreModelo."/read.php", 
			$view->generateRead($nombreModelo, $Campos));
			echo "Generado read<br>";

			$this->writeFile($carpetaScaffoldUser, 
			"vw/".$nombreModelo."/update.php", 
			$view->generateUpdate($nombreModelo, $Campos));
			echo "Generado update<br>";

			$this->writeFile($carpetaScaffoldUser, 
			"vw/".$nombreModelo."/delete.php", 
			$view->generateDelete($nombreModelo));
			echo "Generado delete<br>";

			$this->writeFile($carpetaScaffoldUser, 
			"ct/".$nombreModelo."Controller.php", 
			$controller->generateController($nombreModelo, $Campos, $entity, $carpetaScaffoldUser, $contadorEntidades));
			echo "Generado Controller<br>";

			$this->writeFile($carpetaScaffoldUser, 
			"md/".$nombreModelo."Model.php", 
			$model->generateModel($entity, $nombreModelo, $Campos, $Proyecto->getNombreBaseDatos()));
			echo "Generado Model<br>";

			$contenidoSQL.=$config->generateSQL($nombreModelo, $Campos);
			
			$contenidoMenu.=$menu->generateMenu($nombreModelo, $contadorEntidades);
			
			$insertEntidades.="
	INSERT INTO EntidadSeguridad (Codigo, Nombre) VALUES ('".$contadorEntidades."', '".$nombreModelo."');";
			$scriptsDataTables.='
	$(\'#dt'.$nombreModelo.'\').DataTable({
		"pagingType": "full_numbers" 
	});';
			$contadorEntidades++;

		}
		$this->writeFile($carpetaScaffoldUser, 
		"ct/AccessController.php", 
		$controller->generateAccessController($carpetaScaffoldUser));
		echo "Generado AccessController<br>";

		$contenidoMenu.=$menu->generateMenu2();
		$this->writeFile($carpetaScaffoldUser, "vw/Templates/header.php", $contenidoMenu);
		echo "Generado header<br>";

		$contenidoSQL.=$config->generateSQL2($insertEntidades);
		$this->writeFile($carpetaScaffoldUser, "SQL_SCRIPT.sql", $contenidoSQL);
		echo "Generado SQL_SCRIPT<br>";

	
		$this->writeFile(
			$carpetaScaffoldUser, 
			"md/database.php", 
			$config->generateConfig(
				$Proyecto->getNombreBaseDatos(), 
				$Proyecto->getNombreServidor(), 
				$Proyecto->getUsuarioBaseDatos(), 
				$Proyecto->getContrasenaBaseDatos())
			);
		

		$scriptsDataTables.='
	$(\'.dataTables_length\').addClass(\'bs-select\');
});';
		$this->writeFile($carpetaScaffoldUser, "assets/js/datatable.js", $scriptsDataTables);
		echo "Generado datatable<br>";
		
		$downloadPath = $this->compress($carpetaScaffoldUser, $Proyecto->getNombre());
		echo "Comprimido<br>";

		$this->deleteDir($carpetaScaffoldUser);
		echo "Borrado<br>";

		echo "Proceso Finalizado!! <br/><br/>
				Descargar: <a href='".$downloadPath."'>".$Proyecto->getNombre()."</a><br>";

	}

	function writeFile($carpetaScaffoldUser, $fileName, $contenidoIndexProy){
		if(!file_exists($carpetaScaffoldUser)){
			mkdir($carpetaScaffoldUser, 0777);
		}
		
		$fileConfig = fopen($carpetaScaffoldUser."/".$fileName, "w");
		fwrite($fileConfig, $contenidoIndexProy. PHP_EOL);
		fclose($fileConfig);
	}

	

	function generateMenu($nombreModelo, $contadorEntidades){
		if($contadorEntidades>5){ // Las primero 5 entidades ya están ingresadas en otro menú de seguridad.
			return '
								<a class="text-white dropdown-item display-4" href="../ct/'.$nombreModelo.'Controller.php">
									'.$nombreModelo.'
								</a>
			';

		}
	}

	
	
	public static function compress($carpetaScaffoldUser, $NombreProyecto){
		$zip = new ZipArchive();
		echo 'carpeta: '.$carpetaScaffoldUser;
		$dir = $carpetaScaffoldUser.'/';
		$rutaFinal = "../assets/compressed";

		if(!file_exists($rutaFinal)){
			mkdir($rutaFinal);
		}
		$archivoZip = $NombreProyecto.".zip";

		if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
			self::agregar_zip($dir, $zip);
			$zip->close();

			rename($archivoZip, "$rutaFinal/$archivoZip");
			
			if (file_exists($rutaFinal. "/" . $archivoZip)) {
				return $rutaFinal."/".$archivoZip;
			} else {
				echo "Error, archivo zip no ha sido creado!!";
			}
		}
	}

	public static function agregar_zip($dir, $zip) {
		if (is_dir($dir) && $da = opendir($dir)) {
			
			while (($archivo = readdir($da)) !== false) {

				if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
					self::agregar_zip($dir . $archivo . "/", $zip);

				} elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
					$zip->addFile($dir . $archivo, $dir . $archivo);
				}
			}
			closedir($da);
			
		}
	}

	public static function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}



}
?>

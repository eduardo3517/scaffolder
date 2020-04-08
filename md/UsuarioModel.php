<?php
	include_once "database.php";

Class UsuarioModel {

	private $id;
	private $Nombre;
	private $Apellido;
	private $CorreoElectronico;
	private $Contrasena;
	private $TipoUsuario;
	private	$db;

	function __construct ($id = "", $Nombre = "", $Apellido = "", $CorreoElectronico = "", $Contrasena = "", $TipoUsuario = ""){

    	$this->id=$id;
		$this->Nombre=$Nombre;
		$this->Apellido=$Apellido;
		$this->CorreoElectronico=$CorreoElectronico;
		$this->Contrasena=$Contrasena;
		$this->TipoUsuario=$TipoUsuario;
		$this->db=Database::$dbName;
    	
	}

	public function getId(){
		return $this->id;
	}

	
	public function getNombre(){
		return $this->Nombre;
	}

	public function setNombre($Nombre){
		$this->Nombre = $Nombre;
	}

	
	public function getApellido(){
		return $this->Apellido;
	}

	public function setApellido($Apellido){
		$this->Apellido = $Apellido;
	}

	
	public function getCorreoElectronico(){
		return $this->CorreoElectronico;
	}

	public function setCorreoElectronico($CorreoElectronico){
		$this->CorreoElectronico = $CorreoElectronico;
	}

	
	public function getContrasena(){
		return $this->Contrasena;
	}

	public function setContrasena($Contrasena){
		$this->Contrasena = $Contrasena;
	}

	
	public function getTipoUsuario(){
		return $this->TipoUsuario;
	}

	public function setTipoUsuario($TipoUsuario){
		$this->TipoUsuario = $TipoUsuario;
	}

	
  
	function create() {
    	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO ".$this->db.".Usuario (Nombre, Apellido, CorreoElectronico, Contrasena, TipoUsuario) values(?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
 		try {
			$q->execute(array($this->Nombre, $this->Apellido, $this->CorreoElectronico, password_hash($this->Contrasena, PASSWORD_DEFAULT), $this->TipoUsuario));
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
		$Usuarios = array();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".Usuario";
		$q = $pdo->prepare($sql);
		$q->execute();
		$results = $q->fetchAll();
		foreach ($results as $row) {
			array_push ($Usuarios, new UsuarioModel($row["id"], $row["Nombre"], $row["Apellido"], $row["CorreoElectronico"], $row["Contrasena"], $row["TipoUsuario"]));
		}
		Database::disconnect();
		return $Usuarios;
	}

	function read($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".Usuario WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		return new UsuarioModel($row["id"], $row["Nombre"], $row["Apellido"], $row["CorreoElectronico"], $row["Contrasena"], $row["TipoUsuario"]);
	}

	function delete($id){

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM ".$this->db.".Usuario WHERE ID = ?";
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
		$sql = "UPDATE ".$this->db.".Usuario SET Nombre=?, Apellido=?, CorreoElectronico=?, Contrasena=?, TipoUsuario=? WHERE id = ?";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array($this->Nombre, $this->Apellido, $this->CorreoElectronico, $this->Contrasena, $this->TipoUsuario, $this->id));
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			Database::disconnect();
			return $e->getCode();	
		}
	}

	

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

	


}
?>

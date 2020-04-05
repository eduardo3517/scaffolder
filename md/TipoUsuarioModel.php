<?php
	include_once "database.php";

Class TipoUsuarioModel {

	private $id;
	private $Nombre;
	private $Descripcion;
	private	$db;

	function __construct ($id = "", $Nombre = "", $Descripcion = ""){

    	$this->id=$id;
		$this->Nombre=$Nombre;
		$this->Descripcion=$Descripcion;
	  	$this->db="scaffolder2";
    	
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

	
	public function getDescripcion(){
		return $this->Descripcion;
	}

	public function setDescripcion($Descripcion){
		$this->Descripcion = $Descripcion;
	}

	
  
	function create() {
    	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO ".$this->db.".TipoUsuario (Nombre, Descripcion) values(?, ?)";
		$q = $pdo->prepare($sql);
 		try {
			$q->execute(array($this->Nombre, $this->Descripcion));
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
		$TipoUsuarios = array();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".TipoUsuario";
		$q = $pdo->prepare($sql);
		$q->execute();
		$results = $q->fetchAll();
		foreach ($results as $row) {
			array_push ($TipoUsuarios, new TipoUsuarioModel($row["id"], $row["Nombre"], $row["Descripcion"]));
		}
		Database::disconnect();
		return $TipoUsuarios;
	}

	function read($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".TipoUsuario WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		return new TipoUsuarioModel($row["id"], $row["Nombre"], $row["Descripcion"]);
	}

	function delete($id){

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM ".$this->db.".TipoUsuario WHERE ID = ?";
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
		$sql = "UPDATE ".$this->db.".TipoUsuario SET Nombre=?, Descripcion=? WHERE id = ?";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array($this->Nombre, $this->Descripcion, $this->id));
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			Database::disconnect();
			return $e->getCode();	
		}
	}


}
?>

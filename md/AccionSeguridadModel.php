<?php
	include_once "database.php";

Class AccionSeguridadModel {

	private $id;
	private $Codigo;
	private $Nombre;
	private	$db;

	function __construct ($id = "", $Codigo = "", $Nombre = ""){

    	$this->id=$id;
		$this->Codigo=$Codigo;
		$this->Nombre=$Nombre;
		$this->db=Database::getDataBaseName();
    	
	}

	public function getId(){
		return $this->id;
	}

	
	public function getCodigo(){
		return $this->Codigo;
	}

	public function setCodigo($Codigo){
		$this->Codigo = $Codigo;
	}

	
	public function getNombre(){
		return $this->Nombre;
	}

	public function setNombre($Nombre){
		$this->Nombre = $Nombre;
	}

	
  
	function create() {
    	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO ".$this->db.".AccionSeguridad (Codigo, Nombre) values(?, ?)";
		$q = $pdo->prepare($sql);
 		try {
			$q->execute(array($this->Codigo, $this->Nombre));
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
		$AccionSeguridads = array();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".AccionSeguridad";
		$q = $pdo->prepare($sql);
		$q->execute();
		$results = $q->fetchAll();
		foreach ($results as $row) {
			array_push ($AccionSeguridads, new AccionSeguridadModel($row["id"], $row["Codigo"], $row["Nombre"]));
		}
		Database::disconnect();
		return $AccionSeguridads;
	}

	function read($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".AccionSeguridad WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		return new AccionSeguridadModel($row["id"], $row["Codigo"], $row["Nombre"]);
	}

	function delete($id){

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM ".$this->db.".AccionSeguridad WHERE ID = ?";
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
		$sql = "UPDATE ".$this->db.".AccionSeguridad SET Codigo=?, Nombre=? WHERE id = ?";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array($this->Codigo, $this->Nombre, $this->id));
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			Database::disconnect();
			return $e->getCode();	
		}
	}


}
?>

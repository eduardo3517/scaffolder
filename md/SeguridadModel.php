<?php
	include_once "database.php";

Class SeguridadModel {

	private $id;
	private $TipoUsuario;
	private $EntidadSeguridad;
	private $AccionSeguridad;
	private	$db;

	function __construct ($id = "", $TipoUsuario = "", $EntidadSeguridad = "", $AccionSeguridad = ""){

    	$this->id=$id;
		$this->TipoUsuario=$TipoUsuario;
		$this->EntidadSeguridad=$EntidadSeguridad;
		$this->AccionSeguridad=$AccionSeguridad;
		$this->db=Database::getDataBaseName();
    	
	}

	public function getId(){
		return $this->id;
	}

	
	public function getTipoUsuario(){
		return $this->TipoUsuario;
	}

	public function setTipoUsuario($TipoUsuario){
		$this->TipoUsuario = $TipoUsuario;
	}

	
	public function getEntidadSeguridad(){
		return $this->EntidadSeguridad;
	}

	public function setEntidadSeguridad($EntidadSeguridad){
		$this->EntidadSeguridad = $EntidadSeguridad;
	}

	
	public function getAccionSeguridad(){
		return $this->AccionSeguridad;
	}

	public function setAccionSeguridad($AccionSeguridad){
		$this->AccionSeguridad = $AccionSeguridad;
	}

	
  
	function create() {
    	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO ".$this->db.".Seguridad (TipoUsuario, EntidadSeguridad, AccionSeguridad) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
 		try {
			$q->execute(array($this->TipoUsuario, $this->EntidadSeguridad, $this->AccionSeguridad));
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
		$Seguridads = array();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".Seguridad";
		$q = $pdo->prepare($sql);
		$q->execute();
		$results = $q->fetchAll();
		foreach ($results as $row) {
			array_push ($Seguridads, new SeguridadModel($row["id"], $row["TipoUsuario"], $row["EntidadSeguridad"], $row["AccionSeguridad"]));
		}
		Database::disconnect();
		return $Seguridads;
	}

	function read($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".Seguridad WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		return new SeguridadModel($row["id"], $row["TipoUsuario"], $row["EntidadSeguridad"], $row["AccionSeguridad"]);
	}

	function delete($id){

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM ".$this->db.".Seguridad WHERE ID = ?";
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
		$sql = "UPDATE ".$this->db.".Seguridad SET TipoUsuario=?, EntidadSeguridad=?, AccionSeguridad=? WHERE id = ?";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array($this->TipoUsuario, $this->EntidadSeguridad, $this->AccionSeguridad, $this->id));
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			Database::disconnect();
			return $e->getCode();	
		}
	}


}
?>

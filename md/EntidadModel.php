<?php
	include_once "database.php";

Class EntidadModel {

	private $id;
	private $Nombre;
	private $Proyecto;
	private $TieneSeguridadUsuario;
	private $FechaCreacion;
	private $FechaUltimaModificacion;
	private $Comentario;
	private $Relacion;
	private	$db;

	function __construct ($id = "", $Nombre = "", $Proyecto = "", $TieneSeguridadUsuario = "", $FechaCreacion = "", $FechaUltimaModificacion = "", $Comentario = "", $Relacion = ""){

    	$this->id=$id;
		$this->Nombre=$Nombre;
		$this->Proyecto=$Proyecto;
		$this->TieneSeguridadUsuario=$TieneSeguridadUsuario;
		$this->FechaCreacion=$FechaCreacion;
		$this->FechaUltimaModificacion=$FechaUltimaModificacion;
		$this->Comentario=$Comentario;
		$this->Relacion=$Relacion;
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

	
	public function getProyecto(){
		return $this->Proyecto;
	}

	public function setProyecto($Proyecto){
		$this->Proyecto = $Proyecto;
	}

	
	public function getTieneSeguridadUsuario(){
		return $this->TieneSeguridadUsuario;
	}

	public function setTieneSeguridadUsuario($TieneSeguridadUsuario){
		$this->TieneSeguridadUsuario = $TieneSeguridadUsuario;
	}

	
	public function getFechaCreacion(){
		return $this->FechaCreacion;
	}

	public function setFechaCreacion($FechaCreacion){
		$this->FechaCreacion = $FechaCreacion;
	}

	
	public function getFechaUltimaModificacion(){
		return $this->FechaUltimaModificacion;
	}

	public function setFechaUltimaModificacion($FechaUltimaModificacion){
		$this->FechaUltimaModificacion = $FechaUltimaModificacion;
	}

	
	public function getComentario(){
		return $this->Comentario;
	}

	public function setComentario($Comentario){
		$this->Comentario = $Comentario;
	}

	
	public function getRelacion(){
		return $this->Relacion;
	}

	public function setRelacion($Relacion){
		$this->Relacion = $Relacion;
	}

	
  
	function create() {
    	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO ".$this->db.".Entidad (Nombre, Proyecto, TieneSeguridadUsuario, Comentario, Relacion) values(?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array($this->Nombre, $this->Proyecto, $this->TieneSeguridadUsuario,  $this->Comentario, $this->Relacion));
			$this->id = $pdo->lastInsertId();
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			
			Database::disconnect();
			return $e->getCode();	
		}
	}


	function list($project){

		$pdo = Database::connect();
		$Entidads = array();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".Entidad where Proyecto = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($project));
		$results = $q->fetchAll();
		foreach ($results as $row) {
			array_push ($Entidads, new EntidadModel($row["id"], $row["Nombre"], $row["Proyecto"], $row["TieneSeguridadUsuario"], $row["FechaCreacion"], $row["FechaUltimaModificacion"], $row["Comentario"], $row["Relacion"]));
		}
		Database::disconnect();
		return $Entidads;
	}

	function read($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".Entidad WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		return new EntidadModel($row["id"], $row["Nombre"], $row["Proyecto"], $row["TieneSeguridadUsuario"], $row["FechaCreacion"], $row["FechaUltimaModificacion"], $row["Comentario"], $row["Relacion"]);
	}

	function delete($id){

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM ".$this->db.".Entidad WHERE ID = ?";
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
		$sql = "UPDATE ".$this->db.".Entidad SET Nombre=?, Proyecto=?, TieneSeguridadUsuario=?, FechaUltimaModificacion=CURRENT_TIMESTAMP, Comentario=?, Relacion=? WHERE id = ?";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array($this->Nombre, $this->Proyecto, $this->TieneSeguridadUsuario,$this->Comentario, $this->Relacion, $this->id));
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			Database::disconnect();
			return $e->getCode();	
		}
	}


}
?>

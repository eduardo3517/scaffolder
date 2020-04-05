<?php
	include_once "database.php";

Class CampoModel {

	private $id;
	private $Nombre;
	private $Longitud;
	private $EsNull;
	private $Tipo;
	private $EsVisible;
	private $ValorDefault;
	private $Entidad;
	private $FechaCreacion;
	private $FechaUltimaModificacion;
	private $RelacionEntidad;
	private $RelacionEntidadCampo;
	private $Comentarios;
	private	$db;

	function __construct (
		$id = "", 
		$Nombre = "", 
		$Longitud = "", 
		$EsNull = "", 
		$Tipo = "", 
		$EsVisible = "", 
		$ValorDefault = "", 
		$Entidad = "", 
		$FechaCreacion = "", 
		$FechaUltimaModificacion = "", 
		$RelacionEntidad = "", 
		$RelacionEntidadCampo = "", 
		$Comentarios = ""){

    	$this->id=$id;
		$this->Nombre=$Nombre;
		$this->Longitud=$Longitud;
		$this->EsNull=$EsNull;
		$this->Tipo=$Tipo;
		$this->EsVisible=$EsVisible;
		$this->ValorDefault=$ValorDefault;
		$this->Entidad=$Entidad;
		$this->FechaCreacion=$FechaCreacion;
		$this->FechaUltimaModificacion=$FechaUltimaModificacion;
		$this->RelacionEntidad=$RelacionEntidad;
		$this->RelacionEntidadCampo=$RelacionEntidadCampo;
		$this->Comentarios=$Comentarios;
	  	$this->db="scaffolder2";
    	
	}
	public function setId($Id){
		$this->id = $Id;
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

	
	public function getLongitud(){
		return $this->Longitud;
	}

	public function setLongitud($Longitud){
		$this->Longitud = $Longitud;
	}

	
	public function getEsNull(){
		return $this->EsNull;
	}

	public function setEsNull($EsNull){
		$this->EsNull = $EsNull;
	}

	
	public function getTipo(){
		return $this->Tipo;
	}

	public function setTipo($Tipo){
		$this->Tipo = $Tipo;
	}

	
	public function getEsVisible(){
		return $this->EsVisible;
	}

	public function setEsVisible($EsVisible){
		$this->EsVisible = $EsVisible;
	}

	
	public function getValorDefault(){
		return $this->ValorDefault;
	}

	public function setValorDefault($ValorDefault){
		$this->ValorDefault = $ValorDefault;
	}

	
	public function getEntidad(){
		return $this->Entidad;
	}

	public function setEntidad($Entidad){
		$this->Entidad = $Entidad;
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

	
	public function getRelacionEntidad(){
		return $this->RelacionEntidad;
	}

	public function setRelacionEntidad($RelacionEntidad){
		$this->RelacionEntidad = $RelacionEntidad;
	}

	
	public function getRelacionEntidadCampo(){
		return $this->RelacionEntidadCampo;
	}

	public function setRelacionEntidadCampo($RelacionEntidadCampo){
		$this->RelacionEntidadCampo = $RelacionEntidadCampo;
	}

	
	public function getComentarios(){
		return $this->Comentarios;
	}

	public function setComentarios($Comentarios){
		$this->Comentarios = $Comentarios;
	}

	
  
	function create() {
    	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO ".$this->db.".Campo (Nombre, Longitud, EsNull, Tipo, EsVisible, ValorDefault, Entidad, RelacionEntidad, RelacionEntidadCampo, Comentarios) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
 		try {
			$q->execute(
				array(
					$this->Nombre,
					$this->Longitud, 
					$this->EsNull, 
					$this->Tipo, 
					$this->EsVisible, 
					$this->ValorDefault, 
					$this->Entidad, 
					$this->RelacionEntidad, 
					$this->RelacionEntidadCampo, 
					$this->Comentarios));
			$this->id = $pdo->lastInsertId();
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			
			Database::disconnect();
			return $e->getCode();	
		}
	}


	function list($entity){

		$pdo = Database::connect();
		$Campos = array();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".Campo WHERE Entidad = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($entity));
		$results = $q->fetchAll();
		foreach ($results as $row) {
			array_push ($Campos, new CampoModel(
				$row["id"], 
				$row["Nombre"], 
				$row["Longitud"], 
				$row["EsNull"], 
				$row["Tipo"], 
				$row["EsVisible"], 
				$row["ValorDefault"], 
				$row["Entidad"], 
				$row["FechaCreacion"], 
				$row["FechaUltimaModificacion"], 
				$row["RelacionEntidad"], 
				$row["RelacionEntidadCampo"], 
				$row["Comentarios"]
			));
		}
		Database::disconnect();
		return $Campos;
	}

	function read($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".Campo WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		return new CampoModel(
			$row["id"], 
			$row["Nombre"], 
			$row["Longitud"], 
			$row["EsNull"], 
			$row["Tipo"], 
			$row["EsVisible"], 
			$row["ValorDefault"], 
			$row["Entidad"], 
			$row["FechaCreacion"], 
			$row["FechaUltimaModificacion"], 
			$row["RelacionEntidad"], 
			$row["RelacionEntidadCampo"], 
			$row["Comentarios"]
		);
	}

	function delete($id){

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM ".$this->db.".Campo WHERE ID = ?";
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
		$sql = "UPDATE ".$this->db.".Campo SET Nombre=?, Longitud=?, EsNull=?, Tipo=?, EsVisible=?, ValorDefault=?, FechaUltimaModificacion=CURRENT_TIMESTAMP, RelacionEntidad=?, RelacionEntidadCampo=?, Comentarios=? WHERE id = ?";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array(
				$this->Nombre, 
				$this->Longitud, 
				$this->EsNull, 
				$this->Tipo, 
				$this->EsVisible, 
				$this->ValorDefault,
				$this->RelacionEntidad, 
				$this->RelacionEntidadCampo, 
				$this->Comentarios, 
				$this->id)
			);
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			Database::disconnect();
			return $e->getCode();	
		}
	}


}
?>

<?php
	include_once "database.php";

Class TipoCampoModel {

	private $id;
	private $Nombre;
	private $ValorBD;
	private $ValorForm;
	private $Placeholder;
	private	$db;

	function __construct ($id = "", $Nombre = "", $ValorBD = "", $ValorForm = "", $Placeholder=""){

    	$this->id=$id;
		$this->Nombre=$Nombre;
		$this->ValorBD=$ValorBD;
		$this->ValorForm=$ValorForm;
		$this->Placeholder = $Placeholder;
		$this->db=Database::getDataBaseName();
    	
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

	
	public function getValorBD(){
		return $this->ValorBD;
	}

	public function setValorBD($ValorBD){
		$this->ValorBD = $ValorBD;
	}

	
	public function getValorForm(){
		return $this->ValorForm;
	}

	public function setValorForm($ValorForm){
		$this->ValorForm = $ValorForm;
	}

	public function getPlaceHolder(){
		return $this->Placeholder;
	}

	public function setPlaceholder($Placeholder){
		$this->Placeholder = $Placeholder;
	}

	
  
	function create() {
    	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO ".$this->db.".TipoCampo (Nombre, ValorBD, ValorForm, Placeholder) values(?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
 		try {
			$q->execute(array($this->Nombre, $this->ValorBD, $this->ValorForm, $this->Placeholder));
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
		$TipoCampos = array();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".TipoCampo";
		$q = $pdo->prepare($sql);
		$q->execute();
		$results = $q->fetchAll();
		foreach ($results as $row) {
			array_push ($TipoCampos, new TipoCampoModel($row["id"], $row["Nombre"], $row["ValorBD"], $row["ValorForm"], $row["Placeholder"]));
		}
		Database::disconnect();
		return $TipoCampos;
	}

	function read($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ".$this->db.".TipoCampo WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		return new TipoCampoModel($row["id"], $row["Nombre"], $row["ValorBD"], $row["ValorForm"], $row["Placeholder"]);
	}

	function delete($id){

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM ".$this->db.".TipoCampo WHERE ID = ?";
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
		$sql = "UPDATE ".$this->db.".TipoCampo SET Nombre=?, ValorBD=?, ValorForm=?, Placeholder=? WHERE id = ?";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array($this->Nombre, $this->ValorBD, $this->ValorForm, $this->Placeholder, $this->id));
			Database::disconnect();
			return "";
		} catch (Exception $e) {
			Database::disconnect();
			return $e->getCode();	
		}
	}


}
?>

<?php 

class Model{

    

    function generateModel($entidad, $nombreModelo, $resultadoCampo, $baseDatos){
		$ScriptSiUsuario = '';

		if($entidad->getTieneSeguridadUsuario()==1){
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
	private $'.$rowCampo->getNombre().';';
			if($rowCampo->getTipo()==10){
				$contenidoModel.='
	private $'.$rowCampo->getNombre().'Type;';
			}
		 }
	 
	

  	$contenidoModel.='
	private	$db;

	function __construct (){

	  	$this->db="'.$baseDatos.'";
    	
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	';
	foreach ($resultadoCampo as $rowCampo) {
		
		$contenidoModel.='
	public function get'.$rowCampo->getNombre().'(){
		return $this->'.$rowCampo->getNombre().';
	}

	public function set'.$rowCampo->getNombre().'($'.$rowCampo->getNombre().'){
		$this->'.$rowCampo->getNombre().' = $'.$rowCampo->getNombre().';
	}

	';
		if($rowCampo->getTipo()==10){
			$contenidoModel.='
	public function get'.$rowCampo->getNombre().'Type(){
		return $this->'.$rowCampo->getNombre().'Type;
	}

	public function set'.$rowCampo->getNombre().'Type($'.$rowCampo->getNombre().'Type){
		$this->'.$rowCampo->getNombre().'Type = $'.$rowCampo->getNombre().'Type;
	}

	';
		}
	}
	$contenidoModel.='
  
	function create() {
    	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO ".$this->db.".'.$nombreModelo.' (
			';
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo->getTipo()<>9){
				if($rowCampo->getTipo()==10){
					$contenidoModel.=$rowCampo->getNombre().', 
			';
					$contenidoModel.=$rowCampo->getNombre().'Type, 
			';
				} else {
					$contenidoModel.=$rowCampo->getNombre().', 
			';
					
				}
			}
			
		
      	}
      	//elimina la ultima coma
      	$contenidoModel = substr($contenidoModel, 0, -6);
		$contenidoModel.=') values (';
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo->getTipo()<>9){
				if($rowCampo->getTipo()==10){
					$contenidoModel.='?, ?, ';
				} else {
					$contenidoModel.='?, ';
				}
			}
		
      	}
      	//elimina la ultima coma
      	$contenidoModel = substr($contenidoModel, 0, -2);
		$contenidoModel.=')";
		$q = $pdo->prepare($sql);
 		try {
			$q->execute(array(
				';
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo->getTipo()<>9){
				if ($rowCampo->getTipo() == 6){
					$contenidoModel.='password_hash($this->'.$rowCampo->getNombre().', PASSWORD_DEFAULT), 
				';
				} else if($rowCampo->getTipo()==10){
					$contenidoModel.='$this->'.$rowCampo->getNombre().', 
				$this->'.$rowCampo->getNombre().'Type["mime"], 
				';
				} else {
					$contenidoModel.='$this->'.$rowCampo->getNombre().', 
				';
				}
			}
		
      	}
		  //elimina la ultima coma
		//echo $contenidoModel;
      	$contenidoModel = substr($contenidoModel, 0, -7);
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
			$'.$nombreModelo.' = new '.$nombreModelo.'Model();
			$'.$nombreModelo.'->setId($row["id"]);';

			
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.='
			$'.$nombreModelo.'->set'.$rowCampo->getNombre().'($row["'.$rowCampo->getNombre().'"]);';
		
		  }
		  $contenidoModel.='
		  	array_push ($'.$nombreModelo.'s, $'.$nombreModelo.');';
		
		$contenidoModel.='
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
		$'.$nombreModelo.' = new '.$nombreModelo.'Model();
		$'.$nombreModelo.'->setId($row["id"]);';

			
		foreach ($resultadoCampo as $rowCampo) {
			$contenidoModel.='
		$'.$nombreModelo.'->set'.$rowCampo->getNombre().'($row["'.$rowCampo->getNombre().'"]);';
		
		}
		$contenidoModel.='
		return $'.$nombreModelo.';
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
			if($rowCampo->getTipo()<>9){
				if($rowCampo->getTipo()==10){
					$contenidoModel.=$rowCampo->getNombre().'=?, '.$rowCampo->getNombre().'Type =?, ';
				} else {
					$contenidoModel.=$rowCampo->getNombre().'=?, ';
				}
			}
      	}
      	//elimina la ultima coma
      	$contenidoModel = substr($contenidoModel, 0, -2);
		$contenidoModel.=' WHERE id = ?";
		$q = $pdo->prepare($sql);
		try {
			$q->execute(array(';
			if($rowCampo->getTipo()<>9){
				if ($rowCampo->getTipo() == 6){
					$contenidoModel.='password_hash($this->'.$rowCampo->getNombre().', PASSWORD_DEFAULT), ';
				} else if($rowCampo->getTipo()==10){
					$contenidoModel.='$this->'.$rowCampo->getNombre().', $this->'.$rowCampo->getNombre().'Type["mime"], ';
				} else {
					$contenidoModel.='$this->'.$rowCampo->getNombre().', ';
				}
			}
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
		return $contenidoModel;
	}
}

?>
	

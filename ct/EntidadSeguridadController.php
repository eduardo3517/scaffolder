<?php
  
include '../md/EntidadSeguridadModel.php';
include '../md/UsuarioModel.php';
include_once '../util/Messages.php';

class EntidadSeguridadController{
    
	private $EntidadSeguridadModel;
	private const SESSION_TAG = "IDUSUARIOSISTEMAGeneracion/17";
    
	public function __CONSTRUCT(){
		$this->EntidadSeguridadModel = new EntidadSeguridadModel();
		if(!isset($_SESSION)) { 
			session_start();
		}
	}

	public function direccionar($c, $mensaje){
		if(!isset($_SESSION[$this::SESSION_TAG])){
			require_once "../vw/Templates/header.php";
			require_once "../vw/login.php";
			require_once "../vw/Templates/footer.php";
		} else {
			$UsuarioModel = new UsuarioModel();
			$UsuarioLogueado = $UsuarioModel->read($_SESSION[$this::SESSION_TAG]);
			$Permiso = $UsuarioModel->getPermissions($_SESSION[$this::SESSION_TAG], 3);

			if ($Permiso==-1){
				require_once "../vw/Templates/header.php";
				require_once "../vw/PaginaError.php";
				require_once "../vw/Templates/footer.php";
				
			} else {

				switch ($c){
					case "c":
						require_once "../vw/EntidadSeguridad/create.php";
					break;

					case "i":
						if (in_array(5, $Permiso)){
							
							require_once "../vw/EntidadSeguridad/index.php";
						}
					break;

					case "r":
						require_once "../vw/EntidadSeguridad/read.php";
					break;

					case "d":
						require_once "../vw/EntidadSeguridad/delete.php";
					break;

					case "u":
						require_once "../vw/EntidadSeguridad/update.php";
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

        return $this->EntidadSeguridadModel->list();
        
	}

	public function read($id){

        return $this->EntidadSeguridadModel->read($id);
        
	}


	public function create(){
      
		
		$Codigo = trim($_REQUEST["Codigo"]);
		$Nombre = trim($_REQUEST["Nombre"]);
		
		$EntidadSeguridad = new EntidadSeguridadModel("", $Codigo, $Nombre);
		$message = $EntidadSeguridad->create(); 
		if ($message==23000){
			$this->direccionar("i",  Messages::DUPLICATED_CREATE_ERROR);
		} else if ($message != ""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			
			$this->direccionar("i", Messages::CREATE_SUCCESS);
		}
		
	}
                                    
	public function update(){

		$id = trim($_REQUEST["id"]);
		$Codigo = trim($_REQUEST["Codigo"]);
		$Nombre = trim($_REQUEST["Nombre"]);
		$EntidadSeguridad = new EntidadSeguridadModel($id, $Codigo, $Nombre);
		
		$message = $EntidadSeguridad->update(); //realiza la operación de actualizado
		if ($message==23000){
			$this->direccionar("i", Messages::DUPLICATED_UPDATE_ERROR);
		} else if($message != ""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::UPDATE_SUCCESS);
		}
	}
    
	public function delete(){
		$id = trim($_REQUEST["id"]);
		$message = $this->EntidadSeguridadModel->delete($id);
		if ($message==23000){
			$this->direccionar("i", Messages::RELATED_REG_DELETE_ERROR);
		} else if ($message!=""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::DELETE_SUCCESS);
		}
	}

	
}
 
$controladorEntidadSeguridad = new EntidadSeguridadController();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controladorEntidadSeguridad->direccionar($c, "");

?>

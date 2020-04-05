<?php
  
include '../md/SeguridadModel.php';
include '../md/UsuarioModel.php';
include_once '../util/Messages.php';

class SeguridadController{
    
	private $SeguridadModel;
	private const SESSION_TAG = "IDUSUARIOSISTEMAGeneracion/17";
    
	public function __CONSTRUCT(){
		$this->SeguridadModel = new SeguridadModel();
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
			$Permiso = $UsuarioModel->getPermissions($_SESSION[$this::SESSION_TAG], 5);

			if ($Permiso==-1){
				require_once "../vw/Templates/header.php";
				require_once "../vw/PaginaError.php";
				require_once "../vw/Templates/footer.php";
				
			} else {

				switch ($c){
					case "c":
						require_once "../vw/Seguridad/create.php";
					break;

					case "i":
						if (in_array(5, $Permiso)){
							
							require_once "../vw/Seguridad/index.php";
						}
					break;

					case "r":
						require_once "../vw/Seguridad/read.php";
					break;

					case "d":
						require_once "../vw/Seguridad/delete.php";
					break;

					case "u":
						require_once "../vw/Seguridad/update.php";
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

        return $this->SeguridadModel->list();
        
	}

	public function read($id){

        return $this->SeguridadModel->read($id);
        
	}


	public function create(){
      
		
		$TipoUsuario = trim($_REQUEST["TipoUsuario"]);
		$EntidadSeguridad = trim($_REQUEST["EntidadSeguridad"]);
		$AccionSeguridad = trim($_REQUEST["AccionSeguridad"]);
		
		$Seguridad = new SeguridadModel("", $TipoUsuario, $EntidadSeguridad, $AccionSeguridad);
		$message = $Seguridad->create(); 
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
		$TipoUsuario = trim($_REQUEST["TipoUsuario"]);
		$EntidadSeguridad = trim($_REQUEST["EntidadSeguridad"]);
		$AccionSeguridad = trim($_REQUEST["AccionSeguridad"]);
		$Seguridad = new SeguridadModel($id, $TipoUsuario, $EntidadSeguridad, $AccionSeguridad);
		
		$message = $Seguridad->update(); //realiza la operación de actualizado
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
		$message = $this->SeguridadModel->delete($id);
		if ($message==23000){
			$this->direccionar("i", Messages::RELATED_REG_DELETE_ERROR);
		} else if ($message!=""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::DELETE_SUCCESS);
		}
	}

	
}
 
$controladorSeguridad = new SeguridadController();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controladorSeguridad->direccionar($c, "");

?>

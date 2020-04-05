<?php
  
include '../md/AccionSeguridadModel.php';
include '../md/UsuarioModel.php';
include_once '../util/Messages.php';

class AccionSeguridadController{
    
	private $AccionSeguridadModel;
	private const SESSION_TAG = "IDUSUARIOSISTEMAGeneracion/17";
    
	public function __CONSTRUCT(){
		$this->AccionSeguridadModel = new AccionSeguridadModel();
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
			$Permiso = $UsuarioModel->getPermissions($_SESSION[$this::SESSION_TAG], 4);

			if ($Permiso==-1){
				require_once "../vw/Templates/header.php";
				require_once "../vw/PaginaError.php";
				require_once "../vw/Templates/footer.php";
				
			} else {

				switch ($c){
					case "c":
						require_once "../vw/AccionSeguridad/create.php";
					break;

					case "i":
						if (in_array(5, $Permiso)){
							
							require_once "../vw/AccionSeguridad/index.php";
						}
					break;

					case "r":
						require_once "../vw/AccionSeguridad/read.php";
					break;

					case "d":
						require_once "../vw/AccionSeguridad/delete.php";
					break;

					case "u":
						require_once "../vw/AccionSeguridad/update.php";
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

        return $this->AccionSeguridadModel->list();
        
	}

	public function read($id){

        return $this->AccionSeguridadModel->read($id);
        
	}


	public function create(){
      
		
		$Codigo = trim($_REQUEST["Codigo"]);
		$Nombre = trim($_REQUEST["Nombre"]);
		
		$AccionSeguridad = new AccionSeguridadModel("", $Codigo, $Nombre);
		$message = $AccionSeguridad->create(); 
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
		$AccionSeguridad = new AccionSeguridadModel($id, $Codigo, $Nombre);
		
		$message = $AccionSeguridad->update(); //realiza la operación de actualizado
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
		$message = $this->AccionSeguridadModel->delete($id);
		if ($message==23000){
			$this->direccionar("i", Messages::RELATED_REG_DELETE_ERROR);
		} else if ($message!=""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::DELETE_SUCCESS);
		}
	}

	
}
 
$controladorAccionSeguridad = new AccionSeguridadController();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controladorAccionSeguridad->direccionar($c, "");

?>

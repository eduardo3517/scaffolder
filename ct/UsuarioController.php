<?php
include '../md/UsuarioModel.php';
include_once '../util/Messages.php';

class UsuarioController{
    
	private $UsuarioModel;
	private const SESSION_TAG = "IDUSUARIOSISTEMAGeneracion/17";
    
	public function __CONSTRUCT(){
		$this->UsuarioModel = new UsuarioModel();
		if(!isset($_SESSION)) { 
			session_start();
		}
	}

	public function direccionar($c, $mensaje){
		if(!isset($_SESSION[$this::SESSION_TAG]) && $c!='lg'){
			require_once "../vw/Templates/header.php";
			require_once "../vw/login.php";
			require_once "../vw/Templates/footer.php";
		} else {
			$UsuarioLogueado = $this->UsuarioModel->read($_SESSION[$this::SESSION_TAG]);
			$Permiso = $this->UsuarioModel->getPermissions($_SESSION[$this::SESSION_TAG], 2);

			if ($Permiso==-1){
				require_once "../vw/Templates/header.php";
				require_once "../vw/PaginaError.php";
				require_once "../vw/Templates/footer.php";
				
			} else {

				switch ($c){
					case "c":
						require_once "../vw/Usuario/create.php";
					break;

					case "i":
						if (in_array(5, $Permiso)){
							
							require_once "../vw/Usuario/index.php";
						}
					break;

					case "r":
						require_once "../vw/Usuario/read.php";
					break;

					case "d":
						require_once "../vw/Usuario/delete.php";
					break;

					case "u":
						require_once "../vw/Usuario/update.php";
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

        return $this->UsuarioModel->list();
        
	}

	public function read($id){

        return $this->UsuarioModel->read($id);
        
	}


	public function create(){
      
		
		$Nombre = trim($_REQUEST["Nombre"]);
		$Apellido = trim($_REQUEST["Apellido"]);
		$CorreoElectronico = trim($_REQUEST["CorreoElectronico"]);
		$Contrasena = trim($_REQUEST["Contrasena"]);
		$TipoUsuario = trim($_REQUEST["TipoUsuario"]);
		
		$Usuario = new UsuarioModel("", $Nombre, $Apellido, $CorreoElectronico, $Contrasena, $TipoUsuario);
		$message = $Usuario->create(); 
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
		$Nombre = trim($_REQUEST["Nombre"]);
		$Apellido = trim($_REQUEST["Apellido"]);
		$CorreoElectronico = trim($_REQUEST["CorreoElectronico"]);
		$Contrasena = trim($_REQUEST["Contrasena"]);
		$TipoUsuario = trim($_REQUEST["TipoUsuario"]);
		$Usuario = new UsuarioModel($id, $Nombre, $Apellido, $CorreoElectronico, $Contrasena, $TipoUsuario);
		
		$message = $Usuario->update(); //realiza la operación de actualizado
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
		$message = $this->UsuarioModel->delete($id);
		if ($message==23000){
			$this->direccionar("i", Messages::RELATED_REG_DELETE_ERROR);
		} else if ($message!=""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::DELETE_SUCCESS);
		}
	}

	
}
 
$controladorUsuario = new UsuarioController();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controladorUsuario->direccionar($c, "");

?>

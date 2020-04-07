
<?php
include '../md/UsuarioModel.php';
include_once '../util/Messages.php';

class AccessController{
	
	private $UsuarioModel;
	private const SESSION_TAG = "IDUSUARIOSISTEMAGeneracion/17";
	
	public function __CONSTRUCT(){
		$this->UsuarioModel = new UsuarioModel();
		if(!isset($_SESSION)) { 
			session_start();
		}
	}

	public function direccionar($c, $mensaje){
		echo $c;
		
		switch ($c){
			case "lg":

				$idUsuario = $this->UsuarioModel->loggin($_REQUEST["CorreoElectronico"], $_REQUEST["Contrasena"]);
				
				if($idUsuario==-1){
					$mensaje = Messages::ERROR_LOGIN;
					require_once "../vw/Templates/header.php";
					require_once "../vw/login.php";
					require_once "../vw/Templates/footer.php";
				}else{
					if(!isset($_SESSION)) { 
						session_start();
					}
					$_SESSION[$this::SESSION_TAG]=$idUsuario;
					header("Location: ProyectoController.php");
				}

			break;

			case "cs":
				if(!isset($_SESSION)) { 
					session_start();
				}
				//se destruyen todas las variables de sesión usadas en algun módulo del sistema
				unset($_SESSION[$this::SESSION_TAG]); 
				session_destroy(); 
				//se redirecciona a la página principal.
				header ("Location: ../index.php");
			break;
		} 
	}
}
 
$controladorAccess = new AccessController();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controladorAccess->direccionar($c, "");

?>

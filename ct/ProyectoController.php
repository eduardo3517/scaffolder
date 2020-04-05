<?php
  
include '../md/ProyectoModel.php';
include '../md/UsuarioModel.php';
include_once '../util/Messages.php';

class ProyectoController{
    
	private $ProyectoModel;
	private const SESSION_TAG = "IDUSUARIOSISTEMAGeneracion/17";
    
	public function __CONSTRUCT(){
		$this->ProyectoModel = new ProyectoModel();
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
			$Permiso = $UsuarioModel->getPermissions($_SESSION[$this::SESSION_TAG], 6);

			if ($Permiso==-1){
				require_once "../vw/Templates/header.php";
				require_once "../vw/PaginaError.php";
				require_once "../vw/Templates/footer.php";
				
			} else {

				switch ($c){
					case "c":
						require_once "../vw/Proyecto/create.php";
					break;

					case "i":
						if (in_array(5, $Permiso)){
							
							require_once "../vw/Proyecto/index.php";
						}
					break;

					case "r":
						require_once "../vw/Proyecto/read.php";
					break;

					case "d":
						require_once "../vw/Proyecto/delete.php";
					break;

					case "u":
						require_once "../vw/Proyecto/update.php";
					break;

					case "b":
						$this->delete();
					break;

					case "g":
						$this->create();
					break;

					case "gen":
						require_once "../vw/Proyecto/build.php";
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

        return $this->ProyectoModel->list();
        
	}

	public function read($id){

        return $this->ProyectoModel->read($id);
        
	}


	public function create(){
		
		$Proyecto = new ProyectoModel();
		$Proyecto->setId("");
		$Proyecto->setNombre(trim($_REQUEST["Nombre"]));
		$Proyecto->setFechaCreacion("");
		$Proyecto->setNombreServidor(trim($_REQUEST["NombreServidor"]));
		$Proyecto->setNombreBaseDatos(trim($_REQUEST["NombreBaseDatos"]));
		$Proyecto->setUsuarioBaseDatos(trim($_REQUEST["UsuarioBaseDatos"]));
		$Proyecto->setContrasenaBaseDatos(trim($_REQUEST["ContrasenaBaseDatos"]));
		$Proyecto->setFechaUltimaModificacion("");
		$Proyecto->setUsuario(trim($_REQUEST["Usuario"]));

		$message = $Proyecto->create(); 
		if ($message==23000){
			$this->direccionar("i",  Messages::DUPLICATED_CREATE_ERROR);
		} else if ($message != ""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::CREATE_SUCCESS);
		}
		
	}
                                    
	public function update(){

		
		$Proyecto = new ProyectoModel();
		$Proyecto->setId("");
		$Proyecto->setNombre(trim($_REQUEST["Nombre"]));
		$Proyecto->setFechaCreacion("");
		$Proyecto->setNombreServidor(trim($_REQUEST["NombreServidor"]));
		$Proyecto->setNombreBaseDatos(trim($_REQUEST["NombreBaseDatos"]));
		$Proyecto->setUsuarioBaseDatos(trim($_REQUEST["UsuarioBaseDatos"]));
		$Proyecto->setContrasenaBaseDatos(trim($_REQUEST["ContrasenaBaseDatos"]));
		$Proyecto->setFechaUltimaModificacion("");
		$Proyecto->setUsuario("");
		$message = $Proyecto->update(); //realiza la operación de actualizado
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
		$message = $this->ProyectoModel->delete($id);
		if ($message==23000){
			$this->direccionar("i", Messages::RELATED_REG_DELETE_ERROR);
		} else if ($message!=""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::DELETE_SUCCESS);
		}
	}


	
}
 
$controladorProyecto = new ProyectoController();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controladorProyecto->direccionar($c, "");

?>

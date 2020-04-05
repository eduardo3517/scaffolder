<?php
  
include '../md/EntidadModel.php';
include '../md/UsuarioModel.php';
include_once '../util/Messages.php';

class EntidadController{
    
	private $EntidadModel;
	private const SESSION_TAG = "IDUSUARIOSISTEMAGeneracion/17";
    
	public function __CONSTRUCT(){
		$this->EntidadModel = new EntidadModel();
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
			$Permiso = $UsuarioModel->getPermissions($_SESSION[$this::SESSION_TAG], 7);
			include_once '../md/ProyectoModel.php';
			$project = (new ProyectoModel())->read($_SESSION["projectId".$this::SESSION_TAG]);
			

			if ($Permiso==-1){
				require_once "../vw/Templates/header.php";
				require_once "../vw/PaginaError.php";
				require_once "../vw/Templates/footer.php";
				
			} else {

				switch ($c){
					case "c":
						require_once "../vw/Entidad/create.php";
					break;

					case "i":
						if (in_array(5, $Permiso)){
							
							require_once "../vw/Entidad/index.php";
						}
					break;
					//comes from project master
					case "ie":
						
						$_SESSION["projectId".$this::SESSION_TAG] = $_REQUEST["id"];
					break;

					case "em":
						$entidadesMostrar =$this->EntidadModel->list($_SESSION["projectId".$this::SESSION_TAG]);
						
						foreach ($entidadesMostrar as $row) {
							echo '
							<option value="'.$row->getId().'">'. $row->getNombre().'</option>';
						}
					break;

					case "r":
						require_once "../vw/Entidad/read.php";
					break;

					case "d":
						require_once "../vw/Entidad/delete.php";
					break;

					case "u":
						require_once "../vw/Entidad/update.php";
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
	
    
	public function list($project){

        return $this->EntidadModel->list($project);
        
	}

	public function read($id){

        return $this->EntidadModel->read($id);
        
	}


	public function create(){
		
		$Nombre = trim($_REQUEST["Nombre"]);
		$Proyecto = trim($_REQUEST["Proyecto"]);
		$TieneSeguridadUsuario = isset($_REQUEST["TieneSeguridadUsuario"])==1?1:0;
		$Comentario = trim($_REQUEST["Comentario"]);
		$Relacion = 0;
		
		$Entidad = new EntidadModel("", $Nombre, $Proyecto, $TieneSeguridadUsuario, "", "", $Comentario, $Relacion);
		$message = $Entidad->create(); 
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
		$Proyecto = trim($_REQUEST["Proyecto"]);
		$TieneSeguridadUsuario = isset($_REQUEST["TieneSeguridadUsuario"])==1?1:0;
		$Comentario = trim($_REQUEST["Comentario"]);
		$Relacion = 0;
		$Entidad = new EntidadModel($id, $Nombre, $Proyecto, $TieneSeguridadUsuario, "", "", $Comentario, $Relacion);
		
		$message = $Entidad->update(); //realiza la operación de actualizado
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
		$message = $this->EntidadModel->delete($id);
		if ($message==23000){
			$this->direccionar("i", Messages::RELATED_REG_DELETE_ERROR);
		} else if ($message!=""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::DELETE_SUCCESS);
		}
	}

	
}
 
$controladorEntidad = new EntidadController();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controladorEntidad->direccionar($c, "");

?>

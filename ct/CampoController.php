<?php
  
include '../md/CampoModel.php';
include '../md/UsuarioModel.php';
include_once '../util/Messages.php';

class CampoController{
    
	private $CampoModel;
	private const SESSION_TAG = "IDUSUARIOSISTEMAGeneracion/17";
    
	public function __CONSTRUCT(){
		$this->CampoModel = new CampoModel();
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
			$Permiso = $UsuarioModel->getPermissions($_SESSION[$this::SESSION_TAG], 8);
			include_once '../md/EntidadModel.php';
			$entity = (new EntidadModel())->read($_SESSION["entityId".$this::SESSION_TAG]);
							

			if ($Permiso==-1){
				require_once "../vw/Templates/header.php";
				require_once "../vw/PaginaError.php";
				require_once "../vw/Templates/footer.php";
				
			} else {

				switch ($c){
					case "c":
						require_once "../vw/Campo/create.php";
					break;

					case "i":
						if (in_array(5, $Permiso)){
							require_once "../vw/Campo/index.php";
						}
					break;

					//comes from entity master
					case "ie":
						$_SESSION["entityId".$this::SESSION_TAG] = $_REQUEST["id"];
					break;

					case "cm":
						$camposMostrar =$this->CampoModel->list($_POST['idEntidad']);
						foreach ($camposMostrar as $row) {
							echo '
							<option value="'.$row->getNombre().'">'. $row->getNombre().'</option>';
						}
					break;

					case "r":
						require_once "../vw/Campo/read.php";
					break;

					case "d":
						require_once "../vw/Campo/delete.php";
					break;

					case "u":
						require_once "../vw/Campo/update.php";
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
	
    
	public function list($entity){

        return $this->CampoModel->list($entity);
        
	}

	public function read($id){

        return $this->CampoModel->read($id);
        
	}


	public function create(){
		
		$Campo = new CampoModel();
		$Campo->SetNombre(trim($_REQUEST["Nombre"]));
		$Campo->SetLongitud(isset($_REQUEST["Longitud"])?trim($_REQUEST["Longitud"]):0);
		$Campo->SetEsNull(isset($_REQUEST["EsNull"])==1?1:0);
		$Campo->SetTipo(trim($_REQUEST["Tipo"]));
		$Campo->SetEsVisible(isset($_REQUEST["EsVisible"])==1?1:0);
		$Campo->SetValorDefault(trim($_REQUEST["ValorDefault"]));
		$Campo->SetEntidad($_REQUEST["Entidad"]);
		$Campo->SetRelacionEntidad(isset($_REQUEST["RelacionEntidad"])?$_REQUEST["RelacionEntidad"]:null);
		$Campo->SetRelacionEntidadCampo(isset($_REQUEST["RelacionEntidadCampo"])?$_REQUEST["RelacionEntidadCampo"]:null);
		$Campo->SetComentarios(isset($_REQUEST["Comentarios"])?$_REQUEST["Comentarios"]:null);
		

		/*$Nombre = trim($_REQUEST["Nombre"]);
		$Longitud = isset($_REQUEST["Longitud"])?trim($_REQUEST["Longitud"]):null;
		$EsNull = isset($_REQUEST["EsNull"])==1?1:0;
		$Tipo = trim($_REQUEST["Tipo"]);
		$EsVisible = isset($_REQUEST["EsVisible"])==1?1:0;
		$ValorDefault = trim($_REQUEST["ValorDefault"]);
		$Entidad = $_REQUEST["Entidad"];
		$RelacionEntidad = isset($_REQUEST["RelacionEntidad"])?$_REQUEST["RelacionEntidad"]:null;
		$RelacionEntidadCampo = isset($_REQUEST["RelacionEntidadCampo"])?$_REQUEST["RelacionEntidadCampo"]:null;
		$Comentarios = isset($_REQUEST["Comentarios"])?trim($_REQUEST["Comentarios"]):"";
		
		$Campo = new CampoModel(
			"", 
			$Nombre, 
			$Longitud, 
			$EsNull, 
			$Tipo, 
			$EsVisible, 
			$ValorDefault, 
			$Entidad, 
			"", 
			"", 
			$RelacionEntidad,
			$RelacionEntidadCampo, 
			$Comentarios);*/
		$message = $Campo->create(); 
		if ($message==23000){
			$this->direccionar("i",  Messages::DUPLICATED_CREATE_ERROR);
		} else if ($message != ""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			
			$this->direccionar("i", Messages::CREATE_SUCCESS);
		}
		
	}
                                     
	public function update(){

		$Campo = new CampoModel();
		$Campo->SetId(trim($_REQUEST["id"]));
		$Campo->SetNombre(trim($_REQUEST["Nombre"]));
		$Campo->SetLongitud(trim($_REQUEST["Longitud"]));
		$Campo->SetEsNull(isset($_REQUEST["EsNull"])==1?1:0);
		$Campo->SetTipo(trim($_REQUEST["Tipo"]));
		$Campo->SetEsVisible(isset($_REQUEST["EsVisible"])==1?1:0);
		$Campo->SetValorDefault(trim($_REQUEST["ValorDefault"]));
		$Campo->SetRelacionEntidad(isset($_REQUEST["RelacionEntidad"])?$_REQUEST["RelacionEntidad"]:null);
		$Campo->SetRelacionEntidadCampo(isset($_REQUEST["RelacionEntidadCampo"])?$_REQUEST["RelacionEntidadCampo"]:null);
		$Campo->SetComentarios(isset($_REQUEST["Comentarios"])?$_REQUEST["Comentarios"]:null);
		
		$message = $Campo->update(); //realiza la operación de actualizado
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
		$message = $this->CampoModel->delete($id);
		if ($message==23000){
			$this->direccionar("i", Messages::RELATED_REG_DELETE_ERROR);
		} else if ($message!=""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::DELETE_SUCCESS);
		}
	}

	
}
 
$controladorCampo = new CampoController();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controladorCampo->direccionar($c, "");

?>

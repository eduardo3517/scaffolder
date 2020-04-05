<?php 

class Controller{

    function generateController($nombreModelo, $resultadoCampo, $entity, $carpetaScaffoldUser, $contadorEntidades){

		$scriptFileSaving = '
  			//realiza la operación de insertado
			
			if (isset($_FILES[\'uploadedFile\']) && $_FILES[\'uploadedFile\'][\'error\'] === UPLOAD_ERR_OK) {
				// get details of the uploaded file
				$fileTmpPath = strval($_FILES[\'uploadedFile\'][\'tmp_name\']);
				$fileName = $_FILES[\'uploadedFile\'][\'name\'];
				$fileinfo = @getimagesize($_FILES["uploadedFile"]["tmp_name"]);
				$width = $fileinfo[0];
				$height = $fileinfo[1];
				$fileNameCmps = explode(".", $fileName);
				$fileExtension = strtolower(end($fileNameCmps));
				// sanitize file-name
				$newFileName = $Compania->Nombre. \'.\' . $fileExtension;
				$Icono = $newFileName;
				// check if file has one of the following extensions
				$allowedfileExtensions = array(\'png\');
				if (in_array($fileExtension, $allowedfileExtensions)) {
					
					// directory in which the uploaded file will be moved
					$uploadFileDir = \'../assets/images/iconos/\';
					$dest_path = $uploadFileDir . $newFileName;
					if(!move_uploaded_file($fileTmpPath, $dest_path)) {
						$message = Messages::UPLOAD_GENERIC_ERROR;
					}
					
				} else {
					$message = Messages::UPLOAD_EXT_ERROR  . implode(\',\', $allowedfileExtensions);
				}
			} else {
				
				$message = Messages::UPLOAD_GENERIC_ERROR_2;
			}
		
			if($message==""){
				$'.$nombreModelo.'->Icono = $Icono;
				$'.$nombreModelo.'->update();
				$this->direccionar("i", Messages::CREATE_SUCCESS);
			} else {
				$'.$nombreModelo.'->delete($'.$nombreModelo.'->id);
				$this->direccionar("i", Messages::GENERIC_ERROR.$message);
			}
  ';

  	

	

	$updateFileScript='
	if (isset($_FILES[\'uploadedFile\']) && $_FILES[\'uploadedFile\'][\'error\'] === UPLOAD_ERR_OK) {
		// get details of the uploaded file
		$fileTmpPath = strval($_FILES[\'uploadedFile\'][\'tmp_name\']);
		$fileName = $_FILES[\'uploadedFile\'][\'name\'];
		$fileinfo = @getimagesize($_FILES["uploadedFile"]["tmp_name"]);
		$width = $fileinfo[0];
		$height = $fileinfo[1];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
		// sanitize file-name
		$newFileName = $id . \'.\' . $fileExtension;
		$Icono = $newFileName;
		// check if file has one of the following extensions
		$allowedfileExtensions = array(\'png\');
		if (in_array($fileExtension, $allowedfileExtensions)) {
			
			if(($width!=  $height) || ($width<400)){
				$message = Messages::ICON_UPLOAD_ERROR;
			} else {
				// directory in which the uploaded file will be moved
				$uploadFileDir = \'../assets/images/iconos/\';
				$dest_path = $uploadFileDir . $newFileName;
				if(!move_uploaded_file($fileTmpPath, $dest_path)) {
					$message =  Messages::UPLOAD_GENERIC_ERROR;
				} 
			}
			
		} else {
			$message = Messages::UPLOAD_EXT_ERROR . implode(\',\', $allowedfileExtensions);
		}
	} else {
		$Icono = $this->read($id)->Icono;
	}

	$Compania = new CompaniaModel($id, $Nombre, $Icono);

	if($message==""){
		$message = $Compania->update();
		if ($message==23000){
			$this->direccionar("i", Messages::DUPLICATED_UPDATE_ERROR);
		} else if($message != ""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::UPDATE_SUCCESS);
		}
	}
	$this->direccionar("i", Messages::GENERIC_ERROR.$message);';


		$contenidoFiles = '
						';
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo->getTipo()==10){
				$contenidoFiles.= 'if(isset($_GET["'.$rowCampo->getNombre().'_id"])){
							$'.$nombreModelo.' = $this->'.$nombreModelo.'Model->read($_GET["'.$rowCampo->getNombre().'_id"]);
							header("Content-type: " . $'.$nombreModelo.'->get'.$rowCampo->getNombre().'Type());
							echo $'.$nombreModelo.'->get'.$rowCampo->getNombre().'();
						} else ';
			}
		}

		$contenidoController='<?php';
	if($entity->getTieneSeguridadUsuario()!=1){
		  $contenidoController.='
  
include \'../md/'.$nombreModelo.'Model.php\';';
	  }
	  $contenidoController.='
include \'../md/UsuarioModel.php\';
include_once \'../util/Messages.php\';

class '.$nombreModelo.'Controller{
    
	private $'.$nombreModelo.'Model;
	private const SESSION_TAG = "IDUSUARIOSISTEMA'.$carpetaScaffoldUser.'";
    
	public function __CONSTRUCT(){
		$this->'.$nombreModelo.'Model = new '.$nombreModelo.'Model();
		if(!isset($_SESSION)) { 
			session_start();
		}
	}

	public function direccionar($c, $mensaje){
		if(!isset($_SESSION[$this::SESSION_TAG])'.($entity->getTieneSeguridadUsuario()==1?' && $c!=\'lg\'':'').'){
			require_once "../vw/Templates/header.php";
			require_once "../vw/login.php";
			require_once "../vw/Templates/footer.php";
		} else {';
			if($entity->getTieneSeguridadUsuario()!=1){
				$contenidoController.='
			$UsuarioModel = new UsuarioModel();';
			}
			$contenidoController.='
			$UsuarioLogueado = $'.($entity->getTieneSeguridadUsuario()==1?'this->':'').'UsuarioModel->read($_SESSION[$this::SESSION_TAG]);
			$Permiso = $'.($entity->getTieneSeguridadUsuario()==1?'this->':'').'UsuarioModel->getPermissions($_SESSION[$this::SESSION_TAG], '.$contadorEntidades.');

			if ($Permiso==-1){
				require_once "../vw/Templates/header.php";
				require_once "../vw/PaginaError.php";
				require_once "../vw/Templates/footer.php";
				
			} else {

				switch ($c){
					case "c":
						require_once "../vw/'.$nombreModelo.'/create.php";
					break;

					case "i":
						'.($contenidoFiles==''?('
						if (in_array(5, $Permiso)){
							
							require_once "../vw/'.$nombreModelo.'/index.php";
						}'):($contenidoFiles.'{
							if (in_array(5, $Permiso)){
							
								require_once "../vw/'.$nombreModelo.'/index.php";
							}
						}')).
						'
					break;

					case "r":
						require_once "../vw/'.$nombreModelo.'/read.php";
					break;

					case "d":
						require_once "../vw/'.$nombreModelo.'/delete.php";
					break;

					case "u":
						require_once "../vw/'.$nombreModelo.'/update.php";
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

        return $this->'.$nombreModelo.'Model->list();
        
	}

	public function read($id){

        return $this->'.$nombreModelo.'Model->read($id);
        
	}


	public function create(){
      
		
		$'.$nombreModelo.' = new '.$nombreModelo.'Model();';
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo->getTipo()<>9){
				
				if($rowCampo->getTipo()==10){
					$contenidoController.='
		if(count($_FILES) > 0) {
			if(is_uploaded_file($_FILES["'.$rowCampo->getNombre().'"]["tmp_name"])) {
				$'.$nombreModelo.'->set'.$rowCampo->getNombre().'(file_get_contents($_FILES["'.$rowCampo->getNombre().'"]["tmp_name"]));
				$'.$nombreModelo.'->set'.$rowCampo->getNombre().'Type(getimageSize($_FILES["'.$rowCampo->getNombre().'"]["tmp_name"]));
				
			}
		}';
				} else {
					$contenidoController.='
		$'.$nombreModelo.'->set'.$rowCampo->getNombre().'(trim($_REQUEST["'.$rowCampo->getNombre().'"]));';
				}
			} 
		}
		$contenidoController.='
		$message = $'.$nombreModelo.'->create(); 
		if ($message==23000){
			$this->direccionar("i",  Messages::DUPLICATED_CREATE_ERROR);
		} else if ($message != ""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			';
			/*if($rowCampo->getTipo()==10){
				$contenidoController.=$scriptFileSaving;
			} else {*/
				$contenidoController.='
			$this->direccionar("i", Messages::CREATE_SUCCESS);';
		//	}
			
			
			$contenidoController.='
		}
		
	}
                                    
	public function update(){

		$'.$nombreModelo.' = new '.$nombreModelo.'Model();
		$'.$nombreModelo.'->setId(trim($_REQUEST["id"]));';
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo->getTipo()<>9){
				if($rowCampo->getTipo()==10){
					$contenidoController.='
		if(count($_FILES) > 0 && is_uploaded_file($_FILES["'.$rowCampo->getNombre().'"]["tmp_name"])) {
			$'.$nombreModelo.'->set'.$rowCampo->getNombre().'(file_get_contents($_FILES["'.$rowCampo->getNombre().'"]["tmp_name"]));
			$'.$nombreModelo.'->set'.$rowCampo->getNombre().'Type(getimageSize($_FILES["'.$rowCampo->getNombre().'"]["tmp_name"]));
		}';
				} else {
					$contenidoController.='
		$'.$nombreModelo.'->set'.$rowCampo->getNombre().'(trim($_REQUEST["'.$rowCampo->getNombre().'"]));';
				}
			}
      	}
		
		$tieneArchivo=false;
		if($tieneArchivo){
			$contenidoController.=$updateFileScript;
		}
		else{
			$contenidoController.='
		$message = $'.$nombreModelo.'->update(); //realiza la operación de actualizado
		if ($message==23000){
			$this->direccionar("i", Messages::DUPLICATED_UPDATE_ERROR);
		} else if($message != ""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::UPDATE_SUCCESS);
		}';
			
		}
			
		
			
		$contenidoController.='
	}
    
	public function delete(){
		$id = trim($_REQUEST["id"]);
		$message = $this->'.$nombreModelo.'Model->delete($id);
		if ($message==23000){
			$this->direccionar("i", Messages::RELATED_REG_DELETE_ERROR);
		} else if ($message!=""){
			$this->direccionar("i", Messages::GENERIC_ERROR.$message);
		} else {
			$this->direccionar("i", Messages::DELETE_SUCCESS);
		}
	}

	
}
 
$controlador'.$nombreModelo.' = new '.$nombreModelo.'Controller();
$c="";
if(isset($_POST["c"])){
	$c=$_POST["c"];
} else {
	$c="i";
}
$controlador'.$nombreModelo.'->direccionar($c, "");

?>';
		return $contenidoController;

	}
	

	function generateAccessController($carpetaScaffoldUser){
		return '
<?php
include \'../md/UsuarioModel.php\';
include_once \'../util/Messages.php\';

class AccessController{
	
	private $UsuarioModel;
	private const SESSION_TAG = "IDUSUARIOSISTEMA'.$carpetaScaffoldUser.'";
	
	public function __CONSTRUCT(){
		$this->UsuarioModel = new UsuarioModel();
		if(!isset($_SESSION)) { 
			session_start();
		}
	}

	public function direccionar($c, $mensaje){
		
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
					header("Location: UsuarioController.php");
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

?>';
	}

   
}

?>
	

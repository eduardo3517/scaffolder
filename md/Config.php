<?php 

class Config{

    function generateSQL($nombreModelo, $resultadoCampo){
		$contenidoSQL='
CREATE TABLE IF NOT EXISTS `'.$nombreModelo.'` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	';
		
	    foreach ($resultadoCampo as $rowCampo) {
			$nulidad = "NOT NULL";
	   		if($rowCampo->getEsNull() == 1){
				$nulidad = "NULL";
			}
			
			include_once 'TipoCampoModel.php';
			$TipoCampo = (new TipoCampoModel())->read($rowCampo->getTipo());
			$contenidoSQL.='`'.$rowCampo->getNombre().'` '.$TipoCampo->getValorBD()." ".($TipoCampo->getValorBD()=='VARCHAR'?('('.$rowCampo->getLongitud().') '):'').$nulidad.($rowCampo->getValorDefault()==''?'':' DEFAULT '.$rowCampo->getValorDefault()).', 
	';
			if($rowCampo->getTipo()==10){
				$contenidoSQL.='`'.$rowCampo->getNombre().'Type` VARCHAR(25) '.$nulidad.', 
	';
			}
	   		
			
		}
		
		
	  	
	  
	  	$contenidoSQL.='PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;';
		return $contenidoSQL;

	}

	function generateSQL2($insertEntidades){
		return '
ALTER TABLE `Seguridad`
	ADD UNIQUE KEY `TipoUsuario` (`TipoUsuario`,`EntidadSeguridad`,`AccionSeguridad`),
	ADD KEY `Seguridad_ibfk_1` (`AccionSeguridad`),
	ADD KEY `Seguridad_ibfk_2` (`EntidadSeguridad`),
	ADD CONSTRAINT `Seguridad_ibfk_1` FOREIGN KEY (`AccionSeguridad`) REFERENCES `AccionSeguridad` (`id`),
	ADD CONSTRAINT `Seguridad_ibfk_2` FOREIGN KEY (`EntidadSeguridad`) REFERENCES `EntidadSeguridad` (`id`),
	ADD CONSTRAINT `Seguridad_ibfk_3` FOREIGN KEY (`TipoUsuario`) REFERENCES `TipoUsuario` (`id`);
	
ALTER TABLE `Usuario`
	ADD UNIQUE KEY `CorreoElectronico` (`CorreoElectronico`),
	ADD KEY `Usuario_ibfk_1` (`TipoUsuario`),
	ADD CONSTRAINT `Usuario_ibfk_1` FOREIGN KEY (`TipoUsuario`) REFERENCES `TipoUsuario` (`id`);
	
	'.$insertEntidades.'
	
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(1, \'001\', \'Leer\');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(2, \'002\', \'Registrar\');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(3, \'003\', \'Eliminar\');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(4, \'004\', \'Actualizar\');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(5, \'005\', \'Listar\');

	INSERT INTO `TipoUsuario` (`id`, `Nombre`, `Descripcion`) VALUES(1, \'Analista de seguridad\', \'Administra la seguridad de usuario\');

	INSERT INTO `Usuario` (`id`, `Nombre`, `Apellido`, `CorreoElectronico`, `Contrasena`, `TipoUsuario`) VALUES(1, \'Eduardo\', \'Campo Herrera\', \'eduardo3517@gmail.com\', \'$2y$10$pGIQr2OzX7VMmqOqAdENpO3QzIdW64pDbkDHwiq0IWEfdV17zv2iO\', 1);

	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 1, 1);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 1, 2);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 1, 3);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 1, 4);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 1, 5);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 2, 1);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 2, 2);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 2, 3);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 2, 4);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 2, 5);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 3, 1);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 3, 2);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 3, 3);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 3, 4);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 3, 5);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 4, 1);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 4, 2);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 4, 3);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 4, 4);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 4, 5);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 5, 1);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 5, 2);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 5, 3);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 5, 4);
	INSERT INTO `Seguridad` (`TipoUsuario`, `EntidadSeguridad`, `AccionSeguridad`) VALUES(1, 5, 5);
	
		
		';
	}

	function generateConfig($baseDatos, $servidor, $usuario, $contrasena){
		return '<?php
class Database{

    private static $dbName = "'.$baseDatos.'" ;
    private static $dbHost = "'.$servidor.'" ;
    private static $dbUsername = "'.$usuario.'";
    private static $dbUserPassword = "'.$contrasena.'";
     
    private static $cont  = null;
     
    public function __construct() {
        die("Init function is not allowed");
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont ){     
			try{
				self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
			}
			catch(PDOException $e){
				die($e->getMessage()); 
			}
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>';
	}


    
}

?>
	

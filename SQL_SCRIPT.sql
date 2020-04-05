
CREATE TABLE IF NOT EXISTS `TipoUsuario` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`Nombre` VARCHAR(50) NOT NULL, 
	`Descripcion` VARCHAR(500) NOT NULL, 
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `Usuario` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`Nombre` VARCHAR(50) NOT NULL, 
	`Apellido` VARCHAR(50) NOT NULL, 
	`CorreoElectronico` VARCHAR(50) NOT NULL, 
	`Contrasena` VARCHAR(500) NOT NULL, 
	`TipoUsuario` INT NOT NULL, 
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `EntidadSeguridad` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`Codigo` VARCHAR(20) NOT NULL, 
	`Nombre` VARCHAR(200) NOT NULL, 
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `AccionSeguridad` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`Codigo` VARCHAR(20) NOT NULL, 
	`Nombre` VARCHAR(200) NOT NULL, 
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `Seguridad` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`TipoUsuario` INT NOT NULL, 
	`EntidadSeguridad` INT NULL, 
	`AccionSeguridad` INT NULL, 
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `Proyecto` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`Nombre` VARCHAR(200) NOT NULL, 
	`FechaCreacion` VARCHAR(0) NOT NULL, 
	`NombreServidor` VARCHAR(200) NOT NULL, 
	`NombreBaseDatos` VARCHAR(200) NULL, 
	`UsuarioBaseDatos` VARCHAR(200) NOT NULL, 
	`ContrasenaBaseDatos` VARCHAR(200) NOT NULL, 
	`FechaUltimaModificacion` VARCHAR(0) NOT NULL, 
	`Usuario` INT NOT NULL, 
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `Entidad` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`Nombre` VARCHAR(200) NOT NULL, 
	`Proyecto` INT NOT NULL, 
	`TieneSeguridadUsuario` INT NOT NULL, 
	`FechaCreacion` VARCHAR(0) NOT NULL, 
	`FechaUltimaModificacion` VARCHAR(0) NOT NULL, 
	`Comentario` VARCHAR(20000) NULL, 
	`Relacion` INT NOT NULL, 
	PRIMARY KEY (`id`)
);
CREATE TABLE IF NOT EXISTS `Campo` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`Nombre` VARCHAR(200) NOT NULL, 
	`Longitud` VARCHAR(0) NULL, 
	`EsNull` INT NOT NULL, 
	`Tipo` VARCHAR(0) NOT NULL, 
	`EsVisible` INT NOT NULL, 
	`ValorDefault` VARCHAR(2000) NULL, 
	`Entidad` INT NOT NULL, 
	`FechaCreacion` VARCHAR(0) NOT NULL, 
	`FechaUltimaModificacion` VARCHAR(0) NOT NULL, 
	`RelacionEntidad` INT NOT NULL, 
	`RelacionEntidadCampo` INT NOT NULL, 
	`Comentarios` VARCHAR(5000) NOT NULL, 
	PRIMARY KEY (`id`)
);
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

	
	Insert Into EntidadSeguridad (Codigo, Nombre) Values ('1', 'TipoUsuario');
	Insert Into EntidadSeguridad (Codigo, Nombre) Values ('2', 'Usuario');
	Insert Into EntidadSeguridad (Codigo, Nombre) Values ('3', 'EntidadSeguridad');
	Insert Into EntidadSeguridad (Codigo, Nombre) Values ('4', 'AccionSeguridad');
	Insert Into EntidadSeguridad (Codigo, Nombre) Values ('5', 'Seguridad');
	Insert Into EntidadSeguridad (Codigo, Nombre) Values ('6', 'Proyecto');
	Insert Into EntidadSeguridad (Codigo, Nombre) Values ('7', 'Entidad');
	Insert Into EntidadSeguridad (Codigo, Nombre) Values ('8', 'Campo');

	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(1, '001', 'Leer');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(2, '002', 'Registrar');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(3, '003', 'Eliminar');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(4, '004', 'Actualizar');
	INSERT INTO `AccionSeguridad` (`id`, `Codigo`, `Nombre`) VALUES(5, '005', 'Listar');

	INSERT INTO `TipoUsuario` (`id`, `Nombre`, `Descripcion`) VALUES(1, 'Analista de seguridad', 'Administra la seguridad de usuario');

	INSERT INTO `Usuario` (`id`, `Nombre`, `Apellido`, `CorreoElectronico`, `Contrasena`, `TipoUsuario`) VALUES(1, 'Eduardo', 'Campo Herrera', 'eduardo3517@gmail.com', '$2y$10$pGIQr2OzX7VMmqOqAdENpO3QzIdW64pDbkDHwiq0IWEfdV17zv2iO', 1);

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

	
	

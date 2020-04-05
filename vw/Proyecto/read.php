
	<?php
		$Proyecto = $this->read($_POST['id']);
	?>
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Detalle de Proyecto</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<div class="modal-body">
		<div class="col-sm-10 offset-md-1">
			<div class="card border-light">
				<div class="card-header">Nombre</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Proyecto->getNombre();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">FechaCreacion</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Proyecto->getFechaCreacion();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">NombreServidor</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Proyecto->getNombreServidor();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">NombreBaseDatos</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Proyecto->getNombreBaseDatos();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">UsuarioBaseDatos</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Proyecto->getUsuarioBaseDatos();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">ContrasenaBaseDatos</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Proyecto->getContrasenaBaseDatos();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">FechaUltimaModificacion</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Proyecto->getFechaUltimaModificacion();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">Usuario</div>
				<div class="card-body">
					<p class="card-text"> 
					<?php
						include_once '../md/UsuarioModel.php';
						$Usuario = new UsuarioModel();
						$Encontrado = $Usuario->read($Proyecto->getUsuario());
						echo $Encontrado->getNombre();
					?>
					</p>
				</div>
			</div>
		</div> 
	</div> 
	<div class="modal-footer">
		<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Atrás</button>
	</div>

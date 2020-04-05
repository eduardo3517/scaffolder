
	<?php
		$Entidad = $this->read($_POST['id']);
	?>
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Detalle de Entidad</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<div class="modal-body">
		<div class="col-sm-10 offset-md-1">
			<div class="card border-light">
				<div class="card-header">Nombre</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Entidad->getNombre();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">Proyecto</div>
				<div class="card-body">
					<p class="card-text"> 
					<?php
						include_once '../md/ProyectoModel.php';
						$Proyecto = new ProyectoModel();
						$Encontrado = $Proyecto->read($Entidad->getProyecto());
						echo $Encontrado->getNombre();
					?>
					</p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">TieneSeguridadUsuario</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Entidad->getTieneSeguridadUsuario();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">FechaCreacion</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Entidad->getFechaCreacion();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">FechaUltimaModificacion</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Entidad->getFechaUltimaModificacion();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">Comentario</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Entidad->getComentario();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">Relacion</div>
				<div class="card-body">
					<p class="card-text"> 
					<?php
						include_once '../md/EntidadModel.php';
						$Entidad = new EntidadModel();
						$Encontrado = $Entidad->read($Entidad->getRelacion());
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

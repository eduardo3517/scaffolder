
	<?php
		$Campo = $this->read($_POST['id']);
	?>
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Detalle de Campo</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<div class="modal-body">
		<div class="col-sm-10 offset-md-1">
			<div class="card border-light">
				<div class="card-header">Nombre</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Campo->getNombre();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">Longitud</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Campo->getLongitud();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">EsNull</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Campo->getEsNull();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">Tipo</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Campo->getTipo();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">EsVisible</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Campo->getEsVisible();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">ValorDefault</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Campo->getValorDefault();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">Entidad</div>
				<div class="card-body">
					<p class="card-text"> 
					<?php
						include_once '../md/EntidadModel.php';
						$Entidad = new EntidadModel();
						$Encontrado = $Entidad->read($Campo->getEntidad());
						echo $Encontrado->getNombre();
					?>
					</p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">FechaCreacion</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Campo->getFechaCreacion();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">FechaUltimaModificacion</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Campo->getFechaUltimaModificacion();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">RelacionEntidad</div>
				<div class="card-body">
					<p class="card-text"> 
					<?php
						include_once '../md/EntidadModel.php';
						$Entidad = new EntidadModel();
						$Encontrado = $Entidad->read($Campo->getRelacionEntidad());
						echo $Encontrado->getNombre();
					?>
					</p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">RelacionEntidadCampo</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Campo->getRelacionEntidadCampo();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">Comentarios</div>
				<div class="card-body">
					<p class="card-text"><?php echo $Campo->getComentarios();?></p>
				</div>
			</div>
		</div> 
	</div> 
	<div class="modal-footer">
		<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Atrás</button>
	</div>

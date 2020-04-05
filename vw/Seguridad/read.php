
	<?php
		$Seguridad = $this->read($_POST['id']);
	?>
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Detalle de Seguridad</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<div class="modal-body">
		<div class="col-sm-10 offset-md-1">
			<div class="card border-light">
				<div class="card-header">TipoUsuario</div>
				<div class="card-body">
					<p class="card-text"> 
					<?php
						include_once '../md/TipoUsuarioModel.php';
						$TipoUsuario = new TipoUsuarioModel();
						$Encontrado = $TipoUsuario->read($Seguridad->getTipoUsuario());
						echo $Encontrado->getNombre();
					?>
					</p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">EntidadSeguridad</div>
				<div class="card-body">
					<p class="card-text"> 
					<?php
						include_once '../md/EntidadSeguridadModel.php';
						$EntidadSeguridad = new EntidadSeguridadModel();
						$Encontrado = $EntidadSeguridad->read($Seguridad->getEntidadSeguridad());
						echo $Encontrado->getNombre();
					?>
					</p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">AccionSeguridad</div>
				<div class="card-body">
					<p class="card-text"> 
					<?php
						include_once '../md/AccionSeguridadModel.php';
						$AccionSeguridad = new AccionSeguridadModel();
						$Encontrado = $AccionSeguridad->read($Seguridad->getAccionSeguridad());
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


	<?php
		$AccionSeguridad = $this->read($_POST['id']);
	?>
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Detalle de AccionSeguridad</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<div class="modal-body">
		<div class="col-sm-10 offset-md-1">
			<div class="card border-light">
				<div class="card-header">Codigo</div>
				<div class="card-body">
					<p class="card-text"><?php echo $AccionSeguridad->getCodigo();?></p>
				</div>
			</div>
			<div class="card border-light">
				<div class="card-header">Nombre</div>
				<div class="card-body">
					<p class="card-text"><?php echo $AccionSeguridad->getNombre();?></p>
				</div>
			</div>
		</div> 
	</div> 
	<div class="modal-footer">
		<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Atrás</button>
	</div>

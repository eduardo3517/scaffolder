	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Construcción del Proyecto</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<div class="col-sm-10 offset-md-1">
			
	<?php
		$Proyecto = $this->ProyectoModel->build($_POST['id']);
	?>

	?>
		</div> 
	</div> 
	<div class="modal-footer">
		<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Atrás</button>
	</div>
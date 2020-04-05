
	<form class="form-horizontal" action="EntidadSeguridadController.php" method="post">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Eliminar EntidadSeguridad</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class = "row">
				<div class ="col">
				</div>
				<div class ="col-10">
					<input type="hidden" name="c" value="b"/>
					<input type="hidden" name="id" value="<?php echo htmlspecialchars($_POST["id"]);?>"/>
					<p class="alert-error">¿Está seguro de eliminar este registro?</p>
					
				</div>
				<div class ="col">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
			<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancelar</button>
		</div>

	</form>

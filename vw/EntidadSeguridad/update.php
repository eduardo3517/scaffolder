
	<?php
		$EntidadSeguridad = $this->read($_POST['id']);
	?>
	<form action="EntidadSeguridadController.php" method="post" enctype="multipart/form-data">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Modificar EntidadSeguridad</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class = "row">
				<div class ="col">
				</div>
				<div class ="col-10">
					<h4 class="display-12">Llena todos los campos requeridos.</h4>
					<br>
					<input class="form-control" name="c" type="hidden" value="a" >
					<input class="form-control" name="id" type="hidden" value="<?php echo $EntidadSeguridad->getId();?>" >

					<label for="NumeroId">Codigo</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Codigo" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$EntidadSeguridad->getCodigo().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">Nombre</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$EntidadSeguridad->getNombre().'"'?>  required>
						</div>
					</div>
				</div>
				<div class ="col">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-outline-primary btn-sm">Actualizar</button>
			<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancelar</button>
		</div>
	</form>


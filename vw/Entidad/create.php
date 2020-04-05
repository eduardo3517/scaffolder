
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Agregar Entidad</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class ="col">
			</div>
			<div class ="col-10">
				<h4 class="display-6">Llena todos los campos requeridos.</h4>
				<br>
				<form action="EntidadController.php" method="post" enctype="multipart/form-data">
					<input class="form-control" name="c" type="hidden" value="g" >
					<input class="form-control" name="Proyecto" type="hidden" value="<?php echo $project->getId(); ?>" >
					<label for="Nombre">Nombre</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					<label for="Proyecto">Proyecto</label>
					
					<div class="form-group custom-control custom-switch">
						
						<input type="checkbox" name="TieneSeguridadUsuario" class="custom-control-input" id="TieneSeguridadUsuario">
						<label class="custom-control-label" for="TieneSeguridadUsuario">Tiene Seguridad de Usuario</label>
					</div>

				
					
					<label for="Comentario">Comentario</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Comentario" type="text" title="Este campo es sólo números o letras.">
						</div>
					</div>
					<label for="Relacion">Relacion</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="Relacion" >
								<?php

									foreach ($Entidads as $Fila){
										echo '<option value="'.$Fila->getId().'">'.$Fila->getNombre().'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-outline-primary">Guardar</button>
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
					</div>
				</form>
				</div>
				<div class ="col">
				</div>
			</div>
		</div>

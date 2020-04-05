
	<?php
		$Entidad = $this->read($_POST['id']);
	?>
	<form action="EntidadController.php" method="post" enctype="multipart/form-data">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Modificar Entidad</h5>
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
					<input class="form-control" name="id" type="hidden" value="<?php echo $Entidad->getId();?>" >
					<input class="form-control" name="Proyecto" type="hidden" value="<?php echo $project->getId(); ?>" >
					
					<label for="NumeroId">Nombre</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Entidad->getNombre().'"'?>  required>
						</div>
					</div>

					<div class="form-group custom-control custom-switch">
						<input type="checkbox" name="TieneSeguridadUsuario" class="custom-control-input" id="TieneSeguridadUsuario" <?php echo $Entidad->getTieneSeguridadUsuario()==1?'checked':''?>>
						<label class="custom-control-label" for="TieneSeguridadUsuario">Tiene Seguridad de Usuario</label>
					</div>

					<label for="NumeroId">Comentario</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Comentario" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Entidad->getComentario().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">Relación</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="Relacion" >
								<?php

									foreach ($Entidads as $Fila){
										$selected = $Entidad->getRelacion()==$Fila->getId()?'" selected="selected">':'" >';
										echo '<option value="'.$Fila->getId().$selected.$Fila->getNombre().'</option>';
									}
								?>
							</select>
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


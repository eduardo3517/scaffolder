
	<?php
		$Proyecto = $this->read($_POST['id']);
	?>
	<form action="ProyectoController.php" method="post" enctype="multipart/form-data">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Modificar Proyecto</h5>
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
					<input class="form-control" name="id" type="hidden" value="<?php echo $Proyecto->getId();?>" >
					<input class="form-control" name="Usuario" type="hidden" value="<?php echo $UsuarioLogueado->getId(); ?>" >

					<label for="NumeroId">Nombre Proyecto </label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Proyecto->getNombre().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">Nombre Servidor</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="NombreServidor" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Proyecto->getNombreServidor().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">Nombre Base de Datos</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="NombreBaseDatos" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Proyecto->getNombreBaseDatos().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">Usuario Base de Datos</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="UsuarioBaseDatos" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Proyecto->getUsuarioBaseDatos().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">Contraseña Base de Datos</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="ContrasenaBaseDatos" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Proyecto->getContrasenaBaseDatos().'"'?>  required>
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


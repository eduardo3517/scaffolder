
	<?php
		$Usuario = $this->read($_POST['id']);
	?>
	<form action="UsuarioController.php" method="post" enctype="multipart/form-data">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Modificar Usuario</h5>
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
					<input class="form-control" name="id" type="hidden" value="<?php echo $Usuario->getId();?>" >

					<label for="NumeroId">Nombre</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Usuario->getNombre().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">Apellido</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Apellido" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Usuario->getApellido().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">CorreoElectronico</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="CorreoElectronico" type="email" title="Este campo es sólo tipo correo electrónico." <?php echo 'value="'.$Usuario->getCorreoElectronico().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">Contrasena</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Contrasena" type="password" title="Este campo es de tipo contraseña." <?php echo 'value="'.$Usuario->getContrasena().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">TipoUsuario</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="TipoUsuario" required>
								<?php
									include "../md/TipoUsuarioModel.php";
									$TipoUsuario = new TipoUsuarioModel();
									$TipoUsuarios = $TipoUsuario->list();

									foreach ($TipoUsuarios as $Fila){
										$selected = $Usuario->getTipoUsuario()==$Fila->getId()?'" selected="selected">':'" >';
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


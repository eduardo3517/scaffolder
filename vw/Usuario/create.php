
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Agregar Usuario</h5>
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
				<form action="UsuarioController.php" method="post" enctype="multipart/form-data">
					<input class="form-control" name="c" type="hidden" value="g" >
					<label for="Nombre">Nombre</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					<label for="Apellido">Apellido</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Apellido" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					<label for="CorreoElectronico">CorreoElectronico</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="CorreoElectronico" type="email" title="Este campo es sólo tipo correo electrónico." required>
						</div>
					</div>
					<label for="Contrasena">Contrasena</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Contrasena" type="password" title="Este campo es de tipo contraseña." required>
						</div>
					</div>
					<label for="TipoUsuario">TipoUsuario</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="TipoUsuario" required>
								<?php
									include "../md/TipoUsuarioModel.php";
									$TipoUsuario = new TipoUsuarioModel();
									$TipoUsuarios = $TipoUsuario->list();

									foreach ($TipoUsuarios as $Fila){
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

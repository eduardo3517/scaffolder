
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Agregar Seguridad</h5>
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
				<form action="SeguridadController.php" method="post" enctype="multipart/form-data">
					<input class="form-control" name="c" type="hidden" value="g" >
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
					<label for="EntidadSeguridad">EntidadSeguridad</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="EntidadSeguridad" required>
								<?php
									include "../md/EntidadSeguridadModel.php";
									$EntidadSeguridad = new EntidadSeguridadModel();
									$EntidadSeguridads = $EntidadSeguridad->list();

									foreach ($EntidadSeguridads as $Fila){
										echo '<option value="'.$Fila->getId().'">'.$Fila->getNombre().'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<label for="AccionSeguridad">AccionSeguridad</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="AccionSeguridad" required>
								<?php
									include "../md/AccionSeguridadModel.php";
									$AccionSeguridad = new AccionSeguridadModel();
									$AccionSeguridads = $AccionSeguridad->list();

									foreach ($AccionSeguridads as $Fila){
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

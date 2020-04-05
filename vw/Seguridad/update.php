
	<?php
		$Seguridad = $this->read($_POST['id']);
	?>
	<form action="SeguridadController.php" method="post" enctype="multipart/form-data">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Modificar Seguridad</h5>
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
					<input class="form-control" name="id" type="hidden" value="<?php echo $Seguridad->getId();?>" >

					<label for="NumeroId">TipoUsuario</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="TipoUsuario" required>
								<?php
									include "../md/TipoUsuarioModel.php";
									$TipoUsuario = new TipoUsuarioModel();
									$TipoUsuarios = $TipoUsuario->list();

									foreach ($TipoUsuarios as $Fila){
										$selected = $Seguridad->getTipoUsuario()==$Fila->getId()?'" selected="selected">':'" >';
										echo '<option value="'.$Fila->getId().$selected.$Fila->getNombre().'</option>';
									}
								?>
							</select>
						</div>
					</div>

					<label for="NumeroId">EntidadSeguridad</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="EntidadSeguridad" required>
								<?php
									include "../md/EntidadSeguridadModel.php";
									$EntidadSeguridad = new EntidadSeguridadModel();
									$EntidadSeguridads = $EntidadSeguridad->list();

									foreach ($EntidadSeguridads as $Fila){
										$selected = $Seguridad->getEntidadSeguridad()==$Fila->getId()?'" selected="selected">':'" >';
										echo '<option value="'.$Fila->getId().$selected.$Fila->getNombre().'</option>';
									}
								?>
							</select>
						</div>
					</div>

					<label for="NumeroId">AccionSeguridad</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="AccionSeguridad" required>
								<?php
									include "../md/AccionSeguridadModel.php";
									$AccionSeguridad = new AccionSeguridadModel();
									$AccionSeguridads = $AccionSeguridad->list();

									foreach ($AccionSeguridads as $Fila){
										$selected = $Seguridad->getAccionSeguridad()==$Fila->getId()?'" selected="selected">':'" >';
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


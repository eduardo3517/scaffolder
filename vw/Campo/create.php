
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Agregar Campo</h5>
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
				<form action="CampoController.php" method="post" enctype="multipart/form-data">
					<input class="form-control" name="c" type="hidden" value="g" >
					<input class="form-control" name="Entidad" type="hidden" value="<?php echo $entity->getId(); ?>" >
					
					<label for="Tipo">Tipo</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select id="Tipo" class="form-control" name="Tipo" onchange="ajaxEntidades()" required>
								<?php
									include "../md/TipoCampoModel.php";
									$TipoCampo = new TipoCampoModel();
									$TipoCampos = $TipoCampo->list();

									foreach ($TipoCampos as $Fila){
										echo '<option value="'.$Fila->getId().'">'.$Fila->getNombre().'</option>';
									}
								?>
							</select>
						</div>
					</div>

					<label for="Nombre">Nombre</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>

					<label for="Longitud">Longitud</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input id="longInput" class="form-control" name="Longitud" type="number" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					
					
					
					<label for="ValorDefault">Valor Default</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="ValorDefault" type="text" title="Este campo es sólo números o letras.">
						</div>
					</div>

					<label for="Entidad">Entidad</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="RelacionEntidad" id="inputEntidades" onchange="ajaxCampos($('#inputEntidades').val())" disabled>
								
							</select>
						</div>
					</div>
					
					<label for="RelacionEntidadCampo">Campo a mostrar</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="RelacionEntidadCampo" id="inputCampoMostrar" disabled>
								
							</select>
						</div>
					</div>

					<label for="Comentarios">Comentarios</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Comentarios" type="text" title="Este campo es sólo números o letras." >
						</div>
					</div>

					<div class="form-group custom-control custom-switch">
						
						<input type="checkbox" name="EsNull" class="custom-control-input" id="EsNull">
						<label class="custom-control-label" for="EsNull">Es Null</label>
					</div>

					<div class="form-group custom-control custom-switch">
						
						<input type="checkbox" name="EsVisible" class="custom-control-input" id="EsVisible">
						<label class="custom-control-label" for="EsVisible">Es Visible</label>
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

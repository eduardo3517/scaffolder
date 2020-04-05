
	<?php
		$Campo = $this->read($_POST['id']);
	?>
	<form action="CampoController.php" method="post" enctype="multipart/form-data">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Modificar Campo</h5>
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
					<input class="form-control" name="id" type="hidden" value="<?php echo $Campo->getId();?>" >

					<label for="NumeroId">Tipo</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select id="Tipo" class="form-control" name="Tipo" onchange="ajaxEntidades()" required>
								<?php
									include "../md/TipoCampoModel.php";
									$TipoCampo = new TipoCampoModel();
									$TipoCampos = $TipoCampo->list();

									foreach ($TipoCampos as $Fila){
										$selected = $Campo->getTipo()==$Fila->getId()?'" selected="selected">':'" >';
										echo '<option value="'.$Fila->getId().$selected.$Fila->getNombre().'</option>';
									}
								?>
							</select>
						</div>
					</div>
					
					<label for="NumeroId">Nombre</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Campo->getNombre().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">Longitud</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Longitud" type="number" title="Este campo es sólo números o letras." <?php echo 'value="'.$Campo->getLongitud().'"'?>  required>
						</div>
					</div>

					
					<div class="form-group custom-control custom-switch">
						
						<input type="checkbox" name="EsNull" class="custom-control-input" id="EsNull" <?php echo $Campo->getEsNull()==1?'checked':''?>>
						<label class="custom-control-label" for="EsNull">Es Null</label>
					</div>

					<div class="form-group custom-control custom-switch">
						
						<input type="checkbox" name="EsVisible" class="custom-control-input" id="EsVisible" <?php echo $Campo->getEsVisible()==1?'checked':''?>>
						<label class="custom-control-label" for="EsVisible">Es Visible</label>
					</div>

					<label for="NumeroId">ValorDefault</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="ValorDefault" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Campo->getValorDefault().'"'?>>
						</div>
					</div>

					<label for="NumeroId">Entidad</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" id="inputEntidades" name="RelacionEntidad" onchange="ajaxCampos($('#inputEntidades').val())" <?php echo $Campo->getTipo()!=8?'disabled':'' ?>>
								<?php
									if($Campo->getTipo()!=8){
										$Entidad = new EntidadModel();
										$Entidads = $Entidad->list($_SESSION["projectId".$this::SESSION_TAG]);

										foreach ($Entidads as $Fila){
											$selected = $Campo->getRelacionEntidad()==$Fila->getId()?'" selected="selected">':'" >';
											echo '<option value="'.$Fila->getId().$selected.$Fila->getNombre().'</option>';
										}
									}
									
								?>
							</select>
						</div>
					</div>

					<label for="NumeroId">Relacion Entidad Campo</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<select class="form-control" name="RelacionEntidadCampo" id="inputCampoMostrar" disabled>
								
							</select>
						</div>
					</div>

					<label for="NumeroId">Comentarios</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Comentarios" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$Campo->getComentarios().'"'?> >
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


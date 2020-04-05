
	<?php
		$TipoCampo = $this->read($_POST['id']);
	?>
	<form action="TipoCampoController.php" method="post" enctype="multipart/form-data">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Modificar TipoCampo</h5>
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
					<input class="form-control" name="id" type="hidden" value="<?php echo $TipoCampo->getId();?>" >

					<label for="NumeroId">Nombre</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$TipoCampo->getNombre().'"'?>  required>
						</div>
					</div>

					<label for="NumeroId">ValorBD</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="ValorBD" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$TipoCampo->getValorBD().'"'?>  required>
						</div>
					</div>
					
					<label for="NumeroId">ValorForm</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="ValorForm" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$TipoCampo->getValorForm().'"'?>  required>
						</div>
					</div>
					<label for="NumeroId">Placeholder</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Placeholder" type="text" title="Este campo es sólo números o letras." <?php echo 'value="'.$TipoCampo->getPlaceholder().'"'?>  required>
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



	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Agregar TipoCampo</h5>
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
				<form action="TipoCampoController.php" method="post" enctype="multipart/form-data">
					<input class="form-control" name="c" type="hidden" value="g" >
					<label for="Nombre">Nombre</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					<label for="ValorBD">ValorBD</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="ValorBD" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					<label for="ValorForm">ValorForm</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="ValorForm" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					<label for="Placeholder">Placeholder</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Placeholder" type="text" title="Este campo es sólo números o letras." required>
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

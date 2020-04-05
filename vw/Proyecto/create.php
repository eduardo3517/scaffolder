
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Agregar Proyecto</h5>
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
				<form action="ProyectoController.php" method="post" enctype="multipart/form-data">
					<input class="form-control" name="c" type="hidden" value="g" >
					<input class="form-control" name="Usuario" type="hidden" value="<?php echo $UsuarioLogueado->getId(); ?>" >
					
					<label for="Nombre">Nombre Proyecto</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="Nombre" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					<label for="NombreServidor">Nombre de Servidor</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="NombreServidor" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					<label for="NombreBaseDatos">Nombre Base de Datos</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="NombreBaseDatos" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					<label for="UsuarioBaseDatos">Usuario Base de Datos</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="UsuarioBaseDatos" type="text" title="Este campo es sólo números o letras." required>
						</div>
					</div>
					<label for="ContrasenaBaseDatos">Contraseña Base de Datos</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="ContrasenaBaseDatos" type="text" title="Este campo es sólo números o letras." required>
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

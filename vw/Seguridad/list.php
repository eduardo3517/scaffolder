

 			<h3 class="display-6">Listado de Seguridad</h3>
			<br>
			
			<table id="dtSeguridad" class="table table-striped table-bordered table-sm">
				<caption>Maestro de Seguridad</caption>
				<thead class="thead-light">
					<tr>
						<th scope="col" style="width:25%">
							TipoUsuario
						</th>
						<th scope="col" style="width:25%">
							EntidadSeguridad
						</th>
						<th scope="col" style="width:25%">
							AccionSeguridad
						</th>
						<th scope="col" style="width:25%">
							Acciones
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
					

					$Seguridads = $this->list();
					foreach ($Seguridads as $row) {
						echo '<tr>';
						include_once '../md/TipoUsuarioModel.php';
						$TipoUsuario = new TipoUsuarioModel();
						$Encontrado = $TipoUsuario->read($row->getTipoUsuario());
						echo '<td scope="col" style="width:25%"><a data-toggle="modal" data-target="#modal" onclick="accionModal(\''.$Encontrado->getId().'\', \'r\', \'TipoUsuario\')" >'.$Encontrado->getNombre() .'</a></td>';
						include_once '../md/EntidadSeguridadModel.php';
						$EntidadSeguridad = new EntidadSeguridadModel();
						$Encontrado = $EntidadSeguridad->read($row->getEntidadSeguridad());
						echo '<td scope="col" style="width:25%"><a data-toggle="modal" data-target="#modal" onclick="accionModal(\''.$Encontrado->getId().'\', \'r\', \'EntidadSeguridad\')" >'.$Encontrado->getNombre() .'</a></td>';
						include_once '../md/AccionSeguridadModel.php';
						$AccionSeguridad = new AccionSeguridadModel();
						$Encontrado = $AccionSeguridad->read($row->getAccionSeguridad());
						echo '<td scope="col" style="width:25%"><a data-toggle="modal" data-target="#modal" onclick="accionModal(\''.$Encontrado->getId().'\', \'r\', \'AccionSeguridad\')" >'.$Encontrado->getNombre() .'</a></td>';
						echo '<td scope="col" style="width:25%">
							<div class="btn-group" role="group" aria-label="Basic example">';

						echo in_array(1, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'r\', \'Seguridad\')" ><i class="material-icons">remove_red_eye</i></button>':''; 
						echo in_array(4, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'u\', \'Seguridad\')" ><i class="material-icons">create</i></button>':''; 
						echo in_array(3, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-danger btn-sm" onclick="accionModal(\''.$row->getId().'\', \'d\', \'Seguridad\')" ><i class="material-icons">delete</i></button>':''; 
						echo '</div>
							</td>
						</tr>';
					}
				?>
				</tbody>
			</table>
			
		

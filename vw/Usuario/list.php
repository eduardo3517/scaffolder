

 			<h3 class="display-6">Listado de Usuario</h3>
			<br>
			
			<table id="dtUsuario" class="table table-striped table-bordered table-sm">
				<caption>Maestro de Usuario</caption>
				<thead class="thead-light">
					<tr>
						<th scope="col" style="width:16.666666666667%">
							Nombre
						</th>
						<th scope="col" style="width:16.666666666667%">
							Apellido
						</th>
						<th scope="col" style="width:16.666666666667%">
							CorreoElectronico
						</th>
						<th scope="col" style="width:16.666666666667%">
							Contrasena
						</th>
						<th scope="col" style="width:16.666666666667%">
							TipoUsuario
						</th>
						<th scope="col" style="width:16.666666666667%">
							Acciones
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
					

					$Usuarios = $this->list();
					foreach ($Usuarios as $row) {
						echo '<tr>';
						echo '<td scope="col" style="width:16.666666666667%">'. $row->getNombre() . '</td>';
						echo '<td scope="col" style="width:16.666666666667%">'. $row->getApellido() . '</td>';
						echo '<td scope="col" style="width:16.666666666667%">'. $row->getCorreoElectronico() . '</td>';
						echo '<td scope="col" style="width:16.666666666667%">'. $row->getContrasena() . '</td>';
						include_once '../md/TipoUsuarioModel.php';
						$TipoUsuario = new TipoUsuarioModel();
						$Encontrado = $TipoUsuario->read($row->getTipoUsuario());
						echo '<td scope="col" style="width:16.666666666667%"><a data-toggle="modal" data-target="#modal" onclick="accionModal(\''.$Encontrado->getId().'\', \'r\', \'TipoUsuario\')" >'.$Encontrado->getNombre() .'</a></td>';
						echo '<td scope="col" style="width:16.666666666667%">
							<div class="btn-group" role="group" aria-label="Basic example">';

						echo in_array(1, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'r\', \'Usuario\')" ><i class="material-icons">remove_red_eye</i></button>':''; 
						echo in_array(4, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'u\', \'Usuario\')" ><i class="material-icons">create</i></button>':''; 
						echo in_array(3, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-danger btn-sm" onclick="accionModal(\''.$row->getId().'\', \'d\', \'Usuario\')" ><i class="material-icons">delete</i></button>':''; 
						echo '</div>
							</td>
						</tr>';
					}
				?>
				</tbody>
			</table>
			
		

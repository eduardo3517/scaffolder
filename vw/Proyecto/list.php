

 			<h3 class="display-6" id="tableDesc">Listado de Proyectos de <?php echo $UsuarioLogueado->getNombre(); ?></h3>
			<br>
			
			<table id="dtProyecto" class="table table-striped table-bordered table-sm" aria-describedby="tableDesc">
				
				<thead class="thead-light">
					<tr>
						<th scope="col" style="width:11.111111111111%">
							Proyecto
						</th>
						<th scope="col" style="width:11.111111111111%">
							Servidor
						</th>
						<th scope="col" style="width:11.111111111111%">
							Nombre Base de Datos
						</th>
						<th scope="col" style="width:11.111111111111%">
							Usuario Base de Datos
						</th>
						<th scope="col" style="width:11.111111111111%">
							Contrasena Base de Datos
						</th>
						<th scope="col" style="width:11.111111111111%">
							Acciones
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
					

					$Proyectos = $this->list();
					foreach ($Proyectos as $row) {
						echo '<tr>';
						echo '<td scope="col" style="width:11.111111111111%">'. $row->getNombre() . '</td>';
						echo '<td scope="col" style="width:11.111111111111%">'. $row->getNombreServidor() . '</td>';
						echo '<td scope="col" style="width:11.111111111111%">'. $row->getNombreBaseDatos() . '</td>';
						echo '<td scope="col" style="width:11.111111111111%">'. $row->getUsuarioBaseDatos() . '</td>';
						echo '<td scope="col" style="width:11.111111111111%">'. $row->getContrasenaBaseDatos() . '</td>';
						echo '<td scope="col" style="width:11.111111111111%">
							<div class="btn-group" role="group" aria-label="Basic example">';

						echo in_array(1, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'r\', \'Proyecto\')" ><i class="material-icons">remove_red_eye</i></button>':''; 
						echo in_array(4, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'u\', \'Proyecto\')" ><i class="material-icons">create</i></button>':''; 
						echo in_array(3, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-danger btn-sm" onclick="accionModal(\''.$row->getId().'\', \'d\', \'Proyecto\')" ><i class="material-icons">delete</i></button>':''; 
						echo in_array(6, $Permiso)?'<button type="button" class="btn btn-outline-primary btn-sm" onclick="actionNavigate(\''.$row->getId().'\', \'Entidad\')" ><i class="material-icons">input</i></button>':''; 
						echo in_array(8, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-primary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'gen\', \'Proyecto\')" ><i class="material-icons">build</i></button>':''; 
						echo '</div>
							</td>
						</tr>';
					}
				?>
				</tbody>
			</table>
			
		

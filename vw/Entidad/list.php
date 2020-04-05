

 			<h3 class="display-6">Listado de Entidades del proyecto <?php echo $project->getNombre(); ?></h3>
			<br>
			<a onclick ="actionNavigate('<?php echo $project->getId(); ?>', 'Proyecto')">Volver a proyectos</a>
			<br>
			
			<table id="dtEntidad" class="table table-striped table-bordered table-sm">
				<caption>Maestro de Entidad</caption>
				<thead class="thead-light">
					<tr>
						<th scope="col" style="width:12.5%">
							Nombre
						</th>
						<th scope="col" style="width:12.5%">
							Proyecto
						</th>
						<th scope="col" style="width:12.5%">
							TieneSeguridadUsuario
						</th>
						<th scope="col" style="width:12.5%">
							Comentario
						</th>
						<th scope="col" style="width:12.5%">
							Relacion
						</th>
						<th scope="col" style="width:12.5%">
							Acciones
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
					

					$Entidads = $this->list($project->getId());
					foreach ($Entidads as $row) {
						echo '<tr>';
						echo '<td scope="col" style="width:12.5%">'. $row->getNombre() . '</td>';
						include_once '../md/ProyectoModel.php';
						$Proyecto = new ProyectoModel();
						$Encontrado = $Proyecto->read($row->getProyecto());
						echo '<td scope="col" style="width:12.5%"><a data-toggle="modal" data-target="#modal" onclick="accionModal(\''.$Encontrado->getId().'\', \'r\', \'Proyecto\')" >'.$Encontrado->getNombre() .'</a></td>';
						echo '<td scope="col" style="width:12.5%">'. $row->getTieneSeguridadUsuario() . '</td>';
						echo '<td scope="col" style="width:12.5%">'. $row->getComentario() . '</td>';
						include_once '../md/EntidadModel.php';
						$Entidad = new EntidadModel();
						$Encontrado = $Entidad->read($row->getRelacion());
						echo '<td scope="col" style="width:12.5%"><a data-toggle="modal" data-target="#modal" onclick="accionModal(\''.$Encontrado->getId().'\', \'r\', \'Entidad\')" >'.$Encontrado->getNombre() .'</a></td>';
						echo '<td scope="col" style="width:12.5%">
							<div class="btn-group" role="group" aria-label="Basic example">';

						echo in_array(1, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'r\', \'Entidad\')" ><i class="material-icons">remove_red_eye</i></button>':''; 
						echo in_array(4, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'u\', \'Entidad\')" ><i class="material-icons">create</i></button>':''; 
						echo in_array(3, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-danger btn-sm" onclick="accionModal(\''.$row->getId().'\', \'d\', \'Entidad\')" ><i class="material-icons">delete</i></button>':''; 
						echo in_array(7, $Permiso)?'<button type="button" class="btn btn-outline-primary btn-sm" onclick="actionNavigate(\''.$row->getId().'\', \'Campo\')" ><i class="material-icons">input</i></button>':''; 
						echo '</div>
							</td>
						</tr>';
					}
				?>
				</tbody>
			</table>
			
		

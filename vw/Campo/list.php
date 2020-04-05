

 			<h3 class="display-6" id="tableDesc">Listado de Campos de la entidad <?php echo $entity->getNombre(); ?></h3>
			 <br>
			 <a onclick ="actionNavigate('<?php echo $entity->getProyecto(); ?>', 'Entidad')">Volver a entidades del proyecto</a>
			<br>
			
			<table id="dtCampo" class="table table-striped table-bordered table-sm" aria-describedby="tableDesc">
				<thead class="thead-light">
					<tr>
						<th scope="col" style="width:7.6923076923077%">
							Nombre
						</th>
						<th scope="col" style="width:7.6923076923077%">
							Longitud
						</th>
						<th scope="col" style="width:7.6923076923077%">
							Es Null
						</th>
						<th scope="col" style="width:7.6923076923077%">
							Tipo
						</th>
						<th scope="col" style="width:7.6923076923077%">
							Es Visible
						</th>
						<th scope="col" style="width:7.6923076923077%">
							Valor Default
						</th>
						<th scope="col" style="width:7.6923076923077%">
							Entidad
						</th>
						<th scope="col" style="width:7.6923076923077%">
							Relación Entidad
						</th>
						<th scope="col" style="width:7.6923076923077%">
							Relación Entidad Campo
						</th>
						<th scope="col" style="width:7.6923076923077%">
							Comentarios
						</th>
						<th scope="col" style="width:7.6923076923077%">
							Acciones
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
					

					$Campos = $this->list($entity->getId());
					foreach ($Campos as $row) {
						echo '<tr>';
						echo '<td scope="col" style="width:7.6923076923077%">'. $row->getNombre() . '</td>';
						echo '<td scope="col" style="width:7.6923076923077%">'. $row->getLongitud() . '</td>';
						echo '<td scope="col" style="width:7.6923076923077%">'. $row->getEsNull() . '</td>';
						echo '<td scope="col" style="width:7.6923076923077%">'. $row->getTipo() . '</td>';
						echo '<td scope="col" style="width:7.6923076923077%">'. $row->getEsVisible() . '</td>';
						echo '<td scope="col" style="width:7.6923076923077%">'. $row->getValorDefault() . '</td>';
						include_once '../md/EntidadModel.php';
						$Entidad = new EntidadModel();
						$Encontrado = $Entidad->read($row->getEntidad());
						echo '<td scope="col" style="width:7.6923076923077%"><a data-toggle="modal" data-target="#modal" onclick="accionModal(\''.$Encontrado->getId().'\', \'r\', \'Entidad\')" >'.$Encontrado->getNombre() .'</a></td>';
						include_once '../md/EntidadModel.php';
						$Entidad = new EntidadModel();
						$Encontrado = $Entidad->read($row->getRelacionEntidad());
						echo '<td scope="col" style="width:7.6923076923077%"><a data-toggle="modal" data-target="#modal" onclick="accionModal(\''.$Encontrado->getId().'\', \'r\', \'Entidad\')" >'.$Encontrado->getNombre() .'</a></td>';
						
						echo '<td scope="col" style="width:7.6923076923077%">'.$row->getRelacionEntidadCampo() .'</td>';
						echo '<td scope="col" style="width:7.6923076923077%">'. $row->getComentarios() . '</td>';
						echo '<td scope="col" style="width:7.6923076923077%">
							<div class="btn-group" role="group" aria-label="Basic example">';

						echo in_array(1, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'r\', \'Campo\')" ><i class="material-icons">remove_red_eye</i></button>':''; 
						echo in_array(4, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'u\', \'Campo\')" ><i class="material-icons">create</i></button>':''; 
						echo in_array(3, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-danger btn-sm" onclick="accionModal(\''.$row->getId().'\', \'d\', \'Campo\')" ><i class="material-icons">delete</i></button>':''; 
						echo '</div>
							</td>
						</tr>';
					}
				?>
				</tbody>
			</table>
			
		



 			<h3 class="display-6">Listado de EntidadSeguridad</h3>
			<br>
			
			<table id="dtEntidadSeguridad" class="table table-striped table-bordered table-sm">
				<caption>Maestro de EntidadSeguridad</caption>
				<thead class="thead-light">
					<tr>
						<th scope="col" style="width:33.333333333333%">
							Codigo
						</th>
						<th scope="col" style="width:33.333333333333%">
							Nombre
						</th>
						<th scope="col" style="width:33.333333333333%">
							Acciones
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
					

					$EntidadSeguridads = $this->list();
					foreach ($EntidadSeguridads as $row) {
						echo '<tr>';
						echo '<td scope="col" style="width:33.333333333333%">'. $row->getCodigo() . '</td>';
						echo '<td scope="col" style="width:33.333333333333%">'. $row->getNombre() . '</td>';
						echo '<td scope="col" style="width:33.333333333333%">
							<div class="btn-group" role="group" aria-label="Basic example">';

						echo in_array(1, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'r\', \'EntidadSeguridad\')" ><i class="material-icons">remove_red_eye</i></button>':''; 
						echo in_array(4, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'u\', \'EntidadSeguridad\')" ><i class="material-icons">create</i></button>':''; 
						echo in_array(3, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-danger btn-sm" onclick="accionModal(\''.$row->getId().'\', \'d\', \'EntidadSeguridad\')" ><i class="material-icons">delete</i></button>':''; 
						echo '</div>
							</td>
						</tr>';
					}
				?>
				</tbody>
			</table>
			
		

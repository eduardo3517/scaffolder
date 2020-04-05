

 			<h3 class="display-6" id="tableDesc">Listado de TipoCampo</h3>
			<br>
			
			<table id="dtTipoCampo" class="table table-striped table-bordered table-sm" aria-describedby="tableDesc">
				
				<thead class="thead-light">
					<tr>
						<th scope="col" style="width:20%">
							Nombre
						</th>
						<th scope="col" style="width:20%">
							ValorBD
						</th>
						<th scope="col" style="width:20%">
							ValorForm
						</th>
						<th scope="col" style="width:20%">
							Placeholder
						</th>
						<th scope="col" style="width:20%">
							Acciones
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
					

					$TipoCampos = $this->list();
					foreach ($TipoCampos as $row) {
						echo '<tr>';
						echo '<td scope="col" style="width:20%">'. $row->getNombre() . '</td>';
						echo '<td scope="col" style="width:20%">'. $row->getValorBD() . '</td>';
						echo '<td scope="col" style="width:20%">'. $row->getValorForm() . '</td>';
						echo '<td scope="col" style="width:20%">'. $row->getPlaceholder() . '</td>';
						echo '<td scope="col" style="width:20%">
							<div class="btn-group" role="group" aria-label="Basic example">';

						echo in_array(1, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'r\', \'TipoCampo\')" ><i class="material-icons">remove_red_eye</i></button>':''; 
						echo in_array(4, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal(\''.$row->getId().'\', \'u\', \'TipoCampo\')" ><i class="material-icons">create</i></button>':''; 
						echo in_array(3, $Permiso)?'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-danger btn-sm" onclick="accionModal(\''.$row->getId().'\', \'d\', \'TipoCampo\')" ><i class="material-icons">delete</i></button>':''; 
						echo '</div>
							</td>
						</tr>';
					}
				?>
				</tbody>
			</table>
			
		

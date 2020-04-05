<?php 

class View{

    

    function generateIndex($nombreModelo){
		/*generación del archivo index*/
		$comilla = "\'";
		return '
	<?php
		include "../vw/Templates/header.php";
	?>
		<div class="container">
			<br>
			<div class="btn-group" role="group" aria-label="Acciones de Ventana">
				<?php
					if (in_array(2, $Permiso)) {
						echo \'<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal" onclick="accionModal('.$comilla.$comilla.', '.$comilla.'c'.$comilla.', '.$comilla.$nombreModelo.$comilla.')"><i class="material-icons">add</i>Agregar</button>\';
					}
				?>
			</div>
			<br>
			<br>
			<?php
				if($mensaje != "") {
					echo \'
					<div class="alert alert-info">
					  	<strong>¡Atención!</strong> \'.$mensaje.\'
					</div>\';
				}
				include "../vw/'.$nombreModelo.'/list.php";
			?>
			
		</div> <!-- /container -->

	<?php
		include "../vw/Templates/footer.php";
	?>
		
		';
	}

	

	function generateList($nombreModelo, $resultadoCampo){
		/*inicio generación del archivo listado*/
		$comilla = "\'";
		$contenidoListado ='

		<h3 class="display-6" id="tableDesc">Listado de '.$nombreModelo.'</h3>
	   	<br>
	   
	   	<table id="dt'.$nombreModelo.'" class="table table-striped table-bordered table-sm" aria-describedby="tableDesc">
		   
		   	<thead class="thead-light">
			   	<tr>';
			   //El tamaño de las columnas
		$tamCol = 100/(sizeof($resultadoCampo)+1);
		$imports = '';
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo->getEsVisible() == 1){
				$contenidoListado.='
					<th scope="col" style="width:'.$tamCol.'%">
						'.$rowCampo->getNombre().'
					</th>';
				if(!is_null($rowCampo->getRelacionEntidad())){
					include_once 'EntidadModel.php';
					$rowEnt = (new EntidadModel())->read($rowCampo->getRelacionEntidad());
					$imports.= $rowEnt->getNombre()=='Usuario'?'':('include_once \'../md/'.$rowEnt->getNombre().'Model.php\';').'
					$'.$rowEnt->getNombre().' = new '.$rowEnt->getNombre().'Model();
					$Encontrado = $'.$rowEnt->getNombre().'->read($row->get'.$rowCampo->getNombre().'());
				
				';
				}
			}
			
		}
		$word = '$this';
		$contenidoListado.='
				   <th scope="col" style="width:'.$tamCol.'%">
					   Acciones
				   </th>
			   </tr>
		   </thead>
		   <tbody>
		   <?php
			   	$'.$nombreModelo.'s = $this->list();
			   	foreach ($'.$nombreModelo.'s as $row) {

					$readButton = in_array(1, $Permiso)?\'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal('.$comilla.'\'.$row->getId().\''.$comilla.', '.$comilla.'r'.$comilla.', '.$comilla.$nombreModelo.$comilla.')" ><i class="material-icons">remove_red_eye</i></button>\':\'\'; 
					$updateButton = in_array(4, $Permiso)?\'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-secondary btn-sm" onclick="accionModal('.$comilla.'\'.$row->getId().\''.$comilla.', '.$comilla.'u'.$comilla.', '.$comilla.$nombreModelo.$comilla.')" ><i class="material-icons">create</i></button>\':\'\'; 
					$deleteButton = in_array(3, $Permiso)?\'<button type="button" data-toggle="modal" data-target="#modal" class="btn btn-outline-danger btn-sm" onclick="accionModal('.$comilla.'\'.$row->getId().\''.$comilla.', '.$comilla.'d'.$comilla.', '.$comilla.$nombreModelo.$comilla.')" ><i class="material-icons">delete</i></button>\':\'\'; 
					
					'.$imports.'

					echo \'
					<tr>';
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo->getEsVisible() == 1){
				if (is_null($rowCampo->getRelacionEntidad())){
					if($rowCampo->getTipo()==10){
						$contenidoListado.='
						<td scope="col" style="width:'.$tamCol.'%">
							<img class="img-fluid" style="max-width:15%" src="'.$nombreModelo.'Controller.php?'.$rowCampo->getNombre().'_id=\'. $row->getId() . \'" alt="'.$nombreModelo.$rowCampo->getNombre().'"/>
						</td>
						';
					} else {
						$contenidoListado.='
						<td scope="col" style="width:'.$tamCol.'%">
							\'. $row->get'.$rowCampo->getNombre().'() . \'
						</td>
						';
					}
					
				} else {
					include_once 'EntidadModel.php';
					$rowEnt = (new EntidadModel())->read($rowCampo->getRelacionEntidad());
					
					$contenidoListado.='
						<td scope="col" style="width:'.$tamCol.'%">
							<a data-toggle="modal" data-target="#modal" onclick="accionModal('.$comilla.'\'.$Encontrado->getId().\''.$comilla.', '.$comilla.'r'.$comilla.', '.$comilla.$rowEnt->getNombre().$comilla.')" >
								\'.$Encontrado->get'.$rowCampo->getRelacionEntidadCampo().'() .\'
							</a>
						</td>
						';
				}
			}
		}
   		$contenidoListado.='
						<td scope="col" style="width:'.$tamCol.'%">
							<div class="btn-group" role="group" aria-label="Basic example">
								\'.$readButton.\'
								\'.$updateButton.\' 
								\'.$deleteButton.\'
				   			</div>
					   </td>
				   </tr>\';
			   }
		   ?>
		   </tbody>
	   </table>
	   
   ';

   		return $contenidoListado;
	}




	function generateCreate($nombreModelo, $resultadoCampo){


		$contenidoCreate='
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Agregar '.$nombreModelo.'</h5>
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
				<form action="'.$nombreModelo.'Controller.php" method="post" enctype="multipart/form-data">
					<input class="form-control" name="c" type="hidden" value="g" >';
						
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo->getTipo()<>9){
				if (is_null($rowCampo->getRelacionEntidad())){
					
					include_once "TipoCampoModel.php";
					$TipoCampo = (new TipoCampoModel())->read($rowCampo->getTipo());
					$contenidoCreate.='
					<label for="'.$rowCampo->getNombre().'">'.$rowCampo->getNombre().'</label>
					<div class="form-group input-group">
						<div class="col-sm-12">
							<input class="form-control" name="'.$rowCampo->getNombre().'" type="'.$TipoCampo->getValorForm().'" title="'.$TipoCampo->getPlaceholder().'" required>
						</div>
					</div>';
					

				} else {
					include_once 'EntidadModel.php';
					$Entidad = (new EntidadModel())->read($rowCampo->getRelacionEntidad());
					
			
					$NombreEntidad = $Entidad->getNombre();
					$NombreCampo = $rowCampo->getRelacionEntidadCampo();
					$contenidoCreate.='
						<label for="'.$rowCampo->getNombre().'">'.$rowCampo->getNombre().'</label>
						<div class="form-group input-group">
							<div class="col-sm-12">
								<select class="form-control" name="'.$rowCampo->getNombre().'" required>
									<?php
										include "../md/'.$NombreEntidad.'Model.php";
										$'.$NombreEntidad.' = new '.$NombreEntidad.'Model();
										$'.$NombreEntidad.'s = $'.$NombreEntidad.'->list();

										foreach ($'.$NombreEntidad.'s as $Fila){
											echo \'<option value="\'.$Fila->getId().\'">\'.$Fila->get'.$NombreCampo.'().\'</option>\';
										}
									?>
								</select>
							</div>
						</div>';

				}	
			}
		}
		
		$contenidoCreate.='
					<div class="modal-footer">
						<button type="submit" class="btn btn-outline-primary">Guardar</button>
						<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
					</div>
				</form>
				</div>
				<div class ="col">
				</div>
			</div>
		</div>';

		return $contenidoCreate;
	}



	public function generateRead($nombreModelo, $resultadoCampo){
		$contenidoRead='
	<?php
		$'.$nombreModelo.' = $this->read($_POST[\'id\']);
	?>
	<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLongTitle">Detalle de '.$nombreModelo.'</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
	</div>

	<div class="modal-body">
		<div class="col-sm-10 offset-md-1">';

			foreach ($resultadoCampo as $rowCampo) {
				if (is_null($rowCampo->getRelacionEntidad())){
					$cellContent=$rowCampo->getTipo()==10?
					('<img class="img-fluid" src="'.$nombreModelo.'Controller.php?'.
					$rowCampo->getNombre().'_id=<?php echo $'.$nombreModelo.'->getId();?>" alt="'.$nombreModelo.$rowCampo->getNombre().'"/>')
					:('<?php echo $'.$nombreModelo.'->get'.$rowCampo->getNombre().'();?>');
					$contenidoRead.='
			<div class="card border-light">
				<div class="card-header">'.$rowCampo->getNombre().'</div>
				<div class="card-body">
					<p class="card-text">
						'.$cellContent.'
					</p>
				</div>
			</div>';
				} else {
					include_once 'EntidadModel.php';
					$Entidad = (new EntidadModel())->read($rowCampo->getRelacionEntidad());
					$contenidoRead.='
			<div class="card border-light">
				<div class="card-header">'.$rowCampo->getNombre().'</div>
				<div class="card-body">
					<p class="card-text"> 
					<?php
						include_once \'../md/'.$Entidad->getNombre().'Model.php\';
						$'.$Entidad->getNombre().' = new '.$Entidad->getNombre().'Model();
						$Encontrado = $'.$Entidad->getNombre().'->read($'.$nombreModelo.'->get'.$rowCampo->getNombre().'());
						echo $Encontrado->get'.$rowCampo->getRelacionEntidadCampo().'();
					?>
					</p>
				</div>
			</div>';
				}
				
			}
			
			$contenidoRead.='
		</div> 
	</div> 
	<div class="modal-footer">
		<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Atrás</button>
	</div>';

	return $contenidoRead;
	}



	function generateUpdate($nombreModelo, $resultadoCampo){
		$contenidoUpdate='
	<?php
		$'.$nombreModelo.' = $this->read($_POST[\'id\']);
	?>
	<form action="'.$nombreModelo.'Controller.php" method="post" enctype="multipart/form-data">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Modificar '.$nombreModelo.'</h5>
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
					<input class="form-control" name="id" type="hidden" value="<?php echo $'.$nombreModelo.'->getId();?>" >';

						
		foreach ($resultadoCampo as $rowCampo) {
			if($rowCampo->getTipo()<>9){
				

				if (is_null($rowCampo->getRelacionEntidad())){
					
					if($rowCampo->getTipo()==10){
						$contenidoUpdate.='
						<label for="'.$rowCampo->getNombre().'">'.$rowCampo->getNombre().'</label>
						<div class="form-group input-group">
							<div class="col-sm-12">
								<input class="form-control" name="'.$rowCampo->getNombre().'" type="file">
							</div>
						</div>';
					} else {

						include_once "TipoCampoModel.php";
						$TipoCampo = (new TipoCampoModel())->read($rowCampo->getTipo());
						$contenidoUpdate.='
						<label for="'.$rowCampo->getNombre().'">'.$rowCampo->getNombre().'</label>
						<div class="form-group input-group">
							<div class="col-sm-12">
								<input class="form-control" name="'.$rowCampo->getNombre().'" type="'.$TipoCampo->getNombre().'" title="'.$TipoCampo->getPlaceholder().'" <?php echo \'value="\'.$'.$nombreModelo.'->get'.$rowCampo->getNombre().'().\'"\'?>  required>
							</div>
						</div>';

					}
					
				} else {
					include_once 'EntidadModel.php';
					$Entidad = (new EntidadModel())->read($rowCampo->getRelacionEntidad());
					
			
					$NombreEntidad = $Entidad->getNombre();
					$NombreCampo = $rowCampo->getRelacionEntidadCampo();
					$contenidoUpdate.='

						<label for="NumeroId">'.$rowCampo->getNombre().'</label>
						<div class="form-group input-group">
							<div class="col-sm-12">
								<select class="form-control" name="'.$rowCampo->getNombre().'" required>
									<?php
										include "../md/'.$NombreEntidad.'Model.php";
										$'.$NombreEntidad.' = new '.$NombreEntidad.'Model();
										$'.$NombreEntidad.'s = $'.$NombreEntidad.'->list();

										foreach ($'.$NombreEntidad.'s as $Fila){
											$selected = $'.$nombreModelo.'->get'.$rowCampo->getNombre().'()==$Fila->getId()?\'" selected="selected">\':\'" >\';
											echo \'<option value="\'.$Fila->getId().$selected.$Fila->get'.$NombreCampo.'().\'</option>\';
										}
									?>
								</select>
							</div>
						</div>';

				}
			}
				
		}
		
		$contenidoUpdate.='
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
';
		return $contenidoUpdate;
	}



	function generateDelete($nombreModelo){
		return '
	<form class="form-horizontal" action="'.$nombreModelo.'Controller.php" method="post">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Eliminar '.$nombreModelo.'</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<div class = "row">
				<div class ="col">
				</div>
				<div class ="col-10">
					<input type="hidden" name="c" value="b"/>
					<input type="hidden" name="id" value="<?php echo htmlspecialchars($_POST["id"]);?>"/>
					<p class="alert-error">¿Está seguro de eliminar este registro?</p>
					
				</div>
				<div class ="col">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-outline-danger btn-sm">Eliminar</button>
			<button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Cancelar</button>
		</div>

	</form>';
	}
}

?>
	


	<?php
		include "../vw/Templates/header.php";
	?>
		<div class="container">
			<br>
			<div class="btn-group" role="group" aria-label="Acciones de Ventana">
				<?php
					if (in_array(2, $Permiso)) {
						echo '<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modal" onclick="accionModal(\'\', \'c\', \'Usuario\')"><i class="material-icons">add</i>Agregar</button>';
					}
				?>
			</div>
			<br>
			<br>
			<?php
				if($mensaje != "") {
					echo '
					<div class="alert alert-info">
					  	<strong>¡Atención!</strong> '.$mensaje.'
					</div>';
				}
				include "../vw/Usuario/list.php";
			?>
			
		</div> <!-- /container -->

	<?php
		include "../vw/Templates/footer.php";
	?>
		
		

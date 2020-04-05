<section class="header15 cid-rz4zGoPzDT mbr-fullscreen mbr-parallax-background" id="header15-a">
    <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(35, 35, 35);">
    </div>
    <div class="container align-right">
        <?php
            if ($mensaje != ""){
                echo '
        <div class="row justify-content-md-center">
            <div class="alert alert-danger">
          		<strong>¡Atención!</strong> '.$mensaje.' 
            </div>
        </div>';
            }
        ?>
        <div class="row">
            <div class="mbr-white col-lg-8 col-md-7 content-container">
                <h1 class="mbr-section-title mbr-bold pb-3 mbr-fonts-style display-1">
                    Bienvenido
                </h1>
                <p class="mbr-text pb-3 mbr-fonts-style display-5">
                    A continuación ingrese su usuario y contraseña para acceder al sistema.
                </p>
            </div>
            <div class="col-lg-4 col-md-5">
                <div class="form-container">
                    <div class="media-container-column" data-form-type="formoid">
                        
                        <form action="AccessController.php" method="POST" class="mbr-form form-with-styler" >
                            <div class="dragArea row">
                                <input name="c" type="hidden" value="lg" >
                                <div class="col-md-12 form-group " data-for="CorreoElectronico">
                                    <input type="email" name="CorreoElectronico" placeholder="Usuario" data-form-field="CorreoElectronico" required="required" class="form-control px-3 display-7">
                                </div>
                                <div data-for="phone" class="col-md-12 form-group ">
                                    <input type="password" name="Contrasena" placeholder="Contraseña" data-form-field="Contrasena" class="form-control px-3 display-7">
                                </div>
                                
                                <div class="col-md-12 input-group-btn"><button type="submit" class="btn btn-secondary btn-form display-4">Entrar</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
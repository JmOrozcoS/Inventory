<header class="main-header">
    <!-- ====================
    LOGOTIPO
     ==================== -->
    <a href="inicio" class="logo">

        <!--logo mini-->
        <span class="logo-mini">
            <img src="vistas/img/plantilla/icono-blanco.png" class="img-responsive" style="padding:10px">

        </span>
        <!--logo normal-->
        <span class="logo-lg">
            <img src="vistas/img/plantilla/logo-blanco-lineal.png" class="img-responsive">

        </span>

    </a>

            <!-- ====================
    BARRAS DE NAVEGACION
    ==================== -->
            <nav class=" navbar navbar-static-top" role="navigation">

            <!--Botón de navegacion-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">

                <span class="sr-only">Toggle navigation</span>

            </a>

            <!--perfil de usuario-->
            <div class="navbar-custom-menu">

                <ul class="nav navbar-nav">

                    <li class="dropdown user user-menu">

                        <a href="#" dropdown-toggle data-toggle="dropdown">

                            <?php

                            if ($_SESSION["foto"] != "") {

                                echo '<img src="' . $_SESSION["foto"] . '" class="user-image">';

                            } else {

                                echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';
                            }

                            ?>

                            <span class="hidden-xs">
                                <?php echo $_SESSION["nombre"] ?>
                            </span>

                        </a>
                        <!--Dropdown-toggle-->
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">

                                <?php

                                if ($_SESSION["foto"] != "") {

                                    echo '<img src="' . $_SESSION["foto"] . '" class="img-circle" alt="User Image">';

                                } else {

                                    echo '<img src="vistas/img/usuarios/default/anonymous.png" class="img-circle" alt="User Image">';
                                }

                                ?>

                                <p>
                                    <?php echo $_SESSION["usuario"] ?>
                                    <small>
                                        <?php echo $_SESSION["perfil"] ?>
                                    </small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">

                                <!-- Opcional -->
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked">

                                        <li><a href="#">Ventas<span
                                                    class="pull-right badge bg-green">12</span></a>
                                        </li>
                                    </ul>
                                </div>
                                <br>
                                <!-- Opcional-->

                                <div class="pull-left">

                                    <button class="btn btn-flat btnEditarUsuario2"
                                        idUsuario="<?php echo $_SESSION["id"]; ?>" data-toggle="modal"
                                        data-target="#modalEditarUsuario2">Editar perfil</button>


                                </div>

                                <div class="pull-right">
                                    <a href="salir" class="btn btn-default btn-flat">Salir</a>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                        </ul>

                    </li>

                </ul>
            </div>

            </nav>

            
</header>

<!-- ====================
MODAL EDITAR USUARIO
 ==================== -->

            <!-- Modal -->
            <div id="modalEditarUsuario2" class="modal fade" role="dialog">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form role="form" method="post" enctype="multipart/form-data">

                            <!-- ====================
            CABEZA DEL MODAL
            ==================== -->

                            <div class="modal-header" style="background: #3c8dbc; color:white">

                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                                <h4 class="modal-title">Editar usuario</h4>

                            </div>

                            <!-- ====================
            CUERPO DEL MODAL
             ==================== -->

                            <div class="modal-body">

                                <div class="box-body">

                                    <!-- ====================
                    ENTRADA PARA EL NOMBRE
                     ==================== -->

                                    <div class="form-group">

                                        <div class="input-group">

                                            <span class="input-group-addon">
                                                <i class="fa fa-user"></i>

                                            </span>

                                            <input id="editarNombre2" name="editarNombre2" type="text"
                                                class="form-control input-md" value="" required>
                                            </input>

                                        </div>

                                    </div>

                                    <!-- ====================
                    ENTRADA PARA EL USUARIO
                    ==================== -->

                                    <div class="form-group">

                                        <div class="input-group">

                                            <span class="input-group-addon">
                                                <i class="fa fa-key"></i>

                                            </span>

                                            <input id="editarUsuario2" name="editarUsuario2" type="text"
                                                class="form-control input-md" value="" readonly>
                                            </input>

                                        </div>

                                    </div>

                                    <!-- ====================
                    ENTRADA PARA LA CONTRASEÑA
                    ==================== -->

                                    <div class="form-group">

                                        <div class="input-group">

                                            <span class="input-group-addon">
                                                <i class="fa fa-lock"></i>

                                            </span>

                                            <input name="editarPassword2" type="password" class="form-control input-md"
                                                placeholder="escriba la nueva contraseña"> </input>

                                            <input name="passwordActual2" type="hidden" id="passwordActual2"> </input>

                                        </div>

                                    </div>

                                    <!-- ====================
                    ENTRADA PARA SELECCION E PERFIL
                     ==================== -->

                                    <div class="form-group">

                                        <div class="input-group">

                                            <span class="input-group-addon">
                                                <i class="fa fa-users"></i>

                                            </span>

                                            <select class="form-control input-md" name="editarPerfil2" readonly>
                                                <option value="" id="editarPerfil2"></option>
                                                
                                            </select>

                                        </div>

                                    </div>

                                    <!-- ====================
                                     ENTRADA PARA SUBIR FOTO-->

                                    <div class="form-group">

                                        <div class="panel">SUBIR FOTO</div>

                                        <input type="file" name="editarFoto2" class="nuevaFoto2">

                                        <p class="help-block">Peso máximo de la foto 200kb</p>

                                        <img src="vistas/img/usuarios/default/anonymous.png"
                                            class="img-thumbnail previsualizar2" width="100px">

                                        <input name="fotoActual2" type="hidden" id="fotoActual2"> </input>

                                    </div>

                                </div>

                            </div>

                            <!-- ====================
            PIE DE PÁGINA DEL MODAL
             ==================== -->

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default pull-left"
                                    data-dismiss="modal">Salir</button>

                                <button type="submit" class="btn btn-primary">Guardar cambios</button>

                            </div>

                            <?php

                            $editarUsuario = new ControladorUsuarios();
                            $editarUsuario->ctrEditarUsuario();

                            ?>

                        </form>

                    </div>

                </div>

            </div>
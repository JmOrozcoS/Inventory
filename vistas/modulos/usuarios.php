<?php

if($_SESSION["perfil"] != "Administrador"){

  echo '<script>

  swal({
    type: "warning",
    title: "No tiene acceso a este módulo",
    showConfirmButton: true,
    confirmButtonText: "Cerrar"
    }).then(function(result){
        window.location = "inicio";
          })

  </script>';

  return;

}

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Administrar Usuarios
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Administrar usuarios</li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <div class="box-header with-border">

                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">

                    Agregar usuario

                </button>

            </div>

            <div class="box-body">



                <table class="table <!--=table-bordered table-striped=--> dt-responsive table-hover display tablas tablaUsuarios tabla-redondeada"
                    cellspacing="0" width="100%">
                    <thead>

                        <tr>
                            <th style="width:10px"><i class="fa fa-hashtag"></i></th>
                            <th><i class="fa fa-id-card-o"></i> Nombre</th>
                            <th><i class="fa fa-file-code-o"></i> Usuario</th>
                            <th><i class="fa fa-file-image-o"></i> Foto</th>
                            <th><i class="fa fa-id-badge"></i> Perfil</th>
                            <th><i class="fa fa-id-badge"></i> Estado</th>
                            <th><i class="fa fa-calendar"></i> Último login</th>
                            <th><i class="fa fa-pencil-square-o"></i> Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        $item = null;
                        $valor = null;

                        $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

                        foreach ($usuarios as $key => $value) {

                            echo ' <tr>
                            <td>' . ($key + 1) . '</td>
                            <td>' . $value["nombre"] . '</td>
                            <td>' . $value["usuario"] . '</td>';

                            if ($value["foto"] != "") {

                                echo '<td><img src="' . $value["foto"] . '" class="img-thumbnail" width="40px"></td>';

                            } else {

                                echo '<td><img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail" width="40px"></td>';

                            }

                            echo '<td>' . $value["perfil"] . '</td>';

                            if ($value["estado"] != 0) {

                                echo '<td><button class="btn btn-success btn-xs btnActivar" idUsuario="' . $value["id"] . '" estadoUsuario="0">Activado</button></td>';

                            } else {

                                echo '<td><button class="btn btn-danger btn-xs btnActivar" idUsuario="' . $value["id"] . '" estadoUsuario="1">Desactivado</button></td>';

                            }

                            echo '<td>' . $value["ultimo_login"] . '</td>
                            <td>

                                <div class="btn-group">
                                    
                                <button class="btn btn-warning btnEditarUsuario" idUsuario="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-edit"></i></button>';

                            if ($_SESSION["perfil"] == "Administrador") {

                                echo '<button class="btn btn-danger btnEliminarUsuario" idUsuario="' . $value["id"] . '" fotoUsuario="' . $value["foto"] . '" usuario="' . $value["usuario"] . '"><i class="fa fa-trash"></i></button>';
                            }

                            echo '</div>  

                            </td>

                            </tr>';
                        }


                        ?>

                    </tbody>

                </table>

            </div>

        </div>

    </section>

</div>

<!-- ====================
MODAL AGREGAR USUARIO
<!-- ==================== -->

<!-- Modal -->
<div id="modalAgregarUsuario" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <!-- ====================
                CABEZA DEL MODAL
                <!-- ==================== -->

                <div class="modal-header" style="background: #3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Agregar usuario</h4>

                </div>

                <!-- ====================
                CUERPO DEL MODAL
                <!-- ==================== -->

                <div class="modal-body">

                    <div class="box-body">

                        <!-- ====================
                        ENTRADA PARA EL NOMBRE
                        <!-- ==================== -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>

                                </span>

                                <input name="nuevoNombre" type="text" class="form-control input-md"
                                    placeholder="Ingresar nombre" required> </input>

                            </div>

                        </div>

                        <!-- ====================
                        ENTRADA PARA LA USUARIO
                        <!-- ==================== -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon">
                                    <i class="fa fa-key"></i>

                                </span>

                                <input id="nuevoUsuario" name="nuevoUsuario" type="text" class="form-control input-md"
                                    placeholder="Ingresar usuario" required> </input>

                            </div>

                        </div>

                        <!-- ====================
                        ENTRADA PARA LA CONTRASEÑA
                        <!-- ==================== -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>

                                </span>

                                <input name="nuevoPassword" type="password" class="form-control input-md"
                                    placeholder="Ingresar contraseña" required> </input>

                            </div>

                        </div>

                        <!-- ====================
                        ENTRADA PARA SELECCION E PERFIL
                        <!-- ==================== -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon">
                                    <i class="fa fa-users"></i>

                                </span>

                                <select class="form-control input-md" name="nuevoPerfil">
                                    <option value="" selected>Seleccionar perfil</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Sub-Administrador">Sub-Administrador</option>
                                    <option value="Vendedor">Vendedor</option>
                                    <option value="Especial">Especial</option>
                                    
                                </select>

                            </div>

                        </div>

                        <!-- ====================
                    ENTRADA PARA SUBIR FOTO
                    <!-- ==================== -->

                        <div class="form-group">

                            <div class="panel">SUBIR FOTO</div>

                            <input type="file" name="nuevaFoto" class="nuevaFoto">

                            <p class="help-block">Peso máximo de la foto 200kb</p>

                            <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar"
                                width="100px">

                        </div>

                    </div>

                </div>

                <!-- ====================
                PIE DE PÁGINA DEL MODAL
                <!-- ==================== -->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                    <button type="submit" class="btn btn-primary">Guardar usuario</button>

                </div>

                <?php

                $crearUsuario = new ControladorUsuarios();
                $crearUsuario->ctrCrearUsuario();

                ?>

            </form>

        </div>

    </div>

</div>

<!-- ====================
MODAL EDITAR USUARIO
<!-- ==================== -->

<!-- Modal -->
<div id="modalEditarUsuario" class="modal fade" role="dialog">

    <div class="modal-dialog">

        <div class="modal-content">

            <form role="form" method="post" enctype="multipart/form-data">

                <!-- ====================
                CABEZA DEL MODAL
                <!-- ==================== -->

                <div class="modal-header" style="background: #3c8dbc; color:white">

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                    <h4 class="modal-title">Editar usuario</h4>

                </div>

                <!-- ====================
                CUERPO DEL MODAL
                <!-- ==================== -->

                <div class="modal-body">

                    <div class="box-body">

                        <!-- ====================
                        ENTRADA PARA EL NOMBRE
                        <!-- ==================== -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>

                                </span>

                                <input id="editarNombre" name="editarNombre" type="text" class="form-control input-md"
                                    value="" required>
                                </input>

                            </div>

                        </div>

                        <!-- ====================
                        ENTRADA PARA EL USUARIO
                        <!-- ==================== -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon">
                                    <i class="fa fa-key"></i>

                                </span>

                                <input id="editarUsuario" name="editarUsuario" type="text" class="form-control input-md"
                                    value="" readonly>
                                </input>

                            </div>

                        </div>

                        <!-- ====================
                        ENTRADA PARA LA CONTRASEÑA
                        <!-- ==================== -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon">
                                    <i class="fa fa-lock"></i>

                                </span>

                                <input name="editarPassword" type="password" class="form-control input-md"
                                    placeholder="escriba la nueva contraseña"> </input>

                                <input name="passwordActual" type="hidden" id="passwordActual"> </input>

                            </div>

                        </div>

                        <!-- ====================
                        ENTRADA PARA SELECCION E PERFIL
                        <!-- ==================== -->

                        <div class="form-group">

                            <div class="input-group">

                                <span class="input-group-addon">
                                    <i class="fa fa-users"></i>

                                </span>

                                <select class="form-control input-md" name="editarPerfil">
                                    <option value="" id="editarPerfil"></option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Sub-Administrador">Sub-Administrador</option>
                                    <option value="Vendedor">Vendedor</option>
                                    <option value="Especial">Especial</option>
                                </select>

                            </div>

                        </div>

                        <!-- ====================
                    ENTRADA PARA SUBIR FOTO
                    <!-- ==================== -->

                        <div class="form-group">

                            <div class="panel">SUBIR FOTO</div>

                            <input type="file" name="editarFoto" class="nuevaFoto">

                            <p class="help-block">Peso máximo de la foto 200kb</p>

                            <img src="vistas/img/usuarios/default/anonymous.png" class="img-thumbnail previsualizar"
                                width="100px">

                            <input name="fotoActual" type="hidden" id="fotoActual"> </input>

                        </div>

                    </div>

                </div>

                <!-- ====================
                PIE DE PÁGINA DEL MODAL
                <!-- ==================== -->

                <div class="modal-footer">

                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

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

<?php

$borrarUsuario = new ControladorUsuarios();
$borrarUsuario->ctrBorrarUsuario();

?>
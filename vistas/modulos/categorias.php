<?php

if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Sub-Administrador") {

  ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>

        Administrar categorías

      </h1>

      <ol class="breadcrumb">

        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

        <li class="active">Administrar categorías</li>

      </ol>

    </section>

    <section class="content">

      <div class="box">

        <div class="box-header with-border">

          <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">

            Agregar categoría

          </button>

        </div>

        <div class="box-body">

          <table class="table <!--=table-bordered table-striped=--> dt-responsive table-hover display tablas tablaCategorias tabla-redondeada"
            cellspacing="0" width="100%">

            <thead>

              <tr>

                <th style="width:10px"><i class="fa fa-hashtag"></i></th>
                <th><i class="fa fa-th"></i> Categoria</th>
                <th><i class="fa fa-pencil-square-o"></i> Acciones</th>

              </tr>

            </thead>

            <tbody>

              <?php

              $item = null;
              $valor = null;

              $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

              foreach ($categorias as $key => $value) {

                echo ' <tr>

                    <td>' . ($key + 1) . '</td>

                    <td>' . $value["categoria"] . '</td>

                    <td>

                      <div class="btn-group">
                          
                        <button class="btn btn-warning btnEditarCategoria" idCategoria="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-edit"></i></button>';

                if ($_SESSION["perfil"] == "Administrador") {

                  echo '<button class="btn btn-danger btnEliminarCategoria" idCategoria="' . $value["id"] . '"><i class="fa fa-trash"></i></button>';
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

  <!--=====================================
MODAL AGREGAR CATEGORÍA
======================================-->

  <div id="modalAgregarCategoria" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <div class="modal-content">

        <form role="form" method="post">

          <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

          <div class="modal-header" style="background:#3c8dbc; color:white">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">Agregar categoría</h4>

          </div>

          <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

          <div class="modal-body">

            <div class="box-body">

              <!-- ENTRADA PARA EL NOMBRE -->

              <div class="form-group">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-th"></i></span>

                  <input type="text" class="form-control input-md" name="nuevaCategoria" id="nuevaCategoria"
                    placeholder="Ingresar categoría" required>

                </div>

                <div id="errorNombreC" style="margin-left: 42px; color: red;">
                
                </div>

              </div>

            </div>

          </div>

          <!--=====================================
        PIE DEL MODAL
        ======================================-->

          <div class="modal-footer">

            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">Guardar categoría</button>

          </div>

          <?php

          $crearCategoria = new ControladorCategorias();
          $crearCategoria->ctrCrearCategoria();

          ?>

        </form>

      </div>

    </div>

  </div>

  <!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->

  <div id="modalEditarCategoria" class="modal fade" role="dialog">

    <div class="modal-dialog">

      <div class="modal-content">

        <form role="form" method="post">

          <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

          <div class="modal-header" style="background:#3c8dbc; color:white">

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <h4 class="modal-title">Editar categoría</h4>

          </div>

          <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

          <div class="modal-body">

            <div class="box-body">

              <!-- ENTRADA PARA EL NOMBRE -->

              <div class="form-group">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-th"></i></span>

                  <input type="text" class="form-control input-md" name="CeditarCategoria" id="CeditarCategoria" required>

                  <input type="hidden" name="CidCategoria" id="CidCategoria" required>

                </div>

                <div id="errorNombreEC" style="margin-left: 42px; color: red;">
                
                </div>

              </div>
              <table class="table table-hover tablaCategoriasProductos" style="overflow-y: auto;" cellspacing="0"
                width="100%">
                <thead>
                  <tr>
                    <h4 class="box-title page-header "><b class='text-navy'><i class="fa fa-cube"></i> Productos </b></h4>
                    <!--<th style="width:10px"><i class="fa fa-hashtag"></i></th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Precio Venta</th>
                  <th>Stock</th>-->
                  </tr>
                </thead>

                <tbody>

                </tbody>
              </table>

            </div>

          </div>



          <!--=====================================
        PIE DEL MODAL
        ======================================-->

          <div class="modal-footer">

            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>

          </div>

          <?php

          $editarCategoria = new ControladorCategorias();
          $editarCategoria->ctrEditarCategoria();

          ?>

        </form>

      </div>

    </div>

  </div>

  <?php

  $borrarCategoria = new ControladorCategorias();
  $borrarCategoria->ctrBorrarCategoria();

} else {
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
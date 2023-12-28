<?php

if ($_SESSION["perfil"] == "Especial") {

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
      Administrar Productos

    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar productos</li>
    </ol>
  </section>

  <section class="content">

    <div class="box">
      <div class="box-header with-border">

        <?php

        if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Sub-Administrador") {

          echo

            '<button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto"><i
            class="fa fa-cube"></i>

          Agregar producto

        </button>';
        }

        ?>

        <?php

        if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Sub-Administrador") {

          echo

            '<button class="btn btn-instagram crear-combo-button"><i
            class="fa fa-cubes"></i>

            Creat combo/kit

        </button>';
        }

        ?>

        <?php

        if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Sub-Administrador") {

          echo

            '<button class="btn btn-default edit-category-button"><i
            class="fa fa-th"></i>

            Editar Categorias

          </button>';
        }

        ?>

        <div class="pull-right input-group">

          <select class="btn primary" id="cat-select" name="cat-select">

            <option value="">Todas</option>

            <?php

            $item = null;
            $valor = null;

            $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

            foreach ($categorias as $key => $value) {

              echo '<option value="' . $value["categoria"] . '">' . $value["categoria"] . '</option>';
            }

            ?>
          </select>

        </div>

        <!-- Mantener el color blanco del texto del select -->
        <script>
          document.addEventListener('DOMContentLoaded', function () {
            var select = document.querySelector('select');
            select.addEventListener('mouseover', function () {
              select.style.color = 'white';
            });
            select.addEventListener('mouseout', function () {
              select.style.color = 'white';
            });
          });
        </script>

        <!-- <a href="productos-mosaico">
          <button class="btn btn-primary pull-right" id="toggleButton"><i class="fa fa-th"></i>

            Cambiar Vista

          </button>
        </a>=-->

        <!--=====================================
                
                <button class="btn btn-vk" data-toggle="modal" data-target="#modalAgregarCategoria"> <i class="fa fa-th"></i>

                    Agregar Categoría

                </button>

                

                <a href="categorias">
                <button class="btn btn-vk"> <i class="fa fa-pencil-square-o"></i> Editar Categoría</button>
                </a> 

                ======================================-->


      </div>

      <div class="box-body">

        <div class="table-container">


          <table
            class="table  <!--table-bordered table-striped--> dt-responsive table-hover display tablaProductos tabla-redondeada"
            cellspacing="0" width="100%">
            <thead>

              <tr>
                <th style="width:10px"><i class="fa fa-hashtag"></i></th>
                <th><i class="fa fa-file-image-o"></i> Imagen</th>
                <th><i class="fa fa-file-code-o"></i> Código</th>
                <th><i class="fa fa-file"></i> Descripcion</th>
                <th><i class="fa fa-th"></i> Categoría</th>
                <th><i class="fa fa-cubes"></i> Stock</th>
                <th><i class="fa fa-money"></i> Precio de Compra</th>
                <th><i class="fa fa-tags"></i> Precio de Venta</th>
                <th><i class="fa fa-tags"></i> Estado</th>
                <th><i class="fa fa-calendar"></i> Agregado</th>
                <th><i class="fa fa-pencil-square-o"></i> Acciones</th>
              </tr>


            </thead>

          </table>

        </div>

        <div class="category-sidebar">
          <!-- Aquí se mostrarán las categorías -->
          <div class="box-body">

            <button class="btn btn-flat edit-category-button"> <i class="fa fa-arrow-left"></i></button>

            <br>

            <div class="col-xs-6">

              <h2 class="tCategoria">
                <b>Editar categorias</b>
              </h2>

            </div>
            <br>
            <br>

            <div class="col-xs-6" style="padding-left:0px">

              <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalAgregarCategoria">

                Nueva categoría

              </button>

            </div>

            <br>
            <br>
            <br>
            <br>


            <table
              class="table <!--=table-bordered table-striped=--> dt-responsive table-hover display tablas tablaCategorias tabla-redondeada"
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
                          
                        <button class="btn btn-default btnEditarCategoria" idCategoria="' . $value["id"] . '" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-edit"></i></button>';

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


      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR PRODUCTO
======================================-->

<div id="modalAgregarProducto" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar producto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-md" id="nuevaCategoria" name="nuevaCategoria" required>

                  <option value="">Selecionar categoría</option>

                  <?php

                  $item = null;
                  $valor = null;

                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                  foreach ($categorias as $key => $value) {

                    echo '<option value="' . $value["id"] . '">' . $value["categoria"] . '</option>';
                  }

                  ?>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL CÓDIGO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-code"></i></span>

                <input type="text" class="form-control input-md" id="nuevoCodigo" name="nuevoCodigo"
                  placeholder="Ingresar código" readonly required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                <input type="text" class="form-control input-md" id="nuevaDescripcion" name="nuevaDescripcion"
                  placeholder="Ingresar descripción" required>

              </div>

              <div id="errorNombreD" style="margin-left: 42px; color: red;">
              </div>

            </div>

            <!-- ENTRADA PARA STOCK -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-check"></i></span>

                <input type="number" class="form-control input-md" name="nuevoStock" value="0" min="0"
                  placeholder="Stock" readonly>

              </div>

            </div>

            <!-- ENTRADA PARA PRECIO COMPRA -->

            <div class="form-group row">

              <div class="col-xs-12 col-sm-6">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>

                  <input type="number" class="form-control input-md" id="nuevoPrecioCompra" name="nuevoPrecioCompra"
                    step="any" min="0" placeholder="Precio de compra" required>

                </div>

              </div>

              <!-- ENTRADA PARA PRECIO VENTA -->

              <div class="col-xs-12 col-sm-6">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>

                  <input type="number" class="form-control input-md" id="nuevoPrecioVenta" name="nuevoPrecioVenta"
                    step="any" min="0" placeholder="Precio de venta" required>

                </div>

                <br>

                <!-- CHECKBOX PARA PORCENTAJE -->

                <div class="col-xs-6">

                  <div class="form-group">

                    <label>

                      <input type="checkbox" class="minimal porcentaje" checked>
                      Utilizar procentaje
                    </label>

                  </div>

                </div>

                <!-- ENTRADA PARA PORCENTAJE -->

                <div class="col-xs-6" style="padding:0">

                  <div class="input-group">

                    <input type="number" class="form-control input-md nuevoPorcentaje" min="0" value="40" required>

                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                  </div>

                </div>

              </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

            <div class="form-group">

              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaImagen" name="nuevaImagen">

              <p class="help-block">Peso máximo de la imagen 200KB</p>

              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar producto</button>

        </div>

      </form>

      <?php

      $crearProducto = new ControladorProductos();
      $crearProducto->ctrCrearProducto();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR PRODUCTO
======================================-->

<div id="modalEditarProducto" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar producto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-md" name="editarCategoria" readonly required>

                  <option id="editarCategoria"></option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL CÓDIGO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-code"></i></span>

                <input type="text" class="form-control input-md" id="editarCodigo" name="editarCodigo" readonly
                  required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                <input type="text" class="form-control input-md" id="editarDescripcion" name="editarDescripcion"
                  required>

              </div>

              <div id="errorNombreED" style="margin-left: 42px; color: red;"> </div>

            </div>

            <!-- ENTRADA PARA STOCK -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-check"></i></span>

                <input type="number" class="form-control input-md" id="editarStock" name="editarStock" min="0" required
                  readonly>
                <input type="hidden" class="form-control input-md" id="actualStock" name="actualStock" min="0">
                <input type="hidden" class="form-control input-md" id="actualInicialStock" name="actualInicialStock"
                  min="0">
                <input type="hidden" class="form-control input-md" id="resultado" name="resultado" min="0">

              </div>

            </div>

            <!-- ENTRADA PARA PRECIO COMPRA -->

            <div class="form-group row">

              <div class="col-xs-12 col-sm-6">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>

                  <input type="number" class="form-control input-md" id="editarPrecioCompra" name="editarPrecioCompra"
                    step="any" min="0" required>

                </div>

              </div>

              <!-- ENTRADA PARA PRECIO VENTA -->

              <div class="col-xs-12 col-sm-6">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>

                  <input type="number" class="form-control input-md" id="editarPrecioVenta" name="editarPrecioVenta"
                    step="any" min="0" readonly required>

                </div>

                <br>

                <!-- CHECKBOX PARA PORCENTAJE -->

                <div class="col-xs-6">

                  <div class="form-group">

                    <label>

                      <input type="checkbox" class="minimal porcentaje" checked>
                      Utilizar procentaje
                    </label>

                  </div>

                </div>

                <!-- ENTRADA PARA PORCENTAJE -->

                <div class="col-xs-6" style="padding:0">

                  <div class="input-group">

                    <input type="number" class="form-control input-md nuevoPorcentaje" min="0" value="40" required>

                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>

                  </div>

                </div>

              </div>

            </div>

            <!-- ENTRADA PARA SUBIR FOTO -->

            <div class="form-group">

              <div class="panel">SUBIR IMAGEN</div>

              <input type="file" class="nuevaImagen" name="editarImagen">

              <p class="help-block">Peso máximo de la imagen 2MB</p>

              <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" width="100px">

              <input type="hidden" name="imagenActual" id="imagenActual">

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

      <?php

      $editarProducto = new ControladorProductos();
      $editarProducto->ctrEditarProducto();

      ?>

    </div>

  </div>

</div>

<?php

$eliminarProducto = new ControladorProductos();
$eliminarProducto->ctrEliminarProducto();



?>

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

                <input type="text" class="form-control input-md" name="CnuevaCategoria" id="CnuevaCategoria"
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

?>
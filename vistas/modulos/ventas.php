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

  <section class="content-header">

    <h1>

      Administrar ventas

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar ventas</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <a href="crear-venta">

          <button class="btn styleVenta"><i class="fa fa-cart-plus"></i>

            Nueva venta

          </button>

        </a>

        <?php
        if ($_SESSION["perfil"] == "Vendedor") {

        } else {
          echo '<a href="surtir-inventario">

          <button class="btn styleCosto"><i class="fa fa-cart-plus"></i>

            Surtir Inventario

          </button>

        </a>';
        }

        ?>

        <button class="btn pull-center styleGasto" data-toggle="modal" data-target="#modalAgregarGasto"><i
            class="fa fa-arrow-circle-down"></i>

          Ingreso/Gasto

        </button>


        <button class="btn btn-primary pull-right" id="daterange-btn">
          <span>
            <i class="fa fa-calendar"></i> Rango de fechas
          </span>
          <i class="fa fa-caret-down"></i>

        </button>

        <br>
        <br>

        <!-- ./box-body 
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-4 col-xs-4">
              <div class="description-block border-right">
                

                <?php
                /*
                if (isset($_GET["fechaInicial"])) {

                  $fechaInicial = $_GET["fechaInicial"];
                  $fechaFinal = $_GET["fechaFinal"];

                } else {

                  $fechaInicial = null;
                  $fechaFinal = null;

                }

                $respuesta = ControladorVentas::ctrSumaTVentas($fechaInicial, $fechaFinal);

                foreach ($respuesta as $key => $value1) {

                  $totalVentas = $value1["total_ventas"];
                }

                $respuesta2 = ControladorCostos::ctrSumaTCostos($fechaInicial, $fechaFinal);

                foreach ($respuesta2 as $key => $value2) {

                  $totalCompras = $value2["total_costos"];
                }

                $respuesta3 = ControladorGastos::ctrSumaTGastos($fechaInicial, $fechaFinal);

                foreach ($respuesta3 as $key => $value3) {

                  $totalGastos = $value3["total_gastos"];
                }

                // Realizar la suma total
                $sumaTotal = $totalVentas - $totalCompras - $totalGastos;

                $sumaFormateado = number_format($sumaTotal, 2, '.', ',');

                if ($sumaTotal <= 0) {
                  echo '<h5 class="description-header text-red">$' . $sumaFormateado . '</h5>';
                } else {
                  echo '<h5 class="description-header text-green">$' . $sumaFormateado . '</h5>';
                }
                */
                ?>

            </div>
            
            <div class="col-sm-4 col-xs-4">
              <div class="description-block border-right">
               
                <h5 class="description-header">
                  <?php

                  $valorFormateadoVentas = number_format($totalVentas, 2, '.', ',');
                  echo "$" . $valorFormateadoVentas;

                  ?>

                </h5>
                <span class="description-text">Total Ventas</span>
              </div>
              
            </div>
            
            <div class="col-sm-4 col-xs-4">
              <div class="description-block border-right">
                
                <h5 class="description-header">

                  <?php


                  $sumaTotal2 = $totalCompras + $totalGastos;

                  $sumaFormateado2 = number_format($sumaTotal2, 2, '.', ',');

                  echo "$" . $sumaFormateado2;


                  ?>


                </h5>
                <span class="description-text">Costos/Gastos</span>
              </div>
              
            </div>

          </div>
          
        </div> -->

      </div>

      <style>
        .nav-tabs-custom {
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .nav-tabs-custom .nav-tabs {
            border-bottom: none;
            background-color: #f5f5f5;
            
        }

        .nav-tabs-custom .nav-tabs > li {
            border-radius: 5px 5px 0 0;
        }

        .nav-tabs-custom .nav-tabs > li > a {
            border-radius: 5px 5px 0 0;
            /*margin-right: -1px;*/
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            font-size: 18;  /*Tamaño de fuente más grande */
            font-weight: bold; /* Opcional: hacer el texto en negrita */
            color: #666; /* Color del texto de la pestaña activa */
            
        }

        .nav-tabs-custom .nav-tabs > li.active > a {
            border-color: #ddd;
            background-color: #fff;
            border-bottom-color: transparent;
            color: #666; /* Color del texto de la pestaña activa */
        }

        /* Ajustar las pestañas en pantallas pequeñas */
        @media (max-width: 767px) {
            .nav-tabs-custom .nav-tabs {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
            }

            .nav-tabs-custom .nav-tabs > li {
                flex: 1 1 auto;
                text-align: center;
                margin-bottom: -1px;
            }

            .nav-tabs-custom .nav-tabs > li > a {
                border-radius: 0;
                margin-right: 0;
                border: 0px solid #ddd;
               
            }
        }

     
    </style>
    
      
      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">

        <ul class="nav nav-tabs nav-justified">
          <li role="presentation" class="active"><a href="#tab_1" data-toggle="tab">VENTAS</a></li>
          <li role="presentation"><a href="#tab_2" data-toggle="tab">COSTOS</a></li>
          <li role="presentation"><a href="#tab_3" data-toggle="tab">GASTOS</a></li>
        </ul>
        
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">

            <table class="table dt-responsive tabla-redondeada tablaVentasListado" width="100%">

              <thead>

                <tr>

                  <th style="width:10px"><i class="fa fa-hashtag"></i></th>
                  <th><i class="fa fa-id-card-o"></i> factura</th>
                  <th><i class="fa fa-user"></i> Cliente</th>
                  <th><i class="fa fa-user-secret"></i> Vendedor</th>
                  <th><i class="fa fa-cc-visa"></i> Forma de pago</th>
                  <th><i class="fa fa-usd"></i> Neto</th>
                  <th><i class="fa fa-money"></i> Total</th>
                  <th><i class="fa fa-calendar-o"></i> Fecha</th>
                  <th><i class="fa fa-pencil-square-o"></i>Acciones</th>

                </tr>

              </thead>

              

            </table>

            <?php

            $eliminarVenta = new ControladorVentas();
            $eliminarVenta->ctrEliminarVenta();

            ?>



          </div>
          <!-- /.tab-pane -->




          <div class="tab-pane" id="tab_2">

            <table class="table dt-responsive tablaCostos tabla-redondeada" width="100%">

              <thead>

                <tr>

                  <th style="width:10px"><i class="fa fa-hashtag"></i></th>
                  <th><i class="fa fa-id-card-o"></i> factura</th>
                  <th><i class="fa fa-truck"></i> Proveedor</th>
                  <th><i class="fa fa-cube"></i> Productos</th>
                  <th><i class="fa fa-file-text-o"></i> Comentario</th>
                  <th><i class="fa fa-money"></i> Total</th>
                  <th><i class="fa fa-cc-visa"></i> F. Pago</th>
                  <th><i class="fa fa-user"></i> Usuario</th>
                  <th><i class="fa fa-calendar-o"></i> Fecha</th>
                  <th><i class="fa fa-calendar-check-o"></i> F. Vence</th>
                  <th><i class="fa fa-hourglass-2"></i> Estado</th>
                  <th><i class="fa fa-pencil-square-o"></i>Acciones</th>

                </tr>

              </thead>

            </table>

            <?php

            $DevolverCosto = new ControladorCostos();
            $DevolverCosto->ctrDevolverCosto();

            // $eliminarCosto = new ControladorCostos();
            // $eliminarCosto->ctrEliminarCosto();

            ?>



          </div>
          <!-- /.tab-pane -->



          <div class="tab-pane" id="tab_3">
            <table class="table dt-responsive tablaGastos tabla-redondeada" width="100%">

              <thead>

                <tr>

                  <th style="width:10px"><i class="fa fa-hashtag"></i></th>
                  <th><i class="fa fa-file-code-o"></i> Código</th>
                  <th><i class="fa fa-th"></i> Categoría</th>
                  <th><i class="fa fa-money"></i> Monto</th>
                  <th><i class="fa fa-file-text-o"></i> Concepto</th>
                  <th><i class="fa fa-truck"></i> proveedor</th>
                  <th><i class="fa fa-cc-visa"></i> F. Pago</th>
                  <th><i class="fa fa-user"></i> Usuario</th>
                  <th><i class="fa fa-calendar-o"></i> Fecha</th>
                  <th><i class="fa fa-pencil-square-o"></i>Acciones</th>

                </tr>

              </thead>

            </table>

          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- nav-tabs-custom -->

      <!-- /.col -->


    </div>

  </section>

</div>


<!--=====================================
MODAL AGREGAR GASTO
======================================-->

<div id="modalAgregarGasto" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar gasto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================-->

            <!--div class="form-group">-->

            <div class="input-group">

              <!--<span class="input-group-addon"><i class="fa fa-key"></i></span>-->

              <?php

              $item = null;
              $valor = null;


              $gastos = ControladorGastos::ctrMostrarMaxCodigoGastos($item, $valor);

              if (!$gastos) {

                echo '<input type="hidden" class="form-control" id="nuevoGastoInventario" name="nuevoGastoInventario" value="10001" readonly>';


              } else {

                foreach ($gastos as $key => $value) {



                }

                $codigo = $value["codigo"] + 1;



                echo '<input type="hidden" class="form-control" id="nuevoGastoInventario" name="nuevoGastoInventario" value="' . $codigo . '" readonly>';


              }

              ?>


            </div>

            <!--</div>-->


            <!-- ENTRADA PARA SELECCIONAR REGISTRO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-md" id="nuevoTipoGasto" name="nuevoTipoGasto" required>
                  <option value="Gasto">Gasto</option>
                  <option value="Ingreso">Ingreso</option>
                </select>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-md" id="nuevaCategoriaG" name="nuevaCategoriaG" required>

                  <option value="" selected>Selecionar categoría</option>
                  <option value="Productos e insumos">Productos e insumos</option>
                  <option value="Servicios públicos">Servicios públicos</option>
                  <option value="Arriendo">Arriendo</option>
                  <option value="Nómina">Nómina</option>
                  <option value="Publicidad">Publicidad</option>
                  <option value="Impuestos">Impuestos</option>
                  <option value="Otro">Otro</option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL MONTO -->

            <div class="form-group row">

              <div class="col-xs-12 col-sm-12">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>

                  <input type="number" class="form-control input-md" id="nuevoMonto" name="nuevoMonto" step="any"
                    min="0" placeholder="Monto" required>

                </div>

              </div>

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                <input type="text" class="form-control input-md" name="nuevoConcepto" placeholder="Ingresar el concepto"
                  required>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR EL PROVEEDOR -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-md" id="nuevoProveedor" name="nuevoProveedor" style="width: 100%;">

                  <option></option>

                  <?php

                  $item = null;
                  $valor = null;

                  $proveedores = ControladorProveedores::ctrMostrarProveedores($item, $valor);

                  foreach ($proveedores as $key => $value) {

                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';
                  }

                  ?>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR FORMA DE PAGO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-md" id="nuevoMpago" name="nuevoMpago" required>

                  <option value="" selected>Selecionar forma de pago</option>
                  <option value="Efectivo">Efectivo</option>
                  <option value="Transferencia">Transferencia</option>
                  <option value="Tarjeta Crédito">Tarjeta Crédito</option>
                  <option value="Tarjeta Débito">Tarjeta Débito</option>
                  <option value="Otro">Otro</option>

                </select>

              </div>

            </div>


            <!--=====================================
                ENTRADA EL USUARIO
                ======================================-->

            <div class="form-group">

              <div class="input-group">

                <input type="hidden" name="idRusuario" value="<?php echo $_SESSION["id"]; ?>">

              </div>

            </div>



          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn styleGasto">Guardar gasto</button>

        </div>

      </form>

      <?php

      $crearGasto = new ControladorGastos();
      $crearGasto->ctrCrearGasto();

      ?>

    </div>

  </div>

</div>


<!--=====================================
MODAL EDITAR GASTO
======================================-->

<div id="modalEditarGasto" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar gasto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


          <!-- ENTRADA PARA SELECCIONAR REGISTRO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-md" name="editarTipoGasto" required>
                  <option value="" id="editarTipoGasto"></option>
                  <option value="Gasto">Gasto</option>
                  <option value="Ingreso">Ingreso</option>
                </select>

              </div>

            </div>


            <!-- ENTRADA PARA SELECCIONAR CATEGORÍA -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-md" name="editarCategoriaG" required>

                  <option value="" id="editarCategoriaG"></option>
                  <option value="Productos e insumos">Productos e insumos</option>
                  <option value="Servicios públicos">Servicios públicos</option>
                  <option value="Arriendo">Arriendo</option>
                  <option value="Nómina">Nómina</option>
                  <option value="Publicidad">Publicidad</option>
                  <option value="Otro">Otro</option>

                </select>

              </div>

            </div>

            <!-- ENTRADA PARA EL MONTO -->

            <div class="form-group row">

              <div class="col-xs-12 col-sm-12">

                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>

                  <input type="number" class="form-control input-md" id="editarMonto" name="editarMonto" step="any"
                     required>

                </div>

              </div>

            </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>

                <input type="text" class="form-control input-md" id="editarConcepto" name="editarConcepto" required>

                <input type="hidden" id="idGasto" name="idGasto" required>

              </div>

            </div>

            <!-- ENTRADA PARA SELECCIONAR EL PROVEEDOR-->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-md select2editarProveedor" name="editarProveedor"
                  style="width: 100%;">

                  <option id="editarProveedor"></option>

                  <?php

                  $item = null;
                  $valor = null;

                  $proveedor = ControladorProveedores::ctrMostrarProveedores($item, $valor);

                  foreach ($proveedor as $key => $value) {

                    echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';

                  }

                  ?>

                </select>

              </div>

            </div>


            <!-- ENTRADA PARA SELECCIONAR FORMA DE PAGO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <select class="form-control input-md" name="editarMpago" required>

                  <option value="" id="editarMpago"></option>
                  <option value="Efectivo">Efectivo</option>
                  <option value="Transferencia">Transferencia</option>
                  <option value="Tarjeta Crédito">Tarjeta Crédito</option>
                  <option value="Tarjeta Débito">Tarjeta Débito</option>
                  <option value="Otro">Otro</option>

                </select>

              </div>

            </div>


            <!--=====================================
                ENTRADA EL USUARIO
                ======================================-->

            <div class="form-group">

              <div class="input-group">

                <input type="hidden" name="idEditarRusuario" value="<?php echo $_SESSION["id"]; ?>">

              </div>

            </div>

          </div>

        </div>


        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Editar gasto</button>

        </div>

        <?php

        $editarGasto = new ControladorGastos();
        $editarGasto->ctrEditarGasto();

        ?>

      </form>

    </div>

  </div>

</div>

<?php

$eliminarGasto = new ControladorGastos();
$eliminarGasto->ctrEliminarGasto();

?>
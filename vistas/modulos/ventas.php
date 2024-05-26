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

        <!-- ./box-body -->
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-4 col-xs-4">
              <div class="description-block border-right">
                <!-- <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 17%</span>-->

                <?php
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

                ?>


                <span class="description-text">Balance</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-xs-4">
              <div class="description-block border-right">
                <!-- <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 90%</span>-->
                <h5 class="description-header">
                  <?php

                  $valorFormateadoVentas = number_format($totalVentas, 2, '.', ',');
                  echo "$" . $valorFormateadoVentas;

                  ?>

                </h5>
                <span class="description-text">Total Ventas</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-xs-4">
              <div class="description-block border-right">
                <!-- <span class="description-percentage text-red"><i class="fa fa-caret-up"></i> 20%</span>-->
                <h5 class="description-header">

                  <?php


                  $sumaTotal2 = $totalCompras + $totalGastos;

                  $sumaFormateado2 = number_format($sumaTotal2, 2, '.', ',');

                  echo "$" . $sumaFormateado2;


                  ?>


                </h5>
                <span class="description-text">Costos/Gastos</span>
              </div>
              <!-- /.description-block -->
            </div>

          </div>
          <!-- /.row -->
        </div>

      </div>

      <style>
        /* Estilo para la pestaña activa */
        .nav-tabs-custom .nav-tabs .active a {
          background-color: #f8f8f8;
          /* Fondo de la pestaña activa */
          color: #fff;
          /* Color del texto de la pestaña activa */
          border-color: #f8f8f8;
          /* Borde de la pestaña activa */
        }

        /* Estilo para las pestañas inactivas */
        .nav-tabs-custom .nav-tabs li a {
          background-color: #f8f8f8;
          /* Fondo de las pestañas inactivas */
          color: #333;
          /* Color del texto de las pestañas inactivas */
          border-color: #ccc;
          /* Borde de las pestañas inactivas */
        }

        /* Estilo para el contenido de las pestañas */
        .nav-tabs-custom .tab-content {
          border: 1px solid #ccc;
          /* Borde alrededor del contenido */
          border-top: none;
          /* Elimina el borde superior */
          border-radius: 0 0 4px 4px;
          /* Bordes inferiores redondeados */
          padding: 20px;
          /* Espaciado interior del contenido de pestaña */
          background-color: #fff;
          /* Color de fondo del contenido de pestaña */
        }
      </style>


      <!-- Custom Tabs -->
      <div class="nav-tabs-custom">
        <!-- Para dispositivos pequeños -->
        <div class="btn-group btn-group-justified visible-xs">
          <a href="#tab_1" data-toggle="tab" class="btn btn-default">
            <H4><b style="color: #526c77;">VENTAS</b></H4>
          </a>
          <a href="#tab_2" data-toggle="tab" class="btn btn-default">
            <H4><b style="color: #526c77;">COSTOS</b></H4>
          </a>
          <a href="#tab_3" data-toggle="tab" class="btn btn-default">
            <H4><b style="color: #526c77;">GASTOS</b></H4>
          </a>
        </div>

        <!-- Para dispositivos grandes -->
        <div class="btn-group btn-group-justified hidden-xs">
          <a href="#tab_1" data-toggle="tab" class="btn btn-default">
            <H4><b style="color: #526c77;">VENTAS</b></H4>
          </a>
          <a href="#tab_2" data-toggle="tab" class="btn btn-default">
            <H4><b style="color: #526c77;">COSTOS</b></H4>
          </a>
          <a href="#tab_3" data-toggle="tab" class="btn btn-default">
            <H4><b style="color: #526c77;">GASTOS</b></H4>
          </a>
        </div>

        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">

            <table class="table dt-responsive tablas tablaVentas tabla-redondeada" width="100%">

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

              <tbody>

                <?php

                if (isset($_GET["fechaInicial"])) {

                  $fechaInicial = $_GET["fechaInicial"];
                  $fechaFinal = $_GET["fechaFinal"];

                } else {

                  $fechaInicial = null;
                  $fechaFinal = null;

                }

                $respuesta = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

                foreach ($respuesta as $key => $valueV) {


                  echo '<tr>
 
                   <td>' . ($key + 1) . '</td>
 
                   <td>' . $valueV["codigo"] . '</td>';

                  $itemCliente = "id";
                  $valorCliente = $valueV["id_cliente"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  echo '<td>' . $respuestaCliente["nombre"] . '</td>';

                  $itemUsuario = "id";
                  $valorUsuario = $valueV["id_vendedor"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td>' . $respuestaUsuario["nombre"] . '</td>
 
                   <td>' . $valueV["metodo_pago"] . '</td>
 
                   <td>$ ' . number_format($valueV["neto"], 2) . '</td>
 
                   <td>$ ' . number_format($valueV["total"], 2) . '</td>
 
                   <td>' . $valueV["fecha_crea"] . '</td>
 
                   <td>
 
                     <div class="btn-group">
                         
                       <button class="btn btn-info"><i class="fa fa-print"></i></button>';

                  if ($_SESSION["perfil"] == "Administrador") {

                    //La edicion de la venta se encuentra en revision, ya que debe anularse con nota credito segun DIAN
                    //echo '<button class="btn btn-warning btnEditarVenta" idVenta="' . $valueV["id"] . '" data-toggle="modal" data-target="#modalEditarVenta"><i class="fa fa-edit"></i></button>';
                
                    //echo '<button class="btn btn-danger btnEliminarVenta" idVenta="' . $valueV["id"] . '"><i class="fa fa-trash"></i></button>';

                  }

                  echo '</div>  
 
                   </td>
 
                 </tr>';
                }

                ?>

              </tbody>

            </table>

            <?php

            $eliminarVenta = new ControladorVentas();
            $eliminarVenta->ctrEliminarVenta();

            ?>



          </div>
          <!-- /.tab-pane -->




          <div class="tab-pane" id="tab_2">

            <table class="table dt-responsive tablas tablaCostos tabla-redondeada" width="100%">

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

              <tbody>

                <?php

                if (isset($_GET["fechaInicial"])) {

                  $fechaInicial = $_GET["fechaInicial"];
                  $fechaFinal = $_GET["fechaFinal"];

                } else {

                  $fechaInicial = null;
                  $fechaFinal = null;

                }

                $respuesta = ControladorCostos::ctrRangoFechasCostos($fechaInicial, $fechaFinal);


                foreach ($respuesta as $key => $valueC) {


                  echo '<tr>
 
                   <td>' . ($key + 1) . '</td>
 
                   <td>' . $valueC["codigo"] . '</td>';

                  $itemProveedorC = "id";
                  $valorProveedorC = $valueC["id_proveedor"];

                  $respuestaProveedorC = ControladorProveedores::ctrMostrarProveedores($itemProveedorC, $valorProveedorC);

                  echo '<td>' . $respuestaProveedorC["nombre"] . '</td>';

                  //Obtener la celda de productos
                  $json = $valueC["productos"];

                  // Decodificar el JSON de productos
                  $productos = json_decode($json, true);

                  // Inicializar una variable para concatenar descripciones de productos
                  $descripcionProductos = '';

                  foreach ($productos as $producto) {
                    $descripcionProductos .= $producto['descripcion'] . '<br> ';
                  }

                  // Eliminar la coma y el espacio al final de la cadena
                  $descripcionProductos = rtrim($descripcionProductos, ', ');

                  // Mostrar las descripciones de productos en la celda
                  echo '<td>' . $descripcionProductos . '</td>

                    <td>' . $valueC["nombre_costo"] . '</td>

 
                   <td>$ ' . number_format($valueC["total"], 2) . '</td>


                  <td>' . $valueC["metodo_pago"] . '</td>';



                  $itemUsuario = "id";
                  $valorUsuario = $valueC["id_usuario"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td>' . $respuestaUsuario["nombre"] . '</td>
 
                   <td>' . $valueC["fecha_crea"] . '</td>

                   <td>' . $valueC["vencimiento"] . '</td>';

                   $fecha_actual = new DateTime();

              $fecha_Vencimiento = new DateTime($valueC['vencimiento']);
              ;

              $intervalo = $fecha_actual->diff($fecha_Vencimiento);


              echo '<td>';


              if ($valueC['estado'] == "" && $valueC['vencimiento'] == "0000-00-00 00:00:00") {
                echo "<b class='custom-label'>N/A<td>

                  <div align='center' valign='middle'><i class='fa fa-exclamation-circle'></i></div>

                  </b>";

                } elseif ($valueC['estado'] == "NR") {
                echo "<b class='custom-label'>Devuelto<td>

                <div align='center' valign='middle'><i class='fa fa-exclamation-circle'></i></div>

                    </b>";
              } elseif ($valueC['estado'] == "R") {
                echo "<b class='label label-primary'>Renovado<td>

                <div align='center' valign='middle'><i class='fa fa-exclamation-circle'></i></div>


                    </b>";
              } elseif ($fecha_Vencimiento >= $fecha_actual & $intervalo->days >= 6) {
                echo "<b class='label label-success'>Vigente<td>

                    <div class='btn-group'>

                    <button class='btn btn-twitter btnRenovarCosto' title = 'Renovar' estadoCosto='R' idCosto='" . $valueC["id"] . "'><i class='fa fa-refresh'></i></button>

                    </b>";
              } elseif ($fecha_Vencimiento <= $fecha_actual) {
                echo "<b class='label label-danger'>VENCIDO<td>

                    <div class='btn-group'>

                    <button class='btn bg-light-blue-active btnDevolverCosto' title = 'Devolver Producto' estadoCosto='NR' idCosto='" . $valueC["id"] . "'><i class='fa fa-retweet'></i></button>
                    <button class='btn btn-twitter btnRenovarCosto' title = 'Renovar' estadoCosto='R' idCosto='" . $valueC["id"] . "'><i class='fa fa-refresh'></i></button>
                    </b>";


              } elseif ($intervalo->days <= 6) {

                 if ($_SESSION["perfil"] == "Administrador") {
                echo "<b class='label label-warning'>Por vencer<td>

                    <div class='btn-group'>
                
      
                    <button class='btn bg-light-blue-active btnDevolverCosto' title = 'Devolver Producto' estadoCosto='NR' idCosto='" . $valueC["id"] . "'><i class='fa fa-retweet'></i></button>

                    <button class='btn btn-twitter btnRenovarCosto' title = 'Renovar' estadoCosto='R' idCosto='" . $valueC["id"] . "'><i class='fa fa-refresh'></i></button>
                    
                    <!--<button class='btn btn-danger btnEliminarCosto' idCosto='" . $valueC["id"] . "'><i class='fa fa-trash'></i></button>-->

                    </b>";

                    
                 }else{
                  echo "<b class='label label-warning'>Por vencer<td>

                    <div class='btn-group'>
                
      
                    <button class='btn bg-light-blue-active btnDevolverCosto' title = 'Devolver Producto' estadoCosto='NR' idCosto='" . $valueC["id"] . "'><i class='fa fa-retweet'></i></button>

                    <button class='btn btn-twitter btnRenovarCosto' title = 'Renovar' estadoCosto='R' idCosto='" . $valueC["id"] . "'><i class='fa fa-refresh'></i></button>

                    </b>";

                 }

              }
              echo '</td>
        
                  

                </tr>';
            }

                   /*
 
                   <td>
 
                     <div class="btn-group">
                         
                       <button class="btn btn-info"><i class="fa fa-print"></i></button>';

                  if ($_SESSION["perfil"] == "Administrador") {

                    //La edicion del costo se encuentra en revision, ya que no se ha podido implementar una manera de no alterar el inventario
                    //echo '<button class="btn btn-warning btnEditarCosto" idCosto="' . $valueC["id"] . '"><i class="fa fa-edit"></i></button>';
                


                    echo '<button class="btn btn-danger btnEliminarCosto" idCosto="' . $valueC["id"] . '"><i class="fa fa-trash"></i></button>';

                  }

                  echo '</div>  
 
                   </td>
 
                 </tr>';
                }

                */

                ?>

              </tbody>

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
            <table class="table dt-responsive tablas tablaGastos tabla-redondeada" width="100%">

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

              <tbody>

                <?php

                if (isset($_GET["fechaInicial"])) {

                  $fechaInicial = $_GET["fechaInicial"];
                  $fechaFinal = $_GET["fechaFinal"];

                } else {

                  $fechaInicial = null;
                  $fechaFinal = null;

                }

                $respuesta = ControladorGastos::ctrRangoFechasGastos($fechaInicial, $fechaFinal);

                foreach ($respuesta as $key => $valueG) {


                  echo '<tr>
 
                   <td>' . ($key + 1) . '</td>
                   <td>' . $valueG["codigo"] . '</td>';

                  /*
                   if ($valueG["categoria"] == 1) {
                     echo '<td>Servicios públicos</td>';

                   } elseif ($valueG["categoria"] == 2) {
                     echo '<td>Compra de productos e insumos</td>';

                   } elseif ($valueG["categoria"] == 3) {
                     echo '<td>Arriendo</td>';

                   } elseif ($valueG["categoria"] == 4) {
                     echo '<td>Nómina</td>';

                   } elseif ($valueG["categoria"] == 5) {
                     echo '<td>Publicidad</td>';

                   } else {
                     echo '<td>Otro</td>';
                   }*/

                  echo '<td>' . $valueG["categoria"] . '</td>';

                  echo '<td>$ ' . number_format($valueG["monto"], 2) . '</td>

                   <td>' . $valueG["nombre_gasto"] . '</td>';

                  $itemProveedor = "id";
                  $valorProveedor = $valueG["id_proveedor"];

                  $respuestaProveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);



                  if ($valueG["id_proveedor"] == 0) {
                    echo '<td> - </td>';
                  } else {
                    echo '<td>' . $respuestaProveedor["nombre"] . '</td>';
                  }

                  /* 
                  if ($valueG["forma_pago"] == 1) {
                    echo '<td>Efectivo</td>';

                  } elseif ($valueG["forma_pago"] == 2) {
                    echo '<td>Transferencia</td>';

                  } elseif ($valueG["forma_pago"] == 3) {
                    echo '<td>Tarjeta Crédito</td>';

                  } elseif ($valueG["forma_pago"] == 4) {
                    echo '<td>Tarjeta Débito</td>';

                  } else {
                    echo '<td>Otro</td>';
                  }*/

                  echo '<td>' . $valueG["forma_pago"] . '</td>';

                  $itemUsuario = "id";
                  $valorUsuario = $valueG["id_usuario"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td>' . $respuestaUsuario["nombre"] . '</td>
               
 
                   <td>' . $valueG["fecha_crea"] . '</td>
 
                   <td>
 
                     <div class="btn-group">  

                     <button class="btn btn-info"><i class="fa fa-print"></i></button>';

                  if ($_SESSION["perfil"] == "Administrador") {

                    // Calculate the date 30 days ago
                    $thirtyDaysAgo = new DateTime('-30 days');
                    $fechaCrea = new DateTime($valueG["fecha_crea"]);

                    // Compare the date with today's date and 30 days ago
                    if ($fechaCrea > $thirtyDaysAgo) {
                      // If the date is more recent than 30 days ago, display the button
                      echo '<button class="btn btn-warning btnEditarGasto" idGasto="' . $valueG["id"] . '" data-toggle="modal" data-target="#modalEditarGasto"><i class="fa fa-edit"></i></button>';

                      echo '<button class="btn btn-danger btnEliminarGasto" idGasto="' . $valueG["id"] . '"><i class="fa fa-trash"></i></button>';
                    }


                  } elseif ($_SESSION["perfil"] == "Sub-Administrador") {
                    // Calculate the date 30 days ago
                    $thirtyDaysAgo = new DateTime('-30 days');
                    $fechaCrea = new DateTime($valueG["fecha_crea"]);

                    // Compare the date with today's date and 30 days ago
                    if ($fechaCrea > $thirtyDaysAgo) {
                      // If the date is more recent than 30 days ago, display the button
                      echo '<button class="btn btn-warning btnEditarGasto" idGasto="' . $valueG["id"] . '" data-toggle="modal" data-target="#modalEditarGasto"><i class="fa fa-edit"></i></button>';
                    }
                  }


                  echo '</div>  
 
                   </td>
 
                 </tr>';
                }

                ?>

              </tbody>

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
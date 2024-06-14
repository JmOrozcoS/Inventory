<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar alquileres

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar alquileres</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <a href="crear-venta">

          <button class="btn styleVenta"><i class="fa fa-cart-plus"></i>

            Agregar venta

          </button>

        </a> 

        <div class="pull-right input-group">
          
          <select class="btn primary" id="estados-select" name="estados-select">

            <option value="todos" selected>Todos</option>
            <option value="vencido">VENCIDO</option>
            <option value="por vencer">Por vencer</option>
            <option value="vigente">Vigente</option>
            <option value="renovado">Renovado</option>
            <option value="devuelto">Devuelto</option>
          </select>

        </div>
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


      <div class="box-body">

        <table class="table dt-responsive tablas tablaAlquiler tabla-redondeada" width="100%">

          <thead>

            <tr>

              <th style="width:10px"><i class="fa fa-hashtag"></i></th>
              <th><i class="fa fa-id-card-o"></i> factura</th>
              <th><i class="fa fa-user"></i> Cliente</th>
              <th><i class="fa fa-product-hunt"></i> Productos</th>
              <th><i class="fa fa-money"></i> Total</th>
              <th><i class="fa fa-file-text-o"></i> Comentario</th>
              <th><i class="fa fa-calendar-check-o"></i> Fecha Vencimiento</th>
              <th><i class="fa fa-hourglass-2"></i> Estado</th>
              <th><i class="fa fa-pencil-square-o"></i>Acciones</th>

            </tr>

          </thead>

          <tbody>

            <?php

            $item = "tipo_venta";
            $valor = "Alquiler";

            $respuesta = ControladorVentas::ctrMostrarAlquiler($item, $valor);

            foreach ($respuesta as $key => $value) {


              echo '<tr>

                  <td>' . ($key + 1) . '</td>

                  <td>' . $value["codigo"] . '</td>';

              $itemCliente = "id";
              $valorCliente = $value["id_cliente"];

              $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

              echo '<td>' . $respuestaCliente["nombre"] . '</td>';


              //Obtener la celda de productos
              $json = $value["productos"];

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

                  <td>$ ' . number_format($value["total"], 2) . '</td>

                  <td><b class="text-#526c77"><i>' . $value["nombre_venta"] . '</i></b></td>

                
                  <td>' . $value["vencimiento"] . '</td>';

              $fecha_actual = new DateTime();

              $fecha_Vencimiento = new DateTime($value['vencimiento']);
              ;

              $intervalo = $fecha_actual->diff($fecha_Vencimiento);

              echo '<td>';

              if ($value['estado'] == "NR") {
                echo "<b class='custom-label'>Devuelto<td>

                    <div class='btn-group'>

                    <button class='btn btn-success btnContactar' title = 'Contactar cliente' producto='" . $descripcionProductos . "' fVencimiento='" . $value["vencimiento"] . "' nCliente='" . $respuestaCliente["nombre"] . "' cCliente='" . $respuestaCliente["telefono"] . "'><i class='fa fa-whatsapp'></i></button></b>";
                    
              } elseif ($value['estado'] == "R") {
                echo "<b class='label label-primary'>Renovado<td>

                    <div class='btn-group'>

                    <button class='btn btn-success btnContactar' title = 'Contactar cliente' producto='" . $descripcionProductos . "' fVencimiento='" . $value["vencimiento"] . "' nCliente='" . $respuestaCliente["nombre"] . "' cCliente='" . $respuestaCliente["telefono"] . "'><i class='fa fa-whatsapp'></i></button></b>";
              } elseif ($fecha_Vencimiento >= $fecha_actual & $intervalo->days >= 6) {
                echo "<b class='label label-success'>Vigente<td>

                    <div class='btn-group'>

                    <button class='btn bg-light-blue-active btnDevolverVenta' title = 'Devolver Producto' estadoVenta='NR' idVenta='" . $value["id"] . "'><i class='fa fa-retweet'></i></button>

                    <button class='btn btn-twitter btnRenovarVenta' title = 'Renovar' estadoVenta='R' idVenta='" . $value["id"] . "'><i class='fa fa-refresh'></i></button>

                    <button class='btn btn-success btnContactar' title = 'Contactar cliente' producto='" . $descripcionProductos . "' fVencimiento='" . $value["vencimiento"] . "' nCliente='" . $respuestaCliente["nombre"] . "' cCliente='" . $respuestaCliente["telefono"] . "'><i class='fa fa-whatsapp'></i></button></b>";

              } elseif ($fecha_Vencimiento <= $fecha_actual) {
                echo "<b class='label label-danger'>VENCIDO<td>

                    <div class='btn-group'>

                    <button class='btn bg-light-blue-active btnDevolverVenta' title = 'Devolver Producto' estadoVenta='NR' idVenta='" . $value["id"] . "'><i class='fa fa-retweet'></i></button>

                    <button class='btn btn-twitter btnRenovarVenta' title = 'Renovar' estadoVenta='R' idVenta='" . $value["id"] . "'><i class='fa fa-refresh'></i></button>

                    <button class='btn btn-success btnContactar' title = 'Contactar cliente' producto='" . $descripcionProductos . "' fVencimiento='" . $value["vencimiento"] . "' nCliente='" . $respuestaCliente["nombre"] . "' cCliente='" . $respuestaCliente["telefono"] . "'><i class='fa fa-whatsapp'></i></button></b>";



              } elseif ($intervalo->days <= 6) {
                echo "<b class='label label-warning'>Por vencer<td>

                    <div class='btn-group'>

                    <button class='btn bg-light-blue-active btnDevolverVenta' title = 'Devolver Producto' estadoVenta='NR' idVenta='" . $value["id"] . "'><i class='fa fa-retweet'></i></button>

                    <button class='btn btn-twitter btnRenovarVenta' title = 'Renovar' estadoVenta='R' idVenta='" . $value["id"] . "'><i class='fa fa-refresh'></i></button>

                    <button class='btn btn-success btnContactar' title = 'Contactar cliente' producto='" . $descripcionProductos . "' fVencimiento='" . $value["vencimiento"] . "' nCliente='" . $respuestaCliente["nombre"] . "' cCliente='" . $respuestaCliente["telefono"] . "'><i class='fa fa-whatsapp'></i></button></b>";


              }
              echo '</td>
        
                  

                </tr>';
            }

            ?>

          </tbody>

        </table>

        <?php
        $DevolverVenta = new ControladorVentas();
        $DevolverVenta->ctrDevolverVenta();
        ?>


      </div>

    </div>

  </section>

</div>
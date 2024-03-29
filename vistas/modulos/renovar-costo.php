<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Renovar Costo

    </h1>

    <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Crear Costo</li>

    </ol>

  </section>

  <section class="content">

    <div class="row">

      <!--=====================================
      EL FORMULARIO
      ======================================-->

      <div class="col-lg-5 col-xs-12">

        <div class="box box-success">

          <div class="box-header with-border"></div>

          <form role="form" method="post" class="formularioSurtirInventario">

            <div class="box-body">

              <div class="box">

                <?php

                $item = "id";
                $valor = $_GET["idCosto"];

                $costo = ControladorCostos::ctrMostrarCostos($item, $valor);

                $itemUsuario = "id";
                $valorUsuario = $costo["id_usuario"];

                $usuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                $itemProveedor = "id";
                $valorProveedor = $costo["id_proveedor"];

                $proveedor = ControladorProveedores::ctrMostrarProveedores($itemProveedor, $valorProveedor);

                $porcentajeDescuento = $costo["neto"] - $costo["total"];


                ?>

                <!--=====================================
                ENTRADA DEL USUARIO
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control" id="nuevoUsuario"
                      value="<?php echo $usuario["nombre"]; ?>" readonly>

                    <input type="hidden" name="idUsuario" value="<?php echo $usuario["id"]; ?>">

                  </div>

                </div>

                <!--=====================================
                ENTRADA DEL CÓDIGO
                ======================================-->

                <!--=

                <div class="form-group">
                  
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                   <input type="text" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php echo $costo["codigo"]; ?>" readonly>
               
                  </div>
                
                </div>

                =-->


                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-key"></i></span>

                    <?php

                    $item = null;
                    $valor = null;

                    $gastos = ControladorCostos::ctrMostrarMaxCodigoCostos($item, $valor);

                    if (!$gastos) {

                      echo '<input type="text" class="form-control" id="nuevoCostoInventario" name="nuevoCostoInventario" value="10001" readonly>';


                    } else {

                      foreach ($gastos as $key => $value) {



                      }

                      $codigo = $value["codigo"] + 1;



                      echo '<input type="text" class="form-control" id="nuevoCostoInventario" name="nuevoCostoInventario" value="' . $codigo . '" readonly>';


                    }

                    ?>


                  </div>

                </div>

                <!--=====================================
                ENTRADA PARA EL PROVEEDOR
                ======================================-->

                <div class="form-group">

                  <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-users"></i></span>

                    <select class="form-control" id="seleccionarProveedor" name="seleccionarProveedor" required>

                      <option value="<?php echo $proveedor["id"]; ?>">
                        <?php echo $proveedor["nombre"]; ?>
                      </option>

                      <?php

                        $item = null;
                        $valor = null;

                        $categorias = ControladorProveedores::ctrMostrarProveedores($item, $valor);

                        foreach ($categorias as $key => $value) {

                          echo '<option value="' . $value["id"] . '">' . $value["nombre"] . '</option>';

                        }

                      ?>

                    </select>

                  </div>

                </div>

                <button type="button" class="btn btn-md pull-left styleCosto" data-toggle="modal"
                    data-target="#modalAgregarProductos" data-dismiss="modal">Agregar productos</button>

                  <button type="button" class="btn btn-md pull-right styleCosto" data-toggle="modal"
                    data-target="#modalAgregarProveedor" data-dismiss="modal">Agregar proveedor</button>
                  <br>
                  <br>

                <!--=====================================
                ENTRADA PARA AGREGAR PRODUCTO
                ======================================-->

                <div class="form-group row nuevoProducto">

                  <?php

                  $listaProducto = json_decode($costo["productos"], true);

                  foreach ($listaProducto as $key => $value) {

                    $item = "id";
                    $valor = $value["id"];

                    $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);

                    $stockAntiguo = $respuesta["stock"];
                    $nuevoStock = $respuesta["stock"] - $value["cantidad"] +1;

                    echo '<div class="row" style="padding:5px 15px">
            
                        <div class="col-xs-6" style="padding-right:0px">
            
                          <div class="input-group">
                
                            <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' . $value["id"] . '"><i class="fa fa-trash"></i></button></span>

                            <input type="text" class="form-control nuevaDescripcionProducto" style="padding:0px 3px" idProducto="' . $value["id"] . '" name="agregarProducto" value="' . $value["descripcion"] . '" readonly required>

                          </div>

                        </div>

                        <div class="col-xs-2">
              
                          <input type="number" class="form-control editarCantidadProducto" name="editarCantidadProducto" min="1" value="' . $value["cantidad"] . '" stock="' . $stockAntiguo . '" nuevoStock="' . $nuevoStock . '" required style="padding-left:5px" placeholder="0" style="padding-right:5px">

                        </div>

                        <div class="col-xs-4 ingresoPrecio" style="padding-left:0px">

                          <div class="input-group">

                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                   
                            <input type="text" class="form-control nuevoPrecioProducto" precioReal="' . $respuesta["precio_compra"] . '" name="nuevoPrecioProducto" value="' . $value["total"] . '" readonly required>
   
                          </div>
               
                        </div>

                      </div>';
                  }


                  ?>

                </div>

                <input type="hidden" id="listaProductos" name="listaProductos">

                <!--=====================================
                BOTÓN PARA AGREGAR PRODUCTO
                ======================================-->

                <button type="button" class="btn btn-default hidden-lg btnAgregarProductoI">Agregar producto</button>

                <hr>

                <div class="row">

                  <!--=====================================
                  ENTRADA DescuentoS Y TOTAL
                  ======================================-->

                  <div class="col-xs-8 pull-right mi-div-especifico">

                      <table class="table tablaIDT">

                        <thead>

                          <tr>
                            <th>Descuento</th>
                            <th>Total</th>
                          </tr>

                        </thead>

                        <tbody>

                          <tr>

                          <td style="width: 50%">

                            <div class="input-group">

                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

                              <input type="text" class="form-control input-md" min="0" id="nuevoDescuentoVenta"
                                name="nuevoDescuentoVenta" placeholder="0" value="<?php echo $porcentajeDescuento; ?>" required>

                              <input type="hidden" name="nuevoPrecioDescuento" id="nuevoPrecioDescuento"
                                value="<?php echo $costo["descuento"]; ?>" required>

                              <input type="hidden" name="nuevoPrecioNeto" id="nuevoPrecioNeto"
                                value="<?php echo $costo["neto"]; ?>" required>



                            </div>

                          </td>

                          <td style="width: 50%">

                            <div class="input-group">

                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

                              <input type="text" class="form-control input-md" id="nuevoTotalVenta"
                                name="nuevoTotalVenta" total="<?php echo $costo["neto"]; ?>"
                                value="<?php echo $costo["total"]; ?>" readonly required>

                              <input type="hidden" name="totalVenta" value="<?php echo $costo["total"]; ?>"
                                id="totalVenta">


                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>

                <hr>

                <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->

                <div class="form-group row">

                  <div class="col-xs-6" style="padding-right:0px">

                    <div class="input-group">

                      <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                        <option value="">Seleccione método de pago</option>
                        <option value="Efectivo">Efectivo</option>
                        <option value="Transferencia">Transferencia</option>
                        <option value="TC">Tarjeta Crédito</option>
                        <option value="TD">Tarjeta Débito</option>
                        <option value="Otro">Otro</option>
                      </select>

                    </div>

                  </div>

                  <div class="cajasMetodoPago"></div>

                  <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">

                </div>


                <!--=====================================
                ENTRADA TIPO DE VENTA
                ======================================-->

                <div class="form-group row">

                  <div class="col-xs-6" style="padding-right:0px">

                    <div class="input-group">

                      <select class="form-control" id="nuevoTipoCosto" name="nuevoTipoCosto" required>
                        <option value="">Seleccione el tipo de costo</option>
                        <option value="Costo">Pago Unico</option>
                        <option value="Alquiler">Alquiler</option>
                      </select>

                    </div>

                  </div>

                  <div class="cajasTipoCosto"></div>

                  <input type="hidden" id="listaTipoCosto" name="listaTipoCosto">
                  <input type="hidden" id="listaNombreCosto" name="listaNombreCosto">
                  <input type="hidden" id="listaVencimientoc" name="listaVencimientoc">

                </div>

                <br>

              </div>

            </div>

            <div class="box-footer">

              <button type="submit" class="btn btn-primary pull-right btnRcosto styleCosto" id="btnRcosto"
                estadoCosto="R">Guardar cambios</button>

            </div>

          </form>

          <?php

          $editarCosto = new ControladorCostos();
          $editarCosto->ctrRenovarCosto();

          ?>

        </div>

      </div>

      <!--=====================================
      LA TABLA DE PRODUCTOS
      ======================================-->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">

        <div class="box box-warning">

          <div class="box-header with-border"></div>

          <div class="box-body">

            <table class="table dt-responsive table-hover display tablaSurtirInventario tabla-redondeada" cellspacing="0"
              width="100%">

              <thead>

                <tr>
                  <th style="width:10px"><i class="fa fa-hashtag"></i></th>
                  <th><i class="fa fa-file-image-o"></i> Imagen</th>
                  <th><i class="fa fa-file-code-o"></i> Código</th>
                  <th><i class="fa fa-file"></i> Descripcion</th>
                  <th><i class="fa fa-cubes"></i> Stock</th>
                  <th><i class="fa fa-pencil-square-o"></i> Acciones</th>
                </tr>

              </thead>

            </table>

          </div>

        </div>


      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-md" name="nuevoCliente" placeholder="Ingresar nombre"
                  required>

              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="number" min="0" class="form-control input-md" name="nuevoDocumentoId"
                  placeholder="Ingresar documento" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL EMAIL -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                <input type="email" class="form-control input-md" name="nuevoEmail" placeholder="Ingresar email"
                  required>

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md" name="nuevoTelefono" placeholder="Ingresar teléfono"
                  data-inputmask="'mask':'(999) 999-9999'" data-mask required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

                <input type="text" class="form-control input-md" name="nuevaDireccion" placeholder="Ingresar dirección"
                  required>

              </div>

            </div>

            <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->

            <div class="form-group">

              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                <input type="text" class="form-control input-md" name="nuevaFechaNacimiento"
                  placeholder="Ingresar fecha nacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

              </div>

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn styleVenta">Guardar cliente</button>

        </div>

      </form>

      <?php

      $crearCliente = new ControladorClientes();
      $crearCliente->ctrCrearCliente();

      ?>

    </div>

  </div>

</div>
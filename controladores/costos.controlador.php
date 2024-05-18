<?php

class ControladorCostos
{


	/*=============================================
					  Obtener los Costos totales
					  =============================================*/
	static public function ctrSumaTCostos($fechaInicial, $fechaFinal)
	{

		$tabla = "costos";

		$respuesta = ModeloCostos::mdlSumaTCostos($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;


	}


	/*=============================================
					  MOSTRAR ULTIMO CODIGO DE COSTOS
					  =============================================*/

	static public function ctrMostrarMaxCodigoCostos($item, $valor)
	{

		$tabla = "costos";

		$respuesta = ModeloCostos::mdlMostrarMaxCodigoCostos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
					  MOSTRAR COSTOS
					  =============================================*/

	static public function ctrMostrarCostos($item, $valor)
	{

		$tabla = "costos";

		$respuesta = ModeloCostos::mdlMostrarCostos($tabla, $item, $valor);

		return $respuesta;

	}





/*=============================================
	   DEVOLVER Costo
	   =============================================*/

	   static public function ctrDevolverCosto()
	   {
   
		   if (isset($_GET["idCosto"])) {
   
			   $tabla = "costos";
   
			   $item = "id";
			   $valor = $_GET["idCosto"];
   
			   $traerCosto = ModeloCostos::mdlMostrarCostos($tabla, $item, $valor);
   
			   if (is_array($traerCosto)) {
   
				   /*=============================================
							  FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
							  =============================================*/
   
				   $productos = json_decode($traerCosto["productos"], true);
   
				   $totalProductosComprados = array();
   
				   foreach ($productos as $key => $value) {
   
					   array_push($totalProductosComprados, $value["cantidad"]);
   
					   $tablaProductos = "productos";
   
					   $item = "id";
					   $valor = $value["id"];
   
					   $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor);
   
					   /*$item1a = "ventas";
								   $valor1a = $traerProducto["ventas"] - $value["cantidad"];
   
								   $nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);*/
   
					   $item1b = "stock";
					   $valor1b =  $traerProducto["stock"] - $value["cantidad"];
   
					   $nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);
   
					   if ($nuevoStock == "ok") {
   
						   echo '<script>
	   
					   swal({
							 type: "success",
							 title: "Los productos han sido devueltos correctamente",
							 showConfirmButton: true,
							 confirmButtonText: "Cerrar",
							 closeOnConfirm: false
							 }).then((result) => {
									   if (result.value) {
	   
									   window.location = "ventas";
	   
									   }
								   })
	   
					   </script>';
   
					   }
   
				   }
			   }
		   }
   
	   }





	/*=============================================
					  CREAR COSTO SURTIR INVENTARIO
					  =============================================*/

	static public function ctrCrearCostoInventario()
	{

		if (isset($_POST["nuevoCostoInventario"])) {

			/*=============================================
								 ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
								  =============================================*/

			$listaProductos = json_decode($_POST["listaProductos"], true);

			$totalProductosComprados = array();

			foreach ($listaProductos as $key => $value) {

				array_push($totalProductosComprados, $value["cantidad"]);

				$tablaProductos = "productos";

				$item = "id";
				$valor = $value["id"];

				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor);

				$item1a = "compras";
								$valor1a = $value["cantidad"] + $traerProducto["compras"];
								$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				$item1b = "stock";
				$valor1b = $value["stock"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}

			$tablaProveedores = "proveedores";

			$item = "id";
			$valor = $_POST["seleccionarProveedor"];

			$traerProveedor = ModeloProveedores::mdlMostrarProveedores($tablaProveedores, $item, $valor);

			$item1a = "ventas";
			$valor1a = array_sum($totalProductosComprados) + $traerProveedor["ventas"];

			$ventasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1a, $valor1a, $valor);

			$item1b = "ultima_compra";
			$item2b = "ultima_venta";

			date_default_timezone_set('America/Bogota');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha . ' ' . $hora;

			$fechaProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item2b, $valor1b, $valor);

			/*=============================================
								 GUARDAR LA COMPRA
								 =============================================*/

			$tabla = "costos";

			$datos = array(
				"id_usuario" => $_POST["idUsuario"],
				"id_proveedor" => $_POST["seleccionarProveedor"],
				"codigo" => $_POST["nuevoCostoInventario"],
				"productos" => $_POST["listaProductos"],
				"descuento" => $_POST["nuevoPrecioDescuento"],
				"neto" => $_POST["nuevoPrecioNeto"],
				"total" => $_POST["totalVenta"],
				"metodo_pago" => $_POST["listaMetodoPago"],
				//"tipo_venta"=>$_POST["listaTipoVenta"],
				"nombre_costo" => $_POST["listaNombreCosto"],
				"vencimiento" => $_POST["listaVencimientoc"],
				"fecha_crea" => $valor1b

			);

			$respuesta = ModeloCostos::mdlIngresarCosto($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>

				localStorage.removeItem("rango");

				swal({
					  type: "success",
					  title: "El costo ha sido guardado correctamente, se ha hactualizado el inventario",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}

		}

	}








	

	

		

			



	/*=============================================
					  ELIMINAR COSTO
					  =============================================*/

	static public function ctrEliminarCosto()
	{

		if (isset($_GET["idCosto"])) {

			$tabla = "costos";

			$item = "id";
			$valor = $_GET["idCosto"];

			$traerVenta = ModeloCostos::mdlMostrarCostos($tabla, $item, $valor);

			/*=============================================
																  ACTUALIZAR FECHA ÚLTIMA COMPRA
																  =============================================*/

			$tablaProveedores = "proveedores";

			$itemVentas = null;
			$valorVentas = null;

			$traerVentas = ModeloCostos::mdlMostrarCostos($tabla, $itemVentas, $valorVentas);

			$guardarFechas = array();

			foreach ($traerVentas as $key => $value) {

				if ($value["id_proveedor"] == $traerVenta["id_proveedor"]) {

					array_push($guardarFechas, $value["fecha"]);

				}

			}

			if (count($guardarFechas) > 1) {

				if ($traerVenta["fecha"] > $guardarFechas[count($guardarFechas) - 2]) {

					$item = "ultima_venta";
					$valor = $guardarFechas[count($guardarFechas) - 2];
					$valorIdProveedor = $traerVenta["id_proveedor"];

					$comprasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item, $valor, $valorIdProveedor);

				} else {

					$item = "ultima_venta";
					$valor = $guardarFechas[count($guardarFechas) - 1];
					$valorIdProveedor = $traerVenta["id_proveedor"];

					$comprasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item, $valor, $valorIdProveedor);

				}


			} else {

				$item = "ultima_venta";
				$valor = "0000-00-00 00:00:00";
				$valorIdProveedor = $traerVenta["id_proveedor"];

				$comprasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item, $valor, $valorIdProveedor);

			}

			/*=============================================
																  FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
																  =============================================*/

			$productos = json_decode($traerVenta["productos"], true);

			$totalProductosComprados = array();

			foreach ($productos as $key => $value) {

				array_push($totalProductosComprados, $value["cantidad"]);

				$tablaProductos = "productos";

				$item = "id";
				$valor = $value["id"];

				$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor);

				/*$item1a = "ventas";
																						$valor1a = $traerProducto["ventas"] - $value["cantidad"];

																						$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);*/

				$item1b = "stock";
				$valor1b = $traerProducto["stock"] - $value["cantidad"];

				$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

			}

			$tablaProveedores = "proveedores";

			$itemProveedor = "id";
			$valorProveedor = $traerVenta["id_proveedor"];

			$traerProveedor = ModeloProveedores::mdlMostrarProveedores($tablaProveedores, $itemProveedor, $valorProveedor);

			$item1a = "ventas";
			$valor1a = $traerProveedor["ventas"] - array_sum($totalProductosComprados);

			$ventasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1a, $valor1a, $valorProveedor);

			/*=============================================
																  ELIMINAR VENTA
																  =============================================*/

			$respuesta = ModeloCostos::mdlEliminarCosto($tabla, $_GET["idCosto"]);

			if ($respuesta == "ok") {

				echo '<script>

				swal({
					  type: "success",
					  title: "El costo ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then((result) => {
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}
		}

	}

	static public function ctrRangoFechasCostos($fechaInicial, $fechaFinal)
	{

		$tabla = "costos";

		$respuesta = ModeloCostos::mdlRangoFechasCostos($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;

	}







	/*=============================================
			 RENOVAR COSTO
			 =============================================*/

	static public function ctrRenovarCosto()
	{

		if (isset($_POST["nuevoCostoInventario"])) {

			/*=============================================
									   FORMATEAR TABLA DE PRODUCTOS Y LA DE CLIENTES
									   =============================================*/
			$tabla = "costos";

			//Capturar id por url
			$idCosto = isset($_GET['idCosto']) ? $_GET['idCosto'] : null;


			$item = "id";
			$valor = $idCosto;

			$traerCosto = ModeloCostos::mdlMostrarCostos($tabla, $item, $valor);

			/*=============================================
									   REVISAR SI VIENE PRODUCTOS EDITADOS
									   =============================================*/

			if ($_POST["listaProductos"] == "") {

				$listaProductos = $traerCosto["productos"];
				$cambioProducto = false;


			} else {

				$listaProductos = $_POST["listaProductos"];
				$cambioProducto = true;
			}

			//Si vienen productos editados

			if ($cambioProducto) {

				$productos = json_decode($traerCosto["productos"], true);

				$totalProductosComprados = array();

				foreach ($productos as $key => $value) {

					array_push($totalProductosComprados, $value["cantidad"]);

					$tablaProductos = "productos";

					$item = "id";
					$valor = $value["id"];

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor);

					// Ya se actualiza mas abajo
					/*$item1a = "ventas";
																 $valor1a = $traerProducto["ventas"] - $value["cantidad"];
							  
																 $nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);*/


					//Actualizar Stock, cantidad de ventas + el stock
					//Actualizar restar productos eliminados
					$item1b = "stock";
					$valor1b =  $traerProducto["stock"] - $value["cantidad"];
					//$valor1b = $value["cantidad"] + $traerProducto["stock"];

					$nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

				}

				//No es necesario reducir compras del cliente
				/*$tablaClientes = "clientes";
						
													$itemCliente = "id";
													$valorCliente = $_POST["seleccionarCliente"];
						
													$traerCliente = ModeloClientes::mdlMostrarClientes($tablaClientes, $itemCliente, $valorCliente);
						
													$item1a = "compras";
													$valor1a = $traerCliente["compras"] - array_sum($totalProductosComprados);
						
													$comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valorCliente);*/

				/*=============================================
										ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS
										=============================================*/

				$listaProductos_2 = json_decode($listaProductos, true);

				$totalProductosComprados_2 = array();

				foreach ($listaProductos_2 as $key => $value) {

					array_push($totalProductosComprados_2, $value["cantidad"]);

					$tablaProductos_2 = "productos";

					$item_2 = "id";
					$valor_2 = $value["id"];

					$traerProducto_2 = ModeloProductos::mdlMostrarProductos($tablaProductos_2, $item_2, $valor_2);

					$item1a_2 = "compras";
					$valor1a_2 = $value["cantidad"] + $traerProducto_2["compras"];

					$nuevasVentas_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1a_2, $valor1a_2, $valor_2);

					$item1b_2 = "stock";
					$valor1b_2 = $value["stock"];

					$nuevoStock_2 = ModeloProductos::mdlActualizarProducto($tablaProductos_2, $item1b_2, $valor1b_2, $valor_2);

				}

				$tablaProveedor_2 = "proveedores";

				$item_2 = "id";
				$valor_2 = $_POST["seleccionarProveedor"];

				$traerProveedor_2 = ModeloProveedores::mdlMostrarProveedores($tablaProveedor_2, $item_2, $valor_2);

				$item1a_2 = "ventas";
				$valor1a_2 = array_sum($totalProductosComprados_2) + $traerProveedor_2["ventas"];

				$comprasProveedor_2 = ModeloProveedores::mdlActualizarProveedor($tablaProveedor_2, $item1a_2, $valor1a_2, $valor_2);

				$item1b_2 = "ultima_venta";

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b_2 = $fecha . ' ' . $hora;

				$fechaProveedor_2 = ModeloProveedores::mdlActualizarProveedor($tablaProveedor_2, $item1b_2, $valor1b_2, $valor_2);
				

			} else {

				$listaProductos_2 = json_decode($listaProductos, true);


				$totalProductosComprados = array();

				foreach ($listaProductos_2 as $key => $value) {

					array_push($totalProductosComprados, $value["cantidad"]);

					$tablaProductos = "productos";

					$item = "id";
					$valor = $value["id"];

					$traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor);

					$item1a = "compras";
					$valor1a = $value["cantidad"] + $traerProducto["compras"];

					$nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

					// si no viene productos editados desactivar actualizar stock por eso se deja comentado
					/*$item1b = "stock";
											   $valor1b = $value["stock"];
							   
											   $nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);*/

				}

				$tablaProveedores = "proveedores";

				$item = "id";
				$valor = $_POST["seleccionarProveedor"];

				$traerProveedor = ModeloProveedores::mdlMostrarProveedores($tablaProveedores, $item, $valor);

				$item1a = "ventas";
				$valor1a = array_sum($totalProductosComprados) + $traerProveedor["ventas"];

				$comprasProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1a, $valor1a, $valor);

				$item1b = "ultima_venta";

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b = $fecha . ' ' . $hora;

				$fechaProveedor = ModeloProveedores::mdlActualizarProveedor($tablaProveedores, $item1b, $valor1b, $valor);

			}

			date_default_timezone_set('America/Bogota');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b_2_3 = $fecha . ' ' . $hora;

			/*=============================================
									   GUARDAR CAMBIOS DE LA COMPRA
									   =============================================*/
			if ($_POST["listaNombreCosto"] == "") {
				$nCosto = $_POST["nuevoNombreCosto"];
			} else {
				$nCosto = $_POST["listaNombreCosto"];
			}

			if ($_POST["listaMetodoPago"] == "") {
				$nMetodoPago = $_POST["nuevoMetodoPago"];
			} else {
				$nMetodoPago = $_POST["listaMetodoPago"];
			}

			$tabla = "costos";

			$datos = array(
				"id_usuario" => $_POST["idUsuario"],
				"id_proveedor" => $_POST["seleccionarProveedor"],
				"codigo" => $_POST["nuevoCostoInventario"],
				"productos" => $listaProductos,
				"descuento" => $_POST["nuevoPrecioDescuento"],
				"neto" => $_POST["nuevoPrecioNeto"],
				"total" => $_POST["totalVenta"],
				"metodo_pago" => $nMetodoPago,
				//"tipo_venta" => $_POST["listaTipoVenta"],
				"nombre_costo" => $nCosto,
				"vencimiento" => $_POST["listaVencimientoc"],
				"fecha_crea" => $valor1b_2_3



			);


			$respuesta = ModeloCostos::mdlIngresarCosto($tabla, $datos);

			if ($respuesta == "ok") {

				echo '<script>
   
				   localStorage.removeItem("rango");
   
				   swal({
						 type: "success",
						 title: "El costo ha sido renovado correctamente",
						 showConfirmButton: true,
						 confirmButtonText: "Cerrar"
						 }).then((result) => {
								   if (result.value) {
   
								   window.location = "ventas";
   
								   }
							   })
   
				   </script>';

			}

		}

	}










}
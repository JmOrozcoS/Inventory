<?php

session_start();

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";


class TablaProductos
{

	/*=============================================
		   MOSTRAR LA TABLA DE PRODUCTOS
		   =============================================*/

	public function mostrarTablaProductos()
	{

		$item = null;
		$valor = null;

		$productos = ControladorProductos::ctrMostrarProductos($item, $valor);

		if (count($productos) == 0) {

			echo '{"data": []}';

			return;
		}

		$datosJson = '{
		  "data": [';

		for ($i = 0; $i < count($productos); $i++) {

			/*=============================================
							  TRAEMOS LA IMAGEN
							  =============================================*/

			$imagen = "<div align='center' valign='middle'><img src='" . $productos[$i]["imagen"] . "' width='40px'></div>";

			/*=============================================
							  TRAEMOS LA CATEGORÍA
							  =============================================*/

			$item = "id";
			$valor = $productos[$i]["id_categoria"];

			$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

			/*=============================================
							  STOCK
							  =============================================*/

			if ($productos[$i]["stock"] <= 2) {

				$stock = "<div align='center' valign='middle'><button class='btn btn-danger'>" . $productos[$i]["stock"] . "</button></div>";

			} else if ($productos[$i]["stock"] > 2 && $productos[$i]["stock"] <= 4) {

				$stock = "<div align='center' valign='middle'><button class='btn btn-warning'>" . $productos[$i]["stock"] . "</button></div>";

			} else {

				$stock = "<div align='center' valign='middle'><button class='btn btn-success'>" . $productos[$i]["stock"] . "</button></div>";

			}

			/*=============================================
								TRAEMOS EL ESTADO DEL PRODUCTO
								=============================================*/


			if ($productos[$i]["estado"] != 0) {

				$estado = "<td><button class='btn btn-success btn-xs btnActivarProducto' idProducto=" . $productos[$i]["id"] . " estadoProducto='0'>Activado</button></td>";

			} else {

				$estado = "<td><button class='btn btn-danger btn-xs btnActivarProducto' idProducto=" . $productos[$i]["id"] . " estadoProducto='1'>Desactivado</button></td>";

			}

			/*=============================================
							  TRAEMOS LAS ACCIONES
							  =============================================*/

			if ($_SESSION["perfil"] == "Administrador") {

				$botones = "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='" . $productos[$i]["id"] . "' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-edit'></i></button><button class='btn btn-danger btnEliminarProducto' idProducto='" . $productos[$i]["id"] . "' codigo='" . $productos[$i]["codigo"] . "' imagen='" . $productos[$i]["imagen"] . "'><i class='fa fa-trash'></i></button></div>";

			} elseif ($_SESSION["perfil"] == "Sub-Administrador") {
				$botones = "<div class='btn-group'><button class='btn btn-warning btnEditarProducto' idProducto='" . $productos[$i]["id"] . "' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-edit'></i></button></div>";
			} else {

				$botones = "<div align='center' valign='middle'><i class='fa fa-exclamation-circle'></i></div>";
			}

			/*=============================================
								  CAMBIANDO EL FORMATO DE NUMERO A MONEDA
								  ============================================= */

			$PrecioCompra = $productos[$i]["precio_compra"];
			$PrecioCompraFormat = number_format($PrecioCompra, 2);

			$PrecioVenta = $productos[$i]["precio_venta"];
			$PrecioVentaFormat = number_format($PrecioVenta, 2);

			/*=============================================
								   CAMBIANDO EL FORMATO DE NUMERO A MONEDA
								   ============================================= */

			$datosJson .= '[
			      "' . ($i + 1) . '",
			      "' . $imagen . '",
			      "' . $productos[$i]["codigo"] . '",
			      "' . $productos[$i]["descripcion"] . '",
			      "' . $categorias["categoria"] . '",
			      "' . $stock . '",
			      "' . "$ " . $PrecioCompraFormat . '",
			      "' . "$ " . $PrecioVentaFormat . '",
				  "' . $estado . '",
			      "' . $productos[$i]["fecha_crea"] . '",
			      "' . $botones . '"
			    ],';

		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson .= '] 

		 }';

		echo $datosJson;


	}


}

/*=============================================
ACTIVAR TABLA DE PRODUCTOS
=============================================*/
$activarProductos = new TablaProductos();
$activarProductos->mostrarTablaProductos();
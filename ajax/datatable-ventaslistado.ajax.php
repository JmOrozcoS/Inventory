<?php

session_start();

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


class tablaVentasListado
{

	/*=============================================
		   MOSTRAR LA TABLA DE VENTAS
		   =============================================*/

	public function mostrartablaVentasListado()
	{

		if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {
            $fechaInicial = htmlspecialchars($_GET["fechaInicial"]);
            $fechaFinal = htmlspecialchars($_GET["fechaFinal"]);
        } else {
            $fechaInicial = null;
            $fechaFinal = null;
        };

		$ventas = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

		if (count($ventas) == 0) {

			echo '{"data": []}';

			return;
		}

		$datosJson = '{
		  "data": [';

		for ($i = 0; $i < count($ventas); $i++) {

			/*=============================================
			TRAEMOS EL CLIENTE
			=============================================*/

			$item = "id";
			$valor = $ventas[$i]["id_cliente"];

			$cliente = ControladorClientes::ctrMostrarClientes($item, $valor);

			/*=============================================
			TRAEMOS EL VENDEDOR
			=============================================*/

			$item = "id";
			$valor = $ventas[$i]["id_vendedor"];

			$vendedor = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);


			/*=============================================
			TRAEMOS LAS ACCIONES
			=============================================*/

			$botones = "<div class='btn-group'><button class='btn btn-info btnImprimirVenta' codigoVenta='". $ventas[$i]["codigo"] . "'><i class='fa fa-print'></i></button></div>";


			/*=============================================
			CAMBIANDO EL FORMATO DE NUMERO A MONEDA
			============================================= */

			$PrecioNeto = $ventas[$i]["neto"];
			$PrecioNetoFormat = number_format($PrecioNeto, 2);
					  
			$PrecioTotal = $ventas[$i]["total"];
			$PrecioTotalFormat = number_format($PrecioTotal, 2);
					  
			

			$datosJson .= '[
			      "' . ($i + 1) . '",
			      "' . $ventas[$i]["codigo"] . '",
				  "' . $cliente["nombre"] . '",
				  "' . $vendedor["nombre"] . '",
				  "' . $ventas[$i]["metodo_pago"] . '",
				"' . "$ " . $PrecioNetoFormat . '",
			      "' . "$ " . $PrecioTotalFormat . '",
				  "' . $ventas[$i]["fecha_crea"] . '",
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
$activarVentasListado = new tablaVentasListado();
$activarVentasListado->mostrartablaVentasListado();
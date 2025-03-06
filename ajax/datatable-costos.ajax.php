<?php

session_start();

require_once "../controladores/costos.controlador.php";
require_once "../modelos/costos.modelo.php";

require_once "../controladores/Proveedores.controlador.php";
require_once "../modelos/Proveedores.modelo.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaCostos
{

    /*=============================================
    MOSTRAR LA TABLA DE COSTOS
    =============================================*/

    public function mostrarTablaCostos()
    {
       

        if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {
            $fechaInicial = htmlspecialchars($_GET["fechaInicial"]);
            $fechaFinal = htmlspecialchars($_GET["fechaFinal"]);
        } else {
            $fechaInicial = null;
            $fechaFinal = null;
        }
    
    
        $costos = ControladorCostos::ctrRangoFechasCostos($fechaInicial, $fechaFinal);

        if (count($costos) == 0) {
            echo json_encode(["data" => []]);
            return;
        }

        $datosJson = [
            "data" => []
        ];

        foreach ($costos as $i => $costo) {
            /*=============================================
            TRAEMOS EL PROVEEDOR
            =============================================*/

            $item = "id";
            $valor = $costo["id_proveedor"];
            $proveedor = ControladorProveedores::ctrMostrarProveedores($item, $valor);

			/*=============================================
            TRAEMOS EL PRODUCTO
            =============================================*/

			//Obtener la celda de productos
			$json = $costo["productos"];

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
			$productos = "<td>" . $descripcionProductos . "</td>";
			

            /*=============================================
            CAMBIANDO EL FORMATO DE NUMERO A MONEDA
            =============================================*/

            $PrecioCosto = $costo["total"];
            $PrecioCostoFormat = number_format($PrecioCosto, 2);

            /*=============================================
            TRAEMOS EL USUARIO
            =============================================*/

            $item = "id";
            $valor = $costo["id_usuario"];
            $usuario = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

            // Convertir y formatear la fecha
            $fechaStr = $costo["fecha_crea"];
            $fecha = new DateTime($fechaStr);
            $fechaFormateada = $fecha->format('d-m-Y');

            // Convertir y formatear la fecha
            $fechaStr = $costo["vencimiento"];
            $fecha = new DateTime($fechaStr);
            $fechaFormateadaF = $fecha->format('d-m-Y');

            $fechaC = "<td>" . htmlspecialchars($fechaFormateada) . "</td>";
            $fechaF = "<td>" . htmlspecialchars($fechaFormateadaF) . "</td>";

            /*=============================================
            TRAEMOS EL ESTADO Y ACCIONES
            =============================================*/

            $fecha_actual = new DateTime();
            $fecha_Vencimiento = new DateTime($costo['vencimiento']);
            $intervalo = $fecha_actual->diff($fecha_Vencimiento);

            if ($costo['estado'] == "" && $costo['vencimiento'] == "0000-00-00 00:00:00") {
                $estado = "<b class='label custom-label'>N/A</b>";
                $botones = "<div align='center' valign='middle'
                     title='Estado desconocido'><i class='fa fa-exclamation-circle'></i>
                </div>";

            } elseif ($costo['estado'] == "NR") {
                $estado = "<b class='label custom-label'>Devuelto</b>";
                $botones = "<div align='center' valign='middle'
                    title='Devuelto'><i class='fa fa-exclamation-circle'></i>
                </div>";

            } elseif ($costo['estado'] == "R") {
                $estado = "<b class='label label-primary'>Renovado</b>";
                $botones = "<div align='center' valign='middle'
                    title='Renovado'><i class='fa fa-exclamation-circle'></i>
                </div>";

            } elseif ($fecha_Vencimiento >= $fecha_actual && $intervalo->days >= 6) {
                $estado = "<b class='label label-success'>Vigente</b>";
                $botones = "<div class='btn-group'>
                <button class='btn bg-light-blue-active btnDevolverCosto' title = 'Devolver Producto' estadoCosto='NR' idCosto='" . $costo["id"] . "'><i class='fa fa-refresh'></i></button>
                    <button class='btn btn-twitter btnRenovarCosto' title='Renovar' estadoCosto='R' idCosto='" . $costo["id"] . "'><i class='fa fa-refresh'></i></button>
                </div>";

			}elseif ($fecha_Vencimiento <= $fecha_actual) {

				$estado = "<b class='label label-danger'>VENCIDO</b>";
				$botones = "<div class='btn-group'>
					<button class='btn bg-light-blue-active btnDevolverCosto' title = 'Devolver Producto' estadoCosto='NR' idCosto='" . $costo["id"] . "'><i class='fa fa-refresh'></i></button>
					<button class='btn btn-twitter btnRenovarCosto' title = 'Renovar' estadoCosto='R' idCosto='" . $costo["id"] . "'><i class='fa fa-refresh'></i></button>
					</div>";

			} elseif ($intervalo->days <= 6) {

				if ($_SESSION["perfil"] == "Administrador") {
	
					$estado = "<b class='label label-warning'>Por vencer</b>";
					$botones = "<div class='btn-group'>
					<button class='btn bg-light-blue-active btnDevolverCosto' title = 'Devolver Producto' estadoCosto='NR' idCosto='" . $costo["id"] . "'><i class='fa fa-retweet'></i></button>
					<button class='btn btn-twitter btnRenovarCosto' title = 'Renovar' estadoCosto='R' idCosto='" . $costo["id"] . "'><i class='fa fa-refresh'></i></button>
					<!--<button class='btn btn-danger btnEliminarCosto' idCosto='" . $costo["id"] . "'><i class='fa fa-trash'></i></button>-->
					</div>";
				}else{

					$estado = "<b class='label label-warning'>Por vencer</b>";
					$botones = "<div class='btn-group'>
					  <button class='btn bg-light-blue-active btnDevolverCosto' title = 'Devolver Producto' estadoCosto='NR' idCosto='" . $costo["id"] . "'><i class='fa fa-retweet'></i></button>
					  <button class='btn btn-twitter btnRenovarCosto' title = 'Renovar' estadoCosto='R' idCosto='" . $costo["id"] . "'><i class='fa fa-refresh'></i></button>
					  </div>";
  
				   }

            } else {
                $estado = "<b class='label custom-label'>N/A</b>";
                $botones = "<div align='center' valign='middle'
                title='Estado desconocido'><i class='fa fa-exclamation-circle'></i>
                </div>";
            }


            $datosJson['data'][] = [
                ($i + 1),
                $costo["codigo"],
                $proveedor["nombre"],
                $productos,
                $costo["nombre_costo"],
                "$ " . $PrecioCostoFormat,
                $costo["metodo_pago"],
                $usuario["nombre"],
                $fechaC,
                $fechaF,
                $estado,
                $botones
            ];
        }

        echo json_encode($datosJson);
    }
}

/*=============================================
ACTIVAR TABLA DE COSTOS
=============================================*/
$activarCostos = new TablaCostos();
$activarCostos->mostrarTablaCostos();


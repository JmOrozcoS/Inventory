<?php

session_start();

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class TablaAlquiler
{
    /*=============================================
    MOSTRAR LA TABLA DE ALQUILERES
    =============================================*/

    public function mostrarTablaAlquiler()
    {
        $item = "tipo_venta";
        $valor = "Alquiler";

        $alquilers = ControladorVentas::ctrMostrarAlquiler($item, $valor);

        if (count($alquilers) == 0) {
            echo json_encode(["data" => []]);
            return;
        }

        $datosJson = [
            "data" => []
        ];

        foreach ($alquilers as $i => $alquiler) {
            /*=============================================
            TRAEMOS EL CLIENTE
            =============================================*/

            $item = "id";
            $valor = $alquiler["id_cliente"];
            $cliente = ControladorClientes::ctrMostrarClientes($item, $valor);

            /*=============================================
            TRAEMOS EL PRODUCTO
            =============================================*/

            // Obtener la celda de productos
            $json = $alquiler["productos"];
            $productos = json_decode($json, true);
            $descripcionProductos = '';

            foreach ($productos as $producto) {
                $descripcionProductos .= htmlspecialchars($producto['descripcion']) . '<br> ';
            }

            // Eliminar el último salto de línea y espacio
            $descripcionProductos = rtrim($descripcionProductos, '<br> ');

            // Mostrar las descripciones de productos en la celda
            $productos = $descripcionProductos;

            /*=============================================
            CAMBIANDO EL FORMATO DE NUMERO A MONEDA
            =============================================*/

            $PrecioTotal = $alquiler["total"];
            $PrecioTotalFormat = number_format($PrecioTotal, 2);

            // Convertir y formatear la fecha
            $fechaStr = $alquiler["vencimiento"];
            $fecha = new DateTime($fechaStr);
            $fechaFormateadaF = $fecha->format('d-m-Y');

            $fechaF = "<td>" . $fechaFormateadaF . "</td>";

            /*=============================================
            TRAEMOS EL ESTADO Y ACCIONES
            =============================================*/

            $fecha_actual = new DateTime();
            $fecha_Vencimiento = new DateTime($alquiler['vencimiento']);
            $intervalo = $fecha_actual->diff($fecha_Vencimiento);

            $botonesD = "<div align='center' valign='middle'
                title='Estado desconocido'><i class='fa fa-exclamation-circle'></i></div>";

            $botonesT = "<div class='btn-group'>
                <button class='btn bg-light-blue-active btnDevolverVenta' title='Devolver Producto' estadoVenta='NR' idVenta='" . $alquiler["id"] . "'><i class='fa fa-retweet'></i></button>
                <button class='btn btn-twitter btnRenovarVenta' title='Renovar' estadoVenta='R' idVenta='" . $alquiler["id"] . "'><i class='fa fa-refresh'></i></button>
                <button class='btn btn-success btnContactar' title='Contactar cliente' producto='" . htmlspecialchars($descripcionProductos) . "' fVencimiento='" . $fecha_Vencimiento->format('d-m-Y') . "' nCliente='" . htmlspecialchars($cliente["nombre"]) . "' cCliente='" . htmlspecialchars($cliente["telefono"]) . "'><i class='fa fa-whatsapp'></i></button>
            </div>";

            if ($alquiler['estado'] == "" && $alquiler['vencimiento'] == "0000-00-00 00:00:00") {
                $estado = "<b class='label custom-label'>N/A</b>";
                $botones = $botonesD;
            } elseif ($alquiler['estado'] == "NR") {
                $estado = "<b class='label custom-label'>Devuelto</b>";
                $botones = $botonesD;
            } elseif ($alquiler['estado'] == "R") {
                $estado = "<b class='label label-primary'>Renovado</b>";
                $botones = $botonesD;
            } elseif ($fecha_Vencimiento >= $fecha_actual && $intervalo->days >= 6) {
                $estado = "<b class='label label-success'>Vigente</b>";
                $botones = $botonesT;
            } elseif ($fecha_Vencimiento <= $fecha_actual) {
                $estado = "<b class='label label-danger'>VENCIDO</b>";
                $botones = $botonesT;
            } elseif ($intervalo->days <= 6) {
                $estado = "<b class='label label-warning'>Por vencer</b>";
                    $botones = $botonesT;
            } else {
                $estado = "<b class='label custom-label'>N/A</b>";
                $botones = $botonesD;
            }

            $datosJson['data'][] = [
                ($i + 1),
                htmlspecialchars($alquiler["codigo"]),
                htmlspecialchars($cliente["nombre"]),
                $productos,
                "$ " . $PrecioTotalFormat,
                htmlspecialchars($alquiler["nombre_venta"]),
                $fechaF,
                $estado,
                $botones
            ];
        }

        echo json_encode($datosJson);
    }
}

/*=============================================
ACTIVAR TABLA DE ALQUILERES
=============================================*/
$activarAlquiler = new TablaAlquiler();
$activarAlquiler->mostrarTablaAlquiler();


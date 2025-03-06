<?php

session_start();

require_once "../controladores/gastos.controlador.php";
require_once "../modelos/gastos.modelo.php";

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaGastos
{

    /*=============================================
    MOSTRAR LA TABLA DE GASTOS
    =============================================*/

    public function mostrarTablaGastos()
    {
       
        // Validación de parámetros
      //$fechaInicial = isset($_GET["fechaInicial"]) ? htmlspecialchars($_GET["fechaInicial"]) : null;
      //$fechaFinal = isset($_GET["fechaFinal"]) ? htmlspecialchars($_GET["fechaFinal"]) : null;

      // Imprimir las fechas para depuración
      //var_dump($fechaInicial, $fechaFinal);

      if (isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])) {
        $fechaInicial = htmlspecialchars($_GET["fechaInicial"]);
        $fechaFinal = htmlspecialchars($_GET["fechaFinal"]);
    } else {
        $fechaInicial = null;
        $fechaFinal = null;
    }




          $gastos = ControladorGastos::ctrRangoFechasGastos($fechaInicial, $fechaFinal);

        if (count($gastos) == 0) {
            echo json_encode(["data" => []]);
            return;
        }

        $datosJson = [
            "data" => []
        ];

        foreach ($gastos as $i => $gasto) {


            /*=============================================
            TRAEMOS EL PROVEEDOR
            =============================================*/

            $item = "id";
            $valor = $gasto["id_proveedor"];
            $respuestaProveedor = ControladorProveedores::ctrMostrarProveedores($item, $valor);

            if ($gasto["id_proveedor"] == 0) {
                $proveedor = "<td> - </td>";
              } else {
                $proveedor = "<td>" . $respuestaProveedor["nombre"] . "</td>";
              }

            /*=============================================
            CAMBIANDO EL FORMATO DE NUMERO A MONEDA
            =============================================*/

             // Obtener el valor del monto
            $monto = $gasto["monto"];

            // Determinar el color del texto
            $color = ($monto < 0) ? "style='color: green;'" : "style='color: red;'";

            // Agregar negrita al texto
            $texto = ($monto < 0) ? "<strong>$ " . number_format($monto, 2) . "</strong>" : "$ " . number_format($monto, 2);

            // Imprimir el valor formateado con el color determinado y negrita
            $PrecioGasto = "<div $color>$texto</div>";


            /*=============================================
            TRAEMOS EL USUARIO
            =============================================*/

            $item = "id";
            $valor = $gasto["id_usuario"];
            $usuario = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

            // Convertir y formatear la fecha
            $fechaStr = $gasto["fecha_crea"];
            $fecha = new DateTime($fechaStr);
            $fechaFormateada = $fecha->format('d-m-Y');

            $fechaC = "<td>" . htmlspecialchars($fechaFormateada) . "</td>";

            /*=============================================
            TRAEMOS LAS ACCIONES
            =============================================*/

            if ($_SESSION["perfil"] == "Administrador") {

                // Calculate the date 30 days ago
                $thirtyDaysAgo = new DateTime('-30 days');
                $fechaCrea = new DateTime($gasto["fecha_crea"]);

                // Compare the date with today's date and 30 days ago
                if ($fechaCrea > $thirtyDaysAgo) {
                  // If the date is more recent than 30 days ago, display the button
                  $botones = "<div class='btn-group'>
                  <button class='btn btn-warning btnEditarGasto' idGasto='" . $gasto["id"] . "' data-toggle='modal' data-target='#modalEditarGasto'><i class='fa fa-edit'></i></button>

                  <button class='btn btn-danger btnEliminarGasto' idGasto='" . $gasto["id"] . "'><i class='fa fa-trash'></i></button></div>";

                }else{
                    $botones = "<div align='center' valign='middle'
                title='Estado desconocido'><i class='fa fa-exclamation-circle'></i>
                </div>";
                }


            } elseif ($_SESSION["perfil"] == "Sub-Administrador") {
               // Calculate the date 30 days ago
               $thirtyDaysAgo = new DateTime('-30 days');
               $fechaCrea = new DateTime($gasto["fecha_crea"]);

               // Compare the date with today's date and 30 days ago
               if ($fechaCrea > $thirtyDaysAgo) {
                 // If the date is more recent than 30 days ago, display the button
                 $botones = "<div class='btn-group'>
                 <button class='btn btn-warning btnEditarGasto' idGasto='" . $gasto["id"] . "' data-toggle='modal' data-target='#modalEditarGasto'><i class='fa fa-edit'></i></button></div>";
                }else{
                    $botones = "<div align='center' valign='middle'
                title='Estado desconocido'><i class='fa fa-exclamation-circle'></i>
                </div>";
                }
              }

            $datosJson['data'][] = [
                ($i + 1),
                $gasto["codigo"],
                $gasto["categoria"],
                $PrecioGasto,
                $gasto["nombre_gasto"],
                $proveedor,
                $gasto["forma_pago"],
                $usuario["nombre"],
                $fechaC,
                $botones
            ];
        }

        echo json_encode($datosJson);
    }
}

/*=============================================
ACTIVAR TABLA DE GASTOS
=============================================*/
$activarGastos = new TablaGastos();
$activarGastos->mostrarTablaGastos();


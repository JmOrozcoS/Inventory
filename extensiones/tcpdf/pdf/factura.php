<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

class imprimirFactura {

    public $codigo;

    public function traerImpresionFactura() {

        // TRAEMOS LA INFORMACIÓN DE LA VENTA

        $itemVenta = "codigo";
        $valorVenta = $this->codigo;

        $respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

        $fecha = substr($respuestaVenta["fecha"],0,-8);
        $productos = json_decode($respuestaVenta["productos"], true);
        $neto = number_format($respuestaVenta["neto"],2);
		$descuento = number_format($respuestaVenta["descuento"],2);
        $total = number_format($respuestaVenta["total"],2);

		//TRAEMOS LA INFORMACIÓN DEL CLIENTE

		$itemCliente = "id";
		$valorCliente = $respuestaVenta["id_cliente"];

		$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

        // REQUERIMOS LA CLASE TCPDF
        require_once('tcpdf_include.php');

        ob_clean(); // Limpiar el buffer de salida

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->startPageGroup();
        $pdf->AddPage();

        // ---------------------------------------------------------
        $bloque1 = <<<EOF
        <table>
            <tr>
			<br>
                <td style="width:150px"><img src="images/logo-negro-bloque.png"></td>
                <td style="background-color:white; width:140px">
                    
                </td>
                <td style="background-color:white; width:140px">
                    <div style="font-size:8.5px; text-align:right; line-height:5px;">
                        odteamshop@gmail.com
                        <br>
						<br>
                        WhatsApp: +57 320 7919890
                    </div>
                </td>
                <td style="background-color:white; width:110px; text-align:center; color:red">
				<b>FACTURA</b><br><b>$valorVenta</b>
				</td>

            </tr>
        </table>
EOF;

        $pdf->writeHTML($bloque1, false, false, false, false, '');

		// ---------------------------------------------------------

$bloque2 = <<<EOF

<table>
	<tr>
		<td style="width:540px"><img src="images/back.jpg"></td>
	</tr>
</table>
<table style="font-size:10px; padding:5px 10px;">
	<tr>
		<td style="border: 1px solid #666; background-color:white; width:390px">
			<b>Cliente:</b> $respuestaCliente[nombre]
		</td>
		<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
			<b>Fecha:</b> $fecha
		</td>
	</tr>
	<tr>
		<td style="border: 1px solid #666; background-color:white; width:540px"><b>Direccion:</b> $respuestaCliente[direccion]</td>
	</tr>
    <tr>
		<td style="border: 1px solid #666; background-color:white; width:540px"><b>Telefono:</b> $respuestaCliente[telefono]</td>
	</tr>
	<tr>
	<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>
	</tr>
</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size: 10px; padding: 5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color: #ccc; width: 260px; text-align: center; padding: 8px;"><b>Producto</b></td>
			<td style="border: 1px solid #666; background-color: #ccc; width: 80px; text-align: center; padding: 8px;"><b>Cantidad</b></td>
			<td style="border: 1px solid #666; background-color: #ccc; width: 100px; text-align: center; padding: 8px;"><b>Valor Unit.</b></td>
			<td style="border: 1px solid #666; background-color: #ccc; width: 100px; text-align: center; padding: 8px;"><b>Valor Total</b></td>
		</tr>
	</table>


EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {

    $itemProducto = "id";
    $valorProducto = $item["id"];

    // Obtener información del producto
    $respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto);

    // Verificar si se obtuvo la información del producto correctamente
    if ($respuestaProducto && isset($respuestaProducto["precio_venta"])) {
        $valorUnitario = number_format($respuestaProducto["precio_venta"], 2);
    } else {
        $valorUnitario = "0"; // O cualquier valor por defecto que desees mostrar
    }

    $precioTotal = number_format($item["total"], 2);

    // Construir el bloque HTML
    $bloque4 = <<<EOF
        <table style="font-size:10px; padding:5px 10px;">
            <tr>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:center">
                    {$item['descripcion']}
                </td>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
                    {$item['cantidad']}
                </td>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
                    {$valorUnitario}
                </td>
                <td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
                    {$precioTotal}
                </td>
            </tr>
        </table>
    EOF;

    // Escribir el bloque HTML en el PDF
    $pdf->writeHTML($bloque4, false, false, false, false, '');
}

	// ---------------------------------------------------------

$bloque5 = <<<EOF

<table style="font-size:10px; padding:5px 10px;">
	<tr>
		<td style="color:#333; background-color:white; width:340px; text-align:center"></td>
		<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>
		<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center"></td>
	</tr>
	<tr>
		<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
		<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
			Neto:
		</td>
		<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
			$ $neto
		</td>
	</tr>
	<tr>
		<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
			Descuento:
		</td>
		<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">
			-$ $descuento
		</td>
	</tr>
	<tr>
		<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
			Total:
		</td>
		<td style="border: 1px solid #666; background-color: #ccc; width: 100px; text-align:center"><b>
			$ $total</b>
		</td>
	</tr>
</table>
<br><br><br><br>
<br>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');


        // ---------------------------------------------------------
        $bloque6 = <<<EOF
        <table>
            <tr>
			<br>
                <td style="background-color:white">
                    <div style="font-size:10px; text-align:left width:140px">
                        <b>Términos de garantía</b>
                        <p style = "font-size:8px">El software alquilado está garantizado para funcionar correctamente durante el período de alquiler acordado. Cualquier problema técnico será solucionado de manera oportuna por nuestro equipo de soporte técnico. Esta garantía no cubre daños causados por el uso inapropiado del software por parte del usuario</p>
                        
                    </div>
                </td>
            </tr>
        </table>
        <br><br><br><br><br><br><br><br><br>
EOF;

        $pdf->writeHTML($bloque6, false, false, false, false, '');

		// ---------------------------------------------------------

        // ---------------------------------------------------------
        $bloque7 = <<<EOF
        
                    <div style="font-size:15px; text-align:center width:140px">
                        <b>GRACIAS POR SU COMPRA</b>
                    </div>
              
EOF;

        $pdf->writeHTML($bloque7, false, false, false, false, '');

		// ---------------------------------------------------------







        // ---------------------------------------------------------
        // SALIDA DEL ARCHIVO
        $pdf->Output('factura.pdf', 'I');
    }
}

$factura = new imprimirFactura();
$factura->codigo = $_GET["codigo"];
$factura->traerImpresionFactura();
?>

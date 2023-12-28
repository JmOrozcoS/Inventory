<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class AjaxProductosC
{

	/*=============================================
	   EDITAR GASTO
	   =============================================*/

	public $idProductoC;

	public function ajaxMostrarPCategorias()
	{

		$item = "id_categoria";
		$valor = $this->idProductoC;

		$respuesta = ControladorProductos::ctrMostrarProductosUnico($item, $valor);

		echo json_encode($respuesta);


	}

}

/*=============================================
EDITAR CLIENTE
=============================================*/

if (isset($_POST["idProductoC"])) {

	$pCategoria = new AjaxProductosC();
	$pCategoria->idProductoC = $_POST["idProductoC"];
	$pCategoria->ajaxMostrarPCategorias();

}
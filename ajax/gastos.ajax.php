<?php

require_once "../controladores/gastos.controlador.php";
require_once "../modelos/gastos.modelo.php";

class AjaxGastos
{

	/*=============================================
	   EDITAR GASTO
	   =============================================*/

	public $idGasto;

	public function ajaxEditarGasto()
	{

		$item = "id";
		$valor = $this->idGasto;

		$respuesta = ControladorGastos::ctrMostrarGastos($item, $valor);

		echo json_encode($respuesta);


	}

}

/*=============================================
EDITAR CLIENTE
=============================================*/

if (isset($_POST["idGasto"])) {

	$gasto = new AjaxGastos();
	$gasto->idGasto = $_POST["idGasto"];
	$gasto->ajaxEditarGasto();

}
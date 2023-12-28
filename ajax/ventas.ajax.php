<?php

require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxVentas{


    /*=============================================
    RENOVAR VENTA
    =============================================*/	

    public $activarVenta;
    public $activarIdVenta;


    public function ajaxActivarEstadoVenta(){

      $tabla = "ventas";

      $item1 = "estado";
      $valor1 = $this->activarVenta;

      $item2 = "id";
      $valor2 = $this->activarIdVenta;

      $respuesta = ModeloVentas::mdlEditarEstadoVenta($tabla, $item1, $valor1, $item2, $valor2);

	}

  }

/*=============================================
RENOVAR VENTA
=============================================*/

if(isset($_POST["activarVenta"])){

	$activarVenta = new AjaxVentas();
	$activarVenta -> activarVenta = $_POST["activarVenta"];
	$activarVenta -> activarIdVenta = $_POST["activarIdVenta"];
	$activarVenta -> ajaxActivarEstadoVenta();

}


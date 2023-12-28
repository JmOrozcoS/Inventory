<?php

class ControladorGastos{


	/*=============================================
	Obtener las Gastos totales
	=============================================*/
	static public function ctrSumaTGastos($fechaInicial, $fechaFinal){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlSumaTGastos($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;


	}


	/*=============================================
	MOSTRAR Gastos
	=============================================*/

	static public function ctrMostrarGastos($item, $valor){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlMostrarGastos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR ULTIMO CODIGO DE GASTOS
	=============================================*/

	static public function ctrMostrarMaxCodigoGastos($item, $valor){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlMostrarMaxCodigoGastos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR Gasto
	=============================================*/

	static public function ctrCrearGasto(){

		if(isset($_POST["nuevoConcepto"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.:+@#$%&()_* ]+$/', $_POST["nuevoConcepto"]) &&
			   preg_match('/^[0-9]+$/', $_POST["nuevoMonto"])){

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b = $fecha . ' ' . $hora;

			   	$tabla = "gastos";

			   	$datos = array("id_proveedor"=>$_POST["nuevoProveedor"],
							   "codigo"=>$_POST["nuevoGastoInventario"],
					           "id_usuario"=>$_POST["idRusuario"],
					           "monto"=>$_POST["nuevoMonto"],
							   "categoria"=>$_POST["nuevaCategoriaG"],
							   "forma_pago"=>$_POST["nuevoMpago"],
					           "nombre_gasto"=>$_POST["nuevoConcepto"],
							   "fecha_crea" => $valor1b);

			   	$respuesta = ModeloGastos::mdlIngresarGasto($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El gasto ha sido resgistrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "ventas";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El concepto no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "ventas";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	EDITAR GASTO
	=============================================*/

	static public function ctrEditarGasto(){

		if(isset($_POST["editarConcepto"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.:+@#$%&()_* ]+$/', $_POST["editarConcepto"]) &&
			   preg_match('/^[0-9]+$/', $_POST["editarMonto"])){


			   	$tabla = "gastos";

			   	$datos = array("id"=>$_POST["idGasto"],
							   "id_proveedor"=>$_POST["editarProveedor"],
					           "id_usuario"=>$_POST["idEditarRusuario"],
					           "forma_pago"=>$_POST["editarMpago"],
					           "monto"=>$_POST["editarMonto"],
							   "categoria"=>$_POST["editarCategoriaG"],
					           "nombre_gasto"=>$_POST["editarConcepto"]);

			   	$respuesta = ModeloGastos::mdlEditarGasto($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El gasto ha sido editado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "ventas";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El concepto no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "ventas";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrEliminarGasto(){

		if(isset($_GET["idGasto"])){

			$tabla ="gastos";
			$datos = $_GET["idGasto"];

			$respuesta = ModeloGastos::mdlEliminarGasto($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

					swal({
						  type: "success",
						  title: "El registro ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "ventas";

									}
								})

					</script>';
			}
		}
		
	}


	static public function ctrRangoFechasGastos($fechaInicial, $fechaFinal){

		$tabla = "gastos";

		$respuesta = ModeloGastos::mdlRangoFechasGastos($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}
	
}
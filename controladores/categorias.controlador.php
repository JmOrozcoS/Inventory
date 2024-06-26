<?php

class ControladorCategorias
{

	/*=============================================
	   CREAR CATEGORIAS
	   =============================================*/

	static public function ctrCrearCategoria()
	{

		if (isset($_POST["CnuevaCategoria"])) {

			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["CnuevaCategoria"])) {

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b = $fecha . ' ' . $hora;

				$tabla = "categorias";

				$datos = array("categoria" => $_POST["CnuevaCategoria"],
							  "fecha_crea" => $valor1b);

				$respuesta = ModeloCategorias::mdlIngresarCategoria($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "productos";

									}
								})

					</script>';

				}


			} else {

				echo '<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	   MOSTRAR CATEGORIAS
	   =============================================*/

	static public function ctrMostrarCategorias($item, $valor)
	{

		$tabla = "categorias";

		$respuesta = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	   EDITAR CATEGORIA
	   =============================================*/

	static public function ctrEditarCategoria()
	{

		if (isset($_POST["CeditarCategoria"])) {

			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["CeditarCategoria"])) {

				$tabla = "categorias";

				$datos = array(
					"categoria" => $_POST["CeditarCategoria"],
					"id" => $_POST["CidCategoria"]
				);

				$respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido cambiada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "productos";

									}
								})

					</script>';

				}


			} else {

				echo '<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "productos";

							}
						})

			  	</script>';

			}

		}

	}

	/*=============================================
	   BORRAR CATEGORIA
	   =============================================*/

	static public function ctrBorrarCategoria()
	{

		if (isset($_GET["idCategoria"])) {

			$tabla1 = "productos";
			$tabla = "Categorias";
			$item = "id_categoria";
			$datos = $_GET["idCategoria"];

			//Consultar producto para verificar si tiene ventas

			$respuesta1 = ModeloProductos::mdlMostrarProductos($tabla1, $item, $datos);

			//guardat la el resultado en la variable ventas
			$producto = $respuesta1["id"];

			//condicion
			if ($producto == null) {

				$respuesta = ModeloCategorias::mdlBorrarCategoria($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido borrada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "productos";

									}
								})

					</script>';
				}
			} else {

				echo '<script>

				swal({
					  type: "warning",
					  title: "La categoria tiene productos asociadas y no se puede eliminar",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then((result) => {
								if (result.value) {

								window.location = "productos";

								}
							})

				</script>';

			}
		}

	}


}
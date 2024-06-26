<?php

class ControladorProductos
{


	/*=============================================
		  Obtener EL COSTO DE PRODUCTOS totales
		  =============================================*/
	static public function ctrSumaTcostoProductos()
	{

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlSumaTcostoProductos($tabla);

		return $respuesta;


	}


	/*=============================================
		  MOSTRAR PRODUCTOS
		  =============================================*/

	static public function ctrMostrarProductos($item, $valor)
	{

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
		  MOSTRAR PRODUCTOS ACTIVOS Y STOCK MAYOR A 0
		  =============================================*/

	static public function ctrMostrarProductosActivos($item, $valor)
	{

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductosActivos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
		  MOSTRAR PRODUCTOS ACTIVOS
		  =============================================*/

	static public function crtMostrarProductosActivados($item, $valor)
	{

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductosActivados($tabla, $item, $valor);

		return $respuesta;

	}


	/*=============================================
		  MOSTRAR PRODUCTOS UNICOS
		  =============================================*/

	static public function ctrMostrarProductosUnico($item, $valor)
	{

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarProductosUnico($tabla, $item, $valor);

		return $respuesta;

	}


	/*=============================================
		  CREAR PRODUCTO
		  =============================================*/

	static public function ctrCrearProducto()
	{

		if (isset($_POST["nuevaDescripcion"])) {

			if (
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.:+@#$%&()_* ]+$/', $_POST["nuevaDescripcion"]) &&
				preg_match('/^[0-9]+$/', $_POST["nuevoStock"]) &&
				preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioCompra"]) &&
				preg_match('/^[0-9.]+$/', $_POST["nuevoPrecioVenta"])
			) {

				/*=============================================
									 VALIDAR IMAGEN
									 =============================================*/

				$ruta = "vistas/img/productos/default/anonymous.png";

				if ($_FILES["nuevaImagen"]["tmp_name"]) {

					list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
												  CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
												  =============================================*/

					$directorio = "vistas/img/productos/" . $_POST["nuevoCodigo"];

					mkdir($directorio, 0755);

					/*=============================================
												  DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
												  =============================================*/

					if ($_FILES["nuevaImagen"]["type"] == "image/jpeg") {

						/*=============================================
															GUARDAMOS LA IMAGEN EN EL DIRECTORIO
															=============================================*/

						$aleatorio = mt_rand(100, 999);

						$ruta = "vistas/img/productos/" . $_POST["nuevoCodigo"] . "/" . $aleatorio . ".jpg";

						$origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if ($_FILES["nuevaImagen"]["type"] == "image/png") {

						/*=============================================
															GUARDAMOS LA IMAGEN EN EL DIRECTORIO
															=============================================*/

						$aleatorio = mt_rand(100, 999);

						$ruta = "vistas/img/productos/" . $_POST["nuevoCodigo"] . "/" . $aleatorio . ".png";

						$origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				date_default_timezone_set('America/Bogota');

				$fecha = date('Y-m-d');
				$hora = date('H:i:s');
				$valor1b = $fecha . ' ' . $hora;

				$tabla = "productos";

				$datos = array(
					"id_categoria" => $_POST["nuevaCategoria"],
					"codigo" => $_POST["nuevoCodigo"],
					"descripcion" => $_POST["nuevaDescripcion"],
					"stock" => $_POST["nuevoStock"],
					"stock_inicial" => $_POST["nuevoStock"],
					"precio_compra" => $_POST["nuevoPrecioCompra"],
					"precio_venta" => $_POST["nuevoPrecioVenta"],
					"imagen" => $ruta,
					"fecha_crea" => $valor1b
				);

				$respuesta = ModeloProductos::mdlIngresarProducto($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

						swal({
							  type: "success",
							  title: "El producto ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then((result) => {
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
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
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

	/*=============================================
		  EDITAR PRODUCTO
		  =============================================*/

	static public function ctrEditarProducto()
	{

		if (isset($_POST["editarDescripcion"])) {

			if (
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.:+@#$%&()_* ]+$/', $_POST["editarDescripcion"]) &&
				preg_match('/^[0-9]+$/', $_POST["editarStock"]) &&
				preg_match('/^[0-9.]+$/', $_POST["editarPrecioCompra"]) &&
				preg_match('/^[0-9.]+$/', $_POST["editarPrecioVenta"])
			) {

				/*=============================================
									 VALIDAR IMAGEN
									 =============================================*/

				$ruta = $_POST["imagenActual"];

				if (isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])) {

					list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

					$nuevoAncho = 500;
					$nuevoAlto = 500;

					/*=============================================
												  CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
												  =============================================*/

					$directorio = "vistas/img/productos/" . $_POST["editarCodigo"];

					/*=============================================
												  PRIMERO PREGUNTAMOS SI EXISTE OTRA IMAGEN EN LA BD
												  =============================================*/

					if (!empty($_POST["imagenActual"]) && $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png") {

						unlink($_POST["imagenActual"]);

					} else {

						mkdir($directorio, 0755);

					}

					/*=============================================
												  DE ACUERDO AL TIPO DE IMAGEN APLICAMOS LAS FUNCIONES POR DEFECTO DE PHP
												  =============================================*/

					if ($_FILES["editarImagen"]["type"] == "image/jpeg") {

						/*=============================================
															GUARDAMOS LA IMAGEN EN EL DIRECTORIO
															=============================================*/

						$aleatorio = mt_rand(100, 999);

						$ruta = "vistas/img/productos/" . $_POST["editarCodigo"] . "/" . $aleatorio . ".jpg";

						$origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagejpeg($destino, $ruta);

					}

					if ($_FILES["editarImagen"]["type"] == "image/png") {

						/*=============================================
															GUARDAMOS LA IMAGEN EN EL DIRECTORIO
															=============================================*/

						$aleatorio = mt_rand(100, 999);

						$ruta = "vistas/img/productos/" . $_POST["editarCodigo"] . "/" . $aleatorio . ".png";

						$origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);

						$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

						imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

						imagepng($destino, $ruta);

					}

				}

				$tabla = "productos";

				$datos = array(
					"id_categoria" => $_POST["editarCategoria"],
					"codigo" => $_POST["editarCodigo"],
					"descripcion" => $_POST["editarDescripcion"],
					"stock" => $_POST["editarStock"],
					"stock_inicial" => $_POST["resultado"],
					"precio_compra" => $_POST["editarPrecioCompra"],
					"precio_venta" => $_POST["editarPrecioVenta"],
					"imagen" => $ruta
				);

				$respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);

				if ($respuesta == "ok") {

					echo '<script>

						swal({
							  type: "success",
							  title: "El producto ha sido editado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then((result) => {
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
						  title: "¡El producto no puede ir con los campos vacíos o llevar caracteres especiales!",
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

	/*=============================================
		  BORRAR PRODUCTO
		  =============================================*/
	static public function ctrEliminarProducto()
	{

		if (isset($_GET["idProducto"])) {

			$tabla = "productos";
			$item = "id";
			$valor = $_GET["idProducto"];

			//Consultar producto para verificar si tiene ventas
			$respuesta1 = ModeloProductos::mdlMostrarProductos($tabla, $item, $valor);
			
			//guardat la el resultado en la variable ventas
			$ventas = $respuesta1["ventas"];

			//condicion
			if ($ventas == 0) {

				if ($_GET["imagen"] != "" && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png") {

					unlink($_GET["imagen"]);
					rmdir('vistas/img/productos/' . $_GET["codigo"]);

				}

				$respuesta = ModeloProductos::mdlEliminarProducto($tabla, $valor);

				if ($respuesta == "ok") {

					echo '<script>
	
					swal({
						  type: "success",
						  title: "El producto ha sido borrado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then((result) => {
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
						  title: "El producto tiene facturas asociadas y no se puede eliminar",
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

	/*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/

	static public function ctrMostrarSumaVentas(){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarSumaVentas($tabla);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/

	static public function ctrVentasCategorias(){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlVentasCategorias($tabla);

		return $respuesta;

	}

}
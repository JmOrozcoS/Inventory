<?php

require_once "conexion.php";

class ModeloVentas
{


	/*=============================================
				MOSTRAR ultimo codigo de DE VENTAS
				=============================================*/

	static public function mdlMostrarMaxCodigoVentas($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();

		$stmt = null;

	}


	/*=============================================
				MOSTRAR SUMA DE VENTAS
				=============================================*/

	static public function mdlSumaTVentas($tabla, $fechaInicial, $fechaFinal)
	{
		if ($fechaInicial == null) {

			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) AS total_ventas FROM $tabla ORDER BY id DESC");

			$stmt->execute();

			return $stmt->fetchAll();


		} else if ($fechaInicial == $fechaFinal) {

			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) AS total_ventas FROM $tabla WHERE fecha_crea like '%$fechaFinal%' ORDER BY id DESC");


			//$stmt -> bindParam(":fecha_crea", $fechaFinal, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll();

		} else {

			$fechaActual = new DateTime();
			$fechaActual->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");
			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");


			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) AS total_ventas FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY id DESC");


			$stmt->execute();

			return $stmt->fetchAll();



			$stmt->execute();

			return $stmt->fetchAll();



		}

	}


	/*=============================================
				MOSTRAR ALQUILER
				=============================================*/

	static public function mdlMostrarAlquiler($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();

		$stmt = null;

	}


	/*=============================================
				MOSTRAR VENTAS
				=============================================*/

	static public function mdlMostrarVentas($tabla, $item, $valor)
	{

		if ($item != null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();

		} else {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();

		$stmt = null;

	}

	/*=============================================
				REGISTRO DE VENTA
				=============================================*/

	static public function mdlIngresarVenta($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos, descuento, neto, total, metodo_pago, tipo_venta, nombre_venta, vencimiento, fecha_crea) VALUES (:codigo, :id_cliente, :id_vendedor, :productos, :descuento, :neto, :total, :metodo_pago, :tipo_venta , :nombre_venta , :vencimiento, :fecha_crea)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_venta", $datos["tipo_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_venta", $datos["nombre_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":vencimiento", $datos["vencimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";

		} else {

			return "error";

		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
				EDITAR VENTA
				=============================================*/

	static public function mdlEditarVenta($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, descuento = :descuento, neto = :neto, total= :total, metodo_pago = :metodo_pago, tipo_venta = :tipo_venta, nombre_venta = :nombre_venta, vencimiento = :vencimiento WHERE codigo = :codigo");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_venta", $datos["tipo_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_venta", $datos["nombre_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":vencimiento", $datos["vencimiento"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";

		} else {

			return "error";

		}

		$stmt->close();
		$stmt = null;

	}



	/*=============================================
				EDITAR ESTADO DE VENTA
				=============================================*/

	static public function mdlEditarEstadoVenta($tabla, $item1, $valor1, $item2, $valor2)
	{

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
		$stmt->bindParam(":" . $item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";

		} else {

			return "error";

		}

		$stmt->close();

		$stmt = null;

	}









	/*=============================================
				ELIMINAR VENTA
				=============================================*/

	static public function mdlEliminarVenta($tabla, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {

			return "ok";

		} else {

			return "error";

		}

		$stmt->close();

		$stmt = null;

	}


	/*=============================================
			 RANGO FECHAS
			 =============================================*/

	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal)
	{

		if ($fechaInicial == null) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt->execute();

			return $stmt->fetchAll();


		} else if ($fechaInicial == $fechaFinal) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha_crea like '%$fechaFinal%' ORDER BY id DESC");

			//$stmt -> bindParam(":fecha_crea", $fechaFinal, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetchAll();

		} else {



			$fechaActual = new DateTime();
			$fechaActual->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");
			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");


			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY id DESC");


			$stmt->execute();

			return $stmt->fetchAll();



			$stmt->execute();

			return $stmt->fetchAll();

		}

	}

}
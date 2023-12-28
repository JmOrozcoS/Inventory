<?php

require_once "conexion.php";

class ModeloCostos{


	/*=============================================
	   MOSTRAR SUMA DE COSTOS
	   =============================================*/

	   static public function mdlSumaTCostos($tabla, $fechaInicial, $fechaFinal)
	   {
   

		if ($fechaInicial == null) {

			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) AS total_costos FROM $tabla ORDER BY id DESC");

			$stmt->execute();

			return $stmt->fetchAll();


		} else if ($fechaInicial == $fechaFinal) {

			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) AS total_costos FROM $tabla WHERE fecha_crea like '%$fechaFinal%' ORDER BY id DESC");


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


			$stmt = Conexion::conectar()->prepare("SELECT SUM(total) AS total_costos FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY id DESC");


			$stmt->execute();

			return $stmt->fetchAll();



			$stmt->execute();

			return $stmt->fetchAll();

		}
   
	   }


	/*=============================================
	   MOSTRAR ultimo codigo de DE COSTOS
	   =============================================*/

	   static public function mdlMostrarMaxCodigoCostos($tabla, $item, $valor)
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
	MOSTRAR COSTOSS
	=============================================*/

	static public function mdlMostrarCostos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		
		$stmt -> close();

		$stmt = null;

	}



	/*=============================================
	REGISTRO DE COSTO
	=============================================*/

	static public function mdlIngresarCosto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_proveedor, productos, descuento, neto, total, metodo_pago, nombre_costo, id_usuario, fecha_crea) VALUES (:codigo, :id_proveedor, :productos, :descuento, :neto, :total, :metodo_pago, :nombre_costo, :id_usuario, :fecha_crea)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_costo", $datos["nombre_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR COSTO
	=============================================*/

	static public function mdlEditarCosto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codigo = :codigo, id_proveedor = :id_proveedor, productos = :productos, descuento = :descuento, neto = :neto, total = :total, metodo_pago = :metodo_pago, nombre_costo = :nombre_costo, id_usuario = :id_usuario WHERE codigo = :codigo");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_costo", $datos["nombre_costo"], PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}



	/*=============================================
	ELIMINAR COSTO
	=============================================*/

	static public function mdlEliminarCosto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	 RANGO DE FECHAS
	   =============================================*/

	static public function mdlRangoFechasCostos($tabla, $fechaInicial, $fechaFinal)
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
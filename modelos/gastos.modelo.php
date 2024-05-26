<?php

require_once "conexion.php";

class ModeloGastos{


	/*=============================================
	MOSTRAR SUMA DE GastoS
	=============================================*/

	static public function mdlSumaTGastos($tabla, $fechaInicial, $fechaFinal){

		if ($fechaInicial == null) {

			$stmt = Conexion::conectar()->prepare("SELECT SUM(monto) AS total_gastos FROM $tabla ORDER BY id DESC");

			$stmt->execute();

			return $stmt->fetchAll();


		} else if ($fechaInicial == $fechaFinal) {

			$stmt = Conexion::conectar()->prepare("SELECT SUM(monto) AS total_gastos FROM $tabla WHERE fecha_crea like '%$fechaFinal%' ORDER BY id DESC");


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


			$stmt = Conexion::conectar()->prepare("SELECT SUM(monto) AS total_gastos FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' ORDER BY id DESC");


			$stmt->execute();

			return $stmt->fetchAll();



			$stmt->execute();

			return $stmt->fetchAll();

		}

	}




	/*=============================================
	MOSTRAR GastoS
	=============================================*/

	static public function mdlMostrarGastos($tabla, $item, $valor){

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
	   MOSTRAR ultimo codigo de DE GASTOS
	   =============================================*/

	   static public function mdlMostrarMaxCodigoGastos($tabla, $item, $valor)
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
	REGISTRO DE GASTO
	=============================================*/

	static public function mdlIngresarGasto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_proveedor, id_usuario, forma_pago, monto, categoria, nombre_gasto, fecha_crea, tipo_registro) VALUES (:codigo, :id_proveedor, :id_usuario, :forma_pago, :monto, :categoria, :nombre_gasto, :fecha_crea, :tipo_registro)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":forma_pago", $datos["forma_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_gasto", $datos["nombre_gasto"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_crea", $datos["fecha_crea"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_registro", $datos["tipo_registro"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR GASTO
	=============================================*/

	static public function mdlEditarGasto($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_proveedor = :id_proveedor, forma_pago = :forma_pago, monto = :monto, categoria = :categoria, nombre_gasto = :nombre_gasto, id_usuario = :id_usuario, tipo_registro = :tipo_registro WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":id_proveedor", $datos["id_proveedor"], PDO::PARAM_INT);
		$stmt->bindParam(":forma_pago", $datos["forma_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_gasto", $datos["nombre_gasto"], PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);
		$stmt->bindParam(":tipo_registro", $datos["tipo_registro"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}



	/*=============================================
	ELIMINAR Gasto
	=============================================*/

	static public function mdlEliminarGasto($tabla, $datos){

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


	static public function mdlRangoFechasGastos($tabla, $fechaInicial, $fechaFinal)
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
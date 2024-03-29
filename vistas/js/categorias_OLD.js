/*=============================================
EDITAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEditarCategoria", function(){

	var idCategoria = $(this).attr("idCategoria");

	var datos = new FormData();
	datos.append("idCategoria", idCategoria);

	$.ajax({
		url: "ajax/categorias.ajax.php",
		method: "POST",
      	data: datos,
      	cache: false,
     	contentType: false,
     	processData: false,
     	dataType:"json",
     	success: function(respuesta){


			console.log("respuesta", respuesta);

			//limpiar la tabla de productos del modal editar categoria
			$(" .tablaCategoriasProductos tbody").empty();

			var datosCategoriaP = new FormData();
			datosCategoriaP.append("idProductoC", respuesta["id"]); //capturar el id producto de la respuesta anterior

			//Usar la respuesta para obtener a traves de ajax los productos asociados a la categoria
			$.ajax({
	  
			  url: "ajax/datatable-categorias.productos.ajax.php",
			  method: "POST",
			  data: datosCategoriaP,
			  cache: false,
			  contentType: false,
			  processData: false,
			  dataType: "json",
			  success: function (respuesta2) {
	  
				//console.log("respuesta2", respuesta2);
	  
				// Iterar a través de los objetos JSON y agregarlos a la tabla del modal editar categorias en categorias.php
				$.each(respuesta2, function(index, item) {
					var newRow = $("<tr>");
					var cols = "";

					//cols += '<td>' + ( index +1 )+ '</td>';	

					if (item.imagen !== "") {
						cols += '<td><img src="' + item.imagen + '" class="img-thumbnail" width="40px"></td>';
					} else {
						cols += '<td><img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail" width="40px"></td>';
					}		
								
					cols += '<td>' + item.codigo + '</td>';	


					if (item.stock <= 2) {
						stockButton = '<b class="text-red">' + item.stock + ' disponibles</b>';
					} else if (item.stock > 2 && item.stock <= 4) {
						stockButton = '<b class="text-yellow">' + item.stock + ' disponibles</b>';
					} else {
						stockButton = '<b class="text-green">' + item.stock + ' disponibles</b>';
					}

					var precioVenta = item.precio_venta;
					// Formatear el número con dos decimales y formato de moneda.
					var precioVentaFormat = precioVenta.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

					cols += '<td>' + '$ ' + precioVentaFormat + '</td>';	

					cols += '<td>' + stockButton + '</td>';
		
					newRow.append(cols);
					
					$(" .tablaCategoriasProductos tbody").append(newRow);
				});
	  
			  }
	  
			})

			//asignar los valores a los inputs
     		$("#CeditarCategoria").val(respuesta["categoria"]);
     		$("#CidCategoria").val(respuesta["id"]);

     	}

	})


})




/*=============================================
ELIMINAR CATEGORIA
=============================================*/
$(".tablas").on("click", ".btnEliminarCategoria", function(){

	 var idCategoria = $(this).attr("idCategoria");

	 swal({
	 	title: '¿Está seguro de borrar la categoría?',
	 	text: "¡Si no lo está puede cancelar la acción!",
	 	type: 'warning',
	 	showCancelButton: true,
	 	confirmButtonColor: '#3085d6',
	 	cancelButtonColor: '#d33',
	 	cancelButtonText: 'Cancelar',
	 	confirmButtonText: 'Si, borrar categoría!'
	 }).then(function(result){

	 	if(result.value){

	 		window.location = "index.php?ruta=productos&idCategoria="+idCategoria;

	 	}

	 })

})


/*=============================================
VALIDAR INGRESO DE NOMBRE EN TIEMPO REAL
=============================================*/
$(document).ready(function () {
	$("#CnuevaCategoria").on("input", function () {
	  var nombre = $(this).val();
	  var nombrePattern = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/;
  
	  if (!nombrePattern.test(nombre)) {
		$("#errorNombreC").text("Nombre no válido");
	  } else {
		$("#errorNombreC").text(""); // Borra el mensaje de error si el correo es válido
	  }
	});
  });

  /*=============================================
VALIDAR INGRESO DE NOMBRE EN TIEMPO REAL AL EDITAR
=============================================*/
$(document).ready(function () {
	$("#CeditarCategoria").on("input", function () {
	  var nombre = $(this).val();
	  var nombrePattern = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/;
  
	  if (!nombrePattern.test(nombre)) {
		$("#errorNombreEC").text("Nombre no válido");
	  } else {
		$("#errorNombreEC").text(""); // Borra el mensaje de error si el correo es válido
	  }
	});
  });
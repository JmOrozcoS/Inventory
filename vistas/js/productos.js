/*=============================================
CARGAR LA TABLA DINÁMICA DE PRODUCTOS
=============================================*/

// $.ajax({

// 	url: "ajax/datatable-productos.ajax.php",
// 	success:function(respuesta){

// 		console.log("respuesta", respuesta);

// 	}

// })

/*

$('.tablaCategoriasProductos').DataTable( {
	"ajax": "ajax/datatable-productos.ajax.php",
	"deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {

			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}

	}

} );*/




$('.tablaProductos').DataTable({
	"ajax": "ajax/datatable-productos.ajax.php",
	"deferRender": true,
	"retrieve": true,
	"processing": true,
	"language": {

		"sProcessing": "Procesando...",
		"sLengthMenu": "Mostrar _MENU_ registros",
		"sZeroRecords": "No se encontraron resultados",
		"sEmptyTable": "Ningún dato disponible en esta tabla",
		"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix": "",
		"sSearch": "Buscar:",
		"sUrl": "",
		"sInfoThousands": ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
			"sFirst": "Primero",
			"sLast": "Último",
			"sNext": "Siguiente",
			"sPrevious": "Anterior"
		},
		"oAria": {
			"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	}

});

/*=============================================
CAPTURANDO LA CATEGORIA PARA ASIGNAR CÓDIGO
=============================================*/
$("#nuevaCategoria").change(function () {

	var idCategoria = $(this).val();

	var datos = new FormData();
	datos.append("idCategoria", idCategoria);

	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			if (!respuesta) {

				var nuevoCodigo = idCategoria + "01";
				$("#nuevoCodigo").val(nuevoCodigo);

			} else {

				var nuevoCodigo = Number(respuesta["codigo"]) + 1;
				$("#nuevoCodigo").val(nuevoCodigo);

			}

		}

	})

})

/*=============================================
AGREGANDO PRECIO DE VENTA
=============================================*/
$("#nuevoPrecioCompra, #editarPrecioCompra").change(function () {

	if ($(".porcentaje").prop("checked")) {

		var valorPorcentaje = $(".nuevoPorcentaje").val();

		var porcentaje = Number(($("#nuevoPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#nuevoPrecioCompra").val());

		var editarPorcentaje = Number(($("#editarPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#editarPrecioCompra").val());

		$("#nuevoPrecioVenta").val(porcentaje);
		$("#nuevoPrecioVenta").prop("readonly", true);

		$("#editarPrecioVenta").val(editarPorcentaje);
		$("#editarPrecioVenta").prop("readonly", true);

	}

})

/*=============================================
CAMBIO DE PORCENTAJE
=============================================*/
$(".nuevoPorcentaje").change(function () {

	if ($(".porcentaje").prop("checked")) {

		var valorPorcentaje = $(this).val();

		var porcentaje = Number(($("#nuevoPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#nuevoPrecioCompra").val());

		var editarPorcentaje = Number(($("#editarPrecioCompra").val() * valorPorcentaje / 100)) + Number($("#editarPrecioCompra").val());

		$("#nuevoPrecioVenta").val(porcentaje);
		$("#nuevoPrecioVenta").prop("readonly", true);

		$("#editarPrecioVenta").val(editarPorcentaje);
		$("#editarPrecioVenta").prop("readonly", true);

	}

})

$(".porcentaje").on("ifUnchecked", function () {

	$("#nuevoPrecioVenta").prop("readonly", false);
	$("#editarPrecioVenta").prop("readonly", false);

})

$(".porcentaje").on("ifChecked", function () {

	$("#nuevoPrecioVenta").prop("readonly", true);
	$("#editarPrecioVenta").prop("readonly", true);

})

/*=============================================
SUBIENDO LA FOTO DEL PRODUCTO
=============================================*/

$(".nuevaImagen").change(function () {

	var imagen = this.files[0];

	/*=============================================
		VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
		=============================================*/

	if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {

		$(".nuevaImagen").val("");

		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen debe estar en formato JPG o PNG!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});

	} else if (imagen["size"] > 2000000) {

		$(".nuevaImagen").val("");

		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen no debe pesar más de 2MB!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});

	} else {

		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);

		$(datosImagen).on("load", function (event) {

			var rutaImagen = event.target.result;

			$(".previsualizar").attr("src", rutaImagen);

		})

	}
})

/*=============================================
EDITAR PRODUCTO
=============================================*/

$(".tablaProductos tbody").on("click", "button.btnEditarProducto", function () {

	var idProducto = $(this).attr("idProducto");

	var datos = new FormData();
	datos.append("idProducto", idProducto);

	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			var datosCategoria = new FormData();
			datosCategoria.append("idCategoria", respuesta["id_categoria"]);

			$.ajax({

				url: "ajax/categorias.ajax.php",
				method: "POST",
				data: datosCategoria,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function (respuesta) {

					$("#editarCategoria").val(respuesta["id"]);
					$("#editarCategoria").html(respuesta["categoria"]);

				}

			})

			$("#editarCodigo").val(respuesta["codigo"]);

			$("#editarDescripcion").val(respuesta["descripcion"]);

			$("#editarStock").val(respuesta["stock"]);
			$("#actualStock").val(respuesta["stock"]);
			$("#actualInicialStock").val(respuesta["stock_inicial"]);

			$("#editarPrecioCompra").val(respuesta["precio_compra"]);

			$("#editarPrecioVenta").val(respuesta["precio_venta"]);

			if (respuesta["imagen"] != "") {

				$("#imagenActual").val(respuesta["imagen"]);

				$(".previsualizar").attr("src", respuesta["imagen"]);

			}

		}

	})

})


/*=============================================

=============================================*/


$(document).ready(function () {
	// Cuando los inputs cambien su valor
	$('#editarStock, #actualStock').on('input', function () {
		// Obtener los valores de los inputs
		var valor1 = parseFloat($('#editarStock').val()) || 0; // Parsear a número, si no es válido, usar 0
		var valor2 = parseFloat($('#actualStock').val()) || 0;
		var valor3 = parseFloat($('#actualInicialStock').val()) || 0;

		// Calcular la suma
		var suma = valor1 - valor2;
		var nAcumStock = suma + valor3;

		// Mostrar el resultado en el input hidden
		$('#resultado').val(nAcumStock);
		console.log(suma);
	});
});

/*=============================================
ELIMINAR PRODUCTO
=============================================*/

$(".tablaProductos tbody").on("click", "button.btnEliminarProducto", function () {

	var idProducto = $(this).attr("idProducto");
	var codigo = $(this).attr("codigo");
	var imagen = $(this).attr("imagen");

	swal({

		title: '¿Está seguro de borrar el producto?',
		text: "¡Si no lo está puede cancelar la accíón!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, borrar producto!'
	}).then(function (result) {
		if (result.value) {

			window.location = "index.php?ruta=productos&idProducto=" + idProducto + "&imagen=" + imagen + "&codigo=" + codigo;

		}


	})

})


/*=============================================
ACTIVAR PRODUCTO
=============================================*/
$(".tablaProductos tbody").on("click", "button.btnActivarProducto", function () {

	var idProducto = $(this).attr("idProducto");
	var estadoProducto = $(this).attr("estadoProducto");

	var datos = new FormData();
	datos.append("activarIdProducto", idProducto);
	datos.append("activarProducto", estadoProducto);

	//console.log("estadoProducto", estadoProducto);

	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function (respuesta) {


			if (window.matchMedia("(max-width:767px)").matches) {

				swal({
					title: "El Producto ha sido actualizado",
					type: "success",
					confirmButtonText: "¡Cerrar!"
				}).then(function (result) {
					if (result.value) {

						window.location = "productos";

					}


				});

			}

		}

	})

	if (estadoProducto == 0) {

		$(this).removeClass('btn-success');
		$(this).addClass('btn-danger');
		$(this).html('Desactivado');
		$(this).attr('estadoProducto', 1);

	} else {

		$(this).addClass('btn-success');
		$(this).removeClass('btn-danger');
		$(this).html('Activado');
		$(this).attr('estadoProducto', 0);

	}

})

/*=============================================
VALIDAR INGRESO DE NOMBRE EN TIEMPO REAL
=============================================*/
$(document).ready(function () {
	$("#nuevaDescripcion").on("input", function () {
		var nombre = $(this).val();
		var nombrePattern = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.:+@#$%&()_* ]+$/;

		if (!nombrePattern.test(nombre)) {
			$("#errorNombreD").text("Nombre no válido");
		} else {
			$("#errorNombreD").text(""); // Borra el mensaje de error si el correo es válido
		}
	});
});

/*=============================================
VALIDAR INGRESO DE NOMBRE EN TIEMPO REAL
=============================================*/
$(document).ready(function () {
	$("#editarDescripcion").on("input", function () {
		var nombre = $(this).val();
		var nombrePattern = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.:+@#$%&()_* ]+$/;

		if (!nombrePattern.test(nombre)) {
			$("#errorNombreED").text("Nombre no válido");
		} else {
			$("#errorNombreED").text(""); // Borra el mensaje de error si el correo es válido
		}
	});
});


/*=============================================
FILTRO ESTADO con pluggin DATETABLE
=============================================*/

$(document).ready(function () {
	var tabla = $(' .tablaProductos').DataTable(); // Obtén una referencia a la tabla DataTable

	$('#cat-select').on('change', function () {
		var filtro = $(this).val().toLowerCase();

		// Realiza la búsqueda en la tabla DataTable y muestra las filas correspondientes
		if (filtro === 'todas') {
			tabla.column(4).search('', true, true).draw();
		} else {

			//false indica coincidencia exacta
			tabla.column(4).search(filtro, true, false).draw();
		}
	});
});



// SIdebar categorias del modulo productos
$(document).ready(function () {
    $('.edit-category-button').click(function () {
        const categorySidebar = $('.category-sidebar');
        if (categorySidebar.css('right') === '0px') {
            categorySidebar.css('right', '-426px'); // Cierra la ventana deslizante
        } else {
            categorySidebar.css('right', '0px'); // Abre la ventana deslizante
        }
    });
});


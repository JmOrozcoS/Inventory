/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/

$.ajax({

	url: "ajax/datatable-surtir-inventario.ajax.php",
	success: function (respuesta) {

		//console.log("respuesta", respuesta);

	}

})

$(document).ready(function () {
	// Inicializar el select con Select2 
	$("#seleccionarProveedor").select2({
		placeholder: "Selecionar Proveedor", // Texto del placeholder
		width: '100%', // Establece el ancho
		height: '60px' // Establece la altura
	});

});

$('.tablaSurtirInventario').DataTable({
	"ajax": "ajax/datatable-surtir-inventario.ajax.php",
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
AGREGANDO PRODUCTOS A LA VENTA DESDE LA TABLA
=============================================*/

$(".tablaSurtirInventario tbody").on("click", "button.agregarProducto", function () {

	//capturar ID
	var idProducto = $(this).attr("idProducto");

	//remover la clase del boton
	$(this).removeClass("btn-primary agregarProducto");

	//agregar clase default
	$(this).addClass("btn-default");

	//guardar el ID en una variable datos
	var datos = new FormData();
	datos.append("idProducto", idProducto);

	//Solicitar por AJAX respuesta de productos
	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			var descripcion = respuesta["descripcion"];
			var stock = respuesta["stock"];
			var precio = respuesta["precio_compra"];
			var estado = respuesta["estado"];

			/*=============================================
			EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
			=============================================*/

			if (estado == 0) {

				swal({
					title: "No hay stock disponible",
					type: "error",
					confirmButtonText: "¡Cerrar!"
				});

			$("button[idProducto='" + idProducto + "']").addClass("btn-primary agregarProducto");

			return;

			}



			$(".nuevoProducto").append(

				'<div class="row" style="padding:5px 15px">' +

				'<!-- Descripción del producto -->' +

				'<div class="col-xs-6" style="padding-right:0px">' +

				'<div class="input-group">' +

				'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="' + idProducto + '"><i class="fa fa-trash"></i></button></span>' +

				'<input type="text" class="form-control nuevaDescripcionProducto" style="padding:0px 3px" idProducto="' + idProducto + '" name="agregarProducto" value="' + descripcion + '" readonly required>' +

				'</div>' +

				'</div>' +

				'<!-- Cantidad del producto -->' +

				'<div class="col-xs-2">' +

				'<input type="number" class="form-control nuevaCantidadProducto" style="padding:0px 4px" name="nuevaCantidadProducto"  value="0" stock="' + stock + '" nuevoStock="' + Number(stock + 1) + '" required style="padding-left:5px" placeholder="0" style="padding-right:5px" required>' +

				'</div>' +

				'<!-- Precio del producto -->' +

				'<div class="col-xs-4 ingresoPrecio" style="padding-left:0px">' +

				'<div class="input-group">' +

				'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +

				'<input type="text" class="form-control nuevoPrecioProducto" precioReal="' + precio + '" name="nuevoPrecioProducto" value="' + precio + '" readonly required>' +

				'</div>' +

				'</div>' +

				'</div>')

			// SUMAR TOTAL DE PRECIOS

			sumarTotalPrecios()

			// AGREGAR Descuento

			agregarDescuento()

			// AGRUPAR PRODUCTOS EN FORMATO JSON

			listarProductos()

			// PONER FORMATO AL PRECIO DE LOS PRODUCTOS

			$(".nuevoPrecioProducto").number(true, 2);

		}

	})

});

/*=============================================
CUANDO CARGUE LA TABLA CADA VEZ QUE NAVEGUE EN ELLA
=============================================*/

$(".tablaSurtirInventario").on("draw.dt", function () {

	if (localStorage.getItem("quitarProducto") != null) {

		var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));

		for (var i = 0; i < listaIdProductos.length; i++) {

			$("button.recuperarBoton[idProducto='" + listaIdProductos[i]["idProducto"] + "']").removeClass('btn-default');
			$("button.recuperarBoton[idProducto='" + listaIdProductos[i]["idProducto"] + "']").addClass('btn-primary agregarProducto');

		}


	}


})


/*=============================================
QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTÓN
=============================================*/

var idQuitarProducto = [];

localStorage.removeItem("quitarProducto");

$(".formularioSurtirInventario").on("click", "button.quitarProducto", function () {

	$(this).parent().parent().parent().parent().remove();

	var idProducto = $(this).attr("idProducto");

	/*=============================================
	ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR
	=============================================*/

	if (localStorage.getItem("quitarProducto") == null) {

		idQuitarProducto = [];

	} else {

		idQuitarProducto.concat(localStorage.getItem("quitarProducto"))

	}

	idQuitarProducto.push({ "idProducto": idProducto });

	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

	$("button.recuperarBoton[idProducto='" + idProducto + "']").removeClass('btn-default');

	$("button.recuperarBoton[idProducto='" + idProducto + "']").addClass('btn-primary agregarProducto');

	if ($(".nuevoProducto").children().length == 0) {

		$("#nuevoDescuentoVenta").val(0);
		$("#nuevoTotalVenta").val(0);
		$("#totalVenta").val(0);
		$("#nuevoTotalVenta").attr("total", 0);

	} else {

		// SUMAR TOTAL DE PRECIOS

		sumarTotalPrecios()

		// AGREGAR Descuento

		agregarDescuento()

		// AGRUPAR PRODUCTOS EN FORMATO JSON

		listarProductos()

	}

})



/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/

var numProducto = 0;

$(".btnAgregarProductoI").click(function () {

	numProducto++;

	var datos = new FormData();
	datos.append("traerProductos", "ok");

	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			$(".nuevoProducto").append(

				'<div class="row" style="padding:5px 15px">' +

				'<!-- Descripción del producto -->' +

				'<div class="col-xs-6" style="padding-right:0px">' +

				'<div class="input-group">' +

				'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-trash"></i></button></span>' +

				'<select class="form-control nuevaDescripcionProducto" style="padding:0px 0px" id="producto' + numProducto + '" idProducto name="nuevaDescripcionProducto" required>' +

				'<option>Seleccione el producto</option>' +

				'</select>' +

				'</div>' +

				'</div>' +

				'<!-- Cantidad del producto -->' +

				'<div class="col-xs-2 ingresoCantidad">' +

				'<input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto"  value="1" stock nuevoStock required style="padding:0px 4px" placeholder="0">' +

				'</div>' +

				'<!-- Precio del producto -->' +

				'<div class="col-xs-4 ingresoPrecio" style="padding-left:0px">' +

				'<div class="input-group">' +

				'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +

				'<input type="text" class="form-control nuevoPrecioProducto" precioReal="" name="nuevoPrecioProducto" readonly required>' +

				'</div>' +

				'</div>' +

				'</div>');


			// AGREGAR LOS PRODUCTOS AL SELECT 

			respuesta.forEach(funcionForEach);

			function funcionForEach(item, index) {

				if (item.estado != 0) {

					$("#producto" + numProducto).append(

						'<option idProducto="' + item.id + '" value="' + item.descripcion + '">' + item.descripcion + '</option>'
					)

				}

			}

			// SUMAR TOTAL DE PRECIOS

			sumarTotalPrecios()

			// AGREGAR Descuento

			agregarDescuento()

			// PONER FORMATO AL PRECIO DE LOS PRODUCTOS

			$(".nuevoPrecioProducto").number(true, 2);

		}


	})

})





/*=============================================
SELECCIONAR PRODUCTO
=============================================*/

$(".formularioSurtirInventario").on("change", "select.nuevaDescripcionProducto", function () {

	var nombreProducto = $(this).val();

	var nuevaDescripcionProducto = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionProducto");

	var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");

	var datos = new FormData();
	datos.append("nombreProducto", nombreProducto);


	$.ajax({

		url: "ajax/productos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function (respuesta) {

			$(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
			$(nuevaCantidadProducto).attr("stock", respuesta["stock"]);
			$(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stock"]) - 1);
			$(nuevoPrecioProducto).val(respuesta["precio_compra"]);
			$(nuevoPrecioProducto).attr("precioReal", respuesta["precio_compra"]);

			// AGRUPAR PRODUCTOS EN FORMATO JSON

			listarProductos()

		}

	})
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioSurtirInventario").on("change", "input.nuevaCantidadProducto", function () {

	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var precioFinal = $(this).val() * precio.attr("precioReal");

	precio.val(precioFinal);

	var nuevoStock = Number($(this).attr("stock")) + Number($(this).val());

	$(this).attr("nuevoStock", nuevoStock);

	/*if (Number($(this).val()) > Number($(this).attr("stock"))) {

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================

		$(this).val(1);

		var precioFinal = $(this).val() * precio.attr("precioReal");

		precio.val(precioFinal);

		sumarTotalPrecios();

		swal({
			title: "La cantidad supera el Stock",
			text: "¡Sólo hay " + $(this).attr("stock") + " unidades!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});

		return;

	}*/

	// SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()

	// AGREGAR Descuento

	agregarDescuento()

	// AGRUPAR PRODUCTOS EN FORMATO JSON

	listarProductos()

})


/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioSurtirInventario").on("change", "input.editarCantidadProducto", function () {

	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var precioFinal = $(this).val() * precio.attr("precioReal");

	precio.val(precioFinal);

	var nuevoStock = Number($(this).val());

	$(this).attr("nuevoStock", nuevoStock);

	/*if (Number($(this).val()) > Number($(this).attr("stock"))) {

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================

		$(this).val(1);

		var precioFinal = $(this).val() * precio.attr("precioReal");

		precio.val(precioFinal);

		sumarTotalPrecios();

		swal({
			title: "La cantidad supera el Stock",
			text: "¡Sólo hay " + $(this).attr("stock") + " unidades!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});

		return;

	}*/

	// SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()

	// AGREGAR Descuento

	agregarDescuento()

	// AGRUPAR PRODUCTOS EN FORMATO JSON

	listarProductosC()

})


/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductosC() {

	var listaProductos = [];

	var descripcion = $(".nuevaDescripcionProducto");

	var cantidad = $(".editarCantidadProducto");

	var precio = $(".nuevoPrecioProducto");

	for (var i = 0; i < descripcion.length; i++) {

		listaProductos.push({
			"id": $(descripcion[i]).attr("idProducto"),
			"descripcion": $(descripcion[i]).val(),
			"cantidad": $(cantidad[i]).val(),
			"stock": $(cantidad[i]).attr("nuevoStock"),
			"precio": $(precio[i]).attr("precioReal"),
			"total": $(precio[i]).val()
		})

	}

	$("#listaProductos").val(JSON.stringify(listaProductos));

}



/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarProducto() {

	//Capturamos todos los id de productos que fueron elegidos en la venta
	var idProductos = $(".quitarProducto");

	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaSurtirInventario tbody button.agregarProducto");

	//Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
	for (var i = 0; i < idProductos.length; i++) {

		//Capturamos los Id de los productos agregados a la venta
		var boton = $(idProductos[i]).attr("idProducto");

		//Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
		for (var j = 0; j < botonesTabla.length; j++) {

			if ($(botonesTabla[j]).attr("idProducto") == boton) {

				$(botonesTabla[j]).removeClass("btn-primary agregarProducto");
				$(botonesTabla[j]).addClass("btn-default");

			}
		}

	}

}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaSurtirInventario').on('draw.dt', function () {

	quitarAgregarProducto();

})



/*=============================================
CAMBIO EN EFECTIVO
=============================================*/
$(".formularioSurtirInventario").on("change", "input#nuevoValorEfectivo", function () {

	var efectivo = $(this).val();

	var cambio = Number(efectivo) - Number($('#nuevoTotalVenta').val());

	var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');

	nuevoCambioEfectivo.val(cambio);

})

/*=============================================
CAMBIO TRANSACCIÓN
=============================================*/
$(".formularioSurtirInventario").on("change", "input#nuevoCodigoTransaccion", function () {

	// Listar método en la entrada
	listarMetodos()


})


/*=============================================
CAMBIO TIPO DE VENTA
=============================================*/
$(".formularioSurtirInventario").on("change", "input#nuevoNombreCosto", function () {


	$("#listaNombreCosto").val($("#nuevoNombreCosto").val());


})


/*=============================================
METODO PAGO
=============================================*/
$(".formularioSurtirInventario").on("change", "input#nuevoMetodoPago", function () {


	$("#listaMetodoPago").val($("#nuevoMetodoPago").val());


})


/*=============================================
BOTON EDITAR COSTO
=============================================*/
$(".tablas").on("click", ".btnEditarCosto", function () {

	var idCosto = $(this).attr("idCosto");

	//console.log("idVenta", idVenta);

	window.location = "index.php?ruta=editar-costo&idCosto=" + idCosto;


})


/*=============================================
BORRAR COSTO
=============================================*/
$(".tablaCostos").on("click", ".btnEliminarCosto", function () {

	var idCosto = $(this).attr("idCosto");

	swal({
		title: '¿Está seguro de borrar el Costo?',
		text: "¡Si no lo está puede cancelar la accíón!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, borrar Costo!'
	}).then(function (result) {
		if (result.value) {

			window.location = "index.php?ruta=ventas&idCosto=" + idCosto;
		}

	})

})


/*=============================================
BOTON RENOVAR COSTO
=============================================*/
$(".tablas").on("click", ".btnRenovarCosto", function () {

	var idCosto = $(this).attr("idCosto");

	window.location = "index.php?ruta=renovar-costo&idCosto=" + idCosto;


})


/*=============================================
BOTON GUARDAR RENOVAR COSTO
=============================================*/

$(document).ready(function () {
	$("#btnRcosto").click(function () {

		// Obtén el valor del parámetro idVenta de la URL
		var parametros = new URLSearchParams(window.location.search);
		var idCosto = parametros.get('idCosto');

		var estadoCosto = $(this).attr("estadoCosto");

		var datos = new FormData();
		datos.append("activarIdCosto", idCosto);
		datos.append("activarCosto", estadoCosto);


		// Ahora puedes usar idVenta en esta página
		//console.log('idVenta:', idVenta);
		//console.log('estadoVenta', estadoVenta);


		$.ajax({

			url: "ajax/ventas.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			success: function (respuesta) {

				//console.log(respuesta);
				//window.location = "index.php?ruta=renovar-venta&idVenta="+idVenta;
				//window.location = "rentas";


				//if(window.matchMedia("(max-width:767px)").matches){

				/*swal({
					title: "El estado de la venta se ha renovado",
					type: "success",
					confirmButtonText: "¡Cerrar!"
				}).then(function (result) {
					if (result.value) {

						//window.location = "rentas";


					}


				});*/

				//}

			}

		})

	})
});


/*=============================================
BOTON DEVOLVER VENTA
=============================================*/
$(".tablaCostos").on("click", ".btnDevolverCosto", function () {

	var idCosto = $(this).attr("idCosto");
	var estadoCosto = $(this).attr("estadoCosto");

	var datos = new FormData();
	datos.append("activarIdCosto", idCosto);
	datos.append("activarCosto", estadoCosto);


	// Ahora puedes usar idVenta en esta página
	//console.log('idVenta:', idVenta);
	//console.log('estadoVenta', estadoVenta);


	swal({
		title: '¿Está seguro de devolver los productos?',
		text: "¡Esta accíón no se puede revertir!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, devolver productos!'
	}).then(function (result) {
		if (result.value) {

			$.ajax({

				url: "ajax/ventas.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				success: function (respuesta) {

					//console.log(respuesta);
					window.location = "index.php?ruta=ventas&idCosto=" + idCosto;
					//window.location = "ventas";


					/*//if(window.matchMedia("(max-width:767px)").matches){
	  
						swal({
						title: "El estado de la venta se ha renovado",
						type: "success",
						confirmButtonText: "¡Cerrar!"
					  }).then(function(result) {
						  if (result.value) {
	  
							  window.location = "index.php?ruta=rentas&idVenta="+idVenta;
							  
	  
						  }
	  
	  
					  });
	  
					//}*/

				}

			})
		}

	})





})



/*=============================================
CARGAR LA TABLA DINÁMICA DE VENTAS
=============================================*/
/*
 $.ajax({

 	url: "ajax/datatable-costos.ajax.php",
	success:function(respuesta){

		console.log("respuesta", respuesta);

 	}

 })


/*=============================================
VARIABLE LOCAL STORAGE
=============================================*/

if (localStorage.getItem("capturarRango") != null) {

	$("#daterange-btn span").html(localStorage.getItem("capturarRango"));

} else {
	$("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha');

}

/*=============================================
SELECT2
=============================================*/

$(document).ready(function () {
	// Inicializar el select con Select2 
	$("#seleccionarCliente").select2({
		placeholder: "Selecionar cliente", // Texto del placeholder
		width: '100%', // Establece el ancho
		height: '60px' // Establece la altura
	});

});

/*=============================================
FILTRO ESTADO con pluggin DATETABLE
=============================================*/

$(document).ready(function () {
	var tabla = $(' .tablaAlquiler').DataTable(); // Obtén una referencia a la tabla DataTable

	$('#estados-select').on('change', function () {
		var filtro = $(this).val().toLowerCase();

		// Realiza la búsqueda en la tabla DataTable y muestra las filas correspondientes
		if (filtro === 'todos') {
			tabla.column(7).search('', true, true).draw();
		} else {

			//false indica coincidencia exacta
			tabla.column(7).search(filtro, true, false).draw();
		}
	});
});


// Tabla de modulo nueva venta
$('.tablaVentas').DataTable({
	"ajax": "ajax/datatable-productos-ventas.ajax.php",
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

$('.tablaAlquiler').DataTable({
	"ajax": "ajax/datatable-alquiler.ajax.php",
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

$(".tablaVentas tbody").on("click", "button.agregarProducto", function () {

	var idProducto = $(this).attr("idProducto");

	$(this).removeClass("btn-primary agregarProducto");

	$(this).addClass("btn-default");

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

			var descripcion = respuesta["descripcion"];
			var stock = respuesta["stock"];
			var precio = respuesta["precio_venta"];

			/*=============================================
			EVITAR AGREGAR PRODUTO CUANDO EL STOCK ESTÁ EN CERO
			=============================================*/

			if (stock == 0) {

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

				'<input type="number" class="form-control nuevaCantidadProducto" style="padding:0px 4px" name="nuevaCantidadProducto" min="1" value="1" stock="' + stock + '" nuevoStock="' + Number(stock - 1) + '" required style="padding-left:5px" placeholder="0" style="padding-right:5px">' +

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

$(".tablaVentas").on("draw.dt", function () {

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

$(".formularioVenta").on("click", "button.quitarProducto", function () {

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

	/*$("button.recuperarBoton[idProducto='" + idProducto + "']").removeClass('btn-default');

	$("button.recuperarBoton[idProducto='" + idProducto + "']").addClass('btn-primary agregarProducto');*/

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

$(".btnAgregarProducto").click(function () {

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
                '   <!-- Descripción del producto -->' +
                '   <div class="col-xs-6" style="padding-right:0px">' +
                '       <div class="input-group">' +
                '           <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-trash"></i></button></span>' +
                '           <select class="form-control nuevaDescripcionProducto" style="padding:0px 0px; max-width: 100%;" id="producto_' + numProducto + '" name="nuevaDescripcionProducto" required>' +
                '               <option>Seleccione el producto</option>' +
                '           </select>' +
                '       </div>' +
                '   </div>' +
                '   <!-- Cantidad del producto -->' +
                '   <div class="col-xs-2 ingresoCantidad">' +
                '       <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock nuevoStock required style="padding:0px 4px" placeholder="0">' +
                '   </div>' +
                '   <!-- Precio del producto -->' +
                '   <div class="col-xs-4 ingresoPrecio" style="padding-left:0px">' +
                '       <div class="input-group">' +
                '           <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +
                '           <input type="text" class="form-control nuevoPrecioProducto" precioReal="" name="nuevoPrecioProducto" readonly required>' +
                '       </div>' +
                '   </div>' +
                '</div>');


			// Agregar opciones al select
            respuesta.forEach(function (item, index) {
                if (item.estado != 0) {
                    $("#producto_" + numProducto).append(
                        '<option idProducto="' + item.id + '" value="' + item.descripcion + '">' + item.descripcion + '</option>'
                    );
                }
            });

            // Inicializar Select2 en el nuevo select
            $('#producto_' + numProducto).select2({
                placeholder: "Seleccione el producto",
                width: '100%', // Ajustar el ancho según tu diseño
                templateSelection: function (data, container) {
                    // Calcular el ancho del contenedor padre
                    var maxWidth = container.css('width').replace('px', '');

                    // Calcular la cantidad de caracteres en función del ancho disponible
                    var maxLength = Math.floor(maxWidth / 10); // Ajusta este número según el tamaño de fuente y el espacio disponible

                    // Cortar el texto si es muy largo
                    return data.text.length > maxLength ? data.text.substring(0, maxLength) + '...' : data.text;
                }
            });

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

$(".formularioVenta").on("change", "select.nuevaDescripcionProducto", function () {

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
			$(nuevoPrecioProducto).val(respuesta["precio_venta"]);
			$(nuevoPrecioProducto).attr("precioReal", respuesta["precio_venta"]);

			// AGRUPAR PRODUCTOS EN FORMATO JSON

			listarProductos()

		}

	})
})

/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/

$(".formularioVenta").on("change", "input.nuevaCantidadProducto", function () {

	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var precioFinal = $(this).val() * precio.attr("precioReal");

	precio.val(precioFinal);

	var nuevoStock = Number($(this).attr("stock")) - $(this).val();

	$(this).attr("nuevoStock", nuevoStock);

	if (Number($(this).val()) > Number($(this).attr("stock"))) {

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/

		$(this).val(0);

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

	}

	// SUMAR TOTAL DE PRECIOS

	sumarTotalPrecios()

	// AGREGAR Descuento

	agregarDescuento()

	// AGRUPAR PRODUCTOS EN FORMATO JSON

	listarProductos()

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/

function sumarTotalPrecios() {

	var precioItem = $(".nuevoPrecioProducto");
	var arraySumaPrecio = [];

	for (var i = 0; i < precioItem.length; i++) {

		arraySumaPrecio.push(Number($(precioItem[i]).val()));

	}

	function sumaArrayPrecios(total, numero) {

		return total + numero;

	}

	var sumaTotalPrecio = arraySumaPrecio.reduce(sumaArrayPrecios);

	$("#nuevoTotalVenta").val(sumaTotalPrecio);
	$("#totalVenta").val(sumaTotalPrecio);
	$("#nuevoTotalVenta").attr("total", sumaTotalPrecio);


}

/*=============================================
FUNCIÓN AGREGAR Descuento
=============================================

function agregarDescuento(){

	var Descuento = $("#nuevoDescuentoVenta").val();
	var precioTotal = $("#nuevoTotalVenta").attr("total");

	var precioDescuento = Number(precioTotal * Descuento/100);

	var totalConDescuento = Number(precioTotal) - Number(precioDescuento);
	
	$("#nuevoTotalVenta").val(totalConDescuento);

	$("#totalVenta").val(totalConDescuento);

	$("#nuevoPrecioDescuento").val(precioDescuento);

	$("#nuevoPrecioNeto").val(precioTotal);

}

/*=============================================
CUANDO CAMBIA EL Descuento
=============================================*/



/*=============================================
FUNCIÓN AGREGAR Descuento
=============================================*/

function agregarDescuento() {

	var Descuento = $("#nuevoDescuentoVenta").val();
	var precioTotal = $("#nuevoTotalVenta").attr("total");

	var precioDescuento = Number(Descuento);

	var totalConDescuento = Number(precioTotal) - Number(precioDescuento);


	$("#nuevoTotalVenta").val(totalConDescuento);

	$("#totalVenta").val(totalConDescuento);

	$("#nuevoPrecioDescuento").val(precioDescuento);

	$("#nuevoPrecioNeto").val(precioTotal);

}

/*=============================================
CUANDO CAMBIA EL Descuento
=============================================*/







$("#nuevoDescuentoVenta").change(function () {

	agregarDescuento();

});

/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/

$("#nuevoTotalVenta").number(true, 2);
$("#nuevoDescuentoVenta").number(true, 2);
$("#nuevoPrecioDescuento").number(true, 2);

/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/

$("#nuevoMetodoPago").change(function () {

	var metodo = $(this).val();

	if (metodo == "Efectivo") {

		$(this).parent().parent().removeClass("col-xs-6");

		$(this).parent().parent().addClass("col-xs-4");

		$(this).parent().parent().parent().children(".cajasMetodoPago").html(

			'<div class="col-xs-4">' +

			'<div class="input-group">' +

			'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +

			'<input type="text" class="form-control" id="nuevoValorEfectivo" placeholder="000000" required>' +

			'</div>' +

			'</div>' +

			'<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">' +

			'<div class="input-group">' +

			'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>' +

			'<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>' +

			'</div>' +

			'</div>'

		)

		// Agregar formato al precio

		$('#nuevoValorEfectivo').number(true, 2);
		$('#nuevoCambioEfectivo').number(true, 2);


		// Listar método en la entrada
		listarMetodos()

	} else {

		$(this).parent().parent().removeClass('col-xs-4');

		$(this).parent().parent().addClass('col-xs-6');

		$(this).parent().parent().parent().children('.cajasMetodoPago').html(

			'<div class="col-xs-6" style="padding-left:0px">' +

			'<div class="input-group">' +

			'<input type="number" min="0" class="form-control" id="nuevoCodigoTransaccion" placeholder="Código transacción"  required>' +

			'<span class="input-group-addon"><i class="fa fa-lock"></i></span>' +

			'</div>' +

			'</div>')

	}



})


/*=============================================
SELECCIONAR TIPO VENTA
=============================================*/

$("#nuevoTipoVenta").change(function () {

	var tipo = $(this).val();

	if (tipo == "Venta") {

		$(this).parent().parent().removeClass('col-xs-4');

		$(this).parent().parent().addClass('col-xs-6');

		$(this).parent().parent().parent().children('.cajasTipoVenta').html(

			'<div class="col-xs-6" style="padding-left:0px">' +

			'<div class="input-group">' +

			'<span class="input-group-addon"><i class="fa fa-tags"></i></span>' +

			'<input type="text" class="form-control input-md" id="nuevoNombreVenta" name="nuevoNombreVenta" placeholder="Ingresa un nombre a esta venta">' +

			'</div>' +

			'</div>')

		listarTipoVenta()


	} else {

		$(this).parent().parent().removeClass('col-xs-6');

		$(this).parent().parent().addClass('col-xs-4');

		$(this).parent().parent().parent().children('.cajasTipoVenta').html(

			'<div class="col-xs-4"">' +

			'<div class="input-group">' +

			'<span class="input-group-addon"><i class="fa fa-tags"></i></span>' +

			'<input type="text" class="form-control input-md" id="nuevoNombreVenta" name="nuevoNombreVenta" placeholder="Nombre a esta venta">' +

			'</div>' +

			'</div>' +

			'<div class="col-xs-4" style="padding-left:0px">' +

			'<div class="input-group">' +

			'<span class="input-group-addon"><i class="fa fa-calendar"></i></span>' +

			'<input type="date" class="form-control input-md" id="nuevaFechaVencimiento" name="nuevaFechaVencimiento" required>' +

			'</div>' +

			'</div>'

		)
		Pfecha()
		listarTipoVenta()
		

	}



})


/*=============================================
SELECCIONAR TIPO COSTO
=============================================*/

$("#nuevoTipoCosto").change(function () {

	var tipo = $(this).val();

	if (tipo == "Costo") {

		$(this).parent().parent().removeClass('col-xs-4');

		$(this).parent().parent().addClass('col-xs-6');

		$(this).parent().parent().parent().children('.cajasTipoCosto').html(

			'<div class="col-xs-6" style="padding-left:0px">' +

			'<div class="input-group">' +

			'<span class="input-group-addon"><i class="fa fa-tags"></i></span>' +

			'<input type="text" class="form-control input-md" id="nuevoNombreCosto" name="nuevoNombreCosto" placeholder="Ingresa un nombre a esta costo">' +

			'</div>' +

			'</div>')

		listarTipoCosto()


	} else {

		$(this).parent().parent().removeClass('col-xs-6');

		$(this).parent().parent().addClass('col-xs-4');

		$(this).parent().parent().parent().children('.cajasTipoCosto').html(

			'<div class="col-xs-4"">' +

			'<div class="input-group">' +

			'<span class="input-group-addon"><i class="fa fa-tags"></i></span>' +

			'<input type="text" class="form-control input-md" id="nuevoNombreCosto" name="nuevoNombreCosto" placeholder="Nombre a esta costo">' +

			'</div>' +

			'</div>' +

			'<div class="col-xs-4" style="padding-left:0px">' +

			'<div class="input-group">' +

			'<span class="input-group-addon"><i class="fa fa-calendar"></i></span>' +

			'<input type="date" class="form-control input-md" id="nuevaFechaVencimientoc" name="nuevaFechaVencimientoc" required>' +

			'</div>' +

			'</div>'

		)
		PfechaC()
		listarTipoCosto()
		

	}



})



//Predeterminar fecha de vencimiento
function Pfecha() {
	// Obtén la fecha actual
	const fechaActual = new Date();

	// Agrega 30 días
	fechaActual.setDate(fechaActual.getDate() + 30);

	// Formatea la fecha en el formato YYYY-MM-DD (que es el formato de entrada "date" en HTML)
	const fechaFormateada = fechaActual.toISOString().split('T')[0];

	// Establece la fecha en el campo de entrada utilizando jQuery
	$('#nuevaFechaVencimiento').val(fechaFormateada);
}

//Predeterminar fecha de vencimiento
function PfechaC() {
	// Obtén la fecha actual
	const fechaActual = new Date();

	// Agrega 30 días
	fechaActual.setDate(fechaActual.getDate() + 30);

	// Formatea la fecha en el formato YYYY-MM-DD (que es el formato de entrada "date" en HTML)
	const fechaFormateada = fechaActual.toISOString().split('T')[0];

	// Establece la fecha en el campo de entrada utilizando jQuery
	$('#nuevaFechaVencimientoc').val(fechaFormateada);
}



/*=============================================
CAMBIO EN EFECTIVO
=============================================*/
$(".formularioVenta").on("change", "input#nuevoValorEfectivo", function () {

	var efectivo = $(this).val();

	var cambio = Number(efectivo) - Number($('#nuevoTotalVenta').val());

	var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');

	nuevoCambioEfectivo.val(cambio);

})

/*=============================================
CAMBIO TRANSACCIÓN
=============================================*/
$(".formularioVenta").on("change", "input#nuevoCodigoTransaccion", function () {

	// Listar método en la entrada
	listarMetodos()


})

/*=============================================
CAMBIO TIPO DE VENTA
=============================================*/
$(".formularioVenta").on("change", "input#nuevoNombreVenta", function () {

	// Listar método en la entrada
	listarTipoVenta()


})

$(".formularioVenta").on("change", "input#nuevaFechaVencimiento", function () {

	// Listar método en la entrada
	listarTipoVenta()


})

/*=============================================
CAMBIO TIPO COSTO
=============================================*/
$(".formularioSurtirInventario").on("change", "input#nuevoNombreVentac", function () {

	// Listar método en la entrada
	listarTipoVenta()


})

$(".formularioSurtirInventario").on("change", "input#nuevaFechaVencimientoc", function () {

	// Listar método en la entrada
	listarTipoCosto()


})



/*=============================================
LISTAR TODOS LOS PRODUCTOS
=============================================*/

function listarProductos() {

	var listaProductos = [];

	var descripcion = $(".nuevaDescripcionProducto");

	var cantidad = $(".nuevaCantidadProducto");

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
LISTAR MÉTODO DE PAGO
=============================================*/

function listarMetodos() {

	var listaMetodos = "";

	if ($("#nuevoMetodoPago").val() == "Efectivo") {

		$("#listaMetodoPago").val("Efectivo");

	} else {

		$("#listaMetodoPago").val($("#nuevoMetodoPago").val() + "-" + $("#nuevoCodigoTransaccion").val());

	}

}


/*=============================================
LISTAR TIPO DE VENTA
=============================================*/

function listarTipoVenta() {

	var listaTipos = "";

	if ($("#nuevoTipoVenta").val() == "Venta") {

		$("#listaTipoVenta").val("Venta");
		$("#listaNombreVenta").val($("#nuevoNombreVenta").val());

	} else {

		$("#listaTipoVenta").val("Alquiler");
		$("#listaNombreVenta").val($("#nuevoNombreVenta").val());
		$("#listaVencimiento").val($("#nuevaFechaVencimiento").val());

	}

}

/*=============================================
LISTAR TIPO DE COSTO
=============================================*/

function listarTipoCosto() {

	var listaTipos = "";

	if ($("#nuevoTipoCosto").val() == "Costo") {

		$("#listaTipoCosto").val("Costo");
		$("#listaNombreCosto").val($("#nuevoNombreCosto").val());

	} else {

		$("#listaTipoCosto").val("Alquiler");
		$("#listaNombreCosto").val($("#nuevoNombreCosto").val());
		$("#listaVencimientoc").val($("#nuevaFechaVencimientoc").val());

	}

}


/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablaVentasListado").on("click", ".btnEditarVenta", function () {

	var idVenta = $(this).attr("idVenta");

	//console.log("idVenta", idVenta);

	//window.location = "index.php?ruta=editar-venta&idVenta=" + idVenta;


})



/*=============================================
BOTON RENOVAR VENTA
=============================================*/
$(".tablaAlquiler").on("click", ".btnRenovarVenta", function () {

	var idVenta = $(this).attr("idVenta");

	window.location = "index.php?ruta=renovar-venta&idVenta=" + idVenta;


})

/*=============================================
BOTON GUARDAR RENOVAR VENTA
=============================================*/

$(document).ready(function () {
	$("#btnRventa").click(function () {

		// Obtén el valor del parámetro idVenta de la URL
		var parametros = new URLSearchParams(window.location.search);
		var idVenta = parametros.get('idVenta');

		var estadoVenta = $(this).attr("estadoVenta");

		var datos = new FormData();
		datos.append("activarIdVenta", idVenta);
		datos.append("activarVenta", estadoVenta);


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
$(".tablaAlquiler").on("click", ".btnDevolverVenta", function () {

	var idVenta = $(this).attr("idVenta");
	var estadoVenta = $(this).attr("estadoVenta");

	var datos = new FormData();
	datos.append("activarIdVenta", idVenta);
	datos.append("activarVenta", estadoVenta);


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
					window.location = "index.php?ruta=rentas&idVenta=" + idVenta;
					//window.location = "rentas";


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




/*=============================================
ENVIAR MENSAJE DE RECORDATORIO AL CLIENTE
=============================================*/

$(".tablaAlquiler").on("click", ".btnContactar", function () {
	//Obtener nombre cliente
	var nombreC = $(this).attr("nCliente");
	// Divide el texto en palabras
	var palabras = nombreC.split(' ');
	// Verifica si hay más de una palabra (nombre y apellido)
	if (palabras.length > 1) {
		// Toma solo la primera palabra, que es el nombre
		var nombre = palabras[0];
	}

	//Obtener telefono de cliente
	var telefono = $(this).attr("cCliente");

	var productoC = $(this).attr("producto");

	var palabras = productoC.split(' ');
	// Verifica si hay más de una palabra (nombre y apellido)
	if (palabras.length > 1) {
		// Toma solo la primera palabra, que es el nombre
		var producto = palabras[0];
	}

	// Convertir fecha a formato largo
	// Fecha original en formato "2023-08-22 09:24:00"
	var fechaOriginal = $(this).attr("fVencimiento");

	// Parsea la fecha original en un objeto Date
	var fecha = new Date(fechaOriginal);

	// Obtiene el día, mes y año de la fecha
	var dia = fecha.getDate();
	var mes = fecha.getMonth() + 1; // Nota: Los meses en JavaScript se indexan desde 0
	var año = fecha.getFullYear();

	// Función para obtener el nombre del mes a partir de su número
	function obtenerNombreMes(numeroMes) {
		var meses = [
			"enero", "febrero", "marzo", "abril", "mayo", "junio",
			"julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
		];
		return meses[numeroMes - 1];
	}

	// Formatea la fecha en el nuevo formato
	var fechaFormateada = dia + " de " + obtenerNombreMes(mes) + " de " + año;

	var mensaje = 'Hola,' + ' ' + nombre + ' ' + '¿cómo estás?. El ' + fechaFormateada + ' ha vencido tu suscripción a ' + producto + ', renueva hoy y sigue disfrutando de tu contenido favorito. Puedes realizar el pago por Nequi al siguiente numero: 3008892255';
	var url = 'https://api.whatsapp.com/send?phone=' + "57" + telefono + '&text=' + encodeURIComponent(mensaje);
	window.open(url, '_blank');
});





/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarProducto() {

	//Capturamos todos los id de productos que fueron elegidos en la venta
	var idProductos = $(".quitarProducto");

	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaVentas tbody button.agregarProducto");

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

$('.tablaVentas').on('draw.dt', function () {

	quitarAgregarProducto();

})



/*=============================================
BORRAR VENTA
=============================================*/
$(".tablaVentasListado").on("click", ".btnEliminarVenta", function () {

	var idVenta = $(this).attr("idVenta");

	swal({
		title: '¿Está seguro de borrar la venta?',
		text: "¡Si no lo está puede cancelar la accíón!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, borrar venta!'
	}).then(function (result) {
		if (result.value) {

			window.location = "index.php?ruta=ventas&idVenta=" + idVenta;
		}

	})

})



$(document).ready(function() {
    // Definir fechas predeterminadas
    var startDate = moment().subtract(29, 'days'); // Últimos 30 días
    var endDate = moment(); // Hoy

    // Inicializar el DataTable
    var tablaCostos = $('.tablaCostos').DataTable({
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

	// Inicializar el DataTable
    var tablaVentas = $('.tablaVentasListado').DataTable({
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

	// Inicializar el DataTable
    var tablaGastos = $('.tablaGastos').DataTable({
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


    // Inicializar el daterangepicker
    $("#daterange-btn").daterangepicker(
        {
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                'Este mes': [moment().startOf('month'), moment().endOf('month')],
                'Último mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				//'Este año': [moment().startOf('year'), moment()],
                //'Último año': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            },
            startDate: startDate,
            endDate: endDate
        },
        function(start, end) {
            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

            var fechaInicial = start.format('YYYY-MM-DD');
            var fechaFinal = end.format('YYYY-MM-DD');

            // Actualiza la configuración del DataTable para que use los nuevos parámetros de fecha
            tablaVentas.ajax.url('ajax/datatable-ventaslistado.ajax.php?fechaInicial=' + fechaInicial + '&fechaFinal=' + fechaFinal).load();
			tablaCostos.ajax.url('ajax/datatable-costos.ajax.php?fechaInicial=' + fechaInicial + '&fechaFinal=' + fechaFinal).load();
			tablaGastos.ajax.url('ajax/datatable-gastos.ajax.php?fechaInicial=' + fechaInicial + '&fechaFinal=' + fechaFinal).load();

			// Depura la respuesta del servidor en la consola
			//console.log("Respuesta del servidor:", tablaCostos);
        }
		
    );

	/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function () {

	localStorage.removeItem("capturarRango");
	localStorage.clear();
	window.location = "ventas";
})

    // Configurar el texto inicial del botón con las fechas predeterminadas
    $('#daterange-btn span').html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));

    // Cargar la tabla con el rango de fechas predeterminado al cargar la página
	tablaVentas.ajax.url('ajax/datatable-ventaslistado.ajax.php?fechaInicial=' + startDate.format('YYYY-MM-DD') + '&fechaFinal=' + endDate.format('YYYY-MM-DD')).load();
	tablaCostos.ajax.url('ajax/datatable-costos.ajax.php?fechaInicial=' + startDate.format('YYYY-MM-DD') + '&fechaFinal=' + endDate.format('YYYY-MM-DD')).load();
    tablaGastos.ajax.url('ajax/datatable-gastos.ajax.php?fechaInicial=' + startDate.format('YYYY-MM-DD') + '&fechaFinal=' + endDate.format('YYYY-MM-DD')).load();
});


/*=============================================
IMPRIMIR FACTURA
=============================================*/
$(".tablaVentasListado").on("click", ".btnImprimirVenta", function () {

	var codigoVenta = $(this).attr("codigoVenta");

	window.open("extensiones/tcpdf/pdf/factura.php?codigo="+codigoVenta, "_blank");


})





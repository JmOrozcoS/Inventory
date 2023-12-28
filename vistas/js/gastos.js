

$(document).ready(function () {
  // Inicializar el select con Select2 
  $("#nuevoProveedor").select2({
    placeholder: "Selecionar proveedor (Opcional)" // Texto del placeholder
  });
   
});

/*=============================================
EDITAR PRODUCTO
=============================================*/

$(".tablas").on("click", ".btnEditarGasto", function () {

  var idGasto = $(this).attr("idGasto");

  //console.log("idGasto", idGasto);

  var datos = new FormData();
  datos.append("idGasto", idGasto);


  $.ajax({

    url: "ajax/gastos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {

      //console.log("respuesta", respuesta);

      var datosProveedor = new FormData();
      datosProveedor.append("idProveedor", respuesta["id_proveedor"]);

      $.ajax({

        url: "ajax/proveedores.ajax.php",
        method: "POST",
        data: datosProveedor,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta2) {

          //console.log("respuesta2", respuesta2);

          $("#editarProveedor").val(respuesta2["id"]);
          $("#editarProveedor").html(respuesta2["nombre"]);

          $(" .select2editarProveedor").select2();

        }

      })

      $("#idGasto").val(respuesta["id"]);
      $("#editarCategoriaG").html(respuesta["categoria"]);
      $("#editarCategoriaG").val(respuesta["categoria"]);
      $("#editarMonto").val(respuesta["monto"]);
      $("#editarConcepto").val(respuesta["nombre_gasto"]);
      $("#editarMpago").html(respuesta["forma_pago"]);
      $("#editarMpago").val(respuesta["forma_pago"]);

    }

  })

})



/*=============================================
ELIMINAR GASTO
=============================================*/
$(".tablas").on("click", ".btnEliminarGasto", function () {

  var idGasto = $(this).attr("idGasto");

  swal({
    title: '¿Está seguro de borrar el registro?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar gasto!'
  }).then(function (result) {
    if (result.value) {

      window.location = "index.php?ruta=ventas&idGasto=" + idGasto;
    }

  })

})
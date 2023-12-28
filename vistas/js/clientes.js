/*=============================================
EDITAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEditarCliente", function () {

  var idCliente = $(this).attr("idCliente");

  var datos = new FormData();
  datos.append("idCliente", idCliente);

  $.ajax({

    url: "ajax/clientes.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {

      $("#idCliente").val(respuesta["id"]);
      $("#editarCliente").val(respuesta["nombre"]);
      $("#editarDocumentoId").val(respuesta["documento"]);
      $("#editarEmail").val(respuesta["email"]);
      $("#editarTelefono").val(respuesta["telefono"]);
      $("#editarDireccion").val(respuesta["direccion"]);
      $("#editarFechaNacimiento").val(respuesta["fecha_nacimiento"]);
    }

  })

})

/*=============================================
ELIMINAR CLIENTE
=============================================*/
$(".tablas").on("click", ".btnEliminarCliente", function () {

  var idCliente = $(this).attr("idCliente");

  swal({
    title: '¿Está seguro de borrar el cliente?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar cliente!'
  }).then(function (result) {
    if (result.value) {

      window.location = "index.php?ruta=clientes&idCliente=" + idCliente;
    }

  })

})

/*=============================================
VALIDAR INGRESO DE CORREO EN TIEMPO REAL
=============================================*/
$(document).ready(function () {
  $("#nuevoEmail").on("input", function () {
    var email = $(this).val();
    var emailPattern = /^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/;

    if (!emailPattern.test(email)) {
      $("#errorEmail").text("Correo no válido");
    } else {
      $("#errorEmail").text(""); // Borra el mensaje de error si el correo es válido
    }
  });
});

/*=============================================
VALIDAR INGRESO DE CORREO EN TIEMPO REAL AL EDITAR
=============================================*/
$(document).ready(function () {
  $("#editarEmail").on("input", function () {
    var email = $(this).val();
    var emailPattern = /^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/;

    if (!emailPattern.test(email)) {
      $("#errorNombreECL").text("Correo no válido");
    } else {
      $("#errorNombreECL").text(""); // Borra el mensaje de error si el correo es válido
    }
  });
});


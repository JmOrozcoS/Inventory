

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
      $("#editarTipoGasto").html(respuesta["tipo_registro"]);
      $("#editarTipoGasto").val(respuesta["tipo_registro"]);
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


/*=============================================
SELECT TIPO DE REGISTRO
=============================================*/
$(document).ready(function() {
  $('#nuevoTipoGasto').change(function() {
      var pais = $(this).val();

      //console.log("pais", pais);

      // Limpiar las opciones existentes
      $('#nuevaCategoriaG').empty();
      $('#nuevoMonto').val('');

      if (pais == 'Gasto') {

        $('#nuevoMonto').change(function() {
            var valor = $(this).val();
            var numero = parseFloat(valor);
            
            // Si el número es positivo, cambia su signo a negativo
            if (numero < 0) {
                $(this).val(-numero);
            }
        });


        $('#nuevoMonto').attr('min', '0');
        $('#nuevaCategoriaG').append('<option value="" selected>Selecionar categoría</option>');
          $('#nuevaCategoriaG').append('<option value="Productos e insumos">Productos e insumos</option>');
          $('#nuevaCategoriaG').append('<option value="Servicios públicos">Servicios públicos</option>');
          $('#nuevaCategoriaG').append('<option value="Arriendo">Arriendo</option>');
          $('#nuevaCategoriaG').append('<option value="Nómina">Nómina</option>');
          $('#nuevaCategoriaG').append('<option value="Publicidad">Publicidad</option>');
          $('#nuevaCategoriaG').append('<option value="Impuestos">Impuestos</option>');
          $('#nuevaCategoriaG').append('<option value="Otro">Otro</option>');

      } else if (pais == 'Ingreso') {

        // Limpiar las opciones existentes
        $('#nuevaCategoriaG').empty();
        $('#nuevoMonto').val('');

        $('#nuevoMonto').change(function() {
          var valor = $(this).val();
          var numero = parseFloat(valor);
          
          // Si el número es positivo, cambia su signo a negativo
          if (numero > 0) {
              $(this).val(-numero);
          }
        });

          $('#nuevoMonto').removeAttr('min');
          $('#nuevaCategoriaG').append('<option value="" selected>Selecionar categoría</option>');
          $('#nuevaCategoriaG').append('<option value="Servicios/Honorarios">Servicios/Honorarios</option>');
          $('#nuevaCategoriaG').append('<option value="Ingresosfinancieros">Ingresos financieros</option>');
          $('#nuevaCategoriaG').append('<option value="Propiedad intelectual">Propiedad intelectual</option>');
          $('#nuevaCategoriaG').append('<option value="Otros ingresos">Otros ingresos</option>');
          

      }
  });
});


/*=============================================
EDITAR TIPO DE REGISTRO
=============================================*/
$(document).ready(function() {
  $('[name="editarTipoGasto"]').change(function() {
      var editC = $(this).val();
   
      console.log("editC", editC);

      // Limpiar las opciones existentes
      $('[name="editarCategoriaG"]').empty();
      $('[name="editarMonto"]').val('');

      if (editC == 'Gasto') {

        $('[name="editarMonto"]').change(function() {
            var valor = $(this).val();
            var numero = parseFloat(valor);
            
            // Si el número es positivo, cambia su signo a negativo
            if (numero < 0) {
                $(this).val(-numero);
            }
        });


        $('[name="editarMonto"]').attr('min', '0');
        $('[name="editarCategoriaG"]').append('<option value="" selected>Selecionar categoría</option>');
          $('[name="editarCategoriaG"]').append('<option value="Productos e insumos">Productos e insumos</option>');
          $('[name="editarCategoriaG"]').append('<option value="Servicios públicos">Servicios públicos</option>');
          $('[name="editarCategoriaG"]').append('<option value="Arriendo">Arriendo</option>');
          $('[name="editarCategoriaG"]').append('<option value="Nómina">Nómina</option>');
          $('[name="editarCategoriaG"]').append('<option value="Publicidad">Publicidad</option>');
          $('[name="editarCategoriaG"]').append('<option value="Impuestos">Impuestos</option>');
          $('[name="editarCategoriaG"]').append('<option value="Otro">Otro</option>');

      } else if (editC == 'Ingreso') {

        // Limpiar las opciones existentes
        $('[name="editarCategoriaG"]').empty();
        $('[name="editarMonto"]').val('');

        $('[name="editarMonto"]').change(function() {
          var valor = $(this).val();
          var numero = parseFloat(valor);
          
          // Si el número es positivo, cambia su signo a negativo
          if (numero > 0) {
              $(this).val(-numero);
          }
        });

          $('[name="editarMonto"]').removeAttr('min');
          $('[name="editarCategoriaG"]').append('<option value="" selected>Selecionar categoría</option>');
          $('[name="editarCategoriaG"]').append('<option value="Servicios/Honorarios">Servicios/Honorarios</option>');
          $('[name="editarCategoriaG"]').append('<option value="Ingresosfinancieros">Ingresos financieros</option>');
          $('[name="editarCategoriaG"]').append('<option value="Propiedad intelectual">Propiedad intelectual</option>');
          $('[name="editarCategoriaG"]').append('<option value="Otros ingresos">Otros ingresos</option>');
          

      }
  });
});



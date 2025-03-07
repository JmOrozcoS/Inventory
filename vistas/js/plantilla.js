/*=============================================
SideBar Menu
=============================================*/

$('.sidebar-menu').tree()

$(document).ready(function() {
    
    // Ajustar el sidebar en función del tamaño de la pantalla
    $(window).on('resize', function() {
      if ($(window).width() < 768) { // Ajusta el umbral según tu diseño
		$('body').removeClass('sidebar-collapse');
      } else {
        $('body').addClass('sidebar-collapse');
      }
    }).trigger('resize'); // Llama para aplicar el ajuste al cargar
  });

/*=============================================
Logo
=============================================*/

$(document).ready(function() {
	
    function checkWidth() {

		//oculta el logo en función del tamaño de la pantalla
        if ($(window).width() <= 767) {
            $('.logo').hide();
        } else {
            $('.logo').show();
        }
    }

    // Ejecuta la función al cargar la página
    checkWidth();

    // Ejecuta la función cada vez que la ventana cambie de tamaño
    $(window).resize(checkWidth);
});


/*=============================================
Data Table
=============================================*/

$(".tablas").DataTable({

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

});

/*=============================================
 //iCheck for checkbox and radio inputs
=============================================*/

$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
  checkboxClass: 'icheckbox_minimal-blue',
  radioClass   : 'iradio_minimal-blue'
})

/*=============================================
 //input Mask
=============================================*/

//Datemask dd/mm/yyyy
$('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
//Datemask2 mm/dd/yyyy
$('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
//Money Euro
$('[data-mask]').inputmask()

/*=============================================
 //OCULTAR IMAGEN CUANDO LA RESOLUCION SEA INFERIOR A 768PX
=============================================
$(document).ready(function () {
	// Función para ocultar la imagen en dispositivos con pantalla <= 768px
	function hideLogoOnSmallScreen() {
		if ($(window).width() <= 768) {
			$(" .logo").hide();
		} else { $(".logo").show(); }
	} // Llama a la función al cargar la página
	hideLogoOnSmallScreen(); // Llama a la función cada vez que se redimensiona la ventana
	$(window).resize(function () { hideLogoOnSmallScreen(); });
});*/
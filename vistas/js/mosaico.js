/*=============================================
PAGINACION DE MOSAICO
=============================================*/

$(document).ready(function () {
    const $mosaico = $(".mosaico .producto");
    const $prevPageButton = $("#prevPage");
    const $nextPageButton = $("#nextPage");
    const productsPerPage = 6; // Cambia esto según la cantidad de productos por página
    let currentPage = 1;

    function showPage(page) {
        $mosaico.fadeOut(200, function () {
            $mosaico.hide();
            $mosaico.slice((page - 1) * productsPerPage, page * productsPerPage).fadeIn(200);
        });
    }

    function updateButtons() {
        $prevPageButton.prop("disabled", currentPage === 1);
        $nextPageButton.prop("disabled", currentPage === Math.ceil($mosaico.length / productsPerPage));
    }

    $prevPageButton.on("click", function () {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
            updateButtons();
        }
    });

    $nextPageButton.on("click", function () {
        if (currentPage < Math.ceil($mosaico.length / productsPerPage)) {
            currentPage++;
            showPage(currentPage);
            updateButtons();
        }
    });

    // Mostrar la primera página inicialmente
    showPage(currentPage);
    updateButtons();
});



/*=============================================
BOTON MOSTRAR U OCULTAR VISTA DE MOSAICO
=============================================*/


/*$(document).ready(function () {
    const $tablaProductos = $("#tablaProductos");
    const $mosaicoProductos = $("#mosaicoProductos");
    const $toggleButton = $("#toggleButton");

    $toggleButton.on("click", function () {
        if ($tablaProductos.is(":visible")) {
            $tablaProductos.hide();
            $mosaicoProductos.show();
        } else {
            $tablaProductos.show();
            $mosaicoProductos.hide();
        }
    });
});*/



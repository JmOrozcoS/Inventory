<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Administrar Productos

    </h1>
    <ol class="breadcrumb">
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Administrar productos</li>
    </ol>
  </section>

  <section class="content">

    <div class="box">
      <div class="box-header with-border">

        <a href="productos">
        <button class="btn btn-primary pull-right" id="toggleButton"><i
            class="fa fa-th"></i>

            Cambiar Vista

        </button>
        </a>


        <!--=====================================
                
                <button class="btn btn-vk" data-toggle="modal" data-target="#modalAgregarCategoria"> <i class="fa fa-th"></i>

                    Agregar Categoría

                </button>

                

                <a href="categorias">
                <button class="btn btn-vk"> <i class="fa fa-pencil-square-o"></i> Editar Categoría</button>
                </a> 

                ======================================-->


      </div>

      <div class="box-body">


        <div class="mosaico">


          <?php

          $item = null;
          $valor = null;

          $productos = ControladorProductos::ctrMostrarProductos($item, $valor);

          foreach ($productos as $key => $value) {


            echo '<div class="producto">
            <img src="' . $value["imagen"] . '" alt="' . $value["precio_venta"] . '">
            <h2>$ ' . number_format($value["precio_venta"], 2) . '</h2>';

            $itemC = "id";
            $valorC = $value["id_categoria"];

            $categorias = ControladorCategorias::ctrMostrarCategorias($itemC, $valorC);

            echo '<h2>' . $categorias["categoria"] . '</h2>
            <p>' . $value["codigo"] . '</p>';

            if ($value["stock"] <= 2) {
              echo '<p style="color: red;">' . $value["stock"] . ' disponibles</p>';

            } elseif ($value["stock"] > 2 && $value["stock"] <= 4) {
              echo '<p style="color: orange;">' . $value["stock"] . ' disponibles</p>';
            } else {
              echo '<p style="color: green;">' . $value["stock"] . ' disponibles</p>';
            }



            echo '</div>';

          }


          ?>

        </div>

        <div class="pagination">

          <button id="prevPage">Anterior</button>
          <button id="nextPage">Siguiente</button>


        </div>

      </div>

  </section>

</div>


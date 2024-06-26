<?php

if($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      Reportes de ventas
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Reportes de ventas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <div class="input-group">

          <button type="button" class="btn btn-default" id="daterange-btn2">
           
            <span>
              <i class="fa fa-calendar"></i> Rango de fecha
            </span>

            <i class="fa fa-caret-down"></i>

          </button>

        </div>

        <div class="box-tools pull-right">

        <?php

        if(isset($_GET["fechaInicial"])){

          echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'">';

        }else{

           echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte">';

        }         

        ?>
           
           <button class="btn btn-success" style="margin-top:5px">Descargar reporte en Excel</button>

          </a>

        </div>
         
      </div>

      <div class="box-body">
        <!-- ./box-body -->
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-4 col-xs-4">
              <div class="description-block border-right">
                <!-- <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 17%</span>-->

                <?php
                if (isset($_GET["fechaInicial"])) {

                  $fechaInicial = $_GET["fechaInicial"];
                  $fechaFinal = $_GET["fechaFinal"];

                } else {

                  $fechaInicial = null;
                  $fechaFinal = null;

                }

                $respuesta = ControladorVentas::ctrSumaTVentas($fechaInicial, $fechaFinal);

                foreach ($respuesta as $key => $value1) {

                  $totalVentas = $value1["total_ventas"];
                }

                $respuesta2 = ControladorCostos::ctrSumaTCostos($fechaInicial, $fechaFinal);

                foreach ($respuesta2 as $key => $value2) {

                  $totalCompras = $value2["total_costos"];
                }

                $respuesta3 = ControladorGastos::ctrSumaTGastos($fechaInicial, $fechaFinal);

                foreach ($respuesta3 as $key => $value3) {

                  $totalGastos = $value3["total_gastos"];
                }

                // Realizar la suma total
                $sumaTotal = $totalVentas - $totalCompras - $totalGastos;

                $sumaFormateado = number_format($sumaTotal, 2, '.', ',');

                if ($sumaTotal <= 0) {
                  echo '<h5 class="description-header text-red">$' . $sumaFormateado . '</h5>';
                } else {
                  echo '<h5 class="description-header text-green">$' . $sumaFormateado . '</h5>';
                }

                ?>


                <span class="description-text">Balance</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-xs-4">
              <div class="description-block border-right">
                <!-- <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 90%</span>-->
                <h5 class="description-header">
                  <?php

                  $valorFormateadoVentas = number_format($totalVentas, 2, '.', ',');
                  echo "$" . $valorFormateadoVentas;

                  ?>

                </h5>
                <span class="description-text">Total Ventas</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 col-xs-4">
              <div class="description-block border-right">
                <!-- <span class="description-percentage text-red"><i class="fa fa-caret-up"></i> 20%</span>-->
                <h5 class="description-header">

                  <?php


                  $sumaTotal2 = $totalCompras + $totalGastos;

                  $sumaFormateado2 = number_format($sumaTotal2, 2, '.', ',');

                  echo "$" . $sumaFormateado2;


                  ?>


                </h5>
                <span class="description-text">Costos/Gastos</span>
              </div>
              <!-- /.description-block -->
            </div>

          </div>
          <!-- /.row -->
        </div>

      </div>
        
        <div class="row">

          <div class="col-xs-12">
            
            <?php

            include "reportes/grafico-ventas.php";

            ?>

          </div>

           <div class="col-md-6 col-xs-12">
             
            <?php

            include "reportes/productos-mas-vendidos.php";

            ?>

           </div>

            <div class="col-md-6 col-xs-12">
             
            <?php

            include "reportes/compradores.php";

            ?>

           </div>

           <div class="col-md-6 col-xs-12">
             
            <?php

            include "reportes/vendedores.php";            

            ?>

           </div>
          
        </div>

      </div>
      
    </div>

  </section>
 
 </div>

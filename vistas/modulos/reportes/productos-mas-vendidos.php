<style>
    .custom-badge {
        padding: 5px 10px;
        /* Ajusta el padding según tus necesidades */
        /* color: white; /* Color del texto */
        background-color: #ECF0F5;
        /* Color de fondo */
        border-radius: 5px;
        /* Bordes redondeados */
    }
</style>

<?php
$item = null;
$valor = null;

$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
$totalCategorias = count($categorias);


$colores = array("red", "blue", "purple", "aqua", "orange", "blue", "magenta", "green", "cyan", "yellow", "gold");

$totalVentas = ControladorProductos::ctrMostrarSumaVentas();
$VentasCategorias = ControladorProductos::ctrVentasCategorias();



?>

<!--=====================================
PRODUCTOS MÁS VENDIDOS
======================================-->

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Categorías más vendidas</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12 col-md-5">
                <div class="chart-legend clearfix nav nav-pills nav-stacked">
                    <?php
                    for ($i = 0; $i < min(6, $totalCategorias); $i++) {
                        echo '<li>
                                <a style="display: flex; align-items: center;">
                                    <img src="' . $VentasCategorias[$i]["imagen"] . '" class="product-img" width="50px" style="margin-right:10px">
                                    <span>' . $VentasCategorias[$i]["categoria"] . '</span>
                                    <span class="badge custom-badge pull-right text-' . $colores[$i] . '">
                                        ' . ceil($VentasCategorias[$i]["total_ventas"] * 100 / $totalVentas["total"]) . '%
                                    </span>
                                </a>
                            </li>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-xs-12 col-md-7">
                <div class="chart-responsive">
                    <canvas id="pieChart" height="190"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


<script>


    // -------------
    // - PIE CHART -
    // -------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [

        <?php

        for ($i = 0; $i < min(6, $totalCategorias); $i++) {

            echo "{
      value    : " . $VentasCategorias[$i]["total_ventas"] . ",
      color    : '" . $colores[$i] . "',
      highlight: '" . $colores[$i] . "',
      label    : '" . $VentasCategorias[$i]["categoria"] . "'
    },";

        }

        ?>
    ];
    var pieOptions = {
        // Boolean - Whether we should show a stroke on each segment
        segmentShowStroke: true,
        // String - The colour of each segment stroke
        segmentStrokeColor: '#fff',
        // Number - The width of each segment stroke
        segmentStrokeWidth: 1,
        // Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        // Number - Amount of animation steps
        animationSteps: 100,
        // String - Animation easing effect
        animationEasing: 'easeOutBounce',
        // Boolean - Whether we animate the rotation of the Doughnut
        animateRotate: true,
        // Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale: false,
        // Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: false,
        // String - A legend template
        legendTemplate: '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
        // String - A tooltip template
        tooltipTemplate: '<%=value %> <%=label%>'
    };
    // Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
    // -----------------
    // - END PIE CHART -
    // -----------------


</script>
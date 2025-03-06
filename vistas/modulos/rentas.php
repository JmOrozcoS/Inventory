<div class="content-wrapper">

  <section class="content-header">

    <h1>

      Administrar alquileres

    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Administrar alquileres</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">

        <a href="crear-venta">

          <button class="btn styleVenta"><i class="fa fa-cart-plus"></i>

            Agregar venta

          </button>

        </a> 

        <div class="pull-right input-group">
          
          <select class="btn primary" id="estados-select" name="estados-select">

            <option value="todos" selected>Todos</option>
            <option value="vencido">VENCIDO</option>
            <option value="por vencer">Por vencer</option>
            <option value="vigente">Vigente</option>
            <option value="renovado">Renovado</option>
            <option value="devuelto">Devuelto</option>
          </select>

        </div>
      </div>
      
      <!-- Mantener el color blanco del texto del select -->
      <script>
          document.addEventListener('DOMContentLoaded', function () {
            var select = document.querySelector('select');
            select.addEventListener('mouseover', function () {
              select.style.color = 'white';
            });
            select.addEventListener('mouseout', function () {
              select.style.color = 'white';
            });
          });
        </script>


      <div class="box-body">

        <table class="table dt-responsive tablaAlquiler tabla-redondeada" width="100%">

          <thead>

            <tr>

              <th style="width:10px"><i class="fa fa-hashtag"></i></th>
              <th><i class="fa fa-id-card-o"></i> factura</th>
              <th><i class="fa fa-user"></i> Cliente</th>
              <th><i class="fa fa-product-hunt"></i> Productos</th>
              <th><i class="fa fa-money"></i> Total</th>
              <th><i class="fa fa-file-text-o"></i> Comentario</th>
              <th><i class="fa fa-calendar-check-o"></i> Fecha Vencimiento</th>
              <th><i class="fa fa-hourglass-2"></i> Estado</th>
              <th><i class="fa fa-pencil-square-o"></i>Acciones</th>

            </tr>

          </thead>

          

        </table>

        <?php
        $DevolverVenta = new ControladorVentas();
        $DevolverVenta->ctrDevolverVenta();
        ?>


      </div>

    </div>

  </section>

</div>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="active">
                <a href="inicio">
                    <i class="fa fa-home"></i>
                    <span>Inicio</span>

                </a>
            </li>

            <?php

            if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Sub-Administrador") {

                echo '<li class="treeview">
                <a href="">
                    <i class="fa fa-briefcase"></i>
                    <span>Inventario</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>

                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="productos">
                            <i class="fa fa-cube"></i>
                            <span>Productos</span>

                        </a>
                    </li>
                    <li>
                        <a href="surtir-inventario">
                            <i class="fa fa-cart-plus"></i>
                            <span>Surtir inventario</span>

                        </a>
                    </li>
                </ul>
            </li>';

            }


            if ($_SESSION["perfil"] == "Vendedor") {

                echo '<li class="treeview">
                <a href="">
                    <i class="fa fa-briefcase"></i>
                    <span>Inventario</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>

                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="productos">
                            <i class="fa fa-cube"></i>
                            <span>Productos</span>

                        </a>
                    </li>
                </ul>
            </li>';

            }
            ?>


            <!--==
            <li>
                <a href="categorias">
                    <i class="fa fa-th"></i>
                        <span>Categorias</span>
                </a>
            </li>

            <li>
                <a href="productos">
                    <i class="fa fa-cube"></i>
                        <span>Productos</span>

                </a>
            </li>

            =-->

            <li class="treeview">
                <a href="">
                    <i class="fa fa-list-alt"></i>
                    <span>Movimientos</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>

                </a>
                <ul class="treeview-menu">

                    <li>
                        <a href="rentas">
                            <i class="fa fa-retweet"></i>
                            <span>Gestion de alquiler</span>
                        </a>

                    </li>
                    <li>
                        <a href="ventas">
                            <i class="fa fa-line-chart"></i>
                            <span>Aministrar ventas</span>
                        </a>

                    </li>

                    <li>
                        <a href="reportes">
                            <i class="fa fa-pie-chart"></i>
                            <span>Reporte de ventas</span>
                        </a>

                    </li>
                </ul>
            </li>

            <li>
                <a href="clientes">
                    <i class="fa fa-users"></i>
                    <span>Clientes</span>

                </a>
            </li>

            <?php
            if ($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Sub-Administrador") {
                echo
                    '<li>
                <a href="proveedores">
                    <i class="fa fa-truck"></i>
                    <span>Proveedores</span>

                </a>
            </li>';
            }


            if ($_SESSION["perfil"] == "Administrador") {
                echo
                    '<li>
                    <a href="usuarios">
                        <i class="fa fa-user"></i>
                        <span>Usuarios</span>
                    </a>
                </li>';
            }
            ?>

        </ul>

    </section>

</aside>
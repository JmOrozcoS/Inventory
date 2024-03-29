-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-03-2024 a las 16:25:33
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventory`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_crea` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `fecha`, `fecha_crea`) VALUES
(1, 'CAT PRUEBA', '2024-03-24 18:32:17', '2024-03-24 13:32:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `documento` int(11) NOT NULL,
  `email` text NOT NULL,
  `telefono` text NOT NULL,
  `direccion` text NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `compras` int(11) NOT NULL,
  `ultima_compra` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_crea` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `documento`, `email`, `telefono`, `direccion`, `fecha_nacimiento`, `compras`, `ultima_compra`, `fecha`, `fecha_crea`) VALUES
(1, 'Cliente de rueba', 123456789, 'cp@gmail.com', '(300) 456-7473', 'calle', '2000-01-01', 32, '2024-03-29 00:35:21', '2024-03-29 05:35:21', '2024-03-28 17:12:40');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costos`
--

CREATE TABLE `costos` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `productos` text NOT NULL,
  `descuento` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text NOT NULL,
  `nombre_costo` text NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_crea` datetime DEFAULT NULL,
  `vencimiento` datetime DEFAULT NULL,
  `estado` text NOT NULL,
  `tipo_costo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `costos`
--

INSERT INTO `costos` (`id`, `codigo`, `id_proveedor`, `productos`, `descuento`, `neto`, `total`, `metodo_pago`, `nombre_costo`, `id_usuario`, `fecha`, `fecha_crea`, `vencimiento`, `estado`, `tipo_costo`) VALUES
(81, 10001, 1, '[{\"id\":\"2\",\"descripcion\":\"Producto de prueba\",\"cantidad\":\"10\",\"stock\":\"10\",\"precio\":\"1000\",\"total\":\"10000\"}]', 0, 10000, 10000, 'Transferencia-3233', '3123213', 1, '2024-03-29 05:23:05', '2024-03-29 00:23:05', '2024-04-28 00:00:00', 'NR', ''),
(82, 10002, 1, '[{\"id\":\"2\",\"descripcion\":\"Producto de prueba\",\"cantidad\":\"10\",\"stock\":\"10\",\"precio\":\"1000\",\"total\":\"10000\"}]', 0, 10000, 10000, 'Transferencia-2333', '3213213', 1, '2024-03-29 05:24:54', '2024-03-29 00:24:54', '2024-04-28 00:00:00', 'R', ''),
(83, 10003, 1, '[{\"id\":\"2\",\"descripcion\":\"Producto de prueba\",\"cantidad\":\"10\",\"stock\":\"10\",\"precio\":\"1000\",\"total\":\"10000\"}]', 0, 10000, 10000, 'Transferencia-2323', '213123', 1, '2024-03-29 05:25:28', '2024-03-29 00:25:28', '2024-05-30 00:00:00', 'NR', ''),
(84, 10004, 1, '[{\"id\":\"2\",\"descripcion\":\"Producto de prueba\",\"cantidad\":\"10\",\"stock\":\"10\",\"precio\":\"1000\",\"total\":\"10000\"}]', 0, 10000, 10000, 'Transferencia-2343423', '4234234', 1, '2024-03-29 05:29:23', '2024-03-29 00:29:23', '2024-04-28 00:00:00', 'NR', ''),
(85, 10005, 1, '[{\"id\":\"2\",\"descripcion\":\"Producto de prueba\",\"cantidad\":\"10\",\"stock\":\"10\",\"precio\":\"1000\",\"total\":\"10000\"}]', 0, 10000, 10000, 'Transferencia-321323', '1323123', 1, '2024-03-29 05:30:28', '2024-03-29 00:30:28', '0000-00-00 00:00:00', '', ''),
(86, 10006, 1, '[{\"id\":\"2\",\"descripcion\":\"Producto de prueba\",\"cantidad\":\"5\",\"stock\":\"10\",\"precio\":\"1000\",\"total\":\"5000\"}]', 0, 5000, 5000, 'Transferencia-13123', '1323123', 1, '2024-03-29 15:13:53', '2024-03-29 10:13:53', '0000-00-00 00:00:00', 'R', ''),
(87, 10007, 1, '[{\"id\":\"2\",\"descripcion\":\"Producto de prueba\",\"cantidad\":\"5\",\"stock\":\"10\",\"precio\":\"1000\",\"total\":\"5000\"}]', 0, 5000, 5000, 'Transferencia-313', '21323123', 1, '2024-03-29 15:22:43', '2024-03-29 10:22:43', '2024-04-02 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id` int(11) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `forma_pago` text NOT NULL,
  `monto` float NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre_gasto` text NOT NULL,
  `categoria` text NOT NULL,
  `codigo` int(11) NOT NULL,
  `fecha_crea` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id`, `id_proveedor`, `id_usuario`, `forma_pago`, `monto`, `fecha`, `nombre_gasto`, `categoria`, `codigo`, `fecha_crea`) VALUES
(1, 1, 1, 'Transferencia', 10000, '2024-03-29 15:18:12', 'p', 'Productos e insumos', 10001, '2024-03-29 10:18:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `codigo` text NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` text NOT NULL,
  `stock` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `precio_venta` float NOT NULL,
  `ventas` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL,
  `stock_inicial` int(11) NOT NULL,
  `fecha_crea` datetime DEFAULT NULL,
  `compras` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `id_categoria`, `codigo`, `descripcion`, `imagen`, `stock`, `precio_compra`, `precio_venta`, `ventas`, `fecha`, `estado`, `stock_inicial`, `fecha_crea`, `compras`) VALUES
(2, 1, '101', 'Producto de prueba', 'vistas/img/productos/default/anonymous.png', 10, 1000, 10000, 5, '2024-03-29 15:22:43', 1, 0, '2024-03-28 19:01:29', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `documento` int(11) NOT NULL,
  `email` text NOT NULL,
  `telefono` text NOT NULL,
  `direccion` text NOT NULL,
  `ventas` int(11) NOT NULL,
  `ultima_venta` datetime NOT NULL,
  `fecha_crea` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre`, `fecha`, `documento`, `email`, `telefono`, `direccion`, `ventas`, `ultima_venta`, `fecha_crea`) VALUES
(1, 'PROVEDOR DE PRUEBA', '2024-03-24 18:34:19', 123456789, 'PP@GMAIL.COM', '(310) 123-1212', 'Calle falsa 123', 60, '2024-03-29 10:22:43', '2024-03-24 13:34:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `usuario` text NOT NULL,
  `password` text NOT NULL,
  `perfil` text NOT NULL,
  `foto` text NOT NULL,
  `estado` int(11) NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_crea` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`, `fecha_crea`) VALUES
(1, 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5auOsTcxV66Wf1lWFlt.R6o37VOXIB1YhO', 'Administrador', 'vistas/img/usuarios/admin/401.jpg', 1, '2024-03-29 10:12:48', '2024-03-29 15:12:48', '2023-08-01 19:55:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `productos` text NOT NULL,
  `descuento` float NOT NULL,
  `neto` float NOT NULL,
  `total` float NOT NULL,
  `metodo_pago` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_venta` text NOT NULL,
  `nombre_venta` text NOT NULL,
  `vencimiento` datetime NOT NULL,
  `estado` text NOT NULL,
  `fecha_crea` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `codigo`, `id_cliente`, `id_vendedor`, `productos`, `descuento`, `neto`, `total`, `metodo_pago`, `fecha`, `tipo_venta`, `nombre_venta`, `vencimiento`, `estado`, `fecha_crea`) VALUES
(6, 10001, 1, 1, '[{\"id\":\"2\",\"descripcion\":\"Producto de prueba\",\"cantidad\":\"5\",\"stock\":\"5\",\"precio\":\"10000\",\"total\":\"50000\"}]', 0, 50000, 50000, 'Transferencia-33123', '2024-03-29 05:35:21', 'Venta', '1323123', '0000-00-00 00:00:00', '', '2024-03-29 00:35:21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `costos`
--
ALTER TABLE `costos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `costos`
--
ALTER TABLE `costos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

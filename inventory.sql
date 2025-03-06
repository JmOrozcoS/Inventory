-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-03-2025 a las 03:34:09
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
(4, 'LAPTOPS', '2025-03-06 02:15:05', '2025-03-05 21:15:05'),
(5, 'CELULARES', '2025-03-06 02:16:07', '2025-03-05 21:16:07');

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
(2, 'Pedro Pérez', 2147483647, 'pedro@gmail.com', '(666) 666-6667', 'Calle 456', '0000-00-00', 2, '2025-03-05 21:31:15', '2025-03-06 02:31:15', '2025-03-05 21:27:51');

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
(195, 10001, 2, '[{\"id\":\"10\",\"descripcion\":\"Celular iPhone Xr Color Azul 128 Gb\",\"cantidad\":\"30\",\"stock\":\"30\",\"precio\":\"500000\",\"total\":\"15000000\"},{\"id\":\"9\",\"descripcion\":\"Asus ROG Strix SCAR 17 Windows 11 CPU Intel Core i9 12900H GPU Nvidia GeForce RTX 3080 Ti \",\"cantidad\":\"10\",\"stock\":\"10\",\"precio\":\"1500000\",\"total\":\"15000000\"}]', 900000, 30000000, 29100000, 'Transferencia-0987654321', 'Unica compra', 1, '2025-03-06 02:26:53', '2025-03-05 21:26:53', '0000-00-00 00:00:00', '', '');

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
  `fecha_crea` datetime DEFAULT NULL,
  `tipo_registro` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id`, `id_proveedor`, `id_usuario`, `forma_pago`, `monto`, `fecha`, `nombre_gasto`, `categoria`, `codigo`, `fecha_crea`, `tipo_registro`) VALUES
(24, 0, 1, 'Efectivo', 20000, '2025-03-06 02:33:16', 'Envío venta fact 10002', 'Otro', 10001, '2025-03-05 21:33:16', 'Gasto');

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
(9, 4, '401', 'Asus ROG Strix SCAR 17 Windows 11 CPU Intel Core i9 12900H GPU Nvidia GeForce RTX 3080 Ti ', 'vistas/img/productos/401/627.png', 9, 1500000, 2700000, 1, '2025-03-06 02:31:15', 1, 0, '2025-03-05 21:18:53', 10),
(10, 5, '501', 'Celular iPhone Xr Color Azul 128 Gb', 'vistas/img/productos/501/681.jpg', 29, 500000, 1858000, 1, '2025-03-06 02:28:32', 1, 0, '2025-03-05 21:23:41', 30);

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
(2, 'Alibaba', '2025-03-06 02:25:51', 1234567890, 'Alibaba@Alibaba.com', '(555) 555-5556', 'Calle 123', 40, '2025-03-05 21:26:53', '2025-03-05 21:25:51');

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
(1, 'Administrador', 'admin', '$2a$07$asxx54ahjppf45sd87a5auOsTcxV66Wf1lWFlt.R6o37VOXIB1YhO', 'Administrador', 'vistas/img/usuarios/admin/401.jpg', 1, '2025-03-05 21:10:00', '2025-03-06 02:10:00', '2023-08-01 19:55:59'),
(2, 'Prueba', 'prueb01', '$2a$07$asxx54ahjppf45sd87a5auJRR6foEJ7ynpjisKtbiKJbvJsoQ8VPS', 'Vendedor', '', 1, '2024-06-15 21:25:27', '2024-06-16 02:25:27', '2024-06-15 21:23:35');

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
(32, 10001, 2, 1, '[{\"id\":\"10\",\"descripcion\":\"Celular iPhone Xr Color Azul 128 Gb\",\"cantidad\":\"1\",\"stock\":\"29\",\"precio\":\"1858000\",\"total\":\"1858000\"}]', 0, 1858000, 1858000, 'TC-234567', '2025-03-06 02:28:32', 'Venta', 'Envío incluido', '0000-00-00 00:00:00', '', '2025-03-05 21:28:32'),
(33, 10002, 2, 1, '[{\"id\":\"9\",\"descripcion\":\"Asus ROG Strix SCAR 17 Windows 11 CPU Intel Core i9 12900H GPU Nvidia GeForce RTX 3080 Ti \",\"cantidad\":\"1\",\"stock\":\"9\",\"precio\":\"2700000\",\"total\":\"2700000\"}]', 0, 2700000, 2700000, 'Transferencia-45645677', '2025-03-06 02:31:15', 'Alquiler', 'Producto en alquiler', '2025-04-05 00:00:00', '', '2025-03-05 21:31:15');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `costos`
--
ALTER TABLE `costos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

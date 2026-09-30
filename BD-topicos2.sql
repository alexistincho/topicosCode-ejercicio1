-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-09-2026 a las 21:21:21
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mycar_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquileres`
--

CREATE TABLE `alquileres` (
  `id` int(11) NOT NULL,
  `reserva_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `vehiculo_id` int(11) NOT NULL,
  `fecha_desde` date NOT NULL,
  `fecha_hasta` date NOT NULL,
  `devuelto` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_devolucion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alquileres`
--

INSERT INTO `alquileres` (`id`, `reserva_id`, `cliente_id`, `vehiculo_id`, `fecha_desde`, `fecha_hasta`, `devuelto`, `fecha_devolucion`) VALUES
(1, 2, 1, 8, '2026-06-30', '2026-07-10', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `fecha_alta` date NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `usuario_id`, `nombre`, `apellido`, `direccion`, `telefono`, `fecha_alta`, `estado`) VALUES
(1, 1, 'alexi', 'rodri', 'hola', '2664123456', '2026-06-18', 1),
(2, 3, 'Ricardo', 'Rodriguez', 'mitre 1232', '2664758222', '2026-06-23', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `vehiculo_id` int(11) NOT NULL,
  `fecha_desde` date NOT NULL,
  `cantidad_dias` int(11) NOT NULL,
  `estado` enum('pendiente','aprobada','rechazada') NOT NULL DEFAULT 'pendiente',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `cliente_id`, `vehiculo_id`, `fecha_desde`, `cantidad_dias`, `estado`, `creado_en`) VALUES
(1, 2, 3, '2027-07-23', 8, 'pendiente', '2026-06-23 17:36:13'),
(2, 1, 8, '2026-06-30', 10, 'aprobada', '2026-06-23 20:29:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contra` varchar(255) NOT NULL,
  `rol` enum('admin','cliente') NOT NULL DEFAULT 'cliente',
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `email`, `contra`, `rol`, `estado`, `creado_en`) VALUES
(1, 'alexis', 'alexistincho2028@gmail.com', '$2y$10$r4KF4p0F/tbbpr.76rSi6Ot1BVpKgDnnP722eUFWZObQgPi7Z3MQq', 'cliente', 1, '2026-06-18 03:06:38'),
(2, 'admin', 'admin@mycar.com', '$2y$10$ZCdLyd.PtOUXSMzL30hdmeSv8NXhNhBSDypQqqpMZRc5H737JSjha', 'admin', 1, '2026-06-18 03:07:57'),
(3, 'Ricardo', 'ricardoroorodriguez11@gmail.com', '$2y$10$j5IXJypAdTxQDUprn2dZoe4vUINkNlH9MRWGXRjV.Umz1hTxXwWu6', 'cliente', 1, '2026-06-23 17:32:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `anio` int(11) NOT NULL,
  `plazas` int(11) NOT NULL,
  `motor` varchar(50) NOT NULL,
  `kilometraje` decimal(10,2) NOT NULL DEFAULT 0.00,
  `precio_dia` decimal(10,2) NOT NULL,
  `disponible` tinyint(1) NOT NULL DEFAULT 1,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `marca`, `modelo`, `anio`, `plazas`, `motor`, `kilometraje`, `precio_dia`, `disponible`, `estado`) VALUES
(1, 'Volkswagen', 'Gol Trend', 2021, 5, '1.6 Nafta', 32500.00, 18500.00, 0, 0),
(2, 'Toyota', 'Corolla', 2022, 5, '2.0 Nafta', 18000.00, 27500.00, 1, 1),
(3, 'Chevrolet', 'Onix', 2020, 5, '1.4 Nafta', 41200.00, 16800.00, 1, 1),
(4, 'Ford', 'Ranger', 2019, 5, '3.2 Diesel', 65000.00, 35000.00, 1, 1),
(5, 'Fiat', 'Cronos', 2023, 5, '1.3 Nafta', 9500.00, 19900.00, 1, 1),
(6, 'Renault', 'Duster', 2021, 5, '1.6 Nafta', 28700.00, 24500.00, 0, 1),
(7, 'Peugeot', '208', 2018, 5, '1.6 Nafta', 78400.00, 15200.00, 1, 1),
(8, 'Toyota', 'Corolla XEI', 2023, 5, '2.0L Dynamic Force', 3500.00, 25000.00, 0, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reserva_id` (`reserva_id`),
  ADD KEY `fk_alquileres_cliente` (`cliente_id`),
  ADD KEY `fk_alquileres_vehiculo` (`vehiculo_id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reservas_cliente` (`cliente_id`),
  ADD KEY `fk_reservas_vehiculo` (`vehiculo_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD CONSTRAINT `fk_alquileres_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_alquileres_reserva` FOREIGN KEY (`reserva_id`) REFERENCES `reservas` (`id`),
  ADD CONSTRAINT `fk_alquileres_vehiculo` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`);

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reservas_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_reservas_vehiculo` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

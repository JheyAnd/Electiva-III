-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2024 a las 16:49:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `perfumeria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `verificado` tinyint(1) DEFAULT 0,
  `codigo_verificacion` varchar(6) DEFAULT NULL,
  `token_verificacion` varchar(32) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `nombre`, `correo`, `usuario`, `clave`, `cedula`, `telefono`, `verificado`, `codigo_verificacion`, `token_verificacion`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Jheyson Andres Mena Perea', 'jheisonandres03@gmail.com', 'JheyAdmin', '$argon2id$v=19$m=65536,t=4,p=1$WmdVYlJaNi5MY2tPVVczZQ$wGwYyTP0FBMVH7kTXnc6b9zI1Jft8frUPSZ/kZ7IG9o', '1004012908', '3117508736', 1, NULL, '1dabac376983a07052b3eb433bf4649c', '2024-11-05 01:11:11', '2024-11-05 01:11:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `fecha_creacion`) VALUES
(1, 'Hombres', 'Lociones para Hombres', '2024-11-02 22:28:10'),
(2, 'Mujeres', 'Lociones para Mujeres', '2024-11-02 22:32:49'),
(3, 'Unisex', 'Seccion de genero neutro', '2024-11-03 01:27:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fragancia`
--

CREATE TABLE `fragancia` (
  `id` int(11) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `tipo_fragancia` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `proveedor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `fragancia`
--

INSERT INTO `fragancia` (`id`, `marca`, `tipo_fragancia`, `descripcion`, `fecha_creacion`, `fecha_actualizacion`, `proveedor_id`) VALUES
(1, 'Hugo Boss', 'Olfativa floral', 'Florales, florales suaves y floral oriental', '2024-11-03 00:45:04', '2024-11-03 00:45:04', NULL),
(2, 'Hugo Boss', 'Olfativa oriental', 'Orientales, orientales suaves y oriental amaderada', '2024-11-03 00:47:40', '2024-11-03 00:47:40', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `proveedor_id` int(11) DEFAULT NULL,
  `fragancia_id` int(11) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `tipo_fragancia` varchar(50) DEFAULT NULL,
  `tamaño` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_x1` decimal(10,2) DEFAULT NULL,
  `descuento_x1` decimal(10,2) DEFAULT NULL,
  `imagen1` varchar(255) DEFAULT NULL,
  `imagen2` varchar(255) DEFAULT NULL,
  `imagen3` varchar(255) DEFAULT NULL,
  `imagen4` varchar(255) DEFAULT NULL,
  `imagen5` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `categoria_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `proveedor_id`, `fragancia_id`, `marca`, `tipo_fragancia`, `tamaño`, `cantidad`, `precio_x1`, `descuento_x1`, `imagen1`, `imagen2`, `imagen3`, `imagen4`, `imagen5`, `fecha_creacion`, `fecha_actualizacion`, `categoria_id`) VALUES
(3, 'Hugo Boss', '<p>Una fragancia es una&nbsp;<strong>mezcla de materias primas odor&iacute;feras con una estructura determinada y dise&ntilde;ada para impactar positivamente en los seres humanos</strong>. A trav&eacute;s del sentido del olfato se puede percibir un extenso abanico de olores que provocan diferentes sensaciones en los seres vivos.</p>', 1, 1, 'Hugo Boss', 'Olfativa floral', '15 ML', 20, 10000.00, 5000.00, 'imagen/6727b9d2ce43e_N1-1.png', 'imagen/6727b9d2cee4c_N1-2.png', 'imagen/6727b9d2cf8b1_N2-1.png', 'imagen/6727b9d2d00b5_N2-2.png', 'imagen/6727b9d2d08c0_N3.png', '2024-11-03 16:42:55', '2024-11-03 19:12:34', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre_empresa` varchar(100) NOT NULL,
  `nombre_contacto` varchar(100) NOT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre_empresa`, `nombre_contacto`, `contacto`, `telefono`, `email`, `direccion`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Hugo Boss', 'Leonel Messi', NULL, '3117508736', NULL, 'cr2a#31-93', '2024-11-03 01:21:18', '2024-11-03 01:21:18');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `fragancia`
--
ALTER TABLE `fragancia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_proveedor_id` (`proveedor_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `fragancia_id` (`fragancia_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `fragancia`
--
ALTER TABLE `fragancia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fragancia`
--
ALTER TABLE `fragancia`
  ADD CONSTRAINT `fk_proveedor_id` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`fragancia_id`) REFERENCES `fragancia` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

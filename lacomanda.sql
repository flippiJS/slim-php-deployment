-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2023 a las 17:32:31
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lacomanda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id` int(11) NOT NULL,
  `idMesa` int(11) DEFAULT NULL,
  `puntuacionMesa` int(11) DEFAULT NULL,
  `idMozo` int(11) DEFAULT NULL,
  `puntuacionMozo` int(11) DEFAULT NULL,
  `puntuacionRestaurante` int(11) DEFAULT NULL,
  `idCocinero` int(11) DEFAULT NULL,
  `puntuacionCocinero` int(11) DEFAULT NULL,
  `comentarios` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id`, `idMesa`, `puntuacionMesa`, `idMozo`, `puntuacionMozo`, `puntuacionRestaurante`, `idCocinero`, `puntuacionCocinero`, `comentarios`) VALUES
(1, 1, 8, 10, 9, 8, 8, 8, 'La comida estuvo buena y los precios son bastante razonables'),
(2, 2, 10, 11, 9, 10, 9, 9, 'El mejor restaurante de la zona'),
(3, 4, 7, 10, 7, 7, 8, 7, 'Buena atención y comida. Lo recomiendo. '),
(4, 5, 2, 11, 2, 3, 9, 2, 'Pésimo restaurante!'),
(5, 2, 2, 10, 1, 3, 9, 2, 'Ni se gasten en ir, pésima atención y pésima comida.'),
(6, 2, 5, 11, 4, 5, 8, 5, 'Muy mala atención y la comida no es de lo mejor. '),
(7, 8, 8, 11, 9, 10, 8, 9, 'Muy buen restaurante! '),
(8, 2, 8, 10, 8, 8, 8, 8, 'Voy muy seguido. Es bastante accesible comparando con los de la zona. '),
(9, 2, 10, 10, 10, 10, 9, 10, 'Excelente atención y muy buena comida '),
(10, 2, 7, 10, 7, 7, 9, 8, 'La comida es buena, pero un poco caro. '),
(11, 2, 1, 11, 1, 2, 8, 1, 'La atención es malísima, no vayan. '),
(12, 2, 2, 10, 1, 2, 8, 2, 'Bastante caro!! En otros restaurantes de la zona se come mejor y a mejor precio. '),
(13, 2, 8, 10, 9, 9, 8, 9, 'Muy buenos precios y buena calidad de comida.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `operacion` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `logs`
--

INSERT INTO `logs` (`id`, `idUsuario`, `fecha`, `operacion`) VALUES
(1, 1, '2022-11-12 23:50:49', 'Login'),
(2, 2, '2022-11-12 23:51:14', 'Login'),
(3, 3, '2022-11-12 23:51:26', 'Login'),
(4, 4, '2022-11-12 23:51:26', 'Login'),
(5, 5, '2022-11-12 23:51:26', 'Login'),
(6, 6, '2022-11-12 23:51:26', 'Login'),
(7, 7, '2022-11-12 23:51:26', 'Login'),
(8, 8, '2022-11-12 23:51:26', 'Login'),
(9, 9, '2022-11-12 23:51:26', 'Login'),
(10, 10, '2022-11-12 23:51:26', 'Login'),
(11, 11, '2022-11-12 23:51:26', 'Login'),
(12, 10, '2022-11-12 23:51:26', 'Emitir informe de pedidos pendientes por perfil'),
(13, 11, '2022-11-12 23:51:26', 'Emitir informe de pedidos pendientes por perfil'),
(14, 10, '2022-11-12 23:51:26', 'Emitir informe de pedidos pendientes por perfil'),
(15, 11, '2022-11-12 23:51:26', 'Emitir informe de pedidos pendientes por perfil'),
(16, 11, '2022-11-12 23:55:26', 'Servir la mesa'),
(17, 10, '2022-11-12 23:55:26', 'Servir la mesa'),
(18, 10, '2022-11-12 23:56:26', 'Servir la mesa'),
(19, 11, '2022-11-12 23:58:26', 'Servir la mesa'),
(20, 8, '2022-11-20 20:58:26', 'Empezar a preparar un pedido'),
(21, 9, '2022-11-20 20:58:26', 'Empezar a preparar un pedido'),
(22, 8, '2022-11-21 20:58:26', 'Empezar a preparar un pedido'),
(23, 9, '2022-11-21 20:58:26', 'Empezar a preparar un pedido'),
(24, 8, '2022-11-23 20:58:26', 'Terminar de preparar un pedido'),
(25, 9, '2022-11-23 20:58:26', 'Terminar de preparar un pedido'),
(26, 8, '2022-11-23 20:58:26', 'Terminar de preparar un pedido'),
(27, 9, '2022-11-23 21:58:26', 'Terminar de preparar un pedido'),
(28, 8, '2022-11-23 22:58:26', 'Terminar de preparar un pedido'),
(29, 11, '2022-11-23 23:58:26', 'Alta de un pedido'),
(30, 10, '2022-11-23 23:58:26', 'Alta de un pedido'),
(31, 11, '2022-11-24 23:58:26', 'Alta de un pedido'),
(32, 10, '2022-11-24 23:58:26', 'Alta de un pedido'),
(33, 10, '2022-11-24 23:59:26', 'Cobrar la cuenta de la mesa'),
(34, 11, '2022-11-24 23:59:27', 'Cobrar la cuenta de la mesa'),
(35, 10, '2022-11-24 23:59:28', 'Cobrar la cuenta de la mesa'),
(36, 10, '2022-11-24 23:59:30', 'Cobrar la cuenta de la mesa'),
(37, 1, '2022-11-24 23:59:35', 'Cierre de mesa'),
(38, 1, '2022-11-24 23:59:36', 'Cierre de mesa'),
(39, 1, '2022-11-24 23:59:37', 'Cierre de mesa'),
(40, 1, '2022-11-24 23:59:38', 'Cierre de mesa'),
(41, 1, '2022-11-25 20:00:00', 'Login'),
(42, 2, '2022-11-25 20:00:00', 'Login'),
(43, 3, '2022-11-25 20:00:00', 'Login'),
(44, 4, '2022-11-25 20:00:00', 'Login'),
(45, 5, '2022-11-25 20:00:00', 'Login'),
(46, 6, '2022-11-25 20:00:00', 'Login'),
(47, 7, '2022-11-25 20:00:00', 'Login'),
(48, 8, '2022-11-25 20:00:00', 'Login'),
(49, 9, '2022-11-25 20:00:00', 'Login'),
(50, 10, '2022-11-25 20:00:00', 'Login'),
(51, 1, '2022-11-28 20:00:00', 'Emitir informe de pedidos y tiempo de demora'),
(52, 1, '2022-11-28 20:00:00', 'Emitir informe de mesa más usada'),
(53, 1, '2022-11-28 20:00:00', 'Emitir informe de pedidos no entregados a tiempo'),
(54, 1, '2022-11-28 20:00:00', 'Emitir informes de mesas por monto de facturación'),
(55, 1, '2022-11-28 20:00:00', 'Informe de lo facturado por mesa entre determinadas fechas'),
(56, 1, '2022-11-28 20:00:00', 'Emitir informe de pedidos cancelados'),
(57, 1, '2022-11-28 20:00:00', 'Emitir informe de mesa menos usada'),
(58, 1, '2022-11-28 20:00:00', 'Emitir informes de mesas de mayor facturación'),
(59, 1, '2022-11-28 20:00:00', 'Emitir informes de mesas de menor facturación'),
(60, 1, '2022-11-28 20:00:00', 'Emisión de informe de estado de las mesas'),
(61, 1, '2022-11-28 20:00:00', 'Emitir un listado de pedidos listos para servir'),
(62, 1, '2022-11-28 20:00:00', 'Emitir listado de productos por cantidad vendida'),
(63, 1, '2022-11-29 23:50:49', 'Login'),
(64, 2, '2022-11-29 23:50:49', 'Login'),
(65, 3, '2022-11-29 23:50:49', 'Login'),
(66, 4, '2022-11-29 23:50:49', 'Login'),
(67, 5, '2022-11-29 23:50:49', 'Login'),
(68, 6, '2022-11-29 23:50:49', 'Login'),
(69, 7, '2022-11-29 23:50:49', 'Login'),
(70, 8, '2022-11-29 23:50:49', 'Login'),
(71, 9, '2022-11-29 23:50:49', 'Login'),
(72, 10, '2022-11-29 23:50:49', 'Login'),
(73, 2, '2022-11-30 20:00:00', 'Emitir informe de pedidos y tiempo de demora'),
(74, 2, '2022-11-30 20:00:00', 'Emitir informe de mesa más usada'),
(75, 3, '2022-11-30 20:00:00', 'Emitir informe de pedidos no entregados a tiempo'),
(76, 2, '2022-11-30 20:00:00', 'Emitir informe de pedidos cancelados'),
(77, 2, '2022-11-30 20:00:00', 'Emitir informes de mesas de menor facturación'),
(78, 3, '2022-11-30 20:00:00', 'Emitir listado de productos por cantidad vendida'),
(79, 10, '2022-11-30 21:00:00', 'Emitir informe de pedidos pendientes por perfil'),
(80, 11, '2022-11-30 21:00:26', 'Emitir informe de pedidos pendientes por perfil'),
(81, 11, '2022-11-30 21:00:00', 'Servir la mesa'),
(82, 10, '2022-11-30 21:00:00', 'Servir la mesa'),
(83, 11, '2022-11-30 21:00:00', 'Servir la mesa'),
(84, 10, '2022-11-30 21:00:00', 'Alta de un pedido'),
(85, 11, '2022-11-30 21:00:00', 'Alta de un pedido'),
(86, 10, '2022-11-30 22:00:00', 'Alta de un pedido'),
(87, 11, '2022-11-30 22:00:00', 'Alta de un pedido'),
(88, 10, '2022-11-30 23:00:00', 'Cobrar la cuenta de la mesa'),
(89, 11, '2022-11-30 23:00:00', 'Cobrar la cuenta de la mesa'),
(90, 1, '2022-11-30 23:00:00', 'Cierre de mesa'),
(91, 1, '2022-11-30 23:05:00', 'Cierre de mesa'),
(92, 11, '2022-12-01 20:58:26', 'Emitir informe de pedidos listos para servir'),
(93, 11, '2022-12-02 20:58:26', 'Asignar una foto al pedido'),
(94, 11, '2022-12-03 20:58:26', 'Emitir informe de pedidos listos para servir');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesas`
--

CREATE TABLE `mesas` (
  `id` int(11) NOT NULL,
  `codigoMesa` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `disponible` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `mesas`
--

INSERT INTO `mesas` (`id`, `codigoMesa`, `estado`, `disponible`) VALUES
(1, 'A1001', 'cerrada', 1),
(2, 'A1002', 'cerrada', 1),
(3, 'A1003', 'cerrada', 1),
(4, 'A1004', 'cerrada', 1),
(5, 'A1005', 'cerrada', 1),
(6, 'A1006', 'cerrada', 1),
(7, 'A1007', 'cerrada', 1),
(8, 'A1008', 'cerrada', 1),
(9, 'A1009', 'cerrada', 1),
(10, 'A1010', 'cerrada', 1),
(11, 'A1011', 'cerrada', 1),
(12, 'A1012', 'cerrada', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `idMesa` int(11) DEFAULT NULL,
  `codigoPedido` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idMozo` int(11) DEFAULT NULL,
  `nombreCliente` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fotoMesa` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `horarioPautado` datetime DEFAULT NULL,
  `horarioEntregado` datetime DEFAULT NULL,
  `totalFacturado` float DEFAULT NULL,
  `estado` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `idMesa`, `codigoPedido`, `idMozo`, `nombreCliente`, `fotoMesa`, `horarioPautado`, `horarioEntregado`, `totalFacturado`, `estado`) VALUES
(1, 1, 'A1231', 10, 'Juancito', '.\\fotosMesas\\mesa1.jpg', '2022-11-10 20:20:00', '2022-11-10 20:21:00', 1000, 'entregado'),
(2, 2, 'A1232', 11, 'Fulanito', '.\\fotosMesas\\mesa2.jpg', '2022-11-10 21:05:00', '2022-11-10 21:00:00', 5000, 'entregado'),
(3, 3, 'A1233', 12, 'Eliminable', '.\\fotosMesas\\mesa3.jpg', NULL, NULL, NULL, 'cancelado'),
(4, 4, 'A1234', 10, 'Esteban', NULL, '2022-11-13 21:30:00', '2022-11-13 21:25:00', 3000, 'entregado'),
(5, 5, 'A1235', 11, 'Alejandro', NULL, '2022-11-13 21:40:00', '2022-11-13 21:43:00', 2500, 'entregado'),
(6, 2, 'A1236', 10, 'Lorena', NULL, '2022-11-13 21:45:00', '2022-11-13 21:47:00', 3500, 'entregado'),
(7, 2, 'A1237', 11, 'Matias', NULL, '2022-11-13 21:50:00', '2022-11-13 21:58:00', 9000, 'entregado'),
(8, 2, 'A1238', 10, 'Laura', NULL, '2022-11-13 22:00:00', '2022-11-13 22:08:00', 4500, 'entregado'),
(9, 2, 'A1239', 10, 'Rodolfo', NULL, '2022-11-15 20:00:00', '2022-11-15 20:05:00', 1500, 'entregado'),
(10, 2, 'A1240', 10, 'Mariana', NULL, '2022-11-20 20:00:00', '2022-11-20 20:05:00', 2800, 'entregado'),
(11, 3, 'A1241', 10, 'Josefina', NULL, NULL, NULL, NULL, 'cancelado'),
(12, 4, 'A1242', 11, 'Vanesa', NULL, NULL, NULL, NULL, 'cancelado'),
(13, 2, 'A1243', 11, 'Natalia', NULL, '2022-11-27 20:00:00', '2022-11-27 20:07:00', 5500, 'entregado'),
(14, 2, 'A1244', 10, 'Eduardo', NULL, '2022-12-05 20:00:00', '2022-12-05 20:09:00', 3500, 'entregado'),
(15, 2, 'A1245', 10, 'Luis', NULL, '2022-12-09 20:00:00', '2022-12-09 19:50:00', 3500, 'entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `precio` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `sector` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `disponible` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `sector`, `disponible`) VALUES
(1, 'milanesa a caballo', '100', 'cocinero', 1),
(2, 'hamburguesa de garbanzo', '90', 'cocinero', 1),
(3, 'empanada', '110', 'cocinero', 1),
(4, 'pizza', '120', 'cocinero', 1),
(5, 'papas fritas', '90', 'cocinero', 1),
(6, 'milanesa napolitana', '150', 'cocinero', 1),
(7, 'quilmes', '50', 'cervecero', 1),
(8, 'grolsch', '115', 'cervecero', 1),
(9, 'brahma', '70', 'cervecero', 1),
(10, 'corona', '60', 'cervecero', 1),
(11, 'vino', '65', 'bartender', 1),
(12, 'vodka', '120', 'bartender', 1),
(13, 'taco', '50', 'bartender', 1),
(14, 'daikiri', '45', 'bartender', 1),
(15, 'gin', '75', 'bartender', 1),
(16, 'eliminable', '100', 'bartender', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productospedidos`
--

CREATE TABLE `productospedidos` (
  `id` int(11) NOT NULL,
  `codigoPedido` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idEmpleado` int(11) DEFAULT NULL,
  `perfil` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `horarioPautado` datetime DEFAULT NULL,
  `estado` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productospedidos`
--

INSERT INTO `productospedidos` (`id`, `codigoPedido`, `idEmpleado`, `perfil`, `idProducto`, `cantidad`, `horarioPautado`, `estado`) VALUES
(1, 'A1231', 8, 'cocinero', 3, 3, '2022-11-10 20:05:00', 'entregado'),
(2, 'A1231', 8, 'cocinero', 4, 2, '2022-11-10 20:20:00', 'entregado'),
(3, 'A1231', 4, 'bartender', 11, 1, '2022-11-10 20:10:00', 'entregado'),
(4, 'A1232', 9, 'cocinero', 6, 1, '2022-11-13 21:00:00', 'entregado'),
(5, 'A1232', 5, 'bartender', 11, 1, '2022-11-13 21:05:00', 'entregado'),
(6, 'A1233', NULL, 'cocinero', 6, 1, NULL, 'cancelado'),
(7, 'A1233', NULL, 'bartender', 11, 1, NULL, 'cancelado'),
(8, 'A1234', 8, 'cocinero', 3, 3, '2022-11-13 21:15:00', 'entregado'),
(9, 'A1234', 8, 'cocinero', 5, 4, '2022-11-13 21:15:00', 'entregado'),
(10, 'A1234', 6, 'cervecero', 8, 1, '2022-11-13 21:30:00', 'entregado'),
(11, 'A1234', 5, 'bartender', 12, 1, '2022-11-13 21:22:00', 'entregado'),
(12, 'A1235', 9, 'cocinero', 6, 1, '2022-11-13 21:40:00', 'entregado'),
(13, 'A1235', 7, 'cervecero', 7, 1, '2022-11-13 21:35:00', 'entregado'),
(14, 'A1236', 4, 'cervecero', 8, 1, '2022-11-13 21:45:00', 'entregado'),
(15, 'A1237', 8, 'cocinero', 4, 1, '2022-11-13 21:50:00', 'entregado'),
(16, 'A1238', 8, 'cocinero', 1, 1, '2022-11-13 22:00:00', 'entregado'),
(17, 'A1239', 8, 'cocinero', 1, 1, '2022-11-15 20:00:00', 'entregado'),
(18, 'A1240', 9, 'cocinero', 2, 1, '2022-11-20 20:00:00', 'entregado'),
(19, 'A1241', NULL, 'cocinero', 6, 1, NULL, 'cancelado'),
(20, 'A1242', NULL, 'cocinero', 4, 1, NULL, 'cancelado'),
(21, 'A1243', 8, 'cocinero', 3, 1, '2022-11-27 20:00:00', 'entregado'),
(22, 'A1244', 8, 'cocinero', 3, 1, '2022-12-05 20:00:00', 'entregado'),
(23, 'A1245', 8, 'cocinero', 5, 1, '2022-12-09 20:00:00', 'entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clave` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `perfil` varchar(250) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fechaAlta` datetime DEFAULT NULL,
  `fechaBaja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `clave`, `perfil`, `fechaAlta`, `fechaBaja`) VALUES
(1, 'Marcos', '$2y$10$U1QKjoQBaIOeE8KjGTYNVuVIeNSB.nybPIdh8GebOnSOps0OrsbO6', 'socio', '2022-01-01 00:00:00', NULL),
(2, 'Pablo', '$2y$10$bfqgWc./g9csBjZV9QJDz./zp42dlbatGFX7q8YHyloX0BetbyhSG', 'socio', '2022-01-01 00:00:00', NULL),
(3, 'Walter', '$2y$10$wUi49XlK8rNTjbEFB2JU9e62q82wsNOWBW7nk6MvAh93IQHWo5.Ni', 'socio', '2022-01-01 00:00:00', NULL),
(4, 'Lucas', '$2y$10$lEFcSlY8uvZkwjK4eJ496OqwBODzHHbTbmAzikTqyl0gImqaZpw5m', 'bartender', '2022-02-01 00:00:00', NULL),
(5, 'Carolina', '$2y$10$hSIaTYPucejFEZS0O5tOr.mlvuyzoZcKd/h6JXyLtugDt2r4QxaRi', 'bartender', '2022-02-15 00:00:00', NULL),
(6, 'Leandro', '$2y$10$VXBVgAynUjlr6KLO1XrtJeRHeaMfC.4gLMSiq6ehH2f5z8kK70fFS', 'cervecero', '2022-03-01 00:00:00', NULL),
(7, 'Julian', '$2y$10$mjWtqsocPSaWtjIeUg8AG.GwrgJ73eeJJHcM9TDXFFWqHwAJDHFY.', 'cervecero', '2022-03-15 00:00:00', NULL),
(8, 'Lucia', '$2y$10$TaexwFxphEcrxkhBxULsyOZysSS6vHG.nxP0DmSp.M7d4cLP6WEgG', 'cocinero', '2022-04-01 00:00:00', NULL),
(9, 'Miguel', '$2y$10$L3wLqa7NJLg6qrzRGG2j0eIAjGLSF4kHXyxPLKwLDVE4OXomc5MB.', 'cocinero', '2022-04-15 00:00:00', NULL),
(10, 'Cristian', '$2y$10$RUyJQFMXWBKtVK72zwO8duXGMeC.D2NY3vF9Kve5dw9VWSYpl11Fe', 'mozo', '2022-05-01 00:00:00', NULL),
(11, 'Marcio', '$2y$10$uniLgNxJCR/UXx19E7QdvucsKYmMYGDhipfRx0KLmGHjY3UM.kIP6', 'mozo', '2022-05-02 00:00:00', NULL),
(12, 'Eliminable', '$2y$10$n69kkP1Le.2sYG3hEY/N5unZeW73JkR9vBurOKReuljnD1sUtwE9y', 'mozo', '2022-05-02 00:00:00', '2022-12-12 23:26:14');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mesas`
--
ALTER TABLE `mesas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productospedidos`
--
ALTER TABLE `productospedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT de la tabla `mesas`
--
ALTER TABLE `mesas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `productospedidos`
--
ALTER TABLE `productospedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
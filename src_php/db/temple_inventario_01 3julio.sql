-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 03-07-2021 a las 17:58:43
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `temple_inventario_01`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acce_acceso`
--

CREATE TABLE `acce_acceso` (
  `acce_codigo` int(11) NOT NULL,
  `acce_usua_codigo` int(11) NOT NULL DEFAULT '0',
  `acce_form_codigo` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `acce_acceso`
--

INSERT INTO `acce_acceso` (`acce_codigo`, `acce_usua_codigo`, `acce_form_codigo`) VALUES
(25, 2, 3),
(26, 2, 4),
(27, 1, 7),
(28, 1, 8),
(29, 1, 9),
(30, 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clie_cliente`
--

CREATE TABLE `clie_cliente` (
  `clie_codigo` int(11) NOT NULL,
  `clie_nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `clie_direccion` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `clie_pais` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `clie_responsable` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `clie_contacto` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `clie_fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equi_equivalencia`
--

CREATE TABLE `equi_equivalencia` (
  `equi_codigo` int(11) NOT NULL,
  `equi_nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `equi_codigo_producto` int(11) DEFAULT '0',
  `equi_cantidad` int(11) DEFAULT '0',
  `equi_costo` decimal(10,4) DEFAULT '0.0000',
  `equi_costo_extra` decimal(10,4) DEFAULT '0.0000',
  `equi_costo_total` decimal(10,4) DEFAULT '0.0000',
  `equi_precio` decimal(10,4) DEFAULT NULL,
  `equi_fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equi_equivalencia`
--

INSERT INTO `equi_equivalencia` (`equi_codigo`, `equi_nombre`, `equi_codigo_producto`, `equi_cantidad`, `equi_costo`, `equi_costo_extra`, `equi_costo_total`, `equi_precio`, `equi_fecha`) VALUES
(3, 'qwer', 97, 11, '1.0000', '1.0000', '3.0000', '44.0000', '2021-07-02 14:07:04'),
(4, 'yuio', 97, 11, '22.0000', '33.0000', '55.0000', '44.0000', '2021-06-30 16:40:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form_formulario`
--

CREATE TABLE `form_formulario` (
  `form_codigo` int(11) NOT NULL,
  `form_nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `form_ruta` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `form_acceso` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `form_formulario`
--

INSERT INTO `form_formulario` (`form_codigo`, `form_nombre`, `form_ruta`, `form_acceso`) VALUES
(1, 'Unidad', 'sis_unidad.php', 'unidad'),
(2, 'Unidad Configurar', 'sis_unidad_crud.php', 'unidad_crud'),
(3, 'Laboratorio', 'sis_laboratorio.php', 'labo'),
(4, 'Laboratorio Configurar', 'sis_laboratorio_crud.php', 'labo_crud'),
(5, 'Cliente', 'sis_cliente.php', 'clie'),
(6, 'Cliente Configurar', 'sis_cliente_crud.php', 'clie_crud'),
(7, 'Proveedor', 'sis_proveedor.php', 'prov'),
(8, 'Provedor Configurar', 'sis_proveedor_crud.php', 'prov_crud'),
(9, 'Producto', 'sis_producto.php', 'prod'),
(10, 'Producto Configurar', 'sis_producto_crud.php', 'prod_crud'),
(11, 'Equivalencias y Precios', 'sis_equivalencia.php', 'equi_crud'),
(12, 'Usuario', 'sis_usuario.php', 'usu'),
(13, 'Usuario Configurar', 'sis_usuario_crud.php', 'usu_crud');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hist_historial`
--

CREATE TABLE `hist_historial` (
  `hist_codigo` int(11) NOT NULL,
  `hist_tabla` varchar(15) COLLATE utf8mb4_general_ci DEFAULT '',
  `hist_descripcion` varchar(200) COLLATE utf8mb4_general_ci DEFAULT '',
  `hist_usuario` varchar(20) COLLATE utf8mb4_general_ci DEFAULT '',
  `hist_cod_usuario` int(11) DEFAULT '0',
  `hist_fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hist_historial`
--

INSERT INTO `hist_historial` (`hist_codigo`, `hist_tabla`, `hist_descripcion`, `hist_usuario`, `hist_cod_usuario`, `hist_fecha`) VALUES
(1, 'usuario', 'crea,jefe jefe,jefe,1', 'Josue Romero', 1, '2021-04-03 15:53:54'),
(2, 'usuario', 'crea,n:tt* a:tt*,u:tt*,1', 'Josue Romero', 1, '2021-04-03 16:00:16'),
(3, 'usuario', 'elimino,n:tt* a:tt*,u:tt*,1', 'Josue Romero', 1, '2021-04-03 16:03:13'),
(4, 'usuario', 'elimino,n:tt* a:tt*,u:tt*,1', 'Josue Romero', 1, '2021-04-03 16:03:21'),
(5, 'usuario', 'modifico,n:zz a:zz,u:zz,1', 'Josue Romero', 1, '2021-04-03 16:03:44'),
(6, 'usuario', 'elimino,n:zz a:zz,u:zz,1', 'Josue Romero', 1, '2021-04-03 16:05:57'),
(7, 'unidad', 'crea,n: caja 20', 'admin admin', 31, '2021-04-03 17:41:32'),
(8, 'unidad', 'modifico,n: caja x 20', 'admin admin', 31, '2021-04-03 17:41:42'),
(9, 'unidad', 'elimino,n: caja x 20', 'admin admin', 31, '2021-04-03 17:41:47'),
(10, 'unidad', 'crea,n: Laboratorio MK p:El Salvador', 'admin admin', 31, '2021-04-03 17:59:20'),
(11, 'laboratorio', 'crea,n: Laboratorios Suiza p:El Salvador', 'admin admin', 31, '2021-04-03 18:02:38'),
(12, 'laboratorio', 'edita,n: Laboratorios Vijosa p:El Salvador', 'admin admin', 31, '2021-04-03 18:02:59'),
(13, 'laboratorio', 'edita,n: Laboratorios Vijosa p:El Salvador', 'admin admin', 31, '2021-04-03 18:03:33'),
(14, 'laboratorio', 'edita,n: Laboratorios Vijosa p:El Salvador', 'admin admin', 31, '2021-04-03 18:04:05'),
(15, 'laboratorio', 'edita,n: Laboratorios Vijosa. p:El Salvador.', 'admin admin', 31, '2021-04-03 18:04:14'),
(16, 'laboratorio', 'elimino,n: Laboratorios Vijosa.', 'admin admin', 31, '2021-04-03 18:04:22'),
(17, 'laboratorio', 'elimina,n: Laboratorios Vijosa. p:El Salvador.', 'admin admin', 31, '2021-04-03 18:05:27'),
(18, 'laboratorio', 'crea, n: prueba, p:eeuu', 'admin admin', 31, '2021-04-03 18:07:36'),
(19, 'laboratorio', 'edita,n: prueba edited, p: edited', 'admin admin', 31, '2021-04-03 18:07:49'),
(20, 'laboratorio', 'elimina, n: prueba edited, p: edited', 'admin admin', 31, '2021-04-03 18:07:54'),
(21, 'laboratorio', 'crea, c:0, n: Laboratorio Gringo, p:EEUU', 'admin admin', 31, '2021-04-03 18:15:25'),
(22, 'laboratorio', 'edita,c:5, n: Laboratorio Gringo.., p:EEUU..', 'admin admin', 31, '2021-04-03 18:15:35'),
(23, 'laboratorio', 'elimina, c:5, n: Laboratorio Gringo.., p:EEUU..', 'admin admin', 31, '2021-04-03 18:15:40'),
(24, 'proveedor', 'crea, c:0, n: Distribuidora fronteriza, p:Guatemala, d:Frontera nva Guatemala, r:Nombre encargado, c:tel 2550.666', 'admin admin', 31, '2021-04-03 18:54:56'),
(25, 'proveedor', 'edita,c:2, n: xxDistribuidora fronteriza, p:xxGuatemala, d:xxFrontera nva Guatemala, r:xxNombre encargado, c:xxtel 2550.666', 'admin admin', 31, '2021-04-03 18:58:49'),
(26, 'proveedor', 'edita,c:2, n: xxDistribuidora fronteriza, p:xxGuatemala, d:xxFrontera nva Guatemala, r:xxNombre encargado, c:xxtel 2550.666', 'admin admin', 31, '2021-04-03 18:59:38'),
(27, 'proveedor', 'elimina, c:2, n: xxDistribuidora fronteriza, p:xxGuatemala, d:xxFrontera nva Guatemala, r:xxNombre encargado, c:xxtel 2550.666', 'admin admin', 31, '2021-04-03 18:59:43'),
(28, 'producto', 'crea, c:0, n: segundo producto, d:descricp segundo, b:def, c1:1, c2:0.5, c3:1.5, p:2, e:10, l:0, p:0', 'Josue Romero', 1, '2021-04-04 04:48:43'),
(29, 'producto', 'crea, c:0, n: segundo producto, d:descricp segundo, b:def, c1:1, c2:0.5, c3:1.5, p:2, e:10, l:0, p:0', 'Josue Romero', 1, '2021-04-04 04:49:02'),
(30, 'producto', 'edita,c:2, n: segundo producto, d:descricp segundo, b:def, c1:1.00, c2:0.50, c3:1.50, p:2.00, e:10.00, l:3, p:1', 'Josue Romero', 1, '2021-04-04 04:49:17'),
(31, 'producto', 'edita,c:2, n: segundo producto edit, d:descricp segundo edit, b:def, c1:10, c2:15, c3:150, p:20, e:100, l:0, p:0', 'Josue Romero', 1, '2021-04-04 04:57:29'),
(32, 'producto', 'edita,c:2, n: segundo producto edit, d:descricp segundo edit, b:def, c1:10, c2:15, c3:150, p:20, e:100, l:0, p:0', 'Josue Romero', 1, '2021-04-04 04:57:59'),
(33, 'producto', 'edita,c:2, n: segundo producto, d:descricp segundo, b:def, c1:1.00, c2:0.50, c3:1.50, p:2.00, e:10.00, l:0, p:0', 'Josue Romero', 1, '2021-04-04 04:58:04'),
(34, 'producto', 'edita,c:2, n: segundo producto, d:descricp segundo, b:def, c1:1.00, c2:0.50, c3:1.50, p:2.00, e:10.00, l:0, p:0', 'Josue Romero', 1, '2021-04-04 04:58:53'),
(35, 'producto', 'edita,c:2, n: segundo producto, d:descricp segundo, b:def, c1:1.00, c2:0.50, c3:1.50, p:2.00, e:10.00, l:0, p:0', 'Josue Romero', 1, '2021-04-04 05:00:22'),
(36, 'producto', 'edita,c:2, n: segundo producto, d:descricp segundo, b:def, c1:1.00, c2:0.50, c3:1.50, p:2.00, e:10.00, l:0, p:0', 'Josue Romero', 1, '2021-04-04 05:02:03'),
(37, 'producto', 'edita,c:2, n: segundo producto, d:descricp segundo, b:def, c1:1.00, c2:0.50, c3:1.50, p:2.00, e:10.00, l:0, p:0', 'Josue Romero', 1, '2021-04-04 05:28:22'),
(38, 'producto', 'edita,c:2, n: segundo producto, d:descricp segundo, b:def, c1:1.00, c2:0.50, c3:1.50, p:2.00, e:10.00, l:2, p:1', 'Josue Romero', 1, '2021-04-04 05:28:31'),
(39, 'producto', 'edita,c:2, n: segundo producto, d:descricp segundo, b:def, c1:1, c2:2, c3:3, p:2.00, e:10.00, l:2, p:1', 'Josue Romero', 1, '2021-04-04 05:28:41'),
(40, 'producto', 'elimina, c:2, n: segundo producto, d:descricp segundo, b:def, c1:1.00, c2:2.00, c3:3.00, p:2.00, e:10.00, l:2, p:1', 'Josue Romero', 1, '2021-04-04 05:30:56'),
(41, 'producto', 'crea, c:0, n: asd, d:, b:sdf, c1:, c2:, c3:, p:, e:, l:0, p:0', 'Josue Romero', 1, '2021-04-04 05:32:09'),
(42, 'producto', 'crea, c:0, n: uuuuu, d:, b:uuuuu, c1:0, c2:0, c3:0, p:0, e:0, l:0, p:0', 'Josue Romero', 1, '2021-04-04 05:37:39'),
(43, 'producto', 'elimina, c:4, n: uuuuu, d:, b:uuuuu, c1:0.00, c2:0.00, c3:0.00, p:0.00, e:0.00, l:0, p:0', 'Josue Romero', 1, '2021-04-04 05:37:48'),
(44, 'producto', 'edita,c:3, n: asd, d:, b:sdf, c1:asdf, c2:asdf, c3:0, p:0.00, e:0.00, l:0, p:0', 'Josue Romero', 1, '2021-04-04 06:16:12'),
(45, 'producto', 'edita,c:3, n: asd, d:, b:sdf, c1:0sdfasdf, c2:asdfasdfasdf, c3:0, p:0.00, e:0.00, l:0, p:0', 'Josue Romero', 1, '2021-04-04 06:18:03'),
(46, 'producto', 'crea, c:0, n: asdfasd, d:, b:asdfasdf, c1:  asd  dsd, c2:0, c3:NaN, p:0, e:0, l:0, p:0', 'Josue Romero', 1, '2021-04-04 06:18:26'),
(47, 'producto', 'elimina, c:3, n: asd, d:, b:sdf, c1:0.00, c2:0.00, c3:0.00, p:0.00, e:0.00, l:0, p:0', 'Josue Romero', 1, '2021-04-04 06:18:39'),
(48, 'producto', 'elimina, c:5, n: asdfasd, d:, b:asdfasdf, c1:0.00, c2:0.00, c3:0.00, p:0.00, e:0.00, l:0, p:0', 'Josue Romero', 1, '2021-04-04 06:18:44'),
(49, 'cliente', 'crea, c:0, n: Clientes Varios, p:, d:, r:, c:', 'Josue Romero', 1, '2021-04-04 18:21:54'),
(50, 'cliente', 'edita,c:1, n: Editado, p:sdlkfjsdkjf, d:sdkfjsdkl, r:skdjfk, c:sdkfjsdk', 'Josue Romero', 1, '2021-04-04 18:22:09'),
(51, 'cliente', 'elimina, c:1, n: Editado, p:sdlkfjsdkjf, d:sdkfjsdkl, r:skdjfk, c:sdkfjsdk', 'Josue Romero', 1, '2021-04-04 18:22:18'),
(52, 'Equivalencia', 'crea, c:0, n: asdf, c: 0, cx: 0, ct: 0, p: 0, cntdad: ', 'Josue Romero', 1, '2021-06-30 16:05:29'),
(53, 'Equivalencia', 'crea, c:0, n: zxcv, c: 2, cx: 2, ct: 0, p: 2, cntdad: 5', 'Josue Romero', 1, '2021-06-30 16:09:52'),
(54, 'producto', 'edita,c:97, n: ACETAMINOFEN MK 500 MG X 100 TABLETAS	, d:, b:741000281, c1:0.00, c2:0.00, c3:0.00, p:5.40, e:0.00, l:0, p:0', 'Josue Romero', 1, '2021-06-30 16:24:40'),
(55, 'producto', 'edita,c:97, n: ACETAMINOFEN MK 500 MG X 100 TABLETAS	, d:, b:741000281, c1:0.00, c2:0.00, c3:0.00, p:5.40, e:0.00, l:2, p:1', 'Josue Romero', 1, '2021-06-30 16:24:51'),
(56, 'Equivalencia', 'crea, c:0, n: qwer, c: 0, cx: 0, ct: 55, p: 44, cntdad: 11', 'Josue Romero', 1, '2021-06-30 16:39:56'),
(57, 'Equivalencia', 'crea, c:0, n: yuio, c: 22, cx: 33, ct: 55, p: 44, cntdad: 11', 'Josue Romero', 1, '2021-06-30 16:40:33'),
(58, 'Equivalencia', 'edita,c:1, n: media docena, c: 11, cx: 22, ct: 33, p: 44, cntdad: 6', 'Josue Romero', 1, '2021-06-30 16:45:10'),
(59, 'Equivalencia', 'elimina, c:2, n: zxcv, c: 2.0000, cx: 2.0000, ct: 0.0000, p: 2.0000, cntdad: 5', 'Josue Romero', 1, '2021-06-30 16:49:02'),
(60, 'Equivalencia', 'elimina, c:1, n: media docena, c: 11.0000, cx: 11.0000, ct: 33.0000, p: 44.0000, cntdad: 6', 'Josue Romero', 1, '2021-06-30 16:49:07'),
(61, 'usuario', 'modifico,n:jefe a:jefe,u:jefe,1', 'Josue Romero', 1, '2021-07-01 15:37:53'),
(62, 'usuario', 'modifico,n:jefe 123 a:jefe,u:jefe,1', 'Josue Romero', 1, '2021-07-01 15:38:00'),
(63, 'usuario', 'modifico,n:jefe  a:jefe,u:jefe,1', 'Josue Romero', 1, '2021-07-01 15:38:07'),
(64, 'unidad', 'elimino,n: ', 'Josue Romero', 1, '2021-07-01 17:33:28'),
(65, 'unidad', 'elimino,n: ', 'Josue Romero', 1, '2021-07-01 17:33:48'),
(66, 'unidad', 'elimino,n: ', 'Josue Romero', 1, '2021-07-01 17:33:48'),
(67, 'unidad', 'elimino,n: ', 'Josue Romero', 1, '2021-07-01 17:33:58'),
(68, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:25:37'),
(69, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:26:26'),
(70, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:26:29'),
(71, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:26:30'),
(72, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:28:13'),
(73, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:29:10'),
(74, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:30:40'),
(75, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:30:55'),
(76, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:31:34'),
(77, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:31:40'),
(78, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 10:32:26'),
(79, 'Sucursales', 'modifico,n: agencias', 'Josue Romero', 1, '2021-07-02 14:06:22'),
(80, 'Equivalencia', 'edita,c:3, n: qwer, c: 1, cx: 2, ct: 3, p: 44.0000, cntdad: 11', 'Josue Romero', 1, '2021-07-02 14:07:04'),
(81, 'usuario', 'modifico,n:jefe  a:jefe,u:jefe,1', 'Josue Romero', 1, '2021-07-03 10:01:35'),
(82, 'usuario', 'modifico,n:Josue a:Romero,u:admin,1', 'Josue Romero', 1, '2021-07-03 10:01:42'),
(83, 'usuario', 'modifico,n:jefe  a:jefe,u:jefe,1', 'Josue Romero', 1, '2021-07-03 10:02:58'),
(84, 'usuario', 'modifico,n:jefe  a:jefe,u:jefe,1', 'Josue Romero', 1, '2021-07-03 10:04:05'),
(85, 'usuario', 'modifico,n:Josue a:Romero,u:admin,1', 'Josue Romero', 1, '2021-07-03 10:05:05'),
(86, 'Equivalencia', 'crea, c:0, n: das, c: 0, cx: 0, ct: 0, p: 0, cntdad: 0', 'Josue Romero', 1, '2021-07-03 10:29:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `labo_laboratorio`
--

CREATE TABLE `labo_laboratorio` (
  `labo_codigo` int(11) NOT NULL,
  `labo_nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `labo_pais` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `labo_fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `labo_laboratorio`
--

INSERT INTO `labo_laboratorio` (`labo_codigo`, `labo_nombre`, `labo_pais`, `labo_fecha`) VALUES
(2, 'Laboratorio MK', 'El Salvador', '2021-04-03 17:59:20'),
(3, 'Laboratorios Suiza', 'El Salvador', '2021-04-03 18:02:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_producto`
--

CREATE TABLE `prod_producto` (
  `prod_codigo` int(11) NOT NULL,
  `prod_codigo_barra` varchar(40) COLLATE utf8mb4_general_ci DEFAULT '',
  `prod_nombre` varchar(80) COLLATE utf8mb4_general_ci DEFAULT '',
  `prod_descripcion` varchar(80) COLLATE utf8mb4_general_ci DEFAULT '',
  `prod_existencia` decimal(10,2) DEFAULT '0.00',
  `prod_unidad` varchar(80) COLLATE utf8mb4_general_ci DEFAULT '',
  `prod_costo_compra` decimal(12,2) DEFAULT '0.00',
  `prod_costo_agregado` decimal(12,2) DEFAULT '0.00',
  `prod_costo_total` decimal(12,2) DEFAULT '0.00',
  `prod_precio` decimal(12,2) DEFAULT '0.00',
  `prod_cod_laboratorio` int(11) DEFAULT '0',
  `prod_cod_proveedor` int(11) DEFAULT '0',
  `prod_fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `prod_existencia1` int(11) DEFAULT '0',
  `prod_existencia2` int(11) DEFAULT '0',
  `prod_existencia3` int(11) DEFAULT '0',
  `prod_existencia4` int(11) DEFAULT '0',
  `prod_existencia5` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prod_producto`
--

INSERT INTO `prod_producto` (`prod_codigo`, `prod_codigo_barra`, `prod_nombre`, `prod_descripcion`, `prod_existencia`, `prod_unidad`, `prod_costo_compra`, `prod_costo_agregado`, `prod_costo_total`, `prod_precio`, `prod_cod_laboratorio`, `prod_cod_proveedor`, `prod_fecha`, `prod_existencia1`, `prod_existencia2`, `prod_existencia3`, `prod_existencia4`, `prod_existencia5`) VALUES
(1, 'abc', 'primer producto', 'primer descr', '15.00', 'tableta', '1.00', '0.50', '1.50', '2.00', 2, 1, '2021-04-04 04:25:12', 0, 0, 0, 0, 0),
(6, '741510020', 'ULTRADOCEPLEX MEGA', '', '0.00', '', '0.00', '0.00', '0.00', '9.61', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(7, '745107900', 'ZENTEL SUSPENSION X 10 ML. RM', '', '0.00', '', '0.00', '0.00', '0.00', '4.76', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(8, '750104319', 'ZENTEL 200 MG. X 25 SOBRES X 2 TABLETAS RM', '', '0.00', '', '0.00', '0.00', '0.00', '70.90', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(9, '740101090', 'PASINERVA X 30 CAPSULA', '', '0.00', '', '0.00', '0.00', '0.00', '5.07', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(10, '11418218', 'TABCIN GRIPE Y TOS X 60 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '9.90', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(11, '11418666', 'TABCIN NINOS MASTICABLE X 48 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '5.25', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(12, '11418219', 'TABCIN ADULTO X72 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '10.30', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(13, '741000342', 'IRBESARTAN ECOMED 300 MG. X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '35.20', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(14, '7410003421', 'IRBESARTAN ECOMED 150 MG. X 100 TABLETAS  RM	', '', '0.00', '', '0.00', '0.00', '0.00', '24.20', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(15, '741100215', 'HONGOSIL PLUS SOLUCION X 20 ML', '', '0.00', '', '0.00', '0.00', '0.00', '4.18', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(16, '189017907', 'LOSARTAN POTASICO ARGUS 100 MG X 50 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '19.80', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(17, '189017907', 'PARACETAMOL  ARGUS 500 MG. X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '3.30', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(18, '1890179071', 'AMLODIPINA ARGUS 5MG X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '17.60', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(19, '1890179072', 'ERITROMICINA ARGUS 500 MG. X 50 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '9.66', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(20, '741510020', 'MENOPAUSIA VIJOSA N X 90 CAPSULAS	', '', '0.00', '', '0.00', '0.00', '0.00', '12.68', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(21, '750129821', 'DEXA NEUROBION AMPOLLA ND	', '', '0.00', '', '0.00', '0.00', '0.00', '7.16', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(22, '11418030', 'ASPIRINA NINO X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '7.80', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(23, '11418203', 'CARDIOASPIRINA X 30 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '7.85', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(24, '750112301', 'BEDOYECTA TRI 50000X 5 AMPOLLAS	', '', '0.00', '', '0.00', '0.00', '0.00', '13.67', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(25, '741510020', 'VIROGRIP PM GEL CAPS X 24 SOBRES', '', '0.00', '', '0.00', '0.00', '0.00', '8.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(26, '7414100201', 'VIROGRIP AMPOLLA X 5 ML RM', '', '0.00', '', '0.00', '0.00', '0.00', '1.70', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(27, '890179068', 'AMOXICILINA SM 500 MG X 100 CAPSULAS', '', '0.00', '', '0.00', '0.00', '0.00', '6.60', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(28, '4344', 'BISMUTO COMPUESTO X 100 SOBRES', '', '0.00', '', '0.00', '0.00', '0.00', '15.50', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(29, '71000371', 'DICLOFENACO BK 75 MG. AMPOLLA RM ND', '', '0.00', '', '0.00', '0.00', '0.00', '0.67', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(30, '765446073', 'NERVO TIAMIN X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '9.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(31, '355687451', 'SAL INGLERSA EL TRIUNFO X 50 SOBRES', '', '0.00', '', '0.00', '0.00', '0.00', '3.30', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(32, '764600121', 'MEBENDAMIN X 25 SOBRES X 6 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '49.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(33, '7415100202', 'FENAKER JARABE X 120 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '2.23', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(34, '125458745', 'DEXAMETASONA VJH AMPOLLA 4MG X 2 ML', '', '0.00', '', '0.00', '0.00', '0.00', '2.50', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(35, '83381', 'DICLOFENACO SODICO GEL CAPS SM X 100 RM	', '', '0.00', '', '0.00', '0.00', '0.00', '2.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(36, '741000200', 'DICLOSONA AMPOLLA RM', '', '0.00', '', '0.00', '0.00', '0.00', '5.52', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(37, '890179068', 'LORATADINA SM SUSPENSION X 100', '', '0.00', '', '0.00', '0.00', '0.00', '1.50', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(38, '83038', 'TRIMETOPRIN 960 MG. SM X 100 TABLETAS RM', '', '0.00', '', '0.00', '0.00', '0.00', '4.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(39, '741000342', 'TRAMADOL ECOMED 50 MG. X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '19.80', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(40, '722000200', 'MUSFLEX COMPUESTO X 50 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '20.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(41, '189017907', 'AZITROMUICINA ARGUS 500 MG. X 5 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '9.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(42, '769041002', 'BACZOL EXPECTORANTE X 120 ML. ND', '', '0.00', '', '0.00', '0.00', '0.00', '5.70', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(43, '740604800', 'CROMATOMBIC FERRO X 5 AMPOLLAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '22.95', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(44, '770724392', 'CUAJO MARSHALL X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '11.20', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(45, '779534500', 'SERTAl COMPUESTO X 3 AMPOLLAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '7.75', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(46, '740103610', 'NOVALGINA  X 100 TABLETAS ND	', '', '0.00', '', '0.00', '0.00', '0.00', '6.55', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(47, '74100235', 'RINOFIN X 100 TABLETAS RM', '', '0.00', '', '0.00', '0.00', '0.00', '25.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(48, '18917906', 'ALOPURINOL SM 300 X 100 TABLETAS RM', '', '0.00', '', '0.00', '0.00', '0.00', '6.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(49, '78544614', 'ZORRITONE X 100 CARAMELO', '', '0.00', '', '0.00', '0.00', '0.00', '2.65', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(50, '742000200', 'MUSFLEX COMPUESTO X 50 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '20.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(51, '791000201', 'SUDAGRIP X 100  CAPSULAS', '', '0.00', '', '0.00', '0.00', '0.00', '11.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(52, '741000540', 'ORANGE VIT C X 15 AMPOLLAS BEBIBLES	', '', '0.00', '', '0.00', '0.00', '0.00', '12.39', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(53, '18901907', 'SALBUTAMOL INHALADOR ARGUS X 200	', '', '0.00', '', '0.00', '0.00', '0.00', '3.23', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(54, '741000342', 'METOCARBAMOL ECOMED 500 MG X100 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '9.68', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(55, '74100640', 'ULTRA APETIT JARABE X 220 ML.	', '', '0.00', '', '0.00', '0.00', '0.00', '8.68', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(56, '74100046', 'GLUTAPLEX CEREBRAL JARABE X 220 ML.	', '', '0.00', '', '0.00', '0.00', '0.00', '5.42', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(57, '741000567', 'SECNI PARA X 500 MG X 4 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '5.08', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(58, '74100054012', 'SECNI PARA X SUSPENSIÃ“N X 30 ML.	', '', '0.00', '', '0.00', '0.00', '0.00', '4.29', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(59, '741005412', 'HEMOTOTAL  JARABE X 220 ML', '', '0.00', '', '0.00', '0.00', '0.00', '7.44', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(60, '741005413', 'BRONK OFLU HEDERA JARABE X 120ML.	', '', '0.00', '', '0.00', '0.00', '0.00', '5.94', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(61, '751000540', 'DOL JARABE120 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '2.51', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(62, '75104611', 'COMPLEJO B FUERTE X10 CC RM	', '', '0.00', '', '0.00', '0.00', '0.00', '1.38', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(63, '4389', 'PIOJIN X 12 BURBUJA', '', '0.00', '', '0.00', '0.00', '0.00', '2.25', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(64, '470051106', 'TOMA PARA EMPACHO SALUFRAMA SOBRE', '', '0.00', '', '0.00', '0.00', '0.00', '0.55', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(65, '890179068', 'NEUROTROPAS 25000 SM AMP. JERINGA', '', '0.00', '', '0.00', '0.00', '0.00', '1.80', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(66, '789611688', 'MICROGYNON X 21 GRAGEAS	', '', '0.00', '', '0.00', '0.00', '0.00', '4.68', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(67, '741000371', 'DOLO ULTRAESTRES X 20 SOB X 4 CAP RM ND', '', '0.00', '', '0.00', '0.00', '0.00', '8.65', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(68, '741000342', 'PREDNISONA ECOMED 5 MG X 100TABLETAS RM', '', '0.00', '', '0.00', '0.00', '0.00', '8.80', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(69, '711604102', 'IBUPROFENO GAMMA SUSPENSION X 120 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '1.63', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(70, '769041045', 'INTESTINOMICINA AD CAPSULAS ND', '', '0.00', '', '0.00', '0.00', '0.00', '12.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(71, '741002602', 'ANADENT TODO DOLOR X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '15.15', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(72, '740107896', 'SARGENOR FORTE X 10 AMPOLLA BEBIBLES RM	', '', '0.00', '', '0.00', '0.00', '0.00', '19.93', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(73, '769041009', 'ALERFIN 4MG. X 200 TABLETAS ND	', '', '0.00', '', '0.00', '0.00', '0.00', '19.72', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(74, '741000070', 'CLORFENIRAMINA FD 8MG X 25 SOBRES X 4 TAB	', '', '0.00', '', '0.00', '0.00', '0.00', '14.66', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(75, '769041001', 'VERMEX SUSPENSION X 30 ML ND', '', '0.00', '', '0.00', '0.00', '0.00', '2.78', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(76, '711604100', 'CLORANFENICOL GAMMA COLIRIO X 15 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '1.55', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(77, '741006120', 'MAGNESIA CALCINADA SOBRE X 15 GR.	', '', '0.00', '', '0.00', '0.00', '0.00', '1.44', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(78, '741000280', 'TETRACICLINA MK 500 MG X 100 CAPSULAS RM', '', '0.00', '', '0.00', '0.00', '0.00', '7.55', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(79, '741510020', 'ULTRADOCEPLEX AMPOLLA RM	', '', '0.00', '', '0.00', '0.00', '0.00', '3.83', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(80, '189017907', 'NAPPIL 550 MG X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '8.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(81, '741510022', 'NERVIDOCE 25000 AMPOLLAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '2.30', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(82, '7410000371', 'ARTRIBION VITAMINADO AMPOLLAS RM ND	', '', '0.00', '', '0.00', '0.00', '0.00', '2.72', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(83, '1000371', 'FOSKROL DESESTRESANTE X10 AMP.BEB .ND	', '', '0.00', '', '0.00', '0.00', '0.00', '4.45', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(84, '751000201', 'SUDAGRIP CARAMELO X 100', '', '0.00', '', '0.00', '0.00', '0.00', '2.88', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(85, '790179068', 'GENTA + BETA + CLOTRI SM CREMA X 3O GR RMA	', '', '0.00', '', '0.00', '0.00', '0.00', '0.70', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(86, '161000540', 'FLUCONAZOL ARGUS 200 MG X 2 CPS RM', '', '0.00', '', '0.00', '0.00', '0.00', '3.52', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(87, '799110600', 'CANESTEN CREMA VAGINAL 1 % X 35 GR', '', '0.00', '', '0.00', '0.00', '0.00', '9.93', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(88, '733331168', 'YASMIN X 21 COMPRIMIDOS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '13.33', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(89, '751000342', 'LOSARTAN ECOMED 50 MG X 100 TABLETAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '13.20', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(90, '35874954', 'GARGANTINAS X 50 BLISTERS Y 6 CARAMELOS', '', '0.00', '', '0.00', '0.00', '0.00', '16.94', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(91, '750129826', 'NEUROBION X 120 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '35.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(92, '1510021', 'ULTRADOCEPLEX X 12 AMPOLLAS BEBIBLES	', '', '0.00', '', '0.00', '0.00', '0.00', '6.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(93, '79100021', 'SELECTAVIT AMPOLLA X 10 ML RM	', '', '0.00', '', '0.00', '0.00', '0.00', '1.36', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(94, '189874512', 'CLORFENIRAMINA GAMMA 8 MG X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '3.50', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(95, '15100024', 'ULTRADOCEPLEX MEGA MAN X 50 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '3.50', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(96, '75129822', 'ERITROMICINA ARGUS 500 MG. X 50 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '9.68', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(97, '741000281', 'ACETAMINOFEN MK 500 MG X 100 TABLETAS	', '', '0.00', 'unidad', '0.00', '0.00', '0.00', '5.40', 2, 1, '2021-06-30 16:24:51', 0, 0, 0, 0, 0),
(98, '750240024', 'NIKZON X 40 TABLETAS MASTICABLES', '', '0.00', '', '0.00', '0.00', '0.00', '9.75', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(99, '741690410', 'ARTRIFIN VITAMINADO X 20 SOBRES	', '', '0.00', '', '0.00', '0.00', '0.00', '6.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(100, '750240001', 'NIKZON X 90 TABLETAS MASTICABLES	', '', '0.00', '', '0.00', '0.00', '0.00', '19.05', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(101, '745107900', 'PANADOL INFANTIL X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '6.85', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(102, '74101931', 'ACETAMINOFEN MK GOTAS X 30 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '5.30', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(103, '4001077892', 'AVAMIGRAN X 200 TABLETAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '46.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(104, '75012932', 'DOLO NEUROBION X 120 TABLETAS ND.RM	', '', '0.00', '', '0.00', '0.00', '0.00', '34.50', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(105, '741009363', 'ARTRIBION VITAMINADO X 20 SOBRES RM ND', '', '0.00', '', '0.00', '0.00', '0.00', '20.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(106, '790179068', 'DICLOFENAC SODICO PL AMPOLLA RM', '', '0.00', '', '0.00', '0.00', '0.00', '1.33', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(107, '75013392', 'DAYAMINERAL JARABE X 240 ML', '', '0.00', '', '0.00', '0.00', '0.00', '13.23', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(108, '7410000260', 'NORPURINOL X 30 TAVLETAS RM', '', '0.00', '', '0.00', '0.00', '0.00', '6.92', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(109, '741000371', 'LAGRIMAS DE BIOMIXIN X 100 ND', '', '0.00', '', '0.00', '0.00', '0.00', '5.50', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(110, '76035131', 'NAZIL OFTENO X 15 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '2.87', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(111, '13354', 'SILDENAFIL SM 100 MG X 4 TABLETAS RM', '', '0.00', '', '0.00', '0.00', '0.00', '3.52', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(112, '741000163', 'HIGAVIT 5 AMPOLLA X 10 CC RM	', '', '0.00', '', '0.00', '0.00', '0.00', '1.38', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(113, '74104611', 'COMPLEJO B FUERTE PAIL AMPOLLA X 10 CC RM	', '', '0.00', '', '0.00', '0.00', '0.00', '1.38', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(114, '741006120', 'ROJAMINA FUERTE 50000 AMPOLLA X 10 CC RM	', '', '0.00', '', '0.00', '0.00', '0.00', '5.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(115, '745207970', 'SINSUENO X 100 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '11.14', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(116, '764600121', 'MEDOX  PRENATAL X 30 GRAGEAS', '', '0.00', '', '0.00', '0.00', '0.00', '11.14', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(117, '5374', 'PEINE FINO GRANDE DOCENA', '', '0.00', '', '0.00', '0.00', '0.00', '0.75', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(118, '569041002', 'CLOTEN UNA X1 CAPSULA', '', '0.00', '', '0.00', '0.00', '0.00', '3.13', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(119, '741000371', 'BIOBENZOLE X 20 SOBRES X TABLETAS ND	', '', '0.00', '', '0.00', '0.00', '0.00', '9.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(120, '741000370', 'FOSKROL ESCOLAR X 15 AMPOLLAS BEBIBLES', '', '0.00', '', '0.00', '0.00', '0.00', '4.60', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(121, '741000540', 'APETTI KID JARABE X 220 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '5.70', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(122, '741100260', 'RABANO YODADO LAINEZ  X 240 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '1.58', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(123, '11418040', 'ALKASELTZER X 60 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '8.65', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(124, '741000540', 'SECNI PARAX 500 MG X 4 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '5.08', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(125, '741005401', 'SECNI PARAX SUSPENSION X 30 ML.	', '', '0.00', '', '0.00', '0.00', '0.00', '4.29', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(126, '741000375', 'TRICALCIO X 10 AMPOLLA BEBIBLES', '', '0.00', '', '0.00', '0.00', '0.00', '4.50', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(127, '12849020', 'KOMILON JARABE X 120 ML.	', '', '0.00', '', '0.00', '0.00', '0.00', '3.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(128, '82940', 'OMEPRAZOL SM 20 MG X 100 CAPSULAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '4.30', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(129, '332220', 'RANITIDINA SM 150 MG X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '1.80', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(130, '741510022', 'NEURO CAMPOLON ENERGY X 12 AMPOLLAS BEBIBLES', '', '0.00', '', '0.00', '0.00', '0.00', '6.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(131, '71510022', 'FORTIPLEX OMEGA 3 X 50 SOFTGELS	', '', '0.00', '', '0.00', '0.00', '0.00', '8.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(132, '789041001', 'ESPASMOFIN X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '14.39', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(133, '470051102', 'BICARBONATO DE SODIO 500 MG X 100 CAPSULAS	', '', '0.00', '', '0.00', '0.00', '0.00', '9.33', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(134, '758745120', 'BICARBONATO DE SODIO 800 MG. X 100 CAPSULAS', '', '0.00', '', '0.00', '0.00', '0.00', '9.33', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(135, '741510020', 'ULTRADOCEPLEX MEGA WOMAN X 50 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '9.60', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(136, '759041002', 'UROFIN POLVO X 100 SOBRES', '', '0.00', '', '0.00', '0.00', '0.00', '23.85', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(137, '7410000332', 'COLIPAX X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '11.75', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(138, '7501103790', 'BUSCAPINA 10 MG X 24 GRAGEAS', '', '0.00', '', '0.00', '0.00', '0.00', '8.41', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(139, '759041045', 'INTESTINOMICINA AD X 100 CAPSULAS', '', '0.00', '', '0.00', '0.00', '0.00', '11.60', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(140, '745207971', 'NOVOMIT X 250 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '21.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(141, '21418240', 'ALKA D X 60 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '10.75', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(142, '90179068', 'ENALAPRIL SM 20 MH X 100 TABLETAS RM', '', '0.00', '', '0.00', '0.00', '0.00', '2.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(143, '544113940', 'DEPO PROVERA 150 MG AMPOLLAS ND RM', '', '0.00', '', '0.00', '0.00', '0.00', '10.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(144, '74104598', 'NOVULAR AMPOLLA X 1 ML. RM', '', '0.00', '', '0.00', '0.00', '0.00', '3.16', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(145, '10000340', 'FINADOL MUJER 200 MG X 50 SOBRES X TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '7.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(146, '7415100022', 'NOMAGEST AMPOLA X 1 ML.RM', '', '0.00', '', '0.00', '0.00', '0.00', '4.27', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(147, '7401114005', 'REGULADOR GESTEIRA X 120 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '5.62', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(148, '7510000211', 'PERLA X 24 SOBRES ND', '', '0.00', '', '0.00', '0.00', '0.00', '43.50', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(149, '750110463', 'CUERPO AMARILLO AMPOLLA X 2 ML. RM', '', '0.00', '', '0.00', '0.00', '0.00', '4.56', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(150, '741510025', 'VERMAGEST X 2 TABLETAS RM', '', '0.00', '', '0.00', '0.00', '0.00', '8.25', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(151, '764600113', 'UNICIL L. A. 1.2 UNIDADES AMPOLLAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '3.98', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(152, '771000077', 'CIPROFLOXACINA SM 500 MG X 100 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '5.50', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(153, '76100194', 'FENAKLER AMPOLLA X 1 ML RM', '', '0.00', '', '0.00', '0.00', '0.00', '2.04', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(154, '711418206', 'DORIVAL LIQUI GELS X 36 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '10.05', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(155, '750104317', 'VENTOLIN INHALADOR X200 DOSIS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '6.17', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(156, '7555446120', 'OIDOL GOTAS X 15 ML.	', '', '0.00', '', '0.00', '0.00', '0.00', '2.40', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(157, '740110460', 'BETA 2 PAN AMPOLLA RM', '', '0.00', '', '0.00', '0.00', '0.00', '9.12', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(158, '7510000540', 'ORANGE VIT C JARABE X22O ML	', '', '0.00', '', '0.00', '0.00', '0.00', '7.28', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(159, '721000201', 'DRAMANYL X 100 CAPSULAS', '', '0.00', '', '0.00', '0.00', '0.00', '8.72', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(160, '761000371', 'FOSKROL X 15 AMPOLLA BEBIBLES ND', '', '0.00', '', '0.00', '0.00', '0.00', '4.55', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(161, '741000371', 'BIOBENZOLE SUSPENSION X 30 ML. ND', '', '0.00', '', '0.00', '0.00', '0.00', '0.76', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(162, '769041009', 'VERMEX TOTAL 500 MG X 6 TABLETAS ND', '', '0.00', '', '0.00', '0.00', '0.00', '3.99', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(163, '744101310', 'MATRICARIA POLVO X 20	', '', '0.00', '', '0.00', '0.00', '0.00', '2.20', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(164, '76544641', 'SUPER TIAMINA 300 X 100 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '6.25', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(165, '7410000371', 'FOSKROL COMPLEX X 30 TABLETAS ND', '', '0.00', '', '0.00', '0.00', '0.00', '2.55', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(166, '7501799055', 'DOLO NEUROTROPAS SM X 20 SOB X 4 TABS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '7.80', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(167, '755207970', 'FOSFO B12 X 15 AMPOLLAS BEBIBLES', '', '0.00', '', '0.00', '0.00', '0.00', '13.67', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(168, '744410187', 'SAL ANDREWS X 50 SOBRES', '', '0.00', '', '0.00', '0.00', '0.00', '6.35', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(169, '78904145', 'INTESTINOMINA AD X 100 CAPSULAS ND', '', '0.00', '', '0.00', '0.00', '0.00', '17.81', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(170, '741510022', 'VIROGRIP A.M. TE X 24 SOBRES', '', '0.00', '', '0.00', '0.00', '0.00', '8.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(171, '7415100022', 'VIROGRIP P.M TE X 24SOBRES	', '', '0.00', '', '0.00', '0.00', '0.00', '8.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(172, '741510020', 'FENALER JARABE X 120 M.L', '', '0.00', '', '0.00', '0.00', '0.00', '2.22', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(173, '760219510', 'CREMOQUINONA 4% X 30 GR. RM', '', '0.00', '', '0.00', '0.00', '0.00', '7.88', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(174, '789041052', 'DESMOXIDO CREMA LATA ND', '', '0.00', '', '0.00', '0.00', '0.00', '0.98', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(175, '750103392', 'PENICILINA UNGÃœENTO LATA LOPEZ X 12 GR. ND', '', '0.00', '', '0.00', '0.00', '0.00', '0.82', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(176, '741510020', 'VIROGRIP AM GEL CAPS X 24 SOBRES	', '', '0.00', '', '0.00', '0.00', '0.00', '8.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(177, '735987429', 'LOSARTAN SM 50 MG. X 50 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '9.60', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(178, '750129821', 'DEXA NEUROBION AMPOLLA ND	', '', '0.00', '', '0.00', '0.00', '0.00', '7.16', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(179, '7415100200', 'VIROGRIP GRIPE Y TOS X 120 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '2.90', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(180, '765446120', 'ZORRITONE JARABE X120 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '2.09', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(181, '74101726', 'ACETAMINOFEN MK JARABE X 60 ML', '', '0.00', '', '0.00', '0.00', '0.00', '2.59', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(182, '74109364', 'DICLOFENAC SODICO PL AMPOLLA RM', '', '0.00', '', '0.00', '0.00', '0.00', '1.33', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(183, '741410020', 'DOLO NERVIDOCE AMPOLLA RM	', '', '0.00', '', '0.00', '0.00', '0.00', '1.80', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(184, '759041045', 'DOLOFIN RAPIDA ACCION X 100 TABLETAS ND	', '', '0.00', '', '0.00', '0.00', '0.00', '6.65', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(185, '74160020', 'DOLAREN AMPOLLA X 2 ML RN	', '', '0.00', '', '0.00', '0.00', '0.00', '0.65', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(186, '1148205', 'DORIVAL 200 MG. X 60 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '11.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(187, '82938', 'IBUPROFENO SM 600 MG X 100 TABLETAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '4.80', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(188, '741000280', 'METFORMINA MK 850 MG. X 30 TABLETAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '7.71', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(189, '741000080', 'PARACETAMOL MK 750 MG. X 100 CAPSULAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '22.58', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(190, '741000260', 'SALVADOL X 25 SOBRES X 2 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '4.80', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(191, '741000281', 'METFORMINA MK 1000 MG. X 30 TABLETAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '13.64', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(192, '852019491', 'AZIMEX 500 MG .X 9 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '20.92', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(193, '124', 'AGUA DESTILANDA VHJ X 10 CC. RM ND	', '', '0.00', '', '0.00', '0.00', '0.00', '1.44', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(194, '741000612', 'ALCANFOR FORSON LIBRA	', '', '0.00', '', '0.00', '0.00', '0.00', '36.00', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(195, '750112510', 'SOLUCION SALINA NORMAL PISA X 250 ML	', '', '0.00', '', '0.00', '0.00', '0.00', '1.43', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(196, '750129821', 'NEUROBION 25000 X 1 AMPOLLA X 3 ML. RM ND	', '', '0.00', '', '0.00', '0.00', '0.00', '7.90', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(197, '741510020', 'ROCEFORT 1 GR. AMPOLLA INTRAMUSCULAR RM', '', '0.00', '', '0.00', '0.00', '0.00', '3.90', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(198, '189017907', 'DICLOFENACO SODICO SM 50 MG X 100 TABLETAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '0.86', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(199, '741000260', 'ANADENT X 25 SOBRES X 4 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '15.15', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(200, '189017907', 'ATORVASTATINA ARGUS 40 MG X 30 TABLETAS RM.	', '', '0.00', '', '0.00', '0.00', '0.00', '21.12', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(201, '189017905', 'ATORVASTATINA ARGUS 20 MG X 30 TABLETAS RM.	', '', '0.00', '', '0.00', '0.00', '0.00', '14.74', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(202, '74107087', 'VITADAK 15 AMPOLLA BEBIBLE	', '', '0.00', '', '0.00', '0.00', '0.00', '3.58', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(203, '74107735', 'VITADAK 5 AMPOLLA BEBIBLE	', '', '0.00', '', '0.00', '0.00', '0.00', '3.42', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(204, '7410000342', 'METFORMINA  ECOMED 500 MG X 100 TABLETAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '9.68', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(205, '456874512', 'DEXAMETASONA SM AMPOLLA 8 MG. X  ML. RM	', '', '0.00', '', '0.00', '0.00', '0.00', '0.36', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(206, '770376365', 'GENTAMICINA LS 160 MG. X1 AMPOLLA	', '', '0.00', '', '0.00', '0.00', '0.00', '2.58', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(207, '779308108', 'QUADRIERM CREMA X 30 GR. RM ND	', '', '0.00', '', '0.00', '0.00', '0.00', '22.93', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(208, '764600212', 'NEOBOL SPRAY X 30 ML . RM	', '', '0.00', '', '0.00', '0.00', '0.00', '5.62', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(209, '741000341', 'IBUPROFENO ECOMED 600 MG. X 60 TABLETAS', '', '0.00', '', '0.00', '0.00', '0.00', '7.04', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(210, '764600212', 'NEOBOL CREMA X 30 GR. RM	', '', '0.00', '', '0.00', '0.00', '0.00', '5.24', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(211, '765446470', 'PROSTAMEN X 30 CAPSULAS RM	', '', '0.00', '', '0.00', '0.00', '0.00', '14.69', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0),
(212, '83276', 'METFORMINA SM 850 MG X 100 TABLETAS	', '', '0.00', '', '0.00', '0.00', '0.00', '7.20', 0, 0, '2021-04-04 06:59:38', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prov_proveedor`
--

CREATE TABLE `prov_proveedor` (
  `prov_codigo` int(11) NOT NULL,
  `prov_nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `prov_direccion` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `prov_pais` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `prov_responsable` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `prov_contacto` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '',
  `prov_fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prov_proveedor`
--

INSERT INTO `prov_proveedor` (`prov_codigo`, `prov_nombre`, `prov_direccion`, `prov_pais`, `prov_responsable`, `prov_contacto`, `prov_fecha`) VALUES
(1, 'Distribuidora F', 'Direccion', 'El Salvador', 'Carlos Guzman', '2550-5005', '2021-04-03 18:25:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucu_sucursal`
--

CREATE TABLE `sucu_sucursal` (
  `sucu_codigo` int(11) NOT NULL,
  `sucu_nombre` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sucu_descripcion` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sucu_orden` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucu_sucursal`
--

INSERT INTO `sucu_sucursal` (`sucu_codigo`, `sucu_nombre`, `sucu_descripcion`, `sucu_orden`) VALUES
(1, '#1 AGENCIA #1 one', 'desc edit one', 11),
(2, '#2 AGENCIA #2 edit two', 'desc edit two', 22),
(3, '#3 AGENCIA #3 edit three', 'desc edit three', 33),
(4, '#4 AGENCIA #4 edit four', 'desc edit four', 44),
(5, '#5 AGENCIA #5 edit five', 'desc edit five', 55);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucu_usuario`
--

CREATE TABLE `sucu_usuario` (
  `sucu_usua_codigo` int(11) NOT NULL,
  `sucu_usuario_codigo` int(11) DEFAULT NULL,
  `sucu_sucursal_codigo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucu_usuario`
--

INSERT INTO `sucu_usuario` (`sucu_usua_codigo`, `sucu_usuario_codigo`, `sucu_sucursal_codigo`) VALUES
(20, 2, 1),
(21, 2, 5),
(22, 1, 1),
(23, 1, 3),
(24, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabl_temporal`
--

CREATE TABLE `tabl_temporal` (
  `codigo` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nombre` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tabl_temporal`
--

INSERT INTO `tabl_temporal` (`codigo`, `nombre`, `precio`) VALUES
('741510020', 'ULTRADOCEPLEX MEGA', '9.61'),
('745107900', 'ZENTEL SUSPENSION X 10 ML. RM', '4.76'),
('750104319', 'ZENTEL 200 MG. X 25 SOBRES X 2 TABLETAS RM', '70.90'),
('740101090', 'PASINERVA X 30 CAPSULA', '5.07'),
('11418218', 'TABCIN GRIPE Y TOS X 60 TABLETAS	', '9.90'),
('11418666', 'TABCIN NINOS MASTICABLE X 48 TABLETAS', '5.25'),
('11418219', 'TABCIN ADULTO X72 TABLETAS', '10.30'),
('741000342', 'IRBESARTAN ECOMED 300 MG. X 100 TABLETAS', '35.20'),
('7410003421', 'IRBESARTAN ECOMED 150 MG. X 100 TABLETAS  RM	', '24.20'),
('741100215', 'HONGOSIL PLUS SOLUCION X 20 ML', '4.18'),
('189017907', 'LOSARTAN POTASICO ARGUS 100 MG X 50 TABLETAS	', '19.80'),
('189017907', 'PARACETAMOL  ARGUS 500 MG. X 100 TABLETAS', '3.30'),
('1890179071', 'AMLODIPINA ARGUS 5MG X 100 TABLETAS', '17.60'),
('1890179072', 'ERITROMICINA ARGUS 500 MG. X 50 TABLETAS', '9.66'),
('741510020', 'MENOPAUSIA VIJOSA N X 90 CAPSULAS	', '12.68'),
('750129821', 'DEXA NEUROBION AMPOLLA ND	', '7.16'),
('11418030', 'ASPIRINA NINO X 100 TABLETAS', '7.80'),
('11418203', 'CARDIOASPIRINA X 30 TABLETAS	', '7.85'),
('750112301', 'BEDOYECTA TRI 50000X 5 AMPOLLAS	', '13.67'),
('741510020', 'VIROGRIP PM GEL CAPS X 24 SOBRES', '8.00'),
('7414100201', 'VIROGRIP AMPOLLA X 5 ML RM', '1.70'),
('890179068', 'AMOXICILINA SM 500 MG X 100 CAPSULAS', '6.60'),
('4344', 'BISMUTO COMPUESTO X 100 SOBRES', '15.50'),
('71000371', 'DICLOFENACO BK 75 MG. AMPOLLA RM ND', '0.67'),
('765446073', 'NERVO TIAMIN X 100 TABLETAS', '9.40'),
('355687451', 'SAL INGLERSA EL TRIUNFO X 50 SOBRES', '3.30'),
('764600121', 'MEBENDAMIN X 25 SOBRES X 6 TABLETAS', '49.40'),
('7415100202', 'FENAKER JARABE X 120 ML	', '2.23'),
('125458745', 'DEXAMETASONA VJH AMPOLLA 4MG X 2 ML', '2.50'),
('83381', 'DICLOFENACO SODICO GEL CAPS SM X 100 RM	', '2.40'),
('741000200', 'DICLOSONA AMPOLLA RM', '5.52'),
('890179068', 'LORATADINA SM SUSPENSION X 100', '1.50'),
('83038', 'TRIMETOPRIN 960 MG. SM X 100 TABLETAS RM', '4.00'),
('741000342', 'TRAMADOL ECOMED 50 MG. X 100 TABLETAS', '19.80'),
('722000200', 'MUSFLEX COMPUESTO X 50 TABLETAS	', '20.00'),
('189017907', 'AZITROMUICINA ARGUS 500 MG. X 5 TABLETAS', '9.40'),
('769041002', 'BACZOL EXPECTORANTE X 120 ML. ND', '5.70'),
('740604800', 'CROMATOMBIC FERRO X 5 AMPOLLAS RM	', '22.95'),
('770724392', 'CUAJO MARSHALL X 100 TABLETAS', '11.20'),
('779534500', 'SERTAl COMPUESTO X 3 AMPOLLAS RM	', '7.75'),
('740103610', 'NOVALGINA  X 100 TABLETAS ND	', '6.55'),
('74100235', 'RINOFIN X 100 TABLETAS RM', '25.00'),
('18917906', 'ALOPURINOL SM 300 X 100 TABLETAS RM', '6.00'),
('78544614', 'ZORRITONE X 100 CARAMELO', '2.65'),
('742000200', 'MUSFLEX COMPUESTO X 50 TABLETAS	', '20.00'),
('791000201', 'SUDAGRIP X 100  CAPSULAS', '11.40'),
('741000540', 'ORANGE VIT C X 15 AMPOLLAS BEBIBLES	', '12.39'),
('18901907', 'SALBUTAMOL INHALADOR ARGUS X 200	', '3.23'),
('741000342', 'METOCARBAMOL ECOMED 500 MG X100 TABLETAS	', '9.68'),
('74100640', 'ULTRA APETIT JARABE X 220 ML.	', '8.68'),
('74100046', 'GLUTAPLEX CEREBRAL JARABE X 220 ML.	', '5.42'),
('741000567', 'SECNI PARA X 500 MG X 4 TABLETAS	', '5.08'),
('74100054012', 'SECNI PARA X SUSPENSIÃ“N X 30 ML.	', '4.29'),
('741005412', 'HEMOTOTAL  JARABE X 220 ML', '7.44'),
('741005413', 'BRONK OFLU HEDERA JARABE X 120ML.	', '5.94'),
('751000540', 'DOL JARABE120 ML	', '2.51'),
('75104611', 'COMPLEJO B FUERTE X10 CC RM	', '1.38'),
('4389', 'PIOJIN X 12 BURBUJA', '2.25'),
('470051106', 'TOMA PARA EMPACHO SALUFRAMA SOBRE', '0.55'),
('890179068', 'NEUROTROPAS 25000 SM AMP. JERINGA', '1.80'),
('789611688', 'MICROGYNON X 21 GRAGEAS	', '4.68'),
('741000371', 'DOLO ULTRAESTRES X 20 SOB X 4 CAP RM ND', '8.65'),
('741000342', 'PREDNISONA ECOMED 5 MG X 100TABLETAS RM', '8.80'),
('711604102', 'IBUPROFENO GAMMA SUSPENSION X 120 ML	', '1.63'),
('769041045', 'INTESTINOMICINA AD CAPSULAS ND', '12.40'),
('741002602', 'ANADENT TODO DOLOR X 100 TABLETAS', '15.15'),
('740107896', 'SARGENOR FORTE X 10 AMPOLLA BEBIBLES RM	', '19.93'),
('769041009', 'ALERFIN 4MG. X 200 TABLETAS ND	', '19.72'),
('741000070', 'CLORFENIRAMINA FD 8MG X 25 SOBRES X 4 TAB	', '14.66'),
('769041001', 'VERMEX SUSPENSION X 30 ML ND', '2.78'),
('711604100', 'CLORANFENICOL GAMMA COLIRIO X 15 ML	', '1.55'),
('741006120', 'MAGNESIA CALCINADA SOBRE X 15 GR.	', '1.44'),
('741000280', 'TETRACICLINA MK 500 MG X 100 CAPSULAS RM', '7.55'),
('741510020', 'ULTRADOCEPLEX AMPOLLA RM	', '3.83'),
('189017907', 'NAPPIL 550 MG X 100 TABLETAS', '8.40'),
('741510022', 'NERVIDOCE 25000 AMPOLLAS RM	', '2.30'),
('7410000371', 'ARTRIBION VITAMINADO AMPOLLAS RM ND	', '2.72'),
('1000371', 'FOSKROL DESESTRESANTE X10 AMP.BEB .ND	', '4.45'),
('751000201', 'SUDAGRIP CARAMELO X 100', '2.88'),
('790179068', 'GENTA + BETA + CLOTRI SM CREMA X 3O GR RMA	', '0.70'),
('161000540', 'FLUCONAZOL ARGUS 200 MG X 2 CPS RM', '3.52'),
('799110600', 'CANESTEN CREMA VAGINAL 1 % X 35 GR', '9.93'),
('733331168', 'YASMIN X 21 COMPRIMIDOS RM	', '13.33'),
('751000342', 'LOSARTAN ECOMED 50 MG X 100 TABLETAS RM	', '13.20'),
('35874954', 'GARGANTINAS X 50 BLISTERS Y 6 CARAMELOS', '16.94'),
('750129826', 'NEUROBION X 120 TABLETAS', '35.00'),
('1510021', 'ULTRADOCEPLEX X 12 AMPOLLAS BEBIBLES	', '6.00'),
('79100021', 'SELECTAVIT AMPOLLA X 10 ML RM	', '1.36'),
('189874512', 'CLORFENIRAMINA GAMMA 8 MG X 100 TABLETAS', '3.50'),
('15100024', 'ULTRADOCEPLEX MEGA MAN X 50 TABLETAS', '3.50'),
('75129822', 'ERITROMICINA ARGUS 500 MG. X 50 TABLETAS', '9.68'),
('741000281', 'ACETAMINOFEN MK 500 MG X 100 TABLETAS	', '5.40'),
('750240024', 'NIKZON X 40 TABLETAS MASTICABLES', '9.75'),
('741690410', 'ARTRIFIN VITAMINADO X 20 SOBRES	', '6.40'),
('750240001', 'NIKZON X 90 TABLETAS MASTICABLES	', '19.05'),
('745107900', 'PANADOL INFANTIL X 100 TABLETAS', '6.85'),
('74101931', 'ACETAMINOFEN MK GOTAS X 30 ML	', '5.30'),
('4001077892', 'AVAMIGRAN X 200 TABLETAS RM	', '46.00'),
('75012932', 'DOLO NEUROBION X 120 TABLETAS ND.RM	', '34.50'),
('741009363', 'ARTRIBION VITAMINADO X 20 SOBRES RM ND', '20.00'),
('790179068', 'DICLOFENAC SODICO PL AMPOLLA RM', '1.33'),
('75013392', 'DAYAMINERAL JARABE X 240 ML', '13.23'),
('7410000260', 'NORPURINOL X 30 TAVLETAS RM', '6.92'),
('741000371', 'LAGRIMAS DE BIOMIXIN X 100 ND', '5.50'),
('76035131', 'NAZIL OFTENO X 15 ML	', '2.87'),
('13354', 'SILDENAFIL SM 100 MG X 4 TABLETAS RM', '3.52'),
('741000163', 'HIGAVIT 5 AMPOLLA X 10 CC RM	', '1.38'),
('74104611', 'COMPLEJO B FUERTE PAIL AMPOLLA X 10 CC RM	', '1.38'),
('741006120', 'ROJAMINA FUERTE 50000 AMPOLLA X 10 CC RM	', '5.00'),
('745207970', 'SINSUENO X 100 TABLETAS	', '11.14'),
('764600121', 'MEDOX  PRENATAL X 30 GRAGEAS', '11.14'),
('5374', 'PEINE FINO GRANDE DOCENA', '0.75'),
('569041002', 'CLOTEN UNA X1 CAPSULA', '3.13'),
('741000371', 'BIOBENZOLE X 20 SOBRES X TABLETAS ND	', '9.00'),
('741000370', 'FOSKROL ESCOLAR X 15 AMPOLLAS BEBIBLES', '4.60'),
('741000540', 'APETTI KID JARABE X 220 ML	', '5.70'),
('741100260', 'RABANO YODADO LAINEZ  X 240 ML	', '1.58'),
('11418040', 'ALKASELTZER X 60 TABLETAS', '8.65'),
('741000540', 'SECNI PARAX 500 MG X 4 TABLETAS', '5.08'),
('741005401', 'SECNI PARAX SUSPENSION X 30 ML.	', '4.29'),
('741000375', 'TRICALCIO X 10 AMPOLLA BEBIBLES', '4.50'),
('12849020', 'KOMILON JARABE X 120 ML.	', '3.00'),
('82940', 'OMEPRAZOL SM 20 MG X 100 CAPSULAS RM	', '4.30'),
('332220', 'RANITIDINA SM 150 MG X 100 TABLETAS', '1.80'),
('741510022', 'NEURO CAMPOLON ENERGY X 12 AMPOLLAS BEBIBLES', '6.00'),
('71510022', 'FORTIPLEX OMEGA 3 X 50 SOFTGELS	', '8.00'),
('789041001', 'ESPASMOFIN X 100 TABLETAS', '14.39'),
('470051102', 'BICARBONATO DE SODIO 500 MG X 100 CAPSULAS	', '9.33'),
('758745120', 'BICARBONATO DE SODIO 800 MG. X 100 CAPSULAS', '9.33'),
('741510020', 'ULTRADOCEPLEX MEGA WOMAN X 50 TABLETAS', '9.60'),
('759041002', 'UROFIN POLVO X 100 SOBRES', '23.85'),
('7410000332', 'COLIPAX X 100 TABLETAS', '11.75'),
('7501103790', 'BUSCAPINA 10 MG X 24 GRAGEAS', '8.41'),
('759041045', 'INTESTINOMICINA AD X 100 CAPSULAS', '11.60'),
('745207971', 'NOVOMIT X 250 TABLETAS', '21.00'),
('21418240', 'ALKA D X 60 TABLETAS', '10.75'),
('90179068', 'ENALAPRIL SM 20 MH X 100 TABLETAS RM', '2.40'),
('544113940', 'DEPO PROVERA 150 MG AMPOLLAS ND RM', '10.40'),
('74104598', 'NOVULAR AMPOLLA X 1 ML. RM', '3.16'),
('10000340', 'FINADOL MUJER 200 MG X 50 SOBRES X TABLETAS	', '7.00'),
('7415100022', 'NOMAGEST AMPOLA X 1 ML.RM', '4.27'),
('7401114005', 'REGULADOR GESTEIRA X 120 ML	', '5.62'),
('7510000211', 'PERLA X 24 SOBRES ND', '43.50'),
('750110463', 'CUERPO AMARILLO AMPOLLA X 2 ML. RM', '4.56'),
('741510025', 'VERMAGEST X 2 TABLETAS RM', '8.25'),
('764600113', 'UNICIL L. A. 1.2 UNIDADES AMPOLLAS RM	', '3.98'),
('771000077', 'CIPROFLOXACINA SM 500 MG X 100 TABLETAS', '5.50'),
('76100194', 'FENAKLER AMPOLLA X 1 ML RM', '2.04'),
('711418206', 'DORIVAL LIQUI GELS X 36 TABLETAS', '10.05'),
('750104317', 'VENTOLIN INHALADOR X200 DOSIS RM	', '6.17'),
('7555446120', 'OIDOL GOTAS X 15 ML.	', '2.40'),
('740110460', 'BETA 2 PAN AMPOLLA RM', '9.12'),
('7510000540', 'ORANGE VIT C JARABE X22O ML	', '7.28'),
('721000201', 'DRAMANYL X 100 CAPSULAS', '8.72'),
('761000371', 'FOSKROL X 15 AMPOLLA BEBIBLES ND', '4.55'),
('741000371', 'BIOBENZOLE SUSPENSION X 30 ML. ND', '0.76'),
('769041009', 'VERMEX TOTAL 500 MG X 6 TABLETAS ND', '3.99'),
('744101310', 'MATRICARIA POLVO X 20	', '2.20'),
('76544641', 'SUPER TIAMINA 300 X 100 TABLETAS	', '6.25'),
('7410000371', 'FOSKROL COMPLEX X 30 TABLETAS ND', '2.55'),
('7501799055', 'DOLO NEUROTROPAS SM X 20 SOB X 4 TABS RM	', '7.80'),
('755207970', 'FOSFO B12 X 15 AMPOLLAS BEBIBLES', '13.67'),
('744410187', 'SAL ANDREWS X 50 SOBRES', '6.35'),
('78904145', 'INTESTINOMINA AD X 100 CAPSULAS ND', '17.81'),
('741510022', 'VIROGRIP A.M. TE X 24 SOBRES', '8.00'),
('7415100022', 'VIROGRIP P.M TE X 24SOBRES	', '8.00'),
('741510020', 'FENALER JARABE X 120 M.L', '2.22'),
('760219510', 'CREMOQUINONA 4% X 30 GR. RM', '7.88'),
('789041052', 'DESMOXIDO CREMA LATA ND', '0.98'),
('750103392', 'PENICILINA UNGÃœENTO LATA LOPEZ X 12 GR. ND', '0.82'),
('741510020', 'VIROGRIP AM GEL CAPS X 24 SOBRES	', '8.00'),
('735987429', 'LOSARTAN SM 50 MG. X 50 TABLETAS', '9.60'),
('750129821', 'DEXA NEUROBION AMPOLLA ND	', '7.16'),
('7415100200', 'VIROGRIP GRIPE Y TOS X 120 ML	', '2.90'),
('765446120', 'ZORRITONE JARABE X120 ML	', '2.09'),
('74101726', 'ACETAMINOFEN MK JARABE X 60 ML', '2.59'),
('74109364', 'DICLOFENAC SODICO PL AMPOLLA RM', '1.33'),
('741410020', 'DOLO NERVIDOCE AMPOLLA RM	', '1.80'),
('759041045', 'DOLOFIN RAPIDA ACCION X 100 TABLETAS ND	', '6.65'),
('74160020', 'DOLAREN AMPOLLA X 2 ML RN	', '0.65'),
('1148205', 'DORIVAL 200 MG. X 60 TABLETAS', '11.00'),
('82938', 'IBUPROFENO SM 600 MG X 100 TABLETAS RM	', '4.80'),
('741000280', 'METFORMINA MK 850 MG. X 30 TABLETAS RM	', '7.71'),
('741000080', 'PARACETAMOL MK 750 MG. X 100 CAPSULAS RM	', '22.58'),
('741000260', 'SALVADOL X 25 SOBRES X 2 TABLETAS', '4.80'),
('741000281', 'METFORMINA MK 1000 MG. X 30 TABLETAS RM	', '13.64'),
('852019491', 'AZIMEX 500 MG .X 9 TABLETAS	', '20.92'),
('124', 'AGUA DESTILANDA VHJ X 10 CC. RM ND	', '1.44'),
('741000612', 'ALCANFOR FORSON LIBRA	', '36.00'),
('750112510', 'SOLUCION SALINA NORMAL PISA X 250 ML	', '1.43'),
('750129821', 'NEUROBION 25000 X 1 AMPOLLA X 3 ML. RM ND	', '7.90'),
('741510020', 'ROCEFORT 1 GR. AMPOLLA INTRAMUSCULAR RM', '3.90'),
('189017907', 'DICLOFENACO SODICO SM 50 MG X 100 TABLETAS RM	', '0.86'),
('741000260', 'ANADENT X 25 SOBRES X 4 TABLETAS', '15.15'),
('189017907', 'ATORVASTATINA ARGUS 40 MG X 30 TABLETAS RM.	', '21.12'),
('189017905', 'ATORVASTATINA ARGUS 20 MG X 30 TABLETAS RM.	', '14.74'),
('74107087', 'VITADAK 15 AMPOLLA BEBIBLE	', '3.58'),
('74107735', 'VITADAK 5 AMPOLLA BEBIBLE	', '3.42'),
('7410000342', 'METFORMINA  ECOMED 500 MG X 100 TABLETAS RM	', '9.68'),
('456874512', 'DEXAMETASONA SM AMPOLLA 8 MG. X  ML. RM	', '0.36'),
('770376365', 'GENTAMICINA LS 160 MG. X1 AMPOLLA	', '2.58'),
('779308108', 'QUADRIERM CREMA X 30 GR. RM ND	', '22.93'),
('764600212', 'NEOBOL SPRAY X 30 ML . RM	', '5.62'),
('741000341', 'IBUPROFENO ECOMED 600 MG. X 60 TABLETAS', '7.04'),
('764600212', 'NEOBOL CREMA X 30 GR. RM	', '5.24'),
('765446470', 'PROSTAMEN X 30 CAPSULAS RM	', '14.69'),
('83276', 'METFORMINA SM 850 MG X 100 TABLETAS	', '7.20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tran_transaccion`
--

CREATE TABLE `tran_transaccion` (
  `tran_codigo` int(11) NOT NULL,
  `tran_codigo_temporal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT '' COMMENT 'Cuando este sea cero entonces se creara un nuevo token para almacenarlo, no aparecera en el historial de transacicones hechas',
  `tran_tipo` int(11) DEFAULT '0' COMMENT '0 salida, 1 entrada',
  `tran_estado` int(11) DEFAULT '0' COMMENT '0 borrador 1 ok 2 anulado',
  `tran_codigo_concepto` int(11) DEFAULT '0' COMMENT 'concepto transaccion codigo',
  `tran_nombre_concepto` varchar(100) COLLATE utf8mb4_general_ci DEFAULT '' COMMENT 'concepto transaccion NOMBRE',
  `tran_codigo_cliente` int(11) DEFAULT '0',
  `tran_nombre_cliente` varchar(80) COLLATE utf8mb4_general_ci DEFAULT '',
  `tran_codigo_proveedor` int(11) DEFAULT '0',
  `tran_nombre_proveedor` varchar(80) COLLATE utf8mb4_general_ci DEFAULT '',
  `tran_actualizar_costo` int(11) DEFAULT '0' COMMENT '0 no 1 si',
  `tran_referencia` varchar(50) COLLATE utf8mb4_general_ci DEFAULT '' COMMENT 'cualquier comentario sobre esta transaccion',
  `tran_cantidad_articulo` int(11) DEFAULT '0',
  `tran_recibido` decimal(10,2) DEFAULT '0.00',
  `tran_cambio` decimal(10,2) DEFAULT '0.00',
  `tran_total` decimal(10,2) DEFAULT '0.00',
  `tran_usuario_inicia` int(11) DEFAULT '0',
  `tran_fecha` datetime DEFAULT CURRENT_TIMESTAMP,
  `tran_usuario_fin` int(11) DEFAULT '0',
  `tran_fecha_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tran_transaccion`
--

INSERT INTO `tran_transaccion` (`tran_codigo`, `tran_codigo_temporal`, `tran_tipo`, `tran_estado`, `tran_codigo_concepto`, `tran_nombre_concepto`, `tran_codigo_cliente`, `tran_nombre_cliente`, `tran_codigo_proveedor`, `tran_nombre_proveedor`, `tran_actualizar_costo`, `tran_referencia`, `tran_cantidad_articulo`, `tran_recibido`, `tran_cambio`, `tran_total`, `tran_usuario_inicia`, `tran_fecha`, `tran_usuario_fin`, `tran_fecha_fin`) VALUES
(1, '  ', 1, 0, 0, '', 0, '', 0, '', 0, '', 0, '0.00', '0.00', '0.00', 0, '2021-04-06 14:57:59', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unid_unidad`
--

CREATE TABLE `unid_unidad` (
  `unid_codigo` int(11) NOT NULL,
  `unid_nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `unid_fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unid_unidad`
--

INSERT INTO `unid_unidad` (`unid_codigo`, `unid_nombre`, `unid_fecha`) VALUES
(2, 'caja 10', '2021-04-03 17:24:09'),
(3, 'caja 12', '2021-04-03 17:24:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usua_usuario`
--

CREATE TABLE `usua_usuario` (
  `usua_codigo` int(11) NOT NULL,
  `usua_nombre` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usua_apellido` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usua_usuario` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usua_contra` varchar(80) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usua_status` int(11) DEFAULT '0',
  `usua_cajero` smallint(6) DEFAULT '0',
  `usua_fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usua_usuario`
--

INSERT INTO `usua_usuario` (`usua_codigo`, `usua_nombre`, `usua_apellido`, `usua_usuario`, `usua_contra`, `usua_status`, `usua_cajero`, `usua_fecha`) VALUES
(1, 'Josue', 'Romero', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 0, '2021-07-03 10:05:05'),
(2, 'jefe ', 'jefe', 'jefe', 'a7434f460c6827fd280bc540f309c25003a50ef4', 1, 1, '2021-07-03 10:04:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acce_acceso`
--
ALTER TABLE `acce_acceso`
  ADD PRIMARY KEY (`acce_codigo`);

--
-- Indices de la tabla `clie_cliente`
--
ALTER TABLE `clie_cliente`
  ADD PRIMARY KEY (`clie_codigo`);

--
-- Indices de la tabla `equi_equivalencia`
--
ALTER TABLE `equi_equivalencia`
  ADD PRIMARY KEY (`equi_codigo`);

--
-- Indices de la tabla `form_formulario`
--
ALTER TABLE `form_formulario`
  ADD PRIMARY KEY (`form_codigo`);

--
-- Indices de la tabla `hist_historial`
--
ALTER TABLE `hist_historial`
  ADD PRIMARY KEY (`hist_codigo`);

--
-- Indices de la tabla `labo_laboratorio`
--
ALTER TABLE `labo_laboratorio`
  ADD PRIMARY KEY (`labo_codigo`);

--
-- Indices de la tabla `prod_producto`
--
ALTER TABLE `prod_producto`
  ADD PRIMARY KEY (`prod_codigo`);

--
-- Indices de la tabla `prov_proveedor`
--
ALTER TABLE `prov_proveedor`
  ADD PRIMARY KEY (`prov_codigo`);

--
-- Indices de la tabla `sucu_sucursal`
--
ALTER TABLE `sucu_sucursal`
  ADD PRIMARY KEY (`sucu_codigo`);

--
-- Indices de la tabla `sucu_usuario`
--
ALTER TABLE `sucu_usuario`
  ADD PRIMARY KEY (`sucu_usua_codigo`);

--
-- Indices de la tabla `tran_transaccion`
--
ALTER TABLE `tran_transaccion`
  ADD PRIMARY KEY (`tran_codigo`);

--
-- Indices de la tabla `unid_unidad`
--
ALTER TABLE `unid_unidad`
  ADD PRIMARY KEY (`unid_codigo`);

--
-- Indices de la tabla `usua_usuario`
--
ALTER TABLE `usua_usuario`
  ADD PRIMARY KEY (`usua_codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acce_acceso`
--
ALTER TABLE `acce_acceso`
  MODIFY `acce_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `clie_cliente`
--
ALTER TABLE `clie_cliente`
  MODIFY `clie_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `equi_equivalencia`
--
ALTER TABLE `equi_equivalencia`
  MODIFY `equi_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `form_formulario`
--
ALTER TABLE `form_formulario`
  MODIFY `form_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `hist_historial`
--
ALTER TABLE `hist_historial`
  MODIFY `hist_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `labo_laboratorio`
--
ALTER TABLE `labo_laboratorio`
  MODIFY `labo_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `prod_producto`
--
ALTER TABLE `prod_producto`
  MODIFY `prod_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT de la tabla `prov_proveedor`
--
ALTER TABLE `prov_proveedor`
  MODIFY `prov_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sucu_sucursal`
--
ALTER TABLE `sucu_sucursal`
  MODIFY `sucu_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sucu_usuario`
--
ALTER TABLE `sucu_usuario`
  MODIFY `sucu_usua_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tran_transaccion`
--
ALTER TABLE `tran_transaccion`
  MODIFY `tran_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `unid_unidad`
--
ALTER TABLE `unid_unidad`
  MODIFY `unid_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usua_usuario`
--
ALTER TABLE `usua_usuario`
  MODIFY `usua_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

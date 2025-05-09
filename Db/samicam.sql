-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-05-2025 a las 01:56:01
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
-- Base de datos: `samicam`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idmodulo` bigint(20) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `modulo`
--

INSERT INTO `modulo` (`idmodulo`, `titulo`, `descripcion`, `status`) VALUES
(1, 'Administrador', 'Administrador', 1),
(2, 'Usuarios', 'Usuarios', 1),
(3, 'Roles', 'Roles', 1),
(4, 'Funcionarios Ops', 'Usuarios', 1),
(5, 'Funcionarios Planta', 'Funionarios Ops', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `idpermiso` bigint(20) NOT NULL,
  `rolid` bigint(20) NOT NULL,
  `moduloid` bigint(20) NOT NULL,
  `r` int(11) NOT NULL DEFAULT 0,
  `w` int(11) NOT NULL DEFAULT 0,
  `u` int(11) NOT NULL DEFAULT 0,
  `d` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idpermiso`, `rolid`, `moduloid`, `r`, `w`, `u`, `d`) VALUES
(229, 1, 1, 1, 1, 1, 1),
(230, 1, 2, 1, 1, 1, 1),
(231, 1, 3, 1, 1, 1, 1),
(232, 1, 4, 1, 1, 1, 1),
(233, 1, 5, 1, 1, 1, 1),
(234, 1, 6, 1, 1, 1, 1),
(434, 2, 1, 1, 0, 0, 0),
(435, 2, 2, 0, 0, 0, 0),
(436, 2, 3, 0, 0, 0, 0),
(437, 2, 4, 1, 0, 0, 0),
(438, 2, 5, 1, 0, 0, 0),
(439, 4, 1, 0, 0, 0, 0),
(440, 4, 2, 0, 0, 0, 0),
(441, 4, 3, 0, 0, 0, 0),
(442, 4, 4, 1, 0, 0, 0),
(443, 4, 5, 1, 0, 0, 0),
(454, 3, 1, 1, 0, 0, 0),
(455, 3, 2, 0, 0, 0, 0),
(456, 3, 3, 0, 0, 0, 0),
(457, 3, 4, 1, 0, 0, 0),
(458, 3, 5, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idrol` bigint(20) NOT NULL,
  `nombrerol` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idrol`, `nombrerol`, `descripcion`, `status`) VALUES
(1, 'Superadministrador', 'Acceso a todo el sistema', 1),
(2, 'Jefe Talento Humano', 'Acceso total al área de Talento Humano', 1),
(3, 'Secretaria TH', 'Apoyo administrativo en el area de Talento Humano', 1),
(4, 'Contratación', 'Acceso total al área de Contratación', 1),
(5, 'Tecnico Ntic', 'Apoyo técnico en el área de Ntic', 2),
(6, 'Usuario', 'el sugeto no presenta cambios', 0),
(7, 'Secretaria Ntic', 'Apoyo administrativo en el área de Ntic ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cargos`
--

CREATE TABLE `tbl_cargos` (
  `idecargos` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `nivel` varchar(255) NOT NULL,
  `salario` bigint(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_cargos`
--

INSERT INTO `tbl_cargos` (`idecargos`, `nombre`, `nivel`, `salario`, `status`) VALUES
(1, 'Alcalde', 'Directivo', 8000000, 1),
(3, 'Técnico Administrativo ', 'Técnico', 2825000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_contrato`
--

CREATE TABLE `tbl_contrato` (
  `id_contrato` int(10) NOT NULL,
  `tipo_cont` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_contrato`
--

INSERT INTO `tbl_contrato` (`id_contrato`, `tipo_cont`) VALUES
(1, 'Carrera'),
(2, 'Libre Nombramiento'),
(3, 'Ops'),
(4, 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_dependencia`
--

CREATE TABLE `tbl_dependencia` (
  `dependencia_pk` int(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_dependencia`
--

INSERT INTO `tbl_dependencia` (`dependencia_pk`, `nombre`) VALUES
(1, 'Despacho'),
(3, 'Secretaria de Salud'),
(4, 'Oficina Ntic');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_funcionarios`
--

CREATE TABLE `tbl_funcionarios` (
  `idefuncionario` int(11) NOT NULL,
  `nombre_completo` varchar(255) DEFAULT NULL,
  `nm_identificacion` int(255) DEFAULT NULL,
  `cargo_fk` int(11) DEFAULT NULL,
  `dependencia_fk` int(255) DEFAULT NULL,
  `contrato_fk` int(10) NOT NULL,
  `celular` int(150) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo_elc` varchar(255) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `vacaciones` varchar(15) DEFAULT NULL,
  `fecha_vacaciones` date DEFAULT NULL,
  `hijos` int(11) DEFAULT NULL,
  `nombres_de_hijos` varchar(255) DEFAULT NULL,
  `sexo` varchar(255) DEFAULT NULL,
  `lugar_de_residencia` varchar(255) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `estado_civil` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `formacion_academica` varchar(500) DEFAULT NULL,
  `nombre_formacion` varchar(500) DEFAULT NULL,
  `status` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_funcionarios`
--

INSERT INTO `tbl_funcionarios` (`idefuncionario`, `nombre_completo`, `nm_identificacion`, `cargo_fk`, `dependencia_fk`, `contrato_fk`, `celular`, `direccion`, `correo_elc`, `fecha_ingreso`, `vacaciones`, `fecha_vacaciones`, `hijos`, `nombres_de_hijos`, `sexo`, `lugar_de_residencia`, `edad`, `estado_civil`, `religion`, `formacion_academica`, `nombre_formacion`, `status`) VALUES
(1, 'carlos Lopez', 123, 1, 1, 2, 123, '123', 'carloslxpxz@gmail.com', '2025-05-01', '2', '2025-05-31', 3, 'carlos, juan , fredy', 'masculino', 'la jagua de ibirico ', 23, 'soltero', 'catolico', 'tecnico', 'sistemas ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `ideusuario` bigint(32) NOT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `imgperfil` varchar(300) DEFAULT 'sinimagen.jpg',
  `rolid` bigint(20) NOT NULL,
  `status` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`ideusuario`, `nombres`, `correo`, `password`, `imgperfil`, `rolid`, `status`) VALUES
(1, 'Luis Carlos', 'admin.ntic@gmail.com.co', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'sinimagen.png', 1, 1),
(8, 'Secretaria Luz', 'secretaria.ntic@gmail.com.co', 'd0d1e677873374aff69760f74a46814bc27365f476a83653c9efd4da402a3503', 'sinimagen.jpg', 2, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idmodulo`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`idpermiso`),
  ADD KEY `rolid` (`rolid`),
  ADD KEY `moduloid` (`moduloid`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  ADD PRIMARY KEY (`idecargos`);

--
-- Indices de la tabla `tbl_contrato`
--
ALTER TABLE `tbl_contrato`
  ADD PRIMARY KEY (`id_contrato`);

--
-- Indices de la tabla `tbl_dependencia`
--
ALTER TABLE `tbl_dependencia`
  ADD PRIMARY KEY (`dependencia_pk`);

--
-- Indices de la tabla `tbl_funcionarios`
--
ALTER TABLE `tbl_funcionarios`
  ADD PRIMARY KEY (`idefuncionario`),
  ADD KEY `cargo_fk` (`cargo_fk`),
  ADD KEY `dependencia_fk` (`dependencia_fk`),
  ADD KEY `contrato_fk` (`contrato_fk`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`ideusuario`),
  ADD KEY `rolid` (`rolid`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `idpermiso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=459;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  MODIFY `idecargos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `tbl_contrato`
--
ALTER TABLE `tbl_contrato`
  MODIFY `id_contrato` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_dependencia`
--
ALTER TABLE `tbl_dependencia`
  MODIFY `dependencia_pk` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_funcionarios`
--
ALTER TABLE `tbl_funcionarios`
  MODIFY `idefuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `ideusuario` bigint(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD CONSTRAINT `modulo_ibfk_1` FOREIGN KEY (`idmodulo`) REFERENCES `permisos` (`moduloid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_funcionarios`
--
ALTER TABLE `tbl_funcionarios`
  ADD CONSTRAINT `tbl_funcionarios_ibfk_1` FOREIGN KEY (`cargo_fk`) REFERENCES `tbl_cargos` (`idecargos`),
  ADD CONSTRAINT `tbl_funcionarios_ibfk_2` FOREIGN KEY (`dependencia_fk`) REFERENCES `tbl_dependencia` (`dependencia_pk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_funcionarios_ibfk_3` FOREIGN KEY (`contrato_fk`) REFERENCES `tbl_contrato` (`id_contrato`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `tbl_usuarios_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

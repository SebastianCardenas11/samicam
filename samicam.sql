-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-05-2025 a las 02:49:29
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
(5, 'Funcionarios Planta', 'Funionarios Ops', 1),
(6, 'Notificaciones', 'Notificaciones', 1);

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
(5, 'Tecnico Ntic', 'Apoyo técnico en el área de Ntic', 1),
(6, 'Usuario', 'el sugeto no presenta cambios', 0),
(7, 'Secretaria Ntic', 'Apoyo administrativo en el área de Ntic ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_capital_viaticos`
--

CREATE TABLE `tbl_capital_viaticos` (
  `idCapital` int(11) NOT NULL,
  `anio` int(4) NOT NULL,
  `capital_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `capital_disponible` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_capital_viaticos`
--

INSERT INTO `tbl_capital_viaticos` (`idCapital`, `anio`, `capital_total`, `capital_disponible`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 2025, 22999999.99, 22999999.99, '2025-05-15 19:38:53', '2025-05-15 20:14:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_cargos`
--

CREATE TABLE `tbl_cargos` (
  `idecargos` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `nivel` varchar(255) NOT NULL,
  `salario` decimal(15,2) NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_cargos`
--

INSERT INTO `tbl_cargos` (`idecargos`, `nombre`, `nivel`, `salario`, `estatus`) VALUES
(1, 'Alcalde', 'Directivo', 8000000.00, 0),
(3, 'Técnico Administrativo', 'Técnico', 2800000.00, 1),
(13, 'carlos', 'tecnico', 883.00, 0),
(30, 'aguita', 'de maiz', 7777.00, 0),
(31, 'luiji', 'lleva', 111.00, 0),
(32, '1', '1', 1000000.00, 0),
(33, 'Tecnico Telecomunicaciones', 'Técnico', 1000000.00, 1);

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
(1, 'Despacho');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_funcionarios`
--

CREATE TABLE `tbl_funcionarios` (
  `idefuncionario` int(11) NOT NULL,
  `nombre_completo` varchar(255) DEFAULT NULL,
  `imagen` varchar(300) DEFAULT NULL,
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
  `formacion_academica` varchar(255) DEFAULT NULL,
  `nombre_formacion` varchar(255) DEFAULT NULL,
  `permisos_fk` int(25) DEFAULT NULL,
  `status` int(15) NOT NULL,
  `periodos_vacaciones` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_funcionarios`
--

INSERT INTO `tbl_funcionarios` (`idefuncionario`, `nombre_completo`, `imagen`, `nm_identificacion`, `cargo_fk`, `dependencia_fk`, `contrato_fk`, `celular`, `direccion`, `correo_elc`, `fecha_ingreso`, `vacaciones`, `fecha_vacaciones`, `hijos`, `nombres_de_hijos`, `sexo`, `lugar_de_residencia`, `edad`, `estado_civil`, `religion`, `formacion_academica`, `nombre_formacion`, `permisos_fk`, `status`, `periodos_vacaciones`) VALUES
(10, 'Carlos Lopez', 'user.png', 1, 33, 1, 1, 1, '1', 'Carlos@gmail.com', '2023-10-15', NULL, NULL, 1, '1', 'masculino', '1', 21, 'casado', 'cato', 'bachiller', '1', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_historial_permisos`
--

CREATE TABLE `tbl_historial_permisos` (
  `id_historial` int(25) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `fecha_permiso` date NOT NULL,
  `mes` int(2) NOT NULL,
  `anio` int(4) NOT NULL,
  `motivo` varchar(300) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_motivo_permiso`
--

CREATE TABLE `tbl_motivo_permiso` (
  `id_motivo` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_motivo_permiso`
--

INSERT INTO `tbl_motivo_permiso` (`id_motivo`, `descripcion`, `status`) VALUES
(1, 'Cita médica', 1),
(2, 'Calamidad doméstica', 1),
(3, 'Diligencia personal', 1),
(4, 'Capacitación', 1),
(5, 'Asunto familiar', 1),
(6, 'Muerte familiar', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_notificaciones`
--

CREATE TABLE `tbl_notificaciones` (
  `id_notificacion` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `leido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_permisos`
--

CREATE TABLE `tbl_permisos` (
  `id_permiso` int(25) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `fecha_permiso` date NOT NULL,
  `mes` int(2) NOT NULL,
  `anio` int(4) NOT NULL,
  `motivo` varchar(300) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Aprobado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_vacaciones`
--

CREATE TABLE `tbl_vacaciones` (
  `id_vacaciones` int(11) NOT NULL,
  `id_funcionario` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `periodo` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Pendiente',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_vacaciones`
--

INSERT INTO `tbl_vacaciones` (`id_vacaciones`, `id_funcionario`, `fecha_inicio`, `fecha_fin`, `periodo`, `estado`, `fecha_registro`) VALUES
(30, 10, '2025-05-15', '2025-05-30', 1, 'Cancelado', '2025-05-15 16:24:18'),
(31, 10, '2025-05-15', '2025-05-30', 1, 'Cancelado', '2025-05-15 16:33:42'),
(32, 10, '2025-05-15', '2025-05-30', 1, 'Cancelado', '2025-05-15 16:42:01'),
(33, 10, '2025-05-15', '2025-05-30', 1, 'Pendiente', '2025-05-15 16:55:53'),
(34, 10, '2025-05-15', '2025-05-30', 1, 'Cancelado', '2025-05-15 16:56:36');

--
-- Disparadores `tbl_vacaciones`
--
DELIMITER $$
CREATE TRIGGER `check_vacaciones_fin` BEFORE UPDATE ON `tbl_vacaciones` FOR EACH ROW BEGIN
    DECLARE nombre_func VARCHAR(255);
    
    -- Si el estado cambia a 'Cumplidas' y antes era 'Aprobado'
    IF NEW.estado = 'Aprobado' AND DATEDIFF(NEW.fecha_fin, CURDATE()) = 1 THEN
        -- Obtener el nombre del funcionario
        SELECT nombre_completo INTO nombre_func 
        FROM tbl_funcionarios 
        WHERE idefuncionario = NEW.id_funcionario;
        
        -- Insertar notificación
        INSERT INTO tbl_notificaciones (id_funcionario, tipo, mensaje)
        VALUES (NEW.id_funcionario, 'vacaciones_fin', 
                CONCAT('Las vacaciones de ', nombre_func, ' terminan mañana (', NEW.fecha_fin, ')'));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_viaticos`
--

CREATE TABLE `tbl_viaticos` (
  `idViatico` int(11) NOT NULL,
  `funci_fk` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha` date NOT NULL,
  `uso` text NOT NULL,
  `estatus` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indices de la tabla `tbl_capital_viaticos`
--
ALTER TABLE `tbl_capital_viaticos`
  ADD PRIMARY KEY (`idCapital`),
  ADD UNIQUE KEY `anio_unique` (`anio`);

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
  ADD KEY `contrato_fk` (`contrato_fk`),
  ADD KEY `permisos_fk` (`permisos_fk`);

--
-- Indices de la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indices de la tabla `tbl_motivo_permiso`
--
ALTER TABLE `tbl_motivo_permiso`
  ADD PRIMARY KEY (`id_motivo`);

--
-- Indices de la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indices de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`ideusuario`),
  ADD KEY `rolid` (`rolid`);

--
-- Indices de la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  ADD PRIMARY KEY (`id_vacaciones`),
  ADD KEY `id_funcionario` (`id_funcionario`);

--
-- Indices de la tabla `tbl_viaticos`
--
ALTER TABLE `tbl_viaticos`
  ADD PRIMARY KEY (`idViatico`),
  ADD KEY `funci_fk` (`funci_fk`);

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
-- AUTO_INCREMENT de la tabla `tbl_capital_viaticos`
--
ALTER TABLE `tbl_capital_viaticos`
  MODIFY `idCapital` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_cargos`
--
ALTER TABLE `tbl_cargos`
  MODIFY `idecargos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `tbl_contrato`
--
ALTER TABLE `tbl_contrato`
  MODIFY `id_contrato` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_dependencia`
--
ALTER TABLE `tbl_dependencia`
  MODIFY `dependencia_pk` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tbl_funcionarios`
--
ALTER TABLE `tbl_funcionarios`
  MODIFY `idefuncionario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  MODIFY `id_historial` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_motivo_permiso`
--
ALTER TABLE `tbl_motivo_permiso`
  MODIFY `id_motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  MODIFY `id_notificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `id_permiso` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `ideusuario` bigint(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  MODIFY `id_vacaciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `tbl_viaticos`
--
ALTER TABLE `tbl_viaticos`
  MODIFY `idViatico` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `tbl_funcionarios_ibfk_3` FOREIGN KEY (`contrato_fk`) REFERENCES `tbl_contrato` (`id_contrato`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_funcionarios_ibfk_4` FOREIGN KEY (`permisos_fk`) REFERENCES `tbl_permisos` (`id_permiso`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_historial_permisos`
--
ALTER TABLE `tbl_historial_permisos`
  ADD CONSTRAINT `tbl_historial_permisos_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios` (`idefuncionario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_notificaciones`
--
ALTER TABLE `tbl_notificaciones`
  ADD CONSTRAINT `tbl_notificaciones_ibfk_1` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios` (`idefuncionario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `tbl_usuarios_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `rol` (`idrol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_vacaciones`
--
ALTER TABLE `tbl_vacaciones`
  ADD CONSTRAINT `fk_vacaciones_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionarios` (`idefuncionario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_viaticos`
--
ALTER TABLE `tbl_viaticos`
  ADD CONSTRAINT `tbl_viaticos_ibfk_1` FOREIGN KEY (`funci_fk`) REFERENCES `tbl_funcionarios` (`idefuncionario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

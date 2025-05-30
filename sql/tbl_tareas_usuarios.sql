-- Estructura de tabla para la relación muchos a muchos entre tareas y usuarios
CREATE TABLE `tbl_tareas_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tarea` int(11) NOT NULL,
  `id_usuario` bigint(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tarea` (`id_tarea`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tbl_tareas_usuarios_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tbl_tareas` (`id_tarea`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_tareas_usuarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`ideusuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
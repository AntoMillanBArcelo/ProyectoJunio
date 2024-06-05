-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2024 a las 13:19:54
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
-- Base de datos: `proyectojunio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) DEFAULT NULL,
  `fecha_hora_ini` datetime NOT NULL,
  `fecha_hora_fin` datetime NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `id_padre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id`, `evento_id`, `fecha_hora_ini`, `fecha_hora_fin`, `descripcion`, `tipo`, `id_padre`) VALUES
(16, 1, '2024-06-10 10:00:00', '2024-06-10 12:00:00', 'Taller de Programación', '1', NULL),
(17, 1, '2024-06-04 12:12:12', '1212-03-12 00:00:00', 'asd', 'compuesta', NULL),
(18, NULL, '2024-06-04 09:12:23', '2024-06-04 09:12:23', '', 'compuesta', NULL),
(19, 1, '2024-06-04 12:31:23', '2024-06-04 12:32:31', 'weqeqw', 'compuesta', NULL),
(20, 1, '2024-06-05 13:23:12', '0123-03-12 00:00:00', '213', 'compuesta', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id` int(11) NOT NULL,
  `alumno_grupo_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `fecha_nac` date NOT NULL,
  `nick` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id`, `alumno_grupo_id`, `nombre`, `correo`, `fecha_nac`, `nick`) VALUES
(7, NULL, 'Nombre del Edificio', 'Nombre del Edificio', '2002-02-04', NULL),
(8, NULL, 'sdf', 'sdf', '2002-02-04', NULL),
(9, NULL, 'Acosta Gautier, Tania', 'fleisin496@educiind.es', '2002-02-04', NULL),
(10, NULL, 'Aguilar Campos, Natividad', 'rtormon359@educiind.es', '2002-02-04', NULL),
(11, NULL, 'Acosta Gautier, Tania', 'fleisin496@educiind.es', '2002-03-30', NULL),
(12, NULL, 'asdasdsad', 'rtormon359@educiind.es', '2002-12-12', NULL),
(13, NULL, 'Acosta Gautier, Tania', 'fleisin496@educiind.es', '2002-02-04', NULL),
(14, NULL, 'Acosta Gautier, Tania', 'fleisin496@educiind.es', '2002-02-04', NULL),
(15, NULL, 'Acosta Griezmann, Antoine', 'antgri@educiind.es', '2002-02-04', NULL),
(16, NULL, 'Acosta Gautier, Tania', 'fleisin496@educiind.es', '2002-02-04', NULL),
(17, NULL, 'Acosta Griezmann, Antoine', 'antgri@educiind.es', '2002-02-04', NULL),
(18, NULL, 'Acosta', 'fleisin496@educiind.es', '2002-02-04', NULL),
(19, NULL, 'Acosta Griezmann, Antoine', 'antgri@educiind.es', '2002-02-04', NULL),
(20, NULL, 'Acosta Gautier, Tania', 'fleisin496@educiind.es', '2002-02-04', NULL),
(21, NULL, 'Acosta Griezmann, Antoine', 'antgri@educiind.es', '2002-02-04', NULL),
(22, NULL, 'Acosta Gautier, Tania', 'fleisin496@educiind.es', '2002-02-04', NULL),
(23, NULL, 'Barceló Millán, Antonio', 'amilbar951@educiind.es', '2002-02-05', NULL),
(24, NULL, 'Acosta Griezmann, Antoine', 'antgri@educiind.es', '2002-02-04', NULL),
(25, NULL, 'Acosta Gautier, Tania', 'fleisin496@educiind.es', '2002-02-04', NULL),
(26, NULL, 'Acosta Griezmann, Antoine', 'antgri@educiind.es', '2002-02-04', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_actividad`
--

CREATE TABLE `detalle_actividad` (
  `id` int(11) NOT NULL,
  `fecha_hora_ini` datetime NOT NULL,
  `fecha_hora_fin` datetime NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `detalle_actividad_espacios_id` int(11) DEFAULT NULL,
  `detalle_actividad_evento_id` int(11) DEFAULT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_actividad`
--

INSERT INTO `detalle_actividad` (`id`, `fecha_hora_ini`, `fecha_hora_fin`, `titulo`, `detalle_actividad_espacios_id`, `detalle_actividad_evento_id`, `url`) VALUES
(11, '2024-06-10 10:00:00', '2024-06-10 12:00:00', 'Taller de Programación', 2, NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_actividad_alumno`
--

CREATE TABLE `detalle_actividad_alumno` (
  `detalle_actividad_id` int(11) NOT NULL,
  `alumno_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240423073727', '2024-04-23 09:38:16', 79),
('DoctrineMigrations\\Version20240423074134', '2024-04-23 09:41:41', 181),
('DoctrineMigrations\\Version20240423081754', '2024-04-23 10:18:02', 136),
('DoctrineMigrations\\Version20240423081908', '2024-04-23 10:19:14', 14),
('DoctrineMigrations\\Version20240423083056', '2024-04-23 10:31:03', 69),
('DoctrineMigrations\\Version20240423085114', '2024-04-23 10:51:19', 131),
('DoctrineMigrations\\Version20240423095900', '2024-04-23 11:59:06', 224),
('DoctrineMigrations\\Version20240423102451', '2024-04-23 12:25:05', 137),
('DoctrineMigrations\\Version20240520083748', '2024-05-20 10:42:25', 39),
('DoctrineMigrations\\Version20240521073752', '2024-05-21 09:37:58', 45),
('DoctrineMigrations\\Version20240521074738', '2024-05-21 09:47:41', 40),
('DoctrineMigrations\\Version20240603074910', '2024-06-03 09:49:17', 47),
('DoctrineMigrations\\Version20240603074959', '2024-06-03 09:50:07', 8),
('DoctrineMigrations\\Version20240605074057', '2024-06-05 09:41:05', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificio`
--

CREATE TABLE `edificio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `edificio`
--

INSERT INTO `edificio` (`id`, `nombre`) VALUES
(1, 'Edificio A'),
(2, 'Edificio B'),
(3, 'Edificio C'),
(4, 'Edificio D'),
(5, 'Edificio E');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacio`
--

CREATE TABLE `espacio` (
  `id` int(11) NOT NULL,
  `aforo` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `espacio_edificio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `espacio`
--

INSERT INTO `espacio` (`id`, `aforo`, `nombre`, `espacio_edificio_id`) VALUES
(1, 25, 'Espacio 1', 1),
(2, 22, 'Espacio 2', 2),
(3, 34, 'Espacio 3', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id`, `titulo`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 'Evento 1', '2024-06-11', '2024-06-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `grupo`
--

INSERT INTO `grupo` (`id`, `nombre`) VALUES
(1, 'DAW'),
(2, 'DAM'),
(3, 'Grupo de Prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_user`
--

CREATE TABLE `grupo_user` (
  `grupo_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_educativo`
--

CREATE TABLE `nivel_educativo` (
  `id` int(11) NOT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `nivel_educativo`
--

INSERT INTO `nivel_educativo` (`id`, `grupo_id`, `nombre`) VALUES
(1, 2, '1º'),
(2, 2, '2º'),
(3, 1, '1º'),
(4, 1, '2º');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ponente`
--

CREATE TABLE `ponente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `ponente_detalle_actividad_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ponente`
--

INSERT INTO `ponente` (`id`, `nombre`, `url`, `cargo`, `ponente_detalle_actividad_id`) VALUES
(1, 'Nombre del Ponente 1', 'URL del Ponente 1', 'Cargo del Ponente 1', 11),
(2, 'Nombre del Ponente 2', 'URL del Ponente 2', 'Cargo del Ponente 2', 11),
(3, 'Nombre del Ponente 3', 'URL del Ponente 3', 'Cargo del Ponente 3', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`id`, `descripcion`) VALUES
(1, 'Pizarra Digital'),
(2, 'Pizarra'),
(4, 'Ordenador'),
(5, 'Tiza'),
(6, 'Tiza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso_espacio`
--

CREATE TABLE `recurso_espacio` (
  `recurso_id` int(11) NOT NULL,
  `espacio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `rol` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `nick` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `url`, `rol`, `nombre`, `nick`) VALUES
(1, 'user@user', '[\"ROLE_ADMIN\",\"ROLE_PROFESOR\"]', '$2y$13$OruGY5MtdFlbFroh3QqlGelETRejvmSszbesKXuqLj3F6e/xnOFD.', 'https://symfony.com/doc/current/index.html', 'admin', NULL, NULL),
(2, 'juan.perez@example.com', '[\"ROLE_ADMIN\",\"ROLE_PROFESOR\"]', '$2y$13$OruGY5MtdFlbFroh3QqlGelETRejvmSszbesKXuqLj3F6e/xnOFD.', NULL, NULL, 'Juan Perez', 'jperez'),
(4, 'juan2.perez@example.com', '[]', '123456', NULL, NULL, 'Juan Perez', 'jperez'),
(6, 'juan4.perez@example.com', '[]', '123456', NULL, NULL, 'Juan Perez', 'jperez'),
(7, 'fleisin496@educiind.es', '[]', '123456', NULL, NULL, 'Acosta Gautier, Tania', 'fleisin496'),
(8, 'rtormon359@educiind.es', '[]', '123456', NULL, NULL, 'Aguilar Campos, Natividad', 'rtirmin339'),
(9, 'jvilent786@educiind.es', '[]', '123456', NULL, NULL, 'Aguilar Cañas, Ana', 'jvilent786'),
(10, 'ipirrub884@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Aguilera Moreno, Ortíz', 'ipirrub884'),
(11, 'mperpen469@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Alhambra Sumalinog, María Salud', 'mperpen469'),
(12, 'mcizmir349@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Alonso Fuentes, Gaspar', 'mcizmir349'),
(13, 'isinchi993@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Álvarez Murillo, Josefina', 'isinchi993'),
(14, 'rcispei438@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Alvear Martín-Bejarano, Antonella María', 'rcispei438'),
(15, 'imirrid367@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Araguez Gutiérrez, Catalina', 'imirrid367'),
(16, 'mciligu646@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Aranda Romero, Helena', 'mciligu646'),
(17, 'rlipirr984@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Baca Vargas, Maria Jose', 'rlipirr984'),
(18, 'mbiresp444@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Barba Molina, Elena', 'mbiresp444'),
(19, 'mesclup893@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Belan Delgado, Rocio', 'mesclup893'),
(20, 'sminper834@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Benavides Molina, Yolanda', 'sminper834'),
(21, 'jmirfir988@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Borrego Lago, Jose Carlos', 'jmirfir988'),
(22, 'fcinmir769@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Cabrera Calderon, Maria Deseada', 'fcinmir769'),
(23, 'jgutgin438@ieslasfuentezuelas.com', '[]', '123456', NULL, NULL, 'Callejas Aranda, Antonio', 'jgutgin438');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8DF2BD0687A5F842` (`evento_id`);

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1435D52DED1CA297` (`alumno_grupo_id`);

--
-- Indices de la tabla `detalle_actividad`
--
ALTER TABLE `detalle_actividad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AC9E0C4683DED650` (`detalle_actividad_espacios_id`),
  ADD KEY `IDX_AC9E0C465A8C275` (`detalle_actividad_evento_id`);

--
-- Indices de la tabla `detalle_actividad_alumno`
--
ALTER TABLE `detalle_actividad_alumno`
  ADD PRIMARY KEY (`detalle_actividad_id`,`alumno_id`),
  ADD KEY `IDX_D4948D5AA954C5A1` (`detalle_actividad_id`),
  ADD KEY `IDX_D4948D5AFC28E5EE` (`alumno_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `edificio`
--
ALTER TABLE `edificio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `espacio`
--
ALTER TABLE `espacio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_90BF6AA4A83B4A79` (`espacio_edificio_id`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grupo_user`
--
ALTER TABLE `grupo_user`
  ADD PRIMARY KEY (`grupo_id`,`user_id`),
  ADD KEY `IDX_E90A3F339C833003` (`grupo_id`),
  ADD KEY `IDX_E90A3F33A76ED395` (`user_id`);

--
-- Indices de la tabla `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indices de la tabla `nivel_educativo`
--
ALTER TABLE `nivel_educativo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_33209C919C833003` (`grupo_id`);

--
-- Indices de la tabla `ponente`
--
ALTER TABLE `ponente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_969EB3C85ACD97A8` (`ponente_detalle_actividad_id`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `recurso_espacio`
--
ALTER TABLE `recurso_espacio`
  ADD PRIMARY KEY (`recurso_id`,`espacio_id`),
  ADD KEY `IDX_C7980686E52B6C4E` (`recurso_id`),
  ADD KEY `IDX_C79806867CFC1D2C` (`espacio_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `detalle_actividad`
--
ALTER TABLE `detalle_actividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `edificio`
--
ALTER TABLE `edificio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `espacio`
--
ALTER TABLE `espacio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nivel_educativo`
--
ALTER TABLE `nivel_educativo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ponente`
--
ALTER TABLE `ponente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD CONSTRAINT `FK_8DF2BD0687A5F842` FOREIGN KEY (`evento_id`) REFERENCES `evento` (`id`);

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `FK_1435D52DED1CA297` FOREIGN KEY (`alumno_grupo_id`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `detalle_actividad`
--
ALTER TABLE `detalle_actividad`
  ADD CONSTRAINT `FK_AC9E0C465A8C275` FOREIGN KEY (`detalle_actividad_evento_id`) REFERENCES `actividad` (`id`),
  ADD CONSTRAINT `FK_AC9E0C4683DED650` FOREIGN KEY (`detalle_actividad_espacios_id`) REFERENCES `espacio` (`id`);

--
-- Filtros para la tabla `detalle_actividad_alumno`
--
ALTER TABLE `detalle_actividad_alumno`
  ADD CONSTRAINT `FK_D4948D5AA954C5A1` FOREIGN KEY (`detalle_actividad_id`) REFERENCES `detalle_actividad` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D4948D5AFC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `espacio`
--
ALTER TABLE `espacio`
  ADD CONSTRAINT `FK_90BF6AA4A83B4A79` FOREIGN KEY (`espacio_edificio_id`) REFERENCES `edificio` (`id`);

--
-- Filtros para la tabla `grupo_user`
--
ALTER TABLE `grupo_user`
  ADD CONSTRAINT `FK_E90A3F339C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_E90A3F33A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nivel_educativo`
--
ALTER TABLE `nivel_educativo`
  ADD CONSTRAINT `FK_33209C919C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `ponente`
--
ALTER TABLE `ponente`
  ADD CONSTRAINT `FK_969EB3C85ACD97A8` FOREIGN KEY (`ponente_detalle_actividad_id`) REFERENCES `detalle_actividad` (`id`);

--
-- Filtros para la tabla `recurso_espacio`
--
ALTER TABLE `recurso_espacio`
  ADD CONSTRAINT `FK_C79806867CFC1D2C` FOREIGN KEY (`espacio_id`) REFERENCES `espacio` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C7980686E52B6C4E` FOREIGN KEY (`recurso_id`) REFERENCES `recurso` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

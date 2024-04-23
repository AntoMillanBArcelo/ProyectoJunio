-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2024 a las 12:25:50
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
-- Base de datos: `proyectojunio/app`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) DEFAULT NULL,
  `fecha_hora_ini` datetime NOT NULL,
  `fecha_hora_fin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id` int(11) NOT NULL,
  `alumno_grupo_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `fecha_nac` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
('DoctrineMigrations\\Version20240423102451', '2024-04-23 12:25:05', 137);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `edificio`
--

CREATE TABLE `edificio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE `grupo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `url` varchar(255) NOT NULL,
  `rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `alumno`
--
ALTER TABLE `alumno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_actividad`
--
ALTER TABLE `detalle_actividad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `edificio`
--
ALTER TABLE `edificio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `espacio`
--
ALTER TABLE `espacio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nivel_educativo`
--
ALTER TABLE `nivel_educativo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ponente`
--
ALTER TABLE `ponente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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

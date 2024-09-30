-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-09-2024 a las 14:26:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mydb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id_admin` int(11) NOT NULL,
  `documento` varchar(20) NOT NULL,
  `usuario_nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `estado` varchar(17) NOT NULL DEFAULT '1',
  `privilegio` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id_admin`, `documento`, `usuario_nombre`, `apellido`, `telefono`, `direccion`, `email`, `usuario`, `clave`, `estado`, `privilegio`) VALUES
(1, '1091669101', 'uriel', 'carvajalino ortiz', '3178394885', 'cll 15 16#40 ocaña norte santander', 'uriel_carva@hotmail.com', 'admin', 'cVdBUkZvV1paZS9qdGo5Q1BqZkRrZz09', 'Activa', 1),
(2, '1515263695874', 'pepito', 'perez', '3129391992', 'av 17- 44 - 89', 'pepito@gmail.com', 'pepito', 'pepito1234', 'Activa', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistente`
--

CREATE TABLE `asistente` (
  `id_asistente` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistente`
--

INSERT INTO `asistente` (`id_asistente`, `nombres`, `apellidos`, `fecha_nacimiento`, `email`, `celular`, `id_admin`) VALUES
(8, 'urielitooo', 'ortiz', '0000-00-00', 'ucarvajalino@gmail.com', '3178394885', 1),
(9, 'JUAN', 'Mecanicodo', '2024-09-12', 'JUAN@GMAIL.COM', '3123931992', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(5) NOT NULL,
  `descripcion` varchar(15) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `descripcion`, `id_admin`) VALUES
(2, 'Entretenimiento', 1),
(3, 'Seminarios', 1),
(4, 'Conferencias', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_promocional`
--

CREATE TABLE `codigo_promocional` (
  `id_codigo` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `porcentaje_descuento` decimal(5,2) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_vigencia_inicio` date DEFAULT NULL,
  `fecha_vigencia_fin` date DEFAULT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `id_asistente` int(11) NOT NULL,
  `porcentaje_adicional` double NOT NULL,
  `recargo` double NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `hora` time NOT NULL,
  `valor_base` decimal(10,2) DEFAULT NULL,
  `id_categoria` int(5) NOT NULL,
  `lugar` varchar(100) NOT NULL,
  `cupo` int(5) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `id_tipo_entrada` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`id_evento`, `titulo`, `descripcion`, `hora`, `valor_base`, `id_categoria`, `lugar`, `cupo`, `estado`, `tipo`, `id_tipo_entrada`, `id_admin`) VALUES
(35, 'logica de programación', 'evento para desarrollar logica de programacion a los estudiantes de la UFPSO', '23:23:00', 200000.00, 3, 'Escuela Bellas Artes', 45, 'Deshabilitado', 'Gratis', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `id_inscripcion` int(11) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `id_asistente` int(11) NOT NULL,
  `tipo_entrada` enum('gratis','general','VIP') NOT NULL,
  `valor_pago` decimal(10,2) DEFAULT NULL,
  `estado_pago` enum('pendiente','pagado') DEFAULT 'pendiente',
  `fecha_registro` date NOT NULL,
  `fecha_apertura` date NOT NULL,
  `fecha_cierre` date NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones_codigos`
--

CREATE TABLE `inscripciones_codigos` (
  `id` int(11) NOT NULL,
  `id_inscripcion` int(11) NOT NULL,
  `id_codigo` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_espera`
--

CREATE TABLE `lista_espera` (
  `id_lista_espera` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_entrada`
--

CREATE TABLE `tipo_entrada` (
  `id_tipo_entrada` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipo_entrada`
--

INSERT INTO `tipo_entrada` (`id_tipo_entrada`, `descripcion`, `id_admin`) VALUES
(5, 'Gratis', 1),
(6, 'General', 1),
(7, 'VIP', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `usuario_dni` (`documento`),
  ADD UNIQUE KEY `usuario_email` (`email`),
  ADD UNIQUE KEY `usuario_usuario` (`usuario`);

--
-- Indices de la tabla `asistente`
--
ALTER TABLE `asistente`
  ADD PRIMARY KEY (`id_asistente`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_asistente_administradores1_idx` (`id_admin`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `fk_categoria_administradores1_idx` (`id_admin`);

--
-- Indices de la tabla `codigo_promocional`
--
ALTER TABLE `codigo_promocional`
  ADD PRIMARY KEY (`id_codigo`),
  ADD KEY `fk_codigo_promocional_administradores1_idx` (`id_admin`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_compra_evento1_idx` (`id_evento`),
  ADD KEY `fk_compra_asistente1_idx` (`id_asistente`),
  ADD KEY `fk_compra_administradores1_idx` (`id_admin`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_evento`),
  ADD KEY `fk_eventos_categoria1_idx` (`id_categoria`),
  ADD KEY `fk_eventos_lugar1_idx` (`lugar`),
  ADD KEY `fk_evento_cupo1_idx` (`cupo`),
  ADD KEY `fk_evento_estado1_idx` (`estado`),
  ADD KEY `fk_evento_tipo1_idx` (`tipo`),
  ADD KEY `fk_evento_tipo_entrada1_idx` (`id_tipo_entrada`),
  ADD KEY `fk_evento_administradores1_idx` (`id_admin`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`id_inscripcion`),
  ADD KEY `id_evento` (`id_evento`),
  ADD KEY `id_asistente` (`id_asistente`),
  ADD KEY `fk_inscripcion_administradores1_idx` (`id_admin`);

--
-- Indices de la tabla `inscripciones_codigos`
--
ALTER TABLE `inscripciones_codigos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_inscripcion` (`id_inscripcion`),
  ADD KEY `id_codigo` (`id_codigo`),
  ADD KEY `fk_inscripciones_codigos_administradores1_idx` (`id_admin`);

--
-- Indices de la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  ADD PRIMARY KEY (`id_lista_espera`);

--
-- Indices de la tabla `tipo_entrada`
--
ALTER TABLE `tipo_entrada`
  ADD PRIMARY KEY (`id_tipo_entrada`),
  ADD KEY `fk_tipo_entrada_administradores1_idx` (`id_admin`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistente`
--
ALTER TABLE `asistente`
  MODIFY `id_asistente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `codigo_promocional`
--
ALTER TABLE `codigo_promocional`
  MODIFY `id_codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inscripciones_codigos`
--
ALTER TABLE `inscripciones_codigos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lista_espera`
--
ALTER TABLE `lista_espera`
  MODIFY `id_lista_espera` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_entrada`
--
ALTER TABLE `tipo_entrada`
  MODIFY `id_tipo_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistente`
--
ALTER TABLE `asistente`
  ADD CONSTRAINT `fk_asistente_administradores1` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fk_categoria_administradores1` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `codigo_promocional`
--
ALTER TABLE `codigo_promocional`
  ADD CONSTRAINT `fk_codigo_promocional_administradores1` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_administradores1` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_asistente1` FOREIGN KEY (`id_asistente`) REFERENCES `asistente` (`id_asistente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_evento1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `fk_evento_administradores1` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evento_tipo_entrada1` FOREIGN KEY (`id_tipo_entrada`) REFERENCES `tipo_entrada` (`id_tipo_entrada`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_eventos_categoria1` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD CONSTRAINT `fk_inscripcion_administradores1` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`),
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`id_asistente`) REFERENCES `asistente` (`id_asistente`);

--
-- Filtros para la tabla `inscripciones_codigos`
--
ALTER TABLE `inscripciones_codigos`
  ADD CONSTRAINT `fk_inscripciones_codigos_administradores1` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `inscripciones_codigos_ibfk_1` FOREIGN KEY (`id_inscripcion`) REFERENCES `inscripcion` (`id_inscripcion`),
  ADD CONSTRAINT `inscripciones_codigos_ibfk_2` FOREIGN KEY (`id_codigo`) REFERENCES `codigo_promocional` (`id_codigo`);

--
-- Filtros para la tabla `tipo_entrada`
--
ALTER TABLE `tipo_entrada`
  ADD CONSTRAINT `fk_tipo_entrada_administradores1` FOREIGN KEY (`id_admin`) REFERENCES `administradores` (`id_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

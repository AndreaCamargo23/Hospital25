-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:33065
-- Tiempo de generación: 14-10-2021 a las 00:04:31
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_hospital`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adquirir`
--

CREATE TABLE `adquirir` (
  `id_servicio` int(20) NOT NULL,
  `id_ingreso` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `adquirir`
--

INSERT INTO `adquirir` (`id_servicio`, `id_ingreso`) VALUES
(1, 3),
(2, 1),
(2, 3),
(3, 4),
(5, 6),
(10, 7),
(11, 1),
(12, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atender`
--

CREATE TABLE `atender` (
  `id_empleado` int(20) NOT NULL,
  `id_ingreso` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `atender`
--

INSERT INTO `atender` (`id_empleado`, `id_ingreso`) VALUES
(159862, 1),
(159862, 3),
(494165, 1),
(494165, 4),
(79390225, 1),
(79390225, 7),
(79390226, 5),
(79390230, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cama`
--

CREATE TABLE `cama` (
  `id_cama` int(20) NOT NULL,
  `valor_c` int(80) NOT NULL,
  `id_estado_fk` int(20) NOT NULL,
  `id_habitacion_fk` int(20) NOT NULL,
  `id_tipo_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cama`
--

INSERT INTO `cama` (`id_cama`, `valor_c`, `id_estado_fk`, `id_habitacion_fk`, `id_tipo_fk`) VALUES
(1, 32000, 11, 201, 2),
(2, 5000, 11, 101, 2),
(3, 5000, 11, 101, 2),
(4, 5000, 1, 101, 2),
(5, 5000, 1, 101, 2),
(6, 5000, 1, 101, 2),
(7, 5000, 11, 102, 2),
(8, 32000, 1, 102, 2),
(9, 15500, 1, 103, 2),
(10, 15500, 1, 103, 2),
(11, 13500, 1, 104, 2),
(12, 25000, 11, 107, 2),
(13, 15000, 1, 102, 2),
(14, 15000, 1, 102, 2),
(15, 12000, 11, 102, 2),
(16, 12000, 11, 103, 2),
(17, 18000, 1, 104, 2),
(18, 18000, 1, 104, 2),
(19, 22000, 1, 105, 2),
(20, 23500, 1, 105, 2),
(21, 13000, 11, 105, 2),
(22, 15300, 1, 105, 2),
(23, 12400, 1, 105, 2),
(24, 35000, 1, 106, 2),
(25, 25000, 1, 108, 2),
(26, 25000, 1, 109, 2),
(27, 16000, 1, 108, 2),
(28, 13500, 1, 108, 2),
(29, 22000, 1, 109, 2),
(30, 32000, 1, 110, 2),
(31, 15000, 1, 202, 2),
(32, 16000, 1, 203, 2),
(33, 15000, 1, 206, 4),
(34, 15600, 1, 206, 3),
(35, 15600, 1, 206, 3),
(36, 15600, 1, 110, 3),
(37, 23500, 1, 109, 3),
(38, 15600, 1, 208, 3),
(39, 16500, 1, 204, 5),
(46, 25600, 1, 206, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(20) NOT NULL,
  `cargo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `cargo`) VALUES
(1, 'Enfermero'),
(2, 'Administrativo'),
(3, 'Doctor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `fecha_nac` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_cargo_fk` int(20) NOT NULL,
  `id_estado_fk` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `nombre`, `apellido`, `direccion`, `fecha_nac`, `email`, `id_cargo_fk`, `id_estado_fk`) VALUES
(159862, 'Alberto', 'Garces', 'calle 21 #15-12', '2003-09-11', 'nuevo@gmail.com', 2, 2),
(494165, 'Harold Luiz', 'Ubaque Monroy', 'called12', '1995-05-18', 'harold@gamil.com', 3, 1),
(1001278, 'Andrea', 'Marquez Monroy', 'carrera 15b', '2003-09-25', 'camargomilena26@gmail.com', 1, 1),
(52165068, 'Helena', 'Gonzalez', 'calle 21 #15-12', '1965-05-02', 'helenagonzalez@gmail.com', 1, 1),
(79390225, 'Fernando', 'Jimenez', 'calle 39b', '1978-09-18', 'jimenez@gmail.com', 3, 1),
(79390226, 'Antonio', 'Marquez Monroy', 'carrera 23 #15-12', '1998-08-10', 'antonio@gmail.com', 1, 1),
(79390230, 'Andres', 'Martinez Perez', 'calle 18 #15-12', '1970-05-15', 'martinezandres@gmail.com', 2, 1),
(1001278905, 'Andrea Milena', 'Camargo Gonzalez', 'carrera 13B este #41-15sur', '2001-08-26', 'camargomilena26@gmail.com', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(20) NOT NULL,
  `estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_estado`, `estado`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'Bloqueado'),
(4, 'En valoracion'),
(5, 'Fallecido'),
(6, 'De alta'),
(7, 'Deuda'),
(8, 'Vacaciones'),
(9, 'Pensionado'),
(10, 'Disponible'),
(11, 'Ocupada'),
(12, 'sin camas'),
(13, 'Pagada'),
(14, 'Deuda'),
(15, 'Generada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturacion`
--

CREATE TABLE `facturacion` (
  `id_fact` int(20) NOT NULL,
  `fecha_factura` date NOT NULL,
  `fecha_pago` date NOT NULL,
  `valor_total` int(50) NOT NULL,
  `id_estado_fk` int(20) NOT NULL,
  `id_ingreso_fk` int(20) NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `facturacion`
--

INSERT INTO `facturacion` (`id_fact`, `fecha_factura`, `fecha_pago`, `valor_total`, `id_estado_fk`, `id_ingreso_fk`, `fecha_vencimiento`) VALUES
(1, '2021-10-11', '0000-00-00', 91000, 14, 1, '2021-10-21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id_genero` int(20) NOT NULL,
  `genero` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id_genero`, `genero`) VALUES
(1, 'Masculino'),
(2, 'Femenino'),
(3, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habitacion`
--

CREATE TABLE `habitacion` (
  `id_habi` int(20) NOT NULL,
  `id_estado_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `habitacion`
--

INSERT INTO `habitacion` (`id_habi`, `id_estado_fk`) VALUES
(101, 10),
(102, 10),
(103, 10),
(104, 10),
(105, 10),
(106, 10),
(108, 10),
(109, 10),
(110, 10),
(202, 10),
(203, 10),
(204, 10),
(206, 10),
(208, 10),
(107, 11),
(201, 11),
(207, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
--

CREATE TABLE `informe` (
  `id_info` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `starDate` date NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingreso`
--

CREATE TABLE `ingreso` (
  `id_ingreso` int(20) NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date DEFAULT NULL,
  `descripcion` varchar(80) NOT NULL,
  `id_paciente_fk` int(20) NOT NULL,
  `id_cama_fk` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ingreso`
--

INSERT INTO `ingreso` (`id_ingreso`, `fecha_ingreso`, `fecha_salida`, `descripcion`, `id_paciente_fk`, `id_cama_fk`) VALUES
(1, '2021-09-30', '2021-10-11', 'Ingreso por oncologia, paciente...', 10012587, 3),
(3, '2021-09-29', '0000-00-00', 'Ingreso por medicina general sintoma sin ', 154895, 2),
(4, '2021-10-19', '0000-00-00', 'Ingreso por tendencia tumor, realizar examenes de radiologia', 8852, 12),
(5, '2021-10-12', '0000-00-00', 'Ingreso por falta de no se que', 598852, 21),
(6, '2021-09-29', '0000-00-00', 'Tratamiento rutinario de oncologia', 159862, 16),
(7, '2021-10-02', '0000-00-00', 'intoxicación', 79390226, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id_paciente` int(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `fecha_nac` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `celular` varchar(30) NOT NULL,
  `id_genero_fk` int(20) NOT NULL,
  `id_rh_fk` int(20) NOT NULL,
  `id_estado_fk` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `nombre`, `apellido`, `direccion`, `fecha_nac`, `email`, `celular`, `id_genero_fk`, `id_rh_fk`, `id_estado_fk`) VALUES
(8852, 'Angela', 'Martinez', 'carrera 19', '2000-01-20', 'angela@hotmail.com', '3134582625', 2, 6, 4),
(154895, 'Caroline', 'Camargo', 'carrera 23 #15-12', '1973-06-27', 'camargo@gmail.com', '3225658585', 1, 1, 4),
(159862, 'Pablo ', 'Martinez', 'calle b este 51', '2001-08-25', 'martinez@gmail.com', '31385873', 1, 3, 4),
(598852, 'Angela Isabel', 'Martinez Perez', 'Calle 68 no 63-45', '1993-06-11', 'angelam@hotmail.com', '3256598', 1, 3, 4),
(10012587, 'Yojhan', 'Cardona', 'calle 19b este', '2002-07-19', 'ejemplo@gmail.com', '31258593', 1, 1, 7),
(79390226, 'Fernando', 'Camargo', 'Carrera 13b este No 41-15 sur', '2021-10-30', 'fernando@gmail.com', '3215589675', 1, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rh`
--

CREATE TABLE `rh` (
  `id_rh` int(5) NOT NULL,
  `rh` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rh`
--

INSERT INTO `rh` (`id_rh`, `rh`) VALUES
(1, 'O+'),
(2, 'O-'),
(3, 'A+'),
(4, 'A-'),
(5, 'B+'),
(6, 'B-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(20) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Empleado'),
(3, 'Paciente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(20) NOT NULL,
  `valor_s` int(100) NOT NULL,
  `nombre` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `valor_s`, `nombre`) VALUES
(1, 40000, 'Medicina interna'),
(2, 30000, 'Urgencias'),
(3, 80000, 'Radiologia'),
(4, 50000, 'Neumología'),
(5, 90000, 'Oncología'),
(6, 45000, 'Ginecología'),
(7, 85000, 'Ortopedia'),
(8, 26980, 'Microobiologia'),
(10, 85000, 'Toxicología'),
(11, 56000, 'bacteriologia'),
(12, 54000, 'Hematologia'),
(13, 1560, 'Servicio de prubea');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `tipo`) VALUES
(1, 'Electrica'),
(2, 'Sencilla'),
(3, 'Rigida'),
(4, 'Articulada'),
(5, 'Ortopedica'),
(6, 'Traumatológica'),
(7, 'Electrocircular');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `id_rol_fk` int(20) NOT NULL,
  `id_estado_fk` int(20) NOT NULL,
  `nombre_usua` varchar(100) NOT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email`, `passwd`, `id_rol_fk`, `id_estado_fk`, `nombre_usua`, `codigo`) VALUES
(2, 'camargomilena26@gmail.com', '123456', 1, 3, 'AndreaCamargo', 1017433006),
(9, 'antonio@gmail.com', 'antonio', 2, 2, 'antonioMarquez', 2),
(30, 'jimenez26@gmail.com', '123456', 2, 1, 'Jimenez', 3),
(32, 'prueba@gmail.com', '145698', 2, 2, 'prueba', 4),
(34, 'fabioro@hotmail.com', 'fabio', 3, 3, 'fabio', 5),
(41, 'brandon@gmail.com', 'prueba123', 1, 1, 'brandonMonrroy', 123),
(45, 'conejillo@gmail.com', '15986234', 2, 1, 'conejillo123', 69720817),
(47, 'codigo@gamil.com', '1589841255', 1, 1, 'codigoMaldito', 1899631380),
(48, 'michael@gmail.com', '123456789', 1, 1, 'michaelGuzman', 812836976),
(53, 'joshua@gmail.com', '1598651452', 2, 1, 'JoshuaCamargo', 1288102280);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `adquirir`
--
ALTER TABLE `adquirir`
  ADD PRIMARY KEY (`id_servicio`,`id_ingreso`),
  ADD KEY `id_ingreso` (`id_ingreso`);

--
-- Indices de la tabla `atender`
--
ALTER TABLE `atender`
  ADD PRIMARY KEY (`id_empleado`,`id_ingreso`),
  ADD KEY `id_ingreso` (`id_ingreso`);

--
-- Indices de la tabla `cama`
--
ALTER TABLE `cama`
  ADD PRIMARY KEY (`id_cama`),
  ADD KEY `id_estado_fk` (`id_estado_fk`),
  ADD KEY `id_habitacion_fk` (`id_habitacion_fk`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_cargo_fk` (`id_cargo_fk`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD PRIMARY KEY (`id_fact`),
  ADD KEY `id_estado_fk` (`id_estado_fk`),
  ADD KEY `id_ingreso_fk` (`id_ingreso_fk`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_genero`);

--
-- Indices de la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD PRIMARY KEY (`id_habi`),
  ADD KEY `id_estado_fk` (`id_estado_fk`);

--
-- Indices de la tabla `informe`
--
ALTER TABLE `informe`
  ADD PRIMARY KEY (`id_info`);

--
-- Indices de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD PRIMARY KEY (`id_ingreso`),
  ADD KEY `id_paciente_fk` (`id_paciente_fk`),
  ADD KEY `id_cama_fk` (`id_cama_fk`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id_paciente`),
  ADD KEY `id_genero_fk` (`id_genero_fk`),
  ADD KEY `id_rh_fk` (`id_rh_fk`),
  ADD KEY `id_estado_fk` (`id_estado_fk`);

--
-- Indices de la tabla `rh`
--
ALTER TABLE `rh`
  ADD PRIMARY KEY (`id_rh`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nombre_usua` (`nombre_usua`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `id_rol_fk` (`id_rol_fk`),
  ADD KEY `id_estado_fk` (`id_estado_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cama`
--
ALTER TABLE `cama`
  MODIFY `id_cama` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `facturacion`
--
ALTER TABLE `facturacion`
  MODIFY `id_fact` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id_genero` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ingreso`
--
ALTER TABLE `ingreso`
  MODIFY `id_ingreso` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `rh`
--
ALTER TABLE `rh`
  MODIFY `id_rh` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `adquirir`
--
ALTER TABLE `adquirir`
  ADD CONSTRAINT `adquirir_ibfk_2` FOREIGN KEY (`id_ingreso`) REFERENCES `ingreso` (`id_ingreso`),
  ADD CONSTRAINT `adquirir_ibfk_3` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`);

--
-- Filtros para la tabla `atender`
--
ALTER TABLE `atender`
  ADD CONSTRAINT `atender_ibfk_2` FOREIGN KEY (`id_ingreso`) REFERENCES `ingreso` (`id_ingreso`),
  ADD CONSTRAINT `atender_ibfk_3` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`);

--
-- Filtros para la tabla `cama`
--
ALTER TABLE `cama`
  ADD CONSTRAINT `cama_ibfk_1` FOREIGN KEY (`id_estado_fk`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `cama_ibfk_2` FOREIGN KEY (`id_habitacion_fk`) REFERENCES `habitacion` (`id_habi`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`id_cargo_fk`) REFERENCES `cargo` (`id_cargo`);

--
-- Filtros para la tabla `facturacion`
--
ALTER TABLE `facturacion`
  ADD CONSTRAINT `facturacion_ibfk_1` FOREIGN KEY (`id_estado_fk`) REFERENCES `estado` (`id_estado`),
  ADD CONSTRAINT `facturacion_ibfk_2` FOREIGN KEY (`id_ingreso_fk`) REFERENCES `ingreso` (`id_ingreso`);

--
-- Filtros para la tabla `habitacion`
--
ALTER TABLE `habitacion`
  ADD CONSTRAINT `habitacion_ibfk_2` FOREIGN KEY (`id_estado_fk`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `ingreso`
--
ALTER TABLE `ingreso`
  ADD CONSTRAINT `ingreso_ibfk_1` FOREIGN KEY (`id_paciente_fk`) REFERENCES `paciente` (`id_paciente`),
  ADD CONSTRAINT `ingreso_ibfk_2` FOREIGN KEY (`id_cama_fk`) REFERENCES `cama` (`id_cama`);

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`id_genero_fk`) REFERENCES `genero` (`id_genero`),
  ADD CONSTRAINT `paciente_ibfk_2` FOREIGN KEY (`id_rh_fk`) REFERENCES `rh` (`id_rh`),
  ADD CONSTRAINT `paciente_ibfk_3` FOREIGN KEY (`id_estado_fk`) REFERENCES `estado` (`id_estado`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol_fk`) REFERENCES `rol` (`id_rol`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`id_estado_fk`) REFERENCES `estado` (`id_estado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

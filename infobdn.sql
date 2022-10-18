-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2022 a las 07:52:43
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `infobdn`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `Nombre` varchar(90) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`Nombre`, `Password`) VALUES
('admin', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnes`
--

CREATE TABLE `alumnes` (
  `DNI` varchar(9) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Nom` varchar(90) NOT NULL,
  `Cognoms` varchar(90) NOT NULL,
  `Edat` int(11) NOT NULL,
  `Foto` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumnes`
--

INSERT INTO `alumnes` (`DNI`, `Email`, `Nom`, `Cognoms`, `Edat`, `Foto`, `Password`) VALUES
('11111111A', 'alumno1@gmail.es', 'Alumno', '1', 20, 'alumnes/408088.png', '202cb962ac59075b964b07152d234b70'),
('22222222A', 'alumno2@gmail.es', 'Alumno', '2', 25, 'alumnes/th.png', '202cb962ac59075b964b07152d234b70'),
('33333333A', 'alumno3@mail.es', 'Alumno', '3', 18, 'alumnes/ola.png', '202cb962ac59075b964b07152d234b70'),
('42965325B', 'mateo@mail.es', 'Mateo', 'Rodríguez', 25, 'alumnes/alumno.png', '202cb962ac59075b964b07152d234b70'),
('78264915P', 'martin@mail.es', 'Martin', 'Pérez', 19, 'alumnes/826-8267293_ned-flanders-png.png', '6e6e2ddb6346ce143d19d79b3358c16a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `Codi` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Descripcio` varchar(1024) NOT NULL,
  `Hores_Duracio` int(10) NOT NULL,
  `Data_Inici` date NOT NULL,
  `Data_Final` date NOT NULL,
  `DNI` varchar(9) NOT NULL,
  `Activado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`Codi`, `Nom`, `Descripcio`, `Hores_Duracio`, `Data_Inici`, `Data_Final`, `DNI`, `Activado`) VALUES
(1, 'Curso profesional de Python', 'En el nuevo curso profesional de Python nos enfocaremos en aprender todo los necesario para convertirnos en desarrolladores Python. Aplicando las mejores practicas de programación logrando así un código mucho más Pythonico.', 528, '2022-08-09', '2022-10-05', '54821696P', 1),
(8, 'CSS', 'Aprende los fundamentos y bases sólidas de CSS desde 0. Este curso es para ti si quieres empezar en CSS.', 236, '2022-09-29', '2022-10-07', '54821696P', 1),
(9, 'JavaScript', 'Aprende JavaScript a profundidad, desde las bases del lenguaje, hasta el trabajo con objetos, programación asíncrona, novedades del lenguaje, buenas prácticas, conceptos teóricos y mucho más. Un curso teórico práctico para dominar JavaScript, más de 30 mil personas lo han tomado.', 420, '2022-10-26', '2023-02-10', '54821696P', 1),
(11, 'Machine Learning', 'Conoce los conceptos básicos del aprendizaje automático: qué tipos hay, qué es lo que se necesita para comenzar con él, los problemas que podemos encontrar, cómo evaluamos un modelo y qué algoritmos podemos usar.', 69, '2022-09-28', '2022-10-06', '54821569L', 0),
(13, 'PHP', 'En este curso de PHP aprenderás de forma práctica los conceptos básicos, las mejores técnicas, así como las librerías más populares y herramientas necesarias para programar de forma eficiente con este lenguaje de programación. ', 212, '2022-10-11', '2022-10-26', '54821696P', 1),
(15, 'Docker', 'Docker es una plataforma completa de manejo de contenedores. A lo largo de este curso aprenderás qué es Docker, por qué usarlo y te introducirás en el manejo de dichos contenedores con ejemplos prácticos que te guían a través del mundo del manejo de aplicaciones con contenedores.', 69, '2022-09-28', '2022-10-06', '54821569L', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE `matricula` (
  `DNI` varchar(9) NOT NULL,
  `Codi` int(11) NOT NULL,
  `Nota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `matricula`
--

INSERT INTO `matricula` (`DNI`, `Codi`, `Nota`) VALUES
('11111111A', 1, NULL),
('22222222A', 1, NULL),
('33333333A', 1, NULL),
('42965325B', 1, 5),
('78264915P', 1, NULL),
('11111111A', 9, NULL),
('22222222A', 9, NULL),
('33333333A', 9, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `professors`
--

CREATE TABLE `professors` (
  `DNI` varchar(9) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Nom` varchar(90) NOT NULL,
  `Cognoms` varchar(255) NOT NULL,
  `Titol_Academic` varchar(255) NOT NULL,
  `Foto` varchar(255) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `Activado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `professors`
--

INSERT INTO `professors` (`DNI`, `Email`, `Nom`, `Cognoms`, `Titol_Academic`, `Foto`, `Password`, `Activado`) VALUES
('12345678A', 'profesor1@mail.es', 'Profesor', '1', 'JavaScript avanzado', 'professors/Pablo.jpg', '202cb962ac59075b964b07152d234b70', 1),
('23456789A', 'profesor2@mail.es', 'Profesor', '2', 'Física', 'professors/CG_Shadow_11.png', '6e6e2ddb6346ce143d19d79b3358c16a', 0),
('54821569L', 'profesor3@mail.com', 'Profesor', '3', 'Ingeniero informático', 'professors/19-04-10Jaime-Nubiola.jpg', '6e6e2ddb6346ce143d19d79b3358c16a', 1),
('54821696P', 'matias@mail.es', 'Matias', 'Marin', 'Ingeniería en software', 'professors/bruh.jpg', '202cb962ac59075b964b07152d234b70', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Nombre`);

--
-- Indices de la tabla `alumnes`
--
ALTER TABLE `alumnes`
  ADD PRIMARY KEY (`DNI`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`Codi`);

--
-- Indices de la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`Codi`,`DNI`),
  ADD KEY `FK_ActiveDirectories_DNI` (`DNI`);

--
-- Indices de la tabla `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`DNI`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `Codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `matricula`
--
ALTER TABLE `matricula`
  MODIFY `Codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `FK_ActiveDirectories_Codi` FOREIGN KEY (`Codi`) REFERENCES `cursos` (`Codi`),
  ADD CONSTRAINT `FK_ActiveDirectories_DNI` FOREIGN KEY (`DNI`) REFERENCES `alumnes` (`DNI`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

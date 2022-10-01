-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-10-2022 a las 09:18:10
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
('42965325B', 'mateo@mail.es', 'Mateo', 'Rodríguez', 25, 'alumnes/alumno.png', '202cb962ac59075b964b07152d234b70'),
('78264915P', 'martin@mail.es', 'Martin', 'Pérez', 19, 'alumnes/maxresdefault.jpg', '6e6e2ddb6346ce143d19d79b3358c16a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `Codi` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Descripcio` varchar(255) NOT NULL,
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
(1, 'Mates', 'pues no se bro mates', 528, '2022-10-18', '2022-09-18', '54821696P', 1),
(8, 'Historia', 'historia españa', 236, '2022-09-29', '2022-10-07', '23456789A', 1),
(9, 'English', 'English bruh', 420, '2022-09-28', '2022-10-08', '54821569L', 1),
(11, 'Programacion', 'Programar en C', 69, '2022-09-28', '2022-10-06', '54821569L', 0),
(13, 'Aleman', 'Curso básico aleman', 212, '2022-10-09', '2022-10-26', '54821696P', 1);

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
('42965325B', 1, 5),
('78264915P', 1, NULL);

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
('12345678A', 'jesucristo@mail.es', 'Jesucristo', 'Superstar', 'Experto en morir jaja', 'professors/Pablo.jpg', '202cb962ac59075b964b07152d234b70', 1),
('23456789A', 'jose@mail.es', 'Jose', 'Rodriguez', 'Física', 'professors/maxresdefault.jpg', '6e6e2ddb6346ce143d19d79b3358c16a', 0),
('54821569L', 'juanito@mail.com', 'Juan', 'sssssss', 'Experto en Dokkan', 'professors/19-04-10Jaime-Nubiola.jpg', '6e6e2ddb6346ce143d19d79b3358c16a', 1),
('54821696P', 'matias@mail.es', 'Matias', 'Marin', 'Profesor de alemán', 'professors/bruh.jpg', '202cb962ac59075b964b07152d234b70', 1);

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
  MODIFY `Codi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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

-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-08-2017 a las 23:43:29
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ideohos1_cpcp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ArticleCategories`
--

CREATE TABLE `ArticleCategories` (
  `ArticleCategoryId` int(11) NOT NULL,
  `ArticleId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ArticleCategories`
--

INSERT INTO `ArticleCategories` (`ArticleCategoryId`, `ArticleId`, `CategoryId`) VALUES
(14, 3, 4),
(15, 2, 1),
(16, 1, 1),
(17, 1, 2),
(18, 4, 4),
(20, 5, 1),
(22, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ArticlePhotos`
--

CREATE TABLE `ArticlePhotos` (
  `ArticlePhotoId` int(11) NOT NULL,
  `ArticleId` int(11) NOT NULL,
  `Photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Articles`
--

CREATE TABLE `Articles` (
  `ArticleId` int(11) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Photo` varchar(200) DEFAULT NULL,
  `Content` text NOT NULL,
  `PublishDate` date NOT NULL,
  `StatusId` int(11) NOT NULL,
  `Author` varchar(200) NOT NULL,
  `Slug` varchar(100) NOT NULL,
  `MetaTitle` varchar(100) NOT NULL,
  `MetaDescription` varchar(255) NOT NULL,
  `Featured` int(11) DEFAULT '0',
  `Keywords` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Articles`
--

INSERT INTO `Articles` (`ArticleId`, `Title`, `Photo`, `Content`, `PublishDate`, `StatusId`, `Author`, `Slug`, `MetaTitle`, `MetaDescription`, `Featured`, `Keywords`) VALUES
(6, 'Artículo de prueba', 'bm7_cuperosis-sintomas-causas-y-tratamiento.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquid ex ea commodi consequat</p>\r\n', '2017-08-03', 1, 'William Sandoval', 'articulo-de-prueba', 'Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua.', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CalificationDoctors`
--

CREATE TABLE `CalificationDoctors` (
  `CalificationDoctorId` int(11) NOT NULL,
  `DoctorId` int(11) NOT NULL,
  `NameUser` varchar(100) NOT NULL,
  `CountStars` int(2) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `DateComment` datetime NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `CalificationDoctors`
--

INSERT INTO `CalificationDoctors` (`CalificationDoctorId`, `DoctorId`, `NameUser`, `CountStars`, `Email`, `Comment`, `DateComment`, `Status`) VALUES
(1, 61, 'William', 3, 'wjsm93@gmail.com', 'Muy buen médico', '2017-08-04 17:21:56', 'Inactive');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categories`
--

CREATE TABLE `Categories` (
  `CategoryId` int(11) NOT NULL,
  `Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Categories`
--

INSERT INTO `Categories` (`CategoryId`, `Name`) VALUES
(1, 'Cirugía');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clients`
--

CREATE TABLE `Clients` (
  `ClientId` int(11) NOT NULL,
  `BusinessName` varchar(100) NOT NULL,
  `Identification` varchar(100) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `MobilePhone` varchar(100) DEFAULT NULL,
  `LocalPhone` varchar(100) DEFAULT NULL,
  `Address` text,
  `City` varchar(100) DEFAULT NULL,
  `Address2` varchar(100) DEFAULT NULL,
  `Country` varchar(100) DEFAULT NULL,
  `Discount` int(3) DEFAULT NULL,
  `Calification` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Clients`
--

INSERT INTO `Clients` (`ClientId`, `BusinessName`, `Identification`, `Name`, `Email`, `MobilePhone`, `LocalPhone`, `Address`, `City`, `Address2`, `Country`, `Discount`, `Calification`) VALUES
(1, 'Grupo WJSM, C.A.', '40209853-7', 'Willmar Sandoval', 'info@pixelgrafia.com', '02123728999', '2123728999', 'Km 16 Carretera Panamericana\r\nCC Club de Campo', 'San Antonio de los Altos', 'Calle La Pomarrosa', 'Venezuela', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ContestCalificationDoctors`
--

CREATE TABLE `ContestCalificationDoctors` (
  `ContestCalificationDoctorId` int(11) NOT NULL,
  `CalificationDoctorId` int(11) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `DateComment` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Data`
--

CREATE TABLE `Data` (
  `DataDoctorId` int(11) NOT NULL,
  `DoctorId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Doctors`
--

CREATE TABLE `Doctors` (
  `DoctorId` int(11) NOT NULL,
  `ClientId` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `SubTitle` varchar(250) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `PlanId` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Logo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Doctors`
--

INSERT INTO `Doctors` (`DoctorId`, `ClientId`, `Name`, `SubTitle`, `Description`, `PlanId`, `Email`, `Logo`) VALUES
(61, 1, 'John García', 'Médico cirujano', 'Doctor graduado de la Universidad de los Andes y profesional en el área de cirugías', 5, 'doctor@doctor.com', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `GalleryDoctors`
--

CREATE TABLE `GalleryDoctors` (
  `GalleryDoctorId` int(11) NOT NULL,
  `DoctorId` int(11) NOT NULL,
  `Location` varchar(250) NOT NULL,
  `Type` enum('Image','Video') NOT NULL,
  `CalificationDoctorId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `GalleryDoctors`
--

INSERT INTO `GalleryDoctors` (`GalleryDoctorId`, `DoctorId`, `Location`, `Type`, `CalificationDoctorId`) VALUES
(1, 61, 'zpg06r1sf04Cuperosis-siÌntomas-causas-y-tratamiento.png', 'Image', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `PlanClients`
--

CREATE TABLE `PlanClients` (
  `PlanClientId` int(11) NOT NULL,
  `DoctorId` int(11) NOT NULL,
  `PlanId` int(11) NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Plans`
--

CREATE TABLE `Plans` (
  `PlanId` int(11) NOT NULL,
  `Name` text NOT NULL,
  `Price` int(11) NOT NULL,
  `Characteristic` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Plans`
--

INSERT INTO `Plans` (`PlanId`, `Name`, `Price`, `Characteristic`) VALUES
(5, 'Membresía Básica', 15000, 'a:5:{s:9:\"plan_foto\";s:1:\"1\";s:10:\"plan_datos\";s:1:\"1\";s:11:\"plan_perfil\";s:1:\"1\";s:18:\"plan_actualizacion\";s:1:\"1\";s:10:\"plan_casos\";s:1:\"5\";}'),
(6, 'Membresía Estándar', 20000, 'a:9:{s:9:\"plan_foto\";s:1:\"1\";s:10:\"plan_datos\";s:1:\"1\";s:11:\"plan_perfil\";s:1:\"1\";s:18:\"plan_actualizacion\";s:1:\"1\";s:10:\"plan_casos\";s:2:\"10\";s:9:\"plan_link\";s:1:\"1\";s:11:\"plan_conteo\";s:1:\"1\";s:15:\"plan_preguntale\";s:1:\"1\";s:13:\"plan_reportes\";s:1:\"1\";}'),
(7, 'Membresía Elite', 25000, 'a:13:{s:9:\"plan_foto\";s:1:\"1\";s:10:\"plan_datos\";s:1:\"1\";s:11:\"plan_perfil\";s:1:\"1\";s:18:\"plan_actualizacion\";s:1:\"1\";s:10:\"plan_casos\";s:4:\"1000\";s:9:\"plan_link\";s:1:\"1\";s:11:\"plan_conteo\";s:1:\"1\";s:15:\"plan_preguntale\";s:1:\"1\";s:13:\"plan_reportes\";s:1:\"1\";s:11:\"plan_cuenta\";s:1:\"1\";s:13:\"plan_bloquear\";s:1:\"1\";s:18:\"plan_participacion\";s:1:\"1\";s:14:\"plan_respuesta\";s:1:\"1\";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ProceduresDoctor`
--

CREATE TABLE `ProceduresDoctor` (
  `ProceduresDoctorId` int(11) NOT NULL,
  `DoctorId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `SubCategoryId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Publicitys`
--

CREATE TABLE `Publicitys` (
  `PublicityId` int(11) NOT NULL,
  `Title` varchar(150) NOT NULL,
  `Content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Publicitys`
--

INSERT INTO `Publicitys` (`PublicityId`, `Title`, `Content`) VALUES
(1, 'Google AdSense', '<ins class=\"adsbygoogle\"\r\n     style=\"display:block\"\r\n     Data-ad-client=\"ca-pub-5470180008157627\"\r\n     Data-ad-slot=\"6852021198\"\r\n     Data-ad-format=\"auto\"></ins>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Sections`
--

CREATE TABLE `Sections` (
  `SectionId` int(11) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `MetaTitle` varchar(250) NOT NULL,
  `MetaDescription` varchar(250) NOT NULL,
  `Keywords` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Sections`
--

INSERT INTO `Sections` (`SectionId`, `Name`, `MetaTitle`, `MetaDescription`, `Keywords`) VALUES
(1, 'Inicio', 'Cirugía Plástica Colombia', 'test', 'test'),
(2, 'Procedimientos', 'procedimientos', 'test', 'test'),
(3, 'Directorio', 'directorio', 'test2', 'test'),
(4, 'Blog', 'Blog :: Cirugía Plástica Colombia', 'test', 'test'),
(5, 'Videos', 'Videos', 'test', 'test'),
(6, 'Contáctanos', 'contactanos', 'test', 'test');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SubCategories`
--

CREATE TABLE `SubCategories` (
  `SubCategoryId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `Photo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `SubCategories`
--

INSERT INTO `SubCategories` (`SubCategoryId`, `CategoryId`, `Name`, `Description`, `Photo`) VALUES
(1, 1, 'Apendicectomía', 'Extirpación del apéndice', 'lih_doctor.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `UserDoctors`
--

CREATE TABLE `UserDoctors` (
  `UserDoctorsId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `DoctorId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `UserDoctors`
--

INSERT INTO `UserDoctors` (`UserDoctorsId`, `UserId`, `DoctorId`) VALUES
(1, 1, 61);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Users`
--

CREATE TABLE `Users` (
  `UserId` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Phone` varchar(100) DEFAULT NULL,
  `Description` text,
  `Permissions` text,
  `Type` enum('Client','Doctor','UserDoctor','NULL') DEFAULT NULL,
  `TypeId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Users`
--

INSERT INTO `Users` (`UserId`, `Name`, `Email`, `Password`, `Phone`, `Description`, `Permissions`, `Type`, `TypeId`) VALUES
(1, 'William Sandoval', 'wjsm93@gmail.com', 'VWNiZ1VtT1ZXVmw3dHV0eXFtSEFnQT09', '04241726589', 'Super administrador', 'a:30:{i:0;s:14:\"per_blog_crear\";i:1;s:15:\"per_blog_editar\";i:2;s:17:\"per_blog_eliminar\";i:3;s:17:\"per_medicos_crear\";i:4;s:18:\"per_medicos_editar\";i:5;s:20:\"per_medicos_eliminar\";i:6;s:16:\"per_planes_crear\";i:7;s:17:\"per_planes_editar\";i:8;s:19:\"per_planes_eliminar\";i:9;s:24:\"per_procedimientos_crear\";i:10;s:25:\"per_procedimientos_editar\";i:11;s:27:\"per_procedimientos_eliminar\";i:12;s:18:\"per_clientes_crear\";i:13;s:19:\"per_clientes_editar\";i:14;s:21:\"per_clientes_eliminar\";i:15;s:20:\"per_publicidad_crear\";i:16;s:21:\"per_publicidad_editar\";i:17;s:23:\"per_publicidad_eliminar\";i:18;s:15:\"per_pagos_crear\";i:19;s:16:\"per_pagos_editar\";i:20;s:18:\"per_pagos_eliminar\";i:21;s:14:\"per_seo_editar\";i:22;s:18:\"per_usuarios_crear\";i:23;s:19:\"per_usuarios_editar\";i:24;s:21:\"per_usuarios_eliminar\";i:25;s:15:\"per_medico_info\";i:26;s:22:\"per_medico_descripcion\";i:27;s:18:\"per_medico_galeria\";i:28;s:25:\"per_medico_calificaciones\";i:29;s:12:\"per_permisos\";}', NULL, NULL),
(21, 'Luis Ugueto', 'lugueto@prueba.com', 'SGJuTWJONGNZc2gwTTBTbE4xcEg0Zz09', '000000', 'Admin', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ValidationCalificationDoctors`
--

CREATE TABLE `ValidationCalificationDoctors` (
  `ValidationCalificationDoctorId` int(11) NOT NULL,
  `CalificationDoctorId` int(11) NOT NULL,
  `Code` varchar(250) NOT NULL,
  `Status` enum('Active','Inactive') NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ValidationCalificationDoctors`
--

INSERT INTO `ValidationCalificationDoctors` (`ValidationCalificationDoctorId`, `CalificationDoctorId`, `Code`, `Status`) VALUES
(1, 1, '41kt9tdt904', 'Inactive');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ArticleCategories`
--
ALTER TABLE `ArticleCategories`
  ADD PRIMARY KEY (`ArticleCategoryId`);

--
-- Indices de la tabla `ArticlePhotos`
--
ALTER TABLE `ArticlePhotos`
  ADD PRIMARY KEY (`ArticlePhotoId`);

--
-- Indices de la tabla `Articles`
--
ALTER TABLE `Articles`
  ADD PRIMARY KEY (`ArticleId`);

--
-- Indices de la tabla `CalificationDoctors`
--
ALTER TABLE `CalificationDoctors`
  ADD PRIMARY KEY (`CalificationDoctorId`);

--
-- Indices de la tabla `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`CategoryId`);

--
-- Indices de la tabla `Clients`
--
ALTER TABLE `Clients`
  ADD PRIMARY KEY (`ClientId`);

--
-- Indices de la tabla `ContestCalificationDoctors`
--
ALTER TABLE `ContestCalificationDoctors`
  ADD PRIMARY KEY (`ContestCalificationDoctorId`);

--
-- Indices de la tabla `Data`
--
ALTER TABLE `Data`
  ADD PRIMARY KEY (`DataDoctorId`);

--
-- Indices de la tabla `Doctors`
--
ALTER TABLE `Doctors`
  ADD PRIMARY KEY (`DoctorId`);

--
-- Indices de la tabla `GalleryDoctors`
--
ALTER TABLE `GalleryDoctors`
  ADD PRIMARY KEY (`GalleryDoctorId`);

--
-- Indices de la tabla `PlanClients`
--
ALTER TABLE `PlanClients`
  ADD PRIMARY KEY (`PlanClientId`);

--
-- Indices de la tabla `Plans`
--
ALTER TABLE `Plans`
  ADD PRIMARY KEY (`PlanId`);

--
-- Indices de la tabla `ProceduresDoctor`
--
ALTER TABLE `ProceduresDoctor`
  ADD PRIMARY KEY (`ProceduresDoctorId`);

--
-- Indices de la tabla `Publicitys`
--
ALTER TABLE `Publicitys`
  ADD PRIMARY KEY (`PublicityId`);

--
-- Indices de la tabla `Sections`
--
ALTER TABLE `Sections`
  ADD PRIMARY KEY (`SectionId`);

--
-- Indices de la tabla `SubCategories`
--
ALTER TABLE `SubCategories`
  ADD PRIMARY KEY (`SubCategoryId`);

--
-- Indices de la tabla `UserDoctors`
--
ALTER TABLE `UserDoctors`
  ADD PRIMARY KEY (`UserDoctorsId`);

--
-- Indices de la tabla `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indices de la tabla `ValidationCalificationDoctors`
--
ALTER TABLE `ValidationCalificationDoctors`
  ADD PRIMARY KEY (`ValidationCalificationDoctorId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ArticleCategories`
--
ALTER TABLE `ArticleCategories`
  MODIFY `ArticleCategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `ArticlePhotos`
--
ALTER TABLE `ArticlePhotos`
  MODIFY `ArticlePhotoId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Articles`
--
ALTER TABLE `Articles`
  MODIFY `ArticleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `CalificationDoctors`
--
ALTER TABLE `CalificationDoctors`
  MODIFY `CalificationDoctorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Categories`
--
ALTER TABLE `Categories`
  MODIFY `CategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Clients`
--
ALTER TABLE `Clients`
  MODIFY `ClientId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `ContestCalificationDoctors`
--
ALTER TABLE `ContestCalificationDoctors`
  MODIFY `ContestCalificationDoctorId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Data`
--
ALTER TABLE `Data`
  MODIFY `DataDoctorId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Doctors`
--
ALTER TABLE `Doctors`
  MODIFY `DoctorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT de la tabla `GalleryDoctors`
--
ALTER TABLE `GalleryDoctors`
  MODIFY `GalleryDoctorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `PlanClients`
--
ALTER TABLE `PlanClients`
  MODIFY `PlanClientId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Plans`
--
ALTER TABLE `Plans`
  MODIFY `PlanId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `ProceduresDoctor`
--
ALTER TABLE `ProceduresDoctor`
  MODIFY `ProceduresDoctorId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `Publicitys`
--
ALTER TABLE `Publicitys`
  MODIFY `PublicityId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Sections`
--
ALTER TABLE `Sections`
  MODIFY `SectionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `SubCategories`
--
ALTER TABLE `SubCategories`
  MODIFY `SubCategoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `UserDoctors`
--
ALTER TABLE `UserDoctors`
  MODIFY `UserDoctorsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `Users`
--
ALTER TABLE `Users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `ValidationCalificationDoctors`
--
ALTER TABLE `ValidationCalificationDoctors`
  MODIFY `ValidationCalificationDoctorId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

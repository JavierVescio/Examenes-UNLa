CREATE DATABASE  IF NOT EXISTS `royal_academy` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci */;
USE `royal_academy`;
-- MySQL dump 10.13  Distrib 5.5.57, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: royal_academy
-- ------------------------------------------------------
-- Server version	5.5.57-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alumnos`
--

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnos` (
  `id_alumno` bigint(20) NOT NULL AUTO_INCREMENT,
  `apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `genero` varchar(45) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'M',
  `tipo_doc` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `documento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `celular` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clave_acceso` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_sede_inscripcion` bigint(20) NOT NULL,
  `id_staff_inscripcion` bigint(20) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  PRIMARY KEY (`id_alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos_inscripcion`
--

DROP TABLE IF EXISTS `alumnos_inscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnos_inscripcion` (
  `id_inscripcion` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_alumno` bigint(20) NOT NULL,
  `id_curso` bigint(20) NOT NULL,
  `id_sede` int(11) NOT NULL,
  `fecha_inscripcion` datetime NOT NULL,
  `fecha_finalizacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id_inscripcion`),
  KEY `fk_inscripcion_alumno_idx` (`id_alumno`),
  KEY `fk_inscripcion_curso_idx` (`id_curso`),
  KEY `fk_inscripcion_sede_idx` (`id_sede`),
  CONSTRAINT `fk_inscripcion_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_curso` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscripcion_sede` FOREIGN KEY (`id_sede`) REFERENCES `sedes` (`id_sede`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos_inscripcion`
--

LOCK TABLES `alumnos_inscripcion` WRITE;
/*!40000 ALTER TABLE `alumnos_inscripcion` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos_inscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cursos` (
  `id_curso` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursos`
--

LOCK TABLES `cursos` WRITE;
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT INTO `cursos` VALUES (1,'Curso Test','Cursos de testeo del sistema');
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examenes`
--

DROP TABLE IF EXISTS `examenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `examenes` (
  `id_examen` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_curso` bigint(20) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario_creador` bigint(20) DEFAULT NULL,
  `cantidad_preguntas` int(11) DEFAULT NULL,
  `nota_aprobacion` float DEFAULT NULL,
  PRIMARY KEY (`id_examen`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examenes`
--

LOCK TABLES `examenes` WRITE;
/*!40000 ALTER TABLE `examenes` DISABLE KEYS */;
INSERT INTO `examenes` VALUES (1,1,'2017-07-01 12:12:12',NULL,5,8);
/*!40000 ALTER TABLE `examenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `examenes_preguntas`
--

DROP TABLE IF EXISTS `examenes_preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `examenes_preguntas` (
  `id_examenes_preguntas` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_examen` bigint(20) DEFAULT NULL,
  `id_pregunta` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_examenes_preguntas`),
  KEY `fk_examenes_preguntas_examen_idx` (`id_examen`),
  KEY `fk_examenes_preguntas_pregunta_idx` (`id_pregunta`),
  CONSTRAINT `fk_examenes_preguntas_examen` FOREIGN KEY (`id_examen`) REFERENCES `examenes` (`id_examen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_examenes_preguntas_pregunta` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `examenes_preguntas`
--

LOCK TABLES `examenes_preguntas` WRITE;
/*!40000 ALTER TABLE `examenes_preguntas` DISABLE KEYS */;
/*!40000 ALTER TABLE `examenes_preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paises`
--

DROP TABLE IF EXISTS `paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paises` (
  `id_pais` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(70) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_corto` varchar(5) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id_pais`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paises`
--

LOCK TABLES `paises` WRITE;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas`
--

DROP TABLE IF EXISTS `preguntas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preguntas` (
  `id_pregunta` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_curso` bigint(20) NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cant_opciones_validas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas`
--

LOCK TABLES `preguntas` WRITE;
/*!40000 ALTER TABLE `preguntas` DISABLE KEYS */;
/*!40000 ALTER TABLE `preguntas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas_imagenes`
--

DROP TABLE IF EXISTS `preguntas_imagenes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preguntas_imagenes` (
  `id_pregunta_imagen` bigint(20) NOT NULL AUTO_INCREMENT,
  `path` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_pregunta` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_pregunta_imagen`),
  KEY `fk_preguntas_imagenes_preguntas_idx` (`id_pregunta`),
  CONSTRAINT `fk_preguntas_imagenes_preguntas` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas_imagenes`
--

LOCK TABLES `preguntas_imagenes` WRITE;
/*!40000 ALTER TABLE `preguntas_imagenes` DISABLE KEYS */;
/*!40000 ALTER TABLE `preguntas_imagenes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas_opciones`
--

DROP TABLE IF EXISTS `preguntas_opciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preguntas_opciones` (
  `id_opcion` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_pregunta` bigint(20) NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `es_correcta` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_opcion`),
  KEY `fk_preguntas_opciones_pregunta_idx` (`id_pregunta`),
  CONSTRAINT `fk_preguntas_opciones_pregunta` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas_opciones`
--

LOCK TABLES `preguntas_opciones` WRITE;
/*!40000 ALTER TABLE `preguntas_opciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `preguntas_opciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resolucion_examen`
--

DROP TABLE IF EXISTS `resolucion_examen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resolucion_examen` (
  `id_resolucion_examen` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_turno_examen` bigint(20) NOT NULL,
  `id_alumno` bigint(20) NOT NULL,
  `id_pregunta` bigint(20) NOT NULL,
  `id_opcion` bigint(20) NOT NULL,
  PRIMARY KEY (`id_resolucion_examen`),
  KEY `fk_resolucion_examen_turno_idx` (`id_turno_examen`),
  KEY `fk_resolucion_examen_alumno_idx` (`id_alumno`),
  KEY `fk_resolucion_examen_pregunta_idx` (`id_pregunta`),
  KEY `fk_resolucion_examen_opcion_idx` (`id_opcion`),
  CONSTRAINT `fk_resolucion_examen_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_resolucion_examen_opcion` FOREIGN KEY (`id_opcion`) REFERENCES `preguntas_opciones` (`id_opcion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_resolucion_examen_pregunta` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_resolucion_examen_turno` FOREIGN KEY (`id_turno_examen`) REFERENCES `turno_examen` (`id_turno_examen`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resolucion_examen`
--

LOCK TABLES `resolucion_examen` WRITE;
/*!40000 ALTER TABLE `resolucion_examen` DISABLE KEYS */;
/*!40000 ALTER TABLE `resolucion_examen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sedes`
--

DROP TABLE IF EXISTS `sedes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sedes` (
  `id_sede` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `id_pais` int(11) NOT NULL,
  PRIMARY KEY (`id_sede`),
  KEY `fk_sedes_pais_idx` (`id_pais`),
  CONSTRAINT `fk_sedes_pais` FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sedes`
--

LOCK TABLES `sedes` WRITE;
/*!40000 ALTER TABLE `sedes` DISABLE KEYS */;
/*!40000 ALTER TABLE `sedes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id_staff` int(11) NOT NULL,
  `apellido` varchar(70) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(70) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_doc` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `documento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_perfil` varchar(2) COLLATE utf8_spanish_ci DEFAULT 'AG',
  `email` varchar(70) COLLATE utf8_spanish_ci DEFAULT NULL,
  `clave_acceso` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_sede` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_staff`),
  KEY `fk_staff_sede_idx` (`id_sede`),
  CONSTRAINT `fk_staff_sede` FOREIGN KEY (`id_sede`) REFERENCES `sedes` (`id_sede`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turno_examen`
--

DROP TABLE IF EXISTS `turno_examen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `turno_examen` (
  `id_turno_examen` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_sede` int(11) NOT NULL,
  `id_examen` bigint(20) NOT NULL,
  `fecha_examen` datetime NOT NULL,
  PRIMARY KEY (`id_turno_examen`),
  KEY `fk_turno_examen_examen_idx` (`id_examen`),
  KEY `fk_turno_examen_sede_idx` (`id_sede`),
  CONSTRAINT `fk_turno_examen_examen` FOREIGN KEY (`id_examen`) REFERENCES `examenes` (`id_examen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_turno_examen_sede` FOREIGN KEY (`id_sede`) REFERENCES `sedes` (`id_sede`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turno_examen`
--

LOCK TABLES `turno_examen` WRITE;
/*!40000 ALTER TABLE `turno_examen` DISABLE KEYS */;
/*!40000 ALTER TABLE `turno_examen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `turno_examen_inscripcion`
--

DROP TABLE IF EXISTS `turno_examen_inscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `turno_examen_inscripcion` (
  `id_turno_examen` bigint(20) NOT NULL,
  `id_alumno` bigint(20) NOT NULL,
  `fecha_inscripcion` datetime NOT NULL,
  `realizo_examen` tinyint(4) DEFAULT NULL COMMENT 'Flag para levantar cuando el alumno se presenta y realiza el examen',
  `nota_examen` float DEFAULT NULL COMMENT 'Campo para completar luego de la correción del examen',
  PRIMARY KEY (`id_turno_examen`,`id_alumno`),
  KEY `fk_alumno_turno_examen_alumno_idx` (`id_alumno`),
  CONSTRAINT `fk_alumno_turno_examen_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumno_turno_examen_turno` FOREIGN KEY (`id_turno_examen`) REFERENCES `turno_examen` (`id_turno_examen`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turno_examen_inscripcion`
--

LOCK TABLES `turno_examen_inscripcion` WRITE;
/*!40000 ALTER TABLE `turno_examen_inscripcion` DISABLE KEYS */;
/*!40000 ALTER TABLE `turno_examen_inscripcion` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-10-06 19:52:17


insert into paises (id_pais, nombre, nombre_corto) values (1, 'Argentina', 'AR');
insert into paises (id_pais, nombre, nombre_corto) values (2, 'Uruguay', 'UR');
insert into paises (id_pais, nombre, nombre_corto) values (3, 'España', 'ES');

insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (1, 'Maseda', 'Pablo', 'M', 2, '50-839-0633', 'pablomaseda@gmail.com', '+27 280 768 8227', '123456', 1, 3, '2019-10-05 09:32:22');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (2, 'Diorno', 'Axel', 'F', 1, '15-736-9901', 'axeldiorno07@gmail.com', '+591 407 300 4059', '123456', 3, 2, '2019-10-06 20:14:08');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (3, 'Melgarejo', 'José', 'F', 2, '76-457-7704', 'jossse.melgarejo@gmail.com', '+54 382 813 9202', '123456', 1, 2, '2019-10-06 18:09:04');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (4, 'Obaya', 'Guillermo', 'F', 3, '00-215-8614', 'guille.obaya@gmail.com', '+1 408 235 3694', '123456', 1, 3, '2019-10-05 17:05:28');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (5, 'Vescio', 'Javier', 'F', 3, '27-893-4225', 'javiervescio@gmail.com', '+63 391 872 4996', '123456', 2, 3, '2019-10-06 08:59:09');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (6, 'Mulvaney', 'Dennie', 'M', 3, '17-205-4035', 'dmulvaney5@google.es', '+62 290 853 6265', 'r8ZXA7I', 1, 3, '2019-10-06 04:08:00');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (7, 'Glen', 'Roxanne', 'F', 1, '95-222-5224', 'rglen6@ehow.com', '+351 826 626 5841', '7TCAuB', 3, 1, '2019-10-05 14:42:59');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (8, 'Milesap', 'Elonore', 'F', 1, '24-647-2180', 'emilesap7@pcworld.com', '+54 371 388 9410', 'I40EGE8lV1', 3, 2, '2019-10-06 20:42:44');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (9, 'Zotto', 'Marjy', 'F', 3, '84-642-0202', 'mzotto8@istockphoto.com', '+48 187 102 3303', 'xLW11t1fQ', 3, 3, '2019-10-06 08:01:05');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (10, 'Guttridge', 'Vale', 'M', 2, '31-412-7777', 'vguttridge9@desdev.cn', '+54 216 839 4254', 'gCUytk7iMs', 2, 3, '2019-10-06 10:42:42');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (11, 'Bocock', 'Lanita', 'F', 1, '55-610-0642', 'lbococka@ft.com', '+98 625 972 5441', 'sWow1Jby', 1, 3, '2019-10-05 11:59:20');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (12, 'Miquelet', 'Orlando', 'M', 3, '27-606-5923', 'omiqueletb@miitbeian.gov.cn', '+86 594 257 3224', 'CTAsbDiuBZgT', 3, 1, '2019-10-05 11:41:30');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (13, 'Stonner', 'Rodrick', 'M', 3, '09-235-3417', 'rstonnerc@nba.com', '+420 700 740 8630', 'iQb84iexylp', 3, 3, '2019-10-05 18:06:20');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (14, 'Fernely', 'Hedda', 'F', 1, '70-558-6392', 'hfernelyd@networksolutions.com', '+502 934 637 1852', '5MX4KJ1J', 1, 2, '2019-10-06 06:51:00');
insert into alumnos (id_alumno, apellido, nombre, genero, tipo_doc, documento, email, celular, clave_acceso, id_sede_inscripcion, id_staff_inscripcion, fecha_alta) values (15, 'Chorley', 'Hadlee', 'M', 1, '52-298-1089', 'hchorleye@amazon.co.jp', '+1 602 707 1527', 'FtCLFmF', 3, 1, '2019-10-06 00:11:09');

insert into cursos (nombre, descripcion) values ('Oozz', 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.');
insert into cursos (nombre, descripcion) values ('Aibox', 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.');
insert into cursos (nombre, descripcion) values ('Eabox', 'Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.');
insert into cursos (nombre, descripcion) values ('Flashspan', 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.');

insert into sedes (id_sede, nombre, direccion, id_pais) values (1, 'RA Casa Central BsAs', 'Alicia M. De Justo 350', 1);
insert into sedes (id_sede, nombre, direccion, id_pais) values (2, 'RA Rosario', 'Av. Independencia 2473, DW', 1);
insert into sedes (id_sede, nombre, direccion, id_pais) values (3, 'Monahan, Paucek and Mueller', 'Oriental 69033', 2);
insert into sedes (id_sede, nombre, direccion, id_pais) values (4, 'Royal Academy España', '481 Straubel Alley', 3);

insert into staff (id_staff, apellido, nombre, tipo_doc, documento, tipo_perfil, email, clave_acceso, id_sede) values (1, 'Seston', 'Deeann', 2, '73-491-2134', 'AG', 'ag@ag.com', '123456', 1);
insert into staff (id_staff, apellido, nombre, tipo_doc, documento, tipo_perfil, email, clave_acceso, id_sede) values (2, 'Westberg', 'Kirby', 1, '04-521-2771', 'AP', 'ap@ap.com', '123456', 1);
insert into staff (id_staff, apellido, nombre, tipo_doc, documento, tipo_perfil, email, clave_acceso, id_sede) values (3, 'Lackinton', 'Clayson', 1, '71-736-9029', 'AS', 'as@as.com', '123456', 1);

SET FOREIGN_KEY_CHECKS = 1;




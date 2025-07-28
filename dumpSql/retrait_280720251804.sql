/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.11-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: retrait
-- ------------------------------------------------------
-- Server version	10.11.11-MariaDB-0+deb12u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agent`
--

DROP TABLE IF EXISTS `agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `agent` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `nom` varchar(64) NOT NULL,
  `prenom` varchar(64) NOT NULL,
  `idRoleAgent` int(2) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Fk_idRoleAgent` (`idRoleAgent`),
  CONSTRAINT `Fk_idRoleAgent` FOREIGN KEY (`idRoleAgent`) REFERENCES `role_agent` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent`
--

LOCK TABLES `agent` WRITE;
/*!40000 ALTER TABLE `agent` DISABLE KEYS */;
INSERT INTO `agent` VALUES
(1,'Durand','Pierre',1),
(2,'Lemoine','Sophie',2),
(3,'Martin','Jean',3),
(4,'Leclerc','Marion',4),
(5,'Benoit','Lucas',5),
(6,'Bernard','Thierry',3),
(7,'Dupont','Claire',2),
(8,'Charpentier','Marc',1),
(9,'Roche','Julien',4),
(10,'Faure','Isabelle',5);
/*!40000 ALTER TABLE `agent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `appareil`
--

DROP TABLE IF EXISTS `appareil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `appareil` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `idMarque` int(4) NOT NULL,
  `idModele` int(4) NOT NULL,
  `serialNumber` varchar(128) NOT NULL,
  `idAgent` int(4) NOT NULL,
  `dateRecord` date NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `serialNumber` (`serialNumber`),
  KEY `Fk_idAgent` (`idAgent`),
  KEY `Fk_idMarqueVerifyIntegrity` (`idMarque`),
  KEY `Fk_idModelVerifyIntegrity` (`idModele`),
  CONSTRAINT `FK_idModeleAppareil` FOREIGN KEY (`idModele`) REFERENCES `modele` (`ID`),
  CONSTRAINT `Fk_idAgent` FOREIGN KEY (`idAgent`) REFERENCES `agent` (`ID`),
  CONSTRAINT `Fk_idMarqueAppareil` FOREIGN KEY (`idMarque`) REFERENCES `marque` (`ID`),
  CONSTRAINT `Fk_idMarqueVerifyIntegrity` FOREIGN KEY (`idMarque`) REFERENCES `marque` (`ID`),
  CONSTRAINT `Fk_idModelVerifyIntegrity` FOREIGN KEY (`idModele`) REFERENCES `modele` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appareil`
--

LOCK TABLES `appareil` WRITE;
/*!40000 ALTER TABLE `appareil` DISABLE KEYS */;
INSERT INTO `appareil` VALUES
(6,37,37,'abtzrrhbtj',5,'2025-07-22'),
(10,32,41,'00125555',1,'2025-07-23'),
(12,32,41,'4dde7ded7',1,'2025-07-23'),
(13,32,41,'ddeefefef',1,'2025-07-23'),
(14,41,42,'zeffefzefe',5,'2025-07-23'),
(15,42,43,'te6d6de9',1,'2025-07-23'),
(16,32,44,'dd4zd77z8d',1,'2025-07-23'),
(17,32,45,'fede4e8ef4',1,'2025-07-23'),
(18,32,46,'ddzdzdz8zd',1,'2025-07-23'),
(19,32,47,'AXCP54458',1,'2025-07-21'),
(20,20,44,'feffefe',1,'2025-07-24');
/*!40000 ALTER TABLE `appareil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `code`
--

DROP TABLE IF EXISTS `code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `code` (
  `ID` int(3) NOT NULL AUTO_INCREMENT,
  `nom` varchar(256) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `code`
--

LOCK TABLES `code` WRITE;
/*!40000 ALTER TABLE `code` DISABLE KEYS */;
INSERT INTO `code` VALUES
(1,'Ajout d\'un retrait appareil','Un utilisateur à rajouter une ligne de la table \'appareil\''),
(2,'Modification d\'un retrait appareil','Un utilisateur à modifier une ligne de la table \'appareil\''),
(3,'Suppression d\'un retrait appareil','Un utilisateur à supprimer une ligne de la table \'appareil\''),
(4,'Un nouvelle agent de créée','Un nouvelle agent vient d\'être ajouter à la table \'agent\''),
(5,'Erreur durent l\'execution du code','Une erreur est survenue veuillez vous renseigner auprès de la description du log pour le connaitre le motif de l\'erreur dans la table logCode');
/*!40000 ALTER TABLE `code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logCode`
--

DROP TABLE IF EXISTS `logCode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `logCode` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `code` int(3) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `recordLog` timestamp NOT NULL DEFAULT current_timestamp(),
  `idAgent` int(4) DEFAULT NULL,
  `isErrorTrace` text DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_errorCOde` (`code`),
  KEY `FK_idAgentLpg` (`idAgent`),
  CONSTRAINT `FK_errorCOde` FOREIGN KEY (`code`) REFERENCES `code` (`ID`),
  CONSTRAINT `FK_idAgentLpg` FOREIGN KEY (`idAgent`) REFERENCES `agent` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logCode`
--

LOCK TABLES `logCode` WRITE;
/*!40000 ALTER TABLE `logCode` DISABLE KEYS */;
INSERT INTO `logCode` VALUES
(34,5,'Une tentative de division part zéro à était effectuer résultant d\'une erreur fatale ayant stopper le code.','2025-07-25 08:57:01',1,'#0 /var/www/html/retrait/test.php(8): errorExtend->runDivideByZero(12, 0, 1)\n#1 {main}'),
(35,5,'Une tentative de division part zéro à était effectuer résultant d\'une erreur fatale ayant stopper le code.','2025-07-25 13:50:50',1,'#0 /var/www/html/retrait/test.php(8): errorExtend->runDivideByZero(12, 0, 1)\n#1 {main}'),
(36,5,'Une tentative de division part zéro à était effectuer résultant d\'une erreur fatale ayant stopper le code.','2025-07-25 14:11:04',1,'#0 /var/www/html/retrait/test.php(8): errorExtend->runDivideByZero(12, 0, 1)\n#1 {main}'),
(40,5,'Une tentative de recherche d\'un utilisateur dans la base de données semblent n\'avoir pas fonctionner, l\'utilisateur ne semblent pas exister.','2025-07-25 14:37:42',1,'#0 /var/www/html/retrait/class/membre_class.php(316): errorExtend->runAgentNotExistingDatabase(1, Object(Closure))\n#1 /var/www/html/retrait/test.php(7): membre_class->findUserbyId(1)\n#2 {main}'),
(41,5,'Une tentative de recherche d\'un utilisateur dans la base de données semblent n\'avoir pas fonctionner, l\'utilisateur ne semblent pas exister.','2025-07-25 14:38:18',1,'#0 /var/www/html/retrait/class/membre_class.php(316): errorExtend->runAgentNotExistingDatabase(1, Object(Closure))\n#1 /var/www/html/retrait/test.php(7): membre_class->findUserbyId(1)\n#2 {main}'),
(42,5,'Une tentative de recherche d\'un utilisateur dans la base de données semblent n\'avoir pas fonctionner, l\'utilisateur ne semblent pas exister.','2025-07-25 14:38:19',1,'#0 /var/www/html/retrait/class/membre_class.php(316): errorExtend->runAgentNotExistingDatabase(1, Object(Closure))\n#1 /var/www/html/retrait/test.php(7): membre_class->findUserbyId(1)\n#2 {main}'),
(43,5,'Une tentative de recherche d\'un utilisateur dans la base de données semblent n\'avoir pas fonctionner, l\'utilisateur ne semblent pas exister.','2025-07-25 14:40:24',1,'#0 /var/www/html/retrait/class/membre_class.php(316): errorExtend->runAgentNotExistingDatabase(1, Object(Closure))\n#1 /var/www/html/retrait/test.php(7): membre_class->findUserbyId(1)\n#2 {main}'),
(62,5,'Une tentative de recherche d\'un utilisateur dans la base de données semblent n\'avoir pas fonctionner, l\'utilisateur ne semblent pas exister.','2025-07-28 07:59:04',NULL,'#0 /var/www/html/retrait/class/membre_class.php(317): errorExtend->runAgentNotExistingDatabase(5, Object(Closure))\n#1 /var/www/html/retrait/test.php(6): membre_class->findUserbyId(5)\n#2 {main}'),
(63,5,'Une tentative de recherche d\'un utilisateur dans la base de données semblent n\'avoir pas fonctionner, l\'utilisateur ne semblent pas exister.','2025-07-28 08:00:15',NULL,'#0 /var/www/html/retrait/class/membre_class.php(317): errorExtend->runAgentNotExistingDatabase(50, Object(Closure))\n#1 /var/www/html/retrait/test.php(6): membre_class->findUserbyId(50)\n#2 {main}'),
(64,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 12:59:30',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(65,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:00:18',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(66,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:00:41',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(67,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:00:54',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(68,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:01:47',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(69,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:02:27',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(70,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:02:45',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(71,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:03:28',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(72,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:03:43',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(73,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:03:49',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(74,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:03:53',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(75,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:04:20',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(76,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:04:44',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(154): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(77,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 13:32:26',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(161): errorExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}'),
(78,5,'Une tentative de visionnage d\'un historique utilisateur à était effectuer mais celui-ci n\'as pas fonction en raison de la non définition des variables au travers de l\'URL.','2025-07-28 15:51:58',NULL,'#0 /var/www/html/retrait/class/utilitary_class.php(161): exceptionExtend->variableNotDefineHistoricUser(Array, 2)\n#1 /var/www/html/retrait/historic_agent.php(16): utilitary_class->decodeDefineVariable(\'/retrait/histor...\', 2)\n#2 {main}');
/*!40000 ALTER TABLE `logCode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marque`
--

DROP TABLE IF EXISTS `marque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `marque` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `nom` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marque`
--

LOCK TABLES `marque` WRITE;
/*!40000 ALTER TABLE `marque` DISABLE KEYS */;
INSERT INTO `marque` VALUES
(1,'Samsung'),
(2,'Apple'),
(3,'Huawei'),
(4,'Sony'),
(5,'LG'),
(6,'Nokia'),
(7,'Motorola'),
(8,'Xiaomi'),
(9,'Google'),
(10,'OnePlus'),
(11,''),
(12,'GigaCOol tech'),
(13,'effefe'),
(14,'fefefe'),
(15,'59f7f7e8'),
(16,'887a8z7'),
(17,'fxeea8'),
(18,'ex87ea8a'),
(19,'ce875e7f5'),
(20,'Huawe'),
(21,'x89z49adz'),
(22,'ffex887f7'),
(23,'aex'),
(24,'f8afa'),
(25,'rfc7rr'),
(26,'feza7cf7'),
(27,'gvsrgs448dg4787'),
(28,'zedrftyghujiok'),
(29,'fghj'),
(30,'zzz'),
(31,'f ef78fe 78fe 8eff'),
(32,'LDLC'),
(33,'dfefeve'),
(34,'fvefeevf'),
(35,'evfezvzezvezf'),
(36,'vfzfzefevvfezzzfbzbeer'),
(37,'gzgtbabgertregrbr'),
(38,'fe8gg78gre'),
(39,'fe41fce18f1'),
(40,'cfefefecc7'),
(41,'zzddz'),
(42,'test.com'),
(43,'Huawey');
/*!40000 ALTER TABLE `marque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modele`
--

DROP TABLE IF EXISTS `modele`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `modele` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `nom` varchar(64) NOT NULL,
  `idMarque` int(4) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Fk_idMarque` (`idMarque`),
  CONSTRAINT `Fk_idMarque` FOREIGN KEY (`idMarque`) REFERENCES `marque` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modele`
--

LOCK TABLES `modele` WRITE;
/*!40000 ALTER TABLE `modele` DISABLE KEYS */;
INSERT INTO `modele` VALUES
(1,'Galaxy S21',1),
(2,'iPhone 13',2),
(3,'Mate 40',3),
(4,'Xperia 1',4),
(5,'G8 ThinQ',5),
(6,'Lumia 950',6),
(7,'Moto G7',7),
(8,'Mi 11',8),
(9,'Pixel 6',9),
(10,'OnePlus 9',10),
(11,'',11),
(12,'keyboard-drak-oniryx-azerty',12),
(13,'efeffe',13),
(14,'ffefefe',14),
(15,'e78e7f8e',15),
(16,'78d78xdz7a',16),
(17,'7xe7',17),
(18,'x878',18),
(19,'cezec917',13),
(20,'8fe78fce78fe',19),
(21,'idjdzkjdzo',20),
(22,'9xe98a9f89',21),
(23,'7x7',22),
(24,'efc',23),
(25,'8f7cc7e8',24),
(26,'c77e',25),
(27,'77ec7cef7c',26),
(28,'feff7efe8fe8fe78',27),
(29,'sdfgvhbjnk',28),
(30,'fghj',29),
(31,'fe e7 ffe7ef',31),
(32,'S21-39',32),
(33,'evfefvef',33),
(34,'vfevefvefef',34),
(35,'fzevfezevzfezfv',35),
(36,'rbeezbaztbztbz',36),
(37,'rgzereg',37),
(38,'fefefefefeef',38),
(39,'8ecfe8f7e8',39),
(40,'7fefefe7ef',40),
(41,'LDLC-OLED-KeyBoard-Test-001',32),
(42,'dzdzfee',41),
(43,'test-keyboard-001',42),
(44,'test-mouse-001',32),
(45,'test-screen-001',32),
(46,'test-USBKEY-001',32),
(47,'S21-397',32),
(48,'Huawe is not Huawey',43),
(49,'Huawe is not Huawei',43);
/*!40000 ALTER TABLE `modele` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_agent`
--

DROP TABLE IF EXISTS `role_agent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_agent` (
  `ID` int(2) NOT NULL AUTO_INCREMENT,
  `nom` varchar(64) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_agent`
--

LOCK TABLES `role_agent` WRITE;
/*!40000 ALTER TABLE `role_agent` DISABLE KEYS */;
INSERT INTO `role_agent` VALUES
(1,'chef de service'),
(2,'assistant'),
(3,'technicien'),
(4,'saisonnier'),
(5,'stagiaire');
/*!40000 ALTER TABLE `role_agent` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-28 18:06:02

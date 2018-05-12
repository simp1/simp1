-- MySQL dump 10.16  Distrib 10.1.31-MariaDB, for Win32 (AMD64)
--
-- Host: 127.0.0.1    Database: project
-- ------------------------------------------------------
-- Server version	10.1.31-MariaDB

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
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `backupID` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) NOT NULL,
  `timestamp` int(255) NOT NULL,
  PRIMARY KEY (`backupID`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
INSERT INTO `backup` VALUES (13,'admin',1526128815),(14,'admin',1526136033);
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `benutzer`
--

DROP TABLE IF EXISTS `benutzer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `benutzer` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `rights` int(11) NOT NULL,
  `superadmin` int(11) NOT NULL,
  `entfernt` tinyint(4) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `benutzer`
--

LOCK TABLES `benutzer` WRITE;
/*!40000 ALTER TABLE `benutzer` DISABLE KEYS */;
INSERT INTO `benutzer` VALUES ('6te','d1c056a983786a38ca76a05cda240c7b86d77136',0,1,0,1),('admin','A94A8FE5CCB19BA61C4C0873D391E987982FBBD3',1,1,1,0),('adminb','82ab84c9a03ace51218f8f3eff340c8e65feb6ea',1,1,0,1),('asdasd','331a4f44a6a875b2ce139ae0c9ce5bb5e1ec0d97',1,1,0,1),('Daniel','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',1,1,0,0),('esses','b009c7a279b7c92472f331fc8cca642aae7f6123',1,1,0,1),('sad','f10e2821bbbea527ea02200352313bc059445190',0,0,0,1),('steffen','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',0,0,0,1),('t','8efd86fb78a56a5145ed7739dcb00c78581c5375',0,0,0,1),('test','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',1,1,0,1),('Test0','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',1,0,0,0),('Test1','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',0,1,0,0),('Test10','da39a3ee5e6b4b0d3255bfef95601890afd80709',0,0,0,1),('Test4','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',1,1,0,1),('testacc','17ba0791499db908433b80f37c5fbc89b870084b',1,1,0,1),('testss','c6b77501af2051430fdce1659e8a9582ccba40ca',0,1,0,1),('testss1','da39a3ee5e6b4b0d3255bfef95601890afd80709',0,0,0,1),('teststest','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',0,0,0,0),('Trtl','930a0029225aa4c28b8ef095b679285eaae27078',1,1,0,1),('Trtls','da39a3ee5e6b4b0d3255bfef95601890afd80709',0,0,0,1);
/*!40000 ALTER TABLE `benutzer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dokumente`
--

DROP TABLE IF EXISTS `dokumente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dokumente` (
  `dokuID` int(11) NOT NULL AUTO_INCREMENT,
  `einsatzID` int(11) NOT NULL,
  `werkzeugID` int(11) NOT NULL,
  `pruefID` int(11) NOT NULL,
  `geoID` int(11) NOT NULL,
  `format` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  PRIMARY KEY (`dokuID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dokumente`
--

LOCK TABLES `dokumente` WRITE;
/*!40000 ALTER TABLE `dokumente` DISABLE KEYS */;
/*!40000 ALTER TABLE `dokumente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pruefmerkmale`
--

DROP TABLE IF EXISTS `pruefmerkmale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pruefmerkmale` (
  `merkmalID` int(11) NOT NULL AUTO_INCREMENT,
  `pruefID` int(11) NOT NULL,
  `beschreibung` varchar(255) NOT NULL,
  `wert` varchar(255) NOT NULL,
  PRIMARY KEY (`merkmalID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pruefmerkmale`
--

LOCK TABLES `pruefmerkmale` WRITE;
/*!40000 ALTER TABLE `pruefmerkmale` DISABLE KEYS */;
/*!40000 ALTER TABLE `pruefmerkmale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qrcode`
--

DROP TABLE IF EXISTS `qrcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `qrcode` (
  `qrID` int(11) NOT NULL AUTO_INCREMENT,
  `werkzeugID` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `svg` varchar(255) NOT NULL,
  PRIMARY KEY (`qrID`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qrcode`
--

LOCK TABLES `qrcode` WRITE;
/*!40000 ALTER TABLE `qrcode` DISABLE KEYS */;
INSERT INTO `qrcode` VALUES (31,9,'www.localhost.com/werkzeugID=9','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICA8c3ZnIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9InFyY29kZSI+PHN2ZyB2aWV3Qm94PSIwIDAgMjEgMjEiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9I'),(32,9,'www.localhost.com/werkzeugID=9','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICA8c3ZnIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9InFyY29kZSI+PC9nPgogICAgICAgICAgICAgICAgICA8L3N2Zz4KICAgICAgICAgICAgICAg'),(33,9,'www.localhost.com/werkzeugID=9','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICA8c3ZnIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9InFyY29kZSI+PHN2ZyB2aWV3Qm94PSIwIDAgMjEgMjEiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9I'),(34,9,'www.localhost.com/werkzeugID=9','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICA8c3ZnIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9InFyY29kZSI+PHN2ZyB2aWV3Qm94PSIwIDAgNDkgNDkiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9I'),(35,9,'www.localhost.com/werkzeugID=9','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgICAgIDxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgogICAgICAgICAgICAgICAgICAgICA8ZyBpZD0icXJjb2RlIj48c3ZnIHZpZXdCb3g9IjAgMCA0OSA0OSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2ZmZ'),(36,9,'www.localhost.com/werkzeugID=9','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgICAgIDxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgogICAgICAgICAgICAgICAgICAgICA8ZyBpZD0icXJjb2RlIj48c3ZnIHZpZXdCb3g9IjAgMCA0OSA0OSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2ZmZ'),(37,9,'www.localhost.com/werkzeugID=9','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgICAgIDxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPgogICAgICAgICAgICAgICAgICAgICA8ZyBpZD0icXJjb2RlIj48c3ZnIHZpZXdCb3g9IjAgMCA0OSA0OSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0iI2ZmZ'),(38,0,'http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?werkzeugID=undefined','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICA8c3ZnIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9InFyY29kZSI+PHN2ZyB2aWV3Qm94PSIwIDAgNTMgNTMiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9I'),(39,0,'http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?werkzeugID=undefined','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICA8c3ZnIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9InFyY29kZSI+PHN2ZyB2aWV3Qm94PSIwIDAgNTMgNTMiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9I'),(40,0,'http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?werkzeugID=undefined','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICA8c3ZnIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9InFyY29kZSI+PHN2ZyB2aWV3Qm94PSIwIDAgNTMgNTMiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9I'),(41,29,'http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?werkzeugID=9','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICA8c3ZnIGlkPSJzdmdDb250YWluZXIiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9InFyY29kZSI+PHN2ZyB2aWV3Qm94PSIwIDAgNDkgNDkiIHdpZ'),(42,45,'http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?werkzeugID=888776','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICA8c3ZnIGlkPSJzdmdDb250YWluZXIiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9InFyY29kZSI+PHN2ZyB2aWV3Qm94PSIwIDAgNTMgNTMiIHdpZ'),(43,29,'http://localhost/workspace/swimp/WebContent/werkzeugverwaltung.html?werkzeugID=9','','data:image/svg+xml;base64,CiAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICA8c3ZnIGlkPSJzdmdDb250YWluZXIiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgICAgICAgICAgICAgICAgICAgPGcgaWQ9InFyY29kZSI+PHN2ZyB2aWV3Qm94PSIwIDAgNDkgNDkiIHdpZ');
/*!40000 ALTER TABLE `qrcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schlagwort`
--

DROP TABLE IF EXISTS `schlagwort`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schlagwort` (
  `schlagwortID` int(255) NOT NULL AUTO_INCREMENT,
  `werkzeugID` int(255) NOT NULL,
  `schlagwort` varchar(255) NOT NULL,
  PRIMARY KEY (`schlagwortID`)
) ENGINE=InnoDB AUTO_INCREMENT=354 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schlagwort`
--

LOCK TABLES `schlagwort` WRITE;
/*!40000 ALTER TABLE `schlagwort` DISABLE KEYS */;
INSERT INTO `schlagwort` VALUES (168,42,'adad'),(169,42,'opp'),(170,42,'dada'),(171,42,'adad'),(172,42,'adada'),(173,42,'2018-04-09'),(184,43,'sad'),(185,43,'sada'),(186,43,'asdas'),(187,43,'asdsad'),(188,43,'2018-04-15'),(190,44,'sadss'),(191,44,'sada'),(192,44,'asdas'),(193,44,'asdsad'),(194,44,'2018-04-15'),(334,45,'ztu'),(335,45,'888776'),(336,45,'jj'),(337,45,'jj'),(338,45,'jj'),(339,45,'10.10.2000'),(340,41,'sdad'),(341,41,'opss'),(342,41,'sadasd'),(343,41,'sada'),(344,41,'dsaa'),(345,41,'2018-04-08'),(346,29,'    ball'),(347,29,'     hose'),(348,29,'     schuhe'),(349,29,'9'),(350,29,'P300'),(351,29,'Wasses'),(352,29,'Seilii'),(353,29,'2018-04-08');
/*!40000 ALTER TABLE `schlagwort` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stammdaten`
--

DROP TABLE IF EXISTS `stammdaten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stammdaten` (
  `werkzeugID` int(255) NOT NULL AUTO_INCREMENT,
  `werkzeug_nummer` varchar(255) NOT NULL,
  `kurzbeschreibung` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `druckmaterial` varchar(255) NOT NULL,
  `druckmodus` varchar(255) NOT NULL,
  `drucker` varchar(255) NOT NULL,
  `herstelldatum` date NOT NULL,
  `entfernt` int(11) NOT NULL,
  PRIMARY KEY (`werkzeugID`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stammdaten`
--

LOCK TABLES `stammdaten` WRITE;
/*!40000 ALTER TABLE `stammdaten` DISABLE KEYS */;
INSERT INTO `stammdaten` VALUES (29,'9','testsdasda','Seilii','Wasses','laser222','P300','2018-04-08',0),(41,'opss','sdaassdauuu','dsaa','sada','sada','sadasd','2018-04-08',0),(42,'opp','sada','adada','adad','ada','dada','2018-04-09',1),(43,'sad','sadasd','asdsad','asdas','sada','sada','2018-04-15',1),(44,'sadss','sadasd','asdsad','asdas','sada','sada','2018-04-15',1),(45,'888776','jj','jj','jj','jj','jj','0000-00-00',0);
/*!40000 ALTER TABLE `stammdaten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tokens` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `token_login` varchar(255) NOT NULL,
  `lastip` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
INSERT INTO `tokens` VALUES (1,1521633386,'1bacf814380ce284f1f6af1a5c417e392a210903','9027baf6144c234474100a781afb30290128f0a6','0','test'),(2,1526136127,'28e7c77a4dc4ebadd260a5eeb8e3a8e9907e02bf','9027baf6144c234474100a781afb30290128f0a6','0','admin'),(3,1523268711,'7a4ce19ce9f92a684b96a74efec27fbed9547666','9027baf6144c234474100a781afb30290128f0a6','0','Daniel'),(4,1521848888,'beee3a0f544318f6a4089125f4807bf1455ad8e8','9027baf6144c234474100a781afb30290128f0a6','0','Test0'),(5,1523269807,'d4d98c582fd7073ee8826266327dd2b710df3808','9027baf6144c234474100a781afb30290128f0a6','0','Test1'),(6,1524052343,'4f3dade0ffdb15e1ef9b8637a90fa79d6085c4b5','9027baf6144c234474100a781afb30290128f0a6','0','steffen');
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `werkzeug_attribute`
--

DROP TABLE IF EXISTS `werkzeug_attribute`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `werkzeug_attribute` (
  `werkzeug_attID` int(255) NOT NULL AUTO_INCREMENT,
  `werkzeugID` int(255) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `wert` varchar(255) NOT NULL,
  PRIMARY KEY (`werkzeug_attID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `werkzeug_attribute`
--

LOCK TABLES `werkzeug_attribute` WRITE;
/*!40000 ALTER TABLE `werkzeug_attribute` DISABLE KEYS */;
INSERT INTO `werkzeug_attribute` VALUES (1,29,'test','test');
/*!40000 ALTER TABLE `werkzeug_attribute` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `werkzeug_einsatz`
--

DROP TABLE IF EXISTS `werkzeug_einsatz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `werkzeug_einsatz` (
  `einsatzID` int(11) NOT NULL AUTO_INCREMENT,
  `werkzeugID` int(11) NOT NULL,
  `laufendenummer` int(11) NOT NULL,
  `datum` date NOT NULL,
  `schussnummer` int(11) NOT NULL,
  `maschine` varchar(255) NOT NULL,
  `kuehlung` varchar(255) NOT NULL,
  `kuehldauer` varchar(255) NOT NULL,
  `schlieÃŸkraft` int(11) NOT NULL,
  PRIMARY KEY (`einsatzID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `werkzeug_einsatz`
--

LOCK TABLES `werkzeug_einsatz` WRITE;
/*!40000 ALTER TABLE `werkzeug_einsatz` DISABLE KEYS */;
/*!40000 ALTER TABLE `werkzeug_einsatz` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `werkzeug_pruef`
--

DROP TABLE IF EXISTS `werkzeug_pruef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `werkzeug_pruef` (
  `pruefID` int(11) NOT NULL AUTO_INCREMENT,
  `werkzeugID` int(11) NOT NULL,
  `laufendenummer` int(11) NOT NULL,
  `datum` date NOT NULL,
  PRIMARY KEY (`pruefID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `werkzeug_pruef`
--

LOCK TABLES `werkzeug_pruef` WRITE;
/*!40000 ALTER TABLE `werkzeug_pruef` DISABLE KEYS */;
/*!40000 ALTER TABLE `werkzeug_pruef` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `werkzeuggeometrie`
--

DROP TABLE IF EXISTS `werkzeuggeometrie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `werkzeuggeometrie` (
  `werkzeuggeoID` int(11) NOT NULL AUTO_INCREMENT,
  `werkzeugID` int(11) NOT NULL,
  `bezeichnung` varchar(255) NOT NULL,
  `wert` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`werkzeuggeoID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `werkzeuggeometrie`
--

LOCK TABLES `werkzeuggeometrie` WRITE;
/*!40000 ALTER TABLE `werkzeuggeometrie` DISABLE KEYS */;
/*!40000 ALTER TABLE `werkzeuggeometrie` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-12 16:42:07

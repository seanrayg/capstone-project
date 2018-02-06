-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dbilsognobeachresort
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.19-MariaDB

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
-- Table structure for table `tblavailbeachactivity`
--

DROP TABLE IF EXISTS `tblavailbeachactivity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblavailbeachactivity` (
  `strAvailBeachActivityID` varchar(10) NOT NULL,
  `strAvailBAReservationID` varchar(10) NOT NULL,
  `strAvailBABeachActivityID` varchar(10) NOT NULL,
  `strAvailBABoatID` varchar(10) DEFAULT NULL,
  `intAvailBAQuantity` int(11) NOT NULL,
  `intAvailBAPayment` tinyint(1) NOT NULL,
  `intBeachAFinished` tinyint(1) DEFAULT NULL,
  `tmsCreated` datetime NOT NULL,
  PRIMARY KEY (`strAvailBeachActivityID`),
  KEY `FKstrAvailBABeachActivityID_idx` (`strAvailBABeachActivityID`),
  KEY `FKstrAvailBAReservationID_idx` (`strAvailBAReservationID`),
  KEY `FKstrAvailBABoatID_idx` (`strAvailBABoatID`),
  CONSTRAINT `FKstrAvailBABeachActivityID` FOREIGN KEY (`strAvailBABeachActivityID`) REFERENCES `tblbeachactivity` (`strBeachActivityID`) ON UPDATE CASCADE,
  CONSTRAINT `FKstrAvailBABoatID` FOREIGN KEY (`strAvailBABoatID`) REFERENCES `tblboat` (`strBoatID`) ON UPDATE CASCADE,
  CONSTRAINT `FKstrAvailBAReservationID` FOREIGN KEY (`strAvailBAReservationID`) REFERENCES `tblreservationdetail` (`strReservationID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblavailbeachactivity`
--

LOCK TABLES `tblavailbeachactivity` WRITE;
/*!40000 ALTER TABLE `tblavailbeachactivity` DISABLE KEYS */;
INSERT INTO `tblavailbeachactivity` VALUES ('BAVL1','RESV12','ACTV1','BOAT4',1,0,1,'2017-10-18 15:01:55'),('BAVL2','RESV14','ACTV2','BOAT4',1,0,1,'2017-10-25 15:23:52'),('BAVL3','RESV13','ACTV1','BOAT2',1,0,NULL,'2017-10-25 15:28:51'),('BAVL4','RESV13','ACTV1','BOAT2',1,0,NULL,'2017-10-25 15:28:52'),('BAVL5','RESV12','ACTV1','BOAT3',1,0,1,'2017-10-25 15:29:22'),('BAVL6','RESV15','ACTV1','BOAT4',1,0,NULL,'2017-11-04 18:15:26');
/*!40000 ALTER TABLE `tblavailbeachactivity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblavailpackage`
--

DROP TABLE IF EXISTS `tblavailpackage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblavailpackage` (
  `strAvailPReservationID` varchar(10) NOT NULL,
  `strAvailPackageID` varchar(10) NOT NULL,
  PRIMARY KEY (`strAvailPReservationID`),
  KEY `FKstrAvailPackageID` (`strAvailPackageID`),
  CONSTRAINT `FKstrAvailPReservationID` FOREIGN KEY (`strAvailPReservationID`) REFERENCES `tblreservationdetail` (`strReservationID`) ON UPDATE CASCADE,
  CONSTRAINT `FKstrAvailPackageID` FOREIGN KEY (`strAvailPackageID`) REFERENCES `tblpackage` (`strPackageID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblavailpackage`
--

LOCK TABLES `tblavailpackage` WRITE;
/*!40000 ALTER TABLE `tblavailpackage` DISABLE KEYS */;
INSERT INTO `tblavailpackage` VALUES ('RESV5','PACK1');
/*!40000 ALTER TABLE `tblavailpackage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblbeachactivity`
--

DROP TABLE IF EXISTS `tblbeachactivity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblbeachactivity` (
  `strBeachActivityID` varchar(10) NOT NULL,
  `strBeachAName` varchar(45) NOT NULL,
  `strBeachADescription` varchar(100) NOT NULL,
  `intBeachABoat` int(11) NOT NULL,
  `strBeachAStatus` varchar(20) NOT NULL,
  `tmsCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strBeachActivityID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblbeachactivity`
--

LOCK TABLES `tblbeachactivity` WRITE;
/*!40000 ALTER TABLE `tblbeachactivity` DISABLE KEYS */;
INSERT INTO `tblbeachactivity` VALUES ('ACTV1','Fish Feeding','N/A',1,'Available','2017-08-30 23:55:52'),('ACTV2','Island Hopping','N/A',1,'Available','2017-08-13 06:48:59'),('ACTV3','Scuba Diving','N/A',1,'Available','2017-08-13 06:49:07'),('ACTV4','Zipline','N/A',0,'Available','2017-08-13 06:49:14');
/*!40000 ALTER TABLE `tblbeachactivity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblbeachactivityrate`
--

DROP TABLE IF EXISTS `tblbeachactivityrate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblbeachactivityrate` (
  `intBeachActivityRateID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `strBeachActivityID` varchar(10) NOT NULL,
  `dblBeachARate` double NOT NULL,
  `dtmBeachARateAsOf` datetime NOT NULL,
  PRIMARY KEY (`intBeachActivityRateID`),
  KEY `FKstrBeachActivityID_idx` (`strBeachActivityID`),
  CONSTRAINT `FKstrBeachActivityID` FOREIGN KEY (`strBeachActivityID`) REFERENCES `tblbeachactivity` (`strBeachActivityID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblbeachactivityrate`
--

LOCK TABLES `tblbeachactivityrate` WRITE;
/*!40000 ALTER TABLE `tblbeachactivityrate` DISABLE KEYS */;
INSERT INTO `tblbeachactivityrate` VALUES (1,'ACTV1',1200,'2017-08-13 14:48:48'),(2,'ACTV2',2000,'2017-08-13 14:48:59'),(3,'ACTV3',1500,'2017-08-13 14:49:07'),(4,'ACTV4',500,'2017-08-13 14:49:14');
/*!40000 ALTER TABLE `tblbeachactivityrate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblboat`
--

DROP TABLE IF EXISTS `tblboat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblboat` (
  `strBoatID` varchar(10) NOT NULL,
  `strBoatName` varchar(45) NOT NULL,
  `intBoatCapacity` int(11) NOT NULL,
  `strBoatStatus` varchar(20) NOT NULL,
  `strBoatDescription` varchar(100) NOT NULL,
  `tmsCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strBoatID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblboat`
--

LOCK TABLES `tblboat` WRITE;
/*!40000 ALTER TABLE `tblboat` DISABLE KEYS */;
INSERT INTO `tblboat` VALUES ('BOAT1','Dragon',10,'deleted','N/A','2017-10-16 10:11:56'),('BOAT2','Banana',12,'Available','N/A','2017-10-15 08:34:57'),('BOAT3','Am',15,'Available','N/A','2017-10-15 09:04:36'),('BOAT4','Dragon',10,'Available','N/A','2017-10-16 02:12:10');
/*!40000 ALTER TABLE `tblboat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblboatrate`
--

DROP TABLE IF EXISTS `tblboatrate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblboatrate` (
  `intBoatRateID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `strBoatID` varchar(10) NOT NULL,
  `dblBoatRate` double NOT NULL,
  `dtmBoatRateAsOf` datetime NOT NULL,
  PRIMARY KEY (`intBoatRateID`),
  KEY `strBoatID_idx` (`strBoatID`),
  CONSTRAINT `strBoatID` FOREIGN KEY (`strBoatID`) REFERENCES `tblboat` (`strBoatID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblboatrate`
--

LOCK TABLES `tblboatrate` WRITE;
/*!40000 ALTER TABLE `tblboatrate` DISABLE KEYS */;
INSERT INTO `tblboatrate` VALUES (1,'BOAT1',1000,'2017-08-13 14:47:10'),(2,'BOAT2',1200,'2017-08-13 14:47:16'),(3,'BOAT3',1500,'2017-08-13 14:47:28'),(4,'BOAT4',1000,'2017-10-16 10:12:10');
/*!40000 ALTER TABLE `tblboatrate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblboatschedule`
--

DROP TABLE IF EXISTS `tblboatschedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblboatschedule` (
  `strBoatScheduleID` varchar(10) NOT NULL,
  `strBoatSBoatID` varchar(10) NOT NULL,
  `strBoatSPurpose` varchar(45) NOT NULL,
  `dtmBoatSPickUp` datetime NOT NULL,
  `dtmBoatSDropoff` datetime NOT NULL,
  `intBoatSStatus` int(11) NOT NULL,
  `strBoatSReservationID` varchar(10) NOT NULL,
  `intBoatSPayment` tinyint(1) NOT NULL,
  PRIMARY KEY (`strBoatScheduleID`),
  KEY `FKstrBoatSBoatID_idx` (`strBoatSBoatID`),
  KEY `FKstrBoatSReservationID_idx` (`strBoatSReservationID`),
  CONSTRAINT `FKstrBoatSBoatID` FOREIGN KEY (`strBoatSBoatID`) REFERENCES `tblboat` (`strBoatID`) ON UPDATE CASCADE,
  CONSTRAINT `FKstrBoatSReservationID` FOREIGN KEY (`strBoatSReservationID`) REFERENCES `tblreservationdetail` (`strReservationID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblboatschedule`
--

LOCK TABLES `tblboatschedule` WRITE;
/*!40000 ALTER TABLE `tblboatschedule` DISABLE KEYS */;
INSERT INTO `tblboatschedule` VALUES ('BSCHD1','BOAT4','Reservation','2017-10-27 13:00:00','2017-10-27 14:00:00',0,'RESV5',0),('BSCHD2','BOAT4','Beach Activity','2017-10-18 15:01:55','2017-10-18 16:01:55',0,'RESV12',2),('BSCHD3','BOAT4','Beach Activity','2017-10-25 15:23:52','2017-10-25 17:08:52',0,'RESV14',2),('BSCHD4','BOAT2','Beach Activity','2017-10-25 15:28:51','2017-10-25 16:28:52',1,'RESV13',2),('BSCHD5','BOAT2','Beach Activity','2017-10-25 15:28:52','2017-10-25 16:28:52',1,'RESV13',2),('BSCHD6','BOAT3','Beach Activity','2017-10-25 15:29:22','2017-10-25 16:29:22',0,'RESV12',2),('BSCHD7','BOAT4','Reservation','2017-11-04 08:00:00','2017-11-04 09:00:00',1,'RESV15',0),('BSCHD8','BOAT4','Beach Activity','2017-11-04 18:15:26','2017-11-04 19:15:26',1,'RESV15',2);
/*!40000 ALTER TABLE `tblboatschedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcontact`
--

DROP TABLE IF EXISTS `tblcontact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcontact` (
  `strContactID` varchar(10) NOT NULL,
  `strContactName` varchar(100) NOT NULL,
  `strContactDetails` varchar(100) NOT NULL,
  `intContactStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`strContactID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcontact`
--

LOCK TABLES `tblcontact` WRITE;
/*!40000 ALTER TABLE `tblcontact` DISABLE KEYS */;
INSERT INTO `tblcontact` VALUES ('CNCT1','Telephone','87000',0),('CNCT2','Cellphone','911',1),('CNCT3','Telephone','87000',1);
/*!40000 ALTER TABLE `tblcontact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblcustomer`
--

DROP TABLE IF EXISTS `tblcustomer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblcustomer` (
  `strCustomerID` varchar(10) NOT NULL,
  `strCustFirstName` varchar(20) NOT NULL,
  `strCustMiddleName` varchar(20) NOT NULL,
  `strCustLastName` varchar(20) NOT NULL,
  `strCustAddress` varchar(50) NOT NULL,
  `strCustContact` varchar(20) NOT NULL,
  `strCustEmail` varchar(100) NOT NULL,
  `strCustNationality` varchar(20) NOT NULL,
  `strCustGender` char(1) NOT NULL,
  `dtmCustBirthday` date NOT NULL,
  `intCustomerConfirmed` tinyint(1) NOT NULL,
  `strConfirmationCode` varchar(45) DEFAULT NULL,
  `intCustStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`strCustomerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblcustomer`
--

LOCK TABLES `tblcustomer` WRITE;
/*!40000 ALTER TABLE `tblcustomer` DISABLE KEYS */;
INSERT INTO `tblcustomer` VALUES ('CUST1','Pamela Amor','Arcilla','Amac','Pasig City','09386583486','pamelaamac@yahoo.com','Filipino','F','1998-08-12',0,NULL,1),('CUST10','Joseph Jem','Princillo','Gallardo','Paranaque City','09385838355','josephgallardo@yahoo.com','Filipino','M','1998-01-28',0,NULL,1),('CUST11','Veronica','Pestanas','Buyco','Cainta, Rizal','09486838383','veronicabuyco@yahoo.com','Filipino','F','1998-09-11',0,NULL,1),('CUST12','John Rostom','Moratin','Vasol','Paranaque City','09385683848','johnrostom@yahoo.com','Filipino','M','1998-02-12',0,NULL,1),('CUST13','Aireen','Geronimo','Doliente','Quezon City','09285838383','aireendoliente@yahoo.com','Filipino','F','1997-04-15',0,NULL,1),('CUST14','Joshua','Wo','Silao','Manila','09247426264','joshua@yahoo.com','Filipino','M','1998-10-04',0,NULL,1),('CUST15','Julian','Tomas','Jaramilla','GMA, Cavite','092222328787','15.seangarcia@gmail.com','Filipino','M','1998-03-09',0,NULL,1),('CUST2','Mark Steven','Lorania','Banas','Pasig City','09385847674','Marksteven@yahoo.com','Filipino','M','1998-09-23',0,NULL,1),('CUST3','Ethelyn Anne','Sumayod','Consista','Mandaluyong City','09388561242','ethelynann@yahoo.com','Filipino','F','1998-08-12',0,NULL,1),('CUST4','Maria Antoinette','Portillo','Felix','Pasay City','09378584833','AntoinetteFelix@yahoo.com','Filipino','F','1997-05-12',0,NULL,1),('CUST5','Richelle Ann','Salvacion','Lopez','Mandaluyong City','09488583747','richelleann@yahoo.com','Filipino','F','1997-06-28',0,NULL,1),('CUST6','Louie','Rivera','Melo','Kawit, Cavite','09285386584','louiemelo@yahoo.com','Filipino','M','1998-02-17',0,NULL,1),('CUST7','Leny Marie','Abraham','Nadong','Manila City','09285835346','lenymarie@yahoo.com','Filipino','F','1998-08-19',0,NULL,1),('CUST8','Shiela Mae','Corochea','Pornea','Malabon City','09385738823','shielamae@yahoo.com','Filipino','F','1997-08-17',0,NULL,1),('CUST9','Runnie Jay','Jimenez','Olanda','Manila City','09385838835','RunnieJay@yahoo.com','Filipino','M','1997-10-07',0,NULL,1);
/*!40000 ALTER TABLE `tblcustomer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblfee`
--

DROP TABLE IF EXISTS `tblfee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblfee` (
  `strFeeID` varchar(10) NOT NULL,
  `strFeeName` varchar(45) NOT NULL,
  `strFeeStatus` varchar(20) NOT NULL,
  `strFeeDescription` varchar(100) NOT NULL,
  `tmsCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strFeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfee`
--

LOCK TABLES `tblfee` WRITE;
/*!40000 ALTER TABLE `tblfee` DISABLE KEYS */;
INSERT INTO `tblfee` VALUES ('FEE1','Entrance Fee','Active','N/A','2017-08-14 06:22:57'),('FEE2','Kitchen Fee','Active','N/A','2017-08-30 23:56:13'),('FEE3','Accomodation Fee','Active','N/A','2017-08-13 06:50:02'),('FEE4','Excess Fee','deleted','N/A','2017-08-30 23:30:21');
/*!40000 ALTER TABLE `tblfee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblfeeamount`
--

DROP TABLE IF EXISTS `tblfeeamount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblfeeamount` (
  `intFeeAmountID` int(11) NOT NULL AUTO_INCREMENT,
  `strFeeID` varchar(10) NOT NULL,
  `dblFeeAmount` double NOT NULL,
  `dtmFeeAmountAsOf` datetime NOT NULL,
  PRIMARY KEY (`intFeeAmountID`),
  KEY `fkstrFeeID_idx` (`strFeeID`),
  CONSTRAINT `fkstrFeeID` FOREIGN KEY (`strFeeID`) REFERENCES `tblfee` (`strFeeID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblfeeamount`
--

LOCK TABLES `tblfeeamount` WRITE;
/*!40000 ALTER TABLE `tblfeeamount` DISABLE KEYS */;
INSERT INTO `tblfeeamount` VALUES (1,'FEE1',100,'2017-08-13 14:49:25'),(2,'FEE2',200,'2017-08-13 14:49:55'),(3,'FEE3',150,'2017-08-13 14:50:02'),(4,'FEE4',100,'2017-08-13 14:55:17'),(5,'FEE2',250,'2017-08-30 23:56:08');
/*!40000 ALTER TABLE `tblfeeamount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblinoperationaldate`
--

DROP TABLE IF EXISTS `tblinoperationaldate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblinoperationaldate` (
  `strDateID` varchar(10) NOT NULL,
  `strDateTitle` varchar(45) NOT NULL,
  `dteStartDate` date NOT NULL,
  `dteEndDate` date NOT NULL,
  `intDateStatus` tinyint(1) NOT NULL,
  `strDateDescription` tinytext NOT NULL,
  `tmsCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strDateID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblinoperationaldate`
--

LOCK TABLES `tblinoperationaldate` WRITE;
/*!40000 ALTER TABLE `tblinoperationaldate` DISABLE KEYS */;
INSERT INTO `tblinoperationaldate` VALUES ('DATE1','Anniversary Celebration','2017-09-01','2017-09-05',0,'N/A','2017-08-18 06:13:35'),('DATE2','Team Building','2017-09-06','2017-09-08',0,'N/A','2017-08-14 15:32:44'),('DATE3','Team Building','2017-08-30','2017-08-31',0,'N/A','2017-08-18 06:13:37'),('DATE4','asd','2017-10-11','2017-10-12',0,'N/A','2017-10-17 12:32:53'),('DATE5','Electric connection maintenance','2018-01-04','2018-01-05',1,'N/A','2017-10-18 01:30:06');
/*!40000 ALTER TABLE `tblinoperationaldate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblitem`
--

DROP TABLE IF EXISTS `tblitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblitem` (
  `strItemID` varchar(10) NOT NULL,
  `strItemName` varchar(45) NOT NULL,
  `strItemDescription` varchar(100) NOT NULL,
  `intItemQuantity` int(11) NOT NULL,
  `intItemDeleted` tinyint(1) NOT NULL,
  `tmsCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strItemID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblitem`
--

LOCK TABLES `tblitem` WRITE;
/*!40000 ALTER TABLE `tblitem` DISABLE KEYS */;
INSERT INTO `tblitem` VALUES ('ITEM1','Goggles','N/A',11,1,'2017-10-15 17:28:21'),('ITEM2','Grill','N/A',8,1,'2017-10-15 17:31:36'),('ITEM3','Mattress','N/A',5,1,'2017-08-13 06:48:34');
/*!40000 ALTER TABLE `tblitem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblitemrate`
--

DROP TABLE IF EXISTS `tblitemrate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblitemrate` (
  `intItemRateID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `strItemID` varchar(10) NOT NULL,
  `dblItemRate` double NOT NULL,
  `dtmItemRateAsOf` datetime NOT NULL,
  PRIMARY KEY (`intItemRateID`),
  KEY `FKstrItemID_idx` (`strItemID`),
  CONSTRAINT `FKstrItemID` FOREIGN KEY (`strItemID`) REFERENCES `tblitem` (`strItemID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblitemrate`
--

LOCK TABLES `tblitemrate` WRITE;
/*!40000 ALTER TABLE `tblitemrate` DISABLE KEYS */;
INSERT INTO `tblitemrate` VALUES (1,'ITEM1',50,'2017-08-13 14:47:43'),(2,'ITEM2',20,'2017-08-13 14:47:52'),(3,'ITEM3',100,'2017-08-13 14:48:34');
/*!40000 ALTER TABLE `tblitemrate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpackage`
--

DROP TABLE IF EXISTS `tblpackage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpackage` (
  `strPackageID` varchar(10) NOT NULL,
  `strPackageName` varchar(20) NOT NULL,
  `intPackagePax` int(11) NOT NULL,
  `intPackageDuration` tinyint(3) DEFAULT NULL,
  `intBoatFee` tinyint(1) NOT NULL,
  `strPackageDescription` varchar(100) NOT NULL,
  `strPackageStatus` varchar(20) NOT NULL,
  `tmsCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strPackageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpackage`
--

LOCK TABLES `tblpackage` WRITE;
/*!40000 ALTER TABLE `tblpackage` DISABLE KEYS */;
INSERT INTO `tblpackage` VALUES ('PACK1','Barkada Package',8,3,1,'N/A','Available','2017-08-13 19:30:11'),('PACK2','Family Package',8,2,1,'N/A','Available','2017-08-30 15:57:23'),('PACK3','Family Package 2',8,2,1,'N/A','Available','2017-09-18 05:30:31');
/*!40000 ALTER TABLE `tblpackage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpackageactivity`
--

DROP TABLE IF EXISTS `tblpackageactivity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpackageactivity` (
  `strPackageAPackageID` varchar(10) NOT NULL,
  `strPackageABeachActivityID` varchar(10) NOT NULL,
  `intPackageAQuantity` tinyint(1) NOT NULL,
  PRIMARY KEY (`strPackageAPackageID`,`strPackageABeachActivityID`),
  KEY `FKtblPackageABeachActivityID_idx` (`strPackageABeachActivityID`),
  CONSTRAINT `FKtblPackageABeachActivityID` FOREIGN KEY (`strPackageABeachActivityID`) REFERENCES `tblbeachactivity` (`strBeachActivityID`) ON UPDATE CASCADE,
  CONSTRAINT `FKtblPackageAPackageID` FOREIGN KEY (`strPackageAPackageID`) REFERENCES `tblpackage` (`strPackageID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpackageactivity`
--

LOCK TABLES `tblpackageactivity` WRITE;
/*!40000 ALTER TABLE `tblpackageactivity` DISABLE KEYS */;
INSERT INTO `tblpackageactivity` VALUES ('PACK1','ACTV1',1),('PACK1','ACTV3',1),('PACK2','ACTV4',3),('PACK3','ACTV1',1),('PACK3','ACTV4',3);
/*!40000 ALTER TABLE `tblpackageactivity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpackagefee`
--

DROP TABLE IF EXISTS `tblpackagefee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpackagefee` (
  `strPackageFPackageID` varchar(10) NOT NULL,
  `strPackageFFeeID` varchar(10) NOT NULL,
  PRIMARY KEY (`strPackageFPackageID`,`strPackageFFeeID`),
  KEY `FKstrPackageFFeeID_idx` (`strPackageFFeeID`),
  CONSTRAINT `FKstrPackageFFeeID` FOREIGN KEY (`strPackageFFeeID`) REFERENCES `tblfee` (`strFeeID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKstrPackageFPackageID` FOREIGN KEY (`strPackageFPackageID`) REFERENCES `tblpackage` (`strPackageID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpackagefee`
--

LOCK TABLES `tblpackagefee` WRITE;
/*!40000 ALTER TABLE `tblpackagefee` DISABLE KEYS */;
INSERT INTO `tblpackagefee` VALUES ('PACK1','FEE1'),('PACK1','FEE2');
/*!40000 ALTER TABLE `tblpackagefee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpackageitem`
--

DROP TABLE IF EXISTS `tblpackageitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpackageitem` (
  `strPackageIPackageID` varchar(10) NOT NULL,
  `strPackageIItemID` varchar(10) NOT NULL,
  `intPackageIQuantity` tinyint(1) NOT NULL,
  `flPackageIDuration` float NOT NULL,
  PRIMARY KEY (`strPackageIPackageID`,`strPackageIItemID`),
  KEY `FKstrPackageIItemID_idx` (`strPackageIItemID`),
  CONSTRAINT `FKstrPackageIItemID` FOREIGN KEY (`strPackageIItemID`) REFERENCES `tblitem` (`strItemID`) ON UPDATE CASCADE,
  CONSTRAINT `FKstrPackageIPackageID` FOREIGN KEY (`strPackageIPackageID`) REFERENCES `tblpackage` (`strPackageID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpackageitem`
--

LOCK TABLES `tblpackageitem` WRITE;
/*!40000 ALTER TABLE `tblpackageitem` DISABLE KEYS */;
INSERT INTO `tblpackageitem` VALUES ('PACK1','ITEM1',1,1),('PACK1','ITEM2',2,2),('PACK2','ITEM1',1,2),('PACK2','ITEM2',1,2),('PACK3','ITEM1',1,2),('PACK3','ITEM2',2,1);
/*!40000 ALTER TABLE `tblpackageitem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpackageprice`
--

DROP TABLE IF EXISTS `tblpackageprice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpackageprice` (
  `intPackagePriceID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `strPackageID` varchar(10) NOT NULL,
  `dblPackagePrice` double NOT NULL,
  `dtmPackagePriceAsOf` datetime NOT NULL,
  PRIMARY KEY (`intPackagePriceID`),
  KEY `FKstrPackageID_idx` (`strPackageID`),
  CONSTRAINT `FKstrPackageID` FOREIGN KEY (`strPackageID`) REFERENCES `tblpackage` (`strPackageID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpackageprice`
--

LOCK TABLES `tblpackageprice` WRITE;
/*!40000 ALTER TABLE `tblpackageprice` DISABLE KEYS */;
INSERT INTO `tblpackageprice` VALUES (1,'PACK1',16000,'2017-08-14 03:30:11'),(2,'PACK2',12000,'2017-08-30 23:57:23'),(3,'PACK3',12000,'2017-09-18 13:30:31');
/*!40000 ALTER TABLE `tblpackageprice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpackageroom`
--

DROP TABLE IF EXISTS `tblpackageroom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpackageroom` (
  `strPackageRPackageID` varchar(10) NOT NULL,
  `strPackageRRoomTypeID` varchar(10) NOT NULL,
  `intPackageRQuantity` tinyint(1) NOT NULL,
  PRIMARY KEY (`strPackageRPackageID`,`strPackageRRoomTypeID`),
  KEY `FKstrPackageRRoomTypeID_idx` (`strPackageRRoomTypeID`),
  CONSTRAINT `FKstrPackageRRoomTypeID` FOREIGN KEY (`strPackageRRoomTypeID`) REFERENCES `tblroomtype` (`strRoomTypeID`) ON UPDATE CASCADE,
  CONSTRAINT `FKtblPackageRPackageID` FOREIGN KEY (`strPackageRPackageID`) REFERENCES `tblpackage` (`strPackageID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpackageroom`
--

LOCK TABLES `tblpackageroom` WRITE;
/*!40000 ALTER TABLE `tblpackageroom` DISABLE KEYS */;
INSERT INTO `tblpackageroom` VALUES ('PACK1','ACMT1',1),('PACK1','ACMT2',2),('PACK2','ACMT3',1),('PACK3','ACMT1',4);
/*!40000 ALTER TABLE `tblpackageroom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpayment`
--

DROP TABLE IF EXISTS `tblpayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpayment` (
  `strPaymentID` varchar(10) NOT NULL,
  `strPayReservationID` varchar(10) NOT NULL,
  `dblPayAmount` double NOT NULL,
  `strPayTypeID` varchar(10) NOT NULL,
  `dtePayDate` date NOT NULL,
  `strPaymentRemarks` text,
  `tmsCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strPaymentID`),
  KEY `FKstrPayReservationID_idx` (`strPayReservationID`),
  KEY `FKstrPayTypeID_idx` (`strPayTypeID`),
  CONSTRAINT `FKstrPayReservationID` FOREIGN KEY (`strPayReservationID`) REFERENCES `tblreservationdetail` (`strReservationID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKstrPayTypeID` FOREIGN KEY (`strPayTypeID`) REFERENCES `tblpaymenttype` (`strPaymentTypeID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpayment`
--

LOCK TABLES `tblpayment` WRITE;
/*!40000 ALTER TABLE `tblpayment` DISABLE KEYS */;
INSERT INTO `tblpayment` VALUES ('PYMT1','RESV1',3100,'1','2017-10-18',NULL,'2017-10-18 01:31:07'),('PYMT10','RESV7',820,'2','2017-10-18',NULL,'2017-10-18 01:41:21'),('PYMT11','RESV8',640,'2','2017-10-18',NULL,'2017-10-18 01:41:46'),('PYMT12','RESV9',1600,'1','2017-10-18',NULL,'2017-10-18 01:45:40'),('PYMT13','RESV9',320,'2','2017-10-18',NULL,'2017-10-18 01:46:21'),('PYMT14','RESV10',2200,'1','2017-10-18',NULL,'2017-10-18 01:48:44'),('PYMT15','RESV10',440,'2','2017-10-18',NULL,'2017-10-18 01:50:09'),('PYMT16','RESV11',6100,'1','2017-10-18',NULL,'2017-10-18 01:51:41'),('PYMT17','RESV11',150,'11','2017-10-18','{\"RentedItemID\":\"RENT1\"}','2017-10-18 01:52:25'),('PYMT18','RESV12',2200,'1','2017-10-18',NULL,'2017-10-18 01:53:23'),('PYMT19','RESV13',4200,'1','2017-10-18',NULL,'2017-10-18 01:55:37'),('PYMT2','RESV2',1700,'1','2017-10-18',NULL,'2017-10-18 01:32:02'),('PYMT20','RESV13',60,'11','2017-10-18','{\"RentedItemID\":\"RENT2\"}','2017-10-18 01:56:21'),('PYMT21','RESV13',100,'11','2017-10-18','{\"RentedItemID\":\"RENT3\"}','2017-10-18 06:55:39'),('PYMT22','RESV11',100,'6','2017-10-18','{\"QuantityReturned\":\"1\",\"TimePenalty\":\"100\",\"Description\":\"Excess time is:2 hour(s) 3 minutes\",\"ItemID\":\"ITEM1\",\"ItemName\":\"Goggles\",\"RentedItemID\":\"RENT1\"}','2017-10-18 06:56:43'),('PYMT23','RESV13',100,'7','2017-10-18','{\"Description\":\"Number of broken\\/lost item is 1\",\"ItemID\":\"ITEM1\",\"ItemName\":\"Goggles\",\"RentedItemID\":\"RENT3\"}','2017-10-18 06:59:04'),('PYMT24','RESV13',60,'10','2017-10-18','{\"ExtendQuantity\":\"1\",\"ExtendTime\":\"3\",\"ItemID\":\"ITEM2\",\"ItemName\":\"Grill\",\"RentedItemID\":\"RENT2\"}','2017-10-18 07:00:27'),('PYMT25','RESV12',1200,'16','2017-10-18','{\"AvailActivityID\":\"BAVL1\"}','2017-10-18 07:01:55'),('PYMT26','RESV14',2200,'1','2017-10-18',NULL,'2017-10-18 07:10:32'),('PYMT27','RESV14',500,'2','2017-10-18',NULL,'2017-10-18 07:12:47'),('PYMT28','RESV14',4800,'11','2017-10-25','{\"RentedItemID\":\"RENT4\"}','2017-10-25 07:19:03'),('PYMT29','RESV14',5000,'22','2017-10-25','{\"DateUpgraded\":\"2017\\/10\\/25 03:20:32\",\"ArrivalDate\":{\"date\":\"2017-10-25 07:20:32.000000\",\"timezone_type\":3,\"timezone\":\"UTC\"},\"DepartureDate\":{\"date\":\"2017-10-27 13:00:00.000000\",\"timezone_type\":3,\"timezone\":\"UTC\"},\"OriginalRoom\":\"Florence 2\",\"UpgradeRoom\":\"Venice 1\",\"NewRoomID\":\"RMCT10\"}','2017-10-25 07:20:32'),('PYMT3','RESV3',3600,'1','2017-10-18',NULL,'2017-10-18 01:33:03'),('PYMT30','RESV14',2000,'16','2017-10-25','{\"AvailActivityID\":\"BAVL2\"}','2017-10-25 07:23:52'),('PYMT31','RESV13',1200,'16','2017-10-25','{\"AvailActivityID\":\"BAVL3\"}','2017-10-25 07:28:52'),('PYMT32','RESV13',1200,'16','2017-10-25','{\"AvailActivityID\":\"BAVL4\"}','2017-10-25 07:28:53'),('PYMT33','RESV12',1200,'16','2017-10-25','{\"AvailActivityID\":\"BAVL5\"}','2017-10-25 07:29:22'),('PYMT34','RESV14',5000,'29','2017-10-25','upgrade room chu chu','2017-10-25 07:42:12'),('PYMT35','RESV14',4800,'29','2017-10-25','matress','2017-10-25 07:42:48'),('PYMT36','RESV15',9400,'1','2017-10-26',NULL,'2017-10-26 10:00:33'),('PYMT37','RESV15',1880,'2','2017-10-26',NULL,'2017-10-26 10:06:12'),('PYMT38','RESV15',200,'11','2017-11-04','{\"RentedItemID\":\"RENT5\"}','2017-11-04 10:13:08'),('PYMT39','RESV15',1200,'16','2017-11-04','{\"AvailActivityID\":\"BAVL6\"}','2017-11-04 10:15:26'),('PYMT4','RESV4',1600,'1','2017-10-18',NULL,'2017-10-18 01:34:31'),('PYMT40','RESV15',8920,'28','2017-11-04',NULL,'2017-11-04 10:18:38'),('PYMT5','RESV5',16000,'1','2017-10-18',NULL,'2017-10-18 01:36:32'),('PYMT6','RESV6',3200,'1','2017-10-18',NULL,'2017-10-18 01:38:24'),('PYMT7','RESV7',4100,'1','2017-10-18',NULL,'2017-10-18 01:39:43'),('PYMT8','RESV8',3200,'1','2017-10-18',NULL,'2017-10-18 01:40:57'),('PYMT9','RESV6',640,'2','2017-10-18',NULL,'2017-10-18 01:41:10');
/*!40000 ALTER TABLE `tblpayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblpaymenttype`
--

DROP TABLE IF EXISTS `tblpaymenttype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblpaymenttype` (
  `strPaymentTypeID` varchar(10) NOT NULL,
  `strPaymentType` varchar(50) NOT NULL,
  PRIMARY KEY (`strPaymentTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblpaymenttype`
--

LOCK TABLES `tblpaymenttype` WRITE;
/*!40000 ALTER TABLE `tblpaymenttype` DISABLE KEYS */;
INSERT INTO `tblpaymenttype` VALUES ('1','Initial Bill'),('10','Extend Item Bill'),('11','Item Rental Bill'),('12','Item Rental Payment'),('13','Time Penalty Payment'),('14','Extend Item Payment'),('15','Extend Item Payment'),('16','Beach Activity Bill'),('17','Beach Activity Payment'),('18','Fee Bill'),('19','Fee Payment'),('2','Down Payment'),('20','Additional Room Bill'),('21','Additional Room Payment'),('22','Upgrade Room Bill'),('23','Upgrade Room Payment'),('24','Extend Stay Bill'),('25','Extend Stay Payment'),('26','Item Rental Package Reference'),('27','Activity Package Reference'),('28','Check out Payment'),('29','Bill Deductions'),('3','Initial Payment'),('4','Additional Bill'),('5','Additional Payment'),('6','Time Penalty Bill'),('7','Broken/Lost Penalty Bill'),('8','Boat Reservation Bill'),('9','Boat Reservation Payment');
/*!40000 ALTER TABLE `tblpaymenttype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblrenteditem`
--

DROP TABLE IF EXISTS `tblrenteditem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblrenteditem` (
  `strRentedItemID` varchar(10) NOT NULL,
  `strRentedIReservationID` varchar(10) NOT NULL,
  `strRentedIItemID` varchar(10) NOT NULL,
  `intRentedIReturned` tinyint(1) NOT NULL,
  `intRentedIQuantity` int(8) NOT NULL,
  `intRentedIDuration` int(8) NOT NULL,
  `intRentedIBroken` tinyint(1) DEFAULT NULL,
  `intRentedIBrokenQuantity` int(8) NOT NULL,
  `intRentedIPayment` tinyint(1) NOT NULL,
  `tmsCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strRentedItemID`),
  KEY `FKstrRentedIItemID_idx` (`strRentedIItemID`),
  KEY `FKstrRentedIReservationID_idx` (`strRentedIReservationID`),
  CONSTRAINT `FKstrRentedIItemID` FOREIGN KEY (`strRentedIItemID`) REFERENCES `tblitem` (`strItemID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKstrRentedIReservationID` FOREIGN KEY (`strRentedIReservationID`) REFERENCES `tblreservationdetail` (`strReservationID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblrenteditem`
--

LOCK TABLES `tblrenteditem` WRITE;
/*!40000 ALTER TABLE `tblrenteditem` DISABLE KEYS */;
INSERT INTO `tblrenteditem` VALUES ('RENT1','RESV11','ITEM1',1,1,3,0,0,0,'2017-10-18 06:56:43'),('RENT2','RESV13','ITEM2',0,1,6,0,0,0,'2017-10-18 01:56:21'),('RENT3','RESV13','ITEM1',1,1,2,1,1,0,'2017-10-18 06:59:04'),('RENT4','RESV14','ITEM3',0,2,24,0,0,0,'2017-10-25 07:19:03'),('RENT5','RESV15','ITEM3',0,1,2,0,0,0,'2017-11-04 10:13:08');
/*!40000 ALTER TABLE `tblrenteditem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblreservationboat`
--

DROP TABLE IF EXISTS `tblreservationboat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblreservationboat` (
  `strResBReservationID` varchar(10) NOT NULL,
  `strResBBoatID` varchar(10) NOT NULL,
  `intResBPayment` tinyint(1) NOT NULL,
  PRIMARY KEY (`strResBReservationID`,`strResBBoatID`),
  KEY `FKstrResBBoatID_idx` (`strResBBoatID`),
  CONSTRAINT `FKstrResBBoatID` FOREIGN KEY (`strResBBoatID`) REFERENCES `tblboat` (`strBoatID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FKstrResBReservationID` FOREIGN KEY (`strResBReservationID`) REFERENCES `tblreservationdetail` (`strReservationID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblreservationboat`
--

LOCK TABLES `tblreservationboat` WRITE;
/*!40000 ALTER TABLE `tblreservationboat` DISABLE KEYS */;
INSERT INTO `tblreservationboat` VALUES ('RESV15','BOAT4',0),('RESV5','BOAT4',0);
/*!40000 ALTER TABLE `tblreservationboat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblreservationdetail`
--

DROP TABLE IF EXISTS `tblreservationdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblreservationdetail` (
  `strReservationID` varchar(10) NOT NULL,
  `strReservationCode` varchar(6) DEFAULT NULL,
  `intWalkIn` tinyint(1) NOT NULL,
  `strResDCustomerID` varchar(10) NOT NULL,
  `dtmResDArrival` datetime NOT NULL,
  `dtmResDDeparture` datetime NOT NULL,
  `intResDNoOfAdults` int(11) NOT NULL,
  `intResDNoOfKids` int(11) NOT NULL,
  `strResDRemarks` varchar(100) NOT NULL,
  `intResDStatus` tinyint(1) NOT NULL,
  `dteResDBooking` datetime NOT NULL,
  `strResDDepositSlip` longtext,
  PRIMARY KEY (`strReservationID`),
  KEY `FKstrResDCustomerID_idx` (`strResDCustomerID`),
  CONSTRAINT `FKstrResDCustomerID` FOREIGN KEY (`strResDCustomerID`) REFERENCES `tblcustomer` (`strCustomerID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblreservationdetail`
--

LOCK TABLES `tblreservationdetail` WRITE;
/*!40000 ALTER TABLE `tblreservationdetail` DISABLE KEYS */;
INSERT INTO `tblreservationdetail` VALUES ('RESV1','I8RK6K',0,'CUST1','2017-10-25 13:00:00','2017-10-27 13:00:00',1,2,'N/A',3,'2017-10-15 00:00:00',NULL),('RESV10','XFQ8GA',0,'CUST10','2017-10-18 14:00:00','2017-10-20 14:00:00',2,0,'N/A',2,'2017-10-18 00:00:00',NULL),('RESV11',NULL,0,'CUST11','2017-10-18 09:51:41','2017-10-22 09:51:41',1,2,'N/A',4,'2017-10-18 00:00:00',NULL),('RESV12',NULL,0,'CUST12','2017-10-18 09:53:23','2017-10-20 09:53:23',2,2,'N/A',4,'2017-10-18 00:00:00',NULL),('RESV13',NULL,0,'CUST13','2017-10-18 09:55:37','2017-10-20 09:55:37',2,2,'N/A',4,'2017-10-18 00:00:00',NULL),('RESV14','W00Q2F',0,'CUST14','2017-10-25 13:00:00','2017-10-27 13:00:00',2,2,'W/ senior',4,'2017-10-18 00:00:00',NULL),('RESV15','U7ADVM',0,'CUST15','2018-11-04 08:00:00','2018-11-04 08:00:00',4,2,'N/A',5,'2017-10-26 00:00:00','/DepositSlips/WIN_20160628_13_43_33_Pro.jpg'),('RESV2','8NF0OD',0,'CUST2','2017-10-28 13:00:00','2017-10-29 13:00:00',2,2,'N/A',3,'2017-10-15 00:00:00',NULL),('RESV3','CSZ9Z1',0,'CUST3','2017-10-25 13:00:00','2017-10-27 13:00:00',2,3,'N/A',3,'2017-10-13 00:00:00',NULL),('RESV4','LRH06G',0,'CUST4','2017-10-30 14:00:00','2017-10-31 14:00:00',1,2,'N/A',3,'2017-10-18 00:00:00',NULL),('RESV5','8VWM9R',0,'CUST5','2017-10-27 13:00:00','2017-10-30 13:00:00',5,3,'N/A',3,'2017-10-18 00:00:00',NULL),('RESV6','JKDYU3',0,'CUST6','2017-11-03 13:00:00','2017-11-05 13:00:00',2,2,'N/A',2,'2017-10-18 00:00:00',NULL),('RESV7','2JD83U',0,'CUST7','2017-11-07 13:00:00','2017-11-09 13:00:00',1,2,'N/A',2,'2017-10-18 00:00:00',NULL),('RESV8','DUWK37',0,'CUST8','2017-11-10 13:00:00','2017-11-12 13:00:00',2,2,'N/A',2,'2017-10-18 00:00:00',NULL),('RESV9','6T53SE',0,'CUST9','2017-10-18 08:00:00','2017-10-19 08:00:00',1,2,'N/A',2,'2017-10-18 00:00:00',NULL);
/*!40000 ALTER TABLE `tblreservationdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblreservationfee`
--

DROP TABLE IF EXISTS `tblreservationfee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblreservationfee` (
  `strResFReservationID` varchar(10) NOT NULL,
  `strResFFeeID` varchar(10) NOT NULL,
  `intResFPayment` tinyint(1) NOT NULL,
  `intResFQuantity` int(11) NOT NULL,
  PRIMARY KEY (`strResFReservationID`,`strResFFeeID`,`intResFPayment`),
  KEY `fkResFFeeID_idx` (`strResFFeeID`),
  CONSTRAINT `fkResFFeeID` FOREIGN KEY (`strResFFeeID`) REFERENCES `tblfee` (`strFeeID`) ON UPDATE CASCADE,
  CONSTRAINT `fkResFReservationID` FOREIGN KEY (`strResFReservationID`) REFERENCES `tblreservationdetail` (`strReservationID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblreservationfee`
--

LOCK TABLES `tblreservationfee` WRITE;
/*!40000 ALTER TABLE `tblreservationfee` DISABLE KEYS */;
INSERT INTO `tblreservationfee` VALUES ('RESV1','FEE1',0,1),('RESV10','FEE1',0,2),('RESV11','FEE1',0,1),('RESV12','FEE1',0,2),('RESV13','FEE1',0,2),('RESV14','FEE1',0,2),('RESV15','FEE1',0,4),('RESV2','FEE1',0,2),('RESV3','FEE1',0,2),('RESV4','FEE1',0,1),('RESV5','FEE1',1,5),('RESV6','FEE1',0,2),('RESV7','FEE1',0,1),('RESV8','FEE1',0,2),('RESV9','FEE1',0,1);
/*!40000 ALTER TABLE `tblreservationfee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblreservationroom`
--

DROP TABLE IF EXISTS `tblreservationroom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblreservationroom` (
  `strResRReservationID` varchar(10) NOT NULL,
  `strResRRoomID` varchar(10) NOT NULL,
  `intResRPayment` tinyint(1) NOT NULL,
  PRIMARY KEY (`strResRReservationID`,`strResRRoomID`),
  KEY `FKstrResRRoomID_idx` (`strResRRoomID`),
  CONSTRAINT `FKstrResRReservationID` FOREIGN KEY (`strResRReservationID`) REFERENCES `tblreservationdetail` (`strReservationID`) ON UPDATE CASCADE,
  CONSTRAINT `FKstrResRRoomID` FOREIGN KEY (`strResRRoomID`) REFERENCES `tblroom` (`strRoomID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblreservationroom`
--

LOCK TABLES `tblreservationroom` WRITE;
/*!40000 ALTER TABLE `tblreservationroom` DISABLE KEYS */;
INSERT INTO `tblreservationroom` VALUES ('RESV1','RMCT8',0),('RESV10','RMCT1',0),('RESV11','RMCT9',0),('RESV12','RMCT15',0),('RESV13','RMCT16',0),('RESV14','RMCT10',6),('RESV15','RMCT15',0),('RESV2','RMCT8',0),('RESV3','RMCT5',0),('RESV4','RMCT8',0),('RESV5','RMCT1',1),('RESV5','RMCT6',1),('RESV5','RMCT7',1),('RESV6','RMCT8',0),('RESV7','RMCT1',0),('RESV7','RMCT2',0),('RESV8','RMCT8',0),('RESV9','RMCT8',0);
/*!40000 ALTER TABLE `tblreservationroom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblroom`
--

DROP TABLE IF EXISTS `tblroom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblroom` (
  `strRoomID` varchar(10) NOT NULL,
  `strRoomTypeID` varchar(10) NOT NULL,
  `strRoomName` varchar(45) NOT NULL,
  `strRoomStatus` varchar(20) NOT NULL,
  `tmsCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strRoomID`),
  KEY `FKstrRoomTypeID_idx` (`strRoomTypeID`),
  CONSTRAINT `FKstrRoomTypeID` FOREIGN KEY (`strRoomTypeID`) REFERENCES `tblroomtype` (`strRoomTypeID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblroom`
--

LOCK TABLES `tblroom` WRITE;
/*!40000 ALTER TABLE `tblroom` DISABLE KEYS */;
INSERT INTO `tblroom` VALUES ('RMCT1','ACMT1','Florence 1','Available','2017-08-13 06:44:30'),('RMCT10','ACMT3','Venice 1','Available','2017-08-13 06:45:55'),('RMCT11','ACMT5','Kubo 1','Available','2017-08-13 06:46:05'),('RMCT12','ACMT5','Kubo 2','Available','2017-08-13 06:46:14'),('RMCT13','ACMT6','Nipa 1','Available','2017-08-13 06:46:20'),('RMCT14','ACMT6','Nipa 2','Available','2017-08-30 23:54:55'),('RMCT15','ACMT7','Rome 1','Available','2017-10-16 01:42:41'),('RMCT16','ACMT7','Rome 2','Available','2017-10-16 09:43:01'),('RMCT17','ACMT7','Rome 3','Available','2017-10-16 01:43:08'),('RMCT18','ACMT7','Rome 4','Available','2017-10-16 01:43:14'),('RMCT19','ACMT7','Rome 5','Available','2017-10-16 01:43:22'),('RMCT2','ACMT1','Florence 2','Available','2017-08-13 06:44:41'),('RMCT3','ACMT1','Florence 3','Available','2017-08-13 06:44:47'),('RMCT4','ACMT1','Florence 4','Available','2017-08-13 06:44:51'),('RMCT5','ACMT2','Milan 1','Available','2017-08-13 06:44:56'),('RMCT6','ACMT2','Milan 2','Available','2017-08-30 23:54:45'),('RMCT7','ACMT2','Milan 3','Available','2017-08-13 06:45:09'),('RMCT8','ACMT4','Naples 1','Available','2017-08-13 06:45:36'),('RMCT9','ACMT4','Naples 2','Available','2017-08-13 06:45:43');
/*!40000 ALTER TABLE `tblroom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblroompicture`
--

DROP TABLE IF EXISTS `tblroompicture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblroompicture` (
  `strRoomPictureID` varchar(10) NOT NULL,
  `strRoomPRoomTID` varchar(10) NOT NULL,
  `blobRoomPPicture` text NOT NULL,
  PRIMARY KEY (`strRoomPictureID`),
  KEY `FKstrRoomPRoomTID_idx` (`strRoomPRoomTID`),
  CONSTRAINT `FKstrRoomPRoomTID` FOREIGN KEY (`strRoomPRoomTID`) REFERENCES `tblroomtype` (`strRoomTypeID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblroompicture`
--

LOCK TABLES `tblroompicture` WRITE;
/*!40000 ALTER TABLE `tblroompicture` DISABLE KEYS */;
INSERT INTO `tblroompicture` VALUES ('AIMG10','ACMT6','/Accommodation/Cottage2.jpg'),('AIMG4','ACMT1','/Accommodation/Room1.jpg'),('AIMG5','ACMT2','/Accommodation/Room2.jpg'),('AIMG6','ACMT3','/Accommodation/Room3.jpg'),('AIMG7','ACMT4','/Accommodation/Room4.jpg'),('AIMG8','ACMT7','/Accommodation/Room5.jpg'),('AIMG9','ACMT5','/Accommodation/Cottage1.jpg');
/*!40000 ALTER TABLE `tblroompicture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblroomrate`
--

DROP TABLE IF EXISTS `tblroomrate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblroomrate` (
  `intRoomRateID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `strRoomTypeID` varchar(10) NOT NULL,
  `dblRoomRate` double NOT NULL,
  `dtmRoomRateAsOf` datetime NOT NULL,
  PRIMARY KEY (`intRoomRateID`),
  KEY `FKstrRoomTypeID_idx` (`strRoomTypeID`),
  CONSTRAINT `rateFKstrRoomTypeID` FOREIGN KEY (`strRoomTypeID`) REFERENCES `tblroomtype` (`strRoomTypeID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblroomrate`
--

LOCK TABLES `tblroomrate` WRITE;
/*!40000 ALTER TABLE `tblroomrate` DISABLE KEYS */;
INSERT INTO `tblroomrate` VALUES (1,'ACMT1',1000,'2017-08-13 14:33:54'),(2,'ACMT2',1700,'2017-08-13 14:34:45'),(3,'ACMT3',2500,'2017-08-13 14:43:26'),(4,'ACMT4',1500,'2017-08-13 14:43:51'),(5,'ACMT5',1000,'2017-08-13 14:44:02'),(6,'ACMT6',900,'2017-08-13 14:44:15'),(7,'ACMT7',200,'2017-10-16 09:42:18'),(8,'ACMT7',2000,'2017-10-17 17:24:33');
/*!40000 ALTER TABLE `tblroomrate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblroomtype`
--

DROP TABLE IF EXISTS `tblroomtype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblroomtype` (
  `strRoomTypeID` varchar(10) NOT NULL,
  `strRoomType` varchar(20) NOT NULL,
  `intRoomTCapacity` int(11) NOT NULL,
  `intRoomTNoOfBeds` tinyint(3) NOT NULL,
  `intRoomTNoOfBathrooms` tinyint(3) NOT NULL,
  `intRoomTAirconditioned` tinyint(1) NOT NULL,
  `intRoomTCategory` int(11) NOT NULL,
  `strRoomDescription` varchar(100) NOT NULL,
  `intRoomTDeleted` tinyint(1) NOT NULL,
  `tmsCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`strRoomTypeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblroomtype`
--

LOCK TABLES `tblroomtype` WRITE;
/*!40000 ALTER TABLE `tblroomtype` DISABLE KEYS */;
INSERT INTO `tblroomtype` VALUES ('ACMT1','Florence',2,1,1,1,1,'N/A',1,'2017-08-30 23:55:18'),('ACMT2','Milan',5,3,1,1,1,'N/A',1,'2017-08-13 06:34:45'),('ACMT3','Venice',12,8,3,1,1,'N/A',1,'2017-08-13 06:43:26'),('ACMT4','Naples',4,2,0,1,1,'N/A',1,'2017-08-13 06:43:51'),('ACMT5','Kubo',12,0,0,0,0,'N/A',1,'2017-08-30 23:55:29'),('ACMT6','Nipa',10,0,0,0,0,'N/A',1,'2017-08-13 06:44:15'),('ACMT7','Rome',6,3,2,1,1,'N/A',1,'2017-10-16 01:42:18');
/*!40000 ALTER TABLE `tblroomtype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbluser`
--

DROP TABLE IF EXISTS `tbluser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbluser` (
  `strUserID` varchar(15) NOT NULL,
  `strUsername` varchar(45) NOT NULL,
  `strUserPassword` varchar(45) NOT NULL,
  `intRoom` tinyint(1) NOT NULL,
  `intBoat` tinyint(1) NOT NULL,
  `intItem` tinyint(1) NOT NULL,
  `intFee` tinyint(1) NOT NULL,
  `intActivity` tinyint(1) NOT NULL,
  `intBilling` tinyint(1) NOT NULL,
  `intMaintenance` tinyint(1) NOT NULL,
  `intReports` tinyint(1) NOT NULL,
  `intUtilities` tinyint(1) NOT NULL,
  `intUserStatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`strUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbluser`
--

LOCK TABLES `tbluser` WRITE;
/*!40000 ALTER TABLE `tbluser` DISABLE KEYS */;
INSERT INTO `tbluser` VALUES ('USER1','sa','a',0,0,0,0,1,1,0,1,1,0),('USER2','s','s',0,0,0,0,1,0,0,0,0,0),('USER3','admin','admin',1,1,1,1,1,1,1,1,1,1),('USER4','staff','staff',1,1,1,1,1,1,0,0,0,1),('USER5','boat driver','123123123',0,1,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `tbluser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblwebcontent`
--

DROP TABLE IF EXISTS `tblwebcontent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblwebcontent` (
  `strPageTitle` varchar(50) NOT NULL,
  `strHeaderDescription` text NOT NULL,
  `strHeaderImage` text NOT NULL,
  `strBodyDescription` text,
  `strBodyImage` longtext,
  PRIMARY KEY (`strPageTitle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblwebcontent`
--

LOCK TABLES `tblwebcontent` WRITE;
/*!40000 ALTER TABLE `tblwebcontent` DISABLE KEYS */;
INSERT INTO `tblwebcontent` VALUES ('About Us','Header Description','/img/header-4.jpg','{\"AboutDescription1\":\"Il Sogno is a beautiful beach resort in Bauan Batangas which is at the middle part of Batangas, Philippines. There are mountains present along the area giving the place fresh air in great contrast with the chaotic urban. The name Il Sogno is an Italian term meaning, \\u201cThe Dream\\u201d, it is The Dream Resort. Imagine waking up with the birds singing and soaring cheerfully in the sky, rising in a place where your first glimpse of the day is an endless horizon of turquoise and blue with a touch of a gleaming white powdery sand. Well, it already exist and it could be experienced by yours. Here at Il Sogno Beach Resort, we will let you feel that dreams do come true.\",\"AboutDescription2\":\"\\/img\\/filler-2.jpg\",\"AboutDescription3\":\"\\/img\\/filler-3.jpg\"}',NULL),('Accommodation','Il Sogno Beach Resort has cottages with the traditional Filipino design. This resort also has a wide variety of rooms excellent for relaxation and will give you comfort. Dwelling in these areas will allow you to see the enchanting view of the Batangas Bay, a mountain called Galugod Baboy and other surrounding islands.','/img/header-2.jpg',NULL,NULL),('Activities','Il Sogno Beach Resort lets you experience activities closely with nature.','/img/header-7.jpg',NULL,NULL),('Contact Us','Nangkaan Locloc Bauan, Batangas','/img/header-5.jpg',NULL,NULL),('Home Page','Il Sogno Beach Resort is located specifically at Nangkaan Locloc Bauan, Batangas. The resort offers warm hospitality and remarkable experiences you will surely enjoy in the midst of the nature.','/img/header-1.jpeg','THE UNSEEN BEAUTY OF BAUAN. Nasugbu, Calatagan, Laiya and Anilao top the list of places in Batangas that have nice beaches and astonishing underwater world. But do not close that list just yet because Bauan, Batangas has its own secret marvel that is yet to be revealed.\r\nIntroducing a beach resort perfect for your trip away from the city, Il Sogno Beach Resort. This place is ideal for individuals seeking for personal space, wanting to explore nature, and looking for a place for family gathering. It will surely let you experience a life away from the busy, polluted, and noisy metro.\r\nWhat are you waiting for? Book now to experience the alluring beauty of the Il Sogno Beach Resort in Bauan, Batangas.','[\"\\/img\\/filler-1.jpg\",\"\\/img\\/12028856_536689703151053_5061722610295416643_o.jpg\",\"\\/img\\/filler-3.jpg\"]'),('Location','If you ever wondered where you can go for a budget weekend getaway, Bauan, Batangas is the perfect destination. It is not too far from Manila but you can spend time to break free from the chaotic urban life.','/img/header-3.jpg','From Cubao, Quezon City (Boat ride).Ride a bus on the terminal, and alight in the Batangas City Grand Terminal. From there, take a jeep going to Bauan Pier. In the Bauan Pier, ride a boat going to Il Sogno Beach Resort.\r\nTo get there by land,you need to take a jeep then a tricycle. You can take a jeep going to Mabini, Batangas and alight at the town of San Pedro, from there you can take a tricycle up to the town of Sampaguita. From the town of Sampaguita, walk your way through the beautiful Il Sogno Beach Resort.',NULL),('Packages','Perfect deals during your stay in Il Sogno Beach Resort. This includes accommodation, items, and activities that you will absolutely adore.','/img/header-6.jpg',NULL,NULL);
/*!40000 ALTER TABLE `tblwebcontent` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-13  1:26:23

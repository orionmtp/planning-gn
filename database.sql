CREATE DATABASE /*!32312 IF NOT EXISTS*/ `planning` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `planning`;

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gn` int(11) NOT NULL,
  `login` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `medical` tinyint(1) NOT NULL DEFAULT 0,
  `role` varchar(255) NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `gn` (`gn`),
  KEY `admin` (`login`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`gn`) REFERENCES `gn` (`id`) ON DELETE CASCADE,
  CONSTRAINT `admin_ibfk_2` FOREIGN KEY (`login`) REFERENCES `login` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='liste les admins d''un GN';
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `appartenance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appartenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL,
  `groupe` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `besoin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `besoin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gn` int(11) NOT NULL,
  `event` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `description` blob DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  `number` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `event` (`event`),
  KEY `role` (`role`),
  KEY `gn` (`gn`),
  CONSTRAINT `besoin_ibfk_1` FOREIGN KEY (`event`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  CONSTRAINT `besoin_ibfk_2` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE CASCADE,
  CONSTRAINT `besoin_ibfk_3` FOREIGN KEY (`gn`) REFERENCES `gn` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8 COMMENT='liste les besoins d''un event';
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `debut` time DEFAULT NULL,
  `prepa` time DEFAULT NULL,
  `duree` time DEFAULT NULL,
  `priorite` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `gn` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gn` (`gn`),
  CONSTRAINT `event_ibfk_1` FOREIGN KEY (`gn`) REFERENCES `gn` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COMMENT='liste des evenements d''un GN';
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `gn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  `debut` datetime DEFAULT NULL,
  `fin` datetime DEFAULT NULL,
  `description` text CHARACTER SET latin1 DEFAULT NULL,
  `presentation` longtext DEFAULT NULL,
  `nb_pnj` int(11) NOT NULL,
  `nb_pj` int(11) NOT NULL,
  `paf_pj` int(11) NOT NULL,
  `paf_pnj` int(11) NOT NULL,
  `rue` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `pays` varchar(25) DEFAULT NULL,
  `CP` int(11) DEFAULT NULL,
  `fedeGN` tinyint(1) NOT NULL DEFAULT 0,
  `website` varchar(60) DEFAULT 'http://',
  `avant` longtext NOT NULL,
  `scenario` longtext NOT NULL,
  `running` tinyint(1) NOT NULL DEFAULT 0,
  `delta` time NOT NULL DEFAULT '00:00:00',
  `avance` tinyint(1) NOT NULL DEFAULT 0,
  `serial` varchar(16) DEFAULT NULL,
  `recur` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `groupe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(40) DEFAULT NULL,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `hierarchie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hierarchie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupe` int(11) NOT NULL,
  `dans_groupe` int(11) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `inscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) DEFAULT NULL,
  `gn` int(11) DEFAULT NULL,
  `pnj` tinyint(1) NOT NULL DEFAULT 0,
  `paiement` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `gn` (`gn`),
  KEY `pnj` (`login`),
  KEY `id` (`id`),
  CONSTRAINT `inscription_ibfk_1` FOREIGN KEY (`gn`) REFERENCES `gn` (`id`) ON DELETE CASCADE,
  CONSTRAINT `inscription_ibfk_2` FOREIGN KEY (`login`) REFERENCES `login_jeu` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='personnes inscrites a un GN';
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `delta` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nom` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='liste des comptes inscrits';
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `login_jeu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_jeu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `sante` varchar(255) DEFAULT NULL,
  `alim` tinyint(4) NOT NULL DEFAULT 0,
  `contact1_nom` varchar(50) DEFAULT NULL,
  `contact1_tel` varchar(15) DEFAULT NULL,
  `contact2_nom` varchar(50) DEFAULT NULL,
  `contact2_tel` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nom` (`pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COMMENT='liste des comptes inscrits';
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `objectif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objectif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gn` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `relation` int(11) NOT NULL DEFAULT 0,
  `succes` tinyint(1) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `obj_secret` tinyint(1) NOT NULL DEFAULT 0,
  `cible_secret` tinyint(1) NOT NULL DEFAULT 0,
  `defvalue` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `planning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `besoin` int(11) DEFAULT NULL,
  `pnj` int(11) DEFAULT NULL,
  `debut` datetime DEFAULT NULL,
  `fin` datetime DEFAULT NULL,
  `gn` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pnj` (`pnj`),
  KEY `besoin` (`besoin`),
  KEY `gn` (`gn`),
  CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`pnj`) REFERENCES `inscription` (`id`) ON DELETE CASCADE,
  CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`besoin`) REFERENCES `besoin` (`id`) ON DELETE CASCADE,
  CONSTRAINT `planning_ibfk_3` FOREIGN KEY (`gn`) REFERENCES `gn` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='planning des non joueurs';
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `pre_requis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pre_requis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` int(11) NOT NULL,
  `objectif` int(11) NOT NULL,
  `cond` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `preference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pnj` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `gn` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role`),
  KEY `pnj` (`pnj`),
  KEY `pnj_2` (`pnj`),
  KEY `gn` (`gn`),
  CONSTRAINT `preference_ibfk_1` FOREIGN KEY (`role`) REFERENCES `role` (`id`) ON DELETE CASCADE,
  CONSTRAINT `preference_ibfk_2` FOREIGN KEY (`pnj`) REFERENCES `login_jeu` (`id`) ON DELETE CASCADE,
  CONSTRAINT `preference_ibfk_3` FOREIGN KEY (`gn`) REFERENCES `inscription` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='liste les preferences de roles des non joueurs';
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` int(11) NOT NULL,
  `gn` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `pnj` tinyint(1) NOT NULL DEFAULT 0,
  `pnj_recurent` tinyint(1) NOT NULL DEFAULT 0,
  `background` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `style`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `style`
--

LOCK TABLES `style` WRITE;
/*!40000 ALTER TABLE `style` DISABLE KEYS */;
INSERT INTO `style` VALUES (1,'combattant'),(2,'diplomate'),(3,'discret'),(4,'commercant'),(5,'arnaqueur'),(6,'beau parleur'),(7,'recurent'),(8,'intermitent');
/*!40000 ALTER TABLE `style` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `style_joueur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `style_joueur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `joueur` int(11) DEFAULT NULL,
  `style` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `style_pnj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `style_pnj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) DEFAULT NULL,
  `style` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



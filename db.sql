DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `first_name` varchar(45) CHARACTER SET latin1 NOT NULL,
                           `last_name` varchar(45) CHARACTER SET latin1 NOT NULL,
                           `birth_date` date NOT NULL,
                           `report_subject` varchar(200) CHARACTER SET latin1 NOT NULL,
                           `country` varchar(50) CHARACTER SET latin1 NOT NULL,
                           `phone` varchar(45) CHARACTER SET latin1 NOT NULL,
                           `email` varchar(100) CHARACTER SET latin1 NOT NULL,
                           `company` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
                           `position` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
                           `about_me` varchar(300) CHARACTER SET latin1 DEFAULT NULL,
                           `photo` varchar(100) CHARACTER SET latin1 DEFAULT 'no-photo.jpeg',
                           PRIMARY KEY (`id`),
                           UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

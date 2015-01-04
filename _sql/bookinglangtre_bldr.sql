
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
DROP TABLE IF EXISTS `aphs_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_accounts` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `email` varchar(70) CHARACTER SET latin1 NOT NULL,
  `account_type` enum('owner','mainadmin','admin','hotelowner','accounthotelmanageme','hotelmanagement','booking') CHARACTER SET latin1 NOT NULL DEFAULT 'mainadmin',
  `hotels` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `preferred_language` varchar(2) CHARACTER SET latin1 NOT NULL,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_accounts` WRITE;
/*!40000 ALTER TABLE `aphs_accounts` DISABLE KEYS */;
INSERT INTO `aphs_accounts` VALUES (1,'Nhan','Nguyen','admin','¡2 @à£¨‘évÞrÌn','nnhansg@gmail.com','owner','','en','0000-00-00 00:00:00','2014-11-28 19:05:17',1);
INSERT INTO `aphs_accounts` VALUES (6,'Nhan','Nguyen','nhannguyen','–HòpÛ+þ…]z2gO›','nhantidus@gmail.com','booking','a:1:{i:0;s:1:\"4\";}','en','2014-04-09 12:45:53','2014-11-25 12:30:45',1);
INSERT INTO `aphs_accounts` VALUES (10,'Dung','Lang Tre','dunglangtre','ËAñ¥ÏÐ¸Ã²¤¸îÇGË´h30jýQ^GÏÐK;%','dunglangtre@gmail.com','mainadmin','a:1:{i:0;s:1:\"4\";}','en','2014-05-25 05:22:27','2014-10-24 12:41:29',1);
INSERT INTO `aphs_accounts` VALUES (11,'Minh Hieu','Tran','minhhieu','…ëÐ‘(Ë„º¥Ë7WV','hieu_tran@bamboovillageresortvn.com','mainadmin','','en','2014-08-10 00:29:04','2014-08-21 11:37:11',1);
/*!40000 ALTER TABLE `aphs_accounts` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_banlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_banlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ban_item` varchar(70) CHARACTER SET latin1 NOT NULL,
  `ban_item_type` enum('IP','Email') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'IP',
  `ban_reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ban_ip` (`ban_item`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_banlist` WRITE;
/*!40000 ALTER TABLE `aphs_banlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `aphs_banlist` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_banners` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `image_file` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `image_file_thumb` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `priority_order` tinyint(1) NOT NULL DEFAULT '0',
  `link_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `priority_order` (`priority_order`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_banners` WRITE;
/*!40000 ALTER TABLE `aphs_banners` DISABLE KEYS */;
INSERT INTO `aphs_banners` VALUES (1,'uda6wqw82di4kh186blf.jpg','uda6wqw82di4kh186blf_thumb.jpg',1,'',1);
INSERT INTO `aphs_banners` VALUES (2,'v4vqrryxizavtqk4gwfl.jpg','v4vqrryxizavtqk4gwfl_thumb.jpg',2,'',1);
INSERT INTO `aphs_banners` VALUES (3,'l63zfwtsr2tmrespc8x2.jpg','l63zfwtsr2tmrespc8x2_thumb.jpg',3,'',1);
INSERT INTO `aphs_banners` VALUES (4,'ti0z69fsn7f5u9o07wfk.jpg','ti0z69fsn7f5u9o07wfk_thumb.jpg',4,'',1);
INSERT INTO `aphs_banners` VALUES (5,'y6lqa0a1zje87pe7q7uo.jpg','y6lqa0a1zje87pe7q7uo_thumb.jpg',5,'',1);
/*!40000 ALTER TABLE `aphs_banners` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_banners_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_banners_description` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `banner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `image_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_banners_description` WRITE;
/*!40000 ALTER TABLE `aphs_banners_description` DISABLE KEYS */;
INSERT INTO `aphs_banners_description` VALUES (1,1,'en','Rooms measuring 15 m² equipped with all the details expected of a superior 4 star hotel.');
INSERT INTO `aphs_banners_description` VALUES (22,2,'ru','Modern and functional rooms measuring approximately 20-25 m² equipped with all the details expected of the hotel. The rooms have a king or queen size bed or two single beds.');
INSERT INTO `aphs_banners_description` VALUES (4,2,'en','Modern and functional rooms measuring approximately 20-25 m² equipped with all the details expected of the hotel. The rooms have a king or queen size bed or two single beds.');
INSERT INTO `aphs_banners_description` VALUES (19,4,'vi','');
INSERT INTO `aphs_banners_description` VALUES (20,5,'vi','');
INSERT INTO `aphs_banners_description` VALUES (21,1,'ru','Rooms measuring 15 m² equipped with all the details expected of a superior 4 star hotel.');
INSERT INTO `aphs_banners_description` VALUES (17,2,'vi','Modern and functional rooms measuring approximately 20-25 m² equipped with all the details expected of the hotel. The rooms have a king or queen size bed or two single beds.');
INSERT INTO `aphs_banners_description` VALUES (7,3,'en','');
INSERT INTO `aphs_banners_description` VALUES (18,3,'vi','');
INSERT INTO `aphs_banners_description` VALUES (10,4,'en','');
INSERT INTO `aphs_banners_description` VALUES (13,5,'en','');
INSERT INTO `aphs_banners_description` VALUES (16,1,'vi','Rooms measuring 15 m² equipped with all the details expected of a superior 4 star hotel.');
INSERT INTO `aphs_banners_description` VALUES (23,3,'ru','');
INSERT INTO `aphs_banners_description` VALUES (24,4,'ru','');
INSERT INTO `aphs_banners_description` VALUES (25,5,'ru','');
/*!40000 ALTER TABLE `aphs_banners_description` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_number` varchar(20) CHARACTER SET latin1 NOT NULL,
  `hotel_reservation_id` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `booking_description` varchar(255) CHARACTER SET latin1 NOT NULL,
  `discount_percent` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  `discount_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `order_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pre_payment_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `pre_payment_value` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `vat_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `vat_percent` decimal(5,3) unsigned NOT NULL DEFAULT '0.000',
  `initial_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `payment_sum` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `additional_payment` decimal(10,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(3) CHARACTER SET latin1 NOT NULL DEFAULT 'USD',
  `rooms_amount` tinyint(4) NOT NULL DEFAULT '0',
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `is_admin_reservation` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `transaction_number` varchar(30) CHARACTER SET latin1 NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - POA, 1 - Online Order, 2 - PayPal, 3 - 2CO, 4 - Authorize.Net, 5 - Bank Transfer',
  `payment_method` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 - Payment Company Account, 1 - Credit Card, 2 - E-Check',
  `coupon_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `discount_campaign_id` int(10) DEFAULT '0',
  `additional_info` text COLLATE utf8_unicode_ci NOT NULL,
  `extras` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `extras_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `cc_type` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `cc_holder_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cc_number` varchar(50) CHARACTER SET latin1 NOT NULL,
  `cc_expires_month` varchar(2) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `cc_expires_year` varchar(4) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `cc_cvv_code` varchar(4) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - preparing, 1 - reserved, 2 - completed, 3 - refunded, 4 - payment error, 5 - canceled',
  `status_changed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email_sent` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `payment_type` (`payment_type`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_bookings` WRITE;
/*!40000 ALTER TABLE `aphs_bookings` DISABLE KEYS */;
INSERT INTO `aphs_bookings` VALUES (1,'1UN7LD0PAB','','Rooms Reservation',0.00,0.00,55.00,'full price',0.00,0.00,0.000,0.00,55.00,0.00,'USD',1,1,1,'','2013-10-11 22:44:02','0000-00-00 00:00:00',3,0,'',0,'','a:0:{}',0.00,'','','','','','',1,'0000-00-00 00:00:00','',0);
INSERT INTO `aphs_bookings` VALUES (2,'OVK4RC91S8','','Rooms Reservation',0.00,0.00,110.00,'full price',0.00,0.00,0.000,0.00,120.00,0.00,'USD',1,1,0,'','2013-10-11 22:47:31','0000-00-00 00:00:00',0,0,'',0,'','a:1:{i:1;s:1:\"1\";}',10.00,'','','´h30jýQ^GÏÐK;%','','','',1,'2013-10-11 22:47:34','',0);
INSERT INTO `aphs_bookings` VALUES (3,'4PVV6J2BN5','','Rooms Reservation',0.00,0.00,55.00,'full price',0.00,0.00,0.000,0.00,55.00,0.00,'USD',1,3,0,'','2013-10-12 19:11:56','0000-00-00 00:00:00',0,0,'',0,'','a:0:{}',0.00,'','','´h30jýQ^GÏÐK;%','','','',1,'2013-10-12 19:12:05','',0);
INSERT INTO `aphs_bookings` VALUES (4,'KUDTZG8VVO','','Rooms Reservation',0.00,0.00,55.00,'full price',0.00,0.00,0.000,0.00,55.00,0.00,'USD',1,2,0,'','2013-10-13 00:30:36','0000-00-00 00:00:00',0,0,'',0,'','a:0:{}',0.00,'','','´h30jýQ^GÏÐK;%','','','',1,'2013-10-13 00:30:38','',0);
INSERT INTO `aphs_bookings` VALUES (6,'XQVMN2A7SN','','Rooms Reservation',0.00,0.00,80.00,'full price',0.00,0.00,0.000,0.00,80.00,0.00,'USD',1,6,0,'','2013-10-28 20:41:23','0000-00-00 00:00:00',0,0,'',0,'','a:0:{}',0.00,'','','´h30jýQ^GÏÐK;%','','','',1,'2013-10-28 20:41:30','',0);
INSERT INTO `aphs_bookings` VALUES (7,'NTXN6XLR9V','','Rooms Reservation',0.00,0.00,55.00,'full price',0.00,0.00,0.000,0.00,55.00,0.00,'USD',1,7,0,'','2013-11-11 15:55:52','0000-00-00 00:00:00',0,0,'',0,'','a:0:{}',0.00,'','','´h30jýQ^GÏÐK;%','','','',1,'2013-11-11 15:56:05','',0);
INSERT INTO `aphs_bookings` VALUES (8,'DYLYH1W15I','','Rooms Reservation',0.00,0.00,55.00,'full price',0.00,0.00,0.000,0.00,95.00,0.00,'USD',1,8,0,'','2014-01-27 11:45:08','0000-00-00 00:00:00',5,0,'',0,'','a:2:{i:1;s:1:\"1\";i:2;s:1:\"1\";}',40.00,'','','´h30jýQ^GÏÐK;%','','','',1,'2014-01-27 11:45:33','',0);
INSERT INTO `aphs_bookings` VALUES (9,'YCO7PPRYUT','','Rooms Reservation',0.00,0.00,176.84,'full price',0.00,24.68,10.000,0.00,271.52,0.00,'USD',2,4,0,'','2014-04-10 08:31:19','2014-04-10 14:41:09',0,0,'',0,'That\';s good!','a:2:{i:1;s:1:\"1\";i:2;s:1:\"2\";}',70.00,'','','´h30jýQ^GÏÐK;%','','','',5,'2014-08-02 09:20:51','This booking was canceled by administrator.',1);
INSERT INTO `aphs_bookings` VALUES (11,'GABGI7PWDX','','Rooms Reservation',0.00,0.00,12956000.00,'full price',0.00,1295600.00,10.000,0.00,14251600.00,0.00,'VND',2,9,0,'','2014-08-28 08:52:49','0000-00-00 00:00:00',5,0,'',0,'Test add infomation','a:0:{}',0.00,'','','´h30jýQ^GÏÐK;%','','','',1,'2014-08-28 08:53:12','',0);
INSERT INTO `aphs_bookings` VALUES (14,'QUH4BS63WF','','Rooms Reservation',0.00,0.00,6381000.00,'full price',0.00,638100.00,10.000,0.00,7019100.00,0.00,'VND',1,13,0,'','2014-10-14 10:26:21','0000-00-00 00:00:00',5,0,'',0,'','a:0:{}',0.00,'','','´h30jýQ^GÏÐK;%','','','',1,'2014-10-14 10:27:13','',0);
INSERT INTO `aphs_bookings` VALUES (15,'5KSPSJ4SJU','','Rooms Reservation',0.00,0.00,9993000.00,'full price',0.00,0.00,0.000,0.00,9993000.00,0.00,'VND',1,14,0,'','2014-10-14 10:39:21','0000-00-00 00:00:00',0,0,'',0,'','a:1:{i:1;s:1:\"1\";}',0.00,'','','´h30jýQ^GÏÐK;%','','','',1,'2014-10-14 10:39:32','',0);
/*!40000 ALTER TABLE `aphs_bookings` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_bookings_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_bookings_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_number` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `hotel_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `room_id` int(11) NOT NULL DEFAULT '0',
  `room_numbers` varchar(12) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `adults` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `children` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `rooms` tinyint(1) NOT NULL DEFAULT '0',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `guests` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `guests_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `meal_plan_id` int(11) unsigned NOT NULL DEFAULT '0',
  `meal_plan_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `booking_number` (`booking_number`),
  KEY `room_id` (`room_id`),
  KEY `hotel_id` (`hotel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_bookings_rooms` WRITE;
/*!40000 ALTER TABLE `aphs_bookings_rooms` DISABLE KEYS */;
INSERT INTO `aphs_bookings_rooms` VALUES (1,'1UN7LD0PAB',1,1,'','2013-10-11','2013-10-12',1,0,1,55.00,0,0.00,1,0.00);
INSERT INTO `aphs_bookings_rooms` VALUES (3,'OVK4RC91S8',1,1,'2','2013-10-12','2013-10-14',1,0,1,110.00,0,0.00,1,0.00);
INSERT INTO `aphs_bookings_rooms` VALUES (4,'4PVV6J2BN5',1,1,'','2013-10-13','2013-10-14',1,0,1,55.00,0,0.00,1,0.00);
INSERT INTO `aphs_bookings_rooms` VALUES (5,'KUDTZG8VVO',1,1,'','2013-10-13','2013-10-14',1,0,1,55.00,0,0.00,1,0.00);
INSERT INTO `aphs_bookings_rooms` VALUES (6,'HUDZB435LP',1,1,'','2013-10-15','2013-10-16',1,0,6,330.00,0,0.00,1,0.00);
INSERT INTO `aphs_bookings_rooms` VALUES (7,'XQVMN2A7SN',1,2,'','2013-10-29','2013-10-30',2,0,1,80.00,0,0.00,1,0.00);
INSERT INTO `aphs_bookings_rooms` VALUES (8,'NTXN6XLR9V',1,1,'','2013-11-11','2013-11-12',1,0,1,55.00,0,0.00,1,0.00);
INSERT INTO `aphs_bookings_rooms` VALUES (9,'DYLYH1W15I',1,1,'','2014-01-27','2014-01-28',1,0,1,55.00,0,0.00,1,0.00);
INSERT INTO `aphs_bookings_rooms` VALUES (10,'YCO7PPRYUT',4,5,'','2014-04-10','2014-04-11',1,0,2,176.84,0,0.00,0,0.00);
INSERT INTO `aphs_bookings_rooms` VALUES (15,'XW234RUO9R',4,4,'','2014-04-23','2014-04-27',1,0,1,760.00,0,0.00,0,0.00);
INSERT INTO `aphs_bookings_rooms` VALUES (16,'GABGI7PWDX',4,7,'','2014-08-28','2014-08-29',1,0,2,7456000.00,1,1720000.00,10,3780000.00);
INSERT INTO `aphs_bookings_rooms` VALUES (25,'ANN24EHTF2',4,10,'','2014-10-08','2014-10-09',1,0,1,1460000.00,0,0.00,10,1890000.00);
INSERT INTO `aphs_bookings_rooms` VALUES (27,'7DK5TV7UD4',4,7,'','2014-10-10','2014-10-11',1,0,1,3728000.00,0,0.00,10,1890000.00);
INSERT INTO `aphs_bookings_rooms` VALUES (31,'QUH4BS63WF',4,6,'','2014-11-21','2014-11-22',1,0,1,6213000.00,0,0.00,9,168000.00);
INSERT INTO `aphs_bookings_rooms` VALUES (33,'5KSPSJ4SJU',4,7,'','2014-12-24','2014-12-25',2,0,1,6213000.00,0,0.00,10,3780000.00);
INSERT INTO `aphs_bookings_rooms` VALUES (37,'BQW6B3PK7Q',4,11,'','2015-04-08','2015-04-14',2,0,1,28458000.00,1,10320000.00,8,4536000.00);
INSERT INTO `aphs_bookings_rooms` VALUES (40,'QA533GS32J',4,7,'','2014-11-19','2014-11-22',2,0,1,18639000.00,0,0.00,10,11340000.00);
INSERT INTO `aphs_bookings_rooms` VALUES (42,'U9BEJN11XO',4,7,'','2014-11-21','2014-11-22',1,0,1,6213000.00,0,0.00,10,1890000.00);
INSERT INTO `aphs_bookings_rooms` VALUES (43,'FYEU7RWXKV',4,7,'','2014-11-25','2014-11-26',1,0,1,6213000.00,0,0.00,10,1890000.00);
INSERT INTO `aphs_bookings_rooms` VALUES (44,'OQ8HGP5QPW',4,7,'','2014-12-22','2014-12-23',1,0,1,6213000.00,0,0.00,9,168000.00);
/*!40000 ALTER TABLE `aphs_bookings_rooms` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_campaigns` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `campaign_type` enum('global','standard') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'global',
  `campaign_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `finish_date` date NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `target_group_id` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_campaigns` WRITE;
/*!40000 ALTER TABLE `aphs_campaigns` DISABLE KEYS */;
INSERT INTO `aphs_campaigns` VALUES (1,0,'global','Campaign #_ Aug 2014','2014-08-02','2014-08-10',30.00,0);
/*!40000 ALTER TABLE `aphs_campaigns` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(10) NOT NULL DEFAULT '0',
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(70) CHARACTER SET latin1 NOT NULL,
  `comment_text` text COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `date_published` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_comments` WRITE;
/*!40000 ALTER TABLE `aphs_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `aphs_comments` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_countries` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `abbrv` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `vat_value` decimal(5,3) NOT NULL DEFAULT '0.000',
  `priority_order` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `abbrv` (`abbrv`)
) ENGINE=MyISAM AUTO_INCREMENT=238 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_countries` WRITE;
/*!40000 ALTER TABLE `aphs_countries` DISABLE KEYS */;
INSERT INTO `aphs_countries` VALUES (1,'AF','Afghanistan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (2,'AL','Albania',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (3,'DZ','Algeria',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (4,'AS','American Samoa',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (5,'AD','Andorra',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (6,'AO','Angola',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (7,'AI','Anguilla',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (8,'AQ','Antarctica',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (9,'AG','Antigua and Barbuda',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (10,'AR','Argentina',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (11,'AM','Armenia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (12,'AW','Aruba',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (13,'AU','Australia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (14,'AT','Austria',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (15,'AZ','Azerbaijan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (16,'BS','Bahamas',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (17,'BH','Bahrain',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (18,'BD','Bangladesh',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (19,'BB','Barbados',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (20,'BY','Belarus',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (21,'BE','Belgium',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (22,'BZ','Belize',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (23,'BJ','Benin',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (24,'BM','Bermuda',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (25,'BT','Bhutan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (26,'BO','Bolivia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (27,'BA','Bosnia and Herzegowina',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (28,'BW','Botswana',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (29,'BV','Bouvet Island',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (30,'BR','Brazil',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (31,'IO','British Indian Ocean Territory',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (32,'VG','British Virgin Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (33,'BN','Brunei Darussalam',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (34,'BG','Bulgaria',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (35,'BF','Burkina Faso',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (36,'BI','Burundi',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (37,'KH','Cambodia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (38,'CM','Cameroon',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (39,'CA','Canada',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (40,'CV','Cape Verde',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (41,'KY','Cayman Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (42,'CF','Central African Republic',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (43,'TD','Chad',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (44,'CL','Chile',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (45,'CN','China',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (46,'CX','Christmas Island',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (47,'CC','Cocos (Keeling) Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (48,'CO','Colombia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (49,'KM','Comoros',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (50,'CG','Congo',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (51,'CK','Cook Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (52,'CR','Costa Rica',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (53,'CI','Cote D\'ivoire',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (54,'HR','Croatia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (55,'CU','Cuba',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (56,'CY','Cyprus',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (57,'CZ','Czech Republic',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (58,'DK','Denmark',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (59,'DJ','Djibouti',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (60,'DM','Dominica',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (61,'DO','Dominican Republic',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (62,'TP','East Timor',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (63,'EC','Ecuador',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (64,'EG','Egypt',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (65,'SV','El Salvador',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (66,'GQ','Equatorial Guinea',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (67,'ER','Eritrea',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (68,'EE','Estonia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (69,'ET','Ethiopia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (70,'FK','Falkland Islands (Malvinas)',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (71,'FO','Faroe Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (72,'FJ','Fiji',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (73,'FI','Finland',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (74,'FR','France',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (75,'GF','French Guiana',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (76,'PF','French Polynesia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (77,'TF','French Southern Territories',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (78,'GA','Gabon',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (79,'GM','Gambia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (80,'GE','Georgia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (81,'DE','Germany',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (82,'GH','Ghana',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (83,'GI','Gibraltar',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (84,'GR','Greece',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (85,'GL','Greenland',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (86,'GD','Grenada',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (87,'GP','Guadeloupe',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (88,'GU','Guam',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (89,'GT','Guatemala',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (90,'GN','Guinea',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (91,'GW','Guinea-Bissau',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (92,'GY','Guyana',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (93,'HT','Haiti',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (94,'HM','Heard and McDonald Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (95,'HN','Honduras',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (96,'HK','Hong Kong',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (97,'HU','Hungary',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (98,'IS','Iceland',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (99,'IN','India',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (100,'ID','Indonesia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (101,'IQ','Iraq',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (102,'IE','Ireland',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (103,'IR','Islamic Republic of Iran',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (104,'IL','Israel',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (105,'IT','Italy',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (106,'JM','Jamaica',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (107,'JP','Japan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (108,'JO','Jordan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (109,'KZ','Kazakhstan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (110,'KE','Kenya',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (111,'KI','Kiribati',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (112,'KP','Korea, Dem. Peoples Rep of',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (113,'KR','Korea, Republic of',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (114,'KW','Kuwait',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (115,'KG','Kyrgyzstan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (116,'LA','Laos',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (117,'LV','Latvia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (118,'LB','Lebanon',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (119,'LS','Lesotho',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (120,'LR','Liberia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (121,'LY','Libyan Arab Jamahiriya',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (122,'LI','Liechtenstein',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (123,'LT','Lithuania',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (124,'LU','Luxembourg',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (125,'MO','Macau',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (126,'MK','Macedonia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (127,'MG','Madagascar',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (128,'MW','Malawi',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (129,'MY','Malaysia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (130,'MV','Maldives',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (131,'ML','Mali',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (132,'MT','Malta',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (133,'MH','Marshall Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (134,'MQ','Martinique',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (135,'MR','Mauritania',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (136,'MU','Mauritius',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (137,'YT','Mayotte',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (138,'MX','Mexico',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (139,'FM','Micronesia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (140,'MD','Moldova, Republic of',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (141,'MC','Monaco',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (142,'MN','Mongolia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (143,'MS','Montserrat',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (144,'MA','Morocco',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (145,'MZ','Mozambique',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (146,'MM','Myanmar',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (147,'NA','Namibia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (148,'NR','Nauru',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (149,'NP','Nepal',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (150,'NL','Netherlands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (151,'AN','Netherlands Antilles',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (152,'NC','New Caledonia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (153,'NZ','New Zealand',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (154,'NI','Nicaragua',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (155,'NE','Niger',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (156,'NG','Nigeria',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (157,'NU','Niue',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (158,'NF','Norfolk Island',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (159,'MP','Northern Mariana Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (160,'NO','Norway',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (161,'OM','Oman',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (162,'PK','Pakistan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (163,'PW','Palau',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (164,'PA','Panama',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (165,'PG','Papua New Guinea',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (166,'PY','Paraguay',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (167,'PE','Peru',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (168,'PH','Philippines',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (169,'PN','Pitcairn',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (170,'PL','Poland',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (171,'PT','Portugal',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (172,'PR','Puerto Rico',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (173,'QA','Qatar',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (174,'RE','Reunion',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (175,'RO','Romania',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (176,'RU','Russian Federation',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (177,'RW','Rwanda',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (178,'LC','Saint Lucia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (179,'WS','Samoa',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (180,'SM','San Marino',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (181,'ST','Sao Tome and Principe',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (182,'SA','Saudi Arabia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (183,'SN','Senegal',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (184,'YU','Serbia and Montenegro',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (185,'SC','Seychelles',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (186,'SL','Sierra Leone',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (187,'SG','Singapore',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (188,'SK','Slovakia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (189,'SI','Slovenia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (190,'SB','Solomon Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (191,'SO','Somalia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (192,'ZA','South Africa',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (193,'ES','Spain',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (194,'LK','Sri Lanka',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (195,'SH','St. Helena',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (196,'KN','St. Kitts and Nevis',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (197,'PM','St. Pierre and Miquelon',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (198,'VC','St. Vincent and the Grenadines',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (199,'SD','Sudan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (200,'SR','Suriname',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (201,'SJ','Svalbard and Jan Mayen Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (202,'SZ','Swaziland',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (203,'SE','Sweden',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (204,'CH','Switzerland',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (205,'SY','Syrian Arab Republic',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (206,'TW','Taiwan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (207,'TJ','Tajikistan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (208,'TZ','Tanzania, United Republic of',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (209,'TH','Thailand',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (210,'TG','Togo',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (211,'TK','Tokelau',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (212,'TO','Tonga',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (213,'TT','Trinidad and Tobago',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (214,'TN','Tunisia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (215,'TR','Turkey',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (216,'TM','Turkmenistan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (217,'TC','Turks and Caicos Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (218,'TV','Tuvalu',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (219,'UG','Uganda',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (220,'UA','Ukraine',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (221,'AE','United Arab Emirates',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (222,'GB','United Kingdom (GB)',1,0,0.000,999);
INSERT INTO `aphs_countries` VALUES (224,'US','United States',1,1,10.000,1000);
INSERT INTO `aphs_countries` VALUES (225,'VI','United States Virgin Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (226,'UY','Uruguay',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (227,'UZ','Uzbekistan',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (228,'VU','Vanuatu',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (229,'VA','Vatican City State',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (230,'VE','Venezuela',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (231,'VN','Vietnam',1,0,10.000,888);
INSERT INTO `aphs_countries` VALUES (232,'WF','Wallis And Futuna Islands',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (233,'EH','Western Sahara',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (234,'YE','Yemen',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (235,'ZR','Zaire',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (236,'ZM','Zambia',1,0,0.000,0);
INSERT INTO `aphs_countries` VALUES (237,'ZW','Zimbabwe',1,0,0.000,0);
/*!40000 ALTER TABLE `aphs_countries` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `date_started` date NOT NULL,
  `date_finished` date NOT NULL,
  `discount_percent` tinyint(2) NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_coupons` WRITE;
/*!40000 ALTER TABLE `aphs_coupons` DISABLE KEYS */;
INSERT INTO `aphs_coupons` VALUES (3,'Summer Cool package','2014-05-01','2014-10-31',35,'Stay in Deluxe room, enjoy 2 ice-cream per room night, 10% discount for local site seeing tour, 15% discount on F&B and Laundry, 20 % Spa off',0);
/*!40000 ALTER TABLE `aphs_coupons` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(3) CHARACTER SET latin1 NOT NULL,
  `rate` double(10,4) NOT NULL DEFAULT '1.0000',
  `symbol_placement` enum('left','right') CHARACTER SET latin1 NOT NULL DEFAULT 'right',
  `primary_order` tinyint(1) NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_currencies` WRITE;
/*!40000 ALTER TABLE `aphs_currencies` DISABLE KEYS */;
INSERT INTO `aphs_currencies` VALUES (7,'Viet Nam Dong',' đ','VND',1.0000,'right',2,1,1);
/*!40000 ALTER TABLE `aphs_currencies` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_customer_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_customer_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_customer_groups` WRITE;
/*!40000 ALTER TABLE `aphs_customer_groups` DISABLE KEYS */;
INSERT INTO `aphs_customer_groups` VALUES (1,'General','General purpose only');
INSERT INTO `aphs_customer_groups` VALUES (2,'Old','Old');
INSERT INTO `aphs_customer_groups` VALUES (3,'Promo1','');
/*!40000 ALTER TABLE `aphs_customer_groups` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `first_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `birth_date` date NOT NULL DEFAULT '0000-00-00',
  `company` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `b_address` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `b_address_2` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `b_city` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `b_state` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `b_country` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `b_zipcode` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(32) CHARACTER SET latin1 NOT NULL,
  `user_password` varchar(50) CHARACTER SET latin1 NOT NULL,
  `preferred_language` varchar(2) CHARACTER SET latin1 NOT NULL DEFAULT 'en',
  `date_created` datetime NOT NULL,
  `date_lastlogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `registered_from_ip` varchar(15) CHARACTER SET latin1 NOT NULL,
  `last_logged_ip` varchar(15) CHARACTER SET latin1 NOT NULL DEFAULT '000.000.000.000',
  `email_notifications` tinyint(1) NOT NULL DEFAULT '0',
  `notification_status_changed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `orders_count` smallint(6) NOT NULL DEFAULT '0',
  `rooms_count` smallint(6) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 - registration pending, 1 - active customer',
  `is_removed` tinyint(4) NOT NULL DEFAULT '0',
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `registration_code` varchar(20) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `b_country` (`b_country`),
  KEY `status` (`is_active`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_customers` WRITE;
/*!40000 ALTER TABLE `aphs_customers` DISABLE KEYS */;
INSERT INTO `aphs_customers` VALUES (1,0,'Tam','Nguyen','1985-01-02','VN','HCM','','HCM','','VN','70000','0939595373','','nguyentamvinhlong@gmail.com','','','','en','2013-10-11 22:46:27','0000-00-00 00:00:00','127.0.0.1','',1,'0000-00-00 00:00:00',1,1,1,0,'','');
INSERT INTO `aphs_customers` VALUES (2,1,'Test','Guest','1990-01-01','','18/1 Tan An, Tan Hanh, Long Ho','','Vinh Long','','VN','','0907516603','','test@egs.vn','','test','fãfœ+ùí)n©Åèè','en','2013-10-12 12:08:35','2013-10-28 23:17:52','127.0.0.1','222.254.206.211',1,'0000-00-00 00:00:00',1,1,1,0,'','JWQDSV93DNOA4UQ9NTC');
INSERT INTO `aphs_customers` VALUES (3,0,'Tam','Nguyen','1984-02-02','','3 Ly Van Phuc, Tan Dinh, quan 1','3 Ly Van Phuc, Tan Dinh, quan 1','Ho Chi Minh','HCM','VN','70000','0907516603','','nguyentamvinhlong@gmail.com','','','','en','2013-10-12 19:11:42','0000-00-00 00:00:00','171.243.97.85','',1,'0000-00-00 00:00:00',1,1,1,0,'','');
INSERT INTO `aphs_customers` VALUES (4,1,'Nhan','Nguyen','1985-03-04','','166/11/10G','','Ho Chi Minh','','VN','70000','0902763955','','nhantidus@gmail.com','','nhantidus@gmail.com','–HòpÛ+þ…]z2gO›','en','2013-10-15 14:25:17','2014-06-19 10:31:55','14.161.1.186','14.169.55.245',1,'0000-00-00 00:00:00',1,2,1,0,'','');
INSERT INTO `aphs_customers` VALUES (6,0,'Luu','Khuynh','1970-02-03','BD','TAN PHU','','HCM','','VN','70000','0964646464646','','khuynh.luu@hcmufa.edu.vn','','','','en','2013-10-28 20:40:53','0000-00-00 00:00:00','183.91.18.56','',1,'0000-00-00 00:00:00',1,1,1,0,'','');
INSERT INTO `aphs_customers` VALUES (7,0,'Tam','Nguyen','1985-03-27','','HCM','3 Ly Van Phuc, Tan Dinh, quan 1','HCM','HCM','VN','70000','0907516603','','nguyentamvinhlong@gmail.com','','','','en','2013-11-11 15:55:40','0000-00-00 00:00:00','222.254.206.189','',1,'0000-00-00 00:00:00',1,1,1,0,'','');
INSERT INTO `aphs_customers` VALUES (8,0,'Nhan','Nguyen','1985-03-04','','166','','ho chi minh','','VN','70000','0902763955','','nhannguyen@9dragons.vn','','','','en','2014-01-27 11:44:36','0000-00-00 00:00:00','123.21.143.181','',1,'0000-00-00 00:00:00',1,1,1,0,'','');
INSERT INTO `aphs_customers` VALUES (9,0,'FN test','LN test','1985-03-04','NhanTamDevTeam','166/11 LTD','166/11/10G Le Trung Dinh Street, Son Ky Ward, Tan Phu District','Ho Chi Minh','','VN','70000','84902763955','','nnhansg@gmail.com','','','','en','2014-08-28 08:50:56','0000-00-00 00:00:00','123.21.137.89','',1,'0000-00-00 00:00:00',1,2,1,0,'','');
INSERT INTO `aphs_customers` VALUES (10,0,'Linh','Luong','1989-05-05','','So 38, duong 53, phuong Binh Thuan, Quan 7','So 38, duong 53, phuong Binh Thuan, Quan 7','Ho Chi Minh','','VN','08','0983601705','','thuy_linh5589@yahoo.com','','','','en','2014-10-07 10:46:46','0000-00-00 00:00:00','116.100.199.37','',1,'0000-00-00 00:00:00',0,0,1,0,'','');
INSERT INTO `aphs_customers` VALUES (11,0,'Linh','Luong','0000-00-00','','So 38, duong 53, phuong Binh Thuan, Quan 7','So 38, duong 53, phuong Binh Thuan, Quan 7','Ho Chi Minh','','VN','08','0983601705','','thuy_linh5589@yahoo.com','','','','en','2014-10-09 14:34:12','0000-00-00 00:00:00','116.100.199.37','',1,'0000-00-00 00:00:00',0,0,1,0,'','');
INSERT INTO `aphs_customers` VALUES (12,0,'Linh','Luong','0000-00-00','','So 38, duong 53, phuong Binh Thuan, Quan 7','So 38, duong 53, phuong Binh Thuan, Quan 7','Ho Chi Minh','','VN','08','0983601705','','thuy_linh5589@yahoo.com','','','','en','2014-10-10 12:44:19','0000-00-00 00:00:00','116.100.199.37','',1,'0000-00-00 00:00:00',0,0,1,0,'','');
INSERT INTO `aphs_customers` VALUES (13,0,'Hillgo','Tran','1968-01-01','','13806 Eldridge Garden Cir ','','Houston','','US','77083','7135755152','','hieusaigon1@gmail.com','','','','en','2014-10-14 10:19:11','0000-00-00 00:00:00','116.100.199.37','',1,'0000-00-00 00:00:00',1,1,1,0,'','');
INSERT INTO `aphs_customers` VALUES (14,0,'Hillgo','Tran','1925-08-07','','1122 Banhdn','','hyhuamhj','','AT','12345','441587982','','hieusaigon1@gmail.com','','','','en','2014-10-14 10:36:36','0000-00-00 00:00:00','116.100.199.37','',1,'0000-00-00 00:00:00',1,1,1,0,'','');
INSERT INTO `aphs_customers` VALUES (15,0,'Hillgo','Tran','1933-12-06','','176578 jhu8niuia','','jihunuz','','AW','11111','71548513215','','hieusaigon1@gmail.com','','','','en','2014-10-14 10:46:38','0000-00-00 00:00:00','116.100.199.37','',1,'0000-00-00 00:00:00',0,0,1,0,'','');
INSERT INTO `aphs_customers` VALUES (16,0,'hieu','tran','1941-01-01','','123jjkij','','hkhkyn','','US','11111','14326814','','hieusaigon1@gmail.com','','','','en','2014-10-16 10:08:06','0000-00-00 00:00:00','116.100.199.37','',1,'0000-00-00 00:00:00',0,0,1,0,'','');
INSERT INTO `aphs_customers` VALUES (17,0,'Linh','Luong','0000-00-00','','So 38, duong 53, phuong Binh Thuan, Quan 7','So 38, duong 53, phuong Binh Thuan, Quan 7','Ho Chi Minh','','VN','08','0983601705','','thuy_linh5589@yahoo.com','','','','en','2014-11-20 15:45:44','0000-00-00 00:00:00','116.100.179.196','',1,'0000-00-00 00:00:00',0,0,1,0,'','');
INSERT INTO `aphs_customers` VALUES (18,0,'nhan','nguyen','1981-03-04','','166/11','','ho chi minh','','VN','70000','0902763955','','nnhansg@gmail.com','','','','en','2014-11-25 15:41:10','0000-00-00 00:00:00','116.100.204.214','',1,'0000-00-00 00:00:00',0,0,1,0,'','');
INSERT INTO `aphs_customers` VALUES (19,0,'ndddf','eeeer','1924-01-01','','eerrr','','deefgg','','US','00000','ee4444rr','','hieusaigon1@gmail.com','','','','en','2014-12-02 18:22:54','0000-00-00 00:00:00','116.100.204.214','',1,'0000-00-00 00:00:00',0,0,1,0,'','');
/*!40000 ALTER TABLE `aphs_customers` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_email_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_email_templates` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` varchar(2) CHARACTER SET latin1 NOT NULL,
  `template_code` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `template_name` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `template_subject` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `template_content` text COLLATE utf8_unicode_ci NOT NULL,
  `is_system_template` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_email_templates` WRITE;
/*!40000 ALTER TABLE `aphs_email_templates` DISABLE KEYS */;
INSERT INTO `aphs_email_templates` VALUES (1,'en','new_account_created','Email for new customer','Your account has been created','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on creating your new account.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYou login: {USER NAME}\r\nYou password: {USER PASSWORD}\r\n\r\nYou may follow the link below to log into your account:\r\n<a href=\"{BASE URL}index.php?customer=login\">Login</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (4,'en','new_account_created_confirm_by_admin','Email for new user (admin approval required)','Your account has been created (approval required)','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on creating your new account.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYour login: {USER NAME}\r\nYour password: {USER PASSWORD}\r\n\r\nAfter your registration will be approved by administrator,  you could log into your account with a following link:\r\n<a href=\"{BASE URL}index.php?customer=login\">Login</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (95,'ru','test_template','Testing Email','Testing Email','Hello <b>{USER NAME}</b>!\r\n\r\nThis a testing email.\r\n\r\nBest regards,\r\n{WEB SITE}',0);
INSERT INTO `aphs_email_templates` VALUES (77,'ru','new_account_created','Email for new customer','Your account has been created','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on creating your new account.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYou login: {USER NAME}\r\nYou password: {USER PASSWORD}\r\n\r\nYou may follow the link below to log into your account:\r\n<a href=\"{BASE URL}index.php?customer=login\">Login</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (78,'ru','new_account_created_confirm_by_admin','Email for new user (admin approval required)','Your account has been created (approval required)','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on creating your new account.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYour login: {USER NAME}\r\nYour password: {USER PASSWORD}\r\n\r\nAfter your registration will be approved by administrator,  you could log into your account with a following link:\r\n<a href=\"{BASE URL}index.php?customer=login\">Login</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (7,'en','new_account_created_confirm_by_email','Email for new user (email confirmation required)','Your account has been created (confirmation required)','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on creating your new account.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYour login: {USER NAME}\r\nYour password: {USER PASSWORD}\r\n\r\nIn order to become authorized member, you will need to confirm your registration. You may follow the link below to access the confirmation page:\r\n<a href=\"{BASE URL}index.php?customer=confirm_registration&c={REGISTRATION CODE}\">Confirm Registration</a>\r\n\r\nP.S. Remember, we will never sell your personal information or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (93,'ru','unsubscription_from_newsletter','Newsletter - member has unsubscribed (member copy)','You have been unsubscribed from the Newsletter','Hello!\r\n\r\nYou are receiving this email because you, or someone using this email address, unsubscribed from the Newsletter of {WEB SITE}\r\n\r\nYou can always restore your subscription, using the link below: <a href=\"{BASE URL}index.php?page=newsletter&task=pre_subscribe&email={USER EMAIL}\">Subscribe</a>\r\n\r\n-\r\nBest Regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (94,'ru','reservation_expired','Reservation has been expired','Your reservation has been expired!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nYour order reservation has been expired.\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please feel free to contact us if you have any questions.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (74,'vi','unsubscription_from_newsletter','Newsletter - member has unsubscribed (member copy)','You have been unsubscribed from the Newsletter','Hello!\r\n\r\nYou are receiving this email because you, or someone using this email address, unsubscribed from the Newsletter of {WEB SITE}\r\n\r\nYou can always restore your subscription, using the link below: <a href=\"{BASE URL}index.php?page=newsletter&task=pre_subscribe&email={USER EMAIL}\">Subscribe</a>\r\n\r\n-\r\nBest Regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (75,'vi','reservation_expired','Reservation has been expired','Your reservation has been expired!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nYour order reservation has been expired.\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please feel free to contact us if you have any questions.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (76,'vi','test_template','Testing Email','Testing Email','Hello <b>{USER NAME}</b>!\r\n\r\nThis a testing email.\r\n\r\nBest regards,\r\n{WEB SITE}',0);
INSERT INTO `aphs_email_templates` VALUES (10,'en','new_account_created_by_admin','Email for new user (account created by admin)','Your account has been created by admin','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nOur administrator just created a new account for you.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYou login: {USER NAME}\r\nYou password: {USER PASSWORD}\r\n\r\nYou may follow the link below to log into your account:\r\n<a href=\"{BASE URL}index.php?customer=login\">Login</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (91,'ru','payment_error','Customer payment has been failed for some reason','Your payment has been failed','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThe payment for your booking {BOOKING NUMBER} has been failed. The reason was: {STATUS DESCRIPTION}\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please feel free to contact us if you have any questions.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (92,'ru','subscription_to_newsletter','Newsletter - new member has subscribed (member copy)','You have been subscribed to the Newsletter','Hello!\r\n\r\nYou are receiving this email because you, or someone using this email address, subscribed to the Newsletter of {WEB SITE}\r\n\r\nIf you do not wish to receive such emails in the future, please click this link: <a href=\"{BASE URL}index.php?page=newsletter&task=pre_unsubscribe&email={USER EMAIL}\">Unsubscribe</a>\r\n\r\n-\r\nBest Regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (73,'vi','subscription_to_newsletter','Newsletter - new member has subscribed (member copy)','You have been subscribed to the Newsletter','Hello!\r\n\r\nYou are receiving this email because you, or someone using this email address, subscribed to the Newsletter of {WEB SITE}\r\n\r\nIf you do not wish to receive such emails in the future, please click this link: <a href=\"{BASE URL}index.php?page=newsletter&task=pre_unsubscribe&email={USER EMAIL}\">Unsubscribe</a>\r\n\r\n-\r\nBest Regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (71,'vi','order_canceled','Reservation has been canceled by Customer/Administrator','Your order has been canceled!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nYour order {BOOKING NUMBER} has been canceled.\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please feel free to contact us if you have any questions.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (72,'vi','payment_error','Customer payment has been failed for some reason','Your payment has been failed','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThe payment for your booking {BOOKING NUMBER} has been failed. The reason was: {STATUS DESCRIPTION}\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please feel free to contact us if you have any questions.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (14,'en','new_account_created_notify_admin','New account has been created (notify admin)','New account has been created','Hello Admin!\r\n\r\nA new user has been registered at your site.\r\nThis email contains a user account details:\r\n\r\nName: {FIRST NAME} {LAST NAME}\r\nEmail: {USER EMAIL}\r\nUsername: {USER NAME}\r\n\r\nP.S. Please check if it doesn\'t require your approval for activation',1);
INSERT INTO `aphs_email_templates` VALUES (90,'ru','order_canceled','Reservation has been canceled by Customer/Administrator','Your order has been canceled!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nYour order {BOOKING NUMBER} has been canceled.\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please feel free to contact us if you have any questions.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (16,'en','password_forgotten','Email for customer or admin forgotten password','Forgotten Password','Hello <b>{USER NAME}</b>!\r\n\r\nYou or someone else asked for your login info on our site:\r\n{WEB SITE}\r\n\r\nYour Login Info:\r\n\r\nUsername: {USER NAME}\r\nPassword: {USER PASSWORD}\r\n\r\n\r\nBest regards,\r\n{WEB SITE}',1);
INSERT INTO `aphs_email_templates` VALUES (89,'ru','events_new_registration','Events - new member has registered (member copy)','You have been successfully registered to the event!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on registering to {EVENT}.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need.\r\n\r\n-\r\nBest Regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (19,'en','password_changed_by_admin','Password changed by admin','Your password has been changed','Hello <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nYour password was changed by administrator of the site:\r\n{WEB SITE}\r\n\r\nHere your new login info:\r\n-\r\nUsername: {USER NAME} \r\nPassword: {USER PASSWORD}\r\n\r\n-\r\nBest regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (70,'vi','events_new_registration','Events - new member has registered (member copy)','You have been successfully registered to the event!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on registering to {EVENT}.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need.\r\n\r\n-\r\nBest Regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (22,'en','registration_approved_by_admin','Email for new customer (registration was approved by admin)','Your registration has been approved','Dear <b>{FIRST NAME} {LAST NAME}!</b>\r\n\r\nCongratulations! This e-mail is to confirm that your registration at {WEB SITE} has been approved.\r\n\r\nYou can now login in to your account now.\r\n\r\nThank you for choosing {WEB SITE}.\r\n-\r\nSincerely,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (88,'ru','order_paid','Email for orders paid via payment processing systems','Your order {BOOKING NUMBER} has been paid and received by the system!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThank you for reservation!\r\n\r\nYour order {BOOKING NUMBER} has been completed!\r\n\r\n{BOOKING DETAILS}\r\n\r\n{PERSONAL INFORMATION}\r\n\r\n{BILLING INFORMATION}\r\n\r\nP.S. Please keep this email for your records, as it contains an important information that you may need.\r\nP.P.S You may always check your booking status here:\r\n<a href=\"{BASE URL}index.php?page=check_status\">Check Status</a>\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (69,'vi','order_paid','Email for orders paid via payment processing systems','Your order {BOOKING NUMBER} has been paid and received by the system!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThank you for reservation!\r\n\r\nYour order {BOOKING NUMBER} has been completed!\r\n\r\n{BOOKING DETAILS}\r\n\r\n{PERSONAL INFORMATION}\r\n\r\n{BILLING INFORMATION}\r\n\r\nP.S. Please keep this email for your records, as it contains an important information that you may need.\r\nP.P.S You may always check your booking status here:\r\n<a href=\"{BASE URL}index.php?page=check_status\">Check Status</a>\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (25,'en','account_deleted_by_user','Account removed email (by customer)','Your account has been removed','Dear {USER NAME}!\r\n\r\nYour account was removed.\r\n\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (87,'ru','order_placed_online','Email for online placed orders (not paid yet)','Your order has been placed in our system!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThank you for reservation request!\r\n\r\nYour order {BOOKING NUMBER} has been placed in our system and will be processed shortly.\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please keep this email for your records, as it contains an important information that you may\r\nneed.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (68,'vi','order_placed_online','Email for online placed orders (not paid yet)','Your order has been placed in our system!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThank you for reservation request!\r\n\r\nYour order {BOOKING NUMBER} has been placed in our system and will be processed shortly.\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please keep this email for your records, as it contains an important information that you may\r\nneed.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (65,'vi','registration_approved_by_admin','Email for new customer (registration was approved by admin)','Your registration has been approved','Dear <b>{FIRST NAME} {LAST NAME}!</b>\r\n\r\nCongratulations! This e-mail is to confirm that your registration at {WEB SITE} has been approved.\r\n\r\nYou can now login in to your account now.\r\n\r\nThank you for choosing {WEB SITE}.\r\n-\r\nSincerely,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (66,'vi','account_deleted_by_user','Account removed email (by customer)','Your account has been removed','Dear {USER NAME}!\r\n\r\nYour account was removed.\r\n\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (67,'vi','new_account_created_without','Email for new/returned customer (without account)','Your contact information has been accepted','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThank you for sending us your contact information. You may now complete your booking - just follow the instructions on the checkout page.\r\n\r\nPlease remember that even you don\'t have account on our site, you may always create it with easily. To do it simply follow this link and enter all needed information to create a new account: <a href=\"{BASE URL}index.php?customer=create_account\">Create Account</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (30,'en','new_account_created_without','Email for new/returned customer (without account)','Your contact information has been accepted','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThank you for sending us your contact information. You may now complete your booking - just follow the instructions on the checkout page.\r\n\r\nPlease remember that even you don\'t have account on our site, you may always create it with easily. To do it simply follow this link and enter all needed information to create a new account: <a href=\"{BASE URL}index.php?customer=create_account\">Create Account</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (31,'en','order_placed_online','Email for online placed orders (not paid yet)','Your order has been placed in our system!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThank you for reservation request!\r\n\r\nYour order {BOOKING NUMBER} has been placed in our system and will be processed shortly.\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please keep this email for your records, as it contains an important information that you may\r\nneed.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (64,'vi','password_changed_by_admin','Password changed by admin','Your password has been changed','Hello <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nYour password was changed by administrator of the site:\r\n{WEB SITE}\r\n\r\nHere your new login info:\r\n-\r\nUsername: {USER NAME} \r\nPassword: {USER PASSWORD}\r\n\r\n-\r\nBest regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (34,'en','order_paid','Email for orders paid via payment processing systems','Your order {BOOKING NUMBER} has been paid and received by the system!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThank you for reservation!\r\n\r\nYour order {BOOKING NUMBER} has been completed!\r\n\r\n{BOOKING DETAILS}\r\n\r\n{PERSONAL INFORMATION}\r\n\r\n{BILLING INFORMATION}\r\n\r\nP.S. Please keep this email for your records, as it contains an important information that you may need.\r\nP.P.S You may always check your booking status here:\r\n<a href=\"{BASE URL}index.php?page=check_status\">Check Status</a>\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (85,'ru','account_deleted_by_user','Account removed email (by customer)','Your account has been removed','Dear {USER NAME}!\r\n\r\nYour account was removed.\r\n\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (86,'ru','new_account_created_without','Email for new/returned customer (without account)','Your contact information has been accepted','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThank you for sending us your contact information. You may now complete your booking - just follow the instructions on the checkout page.\r\n\r\nPlease remember that even you don\'t have account on our site, you may always create it with easily. To do it simply follow this link and enter all needed information to create a new account: <a href=\"{BASE URL}index.php?customer=create_account\">Create Account</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (62,'vi','new_account_created_notify_admin','New account has been created (notify admin)','New account has been created','Hello Admin!\r\n\r\nA new user has been registered at your site.\r\nThis email contains a user account details:\r\n\r\nName: {FIRST NAME} {LAST NAME}\r\nEmail: {USER EMAIL}\r\nUsername: {USER NAME}\r\n\r\nP.S. Please check if it doesn\'t require your approval for activation',1);
INSERT INTO `aphs_email_templates` VALUES (63,'vi','password_forgotten','Email for customer or admin forgotten password','Forgotten Password','Hello <b>{USER NAME}</b>!\r\n\r\nYou or someone else asked for your login info on our site:\r\n{WEB SITE}\r\n\r\nYour Login Info:\r\n\r\nUsername: {USER NAME}\r\nPassword: {USER PASSWORD}\r\n\r\n\r\nBest regards,\r\n{WEB SITE}',1);
INSERT INTO `aphs_email_templates` VALUES (37,'en','events_new_registration','Events - new member has registered (member copy)','You have been successfully registered to the event!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on registering to {EVENT}.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need.\r\n\r\n-\r\nBest Regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (84,'ru','registration_approved_by_admin','Email for new customer (registration was approved by admin)','Your registration has been approved','Dear <b>{FIRST NAME} {LAST NAME}!</b>\r\n\r\nCongratulations! This e-mail is to confirm that your registration at {WEB SITE} has been approved.\r\n\r\nYou can now login in to your account now.\r\n\r\nThank you for choosing {WEB SITE}.\r\n-\r\nSincerely,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (61,'vi','new_account_created_by_admin','Email for new user (account created by admin)','Your account has been created by admin','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nOur administrator just created a new account for you.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYou login: {USER NAME}\r\nYou password: {USER PASSWORD}\r\n\r\nYou may follow the link below to log into your account:\r\n<a href=\"{BASE URL}index.php?customer=login\">Login</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (40,'en','order_canceled','Reservation has been canceled by Customer/Administrator','Your order has been canceled!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nYour order {BOOKING NUMBER} has been canceled.\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please feel free to contact us if you have any questions.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (83,'ru','password_changed_by_admin','Password changed by admin','Your password has been changed','Hello <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nYour password was changed by administrator of the site:\r\n{WEB SITE}\r\n\r\nHere your new login info:\r\n-\r\nUsername: {USER NAME} \r\nPassword: {USER PASSWORD}\r\n\r\n-\r\nBest regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (43,'en','payment_error','Customer payment has been failed for some reason','Your payment has been failed','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nThe payment for your booking {BOOKING NUMBER} has been failed. The reason was: {STATUS DESCRIPTION}\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please feel free to contact us if you have any questions.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (82,'ru','password_forgotten','Email for customer or admin forgotten password','Forgotten Password','Hello <b>{USER NAME}</b>!\r\n\r\nYou or someone else asked for your login info on our site:\r\n{WEB SITE}\r\n\r\nYour Login Info:\r\n\r\nUsername: {USER NAME}\r\nPassword: {USER PASSWORD}\r\n\r\n\r\nBest regards,\r\n{WEB SITE}',1);
INSERT INTO `aphs_email_templates` VALUES (46,'en','subscription_to_newsletter','Newsletter - new member has subscribed (member copy)','You have been subscribed to the Newsletter','Hello!\r\n\r\nYou are receiving this email because you, or someone using this email address, subscribed to the Newsletter of {WEB SITE}\r\n\r\nIf you do not wish to receive such emails in the future, please click this link: <a href=\"{BASE URL}index.php?page=newsletter&task=pre_unsubscribe&email={USER EMAIL}\">Unsubscribe</a>\r\n\r\n-\r\nBest Regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (81,'ru','new_account_created_notify_admin','New account has been created (notify admin)','New account has been created','Hello Admin!\r\n\r\nA new user has been registered at your site.\r\nThis email contains a user account details:\r\n\r\nName: {FIRST NAME} {LAST NAME}\r\nEmail: {USER EMAIL}\r\nUsername: {USER NAME}\r\n\r\nP.S. Please check if it doesn\'t require your approval for activation',1);
INSERT INTO `aphs_email_templates` VALUES (60,'vi','new_account_created_confirm_by_email','Email for new user (email confirmation required)','Your account has been created (confirmation required)','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on creating your new account.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYour login: {USER NAME}\r\nYour password: {USER PASSWORD}\r\n\r\nIn order to become authorized member, you will need to confirm your registration. You may follow the link below to access the confirmation page:\r\n<a href=\"{BASE URL}index.php?customer=confirm_registration&c={REGISTRATION CODE}\">Confirm Registration</a>\r\n\r\nP.S. Remember, we will never sell your personal information or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (49,'en','unsubscription_from_newsletter','Newsletter - member has unsubscribed (member copy)','You have been unsubscribed from the Newsletter','Hello!\r\n\r\nYou are receiving this email because you, or someone using this email address, unsubscribed from the Newsletter of {WEB SITE}\r\n\r\nYou can always restore your subscription, using the link below: <a href=\"{BASE URL}index.php?page=newsletter&task=pre_subscribe&email={USER EMAIL}\">Subscribe</a>\r\n\r\n-\r\nBest Regards,\r\nAdministration',1);
INSERT INTO `aphs_email_templates` VALUES (80,'ru','new_account_created_by_admin','Email for new user (account created by admin)','Your account has been created by admin','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nOur administrator just created a new account for you.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYou login: {USER NAME}\r\nYou password: {USER PASSWORD}\r\n\r\nYou may follow the link below to log into your account:\r\n<a href=\"{BASE URL}index.php?customer=login\">Login</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (59,'vi','new_account_created_confirm_by_admin','Email for new user (admin approval required)','Your account has been created (approval required)','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on creating your new account.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYour login: {USER NAME}\r\nYour password: {USER PASSWORD}\r\n\r\nAfter your registration will be approved by administrator,  you could log into your account with a following link:\r\n<a href=\"{BASE URL}index.php?customer=login\">Login</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (52,'en','reservation_expired','Reservation has been expired','Your reservation has been expired!','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nYour order reservation has been expired.\r\n\r\n{BOOKING DETAILS}\r\n\r\nP.S. Please feel free to contact us if you have any questions.\r\n\r\n-\r\nSincerely,\r\nCustomer Support\r\n\r\n{HOTEL INFO}',1);
INSERT INTO `aphs_email_templates` VALUES (55,'en','test_template','Testing Email','Testing Email','Hello <b>{USER NAME}</b>!\r\n\r\nThis a testing email.\r\n\r\nBest regards,\r\n{WEB SITE}',0);
INSERT INTO `aphs_email_templates` VALUES (79,'ru','new_account_created_confirm_by_email','Email for new user (email confirmation required)','Your account has been created (confirmation required)','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on creating your new account.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYour login: {USER NAME}\r\nYour password: {USER PASSWORD}\r\n\r\nIn order to become authorized member, you will need to confirm your registration. You may follow the link below to access the confirmation page:\r\n<a href=\"{BASE URL}index.php?customer=confirm_registration&c={REGISTRATION CODE}\">Confirm Registration</a>\r\n\r\nP.S. Remember, we will never sell your personal information or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
INSERT INTO `aphs_email_templates` VALUES (58,'vi','new_account_created','Email for new customer','Your account has been created','Dear <b>{FIRST NAME} {LAST NAME}</b>!\r\n\r\nCongratulations on creating your new account.\r\n\r\nPlease keep this email for your records, as it contains an important information that you may need, should you ever encounter problems or forget your password.\r\n\r\nYou login: {USER NAME}\r\nYou password: {USER PASSWORD}\r\n\r\nYou may follow the link below to log into your account:\r\n<a href=\"{BASE URL}index.php?customer=login\">Login</a>\r\n\r\nP.S. Remember, we will never sell your name or email address.\r\n\r\nEnjoy!\r\n-\r\nSincerely,\r\nCustomer Support',1);
/*!40000 ALTER TABLE `aphs_email_templates` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_events_registered`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_events_registered` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL DEFAULT '0',
  `first_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `date_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_events_registered` WRITE;
/*!40000 ALTER TABLE `aphs_events_registered` DISABLE KEYS */;
/*!40000 ALTER TABLE `aphs_events_registered` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_extras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_extras` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `maximum_count` smallint(6) unsigned NOT NULL DEFAULT '0',
  `priority_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_extras` WRITE;
/*!40000 ALTER TABLE `aphs_extras` DISABLE KEYS */;
INSERT INTO `aphs_extras` VALUES (1,0.00,1,3,1);
INSERT INTO `aphs_extras` VALUES (2,2940000.00,15,0,1);
/*!40000 ALTER TABLE `aphs_extras` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_extras_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_extras_description` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `extra_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_extras_description` WRITE;
/*!40000 ALTER TABLE `aphs_extras_description` DISABLE KEYS */;
INSERT INTO `aphs_extras_description` VALUES (1,1,'en','Wireless Internet Access','Wireless Internet Access (24 hour period)	');
INSERT INTO `aphs_extras_description` VALUES (2,1,'es','Acceso inalámbrico a Internet','Acceso inalámbrico a Internet (período de 24 horas)');
INSERT INTO `aphs_extras_description` VALUES (3,1,'de','WLAN','WLAN (24 Stunden)');
INSERT INTO `aphs_extras_description` VALUES (4,2,'en','Airport Pickup','Airport Pickup (1 car with 15 seaters)');
INSERT INTO `aphs_extras_description` VALUES (5,2,'es','Recogida en el aeropuerto','Recogida en el aeropuerto (1 coche con 5 plazas)');
INSERT INTO `aphs_extras_description` VALUES (6,2,'de','Abholung vom Flughafen','Abholung vom Flughafen (1 Fahrzeug mit 5-Sitzer)');
/*!40000 ALTER TABLE `aphs_extras_description` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_faq_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_faq_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `priority_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_faq_categories` WRITE;
/*!40000 ALTER TABLE `aphs_faq_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `aphs_faq_categories` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_faq_category_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_faq_category_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL DEFAULT '0',
  `faq_question` text COLLATE utf8_unicode_ci NOT NULL,
  `faq_answer` text COLLATE utf8_unicode_ci NOT NULL,
  `priority_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_faq_category_items` WRITE;
/*!40000 ALTER TABLE `aphs_faq_category_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `aphs_faq_category_items` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_gallery_album_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_gallery_album_items` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `album_code` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `item_file` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_file_thumb` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `priority_order` smallint(6) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `album_code` (`album_code`),
  KEY `priority_order` (`priority_order`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_gallery_album_items` WRITE;
/*!40000 ALTER TABLE `aphs_gallery_album_items` DISABLE KEYS */;
INSERT INTO `aphs_gallery_album_items` VALUES (1,'dkw3vvot','http://www.youtube.com/watch?v=2l_j7k5P-5I','',5,1);
INSERT INTO `aphs_gallery_album_items` VALUES (2,'afbirxww','home.jpg','home_thumb.jpg',1,1);
INSERT INTO `aphs_gallery_album_items` VALUES (3,'7u9sfhaz','img1_1.jpg','img1_1_thumb.jpg',1,1);
INSERT INTO `aphs_gallery_album_items` VALUES (4,'7u9sfhaz','img1_2.jpg','img1_2_thumb.jpg',2,1);
INSERT INTO `aphs_gallery_album_items` VALUES (5,'7u9sfhaz','img1_3.jpg','img1_3_thumb.jpg',3,1);
INSERT INTO `aphs_gallery_album_items` VALUES (6,'0bxbqgps','img2_1.jpg','img2_1_thumb.jpg',1,1);
INSERT INTO `aphs_gallery_album_items` VALUES (7,'0bxbqgps','img2_2.jpg','img2_2_thumb.jpg',2,1);
INSERT INTO `aphs_gallery_album_items` VALUES (8,'0bxbqgps','img2_3.jpg','img2_3_thumb.jpg',3,1);
INSERT INTO `aphs_gallery_album_items` VALUES (9,'6z5i5ikr','img3_1.jpg','img3_1_thumb.jpg',1,1);
INSERT INTO `aphs_gallery_album_items` VALUES (10,'6z5i5ikr','img3_2.jpg','img3_2_thumb.jpg',2,1);
INSERT INTO `aphs_gallery_album_items` VALUES (11,'6z5i5ikr','img3_3.jpg','img3_3_thumb.jpg',3,1);
INSERT INTO `aphs_gallery_album_items` VALUES (12,'gvgbrtmc','img4_1.jpg','img4_1_thumb.jpg',1,1);
INSERT INTO `aphs_gallery_album_items` VALUES (13,'gvgbrtmc','img4_2.jpg','img4_2_thumb.jpg',2,1);
INSERT INTO `aphs_gallery_album_items` VALUES (14,'gvgbrtmc','img4_3.jpg','img4_3_thumb.jpg',3,1);
/*!40000 ALTER TABLE `aphs_gallery_album_items` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_gallery_album_items_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_gallery_album_items_description` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gallery_album_item_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album_code` (`gallery_album_item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_gallery_album_items_description` WRITE;
/*!40000 ALTER TABLE `aphs_gallery_album_items_description` DISABLE KEYS */;
INSERT INTO `aphs_gallery_album_items_description` VALUES (2,1,'en','My Hotel Video','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (55,13,'vi','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (5,2,'en','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (54,12,'vi','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (7,3,'en','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (62,6,'ru','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (53,11,'vi','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (10,4,'en','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (52,10,'vi','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (13,5,'en','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (61,5,'ru','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (51,9,'vi','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (16,6,'en','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (50,8,'vi','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (19,7,'en','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (60,4,'ru','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (49,7,'vi','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (22,8,'en','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (48,6,'vi','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (25,9,'en','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (59,3,'ru','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (47,5,'vi','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (28,10,'en','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (46,4,'vi','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (31,11,'en','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (58,2,'ru','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (45,3,'vi','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (44,2,'vi','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (35,12,'en','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (37,13,'en','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (57,1,'ru','My Hotel Video','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (40,14,'en','','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (56,14,'vi','','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (43,1,'vi','My Hotel Video','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (63,7,'ru','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (64,8,'ru','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (65,9,'ru','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (66,10,'ru','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (67,11,'ru','Picture #1','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (68,12,'ru','Picture #2','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (69,13,'ru','Picture #3','');
INSERT INTO `aphs_gallery_album_items_description` VALUES (70,14,'ru','','');
/*!40000 ALTER TABLE `aphs_gallery_album_items_description` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_gallery_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_gallery_albums` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `album_code` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `album_type` enum('images','video') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'images',
  `priority_order` smallint(6) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is_active` (`is_active`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_gallery_albums` WRITE;
/*!40000 ALTER TABLE `aphs_gallery_albums` DISABLE KEYS */;
INSERT INTO `aphs_gallery_albums` VALUES (1,'afbirxww','images',1,1);
INSERT INTO `aphs_gallery_albums` VALUES (2,'dkw3vvot','video',11,1);
INSERT INTO `aphs_gallery_albums` VALUES (3,'7u9sfhaz','images',3,1);
INSERT INTO `aphs_gallery_albums` VALUES (4,'0bxbqgps','images',5,1);
INSERT INTO `aphs_gallery_albums` VALUES (5,'6z5i5ikr','images',7,1);
INSERT INTO `aphs_gallery_albums` VALUES (6,'gvgbrtmc','images',9,1);
/*!40000 ALTER TABLE `aphs_gallery_albums` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_gallery_albums_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_gallery_albums_description` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gallery_album_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_gallery_albums_description` WRITE;
/*!40000 ALTER TABLE `aphs_gallery_albums_description` DISABLE KEYS */;
INSERT INTO `aphs_gallery_albums_description` VALUES (29,5,'ru','Superior Rooms','Superior Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (2,1,'en','General Images','General Images');
INSERT INTO `aphs_gallery_albums_description` VALUES (23,5,'vi','Superior Rooms','Superior Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (4,2,'en','General Video','General Video');
INSERT INTO `aphs_gallery_albums_description` VALUES (28,4,'ru','Double Rooms','Double Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (22,4,'vi','Double Rooms','Double Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (7,3,'en','Single Rooms','Single Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (27,3,'ru','Single Rooms','Single Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (21,3,'vi','Single Rooms','Single Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (10,4,'en','Double Rooms','Double Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (26,2,'ru','General Video','General Video');
INSERT INTO `aphs_gallery_albums_description` VALUES (20,2,'vi','General Video','General Video');
INSERT INTO `aphs_gallery_albums_description` VALUES (13,5,'en','Superior Rooms','Superior Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (25,1,'ru','General Images','General Images');
INSERT INTO `aphs_gallery_albums_description` VALUES (16,6,'en','Luxury Rooms','Luxury Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (24,6,'vi','Luxury Rooms','Luxury Rooms');
INSERT INTO `aphs_gallery_albums_description` VALUES (19,1,'vi','General Images','General Images');
INSERT INTO `aphs_gallery_albums_description` VALUES (30,6,'ru','Luxury Rooms','Luxury Rooms');
/*!40000 ALTER TABLE `aphs_gallery_albums_description` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_hotels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_hotels` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `hotel_location_id` int(10) unsigned NOT NULL DEFAULT '0',
  `phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `time_zone` varchar(5) CHARACTER SET latin1 NOT NULL,
  `map_code` text COLLATE utf8_unicode_ci NOT NULL,
  `hotel_image` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `hotel_image_thumb` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `stars` tinyint(1) unsigned NOT NULL DEFAULT '3',
  `priority_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `hotel_location_id` (`hotel_location_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_hotels` WRITE;
/*!40000 ALTER TABLE `aphs_hotels` DISABLE KEYS */;
INSERT INTO `aphs_hotels` VALUES (4,2,'+84 62 3847 007','+84 62 3847 007','dunglangtre@gmail.com','7','http://www.agoda.com/pages/agoda/popup/popup_areamap.aspx?hotel_id=11008&area_id=502082&area_Name=Mui+Ne&city_id=16264&city_Name=Phan+Thiet&country_id=38&latitude=108.198895454407&longitude=10.9454263559363&PopupSize=80&asq=orevQbn5rAsmulNx9MhL7b9nboXq34sA76uJzZp9Ng%2b0ccMpAEY4Pn47oh2pyZBfhnmIbjETPLTMBsNbnI9vn5cL03m6GbxP5biMsn6qfPI%3d&width=990&height=525','hotel-bamboo-village.jpg','hotel-bamboo-village_thumb.jpg',4,0,1,1);
/*!40000 ALTER TABLE `aphs_hotels` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_hotels_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_hotels_description` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `hotel_id` smallint(6) unsigned NOT NULL DEFAULT '1',
  `language_id` varchar(2) CHARACTER SET latin1 NOT NULL DEFAULT 'en',
  `name` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hotel_id` (`hotel_id`,`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_hotels_description` WRITE;
/*!40000 ALTER TABLE `aphs_hotels_description` DISABLE KEYS */;
INSERT INTO `aphs_hotels_description` VALUES (16,4,'en','Bamboo Village - Beach Resort & Spa','38 Nguyen Dinh Chieu Street, Ham Tien Ward, Binh Thuan Province , Mui Ne, Phan Thiet, Vietnam','<p><span id=\"hotelDescription\" class=\"show\">Located few hours away from Ho  Chi Minh’s International Airport, an accommodation is to be found where  you can relax and unwind and discover the authentic charms of Vietnam.  Bamboo Village Beach Resort offers 143 luxury rooms and bungalows form a  seaside village where real tropical warmth can be shared while guests\'  intimacy maintained. <br /><br /> The  sunlit beach that washes away your  concerns, lush landscape that exemplifies nature, smiling staff that  caters to your every need, quality food that satisfies the most  demanding taste buds, energizing yoga courses and relaxing spa treatment  that refreshing your health, and a sustainable operation that runs  environmentally friendly.<br /><br /> Bamboo Village Beach Resort also  provide two sunlit swimming pools and flowery gardens all around the  resort, Bamboo Village does offer an enticing rest &amp; relax  experience.</span></p>');
INSERT INTO `aphs_hotels_description` VALUES (18,4,'vi','Bamboo Village - Beach Resort & Spa','tiếng việt 38 Nguyen Dinh Chieu Street, Ham Tien Ward, Binh Thuan Province , Mui Ne, Phan Thiet, Vietnam','<p><span id=\"hotelDescription\" class=\"show\">tiếng việt </span></p>\r\n<p><span id=\"hotelDescription\" class=\"show\">Located few hours away from Ho  Chi Minh’s International Airport, an accommodation is to be found where  you can relax and unwind and discover the authentic charms of Vietnam.  Bamboo Village Beach Resort offers 143 luxury rooms and bungalows form a  seaside village where real tropical warmth can be shared while guests\'  intimacy maintained. <br /><br /> The  sunlit beach that washes away your  concerns, lush landscape that exemplifies nature, smiling staff that  caters to your every need, quality food that satisfies the most  demanding taste buds, energizing yoga courses and relaxing spa treatment  that refreshing your health, and a sustainable operation that runs  environmentally friendly.<br /><br /> Bamboo Village Beach Resort also  provide two sunlit swimming pools and flowery gardens all around the  resort, Bamboo Village does offer an enticing rest &amp; relax  experience.</span></p>');
/*!40000 ALTER TABLE `aphs_hotels_description` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_hotels_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_hotels_locations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `priority_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_hotels_locations` WRITE;
/*!40000 ALTER TABLE `aphs_hotels_locations` DISABLE KEYS */;
INSERT INTO `aphs_hotels_locations` VALUES (2,'VN',0,1);
/*!40000 ALTER TABLE `aphs_hotels_locations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_hotels_locations_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_hotels_locations_description` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hotel_location_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hotel_location_id` (`hotel_location_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_hotels_locations_description` WRITE;
/*!40000 ALTER TABLE `aphs_hotels_locations_description` DISABLE KEYS */;
INSERT INTO `aphs_hotels_locations_description` VALUES (13,2,'ru','Vietnam');
INSERT INTO `aphs_hotels_locations_description` VALUES (11,2,'vi','Vietnam');
INSERT INTO `aphs_hotels_locations_description` VALUES (3,10,'en','Ronston');
INSERT INTO `aphs_hotels_locations_description` VALUES (4,2,'en','Vietnam');
INSERT INTO `aphs_hotels_locations_description` VALUES (12,10,'ru','Ronston');
INSERT INTO `aphs_hotels_locations_description` VALUES (10,10,'vi','Ronston');
/*!40000 ALTER TABLE `aphs_hotels_locations_description` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_languages` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lang_name_en` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `abbreviation` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `lc_time_name` varchar(5) CHARACTER SET latin1 NOT NULL DEFAULT 'en_US',
  `lang_dir` varchar(3) CHARACTER SET latin1 NOT NULL DEFAULT 'ltr',
  `icon_image` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `priority_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `used_on` enum('front-end','back-end','global') CHARACTER SET latin1 NOT NULL DEFAULT 'global',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_languages` WRITE;
/*!40000 ALTER TABLE `aphs_languages` DISABLE KEYS */;
INSERT INTO `aphs_languages` VALUES (1,'English','English','en','en_US','ltr','en.gif',1,'global',1,1);
INSERT INTO `aphs_languages` VALUES (4,'Tiếng Việt','Vietnamese','vi','vi_VN','ltr','flag_vi.gif',2,'global',0,1);
INSERT INTO `aphs_languages` VALUES (5,'Русский','Russian','ru','ru_RU','ltr','flag_ru.gif',3,'global',0,0);
/*!40000 ALTER TABLE `aphs_languages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_meal_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_meal_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `charge_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Per person per night',
  `priority_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_meal_plans` WRITE;
/*!40000 ALTER TABLE `aphs_meal_plans` DISABLE KEYS */;
INSERT INTO `aphs_meal_plans` VALUES (1,1,0.00,0,0,1,1);
INSERT INTO `aphs_meal_plans` VALUES (2,1,10.00,0,1,1,0);
INSERT INTO `aphs_meal_plans` VALUES (3,1,22.00,0,2,1,0);
INSERT INTO `aphs_meal_plans` VALUES (8,4,378000.00,0,1,1,0);
INSERT INTO `aphs_meal_plans` VALUES (9,4,168000.00,0,1,1,0);
INSERT INTO `aphs_meal_plans` VALUES (10,4,1890000.00,0,2,1,1);
/*!40000 ALTER TABLE `aphs_meal_plans` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_meal_plans_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_meal_plans_description` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `meal_plan_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_meal_plans_description` WRITE;
/*!40000 ALTER TABLE `aphs_meal_plans_description` DISABLE KEYS */;
INSERT INTO `aphs_meal_plans_description` VALUES (1,1,'en','Breakfast (Included)','One meal supplied');
INSERT INTO `aphs_meal_plans_description` VALUES (4,2,'en','Half Board','Two meals (no lunch) supplied');
INSERT INTO `aphs_meal_plans_description` VALUES (7,3,'en','Full Board','Three meals supplied');
INSERT INTO `aphs_meal_plans_description` VALUES (11,2,'vi','Half Board','Two meals (no lunch) supplied');
INSERT INTO `aphs_meal_plans_description` VALUES (10,1,'vi','Breakfast (Included)','One meal supplied');
INSERT INTO `aphs_meal_plans_description` VALUES (12,3,'vi','Full Board','Three meals supplied');
INSERT INTO `aphs_meal_plans_description` VALUES (13,1,'ru','Breakfast (Included)','One meal supplied');
INSERT INTO `aphs_meal_plans_description` VALUES (14,2,'ru','Half Board','Two meals (no lunch) supplied');
INSERT INTO `aphs_meal_plans_description` VALUES (15,3,'ru','Full Board','Three meals supplied');
INSERT INTO `aphs_meal_plans_description` VALUES (16,8,'en','Half-board','HB- price for 1 adult, Children 1/2 price');
INSERT INTO `aphs_meal_plans_description` VALUES (17,9,'en','Breakfast for CHD','Price for BB for CHD from 5 yrs to under 12 yrs');
INSERT INTO `aphs_meal_plans_description` VALUES (18,10,'en','Compulsory GalaDiner Christmas 24.12.14 ','enjoy Gala Dinner with us on Christmas Eve for merry and joyful time. CHD charged half price of Adult');
INSERT INTO `aphs_meal_plans_description` VALUES (19,10,'vi','Compulsory GalaDiner Christmas 24.12.14 ','enjoy Gala Dinner with us on Christmas Eve for merry and joyful time. CHD charged half price of Adult');
INSERT INTO `aphs_meal_plans_description` VALUES (20,8,'vi','Half-board TV','HB- price for 1 adult, Children 1/2 price');
INSERT INTO `aphs_meal_plans_description` VALUES (21,9,'vi','Breakfast for CHD','Price for BB for CHD from 5 yrs to under 12 yrs');
/*!40000 ALTER TABLE `aphs_meal_plans_description` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_code` varchar(10) CHARACTER SET latin1 NOT NULL,
  `language_id` varchar(2) CHARACTER SET latin1 NOT NULL,
  `menu_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_placement` enum('','left','top','right','bottom','hidden') CHARACTER SET latin1 NOT NULL,
  `menu_order` tinyint(3) DEFAULT '1',
  `access_level` enum('public','registered') CHARACTER SET latin1 NOT NULL DEFAULT 'public',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_menus` WRITE;
/*!40000 ALTER TABLE `aphs_menus` DISABLE KEYS */;
INSERT INTO `aphs_menus` VALUES (1,'AMM8WBAKJ9','en','Information','left',1,'public');
INSERT INTO `aphs_menus` VALUES (8,'W7GHW72XM2','vi','Bottom','bottom',2,'public');
INSERT INTO `aphs_menus` VALUES (9,'AMM8WBAKJ9','ru','Information','left',1,'public');
INSERT INTO `aphs_menus` VALUES (7,'AMM8WBAKJ9','vi','Information','left',1,'public');
INSERT INTO `aphs_menus` VALUES (6,'W7GHW72XM2','en','Bottom','bottom',2,'public');
INSERT INTO `aphs_menus` VALUES (10,'W7GHW72XM2','ru','Bottom','bottom',2,'public');
/*!40000 ALTER TABLE `aphs_menus` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_modules` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name_const` varchar(20) CHARACTER SET latin1 NOT NULL,
  `description_const` varchar(30) CHARACTER SET latin1 NOT NULL,
  `icon_file` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `module_tables` varchar(255) CHARACTER SET latin1 NOT NULL,
  `dependent_modules` varchar(20) CHARACTER SET latin1 NOT NULL,
  `settings_page` varchar(30) CHARACTER SET latin1 NOT NULL,
  `settings_const` varchar(30) CHARACTER SET latin1 NOT NULL,
  `settings_access_by` varchar(50) CHARACTER SET latin1 NOT NULL,
  `management_page` varchar(125) CHARACTER SET latin1 NOT NULL,
  `management_const` varchar(125) CHARACTER SET latin1 NOT NULL,
  `management_access_by` varchar(50) CHARACTER SET latin1 NOT NULL,
  `is_installed` tinyint(1) NOT NULL DEFAULT '0',
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `priority_order` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_modules` WRITE;
/*!40000 ALTER TABLE `aphs_modules` DISABLE KEYS */;
INSERT INTO `aphs_modules` VALUES (1,'backup','_BACKUP_AND_RESTORE','_MD_BACKUP_AND_RESTORE','backup.png','','','mod_backup_installation','_BACKUP_INSTALLATION','owner','mod_backup_restore','_BACKUP_RESTORE','owner,mainadmin',1,0,10);
INSERT INTO `aphs_modules` VALUES (2,'news','_NEWS','_MD_NEWS','news.png','news,events_registered,news_subscribed','','mod_news_settings','_NEWS_SETTINGS','owner,mainadmin','mod_news_management,mod_news_subscribed','_NEWS_MANAGEMENT,_SUBSCRIPTION_MANAGEMENT','owner,mainadmin',1,0,6);
INSERT INTO `aphs_modules` VALUES (3,'customers','_CUSTOMERS','_MD_CUSTOMERS','customers.png','customers','','mod_customers_settings','_CUSTOMERS_SETTINGS','owner,mainadmin','','','',1,0,2);
INSERT INTO `aphs_modules` VALUES (4,'gallery','_GALLERY','_MD_GALLERY','gallery.png','gallery_albums,gallery_images','','mod_gallery_settings','_GALLERY_SETTINGS','owner,mainadmin','mod_gallery_management','_GALLERY_MANAGEMENT','owner,mainadmin',1,0,7);
INSERT INTO `aphs_modules` VALUES (5,'contact_us','_CONTACT_US','_MD_CONTACT_US','contact_us.png','','','mod_contact_us_settings','_CONTACT_US_SETTINGS','owner,mainadmin','','','',1,0,3);
INSERT INTO `aphs_modules` VALUES (6,'comments','_COMMENTS','_MD_COMMENTS','comments.png','comments','','mod_comments_settings','_COMMENTS_SETTINGS','owner,mainadmin','mod_comments_management','_COMMENTS_MANAGEMENT','owner,mainadmin',1,0,4);
INSERT INTO `aphs_modules` VALUES (7,'banners','_BANNERS','_MD_BANNERS','banners.png','banners','','mod_banners_settings','_BANNERS_SETTINGS','owner,mainadmin','mod_banners_management','_BANNERS_MANAGEMENT','owner,mainadmin',1,0,8);
INSERT INTO `aphs_modules` VALUES (8,'booking','_BOOKINGS','_MD_BOOKINGS','booking.png','bookings,bookings_rooms,extras','','mod_booking_settings','_BOOKINGS_SETTINGS','owner,mainadmin','','','',1,0,5);
INSERT INTO `aphs_modules` VALUES (9,'rooms','_ROOMS','_MD_ROOMS','rooms.png','rooms,rooms_availabilities,rooms_description,rooms_prices,room_facilities,room_facilities_description','','mod_rooms_settings','_ROOMS_SETTINGS','owner,mainadmin','mod_rooms_management','_ROOMS_MANAGEMENT','owner,mainadmin',1,1,1);
INSERT INTO `aphs_modules` VALUES (10,'pages','_PAGES','_MD_PAGES','pages.png','pages,menus','','','','owner,mainadmin','pages','_PAGE_EDIT_PAGES','owner,mainadmin',1,1,0);
INSERT INTO `aphs_modules` VALUES (11,'testimonials','_TESTIMONIALS','_MD_TESTIMONIALS','testimonials.png','testimonials','','mod_testimonials_settings','_TESTIMONIALS_SETTINGS','owner,mainadmin','mod_testimonials_management','_TESTIMONIALS_MANAGEMENT','owner,mainadmin',1,0,9);
INSERT INTO `aphs_modules` VALUES (12,'faq','_FAQ','_MD_FAQ','faq.png','faq_categories,faq_category_items','','mod_faq_settings','_FAQ_SETTINGS','owner,mainadmin','mod_faq_management','_FAQ_MANAGEMENT','owner,mainadmin',1,0,10);
/*!40000 ALTER TABLE `aphs_modules` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_modules_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_modules_settings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(20) CHARACTER SET latin1 NOT NULL,
  `settings_key` varchar(40) CHARACTER SET latin1 NOT NULL,
  `settings_value` text COLLATE utf8_unicode_ci NOT NULL,
  `settings_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `settings_description_const` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `key_display_type` enum('string','email','numeric','unsigned float','integer','positive integer','unsigned integer','enum','yes/no','html size','text') CHARACTER SET latin1 NOT NULL,
  `key_is_required` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `key_display_source` varchar(255) CHARACTER SET latin1 NOT NULL COMMENT 'for ''enum'' field type',
  PRIMARY KEY (`id`),
  KEY `module_name` (`module_name`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_modules_settings` WRITE;
/*!40000 ALTER TABLE `aphs_modules_settings` DISABLE KEYS */;
INSERT INTO `aphs_modules_settings` VALUES (1,'banners','is_active','yes','Activate Banners','_MS_BANNERS_IS_ACTIVE','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (2,'banners','rotation_type','slide show','Rotation Type','_MS_ROTATION_TYPE','enum',1,'random image,slide show');
INSERT INTO `aphs_modules_settings` VALUES (3,'banners','rotate_delay','9','Rotation Delay','_MS_ROTATE_DELAY','positive integer',1,'');
INSERT INTO `aphs_modules_settings` VALUES (4,'banners','slideshow_caption_html','no','HTML in Slideshow Caption','_MS_BANNERS_CAPTION_HTML','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (5,'booking','is_active','global','Activate Bookings','_MS_ACTIVATE_BOOKINGS','enum',1,'front-end,back-end,global,no');
INSERT INTO `aphs_modules_settings` VALUES (6,'booking','payment_type_poa','yes','&#8226; \'POA\' Payment Type','_MS_PAYMENT_TYPE_POA','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (7,'booking','payment_type_online','yes','&#8226; \'On-line Order\' Payment Type','_MS_PAYMENT_TYPE_ONLINE','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (8,'booking','online_credit_card_required','yes','&nbsp; Credit Cards for \'On-line Orders\'','_MS_ONLINE_CREDIT_CARD_REQUIRED','yes/no',0,'');
INSERT INTO `aphs_modules_settings` VALUES (9,'booking','payment_type_bank_transfer','yes','&#8226; \'Bank Transfer\' Payment Type','_MS_PAYMENT_TYPE_BANK_TRANSFER','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (10,'booking','bank_transfer_info','Bank name: {BANK NAME HERE}\r\nSwift code: {CODE HERE}\r\nRouting in Transit# or ABA#: {ROUTING HERE}\r\nAccount number *: {ACCOUNT NUMBER HERE}\r\n\r\n*The account number must be in the IBAN format which may be obtained from the branch handling the customer\'s account or may be seen at the top the customer\'s bank statement\r\n','&nbsp; Bank Transfer Info','_MS_BANK_TRANSFER_INFO','text',0,'');
INSERT INTO `aphs_modules_settings` VALUES (11,'booking','payment_type_paypal','yes','&#8226; PayPal Payment Type','_MS_PAYMENT_TYPE_PAYPAL','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (12,'booking','paypal_email','paypal@yourdomain.com','&nbsp; PayPal Email','_MS_PAYPAL_EMAIL','email',1,'');
INSERT INTO `aphs_modules_settings` VALUES (13,'booking','payment_type_2co','yes','&#8226; 2CO Payment Type','_MS_PAYMENT_TYPE_2CO','yes/no',0,'');
INSERT INTO `aphs_modules_settings` VALUES (14,'booking','two_checkout_vendor','Your 2CO Vendor ID here','&nbsp; 2CO Vendor ID','_MS_TWO_CHECKOUT_VENDOR','string',1,'');
INSERT INTO `aphs_modules_settings` VALUES (15,'booking','payment_type_authorize','yes','&#8226; Authorize.Net Payment Type','_MS_PAYMENT_TYPE_AUTHORIZE','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (16,'booking','authorize_login_id','Your API Login ID here','&nbsp; Authorize.Net Login ID','_MS_AUTHORIZE_LOGIN_ID','string',1,'');
INSERT INTO `aphs_modules_settings` VALUES (17,'booking','authorize_transaction_key','Your Transaction Key here','&nbsp; Authorize.Net Transaction Key','_MS_AUTHORIZE_TRANSACTION_KEY','string',1,'');
INSERT INTO `aphs_modules_settings` VALUES (18,'booking','default_payment_system','paypal','Default Payment System','_MS_DEFAULT_PAYMENT_SYSTEM','enum',1,'poa,online,bank transfer,paypal,2co,authorize.net');
INSERT INTO `aphs_modules_settings` VALUES (19,'booking','send_order_copy_to_admin','yes','Admin Copy of Order','_MS_SEND_ORDER_COPY_TO_ADMIN','yes/no',0,'');
INSERT INTO `aphs_modules_settings` VALUES (20,'booking','allow_booking_without_account','yes','Allow Booking Without Account','_MS_ALLOW_BOOKING_WITHOUT_ACCOUNT','yes/no',0,'');
INSERT INTO `aphs_modules_settings` VALUES (21,'booking','pre_payment_type','first night','Pre-Payment Type','_MS_PRE_PAYMENT_TYPE','enum',1,'full price,first night,fixed sum,percentage');
INSERT INTO `aphs_modules_settings` VALUES (22,'booking','pre_payment_value','10','Pre-Payment Value','_MS_PRE_PAYMENT_VALUE','enum',0,'1,2,3,4,5,6,7,8,9,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,99');
INSERT INTO `aphs_modules_settings` VALUES (23,'booking','vat_value','0','VAT Default Value','_MS_VAT_VALUE','unsigned float',0,'');
INSERT INTO `aphs_modules_settings` VALUES (24,'booking','minimum_nights','1','Minimum Nights Stay','_MS_MINIMUM_NIGHTS','enum',1,'1,2,3,4,5,6,7,8,9,10,14,21,28,30,45,60,90');
INSERT INTO `aphs_modules_settings` VALUES (25,'booking','maximum_nights','90','Maximum Nights Stay','_MS_MAXIMUM_NIGHTS','enum',1,'1,2,3,4,5,6,7,8,9,10,14,21,28,30,45,60,90,120,150,180,240,360');
INSERT INTO `aphs_modules_settings` VALUES (26,'booking','mode','REAL MODE','Payment Mode','_MS_BOOKING_MODE','enum',1,'TEST MODE,REAL MODE');
INSERT INTO `aphs_modules_settings` VALUES (27,'booking','show_fully_booked_rooms','yes','Show Fully Booked Rooms','_MS_SHOW_FULLY_BOOKED_ROOMS','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (28,'booking','preparing_orders_timeout','2','\'Preparing\' Orders Timeout','_MS_PREPARING_ORDERS_TIMEOUT','enum',1,'0,1,2,3,4,5,6,7,8,9,10,12,14,16,18,20,22,24,36,48,72');
INSERT INTO `aphs_modules_settings` VALUES (29,'booking','customers_cancel_reservation','7','Customers May Cancel Reservation','_MS_CUSTOMERS_CANCEL_RESERVATION','enum',1,'0,1,2,3,4,5,6,7,10,14,21,30,45,60');
INSERT INTO `aphs_modules_settings` VALUES (30,'booking','show_reservation_form','yes','Show Reservation Form','_MS_SHOW_RESERVATION_FORM','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (31,'booking','booking_initial_fee','0','Booking Initial Fee','_MS_RESERVATION_INITIAL_FEE','unsigned float',1,'');
INSERT INTO `aphs_modules_settings` VALUES (32,'booking','booking_number_type','random','Type of Booking Numbers','_MS_BOOKING_NUMBER_TYPE','enum',1,'random,sequential');
INSERT INTO `aphs_modules_settings` VALUES (33,'booking','vat_included_in_price','no','Include VAT in Price','_MS_VAT_INCLUDED_IN_PRICE','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (34,'booking','show_booking_status_form','yes','Show Booking Status Form','_MS_SHOW_BOOKING_STATUS_FORM','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (35,'booking','maximum_allowed_reservations','10','Maximum Allowed Reservations','_MS_MAXIMUM_ALLOWED_RESERVATIONS','positive integer',1,'');
INSERT INTO `aphs_modules_settings` VALUES (36,'booking','first_night_calculating_type','real','First Night Calculating Type','_MS_FIRST_NIGHT_CALCULATING_TYPE','enum',1,'real,average');
INSERT INTO `aphs_modules_settings` VALUES (37,'booking','available_until_approval','no','Available Until Approval','_MS_AVAILABLE_UNTIL_APPROVAL','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (38,'booking','reservation_expired_alert','no','Reservation Expired Alert','_MS_RESERVATION EXPIRED_ALERT','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (39,'booking','allow_booking_in_past','no','Allow Booking in the Past','_MS_ADMIN_BOOKING_IN_PAST','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (40,'customers','allow_adding_by_admin','yes','Admin Creates Customers','_MS_ALLOW_ADDING_BY_ADMIN','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (41,'customers','reg_confirmation','by email','Confirmation Type','_MS_REG_CONFIRMATION','enum',0,'automatic,by email,by admin');
INSERT INTO `aphs_modules_settings` VALUES (42,'customers','image_verification_allow','yes','Image Verification','_MS_CUSTOMERS_IMAGE_VERIFICATION','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (43,'customers','allow_login','yes','Allow Customers to Login','_MS_ALLOW_CUSTOMERS_LOGIN','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (44,'customers','allow_registration','yes','Allow New Customers Registration','_MS_ALLOW_CUSTOMERS_REGISTRATION','yes/no',0,'');
INSERT INTO `aphs_modules_settings` VALUES (45,'customers','password_changing_by_admin','yes','Admin Changes Customer Password','_MS_ADMIN_CHANGE_CUSTOMER_PASSWORD','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (46,'customers','allow_reset_passwords','yes','Allow Reset Passwords','_MS_ALLOW_CUST_RESET_PASSWORDS','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (47,'customers','admin_alert_new_registration','yes','Alert Admin On New  Registration','_MS_ALERT_ADMIN_NEW_REGISTRATION','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (48,'customers','remember_me_allow','yes','Remember Me','_MS_REMEMBER_ME','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (49,'comments','comments_allow','yes','Allow Comments','_MS_COMMENTS_ALLOW','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (50,'comments','user_type','registered','User Type','_MS_USER_TYPE','enum',1,'all,registered');
INSERT INTO `aphs_modules_settings` VALUES (51,'comments','comment_length','500','Comments Length','_MS_COMMENTS_LENGTH','positive integer',1,'');
INSERT INTO `aphs_modules_settings` VALUES (52,'comments','image_verification_allow','yes','Image Verification','_MS_IMAGE_VERIFICATION_ALLOW','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (53,'comments','page_size','20','Comments per Page','_MS_COMMENTS_PAGE_SIZE','positive integer',1,'');
INSERT INTO `aphs_modules_settings` VALUES (54,'comments','pre_moderation_allow','yes','Comments Pre-moderation','_MS_PRE_MODERATION_ALLOW','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (55,'comments','delete_pending_time','2','Pending Time','_MS_DELETE_PENDING_TIME','enum',1,'0,1,2,3,4,5,6,7,8,9,10,15,20,30,45,60,120,180');
INSERT INTO `aphs_modules_settings` VALUES (56,'contact_us','key','{module:contact_us}','Contact Key','_MS_CONTACT_US_KEY','enum',1,'{module:contact_us}');
INSERT INTO `aphs_modules_settings` VALUES (57,'contact_us','email','tamnguyen@egs.vn','Contact Email','_MS_EMAIL','email',1,'');
INSERT INTO `aphs_modules_settings` VALUES (58,'contact_us','is_send_delay','yes','Sending Delay','_MS_IS_SEND_DELAY','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (59,'contact_us','delay_length','20','Delay Length','_MS_DELAY_LENGTH','positive integer',0,'');
INSERT INTO `aphs_modules_settings` VALUES (60,'contact_us','image_verification_allow','yes','Image Verification','_MS_IMAGE_VERIFICATION_ALLOW','yes/no',0,'');
INSERT INTO `aphs_modules_settings` VALUES (61,'faq','is_active','yes','Activate FAQ','_MS_FAQ_IS_ACTIVE','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (62,'gallery','key','{module:gallery}','Gallery Key','_MS_GALLERY_KEY','enum',1,'{module:gallery}');
INSERT INTO `aphs_modules_settings` VALUES (63,'gallery','album_key','{module:album=CODE}','Album Key','_MS_ALBUM_KEY','enum',1,'{module:album=CODE}');
INSERT INTO `aphs_modules_settings` VALUES (64,'gallery','image_gallery_type','lytebox','Image Gallery Type','_MS_IMAGE_GALLERY_TYPE','enum',1,'lytebox,rokbox');
INSERT INTO `aphs_modules_settings` VALUES (65,'gallery','album_icon_width','140px','Album Icon Width','_MS_ALBUM_ICON_WIDTH','html size',1,'');
INSERT INTO `aphs_modules_settings` VALUES (66,'gallery','album_icon_height','105px','Album Icon Height','_MS_ALBUM_ICON_HEIGHT','html size',1,'');
INSERT INTO `aphs_modules_settings` VALUES (67,'gallery','albums_per_line','4','Albums per Line','_MS_ALBUMS_PER_LINE','positive integer',1,'');
INSERT INTO `aphs_modules_settings` VALUES (68,'gallery','video_gallery_type','rokbox','Video Gallery Type','_MS_VIDEO_GALLERY_TYPE','enum',1,'rokbox,videobox');
INSERT INTO `aphs_modules_settings` VALUES (69,'gallery','wrapper','table','HTML Wrapping Tag','_MS_GALLERY_WRAPPER','enum',1,'table,div');
INSERT INTO `aphs_modules_settings` VALUES (70,'gallery','show_items_count_in_album','yes','Show Items Count in Album','_MS_ITEMS_COUNT_IN_ALBUM','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (71,'news','news_count','5','News Count','_MS_NEWS_COUNT','positive integer',1,'');
INSERT INTO `aphs_modules_settings` VALUES (72,'news','news_header_length','80','News Header Length','_MS_NEWS_HEADER_LENGTH','positive integer',1,'');
INSERT INTO `aphs_modules_settings` VALUES (73,'news','news_rss','yes','News RSS','_MS_NEWS_RSS','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (74,'news','show_news_block','left side','News Block','_MS_SHOW_NEWS_BLOCK','enum',1,'no,left side,right side');
INSERT INTO `aphs_modules_settings` VALUES (75,'news','show_newsletter_subscribe_block','no','Newsletter Subscription','_MS_SHOW_NEWSLETTER_SUBSCRIBE_BLOCK','enum',1,'no,left side,right side');
INSERT INTO `aphs_modules_settings` VALUES (76,'rooms','search_availability_page_size','5','Search Availability Page Size','_MS_SEARCH_AVAILABILITY_PAGE_SIZE','enum',1,'1,2,3,4,5,6,7,8,9,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100,250,500,1000');
INSERT INTO `aphs_modules_settings` VALUES (77,'rooms','show_room_types_in_search','all','Show Rooms In Search','_MS_ROOMS_IN_SEARCH','enum',1,'all,available only');
INSERT INTO `aphs_modules_settings` VALUES (78,'rooms','allow_children','yes','Allow Children in Room','_MS_ALLOW_CHILDREN_IN_ROOM','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (79,'rooms','allow_system_suggestion','yes','Allow System Suggestion','_MS_ALLOW_SYSTEM_SUGGESTION','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (80,'rooms','allow_guests','yes','Allow Guests in Room','_MS_ALLOW_GUESTS_IN_ROOM','yes/no',1,'');
INSERT INTO `aphs_modules_settings` VALUES (81,'testimonials','key','{module:testimonials}','Testimonials Key','_MS_TESTIMONIALS_KEY','enum',1,'{module:testimonials}');
/*!40000 ALTER TABLE `aphs_modules_settings` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_news` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `news_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `language_id` varchar(2) CHARACTER SET latin1 NOT NULL,
  `type` enum('news','events') CHARACTER SET latin1 NOT NULL DEFAULT 'news',
  `header_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body_text` text COLLATE utf8_unicode_ci NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_news` WRITE;
/*!40000 ALTER TABLE `aphs_news` DISABLE KEYS */;
INSERT INTO `aphs_news` VALUES (1,'txj17hkwau','en','news','The World\'s Best Business Hotels','<div style=\"font: 14px/16px Arial, helvetica; padding: 4px 0px; text-align: left; color: #72571d; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal;\">Our favorite luxury business hotel recommendations!</div>\r\n<div style=\"font: 11px/16px Arial, helvetica; text-align: left; color: #000000; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal;\">\r\n<div style=\"padding: 0px 15px 5px 0px;\">\r\n<p style=\"color: #474747; line-height: 10.5pt; font-family: Arial; font-size: 13px;\">Looking for the lap of luxury after grueling business meetings abroad? Our extensive list of the world\'s best business hotels is key for the tireless executive who commands an easy and relaxing stay while travelling.</p>\r\n<p style=\"color: #474747; line-height: 10.5pt; font-family: Arial; font-size: 13px;\">A great majority of our favorite luxury business hotels are found in the heart of busy business districts where sprawling urban environments offer reliable access to city splendors, historic sites, and convention centers. These hotels maintain their effervescent glow at night as they shimmer with the white lights of sumptuous luxury and class.</p>\r\n</div>\r\n</div>','2012-11-12 18:47:33');
INSERT INTO `aphs_news` VALUES (4,'txj17hkwau','vi','news','The World\'s Best Business Hotels','<div style=\"font: 14px/16px Arial, helvetica; padding: 4px 0px; text-align: left; color: #72571d; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal;\">Our favorite luxury business hotel recommendations!</div>\r\n<div style=\"font: 11px/16px Arial, helvetica; text-align: left; color: #000000; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal;\">\r\n<div style=\"padding: 0px 15px 5px 0px;\">\r\n<p style=\"color: #474747; line-height: 10.5pt; font-family: Arial; font-size: 13px;\">Looking for the lap of luxury after grueling business meetings abroad? Our extensive list of the world\'s best business hotels is key for the tireless executive who commands an easy and relaxing stay while travelling.</p>\r\n<p style=\"color: #474747; line-height: 10.5pt; font-family: Arial; font-size: 13px;\">A great majority of our favorite luxury business hotels are found in the heart of busy business districts where sprawling urban environments offer reliable access to city splendors, historic sites, and convention centers. These hotels maintain their effervescent glow at night as they shimmer with the white lights of sumptuous luxury and class.</p>\r\n</div>\r\n</div>','2012-11-12 18:47:33');
INSERT INTO `aphs_news` VALUES (5,'txj17hkwau','ru','news','The World\'s Best Business Hotels','<div style=\"font: 14px/16px Arial, helvetica; padding: 4px 0px; text-align: left; color: #72571d; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal;\">Our favorite luxury business hotel recommendations!</div>\r\n<div style=\"font: 11px/16px Arial, helvetica; text-align: left; color: #000000; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal;\">\r\n<div style=\"padding: 0px 15px 5px 0px;\">\r\n<p style=\"color: #474747; line-height: 10.5pt; font-family: Arial; font-size: 13px;\">Looking for the lap of luxury after grueling business meetings abroad? Our extensive list of the world\'s best business hotels is key for the tireless executive who commands an easy and relaxing stay while travelling.</p>\r\n<p style=\"color: #474747; line-height: 10.5pt; font-family: Arial; font-size: 13px;\">A great majority of our favorite luxury business hotels are found in the heart of busy business districts where sprawling urban environments offer reliable access to city splendors, historic sites, and convention centers. These hotels maintain their effervescent glow at night as they shimmer with the white lights of sumptuous luxury and class.</p>\r\n</div>\r\n</div>','2012-11-12 18:47:33');
/*!40000 ALTER TABLE `aphs_news` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_news_subscribed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_news_subscribed` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `date_subscribed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_news_subscribed` WRITE;
/*!40000 ALTER TABLE `aphs_news_subscribed` DISABLE KEYS */;
/*!40000 ALTER TABLE `aphs_news_subscribed` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_packages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `start_date` date NOT NULL DEFAULT '0000-00-00',
  `finish_date` date NOT NULL DEFAULT '0000-00-00',
  `minimum_nights` tinyint(1) NOT NULL DEFAULT '0',
  `maximum_nights` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_packages` WRITE;
/*!40000 ALTER TABLE `aphs_packages` DISABLE KEYS */;
INSERT INTO `aphs_packages` VALUES (1,'Summer Cool Package 2014','2014-05-01','2014-10-31',1,90,1);
/*!40000 ALTER TABLE `aphs_packages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `language_id` varchar(2) CHARACTER SET latin1 NOT NULL,
  `content_type` enum('article','link','') CHARACTER SET latin1 NOT NULL DEFAULT 'article',
  `link_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link_target` enum('','_self','_blank') COLLATE utf8_unicode_ci NOT NULL,
  `page_key` varchar(125) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_text` text COLLATE utf8_unicode_ci,
  `menu_id` int(11) DEFAULT '0',
  `menu_link` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag_keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `tag_description` text COLLATE utf8_unicode_ci NOT NULL,
  `comments_allowed` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `finish_publishing` date NOT NULL DEFAULT '0000-00-00',
  `is_home` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_removed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_system_page` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `system_page` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `show_in_search` tinyint(1) NOT NULL DEFAULT '1',
  `status_changed` datetime NOT NULL,
  `access_level` enum('public','registered') CHARACTER SET latin1 NOT NULL DEFAULT 'public',
  `priority_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is_published` (`is_published`),
  KEY `is_removed` (`is_removed`),
  KEY `language_id` (`language_id`),
  KEY `comments_allowed` (`comments_allowed`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_pages` WRITE;
/*!40000 ALTER TABLE `aphs_pages` DISABLE KEYS */;
INSERT INTO `aphs_pages` VALUES (1,'rpo5bahloy','en','article','','_self','Welcome-to-Bamboo-Village-Beach-Resort','Welcome to Bamboo Village Beach Resort & Spa','Bamboo Village Beach Resort<br><br>38 Nguyen Dinh Chieu Street, Ham Tien Ward, Binh Thuan Province , Mui Ne, Phan Thiet, Vietnam<br><br>Located few hours away from Ho Chi Minh’s International Airport, an accommodation is to be found where you can relax and unwind and discover the authentic charms of Vietnam. Bamboo Village Beach Resort offers 143 luxury rooms and bungalows form a seaside village where real tropical warmth can be shared while guests\' intimacy maintained.<br><br>The sunlit beach that washes away your concerns, lush landscape that exemplifies nature, smiling staff that caters to your every need, quality food that satisfies the most demanding taste buds, energizing yoga courses and relaxing spa treatment that refreshing your health, and a sustainable operation that runs environmentally friendly.<br><br>Bamboo Village Beach Resort also provide two sunlit swimming pools and flowery gardens all around the resort, Bamboo Village does offer an enticing rest &amp; relax experience.<br><br><img alt=\"\" style=\"width: 100%;\" src=\"images/uploads/hotel-bamboo-village-2.jpg\" border=\"0\" hspace=\"\" vspace=\"\"><br><br><img alt=\"\" style=\"width: 100%;\" src=\"images/uploads/banner_03.jpg\" border=\"0\" hspace=\"\" vspace=\"\"><br>',0,'','Bamboo Village Beach Resort & Spa','hotel online booking site','Bamboo Village Beach Resort & Spa',0,'2011-05-01 11:16:22','2014-08-04 11:43:52','0000-00-00',1,0,1,0,'',1,'2010-04-24 16:55:05','public',0);
INSERT INTO `aphs_pages` VALUES (39,'zxcs3d4fd5','vi','article','','_self','test-page','test-page','Test page with comments',1,'Test Page','BD Hotel Site','hotel online booking site','BD Hotel Site',1,'2011-05-01 11:16:22','2012-06-25 15:02:03','0000-00-00',0,0,1,0,'',1,'0000-00-00 00:00:00','public',1);
INSERT INTO `aphs_pages` VALUES (4,'99fnhie8in','en','article','','_self','Test1','Test1','<p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">TP Hạ Long cho tổ chức Đại hội thể dục thể thao Hạ Long lần thứ VII năm 2013 đúng ngày diễn ra Lễ Quốc tang Đại tướng Võ Nguyên Giáp.</p><p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">&nbsp;</p><div style=\"margin: 0px; padding: 0px; height: 5px; text-align: justify; clear: both;\"></div><span id=\"more-89058\"></span><p></p><p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">Khoảng 14h chiều, ngày 11/10 – thời điểm cả nước chính thức Lễ Quốc tang Đại tướng Võ Nguyên Giáp, treo cờ rủ tại Nhà sinh hoạt văn hóa thể thao công nhân của Công ty Cổ phần than Núi Béo, đóng trên địa bàn phường Hồng Hải, thành phố Hạ Long đã diễn ra Đại hội TDTT lần thứ VII.</p><p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">Ghi nhận của phóng viên, đường phố treo rất nhiều băng rôn đỏ với dòng chữ “Nhiệt liệt chào mừng Đại hội thể dục thể thao Hạ Long lần thứ VII năm 2013”.</p>',1,'Test1','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2014-08-09 23:37:39','0000-00-00',0,1,0,0,'',1,'2014-08-09 23:38:36','public',0);
INSERT INTO `aphs_pages` VALUES (44,'op8uy67ydd','ru','article','','_self','Testimonials','Testimonials','{module:testimonials}',0,'Testimonials','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-07 23:35:48','0000-00-00',0,0,1,1,'testimonials',1,'0000-00-00 00:00:00','public',3);
INSERT INTO `aphs_pages` VALUES (45,'87ghtyfd5t','ru','article','','_self','We-offer-several-kinds-of-rooms','We offer several kinds of rooms','<div>{module:rooms}</div>',0,'Rooms','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-06-25 15:03:07','0000-00-00',0,0,1,1,'rooms',1,'0000-00-00 00:00:00','public',0);
INSERT INTO `aphs_pages` VALUES (46,'45tfrtbfg8','ru','article','','_self','Today’s-featured-menu-item','Today’s featured menu item','<img style=\"MARGIN-RIGHT: 7px\" border=\"0\" alt=\"\" vspace=\"5\" align=\"left\" src=\"images/uploads/restaurant_dishes.jpg\"> \r\n<h3 class=\"extra-wrap\">Foie gras!</h3>\r\n<div class=\"extra-wrap\">\r\n<ul class=\"list2\">\r\n<li>Nice and tasty! \r\n</li><li>Made from French ingredients! \r\n</li><li>Cooked by Italian chef! \r\n</li><li>Awarded by world’s assosiation of chef! \r\n</li><li>Proved to be good for your health!</li></ul></div>\r\n<div><strong class=\"txt2\">AS LOW AS €19!</strong></div><br><br><br><br>\r\n<h3><br>Menu/Specials</h3>\r\n<div class=\"extra-wrap\">\r\n<ul>\r\n<li>LYNAGH’S BEER CHEESE <br>Our own recipe, made with Guinness Stout served w/ carrots, celery &amp; crackers. -- $4.99 \r\n</li><li>SALSA <br>TAME OR FLAME Homemade salsa served with tortilla chips. The TAME is HOT!!! -- $2.99 \r\n</li><li>SPINACH ARTICHOKE DIP <br>Served with tortilla chips. -- $6.49 \r\n</li><li>DOC BILL\\\'S PUB PRETZELS <br>Two jumbo pretzels deep fried and served with hot homemade beer cheese. -- $5.49 \r\n</li><li>ULTIMATE IRISH <br>Take the Irish Nacho, add red onions and our famous chili. -- $9.99 \r\n</li><li>SPICY QUESO BEEF DIP <br>Ground beef, queso, Mexican spices, jalapenos, and sour cream. That’s gotta be good! -- $6.49 \r\n</li><li>DELUXE NACHOS <br>Tortillas smothered with chili, cheese, lettuce tomatoes, jalapenos &amp; sour cream.</li></ul></div>',0,'Restaurant','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-07 23:36:59','0000-00-00',0,0,1,1,'restaurant',1,'0000-00-00 00:00:00','public',2);
INSERT INTO `aphs_pages` VALUES (47,'s3d4fder56','ru','article','','_self','About-Us','About Us','{module:about_us} ',0,'About Us','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-03 12:52:10','0000-00-00',0,0,1,1,'about_us',1,'0000-00-00 00:00:00','public',4);
INSERT INTO `aphs_pages` VALUES (48,'90jhtyu78y','ru','article','','_self','Terms-and-Conditions','Terms and Conditions','<h4>Conditions of Purchase and Money Back Guarantee\r\n</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in enim sed arcu congue mollis. Mauris sed elementum nulla. Donec eleifend nunc dapibus turpis euismod at commodo mi pulvinar. Praesent vitae metus ligula. Maecenas commodo massa id arcu luctus posuere. Praesent adipiscing scelerisque nisi id accumsan.&nbsp;</p>\r\n<ul>\r\n<li>Sed posuere, sem mollis eleifend placerat, nisl magna dapibus nunc, in mattis augue urna ac dui. Nunc mollis venenatis mi. \r\n</li><li>A elementum nulla mollis in. Maecenas et mi augue. Nulla euismod mauris sit amet mauris ullamcorper lobortis. \r\n</li><li>Vivamus nec ligula nulla. Curabitur non sapien nec lectus euismod consectetur. Morbi ut vestibulum risus. </li></ul>\r\n<h4><br>Detailed Conditions</h4><br>Cras elit purus, dapibus et cursus vel, eleifend interdum neque. Aenean nec magna sit amet felis pellentesque sollicitudin. Praesent ut enim est, quis ornare massa: <br>\r\n<ul>\r\n<li>Sed ultrices turpis at dolor dictum eu sollicitudin leo gravida. Praesent leo leo, malesuada nec facilisis non, lobortis eget lacus. \r\n</li><li>Donec at orci odio. Aliquam eu nulla felis, eget volutpat enim. Vivamus ullamcorper ligula eu sapien rutrum et hendrerit neque convallis. Sed fringilla tristique arcu, a interdum erat fringilla non. Nunc sit amet sodales leo. \r\n</li><li>Quisque luctus lacus nulla. Duis iaculis porttitor velit et feugiat. Nam sed velit libero. Praesent metus mauris, fermentum nec consequat vel, bibendum vel sem. </li></ul><br>Etiam auctor est et leo tristique ut scelerisque sapien bibendum. Suspendisse tellus urna, pellentesque eget pellentesque a, dictum in massa. ',0,'Terms and Conditions','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-09-26 21:47:52','0000-00-00',0,0,1,1,'terms_and_conditions',1,'0000-00-00 00:00:00','public',6);
INSERT INTO `aphs_pages` VALUES (35,'87ghtyfd5t','vi','article','','_self','We-offer-several-kinds-of-rooms','We offer several kinds of rooms','<div>{module:rooms}</div>',0,'Rooms','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-06-25 15:03:07','0000-00-00',0,0,1,1,'rooms',1,'0000-00-00 00:00:00','public',0);
INSERT INTO `aphs_pages` VALUES (36,'45tfrtbfg8','vi','article','','_self','Today’s-featured-menu-item','Today’s featured menu item','<img style=\"MARGIN-RIGHT: 7px\" border=\"0\" alt=\"\" vspace=\"5\" align=\"left\" src=\"images/uploads/restaurant_dishes.jpg\"> \r\n<h3 class=\"extra-wrap\">Foie gras!</h3>\r\n<div class=\"extra-wrap\">\r\n<ul class=\"list2\">\r\n<li>Nice and tasty! \r\n</li><li>Made from French ingredients! \r\n</li><li>Cooked by Italian chef! \r\n</li><li>Awarded by world’s assosiation of chef! \r\n</li><li>Proved to be good for your health!</li></ul></div>\r\n<div><strong class=\"txt2\">AS LOW AS €19!</strong></div><br><br><br><br>\r\n<h3><br>Menu/Specials</h3>\r\n<div class=\"extra-wrap\">\r\n<ul>\r\n<li>LYNAGH’S BEER CHEESE <br>Our own recipe, made with Guinness Stout served w/ carrots, celery &amp; crackers. -- $4.99 \r\n</li><li>SALSA <br>TAME OR FLAME Homemade salsa served with tortilla chips. The TAME is HOT!!! -- $2.99 \r\n</li><li>SPINACH ARTICHOKE DIP <br>Served with tortilla chips. -- $6.49 \r\n</li><li>DOC BILL\\\'S PUB PRETZELS <br>Two jumbo pretzels deep fried and served with hot homemade beer cheese. -- $5.49 \r\n</li><li>ULTIMATE IRISH <br>Take the Irish Nacho, add red onions and our famous chili. -- $9.99 \r\n</li><li>SPICY QUESO BEEF DIP <br>Ground beef, queso, Mexican spices, jalapenos, and sour cream. That’s gotta be good! -- $6.49 \r\n</li><li>DELUXE NACHOS <br>Tortillas smothered with chili, cheese, lettuce tomatoes, jalapenos &amp; sour cream.</li></ul></div>',0,'Restaurant','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-07 23:36:59','0000-00-00',0,0,1,1,'restaurant',1,'0000-00-00 00:00:00','public',2);
INSERT INTO `aphs_pages` VALUES (37,'s3d4fder56','vi','article','','_self','About-Us','About Us','{module:about_us} ',0,'About Us','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-03 12:52:10','0000-00-00',0,0,1,1,'about_us',1,'0000-00-00 00:00:00','public',4);
INSERT INTO `aphs_pages` VALUES (38,'90jhtyu78y','vi','article','','_self','Terms-and-Conditions','Terms and Conditions','<h4>Conditions of Purchase and Money Back Guarantee\r\n</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in enim sed arcu congue mollis. Mauris sed elementum nulla. Donec eleifend nunc dapibus turpis euismod at commodo mi pulvinar. Praesent vitae metus ligula. Maecenas commodo massa id arcu luctus posuere. Praesent adipiscing scelerisque nisi id accumsan.&nbsp;</p>\r\n<ul>\r\n<li>Sed posuere, sem mollis eleifend placerat, nisl magna dapibus nunc, in mattis augue urna ac dui. Nunc mollis venenatis mi. \r\n</li><li>A elementum nulla mollis in. Maecenas et mi augue. Nulla euismod mauris sit amet mauris ullamcorper lobortis. \r\n</li><li>Vivamus nec ligula nulla. Curabitur non sapien nec lectus euismod consectetur. Morbi ut vestibulum risus. </li></ul>\r\n<h4><br>Detailed Conditions</h4><br>Cras elit purus, dapibus et cursus vel, eleifend interdum neque. Aenean nec magna sit amet felis pellentesque sollicitudin. Praesent ut enim est, quis ornare massa: <br>\r\n<ul>\r\n<li>Sed ultrices turpis at dolor dictum eu sollicitudin leo gravida. Praesent leo leo, malesuada nec facilisis non, lobortis eget lacus. \r\n</li><li>Donec at orci odio. Aliquam eu nulla felis, eget volutpat enim. Vivamus ullamcorper ligula eu sapien rutrum et hendrerit neque convallis. Sed fringilla tristique arcu, a interdum erat fringilla non. Nunc sit amet sodales leo. \r\n</li><li>Quisque luctus lacus nulla. Duis iaculis porttitor velit et feugiat. Nam sed velit libero. Praesent metus mauris, fermentum nec consequat vel, bibendum vel sem. </li></ul><br>Etiam auctor est et leo tristique ut scelerisque sapien bibendum. Suspendisse tellus urna, pellentesque eget pellentesque a, dictum in massa. ',0,'Terms and Conditions','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-09-26 21:47:52','0000-00-00',0,0,1,1,'terms_and_conditions',1,'0000-00-00 00:00:00','public',6);
INSERT INTO `aphs_pages` VALUES (7,'afd4vgf5yt','en','article','','_self','Gallery','Gallery','{module:gallery}',0,'Gallery','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-03 12:53:13','0000-00-00',0,0,1,1,'gallery',1,'0000-00-00 00:00:00','public',1);
INSERT INTO `aphs_pages` VALUES (43,'afd4vgf5yt','ru','article','','_self','Gallery','Gallery','{module:gallery}',0,'Gallery','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-03 12:53:13','0000-00-00',0,0,1,1,'gallery',1,'0000-00-00 00:00:00','public',1);
INSERT INTO `aphs_pages` VALUES (10,'op8uy67ydd','en','article','','_self','Testimonials','Testimonials','{module:testimonials}',0,'Testimonials','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-07 23:35:48','0000-00-00',0,0,1,1,'testimonials',1,'0000-00-00 00:00:00','public',3);
INSERT INTO `aphs_pages` VALUES (33,'afd4vgf5yt','vi','article','','_self','Gallery','Gallery','{module:gallery}',0,'Gallery','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-03 12:53:13','0000-00-00',0,0,1,1,'gallery',1,'0000-00-00 00:00:00','public',1);
INSERT INTO `aphs_pages` VALUES (34,'op8uy67ydd','vi','article','','_self','Testimonials','Testimonials','{module:testimonials}',0,'Testimonials','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-07 23:35:48','0000-00-00',0,0,1,1,'testimonials',1,'0000-00-00 00:00:00','public',3);
INSERT INTO `aphs_pages` VALUES (13,'87ghtyfd5t','en','article','','_self','We-offer-several-kinds-of-rooms','We offer several kinds of rooms','<div>{module:rooms}</div>',0,'Rooms','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-06-25 15:03:07','0000-00-00',0,0,1,1,'rooms',1,'0000-00-00 00:00:00','public',0);
INSERT INTO `aphs_pages` VALUES (16,'45tfrtbfg8','en','article','','_self','Today’s-featured-menu-item','Today’s featured menu item','<img style=\"MARGIN-RIGHT: 7px\" border=\"0\" alt=\"\" vspace=\"5\" align=\"left\" src=\"images/uploads/restaurant_dishes.jpg\"> \r\n<h3 class=\"extra-wrap\">Foie gras!</h3>\r\n<div class=\"extra-wrap\">\r\n<ul class=\"list2\">\r\n<li>Nice and tasty! \r\n</li><li>Made from French ingredients! \r\n</li><li>Cooked by Italian chef! \r\n</li><li>Awarded by world’s assosiation of chef! \r\n</li><li>Proved to be good for your health!</li></ul></div>\r\n<div><strong class=\"txt2\">AS LOW AS €19!</strong></div><br><br><br><br>\r\n<h3><br>Menu/Specials</h3>\r\n<div class=\"extra-wrap\">\r\n<ul>\r\n<li>LYNAGH’S BEER CHEESE <br>Our own recipe, made with Guinness Stout served w/ carrots, celery &amp; crackers. -- $4.99 \r\n</li><li>SALSA <br>TAME OR FLAME Homemade salsa served with tortilla chips. The TAME is HOT!!! -- $2.99 \r\n</li><li>SPINACH ARTICHOKE DIP <br>Served with tortilla chips. -- $6.49 \r\n</li><li>DOC BILL\\\'S PUB PRETZELS <br>Two jumbo pretzels deep fried and served with hot homemade beer cheese. -- $5.49 \r\n</li><li>ULTIMATE IRISH <br>Take the Irish Nacho, add red onions and our famous chili. -- $9.99 \r\n</li><li>SPICY QUESO BEEF DIP <br>Ground beef, queso, Mexican spices, jalapenos, and sour cream. That’s gotta be good! -- $6.49 \r\n</li><li>DELUXE NACHOS <br>Tortillas smothered with chili, cheese, lettuce tomatoes, jalapenos &amp; sour cream.</li></ul></div>',0,'Restaurant','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-07 23:36:59','0000-00-00',0,0,1,1,'restaurant',1,'0000-00-00 00:00:00','public',2);
INSERT INTO `aphs_pages` VALUES (19,'s3d4fder56','en','article','','_self','About-Us','About Us','{module:about_us} ',0,'About Us','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-03 12:52:10','0000-00-00',0,0,1,1,'about_us',1,'0000-00-00 00:00:00','public',4);
INSERT INTO `aphs_pages` VALUES (42,'99fnhie8in','ru','article','','_self','Test1','Test1','<p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">TP Hạ Long cho tổ chức Đại hội thể dục thể thao Hạ Long lần thứ VII năm 2013 đúng ngày diễn ra Lễ Quốc tang Đại tướng Võ Nguyên Giáp.</p><p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">&nbsp;<div style=\"margin: 0px; padding: 0px; height: 5px; text-align: justify; clear: both;\"></div><span id=\"more-89058\"></span><p></p><p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">Khoảng 14h chiều, ngày 11/10 – thời điểm cả nước chính thức Lễ Quốc tang Đại tướng Võ Nguyên Giáp, treo cờ rủ tại Nhà sinh hoạt văn hóa thể thao công nhân của Công ty Cổ phần than Núi Béo, đóng trên địa bàn phường Hồng Hải, thành phố Hạ Long đã diễn ra Đại hội TDTT lần thứ VII.</p><p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">Ghi nhận của phóng viên, đường phố treo rất nhiều băng rôn đỏ với dòng chữ “Nhiệt liệt chào mừng Đại hội thể dục thể thao Hạ Long lần thứ VII năm 2013”.</p>',1,'Test1','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2013-10-12 12:12:09','0000-00-00',0,0,1,0,'',1,'2012-04-23 20:08:59','public',0);
INSERT INTO `aphs_pages` VALUES (22,'90jhtyu78y','en','article','','_self','Terms-and-Conditions','Terms and Conditions','<h4>Conditions of Purchase and Money Back Guarantee\r\n</h4><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in enim sed arcu congue mollis. Mauris sed elementum nulla. Donec eleifend nunc dapibus turpis euismod at commodo mi pulvinar. Praesent vitae metus ligula. Maecenas commodo massa id arcu luctus posuere. Praesent adipiscing scelerisque nisi id accumsan.&nbsp;</p>\r\n<ul>\r\n<li>Sed posuere, sem mollis eleifend placerat, nisl magna dapibus nunc, in mattis augue urna ac dui. Nunc mollis venenatis mi. \r\n</li><li>A elementum nulla mollis in. Maecenas et mi augue. Nulla euismod mauris sit amet mauris ullamcorper lobortis. \r\n</li><li>Vivamus nec ligula nulla. Curabitur non sapien nec lectus euismod consectetur. Morbi ut vestibulum risus. </li></ul>\r\n<h4><br>Detailed Conditions</h4><br>Cras elit purus, dapibus et cursus vel, eleifend interdum neque. Aenean nec magna sit amet felis pellentesque sollicitudin. Praesent ut enim est, quis ornare massa: <br>\r\n<ul>\r\n<li>Sed ultrices turpis at dolor dictum eu sollicitudin leo gravida. Praesent leo leo, malesuada nec facilisis non, lobortis eget lacus. \r\n</li><li>Donec at orci odio. Aliquam eu nulla felis, eget volutpat enim. Vivamus ullamcorper ligula eu sapien rutrum et hendrerit neque convallis. Sed fringilla tristique arcu, a interdum erat fringilla non. Nunc sit amet sodales leo. \r\n</li><li>Quisque luctus lacus nulla. Duis iaculis porttitor velit et feugiat. Nam sed velit libero. Praesent metus mauris, fermentum nec consequat vel, bibendum vel sem. </li></ul><br>Etiam auctor est et leo tristique ut scelerisque sapien bibendum. Suspendisse tellus urna, pellentesque eget pellentesque a, dictum in massa. ',0,'Terms and Conditions','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-09-26 21:47:52','0000-00-00',0,0,1,1,'terms_and_conditions',1,'0000-00-00 00:00:00','public',6);
INSERT INTO `aphs_pages` VALUES (32,'99fnhie8in','vi','article','','_self','Test1','Test1','<p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">TP Hạ Long cho tổ chức Đại hội thể dục thể thao Hạ Long lần thứ VII năm 2013 đúng ngày diễn ra Lễ Quốc tang Đại tướng Võ Nguyên Giáp.</p><p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">&nbsp;<div style=\"margin: 0px; padding: 0px; height: 5px; text-align: justify; clear: both;\"></div><span id=\"more-89058\"></span><p></p><p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">Khoảng 14h chiều, ngày 11/10 – thời điểm cả nước chính thức Lễ Quốc tang Đại tướng Võ Nguyên Giáp, treo cờ rủ tại Nhà sinh hoạt văn hóa thể thao công nhân của Công ty Cổ phần than Núi Béo, đóng trên địa bàn phường Hồng Hải, thành phố Hạ Long đã diễn ra Đại hội TDTT lần thứ VII.</p><p style=\"font: 14px/22.39px Arial, Helvetica, sans-serif; margin: 0px; padding: 0px 0px 10px; text-align: justify; color: #222222; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; background-color: #FFFFFF; -webkit-text-stroke-width: 0px;\">Ghi nhận của phóng viên, đường phố treo rất nhiều băng rôn đỏ với dòng chữ “Nhiệt liệt chào mừng Đại hội thể dục thể thao Hạ Long lần thứ VII năm 2013”.</p>',1,'Test1','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2013-10-12 12:12:09','0000-00-00',0,0,1,0,'',1,'2012-04-23 20:08:59','public',0);
INSERT INTO `aphs_pages` VALUES (25,'zxcs3d4fd5','en','article','','_self','test-page','test-page','Test page with comments',1,'Test Page','BD Hotel Site','hotel online booking site','BD Hotel Site',1,'2011-05-01 11:16:22','2012-06-25 15:02:03','0000-00-00',0,1,0,0,'',1,'2014-08-09 23:39:47','public',1);
INSERT INTO `aphs_pages` VALUES (41,'rpo5bahloy','ru','article','','_self','BD-Hotel-Site-is-happy-to','BD Hotel Site is happy to welcome you!','<div style=\"font: 11px/16px Arial, helvetica; text-align: left; color: #000000; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; font-size-adjust: none; font-stretch: normal; -webkit-text-stroke-width: 0px;\"><img alt=\"The World\'s Best Luxury Hotels\" src=\"http://www.theinformedtraveler.com/archive/worlds-best-page.jpg\" width=\"480\" height=\"186\"></div><div id=\"rec-main\" style=\"font: 11px/16px Arial, helvetica; text-align: left; color: #000000; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; font-size-adjust: none; font-stretch: normal; -webkit-text-stroke-width: 0px;\"><p style=\"color: #474747; line-height: 10.5pt; font-family: Arial; font-size: 13px;\">We\'ve done it again! Our team of luxury hotel experts is proud to present our most current collection of the<span class=\"Apple-converted-space\">&nbsp;</span><strong>World\'s Best Luxury Hotels</strong>. And why not, after the huge success of last year\'s luxury hotel awards. Who better to select the best luxury hotels in the world than the travel agency with the most comprehensive collection of 100% luxury hotels?<br><br>This year we\'ve hand-picked the best luxury hotels worldwide, based on great feedback from our loyal customers.<span class=\"Apple-converted-space\">&nbsp;</span><a style=\"color: #A6332D; text-decoration: none;\" href=\"http://www.fivestaralliance.com/luxury-hotel-experts/about-us\">Learn about Five Star Alliance</a><span class=\"Apple-converted-space\">&nbsp;</span>and how we can help you find and book the ideal luxury hotel - just like we\'ve helped tens of thousands of travelers. As always, we\'d love to<span class=\"Apple-converted-space\">&nbsp;</span><a style=\"color: #A6332D; text-decoration: none;\" href=\"http://www.fivestaralliance.com/luxury-hotel-experts/contact-us\">hear from you</a>. Bon voyage!</p></div>',0,'','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2014-01-26 14:53:09','0000-00-00',1,0,1,0,'',1,'2010-04-24 16:55:05','public',0);
INSERT INTO `aphs_pages` VALUES (28,'q8mv7zrzmo','en','article','','_self','Contact-Us','Contact Us','{module:contact_us}',0,'Contact Us','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-03 12:52:36','0000-00-00',0,0,1,1,'contact_us',1,'0000-00-00 00:00:00','public',5);
INSERT INTO `aphs_pages` VALUES (40,'q8mv7zrzmo','vi','article','','_self','Contact-Us','Contact Us','{module:contact_us}',0,'Contact Us','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-03 12:52:36','0000-00-00',0,0,1,1,'contact_us',1,'0000-00-00 00:00:00','public',5);
INSERT INTO `aphs_pages` VALUES (31,'rpo5bahloy','vi','article','','_self','BD-Hotel-Site-is-happy-to','BD Hotel Site is happy to welcome you!','<div style=\"font: 11px/16px Arial, helvetica; text-align: left; color: #000000; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; font-size-adjust: none; font-stretch: normal; -webkit-text-stroke-width: 0px;\"><img alt=\"The World\'s Best Luxury Hotels\" src=\"http://www.theinformedtraveler.com/archive/worlds-best-page.jpg\" width=\"480\" height=\"186\"></div><div id=\"rec-main\" style=\"font: 11px/16px Arial, helvetica; text-align: left; color: #000000; text-transform: none; text-indent: 0px; letter-spacing: normal; word-spacing: 0px; white-space: normal; font-size-adjust: none; font-stretch: normal; -webkit-text-stroke-width: 0px;\"><p style=\"color: #474747; line-height: 10.5pt; font-family: Arial; font-size: 13px;\">We\'ve done it again! Our team of luxury hotel experts is proud to present our most current collection of the<span class=\"Apple-converted-space\">&nbsp;</span><strong>World\'s Best Luxury Hotels</strong>. And why not, after the huge success of last year\'s luxury hotel awards. Who better to select the best luxury hotels in the world than the travel agency with the most comprehensive collection of 100% luxury hotels?<br><br>This year we\'ve hand-picked the best luxury hotels worldwide, based on great feedback from our loyal customers.<span class=\"Apple-converted-space\">&nbsp;</span><a style=\"color: #A6332D; text-decoration: none;\" href=\"http://www.fivestaralliance.com/luxury-hotel-experts/about-us\">Learn about Five Star Alliance</a><span class=\"Apple-converted-space\">&nbsp;</span>and how we can help you find and book the ideal luxury hotel - just like we\'ve helped tens of thousands of travelers. As always, we\'d love to<span class=\"Apple-converted-space\">&nbsp;</span><a style=\"color: #A6332D; text-decoration: none;\" href=\"http://www.fivestaralliance.com/luxury-hotel-experts/contact-us\">hear from you</a>. Bon voyage!</p></div>',0,'','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2014-01-26 14:53:09','0000-00-00',1,0,1,0,'',1,'2010-04-24 16:55:05','public',0);
INSERT INTO `aphs_pages` VALUES (49,'zxcs3d4fd5','ru','article','','_self','test-page','test-page','Test page with comments',1,'Test Page','BD Hotel Site','hotel online booking site','BD Hotel Site',1,'2011-05-01 11:16:22','2012-06-25 15:02:03','0000-00-00',0,0,1,0,'',1,'0000-00-00 00:00:00','public',1);
INSERT INTO `aphs_pages` VALUES (50,'q8mv7zrzmo','ru','article','','_self','Contact-Us','Contact Us','{module:contact_us}',0,'Contact Us','BD Hotel Site','hotel online booking site','BD Hotel Site',0,'2011-05-01 11:16:22','2012-05-03 12:52:36','0000-00-00',0,0,1,1,'contact_us',1,'0000-00-00 00:00:00','public',5);
INSERT INTO `aphs_pages` VALUES (51,'k435xkshau','en','article','','_self','Sảng-khoái-hè-cùng-mừng-sinh','Sảng khoái hè cùng mừng sinh nhật tuổi 16 KDL Làng Tre- Mũi Né','1<font face=\"Comic Sans MS\">6 năm cùng đồng hành, 16 năm cùng vững bước tự tin đem lại cam kết sự hài lòng cho du khách đến nghĩ dưỡng với KDL Làng Tre Mũi Né.</font><div><font face=\"Comic Sans MS\"><br></font></div><div><font face=\"Comic Sans MS\">Nhân dịp kỷ niệm sinh nhật 16 năm công ty TNHH Làng Tre Mũi Né, BGĐ cùng toàn thể anh chị em nhân viên xin trân trọng gửi đến quý du khách lời cảm ơn chân thành nhất, cùng xin chúc quý du khách được tận hưởng những phút giây khoảnh khắc thoải mái tuyệt vời nhất của mình trong từng kỳ nghĩ</font></div><div><font face=\"Comic Sans MS\"><br></font></div><div><font face=\"Comic Sans MS\">Tận hưởng ngay kỳ nghỉ hè sảng khoái tại bãi biển đẹp nhất Hàm Tiến Mũi né, cùng chúng tôi kỷ niệm sinh nhật 16 năm với gói khuyến mãi hè mát lạnh giá chỉ <b>1.789.000 Đ/dêm phòng, tặng ngay 2 kem cây lắng dịu cơn khát ngay tại hồ bơi ở KDL cùng 2 vé xe buýt 1 lượt khi đăng ký đặt phòng với chúng tôi.</b></font></div><div><b><font face=\"Comic Sans MS\"><br></font></b></div><div><b><font face=\"Comic Sans MS\">Hãy cùng chúng tôi nhân đôi niềm vui, chúng tôi xin cam kết sự hài lòng về kỳ nghỉ của quý khách!</font></b></div><div><b><font face=\"Comic Sans MS\"><br></font></b></div><div><b><font face=\"Comic Sans MS\">Trân trọng</font></b></div><div><b><font face=\"Comic Sans MS\"><br></font></b></div><div><b><font face=\"Comic Sans MS\">BGĐ KDL Làng Tre -Mũi Né<br></font></b></div>',1,'www.bamboovillageresortvn.com','Bamboo Village','hotel, online booking, Bamboo Village','Bamboo Village',0,'2014-08-09 23:52:37','2014-10-06 08:59:56','0000-00-00',0,0,1,0,'',1,'0000-00-00 00:00:00','public',7);
INSERT INTO `aphs_pages` VALUES (53,'k435xkshau','vi','article','','_self','Sảng-khoái-hè-cùng-mừng-sinh','Sảng khoái hè cùng mừng sinh nhật tuổi 16 KDL Làng Tre- Mũi Né','1<font face=\"Comic Sans MS\">6 năm cùng đồng hành, 16 năm cùng vững bước tự tin đem lại cam kết sự hài lòng cho du khách đến nghĩ dưỡng với KDL Làng Tre Mũi Né.</font><div><font face=\"Comic Sans MS\"><br></font></div><div><font face=\"Comic Sans MS\">Nhân dịp kỷ niệm sinh nhật 16 năm công ty TNHH Làng Tre Mũi Né, BGĐ cùng toàn thể anh chị em nhân viên xin trân trọng gửi đến quý du khách lời cảm ơn chân thành nhất, cùng xin chúc quý du khách được tận hưởng những phút giây khoảnh khắc thoải mái tuyệt vời nhất của mình trong từng kỳ nghĩ</font></div><div><font face=\"Comic Sans MS\"><br></font></div><div><font face=\"Comic Sans MS\">Tận hưởng ngay kỳ nghỉ hè sảng khoái tại bãi biển đẹp nhất Hàm Tiến Mũi né, cùng chúng tôi kỷ niệm sinh nhật 16 năm với gói khuyến mãi hè mát lạnh giá chỉ <b>1.789.000 Đ/dêm phòng, tặng ngay 2 kem cây lắng dịu cơn khát ngay tại hồ bơi ở KDL cùng 2 vé xe buýt 1 lượt khi đăng ký đặt phòng với chúng tôi.</b></font></div><div><b><font face=\"Comic Sans MS\"><br></font></b></div><div><b><font face=\"Comic Sans MS\">Hãy cùng chúng tôi nhân đôi niềm vui, chúng tôi xin cam kết sự hài lòng về kỳ nghỉ của quý khách!</font></b></div><div><b><font face=\"Comic Sans MS\"><br></font></b></div><div><b><font face=\"Comic Sans MS\">Trân trọng</font></b></div><div><b><font face=\"Comic Sans MS\"><br></font></b></div><div><b><font face=\"Comic Sans MS\">BGĐ KDL Làng Tre -Mũi Né</font></b></div>',1,'www.bamboovillageresortvn.com','Bamboo Village','hotel, online booking, Bamboo Village','Bamboo Village',0,'2014-08-09 23:52:37','2014-08-09 23:58:54','0000-00-00',0,0,1,0,'',1,'0000-00-00 00:00:00','public',7);
/*!40000 ALTER TABLE `aphs_pages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_privileges` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_privileges` WRITE;
/*!40000 ALTER TABLE `aphs_privileges` DISABLE KEYS */;
INSERT INTO `aphs_privileges` VALUES (1,'add_menus','Add Menus','Add Menus on the site');
INSERT INTO `aphs_privileges` VALUES (2,'edit_menus','Edit Menus','Edit Menus on the site');
INSERT INTO `aphs_privileges` VALUES (3,'delete_menus','Delete Menus','Delete Menus from the site');
INSERT INTO `aphs_privileges` VALUES (4,'add_pages','Add Pages','Add Pages on the site');
INSERT INTO `aphs_privileges` VALUES (5,'edit_pages','Edit Pages','Edit Pages on the site');
INSERT INTO `aphs_privileges` VALUES (6,'delete_pages','Delete Pages','Delete Pages from the site');
INSERT INTO `aphs_privileges` VALUES (7,'edit_hotel_info','Manage Hotels','See and modify the hotels info');
INSERT INTO `aphs_privileges` VALUES (8,'edit_hotel_rooms','Manage Hotel Rooms','See and modify the hotel rooms info');
INSERT INTO `aphs_privileges` VALUES (9,'view_hotel_reports','See Hotel Reports','See only reports related to assigned hotel');
/*!40000 ALTER TABLE `aphs_privileges` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_role_privileges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_role_privileges` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role_id` int(5) NOT NULL,
  `privilege_id` int(5) NOT NULL,
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_role_privileges` WRITE;
/*!40000 ALTER TABLE `aphs_role_privileges` DISABLE KEYS */;
INSERT INTO `aphs_role_privileges` VALUES (1,1,1,1);
INSERT INTO `aphs_role_privileges` VALUES (2,1,2,1);
INSERT INTO `aphs_role_privileges` VALUES (3,1,3,1);
INSERT INTO `aphs_role_privileges` VALUES (4,1,4,1);
INSERT INTO `aphs_role_privileges` VALUES (5,1,5,1);
INSERT INTO `aphs_role_privileges` VALUES (6,1,6,1);
INSERT INTO `aphs_role_privileges` VALUES (7,2,1,1);
INSERT INTO `aphs_role_privileges` VALUES (8,2,2,1);
INSERT INTO `aphs_role_privileges` VALUES (9,2,3,1);
INSERT INTO `aphs_role_privileges` VALUES (10,2,4,1);
INSERT INTO `aphs_role_privileges` VALUES (11,2,5,1);
INSERT INTO `aphs_role_privileges` VALUES (12,2,6,1);
INSERT INTO `aphs_role_privileges` VALUES (13,3,1,0);
INSERT INTO `aphs_role_privileges` VALUES (14,3,2,1);
INSERT INTO `aphs_role_privileges` VALUES (15,3,3,0);
INSERT INTO `aphs_role_privileges` VALUES (16,3,4,1);
INSERT INTO `aphs_role_privileges` VALUES (17,3,5,1);
INSERT INTO `aphs_role_privileges` VALUES (18,3,6,0);
INSERT INTO `aphs_role_privileges` VALUES (19,4,7,1);
INSERT INTO `aphs_role_privileges` VALUES (20,4,8,1);
INSERT INTO `aphs_role_privileges` VALUES (21,4,9,1);
INSERT INTO `aphs_role_privileges` VALUES (22,5,1,1);
INSERT INTO `aphs_role_privileges` VALUES (23,5,2,1);
INSERT INTO `aphs_role_privileges` VALUES (24,5,3,1);
INSERT INTO `aphs_role_privileges` VALUES (25,5,4,1);
INSERT INTO `aphs_role_privileges` VALUES (26,5,5,1);
INSERT INTO `aphs_role_privileges` VALUES (27,5,6,1);
/*!40000 ALTER TABLE `aphs_role_privileges` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_roles` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_roles` WRITE;
/*!40000 ALTER TABLE `aphs_roles` DISABLE KEYS */;
INSERT INTO `aphs_roles` VALUES (1,'owner','Site Owner','Site Owner is the owner of the site, has all privileges and could not be removed.');
INSERT INTO `aphs_roles` VALUES (2,'mainadmin','Main Admin','The \"Main Administrator\" user has top privileges like Site Owner and may be removed only by him.');
INSERT INTO `aphs_roles` VALUES (3,'admin','Simple Admin','The \"Simple Admin\" is required to assist the Main Admins, has different privileges and may be created by Site Owner or Main Admins.');
INSERT INTO `aphs_roles` VALUES (4,'hotelowner','Hotel Owner','The \"Hotel Owner\" is the owner of the hotel, has special privileges to the hotels/rooms he/she assigned to.');
INSERT INTO `aphs_roles` VALUES (5,'accounthotelmanageme','Account & Hotel Management','Account & Hotel Management');
INSERT INTO `aphs_roles` VALUES (6,'hotelmanagement','Hotel Management','Hotel Management');
INSERT INTO `aphs_roles` VALUES (7,'booking','Booking','Booking');
/*!40000 ALTER TABLE `aphs_roles` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_room_facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_room_facilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_room_facilities` WRITE;
/*!40000 ALTER TABLE `aphs_room_facilities` DISABLE KEYS */;
INSERT INTO `aphs_room_facilities` VALUES (24,1,1);
INSERT INTO `aphs_room_facilities` VALUES (23,1,1);
INSERT INTO `aphs_room_facilities` VALUES (22,0,1);
/*!40000 ALTER TABLE `aphs_room_facilities` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_room_facilities_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_room_facilities_description` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_facility_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_room_facilities_description` WRITE;
/*!40000 ALTER TABLE `aphs_room_facilities_description` DISABLE KEYS */;
INSERT INTO `aphs_room_facilities_description` VALUES (100,24,'en','Balcony/terrace','Balcony/terrace');
INSERT INTO `aphs_room_facilities_description` VALUES (98,22,'en','Non smoking rooms','Non smoking rooms');
INSERT INTO `aphs_room_facilities_description` VALUES (99,23,'en','Air conditioning','Air conditioning');
INSERT INTO `aphs_room_facilities_description` VALUES (101,24,'vi','Balcony/terrace','Balcony/terrace');
INSERT INTO `aphs_room_facilities_description` VALUES (102,22,'vi','Non smoking rooms','Non smoking rooms');
INSERT INTO `aphs_room_facilities_description` VALUES (103,23,'vi','Air conditioning','Air conditioning');
/*!40000 ALTER TABLE `aphs_room_facilities_description` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotel_id` smallint(6) unsigned NOT NULL DEFAULT '0',
  `room_type` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `room_short_description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `room_long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `room_count` smallint(6) NOT NULL,
  `max_adults` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `max_guests` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `max_children` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `default_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `additional_guest_fee` decimal(10,2) unsigned NOT NULL,
  `default_availability` tinyint(1) NOT NULL DEFAULT '1',
  `beds` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `bathrooms` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `room_area` decimal(5,2) unsigned NOT NULL DEFAULT '0.00',
  `facilities` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_icon` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_icon_thumb` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_picture_1` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_picture_1_thumb` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_picture_2` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_picture_2_thumb` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_picture_3` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_picture_3_thumb` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_picture_4` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_picture_4_thumb` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_picture_5` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `room_picture_5_thumb` varchar(70) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `priority_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_rooms` WRITE;
/*!40000 ALTER TABLE `aphs_rooms` DISABLE KEYS */;
INSERT INTO `aphs_rooms` VALUES (7,4,'Windy type','<p>adc</p>','',2,2,1,2,3728000.00,860000.00,1,1,1,44.00,'a:3:{i:0;s:2:\"22\";i:1;s:2:\"24\";i:2;s:2:\"23\";}','4_icon_ng138zsqyiyg3kl960ak.jpg','4_icon_ng138zsqyiyg3kl960ak_thumb.jpg','4_view1_rtwgko4q69vx8j5v3pxe.jpg','4_view1_rtwgko4q69vx8j5v3pxe_thumb.jpg','4_view2_jwse1bwdgucogn8pancb.jpg','4_view2_jwse1bwdgucogn8pancb_thumb.jpg','4_view3_zy8zkyk0szeiczl4ir8k.jpg','4_view3_zy8zkyk0szeiczl4ir8k_thumb.jpg','4_view4_sdanqovzvntdmkhjbyw2.jpg','4_view4_sdanqovzvntdmkhjbyw2_thumb.jpg','4_view5_obqayxmmocjjtsz6gb2z.jpg','4_view5_obqayxmmocjjtsz6gb2z_thumb.jpg',0,1);
INSERT INTO `aphs_rooms` VALUES (10,4,'Dove Cottages','<p>abc</p>','',2,2,1,2,1460000.00,860000.00,1,1,1,24.00,'a:3:{i:0;s:2:\"22\";i:1;s:2:\"24\";i:2;s:2:\"23\";}','4_icon_a1u4q2dc9arom544tcj0.JPG','4_icon_a1u4q2dc9arom544tcj0_thumb.jpg','4_view1_yl9qct0eg1e6qxhx7hl2.jpg','4_view1_yl9qct0eg1e6qxhx7hl2_thumb.jpg','4_view2_xptdkapeewuikrsii8u5.jpg','4_view2_xptdkapeewuikrsii8u5_thumb.jpg','4_view3_xo86thgaval7zg4i8w54.jpg','4_view3_xo86thgaval7zg4i8w54_thumb.jpg','4_view4_q7wfu2uxb4m44b3xlljx.jpg','4_view4_q7wfu2uxb4m44b3xlljx_thumb.jpg','','',3,1);
INSERT INTO `aphs_rooms` VALUES (11,4,'Gardenview Bungalows - Deluxe','<p>abc</p>','',2,2,1,2,2846000.00,860000.00,1,1,1,39.00,'a:3:{i:0;s:2:\"22\";i:1;s:2:\"24\";i:2;s:2:\"23\";}','4_icon_m119eat7z3z06nef7t66.jpg','4_icon_m119eat7z3z06nef7t66_thumb.jpg','4_view1_l3pude7i44eudtcdrudl.jpg','4_view1_l3pude7i44eudtcdrudl_thumb.jpg','4_view2_y1ckrtofn5a5xm56dxit.jpg','4_view2_y1ckrtofn5a5xm56dxit_thumb.jpg','4_view3_y19wja7yau7nsw7yvgzb.jpg','4_view3_y19wja7yau7nsw7yvgzb_thumb.jpg','4_view4_myxh8vohq5mebbuq2j8y.jpg','4_view4_myxh8vohq5mebbuq2j8y_thumb.jpg','4_view5_esvrjwz3srusytnsxy52.jpg','4_view5_esvrjwz3srusytnsxy52_thumb.jpg',1,1);
INSERT INTO `aphs_rooms` VALUES (12,4,'Nova Deluxe','<p>Nova Deluxe</p>','',2,2,1,2,2279000.00,860000.00,1,1,1,35.00,'a:3:{i:0;s:2:\"22\";i:1;s:2:\"24\";i:2;s:2:\"23\";}','4_icon_fg7l6whafuwu586klh5t.jpg','4_icon_fg7l6whafuwu586klh5t_thumb.jpg','4_view1_ut46fripd830zdc99rph.jpg','4_view1_ut46fripd830zdc99rph_thumb.jpg','4_view2_z896001hbi6dk7vivzep.jpg','4_view2_z896001hbi6dk7vivzep_thumb.jpg','4_view3_c9lg70z9o2sjfatbuy0m.jpg','4_view3_c9lg70z9o2sjfatbuy0m_thumb.jpg','4_view4_m189zvw74zhhne2s5dkj.jpg','4_view4_m189zvw74zhhne2s5dkj_thumb.jpg','4_view5_xwig2p3gpw70g9xzn0dy.jpg','4_view5_xwig2p3gpw70g9xzn0dy_thumb.jpg',0,1);
INSERT INTO `aphs_rooms` VALUES (13,4,'Prine Suites','<p>Prine Suites</p>','',2,4,2,2,3287000.00,860000.00,1,2,1,56.00,'a:3:{i:0;s:2:\"22\";i:1;s:2:\"24\";i:2;s:2:\"23\";}','4_icon_rmnqkaauor8tvq1u7rrf.jpg','4_icon_rmnqkaauor8tvq1u7rrf_thumb.jpg','4_view1_gz83xetajoxzxbn6iel4.jpg','4_view1_gz83xetajoxzxbn6iel4_thumb.jpg','4_view2_ib3wjtm3u2jyrn8zyl8h.jpg','4_view2_ib3wjtm3u2jyrn8zyl8h_thumb.jpg','4_view3_a1ivlgbwiwc9dbbmujpn.jpg','4_view3_a1ivlgbwiwc9dbbmujpn_thumb.jpg','4_view4_tdqku8sngbd9xttlusil.jpg','4_view4_tdqku8sngbd9xttlusil_thumb.jpg','4_view5_gz6rnqb98xeij7divqul.jpg','4_view5_gz6rnqb98xeij7divqul_thumb.jpg',2,1);
INSERT INTO `aphs_rooms` VALUES (14,4,'Queen','<p>Queen</p>','',2,2,1,2,2153000.00,860000.00,1,1,1,38.00,'a:3:{i:0;s:2:\"22\";i:1;s:2:\"24\";i:2;s:2:\"23\";}','4_icon_a7mp067mipexnxai8d85.jpg','4_icon_a7mp067mipexnxai8d85_thumb.jpg','4_view1_q0ddvxoaa7juvrs0zhdi.jpg','4_view1_q0ddvxoaa7juvrs0zhdi_thumb.jpg','4_view2_fdb11y4xpw5tu0w4dw3k.jpg','4_view2_fdb11y4xpw5tu0w4dw3k_thumb.jpg','4_view3_dfep25je468tmhh5s0hh.jpg','4_view3_dfep25je468tmhh5s0hh_thumb.jpg','4_view4_f706vh2ijsz826yifshe.jpg','4_view4_f706vh2ijsz826yifshe_thumb.jpg','4_view5_a3yuct1a5mbs4ee8urew.jpg','4_view5_a3yuct1a5mbs4ee8urew_thumb.jpg',3,1);
INSERT INTO `aphs_rooms` VALUES (15,4,'Gardenview Bungalows - Hawaiian','<p>Gardenview Bungalows - Hawaiian</p>','',2,2,1,2,2846000.00,860.00,1,1,1,34.00,'','4_icon_xdafvjgwr8hd8ypnx6nf.jpg','4_icon_xdafvjgwr8hd8ypnx6nf_thumb.jpg','4_view1_jsxhtosnn4bn90vlc2gb.jpg','4_view1_jsxhtosnn4bn90vlc2gb_thumb.jpg','4_view2_fxlm4tdeunhmacmd805n.jpg','4_view2_fxlm4tdeunhmacmd805n_thumb.jpg','4_view3_vhiir4ewkxktbzxfgouh.jpg','4_view3_vhiir4ewkxktbzxfgouh_thumb.jpg','4_view4_sbll79o54ccxi0flp0st.jpg','4_view4_sbll79o54ccxi0flp0st_thumb.jpg','4_view5_h48anv0ozm20pyxryxuu.jpg','4_view5_h48anv0ozm20pyxryxuu_thumb.jpg',1,1);
INSERT INTO `aphs_rooms` VALUES (6,4,'Honeyed type','<div class=\"detail-content\"></div>','<div class=\"detail-content\">\r\n<div class=\"title headline\">Room Detail</div>\r\n<p style=\"text-align: justify;\">Sweet like its namesake, our  Honeyed Type Beach Front Bungalows are a marriage of classical and  modern ideas of how bungalows are constructed both architecturally and  functionally. They boast poetic surroundings and offer a view of the  sea. Quietly located at our resort, these 39 meters squared thatched and  straw-earthen-walled bungalows are great hideouts for romantic  getaways.</p>\r\n<p style=\"text-align: justify;\">Your can enjoy reading on the balcony,  resting in the bedroom, or treating yourself to a refreshing bath—all  the while finding peace. Honeymooners wouldn’t find anything sweeter.</p>\r\n<p>Roomsize: 39 sq. meters.</p>\r\n<p style=\"text-align: justify;\">Price: 6,213,000 VND</p>\r\n</div>',1,2,1,2,0.00,0.00,1,1,1,39.00,'','4_icon_dd4zusbjtnqf9kmz4t50.jpg','4_icon_dd4zusbjtnqf9kmz4t50_thumb.jpg','4_view1_wbbj96juku3ydvdl9mlh.jpg','4_view1_wbbj96juku3ydvdl9mlh_thumb.jpg','4_view2_jmv10unz05d63jjbgq4n.jpg','4_view2_jmv10unz05d63jjbgq4n_thumb.jpg','','','4_view4_lorefhaeu62qvzvv25p2.jpg','4_view4_lorefhaeu62qvzvv25p2_thumb.jpg','','',1,1);
/*!40000 ALTER TABLE `aphs_rooms` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_rooms_availabilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_rooms_availabilities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(10) unsigned NOT NULL DEFAULT '0',
  `y` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 - current year, 1 - next year',
  `m` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `d1` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d2` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d3` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d4` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d5` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d6` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d7` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d8` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d9` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d10` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d11` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d12` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d13` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d14` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d15` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d16` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d17` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d18` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d19` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d20` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d21` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d22` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d23` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d24` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d25` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d26` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d27` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d28` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d29` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d30` smallint(6) unsigned NOT NULL DEFAULT '0',
  `d31` smallint(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  KEY `y` (`y`),
  KEY `m` (`m`)
) ENGINE=MyISAM AUTO_INCREMENT=385 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_rooms_availabilities` WRITE;
/*!40000 ALTER TABLE `aphs_rooms_availabilities` DISABLE KEYS */;
INSERT INTO `aphs_rooms_availabilities` VALUES (240,10,1,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (239,10,1,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (238,10,1,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (237,10,1,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (236,10,1,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (235,10,1,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (234,10,1,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (233,10,1,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (232,10,1,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (231,10,1,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (230,10,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (229,10,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (228,10,0,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (227,10,0,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (226,10,0,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (225,10,0,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (224,10,0,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (223,10,0,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (222,10,0,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (221,10,0,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (220,10,0,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (219,10,0,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (218,10,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (217,10,0,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (168,7,1,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (167,7,1,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (166,7,1,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (165,7,1,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (164,7,1,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (163,7,1,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (162,7,1,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (161,7,1,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (160,7,1,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (159,7,1,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (158,7,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (157,7,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (156,7,0,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (155,7,0,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (154,7,0,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (153,7,0,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (152,7,0,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (151,7,0,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (150,7,0,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (149,7,0,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (148,7,0,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (147,7,0,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (146,7,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (145,7,0,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (264,11,1,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (263,11,1,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (262,11,1,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (261,11,1,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (260,11,1,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (259,11,1,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (258,11,1,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (257,11,1,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (256,11,1,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (255,11,1,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (254,11,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (253,11,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (252,11,0,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (251,11,0,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (250,11,0,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (249,11,0,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (248,11,0,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (247,11,0,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (246,11,0,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (245,11,0,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (244,11,0,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (243,11,0,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (242,11,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (241,11,0,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (121,6,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (122,6,0,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (123,6,0,3,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (124,6,0,4,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (125,6,0,5,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (126,6,0,6,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (127,6,0,7,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (128,6,0,8,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (129,6,0,9,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (130,6,0,10,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (131,6,0,11,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (132,6,0,12,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (133,6,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (134,6,1,2,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (135,6,1,3,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (136,6,1,4,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (137,6,1,5,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (138,6,1,6,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (139,6,1,7,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (140,6,1,8,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (141,6,1,9,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (142,6,1,10,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (143,6,1,11,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (144,6,1,12,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
INSERT INTO `aphs_rooms_availabilities` VALUES (265,12,0,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (266,12,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (267,12,0,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (268,12,0,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (269,12,0,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (270,12,0,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (271,12,0,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (272,12,0,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (273,12,0,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (274,12,0,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (275,12,0,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (276,12,0,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (277,12,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (278,12,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (279,12,1,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (280,12,1,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (281,12,1,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (282,12,1,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (283,12,1,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (284,12,1,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (285,12,1,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (286,12,1,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (287,12,1,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (288,12,1,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (289,13,0,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (290,13,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (291,13,0,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (292,13,0,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (293,13,0,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (294,13,0,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (295,13,0,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (296,13,0,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (297,13,0,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (298,13,0,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (299,13,0,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (300,13,0,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (301,13,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (302,13,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (303,13,1,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (304,13,1,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (305,13,1,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (306,13,1,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (307,13,1,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (308,13,1,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (309,13,1,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (310,13,1,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (311,13,1,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (312,13,1,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (313,14,0,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (314,14,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (315,14,0,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (316,14,0,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (317,14,0,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (318,14,0,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (319,14,0,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (320,14,0,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (321,14,0,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (322,14,0,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (323,14,0,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (324,14,0,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (325,14,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (326,14,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (327,14,1,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (328,14,1,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (329,14,1,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (330,14,1,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (331,14,1,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (332,14,1,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (333,14,1,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (334,14,1,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (335,14,1,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (336,14,1,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (337,15,0,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (338,15,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (339,15,0,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (340,15,0,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (341,15,0,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (342,15,0,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (343,15,0,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (344,15,0,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (345,15,0,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (346,15,0,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (347,15,0,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (348,15,0,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (349,15,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (350,15,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (351,15,1,3,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (352,15,1,4,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (353,15,1,5,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (354,15,1,6,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (355,15,1,7,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (356,15,1,8,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (357,15,1,9,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (358,15,1,10,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (359,15,1,11,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
INSERT INTO `aphs_rooms_availabilities` VALUES (360,15,1,12,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2);
/*!40000 ALTER TABLE `aphs_rooms_availabilities` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_rooms_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_rooms_description` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `room_id` int(10) NOT NULL DEFAULT '0',
  `language_id` varchar(2) CHARACTER SET latin1 NOT NULL DEFAULT 'en',
  `room_type` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `room_short_description` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `room_long_description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`room_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_rooms_description` WRITE;
/*!40000 ALTER TABLE `aphs_rooms_description` DISABLE KEYS */;
INSERT INTO `aphs_rooms_description` VALUES (41,14,'vi','Queen','<p>Queen</p>','<p style=\"text-align: justify;\">Our  charming and contemporary Queen rooms are located in the villa section  of Bamboo Village. Measuring 38 meters squared, each room offers a  sophisticated grade of luxury fit for a queen with bath vanities and  tub, a stylized bamboo ceiling, and bedside amenities. Every color,  tone, and shape was deliberately placed. Access to the health and beauty  spa with its assortment of plants and flowers are only steps away. The  Queen room is a masterpiece with extraordinary detail, pleasures, and  privacy.</p>\r\n<p>Roomsize: 38 sq. meters.</p>\r\n<p>Price: 3,588,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (42,15,'vi','Gardenview Bungalows - Hawaiian','<p>Gardenview Bungalows - Hawaiian</p>','<p style=\"text-align: justify;\">These  stylish and harmonious bungalows are hidden royal luxuries featuring  bamboo-themed designs. Their graceful interiors and décor also feature  opulent bamboo flooring, creating a botanical painting-like ambiance.  These Hawaiian bungalows collectively form a seasisde village where  guests can enjoy tropical warmth while maintaining privacy.</p>\r\n<p style=\"text-align: justify;\">These  rooms are wonderful for those who love staying in and are great for  romantic getaways. The spa, swimming pool and Jacuzzi are also a short  walk away.</p>\r\n<p>Roomsize: 34 sq. meters.</p>\r\n<p>Price: 4,743,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (43,6,'vi','Honeyed type','<p>Honeyed type</p>','<div class=\"detail-content\">\r\n<p style=\"text-align: justify;\">Sweet  like its namesake, our Honeyed Type Beach Front Bungalows are a  marriage of classical and modern ideas of how bungalows are constructed  both architecturally and functionally. They boast poetic surroundings  and offer a view of the sea. Quietly located at our resort, these 39  meters squared thatched and straw-earthen-walled bungalows are great  hideouts for romantic getaways.</p>\r\n<p style=\"text-align: justify;\">Your  can enjoy reading on the balcony, resting in the bedroom, or treating  yourself to a refreshing bath—all the while finding peace. Honeymooners  wouldn’t find anything sweeter.</p>\r\n<p>Roomsize: 39 sq. meters.</p>\r\n<p style=\"text-align: justify;\">Price: 6,213,000 VND</p>\r\n</div>');
INSERT INTO `aphs_rooms_description` VALUES (40,13,'vi','Prince Suites','<p>Prince Suites</p>','<p style=\"text-align: justify;\">Our  Prince Suites are located upstairs and have thatched roofs with plank  flooring. Each room is spacious a spacious 56 meters squared filled with  royal interiors. They are accommodating for active individuals while  having all of the necessities of modern life.</p>\r\n<p style=\"text-align: justify;\">With  a meticulously designed skylight in the bathroom, it appears more like  an indoor spa than a bath. Rich gardens surrounding the pool are located  downstairs. Private pool view balconies are heavenly corners for  relaxation. Everything about the Prince Suite promotes an enjoyable  ambiance.</p>\r\n<p>Roomsize: 56 sq. meters.</p>\r\n<p>Price: 5,478,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (38,11,'vi','Gardenview Bungalows - Deluxe','<p>Gardenview Bungalows - Deluxe</p>','<p style=\"text-align: justify;\">Thatched  bungalows can be seen from the main path of the village as well as a  botanical stream. They feature a mix of classic and modern touches,  superb for bungalow lovers. Every piece of furniture and detailed décor  display the highest level of luxury and elegance. The stylish open bath  allows for a brimful of fresh air. Everything here is wonderfully  relaxing, from the cozy bedroom to the breezy private balcony. The  swimming pool, only a few steps away, further enhances one’s experience.</p>\r\n<p>Roomsize: 39 sq. meters.</p>\r\n<p>Price: 4,743,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (39,12,'vi','Nova Deluxe','<p>Nova Deluxe</p>','<p style=\"text-align: justify;\">Our  Nova Deluxe rooms can be found on the newest wing of Bamboo Village.  Each room measures 35 meters squared. The distinguishing feature  includes state-of-the-art conveniences. These rooms are specially  designed for those looking for all the comforts of home, but in a modern  resort atmosphere. These rooms make a great choice for MICE groups.  Tranquil views of the garden and village can be enjoyed from private  balconies where guests find peace throughout their stay.</p>\r\n<p>Roomsize: 35 sq. meters.</p>\r\n<p>Price: 3,798,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (37,10,'vi','Dove Cottages','<p>Dove Cottages</p>','<p style=\"text-align: justify;\">Quietly  situated, our Dove Cottages offer pleasant isolation. The small garden  in front makes you feel one with nature. Views of the Street of Foreign  Travellers allow guests a look at local foot traffic and nightlife. One  of the resort’s two swimming pools is nearby.</p>\r\n<p style=\"text-align: justify;\">These  recently updated cottages each measure 32 meters squared. They meet the  demands of guests who enjoy a homelike atmosphere as well as privacy  from their surroundings. They’re best suited for vacationing families  and small groups of friends who love spending all day on the beach or  around the pool.</p>\r\n<p>Roomsize: 32 sq. meters.</p>\r\n<p>Price: 2,433,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (34,7,'vi','Windy type','<p>Windy type tiếng việt</p>','<p style=\"text-align: justify;\">tiếng việt</p>\r\n<p style=\"text-align: justify;\">Our  Beach Front Bungalows inspire guests with elegance and simplicity. Each  thatched bungalow measures 44 meters squared and is constructed with  the most sophisticated of techniques. They capture the eternal values of  traditional Vietnamese straw-earthen-walled cottages and are  highlighted with bamboo beauty.</p>\r\n<p style=\"text-align: justify;\">Enjoy  specially designed flora all about, oceanic splendor from the patio,  and an open-air bath with miniature landscape inside. All these luxuries  will have you feeling relaxed and refreshed in no time. These bungalows  are only a few steps to the beach, pool, bar, and gym—too great a  location to pass up.</p>\r\n<p>Roomsize: 44 sq. meters.</p>\r\n<p>Price: 6,213,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (23,7,'en','Windy type','<p>Windy type</p>','<p style=\"text-align: justify;\">Our  Beach Front Bungalows inspire guests with elegance and simplicity. Each  thatched bungalow measures 44 meters squared and is constructed with  the most sophisticated of techniques. They capture the eternal values of  traditional Vietnamese straw-earthen-walled cottages and are  highlighted with bamboo beauty.</p>\r\n<p style=\"text-align: justify;\">Enjoy  specially designed flora all about, oceanic splendor from the patio,  and an open-air bath with miniature landscape inside. All these luxuries  will have you feeling relaxed and refreshed in no time. These bungalows  are only a few steps to the beach, pool, bar, and gym—too great a  location to pass up.</p>\r\n<p>Roomsize: 44 sq. meters.</p>\r\n<p>Price: 6,213,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (26,10,'en','Dove Cottages','<p>Dove Cottages</p>','<p style=\"text-align: justify;\">Separetedly situated, our Dove Cottages  offer pleasant isolation. The small garden in front makes you feel one  with nature.  One of the resort’s two swimming pools is nearby.</p>\r\n<p style=\"text-align: justify;\">These recently updated cottages each  measure 32 meters squared. They meet the demands of guests who enjoy a  homelike atmosphere as well as privacy from their surroundings. They’re  best suited for vacationing families and small groups of friends who  love spending all day on the beach or around the pool.</p>\r\n<p style=\"text-align: justify;\">Roomsize: 32 sq. meters.</p>\r\n<p style=\"text-align: justify;\">Price: 2,433,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (27,11,'en','Gardenview Bungalows - Deluxe','<p>Gardenview Bungalows - Deluxe</p>','<p style=\"text-align: justify;\">Thatched  bungalows can be seen from the main path of the village as well as a  botanical stream. They feature a mix of classic and modern touches,  superb for bungalow lovers. Every piece of furniture and detailed décor  display the highest level of luxury and elegance. The stylish open bath  allows for a brimful of fresh air. Everything here is wonderfully  relaxing, from the cozy bedroom to the breezy private balcony. The  swimming pool, only a few steps away, further enhances one’s experience.</p>\r\n<p>Roomsize: 39 sq. meters.</p>\r\n<p>Price: 4,743,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (28,12,'en','Nova Deluxe','<p>Nova Deluxe</p>','<p style=\"text-align: justify;\">Our  Nova Deluxe rooms can be found on the newest wing of Bamboo Village.  Each room measures 35 meters squared. The distinguishing feature  includes state-of-the-art conveniences. These rooms are specially  designed for those looking for all the comforts of home, but in a modern  resort atmosphere. These rooms make a great choice for MICE groups.  Tranquil views of the garden and village can be enjoyed from private  balconies where guests find peace throughout their stay.</p>\r\n<p>Roomsize: 35 sq. meters.</p>\r\n<p>Price: 3,798,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (29,13,'en','Junior Suite','<p>Junior Suite</p>','<p style=\"text-align: justify;\">Our Junior Suites are located upstairs  and have thatched roofs with plank flooring. Each room is spacious a  spacious 56 meters squared filled with royal interiors. They are  accommodating for active individuals while having all of the necessities  of modern life.</p>\r\n<p style=\"text-align: justify;\">With a meticulously designed skylight in  the bathroom, it appears more like an indoor spa than a bath. Rich  gardens surrounding the pool are located downstairs. Private pool view  balconies are heavenly corners for relaxation. Everything about the  Prince Suite promotes an enjoyable ambiance.</p>\r\n<p>Roomsize: 56 sq. meters.</p>\r\n<p>Price: 5,478,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (30,14,'en','Deluxe Room','<p>Deluxe Room</p>','<p style=\"text-align: justify;\">Our Deluxe rooms keep up with modern  demands for luxurious comfort at a seaside resort. Each room measures  from 32 – 38 meters squared and feature thatched roofs with a view of  the garden. Romantic yet functional, the bamboo interior décor is not to  be overlooked.</p>\r\n<p style=\"text-align: justify;\">From the rails to the inside corners,  you will genuinely feel relaxed the moment you enter. The greenery  outside serves as a natural air-conditioner. The feeling of bliss can  also be felt with the sunlit swimming pool at your doorstep. Access to  the health and beauty spa with its assortment of plants and flowers are  only steps away.</p>\r\n<p style=\"text-align: justify;\">Roomsize: 32 – 38 sq. meters.</p>\r\n<p style=\"text-align: justify;\">Price: 3,588,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (31,15,'en','Gardenview Bungalows - Hawaiian','<p>Gardenview Bungalows - Hawaiian</p>','<p style=\"text-align: justify;\">These  stylish and harmonious bungalows are hidden royal luxuries featuring  bamboo-themed designs. Their graceful interiors and décor also feature  opulent bamboo flooring, creating a botanical painting-like ambiance.  These Hawaiian bungalows collectively form a seasisde village where  guests can enjoy tropical warmth while maintaining privacy.</p>\r\n<p style=\"text-align: justify;\">These  rooms are wonderful for those who love staying in and are great for  romantic getaways. The spa, swimming pool and Jacuzzi are also a short  walk away.</p>\r\n<p>Roomsize: 34 sq. meters.</p>\r\n<p>Price: 4,743,000 VND</p>');
INSERT INTO `aphs_rooms_description` VALUES (22,6,'en','Honeyed type','<p>Honeyed type</p>','<div class=\"detail-content\">\r\n<p style=\"text-align: justify;\">Sweet  like its namesake, our Honeyed Type Beach Front Bungalows are a  marriage of classical and modern ideas of how bungalows are constructed  both architecturally and functionally. They boast poetic surroundings  and offer a view of the sea. Quietly located at our resort, these 39  meters squared thatched and straw-earthen-walled bungalows are great  hideouts for romantic getaways.</p>\r\n<p style=\"text-align: justify;\">Your  can enjoy reading on the balcony, resting in the bedroom, or treating  yourself to a refreshing bath—all the while finding peace. Honeymooners  wouldn’t find anything sweeter.</p>\r\n<p>Roomsize: 39 sq. meters.</p>\r\n<p style=\"text-align: justify;\">Price: 6,213,000 VND</p>\r\n</div>');
/*!40000 ALTER TABLE `aphs_rooms_description` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_rooms_prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_rooms_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(10) unsigned NOT NULL DEFAULT '0',
  `date_from` date DEFAULT '0000-00-00',
  `date_to` date DEFAULT '0000-00-00',
  `adults` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `children` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `guest_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `mon` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tue` decimal(10,2) NOT NULL DEFAULT '0.00',
  `wed` decimal(10,2) NOT NULL DEFAULT '0.00',
  `thu` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fri` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sat` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sun` decimal(10,2) NOT NULL DEFAULT '0.00',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_rooms_prices` WRITE;
/*!40000 ALTER TABLE `aphs_rooms_prices` DISABLE KEYS */;
INSERT INTO `aphs_rooms_prices` VALUES (10,10,'0000-00-00','0000-00-00',0,0,860000.00,2433000.00,2433000.00,2433000.00,2433000.00,2433000.00,2433000.00,2433000.00,1);
INSERT INTO `aphs_rooms_prices` VALUES (7,7,'0000-00-00','0000-00-00',0,0,860000.00,6213000.00,6213000.00,6213000.00,6213000.00,6213000.00,6213000.00,6213000.00,1);
INSERT INTO `aphs_rooms_prices` VALUES (11,11,'0000-00-00','0000-00-00',0,0,860000.00,4743000.00,4743000.00,4743000.00,4743000.00,4743000.00,4743000.00,4743000.00,1);
INSERT INTO `aphs_rooms_prices` VALUES (6,6,'0000-00-00','0000-00-00',0,0,860000.00,6213000.00,6213000.00,6213000.00,6213000.00,6213000.00,6213000.00,6213000.00,1);
INSERT INTO `aphs_rooms_prices` VALUES (12,12,'0000-00-00','0000-00-00',0,0,860000.00,3798000.00,3798000.00,3798000.00,3798000.00,3798000.00,3798000.00,3798000.00,1);
INSERT INTO `aphs_rooms_prices` VALUES (13,13,'0000-00-00','0000-00-00',0,0,860000.00,5478000.00,5478000.00,5478000.00,5478000.00,5478000.00,5478000.00,5478000.00,1);
INSERT INTO `aphs_rooms_prices` VALUES (14,14,'0000-00-00','0000-00-00',0,0,860000.00,3588000.00,3588000.00,3588000.00,3588000.00,3588000.00,3588000.00,3588000.00,1);
INSERT INTO `aphs_rooms_prices` VALUES (15,15,'0000-00-00','0000-00-00',0,0,860000.00,4743000.00,4743000.00,4743000.00,4743000.00,4743000.00,4743000.00,4743000.00,1);
INSERT INTO `aphs_rooms_prices` VALUES (17,10,'2014-08-10','2014-10-31',3,2,860000.00,1460000.00,1460000.00,1460000.00,1460000.00,1460000.00,1460000.00,1460000.00,0);
INSERT INTO `aphs_rooms_prices` VALUES (18,11,'2014-08-10','2014-10-31',3,2,860000.00,2846000.00,2846000.00,2846000.00,2846000.00,2846000.00,2846000.00,2846000.00,0);
INSERT INTO `aphs_rooms_prices` VALUES (19,13,'2014-08-10','2014-10-31',4,2,860000.00,3287000.00,3287000.00,3287000.00,3287000.00,3287000.00,3287000.00,3287000.00,0);
INSERT INTO `aphs_rooms_prices` VALUES (20,14,'2014-08-10','2014-10-31',3,2,860000.00,2153000.00,2153000.00,2153000.00,2153000.00,2153000.00,2153000.00,2153000.00,0);
INSERT INTO `aphs_rooms_prices` VALUES (21,15,'2014-08-10','2014-10-31',3,2,860.00,2846000.00,2846000.00,2846000.00,2846000.00,2846000.00,2846000.00,2846000.00,0);
INSERT INTO `aphs_rooms_prices` VALUES (22,6,'2014-08-10','2014-10-31',2,2,860000.00,3728000.00,3728000.00,3728000.00,3728000.00,3728000.00,3728000.00,3728000.00,0);
INSERT INTO `aphs_rooms_prices` VALUES (24,12,'2014-08-10','2014-10-31',3,2,860000.00,2279000.00,2279000.00,2279000.00,2279000.00,2279000.00,2279000.00,2279000.00,0);
INSERT INTO `aphs_rooms_prices` VALUES (25,7,'2014-08-21','2014-10-31',2,2,860000.00,3728000.00,3728000.00,3728000.00,3728000.00,3728000.00,3728000.00,3728000.00,0);
/*!40000 ALTER TABLE `aphs_rooms_prices` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_search_wordlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_search_wordlist` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `word_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `word_count` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `word_text` (`word_text`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_search_wordlist` WRITE;
/*!40000 ALTER TABLE `aphs_search_wordlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `aphs_search_wordlist` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_settings` (
  `id` smallint(6) NOT NULL,
  `template` varchar(32) CHARACTER SET latin1 NOT NULL,
  `ssl_mode` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 - no, 1 - entire site, 2 - admin, 3 - customer & payment modules',
  `seo_urls` tinyint(1) NOT NULL DEFAULT '1',
  `date_format` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'dd/mm/yyyy',
  `time_zone` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `price_format` enum('european','american') CHARACTER SET latin1 NOT NULL,
  `week_start_day` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `admin_email` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `mailer` varchar(20) CHARACTER SET latin1 NOT NULL DEFAULT 'php_mail_standard',
  `mailer_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `mailer_wysiwyg_type` enum('none','tinymce') CHARACTER SET latin1 NOT NULL DEFAULT 'none',
  `smtp_secure` enum('ssl','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ssl',
  `smtp_host` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_port` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_username` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `wysiwyg_type` enum('none','openwysiwyg','tinymce') CHARACTER SET latin1 NOT NULL DEFAULT 'openwysiwyg',
  `rss_feed` tinyint(1) NOT NULL DEFAULT '1',
  `rss_feed_type` enum('rss1','rss2','atom') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'rss1',
  `rss_last_ids` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_offline` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `caching_allowed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cache_lifetime` tinyint(3) unsigned NOT NULL DEFAULT '5' COMMENT 'in minutes',
  `offline_message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `google_rank` varchar(2) CHARACTER SET latin1 NOT NULL,
  `alexa_rank` varchar(12) CHARACTER SET latin1 NOT NULL,
  `cron_type` enum('batch','non-batch','stop') CHARACTER SET latin1 NOT NULL DEFAULT 'non-batch',
  `cron_run_last_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cron_run_period` enum('minute','hour') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'minute',
  `cron_run_period_value` smallint(6) unsigned NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_settings` WRITE;
/*!40000 ALTER TABLE `aphs_settings` DISABLE KEYS */;
INSERT INTO `aphs_settings` VALUES (0,'modern',0,0,'dd/mm/yyyy','7','american',2,'contact@bamboovillageresortvn.com','smtp','php_mail_standard','tinymce','no','mail.bamboovillageresortvn.com','25','contact@bamboovillageresortvn.com','14langtre','openwysiwyg',1,'rss2','1',0,0,5,'Our website is currently offline for maintenance. Please visit us later.','-1','0','non-batch','2014-12-31 18:04:36','hour',24);
/*!40000 ALTER TABLE `aphs_settings` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_site_description`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_site_description` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `language_id` varchar(2) CHARACTER SET latin1 NOT NULL,
  `header_text` text COLLATE utf8_unicode_ci NOT NULL,
  `slogan_text` text COLLATE utf8_unicode_ci NOT NULL,
  `footer_text` text COLLATE utf8_unicode_ci NOT NULL,
  `tag_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag_description` text COLLATE utf8_unicode_ci NOT NULL,
  `tag_keywords` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_site_description` WRITE;
/*!40000 ALTER TABLE `aphs_site_description` DISABLE KEYS */;
INSERT INTO `aphs_site_description` VALUES (1,'en','Bamboo Village','Beach Resort & Spa','© 2014 Bamboo Village Beach Resort & Spa. All rights reserved. Power by <a class=\"footer_link\" href=\"#\">NTDT</a>','Bamboo Village','Bamboo Village','hotel, online booking, Bamboo Village');
INSERT INTO `aphs_site_description` VALUES (5,'ru','Bamboo Village','Beach Resort &Spa','© 2014 Bamboo Village Beach Resort & Spa. All rights reserved. Power by <a class=\"footer_link\" href=\"#\">Blackdragon</a>','Bamboo Village','Bamboo Village','hotel, online booking, Bamboo Village');
INSERT INTO `aphs_site_description` VALUES (4,'vi','Làng Tre','Khu bãi biển nghỉ mát & Spa','© 2014 Bamboo Village Beach Resort & Spa. All rights reserved. Power by <a class=\"footer_link\" href=\"#\">NTDT</a>','Bamboo Village','Bamboo Village','hotel, online booking, Bamboo Village');
/*!40000 ALTER TABLE `aphs_site_description` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `author_country` varchar(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `author_city` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `author_email` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `testimonial_text` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `priority_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_testimonials` WRITE;
/*!40000 ALTER TABLE `aphs_testimonials` DISABLE KEYS */;
INSERT INTO `aphs_testimonials` VALUES (1,'Roberto','IT','Rome','roberto@email.com','Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.',1,0);
INSERT INTO `aphs_testimonials` VALUES (2,'Hantz','DE','Munich','hantz@email.com','Typi non habent claritatem insitam est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt lectores legere me lius quod ii legunt saepius.',1,1);
INSERT INTO `aphs_testimonials` VALUES (3,'Lilian','GB','London','lilian@email.com','Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.',1,3);
INSERT INTO `aphs_testimonials` VALUES (4,'Debora','US','','debora@email.com','Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',1,2);
/*!40000 ALTER TABLE `aphs_testimonials` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `aphs_vocabulary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aphs_vocabulary` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `language_id` varchar(3) CHARACTER SET latin1 NOT NULL,
  `key_value` varchar(50) CHARACTER SET latin1 NOT NULL,
  `key_text` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `voc_item` (`language_id`,`key_value`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5711 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `aphs_vocabulary` WRITE;
/*!40000 ALTER TABLE `aphs_vocabulary` DISABLE KEYS */;
INSERT INTO `aphs_vocabulary` VALUES (2,'en','_2CO_NOTICE','2CheckOut.com Inc. (Ohio, USA) is an authorized retailer for goods and services.');
INSERT INTO `aphs_vocabulary` VALUES (5204,'ru','_MS_CUSTOMERS_IMAGE_VERIFICATION','Specifies whether to allow image verification (captcha) on customer registration page');
INSERT INTO `aphs_vocabulary` VALUES (5,'en','_2CO_ORDER','2CO Order');
INSERT INTO `aphs_vocabulary` VALUES (8,'en','_ABBREVIATION','Abbreviation');
INSERT INTO `aphs_vocabulary` VALUES (11,'en','_ABOUT_US','About Us');
INSERT INTO `aphs_vocabulary` VALUES (14,'en','_ACCESS','Access');
INSERT INTO `aphs_vocabulary` VALUES (5203,'ru','_MS_CUSTOMERS_CANCEL_RESERVATION','Specifies the number of days before customers may cancel a reservation');
INSERT INTO `aphs_vocabulary` VALUES (4241,'vi','_PAYPAL_NOTICE','Save time. Pay securely using your stored payment information.<br />Pay with <b>credit card</b>, <b>bank account</b> or <b>PayPal</b> account balance.');
INSERT INTO `aphs_vocabulary` VALUES (17,'en','_ACCESSIBLE_BY','Accessible By');
INSERT INTO `aphs_vocabulary` VALUES (4240,'vi','_PAYPAL','PayPal');
INSERT INTO `aphs_vocabulary` VALUES (20,'en','_ACCOUNTS','Accounts');
INSERT INTO `aphs_vocabulary` VALUES (4239,'vi','_PAYMENT_TYPE','Payment Type');
INSERT INTO `aphs_vocabulary` VALUES (23,'en','_ACCOUNTS_MANAGEMENT','Accounts');
INSERT INTO `aphs_vocabulary` VALUES (4237,'vi','_PAYMENT_REQUIRED','Payment Required');
INSERT INTO `aphs_vocabulary` VALUES (4238,'vi','_PAYMENT_SUM','Payment Sum');
INSERT INTO `aphs_vocabulary` VALUES (26,'en','_ACCOUNT_ALREADY_RESET','Your account was already reset! Please check your email inbox for more information.');
INSERT INTO `aphs_vocabulary` VALUES (5201,'ru','_MS_COMMENTS_PAGE_SIZE','Defines how much comments will be shown on one page');
INSERT INTO `aphs_vocabulary` VALUES (5202,'ru','_MS_CONTACT_US_KEY','The keyword that will be replaced with Contact Us form (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (4232,'vi','_PAYMENT_COMPANY_ACCOUNT','Payment Company Account');
INSERT INTO `aphs_vocabulary` VALUES (4233,'vi','_PAYMENT_DATE','Payment Date');
INSERT INTO `aphs_vocabulary` VALUES (4234,'vi','_PAYMENT_DETAILS','Payment Details');
INSERT INTO `aphs_vocabulary` VALUES (4235,'vi','_PAYMENT_ERROR','Payment error');
INSERT INTO `aphs_vocabulary` VALUES (4236,'vi','_PAYMENT_METHOD','Payment Method');
INSERT INTO `aphs_vocabulary` VALUES (29,'en','_ACCOUNT_CREATED_CONF_BY_ADMIN_MSG','Your account has been successfully created! In a few minutes you should receive an email, containing the details of your account. <br><br> After approval your registration by administrator, you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (5198,'ru','_MS_BOOKING_NUMBER_TYPE','Specifies the type of booking numbers');
INSERT INTO `aphs_vocabulary` VALUES (5199,'ru','_MS_COMMENTS_ALLOW','Specifies whether to allow comments to articles');
INSERT INTO `aphs_vocabulary` VALUES (5200,'ru','_MS_COMMENTS_LENGTH','The maximum length of a comment');
INSERT INTO `aphs_vocabulary` VALUES (4227,'vi','_PASSWORD_SUCCESSFULLY_SENT','Your password has been successfully sent to the email address.');
INSERT INTO `aphs_vocabulary` VALUES (4228,'vi','_PAST_TIME_ALERT','You cannot perform reservation in the past! Please re-enter dates.');
INSERT INTO `aphs_vocabulary` VALUES (4229,'vi','_PAYED_BY','Payed by');
INSERT INTO `aphs_vocabulary` VALUES (4230,'vi','_PAYMENT','Payment');
INSERT INTO `aphs_vocabulary` VALUES (4231,'vi','_PAYMENTS','Payments');
INSERT INTO `aphs_vocabulary` VALUES (32,'en','_ACCOUNT_CREATED_CONF_BY_EMAIL_MSG','Your account has been successfully created! In a few minutes you should receive an email, containing the details of your registration. <br><br> Complete this registration, using the confirmation code that was sent to the provided email address, and you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (5195,'ru','_MS_BANNERS_CAPTION_HTML','Specifies whether to allow using of HTML in slideshow captions or not');
INSERT INTO `aphs_vocabulary` VALUES (5196,'ru','_MS_BANNERS_IS_ACTIVE','Defines whether banners module is active or not');
INSERT INTO `aphs_vocabulary` VALUES (5197,'ru','_MS_BOOKING_MODE','Specifies which mode is turned ON for booking');
INSERT INTO `aphs_vocabulary` VALUES (4225,'vi','_PASSWORD_NOT_CHANGED','Password was not changed. Please try again!');
INSERT INTO `aphs_vocabulary` VALUES (4226,'vi','_PASSWORD_RECOVERY_MSG','To recover your password, please enter your e-mail address and a link will be emailed to you.');
INSERT INTO `aphs_vocabulary` VALUES (35,'en','_ACCOUNT_CREATED_CONF_MSG','Your account was successfully created. <b>You will receive now an email</b>, containing the details of your account (it may take a few minutes).<br><br>After approval by an administrator, you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (5192,'ru','_MS_AUTHORIZE_TRANSACTION_KEY','Specifies Authorize.Net Transaction Key');
INSERT INTO `aphs_vocabulary` VALUES (5193,'ru','_MS_AVAILABLE_UNTIL_APPROVAL','Specifies whether to show \'reserved\' rooms in search results until booking is complete');
INSERT INTO `aphs_vocabulary` VALUES (5194,'ru','_MS_BANK_TRANSFER_INFO','Specifies a required banking information: name of the bank, branch, account number etc.');
INSERT INTO `aphs_vocabulary` VALUES (4224,'vi','_PASSWORD_IS_EMPTY','Passwords must not be empty and at least 6 characters!');
INSERT INTO `aphs_vocabulary` VALUES (38,'en','_ACCOUNT_CREATED_MSG','Your account was successfully created. <b>You will receive now a confirmation email</b>, containing the details of your account (it may take a few minutes). <br /><br />After completing the confirmation you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (5190,'ru','_MS_ALLOW_SYSTEM_SUGGESTION','Specifies whether to show system suggestion feature on empty search results');
INSERT INTO `aphs_vocabulary` VALUES (5191,'ru','_MS_AUTHORIZE_LOGIN_ID','Specifies Authorize.Net API Login ID');
INSERT INTO `aphs_vocabulary` VALUES (41,'en','_ACCOUNT_CREATED_NON_CONFIRM_LINK','Click <a href=index.php?customer=login>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (5189,'ru','_MS_ALLOW_GUESTS_IN_ROOM','Specifies whether to allow guests in the room');
INSERT INTO `aphs_vocabulary` VALUES (4220,'vi','_PASSWORD_CHANGED','Password was changed.');
INSERT INTO `aphs_vocabulary` VALUES (4221,'vi','_PASSWORD_DO_NOT_MATCH','Password and confirmation do not match!');
INSERT INTO `aphs_vocabulary` VALUES (4222,'vi','_PASSWORD_FORGOTTEN','Forgotten Password');
INSERT INTO `aphs_vocabulary` VALUES (4223,'vi','_PASSWORD_FORGOTTEN_PAGE_MSG','Use a valid administrator e-mail to restore your password to the Administrator Back-End.<br><br>Return to site <a href=\'index.php\'>Home Page</a><br><br><img align=\'center\' src=\'images/password.png\' alt=\'\' width=\'92px\'>');
INSERT INTO `aphs_vocabulary` VALUES (44,'en','_ACCOUNT_CREATED_NON_CONFIRM_MSG','Your account has been successfully created! For your convenience in a few minutes you will receive an email, containing the details of your registration (no confirmation required). <br><br>You may log into your account now.');
INSERT INTO `aphs_vocabulary` VALUES (5186,'ru','_MS_ALLOW_CUSTOMERS_LOGIN','Specifies whether to allow existing customers to login');
INSERT INTO `aphs_vocabulary` VALUES (5187,'ru','_MS_ALLOW_CUSTOMERS_REGISTRATION','Specifies whether to allow registration of new customers');
INSERT INTO `aphs_vocabulary` VALUES (5188,'ru','_MS_ALLOW_CUST_RESET_PASSWORDS','Specifies whether to allow customers to restore their passwords');
INSERT INTO `aphs_vocabulary` VALUES (4218,'vi','_PASSWORD','Password');
INSERT INTO `aphs_vocabulary` VALUES (4219,'vi','_PASSWORD_ALREADY_SENT','Password was already sent to your email. Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (47,'en','_ACCOUNT_CREATE_MSG','This registration process requires confirmation via email! <br />Please fill out the form below with correct information.');
INSERT INTO `aphs_vocabulary` VALUES (5185,'ru','_MS_ALLOW_CHILDREN_IN_ROOM','Specifies whether to allow children in the room');
INSERT INTO `aphs_vocabulary` VALUES (4217,'vi','_PARTIAL_PRICE','Partial Price');
INSERT INTO `aphs_vocabulary` VALUES (50,'en','_ACCOUNT_DETAILS','Account Details');
INSERT INTO `aphs_vocabulary` VALUES (5184,'ru','_MS_ALLOW_BOOKING_WITHOUT_ACCOUNT','Specifies whether to allow booking for customer without creating account');
INSERT INTO `aphs_vocabulary` VALUES (4214,'vi','_PAGE_UNKNOWN','Unknown page!');
INSERT INTO `aphs_vocabulary` VALUES (4215,'vi','_PARAMETER','Parameter');
INSERT INTO `aphs_vocabulary` VALUES (4216,'vi','_PARTIALLY_AVAILABLE','Partially Available');
INSERT INTO `aphs_vocabulary` VALUES (53,'en','_ACCOUNT_SUCCESSFULLY_RESET','You have successfully reset your account and username with temporary password have been sent to your email.');
INSERT INTO `aphs_vocabulary` VALUES (5183,'ru','_MS_ALLOW_ADDING_BY_ADMIN','Specifies whether to allow adding new customers by Admin');
INSERT INTO `aphs_vocabulary` VALUES (4213,'vi','_PAGE_TITLE','Page Title');
INSERT INTO `aphs_vocabulary` VALUES (56,'en','_ACCOUNT_TYPE','Account type');
INSERT INTO `aphs_vocabulary` VALUES (4212,'vi','_PAGE_TEXT','Page text');
INSERT INTO `aphs_vocabulary` VALUES (59,'en','_ACCOUNT_WAS_CREATED','Your account has been created');
INSERT INTO `aphs_vocabulary` VALUES (5182,'ru','_MS_ALERT_ADMIN_NEW_REGISTRATION','Specifies whether to alert admin on new customer registration');
INSERT INTO `aphs_vocabulary` VALUES (4210,'vi','_PAGE_RESTORE_WARNING','Are you sure you want to restore this page?');
INSERT INTO `aphs_vocabulary` VALUES (4211,'vi','_PAGE_SAVED','Page was successfully saved');
INSERT INTO `aphs_vocabulary` VALUES (62,'en','_ACCOUNT_WAS_DELETED','Your account was successfully removed! In seconds, you will be automatically redirected to the homepage.');
INSERT INTO `aphs_vocabulary` VALUES (5181,'ru','_MS_ALBUM_KEY','The keyword that will be replaced with a certain album images (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (65,'en','_ACCOUNT_WAS_UPDATED','Your account was successfully updated!');
INSERT INTO `aphs_vocabulary` VALUES (5180,'ru','_MS_ALBUM_ICON_WIDTH','Album icon width');
INSERT INTO `aphs_vocabulary` VALUES (4208,'vi','_PAGE_REMOVE_WARNING','Are you sure you want to move this page to the Trash?');
INSERT INTO `aphs_vocabulary` VALUES (4209,'vi','_PAGE_RESTORED','Page was successfully restored!');
INSERT INTO `aphs_vocabulary` VALUES (68,'en','_ACCOUT_CREATED_CONF_LINK','Already confirmed your registration? Click <a href=index.php?customer=login>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (5179,'ru','_MS_ALBUM_ICON_HEIGHT','Album icon height');
INSERT INTO `aphs_vocabulary` VALUES (4206,'vi','_PAGE_ORDER_CHANGED','Page order was successfully changed!');
INSERT INTO `aphs_vocabulary` VALUES (4207,'vi','_PAGE_REMOVED','Page was successfully removed!');
INSERT INTO `aphs_vocabulary` VALUES (71,'en','_ACCOUT_CREATED_CONF_MSG','Already confirmed your registration? Click <a href=index.php?customer=login>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (5178,'ru','_MS_ALBUMS_PER_LINE','Number of album icons per line');
INSERT INTO `aphs_vocabulary` VALUES (74,'en','_ACTIONS','Action');
INSERT INTO `aphs_vocabulary` VALUES (5177,'ru','_MS_ADMIN_CHANGE_USER_PASSWORD','Specifies whether to allow changing user password by Admin');
INSERT INTO `aphs_vocabulary` VALUES (4205,'vi','_PAGE_NOT_SAVED','Page was not saved!');
INSERT INTO `aphs_vocabulary` VALUES (77,'en','_ACTIONS_WORD','Action');
INSERT INTO `aphs_vocabulary` VALUES (4204,'vi','_PAGE_NOT_FOUND','No Pages Found');
INSERT INTO `aphs_vocabulary` VALUES (80,'en','_ACTION_REQUIRED','ACTION REQUIRED');
INSERT INTO `aphs_vocabulary` VALUES (4202,'vi','_PAGE_NOT_DELETED','Page was not deleted!');
INSERT INTO `aphs_vocabulary` VALUES (4203,'vi','_PAGE_NOT_EXISTS','The page you attempted to access does not exist');
INSERT INTO `aphs_vocabulary` VALUES (83,'en','_ACTIVATION_EMAIL_ALREADY_SENT','The activation email was already sent to your email. Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (5176,'ru','_MS_ADMIN_CHANGE_CUSTOMER_PASSWORD','Specifies whether to allow changing customer password by Admin');
INSERT INTO `aphs_vocabulary` VALUES (4200,'vi','_PAGE_MANAGEMENT','Pages Management');
INSERT INTO `aphs_vocabulary` VALUES (4201,'vi','_PAGE_NOT_CREATED','Page was not created!');
INSERT INTO `aphs_vocabulary` VALUES (86,'en','_ACTIVATION_EMAIL_WAS_SENT','An email has been sent to _EMAIL_ with an activation key. Please check your mail to complete registration.');
INSERT INTO `aphs_vocabulary` VALUES (5175,'ru','_MS_ADMIN_BOOKING_IN_PAST','Specifies whether to allow booking in the past for admins and hotel owners');
INSERT INTO `aphs_vocabulary` VALUES (89,'en','_ACTIVE','Active');
INSERT INTO `aphs_vocabulary` VALUES (4199,'vi','_PAGE_LINK_TOO_LONG','Menu link too long!');
INSERT INTO `aphs_vocabulary` VALUES (92,'en','_ADD','Add');
INSERT INTO `aphs_vocabulary` VALUES (5174,'ru','_MS_ACTIVATE_BOOKINGS','Specifies whether booking module is active on a Whole Site, Front-End/Back-End only or inactive');
INSERT INTO `aphs_vocabulary` VALUES (4198,'vi','_PAGE_KEY_EMPTY','Page key cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (95,'en','_ADDING_OPERATION_COMPLETED','The adding operation completed successfully!');
INSERT INTO `aphs_vocabulary` VALUES (5172,'ru','_MONTH','Month');
INSERT INTO `aphs_vocabulary` VALUES (5173,'ru','_MONTHS','Months');
INSERT INTO `aphs_vocabulary` VALUES (98,'en','_ADDITIONAL_GUEST_FEE','Additional Guest Fee');
INSERT INTO `aphs_vocabulary` VALUES (5171,'ru','_MONDAY','Monday');
INSERT INTO `aphs_vocabulary` VALUES (4197,'vi','_PAGE_HEADER_EMPTY','Page header cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (101,'en','_ADDITIONAL_INFO','Additional Info');
INSERT INTO `aphs_vocabulary` VALUES (5170,'ru','_MON','Mon');
INSERT INTO `aphs_vocabulary` VALUES (4196,'vi','_PAGE_HEADER','Page Header');
INSERT INTO `aphs_vocabulary` VALUES (104,'en','_ADDITIONAL_MODULES','Additional Modules');
INSERT INTO `aphs_vocabulary` VALUES (107,'en','_ADDITIONAL_PAYMENT','Additional Payment');
INSERT INTO `aphs_vocabulary` VALUES (4193,'vi','_PAGE_EDIT_PAGES','Edit Pages');
INSERT INTO `aphs_vocabulary` VALUES (4194,'vi','_PAGE_EDIT_SYS_PAGES','Edit System Pages');
INSERT INTO `aphs_vocabulary` VALUES (4195,'vi','_PAGE_EXPIRED','The page you requested has expired!');
INSERT INTO `aphs_vocabulary` VALUES (110,'en','_ADDITIONAL_PAYMENT_TOOLTIP','To apply an additional payment or admin discount enter into this field an appropriate value (positive or negative).');
INSERT INTO `aphs_vocabulary` VALUES (5168,'ru','_MODULE_UNINSTALLED','Module was successfully un-installed!');
INSERT INTO `aphs_vocabulary` VALUES (5169,'ru','_MODULE_UNINSTALL_ALERT','Are you sure you want to un-install this module? All data, related to this module will be permanently deleted form the system!');
INSERT INTO `aphs_vocabulary` VALUES (113,'en','_ADDRESS','Address');
INSERT INTO `aphs_vocabulary` VALUES (4192,'vi','_PAGE_EDIT_HOME','Edit Home Page');
INSERT INTO `aphs_vocabulary` VALUES (116,'en','_ADDRESS_2','Address (line 2)');
INSERT INTO `aphs_vocabulary` VALUES (4191,'vi','_PAGE_DELETE_WARNING','Are you sure you want to delete this page?');
INSERT INTO `aphs_vocabulary` VALUES (119,'en','_ADDRESS_EMPTY_ALERT','Address cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5167,'ru','_MODULE_INSTALL_ALERT','Are you sure you want to install this module?');
INSERT INTO `aphs_vocabulary` VALUES (122,'en','_ADD_NEW','Add New');
INSERT INTO `aphs_vocabulary` VALUES (5166,'ru','_MODULE_INSTALLED','Module was successfully installed!');
INSERT INTO `aphs_vocabulary` VALUES (4190,'vi','_PAGE_DELETED','Page was successfully deleted');
INSERT INTO `aphs_vocabulary` VALUES (125,'en','_ADD_NEW_MENU','Add New Menu');
INSERT INTO `aphs_vocabulary` VALUES (128,'en','_ADD_TO_CART','Add to Cart');
INSERT INTO `aphs_vocabulary` VALUES (5165,'ru','_MODULES_NOT_FOUND','No modules found!');
INSERT INTO `aphs_vocabulary` VALUES (131,'en','_ADD_TO_MENU','Add To Menu');
INSERT INTO `aphs_vocabulary` VALUES (4189,'vi','_PAGE_CREATED','Page was successfully created');
INSERT INTO `aphs_vocabulary` VALUES (134,'en','_ADMIN','Admin');
INSERT INTO `aphs_vocabulary` VALUES (5164,'ru','_MODULES_MANAGEMENT','Modules Management');
INSERT INTO `aphs_vocabulary` VALUES (137,'en','_ADMINISTRATOR_ONLY','Administrator Only');
INSERT INTO `aphs_vocabulary` VALUES (5163,'ru','_MODULES','Modules');
INSERT INTO `aphs_vocabulary` VALUES (4188,'vi','_PAGE_ADD_NEW','Add New Page');
INSERT INTO `aphs_vocabulary` VALUES (140,'en','_ADMINS','Admins');
INSERT INTO `aphs_vocabulary` VALUES (5162,'ru','_MO','Mo');
INSERT INTO `aphs_vocabulary` VALUES (4187,'vi','_PAGES','Pages');
INSERT INTO `aphs_vocabulary` VALUES (143,'en','_ADMINS_AND_CUSTOMERS','Customers & Admins');
INSERT INTO `aphs_vocabulary` VALUES (5161,'ru','_MINUTES','minutes');
INSERT INTO `aphs_vocabulary` VALUES (4186,'vi','_PAGE','Page');
INSERT INTO `aphs_vocabulary` VALUES (146,'en','_ADMINS_MANAGEMENT','Admins Management');
INSERT INTO `aphs_vocabulary` VALUES (149,'en','_ADMIN_EMAIL','Admin Email');
INSERT INTO `aphs_vocabulary` VALUES (4181,'vi','_OTHER','Other');
INSERT INTO `aphs_vocabulary` VALUES (4182,'vi','_OUR_LOCATION','Our location');
INSERT INTO `aphs_vocabulary` VALUES (4183,'vi','_OWNER','Owner');
INSERT INTO `aphs_vocabulary` VALUES (4184,'vi','_PACKAGES','Packages');
INSERT INTO `aphs_vocabulary` VALUES (4185,'vi','_PACKAGES_MANAGEMENT','Packages Management');
INSERT INTO `aphs_vocabulary` VALUES (152,'en','_ADMIN_EMAIL_ALERT','This email is used as \"From\" address for the system email notifications. Make sure, that you write here a valid email address based on domain of your site');
INSERT INTO `aphs_vocabulary` VALUES (5156,'ru','_META_TAGS','META Tags');
INSERT INTO `aphs_vocabulary` VALUES (5157,'ru','_METHOD','Method');
INSERT INTO `aphs_vocabulary` VALUES (5158,'ru','_MIN','Min');
INSERT INTO `aphs_vocabulary` VALUES (5159,'ru','_MINIMUM_NIGHTS','Minimum Nights');
INSERT INTO `aphs_vocabulary` VALUES (5160,'ru','_MINIMUM_NIGHTS_ALERT','The minimum allowed stay for the period of time from _FROM_ to _TO_ is _NIGHTS_ nights per booking. Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4180,'vi','_ORDER_PRICE','Order Price');
INSERT INTO `aphs_vocabulary` VALUES (155,'en','_ADMIN_EMAIL_EXISTS_ALERT','Administrator with such email already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (5155,'ru','_META_TAG','Meta Tag');
INSERT INTO `aphs_vocabulary` VALUES (4179,'vi','_ORDER_PLACED_MSG','Thank you! The order has been placed in our system and will be processed shortly. Your booking number is: _BOOKING_NUMBER_.');
INSERT INTO `aphs_vocabulary` VALUES (158,'en','_ADMIN_EMAIL_IS_EMPTY','Admin email must not be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5152,'ru','_MENU_WORD','Menu');
INSERT INTO `aphs_vocabulary` VALUES (5153,'ru','_MESSAGE','Message');
INSERT INTO `aphs_vocabulary` VALUES (5154,'ru','_MESSAGE_EMPTY_ALERT','Message cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4178,'vi','_ORDER_NOW','Order Now');
INSERT INTO `aphs_vocabulary` VALUES (161,'en','_ADMIN_EMAIL_WRONG','Admin email in wrong format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5151,'ru','_MENU_TITLE','Menu Title');
INSERT INTO `aphs_vocabulary` VALUES (164,'en','_ADMIN_LOGIN','Admin Login');
INSERT INTO `aphs_vocabulary` VALUES (5150,'ru','_MENU_SAVED','Menu was successfully saved');
INSERT INTO `aphs_vocabulary` VALUES (4176,'vi','_ORDER_DATE','Order Date');
INSERT INTO `aphs_vocabulary` VALUES (4177,'vi','_ORDER_ERROR','Cannot complete your order! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (167,'en','_ADMIN_MAILER_ALERT','Select which mailer you prefer to use for the delivery of site emails.');
INSERT INTO `aphs_vocabulary` VALUES (5148,'ru','_MENU_ORDER','Menu Order');
INSERT INTO `aphs_vocabulary` VALUES (5149,'ru','_MENU_ORDER_CHANGED','Menu order was successfully changed');
INSERT INTO `aphs_vocabulary` VALUES (4175,'vi','_ORDERS_COUNT','Orders count');
INSERT INTO `aphs_vocabulary` VALUES (170,'en','_ADMIN_PANEL','Admin Panel');
INSERT INTO `aphs_vocabulary` VALUES (4174,'vi','_ORDERS','Orders');
INSERT INTO `aphs_vocabulary` VALUES (173,'en','_ADMIN_RESERVATION','Admin Reservation');
INSERT INTO `aphs_vocabulary` VALUES (5147,'ru','_MENU_NOT_SAVED','Menu was not saved!');
INSERT INTO `aphs_vocabulary` VALUES (4155,'vi','_NO_TEMPLATE','no template');
INSERT INTO `aphs_vocabulary` VALUES (4156,'vi','_NO_USER_EMAIL_EXISTS_ALERT','It seems that you already booked rooms with us! <br>Please click <a href=index.php?customer=reset_account>here</a> to reset your username and get a temporary password. ');
INSERT INTO `aphs_vocabulary` VALUES (4157,'vi','_NO_WRITE_ACCESS_ALERT','Please check you have write access to following directories:');
INSERT INTO `aphs_vocabulary` VALUES (4158,'vi','_OCCUPANCY','Occupancy');
INSERT INTO `aphs_vocabulary` VALUES (4159,'vi','_OCTOBER','October');
INSERT INTO `aphs_vocabulary` VALUES (4160,'vi','_OFF','Off');
INSERT INTO `aphs_vocabulary` VALUES (4161,'vi','_OFFLINE_LOGIN_ALERT','To log into Admin Panel when site is offline, type in your browser: http://{your_site_address}/index.php?admin=login');
INSERT INTO `aphs_vocabulary` VALUES (4162,'vi','_OFFLINE_MESSAGE','Offline Message');
INSERT INTO `aphs_vocabulary` VALUES (4163,'vi','_ON','On');
INSERT INTO `aphs_vocabulary` VALUES (4164,'vi','_ONLINE','Online');
INSERT INTO `aphs_vocabulary` VALUES (4165,'vi','_ONLINE_ORDER','On-line Order');
INSERT INTO `aphs_vocabulary` VALUES (4166,'vi','_ONLY','Only');
INSERT INTO `aphs_vocabulary` VALUES (4167,'vi','_OPEN','Open');
INSERT INTO `aphs_vocabulary` VALUES (4168,'vi','_OPEN_ALERT_WINDOW','Open Alert Window');
INSERT INTO `aphs_vocabulary` VALUES (4169,'vi','_OPERATION_BLOCKED','This operation is blocked in Demo Version!');
INSERT INTO `aphs_vocabulary` VALUES (4170,'vi','_OPERATION_COMMON_COMPLETED','The operation was successfully completed!');
INSERT INTO `aphs_vocabulary` VALUES (4171,'vi','_OPERATION_WAS_ALREADY_COMPLETED','This operation was already completed!');
INSERT INTO `aphs_vocabulary` VALUES (4172,'vi','_OR','or');
INSERT INTO `aphs_vocabulary` VALUES (4173,'vi','_ORDER','Order');
INSERT INTO `aphs_vocabulary` VALUES (176,'en','_ADMIN_WELCOME_TEXT','<p>Welcome to Administrator Control Panel that allows you to add, edit or delete site content. With this Administrator Control Panel you can easy manage customers, reservations and perform a full hotel site management.</p><p><b>&#8226;</b> There are some modules for you: Backup & Restore, News. Installation or un-installation of them is possible from <a href=\'index.php?admin=modules\'>Modules Menu</a>.</p><p><b>&#8226;</b> In <a href=\'index.php?admin=languages\'>Languages Menu</a> you may add/remove language or change language settings and edit your vocabulary (the words and phrases, used by the system).</p><p><b>&#8226;</b> <a href=\'index.php?admin=settings\'>Settings Menu</a> allows you to define important settings for the site.</p><p><b>&#8226;</b> In <a href=\'index.php?admin=my_account\'>My Account</a> there is a possibility to change your info.</p><p><b>&#8226;</b> <a href=\'index.php?admin=menus\'>Menus</a> and <a href=\'index.php?admin=pages\'>Pages Management</a> are designed for creating and managing menus, links and pages.</p><p><b>&#8226;</b> To create and edit room types, seasons, prices, bookings and other hotel info, use <a href=\'index.php?admin=hotel_info\'>Hotel Management</a>, <a href=\'index.php?admin=rooms_management\'>Rooms Management</a> and <a href=\'index.php?admin=mod_booking_bookings\'>Bookings</a> menus.</p>');
INSERT INTO `aphs_vocabulary` VALUES (5128,'ru','_MD_TESTIMONIALS','The Testimonials Module allows the administrator of the site to add/edit customer testimonials, manage them and show on the Hotel Site frontend.');
INSERT INTO `aphs_vocabulary` VALUES (5129,'ru','_MEAL_PLANS','Meal Plans');
INSERT INTO `aphs_vocabulary` VALUES (5130,'ru','_MEAL_PLANS_MANAGEMENT','Meal Plans Management');
INSERT INTO `aphs_vocabulary` VALUES (5131,'ru','_MENUS','Menus');
INSERT INTO `aphs_vocabulary` VALUES (5132,'ru','_MENUS_AND_PAGES','Menus and Pages');
INSERT INTO `aphs_vocabulary` VALUES (5133,'ru','_MENU_ADD','Add Menu');
INSERT INTO `aphs_vocabulary` VALUES (5134,'ru','_MENU_CREATED','Menu was successfully created');
INSERT INTO `aphs_vocabulary` VALUES (5135,'ru','_MENU_DELETED','Menu was successfully deleted');
INSERT INTO `aphs_vocabulary` VALUES (5136,'ru','_MENU_DELETE_WARNING','Are you sure you want to delete this menu? Note: this will make all its menu links invisible to your site visitors!');
INSERT INTO `aphs_vocabulary` VALUES (5137,'ru','_MENU_EDIT','Edit Menu');
INSERT INTO `aphs_vocabulary` VALUES (5138,'ru','_MENU_LINK','Menu Link');
INSERT INTO `aphs_vocabulary` VALUES (5139,'ru','_MENU_LINK_TEXT','Menu Link (max. 40 chars)');
INSERT INTO `aphs_vocabulary` VALUES (5140,'ru','_MENU_MANAGEMENT','Menus Management');
INSERT INTO `aphs_vocabulary` VALUES (5141,'ru','_MENU_MISSED','Missed menu to update! Please, try again.');
INSERT INTO `aphs_vocabulary` VALUES (5142,'ru','_MENU_NAME','Menu Name');
INSERT INTO `aphs_vocabulary` VALUES (5143,'ru','_MENU_NAME_EMPTY','Menu name cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (5144,'ru','_MENU_NOT_CREATED','Menu was not created!');
INSERT INTO `aphs_vocabulary` VALUES (5145,'ru','_MENU_NOT_DELETED','Menu was not deleted!');
INSERT INTO `aphs_vocabulary` VALUES (5146,'ru','_MENU_NOT_FOUND','No Menus Found');
INSERT INTO `aphs_vocabulary` VALUES (179,'en','_ADULT','Adult');
INSERT INTO `aphs_vocabulary` VALUES (4154,'vi','_NO_ROOMS_FOUND','Sorry, there are no rooms that match your search. Please change your search criteria to see more rooms.');
INSERT INTO `aphs_vocabulary` VALUES (182,'en','_ADULTS','Adults');
INSERT INTO `aphs_vocabulary` VALUES (5127,'ru','_MD_ROOMS','The Rooms module allows the site owner easily manage rooms in your hotel: create, edit or remove them, specify room facilities, define prices and availability for certain period of time, etc.');
INSERT INTO `aphs_vocabulary` VALUES (185,'en','_ADVANCED','Advanced');
INSERT INTO `aphs_vocabulary` VALUES (4153,'vi','_NO_RECORDS_UPDATED','No records were updated!');
INSERT INTO `aphs_vocabulary` VALUES (188,'en','_AFTER_DISCOUNT','after discount');
INSERT INTO `aphs_vocabulary` VALUES (191,'en','_AGREE_CONF_TEXT','I have read and AGREE with Terms & Conditions');
INSERT INTO `aphs_vocabulary` VALUES (5126,'ru','_MD_PAGES','Pages module allows administrator to easily create and maintain page content.');
INSERT INTO `aphs_vocabulary` VALUES (194,'en','_ALBUM','Album');
INSERT INTO `aphs_vocabulary` VALUES (4152,'vi','_NO_RECORDS_PROCESSED','No records found for processing!');
INSERT INTO `aphs_vocabulary` VALUES (197,'en','_ALBUM_CODE','Album Code');
INSERT INTO `aphs_vocabulary` VALUES (200,'en','_ALBUM_NAME','Album Name');
INSERT INTO `aphs_vocabulary` VALUES (4151,'vi','_NO_RECORDS_FOUND','No records found');
INSERT INTO `aphs_vocabulary` VALUES (203,'en','_ALERT_CANCEL_BOOKING','Are you sure you want to cancel this booking?');
INSERT INTO `aphs_vocabulary` VALUES (5125,'ru','_MD_NEWS','The News and Events module allows administrator to post news and events on the site, display latest of them at the side block.');
INSERT INTO `aphs_vocabulary` VALUES (206,'en','_ALERT_REQUIRED_FILEDS','Items marked with an asterisk (*) are required');
INSERT INTO `aphs_vocabulary` VALUES (4150,'vi','_NO_PAYMENT_METHODS_ALERT','No payment methods available! Please contact our technical support.');
INSERT INTO `aphs_vocabulary` VALUES (209,'en','_ALL','All');
INSERT INTO `aphs_vocabulary` VALUES (4149,'vi','_NO_NEWS','No news');
INSERT INTO `aphs_vocabulary` VALUES (212,'en','_ALLOW','Allow');
INSERT INTO `aphs_vocabulary` VALUES (4148,'vi','_NO_CUSTOMER_FOUND','No customer found!');
INSERT INTO `aphs_vocabulary` VALUES (215,'en','_ALLOW_COMMENTS','Allow comments');
INSERT INTO `aphs_vocabulary` VALUES (218,'en','_ALL_AVAILABLE','All Available');
INSERT INTO `aphs_vocabulary` VALUES (4147,'vi','_NO_COMMENTS_YET','No comments yet.');
INSERT INTO `aphs_vocabulary` VALUES (221,'en','_ALREADY_HAVE_ACCOUNT','Already have an account? <a href=\'index.php?customer=login\'>Login here</a>');
INSERT INTO `aphs_vocabulary` VALUES (5124,'ru','_MD_GALLERY','The Gallery module allows administrator to create image or video albums, upload album content and dysplay this content to be viewed by visitor of the site.');
INSERT INTO `aphs_vocabulary` VALUES (4146,'vi','_NO_BOOKING_FOUND','The number of booking you\'ve entered was not found in our system! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (224,'en','_ALREADY_LOGGED','You are already logged in!');
INSERT INTO `aphs_vocabulary` VALUES (227,'en','_AMOUNT','Amount');
INSERT INTO `aphs_vocabulary` VALUES (4145,'vi','_NO_AVAILABLE','Not Available');
INSERT INTO `aphs_vocabulary` VALUES (230,'en','_ANSWER','Answer');
INSERT INTO `aphs_vocabulary` VALUES (233,'en','_ANY','Any');
INSERT INTO `aphs_vocabulary` VALUES (4144,'vi','_NOVEMBER','November');
INSERT INTO `aphs_vocabulary` VALUES (236,'en','_APPLY','Apply');
INSERT INTO `aphs_vocabulary` VALUES (5123,'ru','_MD_FAQ','The Frequently Asked Questions (faq) module allows admin users to create question and answer pairs which they want displayed on the \'faq\' page.');
INSERT INTO `aphs_vocabulary` VALUES (4143,'vi','_NOT_PAID_YET','Not paid yet');
INSERT INTO `aphs_vocabulary` VALUES (239,'en','_APPLY_TO_ALL_LANGUAGES','Apply to all languages');
INSERT INTO `aphs_vocabulary` VALUES (4142,'vi','_NOT_AVAILABLE','N/A');
INSERT INTO `aphs_vocabulary` VALUES (242,'en','_APPLY_TO_ALL_PAGES','Apply changes to all pages');
INSERT INTO `aphs_vocabulary` VALUES (245,'en','_APPROVE','Approve');
INSERT INTO `aphs_vocabulary` VALUES (248,'en','_APPROVED','Approved');
INSERT INTO `aphs_vocabulary` VALUES (251,'en','_APRIL','April');
INSERT INTO `aphs_vocabulary` VALUES (4141,'vi','_NOT_AUTHORIZED','You are not authorized to view this page.');
INSERT INTO `aphs_vocabulary` VALUES (254,'en','_ARTICLE','Article');
INSERT INTO `aphs_vocabulary` VALUES (257,'en','_ARTICLE_ID','Article ID');
INSERT INTO `aphs_vocabulary` VALUES (4140,'vi','_NOT_ALLOWED','Not Allowed');
INSERT INTO `aphs_vocabulary` VALUES (260,'en','_AUGUST','August');
INSERT INTO `aphs_vocabulary` VALUES (5122,'ru','_MD_CUSTOMERS','The Customers module allows easy customers management on your site. Administrator could create, edit or delete customer accounts. Customers could register on the site and log into their accounts.');
INSERT INTO `aphs_vocabulary` VALUES (263,'en','_AUTHENTICATION','Authentication');
INSERT INTO `aphs_vocabulary` VALUES (4139,'vi','_NOTIFICATION_STATUS_CHANGED','Notification status changed');
INSERT INTO `aphs_vocabulary` VALUES (266,'en','_AUTHORIZE_NET_NOTICE','The Authorize.Net payment gateway service provider.');
INSERT INTO `aphs_vocabulary` VALUES (269,'en','_AUTHORIZE_NET_ORDER','Authorize.Net Order');
INSERT INTO `aphs_vocabulary` VALUES (5121,'ru','_MD_CONTACT_US','Contact Us module allows easy create and place on-line contact form on site pages, using predefined code, like: {module:contact_us}.');
INSERT INTO `aphs_vocabulary` VALUES (4138,'vi','_NOTIFICATION_MSG','Please send me information about specials and discounts!');
INSERT INTO `aphs_vocabulary` VALUES (272,'en','_AVAILABILITY','Availability');
INSERT INTO `aphs_vocabulary` VALUES (4132,'vi','_NEXT','Next');
INSERT INTO `aphs_vocabulary` VALUES (4133,'vi','_NIGHT','Night');
INSERT INTO `aphs_vocabulary` VALUES (4134,'vi','_NIGHTS','Nights');
INSERT INTO `aphs_vocabulary` VALUES (4135,'vi','_NO','No');
INSERT INTO `aphs_vocabulary` VALUES (4136,'vi','_NONE','None');
INSERT INTO `aphs_vocabulary` VALUES (4137,'vi','_NOTICE_MODULES_CODE','To add available modules to this page just copy and paste into the text:');
INSERT INTO `aphs_vocabulary` VALUES (275,'en','_AVAILABILITY_ROOMS_NOTE','Define a maximum number of rooms available for booking for a specified day or date range (maximum availability _MAX_ rooms)<br>To edit room availability simply change the value in a day cell and then click \'Save Changes\' button');
INSERT INTO `aphs_vocabulary` VALUES (5120,'ru','_MD_COMMENTS','The Comments module allows visitors to leave comments on articles and administrator of the site to moderate them.');
INSERT INTO `aphs_vocabulary` VALUES (4131,'vi','_NEWS_SETTINGS','News Settings');
INSERT INTO `aphs_vocabulary` VALUES (278,'en','_AVAILABLE','available');
INSERT INTO `aphs_vocabulary` VALUES (281,'en','_AVAILABLE_ROOMS','Available Rooms');
INSERT INTO `aphs_vocabulary` VALUES (4130,'vi','_NEWS_MANAGEMENT','News Management');
INSERT INTO `aphs_vocabulary` VALUES (284,'en','_BACKUP','Backup');
INSERT INTO `aphs_vocabulary` VALUES (5119,'ru','_MD_BOOKINGS','The Bookings module allows the site owner to define bookings for all rooms, then price them on an individual basis by accommodation and date. It also permits bookings to be taken from customers and managed via administrator panel.');
INSERT INTO `aphs_vocabulary` VALUES (4129,'vi','_NEWS_AND_EVENTS','News & Events');
INSERT INTO `aphs_vocabulary` VALUES (287,'en','_BACKUPS_EXISTING','Existing Backups');
INSERT INTO `aphs_vocabulary` VALUES (290,'en','_BACKUP_AND_RESTORE','Backup & Restore');
INSERT INTO `aphs_vocabulary` VALUES (293,'en','_BACKUP_CHOOSE_MSG','Choose a backup from the list below');
INSERT INTO `aphs_vocabulary` VALUES (5118,'ru','_MD_BANNERS','The Banners module allows administrator to display images on the site in random or rotation style.');
INSERT INTO `aphs_vocabulary` VALUES (4128,'vi','_NEWSLETTER_UNSUBSCRIBE_TEXT','<p>To unsubscribe from our newsletters, enter your email address below and click the unsubscribe button.</p>');
INSERT INTO `aphs_vocabulary` VALUES (296,'en','_BACKUP_DELETE_ALERT','Are you sure you want to delete this backup?');
INSERT INTO `aphs_vocabulary` VALUES (299,'en','_BACKUP_EMPTY_MSG','No existing backups found.');
INSERT INTO `aphs_vocabulary` VALUES (4127,'vi','_NEWSLETTER_UNSUBSCRIBE_SUCCESS','You have been successfully unsubscribed from our newsletter!');
INSERT INTO `aphs_vocabulary` VALUES (302,'en','_BACKUP_EMPTY_NAME_ALERT','Name of backup file cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5117,'ru','_MD_BACKUP_AND_RESTORE','With Backup and Restore module you can dump all of your database tables to a file download or save to a file on the server, and to restore from an uploaded or previously saved database dump.');
INSERT INTO `aphs_vocabulary` VALUES (4126,'vi','_NEWSLETTER_SUBSCRIPTION_MANAGEMENT','Newsletter Subscription Management');
INSERT INTO `aphs_vocabulary` VALUES (305,'en','_BACKUP_EXECUTING_ERROR','An error occurred while backup the system! Please check write permissions to backup folder or try again later.');
INSERT INTO `aphs_vocabulary` VALUES (5116,'ru','_MAY','May');
INSERT INTO `aphs_vocabulary` VALUES (308,'en','_BACKUP_INSTALLATION','Backup Installation');
INSERT INTO `aphs_vocabulary` VALUES (5115,'ru','_MAX_RESERVATIONS_ERROR','You have reached the maximum number of permitted room reservations, that you have not yet finished! Please complete at least one of them to proceed reservation of new rooms.');
INSERT INTO `aphs_vocabulary` VALUES (311,'en','_BACKUP_RESTORE','Backup Restore');
INSERT INTO `aphs_vocabulary` VALUES (5114,'ru','_MAX_OCCUPANCY','Max. Occupancy');
INSERT INTO `aphs_vocabulary` VALUES (314,'en','_BACKUP_RESTORE_ALERT','Are you sure you want to restore this backup');
INSERT INTO `aphs_vocabulary` VALUES (5112,'ru','_MAX_CHILDREN','Max Children');
INSERT INTO `aphs_vocabulary` VALUES (5113,'ru','_MAX_GUESTS','Max Guests');
INSERT INTO `aphs_vocabulary` VALUES (317,'en','_BACKUP_RESTORE_NOTE','Remember: this action will rewrite all your current settings!');
INSERT INTO `aphs_vocabulary` VALUES (5110,'ru','_MAX_ADULTS','Max Adults');
INSERT INTO `aphs_vocabulary` VALUES (5111,'ru','_MAX_CHARS','(max: _MAX_CHARS_ chars)');
INSERT INTO `aphs_vocabulary` VALUES (4125,'vi','_NEWSLETTER_SUBSCRIBE_TEXT','<p>To receive newsletters from our site, simply enter your email and click on \"Subscribe\" button.</p><p>If you later decide to stop your subscription or change the type of news you receive, simply follow the link at the end of the latest newsletter and update your profile or unsubscribe by ticking the checkbox below.</p>');
INSERT INTO `aphs_vocabulary` VALUES (320,'en','_BACKUP_RESTORING_ERROR','An error occurred while restoring file! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (323,'en','_BACKUP_WAS_CREATED','Backup _FILE_NAME_ was successfully created.');
INSERT INTO `aphs_vocabulary` VALUES (5109,'ru','_MAXIMUM_NIGHTS_ALERT','The maximum allowed stay for this period of time from _FROM_ to _TO_ is _NIGHTS_ nights per booking. Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4124,'vi','_NEWSLETTER_SUBSCRIBE_SUCCESS','Thank you for subscribing to our electronic newsletter. You will receive an e-mail to confirm your subscription.');
INSERT INTO `aphs_vocabulary` VALUES (326,'en','_BACKUP_WAS_DELETED','Backup _FILE_NAME_ was successfully deleted.');
INSERT INTO `aphs_vocabulary` VALUES (5108,'ru','_MAXIMUM_NIGHTS','Maximum Nights');
INSERT INTO `aphs_vocabulary` VALUES (4123,'vi','_NEWSLETTER_SUBSCRIBERS','Newsletter Subscribers');
INSERT INTO `aphs_vocabulary` VALUES (329,'en','_BACKUP_WAS_RESTORED','Backup _FILE_NAME_ was successfully restored.');
INSERT INTO `aphs_vocabulary` VALUES (5107,'ru','_MASS_MAIL_AND_TEMPLATES','Mass Mail & Templates');
INSERT INTO `aphs_vocabulary` VALUES (332,'en','_BACKUP_YOUR_INSTALLATION','Backup your current Installation');
INSERT INTO `aphs_vocabulary` VALUES (5106,'ru','_MASS_MAIL_ALERT','Attention: shared hosting services usually have a limit of 200 emails per hour');
INSERT INTO `aphs_vocabulary` VALUES (4122,'vi','_NEWSLETTER_PRE_UNSUBSCRIBE_ALERT','Please click on the \"Unsubscribe\" button to complete the process.');
INSERT INTO `aphs_vocabulary` VALUES (335,'en','_BACK_TO_ADMIN_PANEL','Back to Admin Panel');
INSERT INTO `aphs_vocabulary` VALUES (5105,'ru','_MASS_MAIL','Mass Mail');
INSERT INTO `aphs_vocabulary` VALUES (338,'en','_BANK_PAYMENT_INFO','Bank Payment Information');
INSERT INTO `aphs_vocabulary` VALUES (5104,'ru','_MARCH','March');
INSERT INTO `aphs_vocabulary` VALUES (341,'en','_BANK_TRANSFER','Bank Transfer');
INSERT INTO `aphs_vocabulary` VALUES (344,'en','_BANNERS','Banners');
INSERT INTO `aphs_vocabulary` VALUES (5103,'ru','_MAP_OVERLAY','Map Overlay');
INSERT INTO `aphs_vocabulary` VALUES (4121,'vi','_NEWSLETTER_PRE_SUBSCRIBE_ALERT','Please click on the \"Subscribe\" button to complete the process.');
INSERT INTO `aphs_vocabulary` VALUES (347,'en','_BANNERS_MANAGEMENT','Banners Management');
INSERT INTO `aphs_vocabulary` VALUES (5102,'ru','_MAP_CODE','Map Code');
INSERT INTO `aphs_vocabulary` VALUES (350,'en','_BANNERS_SETTINGS','Banners Settings');
INSERT INTO `aphs_vocabulary` VALUES (5101,'ru','_MANAGE_TEMPLATES','Manage Templates');
INSERT INTO `aphs_vocabulary` VALUES (353,'en','_BANNER_IMAGE','Banner Image');
INSERT INTO `aphs_vocabulary` VALUES (356,'en','_BAN_ITEM','Ban Item');
INSERT INTO `aphs_vocabulary` VALUES (5100,'ru','_MAKE_RESERVATION','Make а Reservation');
INSERT INTO `aphs_vocabulary` VALUES (359,'en','_BAN_LIST','Ban List');
INSERT INTO `aphs_vocabulary` VALUES (362,'en','_BATHROOMS','Bathrooms');
INSERT INTO `aphs_vocabulary` VALUES (5099,'ru','_MAIN_ADMIN','Main Admin');
INSERT INTO `aphs_vocabulary` VALUES (365,'en','_BEDS','Beds');
INSERT INTO `aphs_vocabulary` VALUES (5098,'ru','_MAIN','Main');
INSERT INTO `aphs_vocabulary` VALUES (368,'en','_BILLING_ADDRESS','Billing Address');
INSERT INTO `aphs_vocabulary` VALUES (5097,'ru','_MAILER','Mailer');
INSERT INTO `aphs_vocabulary` VALUES (371,'en','_BILLING_DETAILS','Billing Details');
INSERT INTO `aphs_vocabulary` VALUES (5096,'ru','_LOOK_IN','Look in');
INSERT INTO `aphs_vocabulary` VALUES (373,'en','_BILLING_DETAILS_UPDATED','Your Billing Details has been updated.');
INSERT INTO `aphs_vocabulary` VALUES (375,'en','_BIRTH_DATE','Birth Date');
INSERT INTO `aphs_vocabulary` VALUES (5095,'ru','_LONG_DESCRIPTION','Long Description');
INSERT INTO `aphs_vocabulary` VALUES (378,'en','_BIRTH_DATE_VALID_ALERT','Birth date was entered in wrong format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (381,'en','_BOOK','Book');
INSERT INTO `aphs_vocabulary` VALUES (4120,'vi','_NEWSLETTER_PAGE_TEXT','<p>To receive newsletters from our site, simply enter your email and click on \"Subscribe\" button.</p><p>If you later decide to stop your subscription or change the type of news you receive, simply follow the link at the end of the latest newsletter and update your profile or unsubscribe by ticking the checkbox below.</p>');
INSERT INTO `aphs_vocabulary` VALUES (384,'en','_BOOKING','Booking');
INSERT INTO `aphs_vocabulary` VALUES (4119,'vi','_NEWS','News');
INSERT INTO `aphs_vocabulary` VALUES (387,'en','_BOOKINGS','Bookings');
INSERT INTO `aphs_vocabulary` VALUES (4118,'vi','_NEVER','never');
INSERT INTO `aphs_vocabulary` VALUES (390,'en','_BOOKINGS_MANAGEMENT','Bookings Management');
INSERT INTO `aphs_vocabulary` VALUES (4117,'vi','_NAME','Name');
INSERT INTO `aphs_vocabulary` VALUES (393,'en','_BOOKINGS_SETTINGS','Booking Settings');
INSERT INTO `aphs_vocabulary` VALUES (5094,'ru','_LOGIN_PAGE_MSG','Use a valid administrator username and password to get access to the Administrator Back-End.<br><br>Return to site <a href=\'index.php\'>Home Page</a><br><br><img align=\'center\' src=\'images/lock.png\' alt=\'\' width=\'92px\'>');
INSERT INTO `aphs_vocabulary` VALUES (4116,'vi','_MY_ORDERS','My Orders');
INSERT INTO `aphs_vocabulary` VALUES (396,'en','_BOOKING_CANCELED','Booking Canceled');
INSERT INTO `aphs_vocabulary` VALUES (5093,'ru','_LOGINS','Logins');
INSERT INTO `aphs_vocabulary` VALUES (4114,'vi','_MY_ACCOUNT','My Account');
INSERT INTO `aphs_vocabulary` VALUES (4115,'vi','_MY_BOOKINGS','My Bookings');
INSERT INTO `aphs_vocabulary` VALUES (399,'en','_BOOKING_CANCELED_SUCCESS','The booking _BOOKING_ has been successfully canceled from the system!');
INSERT INTO `aphs_vocabulary` VALUES (5091,'ru','_LOCATION_NAME','Location Name');
INSERT INTO `aphs_vocabulary` VALUES (5092,'ru','_LOGIN','Login');
INSERT INTO `aphs_vocabulary` VALUES (402,'en','_BOOKING_COMPLETED','Booking Completed');
INSERT INTO `aphs_vocabulary` VALUES (5090,'ru','_LOCATIONS','Locations');
INSERT INTO `aphs_vocabulary` VALUES (405,'en','_BOOKING_DATE','Booking Date');
INSERT INTO `aphs_vocabulary` VALUES (5089,'ru','_LOCATION','Location');
INSERT INTO `aphs_vocabulary` VALUES (408,'en','_BOOKING_DESCRIPTION','Booking Description');
INSERT INTO `aphs_vocabulary` VALUES (5088,'ru','_LOCAL_TIME','Local Time');
INSERT INTO `aphs_vocabulary` VALUES (411,'en','_BOOKING_DETAILS','Booking Details');
INSERT INTO `aphs_vocabulary` VALUES (5087,'ru','_LOADING','loading');
INSERT INTO `aphs_vocabulary` VALUES (414,'en','_BOOKING_NUMBER','Booking Number');
INSERT INTO `aphs_vocabulary` VALUES (5086,'ru','_LINK_PARAMETER','Link Parameter');
INSERT INTO `aphs_vocabulary` VALUES (4113,'vi','_MUST_BE_LOGGED','You must be logged in to view this page! <a href=\'index.php?customer=login\'>Login</a> or <a href=\'index.php?customer=create_account\'>Create Account for free</a>.');
INSERT INTO `aphs_vocabulary` VALUES (417,'en','_BOOKING_PRICE','Booking Price');
INSERT INTO `aphs_vocabulary` VALUES (5085,'ru','_LINK','Link');
INSERT INTO `aphs_vocabulary` VALUES (420,'en','_BOOKING_SETTINGS','Booking Settings');
INSERT INTO `aphs_vocabulary` VALUES (5084,'ru','_LICENSE','License');
INSERT INTO `aphs_vocabulary` VALUES (4112,'vi','_MS_VIDEO_GALLERY_TYPE','Allowed types of Video Gallery');
INSERT INTO `aphs_vocabulary` VALUES (423,'en','_BOOKING_STATUS','Booking Status');
INSERT INTO `aphs_vocabulary` VALUES (426,'en','_BOOKING_SUBTOTAL','Booking Subtotal');
INSERT INTO `aphs_vocabulary` VALUES (5083,'ru','_LEGEND_RESERVED','Room is reserved, but order was not paid yet');
INSERT INTO `aphs_vocabulary` VALUES (429,'en','_BOOKING_WAS_CANCELED_MSG','Your booking has been canceled.');
INSERT INTO `aphs_vocabulary` VALUES (4111,'vi','_MS_VAT_VALUE','Specifies default VAT value for order (in %) &nbsp;[<a href=index.php?admin=countries_management>Define by Country</a>]');
INSERT INTO `aphs_vocabulary` VALUES (432,'en','_BOOKING_WAS_COMPLETED_MSG','Thank you for reservation rooms in our hotel! Your booking has been completed.');
INSERT INTO `aphs_vocabulary` VALUES (5082,'ru','_LEGEND_REFUNDED','Order was refunded and the room is available again in search');
INSERT INTO `aphs_vocabulary` VALUES (435,'en','_BOOK_NOW','Book Now');
INSERT INTO `aphs_vocabulary` VALUES (5081,'ru','_LEGEND_PREPARING','Room was added to reservation cart, but still not reserved');
INSERT INTO `aphs_vocabulary` VALUES (4110,'vi','_MS_VAT_INCLUDED_IN_PRICE','Specifies whether VAT fee is included in room and extras prices or not');
INSERT INTO `aphs_vocabulary` VALUES (438,'en','_BOOK_ONE_NIGHT_ALERT','Sorry, but you must book at least one night.');
INSERT INTO `aphs_vocabulary` VALUES (441,'en','_BOTTOM','Bottom');
INSERT INTO `aphs_vocabulary` VALUES (4109,'vi','_MS_USER_TYPE','Type of users, who can post comments');
INSERT INTO `aphs_vocabulary` VALUES (444,'en','_BUTTON_BACK','Back');
INSERT INTO `aphs_vocabulary` VALUES (5080,'ru','_LEGEND_PAYMENT_ERROR','An error occurred while processing customer payments');
INSERT INTO `aphs_vocabulary` VALUES (447,'en','_BUTTON_CANCEL','Cancel');
INSERT INTO `aphs_vocabulary` VALUES (4108,'vi','_MS_TWO_CHECKOUT_VENDOR','Specifies 2CO Vendor ID');
INSERT INTO `aphs_vocabulary` VALUES (450,'en','_BUTTON_CHANGE','Change');
INSERT INTO `aphs_vocabulary` VALUES (453,'en','_BUTTON_CHANGE_PASSWORD','Change Password');
INSERT INTO `aphs_vocabulary` VALUES (5079,'ru','_LEGEND_COMPLETED','Money was paid (fully or partially) and order completed');
INSERT INTO `aphs_vocabulary` VALUES (456,'en','_BUTTON_CREATE','Create');
INSERT INTO `aphs_vocabulary` VALUES (459,'en','_BUTTON_LOGIN','Login');
INSERT INTO `aphs_vocabulary` VALUES (462,'en','_BUTTON_LOGOUT','Logout');
INSERT INTO `aphs_vocabulary` VALUES (4107,'vi','_MS_TESTIMONIALS_KEY','The keyword that will be replaced with a list of customer testimonials (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (465,'en','_BUTTON_RESET','Reset');
INSERT INTO `aphs_vocabulary` VALUES (5078,'ru','_LEGEND_CANCELED','Order was canceled by admin and the room is available again in search');
INSERT INTO `aphs_vocabulary` VALUES (468,'en','_BUTTON_REWRITE','Rewrite Vocabulary');
INSERT INTO `aphs_vocabulary` VALUES (5077,'ru','_LEGEND','Legend');
INSERT INTO `aphs_vocabulary` VALUES (471,'en','_BUTTON_SAVE_CHANGES','Save Changes');
INSERT INTO `aphs_vocabulary` VALUES (5076,'ru','_LEFT_TO_RIGHT','LTR (left-to-right)');
INSERT INTO `aphs_vocabulary` VALUES (4106,'vi','_MS_SHOW_RESERVATION_FORM','Specifies whether to show Reservation Form on homepage or not');
INSERT INTO `aphs_vocabulary` VALUES (474,'en','_BUTTON_UPDATE','Update');
INSERT INTO `aphs_vocabulary` VALUES (5075,'ru','_LEFT','Left');
INSERT INTO `aphs_vocabulary` VALUES (477,'en','_CACHE_LIFETIME','Cache Lifetime');
INSERT INTO `aphs_vocabulary` VALUES (480,'en','_CACHING','Caching');
INSERT INTO `aphs_vocabulary` VALUES (5074,'ru','_LEAVE_YOUR_COMMENT','Leave your comment');
INSERT INTO `aphs_vocabulary` VALUES (4105,'vi','_MS_SHOW_NEWS_BLOCK','Defines whether to show News side block or not');
INSERT INTO `aphs_vocabulary` VALUES (483,'en','_CAMPAIGNS','Campaigns');
INSERT INTO `aphs_vocabulary` VALUES (5073,'ru','_LAYOUT','Layout');
INSERT INTO `aphs_vocabulary` VALUES (486,'en','_CAMPAIGNS_MANAGEMENT','Campaigns Management');
INSERT INTO `aphs_vocabulary` VALUES (5072,'ru','_LAST_RUN','Last run');
INSERT INTO `aphs_vocabulary` VALUES (4103,'vi','_MS_SHOW_FULLY_BOOKED_ROOMS','Specifies whether to allow showing of fully booked/unavailable rooms in search');
INSERT INTO `aphs_vocabulary` VALUES (4104,'vi','_MS_SHOW_NEWSLETTER_SUBSCRIBE_BLOCK','Defines whether to show Newsletter Subscription block or not');
INSERT INTO `aphs_vocabulary` VALUES (489,'en','_CAMPAIGNS_TOOLTIP','Global - allows booking for any date and runs (visible) within a defined period of time only\r\n\r\nTargeted - allows booking in a specified period of time only and runs (visible) till the first date is beginning');
INSERT INTO `aphs_vocabulary` VALUES (5068,'ru','_LAST_LOGGED_IP','Last logged IP');
INSERT INTO `aphs_vocabulary` VALUES (5069,'ru','_LAST_LOGIN','Last Login');
INSERT INTO `aphs_vocabulary` VALUES (5070,'ru','_LAST_NAME','Last Name');
INSERT INTO `aphs_vocabulary` VALUES (5071,'ru','_LAST_NAME_EMPTY_ALERT','Last Name cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (492,'en','_CANCELED','Canceled');
INSERT INTO `aphs_vocabulary` VALUES (5067,'ru','_LAST_HOTEL_ALERT','You cannot delete last active hotel record!\r\n');
INSERT INTO `aphs_vocabulary` VALUES (4102,'vi','_MS_SHOW_BOOKING_STATUS_FORM','Specifies whether to show Booking Status Form on homepage or not');
INSERT INTO `aphs_vocabulary` VALUES (495,'en','_CANCELED_BY_ADMIN','This booking was canceled by administrator.');
INSERT INTO `aphs_vocabulary` VALUES (5066,'ru','_LAST_CURRENCY_ALERT','You cannot delete last active currency!');
INSERT INTO `aphs_vocabulary` VALUES (4101,'vi','_MS_SEND_ORDER_COPY_TO_ADMIN','Specifies whether to allow sending a copy of order to admin');
INSERT INTO `aphs_vocabulary` VALUES (498,'en','_CANCELED_BY_CUSTOMER','This booking was canceled by customer.');
INSERT INTO `aphs_vocabulary` VALUES (5065,'ru','_LANG_ORDER_CHANGED','Language order was successfully changed!');
INSERT INTO `aphs_vocabulary` VALUES (501,'en','_CAN_USE_TAGS_MSG','You can use some HTML tags, such as');
INSERT INTO `aphs_vocabulary` VALUES (5064,'ru','_LANG_NOT_DELETED','Language was not deleted!');
INSERT INTO `aphs_vocabulary` VALUES (504,'en','_CAPACITY','Capacity');
INSERT INTO `aphs_vocabulary` VALUES (4100,'vi','_MS_SEARCH_AVAILABILITY_PAGE_SIZE','Specifies the number of rooms/hotels that will be displayed on one page in the search availability results');
INSERT INTO `aphs_vocabulary` VALUES (507,'en','_CART_WAS_UPDATED','Reservation cart was successfully updated!');
INSERT INTO `aphs_vocabulary` VALUES (5063,'ru','_LANG_NAME_EXISTS','Language with such name already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (510,'en','_CATEGORIES','Categories');
INSERT INTO `aphs_vocabulary` VALUES (4099,'vi','_MS_ROTATION_TYPE','Different type of banner rotation');
INSERT INTO `aphs_vocabulary` VALUES (513,'en','_CATEGORIES_MANAGEMENT','Categories Management');
INSERT INTO `aphs_vocabulary` VALUES (5062,'ru','_LANG_NAME_EMPTY','Language name cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (516,'en','_CATEGORY','Category');
INSERT INTO `aphs_vocabulary` VALUES (4098,'vi','_MS_ROTATE_DELAY','Defines banners rotation delay in seconds');
INSERT INTO `aphs_vocabulary` VALUES (519,'en','_CATEGORY_DESCRIPTION','Category Description');
INSERT INTO `aphs_vocabulary` VALUES (5061,'ru','_LANG_MISSED','Missed language to update! Please, try again.');
INSERT INTO `aphs_vocabulary` VALUES (522,'en','_CC_CARD_HOLDER_NAME_EMPTY','No card holder\'s name provided! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4097,'vi','_MS_ROOMS_IN_SEARCH','Specifies what types of rooms to show in search result: all or available rooms only (without fully booked / unavailable)');
INSERT INTO `aphs_vocabulary` VALUES (525,'en','_CC_CARD_INVALID_FORMAT','Credit card number has invalid format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5059,'ru','_LANG_DELETE_LAST_ERROR','You cannot delete last language!');
INSERT INTO `aphs_vocabulary` VALUES (5060,'ru','_LANG_DELETE_WARNING','Are you sure you want to remove this language? This operation will delete all language vocabulary!');
INSERT INTO `aphs_vocabulary` VALUES (528,'en','_CC_CARD_INVALID_NUMBER','Credit card number is invalid! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5058,'ru','_LANG_DELETED','Language was successfully deleted!');
INSERT INTO `aphs_vocabulary` VALUES (4096,'vi','_MS_RESERVATION_INITIAL_FEE','Start (initial) fee - the sum that will be added to each booking (fixed value in default currency)');
INSERT INTO `aphs_vocabulary` VALUES (531,'en','_CC_CARD_NO_CVV_NUMBER','No CVV Code provided! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5057,'ru','_LANG_ABBREV_EMPTY','Language abbreviation cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (4095,'vi','_MS_RESERVATION EXPIRED_ALERT','Specifies whether to send email alert to customer when reservation has expired');
INSERT INTO `aphs_vocabulary` VALUES (534,'en','_CC_CARD_WRONG_EXPIRE_DATE','Credit card expiry date is wrong! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5055,'ru','_LANGUAGE_EDITED','Language data was successfully updated!');
INSERT INTO `aphs_vocabulary` VALUES (5056,'ru','_LANGUAGE_NAME','Language Name');
INSERT INTO `aphs_vocabulary` VALUES (4094,'vi','_MS_REMEMBER_ME','Specifies whether to allow Remember Me feature');
INSERT INTO `aphs_vocabulary` VALUES (537,'en','_CC_CARD_WRONG_LENGTH','Credit card number has a wrong length! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5053,'ru','_LANGUAGE_ADD_NEW','Add New Language');
INSERT INTO `aphs_vocabulary` VALUES (5054,'ru','_LANGUAGE_EDIT','Edit Language');
INSERT INTO `aphs_vocabulary` VALUES (540,'en','_CC_NO_CARD_NUMBER_PROVIDED','No card number provided! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5052,'ru','_LANGUAGE_ADDED','New language was successfully added!');
INSERT INTO `aphs_vocabulary` VALUES (4093,'vi','_MS_REG_CONFIRMATION','Defines whether confirmation (which type of) is required for registration');
INSERT INTO `aphs_vocabulary` VALUES (543,'en','_CC_NUMBER_INVALID','Credit card number is invalid! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5050,'ru','_LANGUAGES','Languages');
INSERT INTO `aphs_vocabulary` VALUES (5051,'ru','_LANGUAGES_SETTINGS','Languages Settings');
INSERT INTO `aphs_vocabulary` VALUES (4092,'vi','_MS_PRE_PAYMENT_VALUE','Defines a pre-payment value for \'fixed sum\' or \'percentage\' types');
INSERT INTO `aphs_vocabulary` VALUES (546,'en','_CC_UNKNOWN_CARD_TYPE','Unknown card type! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5048,'ru','_KEY_DISPLAY_TYPE','Key display type');
INSERT INTO `aphs_vocabulary` VALUES (5049,'ru','_LANGUAGE','Language');
INSERT INTO `aphs_vocabulary` VALUES (549,'en','_CHANGES_SAVED','Changes were saved.');
INSERT INTO `aphs_vocabulary` VALUES (5047,'ru','_KEYWORDS','Keywords');
INSERT INTO `aphs_vocabulary` VALUES (4091,'vi','_MS_PRE_PAYMENT_TYPE','Defines a pre-payment type (full price, first night only, fixed sum or percentage)');
INSERT INTO `aphs_vocabulary` VALUES (552,'en','_CHANGES_WERE_SAVED','Changes were successfully saved! Please refresh the <a href=index.php>Home Page</a> to see the results.');
INSERT INTO `aphs_vocabulary` VALUES (5043,'ru','_JANUARY','January');
INSERT INTO `aphs_vocabulary` VALUES (5044,'ru','_JULY','July');
INSERT INTO `aphs_vocabulary` VALUES (5045,'ru','_JUNE','June');
INSERT INTO `aphs_vocabulary` VALUES (5046,'ru','_KEY','Key');
INSERT INTO `aphs_vocabulary` VALUES (555,'en','_CHANGE_CUSTOMER','Change Customer');
INSERT INTO `aphs_vocabulary` VALUES (5042,'ru','_ITEM_NAME','Item Name');
INSERT INTO `aphs_vocabulary` VALUES (558,'en','_CHANGE_ORDER','Change Order');
INSERT INTO `aphs_vocabulary` VALUES (5041,'ru','_ITEMS_LC','items');
INSERT INTO `aphs_vocabulary` VALUES (4090,'vi','_MS_PRE_MODERATION_ALLOW','Specifies whether to allow pre-moderation for comments');
INSERT INTO `aphs_vocabulary` VALUES (561,'en','_CHANGE_YOUR_PASSWORD','Change your password');
INSERT INTO `aphs_vocabulary` VALUES (5040,'ru','_ITEMS','Items');
INSERT INTO `aphs_vocabulary` VALUES (564,'en','_CHARGE_TYPE','Charge Type');
INSERT INTO `aphs_vocabulary` VALUES (567,'en','_CHECKOUT','Checkout');
INSERT INTO `aphs_vocabulary` VALUES (5039,'ru','_IS_DEFAULT','Is default');
INSERT INTO `aphs_vocabulary` VALUES (570,'en','_CHECK_AVAILABILITY','Check Availability');
INSERT INTO `aphs_vocabulary` VALUES (573,'en','_CHECK_IN','Check In');
INSERT INTO `aphs_vocabulary` VALUES (4089,'vi','_MS_PREPARING_ORDERS_TIMEOUT','Defines a timeout for \'preparing\' orders before automatic deleting (in hours)');
INSERT INTO `aphs_vocabulary` VALUES (576,'en','_CHECK_NOW','Check Now');
INSERT INTO `aphs_vocabulary` VALUES (579,'en','_CHECK_OUT','Check Out');
INSERT INTO `aphs_vocabulary` VALUES (5038,'ru','_IP_ADDRESS_BLOCKED','Your IP Address is blocked! To resolve this problem, please contact the site administrator.');
INSERT INTO `aphs_vocabulary` VALUES (582,'en','_CHECK_STATUS','Check Status');
INSERT INTO `aphs_vocabulary` VALUES (4088,'vi','_MS_PAYPAL_EMAIL','Specifies PayPal (business) email ');
INSERT INTO `aphs_vocabulary` VALUES (585,'en','_CHILD','Child');
INSERT INTO `aphs_vocabulary` VALUES (5037,'ru','_IP_ADDRESS','IP Address');
INSERT INTO `aphs_vocabulary` VALUES (588,'en','_CHILDREN','Children');
INSERT INTO `aphs_vocabulary` VALUES (591,'en','_CITY','City');
INSERT INTO `aphs_vocabulary` VALUES (5036,'ru','_IN_PRODUCTS','In Products');
INSERT INTO `aphs_vocabulary` VALUES (4087,'vi','_MS_PAYMENT_TYPE_POA','Specifies whether to allow \'Pay on Arrival\' (POA) payment type');
INSERT INTO `aphs_vocabulary` VALUES (594,'en','_CITY_EMPTY_ALERT','City cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5035,'ru','_INVOICE_SENT_SUCCESS','The invoice was successfully sent to the customer!');
INSERT INTO `aphs_vocabulary` VALUES (597,'en','_CLEANED','Cleaned');
INSERT INTO `aphs_vocabulary` VALUES (5034,'ru','_INVOICE','Invoice');
INSERT INTO `aphs_vocabulary` VALUES (600,'en','_CLEANUP','Cleanup');
INSERT INTO `aphs_vocabulary` VALUES (4084,'vi','_MS_PAYMENT_TYPE_BANK_TRANSFER','Specifies whether to allow \'Bank Transfer\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (4085,'vi','_MS_PAYMENT_TYPE_ONLINE','Specifies whether to allow \'On-line Order\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (4086,'vi','_MS_PAYMENT_TYPE_PAYPAL','Specifies whether to allow \'PayPal\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (603,'en','_CLEANUP_TOOLTIP','The cleanup feature is used to remove pending (temporary) reservations from your web site. A pending reservation is one where the system is waiting for the payment gateway to callback with the transaction status.');
INSERT INTO `aphs_vocabulary` VALUES (5031,'ru','_INTERNAL_USE_TOOLTIP','For internal use only');
INSERT INTO `aphs_vocabulary` VALUES (5032,'ru','_INVALID_FILE_SIZE','Invalid file size: _FILE_SIZE_ (max. allowed: _MAX_ALLOWED_)');
INSERT INTO `aphs_vocabulary` VALUES (5033,'ru','_INVALID_IMAGE_FILE_TYPE','Uploaded file is not a valid image! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (606,'en','_CLEAN_CACHE','Clean Cache');
INSERT INTO `aphs_vocabulary` VALUES (4083,'vi','_MS_PAYMENT_TYPE_AUTHORIZE','Specifies whether to allow \'Authorize.Net\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (609,'en','_CLICK_FOR_MORE_INFO','Click for more information');
INSERT INTO `aphs_vocabulary` VALUES (612,'en','_CLICK_TO_EDIT','Click to edit');
INSERT INTO `aphs_vocabulary` VALUES (5030,'ru','_INTEGRATION_MESSAGE','Copy the code below and put it in the appropriate place of your web site to get a <b>Search Availability</b> block.');
INSERT INTO `aphs_vocabulary` VALUES (4082,'vi','_MS_PAYMENT_TYPE_2CO','Specifies whether to allow \'2CO\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (615,'en','_CLICK_TO_INCREASE','Click to enlarge');
INSERT INTO `aphs_vocabulary` VALUES (5029,'ru','_INTEGRATION','Integration');
INSERT INTO `aphs_vocabulary` VALUES (618,'en','_CLICK_TO_MANAGE','Click to manage');
INSERT INTO `aphs_vocabulary` VALUES (621,'en','_CLICK_TO_SEE_DESCR','Click to see description');
INSERT INTO `aphs_vocabulary` VALUES (4081,'vi','_MS_ONLINE_CREDIT_CARD_REQUIRED','Specifies whether collecting of credit card info is required for \'On-line Orders\'');
INSERT INTO `aphs_vocabulary` VALUES (624,'en','_CLICK_TO_SEE_PRICES','Click to see prices');
INSERT INTO `aphs_vocabulary` VALUES (5028,'ru','_INSTALL_PHP_EXISTS','File <b>install.php</b> and/or directory <b>install/</b> still exists. For security reasons please remove them immediately!');
INSERT INTO `aphs_vocabulary` VALUES (627,'en','_CLICK_TO_VIEW','Click to view');
INSERT INTO `aphs_vocabulary` VALUES (4080,'vi','_MS_NEWS_RSS','Defines using of RSS for news');
INSERT INTO `aphs_vocabulary` VALUES (630,'en','_CLOSE','Close');
INSERT INTO `aphs_vocabulary` VALUES (5027,'ru','_INSTALLED','Installed');
INSERT INTO `aphs_vocabulary` VALUES (633,'en','_CLOSE_META_TAGS','Close META tags');
INSERT INTO `aphs_vocabulary` VALUES (5026,'ru','_INSTALL','Install');
INSERT INTO `aphs_vocabulary` VALUES (636,'en','_CODE','Code');
INSERT INTO `aphs_vocabulary` VALUES (4079,'vi','_MS_NEWS_HEADER_LENGTH','Defines a length of news header in block');
INSERT INTO `aphs_vocabulary` VALUES (639,'en','_COLLAPSE_PANEL','Collapse navigation panel');
INSERT INTO `aphs_vocabulary` VALUES (5025,'ru','_INITIAL_FEE','Initial Fee');
INSERT INTO `aphs_vocabulary` VALUES (642,'en','_COMMENTS','Comments');
INSERT INTO `aphs_vocabulary` VALUES (4078,'vi','_MS_NEWS_COUNT','Defines how many news will be shown in news block');
INSERT INTO `aphs_vocabulary` VALUES (645,'en','_COMMENTS_AWAITING_MODERATION_ALERT','There are _COUNT_ comment/s awaiting your moderation. Click <a href=\'index.php?admin=mod_comments_management\'>here</a> for review.');
INSERT INTO `aphs_vocabulary` VALUES (5022,'ru','_IMAGE_VERIFY_EMPTY','You must enter image verification code!');
INSERT INTO `aphs_vocabulary` VALUES (5023,'ru','_INCOME','Income');
INSERT INTO `aphs_vocabulary` VALUES (5024,'ru','_INFO_AND_STATISTICS','Information and Statistics');
INSERT INTO `aphs_vocabulary` VALUES (4077,'vi','_MS_MINIMUM_NIGHTS','Defines a minimum number of nights per booking [<a href=index.php?admin=mod_booking_packages>Define by Package</a>]');
INSERT INTO `aphs_vocabulary` VALUES (648,'en','_COMMENTS_LINK','Comments (_COUNT_)');
INSERT INTO `aphs_vocabulary` VALUES (5021,'ru','_IMAGE_VERIFICATION','Image verification');
INSERT INTO `aphs_vocabulary` VALUES (651,'en','_COMMENTS_MANAGEMENT','Comments Management');
INSERT INTO `aphs_vocabulary` VALUES (5020,'ru','_IMAGES','Images');
INSERT INTO `aphs_vocabulary` VALUES (654,'en','_COMMENTS_SETTINGS','Comments Settings');
INSERT INTO `aphs_vocabulary` VALUES (5019,'ru','_IMAGE','Image');
INSERT INTO `aphs_vocabulary` VALUES (4076,'vi','_MS_MAXIMUM_NIGHTS','Defines a maximum number of nights per booking [<a href=index.php?admin=mod_booking_packages>Define by Package</a>]');
INSERT INTO `aphs_vocabulary` VALUES (657,'en','_COMMENT_DELETED_SUCCESS','Your comment was successfully deleted.');
INSERT INTO `aphs_vocabulary` VALUES (5018,'ru','_ICON_IMAGE','Icon image');
INSERT INTO `aphs_vocabulary` VALUES (660,'en','_COMMENT_LENGTH_ALERT','The length of comment must be less than _LENGTH_ characters!');
INSERT INTO `aphs_vocabulary` VALUES (5016,'ru','_HOUR','Hour');
INSERT INTO `aphs_vocabulary` VALUES (5017,'ru','_HOURS','hours');
INSERT INTO `aphs_vocabulary` VALUES (4075,'vi','_MS_MAXIMUM_ALLOWED_RESERVATIONS','Specifies the maximum number of allowed room reservations (not completed) per customer');
INSERT INTO `aphs_vocabulary` VALUES (663,'en','_COMMENT_POSTED_SUCCESS','Your comment has been successfully posted!');
INSERT INTO `aphs_vocabulary` VALUES (4074,'vi','_MS_ITEMS_COUNT_IN_ALBUM','Specifies whether to show count of images/video under album name');
INSERT INTO `aphs_vocabulary` VALUES (666,'en','_COMMENT_SUBMITTED_SUCCESS','Your comment has been successfully submitted and will be posted after administrator\'s review!');
INSERT INTO `aphs_vocabulary` VALUES (5013,'ru','_HOTEL_MANAGEMENT','Hotel Management');
INSERT INTO `aphs_vocabulary` VALUES (5014,'ru','_HOTEL_OWNER','Hotel Owner');
INSERT INTO `aphs_vocabulary` VALUES (5015,'ru','_HOTEL_RESERVATION_ID','Hotel Reservation ID');
INSERT INTO `aphs_vocabulary` VALUES (669,'en','_COMMENT_TEXT','Comment text');
INSERT INTO `aphs_vocabulary` VALUES (672,'en','_COMPANY','Company');
INSERT INTO `aphs_vocabulary` VALUES (5012,'ru','_HOTEL_INFO','Hotel Info');
INSERT INTO `aphs_vocabulary` VALUES (675,'en','_COMPLETED','Completed');
INSERT INTO `aphs_vocabulary` VALUES (4073,'vi','_MS_IS_SEND_DELAY','Specifies whether to allow time delay between sending emails.');
INSERT INTO `aphs_vocabulary` VALUES (678,'en','_CONFIRMATION','Confirmation');
INSERT INTO `aphs_vocabulary` VALUES (5011,'ru','_HOTEL_DESCRIPTION','Hotel Description');
INSERT INTO `aphs_vocabulary` VALUES (681,'en','_CONFIRMATION_CODE','Confirmation Code');
INSERT INTO `aphs_vocabulary` VALUES (4071,'vi','_MS_IMAGE_GALLERY_TYPE','Allowed types of Image Gallery');
INSERT INTO `aphs_vocabulary` VALUES (4072,'vi','_MS_IMAGE_VERIFICATION_ALLOW','Specifies whether to allow image verification (captcha)');
INSERT INTO `aphs_vocabulary` VALUES (684,'en','_CONFIRMED_ALREADY_MSG','Your account has already been confirmed! <br /><br />Click <a href=\'index.php?customer=login\'>here</a> to continue.');
INSERT INTO `aphs_vocabulary` VALUES (5008,'ru','_HOTELS_AND_ROMS','Hotels and Rooms');
INSERT INTO `aphs_vocabulary` VALUES (5009,'ru','_HOTELS_INFO','Hotels Info');
INSERT INTO `aphs_vocabulary` VALUES (5010,'ru','_HOTELS_MANAGEMENT','Hotels Management');
INSERT INTO `aphs_vocabulary` VALUES (4069,'vi','_MS_GALLERY_KEY','The keyword that will be replaced with gallery (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (4070,'vi','_MS_GALLERY_WRAPPER','Defines a wrapper type for gallery');
INSERT INTO `aphs_vocabulary` VALUES (687,'en','_CONFIRMED_SUCCESS_MSG','Thank you for confirming your registration! <br /><br />You may now log into your account. Click <a href=\'index.php?customer=login\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (5007,'ru','_HOTELS','Hotels');
INSERT INTO `aphs_vocabulary` VALUES (690,'en','_CONFIRM_PASSWORD','Confirm Password');
INSERT INTO `aphs_vocabulary` VALUES (4068,'vi','_MS_FIRST_NIGHT_CALCULATING_TYPE','Specifies a type of the \'first night\' value calculating: real or average');
INSERT INTO `aphs_vocabulary` VALUES (693,'en','_CONFIRM_TERMS_CONDITIONS','You must confirm you agree to our Terms & Conditions!');
INSERT INTO `aphs_vocabulary` VALUES (5004,'ru','_HOME','Home');
INSERT INTO `aphs_vocabulary` VALUES (5005,'ru','_HOTEL','Hotel');
INSERT INTO `aphs_vocabulary` VALUES (5006,'ru','_HOTELOWNER_WELCOME_TEXT','Welcome to Hotel Owner Control Panel! With this Control Panel you can easily manage your hotels, customers, reservations and perform a full hotel site management.');
INSERT INTO `aphs_vocabulary` VALUES (4067,'vi','_MS_FAQ_IS_ACTIVE','Defines whether FAQ module is active or not');
INSERT INTO `aphs_vocabulary` VALUES (696,'en','_CONF_PASSWORD_IS_EMPTY','Confirm Password cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (5002,'ru','_HIDDEN','Hidden');
INSERT INTO `aphs_vocabulary` VALUES (5003,'ru','_HIDE','Hide');
INSERT INTO `aphs_vocabulary` VALUES (4066,'vi','_MS_EMAIL','The email address, that will be used to get sent information');
INSERT INTO `aphs_vocabulary` VALUES (699,'en','_CONF_PASSWORD_MATCH','Password must be match with Confirm Password');
INSERT INTO `aphs_vocabulary` VALUES (5001,'ru','_HEADER_IS_EMPTY','Header cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4064,'vi','_MS_DELAY_LENGTH','Defines a length of delay between sending emails (in seconds)');
INSERT INTO `aphs_vocabulary` VALUES (4065,'vi','_MS_DELETE_PENDING_TIME','The maximum pending time for deleting of comment in minutes');
INSERT INTO `aphs_vocabulary` VALUES (702,'en','_CONTACTUS_DEFAULT_EMAIL_ALERT','You have to change default email address for Contact Us module. Click <a href=\'index.php?admin=mod_contact_us_settings\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (4997,'ru','_HDR_TEMPLATE','Template');
INSERT INTO `aphs_vocabulary` VALUES (4998,'ru','_HDR_TEXT_DIRECTION','Text Direction');
INSERT INTO `aphs_vocabulary` VALUES (4999,'ru','_HEADER','Header');
INSERT INTO `aphs_vocabulary` VALUES (5000,'ru','_HEADERS_AND_FOOTERS','Headers & Footers');
INSERT INTO `aphs_vocabulary` VALUES (705,'en','_CONTACT_INFORMATION','Contact Information');
INSERT INTO `aphs_vocabulary` VALUES (4996,'ru','_HDR_SLOGAN_TEXT','Slogan');
INSERT INTO `aphs_vocabulary` VALUES (4063,'vi','_MS_DEFAULT_PAYMENT_SYSTEM','Specifies default payment processing system');
INSERT INTO `aphs_vocabulary` VALUES (708,'en','_CONTACT_US','Contact us');
INSERT INTO `aphs_vocabulary` VALUES (4062,'vi','_MS_CUSTOMERS_IMAGE_VERIFICATION','Specifies whether to allow image verification (captcha) on customer registration page');
INSERT INTO `aphs_vocabulary` VALUES (711,'en','_CONTACT_US_ALREADY_SENT','Your message was already sent. Please try again later or wait _WAIT_ seconds.');
INSERT INTO `aphs_vocabulary` VALUES (4993,'ru','_GUEST_FEE','Guest Fee');
INSERT INTO `aphs_vocabulary` VALUES (4994,'ru','_HDR_FOOTER_TEXT','Footer Text');
INSERT INTO `aphs_vocabulary` VALUES (4995,'ru','_HDR_HEADER_TEXT','Header Text');
INSERT INTO `aphs_vocabulary` VALUES (714,'en','_CONTACT_US_EMAIL_SENT','Thank you for contacting us! Your message has been successfully sent.');
INSERT INTO `aphs_vocabulary` VALUES (4991,'ru','_GUESTS','Guests');
INSERT INTO `aphs_vocabulary` VALUES (4992,'ru','_GUESTS_FEE','Guests Fee');
INSERT INTO `aphs_vocabulary` VALUES (4061,'vi','_MS_CUSTOMERS_CANCEL_RESERVATION','Specifies the number of days before customers may cancel a reservation');
INSERT INTO `aphs_vocabulary` VALUES (717,'en','_CONTACT_US_SETTINGS','Contact Us Settings');
INSERT INTO `aphs_vocabulary` VALUES (4990,'ru','_GUEST','Guest');
INSERT INTO `aphs_vocabulary` VALUES (720,'en','_CONTENT_TYPE','Content Type');
INSERT INTO `aphs_vocabulary` VALUES (723,'en','_CONTINUE_RESERVATION','Continue Reservation');
INSERT INTO `aphs_vocabulary` VALUES (4060,'vi','_MS_CONTACT_US_KEY','The keyword that will be replaced with Contact Us form (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (726,'en','_COPY_TO_OTHER_LANGS','Copy to other languages');
INSERT INTO `aphs_vocabulary` VALUES (729,'en','_COUNT','Count');
INSERT INTO `aphs_vocabulary` VALUES (732,'en','_COUNTRIES','Countries');
INSERT INTO `aphs_vocabulary` VALUES (4989,'ru','_GROUP_TIME_OVERLAPPING_ALERT','This period of time (fully or partially) was already chosen for selected group! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (735,'en','_COUNTRIES_MANAGEMENT','Countries Management');
INSERT INTO `aphs_vocabulary` VALUES (4988,'ru','_GROUP_NAME','Group Name');
INSERT INTO `aphs_vocabulary` VALUES (4059,'vi','_MS_COMMENTS_PAGE_SIZE','Defines how much comments will be shown on one page');
INSERT INTO `aphs_vocabulary` VALUES (738,'en','_COUNTRY','Country');
INSERT INTO `aphs_vocabulary` VALUES (4987,'ru','_GROUP','Group');
INSERT INTO `aphs_vocabulary` VALUES (4058,'vi','_MS_COMMENTS_LENGTH','The maximum length of a comment');
INSERT INTO `aphs_vocabulary` VALUES (741,'en','_COUNTRY_EMPTY_ALERT','Country cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4986,'ru','_GLOBAL_CAMPAIGN','Global Campaign');
INSERT INTO `aphs_vocabulary` VALUES (744,'en','_COUPONS','Coupons');
INSERT INTO `aphs_vocabulary` VALUES (4985,'ru','_GLOBAL','Global');
INSERT INTO `aphs_vocabulary` VALUES (747,'en','_COUPONS_MANAGEMENT','Coupons Management');
INSERT INTO `aphs_vocabulary` VALUES (4984,'ru','_GENERATE','Generate');
INSERT INTO `aphs_vocabulary` VALUES (4057,'vi','_MS_COMMENTS_ALLOW','Specifies whether to allow comments to articles');
INSERT INTO `aphs_vocabulary` VALUES (750,'en','_COUPON_CODE','Coupon Code');
INSERT INTO `aphs_vocabulary` VALUES (4056,'vi','_MS_BOOKING_NUMBER_TYPE','Specifies the type of booking numbers');
INSERT INTO `aphs_vocabulary` VALUES (753,'en','_COUPON_WAS_APPLIED','The coupon _COUPON_CODE_ has been successfully applied!');
INSERT INTO `aphs_vocabulary` VALUES (4982,'ru','_GENERAL_INFO','General Info');
INSERT INTO `aphs_vocabulary` VALUES (4983,'ru','_GENERAL_SETTINGS','General Settings');
INSERT INTO `aphs_vocabulary` VALUES (756,'en','_COUPON_WAS_REMOVED','The coupon has been successfully removed!');
INSERT INTO `aphs_vocabulary` VALUES (4981,'ru','_GENERAL','General');
INSERT INTO `aphs_vocabulary` VALUES (4055,'vi','_MS_BOOKING_MODE','Specifies which mode is turned ON for booking');
INSERT INTO `aphs_vocabulary` VALUES (759,'en','_CREATED_DATE','Date Created');
INSERT INTO `aphs_vocabulary` VALUES (762,'en','_CREATE_ACCOUNT','Create account');
INSERT INTO `aphs_vocabulary` VALUES (4980,'ru','_GALLERY_SETTINGS','Gallery Settings');
INSERT INTO `aphs_vocabulary` VALUES (4054,'vi','_MS_BANNERS_IS_ACTIVE','Defines whether banners module is active or not');
INSERT INTO `aphs_vocabulary` VALUES (765,'en','_CREATE_ACCOUNT_NOTE','NOTE: <br>We recommend that your password should be at least 6 characters long and should be different from your username.<br><br>Your e-mail address must be valid. We use e-mail for communication purposes (order notifications, etc). Therefore, it is essential to provide a valid e-mail address to be able to use our services correctly.<br><br>All your private data is confidential. We will never sell, exchange or market it in any way. For further information on the responsibilities of both parts, you may refer to us.');
INSERT INTO `aphs_vocabulary` VALUES (4967,'ru','_FORGOT_PASSWORD','Forgot your password?');
INSERT INTO `aphs_vocabulary` VALUES (4968,'ru','_FORM','Form');
INSERT INTO `aphs_vocabulary` VALUES (4969,'ru','_FOUND_HOTELS','Found Hotels');
INSERT INTO `aphs_vocabulary` VALUES (4970,'ru','_FOUND_ROOMS','Found Rooms');
INSERT INTO `aphs_vocabulary` VALUES (4971,'ru','_FR','Fr');
INSERT INTO `aphs_vocabulary` VALUES (4972,'ru','_FRI','Fri');
INSERT INTO `aphs_vocabulary` VALUES (4973,'ru','_FRIDAY','Friday');
INSERT INTO `aphs_vocabulary` VALUES (4974,'ru','_FROM','From');
INSERT INTO `aphs_vocabulary` VALUES (4975,'ru','_FROM_TO_DATE_ALERT','Date \'To\' must be the same or later than date \'From\'! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4976,'ru','_FULLY_BOOKED','fully booked/unavailable');
INSERT INTO `aphs_vocabulary` VALUES (4977,'ru','_FULL_PRICE','Full Price');
INSERT INTO `aphs_vocabulary` VALUES (4978,'ru','_GALLERY','Gallery');
INSERT INTO `aphs_vocabulary` VALUES (4979,'ru','_GALLERY_MANAGEMENT','Gallery Management');
INSERT INTO `aphs_vocabulary` VALUES (4053,'vi','_MS_BANNERS_CAPTION_HTML','Specifies whether to allow using of HTML in slideshow captions or not');
INSERT INTO `aphs_vocabulary` VALUES (768,'en','_CREATING_ACCOUNT_ERROR','An error occurred while creating your account! Please try again later or send information about this error to administration of the site.');
INSERT INTO `aphs_vocabulary` VALUES (771,'en','_CREATING_NEW_ACCOUNT','Creating new account');
INSERT INTO `aphs_vocabulary` VALUES (774,'en','_CREDIT_CARD','Credit Card');
INSERT INTO `aphs_vocabulary` VALUES (4052,'vi','_MS_BANK_TRANSFER_INFO','Specifies a required banking information: name of the bank, branch, account number etc.');
INSERT INTO `aphs_vocabulary` VALUES (777,'en','_CREDIT_CARD_EXPIRES','Expires');
INSERT INTO `aphs_vocabulary` VALUES (4966,'ru','_FORCE_SSL_ALERT','Force site access to always occur under SSL (https) for selected areas. You or site visitors will not be able to access selected areas under non-ssl. Note, you must have SSL enabled on your server to make this option works.');
INSERT INTO `aphs_vocabulary` VALUES (780,'en','_CREDIT_CARD_HOLDER_NAME','Card Holder\'s Name');
INSERT INTO `aphs_vocabulary` VALUES (4965,'ru','_FORCE_SSL','Force SSL');
INSERT INTO `aphs_vocabulary` VALUES (783,'en','_CREDIT_CARD_NUMBER','Credit Card Number');
INSERT INTO `aphs_vocabulary` VALUES (4051,'vi','_MS_AVAILABLE_UNTIL_APPROVAL','Specifies whether to show \'reserved\' rooms in search results until booking is complete');
INSERT INTO `aphs_vocabulary` VALUES (786,'en','_CREDIT_CARD_TYPE','Credit Card Type');
INSERT INTO `aphs_vocabulary` VALUES (4964,'ru','_FOOTER_IS_EMPTY','Footer cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4050,'vi','_MS_AUTHORIZE_TRANSACTION_KEY','Specifies Authorize.Net Transaction Key');
INSERT INTO `aphs_vocabulary` VALUES (789,'en','_CRONJOB_HTACCESS_BLOCK','To block remote access to cron.php, in the server&#039;s .htaccess file or vhost configuration file add this section:');
INSERT INTO `aphs_vocabulary` VALUES (4961,'ru','_FIRST_NAME_EMPTY_ALERT','First Name cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4962,'ru','_FIRST_NIGHT','First Night');
INSERT INTO `aphs_vocabulary` VALUES (4963,'ru','_FIXED_SUM','Fixed Sum');
INSERT INTO `aphs_vocabulary` VALUES (4048,'vi','_MS_ALLOW_SYSTEM_SUGGESTION','Specifies whether to show system suggestion feature on empty search results');
INSERT INTO `aphs_vocabulary` VALUES (4049,'vi','_MS_AUTHORIZE_LOGIN_ID','Specifies Authorize.Net API Login ID');
INSERT INTO `aphs_vocabulary` VALUES (792,'en','_CRONJOB_NOTICE','Cron jobs allow you to automate certain commands or scripts on your site.<br /><br />ApPHP Hotel Site needs to periodically run cron.php to close expired discount campaigns or perform another importans operations. The recommended way to run cron.php is to set up a cronjob if you run a Unix/Linux server. If for any reason you can&#039;t run a cronjob on your server, you can choose the Non-batch option below to have cron.php run by ApPHP Hotel Site itself: in this case cron.php will be run each time someone access your home page. <br /><br />Example of Batch Cron job command: <b>php &#36;HOME/public_html/cron.php >/dev/null 2>&1</b>');
INSERT INTO `aphs_vocabulary` VALUES (4953,'ru','_FIELD_VALUE_EXCEEDED','_FIELD_ has exceeded the maximum allowed value _MAX_! Please re-enter. ');
INSERT INTO `aphs_vocabulary` VALUES (4954,'ru','_FIELD_VALUE_MINIMUM','_FIELD_ value should not be less then _MIN_! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4955,'ru','_FILED_UNIQUE_VALUE_ALERT','The field _FIELD_ accepts only unique values - please re-enter!');
INSERT INTO `aphs_vocabulary` VALUES (4956,'ru','_FILE_DELETING_ERROR','An error occurred while deleting file! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (4957,'ru','_FILTER_BY','Filter by');
INSERT INTO `aphs_vocabulary` VALUES (4958,'ru','_FINISH_DATE','Finish Date');
INSERT INTO `aphs_vocabulary` VALUES (4959,'ru','_FINISH_PUBLISHING','Finish Publishing');
INSERT INTO `aphs_vocabulary` VALUES (4960,'ru','_FIRST_NAME','First Name');
INSERT INTO `aphs_vocabulary` VALUES (795,'en','_CRON_JOBS','Cron Jobs');
INSERT INTO `aphs_vocabulary` VALUES (4952,'ru','_FIELD_MUST_BE_UNSIGNED_INT','Field _FIELD_ must be an unsigned integer value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4047,'vi','_MS_ALLOW_GUESTS_IN_ROOM','Specifies whether to allow guests in the room');
INSERT INTO `aphs_vocabulary` VALUES (798,'en','_CURRENCIES','Currencies');
INSERT INTO `aphs_vocabulary` VALUES (4045,'vi','_MS_ALLOW_CUSTOMERS_REGISTRATION','Specifies whether to allow registration of new customers');
INSERT INTO `aphs_vocabulary` VALUES (4046,'vi','_MS_ALLOW_CUST_RESET_PASSWORDS','Specifies whether to allow customers to restore their passwords');
INSERT INTO `aphs_vocabulary` VALUES (801,'en','_CURRENCIES_DEFAULT_ALERT','Remember! After you change the default currency:<br>- Edit exchange rate to each currency manually (relatively to the new default currency)<br>- Redefine prices for all rooms in the new currency.');
INSERT INTO `aphs_vocabulary` VALUES (4950,'ru','_FIELD_MUST_BE_TEXT','_FIELD_ value must be a text! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4951,'ru','_FIELD_MUST_BE_UNSIGNED_FLOAT','Field _FIELD_ must be an unsigned float value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (804,'en','_CURRENCIES_MANAGEMENT','Currencies Management');
INSERT INTO `aphs_vocabulary` VALUES (807,'en','_CURRENCY','Currency');
INSERT INTO `aphs_vocabulary` VALUES (4949,'ru','_FIELD_MUST_BE_SIZE_VALUE','Field _FIELD_ must be a valid HTML size property in \'px\', \'pt\', \'em\' or \'%\' units! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4044,'vi','_MS_ALLOW_CUSTOMERS_LOGIN','Specifies whether to allow existing customers to login');
INSERT INTO `aphs_vocabulary` VALUES (810,'en','_CURRENT_NEXT_YEARS','for current/next years');
INSERT INTO `aphs_vocabulary` VALUES (813,'en','_CUSTOMER','Customer');
INSERT INTO `aphs_vocabulary` VALUES (816,'en','_CUSTOMERS','Customers');
INSERT INTO `aphs_vocabulary` VALUES (4948,'ru','_FIELD_MUST_BE_POSITIVE_INTEGER','Field _FIELD_ must be a positive integer number!');
INSERT INTO `aphs_vocabulary` VALUES (4042,'vi','_MS_ALLOW_BOOKING_WITHOUT_ACCOUNT','Specifies whether to allow booking for customer without creating account');
INSERT INTO `aphs_vocabulary` VALUES (4043,'vi','_MS_ALLOW_CHILDREN_IN_ROOM','Specifies whether to allow children in the room');
INSERT INTO `aphs_vocabulary` VALUES (819,'en','_CUSTOMERS_AWAITING_MODERATION_ALERT','There are _COUNT_ customer/s awaiting your approval. Click <a href=\'index.php?admin=mod_customers_management\'>here</a> for review.');
INSERT INTO `aphs_vocabulary` VALUES (4947,'ru','_FIELD_MUST_BE_POSITIVE_INT','Field _FIELD_ must be a positive integer value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (822,'en','_CUSTOMERS_MANAGEMENT','Customers Management');
INSERT INTO `aphs_vocabulary` VALUES (825,'en','_CUSTOMERS_SETTINGS','Customers Settings');
INSERT INTO `aphs_vocabulary` VALUES (4946,'ru','_FIELD_MUST_BE_PASSWORD','_FIELD_ must be 6 characters at least and consist of letters and digits! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4041,'vi','_MS_ALLOW_ADDING_BY_ADMIN','Specifies whether to allow adding new customers by Admin');
INSERT INTO `aphs_vocabulary` VALUES (828,'en','_CUSTOMER_DETAILS','Customer Details');
INSERT INTO `aphs_vocabulary` VALUES (831,'en','_CUSTOMER_GROUP','Customer Group');
INSERT INTO `aphs_vocabulary` VALUES (834,'en','_CUSTOMER_GROUPS','Customer Groups');
INSERT INTO `aphs_vocabulary` VALUES (4945,'ru','_FIELD_MUST_BE_NUMERIC_POSITIVE','Field _FIELD_ must be a positive numeric value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (837,'en','_CUSTOMER_LOGIN','Customer Login');
INSERT INTO `aphs_vocabulary` VALUES (4040,'vi','_MS_ALERT_ADMIN_NEW_REGISTRATION','Specifies whether to alert admin on new customer registration');
INSERT INTO `aphs_vocabulary` VALUES (840,'en','_CUSTOMER_NAME','Customer Name');
INSERT INTO `aphs_vocabulary` VALUES (843,'en','_CUSTOMER_PANEL','Customer Panel');
INSERT INTO `aphs_vocabulary` VALUES (4944,'ru','_FIELD_MUST_BE_NUMERIC','Field _FIELD_ must be a numeric value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (846,'en','_CUSTOMER_PAYMENT_MODULES','Customer & Payment Modules');
INSERT INTO `aphs_vocabulary` VALUES (849,'en','_CVV_CODE','CVV Code');
INSERT INTO `aphs_vocabulary` VALUES (852,'en','_DASHBOARD','Dashboard');
INSERT INTO `aphs_vocabulary` VALUES (4039,'vi','_MS_ALBUM_KEY','The keyword that will be replaced with a certain album images (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (855,'en','_DATE','Date');
INSERT INTO `aphs_vocabulary` VALUES (4943,'ru','_FIELD_MUST_BE_IP_ADDRESS','_FIELD_ must be a valid IP Address! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4038,'vi','_MS_ALBUM_ICON_WIDTH','Album icon width');
INSERT INTO `aphs_vocabulary` VALUES (858,'en','_DATETIME_PRICE_FORMAT','Datetime & Price Settings');
INSERT INTO `aphs_vocabulary` VALUES (861,'en','_DATE_AND_TIME_SETTINGS','Date & Time Settings');
INSERT INTO `aphs_vocabulary` VALUES (4037,'vi','_MS_ALBUM_ICON_HEIGHT','Album icon height');
INSERT INTO `aphs_vocabulary` VALUES (864,'en','_DATE_CREATED','Date Created');
INSERT INTO `aphs_vocabulary` VALUES (4942,'ru','_FIELD_MUST_BE_FLOAT_POSITIVE','Field _FIELD_ must be a positive float number value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4036,'vi','_MS_ALBUMS_PER_LINE','Number of album icons per line');
INSERT INTO `aphs_vocabulary` VALUES (867,'en','_DATE_EMPTY_ALERT','Date fields cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4941,'ru','_FIELD_MUST_BE_FLOAT','Field _FIELD_ must be a float number value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (870,'en','_DATE_FORMAT','Date Format');
INSERT INTO `aphs_vocabulary` VALUES (873,'en','_DATE_MODIFIED','Date Modified');
INSERT INTO `aphs_vocabulary` VALUES (4035,'vi','_MS_ADMIN_CHANGE_USER_PASSWORD','Specifies whether to allow changing user password by Admin');
INSERT INTO `aphs_vocabulary` VALUES (876,'en','_DATE_PAYMENT','Date of Payment');
INSERT INTO `aphs_vocabulary` VALUES (4940,'ru','_FIELD_MUST_BE_EMAIL','_FIELD_ must be in valid email format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (879,'en','_DATE_PUBLISHED','Date Published');
INSERT INTO `aphs_vocabulary` VALUES (882,'en','_DATE_SUBSCRIBED','Date Subscribed');
INSERT INTO `aphs_vocabulary` VALUES (885,'en','_DAY','Day');
INSERT INTO `aphs_vocabulary` VALUES (4939,'ru','_FIELD_MUST_BE_BOOLEAN','Field _FIELD_ value must be \'yes\' or \'no\'! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (888,'en','_DECEMBER','December');
INSERT INTO `aphs_vocabulary` VALUES (4034,'vi','_MS_ADMIN_CHANGE_CUSTOMER_PASSWORD','Specifies whether to allow changing customer password by Admin');
INSERT INTO `aphs_vocabulary` VALUES (891,'en','_DEFAULT','Default');
INSERT INTO `aphs_vocabulary` VALUES (894,'en','_DEFAULT_AVAILABILITY','Default Availability');
INSERT INTO `aphs_vocabulary` VALUES (4938,'ru','_FIELD_MUST_BE_ALPHA_NUMERIC','_FIELD_ must be an alphanumeric value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4033,'vi','_MS_ADMIN_BOOKING_IN_PAST','Specifies whether to allow booking in the past for admins and hotel owners');
INSERT INTO `aphs_vocabulary` VALUES (897,'en','_DEFAULT_CURRENCY_DELETE_ALERT','You cannot delete default currency!');
INSERT INTO `aphs_vocabulary` VALUES (4031,'vi','_MONTHS','Months');
INSERT INTO `aphs_vocabulary` VALUES (4032,'vi','_MS_ACTIVATE_BOOKINGS','Specifies whether booking module is active on a Whole Site, Front-End/Back-End only or inactive');
INSERT INTO `aphs_vocabulary` VALUES (900,'en','_DEFAULT_EMAIL_ALERT','You have to change default email address for site administrator. Click <a href=\'index.php?admin=settings&tabid=1_4\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (4936,'ru','_FIELD_MIN_LENGTH_ALERT','The length of the field _FIELD_ cannot  be less than _LENGTH_ characters! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4937,'ru','_FIELD_MUST_BE_ALPHA','_FIELD_ must be an alphabetic value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4029,'vi','_MONDAY','Monday');
INSERT INTO `aphs_vocabulary` VALUES (4030,'vi','_MONTH','Month');
INSERT INTO `aphs_vocabulary` VALUES (903,'en','_DEFAULT_HOTEL_DELETE_ALERT','You cannot delete default hotel!');
INSERT INTO `aphs_vocabulary` VALUES (4028,'vi','_MON','Mon');
INSERT INTO `aphs_vocabulary` VALUES (906,'en','_DEFAULT_OWN_EMAIL_ALERT','You have to change your own email address. Click <a href=\'index.php?admin=my_account\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (4934,'ru','_FIELD_LENGTH_ALERT','The length of the field _FIELD_ must be less than _LENGTH_ characters! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4935,'ru','_FIELD_LENGTH_EXCEEDED','_FIELD_ has exceeded the maximum allowed size: _LENGTH_ characters! Please re-enter. ');
INSERT INTO `aphs_vocabulary` VALUES (909,'en','_DEFAULT_PRICE','Default Price');
INSERT INTO `aphs_vocabulary` VALUES (4027,'vi','_MODULE_UNINSTALL_ALERT','Are you sure you want to un-install this module? All data, related to this module will be permanently deleted form the system!');
INSERT INTO `aphs_vocabulary` VALUES (912,'en','_DEFAULT_TEMPLATE','Default Template');
INSERT INTO `aphs_vocabulary` VALUES (4026,'vi','_MODULE_UNINSTALLED','Module was successfully un-installed!');
INSERT INTO `aphs_vocabulary` VALUES (915,'en','_DELETE_WARNING','Are you sure you want to delete this record?');
INSERT INTO `aphs_vocabulary` VALUES (4932,'ru','_FEBRUARY','February');
INSERT INTO `aphs_vocabulary` VALUES (4933,'ru','_FIELD_CANNOT_BE_EMPTY','Field _FIELD_ cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (918,'en','_DELETE_WARNING_COMMON','Are you sure you want to delete this record?');
INSERT INTO `aphs_vocabulary` VALUES (4931,'ru','_FAX','Fax');
INSERT INTO `aphs_vocabulary` VALUES (921,'en','_DELETE_WORD','Delete');
INSERT INTO `aphs_vocabulary` VALUES (4930,'ru','_FAQ_SETTINGS','FAQ Settings');
INSERT INTO `aphs_vocabulary` VALUES (4023,'vi','_MODULES_NOT_FOUND','No modules found!');
INSERT INTO `aphs_vocabulary` VALUES (4024,'vi','_MODULE_INSTALLED','Module was successfully installed!');
INSERT INTO `aphs_vocabulary` VALUES (4025,'vi','_MODULE_INSTALL_ALERT','Are you sure you want to install this module?');
INSERT INTO `aphs_vocabulary` VALUES (924,'en','_DELETING_ACCOUNT_ERROR','An error occurred while deleting your account! Please try again later or send email about this issue to administration of the site.');
INSERT INTO `aphs_vocabulary` VALUES (4927,'ru','_FACILITIES','Facilities');
INSERT INTO `aphs_vocabulary` VALUES (4928,'ru','_FAQ','FAQ');
INSERT INTO `aphs_vocabulary` VALUES (4929,'ru','_FAQ_MANAGEMENT','FAQ Management');
INSERT INTO `aphs_vocabulary` VALUES (4022,'vi','_MODULES_MANAGEMENT','Modules Management');
INSERT INTO `aphs_vocabulary` VALUES (927,'en','_DELETING_OPERATION_COMPLETED','Deleting operation was successfully completed!');
INSERT INTO `aphs_vocabulary` VALUES (4925,'ru','_EXTRAS_MANAGEMENT','Extras Management');
INSERT INTO `aphs_vocabulary` VALUES (4926,'ru','_EXTRAS_SUBTOTAL','Extras Subtotal');
INSERT INTO `aphs_vocabulary` VALUES (4021,'vi','_MODULES','Modules');
INSERT INTO `aphs_vocabulary` VALUES (930,'en','_DESCRIPTION','Description');
INSERT INTO `aphs_vocabulary` VALUES (4924,'ru','_EXTRAS','Extras');
INSERT INTO `aphs_vocabulary` VALUES (4020,'vi','_MO','Mo');
INSERT INTO `aphs_vocabulary` VALUES (933,'en','_DISCOUNT','Discount');
INSERT INTO `aphs_vocabulary` VALUES (4923,'ru','_EXPORT','Export');
INSERT INTO `aphs_vocabulary` VALUES (4019,'vi','_MINUTES','minutes');
INSERT INTO `aphs_vocabulary` VALUES (936,'en','_DISCOUNT_BY_ADMIN','Discount By Administrator');
INSERT INTO `aphs_vocabulary` VALUES (4922,'ru','_EXPIRED','Expired');
INSERT INTO `aphs_vocabulary` VALUES (939,'en','_DISCOUNT_CAMPAIGN','Discount Campaign');
INSERT INTO `aphs_vocabulary` VALUES (4921,'ru','_EXPAND_PANEL','Expand navigation panel');
INSERT INTO `aphs_vocabulary` VALUES (942,'en','_DISCOUNT_CAMPAIGNS','Discount Campaigns');
INSERT INTO `aphs_vocabulary` VALUES (4015,'vi','_METHOD','Method');
INSERT INTO `aphs_vocabulary` VALUES (4016,'vi','_MIN','Min');
INSERT INTO `aphs_vocabulary` VALUES (4017,'vi','_MINIMUM_NIGHTS','Minimum Nights');
INSERT INTO `aphs_vocabulary` VALUES (4018,'vi','_MINIMUM_NIGHTS_ALERT','The minimum allowed stay for the period of time from _FROM_ to _TO_ is _NIGHTS_ nights per booking. Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (945,'en','_DISCOUNT_CAMPAIGN_TEXT','<span class=\'campaign_header\'>Super discount campaign!</span><br /><br />\r\nEnjoy special price cuts <br />_FROM_ _TO_:<br /> \r\n<b>_PERCENT_</b> on every room reservation in our Hotel!');
INSERT INTO `aphs_vocabulary` VALUES (4919,'ru','_EVENT_REGISTRATION_COMPLETED','Thank you for your interest! You have just successfully registered to this event.');
INSERT INTO `aphs_vocabulary` VALUES (4920,'ru','_EVENT_USER_ALREADY_REGISTERED','Member with such email was already registered to this event! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4013,'vi','_META_TAG','Meta Tag');
INSERT INTO `aphs_vocabulary` VALUES (4014,'vi','_META_TAGS','META Tags');
INSERT INTO `aphs_vocabulary` VALUES (948,'en','_DISCOUNT_STD_CAMPAIGN_TEXT','Super discount campaign!<br><br>Enjoy special price cuts in our Hotel at the specified periods of time below!');
INSERT INTO `aphs_vocabulary` VALUES (4916,'ru','_ENTER_EMAIL_ADDRESS','(Please enter ONLY real email address)');
INSERT INTO `aphs_vocabulary` VALUES (4917,'ru','_ENTIRE_SITE','Entire Site');
INSERT INTO `aphs_vocabulary` VALUES (4918,'ru','_EVENTS','Events');
INSERT INTO `aphs_vocabulary` VALUES (4012,'vi','_MESSAGE_EMPTY_ALERT','Message cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (951,'en','_DISPLAY_ON','Display on');
INSERT INTO `aphs_vocabulary` VALUES (4011,'vi','_MESSAGE','Message');
INSERT INTO `aphs_vocabulary` VALUES (954,'en','_DOWN','Down');
INSERT INTO `aphs_vocabulary` VALUES (4010,'vi','_MENU_WORD','Menu');
INSERT INTO `aphs_vocabulary` VALUES (957,'en','_DOWNLOAD','Download');
INSERT INTO `aphs_vocabulary` VALUES (4915,'ru','_ENTER_CONFIRMATION_CODE','Enter Confirmation Code');
INSERT INTO `aphs_vocabulary` VALUES (4009,'vi','_MENU_TITLE','Menu Title');
INSERT INTO `aphs_vocabulary` VALUES (960,'en','_DOWNLOAD_INVOICE','Download Invoice');
INSERT INTO `aphs_vocabulary` VALUES (963,'en','_ECHECK','E-Check');
INSERT INTO `aphs_vocabulary` VALUES (4914,'ru','_ENTER_BOOKING_NUMBER','Enter Your Booking Number');
INSERT INTO `aphs_vocabulary` VALUES (4008,'vi','_MENU_SAVED','Menu was successfully saved');
INSERT INTO `aphs_vocabulary` VALUES (966,'en','_EDIT_MENUS','Edit Menus');
INSERT INTO `aphs_vocabulary` VALUES (4913,'ru','_EMPTY','Empty');
INSERT INTO `aphs_vocabulary` VALUES (969,'en','_EDIT_MY_ACCOUNT','Edit My Account');
INSERT INTO `aphs_vocabulary` VALUES (972,'en','_EDIT_PAGE','Edit Page');
INSERT INTO `aphs_vocabulary` VALUES (4007,'vi','_MENU_ORDER_CHANGED','Menu order was successfully changed');
INSERT INTO `aphs_vocabulary` VALUES (975,'en','_EDIT_WORD','Edit');
INSERT INTO `aphs_vocabulary` VALUES (978,'en','_EMAIL','Email');
INSERT INTO `aphs_vocabulary` VALUES (4912,'ru','_EMAIL_VALID_ALERT','Please enter a valid email address!');
INSERT INTO `aphs_vocabulary` VALUES (4004,'vi','_MENU_NOT_FOUND','No Menus Found');
INSERT INTO `aphs_vocabulary` VALUES (4005,'vi','_MENU_NOT_SAVED','Menu was not saved!');
INSERT INTO `aphs_vocabulary` VALUES (4006,'vi','_MENU_ORDER','Menu Order');
INSERT INTO `aphs_vocabulary` VALUES (981,'en','_EMAILS_SENT_ERROR','An error occurred while sending emails or there are no emails to be sent! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (4909,'ru','_EMAIL_TEMPLATES','Email Templates');
INSERT INTO `aphs_vocabulary` VALUES (4910,'ru','_EMAIL_TEMPLATES_EDITOR','Email Templates Editor');
INSERT INTO `aphs_vocabulary` VALUES (4911,'ru','_EMAIL_TO','Email Address (To)');
INSERT INTO `aphs_vocabulary` VALUES (4003,'vi','_MENU_NOT_DELETED','Menu was not deleted!');
INSERT INTO `aphs_vocabulary` VALUES (984,'en','_EMAILS_SUCCESSFULLY_SENT','Status: _SENT_ emails from _TOTAL_ were successfully sent!');
INSERT INTO `aphs_vocabulary` VALUES (4907,'ru','_EMAIL_SETTINGS','Email Settings');
INSERT INTO `aphs_vocabulary` VALUES (4908,'ru','_EMAIL_SUCCESSFULLY_SENT','Email was successfully sent!');
INSERT INTO `aphs_vocabulary` VALUES (4002,'vi','_MENU_NOT_CREATED','Menu was not created!');
INSERT INTO `aphs_vocabulary` VALUES (987,'en','_EMAIL_ADDRESS','E-mail address');
INSERT INTO `aphs_vocabulary` VALUES (4001,'vi','_MENU_NAME_EMPTY','Menu name cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (990,'en','_EMAIL_BLOCKED','Your email was blocked! To resolve this problem, please contact the site administrator.');
INSERT INTO `aphs_vocabulary` VALUES (4906,'ru','_EMAIL_SEND_ERROR','An error occurred while sending email. Please check your email settings and message recipients, then try again.');
INSERT INTO `aphs_vocabulary` VALUES (4000,'vi','_MENU_NAME','Menu Name');
INSERT INTO `aphs_vocabulary` VALUES (993,'en','_EMAIL_EMPTY_ALERT','Email cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4905,'ru','_EMAIL_NOT_EXISTS','This e-mail account does not exist in the system! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3999,'vi','_MENU_MISSED','Missed menu to update! Please, try again.');
INSERT INTO `aphs_vocabulary` VALUES (996,'en','_EMAIL_FROM','Email Address (From)');
INSERT INTO `aphs_vocabulary` VALUES (3998,'vi','_MENU_MANAGEMENT','Menus Management');
INSERT INTO `aphs_vocabulary` VALUES (999,'en','_EMAIL_IS_EMPTY','Email must not be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4904,'ru','_EMAIL_NOTIFICATIONS','Send email notifications');
INSERT INTO `aphs_vocabulary` VALUES (3997,'vi','_MENU_LINK_TEXT','Menu Link (max. 40 chars)');
INSERT INTO `aphs_vocabulary` VALUES (1002,'en','_EMAIL_IS_WRONG','Please enter a valid email address.');
INSERT INTO `aphs_vocabulary` VALUES (4903,'ru','_EMAIL_IS_WRONG','Please enter a valid email address.');
INSERT INTO `aphs_vocabulary` VALUES (3996,'vi','_MENU_LINK','Menu Link');
INSERT INTO `aphs_vocabulary` VALUES (1005,'en','_EMAIL_NOTIFICATIONS','Send email notifications');
INSERT INTO `aphs_vocabulary` VALUES (4902,'ru','_EMAIL_IS_EMPTY','Email must not be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3995,'vi','_MENU_EDIT','Edit Menu');
INSERT INTO `aphs_vocabulary` VALUES (1008,'en','_EMAIL_NOT_EXISTS','This e-mail account does not exist in the system! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4900,'ru','_EMAIL_EMPTY_ALERT','Email cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4901,'ru','_EMAIL_FROM','Email Address (From)');
INSERT INTO `aphs_vocabulary` VALUES (3994,'vi','_MENU_DELETE_WARNING','Are you sure you want to delete this menu? Note: this will make all its menu links invisible to your site visitors!');
INSERT INTO `aphs_vocabulary` VALUES (1011,'en','_EMAIL_SEND_ERROR','An error occurred while sending email. Please check your email settings and message recipients, then try again.');
INSERT INTO `aphs_vocabulary` VALUES (4898,'ru','_EMAIL_ADDRESS','E-mail address');
INSERT INTO `aphs_vocabulary` VALUES (4899,'ru','_EMAIL_BLOCKED','Your email was blocked! To resolve this problem, please contact the site administrator.');
INSERT INTO `aphs_vocabulary` VALUES (3993,'vi','_MENU_DELETED','Menu was successfully deleted');
INSERT INTO `aphs_vocabulary` VALUES (1014,'en','_EMAIL_SETTINGS','Email Settings');
INSERT INTO `aphs_vocabulary` VALUES (3992,'vi','_MENU_CREATED','Menu was successfully created');
INSERT INTO `aphs_vocabulary` VALUES (1017,'en','_EMAIL_SUCCESSFULLY_SENT','Email was successfully sent!');
INSERT INTO `aphs_vocabulary` VALUES (4897,'ru','_EMAILS_SUCCESSFULLY_SENT','Status: _SENT_ emails from _TOTAL_ were successfully sent!');
INSERT INTO `aphs_vocabulary` VALUES (3991,'vi','_MENU_ADD','Add Menu');
INSERT INTO `aphs_vocabulary` VALUES (1020,'en','_EMAIL_TEMPLATES','Email Templates');
INSERT INTO `aphs_vocabulary` VALUES (3990,'vi','_MENUS_AND_PAGES','Menus and Pages');
INSERT INTO `aphs_vocabulary` VALUES (1023,'en','_EMAIL_TEMPLATES_EDITOR','Email Templates Editor');
INSERT INTO `aphs_vocabulary` VALUES (3989,'vi','_MENUS','Menus');
INSERT INTO `aphs_vocabulary` VALUES (1026,'en','_EMAIL_TO','Email Address (To)');
INSERT INTO `aphs_vocabulary` VALUES (4896,'ru','_EMAILS_SENT_ERROR','An error occurred while sending emails or there are no emails to be sent! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (1029,'en','_EMAIL_VALID_ALERT','Please enter a valid email address!');
INSERT INTO `aphs_vocabulary` VALUES (4895,'ru','_EMAIL','Email');
INSERT INTO `aphs_vocabulary` VALUES (3988,'vi','_MEAL_PLANS_MANAGEMENT','Meal Plans Management');
INSERT INTO `aphs_vocabulary` VALUES (1032,'en','_EMPTY','Empty');
INSERT INTO `aphs_vocabulary` VALUES (4894,'ru','_EDIT_WORD','Edit');
INSERT INTO `aphs_vocabulary` VALUES (3987,'vi','_MEAL_PLANS','Meal Plans');
INSERT INTO `aphs_vocabulary` VALUES (1035,'en','_ENTER_BOOKING_NUMBER','Enter Your Booking Number');
INSERT INTO `aphs_vocabulary` VALUES (4893,'ru','_EDIT_PAGE','Edit Page');
INSERT INTO `aphs_vocabulary` VALUES (1038,'en','_ENTER_CONFIRMATION_CODE','Enter Confirmation Code');
INSERT INTO `aphs_vocabulary` VALUES (4892,'ru','_EDIT_MY_ACCOUNT','Edit My Account');
INSERT INTO `aphs_vocabulary` VALUES (1041,'en','_ENTER_EMAIL_ADDRESS','(Please enter ONLY real email address)');
INSERT INTO `aphs_vocabulary` VALUES (4890,'ru','_ECHECK','E-Check');
INSERT INTO `aphs_vocabulary` VALUES (4891,'ru','_EDIT_MENUS','Edit Menus');
INSERT INTO `aphs_vocabulary` VALUES (1044,'en','_ENTIRE_SITE','Entire Site');
INSERT INTO `aphs_vocabulary` VALUES (3986,'vi','_MD_TESTIMONIALS','The Testimonials Module allows the administrator of the site to add/edit customer testimonials, manage them and show on the Hotel Site frontend.');
INSERT INTO `aphs_vocabulary` VALUES (1047,'en','_EVENTS','Events');
INSERT INTO `aphs_vocabulary` VALUES (4889,'ru','_DOWNLOAD_INVOICE','Download Invoice');
INSERT INTO `aphs_vocabulary` VALUES (1050,'en','_EVENT_REGISTRATION_COMPLETED','Thank you for your interest! You have just successfully registered to this event.');
INSERT INTO `aphs_vocabulary` VALUES (4887,'ru','_DOWN','Down');
INSERT INTO `aphs_vocabulary` VALUES (4888,'ru','_DOWNLOAD','Download');
INSERT INTO `aphs_vocabulary` VALUES (3985,'vi','_MD_ROOMS','The Rooms module allows the site owner easily manage rooms in your hotel: create, edit or remove them, specify room facilities, define prices and availability for certain period of time, etc.');
INSERT INTO `aphs_vocabulary` VALUES (1053,'en','_EVENT_USER_ALREADY_REGISTERED','Member with such email was already registered to this event! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4886,'ru','_DISPLAY_ON','Display on');
INSERT INTO `aphs_vocabulary` VALUES (1056,'en','_EXPAND_PANEL','Expand navigation panel');
INSERT INTO `aphs_vocabulary` VALUES (4885,'ru','_DISCOUNT_STD_CAMPAIGN_TEXT','Super discount campaign!<br><br>Enjoy special price cuts in our Hotel at the specified periods of time below!');
INSERT INTO `aphs_vocabulary` VALUES (1059,'en','_EXPIRED','Expired');
INSERT INTO `aphs_vocabulary` VALUES (3984,'vi','_MD_PAGES','Pages module allows administrator to easily create and maintain page content.');
INSERT INTO `aphs_vocabulary` VALUES (1062,'en','_EXPORT','Export');
INSERT INTO `aphs_vocabulary` VALUES (1065,'en','_EXTRAS','Extras');
INSERT INTO `aphs_vocabulary` VALUES (1068,'en','_EXTRAS_MANAGEMENT','Extras Management');
INSERT INTO `aphs_vocabulary` VALUES (1071,'en','_EXTRAS_SUBTOTAL','Extras Subtotal');
INSERT INTO `aphs_vocabulary` VALUES (1074,'en','_FACILITIES','Facilities');
INSERT INTO `aphs_vocabulary` VALUES (3983,'vi','_MD_NEWS','The News and Events module allows administrator to post news and events on the site, display latest of them at the side block.');
INSERT INTO `aphs_vocabulary` VALUES (1077,'en','_FAQ','FAQ');
INSERT INTO `aphs_vocabulary` VALUES (1080,'en','_FAQ_MANAGEMENT','FAQ Management');
INSERT INTO `aphs_vocabulary` VALUES (4884,'ru','_DISCOUNT_CAMPAIGN_TEXT','<span class=\'campaign_header\'>Super discount campaign!</span><br /><br />\r\nEnjoy special price cuts <br />_FROM_ _TO_:<br /> \r\n<b>_PERCENT_</b> on every room reservation in our Hotel!');
INSERT INTO `aphs_vocabulary` VALUES (1083,'en','_FAQ_SETTINGS','FAQ Settings');
INSERT INTO `aphs_vocabulary` VALUES (1086,'en','_FAX','Fax');
INSERT INTO `aphs_vocabulary` VALUES (1089,'en','_FEBRUARY','February');
INSERT INTO `aphs_vocabulary` VALUES (4883,'ru','_DISCOUNT_CAMPAIGNS','Discount Campaigns');
INSERT INTO `aphs_vocabulary` VALUES (1092,'en','_FIELD_CANNOT_BE_EMPTY','Field _FIELD_ cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4882,'ru','_DISCOUNT_CAMPAIGN','Discount Campaign');
INSERT INTO `aphs_vocabulary` VALUES (3982,'vi','_MD_GALLERY','The Gallery module allows administrator to create image or video albums, upload album content and dysplay this content to be viewed by visitor of the site.');
INSERT INTO `aphs_vocabulary` VALUES (1095,'en','_FIELD_LENGTH_ALERT','The length of the field _FIELD_ must be less than _LENGTH_ characters! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4879,'ru','_DESCRIPTION','Description');
INSERT INTO `aphs_vocabulary` VALUES (4880,'ru','_DISCOUNT','Discount');
INSERT INTO `aphs_vocabulary` VALUES (4881,'ru','_DISCOUNT_BY_ADMIN','Discount By Administrator');
INSERT INTO `aphs_vocabulary` VALUES (3981,'vi','_MD_FAQ','The Frequently Asked Questions (faq) module allows admin users to create question and answer pairs which they want displayed on the \'faq\' page.');
INSERT INTO `aphs_vocabulary` VALUES (1098,'en','_FIELD_LENGTH_EXCEEDED','_FIELD_ has exceeded the maximum allowed size: _LENGTH_ characters! Please re-enter. ');
INSERT INTO `aphs_vocabulary` VALUES (4878,'ru','_DELETING_OPERATION_COMPLETED','Deleting operation was successfully completed!');
INSERT INTO `aphs_vocabulary` VALUES (1101,'en','_FIELD_MIN_LENGTH_ALERT','The length of the field _FIELD_ cannot  be less than _LENGTH_ characters! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3980,'vi','_MD_CUSTOMERS','The Customers module allows easy customers management on your site. Administrator could create, edit or delete customer accounts. Customers could register on the site and log into their accounts.');
INSERT INTO `aphs_vocabulary` VALUES (1104,'en','_FIELD_MUST_BE_ALPHA','_FIELD_ must be an alphabetic value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4876,'ru','_DELETE_WORD','Delete');
INSERT INTO `aphs_vocabulary` VALUES (4877,'ru','_DELETING_ACCOUNT_ERROR','An error occurred while deleting your account! Please try again later or send email about this issue to administration of the site.');
INSERT INTO `aphs_vocabulary` VALUES (1107,'en','_FIELD_MUST_BE_ALPHA_NUMERIC','_FIELD_ must be an alphanumeric value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4875,'ru','_DELETE_WARNING_COMMON','Are you sure you want to delete this record?');
INSERT INTO `aphs_vocabulary` VALUES (3979,'vi','_MD_CONTACT_US','Contact Us module allows easy create and place on-line contact form on site pages, using predefined code, like: {module:contact_us}.');
INSERT INTO `aphs_vocabulary` VALUES (1110,'en','_FIELD_MUST_BE_BOOLEAN','Field _FIELD_ value must be \'yes\' or \'no\'! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4874,'ru','_DELETE_WARNING','Are you sure you want to delete this record?');
INSERT INTO `aphs_vocabulary` VALUES (1113,'en','_FIELD_MUST_BE_EMAIL','_FIELD_ must be in valid email format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4872,'ru','_DEFAULT_PRICE','Default Price');
INSERT INTO `aphs_vocabulary` VALUES (4873,'ru','_DEFAULT_TEMPLATE','Default Template');
INSERT INTO `aphs_vocabulary` VALUES (3978,'vi','_MD_COMMENTS','The Comments module allows visitors to leave comments on articles and administrator of the site to moderate them.');
INSERT INTO `aphs_vocabulary` VALUES (1116,'en','_FIELD_MUST_BE_FLOAT','Field _FIELD_ must be a float number value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1119,'en','_FIELD_MUST_BE_FLOAT_POSITIVE','Field _FIELD_ must be a positive float number value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4870,'ru','_DEFAULT_HOTEL_DELETE_ALERT','You cannot delete default hotel!');
INSERT INTO `aphs_vocabulary` VALUES (4871,'ru','_DEFAULT_OWN_EMAIL_ALERT','You have to change your own email address. Click <a href=\'index.php?admin=my_account\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (1123,'en','_FIELD_MUST_BE_IP_ADDRESS','_FIELD_ must be a valid IP Address! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4869,'ru','_DEFAULT_EMAIL_ALERT','You have to change default email address for site administrator. Click <a href=\'index.php?admin=settings&tabid=1_4\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (3977,'vi','_MD_BOOKINGS','The Bookings module allows the site owner to define bookings for all rooms, then price them on an individual basis by accommodation and date. It also permits bookings to be taken from customers and managed via administrator panel.');
INSERT INTO `aphs_vocabulary` VALUES (1126,'en','_FIELD_MUST_BE_NUMERIC','Field _FIELD_ must be a numeric value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4868,'ru','_DEFAULT_CURRENCY_DELETE_ALERT','You cannot delete default currency!');
INSERT INTO `aphs_vocabulary` VALUES (3976,'vi','_MD_BANNERS','The Banners module allows administrator to display images on the site in random or rotation style.');
INSERT INTO `aphs_vocabulary` VALUES (1129,'en','_FIELD_MUST_BE_NUMERIC_POSITIVE','Field _FIELD_ must be a positive numeric value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4866,'ru','_DEFAULT','Default');
INSERT INTO `aphs_vocabulary` VALUES (4867,'ru','_DEFAULT_AVAILABILITY','Default Availability');
INSERT INTO `aphs_vocabulary` VALUES (1132,'en','_FIELD_MUST_BE_PASSWORD','_FIELD_ must be 6 characters at least and consist of letters and digits! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4863,'ru','_DATE_SUBSCRIBED','Date Subscribed');
INSERT INTO `aphs_vocabulary` VALUES (4864,'ru','_DAY','Day');
INSERT INTO `aphs_vocabulary` VALUES (4865,'ru','_DECEMBER','December');
INSERT INTO `aphs_vocabulary` VALUES (3975,'vi','_MD_BACKUP_AND_RESTORE','With Backup and Restore module you can dump all of your database tables to a file download or save to a file on the server, and to restore from an uploaded or previously saved database dump.');
INSERT INTO `aphs_vocabulary` VALUES (1135,'en','_FIELD_MUST_BE_POSITIVE_INT','Field _FIELD_ must be a positive integer value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4861,'ru','_DATE_PAYMENT','Date of Payment');
INSERT INTO `aphs_vocabulary` VALUES (4862,'ru','_DATE_PUBLISHED','Date Published');
INSERT INTO `aphs_vocabulary` VALUES (3974,'vi','_MAY','May');
INSERT INTO `aphs_vocabulary` VALUES (1138,'en','_FIELD_MUST_BE_POSITIVE_INTEGER','Field _FIELD_ must be a positive integer number!');
INSERT INTO `aphs_vocabulary` VALUES (1140,'en','_FIELD_MUST_BE_SIZE_VALUE','Field _FIELD_ must be a valid HTML size property in \'px\', \'pt\', \'em\' or \'%\' units! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4859,'ru','_DATE_FORMAT','Date Format');
INSERT INTO `aphs_vocabulary` VALUES (4860,'ru','_DATE_MODIFIED','Date Modified');
INSERT INTO `aphs_vocabulary` VALUES (3972,'vi','_MAX_OCCUPANCY','Max. Occupancy');
INSERT INTO `aphs_vocabulary` VALUES (3973,'vi','_MAX_RESERVATIONS_ERROR','You have reached the maximum number of permitted room reservations, that you have not yet finished! Please complete at least one of them to proceed reservation of new rooms.');
INSERT INTO `aphs_vocabulary` VALUES (1143,'en','_FIELD_MUST_BE_TEXT','_FIELD_ value must be a text! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4857,'ru','_DATE_CREATED','Date Created');
INSERT INTO `aphs_vocabulary` VALUES (4858,'ru','_DATE_EMPTY_ALERT','Date fields cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3970,'vi','_MAX_CHILDREN','Max Children');
INSERT INTO `aphs_vocabulary` VALUES (3971,'vi','_MAX_GUESTS','Max Guests');
INSERT INTO `aphs_vocabulary` VALUES (1146,'en','_FIELD_MUST_BE_UNSIGNED_FLOAT','Field _FIELD_ must be an unsigned float value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4856,'ru','_DATE_AND_TIME_SETTINGS','Date & Time Settings');
INSERT INTO `aphs_vocabulary` VALUES (3968,'vi','_MAX_ADULTS','Max Adults');
INSERT INTO `aphs_vocabulary` VALUES (3969,'vi','_MAX_CHARS','(max: _MAX_CHARS_ chars)');
INSERT INTO `aphs_vocabulary` VALUES (1149,'en','_FIELD_MUST_BE_UNSIGNED_INT','Field _FIELD_ must be an unsigned integer value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4853,'ru','_DASHBOARD','Dashboard');
INSERT INTO `aphs_vocabulary` VALUES (4854,'ru','_DATE','Date');
INSERT INTO `aphs_vocabulary` VALUES (4855,'ru','_DATETIME_PRICE_FORMAT','Datetime & Price Settings');
INSERT INTO `aphs_vocabulary` VALUES (1152,'en','_FIELD_VALUE_EXCEEDED','_FIELD_ has exceeded the maximum allowed value _MAX_! Please re-enter. ');
INSERT INTO `aphs_vocabulary` VALUES (4851,'ru','_CUSTOMER_PAYMENT_MODULES','Customer & Payment Modules');
INSERT INTO `aphs_vocabulary` VALUES (4852,'ru','_CVV_CODE','CVV Code');
INSERT INTO `aphs_vocabulary` VALUES (3966,'vi','_MAXIMUM_NIGHTS','Maximum Nights');
INSERT INTO `aphs_vocabulary` VALUES (3967,'vi','_MAXIMUM_NIGHTS_ALERT','The maximum allowed stay for this period of time from _FROM_ to _TO_ is _NIGHTS_ nights per booking. Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1155,'en','_FIELD_VALUE_MINIMUM','_FIELD_ value should not be less then _MIN_! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4849,'ru','_CUSTOMER_NAME','Customer Name');
INSERT INTO `aphs_vocabulary` VALUES (4850,'ru','_CUSTOMER_PANEL','Customer Panel');
INSERT INTO `aphs_vocabulary` VALUES (3965,'vi','_MASS_MAIL_AND_TEMPLATES','Mass Mail & Templates');
INSERT INTO `aphs_vocabulary` VALUES (1158,'en','_FILED_UNIQUE_VALUE_ALERT','The field _FIELD_ accepts only unique values - please re-enter!');
INSERT INTO `aphs_vocabulary` VALUES (4847,'ru','_CUSTOMER_GROUPS','Customer Groups');
INSERT INTO `aphs_vocabulary` VALUES (4848,'ru','_CUSTOMER_LOGIN','Customer Login');
INSERT INTO `aphs_vocabulary` VALUES (3964,'vi','_MASS_MAIL_ALERT','Attention: shared hosting services usually have a limit of 200 emails per hour');
INSERT INTO `aphs_vocabulary` VALUES (1161,'en','_FILE_DELETING_ERROR','An error occurred while deleting file! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (4845,'ru','_CUSTOMER_DETAILS','Customer Details');
INSERT INTO `aphs_vocabulary` VALUES (4846,'ru','_CUSTOMER_GROUP','Customer Group');
INSERT INTO `aphs_vocabulary` VALUES (3963,'vi','_MASS_MAIL','Mass Mail');
INSERT INTO `aphs_vocabulary` VALUES (1164,'en','_FILTER_BY','Filter by');
INSERT INTO `aphs_vocabulary` VALUES (3962,'vi','_MARCH','March');
INSERT INTO `aphs_vocabulary` VALUES (1167,'en','_FINISH_DATE','Finish Date');
INSERT INTO `aphs_vocabulary` VALUES (4844,'ru','_CUSTOMERS_SETTINGS','Customers Settings');
INSERT INTO `aphs_vocabulary` VALUES (1170,'en','_FINISH_PUBLISHING','Finish Publishing');
INSERT INTO `aphs_vocabulary` VALUES (3961,'vi','_MAP_OVERLAY','Map Overlay');
INSERT INTO `aphs_vocabulary` VALUES (1173,'en','_FIRST_NAME','First Name');
INSERT INTO `aphs_vocabulary` VALUES (3960,'vi','_MAP_CODE','Map Code');
INSERT INTO `aphs_vocabulary` VALUES (1176,'en','_FIRST_NAME_EMPTY_ALERT','First Name cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4843,'ru','_CUSTOMERS_MANAGEMENT','Customers Management');
INSERT INTO `aphs_vocabulary` VALUES (3959,'vi','_MANAGE_TEMPLATES','Manage Templates');
INSERT INTO `aphs_vocabulary` VALUES (1179,'en','_FIRST_NIGHT','First Night');
INSERT INTO `aphs_vocabulary` VALUES (1182,'en','_FIXED_SUM','Fixed Sum');
INSERT INTO `aphs_vocabulary` VALUES (3957,'vi','_MAIN_ADMIN','Main Admin');
INSERT INTO `aphs_vocabulary` VALUES (3958,'vi','_MAKE_RESERVATION','Make а Reservation');
INSERT INTO `aphs_vocabulary` VALUES (1185,'en','_FOOTER_IS_EMPTY','Footer cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4842,'ru','_CUSTOMERS_AWAITING_MODERATION_ALERT','There are _COUNT_ customer/s awaiting your approval. Click <a href=\'index.php?admin=mod_customers_management\'>here</a> for review.');
INSERT INTO `aphs_vocabulary` VALUES (3956,'vi','_MAIN','Main');
INSERT INTO `aphs_vocabulary` VALUES (1188,'en','_FORCE_SSL','Force SSL');
INSERT INTO `aphs_vocabulary` VALUES (4841,'ru','_CUSTOMERS','Customers');
INSERT INTO `aphs_vocabulary` VALUES (3953,'vi','_LONG_DESCRIPTION','Long Description');
INSERT INTO `aphs_vocabulary` VALUES (3954,'vi','_LOOK_IN','Look in');
INSERT INTO `aphs_vocabulary` VALUES (3955,'vi','_MAILER','Mailer');
INSERT INTO `aphs_vocabulary` VALUES (1191,'en','_FORCE_SSL_ALERT','Force site access to always occur under SSL (https) for selected areas. You or site visitors will not be able to access selected areas under non-ssl. Note, you must have SSL enabled on your server to make this option works.');
INSERT INTO `aphs_vocabulary` VALUES (4837,'ru','_CURRENCIES_MANAGEMENT','Currencies Management');
INSERT INTO `aphs_vocabulary` VALUES (4838,'ru','_CURRENCY','Currency');
INSERT INTO `aphs_vocabulary` VALUES (4839,'ru','_CURRENT_NEXT_YEARS','for current/next years');
INSERT INTO `aphs_vocabulary` VALUES (4840,'ru','_CUSTOMER','Customer');
INSERT INTO `aphs_vocabulary` VALUES (1194,'en','_FORGOT_PASSWORD','Forgot your password?');
INSERT INTO `aphs_vocabulary` VALUES (1197,'en','_FORM','Form');
INSERT INTO `aphs_vocabulary` VALUES (1200,'en','_FOUND_HOTELS','Found Hotels');
INSERT INTO `aphs_vocabulary` VALUES (3952,'vi','_LOGIN_PAGE_MSG','Use a valid administrator username and password to get access to the Administrator Back-End.<br><br>Return to site <a href=\'index.php\'>Home Page</a><br><br><img align=\'center\' src=\'images/lock.png\' alt=\'\' width=\'92px\'>');
INSERT INTO `aphs_vocabulary` VALUES (1203,'en','_FOUND_ROOMS','Found Rooms');
INSERT INTO `aphs_vocabulary` VALUES (1206,'en','_FR','Fr');
INSERT INTO `aphs_vocabulary` VALUES (3951,'vi','_LOGINS','Logins');
INSERT INTO `aphs_vocabulary` VALUES (1209,'en','_FRI','Fri');
INSERT INTO `aphs_vocabulary` VALUES (4836,'ru','_CURRENCIES_DEFAULT_ALERT','Remember! After you change the default currency:<br>- Edit exchange rate to each currency manually (relatively to the new default currency)<br>- Redefine prices for all rooms in the new currency.');
INSERT INTO `aphs_vocabulary` VALUES (1212,'en','_FRIDAY','Friday');
INSERT INTO `aphs_vocabulary` VALUES (3950,'vi','_LOGIN','Login');
INSERT INTO `aphs_vocabulary` VALUES (1215,'en','_FROM','From');
INSERT INTO `aphs_vocabulary` VALUES (4835,'ru','_CURRENCIES','Currencies');
INSERT INTO `aphs_vocabulary` VALUES (3948,'vi','_LOCATIONS','Locations');
INSERT INTO `aphs_vocabulary` VALUES (3949,'vi','_LOCATION_NAME','Location Name');
INSERT INTO `aphs_vocabulary` VALUES (1218,'en','_FROM_TO_DATE_ALERT','Date \'To\' must be the same or later than date \'From\'! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4834,'ru','_CRON_JOBS','Cron Jobs');
INSERT INTO `aphs_vocabulary` VALUES (3947,'vi','_LOCATION','Location');
INSERT INTO `aphs_vocabulary` VALUES (1221,'en','_FULLY_BOOKED','fully booked/unavailable');
INSERT INTO `aphs_vocabulary` VALUES (1224,'en','_FULL_PRICE','Full Price');
INSERT INTO `aphs_vocabulary` VALUES (3946,'vi','_LOCAL_TIME','Local Time');
INSERT INTO `aphs_vocabulary` VALUES (1227,'en','_GALLERY','Gallery');
INSERT INTO `aphs_vocabulary` VALUES (3945,'vi','_LOADING','loading');
INSERT INTO `aphs_vocabulary` VALUES (1230,'en','_GALLERY_MANAGEMENT','Gallery Management');
INSERT INTO `aphs_vocabulary` VALUES (3944,'vi','_LINK_PARAMETER','Link Parameter');
INSERT INTO `aphs_vocabulary` VALUES (1233,'en','_GALLERY_SETTINGS','Gallery Settings');
INSERT INTO `aphs_vocabulary` VALUES (3943,'vi','_LINK','Link');
INSERT INTO `aphs_vocabulary` VALUES (1236,'en','_GENERAL','General');
INSERT INTO `aphs_vocabulary` VALUES (3942,'vi','_LICENSE','License');
INSERT INTO `aphs_vocabulary` VALUES (1239,'en','_GENERAL_INFO','General Info');
INSERT INTO `aphs_vocabulary` VALUES (1242,'en','_GENERAL_SETTINGS','General Settings');
INSERT INTO `aphs_vocabulary` VALUES (3941,'vi','_LEGEND_RESERVED','Room is reserved, but order was not paid yet');
INSERT INTO `aphs_vocabulary` VALUES (1245,'en','_GENERATE','Generate');
INSERT INTO `aphs_vocabulary` VALUES (1248,'en','_GLOBAL','Global');
INSERT INTO `aphs_vocabulary` VALUES (1251,'en','_GLOBAL_CAMPAIGN','Global Campaign');
INSERT INTO `aphs_vocabulary` VALUES (1254,'en','_GROUP','Group');
INSERT INTO `aphs_vocabulary` VALUES (3940,'vi','_LEGEND_REFUNDED','Order was refunded and the room is available again in search');
INSERT INTO `aphs_vocabulary` VALUES (1257,'en','_GROUP_NAME','Group Name');
INSERT INTO `aphs_vocabulary` VALUES (3939,'vi','_LEGEND_PREPARING','Room was added to reservation cart, but still not reserved');
INSERT INTO `aphs_vocabulary` VALUES (1260,'en','_GROUP_TIME_OVERLAPPING_ALERT','This period of time (fully or partially) was already chosen for selected group! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1263,'en','_GUEST','Guest');
INSERT INTO `aphs_vocabulary` VALUES (3938,'vi','_LEGEND_PAYMENT_ERROR','An error occurred while processing customer payments');
INSERT INTO `aphs_vocabulary` VALUES (1266,'en','_GUESTS','Guests');
INSERT INTO `aphs_vocabulary` VALUES (1269,'en','_GUESTS_FEE','Guests Fee');
INSERT INTO `aphs_vocabulary` VALUES (4833,'ru','_CRONJOB_NOTICE','Cron jobs allow you to automate certain commands or scripts on your site.<br /><br />ApPHP Hotel Site needs to periodically run cron.php to close expired discount campaigns or perform another importans operations. The recommended way to run cron.php is to set up a cronjob if you run a Unix/Linux server. If for any reason you can&#039;t run a cronjob on your server, you can choose the Non-batch option below to have cron.php run by ApPHP Hotel Site itself: in this case cron.php will be run each time someone access your home page. <br /><br />Example of Batch Cron job command: <b>php &#36;HOME/public_html/cron.php >/dev/null 2>&1</b>');
INSERT INTO `aphs_vocabulary` VALUES (1272,'en','_GUEST_FEE','Guest Fee');
INSERT INTO `aphs_vocabulary` VALUES (3937,'vi','_LEGEND_COMPLETED','Money was paid (fully or partially) and order completed');
INSERT INTO `aphs_vocabulary` VALUES (1275,'en','_HDR_FOOTER_TEXT','Footer Text');
INSERT INTO `aphs_vocabulary` VALUES (1278,'en','_HDR_HEADER_TEXT','Header Text');
INSERT INTO `aphs_vocabulary` VALUES (1281,'en','_HDR_SLOGAN_TEXT','Slogan');
INSERT INTO `aphs_vocabulary` VALUES (1284,'en','_HDR_TEMPLATE','Template');
INSERT INTO `aphs_vocabulary` VALUES (4832,'ru','_CRONJOB_HTACCESS_BLOCK','To block remote access to cron.php, in the server&#039;s .htaccess file or vhost configuration file add this section:');
INSERT INTO `aphs_vocabulary` VALUES (3936,'vi','_LEGEND_CANCELED','Order was canceled by admin and the room is available again in search');
INSERT INTO `aphs_vocabulary` VALUES (1287,'en','_HDR_TEXT_DIRECTION','Text Direction');
INSERT INTO `aphs_vocabulary` VALUES (3935,'vi','_LEGEND','Legend');
INSERT INTO `aphs_vocabulary` VALUES (1290,'en','_HEADER','Header');
INSERT INTO `aphs_vocabulary` VALUES (4831,'ru','_CREDIT_CARD_TYPE','Credit Card Type');
INSERT INTO `aphs_vocabulary` VALUES (3934,'vi','_LEFT_TO_RIGHT','LTR (left-to-right)');
INSERT INTO `aphs_vocabulary` VALUES (1293,'en','_HEADERS_AND_FOOTERS','Headers & Footers');
INSERT INTO `aphs_vocabulary` VALUES (3933,'vi','_LEFT','Left');
INSERT INTO `aphs_vocabulary` VALUES (1296,'en','_HEADER_IS_EMPTY','Header cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4830,'ru','_CREDIT_CARD_NUMBER','Credit Card Number');
INSERT INTO `aphs_vocabulary` VALUES (1299,'en','_HIDDEN','Hidden');
INSERT INTO `aphs_vocabulary` VALUES (4829,'ru','_CREDIT_CARD_HOLDER_NAME','Card Holder\'s Name');
INSERT INTO `aphs_vocabulary` VALUES (3932,'vi','_LEAVE_YOUR_COMMENT','Leave your comment');
INSERT INTO `aphs_vocabulary` VALUES (1302,'en','_HIDE','Hide');
INSERT INTO `aphs_vocabulary` VALUES (1305,'en','_HOME','Home');
INSERT INTO `aphs_vocabulary` VALUES (3931,'vi','_LAYOUT','Layout');
INSERT INTO `aphs_vocabulary` VALUES (1308,'en','_HOTEL','Hotel');
INSERT INTO `aphs_vocabulary` VALUES (4828,'ru','_CREDIT_CARD_EXPIRES','Expires');
INSERT INTO `aphs_vocabulary` VALUES (3928,'vi','_LAST_NAME','Last Name');
INSERT INTO `aphs_vocabulary` VALUES (3929,'vi','_LAST_NAME_EMPTY_ALERT','Last Name cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (3930,'vi','_LAST_RUN','Last run');
INSERT INTO `aphs_vocabulary` VALUES (1311,'en','_HOTELOWNER_WELCOME_TEXT','Welcome to Hotel Owner Control Panel! With this Control Panel you can easily manage your hotels, customers, reservations and perform a full hotel site management.');
INSERT INTO `aphs_vocabulary` VALUES (4826,'ru','_CREATING_NEW_ACCOUNT','Creating new account');
INSERT INTO `aphs_vocabulary` VALUES (4827,'ru','_CREDIT_CARD','Credit Card');
INSERT INTO `aphs_vocabulary` VALUES (3927,'vi','_LAST_LOGIN','Last Login');
INSERT INTO `aphs_vocabulary` VALUES (1314,'en','_HOTELS','Hotels');
INSERT INTO `aphs_vocabulary` VALUES (3926,'vi','_LAST_LOGGED_IP','Last logged IP');
INSERT INTO `aphs_vocabulary` VALUES (1317,'en','_HOTELS_AND_ROMS','Hotels and Rooms');
INSERT INTO `aphs_vocabulary` VALUES (4825,'ru','_CREATING_ACCOUNT_ERROR','An error occurred while creating your account! Please try again later or send information about this error to administration of the site.');
INSERT INTO `aphs_vocabulary` VALUES (1320,'en','_HOTELS_INFO','Hotels Info');
INSERT INTO `aphs_vocabulary` VALUES (3925,'vi','_LAST_HOTEL_ALERT','You cannot delete last active hotel record!\r\n');
INSERT INTO `aphs_vocabulary` VALUES (1323,'en','_HOTELS_MANAGEMENT','Hotels Management');
INSERT INTO `aphs_vocabulary` VALUES (1326,'en','_HOTEL_DESCRIPTION','Hotel Description');
INSERT INTO `aphs_vocabulary` VALUES (3924,'vi','_LAST_CURRENCY_ALERT','You cannot delete last active currency!');
INSERT INTO `aphs_vocabulary` VALUES (1329,'en','_HOTEL_INFO','Hotel Info');
INSERT INTO `aphs_vocabulary` VALUES (1332,'en','_HOTEL_MANAGEMENT','Hotel Management');
INSERT INTO `aphs_vocabulary` VALUES (3923,'vi','_LANG_ORDER_CHANGED','Language order was successfully changed!');
INSERT INTO `aphs_vocabulary` VALUES (1335,'en','_HOTEL_OWNER','Hotel Owner');
INSERT INTO `aphs_vocabulary` VALUES (1338,'en','_HOTEL_RESERVATION_ID','Hotel Reservation ID');
INSERT INTO `aphs_vocabulary` VALUES (1341,'en','_HOUR','Hour');
INSERT INTO `aphs_vocabulary` VALUES (3922,'vi','_LANG_NOT_DELETED','Language was not deleted!');
INSERT INTO `aphs_vocabulary` VALUES (1344,'en','_HOURS','hours');
INSERT INTO `aphs_vocabulary` VALUES (1347,'en','_ICON_IMAGE','Icon image');
INSERT INTO `aphs_vocabulary` VALUES (1350,'en','_IMAGE','Image');
INSERT INTO `aphs_vocabulary` VALUES (1353,'en','_IMAGES','Images');
INSERT INTO `aphs_vocabulary` VALUES (3921,'vi','_LANG_NAME_EXISTS','Language with such name already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (1356,'en','_IMAGE_VERIFICATION','Image verification');
INSERT INTO `aphs_vocabulary` VALUES (1359,'en','_IMAGE_VERIFY_EMPTY','You must enter image verification code!');
INSERT INTO `aphs_vocabulary` VALUES (3920,'vi','_LANG_NAME_EMPTY','Language name cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (1362,'en','_INCOME','Income');
INSERT INTO `aphs_vocabulary` VALUES (1365,'en','_INFO_AND_STATISTICS','Information and Statistics');
INSERT INTO `aphs_vocabulary` VALUES (3919,'vi','_LANG_MISSED','Missed language to update! Please, try again.');
INSERT INTO `aphs_vocabulary` VALUES (1368,'en','_INITIAL_FEE','Initial Fee');
INSERT INTO `aphs_vocabulary` VALUES (4824,'ru','_CREATE_ACCOUNT_NOTE','NOTE: <br>We recommend that your password should be at least 6 characters long and should be different from your username.<br><br>Your e-mail address must be valid. We use e-mail for communication purposes (order notifications, etc). Therefore, it is essential to provide a valid e-mail address to be able to use our services correctly.<br><br>All your private data is confidential. We will never sell, exchange or market it in any way. For further information on the responsibilities of both parts, you may refer to us.');
INSERT INTO `aphs_vocabulary` VALUES (1371,'en','_INSTALL','Install');
INSERT INTO `aphs_vocabulary` VALUES (1374,'en','_INSTALLED','Installed');
INSERT INTO `aphs_vocabulary` VALUES (4823,'ru','_CREATE_ACCOUNT','Create account');
INSERT INTO `aphs_vocabulary` VALUES (3918,'vi','_LANG_DELETE_WARNING','Are you sure you want to remove this language? This operation will delete all language vocabulary!');
INSERT INTO `aphs_vocabulary` VALUES (1377,'en','_INSTALL_PHP_EXISTS','File <b>install.php</b> and/or directory <b>install/</b> still exists. For security reasons please remove them immediately!');
INSERT INTO `aphs_vocabulary` VALUES (4821,'ru','_COUPON_WAS_REMOVED','The coupon has been successfully removed!');
INSERT INTO `aphs_vocabulary` VALUES (4822,'ru','_CREATED_DATE','Date Created');
INSERT INTO `aphs_vocabulary` VALUES (3917,'vi','_LANG_DELETE_LAST_ERROR','You cannot delete last language!');
INSERT INTO `aphs_vocabulary` VALUES (1380,'en','_INTEGRATION','Integration');
INSERT INTO `aphs_vocabulary` VALUES (3915,'vi','_LANG_ABBREV_EMPTY','Language abbreviation cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (3916,'vi','_LANG_DELETED','Language was successfully deleted!');
INSERT INTO `aphs_vocabulary` VALUES (1383,'en','_INTEGRATION_MESSAGE','Copy the code below and put it in the appropriate place of your web site to get a <b>Search Availability</b> block.');
INSERT INTO `aphs_vocabulary` VALUES (4818,'ru','_COUPONS_MANAGEMENT','Coupons Management');
INSERT INTO `aphs_vocabulary` VALUES (4819,'ru','_COUPON_CODE','Coupon Code');
INSERT INTO `aphs_vocabulary` VALUES (4820,'ru','_COUPON_WAS_APPLIED','The coupon _COUPON_CODE_ has been successfully applied!');
INSERT INTO `aphs_vocabulary` VALUES (3914,'vi','_LANGUAGE_NAME','Language Name');
INSERT INTO `aphs_vocabulary` VALUES (1386,'en','_INTERNAL_USE_TOOLTIP','For internal use only');
INSERT INTO `aphs_vocabulary` VALUES (4817,'ru','_COUPONS','Coupons');
INSERT INTO `aphs_vocabulary` VALUES (3913,'vi','_LANGUAGE_EDITED','Language data was successfully updated!');
INSERT INTO `aphs_vocabulary` VALUES (1389,'en','_INVALID_FILE_SIZE','Invalid file size: _FILE_SIZE_ (max. allowed: _MAX_ALLOWED_)');
INSERT INTO `aphs_vocabulary` VALUES (4816,'ru','_COUNTRY_EMPTY_ALERT','Country cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3911,'vi','_LANGUAGE_ADD_NEW','Add New Language');
INSERT INTO `aphs_vocabulary` VALUES (3912,'vi','_LANGUAGE_EDIT','Edit Language');
INSERT INTO `aphs_vocabulary` VALUES (1392,'en','_INVALID_IMAGE_FILE_TYPE','Uploaded file is not a valid image! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4815,'ru','_COUNTRY','Country');
INSERT INTO `aphs_vocabulary` VALUES (1395,'en','_INVOICE','Invoice');
INSERT INTO `aphs_vocabulary` VALUES (4814,'ru','_COUNTRIES_MANAGEMENT','Countries Management');
INSERT INTO `aphs_vocabulary` VALUES (3910,'vi','_LANGUAGE_ADDED','New language was successfully added!');
INSERT INTO `aphs_vocabulary` VALUES (1398,'en','_INVOICE_SENT_SUCCESS','The invoice was successfully sent to the customer!');
INSERT INTO `aphs_vocabulary` VALUES (4812,'ru','_COUNT','Count');
INSERT INTO `aphs_vocabulary` VALUES (4813,'ru','_COUNTRIES','Countries');
INSERT INTO `aphs_vocabulary` VALUES (3909,'vi','_LANGUAGES_SETTINGS','Languages Settings');
INSERT INTO `aphs_vocabulary` VALUES (1401,'en','_IN_PRODUCTS','In Products');
INSERT INTO `aphs_vocabulary` VALUES (3908,'vi','_LANGUAGES','Languages');
INSERT INTO `aphs_vocabulary` VALUES (1404,'en','_IP_ADDRESS','IP Address');
INSERT INTO `aphs_vocabulary` VALUES (4811,'ru','_COPY_TO_OTHER_LANGS','Copy to other languages');
INSERT INTO `aphs_vocabulary` VALUES (3906,'vi','_KEY_DISPLAY_TYPE','Key display type');
INSERT INTO `aphs_vocabulary` VALUES (3907,'vi','_LANGUAGE','Language');
INSERT INTO `aphs_vocabulary` VALUES (1407,'en','_IP_ADDRESS_BLOCKED','Your IP Address is blocked! To resolve this problem, please contact the site administrator.');
INSERT INTO `aphs_vocabulary` VALUES (4809,'ru','_CONTENT_TYPE','Content Type');
INSERT INTO `aphs_vocabulary` VALUES (4810,'ru','_CONTINUE_RESERVATION','Continue Reservation');
INSERT INTO `aphs_vocabulary` VALUES (3905,'vi','_KEYWORDS','Keywords');
INSERT INTO `aphs_vocabulary` VALUES (1410,'en','_IS_DEFAULT','Is default');
INSERT INTO `aphs_vocabulary` VALUES (3904,'vi','_KEY','Key');
INSERT INTO `aphs_vocabulary` VALUES (1413,'en','_ITEMS','Items');
INSERT INTO `aphs_vocabulary` VALUES (3903,'vi','_JUNE','June');
INSERT INTO `aphs_vocabulary` VALUES (1416,'en','_ITEMS_LC','items');
INSERT INTO `aphs_vocabulary` VALUES (4808,'ru','_CONTACT_US_SETTINGS','Contact Us Settings');
INSERT INTO `aphs_vocabulary` VALUES (3902,'vi','_JULY','July');
INSERT INTO `aphs_vocabulary` VALUES (1419,'en','_ITEM_NAME','Item Name');
INSERT INTO `aphs_vocabulary` VALUES (1422,'en','_JANUARY','January');
INSERT INTO `aphs_vocabulary` VALUES (3901,'vi','_JANUARY','January');
INSERT INTO `aphs_vocabulary` VALUES (1425,'en','_JULY','July');
INSERT INTO `aphs_vocabulary` VALUES (1428,'en','_JUNE','June');
INSERT INTO `aphs_vocabulary` VALUES (3900,'vi','_ITEM_NAME','Item Name');
INSERT INTO `aphs_vocabulary` VALUES (1431,'en','_KEY','Key');
INSERT INTO `aphs_vocabulary` VALUES (3899,'vi','_ITEMS_LC','items');
INSERT INTO `aphs_vocabulary` VALUES (1434,'en','_KEYWORDS','Keywords');
INSERT INTO `aphs_vocabulary` VALUES (4807,'ru','_CONTACT_US_EMAIL_SENT','Thank you for contacting us! Your message has been successfully sent.');
INSERT INTO `aphs_vocabulary` VALUES (3898,'vi','_ITEMS','Items');
INSERT INTO `aphs_vocabulary` VALUES (1437,'en','_KEY_DISPLAY_TYPE','Key display type');
INSERT INTO `aphs_vocabulary` VALUES (1440,'en','_LANGUAGE','Language');
INSERT INTO `aphs_vocabulary` VALUES (3897,'vi','_IS_DEFAULT','Is default');
INSERT INTO `aphs_vocabulary` VALUES (1443,'en','_LANGUAGES','Languages');
INSERT INTO `aphs_vocabulary` VALUES (1446,'en','_LANGUAGES_SETTINGS','Languages Settings');
INSERT INTO `aphs_vocabulary` VALUES (4806,'ru','_CONTACT_US_ALREADY_SENT','Your message was already sent. Please try again later or wait _WAIT_ seconds.');
INSERT INTO `aphs_vocabulary` VALUES (1449,'en','_LANGUAGE_ADDED','New language was successfully added!');
INSERT INTO `aphs_vocabulary` VALUES (4805,'ru','_CONTACT_US','Contact us');
INSERT INTO `aphs_vocabulary` VALUES (3896,'vi','_IP_ADDRESS_BLOCKED','Your IP Address is blocked! To resolve this problem, please contact the site administrator.');
INSERT INTO `aphs_vocabulary` VALUES (1452,'en','_LANGUAGE_ADD_NEW','Add New Language');
INSERT INTO `aphs_vocabulary` VALUES (3895,'vi','_IP_ADDRESS','IP Address');
INSERT INTO `aphs_vocabulary` VALUES (1455,'en','_LANGUAGE_EDIT','Edit Language');
INSERT INTO `aphs_vocabulary` VALUES (4804,'ru','_CONTACT_INFORMATION','Contact Information');
INSERT INTO `aphs_vocabulary` VALUES (3894,'vi','_IN_PRODUCTS','In Products');
INSERT INTO `aphs_vocabulary` VALUES (1458,'en','_LANGUAGE_EDITED','Language data was successfully updated!');
INSERT INTO `aphs_vocabulary` VALUES (1461,'en','_LANGUAGE_NAME','Language Name');
INSERT INTO `aphs_vocabulary` VALUES (3893,'vi','_INVOICE_SENT_SUCCESS','The invoice was successfully sent to the customer!');
INSERT INTO `aphs_vocabulary` VALUES (1464,'en','_LANG_ABBREV_EMPTY','Language abbreviation cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (3892,'vi','_INVOICE','Invoice');
INSERT INTO `aphs_vocabulary` VALUES (1467,'en','_LANG_DELETED','Language was successfully deleted!');
INSERT INTO `aphs_vocabulary` VALUES (4803,'ru','_CONTACTUS_DEFAULT_EMAIL_ALERT','You have to change default email address for Contact Us module. Click <a href=\'index.php?admin=mod_contact_us_settings\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (1470,'en','_LANG_DELETE_LAST_ERROR','You cannot delete last language!');
INSERT INTO `aphs_vocabulary` VALUES (3891,'vi','_INVALID_IMAGE_FILE_TYPE','Uploaded file is not a valid image! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1473,'en','_LANG_DELETE_WARNING','Are you sure you want to remove this language? This operation will delete all language vocabulary!');
INSERT INTO `aphs_vocabulary` VALUES (4801,'ru','_CONF_PASSWORD_IS_EMPTY','Confirm Password cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (4802,'ru','_CONF_PASSWORD_MATCH','Password must be match with Confirm Password');
INSERT INTO `aphs_vocabulary` VALUES (3890,'vi','_INVALID_FILE_SIZE','Invalid file size: _FILE_SIZE_ (max. allowed: _MAX_ALLOWED_)');
INSERT INTO `aphs_vocabulary` VALUES (1476,'en','_LANG_MISSED','Missed language to update! Please, try again.');
INSERT INTO `aphs_vocabulary` VALUES (4800,'ru','_CONFIRM_TERMS_CONDITIONS','You must confirm you agree to our Terms & Conditions!');
INSERT INTO `aphs_vocabulary` VALUES (3889,'vi','_INTERNAL_USE_TOOLTIP','For internal use only');
INSERT INTO `aphs_vocabulary` VALUES (1479,'en','_LANG_NAME_EMPTY','Language name cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (4799,'ru','_CONFIRM_PASSWORD','Confirm Password');
INSERT INTO `aphs_vocabulary` VALUES (1482,'en','_LANG_NAME_EXISTS','Language with such name already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (3888,'vi','_INTEGRATION_MESSAGE','Copy the code below and put it in the appropriate place of your web site to get a <b>Search Availability</b> block.');
INSERT INTO `aphs_vocabulary` VALUES (1485,'en','_LANG_NOT_DELETED','Language was not deleted!');
INSERT INTO `aphs_vocabulary` VALUES (3887,'vi','_INTEGRATION','Integration');
INSERT INTO `aphs_vocabulary` VALUES (1488,'en','_LANG_ORDER_CHANGED','Language order was successfully changed!');
INSERT INTO `aphs_vocabulary` VALUES (4798,'ru','_CONFIRMED_SUCCESS_MSG','Thank you for confirming your registration! <br /><br />You may now log into your account. Click <a href=\'index.php?customer=login\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (1491,'en','_LAST_CURRENCY_ALERT','You cannot delete last active currency!');
INSERT INTO `aphs_vocabulary` VALUES (1494,'en','_LAST_HOTEL_ALERT','You cannot delete last active hotel record!\r\n');
INSERT INTO `aphs_vocabulary` VALUES (4797,'ru','_CONFIRMED_ALREADY_MSG','Your account has already been confirmed! <br /><br />Click <a href=\'index.php?customer=login\'>here</a> to continue.');
INSERT INTO `aphs_vocabulary` VALUES (3886,'vi','_INSTALL_PHP_EXISTS','File <b>install.php</b> and/or directory <b>install/</b> still exists. For security reasons please remove them immediately!');
INSERT INTO `aphs_vocabulary` VALUES (1497,'en','_LAST_LOGGED_IP','Last logged IP');
INSERT INTO `aphs_vocabulary` VALUES (4796,'ru','_CONFIRMATION_CODE','Confirmation Code');
INSERT INTO `aphs_vocabulary` VALUES (3885,'vi','_INSTALLED','Installed');
INSERT INTO `aphs_vocabulary` VALUES (1500,'en','_LAST_LOGIN','Last Login');
INSERT INTO `aphs_vocabulary` VALUES (3884,'vi','_INSTALL','Install');
INSERT INTO `aphs_vocabulary` VALUES (1503,'en','_LAST_NAME','Last Name');
INSERT INTO `aphs_vocabulary` VALUES (4795,'ru','_CONFIRMATION','Confirmation');
INSERT INTO `aphs_vocabulary` VALUES (3883,'vi','_INITIAL_FEE','Initial Fee');
INSERT INTO `aphs_vocabulary` VALUES (1506,'en','_LAST_NAME_EMPTY_ALERT','Last Name cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (4793,'ru','_COMPANY','Company');
INSERT INTO `aphs_vocabulary` VALUES (4794,'ru','_COMPLETED','Completed');
INSERT INTO `aphs_vocabulary` VALUES (1509,'en','_LAST_RUN','Last run');
INSERT INTO `aphs_vocabulary` VALUES (4792,'ru','_COMMENT_TEXT','Comment text');
INSERT INTO `aphs_vocabulary` VALUES (1512,'en','_LAYOUT','Layout');
INSERT INTO `aphs_vocabulary` VALUES (3882,'vi','_INFO_AND_STATISTICS','Information and Statistics');
INSERT INTO `aphs_vocabulary` VALUES (1515,'en','_LEAVE_YOUR_COMMENT','Leave your comment');
INSERT INTO `aphs_vocabulary` VALUES (3881,'vi','_INCOME','Income');
INSERT INTO `aphs_vocabulary` VALUES (1518,'en','_LEFT','Left');
INSERT INTO `aphs_vocabulary` VALUES (1521,'en','_LEFT_TO_RIGHT','LTR (left-to-right)');
INSERT INTO `aphs_vocabulary` VALUES (1524,'en','_LEGEND','Legend');
INSERT INTO `aphs_vocabulary` VALUES (4791,'ru','_COMMENT_SUBMITTED_SUCCESS','Your comment has been successfully submitted and will be posted after administrator\'s review!');
INSERT INTO `aphs_vocabulary` VALUES (3879,'vi','_IMAGE_VERIFICATION','Image verification');
INSERT INTO `aphs_vocabulary` VALUES (3880,'vi','_IMAGE_VERIFY_EMPTY','You must enter image verification code!');
INSERT INTO `aphs_vocabulary` VALUES (1527,'en','_LEGEND_CANCELED','Order was canceled by admin and the room is available again in search');
INSERT INTO `aphs_vocabulary` VALUES (4790,'ru','_COMMENT_POSTED_SUCCESS','Your comment has been successfully posted!');
INSERT INTO `aphs_vocabulary` VALUES (3877,'vi','_IMAGE','Image');
INSERT INTO `aphs_vocabulary` VALUES (3878,'vi','_IMAGES','Images');
INSERT INTO `aphs_vocabulary` VALUES (1530,'en','_LEGEND_COMPLETED','Money was paid (fully or partially) and order completed');
INSERT INTO `aphs_vocabulary` VALUES (4789,'ru','_COMMENT_LENGTH_ALERT','The length of comment must be less than _LENGTH_ characters!');
INSERT INTO `aphs_vocabulary` VALUES (3875,'vi','_HOURS','hours');
INSERT INTO `aphs_vocabulary` VALUES (3876,'vi','_ICON_IMAGE','Icon image');
INSERT INTO `aphs_vocabulary` VALUES (1533,'en','_LEGEND_PAYMENT_ERROR','An error occurred while processing customer payments');
INSERT INTO `aphs_vocabulary` VALUES (4788,'ru','_COMMENT_DELETED_SUCCESS','Your comment was successfully deleted.');
INSERT INTO `aphs_vocabulary` VALUES (3873,'vi','_HOTEL_RESERVATION_ID','Hotel Reservation ID');
INSERT INTO `aphs_vocabulary` VALUES (3874,'vi','_HOUR','Hour');
INSERT INTO `aphs_vocabulary` VALUES (1536,'en','_LEGEND_PREPARING','Room was added to reservation cart, but still not reserved');
INSERT INTO `aphs_vocabulary` VALUES (4787,'ru','_COMMENTS_SETTINGS','Comments Settings');
INSERT INTO `aphs_vocabulary` VALUES (3871,'vi','_HOTEL_MANAGEMENT','Hotel Management');
INSERT INTO `aphs_vocabulary` VALUES (3872,'vi','_HOTEL_OWNER','Hotel Owner');
INSERT INTO `aphs_vocabulary` VALUES (1539,'en','_LEGEND_REFUNDED','Order was refunded and the room is available again in search');
INSERT INTO `aphs_vocabulary` VALUES (4785,'ru','_COMMENTS_LINK','Comments (_COUNT_)');
INSERT INTO `aphs_vocabulary` VALUES (4786,'ru','_COMMENTS_MANAGEMENT','Comments Management');
INSERT INTO `aphs_vocabulary` VALUES (3870,'vi','_HOTEL_INFO','Hotel Info');
INSERT INTO `aphs_vocabulary` VALUES (1542,'en','_LEGEND_RESERVED','Room is reserved, but order was not paid yet');
INSERT INTO `aphs_vocabulary` VALUES (3869,'vi','_HOTEL_DESCRIPTION','Hotel Description');
INSERT INTO `aphs_vocabulary` VALUES (1545,'en','_LICENSE','License');
INSERT INTO `aphs_vocabulary` VALUES (1548,'en','_LINK','Link');
INSERT INTO `aphs_vocabulary` VALUES (3868,'vi','_HOTELS_MANAGEMENT','Hotels Management');
INSERT INTO `aphs_vocabulary` VALUES (1551,'en','_LINK_PARAMETER','Link Parameter');
INSERT INTO `aphs_vocabulary` VALUES (1554,'en','_LOADING','loading');
INSERT INTO `aphs_vocabulary` VALUES (3867,'vi','_HOTELS_INFO','Hotels Info');
INSERT INTO `aphs_vocabulary` VALUES (1557,'en','_LOCAL_TIME','Local Time');
INSERT INTO `aphs_vocabulary` VALUES (1560,'en','_LOCATION','Location');
INSERT INTO `aphs_vocabulary` VALUES (4784,'ru','_COMMENTS_AWAITING_MODERATION_ALERT','There are _COUNT_ comment/s awaiting your moderation. Click <a href=\'index.php?admin=mod_comments_management\'>here</a> for review.');
INSERT INTO `aphs_vocabulary` VALUES (3866,'vi','_HOTELS_AND_ROMS','Hotels and Rooms');
INSERT INTO `aphs_vocabulary` VALUES (1563,'en','_LOCATIONS','Locations');
INSERT INTO `aphs_vocabulary` VALUES (4783,'ru','_COMMENTS','Comments');
INSERT INTO `aphs_vocabulary` VALUES (3865,'vi','_HOTELS','Hotels');
INSERT INTO `aphs_vocabulary` VALUES (1566,'en','_LOCATION_NAME','Location Name');
INSERT INTO `aphs_vocabulary` VALUES (1569,'en','_LOGIN','Login');
INSERT INTO `aphs_vocabulary` VALUES (1572,'en','_LOGINS','Logins');
INSERT INTO `aphs_vocabulary` VALUES (4782,'ru','_COLLAPSE_PANEL','Collapse navigation panel');
INSERT INTO `aphs_vocabulary` VALUES (3861,'vi','_HIDE','Hide');
INSERT INTO `aphs_vocabulary` VALUES (3862,'vi','_HOME','Home');
INSERT INTO `aphs_vocabulary` VALUES (3863,'vi','_HOTEL','Hotel');
INSERT INTO `aphs_vocabulary` VALUES (3864,'vi','_HOTELOWNER_WELCOME_TEXT','Welcome to Hotel Owner Control Panel! With this Control Panel you can easily manage your hotels, customers, reservations and perform a full hotel site management.');
INSERT INTO `aphs_vocabulary` VALUES (1575,'en','_LOGIN_PAGE_MSG','Use a valid administrator username and password to get access to the Administrator Back-End.<br><br>Return to site <a href=\'index.php\'>Home Page</a><br><br><img align=\'center\' src=\'images/lock.png\' alt=\'\' width=\'92px\'>');
INSERT INTO `aphs_vocabulary` VALUES (4777,'ru','_CLICK_TO_SEE_PRICES','Click to see prices');
INSERT INTO `aphs_vocabulary` VALUES (4778,'ru','_CLICK_TO_VIEW','Click to view');
INSERT INTO `aphs_vocabulary` VALUES (4779,'ru','_CLOSE','Close');
INSERT INTO `aphs_vocabulary` VALUES (4780,'ru','_CLOSE_META_TAGS','Close META tags');
INSERT INTO `aphs_vocabulary` VALUES (4781,'ru','_CODE','Code');
INSERT INTO `aphs_vocabulary` VALUES (3860,'vi','_HIDDEN','Hidden');
INSERT INTO `aphs_vocabulary` VALUES (1578,'en','_LONG_DESCRIPTION','Long Description');
INSERT INTO `aphs_vocabulary` VALUES (1581,'en','_LOOK_IN','Look in');
INSERT INTO `aphs_vocabulary` VALUES (4776,'ru','_CLICK_TO_SEE_DESCR','Click to see description');
INSERT INTO `aphs_vocabulary` VALUES (1584,'en','_MAILER','Mailer');
INSERT INTO `aphs_vocabulary` VALUES (1587,'en','_MAIN','Main');
INSERT INTO `aphs_vocabulary` VALUES (4775,'ru','_CLICK_TO_MANAGE','Click to manage');
INSERT INTO `aphs_vocabulary` VALUES (3859,'vi','_HEADER_IS_EMPTY','Header cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1590,'en','_MAIN_ADMIN','Main Admin');
INSERT INTO `aphs_vocabulary` VALUES (4774,'ru','_CLICK_TO_INCREASE','Click to enlarge');
INSERT INTO `aphs_vocabulary` VALUES (3858,'vi','_HEADERS_AND_FOOTERS','Headers & Footers');
INSERT INTO `aphs_vocabulary` VALUES (1593,'en','_MAKE_RESERVATION','Make а Reservation');
INSERT INTO `aphs_vocabulary` VALUES (4773,'ru','_CLICK_TO_EDIT','Click to edit');
INSERT INTO `aphs_vocabulary` VALUES (3857,'vi','_HEADER','Header');
INSERT INTO `aphs_vocabulary` VALUES (1596,'en','_MANAGE_TEMPLATES','Manage Templates');
INSERT INTO `aphs_vocabulary` VALUES (1599,'en','_MAP_CODE','Map Code');
INSERT INTO `aphs_vocabulary` VALUES (3856,'vi','_HDR_TEXT_DIRECTION','Text Direction');
INSERT INTO `aphs_vocabulary` VALUES (1602,'en','_MAP_OVERLAY','Map Overlay');
INSERT INTO `aphs_vocabulary` VALUES (4772,'ru','_CLICK_FOR_MORE_INFO','Click for more information');
INSERT INTO `aphs_vocabulary` VALUES (1605,'en','_MARCH','March');
INSERT INTO `aphs_vocabulary` VALUES (3855,'vi','_HDR_TEMPLATE','Template');
INSERT INTO `aphs_vocabulary` VALUES (1608,'en','_MASS_MAIL','Mass Mail');
INSERT INTO `aphs_vocabulary` VALUES (4771,'ru','_CLEAN_CACHE','Clean Cache');
INSERT INTO `aphs_vocabulary` VALUES (3853,'vi','_HDR_HEADER_TEXT','Header Text');
INSERT INTO `aphs_vocabulary` VALUES (3854,'vi','_HDR_SLOGAN_TEXT','Slogan');
INSERT INTO `aphs_vocabulary` VALUES (1611,'en','_MASS_MAIL_ALERT','Attention: shared hosting services usually have a limit of 200 emails per hour');
INSERT INTO `aphs_vocabulary` VALUES (3852,'vi','_HDR_FOOTER_TEXT','Footer Text');
INSERT INTO `aphs_vocabulary` VALUES (1614,'en','_MASS_MAIL_AND_TEMPLATES','Mass Mail & Templates');
INSERT INTO `aphs_vocabulary` VALUES (3851,'vi','_GUEST_FEE','Guest Fee');
INSERT INTO `aphs_vocabulary` VALUES (1617,'en','_MAXIMUM_NIGHTS','Maximum Nights');
INSERT INTO `aphs_vocabulary` VALUES (3848,'vi','_GUEST','Guest');
INSERT INTO `aphs_vocabulary` VALUES (3849,'vi','_GUESTS','Guests');
INSERT INTO `aphs_vocabulary` VALUES (3850,'vi','_GUESTS_FEE','Guests Fee');
INSERT INTO `aphs_vocabulary` VALUES (1620,'en','_MAXIMUM_NIGHTS_ALERT','The maximum allowed stay for this period of time from _FROM_ to _TO_ is _NIGHTS_ nights per booking. Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4768,'ru','_CLEANED','Cleaned');
INSERT INTO `aphs_vocabulary` VALUES (4769,'ru','_CLEANUP','Cleanup');
INSERT INTO `aphs_vocabulary` VALUES (4770,'ru','_CLEANUP_TOOLTIP','The cleanup feature is used to remove pending (temporary) reservations from your web site. A pending reservation is one where the system is waiting for the payment gateway to callback with the transaction status.');
INSERT INTO `aphs_vocabulary` VALUES (1623,'en','_MAX_ADULTS','Max Adults');
INSERT INTO `aphs_vocabulary` VALUES (4767,'ru','_CITY_EMPTY_ALERT','City cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1626,'en','_MAX_CHARS','(max: _MAX_CHARS_ chars)');
INSERT INTO `aphs_vocabulary` VALUES (4766,'ru','_CITY','City');
INSERT INTO `aphs_vocabulary` VALUES (1629,'en','_MAX_CHILDREN','Max Children');
INSERT INTO `aphs_vocabulary` VALUES (4765,'ru','_CHILDREN','Children');
INSERT INTO `aphs_vocabulary` VALUES (3847,'vi','_GROUP_TIME_OVERLAPPING_ALERT','This period of time (fully or partially) was already chosen for selected group! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1632,'en','_MAX_GUESTS','Max Guests');
INSERT INTO `aphs_vocabulary` VALUES (4764,'ru','_CHILD','Child');
INSERT INTO `aphs_vocabulary` VALUES (3846,'vi','_GROUP_NAME','Group Name');
INSERT INTO `aphs_vocabulary` VALUES (1635,'en','_MAX_OCCUPANCY','Max. Occupancy');
INSERT INTO `aphs_vocabulary` VALUES (4763,'ru','_CHECK_STATUS','Check Status');
INSERT INTO `aphs_vocabulary` VALUES (3842,'vi','_GENERATE','Generate');
INSERT INTO `aphs_vocabulary` VALUES (3843,'vi','_GLOBAL','Global');
INSERT INTO `aphs_vocabulary` VALUES (3844,'vi','_GLOBAL_CAMPAIGN','Global Campaign');
INSERT INTO `aphs_vocabulary` VALUES (3845,'vi','_GROUP','Group');
INSERT INTO `aphs_vocabulary` VALUES (1638,'en','_MAX_RESERVATIONS_ERROR','You have reached the maximum number of permitted room reservations, that you have not yet finished! Please complete at least one of them to proceed reservation of new rooms.');
INSERT INTO `aphs_vocabulary` VALUES (4758,'ru','_CHECKOUT','Checkout');
INSERT INTO `aphs_vocabulary` VALUES (4759,'ru','_CHECK_AVAILABILITY','Check Availability');
INSERT INTO `aphs_vocabulary` VALUES (4760,'ru','_CHECK_IN','Check In');
INSERT INTO `aphs_vocabulary` VALUES (4761,'ru','_CHECK_NOW','Check Now');
INSERT INTO `aphs_vocabulary` VALUES (4762,'ru','_CHECK_OUT','Check Out');
INSERT INTO `aphs_vocabulary` VALUES (3841,'vi','_GENERAL_SETTINGS','General Settings');
INSERT INTO `aphs_vocabulary` VALUES (1641,'en','_MAY','May');
INSERT INTO `aphs_vocabulary` VALUES (3836,'vi','_GALLERY','Gallery');
INSERT INTO `aphs_vocabulary` VALUES (3837,'vi','_GALLERY_MANAGEMENT','Gallery Management');
INSERT INTO `aphs_vocabulary` VALUES (3838,'vi','_GALLERY_SETTINGS','Gallery Settings');
INSERT INTO `aphs_vocabulary` VALUES (3839,'vi','_GENERAL','General');
INSERT INTO `aphs_vocabulary` VALUES (3840,'vi','_GENERAL_INFO','General Info');
INSERT INTO `aphs_vocabulary` VALUES (1644,'en','_MD_BACKUP_AND_RESTORE','With Backup and Restore module you can dump all of your database tables to a file download or save to a file on the server, and to restore from an uploaded or previously saved database dump.');
INSERT INTO `aphs_vocabulary` VALUES (4754,'ru','_CHANGE_CUSTOMER','Change Customer');
INSERT INTO `aphs_vocabulary` VALUES (4755,'ru','_CHANGE_ORDER','Change Order');
INSERT INTO `aphs_vocabulary` VALUES (4756,'ru','_CHANGE_YOUR_PASSWORD','Change your password');
INSERT INTO `aphs_vocabulary` VALUES (4757,'ru','_CHARGE_TYPE','Charge Type');
INSERT INTO `aphs_vocabulary` VALUES (3834,'vi','_FULLY_BOOKED','fully booked/unavailable');
INSERT INTO `aphs_vocabulary` VALUES (3835,'vi','_FULL_PRICE','Full Price');
INSERT INTO `aphs_vocabulary` VALUES (1647,'en','_MD_BANNERS','The Banners module allows administrator to display images on the site in random or rotation style.');
INSERT INTO `aphs_vocabulary` VALUES (4752,'ru','_CHANGES_SAVED','Changes were saved.');
INSERT INTO `aphs_vocabulary` VALUES (4753,'ru','_CHANGES_WERE_SAVED','Changes were successfully saved! Please refresh the <a href=index.php>Home Page</a> to see the results.');
INSERT INTO `aphs_vocabulary` VALUES (3828,'vi','_FOUND_ROOMS','Found Rooms');
INSERT INTO `aphs_vocabulary` VALUES (3829,'vi','_FR','Fr');
INSERT INTO `aphs_vocabulary` VALUES (3830,'vi','_FRI','Fri');
INSERT INTO `aphs_vocabulary` VALUES (3831,'vi','_FRIDAY','Friday');
INSERT INTO `aphs_vocabulary` VALUES (3832,'vi','_FROM','From');
INSERT INTO `aphs_vocabulary` VALUES (3833,'vi','_FROM_TO_DATE_ALERT','Date \'To\' must be the same or later than date \'From\'! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1650,'en','_MD_BOOKINGS','The Bookings module allows the site owner to define bookings for all rooms, then price them on an individual basis by accommodation and date. It also permits bookings to be taken from customers and managed via administrator panel.');
INSERT INTO `aphs_vocabulary` VALUES (4749,'ru','_CC_NO_CARD_NUMBER_PROVIDED','No card number provided! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4750,'ru','_CC_NUMBER_INVALID','Credit card number is invalid! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4751,'ru','_CC_UNKNOWN_CARD_TYPE','Unknown card type! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3825,'vi','_FORGOT_PASSWORD','Forgot your password?');
INSERT INTO `aphs_vocabulary` VALUES (3826,'vi','_FORM','Form');
INSERT INTO `aphs_vocabulary` VALUES (3827,'vi','_FOUND_HOTELS','Found Hotels');
INSERT INTO `aphs_vocabulary` VALUES (1653,'en','_MD_COMMENTS','The Comments module allows visitors to leave comments on articles and administrator of the site to moderate them.');
INSERT INTO `aphs_vocabulary` VALUES (4747,'ru','_CC_CARD_WRONG_EXPIRE_DATE','Credit card expiry date is wrong! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4748,'ru','_CC_CARD_WRONG_LENGTH','Credit card number has a wrong length! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1656,'en','_MD_CONTACT_US','Contact Us module allows easy create and place on-line contact form on site pages, using predefined code, like: {module:contact_us}.');
INSERT INTO `aphs_vocabulary` VALUES (4745,'ru','_CC_CARD_INVALID_NUMBER','Credit card number is invalid! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4746,'ru','_CC_CARD_NO_CVV_NUMBER','No CVV Code provided! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3821,'vi','_FIXED_SUM','Fixed Sum');
INSERT INTO `aphs_vocabulary` VALUES (3822,'vi','_FOOTER_IS_EMPTY','Footer cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3823,'vi','_FORCE_SSL','Force SSL');
INSERT INTO `aphs_vocabulary` VALUES (3824,'vi','_FORCE_SSL_ALERT','Force site access to always occur under SSL (https) for selected areas. You or site visitors will not be able to access selected areas under non-ssl. Note, you must have SSL enabled on your server to make this option works.');
INSERT INTO `aphs_vocabulary` VALUES (1659,'en','_MD_CUSTOMERS','The Customers module allows easy customers management on your site. Administrator could create, edit or delete customer accounts. Customers could register on the site and log into their accounts.');
INSERT INTO `aphs_vocabulary` VALUES (4743,'ru','_CC_CARD_HOLDER_NAME_EMPTY','No card holder\'s name provided! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4744,'ru','_CC_CARD_INVALID_FORMAT','Credit card number has invalid format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3818,'vi','_FIRST_NAME','First Name');
INSERT INTO `aphs_vocabulary` VALUES (3819,'vi','_FIRST_NAME_EMPTY_ALERT','First Name cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3820,'vi','_FIRST_NIGHT','First Night');
INSERT INTO `aphs_vocabulary` VALUES (1662,'en','_MD_FAQ','The Frequently Asked Questions (faq) module allows admin users to create question and answer pairs which they want displayed on the \'faq\' page.');
INSERT INTO `aphs_vocabulary` VALUES (4739,'ru','_CATEGORIES','Categories');
INSERT INTO `aphs_vocabulary` VALUES (4740,'ru','_CATEGORIES_MANAGEMENT','Categories Management');
INSERT INTO `aphs_vocabulary` VALUES (4741,'ru','_CATEGORY','Category');
INSERT INTO `aphs_vocabulary` VALUES (4742,'ru','_CATEGORY_DESCRIPTION','Category Description');
INSERT INTO `aphs_vocabulary` VALUES (3815,'vi','_FILTER_BY','Filter by');
INSERT INTO `aphs_vocabulary` VALUES (3816,'vi','_FINISH_DATE','Finish Date');
INSERT INTO `aphs_vocabulary` VALUES (3817,'vi','_FINISH_PUBLISHING','Finish Publishing');
INSERT INTO `aphs_vocabulary` VALUES (1665,'en','_MD_GALLERY','The Gallery module allows administrator to create image or video albums, upload album content and dysplay this content to be viewed by visitor of the site.');
INSERT INTO `aphs_vocabulary` VALUES (4737,'ru','_CAPACITY','Capacity');
INSERT INTO `aphs_vocabulary` VALUES (4738,'ru','_CART_WAS_UPDATED','Reservation cart was successfully updated!');
INSERT INTO `aphs_vocabulary` VALUES (3813,'vi','_FILED_UNIQUE_VALUE_ALERT','The field _FIELD_ accepts only unique values - please re-enter!');
INSERT INTO `aphs_vocabulary` VALUES (3814,'vi','_FILE_DELETING_ERROR','An error occurred while deleting file! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (1668,'en','_MD_NEWS','The News and Events module allows administrator to post news and events on the site, display latest of them at the side block.');
INSERT INTO `aphs_vocabulary` VALUES (4735,'ru','_CANCELED_BY_CUSTOMER','This booking was canceled by customer.');
INSERT INTO `aphs_vocabulary` VALUES (4736,'ru','_CAN_USE_TAGS_MSG','You can use some HTML tags, such as');
INSERT INTO `aphs_vocabulary` VALUES (1671,'en','_MD_PAGES','Pages module allows administrator to easily create and maintain page content.');
INSERT INTO `aphs_vocabulary` VALUES (4733,'ru','_CANCELED','Canceled');
INSERT INTO `aphs_vocabulary` VALUES (4734,'ru','_CANCELED_BY_ADMIN','This booking was canceled by administrator.');
INSERT INTO `aphs_vocabulary` VALUES (3811,'vi','_FIELD_VALUE_EXCEEDED','_FIELD_ has exceeded the maximum allowed value _MAX_! Please re-enter. ');
INSERT INTO `aphs_vocabulary` VALUES (3812,'vi','_FIELD_VALUE_MINIMUM','_FIELD_ value should not be less then _MIN_! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1674,'en','_MD_ROOMS','The Rooms module allows the site owner easily manage rooms in your hotel: create, edit or remove them, specify room facilities, define prices and availability for certain period of time, etc.');
INSERT INTO `aphs_vocabulary` VALUES (4732,'ru','_CAMPAIGNS_TOOLTIP','Global - allows booking for any date and runs (visible) within a defined period of time only\r\n\r\nTargeted - allows booking in a specified period of time only and runs (visible) till the first date is beginning');
INSERT INTO `aphs_vocabulary` VALUES (3809,'vi','_FIELD_MUST_BE_UNSIGNED_FLOAT','Field _FIELD_ must be an unsigned float value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3810,'vi','_FIELD_MUST_BE_UNSIGNED_INT','Field _FIELD_ must be an unsigned integer value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1677,'en','_MD_TESTIMONIALS','The Testimonials Module allows the administrator of the site to add/edit customer testimonials, manage them and show on the Hotel Site frontend.');
INSERT INTO `aphs_vocabulary` VALUES (4728,'ru','_CACHE_LIFETIME','Cache Lifetime');
INSERT INTO `aphs_vocabulary` VALUES (4729,'ru','_CACHING','Caching');
INSERT INTO `aphs_vocabulary` VALUES (4730,'ru','_CAMPAIGNS','Campaigns');
INSERT INTO `aphs_vocabulary` VALUES (4731,'ru','_CAMPAIGNS_MANAGEMENT','Campaigns Management');
INSERT INTO `aphs_vocabulary` VALUES (1680,'en','_MEAL_PLANS','Meal Plans');
INSERT INTO `aphs_vocabulary` VALUES (4727,'ru','_BUTTON_UPDATE','Update');
INSERT INTO `aphs_vocabulary` VALUES (3808,'vi','_FIELD_MUST_BE_TEXT','_FIELD_ value must be a text! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1683,'en','_MEAL_PLANS_MANAGEMENT','Meal Plans Management');
INSERT INTO `aphs_vocabulary` VALUES (1686,'en','_MENUS','Menus');
INSERT INTO `aphs_vocabulary` VALUES (4726,'ru','_BUTTON_SAVE_CHANGES','Save Changes');
INSERT INTO `aphs_vocabulary` VALUES (1689,'en','_MENUS_AND_PAGES','Menus and Pages');
INSERT INTO `aphs_vocabulary` VALUES (1692,'en','_MENU_ADD','Add Menu');
INSERT INTO `aphs_vocabulary` VALUES (4725,'ru','_BUTTON_REWRITE','Rewrite Vocabulary');
INSERT INTO `aphs_vocabulary` VALUES (3807,'vi','_FIELD_MUST_BE_SIZE_VALUE','Field _FIELD_ must be a valid HTML size property in \'px\', \'pt\', \'em\' or \'%\' units! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1695,'en','_MENU_CREATED','Menu was successfully created');
INSERT INTO `aphs_vocabulary` VALUES (4724,'ru','_BUTTON_RESET','Reset');
INSERT INTO `aphs_vocabulary` VALUES (1698,'en','_MENU_DELETED','Menu was successfully deleted');
INSERT INTO `aphs_vocabulary` VALUES (4723,'ru','_BUTTON_LOGOUT','Logout');
INSERT INTO `aphs_vocabulary` VALUES (3806,'vi','_FIELD_MUST_BE_POSITIVE_INTEGER','Field _FIELD_ must be a positive integer number!');
INSERT INTO `aphs_vocabulary` VALUES (1701,'en','_MENU_DELETE_WARNING','Are you sure you want to delete this menu? Note: this will make all its menu links invisible to your site visitors!');
INSERT INTO `aphs_vocabulary` VALUES (4720,'ru','_BUTTON_CHANGE_PASSWORD','Change Password');
INSERT INTO `aphs_vocabulary` VALUES (4721,'ru','_BUTTON_CREATE','Create');
INSERT INTO `aphs_vocabulary` VALUES (4722,'ru','_BUTTON_LOGIN','Login');
INSERT INTO `aphs_vocabulary` VALUES (1704,'en','_MENU_EDIT','Edit Menu');
INSERT INTO `aphs_vocabulary` VALUES (4719,'ru','_BUTTON_CHANGE','Change');
INSERT INTO `aphs_vocabulary` VALUES (1707,'en','_MENU_LINK','Menu Link');
INSERT INTO `aphs_vocabulary` VALUES (4718,'ru','_BUTTON_CANCEL','Cancel');
INSERT INTO `aphs_vocabulary` VALUES (3805,'vi','_FIELD_MUST_BE_POSITIVE_INT','Field _FIELD_ must be a positive integer value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1710,'en','_MENU_LINK_TEXT','Menu Link (max. 40 chars)');
INSERT INTO `aphs_vocabulary` VALUES (4717,'ru','_BUTTON_BACK','Back');
INSERT INTO `aphs_vocabulary` VALUES (1713,'en','_MENU_MANAGEMENT','Menus Management');
INSERT INTO `aphs_vocabulary` VALUES (4716,'ru','_BOTTOM','Bottom');
INSERT INTO `aphs_vocabulary` VALUES (1716,'en','_MENU_MISSED','Missed menu to update! Please, try again.');
INSERT INTO `aphs_vocabulary` VALUES (3804,'vi','_FIELD_MUST_BE_PASSWORD','_FIELD_ must be 6 characters at least and consist of letters and digits! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1719,'en','_MENU_NAME','Menu Name');
INSERT INTO `aphs_vocabulary` VALUES (4715,'ru','_BOOK_ONE_NIGHT_ALERT','Sorry, but you must book at least one night.');
INSERT INTO `aphs_vocabulary` VALUES (1722,'en','_MENU_NAME_EMPTY','Menu name cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (4714,'ru','_BOOK_NOW','Book Now');
INSERT INTO `aphs_vocabulary` VALUES (1725,'en','_MENU_NOT_CREATED','Menu was not created!');
INSERT INTO `aphs_vocabulary` VALUES (3803,'vi','_FIELD_MUST_BE_NUMERIC_POSITIVE','Field _FIELD_ must be a positive numeric value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1728,'en','_MENU_NOT_DELETED','Menu was not deleted!');
INSERT INTO `aphs_vocabulary` VALUES (1731,'en','_MENU_NOT_FOUND','No Menus Found');
INSERT INTO `aphs_vocabulary` VALUES (4713,'ru','_BOOKING_WAS_COMPLETED_MSG','Thank you for reservation rooms in our hotel! Your booking has been completed.');
INSERT INTO `aphs_vocabulary` VALUES (3802,'vi','_FIELD_MUST_BE_NUMERIC','Field _FIELD_ must be a numeric value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1734,'en','_MENU_NOT_SAVED','Menu was not saved!');
INSERT INTO `aphs_vocabulary` VALUES (1737,'en','_MENU_ORDER','Menu Order');
INSERT INTO `aphs_vocabulary` VALUES (4712,'ru','_BOOKING_WAS_CANCELED_MSG','Your booking has been canceled.');
INSERT INTO `aphs_vocabulary` VALUES (3801,'vi','_FIELD_MUST_BE_IP_ADDRESS','_FIELD_ must be a valid IP Address! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1740,'en','_MENU_ORDER_CHANGED','Menu order was successfully changed');
INSERT INTO `aphs_vocabulary` VALUES (4711,'ru','_BOOKING_SUBTOTAL','Booking Subtotal');
INSERT INTO `aphs_vocabulary` VALUES (1743,'en','_MENU_SAVED','Menu was successfully saved');
INSERT INTO `aphs_vocabulary` VALUES (4710,'ru','_BOOKING_STATUS','Booking Status');
INSERT INTO `aphs_vocabulary` VALUES (1746,'en','_MENU_TITLE','Menu Title');
INSERT INTO `aphs_vocabulary` VALUES (4709,'ru','_BOOKING_SETTINGS','Booking Settings');
INSERT INTO `aphs_vocabulary` VALUES (1749,'en','_MENU_WORD','Menu');
INSERT INTO `aphs_vocabulary` VALUES (3800,'vi','_FIELD_MUST_BE_FLOAT_POSITIVE','Field _FIELD_ must be a positive float number value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1752,'en','_MESSAGE','Message');
INSERT INTO `aphs_vocabulary` VALUES (4708,'ru','_BOOKING_PRICE','Booking Price');
INSERT INTO `aphs_vocabulary` VALUES (1755,'en','_MESSAGE_EMPTY_ALERT','Message cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4707,'ru','_BOOKING_NUMBER','Booking Number');
INSERT INTO `aphs_vocabulary` VALUES (3799,'vi','_FIELD_MUST_BE_FLOAT','Field _FIELD_ must be a float number value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1758,'en','_META_TAG','Meta Tag');
INSERT INTO `aphs_vocabulary` VALUES (4706,'ru','_BOOKING_DETAILS','Booking Details');
INSERT INTO `aphs_vocabulary` VALUES (1761,'en','_META_TAGS','META Tags');
INSERT INTO `aphs_vocabulary` VALUES (1764,'en','_METHOD','Method');
INSERT INTO `aphs_vocabulary` VALUES (1767,'en','_MIN','Min');
INSERT INTO `aphs_vocabulary` VALUES (4705,'ru','_BOOKING_DESCRIPTION','Booking Description');
INSERT INTO `aphs_vocabulary` VALUES (3798,'vi','_FIELD_MUST_BE_EMAIL','_FIELD_ must be in valid email format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1770,'en','_MINIMUM_NIGHTS','Minimum Nights');
INSERT INTO `aphs_vocabulary` VALUES (4704,'ru','_BOOKING_DATE','Booking Date');
INSERT INTO `aphs_vocabulary` VALUES (3797,'vi','_FIELD_MUST_BE_BOOLEAN','Field _FIELD_ value must be \'yes\' or \'no\'! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1773,'en','_MINIMUM_NIGHTS_ALERT','The minimum allowed stay for the period of time from _FROM_ to _TO_ is _NIGHTS_ nights per booking. Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4702,'ru','_BOOKING_CANCELED_SUCCESS','The booking _BOOKING_ has been successfully canceled from the system!');
INSERT INTO `aphs_vocabulary` VALUES (4703,'ru','_BOOKING_COMPLETED','Booking Completed');
INSERT INTO `aphs_vocabulary` VALUES (1776,'en','_MINUTES','minutes');
INSERT INTO `aphs_vocabulary` VALUES (1779,'en','_MO','Mo');
INSERT INTO `aphs_vocabulary` VALUES (3796,'vi','_FIELD_MUST_BE_ALPHA_NUMERIC','_FIELD_ must be an alphanumeric value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1782,'en','_MODULES','Modules');
INSERT INTO `aphs_vocabulary` VALUES (4701,'ru','_BOOKING_CANCELED','Booking Canceled');
INSERT INTO `aphs_vocabulary` VALUES (1785,'en','_MODULES_MANAGEMENT','Modules Management');
INSERT INTO `aphs_vocabulary` VALUES (4700,'ru','_BOOKINGS_SETTINGS','Booking Settings');
INSERT INTO `aphs_vocabulary` VALUES (3795,'vi','_FIELD_MUST_BE_ALPHA','_FIELD_ must be an alphabetic value! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1788,'en','_MODULES_NOT_FOUND','No modules found!');
INSERT INTO `aphs_vocabulary` VALUES (4699,'ru','_BOOKINGS_MANAGEMENT','Bookings Management');
INSERT INTO `aphs_vocabulary` VALUES (1791,'en','_MODULE_INSTALLED','Module was successfully installed!');
INSERT INTO `aphs_vocabulary` VALUES (4698,'ru','_BOOKINGS','Bookings');
INSERT INTO `aphs_vocabulary` VALUES (1794,'en','_MODULE_INSTALL_ALERT','Are you sure you want to install this module?');
INSERT INTO `aphs_vocabulary` VALUES (4696,'ru','_BOOK','Book');
INSERT INTO `aphs_vocabulary` VALUES (4697,'ru','_BOOKING','Booking');
INSERT INTO `aphs_vocabulary` VALUES (3794,'vi','_FIELD_MIN_LENGTH_ALERT','The length of the field _FIELD_ cannot  be less than _LENGTH_ characters! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1797,'en','_MODULE_UNINSTALLED','Module was successfully un-installed!');
INSERT INTO `aphs_vocabulary` VALUES (1800,'en','_MODULE_UNINSTALL_ALERT','Are you sure you want to un-install this module? All data, related to this module will be permanently deleted form the system!');
INSERT INTO `aphs_vocabulary` VALUES (4694,'ru','_BIRTH_DATE','Birth Date');
INSERT INTO `aphs_vocabulary` VALUES (4695,'ru','_BIRTH_DATE_VALID_ALERT','Birth date was entered in wrong format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1803,'en','_MON','Mon');
INSERT INTO `aphs_vocabulary` VALUES (1806,'en','_MONDAY','Monday');
INSERT INTO `aphs_vocabulary` VALUES (1809,'en','_MONTH','Month');
INSERT INTO `aphs_vocabulary` VALUES (4693,'ru','_BILLING_DETAILS_UPDATED','Your Billing Details has been updated.');
INSERT INTO `aphs_vocabulary` VALUES (3793,'vi','_FIELD_LENGTH_EXCEEDED','_FIELD_ has exceeded the maximum allowed size: _LENGTH_ characters! Please re-enter. ');
INSERT INTO `aphs_vocabulary` VALUES (1812,'en','_MONTHS','Months');
INSERT INTO `aphs_vocabulary` VALUES (1815,'en','_MS_ACTIVATE_BOOKINGS','Specifies whether booking module is active on a Whole Site, Front-End/Back-End only or inactive');
INSERT INTO `aphs_vocabulary` VALUES (4690,'ru','_BEDS','Beds');
INSERT INTO `aphs_vocabulary` VALUES (4691,'ru','_BILLING_ADDRESS','Billing Address');
INSERT INTO `aphs_vocabulary` VALUES (4692,'ru','_BILLING_DETAILS','Billing Details');
INSERT INTO `aphs_vocabulary` VALUES (3791,'vi','_FIELD_CANNOT_BE_EMPTY','Field _FIELD_ cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3792,'vi','_FIELD_LENGTH_ALERT','The length of the field _FIELD_ must be less than _LENGTH_ characters! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1818,'en','_MS_ADMIN_BOOKING_IN_PAST','Specifies whether to allow booking in the past for admins and hotel owners');
INSERT INTO `aphs_vocabulary` VALUES (4687,'ru','_BAN_ITEM','Ban Item');
INSERT INTO `aphs_vocabulary` VALUES (4688,'ru','_BAN_LIST','Ban List');
INSERT INTO `aphs_vocabulary` VALUES (4689,'ru','_BATHROOMS','Bathrooms');
INSERT INTO `aphs_vocabulary` VALUES (3789,'vi','_FAX','Fax');
INSERT INTO `aphs_vocabulary` VALUES (3790,'vi','_FEBRUARY','February');
INSERT INTO `aphs_vocabulary` VALUES (1821,'en','_MS_ADMIN_CHANGE_CUSTOMER_PASSWORD','Specifies whether to allow changing customer password by Admin');
INSERT INTO `aphs_vocabulary` VALUES (4685,'ru','_BANNERS_SETTINGS','Banners Settings');
INSERT INTO `aphs_vocabulary` VALUES (4686,'ru','_BANNER_IMAGE','Banner Image');
INSERT INTO `aphs_vocabulary` VALUES (3788,'vi','_FAQ_SETTINGS','FAQ Settings');
INSERT INTO `aphs_vocabulary` VALUES (1824,'en','_MS_ADMIN_CHANGE_USER_PASSWORD','Specifies whether to allow changing user password by Admin');
INSERT INTO `aphs_vocabulary` VALUES (4683,'ru','_BANNERS','Banners');
INSERT INTO `aphs_vocabulary` VALUES (4684,'ru','_BANNERS_MANAGEMENT','Banners Management');
INSERT INTO `aphs_vocabulary` VALUES (3786,'vi','_FAQ','FAQ');
INSERT INTO `aphs_vocabulary` VALUES (3787,'vi','_FAQ_MANAGEMENT','FAQ Management');
INSERT INTO `aphs_vocabulary` VALUES (1827,'en','_MS_ALBUMS_PER_LINE','Number of album icons per line');
INSERT INTO `aphs_vocabulary` VALUES (4682,'ru','_BANK_TRANSFER','Bank Transfer');
INSERT INTO `aphs_vocabulary` VALUES (3785,'vi','_FACILITIES','Facilities');
INSERT INTO `aphs_vocabulary` VALUES (1830,'en','_MS_ALBUM_ICON_HEIGHT','Album icon height');
INSERT INTO `aphs_vocabulary` VALUES (1833,'en','_MS_ALBUM_ICON_WIDTH','Album icon width');
INSERT INTO `aphs_vocabulary` VALUES (4681,'ru','_BANK_PAYMENT_INFO','Bank Payment Information');
INSERT INTO `aphs_vocabulary` VALUES (3782,'vi','_EXTRAS','Extras');
INSERT INTO `aphs_vocabulary` VALUES (3783,'vi','_EXTRAS_MANAGEMENT','Extras Management');
INSERT INTO `aphs_vocabulary` VALUES (3784,'vi','_EXTRAS_SUBTOTAL','Extras Subtotal');
INSERT INTO `aphs_vocabulary` VALUES (1836,'en','_MS_ALBUM_KEY','The keyword that will be replaced with a certain album images (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (4680,'ru','_BACK_TO_ADMIN_PANEL','Back to Admin Panel');
INSERT INTO `aphs_vocabulary` VALUES (3780,'vi','_EXPIRED','Expired');
INSERT INTO `aphs_vocabulary` VALUES (3781,'vi','_EXPORT','Export');
INSERT INTO `aphs_vocabulary` VALUES (1839,'en','_MS_ALERT_ADMIN_NEW_REGISTRATION','Specifies whether to alert admin on new customer registration');
INSERT INTO `aphs_vocabulary` VALUES (4679,'ru','_BACKUP_YOUR_INSTALLATION','Backup your current Installation');
INSERT INTO `aphs_vocabulary` VALUES (3779,'vi','_EXPAND_PANEL','Expand navigation panel');
INSERT INTO `aphs_vocabulary` VALUES (1842,'en','_MS_ALLOW_ADDING_BY_ADMIN','Specifies whether to allow adding new customers by Admin');
INSERT INTO `aphs_vocabulary` VALUES (4678,'ru','_BACKUP_WAS_RESTORED','Backup _FILE_NAME_ was successfully restored.');
INSERT INTO `aphs_vocabulary` VALUES (3778,'vi','_EVENT_USER_ALREADY_REGISTERED','Member with such email was already registered to this event! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1845,'en','_MS_ALLOW_BOOKING_WITHOUT_ACCOUNT','Specifies whether to allow booking for customer without creating account');
INSERT INTO `aphs_vocabulary` VALUES (4676,'ru','_BACKUP_WAS_CREATED','Backup _FILE_NAME_ was successfully created.');
INSERT INTO `aphs_vocabulary` VALUES (4677,'ru','_BACKUP_WAS_DELETED','Backup _FILE_NAME_ was successfully deleted.');
INSERT INTO `aphs_vocabulary` VALUES (1848,'en','_MS_ALLOW_CHILDREN_IN_ROOM','Specifies whether to allow children in the room');
INSERT INTO `aphs_vocabulary` VALUES (3777,'vi','_EVENT_REGISTRATION_COMPLETED','Thank you for your interest! You have just successfully registered to this event.');
INSERT INTO `aphs_vocabulary` VALUES (1851,'en','_MS_ALLOW_CUSTOMERS_LOGIN','Specifies whether to allow existing customers to login');
INSERT INTO `aphs_vocabulary` VALUES (4675,'ru','_BACKUP_RESTORING_ERROR','An error occurred while restoring file! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (3775,'vi','_ENTIRE_SITE','Entire Site');
INSERT INTO `aphs_vocabulary` VALUES (3776,'vi','_EVENTS','Events');
INSERT INTO `aphs_vocabulary` VALUES (1854,'en','_MS_ALLOW_CUSTOMERS_REGISTRATION','Specifies whether to allow registration of new customers');
INSERT INTO `aphs_vocabulary` VALUES (4674,'ru','_BACKUP_RESTORE_NOTE','Remember: this action will rewrite all your current settings!');
INSERT INTO `aphs_vocabulary` VALUES (3774,'vi','_ENTER_EMAIL_ADDRESS','(Please enter ONLY real email address)');
INSERT INTO `aphs_vocabulary` VALUES (1857,'en','_MS_ALLOW_CUST_RESET_PASSWORDS','Specifies whether to allow customers to restore their passwords');
INSERT INTO `aphs_vocabulary` VALUES (4672,'ru','_BACKUP_RESTORE','Backup Restore');
INSERT INTO `aphs_vocabulary` VALUES (4673,'ru','_BACKUP_RESTORE_ALERT','Are you sure you want to restore this backup');
INSERT INTO `aphs_vocabulary` VALUES (3773,'vi','_ENTER_CONFIRMATION_CODE','Enter Confirmation Code');
INSERT INTO `aphs_vocabulary` VALUES (1860,'en','_MS_ALLOW_GUESTS_IN_ROOM','Specifies whether to allow guests in the room');
INSERT INTO `aphs_vocabulary` VALUES (4671,'ru','_BACKUP_INSTALLATION','Backup Installation');
INSERT INTO `aphs_vocabulary` VALUES (3771,'vi','_EMPTY','Empty');
INSERT INTO `aphs_vocabulary` VALUES (3772,'vi','_ENTER_BOOKING_NUMBER','Enter Your Booking Number');
INSERT INTO `aphs_vocabulary` VALUES (1863,'en','_MS_ALLOW_SYSTEM_SUGGESTION','Specifies whether to show system suggestion feature on empty search results');
INSERT INTO `aphs_vocabulary` VALUES (3770,'vi','_EMAIL_VALID_ALERT','Please enter a valid email address!');
INSERT INTO `aphs_vocabulary` VALUES (1866,'en','_MS_AUTHORIZE_LOGIN_ID','Specifies Authorize.Net API Login ID');
INSERT INTO `aphs_vocabulary` VALUES (4670,'ru','_BACKUP_EXECUTING_ERROR','An error occurred while backup the system! Please check write permissions to backup folder or try again later.');
INSERT INTO `aphs_vocabulary` VALUES (3769,'vi','_EMAIL_TO','Email Address (To)');
INSERT INTO `aphs_vocabulary` VALUES (1869,'en','_MS_AUTHORIZE_TRANSACTION_KEY','Specifies Authorize.Net Transaction Key');
INSERT INTO `aphs_vocabulary` VALUES (4669,'ru','_BACKUP_EMPTY_NAME_ALERT','Name of backup file cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3768,'vi','_EMAIL_TEMPLATES_EDITOR','Email Templates Editor');
INSERT INTO `aphs_vocabulary` VALUES (1872,'en','_MS_AVAILABLE_UNTIL_APPROVAL','Specifies whether to show \'reserved\' rooms in search results until booking is complete');
INSERT INTO `aphs_vocabulary` VALUES (4667,'ru','_BACKUP_DELETE_ALERT','Are you sure you want to delete this backup?');
INSERT INTO `aphs_vocabulary` VALUES (4668,'ru','_BACKUP_EMPTY_MSG','No existing backups found.');
INSERT INTO `aphs_vocabulary` VALUES (3766,'vi','_EMAIL_SUCCESSFULLY_SENT','Email was successfully sent!');
INSERT INTO `aphs_vocabulary` VALUES (3767,'vi','_EMAIL_TEMPLATES','Email Templates');
INSERT INTO `aphs_vocabulary` VALUES (1875,'en','_MS_BANK_TRANSFER_INFO','Specifies a required banking information: name of the bank, branch, account number etc.');
INSERT INTO `aphs_vocabulary` VALUES (4666,'ru','_BACKUP_CHOOSE_MSG','Choose a backup from the list below');
INSERT INTO `aphs_vocabulary` VALUES (3765,'vi','_EMAIL_SETTINGS','Email Settings');
INSERT INTO `aphs_vocabulary` VALUES (1878,'en','_MS_BANNERS_CAPTION_HTML','Specifies whether to allow using of HTML in slideshow captions or not');
INSERT INTO `aphs_vocabulary` VALUES (4663,'ru','_BACKUP','Backup');
INSERT INTO `aphs_vocabulary` VALUES (4664,'ru','_BACKUPS_EXISTING','Existing Backups');
INSERT INTO `aphs_vocabulary` VALUES (4665,'ru','_BACKUP_AND_RESTORE','Backup & Restore');
INSERT INTO `aphs_vocabulary` VALUES (1881,'en','_MS_BANNERS_IS_ACTIVE','Defines whether banners module is active or not');
INSERT INTO `aphs_vocabulary` VALUES (4662,'ru','_AVAILABLE_ROOMS','Available Rooms');
INSERT INTO `aphs_vocabulary` VALUES (3764,'vi','_EMAIL_SEND_ERROR','An error occurred while sending email. Please check your email settings and message recipients, then try again.');
INSERT INTO `aphs_vocabulary` VALUES (1884,'en','_MS_BOOKING_MODE','Specifies which mode is turned ON for booking');
INSERT INTO `aphs_vocabulary` VALUES (4661,'ru','_AVAILABLE','available');
INSERT INTO `aphs_vocabulary` VALUES (3763,'vi','_EMAIL_NOT_EXISTS','This e-mail account does not exist in the system! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1887,'en','_MS_BOOKING_NUMBER_TYPE','Specifies the type of booking numbers');
INSERT INTO `aphs_vocabulary` VALUES (3762,'vi','_EMAIL_NOTIFICATIONS','Send email notifications');
INSERT INTO `aphs_vocabulary` VALUES (1890,'en','_MS_COMMENTS_ALLOW','Specifies whether to allow comments to articles');
INSERT INTO `aphs_vocabulary` VALUES (3761,'vi','_EMAIL_IS_WRONG','Please enter a valid email address.');
INSERT INTO `aphs_vocabulary` VALUES (1893,'en','_MS_COMMENTS_LENGTH','The maximum length of a comment');
INSERT INTO `aphs_vocabulary` VALUES (3760,'vi','_EMAIL_IS_EMPTY','Email must not be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (1896,'en','_MS_COMMENTS_PAGE_SIZE','Defines how much comments will be shown on one page');
INSERT INTO `aphs_vocabulary` VALUES (4660,'ru','_AVAILABILITY_ROOMS_NOTE','Define a maximum number of rooms available for booking for a specified day or date range (maximum availability _MAX_ rooms)<br>To edit room availability simply change the value in a day cell and then click \'Save Changes\' button');
INSERT INTO `aphs_vocabulary` VALUES (3758,'vi','_EMAIL_EMPTY_ALERT','Email cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3759,'vi','_EMAIL_FROM','Email Address (From)');
INSERT INTO `aphs_vocabulary` VALUES (1899,'en','_MS_CONTACT_US_KEY','The keyword that will be replaced with Contact Us form (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (4658,'ru','_AUTHORIZE_NET_ORDER','Authorize.Net Order');
INSERT INTO `aphs_vocabulary` VALUES (4659,'ru','_AVAILABILITY','Availability');
INSERT INTO `aphs_vocabulary` VALUES (3757,'vi','_EMAIL_BLOCKED','Your email was blocked! To resolve this problem, please contact the site administrator.');
INSERT INTO `aphs_vocabulary` VALUES (1902,'en','_MS_CUSTOMERS_CANCEL_RESERVATION','Specifies the number of days before customers may cancel a reservation');
INSERT INTO `aphs_vocabulary` VALUES (4657,'ru','_AUTHORIZE_NET_NOTICE','The Authorize.Net payment gateway service provider.');
INSERT INTO `aphs_vocabulary` VALUES (3756,'vi','_EMAIL_ADDRESS','E-mail address');
INSERT INTO `aphs_vocabulary` VALUES (1905,'en','_MS_CUSTOMERS_IMAGE_VERIFICATION','Specifies whether to allow image verification (captcha) on customer registration page');
INSERT INTO `aphs_vocabulary` VALUES (4654,'ru','_ARTICLE_ID','Article ID');
INSERT INTO `aphs_vocabulary` VALUES (4655,'ru','_AUGUST','August');
INSERT INTO `aphs_vocabulary` VALUES (4656,'ru','_AUTHENTICATION','Authentication');
INSERT INTO `aphs_vocabulary` VALUES (3755,'vi','_EMAILS_SUCCESSFULLY_SENT','Status: _SENT_ emails from _TOTAL_ were successfully sent!');
INSERT INTO `aphs_vocabulary` VALUES (1908,'en','_MS_DEFAULT_PAYMENT_SYSTEM','Specifies default payment processing system');
INSERT INTO `aphs_vocabulary` VALUES (4652,'ru','_APRIL','April');
INSERT INTO `aphs_vocabulary` VALUES (4653,'ru','_ARTICLE','Article');
INSERT INTO `aphs_vocabulary` VALUES (1911,'en','_MS_DELAY_LENGTH','Defines a length of delay between sending emails (in seconds)');
INSERT INTO `aphs_vocabulary` VALUES (4650,'ru','_APPROVE','Approve');
INSERT INTO `aphs_vocabulary` VALUES (4651,'ru','_APPROVED','Approved');
INSERT INTO `aphs_vocabulary` VALUES (3753,'vi','_EMAIL','Email');
INSERT INTO `aphs_vocabulary` VALUES (3754,'vi','_EMAILS_SENT_ERROR','An error occurred while sending emails or there are no emails to be sent! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (1914,'en','_MS_DELETE_PENDING_TIME','The maximum pending time for deleting of comment in minutes');
INSERT INTO `aphs_vocabulary` VALUES (4649,'ru','_APPLY_TO_ALL_PAGES','Apply changes to all pages');
INSERT INTO `aphs_vocabulary` VALUES (3751,'vi','_EDIT_PAGE','Edit Page');
INSERT INTO `aphs_vocabulary` VALUES (3752,'vi','_EDIT_WORD','Edit');
INSERT INTO `aphs_vocabulary` VALUES (1917,'en','_MS_EMAIL','The email address, that will be used to get sent information');
INSERT INTO `aphs_vocabulary` VALUES (4646,'ru','_ANY','Any');
INSERT INTO `aphs_vocabulary` VALUES (4647,'ru','_APPLY','Apply');
INSERT INTO `aphs_vocabulary` VALUES (4648,'ru','_APPLY_TO_ALL_LANGUAGES','Apply to all languages');
INSERT INTO `aphs_vocabulary` VALUES (3750,'vi','_EDIT_MY_ACCOUNT','Edit My Account');
INSERT INTO `aphs_vocabulary` VALUES (1920,'en','_MS_FAQ_IS_ACTIVE','Defines whether FAQ module is active or not');
INSERT INTO `aphs_vocabulary` VALUES (4645,'ru','_ANSWER','Answer');
INSERT INTO `aphs_vocabulary` VALUES (3748,'vi','_ECHECK','E-Check');
INSERT INTO `aphs_vocabulary` VALUES (3749,'vi','_EDIT_MENUS','Edit Menus');
INSERT INTO `aphs_vocabulary` VALUES (1923,'en','_MS_FIRST_NIGHT_CALCULATING_TYPE','Specifies a type of the \'first night\' value calculating: real or average');
INSERT INTO `aphs_vocabulary` VALUES (4643,'ru','_ALREADY_LOGGED','You are already logged in!');
INSERT INTO `aphs_vocabulary` VALUES (4644,'ru','_AMOUNT','Amount');
INSERT INTO `aphs_vocabulary` VALUES (3745,'vi','_DOWN','Down');
INSERT INTO `aphs_vocabulary` VALUES (3746,'vi','_DOWNLOAD','Download');
INSERT INTO `aphs_vocabulary` VALUES (3747,'vi','_DOWNLOAD_INVOICE','Download Invoice');
INSERT INTO `aphs_vocabulary` VALUES (1926,'en','_MS_GALLERY_KEY','The keyword that will be replaced with gallery (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (4642,'ru','_ALREADY_HAVE_ACCOUNT','Already have an account? <a href=\'index.php?customer=login\'>Login here</a>');
INSERT INTO `aphs_vocabulary` VALUES (3744,'vi','_DISPLAY_ON','Display on');
INSERT INTO `aphs_vocabulary` VALUES (1929,'en','_MS_GALLERY_WRAPPER','Defines a wrapper type for gallery');
INSERT INTO `aphs_vocabulary` VALUES (4641,'ru','_ALL_AVAILABLE','All Available');
INSERT INTO `aphs_vocabulary` VALUES (1932,'en','_MS_IMAGE_GALLERY_TYPE','Allowed types of Image Gallery');
INSERT INTO `aphs_vocabulary` VALUES (4639,'ru','_ALLOW','Allow');
INSERT INTO `aphs_vocabulary` VALUES (4640,'ru','_ALLOW_COMMENTS','Allow comments');
INSERT INTO `aphs_vocabulary` VALUES (1935,'en','_MS_IMAGE_VERIFICATION_ALLOW','Specifies whether to allow image verification (captcha)');
INSERT INTO `aphs_vocabulary` VALUES (4638,'ru','_ALL','All');
INSERT INTO `aphs_vocabulary` VALUES (3743,'vi','_DISCOUNT_STD_CAMPAIGN_TEXT','Super discount campaign!<br><br>Enjoy special price cuts in our Hotel at the specified periods of time below!');
INSERT INTO `aphs_vocabulary` VALUES (1938,'en','_MS_IS_SEND_DELAY','Specifies whether to allow time delay between sending emails.');
INSERT INTO `aphs_vocabulary` VALUES (4636,'ru','_ALERT_CANCEL_BOOKING','Are you sure you want to cancel this booking?');
INSERT INTO `aphs_vocabulary` VALUES (4637,'ru','_ALERT_REQUIRED_FILEDS','Items marked with an asterisk (*) are required');
INSERT INTO `aphs_vocabulary` VALUES (1941,'en','_MS_ITEMS_COUNT_IN_ALBUM','Specifies whether to show count of images/video under album name');
INSERT INTO `aphs_vocabulary` VALUES (4634,'ru','_ALBUM_CODE','Album Code');
INSERT INTO `aphs_vocabulary` VALUES (4635,'ru','_ALBUM_NAME','Album Name');
INSERT INTO `aphs_vocabulary` VALUES (3742,'vi','_DISCOUNT_CAMPAIGN_TEXT','<span class=\'campaign_header\'>Super discount campaign!</span><br /><br />\r\nEnjoy special price cuts <br />_FROM_ _TO_:<br /> \r\n<b>_PERCENT_</b> on every room reservation in our Hotel!');
INSERT INTO `aphs_vocabulary` VALUES (1944,'en','_MS_MAXIMUM_ALLOWED_RESERVATIONS','Specifies the maximum number of allowed room reservations (not completed) per customer');
INSERT INTO `aphs_vocabulary` VALUES (4632,'ru','_AGREE_CONF_TEXT','I have read and AGREE with Terms & Conditions');
INSERT INTO `aphs_vocabulary` VALUES (4633,'ru','_ALBUM','Album');
INSERT INTO `aphs_vocabulary` VALUES (3740,'vi','_DISCOUNT_CAMPAIGN','Discount Campaign');
INSERT INTO `aphs_vocabulary` VALUES (3741,'vi','_DISCOUNT_CAMPAIGNS','Discount Campaigns');
INSERT INTO `aphs_vocabulary` VALUES (1947,'en','_MS_MAXIMUM_NIGHTS','Defines a maximum number of nights per booking [<a href=index.php?admin=mod_booking_packages>Define by Package</a>]');
INSERT INTO `aphs_vocabulary` VALUES (4629,'ru','_ADULTS','Adults');
INSERT INTO `aphs_vocabulary` VALUES (4630,'ru','_ADVANCED','Advanced');
INSERT INTO `aphs_vocabulary` VALUES (4631,'ru','_AFTER_DISCOUNT','after discount');
INSERT INTO `aphs_vocabulary` VALUES (3737,'vi','_DESCRIPTION','Description');
INSERT INTO `aphs_vocabulary` VALUES (3738,'vi','_DISCOUNT','Discount');
INSERT INTO `aphs_vocabulary` VALUES (3739,'vi','_DISCOUNT_BY_ADMIN','Discount By Administrator');
INSERT INTO `aphs_vocabulary` VALUES (1950,'en','_MS_MINIMUM_NIGHTS','Defines a minimum number of nights per booking [<a href=index.php?admin=mod_booking_packages>Define by Package</a>]');
INSERT INTO `aphs_vocabulary` VALUES (4628,'ru','_ADULT','Adult');
INSERT INTO `aphs_vocabulary` VALUES (3736,'vi','_DELETING_OPERATION_COMPLETED','Deleting operation was successfully completed!');
INSERT INTO `aphs_vocabulary` VALUES (1953,'en','_MS_NEWS_COUNT','Defines how many news will be shown in news block');
INSERT INTO `aphs_vocabulary` VALUES (1956,'en','_MS_NEWS_HEADER_LENGTH','Defines a length of news header in block');
INSERT INTO `aphs_vocabulary` VALUES (1959,'en','_MS_NEWS_RSS','Defines using of RSS for news');
INSERT INTO `aphs_vocabulary` VALUES (3734,'vi','_DELETE_WORD','Delete');
INSERT INTO `aphs_vocabulary` VALUES (3735,'vi','_DELETING_ACCOUNT_ERROR','An error occurred while deleting your account! Please try again later or send email about this issue to administration of the site.');
INSERT INTO `aphs_vocabulary` VALUES (1962,'en','_MS_ONLINE_CREDIT_CARD_REQUIRED','Specifies whether collecting of credit card info is required for \'On-line Orders\'');
INSERT INTO `aphs_vocabulary` VALUES (3733,'vi','_DELETE_WARNING_COMMON','Are you sure you want to delete this record?');
INSERT INTO `aphs_vocabulary` VALUES (1965,'en','_MS_PAYMENT_TYPE_2CO','Specifies whether to allow \'2CO\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (3732,'vi','_DELETE_WARNING','Are you sure you want to delete this record?');
INSERT INTO `aphs_vocabulary` VALUES (1968,'en','_MS_PAYMENT_TYPE_AUTHORIZE','Specifies whether to allow \'Authorize.Net\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (3730,'vi','_DEFAULT_PRICE','Default Price');
INSERT INTO `aphs_vocabulary` VALUES (3731,'vi','_DEFAULT_TEMPLATE','Default Template');
INSERT INTO `aphs_vocabulary` VALUES (1971,'en','_MS_PAYMENT_TYPE_BANK_TRANSFER','Specifies whether to allow \'Bank Transfer\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (1974,'en','_MS_PAYMENT_TYPE_ONLINE','Specifies whether to allow \'On-line Order\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (3729,'vi','_DEFAULT_OWN_EMAIL_ALERT','You have to change your own email address. Click <a href=\'index.php?admin=my_account\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (1977,'en','_MS_PAYMENT_TYPE_PAYPAL','Specifies whether to allow \'PayPal\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (3728,'vi','_DEFAULT_HOTEL_DELETE_ALERT','You cannot delete default hotel!');
INSERT INTO `aphs_vocabulary` VALUES (1980,'en','_MS_PAYMENT_TYPE_POA','Specifies whether to allow \'Pay on Arrival\' (POA) payment type');
INSERT INTO `aphs_vocabulary` VALUES (1983,'en','_MS_PAYPAL_EMAIL','Specifies PayPal (business) email ');
INSERT INTO `aphs_vocabulary` VALUES (3727,'vi','_DEFAULT_EMAIL_ALERT','You have to change default email address for site administrator. Click <a href=\'index.php?admin=settings&tabid=1_4\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (1986,'en','_MS_PREPARING_ORDERS_TIMEOUT','Defines a timeout for \'preparing\' orders before automatic deleting (in hours)');
INSERT INTO `aphs_vocabulary` VALUES (3726,'vi','_DEFAULT_CURRENCY_DELETE_ALERT','You cannot delete default currency!');
INSERT INTO `aphs_vocabulary` VALUES (1989,'en','_MS_PRE_MODERATION_ALLOW','Specifies whether to allow pre-moderation for comments');
INSERT INTO `aphs_vocabulary` VALUES (3724,'vi','_DEFAULT','Default');
INSERT INTO `aphs_vocabulary` VALUES (3725,'vi','_DEFAULT_AVAILABILITY','Default Availability');
INSERT INTO `aphs_vocabulary` VALUES (1992,'en','_MS_PRE_PAYMENT_TYPE','Defines a pre-payment type (full price, first night only, fixed sum or percentage)');
INSERT INTO `aphs_vocabulary` VALUES (3722,'vi','_DAY','Day');
INSERT INTO `aphs_vocabulary` VALUES (3723,'vi','_DECEMBER','December');
INSERT INTO `aphs_vocabulary` VALUES (1995,'en','_MS_PRE_PAYMENT_VALUE','Defines a pre-payment value for \'fixed sum\' or \'percentage\' types');
INSERT INTO `aphs_vocabulary` VALUES (4626,'ru','_ADMIN_RESERVATION','Admin Reservation');
INSERT INTO `aphs_vocabulary` VALUES (4627,'ru','_ADMIN_WELCOME_TEXT','<p>Welcome to Administrator Control Panel that allows you to add, edit or delete site content. With this Administrator Control Panel you can easy manage customers, reservations and perform a full hotel site management.</p><p><b>&#8226;</b> There are some modules for you: Backup & Restore, News. Installation or un-installation of them is possible from <a href=\'index.php?admin=modules\'>Modules Menu</a>.</p><p><b>&#8226;</b> In <a href=\'index.php?admin=languages\'>Languages Menu</a> you may add/remove language or change language settings and edit your vocabulary (the words and phrases, used by the system).</p><p><b>&#8226;</b> <a href=\'index.php?admin=settings\'>Settings Menu</a> allows you to define important settings for the site.</p><p><b>&#8226;</b> In <a href=\'index.php?admin=my_account\'>My Account</a> there is a possibility to change your info.</p><p><b>&#8226;</b> <a href=\'index.php?admin=menus\'>Menus</a> and <a href=\'index.php?admin=pages\'>Pages Management</a> are designed for creating and managing menus, links and pages.</p><p><b>&#8226;</b> To create and edit room types, seasons, prices, bookings and other hotel info, use <a href=\'index.php?admin=hotel_info\'>Hotel Management</a>, <a href=\'index.php?admin=rooms_management\'>Rooms Management</a> and <a href=\'index.php?admin=mod_booking_bookings\'>Bookings</a> menus.</p>');
INSERT INTO `aphs_vocabulary` VALUES (3720,'vi','_DATE_PUBLISHED','Date Published');
INSERT INTO `aphs_vocabulary` VALUES (3721,'vi','_DATE_SUBSCRIBED','Date Subscribed');
INSERT INTO `aphs_vocabulary` VALUES (1998,'en','_MS_REG_CONFIRMATION','Defines whether confirmation (which type of) is required for registration');
INSERT INTO `aphs_vocabulary` VALUES (4625,'ru','_ADMIN_PANEL','Admin Panel');
INSERT INTO `aphs_vocabulary` VALUES (3719,'vi','_DATE_PAYMENT','Date of Payment');
INSERT INTO `aphs_vocabulary` VALUES (2001,'en','_MS_REMEMBER_ME','Specifies whether to allow Remember Me feature');
INSERT INTO `aphs_vocabulary` VALUES (3717,'vi','_DATE_FORMAT','Date Format');
INSERT INTO `aphs_vocabulary` VALUES (3718,'vi','_DATE_MODIFIED','Date Modified');
INSERT INTO `aphs_vocabulary` VALUES (2004,'en','_MS_RESERVATION EXPIRED_ALERT','Specifies whether to send email alert to customer when reservation has expired');
INSERT INTO `aphs_vocabulary` VALUES (4623,'ru','_ADMIN_LOGIN','Admin Login');
INSERT INTO `aphs_vocabulary` VALUES (4624,'ru','_ADMIN_MAILER_ALERT','Select which mailer you prefer to use for the delivery of site emails.');
INSERT INTO `aphs_vocabulary` VALUES (3715,'vi','_DATE_CREATED','Date Created');
INSERT INTO `aphs_vocabulary` VALUES (3716,'vi','_DATE_EMPTY_ALERT','Date fields cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2007,'en','_MS_RESERVATION_INITIAL_FEE','Start (initial) fee - the sum that will be added to each booking (fixed value in default currency)');
INSERT INTO `aphs_vocabulary` VALUES (4621,'ru','_ADMIN_EMAIL_IS_EMPTY','Admin email must not be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4622,'ru','_ADMIN_EMAIL_WRONG','Admin email in wrong format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3712,'vi','_DATE','Date');
INSERT INTO `aphs_vocabulary` VALUES (3713,'vi','_DATETIME_PRICE_FORMAT','Datetime & Price Settings');
INSERT INTO `aphs_vocabulary` VALUES (3714,'vi','_DATE_AND_TIME_SETTINGS','Date & Time Settings');
INSERT INTO `aphs_vocabulary` VALUES (2010,'en','_MS_ROOMS_IN_SEARCH','Specifies what types of rooms to show in search result: all or available rooms only (without fully booked / unavailable)');
INSERT INTO `aphs_vocabulary` VALUES (4620,'ru','_ADMIN_EMAIL_EXISTS_ALERT','Administrator with such email already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (3710,'vi','_CVV_CODE','CVV Code');
INSERT INTO `aphs_vocabulary` VALUES (3711,'vi','_DASHBOARD','Dashboard');
INSERT INTO `aphs_vocabulary` VALUES (2013,'en','_MS_ROTATE_DELAY','Defines banners rotation delay in seconds');
INSERT INTO `aphs_vocabulary` VALUES (2016,'en','_MS_ROTATION_TYPE','Different type of banner rotation');
INSERT INTO `aphs_vocabulary` VALUES (4619,'ru','_ADMIN_EMAIL_ALERT','This email is used as \"From\" address for the system email notifications. Make sure, that you write here a valid email address based on domain of your site');
INSERT INTO `aphs_vocabulary` VALUES (3707,'vi','_CUSTOMER_NAME','Customer Name');
INSERT INTO `aphs_vocabulary` VALUES (3708,'vi','_CUSTOMER_PANEL','Customer Panel');
INSERT INTO `aphs_vocabulary` VALUES (3709,'vi','_CUSTOMER_PAYMENT_MODULES','Customer & Payment Modules');
INSERT INTO `aphs_vocabulary` VALUES (2019,'en','_MS_SEARCH_AVAILABILITY_PAGE_SIZE','Specifies the number of rooms/hotels that will be displayed on one page in the search availability results');
INSERT INTO `aphs_vocabulary` VALUES (4616,'ru','_ADMINS_AND_CUSTOMERS','Customers & Admins');
INSERT INTO `aphs_vocabulary` VALUES (4617,'ru','_ADMINS_MANAGEMENT','Admins Management');
INSERT INTO `aphs_vocabulary` VALUES (4618,'ru','_ADMIN_EMAIL','Admin Email');
INSERT INTO `aphs_vocabulary` VALUES (3706,'vi','_CUSTOMER_LOGIN','Customer Login');
INSERT INTO `aphs_vocabulary` VALUES (2022,'en','_MS_SEND_ORDER_COPY_TO_ADMIN','Specifies whether to allow sending a copy of order to admin');
INSERT INTO `aphs_vocabulary` VALUES (4615,'ru','_ADMINS','Admins');
INSERT INTO `aphs_vocabulary` VALUES (3704,'vi','_CUSTOMER_GROUP','Customer Group');
INSERT INTO `aphs_vocabulary` VALUES (3705,'vi','_CUSTOMER_GROUPS','Customer Groups');
INSERT INTO `aphs_vocabulary` VALUES (2025,'en','_MS_SHOW_BOOKING_STATUS_FORM','Specifies whether to show Booking Status Form on homepage or not');
INSERT INTO `aphs_vocabulary` VALUES (4612,'ru','_ADD_TO_MENU','Add To Menu');
INSERT INTO `aphs_vocabulary` VALUES (4613,'ru','_ADMIN','Admin');
INSERT INTO `aphs_vocabulary` VALUES (4614,'ru','_ADMINISTRATOR_ONLY','Administrator Only');
INSERT INTO `aphs_vocabulary` VALUES (3703,'vi','_CUSTOMER_DETAILS','Customer Details');
INSERT INTO `aphs_vocabulary` VALUES (2028,'en','_MS_SHOW_FULLY_BOOKED_ROOMS','Specifies whether to allow showing of fully booked/unavailable rooms in search');
INSERT INTO `aphs_vocabulary` VALUES (4609,'ru','_ADD_NEW','Add New');
INSERT INTO `aphs_vocabulary` VALUES (4610,'ru','_ADD_NEW_MENU','Add New Menu');
INSERT INTO `aphs_vocabulary` VALUES (4611,'ru','_ADD_TO_CART','Add to Cart');
INSERT INTO `aphs_vocabulary` VALUES (3701,'vi','_CUSTOMERS_MANAGEMENT','Customers Management');
INSERT INTO `aphs_vocabulary` VALUES (3702,'vi','_CUSTOMERS_SETTINGS','Customers Settings');
INSERT INTO `aphs_vocabulary` VALUES (2031,'en','_MS_SHOW_NEWSLETTER_SUBSCRIBE_BLOCK','Defines whether to show Newsletter Subscription block or not');
INSERT INTO `aphs_vocabulary` VALUES (4608,'ru','_ADDRESS_EMPTY_ALERT','Address cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2034,'en','_MS_SHOW_NEWS_BLOCK','Defines whether to show News side block or not');
INSERT INTO `aphs_vocabulary` VALUES (4606,'ru','_ADDRESS','Address');
INSERT INTO `aphs_vocabulary` VALUES (4607,'ru','_ADDRESS_2','Address (line 2)');
INSERT INTO `aphs_vocabulary` VALUES (2037,'en','_MS_SHOW_RESERVATION_FORM','Specifies whether to show Reservation Form on homepage or not');
INSERT INTO `aphs_vocabulary` VALUES (3698,'vi','_CUSTOMER','Customer');
INSERT INTO `aphs_vocabulary` VALUES (3699,'vi','_CUSTOMERS','Customers');
INSERT INTO `aphs_vocabulary` VALUES (3700,'vi','_CUSTOMERS_AWAITING_MODERATION_ALERT','There are _COUNT_ customer/s awaiting your approval. Click <a href=\'index.php?admin=mod_customers_management\'>here</a> for review.');
INSERT INTO `aphs_vocabulary` VALUES (2040,'en','_MS_TESTIMONIALS_KEY','The keyword that will be replaced with a list of customer testimonials (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (4604,'ru','_ADDITIONAL_PAYMENT','Additional Payment');
INSERT INTO `aphs_vocabulary` VALUES (4605,'ru','_ADDITIONAL_PAYMENT_TOOLTIP','To apply an additional payment or admin discount enter into this field an appropriate value (positive or negative).');
INSERT INTO `aphs_vocabulary` VALUES (3697,'vi','_CURRENT_NEXT_YEARS','for current/next years');
INSERT INTO `aphs_vocabulary` VALUES (2043,'en','_MS_TWO_CHECKOUT_VENDOR','Specifies 2CO Vendor ID');
INSERT INTO `aphs_vocabulary` VALUES (4603,'ru','_ADDITIONAL_MODULES','Additional Modules');
INSERT INTO `aphs_vocabulary` VALUES (3696,'vi','_CURRENCY','Currency');
INSERT INTO `aphs_vocabulary` VALUES (2046,'en','_MS_USER_TYPE','Type of users, who can post comments');
INSERT INTO `aphs_vocabulary` VALUES (4602,'ru','_ADDITIONAL_INFO','Additional Info');
INSERT INTO `aphs_vocabulary` VALUES (3695,'vi','_CURRENCIES_MANAGEMENT','Currencies Management');
INSERT INTO `aphs_vocabulary` VALUES (2049,'en','_MS_VAT_INCLUDED_IN_PRICE','Specifies whether VAT fee is included in room and extras prices or not');
INSERT INTO `aphs_vocabulary` VALUES (4601,'ru','_ADDITIONAL_GUEST_FEE','Additional Guest Fee');
INSERT INTO `aphs_vocabulary` VALUES (2052,'en','_MS_VAT_VALUE','Specifies default VAT value for order (in %) &nbsp;[<a href=index.php?admin=countries_management>Define by Country</a>]');
INSERT INTO `aphs_vocabulary` VALUES (4598,'ru','_ACTIVE','Active');
INSERT INTO `aphs_vocabulary` VALUES (4599,'ru','_ADD','Add');
INSERT INTO `aphs_vocabulary` VALUES (4600,'ru','_ADDING_OPERATION_COMPLETED','The adding operation completed successfully!');
INSERT INTO `aphs_vocabulary` VALUES (3694,'vi','_CURRENCIES_DEFAULT_ALERT','Remember! After you change the default currency:<br>- Edit exchange rate to each currency manually (relatively to the new default currency)<br>- Redefine prices for all rooms in the new currency.');
INSERT INTO `aphs_vocabulary` VALUES (2055,'en','_MS_VIDEO_GALLERY_TYPE','Allowed types of Video Gallery');
INSERT INTO `aphs_vocabulary` VALUES (3692,'vi','_CRON_JOBS','Cron Jobs');
INSERT INTO `aphs_vocabulary` VALUES (3693,'vi','_CURRENCIES','Currencies');
INSERT INTO `aphs_vocabulary` VALUES (2058,'en','_MUST_BE_LOGGED','You must be logged in to view this page! <a href=\'index.php?customer=login\'>Login</a> or <a href=\'index.php?customer=create_account\'>Create Account for free</a>.');
INSERT INTO `aphs_vocabulary` VALUES (4597,'ru','_ACTIVATION_EMAIL_WAS_SENT','An email has been sent to _EMAIL_ with an activation key. Please check your mail to complete registration.');
INSERT INTO `aphs_vocabulary` VALUES (2061,'en','_MY_ACCOUNT','My Account');
INSERT INTO `aphs_vocabulary` VALUES (2064,'en','_MY_BOOKINGS','My Bookings');
INSERT INTO `aphs_vocabulary` VALUES (4596,'ru','_ACTIVATION_EMAIL_ALREADY_SENT','The activation email was already sent to your email. Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (2067,'en','_MY_ORDERS','My Orders');
INSERT INTO `aphs_vocabulary` VALUES (2070,'en','_NAME','Name');
INSERT INTO `aphs_vocabulary` VALUES (4595,'ru','_ACTION_REQUIRED','ACTION REQUIRED');
INSERT INTO `aphs_vocabulary` VALUES (2073,'en','_NEVER','never');
INSERT INTO `aphs_vocabulary` VALUES (2076,'en','_NEWS','News');
INSERT INTO `aphs_vocabulary` VALUES (4594,'ru','_ACTIONS_WORD','Action');
INSERT INTO `aphs_vocabulary` VALUES (2079,'en','_NEWSLETTER_PAGE_TEXT','<p>To receive newsletters from our site, simply enter your email and click on \"Subscribe\" button.</p><p>If you later decide to stop your subscription or change the type of news you receive, simply follow the link at the end of the latest newsletter and update your profile or unsubscribe by ticking the checkbox below.</p>');
INSERT INTO `aphs_vocabulary` VALUES (4591,'ru','_ACCOUT_CREATED_CONF_LINK','Already confirmed your registration? Click <a href=index.php?customer=login>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (4592,'ru','_ACCOUT_CREATED_CONF_MSG','Already confirmed your registration? Click <a href=index.php?customer=login>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (4593,'ru','_ACTIONS','Action');
INSERT INTO `aphs_vocabulary` VALUES (3691,'vi','_CRONJOB_NOTICE','Cron jobs allow you to automate certain commands or scripts on your site.<br /><br />ApPHP Hotel Site needs to periodically run cron.php to close expired discount campaigns or perform another importans operations. The recommended way to run cron.php is to set up a cronjob if you run a Unix/Linux server. If for any reason you can&#039;t run a cronjob on your server, you can choose the Non-batch option below to have cron.php run by ApPHP Hotel Site itself: in this case cron.php will be run each time someone access your home page. <br /><br />Example of Batch Cron job command: <b>php &#36;HOME/public_html/cron.php >/dev/null 2>&1</b>');
INSERT INTO `aphs_vocabulary` VALUES (2082,'en','_NEWSLETTER_PRE_SUBSCRIBE_ALERT','Please click on the \"Subscribe\" button to complete the process.');
INSERT INTO `aphs_vocabulary` VALUES (4590,'ru','_ACCOUNT_WAS_UPDATED','Your account was successfully updated!');
INSERT INTO `aphs_vocabulary` VALUES (3690,'vi','_CRONJOB_HTACCESS_BLOCK','To block remote access to cron.php, in the server&#039;s .htaccess file or vhost configuration file add this section:');
INSERT INTO `aphs_vocabulary` VALUES (2085,'en','_NEWSLETTER_PRE_UNSUBSCRIBE_ALERT','Please click on the \"Unsubscribe\" button to complete the process.');
INSERT INTO `aphs_vocabulary` VALUES (4589,'ru','_ACCOUNT_WAS_DELETED','Your account was successfully removed! In seconds, you will be automatically redirected to the homepage.');
INSERT INTO `aphs_vocabulary` VALUES (2088,'en','_NEWSLETTER_SUBSCRIBERS','Newsletter Subscribers');
INSERT INTO `aphs_vocabulary` VALUES (4588,'ru','_ACCOUNT_WAS_CREATED','Your account has been created');
INSERT INTO `aphs_vocabulary` VALUES (3687,'vi','_CREDIT_CARD_HOLDER_NAME','Card Holder\'s Name');
INSERT INTO `aphs_vocabulary` VALUES (3688,'vi','_CREDIT_CARD_NUMBER','Credit Card Number');
INSERT INTO `aphs_vocabulary` VALUES (3689,'vi','_CREDIT_CARD_TYPE','Credit Card Type');
INSERT INTO `aphs_vocabulary` VALUES (2091,'en','_NEWSLETTER_SUBSCRIBE_SUCCESS','Thank you for subscribing to our electronic newsletter. You will receive an e-mail to confirm your subscription.');
INSERT INTO `aphs_vocabulary` VALUES (4587,'ru','_ACCOUNT_TYPE','Account type');
INSERT INTO `aphs_vocabulary` VALUES (3683,'vi','_CREATING_ACCOUNT_ERROR','An error occurred while creating your account! Please try again later or send information about this error to administration of the site.');
INSERT INTO `aphs_vocabulary` VALUES (3684,'vi','_CREATING_NEW_ACCOUNT','Creating new account');
INSERT INTO `aphs_vocabulary` VALUES (3685,'vi','_CREDIT_CARD','Credit Card');
INSERT INTO `aphs_vocabulary` VALUES (3686,'vi','_CREDIT_CARD_EXPIRES','Expires');
INSERT INTO `aphs_vocabulary` VALUES (2094,'en','_NEWSLETTER_SUBSCRIBE_TEXT','<p>To receive newsletters from our site, simply enter your email and click on \"Subscribe\" button.</p><p>If you later decide to stop your subscription or change the type of news you receive, simply follow the link at the end of the latest newsletter and update your profile or unsubscribe by ticking the checkbox below.</p>');
INSERT INTO `aphs_vocabulary` VALUES (4584,'ru','_ACCOUNT_CREATE_MSG','This registration process requires confirmation via email! <br />Please fill out the form below with correct information.');
INSERT INTO `aphs_vocabulary` VALUES (4585,'ru','_ACCOUNT_DETAILS','Account Details');
INSERT INTO `aphs_vocabulary` VALUES (4586,'ru','_ACCOUNT_SUCCESSFULLY_RESET','You have successfully reset your account and username with temporary password have been sent to your email.');
INSERT INTO `aphs_vocabulary` VALUES (2097,'en','_NEWSLETTER_SUBSCRIPTION_MANAGEMENT','Newsletter Subscription Management');
INSERT INTO `aphs_vocabulary` VALUES (2100,'en','_NEWSLETTER_UNSUBSCRIBE_SUCCESS','You have been successfully unsubscribed from our newsletter!');
INSERT INTO `aphs_vocabulary` VALUES (4583,'ru','_ACCOUNT_CREATED_NON_CONFIRM_MSG','Your account has been successfully created! For your convenience in a few minutes you will receive an email, containing the details of your registration (no confirmation required). <br><br>You may log into your account now.');
INSERT INTO `aphs_vocabulary` VALUES (2103,'en','_NEWSLETTER_UNSUBSCRIBE_TEXT','<p>To unsubscribe from our newsletters, enter your email address below and click the unsubscribe button.</p>');
INSERT INTO `aphs_vocabulary` VALUES (4582,'ru','_ACCOUNT_CREATED_NON_CONFIRM_LINK','Click <a href=index.php?customer=login>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (2106,'en','_NEWS_AND_EVENTS','News & Events');
INSERT INTO `aphs_vocabulary` VALUES (2109,'en','_NEWS_MANAGEMENT','News Management');
INSERT INTO `aphs_vocabulary` VALUES (2112,'en','_NEWS_SETTINGS','News Settings');
INSERT INTO `aphs_vocabulary` VALUES (2115,'en','_NEXT','Next');
INSERT INTO `aphs_vocabulary` VALUES (2118,'en','_NIGHT','Night');
INSERT INTO `aphs_vocabulary` VALUES (2121,'en','_NIGHTS','Nights');
INSERT INTO `aphs_vocabulary` VALUES (2124,'en','_NO','No');
INSERT INTO `aphs_vocabulary` VALUES (3682,'vi','_CREATE_ACCOUNT_NOTE','NOTE: <br>We recommend that your password should be at least 6 characters long and should be different from your username.<br><br>Your e-mail address must be valid. We use e-mail for communication purposes (order notifications, etc). Therefore, it is essential to provide a valid e-mail address to be able to use our services correctly.<br><br>All your private data is confidential. We will never sell, exchange or market it in any way. For further information on the responsibilities of both parts, you may refer to us.');
INSERT INTO `aphs_vocabulary` VALUES (2127,'en','_NONE','None');
INSERT INTO `aphs_vocabulary` VALUES (3680,'vi','_CREATED_DATE','Date Created');
INSERT INTO `aphs_vocabulary` VALUES (3681,'vi','_CREATE_ACCOUNT','Create account');
INSERT INTO `aphs_vocabulary` VALUES (2130,'en','_NOTICE_MODULES_CODE','To add available modules to this page just copy and paste into the text:');
INSERT INTO `aphs_vocabulary` VALUES (4581,'ru','_ACCOUNT_CREATED_MSG','Your account was successfully created. <b>You will receive now a confirmation email</b>, containing the details of your account (it may take a few minutes). <br /><br />After completing the confirmation you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (3679,'vi','_COUPON_WAS_REMOVED','The coupon has been successfully removed!');
INSERT INTO `aphs_vocabulary` VALUES (2133,'en','_NOTIFICATION_MSG','Please send me information about specials and discounts!');
INSERT INTO `aphs_vocabulary` VALUES (2136,'en','_NOTIFICATION_STATUS_CHANGED','Notification status changed');
INSERT INTO `aphs_vocabulary` VALUES (3678,'vi','_COUPON_WAS_APPLIED','The coupon _COUPON_CODE_ has been successfully applied!');
INSERT INTO `aphs_vocabulary` VALUES (2139,'en','_NOT_ALLOWED','Not Allowed');
INSERT INTO `aphs_vocabulary` VALUES (2142,'en','_NOT_AUTHORIZED','You are not authorized to view this page.');
INSERT INTO `aphs_vocabulary` VALUES (4580,'ru','_ACCOUNT_CREATED_CONF_MSG','Your account was successfully created. <b>You will receive now an email</b>, containing the details of your account (it may take a few minutes).<br><br>After approval by an administrator, you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (3677,'vi','_COUPON_CODE','Coupon Code');
INSERT INTO `aphs_vocabulary` VALUES (2145,'en','_NOT_AVAILABLE','N/A');
INSERT INTO `aphs_vocabulary` VALUES (2148,'en','_NOT_PAID_YET','Not paid yet');
INSERT INTO `aphs_vocabulary` VALUES (3676,'vi','_COUPONS_MANAGEMENT','Coupons Management');
INSERT INTO `aphs_vocabulary` VALUES (2151,'en','_NOVEMBER','November');
INSERT INTO `aphs_vocabulary` VALUES (3675,'vi','_COUPONS','Coupons');
INSERT INTO `aphs_vocabulary` VALUES (2154,'en','_NO_AVAILABLE','Not Available');
INSERT INTO `aphs_vocabulary` VALUES (3673,'vi','_COUNTRY','Country');
INSERT INTO `aphs_vocabulary` VALUES (3674,'vi','_COUNTRY_EMPTY_ALERT','Country cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2157,'en','_NO_BOOKING_FOUND','The number of booking you\'ve entered was not found in our system! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2160,'en','_NO_COMMENTS_YET','No comments yet.');
INSERT INTO `aphs_vocabulary` VALUES (3672,'vi','_COUNTRIES_MANAGEMENT','Countries Management');
INSERT INTO `aphs_vocabulary` VALUES (2163,'en','_NO_CUSTOMER_FOUND','No customer found!');
INSERT INTO `aphs_vocabulary` VALUES (4579,'ru','_ACCOUNT_CREATED_CONF_BY_EMAIL_MSG','Your account has been successfully created! In a few minutes you should receive an email, containing the details of your registration. <br><br> Complete this registration, using the confirmation code that was sent to the provided email address, and you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (3671,'vi','_COUNTRIES','Countries');
INSERT INTO `aphs_vocabulary` VALUES (2166,'en','_NO_NEWS','No news');
INSERT INTO `aphs_vocabulary` VALUES (3669,'vi','_COPY_TO_OTHER_LANGS','Copy to other languages');
INSERT INTO `aphs_vocabulary` VALUES (3670,'vi','_COUNT','Count');
INSERT INTO `aphs_vocabulary` VALUES (2169,'en','_NO_PAYMENT_METHODS_ALERT','No payment methods available! Please contact our technical support.');
INSERT INTO `aphs_vocabulary` VALUES (2172,'en','_NO_RECORDS_FOUND','No records found');
INSERT INTO `aphs_vocabulary` VALUES (3668,'vi','_CONTINUE_RESERVATION','Continue Reservation');
INSERT INTO `aphs_vocabulary` VALUES (2175,'en','_NO_RECORDS_PROCESSED','No records found for processing!');
INSERT INTO `aphs_vocabulary` VALUES (3667,'vi','_CONTENT_TYPE','Content Type');
INSERT INTO `aphs_vocabulary` VALUES (2178,'en','_NO_RECORDS_UPDATED','No records were updated!');
INSERT INTO `aphs_vocabulary` VALUES (4578,'ru','_ACCOUNT_CREATED_CONF_BY_ADMIN_MSG','Your account has been successfully created! In a few minutes you should receive an email, containing the details of your account. <br><br> After approval your registration by administrator, you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (3665,'vi','_CONTACT_US_EMAIL_SENT','Thank you for contacting us! Your message has been successfully sent.');
INSERT INTO `aphs_vocabulary` VALUES (3666,'vi','_CONTACT_US_SETTINGS','Contact Us Settings');
INSERT INTO `aphs_vocabulary` VALUES (2181,'en','_NO_ROOMS_FOUND','Sorry, there are no rooms that match your search. Please change your search criteria to see more rooms.');
INSERT INTO `aphs_vocabulary` VALUES (4576,'ru','_ACCOUNTS_MANAGEMENT','Accounts');
INSERT INTO `aphs_vocabulary` VALUES (4577,'ru','_ACCOUNT_ALREADY_RESET','Your account was already reset! Please check your email inbox for more information.');
INSERT INTO `aphs_vocabulary` VALUES (2184,'en','_NO_TEMPLATE','no template');
INSERT INTO `aphs_vocabulary` VALUES (4575,'ru','_ACCOUNTS','Accounts');
INSERT INTO `aphs_vocabulary` VALUES (3662,'vi','_CONTACT_INFORMATION','Contact Information');
INSERT INTO `aphs_vocabulary` VALUES (3663,'vi','_CONTACT_US','Contact us');
INSERT INTO `aphs_vocabulary` VALUES (3664,'vi','_CONTACT_US_ALREADY_SENT','Your message was already sent. Please try again later or wait _WAIT_ seconds.');
INSERT INTO `aphs_vocabulary` VALUES (2187,'en','_NO_USER_EMAIL_EXISTS_ALERT','It seems that you already booked rooms with us! <br>Please click <a href=index.php?customer=reset_account>here</a> to reset your username and get a temporary password. ');
INSERT INTO `aphs_vocabulary` VALUES (4570,'ru','_2CO_ORDER','2CO Order');
INSERT INTO `aphs_vocabulary` VALUES (4571,'ru','_ABBREVIATION','Abbreviation');
INSERT INTO `aphs_vocabulary` VALUES (4572,'ru','_ABOUT_US','About Us');
INSERT INTO `aphs_vocabulary` VALUES (4573,'ru','_ACCESS','Access');
INSERT INTO `aphs_vocabulary` VALUES (4574,'ru','_ACCESSIBLE_BY','Accessible By');
INSERT INTO `aphs_vocabulary` VALUES (2190,'en','_NO_WRITE_ACCESS_ALERT','Please check you have write access to following directories:');
INSERT INTO `aphs_vocabulary` VALUES (4569,'ru','_2CO_NOTICE','2CheckOut.com Inc. (Ohio, USA) is an authorized retailer for goods and services.');
INSERT INTO `aphs_vocabulary` VALUES (2193,'en','_OCCUPANCY','Occupancy');
INSERT INTO `aphs_vocabulary` VALUES (2196,'en','_OCTOBER','October');
INSERT INTO `aphs_vocabulary` VALUES (4568,'vi','_ZIP_CODE','Zip/Postal code');
INSERT INTO `aphs_vocabulary` VALUES (2199,'en','_OFF','Off');
INSERT INTO `aphs_vocabulary` VALUES (3661,'vi','_CONTACTUS_DEFAULT_EMAIL_ALERT','You have to change default email address for Contact Us module. Click <a href=\'index.php?admin=mod_contact_us_settings\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (2202,'en','_OFFLINE_LOGIN_ALERT','To log into Admin Panel when site is offline, type in your browser: http://{your_site_address}/index.php?admin=login');
INSERT INTO `aphs_vocabulary` VALUES (4565,'vi','_YOUR_NAME','Your Name');
INSERT INTO `aphs_vocabulary` VALUES (4566,'vi','_YOU_ARE_LOGGED_AS','You are logged in as');
INSERT INTO `aphs_vocabulary` VALUES (4567,'vi','_ZIPCODE_EMPTY_ALERT','Zip/Postal code cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2205,'en','_OFFLINE_MESSAGE','Offline Message');
INSERT INTO `aphs_vocabulary` VALUES (4564,'vi','_YOUR_EMAIL','Your Email');
INSERT INTO `aphs_vocabulary` VALUES (3660,'vi','_CONF_PASSWORD_MATCH','Password must be match with Confirm Password');
INSERT INTO `aphs_vocabulary` VALUES (2208,'en','_ON','On');
INSERT INTO `aphs_vocabulary` VALUES (4563,'vi','_YES','Yes');
INSERT INTO `aphs_vocabulary` VALUES (2211,'en','_ONLINE','Online');
INSERT INTO `aphs_vocabulary` VALUES (4562,'vi','_YEAR','Year');
INSERT INTO `aphs_vocabulary` VALUES (2214,'en','_ONLINE_ORDER','On-line Order');
INSERT INTO `aphs_vocabulary` VALUES (2217,'en','_ONLY','Only');
INSERT INTO `aphs_vocabulary` VALUES (3659,'vi','_CONF_PASSWORD_IS_EMPTY','Confirm Password cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (2220,'en','_OPEN','Open');
INSERT INTO `aphs_vocabulary` VALUES (4561,'vi','_WYSIWYG_EDITOR','WYSIWYG Editor');
INSERT INTO `aphs_vocabulary` VALUES (2223,'en','_OPEN_ALERT_WINDOW','Open Alert Window');
INSERT INTO `aphs_vocabulary` VALUES (3658,'vi','_CONFIRM_TERMS_CONDITIONS','You must confirm you agree to our Terms & Conditions!');
INSERT INTO `aphs_vocabulary` VALUES (2226,'en','_OPERATION_BLOCKED','This operation is blocked in Demo Version!');
INSERT INTO `aphs_vocabulary` VALUES (4560,'vi','_WRONG_PARAMETER_PASSED','Wrong parameters passed - cannot complete operation!');
INSERT INTO `aphs_vocabulary` VALUES (3657,'vi','_CONFIRM_PASSWORD','Confirm Password');
INSERT INTO `aphs_vocabulary` VALUES (2229,'en','_OPERATION_COMMON_COMPLETED','The operation was successfully completed!');
INSERT INTO `aphs_vocabulary` VALUES (4559,'vi','_WRONG_LOGIN','Wrong username or password!');
INSERT INTO `aphs_vocabulary` VALUES (2232,'en','_OPERATION_WAS_ALREADY_COMPLETED','This operation was already completed!');
INSERT INTO `aphs_vocabulary` VALUES (2235,'en','_OR','or');
INSERT INTO `aphs_vocabulary` VALUES (2238,'en','_ORDER','Order');
INSERT INTO `aphs_vocabulary` VALUES (4558,'vi','_WRONG_FILE_TYPE','Uploaded file is not a valid PHP vocabulary file! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2241,'en','_ORDERS','Orders');
INSERT INTO `aphs_vocabulary` VALUES (2244,'en','_ORDERS_COUNT','Orders count');
INSERT INTO `aphs_vocabulary` VALUES (3656,'vi','_CONFIRMED_SUCCESS_MSG','Thank you for confirming your registration! <br /><br />You may now log into your account. Click <a href=\'index.php?customer=login\'>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (2247,'en','_ORDER_DATE','Order Date');
INSERT INTO `aphs_vocabulary` VALUES (4557,'vi','_WRONG_COUPON_CODE','This coupon code is invalid or has expired!');
INSERT INTO `aphs_vocabulary` VALUES (2250,'en','_ORDER_ERROR','Cannot complete your order! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (2253,'en','_ORDER_NOW','Order Now');
INSERT INTO `aphs_vocabulary` VALUES (4556,'vi','_WRONG_CONFIRMATION_CODE','Wrong confirmation code or your registration was already confirmed!');
INSERT INTO `aphs_vocabulary` VALUES (3653,'vi','_CONFIRMATION','Confirmation');
INSERT INTO `aphs_vocabulary` VALUES (3654,'vi','_CONFIRMATION_CODE','Confirmation Code');
INSERT INTO `aphs_vocabulary` VALUES (3655,'vi','_CONFIRMED_ALREADY_MSG','Your account has already been confirmed! <br /><br />Click <a href=\'index.php?customer=login\'>here</a> to continue.');
INSERT INTO `aphs_vocabulary` VALUES (2256,'en','_ORDER_PLACED_MSG','Thank you! The order has been placed in our system and will be processed shortly. Your booking number is: _BOOKING_NUMBER_.');
INSERT INTO `aphs_vocabulary` VALUES (4555,'vi','_WRONG_CODE_ALERT','Sorry, the code you have entered was invalid! Please try again.');
INSERT INTO `aphs_vocabulary` VALUES (2259,'en','_ORDER_PRICE','Order Price');
INSERT INTO `aphs_vocabulary` VALUES (3652,'vi','_COMPLETED','Completed');
INSERT INTO `aphs_vocabulary` VALUES (2262,'en','_OTHER','Other');
INSERT INTO `aphs_vocabulary` VALUES (4554,'vi','_WRONG_CHECKOUT_DATE_ALERT','Wrong date selected! Please choose a valid check-out date.');
INSERT INTO `aphs_vocabulary` VALUES (3651,'vi','_COMPANY','Company');
INSERT INTO `aphs_vocabulary` VALUES (2265,'en','_OUR_LOCATION','Our location');
INSERT INTO `aphs_vocabulary` VALUES (2268,'en','_OWNER','Owner');
INSERT INTO `aphs_vocabulary` VALUES (3650,'vi','_COMMENT_TEXT','Comment text');
INSERT INTO `aphs_vocabulary` VALUES (2271,'en','_PACKAGES','Packages');
INSERT INTO `aphs_vocabulary` VALUES (2274,'en','_PACKAGES_MANAGEMENT','Packages Management');
INSERT INTO `aphs_vocabulary` VALUES (2277,'en','_PAGE','Page');
INSERT INTO `aphs_vocabulary` VALUES (4553,'vi','_WRONG_BOOKING_NUMBER','The booking number you\'ve entered was not found! Please enter a valid booking number.');
INSERT INTO `aphs_vocabulary` VALUES (2280,'en','_PAGES','Pages');
INSERT INTO `aphs_vocabulary` VALUES (2283,'en','_PAGE_ADD_NEW','Add New Page');
INSERT INTO `aphs_vocabulary` VALUES (4552,'vi','_WITHOUT_ACCOUNT','without account');
INSERT INTO `aphs_vocabulary` VALUES (3649,'vi','_COMMENT_SUBMITTED_SUCCESS','Your comment has been successfully submitted and will be posted after administrator\'s review!');
INSERT INTO `aphs_vocabulary` VALUES (2286,'en','_PAGE_CREATED','Page was successfully created');
INSERT INTO `aphs_vocabulary` VALUES (4551,'vi','_WHOLE_SITE','Whole site');
INSERT INTO `aphs_vocabulary` VALUES (2289,'en','_PAGE_DELETED','Page was successfully deleted');
INSERT INTO `aphs_vocabulary` VALUES (4550,'vi','_WHAT_IS_CVV','What is CVV');
INSERT INTO `aphs_vocabulary` VALUES (3648,'vi','_COMMENT_POSTED_SUCCESS','Your comment has been successfully posted!');
INSERT INTO `aphs_vocabulary` VALUES (2292,'en','_PAGE_DELETE_WARNING','Are you sure you want to delete this page?');
INSERT INTO `aphs_vocabulary` VALUES (2295,'en','_PAGE_EDIT_HOME','Edit Home Page');
INSERT INTO `aphs_vocabulary` VALUES (2298,'en','_PAGE_EDIT_PAGES','Edit Pages');
INSERT INTO `aphs_vocabulary` VALUES (3647,'vi','_COMMENT_LENGTH_ALERT','The length of comment must be less than _LENGTH_ characters!');
INSERT INTO `aphs_vocabulary` VALUES (2301,'en','_PAGE_EDIT_SYS_PAGES','Edit System Pages');
INSERT INTO `aphs_vocabulary` VALUES (2304,'en','_PAGE_EXPIRED','The page you requested has expired!');
INSERT INTO `aphs_vocabulary` VALUES (3646,'vi','_COMMENT_DELETED_SUCCESS','Your comment was successfully deleted.');
INSERT INTO `aphs_vocabulary` VALUES (2307,'en','_PAGE_HEADER','Page Header');
INSERT INTO `aphs_vocabulary` VALUES (3645,'vi','_COMMENTS_SETTINGS','Comments Settings');
INSERT INTO `aphs_vocabulary` VALUES (2310,'en','_PAGE_HEADER_EMPTY','Page header cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (3644,'vi','_COMMENTS_MANAGEMENT','Comments Management');
INSERT INTO `aphs_vocabulary` VALUES (2313,'en','_PAGE_KEY_EMPTY','Page key cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (3643,'vi','_COMMENTS_LINK','Comments (_COUNT_)');
INSERT INTO `aphs_vocabulary` VALUES (2316,'en','_PAGE_LINK_TOO_LONG','Menu link too long!');
INSERT INTO `aphs_vocabulary` VALUES (2319,'en','_PAGE_MANAGEMENT','Pages Management');
INSERT INTO `aphs_vocabulary` VALUES (2322,'en','_PAGE_NOT_CREATED','Page was not created!');
INSERT INTO `aphs_vocabulary` VALUES (2325,'en','_PAGE_NOT_DELETED','Page was not deleted!');
INSERT INTO `aphs_vocabulary` VALUES (2328,'en','_PAGE_NOT_EXISTS','The page you attempted to access does not exist');
INSERT INTO `aphs_vocabulary` VALUES (3642,'vi','_COMMENTS_AWAITING_MODERATION_ALERT','There are _COUNT_ comment/s awaiting your moderation. Click <a href=\'index.php?admin=mod_comments_management\'>here</a> for review.');
INSERT INTO `aphs_vocabulary` VALUES (2331,'en','_PAGE_NOT_FOUND','No Pages Found');
INSERT INTO `aphs_vocabulary` VALUES (4549,'vi','_WELCOME_CUSTOMER_TEXT','<p>Hello <b>_FIRST_NAME_ _LAST_NAME_</b>!</p>        \r\n<p>Welcome to Customer Account Panel, that allows you to view account status, manage your account settings and bookings.</p>\r\n<p>\r\n   _TODAY_<br />\r\n   _LAST_LOGIN_\r\n</p>				\r\n<p> <b>&#8226;</b> To view this account summary just click on a <a href=\'index.php?customer=home\'>Dashboard</a> link.</p>\r\n<p> <b>&#8226;</b> <a href=\'index.php?customer=my_account\'>Edit My Account</a> menu allows you to change your personal info and account data.</p>\r\n<p> <b>&#8226;</b> <a href=\'index.php?customer=my_bookings\'>My Bookings</a> contains information about your orders.</p>\r\n<p><br /></p>');
INSERT INTO `aphs_vocabulary` VALUES (3641,'vi','_COMMENTS','Comments');
INSERT INTO `aphs_vocabulary` VALUES (2334,'en','_PAGE_NOT_SAVED','Page was not saved!');
INSERT INTO `aphs_vocabulary` VALUES (4548,'vi','_WEEK_START_DAY','Week Start Day');
INSERT INTO `aphs_vocabulary` VALUES (3640,'vi','_COLLAPSE_PANEL','Collapse navigation panel');
INSERT INTO `aphs_vocabulary` VALUES (2337,'en','_PAGE_ORDER_CHANGED','Page order was successfully changed!');
INSERT INTO `aphs_vocabulary` VALUES (4546,'vi','_WED','Wed');
INSERT INTO `aphs_vocabulary` VALUES (4547,'vi','_WEDNESDAY','Wednesday');
INSERT INTO `aphs_vocabulary` VALUES (3639,'vi','_CODE','Code');
INSERT INTO `aphs_vocabulary` VALUES (2340,'en','_PAGE_REMOVED','Page was successfully removed!');
INSERT INTO `aphs_vocabulary` VALUES (4545,'vi','_WEB_SITE','Web Site');
INSERT INTO `aphs_vocabulary` VALUES (2343,'en','_PAGE_REMOVE_WARNING','Are you sure you want to move this page to the Trash?');
INSERT INTO `aphs_vocabulary` VALUES (4544,'vi','_WE','We');
INSERT INTO `aphs_vocabulary` VALUES (3637,'vi','_CLOSE','Close');
INSERT INTO `aphs_vocabulary` VALUES (3638,'vi','_CLOSE_META_TAGS','Close META tags');
INSERT INTO `aphs_vocabulary` VALUES (2346,'en','_PAGE_RESTORED','Page was successfully restored!');
INSERT INTO `aphs_vocabulary` VALUES (3636,'vi','_CLICK_TO_VIEW','Click to view');
INSERT INTO `aphs_vocabulary` VALUES (2349,'en','_PAGE_RESTORE_WARNING','Are you sure you want to restore this page?');
INSERT INTO `aphs_vocabulary` VALUES (4542,'vi','_VOC_NOT_FOUND','No keys found');
INSERT INTO `aphs_vocabulary` VALUES (4543,'vi','_VOC_UPDATED','Vocabulary was successfully updated. Click <a href=index.php>here</a> to refresh the site.');
INSERT INTO `aphs_vocabulary` VALUES (3635,'vi','_CLICK_TO_SEE_PRICES','Click to see prices');
INSERT INTO `aphs_vocabulary` VALUES (2352,'en','_PAGE_SAVED','Page was successfully saved');
INSERT INTO `aphs_vocabulary` VALUES (2355,'en','_PAGE_TEXT','Page text');
INSERT INTO `aphs_vocabulary` VALUES (4541,'vi','_VOC_KEY_VALUE_EMPTY','Key value cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3634,'vi','_CLICK_TO_SEE_DESCR','Click to see description');
INSERT INTO `aphs_vocabulary` VALUES (2358,'en','_PAGE_TITLE','Page Title');
INSERT INTO `aphs_vocabulary` VALUES (2361,'en','_PAGE_UNKNOWN','Unknown page!');
INSERT INTO `aphs_vocabulary` VALUES (3633,'vi','_CLICK_TO_MANAGE','Click to manage');
INSERT INTO `aphs_vocabulary` VALUES (2364,'en','_PARAMETER','Parameter');
INSERT INTO `aphs_vocabulary` VALUES (4540,'vi','_VOC_KEY_UPDATED','Vocabulary key was successfully updated.');
INSERT INTO `aphs_vocabulary` VALUES (3632,'vi','_CLICK_TO_INCREASE','Click to enlarge');
INSERT INTO `aphs_vocabulary` VALUES (2367,'en','_PARTIALLY_AVAILABLE','Partially Available');
INSERT INTO `aphs_vocabulary` VALUES (2370,'en','_PARTIAL_PRICE','Partial Price');
INSERT INTO `aphs_vocabulary` VALUES (3631,'vi','_CLICK_TO_EDIT','Click to edit');
INSERT INTO `aphs_vocabulary` VALUES (2373,'en','_PASSWORD','Password');
INSERT INTO `aphs_vocabulary` VALUES (3629,'vi','_CLEAN_CACHE','Clean Cache');
INSERT INTO `aphs_vocabulary` VALUES (3630,'vi','_CLICK_FOR_MORE_INFO','Click for more information');
INSERT INTO `aphs_vocabulary` VALUES (2376,'en','_PASSWORD_ALREADY_SENT','Password was already sent to your email. Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (4538,'vi','_VOCABULARY','Vocabulary');
INSERT INTO `aphs_vocabulary` VALUES (4539,'vi','_VOC_KEYS_UPDATED','Operation was successfully completed. Updated: _KEYS_ keys. Click <a href=\'index.php?admin=vocabulary&filter_by=A\'>here</a> to refresh the site.');
INSERT INTO `aphs_vocabulary` VALUES (2379,'en','_PASSWORD_CHANGED','Password was changed.');
INSERT INTO `aphs_vocabulary` VALUES (4537,'vi','_VISUAL_SETTINGS','Visual Settings');
INSERT INTO `aphs_vocabulary` VALUES (2382,'en','_PASSWORD_DO_NOT_MATCH','Password and confirmation do not match!');
INSERT INTO `aphs_vocabulary` VALUES (4535,'vi','_VIEW_WORD','View');
INSERT INTO `aphs_vocabulary` VALUES (4536,'vi','_VISITOR','Visitor');
INSERT INTO `aphs_vocabulary` VALUES (2385,'en','_PASSWORD_FORGOTTEN','Forgotten Password');
INSERT INTO `aphs_vocabulary` VALUES (4534,'vi','_VIDEO','Video');
INSERT INTO `aphs_vocabulary` VALUES (3624,'vi','_CITY','City');
INSERT INTO `aphs_vocabulary` VALUES (3625,'vi','_CITY_EMPTY_ALERT','City cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3626,'vi','_CLEANED','Cleaned');
INSERT INTO `aphs_vocabulary` VALUES (3627,'vi','_CLEANUP','Cleanup');
INSERT INTO `aphs_vocabulary` VALUES (3628,'vi','_CLEANUP_TOOLTIP','The cleanup feature is used to remove pending (temporary) reservations from your web site. A pending reservation is one where the system is waiting for the payment gateway to callback with the transaction status.');
INSERT INTO `aphs_vocabulary` VALUES (2388,'en','_PASSWORD_FORGOTTEN_PAGE_MSG','Use a valid administrator e-mail to restore your password to the Administrator Back-End.<br><br>Return to site <a href=\'index.php\'>Home Page</a><br><br><img align=\'center\' src=\'images/password.png\' alt=\'\' width=\'92px\'>');
INSERT INTO `aphs_vocabulary` VALUES (4528,'vi','_USER_NAME','User name');
INSERT INTO `aphs_vocabulary` VALUES (4529,'vi','_USE_THIS_PASSWORD','Use this password');
INSERT INTO `aphs_vocabulary` VALUES (4530,'vi','_VALUE','Value');
INSERT INTO `aphs_vocabulary` VALUES (4531,'vi','_VAT','VAT');
INSERT INTO `aphs_vocabulary` VALUES (4532,'vi','_VAT_PERCENT','VAT Percent');
INSERT INTO `aphs_vocabulary` VALUES (4533,'vi','_VERSION','Version');
INSERT INTO `aphs_vocabulary` VALUES (3622,'vi','_CHILD','Child');
INSERT INTO `aphs_vocabulary` VALUES (3623,'vi','_CHILDREN','Children');
INSERT INTO `aphs_vocabulary` VALUES (2391,'en','_PASSWORD_IS_EMPTY','Passwords must not be empty and at least 6 characters!');
INSERT INTO `aphs_vocabulary` VALUES (4527,'vi','_USER_EXISTS_ALERT','User with such username already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (3620,'vi','_CHECK_OUT','Check Out');
INSERT INTO `aphs_vocabulary` VALUES (3621,'vi','_CHECK_STATUS','Check Status');
INSERT INTO `aphs_vocabulary` VALUES (2394,'en','_PASSWORD_NOT_CHANGED','Password was not changed. Please try again!');
INSERT INTO `aphs_vocabulary` VALUES (4526,'vi','_USER_EMAIL_EXISTS_ALERT','User with such email already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (3619,'vi','_CHECK_NOW','Check Now');
INSERT INTO `aphs_vocabulary` VALUES (2397,'en','_PASSWORD_RECOVERY_MSG','To recover your password, please enter your e-mail address and a link will be emailed to you.');
INSERT INTO `aphs_vocabulary` VALUES (4524,'vi','_USERNAME_LENGTH_ALERT','The length of username cannot be less than 4 characters! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4525,'vi','_USERS','Users');
INSERT INTO `aphs_vocabulary` VALUES (3617,'vi','_CHECK_AVAILABILITY','Check Availability');
INSERT INTO `aphs_vocabulary` VALUES (3618,'vi','_CHECK_IN','Check In');
INSERT INTO `aphs_vocabulary` VALUES (2400,'en','_PASSWORD_SUCCESSFULLY_SENT','Your password has been successfully sent to the email address.');
INSERT INTO `aphs_vocabulary` VALUES (4523,'vi','_USERNAME_EMPTY_ALERT','Username cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3615,'vi','_CHARGE_TYPE','Charge Type');
INSERT INTO `aphs_vocabulary` VALUES (3616,'vi','_CHECKOUT','Checkout');
INSERT INTO `aphs_vocabulary` VALUES (2403,'en','_PAST_TIME_ALERT','You cannot perform reservation in the past! Please re-enter dates.');
INSERT INTO `aphs_vocabulary` VALUES (4521,'vi','_USERNAME','Username');
INSERT INTO `aphs_vocabulary` VALUES (4522,'vi','_USERNAME_AND_PASSWORD','Username & Password');
INSERT INTO `aphs_vocabulary` VALUES (2406,'en','_PAYED_BY','Payed by');
INSERT INTO `aphs_vocabulary` VALUES (2409,'en','_PAYMENT','Payment');
INSERT INTO `aphs_vocabulary` VALUES (4520,'vi','_USED_ON','Used On');
INSERT INTO `aphs_vocabulary` VALUES (3614,'vi','_CHANGE_YOUR_PASSWORD','Change your password');
INSERT INTO `aphs_vocabulary` VALUES (2412,'en','_PAYMENTS','Payments');
INSERT INTO `aphs_vocabulary` VALUES (4519,'vi','_URL','URL');
INSERT INTO `aphs_vocabulary` VALUES (2415,'en','_PAYMENT_COMPANY_ACCOUNT','Payment Company Account');
INSERT INTO `aphs_vocabulary` VALUES (4518,'vi','_UPLOAD_FROM_FILE','Upload from File');
INSERT INTO `aphs_vocabulary` VALUES (3613,'vi','_CHANGE_ORDER','Change Order');
INSERT INTO `aphs_vocabulary` VALUES (2418,'en','_PAYMENT_DATE','Payment Date');
INSERT INTO `aphs_vocabulary` VALUES (2421,'en','_PAYMENT_DETAILS','Payment Details');
INSERT INTO `aphs_vocabulary` VALUES (4517,'vi','_UPLOAD_AND_PROCCESS','Upload and Process');
INSERT INTO `aphs_vocabulary` VALUES (3612,'vi','_CHANGE_CUSTOMER','Change Customer');
INSERT INTO `aphs_vocabulary` VALUES (2424,'en','_PAYMENT_ERROR','Payment error');
INSERT INTO `aphs_vocabulary` VALUES (4516,'vi','_UPLOAD','Upload');
INSERT INTO `aphs_vocabulary` VALUES (2427,'en','_PAYMENT_METHOD','Payment Method');
INSERT INTO `aphs_vocabulary` VALUES (2430,'en','_PAYMENT_REQUIRED','Payment Required');
INSERT INTO `aphs_vocabulary` VALUES (2433,'en','_PAYMENT_SUM','Payment Sum');
INSERT INTO `aphs_vocabulary` VALUES (4515,'vi','_UPDATING_OPERATION_COMPLETED','Updating operation was successfully completed!');
INSERT INTO `aphs_vocabulary` VALUES (2436,'en','_PAYMENT_TYPE','Payment Type');
INSERT INTO `aphs_vocabulary` VALUES (3611,'vi','_CHANGES_WERE_SAVED','Changes were successfully saved! Please refresh the <a href=index.php>Home Page</a> to see the results.');
INSERT INTO `aphs_vocabulary` VALUES (2439,'en','_PAYPAL','PayPal');
INSERT INTO `aphs_vocabulary` VALUES (3609,'vi','_CC_UNKNOWN_CARD_TYPE','Unknown card type! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3610,'vi','_CHANGES_SAVED','Changes were saved.');
INSERT INTO `aphs_vocabulary` VALUES (2442,'en','_PAYPAL_NOTICE','Save time. Pay securely using your stored payment information.<br />Pay with <b>credit card</b>, <b>bank account</b> or <b>PayPal</b> account balance.');
INSERT INTO `aphs_vocabulary` VALUES (4513,'vi','_UPDATING_ACCOUNT','Updating Account');
INSERT INTO `aphs_vocabulary` VALUES (4514,'vi','_UPDATING_ACCOUNT_ERROR','An error occurred while updating your account! Please try again later or send information about this error to administration of the site.');
INSERT INTO `aphs_vocabulary` VALUES (2445,'en','_PAYPAL_ORDER','PayPal Order');
INSERT INTO `aphs_vocabulary` VALUES (4512,'vi','_UP','Up');
INSERT INTO `aphs_vocabulary` VALUES (3608,'vi','_CC_NUMBER_INVALID','Credit card number is invalid! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2448,'en','_PAY_ON_ARRIVAL','Pay on Arrival');
INSERT INTO `aphs_vocabulary` VALUES (4511,'vi','_UNSUBSCRIBE','Unsubscribe');
INSERT INTO `aphs_vocabulary` VALUES (3607,'vi','_CC_NO_CARD_NUMBER_PROVIDED','No card number provided! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2451,'en','_PC_BILLING_INFORMATION_TEXT','billing information: address, city, country etc.');
INSERT INTO `aphs_vocabulary` VALUES (4509,'vi','_UNIT_PRICE','Unit Price');
INSERT INTO `aphs_vocabulary` VALUES (4510,'vi','_UNKNOWN','Unknown');
INSERT INTO `aphs_vocabulary` VALUES (2454,'en','_PC_BOOKING_DETAILS_TEXT','order details, list of purchased products etc.');
INSERT INTO `aphs_vocabulary` VALUES (4507,'vi','_UNINSTALL','Uninstall');
INSERT INTO `aphs_vocabulary` VALUES (4508,'vi','_UNITS','Units');
INSERT INTO `aphs_vocabulary` VALUES (3606,'vi','_CC_CARD_WRONG_LENGTH','Credit card number has a wrong length! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2457,'en','_PC_BOOKING_NUMBER_TEXT','the number of order');
INSERT INTO `aphs_vocabulary` VALUES (4506,'vi','_UNDEFINED','undefined');
INSERT INTO `aphs_vocabulary` VALUES (2460,'en','_PC_EVENT_TEXT','the title of event');
INSERT INTO `aphs_vocabulary` VALUES (4505,'vi','_UNCATEGORIZED','Uncategorized');
INSERT INTO `aphs_vocabulary` VALUES (3605,'vi','_CC_CARD_WRONG_EXPIRE_DATE','Credit card expiry date is wrong! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2463,'en','_PC_FIRST_NAME_TEXT','the first name of customer or admin');
INSERT INTO `aphs_vocabulary` VALUES (4504,'vi','_TYPE_CHARS','Type the characters you see in the picture');
INSERT INTO `aphs_vocabulary` VALUES (3604,'vi','_CC_CARD_NO_CVV_NUMBER','No CVV Code provided! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2466,'en','_PC_HOTEL_INFO_TEXT','information about hotel: name, address, telephone, fax etc.');
INSERT INTO `aphs_vocabulary` VALUES (4502,'vi','_TUESDAY','Tuesday');
INSERT INTO `aphs_vocabulary` VALUES (4503,'vi','_TYPE','Type');
INSERT INTO `aphs_vocabulary` VALUES (2469,'en','_PC_LAST_NAME_TEXT','the last name of customer or admin');
INSERT INTO `aphs_vocabulary` VALUES (4500,'vi','_TU','Tu');
INSERT INTO `aphs_vocabulary` VALUES (4501,'vi','_TUE','Tue');
INSERT INTO `aphs_vocabulary` VALUES (3603,'vi','_CC_CARD_INVALID_NUMBER','Credit card number is invalid! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2472,'en','_PC_PERSONAL_INFORMATION_TEXT','personal information of customer: first name, last name etc.');
INSERT INTO `aphs_vocabulary` VALUES (4499,'vi','_TRY_SYSTEM_SUGGESTION','Try out system suggestion');
INSERT INTO `aphs_vocabulary` VALUES (3602,'vi','_CC_CARD_INVALID_FORMAT','Credit card number has invalid format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2475,'en','_PC_REGISTRATION_CODE_TEXT','confirmation code for new account');
INSERT INTO `aphs_vocabulary` VALUES (4498,'vi','_TRY_LATER','An error occurred while executing. Please try again later!');
INSERT INTO `aphs_vocabulary` VALUES (2478,'en','_PC_STATUS_DESCRIPTION_TEXT','description of payment status');
INSERT INTO `aphs_vocabulary` VALUES (4497,'vi','_TRUNCATE_RELATED_TABLES','Truncate related tables?');
INSERT INTO `aphs_vocabulary` VALUES (3601,'vi','_CC_CARD_HOLDER_NAME_EMPTY','No card holder\'s name provided! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2481,'en','_PC_USER_EMAIL_TEXT','email of user');
INSERT INTO `aphs_vocabulary` VALUES (4496,'vi','_TRASH_PAGES','Trash Pages');
INSERT INTO `aphs_vocabulary` VALUES (3600,'vi','_CATEGORY_DESCRIPTION','Category Description');
INSERT INTO `aphs_vocabulary` VALUES (2484,'en','_PC_USER_NAME_TEXT','username (login) of user');
INSERT INTO `aphs_vocabulary` VALUES (4495,'vi','_TRASH','Trash');
INSERT INTO `aphs_vocabulary` VALUES (3599,'vi','_CATEGORY','Category');
INSERT INTO `aphs_vocabulary` VALUES (2487,'en','_PC_USER_PASSWORD_TEXT','password for customer or admin');
INSERT INTO `aphs_vocabulary` VALUES (4494,'vi','_TRANSLATE_VIA_GOOGLE','Translate via Google');
INSERT INTO `aphs_vocabulary` VALUES (3598,'vi','_CATEGORIES_MANAGEMENT','Categories Management');
INSERT INTO `aphs_vocabulary` VALUES (2490,'en','_PC_WEB_SITE_BASED_URL_TEXT','web site base url');
INSERT INTO `aphs_vocabulary` VALUES (4493,'vi','_TRANSACTION','Transaction');
INSERT INTO `aphs_vocabulary` VALUES (3597,'vi','_CATEGORIES','Categories');
INSERT INTO `aphs_vocabulary` VALUES (2493,'en','_PC_WEB_SITE_URL_TEXT','web site url');
INSERT INTO `aphs_vocabulary` VALUES (4492,'vi','_TOTAL_ROOMS','Total Rooms');
INSERT INTO `aphs_vocabulary` VALUES (2496,'en','_PC_YEAR_TEXT','current year in YYYY format');
INSERT INTO `aphs_vocabulary` VALUES (4491,'vi','_TOTAL_PRICE','Total Price');
INSERT INTO `aphs_vocabulary` VALUES (2499,'en','_PENDING','Pending');
INSERT INTO `aphs_vocabulary` VALUES (4490,'vi','_TOTAL','Total');
INSERT INTO `aphs_vocabulary` VALUES (3596,'vi','_CART_WAS_UPDATED','Reservation cart was successfully updated!');
INSERT INTO `aphs_vocabulary` VALUES (2502,'en','_PEOPLE_ARRIVING','People Arriving');
INSERT INTO `aphs_vocabulary` VALUES (4489,'vi','_TOP','Top');
INSERT INTO `aphs_vocabulary` VALUES (3595,'vi','_CAPACITY','Capacity');
INSERT INTO `aphs_vocabulary` VALUES (2505,'en','_PEOPLE_DEPARTING','People Departing');
INSERT INTO `aphs_vocabulary` VALUES (4488,'vi','_TODAY','Today');
INSERT INTO `aphs_vocabulary` VALUES (2508,'en','_PEOPLE_STAYING','People Staying');
INSERT INTO `aphs_vocabulary` VALUES (4487,'vi','_TO','To');
INSERT INTO `aphs_vocabulary` VALUES (3594,'vi','_CAN_USE_TAGS_MSG','You can use some HTML tags, such as');
INSERT INTO `aphs_vocabulary` VALUES (2511,'en','_PERFORM_OPERATION_COMMON_ALERT','Are you sure you want to perform this operation?');
INSERT INTO `aphs_vocabulary` VALUES (4486,'vi','_TIME_ZONE','Time Zone');
INSERT INTO `aphs_vocabulary` VALUES (3593,'vi','_CANCELED_BY_CUSTOMER','This booking was canceled by customer.');
INSERT INTO `aphs_vocabulary` VALUES (3592,'vi','_CANCELED_BY_ADMIN','This booking was canceled by administrator.');
INSERT INTO `aphs_vocabulary` VALUES (2516,'en','_PERSONAL_DETAILS','Personal Details');
INSERT INTO `aphs_vocabulary` VALUES (3591,'vi','_CANCELED','Canceled');
INSERT INTO `aphs_vocabulary` VALUES (2519,'en','_PERSONAL_INFORMATION','Personal Information');
INSERT INTO `aphs_vocabulary` VALUES (4485,'vi','_TIME_PERIOD_OVERLAPPING_ALERT','This period of time (fully or partially) was already selected! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (2522,'en','_PERSON_PER_NIGHT','Person/Per Night');
INSERT INTO `aphs_vocabulary` VALUES (4484,'vi','_THURSDAY','Thursday');
INSERT INTO `aphs_vocabulary` VALUES (2525,'en','_PER_NIGHT','Per Night');
INSERT INTO `aphs_vocabulary` VALUES (2528,'en','_PHONE','Phone');
INSERT INTO `aphs_vocabulary` VALUES (4483,'vi','_THUMBNAIL','Thumbnail');
INSERT INTO `aphs_vocabulary` VALUES (2531,'en','_PHONE_EMPTY_ALERT','Phone field cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4480,'vi','_TEXT','Text');
INSERT INTO `aphs_vocabulary` VALUES (4481,'vi','_TH','Th');
INSERT INTO `aphs_vocabulary` VALUES (4482,'vi','_THU','Thu');
INSERT INTO `aphs_vocabulary` VALUES (2534,'en','_PICK_DATE','Open calendar and pick a date');
INSERT INTO `aphs_vocabulary` VALUES (3590,'vi','_CAMPAIGNS_TOOLTIP','Global - allows booking for any date and runs (visible) within a defined period of time only\r\n\r\nTargeted - allows booking in a specified period of time only and runs (visible) till the first date is beginning');
INSERT INTO `aphs_vocabulary` VALUES (2537,'en','_PLACEMENT','Placement');
INSERT INTO `aphs_vocabulary` VALUES (2540,'en','_PLACE_ORDER','Place Order');
INSERT INTO `aphs_vocabulary` VALUES (2543,'en','_PLAY','Play');
INSERT INTO `aphs_vocabulary` VALUES (4479,'vi','_TEST_MODE_ALERT_SHORT','Attention: Reservation Cart is running in Test Mode!');
INSERT INTO `aphs_vocabulary` VALUES (3589,'vi','_CAMPAIGNS_MANAGEMENT','Campaigns Management');
INSERT INTO `aphs_vocabulary` VALUES (2546,'en','_POPULARITY','Popularity');
INSERT INTO `aphs_vocabulary` VALUES (3588,'vi','_CAMPAIGNS','Campaigns');
INSERT INTO `aphs_vocabulary` VALUES (2549,'en','_POPULAR_SEARCH','Popular Search');
INSERT INTO `aphs_vocabulary` VALUES (3587,'vi','_CACHING','Caching');
INSERT INTO `aphs_vocabulary` VALUES (2552,'en','_POSTED_ON','Posted on');
INSERT INTO `aphs_vocabulary` VALUES (3585,'vi','_BUTTON_UPDATE','Update');
INSERT INTO `aphs_vocabulary` VALUES (3586,'vi','_CACHE_LIFETIME','Cache Lifetime');
INSERT INTO `aphs_vocabulary` VALUES (2555,'en','_POST_COM_REGISTERED_ALERT','Your need to be registered to post comments.');
INSERT INTO `aphs_vocabulary` VALUES (4478,'vi','_TEST_MODE_ALERT','Test Mode in Reservation Cart is turned ON! To change current mode click <a href=index.php?admin=mod_booking_settings>here</a>.');
INSERT INTO `aphs_vocabulary` VALUES (3584,'vi','_BUTTON_SAVE_CHANGES','Save Changes');
INSERT INTO `aphs_vocabulary` VALUES (2558,'en','_PREDEFINED_CONSTANTS','Predefined Constants');
INSERT INTO `aphs_vocabulary` VALUES (4477,'vi','_TEST_EMAIL','Test Email');
INSERT INTO `aphs_vocabulary` VALUES (3583,'vi','_BUTTON_REWRITE','Rewrite Vocabulary');
INSERT INTO `aphs_vocabulary` VALUES (2561,'en','_PREFERRED_LANGUAGE','Preferred Language');
INSERT INTO `aphs_vocabulary` VALUES (2564,'en','_PREPARING','Preparing');
INSERT INTO `aphs_vocabulary` VALUES (4476,'vi','_TESTIMONIALS_SETTINGS','Testimonials Settings');
INSERT INTO `aphs_vocabulary` VALUES (3582,'vi','_BUTTON_RESET','Reset');
INSERT INTO `aphs_vocabulary` VALUES (2567,'en','_PREVIEW','Preview');
INSERT INTO `aphs_vocabulary` VALUES (3581,'vi','_BUTTON_LOGOUT','Logout');
INSERT INTO `aphs_vocabulary` VALUES (2570,'en','_PREVIOUS','Previous');
INSERT INTO `aphs_vocabulary` VALUES (3580,'vi','_BUTTON_LOGIN','Login');
INSERT INTO `aphs_vocabulary` VALUES (2573,'en','_PRE_PAYMENT','Pre-Payment');
INSERT INTO `aphs_vocabulary` VALUES (4475,'vi','_TESTIMONIALS_MANAGEMENT','Testimonials Management');
INSERT INTO `aphs_vocabulary` VALUES (2576,'en','_PRICE','Price');
INSERT INTO `aphs_vocabulary` VALUES (3579,'vi','_BUTTON_CREATE','Create');
INSERT INTO `aphs_vocabulary` VALUES (2579,'en','_PRICES','Prices');
INSERT INTO `aphs_vocabulary` VALUES (4474,'vi','_TESTIMONIALS','Testimonials');
INSERT INTO `aphs_vocabulary` VALUES (3578,'vi','_BUTTON_CHANGE_PASSWORD','Change Password');
INSERT INTO `aphs_vocabulary` VALUES (2582,'en','_PRICE_EMPTY_ALERT','Field price cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4473,'vi','_TERMS','Terms & Conditions');
INSERT INTO `aphs_vocabulary` VALUES (3577,'vi','_BUTTON_CHANGE','Change');
INSERT INTO `aphs_vocabulary` VALUES (2585,'en','_PRICE_FORMAT','Price Format');
INSERT INTO `aphs_vocabulary` VALUES (4472,'vi','_TEMPLATE_IS_EMPTY','Template cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3575,'vi','_BUTTON_BACK','Back');
INSERT INTO `aphs_vocabulary` VALUES (3576,'vi','_BUTTON_CANCEL','Cancel');
INSERT INTO `aphs_vocabulary` VALUES (2588,'en','_PRICE_FORMAT_ALERT','Allows to display prices for visitor in appropriate format');
INSERT INTO `aphs_vocabulary` VALUES (4471,'vi','_TEMPLATE_CODE','Template Code');
INSERT INTO `aphs_vocabulary` VALUES (3574,'vi','_BOTTOM','Bottom');
INSERT INTO `aphs_vocabulary` VALUES (2591,'en','_PRINT','Print');
INSERT INTO `aphs_vocabulary` VALUES (4470,'vi','_TEMPLATES_STYLES','Templates & Styles');
INSERT INTO `aphs_vocabulary` VALUES (2594,'en','_PRIVILEGES','Privileges');
INSERT INTO `aphs_vocabulary` VALUES (4469,'vi','_TAXES','Taxes');
INSERT INTO `aphs_vocabulary` VALUES (2597,'en','_PRIVILEGES_MANAGEMENT','Privileges Management');
INSERT INTO `aphs_vocabulary` VALUES (3573,'vi','_BOOK_ONE_NIGHT_ALERT','Sorry, but you must book at least one night.');
INSERT INTO `aphs_vocabulary` VALUES (2600,'en','_PRODUCT','Product');
INSERT INTO `aphs_vocabulary` VALUES (4468,'vi','_TARGET_GROUP','Target Group');
INSERT INTO `aphs_vocabulary` VALUES (3572,'vi','_BOOK_NOW','Book Now');
INSERT INTO `aphs_vocabulary` VALUES (2603,'en','_PRODUCTS','Products');
INSERT INTO `aphs_vocabulary` VALUES (4467,'vi','_TARGET','Target');
INSERT INTO `aphs_vocabulary` VALUES (2606,'en','_PRODUCTS_COUNT','Products count');
INSERT INTO `aphs_vocabulary` VALUES (2609,'en','_PRODUCTS_MANAGEMENT','Products Management');
INSERT INTO `aphs_vocabulary` VALUES (4466,'vi','_TAG_TITLE_IS_EMPTY','Tag &lt;TITLE&gt; cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3571,'vi','_BOOKING_WAS_COMPLETED_MSG','Thank you for reservation rooms in our hotel! Your booking has been completed.');
INSERT INTO `aphs_vocabulary` VALUES (2612,'en','_PRODUCT_DESCRIPTION','Product Description');
INSERT INTO `aphs_vocabulary` VALUES (4465,'vi','_TAG','Tag');
INSERT INTO `aphs_vocabulary` VALUES (2615,'en','_PROMO_AND_DISCOUNTS','Promo and Discounts');
INSERT INTO `aphs_vocabulary` VALUES (4464,'vi','_SYSTEM_TEMPLATE','System Template');
INSERT INTO `aphs_vocabulary` VALUES (3570,'vi','_BOOKING_WAS_CANCELED_MSG','Your booking has been canceled.');
INSERT INTO `aphs_vocabulary` VALUES (2618,'en','_PROMO_CODE_OR_COUPON','Promo Code or Discount Coupon');
INSERT INTO `aphs_vocabulary` VALUES (3569,'vi','_BOOKING_SUBTOTAL','Booking Subtotal');
INSERT INTO `aphs_vocabulary` VALUES (2621,'en','_PROMO_COUPON_NOTICE','If you have a promo code or discount coupon please enter it here');
INSERT INTO `aphs_vocabulary` VALUES (4462,'vi','_SYSTEM_MODULES','System Modules');
INSERT INTO `aphs_vocabulary` VALUES (4463,'vi','_SYSTEM_MODULE_ACTIONS_BLOCKED','All operations with system module are blocked!');
INSERT INTO `aphs_vocabulary` VALUES (3568,'vi','_BOOKING_STATUS','Booking Status');
INSERT INTO `aphs_vocabulary` VALUES (2624,'en','_PUBLIC','Public');
INSERT INTO `aphs_vocabulary` VALUES (2627,'en','_PUBLISHED','Published');
INSERT INTO `aphs_vocabulary` VALUES (4461,'vi','_SYSTEM_MODULE','System Module');
INSERT INTO `aphs_vocabulary` VALUES (3567,'vi','_BOOKING_SETTINGS','Booking Settings');
INSERT INTO `aphs_vocabulary` VALUES (2630,'en','_PUBLISH_YOUR_COMMENT','Publish your comment');
INSERT INTO `aphs_vocabulary` VALUES (2633,'en','_QTY','Qty');
INSERT INTO `aphs_vocabulary` VALUES (3566,'vi','_BOOKING_PRICE','Booking Price');
INSERT INTO `aphs_vocabulary` VALUES (2636,'en','_QUANTITY','Quantity');
INSERT INTO `aphs_vocabulary` VALUES (2639,'en','_QUESTION','Question');
INSERT INTO `aphs_vocabulary` VALUES (2642,'en','_QUESTIONS','Questions');
INSERT INTO `aphs_vocabulary` VALUES (3565,'vi','_BOOKING_NUMBER','Booking Number');
INSERT INTO `aphs_vocabulary` VALUES (2645,'en','_RATE','Rate');
INSERT INTO `aphs_vocabulary` VALUES (4460,'vi','_SYSTEM_EMAIL_DELETE_ALERT','This email template is used by the system and cannot be deleted!');
INSERT INTO `aphs_vocabulary` VALUES (3564,'vi','_BOOKING_DETAILS','Booking Details');
INSERT INTO `aphs_vocabulary` VALUES (2648,'en','_RATE_PER_NIGHT','Rate per night');
INSERT INTO `aphs_vocabulary` VALUES (4459,'vi','_SYSTEM','System');
INSERT INTO `aphs_vocabulary` VALUES (3563,'vi','_BOOKING_DESCRIPTION','Booking Description');
INSERT INTO `aphs_vocabulary` VALUES (2651,'en','_RATE_PER_NIGHT_AVG','Average rate per night');
INSERT INTO `aphs_vocabulary` VALUES (3562,'vi','_BOOKING_DATE','Booking Date');
INSERT INTO `aphs_vocabulary` VALUES (2654,'en','_REACTIVATION_EMAIL','Resend Activation Email');
INSERT INTO `aphs_vocabulary` VALUES (4458,'vi','_SYMBOL_PLACEMENT','Symbol Placement');
INSERT INTO `aphs_vocabulary` VALUES (2657,'en','_READY','Ready');
INSERT INTO `aphs_vocabulary` VALUES (4457,'vi','_SYMBOL','Symbol');
INSERT INTO `aphs_vocabulary` VALUES (3561,'vi','_BOOKING_COMPLETED','Booking Completed');
INSERT INTO `aphs_vocabulary` VALUES (2660,'en','_READ_MORE','Read more');
INSERT INTO `aphs_vocabulary` VALUES (2663,'en','_REASON','Reason');
INSERT INTO `aphs_vocabulary` VALUES (4456,'vi','_SWITCH_TO_NORMAL','Switch to Normal');
INSERT INTO `aphs_vocabulary` VALUES (2666,'en','_RECORD_WAS_DELETED_COMMON','The record was successfully deleted!');
INSERT INTO `aphs_vocabulary` VALUES (4455,'vi','_SWITCH_TO_EXPORT','Switch to Export');
INSERT INTO `aphs_vocabulary` VALUES (3560,'vi','_BOOKING_CANCELED_SUCCESS','The booking _BOOKING_ has been successfully canceled from the system!');
INSERT INTO `aphs_vocabulary` VALUES (2669,'en','_REFRESH','Refresh');
INSERT INTO `aphs_vocabulary` VALUES (4454,'vi','_SUNDAY','Sunday');
INSERT INTO `aphs_vocabulary` VALUES (2672,'en','_REFUNDED','Refunded');
INSERT INTO `aphs_vocabulary` VALUES (4453,'vi','_SUN','Sun');
INSERT INTO `aphs_vocabulary` VALUES (3559,'vi','_BOOKING_CANCELED','Booking Canceled');
INSERT INTO `aphs_vocabulary` VALUES (2675,'en','_REGISTERED','Registered');
INSERT INTO `aphs_vocabulary` VALUES (4452,'vi','_SUBTOTAL','Subtotal');
INSERT INTO `aphs_vocabulary` VALUES (2678,'en','_REGISTERED_FROM_IP','Registered from IP');
INSERT INTO `aphs_vocabulary` VALUES (4451,'vi','_SUBSCRIPTION_MANAGEMENT','Subscription Management');
INSERT INTO `aphs_vocabulary` VALUES (3558,'vi','_BOOKINGS_SETTINGS','Booking Settings');
INSERT INTO `aphs_vocabulary` VALUES (2681,'en','_REGISTRATIONS','Registrations');
INSERT INTO `aphs_vocabulary` VALUES (3557,'vi','_BOOKINGS_MANAGEMENT','Bookings Management');
INSERT INTO `aphs_vocabulary` VALUES (2684,'en','_REGISTRATION_CODE','Registration code');
INSERT INTO `aphs_vocabulary` VALUES (3556,'vi','_BOOKINGS','Bookings');
INSERT INTO `aphs_vocabulary` VALUES (2687,'en','_REGISTRATION_CONFIRMATION','Registration Confirmation');
INSERT INTO `aphs_vocabulary` VALUES (4450,'vi','_SUBSCRIPTION_ALREADY_SENT','You have already subscribed to our newsletter. Please try again later or wait _WAIT_ seconds.');
INSERT INTO `aphs_vocabulary` VALUES (3555,'vi','_BOOKING','Booking');
INSERT INTO `aphs_vocabulary` VALUES (2690,'en','_REGISTRATION_FORM','Registration Form');
INSERT INTO `aphs_vocabulary` VALUES (3552,'vi','_BIRTH_DATE','Birth Date');
INSERT INTO `aphs_vocabulary` VALUES (3553,'vi','_BIRTH_DATE_VALID_ALERT','Birth date was entered in wrong format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3554,'vi','_BOOK','Book');
INSERT INTO `aphs_vocabulary` VALUES (2693,'en','_REGISTRATION_NOT_COMPLETED','Your registration process is not yet complete! Please check again your email for further instructions or click <a href=index.php?customer=resend_activation>here</a> to resend them again.');
INSERT INTO `aphs_vocabulary` VALUES (4447,'vi','_SUBSCRIBE','Subscribe');
INSERT INTO `aphs_vocabulary` VALUES (4448,'vi','_SUBSCRIBE_EMAIL_EXISTS_ALERT','Someone with such email has already been subscribed to our newsletter. Please choose another email address for subscription.');
INSERT INTO `aphs_vocabulary` VALUES (4449,'vi','_SUBSCRIBE_TO_NEWSLETTER','Newsletter Subscription');
INSERT INTO `aphs_vocabulary` VALUES (3551,'vi','_BILLING_DETAILS_UPDATED','Your Billing Details has been updated.');
INSERT INTO `aphs_vocabulary` VALUES (2696,'en','_REMEMBER_ME','Remember Me');
INSERT INTO `aphs_vocabulary` VALUES (4446,'vi','_SUBMIT_PAYMENT','Submit Payment');
INSERT INTO `aphs_vocabulary` VALUES (2699,'en','_REMOVE','Remove');
INSERT INTO `aphs_vocabulary` VALUES (3550,'vi','_BILLING_DETAILS','Billing Details');
INSERT INTO `aphs_vocabulary` VALUES (2702,'en','_REMOVED','Removed');
INSERT INTO `aphs_vocabulary` VALUES (4445,'vi','_SUBMIT_BOOKING','Submit Booking');
INSERT INTO `aphs_vocabulary` VALUES (3549,'vi','_BILLING_ADDRESS','Billing Address');
INSERT INTO `aphs_vocabulary` VALUES (2705,'en','_REMOVE_ACCOUNT','Remove Account');
INSERT INTO `aphs_vocabulary` VALUES (4444,'vi','_SUBMIT','Submit');
INSERT INTO `aphs_vocabulary` VALUES (3548,'vi','_BEDS','Beds');
INSERT INTO `aphs_vocabulary` VALUES (2708,'en','_REMOVE_ACCOUNT_ALERT','Are you sure you want to remove your account?');
INSERT INTO `aphs_vocabulary` VALUES (4443,'vi','_SUBJECT_EMPTY_ALERT','Subject cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (3547,'vi','_BATHROOMS','Bathrooms');
INSERT INTO `aphs_vocabulary` VALUES (2711,'en','_REMOVE_ACCOUNT_WARNING','If you don\'t think you will use this site again and would like your account deleted, we can take care of this for you. Keep in mind, that you will not be able to reactivate your account or retrieve any of the content or information that was added. If you would like your account deleted, then click Remove button');
INSERT INTO `aphs_vocabulary` VALUES (4436,'vi','_STATE','State');
INSERT INTO `aphs_vocabulary` VALUES (4437,'vi','_STATE_PROVINCE','State/Province');
INSERT INTO `aphs_vocabulary` VALUES (4438,'vi','_STATISTICS','Statistics');
INSERT INTO `aphs_vocabulary` VALUES (4439,'vi','_STATUS','Status');
INSERT INTO `aphs_vocabulary` VALUES (4440,'vi','_STOP','Stop');
INSERT INTO `aphs_vocabulary` VALUES (4441,'vi','_SU','Su');
INSERT INTO `aphs_vocabulary` VALUES (4442,'vi','_SUBJECT','Subject');
INSERT INTO `aphs_vocabulary` VALUES (3544,'vi','_BANNER_IMAGE','Banner Image');
INSERT INTO `aphs_vocabulary` VALUES (3545,'vi','_BAN_ITEM','Ban Item');
INSERT INTO `aphs_vocabulary` VALUES (3546,'vi','_BAN_LIST','Ban List');
INSERT INTO `aphs_vocabulary` VALUES (2714,'en','_REMOVE_LAST_COUNTRY_ALERT','The country selected has not been deleted, because you must have at least one active country for correct work of the site!');
INSERT INTO `aphs_vocabulary` VALUES (4433,'vi','_STARS_5_1','5 stars to 1 star');
INSERT INTO `aphs_vocabulary` VALUES (4434,'vi','_START_DATE','Start Date');
INSERT INTO `aphs_vocabulary` VALUES (4435,'vi','_START_FINISH_DATE_ERROR','Finish date must be later than start date! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2717,'en','_REMOVE_ROOM_FROM_CART','Remove room from the cart');
INSERT INTO `aphs_vocabulary` VALUES (4432,'vi','_STARS_1_5','1 star to 5 stars');
INSERT INTO `aphs_vocabulary` VALUES (3543,'vi','_BANNERS_SETTINGS','Banners Settings');
INSERT INTO `aphs_vocabulary` VALUES (2720,'en','_REPORTS','Reports');
INSERT INTO `aphs_vocabulary` VALUES (4431,'vi','_STARS','Stars');
INSERT INTO `aphs_vocabulary` VALUES (3542,'vi','_BANNERS_MANAGEMENT','Banners Management');
INSERT INTO `aphs_vocabulary` VALUES (2723,'en','_RESEND_ACTIVATION_EMAIL','Resend Activation Email');
INSERT INTO `aphs_vocabulary` VALUES (4430,'vi','_STANDARD_PRICE','Standard Price');
INSERT INTO `aphs_vocabulary` VALUES (3539,'vi','_BANK_PAYMENT_INFO','Bank Payment Information');
INSERT INTO `aphs_vocabulary` VALUES (3540,'vi','_BANK_TRANSFER','Bank Transfer');
INSERT INTO `aphs_vocabulary` VALUES (3541,'vi','_BANNERS','Banners');
INSERT INTO `aphs_vocabulary` VALUES (2726,'en','_RESEND_ACTIVATION_EMAIL_MSG','Please enter your email address then click on Send button. You will receive the activation email shortly.');
INSERT INTO `aphs_vocabulary` VALUES (4426,'vi','_SMTP_SECURE','SMTP Secure');
INSERT INTO `aphs_vocabulary` VALUES (4427,'vi','_SORT_BY','Sort by');
INSERT INTO `aphs_vocabulary` VALUES (4428,'vi','_STANDARD','Standard');
INSERT INTO `aphs_vocabulary` VALUES (4429,'vi','_STANDARD_CAMPAIGN','Targeting Period Campaign');
INSERT INTO `aphs_vocabulary` VALUES (2729,'en','_RESERVATION','Reservation');
INSERT INTO `aphs_vocabulary` VALUES (4425,'vi','_SMTP_PORT','SMTP Port');
INSERT INTO `aphs_vocabulary` VALUES (3538,'vi','_BACK_TO_ADMIN_PANEL','Back to Admin Panel');
INSERT INTO `aphs_vocabulary` VALUES (2732,'en','_RESERVATIONS','Reservations');
INSERT INTO `aphs_vocabulary` VALUES (4424,'vi','_SMTP_HOST','SMTP Host');
INSERT INTO `aphs_vocabulary` VALUES (2735,'en','_RESERVATION_CART','Reservation Cart');
INSERT INTO `aphs_vocabulary` VALUES (4423,'vi','_SITE_SETTINGS','Site Settings');
INSERT INTO `aphs_vocabulary` VALUES (3537,'vi','_BACKUP_YOUR_INSTALLATION','Backup your current Installation');
INSERT INTO `aphs_vocabulary` VALUES (2738,'en','_RESERVATION_CART_IS_EMPTY_ALERT','Your reservation cart is empty!');
INSERT INTO `aphs_vocabulary` VALUES (4421,'vi','_SITE_RANKS','Site Ranks');
INSERT INTO `aphs_vocabulary` VALUES (4422,'vi','_SITE_RSS','Site RSS');
INSERT INTO `aphs_vocabulary` VALUES (2741,'en','_RESERVATION_DETAILS','Reservation Details');
INSERT INTO `aphs_vocabulary` VALUES (3536,'vi','_BACKUP_WAS_RESTORED','Backup _FILE_NAME_ was successfully restored.');
INSERT INTO `aphs_vocabulary` VALUES (2744,'en','_RESERVED','Reserved');
INSERT INTO `aphs_vocabulary` VALUES (4420,'vi','_SITE_PREVIEW','Site Preview');
INSERT INTO `aphs_vocabulary` VALUES (2747,'en','_RESET','Reset');
INSERT INTO `aphs_vocabulary` VALUES (2750,'en','_RESET_ACCOUNT','Reset Account');
INSERT INTO `aphs_vocabulary` VALUES (3535,'vi','_BACKUP_WAS_DELETED','Backup _FILE_NAME_ was successfully deleted.');
INSERT INTO `aphs_vocabulary` VALUES (2753,'en','_RESTAURANT','Restaurant');
INSERT INTO `aphs_vocabulary` VALUES (2756,'en','_RESTORE','Restore');
INSERT INTO `aphs_vocabulary` VALUES (4419,'vi','_SITE_OFFLINE_MESSAGE_ALERT','A message that displays in the Front-end if your site is offline');
INSERT INTO `aphs_vocabulary` VALUES (2759,'en','_RETYPE_PASSWORD','Retype Password');
INSERT INTO `aphs_vocabulary` VALUES (3534,'vi','_BACKUP_WAS_CREATED','Backup _FILE_NAME_ was successfully created.');
INSERT INTO `aphs_vocabulary` VALUES (2762,'en','_RIGHT','Right');
INSERT INTO `aphs_vocabulary` VALUES (2765,'en','_RIGHT_TO_LEFT','RTL (right-to-left)');
INSERT INTO `aphs_vocabulary` VALUES (3533,'vi','_BACKUP_RESTORING_ERROR','An error occurred while restoring file! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (2768,'en','_ROLES_AND_PRIVILEGES','Roles & Privileges');
INSERT INTO `aphs_vocabulary` VALUES (4418,'vi','_SITE_OFFLINE_ALERT','Select whether access to the Site Front-end is available. If Yes, the Front-End will display the message below');
INSERT INTO `aphs_vocabulary` VALUES (2771,'en','_ROLES_MANAGEMENT','Roles Management');
INSERT INTO `aphs_vocabulary` VALUES (4417,'vi','_SITE_OFFLINE','Site Offline');
INSERT INTO `aphs_vocabulary` VALUES (2774,'en','_ROOMS','Rooms');
INSERT INTO `aphs_vocabulary` VALUES (4416,'vi','_SITE_INFO','Site Info');
INSERT INTO `aphs_vocabulary` VALUES (3532,'vi','_BACKUP_RESTORE_NOTE','Remember: this action will rewrite all your current settings!');
INSERT INTO `aphs_vocabulary` VALUES (2777,'en','_ROOMS_AVAILABILITY','Rooms Availability');
INSERT INTO `aphs_vocabulary` VALUES (2780,'en','_ROOMS_COUNT','Number of Rooms (in the Hotel)');
INSERT INTO `aphs_vocabulary` VALUES (3531,'vi','_BACKUP_RESTORE_ALERT','Are you sure you want to restore this backup');
INSERT INTO `aphs_vocabulary` VALUES (2783,'en','_ROOMS_FACILITIES','Rooms Facilities');
INSERT INTO `aphs_vocabulary` VALUES (2786,'en','_ROOMS_LAST','last room');
INSERT INTO `aphs_vocabulary` VALUES (4415,'vi','_SITE_DEVELOPMENT_MODE_ALERT','The site is running in Development Mode! To turn it off change <b>SITE_MODE</b> value in <b>inc/settings.inc.php</b>');
INSERT INTO `aphs_vocabulary` VALUES (3530,'vi','_BACKUP_RESTORE','Backup Restore');
INSERT INTO `aphs_vocabulary` VALUES (2789,'en','_ROOMS_LEFT','rooms left');
INSERT INTO `aphs_vocabulary` VALUES (4414,'vi','_SIMPLE','Simple');
INSERT INTO `aphs_vocabulary` VALUES (2792,'en','_ROOMS_MANAGEMENT','Rooms Management');
INSERT INTO `aphs_vocabulary` VALUES (4413,'vi','_SHOW_META_TAGS','Show META tags');
INSERT INTO `aphs_vocabulary` VALUES (3529,'vi','_BACKUP_INSTALLATION','Backup Installation');
INSERT INTO `aphs_vocabulary` VALUES (2795,'en','_ROOMS_OCCUPANCY','Rooms Occupancy');
INSERT INTO `aphs_vocabulary` VALUES (4412,'vi','_SHOW_IN_SEARCH','Show in Search');
INSERT INTO `aphs_vocabulary` VALUES (2798,'en','_ROOMS_RESERVATION','Rooms Reservation');
INSERT INTO `aphs_vocabulary` VALUES (4411,'vi','_SHOW','Show');
INSERT INTO `aphs_vocabulary` VALUES (2801,'en','_ROOMS_SETTINGS','Rooms Settings');
INSERT INTO `aphs_vocabulary` VALUES (2804,'en','_ROOM_AREA','Room Area');
INSERT INTO `aphs_vocabulary` VALUES (4410,'vi','_SHORT_DESCRIPTION','Short Description');
INSERT INTO `aphs_vocabulary` VALUES (2807,'en','_ROOM_DESCRIPTION','Room Description');
INSERT INTO `aphs_vocabulary` VALUES (4409,'vi','_SET_TIME','Set Time');
INSERT INTO `aphs_vocabulary` VALUES (3528,'vi','_BACKUP_EXECUTING_ERROR','An error occurred while backup the system! Please check write permissions to backup folder or try again later.');
INSERT INTO `aphs_vocabulary` VALUES (2810,'en','_ROOM_DETAILS','Room Details');
INSERT INTO `aphs_vocabulary` VALUES (4408,'vi','_SET_DATE','Set date');
INSERT INTO `aphs_vocabulary` VALUES (2813,'en','_ROOM_FACILITIES','Room Facilities');
INSERT INTO `aphs_vocabulary` VALUES (4407,'vi','_SET_ADMIN','Set Admin');
INSERT INTO `aphs_vocabulary` VALUES (3527,'vi','_BACKUP_EMPTY_NAME_ALERT','Name of backup file cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (2816,'en','_ROOM_FACILITIES_MANAGEMENT','Room Facilities Management');
INSERT INTO `aphs_vocabulary` VALUES (3526,'vi','_BACKUP_EMPTY_MSG','No existing backups found.');
INSERT INTO `aphs_vocabulary` VALUES (2819,'en','_ROOM_NOT_FOUND','Room was not found!');
INSERT INTO `aphs_vocabulary` VALUES (4406,'vi','_SETTINGS_SAVED','Changes were saved! Please refresh the <a href=index.php>Home Page</a> to see the results.');
INSERT INTO `aphs_vocabulary` VALUES (2822,'en','_ROOM_NUMBERS','Room Numbers');
INSERT INTO `aphs_vocabulary` VALUES (4405,'vi','_SETTINGS','Settings');
INSERT INTO `aphs_vocabulary` VALUES (2825,'en','_ROOM_PRICE','Room Price');
INSERT INTO `aphs_vocabulary` VALUES (4404,'vi','_SERVICES','Services');
INSERT INTO `aphs_vocabulary` VALUES (3525,'vi','_BACKUP_DELETE_ALERT','Are you sure you want to delete this backup?');
INSERT INTO `aphs_vocabulary` VALUES (2828,'en','_ROOM_PRICES_WERE_ADDED','Room prices for new period were successfully added!');
INSERT INTO `aphs_vocabulary` VALUES (4402,'vi','_SERVER_LOCALE','Server Locale');
INSERT INTO `aphs_vocabulary` VALUES (4403,'vi','_SERVICE','Service');
INSERT INTO `aphs_vocabulary` VALUES (3524,'vi','_BACKUP_CHOOSE_MSG','Choose a backup from the list below');
INSERT INTO `aphs_vocabulary` VALUES (2831,'en','_ROOM_TYPE','Room Type');
INSERT INTO `aphs_vocabulary` VALUES (4401,'vi','_SERVER_INFO','Server Info');
INSERT INTO `aphs_vocabulary` VALUES (3523,'vi','_BACKUP_AND_RESTORE','Backup & Restore');
INSERT INTO `aphs_vocabulary` VALUES (2834,'en','_ROOM_WAS_ADDED','Room was successfully added to your reservation!');
INSERT INTO `aphs_vocabulary` VALUES (4400,'vi','_SEPTEMBER','September');
INSERT INTO `aphs_vocabulary` VALUES (3521,'vi','_BACKUP','Backup');
INSERT INTO `aphs_vocabulary` VALUES (3522,'vi','_BACKUPS_EXISTING','Existing Backups');
INSERT INTO `aphs_vocabulary` VALUES (2837,'en','_ROOM_WAS_REMOVED','Selected room was successfully removed from your Reservation Cart!');
INSERT INTO `aphs_vocabulary` VALUES (4399,'vi','_SEO_URLS','SEO URLs');
INSERT INTO `aphs_vocabulary` VALUES (2840,'en','_ROWS','Rows');
INSERT INTO `aphs_vocabulary` VALUES (3520,'vi','_AVAILABLE_ROOMS','Available Rooms');
INSERT INTO `aphs_vocabulary` VALUES (2843,'en','_RSS_FEED_TYPE','RSS Feed Type');
INSERT INTO `aphs_vocabulary` VALUES (3519,'vi','_AVAILABLE','available');
INSERT INTO `aphs_vocabulary` VALUES (2846,'en','_RSS_FILE_ERROR','Cannot open RSS file to add new item! Please check your access rights to <b>feeds/</b> directory or try again later.');
INSERT INTO `aphs_vocabulary` VALUES (4395,'vi','_SENDING','Sending');
INSERT INTO `aphs_vocabulary` VALUES (4396,'vi','_SEND_COPY_TO_ADMIN','Send a copy to admin');
INSERT INTO `aphs_vocabulary` VALUES (4397,'vi','_SEND_INVOICE','Send Invoice');
INSERT INTO `aphs_vocabulary` VALUES (4398,'vi','_SEO_LINKS_ALERT','If you select this option, make sure SEO Links Section uncommented in .htaccess file');
INSERT INTO `aphs_vocabulary` VALUES (2849,'en','_RUN_CRON','Run cron');
INSERT INTO `aphs_vocabulary` VALUES (4394,'vi','_SEND','Send');
INSERT INTO `aphs_vocabulary` VALUES (2852,'en','_RUN_EVERY','Run every');
INSERT INTO `aphs_vocabulary` VALUES (2855,'en','_SA','Sa');
INSERT INTO `aphs_vocabulary` VALUES (2858,'en','_SAID','said');
INSERT INTO `aphs_vocabulary` VALUES (2861,'en','_SAT','Sat');
INSERT INTO `aphs_vocabulary` VALUES (2864,'en','_SATURDAY','Saturday');
INSERT INTO `aphs_vocabulary` VALUES (4393,'vi','_SELECT_REPORT_ALERT','Please select a report type!');
INSERT INTO `aphs_vocabulary` VALUES (2867,'en','_SEARCH','Search');
INSERT INTO `aphs_vocabulary` VALUES (3518,'vi','_AVAILABILITY_ROOMS_NOTE','Define a maximum number of rooms available for booking for a specified day or date range (maximum availability _MAX_ rooms)<br>To edit room availability simply change the value in a day cell and then click \'Save Changes\' button');
INSERT INTO `aphs_vocabulary` VALUES (2870,'en','_SEARCH_KEYWORDS','search keywords');
INSERT INTO `aphs_vocabulary` VALUES (4392,'vi','_SELECT_LOCATION','Select Location');
INSERT INTO `aphs_vocabulary` VALUES (3517,'vi','_AVAILABILITY','Availability');
INSERT INTO `aphs_vocabulary` VALUES (2873,'en','_SEARCH_RESULT_FOR','Search Results for');
INSERT INTO `aphs_vocabulary` VALUES (4391,'vi','_SELECT_LANG_TO_UPDATE','Select a language to update');
INSERT INTO `aphs_vocabulary` VALUES (3513,'vi','_AUGUST','August');
INSERT INTO `aphs_vocabulary` VALUES (3514,'vi','_AUTHENTICATION','Authentication');
INSERT INTO `aphs_vocabulary` VALUES (3515,'vi','_AUTHORIZE_NET_NOTICE','The Authorize.Net payment gateway service provider.');
INSERT INTO `aphs_vocabulary` VALUES (3516,'vi','_AUTHORIZE_NET_ORDER','Authorize.Net Order');
INSERT INTO `aphs_vocabulary` VALUES (2876,'en','_SEARCH_ROOM_TIPS','<b>Find more rooms by expanding your search options</b>:<br>- Reduce the number of adults in room to get more results<br>- Reduce the number of children in room to get more results<br>- Change your Check-in/Check-out dates<br>');
INSERT INTO `aphs_vocabulary` VALUES (4386,'vi','_SEC','Sec');
INSERT INTO `aphs_vocabulary` VALUES (4387,'vi','_SELECT','select');
INSERT INTO `aphs_vocabulary` VALUES (4388,'vi','_SELECTED_ROOMS','Selected Rooms');
INSERT INTO `aphs_vocabulary` VALUES (4389,'vi','_SELECT_FILE_TO_UPLOAD','Select a file to upload');
INSERT INTO `aphs_vocabulary` VALUES (4390,'vi','_SELECT_HOTEL','Select Hotel');
INSERT INTO `aphs_vocabulary` VALUES (3512,'vi','_ARTICLE_ID','Article ID');
INSERT INTO `aphs_vocabulary` VALUES (2879,'en','_SEC','Sec');
INSERT INTO `aphs_vocabulary` VALUES (3511,'vi','_ARTICLE','Article');
INSERT INTO `aphs_vocabulary` VALUES (2882,'en','_SELECT','select');
INSERT INTO `aphs_vocabulary` VALUES (3510,'vi','_APRIL','April');
INSERT INTO `aphs_vocabulary` VALUES (2885,'en','_SELECTED_ROOMS','Selected Rooms');
INSERT INTO `aphs_vocabulary` VALUES (3509,'vi','_APPROVED','Approved');
INSERT INTO `aphs_vocabulary` VALUES (2888,'en','_SELECT_FILE_TO_UPLOAD','Select a file to upload');
INSERT INTO `aphs_vocabulary` VALUES (3508,'vi','_APPROVE','Approve');
INSERT INTO `aphs_vocabulary` VALUES (2891,'en','_SELECT_HOTEL','Select Hotel');
INSERT INTO `aphs_vocabulary` VALUES (3507,'vi','_APPLY_TO_ALL_PAGES','Apply changes to all pages');
INSERT INTO `aphs_vocabulary` VALUES (2894,'en','_SELECT_LANG_TO_UPDATE','Select a language to update');
INSERT INTO `aphs_vocabulary` VALUES (4385,'vi','_SEARCH_ROOM_TIPS','<b>Find more rooms by expanding your search options</b>:<br>- Reduce the number of adults in room to get more results<br>- Reduce the number of children in room to get more results<br>- Change your Check-in/Check-out dates<br>');
INSERT INTO `aphs_vocabulary` VALUES (2897,'en','_SELECT_LOCATION','Select Location');
INSERT INTO `aphs_vocabulary` VALUES (4384,'vi','_SEARCH_RESULT_FOR','Search Results for');
INSERT INTO `aphs_vocabulary` VALUES (3505,'vi','_APPLY','Apply');
INSERT INTO `aphs_vocabulary` VALUES (3506,'vi','_APPLY_TO_ALL_LANGUAGES','Apply to all languages');
INSERT INTO `aphs_vocabulary` VALUES (2900,'en','_SELECT_REPORT_ALERT','Please select a report type!');
INSERT INTO `aphs_vocabulary` VALUES (3504,'vi','_ANY','Any');
INSERT INTO `aphs_vocabulary` VALUES (2903,'en','_SEND','Send');
INSERT INTO `aphs_vocabulary` VALUES (4383,'vi','_SEARCH_KEYWORDS','search keywords');
INSERT INTO `aphs_vocabulary` VALUES (3503,'vi','_ANSWER','Answer');
INSERT INTO `aphs_vocabulary` VALUES (2906,'en','_SENDING','Sending');
INSERT INTO `aphs_vocabulary` VALUES (4382,'vi','_SEARCH','Search');
INSERT INTO `aphs_vocabulary` VALUES (3502,'vi','_AMOUNT','Amount');
INSERT INTO `aphs_vocabulary` VALUES (2909,'en','_SEND_COPY_TO_ADMIN','Send a copy to admin');
INSERT INTO `aphs_vocabulary` VALUES (4381,'vi','_SATURDAY','Saturday');
INSERT INTO `aphs_vocabulary` VALUES (2912,'en','_SEND_INVOICE','Send Invoice');
INSERT INTO `aphs_vocabulary` VALUES (4380,'vi','_SAT','Sat');
INSERT INTO `aphs_vocabulary` VALUES (3501,'vi','_ALREADY_LOGGED','You are already logged in!');
INSERT INTO `aphs_vocabulary` VALUES (2915,'en','_SEO_LINKS_ALERT','If you select this option, make sure SEO Links Section uncommented in .htaccess file');
INSERT INTO `aphs_vocabulary` VALUES (4377,'vi','_RUN_EVERY','Run every');
INSERT INTO `aphs_vocabulary` VALUES (4378,'vi','_SA','Sa');
INSERT INTO `aphs_vocabulary` VALUES (4379,'vi','_SAID','said');
INSERT INTO `aphs_vocabulary` VALUES (2918,'en','_SEO_URLS','SEO URLs');
INSERT INTO `aphs_vocabulary` VALUES (4376,'vi','_RUN_CRON','Run cron');
INSERT INTO `aphs_vocabulary` VALUES (2921,'en','_SEPTEMBER','September');
INSERT INTO `aphs_vocabulary` VALUES (2924,'en','_SERVER_INFO','Server Info');
INSERT INTO `aphs_vocabulary` VALUES (2927,'en','_SERVER_LOCALE','Server Locale');
INSERT INTO `aphs_vocabulary` VALUES (3500,'vi','_ALREADY_HAVE_ACCOUNT','Already have an account? <a href=\'index.php?customer=login\'>Login here</a>');
INSERT INTO `aphs_vocabulary` VALUES (2930,'en','_SERVICE','Service');
INSERT INTO `aphs_vocabulary` VALUES (2933,'en','_SERVICES','Services');
INSERT INTO `aphs_vocabulary` VALUES (3499,'vi','_ALL_AVAILABLE','All Available');
INSERT INTO `aphs_vocabulary` VALUES (2936,'en','_SETTINGS','Settings');
INSERT INTO `aphs_vocabulary` VALUES (4375,'vi','_RSS_FILE_ERROR','Cannot open RSS file to add new item! Please check your access rights to <b>feeds/</b> directory or try again later.');
INSERT INTO `aphs_vocabulary` VALUES (3496,'vi','_ALL','All');
INSERT INTO `aphs_vocabulary` VALUES (3497,'vi','_ALLOW','Allow');
INSERT INTO `aphs_vocabulary` VALUES (3498,'vi','_ALLOW_COMMENTS','Allow comments');
INSERT INTO `aphs_vocabulary` VALUES (2939,'en','_SETTINGS_SAVED','Changes were saved! Please refresh the <a href=index.php>Home Page</a> to see the results.');
INSERT INTO `aphs_vocabulary` VALUES (4373,'vi','_ROWS','Rows');
INSERT INTO `aphs_vocabulary` VALUES (4374,'vi','_RSS_FEED_TYPE','RSS Feed Type');
INSERT INTO `aphs_vocabulary` VALUES (2942,'en','_SET_ADMIN','Set Admin');
INSERT INTO `aphs_vocabulary` VALUES (2945,'en','_SET_DATE','Set date');
INSERT INTO `aphs_vocabulary` VALUES (4372,'vi','_ROOM_WAS_REMOVED','Selected room was successfully removed from your Reservation Cart!');
INSERT INTO `aphs_vocabulary` VALUES (3495,'vi','_ALERT_REQUIRED_FILEDS','Items marked with an asterisk (*) are required');
INSERT INTO `aphs_vocabulary` VALUES (2948,'en','_SET_TIME','Set Time');
INSERT INTO `aphs_vocabulary` VALUES (2951,'en','_SHORT_DESCRIPTION','Short Description');
INSERT INTO `aphs_vocabulary` VALUES (2954,'en','_SHOW','Show');
INSERT INTO `aphs_vocabulary` VALUES (4371,'vi','_ROOM_WAS_ADDED','Room was successfully added to your reservation!');
INSERT INTO `aphs_vocabulary` VALUES (3494,'vi','_ALERT_CANCEL_BOOKING','Are you sure you want to cancel this booking?');
INSERT INTO `aphs_vocabulary` VALUES (2957,'en','_SHOW_IN_SEARCH','Show in Search');
INSERT INTO `aphs_vocabulary` VALUES (4370,'vi','_ROOM_TYPE','Room Type');
INSERT INTO `aphs_vocabulary` VALUES (2960,'en','_SHOW_META_TAGS','Show META tags');
INSERT INTO `aphs_vocabulary` VALUES (3493,'vi','_ALBUM_NAME','Album Name');
INSERT INTO `aphs_vocabulary` VALUES (2963,'en','_SIMPLE','Simple');
INSERT INTO `aphs_vocabulary` VALUES (3490,'vi','_AGREE_CONF_TEXT','I have read and AGREE with Terms & Conditions');
INSERT INTO `aphs_vocabulary` VALUES (3491,'vi','_ALBUM','Album');
INSERT INTO `aphs_vocabulary` VALUES (3492,'vi','_ALBUM_CODE','Album Code');
INSERT INTO `aphs_vocabulary` VALUES (2966,'en','_SITE_DEVELOPMENT_MODE_ALERT','The site is running in Development Mode! To turn it off change <b>SITE_MODE</b> value in <b>inc/settings.inc.php</b>');
INSERT INTO `aphs_vocabulary` VALUES (4367,'vi','_ROOM_NUMBERS','Room Numbers');
INSERT INTO `aphs_vocabulary` VALUES (4368,'vi','_ROOM_PRICE','Room Price');
INSERT INTO `aphs_vocabulary` VALUES (4369,'vi','_ROOM_PRICES_WERE_ADDED','Room prices for new period were successfully added!');
INSERT INTO `aphs_vocabulary` VALUES (2969,'en','_SITE_INFO','Site Info');
INSERT INTO `aphs_vocabulary` VALUES (4366,'vi','_ROOM_NOT_FOUND','Room was not found!');
INSERT INTO `aphs_vocabulary` VALUES (3489,'vi','_AFTER_DISCOUNT','after discount');
INSERT INTO `aphs_vocabulary` VALUES (2972,'en','_SITE_OFFLINE','Site Offline');
INSERT INTO `aphs_vocabulary` VALUES (3488,'vi','_ADVANCED','Advanced');
INSERT INTO `aphs_vocabulary` VALUES (2975,'en','_SITE_OFFLINE_ALERT','Select whether access to the Site Front-end is available. If Yes, the Front-End will display the message below');
INSERT INTO `aphs_vocabulary` VALUES (4363,'vi','_ROOM_DETAILS','Room Details');
INSERT INTO `aphs_vocabulary` VALUES (4364,'vi','_ROOM_FACILITIES','Room Facilities');
INSERT INTO `aphs_vocabulary` VALUES (4365,'vi','_ROOM_FACILITIES_MANAGEMENT','Room Facilities Management');
INSERT INTO `aphs_vocabulary` VALUES (3487,'vi','_ADULTS','Adults');
INSERT INTO `aphs_vocabulary` VALUES (2978,'en','_SITE_OFFLINE_MESSAGE_ALERT','A message that displays in the Front-end if your site is offline');
INSERT INTO `aphs_vocabulary` VALUES (4361,'vi','_ROOM_AREA','Room Area');
INSERT INTO `aphs_vocabulary` VALUES (4362,'vi','_ROOM_DESCRIPTION','Room Description');
INSERT INTO `aphs_vocabulary` VALUES (3486,'vi','_ADULT','Adult');
INSERT INTO `aphs_vocabulary` VALUES (2981,'en','_SITE_PREVIEW','Site Preview');
INSERT INTO `aphs_vocabulary` VALUES (4360,'vi','_ROOMS_SETTINGS','Rooms Settings');
INSERT INTO `aphs_vocabulary` VALUES (2984,'en','_SITE_RANKS','Site Ranks');
INSERT INTO `aphs_vocabulary` VALUES (2987,'en','_SITE_RSS','Site RSS');
INSERT INTO `aphs_vocabulary` VALUES (4359,'vi','_ROOMS_RESERVATION','Rooms Reservation');
INSERT INTO `aphs_vocabulary` VALUES (2990,'en','_SITE_SETTINGS','Site Settings');
INSERT INTO `aphs_vocabulary` VALUES (2993,'en','_SMTP_HOST','SMTP Host');
INSERT INTO `aphs_vocabulary` VALUES (4358,'vi','_ROOMS_OCCUPANCY','Rooms Occupancy');
INSERT INTO `aphs_vocabulary` VALUES (2996,'en','_SMTP_PORT','SMTP Port');
INSERT INTO `aphs_vocabulary` VALUES (2999,'en','_SMTP_SECURE','SMTP Secure');
INSERT INTO `aphs_vocabulary` VALUES (4357,'vi','_ROOMS_MANAGEMENT','Rooms Management');
INSERT INTO `aphs_vocabulary` VALUES (3002,'en','_SORT_BY','Sort by');
INSERT INTO `aphs_vocabulary` VALUES (3005,'en','_STANDARD','Standard');
INSERT INTO `aphs_vocabulary` VALUES (4356,'vi','_ROOMS_LEFT','rooms left');
INSERT INTO `aphs_vocabulary` VALUES (3008,'en','_STANDARD_CAMPAIGN','Targeting Period Campaign');
INSERT INTO `aphs_vocabulary` VALUES (4355,'vi','_ROOMS_LAST','last room');
INSERT INTO `aphs_vocabulary` VALUES (3011,'en','_STANDARD_PRICE','Standard Price');
INSERT INTO `aphs_vocabulary` VALUES (3014,'en','_STARS','Stars');
INSERT INTO `aphs_vocabulary` VALUES (4354,'vi','_ROOMS_FACILITIES','Rooms Facilities');
INSERT INTO `aphs_vocabulary` VALUES (3017,'en','_STARS_1_5','1 star to 5 stars');
INSERT INTO `aphs_vocabulary` VALUES (3020,'en','_STARS_5_1','5 stars to 1 star');
INSERT INTO `aphs_vocabulary` VALUES (4353,'vi','_ROOMS_COUNT','Number of Rooms (in the Hotel)');
INSERT INTO `aphs_vocabulary` VALUES (3023,'en','_START_DATE','Start Date');
INSERT INTO `aphs_vocabulary` VALUES (3026,'en','_START_FINISH_DATE_ERROR','Finish date must be later than start date! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4351,'vi','_ROOMS','Rooms');
INSERT INTO `aphs_vocabulary` VALUES (4352,'vi','_ROOMS_AVAILABILITY','Rooms Availability');
INSERT INTO `aphs_vocabulary` VALUES (3029,'en','_STATE','State');
INSERT INTO `aphs_vocabulary` VALUES (4350,'vi','_ROLES_MANAGEMENT','Roles Management');
INSERT INTO `aphs_vocabulary` VALUES (3032,'en','_STATE_PROVINCE','State/Province');
INSERT INTO `aphs_vocabulary` VALUES (3035,'en','_STATISTICS','Statistics');
INSERT INTO `aphs_vocabulary` VALUES (4349,'vi','_ROLES_AND_PRIVILEGES','Roles & Privileges');
INSERT INTO `aphs_vocabulary` VALUES (3038,'en','_STATUS','Status');
INSERT INTO `aphs_vocabulary` VALUES (3041,'en','_STOP','Stop');
INSERT INTO `aphs_vocabulary` VALUES (3044,'en','_SU','Su');
INSERT INTO `aphs_vocabulary` VALUES (4348,'vi','_RIGHT_TO_LEFT','RTL (right-to-left)');
INSERT INTO `aphs_vocabulary` VALUES (3047,'en','_SUBJECT','Subject');
INSERT INTO `aphs_vocabulary` VALUES (4347,'vi','_RIGHT','Right');
INSERT INTO `aphs_vocabulary` VALUES (3050,'en','_SUBJECT_EMPTY_ALERT','Subject cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (4346,'vi','_RETYPE_PASSWORD','Retype Password');
INSERT INTO `aphs_vocabulary` VALUES (3053,'en','_SUBMIT','Submit');
INSERT INTO `aphs_vocabulary` VALUES (4345,'vi','_RESTORE','Restore');
INSERT INTO `aphs_vocabulary` VALUES (3056,'en','_SUBMIT_BOOKING','Submit Booking');
INSERT INTO `aphs_vocabulary` VALUES (4344,'vi','_RESTAURANT','Restaurant');
INSERT INTO `aphs_vocabulary` VALUES (3059,'en','_SUBMIT_PAYMENT','Submit Payment');
INSERT INTO `aphs_vocabulary` VALUES (4343,'vi','_RESET_ACCOUNT','Reset Account');
INSERT INTO `aphs_vocabulary` VALUES (3062,'en','_SUBSCRIBE','Subscribe');
INSERT INTO `aphs_vocabulary` VALUES (4342,'vi','_RESET','Reset');
INSERT INTO `aphs_vocabulary` VALUES (3065,'en','_SUBSCRIBE_EMAIL_EXISTS_ALERT','Someone with such email has already been subscribed to our newsletter. Please choose another email address for subscription.');
INSERT INTO `aphs_vocabulary` VALUES (4339,'vi','_RESERVATION_CART_IS_EMPTY_ALERT','Your reservation cart is empty!');
INSERT INTO `aphs_vocabulary` VALUES (4340,'vi','_RESERVATION_DETAILS','Reservation Details');
INSERT INTO `aphs_vocabulary` VALUES (4341,'vi','_RESERVED','Reserved');
INSERT INTO `aphs_vocabulary` VALUES (3068,'en','_SUBSCRIBE_TO_NEWSLETTER','Newsletter Subscription');
INSERT INTO `aphs_vocabulary` VALUES (4338,'vi','_RESERVATION_CART','Reservation Cart');
INSERT INTO `aphs_vocabulary` VALUES (3071,'en','_SUBSCRIPTION_ALREADY_SENT','You have already subscribed to our newsletter. Please try again later or wait _WAIT_ seconds.');
INSERT INTO `aphs_vocabulary` VALUES (4336,'vi','_RESERVATION','Reservation');
INSERT INTO `aphs_vocabulary` VALUES (4337,'vi','_RESERVATIONS','Reservations');
INSERT INTO `aphs_vocabulary` VALUES (3074,'en','_SUBSCRIPTION_MANAGEMENT','Subscription Management');
INSERT INTO `aphs_vocabulary` VALUES (3077,'en','_SUBTOTAL','Subtotal');
INSERT INTO `aphs_vocabulary` VALUES (3080,'en','_SUN','Sun');
INSERT INTO `aphs_vocabulary` VALUES (3083,'en','_SUNDAY','Sunday');
INSERT INTO `aphs_vocabulary` VALUES (4335,'vi','_RESEND_ACTIVATION_EMAIL_MSG','Please enter your email address then click on Send button. You will receive the activation email shortly.');
INSERT INTO `aphs_vocabulary` VALUES (3086,'en','_SWITCH_TO_EXPORT','Switch to Export');
INSERT INTO `aphs_vocabulary` VALUES (3089,'en','_SWITCH_TO_NORMAL','Switch to Normal');
INSERT INTO `aphs_vocabulary` VALUES (4334,'vi','_RESEND_ACTIVATION_EMAIL','Resend Activation Email');
INSERT INTO `aphs_vocabulary` VALUES (3092,'en','_SYMBOL','Symbol');
INSERT INTO `aphs_vocabulary` VALUES (4333,'vi','_REPORTS','Reports');
INSERT INTO `aphs_vocabulary` VALUES (3485,'vi','_ADMIN_WELCOME_TEXT','<p>Welcome to Administrator Control Panel that allows you to add, edit or delete site content. With this Administrator Control Panel you can easy manage customers, reservations and perform a full hotel site management.</p><p><b>&#8226;</b> There are some modules for you: Backup & Restore, News. Installation or un-installation of them is possible from <a href=\'index.php?admin=modules\'>Modules Menu</a>.</p><p><b>&#8226;</b> In <a href=\'index.php?admin=languages\'>Languages Menu</a> you may add/remove language or change language settings and edit your vocabulary (the words and phrases, used by the system).</p><p><b>&#8226;</b> <a href=\'index.php?admin=settings\'>Settings Menu</a> allows you to define important settings for the site.</p><p><b>&#8226;</b> In <a href=\'index.php?admin=my_account\'>My Account</a> there is a possibility to change your info.</p><p><b>&#8226;</b> <a href=\'index.php?admin=menus\'>Menus</a> and <a href=\'index.php?admin=pages\'>Pages Management</a> are designed for creating and managing menus, links and pages.</p><p><b>&#8226;</b> To create and edit room types, seasons, prices, bookings and other hotel info, use <a href=\'index.php?admin=hotel_info\'>Hotel Management</a>, <a href=\'index.php?admin=rooms_management\'>Rooms Management</a> and <a href=\'index.php?admin=mod_booking_bookings\'>Bookings</a> menus.</p>');
INSERT INTO `aphs_vocabulary` VALUES (3095,'en','_SYMBOL_PLACEMENT','Symbol Placement');
INSERT INTO `aphs_vocabulary` VALUES (3098,'en','_SYSTEM','System');
INSERT INTO `aphs_vocabulary` VALUES (4332,'vi','_REMOVE_ROOM_FROM_CART','Remove room from the cart');
INSERT INTO `aphs_vocabulary` VALUES (3483,'vi','_ADMIN_PANEL','Admin Panel');
INSERT INTO `aphs_vocabulary` VALUES (3484,'vi','_ADMIN_RESERVATION','Admin Reservation');
INSERT INTO `aphs_vocabulary` VALUES (3101,'en','_SYSTEM_EMAIL_DELETE_ALERT','This email template is used by the system and cannot be deleted!');
INSERT INTO `aphs_vocabulary` VALUES (3104,'en','_SYSTEM_MODULE','System Module');
INSERT INTO `aphs_vocabulary` VALUES (3107,'en','_SYSTEM_MODULES','System Modules');
INSERT INTO `aphs_vocabulary` VALUES (4331,'vi','_REMOVE_LAST_COUNTRY_ALERT','The country selected has not been deleted, because you must have at least one active country for correct work of the site!');
INSERT INTO `aphs_vocabulary` VALUES (3481,'vi','_ADMIN_LOGIN','Admin Login');
INSERT INTO `aphs_vocabulary` VALUES (3482,'vi','_ADMIN_MAILER_ALERT','Select which mailer you prefer to use for the delivery of site emails.');
INSERT INTO `aphs_vocabulary` VALUES (3110,'en','_SYSTEM_MODULE_ACTIONS_BLOCKED','All operations with system module are blocked!');
INSERT INTO `aphs_vocabulary` VALUES (3113,'en','_SYSTEM_TEMPLATE','System Template');
INSERT INTO `aphs_vocabulary` VALUES (3116,'en','_TAG','Tag');
INSERT INTO `aphs_vocabulary` VALUES (3480,'vi','_ADMIN_EMAIL_WRONG','Admin email in wrong format! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3119,'en','_TAG_TITLE_IS_EMPTY','Tag &lt;TITLE&gt; cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3122,'en','_TARGET','Target');
INSERT INTO `aphs_vocabulary` VALUES (3125,'en','_TARGET_GROUP','Target Group');
INSERT INTO `aphs_vocabulary` VALUES (3479,'vi','_ADMIN_EMAIL_IS_EMPTY','Admin email must not be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3128,'en','_TAXES','Taxes');
INSERT INTO `aphs_vocabulary` VALUES (3131,'en','_TEMPLATES_STYLES','Templates & Styles');
INSERT INTO `aphs_vocabulary` VALUES (3134,'en','_TEMPLATE_CODE','Template Code');
INSERT INTO `aphs_vocabulary` VALUES (4330,'vi','_REMOVE_ACCOUNT_WARNING','If you don\'t think you will use this site again and would like your account deleted, we can take care of this for you. Keep in mind, that you will not be able to reactivate your account or retrieve any of the content or information that was added. If you would like your account deleted, then click Remove button');
INSERT INTO `aphs_vocabulary` VALUES (3478,'vi','_ADMIN_EMAIL_EXISTS_ALERT','Administrator with such email already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (3137,'en','_TEMPLATE_IS_EMPTY','Template cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4329,'vi','_REMOVE_ACCOUNT_ALERT','Are you sure you want to remove your account?');
INSERT INTO `aphs_vocabulary` VALUES (3140,'en','_TERMS','Terms & Conditions');
INSERT INTO `aphs_vocabulary` VALUES (3143,'en','_TESTIMONIALS','Testimonials');
INSERT INTO `aphs_vocabulary` VALUES (4328,'vi','_REMOVE_ACCOUNT','Remove Account');
INSERT INTO `aphs_vocabulary` VALUES (3146,'en','_TESTIMONIALS_MANAGEMENT','Testimonials Management');
INSERT INTO `aphs_vocabulary` VALUES (4327,'vi','_REMOVED','Removed');
INSERT INTO `aphs_vocabulary` VALUES (3477,'vi','_ADMIN_EMAIL_ALERT','This email is used as \"From\" address for the system email notifications. Make sure, that you write here a valid email address based on domain of your site');
INSERT INTO `aphs_vocabulary` VALUES (3149,'en','_TESTIMONIALS_SETTINGS','Testimonials Settings');
INSERT INTO `aphs_vocabulary` VALUES (4326,'vi','_REMOVE','Remove');
INSERT INTO `aphs_vocabulary` VALUES (3476,'vi','_ADMIN_EMAIL','Admin Email');
INSERT INTO `aphs_vocabulary` VALUES (3152,'en','_TEST_EMAIL','Test Email');
INSERT INTO `aphs_vocabulary` VALUES (4325,'vi','_REMEMBER_ME','Remember Me');
INSERT INTO `aphs_vocabulary` VALUES (3473,'vi','_ADMINS','Admins');
INSERT INTO `aphs_vocabulary` VALUES (3474,'vi','_ADMINS_AND_CUSTOMERS','Customers & Admins');
INSERT INTO `aphs_vocabulary` VALUES (3475,'vi','_ADMINS_MANAGEMENT','Admins Management');
INSERT INTO `aphs_vocabulary` VALUES (3155,'en','_TEST_MODE_ALERT','Test Mode in Reservation Cart is turned ON! To change current mode click <a href=index.php?admin=mod_booking_settings>here</a>.');
INSERT INTO `aphs_vocabulary` VALUES (3471,'vi','_ADMIN','Admin');
INSERT INTO `aphs_vocabulary` VALUES (3472,'vi','_ADMINISTRATOR_ONLY','Administrator Only');
INSERT INTO `aphs_vocabulary` VALUES (3158,'en','_TEST_MODE_ALERT_SHORT','Attention: Reservation Cart is running in Test Mode!');
INSERT INTO `aphs_vocabulary` VALUES (4324,'vi','_REGISTRATION_NOT_COMPLETED','Your registration process is not yet complete! Please check again your email for further instructions or click <a href=index.php?customer=resend_activation>here</a> to resend them again.');
INSERT INTO `aphs_vocabulary` VALUES (3161,'en','_TEXT','Text');
INSERT INTO `aphs_vocabulary` VALUES (3164,'en','_TH','Th');
INSERT INTO `aphs_vocabulary` VALUES (3470,'vi','_ADD_TO_MENU','Add To Menu');
INSERT INTO `aphs_vocabulary` VALUES (3167,'en','_THU','Thu');
INSERT INTO `aphs_vocabulary` VALUES (4323,'vi','_REGISTRATION_FORM','Registration Form');
INSERT INTO `aphs_vocabulary` VALUES (3170,'en','_THUMBNAIL','Thumbnail');
INSERT INTO `aphs_vocabulary` VALUES (3469,'vi','_ADD_TO_CART','Add to Cart');
INSERT INTO `aphs_vocabulary` VALUES (3173,'en','_THURSDAY','Thursday');
INSERT INTO `aphs_vocabulary` VALUES (3467,'vi','_ADD_NEW','Add New');
INSERT INTO `aphs_vocabulary` VALUES (3468,'vi','_ADD_NEW_MENU','Add New Menu');
INSERT INTO `aphs_vocabulary` VALUES (3176,'en','_TIME_PERIOD_OVERLAPPING_ALERT','This period of time (fully or partially) was already selected! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (4321,'vi','_REGISTRATION_CODE','Registration code');
INSERT INTO `aphs_vocabulary` VALUES (4322,'vi','_REGISTRATION_CONFIRMATION','Registration Confirmation');
INSERT INTO `aphs_vocabulary` VALUES (3179,'en','_TIME_ZONE','Time Zone');
INSERT INTO `aphs_vocabulary` VALUES (4320,'vi','_REGISTRATIONS','Registrations');
INSERT INTO `aphs_vocabulary` VALUES (3182,'en','_TO','To');
INSERT INTO `aphs_vocabulary` VALUES (3185,'en','_TODAY','Today');
INSERT INTO `aphs_vocabulary` VALUES (3466,'vi','_ADDRESS_EMPTY_ALERT','Address cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3188,'en','_TOP','Top');
INSERT INTO `aphs_vocabulary` VALUES (3191,'en','_TOTAL','Total');
INSERT INTO `aphs_vocabulary` VALUES (4319,'vi','_REGISTERED_FROM_IP','Registered from IP');
INSERT INTO `aphs_vocabulary` VALUES (3465,'vi','_ADDRESS_2','Address (line 2)');
INSERT INTO `aphs_vocabulary` VALUES (3194,'en','_TOTAL_PRICE','Total Price');
INSERT INTO `aphs_vocabulary` VALUES (4318,'vi','_REGISTERED','Registered');
INSERT INTO `aphs_vocabulary` VALUES (3464,'vi','_ADDRESS','Address');
INSERT INTO `aphs_vocabulary` VALUES (3197,'en','_TOTAL_ROOMS','Total Rooms');
INSERT INTO `aphs_vocabulary` VALUES (4317,'vi','_REFUNDED','Refunded');
INSERT INTO `aphs_vocabulary` VALUES (3200,'en','_TRANSACTION','Transaction');
INSERT INTO `aphs_vocabulary` VALUES (4316,'vi','_REFRESH','Refresh');
INSERT INTO `aphs_vocabulary` VALUES (3203,'en','_TRANSLATE_VIA_GOOGLE','Translate via Google');
INSERT INTO `aphs_vocabulary` VALUES (3206,'en','_TRASH','Trash');
INSERT INTO `aphs_vocabulary` VALUES (4315,'vi','_RECORD_WAS_DELETED_COMMON','The record was successfully deleted!');
INSERT INTO `aphs_vocabulary` VALUES (3209,'en','_TRASH_PAGES','Trash Pages');
INSERT INTO `aphs_vocabulary` VALUES (4314,'vi','_REASON','Reason');
INSERT INTO `aphs_vocabulary` VALUES (3463,'vi','_ADDITIONAL_PAYMENT_TOOLTIP','To apply an additional payment or admin discount enter into this field an appropriate value (positive or negative).');
INSERT INTO `aphs_vocabulary` VALUES (3212,'en','_TRUNCATE_RELATED_TABLES','Truncate related tables?');
INSERT INTO `aphs_vocabulary` VALUES (4313,'vi','_READ_MORE','Read more');
INSERT INTO `aphs_vocabulary` VALUES (3461,'vi','_ADDITIONAL_MODULES','Additional Modules');
INSERT INTO `aphs_vocabulary` VALUES (3462,'vi','_ADDITIONAL_PAYMENT','Additional Payment');
INSERT INTO `aphs_vocabulary` VALUES (3215,'en','_TRY_LATER','An error occurred while executing. Please try again later!');
INSERT INTO `aphs_vocabulary` VALUES (4311,'vi','_REACTIVATION_EMAIL','Resend Activation Email');
INSERT INTO `aphs_vocabulary` VALUES (4312,'vi','_READY','Ready');
INSERT INTO `aphs_vocabulary` VALUES (3460,'vi','_ADDITIONAL_INFO','Additional Info');
INSERT INTO `aphs_vocabulary` VALUES (3218,'en','_TRY_SYSTEM_SUGGESTION','Try out system suggestion');
INSERT INTO `aphs_vocabulary` VALUES (4310,'vi','_RATE_PER_NIGHT_AVG','Average rate per night');
INSERT INTO `aphs_vocabulary` VALUES (3221,'en','_TU','Tu');
INSERT INTO `aphs_vocabulary` VALUES (3224,'en','_TUE','Tue');
INSERT INTO `aphs_vocabulary` VALUES (3227,'en','_TUESDAY','Tuesday');
INSERT INTO `aphs_vocabulary` VALUES (4309,'vi','_RATE_PER_NIGHT','Rate per night');
INSERT INTO `aphs_vocabulary` VALUES (3459,'vi','_ADDITIONAL_GUEST_FEE','Additional Guest Fee');
INSERT INTO `aphs_vocabulary` VALUES (3230,'en','_TYPE','Type');
INSERT INTO `aphs_vocabulary` VALUES (4308,'vi','_RATE','Rate');
INSERT INTO `aphs_vocabulary` VALUES (3233,'en','_TYPE_CHARS','Type the characters you see in the picture');
INSERT INTO `aphs_vocabulary` VALUES (4307,'vi','_QUESTIONS','Questions');
INSERT INTO `aphs_vocabulary` VALUES (3236,'en','_UNCATEGORIZED','Uncategorized');
INSERT INTO `aphs_vocabulary` VALUES (4306,'vi','_QUESTION','Question');
INSERT INTO `aphs_vocabulary` VALUES (3458,'vi','_ADDING_OPERATION_COMPLETED','The adding operation completed successfully!');
INSERT INTO `aphs_vocabulary` VALUES (3239,'en','_UNDEFINED','undefined');
INSERT INTO `aphs_vocabulary` VALUES (4305,'vi','_QUANTITY','Quantity');
INSERT INTO `aphs_vocabulary` VALUES (3457,'vi','_ADD','Add');
INSERT INTO `aphs_vocabulary` VALUES (3242,'en','_UNINSTALL','Uninstall');
INSERT INTO `aphs_vocabulary` VALUES (4304,'vi','_QTY','Qty');
INSERT INTO `aphs_vocabulary` VALUES (3456,'vi','_ACTIVE','Active');
INSERT INTO `aphs_vocabulary` VALUES (3245,'en','_UNITS','Units');
INSERT INTO `aphs_vocabulary` VALUES (3248,'en','_UNIT_PRICE','Unit Price');
INSERT INTO `aphs_vocabulary` VALUES (4303,'vi','_PUBLISH_YOUR_COMMENT','Publish your comment');
INSERT INTO `aphs_vocabulary` VALUES (3251,'en','_UNKNOWN','Unknown');
INSERT INTO `aphs_vocabulary` VALUES (4302,'vi','_PUBLISHED','Published');
INSERT INTO `aphs_vocabulary` VALUES (3254,'en','_UNSUBSCRIBE','Unsubscribe');
INSERT INTO `aphs_vocabulary` VALUES (3257,'en','_UP','Up');
INSERT INTO `aphs_vocabulary` VALUES (4301,'vi','_PUBLIC','Public');
INSERT INTO `aphs_vocabulary` VALUES (3260,'en','_UPDATING_ACCOUNT','Updating Account');
INSERT INTO `aphs_vocabulary` VALUES (3454,'vi','_ACTIVATION_EMAIL_ALREADY_SENT','The activation email was already sent to your email. Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (3455,'vi','_ACTIVATION_EMAIL_WAS_SENT','An email has been sent to _EMAIL_ with an activation key. Please check your mail to complete registration.');
INSERT INTO `aphs_vocabulary` VALUES (3263,'en','_UPDATING_ACCOUNT_ERROR','An error occurred while updating your account! Please try again later or send information about this error to administration of the site.');
INSERT INTO `aphs_vocabulary` VALUES (4299,'vi','_PROMO_CODE_OR_COUPON','Promo Code or Discount Coupon');
INSERT INTO `aphs_vocabulary` VALUES (4300,'vi','_PROMO_COUPON_NOTICE','If you have a promo code or discount coupon please enter it here');
INSERT INTO `aphs_vocabulary` VALUES (3452,'vi','_ACTIONS_WORD','Action');
INSERT INTO `aphs_vocabulary` VALUES (3453,'vi','_ACTION_REQUIRED','ACTION REQUIRED');
INSERT INTO `aphs_vocabulary` VALUES (3266,'en','_UPDATING_OPERATION_COMPLETED','Updating operation was successfully completed!');
INSERT INTO `aphs_vocabulary` VALUES (4297,'vi','_PRODUCT_DESCRIPTION','Product Description');
INSERT INTO `aphs_vocabulary` VALUES (4298,'vi','_PROMO_AND_DISCOUNTS','Promo and Discounts');
INSERT INTO `aphs_vocabulary` VALUES (3451,'vi','_ACTIONS','Action');
INSERT INTO `aphs_vocabulary` VALUES (3269,'en','_UPLOAD','Upload');
INSERT INTO `aphs_vocabulary` VALUES (3272,'en','_UPLOAD_AND_PROCCESS','Upload and Process');
INSERT INTO `aphs_vocabulary` VALUES (4296,'vi','_PRODUCTS_MANAGEMENT','Products Management');
INSERT INTO `aphs_vocabulary` VALUES (3275,'en','_UPLOAD_FROM_FILE','Upload from File');
INSERT INTO `aphs_vocabulary` VALUES (3278,'en','_URL','URL');
INSERT INTO `aphs_vocabulary` VALUES (4295,'vi','_PRODUCTS_COUNT','Products count');
INSERT INTO `aphs_vocabulary` VALUES (3281,'en','_USED_ON','Used On');
INSERT INTO `aphs_vocabulary` VALUES (4294,'vi','_PRODUCTS','Products');
INSERT INTO `aphs_vocabulary` VALUES (3450,'vi','_ACCOUT_CREATED_CONF_MSG','Already confirmed your registration? Click <a href=index.php?customer=login>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (3284,'en','_USERNAME','Username');
INSERT INTO `aphs_vocabulary` VALUES (4293,'vi','_PRODUCT','Product');
INSERT INTO `aphs_vocabulary` VALUES (3287,'en','_USERNAME_AND_PASSWORD','Username & Password');
INSERT INTO `aphs_vocabulary` VALUES (4292,'vi','_PRIVILEGES_MANAGEMENT','Privileges Management');
INSERT INTO `aphs_vocabulary` VALUES (3290,'en','_USERNAME_EMPTY_ALERT','Username cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4290,'vi','_PRINT','Print');
INSERT INTO `aphs_vocabulary` VALUES (4291,'vi','_PRIVILEGES','Privileges');
INSERT INTO `aphs_vocabulary` VALUES (3449,'vi','_ACCOUT_CREATED_CONF_LINK','Already confirmed your registration? Click <a href=index.php?customer=login>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (3293,'en','_USERNAME_LENGTH_ALERT','The length of username cannot be less than 4 characters! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4289,'vi','_PRICE_FORMAT_ALERT','Allows to display prices for visitor in appropriate format');
INSERT INTO `aphs_vocabulary` VALUES (3448,'vi','_ACCOUNT_WAS_UPDATED','Your account was successfully updated!');
INSERT INTO `aphs_vocabulary` VALUES (3296,'en','_USERS','Users');
INSERT INTO `aphs_vocabulary` VALUES (4288,'vi','_PRICE_FORMAT','Price Format');
INSERT INTO `aphs_vocabulary` VALUES (3299,'en','_USER_EMAIL_EXISTS_ALERT','User with such email already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (4287,'vi','_PRICE_EMPTY_ALERT','Field price cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3447,'vi','_ACCOUNT_WAS_DELETED','Your account was successfully removed! In seconds, you will be automatically redirected to the homepage.');
INSERT INTO `aphs_vocabulary` VALUES (3302,'en','_USER_EXISTS_ALERT','User with such username already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (4285,'vi','_PRICE','Price');
INSERT INTO `aphs_vocabulary` VALUES (4286,'vi','_PRICES','Prices');
INSERT INTO `aphs_vocabulary` VALUES (3446,'vi','_ACCOUNT_WAS_CREATED','Your account has been created');
INSERT INTO `aphs_vocabulary` VALUES (3305,'en','_USER_NAME','User name');
INSERT INTO `aphs_vocabulary` VALUES (4284,'vi','_PRE_PAYMENT','Pre-Payment');
INSERT INTO `aphs_vocabulary` VALUES (3308,'en','_USE_THIS_PASSWORD','Use this password');
INSERT INTO `aphs_vocabulary` VALUES (4283,'vi','_PREVIOUS','Previous');
INSERT INTO `aphs_vocabulary` VALUES (3445,'vi','_ACCOUNT_TYPE','Account type');
INSERT INTO `aphs_vocabulary` VALUES (3311,'en','_VALUE','Value');
INSERT INTO `aphs_vocabulary` VALUES (3314,'en','_VAT','VAT');
INSERT INTO `aphs_vocabulary` VALUES (4282,'vi','_PREVIEW','Preview');
INSERT INTO `aphs_vocabulary` VALUES (3317,'en','_VAT_PERCENT','VAT Percent');
INSERT INTO `aphs_vocabulary` VALUES (3320,'en','_VERSION','Version');
INSERT INTO `aphs_vocabulary` VALUES (4281,'vi','_PREPARING','Preparing');
INSERT INTO `aphs_vocabulary` VALUES (3323,'en','_VIDEO','Video');
INSERT INTO `aphs_vocabulary` VALUES (3326,'en','_VIEW_WORD','View');
INSERT INTO `aphs_vocabulary` VALUES (3329,'en','_VISITOR','Visitor');
INSERT INTO `aphs_vocabulary` VALUES (4280,'vi','_PREFERRED_LANGUAGE','Preferred Language');
INSERT INTO `aphs_vocabulary` VALUES (3444,'vi','_ACCOUNT_SUCCESSFULLY_RESET','You have successfully reset your account and username with temporary password have been sent to your email.');
INSERT INTO `aphs_vocabulary` VALUES (3332,'en','_VISUAL_SETTINGS','Visual Settings');
INSERT INTO `aphs_vocabulary` VALUES (3335,'en','_VOCABULARY','Vocabulary');
INSERT INTO `aphs_vocabulary` VALUES (4279,'vi','_PREDEFINED_CONSTANTS','Predefined Constants');
INSERT INTO `aphs_vocabulary` VALUES (3442,'vi','_ACCOUNT_CREATE_MSG','This registration process requires confirmation via email! <br />Please fill out the form below with correct information.');
INSERT INTO `aphs_vocabulary` VALUES (3443,'vi','_ACCOUNT_DETAILS','Account Details');
INSERT INTO `aphs_vocabulary` VALUES (3338,'en','_VOC_KEYS_UPDATED','Operation was successfully completed. Updated: _KEYS_ keys. Click <a href=\'index.php?admin=vocabulary&filter_by=A\'>here</a> to refresh the site.');
INSERT INTO `aphs_vocabulary` VALUES (4276,'vi','_POPULAR_SEARCH','Popular Search');
INSERT INTO `aphs_vocabulary` VALUES (4277,'vi','_POSTED_ON','Posted on');
INSERT INTO `aphs_vocabulary` VALUES (4278,'vi','_POST_COM_REGISTERED_ALERT','Your need to be registered to post comments.');
INSERT INTO `aphs_vocabulary` VALUES (3341,'en','_VOC_KEY_UPDATED','Vocabulary key was successfully updated.');
INSERT INTO `aphs_vocabulary` VALUES (4274,'vi','_PLAY','Play');
INSERT INTO `aphs_vocabulary` VALUES (4275,'vi','_POPULARITY','Popularity');
INSERT INTO `aphs_vocabulary` VALUES (3344,'en','_VOC_KEY_VALUE_EMPTY','Key value cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4272,'vi','_PLACEMENT','Placement');
INSERT INTO `aphs_vocabulary` VALUES (4273,'vi','_PLACE_ORDER','Place Order');
INSERT INTO `aphs_vocabulary` VALUES (3347,'en','_VOC_NOT_FOUND','No keys found');
INSERT INTO `aphs_vocabulary` VALUES (3441,'vi','_ACCOUNT_CREATED_NON_CONFIRM_MSG','Your account has been successfully created! For your convenience in a few minutes you will receive an email, containing the details of your registration (no confirmation required). <br><br>You may log into your account now.');
INSERT INTO `aphs_vocabulary` VALUES (3350,'en','_VOC_UPDATED','Vocabulary was successfully updated. Click <a href=index.php>here</a> to refresh the site.');
INSERT INTO `aphs_vocabulary` VALUES (4271,'vi','_PICK_DATE','Open calendar and pick a date');
INSERT INTO `aphs_vocabulary` VALUES (3353,'en','_WE','We');
INSERT INTO `aphs_vocabulary` VALUES (4270,'vi','_PHONE_EMPTY_ALERT','Phone field cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (3356,'en','_WEB_SITE','Web Site');
INSERT INTO `aphs_vocabulary` VALUES (3359,'en','_WED','Wed');
INSERT INTO `aphs_vocabulary` VALUES (4269,'vi','_PHONE','Phone');
INSERT INTO `aphs_vocabulary` VALUES (3362,'en','_WEDNESDAY','Wednesday');
INSERT INTO `aphs_vocabulary` VALUES (4268,'vi','_PER_NIGHT','Per Night');
INSERT INTO `aphs_vocabulary` VALUES (3440,'vi','_ACCOUNT_CREATED_NON_CONFIRM_LINK','Click <a href=index.php?customer=login>here</a> to proceed.');
INSERT INTO `aphs_vocabulary` VALUES (3365,'en','_WEEK_START_DAY','Week Start Day');
INSERT INTO `aphs_vocabulary` VALUES (4267,'vi','_PERSON_PER_NIGHT','Person/Per Night');
INSERT INTO `aphs_vocabulary` VALUES (3438,'vi','_ACCOUNT_CREATED_CONF_MSG','Your account was successfully created. <b>You will receive now an email</b>, containing the details of your account (it may take a few minutes).<br><br>After approval by an administrator, you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (3439,'vi','_ACCOUNT_CREATED_MSG','Your account was successfully created. <b>You will receive now a confirmation email</b>, containing the details of your account (it may take a few minutes). <br /><br />After completing the confirmation you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (3368,'en','_WELCOME_CUSTOMER_TEXT','<p>Hello <b>_FIRST_NAME_ _LAST_NAME_</b>!</p>        \r\n<p>Welcome to Customer Account Panel, that allows you to view account status, manage your account settings and bookings.</p>\r\n<p>\r\n   _TODAY_<br />\r\n   _LAST_LOGIN_\r\n</p>				\r\n<p> <b>&#8226;</b> To view this account summary just click on a <a href=\'index.php?customer=home\'>Dashboard</a> link.</p>\r\n<p> <b>&#8226;</b> <a href=\'index.php?customer=my_account\'>Edit My Account</a> menu allows you to change your personal info and account data.</p>\r\n<p> <b>&#8226;</b> <a href=\'index.php?customer=my_bookings\'>My Bookings</a> contains information about your orders.</p>\r\n<p><br /></p>');
INSERT INTO `aphs_vocabulary` VALUES (4257,'vi','_PC_WEB_SITE_BASED_URL_TEXT','web site base url');
INSERT INTO `aphs_vocabulary` VALUES (4258,'vi','_PC_WEB_SITE_URL_TEXT','web site url');
INSERT INTO `aphs_vocabulary` VALUES (4259,'vi','_PC_YEAR_TEXT','current year in YYYY format');
INSERT INTO `aphs_vocabulary` VALUES (4260,'vi','_PENDING','Pending');
INSERT INTO `aphs_vocabulary` VALUES (4261,'vi','_PEOPLE_ARRIVING','People Arriving');
INSERT INTO `aphs_vocabulary` VALUES (4262,'vi','_PEOPLE_DEPARTING','People Departing');
INSERT INTO `aphs_vocabulary` VALUES (4263,'vi','_PEOPLE_STAYING','People Staying');
INSERT INTO `aphs_vocabulary` VALUES (4264,'vi','_PERFORM_OPERATION_COMMON_ALERT','Are you sure you want to perform this operation?');
INSERT INTO `aphs_vocabulary` VALUES (4265,'vi','_PERSONAL_DETAILS','Personal Details');
INSERT INTO `aphs_vocabulary` VALUES (4266,'vi','_PERSONAL_INFORMATION','Personal Information');
INSERT INTO `aphs_vocabulary` VALUES (3371,'en','_WHAT_IS_CVV','What is CVV');
INSERT INTO `aphs_vocabulary` VALUES (4256,'vi','_PC_USER_PASSWORD_TEXT','password for customer or admin');
INSERT INTO `aphs_vocabulary` VALUES (3374,'en','_WHOLE_SITE','Whole site');
INSERT INTO `aphs_vocabulary` VALUES (3377,'en','_WITHOUT_ACCOUNT','without account');
INSERT INTO `aphs_vocabulary` VALUES (4255,'vi','_PC_USER_NAME_TEXT','username (login) of user');
INSERT INTO `aphs_vocabulary` VALUES (3437,'vi','_ACCOUNT_CREATED_CONF_BY_EMAIL_MSG','Your account has been successfully created! In a few minutes you should receive an email, containing the details of your registration. <br><br> Complete this registration, using the confirmation code that was sent to the provided email address, and you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (3380,'en','_WRONG_BOOKING_NUMBER','The booking number you\'ve entered was not found! Please enter a valid booking number.');
INSERT INTO `aphs_vocabulary` VALUES (4253,'vi','_PC_STATUS_DESCRIPTION_TEXT','description of payment status');
INSERT INTO `aphs_vocabulary` VALUES (4254,'vi','_PC_USER_EMAIL_TEXT','email of user');
INSERT INTO `aphs_vocabulary` VALUES (3383,'en','_WRONG_CHECKOUT_DATE_ALERT','Wrong date selected! Please choose a valid check-out date.');
INSERT INTO `aphs_vocabulary` VALUES (4252,'vi','_PC_REGISTRATION_CODE_TEXT','confirmation code for new account');
INSERT INTO `aphs_vocabulary` VALUES (3386,'en','_WRONG_CODE_ALERT','Sorry, the code you have entered was invalid! Please try again.');
INSERT INTO `aphs_vocabulary` VALUES (4251,'vi','_PC_PERSONAL_INFORMATION_TEXT','personal information of customer: first name, last name etc.');
INSERT INTO `aphs_vocabulary` VALUES (3389,'en','_WRONG_CONFIRMATION_CODE','Wrong confirmation code or your registration was already confirmed!');
INSERT INTO `aphs_vocabulary` VALUES (4250,'vi','_PC_LAST_NAME_TEXT','the last name of customer or admin');
INSERT INTO `aphs_vocabulary` VALUES (3436,'vi','_ACCOUNT_CREATED_CONF_BY_ADMIN_MSG','Your account has been successfully created! In a few minutes you should receive an email, containing the details of your account. <br><br> After approval your registration by administrator, you will be able to log into your account.');
INSERT INTO `aphs_vocabulary` VALUES (3392,'en','_WRONG_COUPON_CODE','This coupon code is invalid or has expired!');
INSERT INTO `aphs_vocabulary` VALUES (3435,'vi','_ACCOUNT_ALREADY_RESET','Your account was already reset! Please check your email inbox for more information.');
INSERT INTO `aphs_vocabulary` VALUES (3395,'en','_WRONG_FILE_TYPE','Uploaded file is not a valid PHP vocabulary file! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4248,'vi','_PC_FIRST_NAME_TEXT','the first name of customer or admin');
INSERT INTO `aphs_vocabulary` VALUES (4249,'vi','_PC_HOTEL_INFO_TEXT','information about hotel: name, address, telephone, fax etc.');
INSERT INTO `aphs_vocabulary` VALUES (3434,'vi','_ACCOUNTS_MANAGEMENT','Accounts');
INSERT INTO `aphs_vocabulary` VALUES (3398,'en','_WRONG_LOGIN','Wrong username or password!');
INSERT INTO `aphs_vocabulary` VALUES (4247,'vi','_PC_EVENT_TEXT','the title of event');
INSERT INTO `aphs_vocabulary` VALUES (3432,'vi','_ACCESSIBLE_BY','Accessible By');
INSERT INTO `aphs_vocabulary` VALUES (3433,'vi','_ACCOUNTS','Accounts');
INSERT INTO `aphs_vocabulary` VALUES (3401,'en','_WRONG_PARAMETER_PASSED','Wrong parameters passed - cannot complete operation!');
INSERT INTO `aphs_vocabulary` VALUES (4246,'vi','_PC_BOOKING_NUMBER_TEXT','the number of order');
INSERT INTO `aphs_vocabulary` VALUES (3431,'vi','_ACCESS','Access');
INSERT INTO `aphs_vocabulary` VALUES (3404,'en','_WYSIWYG_EDITOR','WYSIWYG Editor');
INSERT INTO `aphs_vocabulary` VALUES (3407,'en','_YEAR','Year');
INSERT INTO `aphs_vocabulary` VALUES (3430,'vi','_ABOUT_US','Bamboo Village');
INSERT INTO `aphs_vocabulary` VALUES (3410,'en','_YES','Yes');
INSERT INTO `aphs_vocabulary` VALUES (4245,'vi','_PC_BOOKING_DETAILS_TEXT','order details, list of purchased products etc.');
INSERT INTO `aphs_vocabulary` VALUES (3413,'en','_YOUR_EMAIL','Your Email');
INSERT INTO `aphs_vocabulary` VALUES (3429,'vi','_ABBREVIATION','Tên viết tắt');
INSERT INTO `aphs_vocabulary` VALUES (3416,'en','_YOUR_NAME','Your Name');
INSERT INTO `aphs_vocabulary` VALUES (3428,'vi','_2CO_ORDER','2CO Order');
INSERT INTO `aphs_vocabulary` VALUES (3419,'en','_YOU_ARE_LOGGED_AS','You are logged in as');
INSERT INTO `aphs_vocabulary` VALUES (4244,'vi','_PC_BILLING_INFORMATION_TEXT','billing information: address, city, country etc.');
INSERT INTO `aphs_vocabulary` VALUES (3422,'en','_ZIPCODE_EMPTY_ALERT','Zip/Postal code cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (4243,'vi','_PAY_ON_ARRIVAL','Pay on Arrival');
INSERT INTO `aphs_vocabulary` VALUES (3427,'vi','_2CO_NOTICE','2CheckOut.com Inc. (Ohio, USA) is an authorized retailer for goods and services.');
INSERT INTO `aphs_vocabulary` VALUES (3425,'en','_ZIP_CODE','Zip/Postal code');
INSERT INTO `aphs_vocabulary` VALUES (4242,'vi','_PAYPAL_ORDER','PayPal Order');
INSERT INTO `aphs_vocabulary` VALUES (5205,'ru','_MS_DEFAULT_PAYMENT_SYSTEM','Specifies default payment processing system');
INSERT INTO `aphs_vocabulary` VALUES (5206,'ru','_MS_DELAY_LENGTH','Defines a length of delay between sending emails (in seconds)');
INSERT INTO `aphs_vocabulary` VALUES (5207,'ru','_MS_DELETE_PENDING_TIME','The maximum pending time for deleting of comment in minutes');
INSERT INTO `aphs_vocabulary` VALUES (5208,'ru','_MS_EMAIL','The email address, that will be used to get sent information');
INSERT INTO `aphs_vocabulary` VALUES (5209,'ru','_MS_FAQ_IS_ACTIVE','Defines whether FAQ module is active or not');
INSERT INTO `aphs_vocabulary` VALUES (5210,'ru','_MS_FIRST_NIGHT_CALCULATING_TYPE','Specifies a type of the \'first night\' value calculating: real or average');
INSERT INTO `aphs_vocabulary` VALUES (5211,'ru','_MS_GALLERY_KEY','The keyword that will be replaced with gallery (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (5212,'ru','_MS_GALLERY_WRAPPER','Defines a wrapper type for gallery');
INSERT INTO `aphs_vocabulary` VALUES (5213,'ru','_MS_IMAGE_GALLERY_TYPE','Allowed types of Image Gallery');
INSERT INTO `aphs_vocabulary` VALUES (5214,'ru','_MS_IMAGE_VERIFICATION_ALLOW','Specifies whether to allow image verification (captcha)');
INSERT INTO `aphs_vocabulary` VALUES (5215,'ru','_MS_IS_SEND_DELAY','Specifies whether to allow time delay between sending emails.');
INSERT INTO `aphs_vocabulary` VALUES (5216,'ru','_MS_ITEMS_COUNT_IN_ALBUM','Specifies whether to show count of images/video under album name');
INSERT INTO `aphs_vocabulary` VALUES (5217,'ru','_MS_MAXIMUM_ALLOWED_RESERVATIONS','Specifies the maximum number of allowed room reservations (not completed) per customer');
INSERT INTO `aphs_vocabulary` VALUES (5218,'ru','_MS_MAXIMUM_NIGHTS','Defines a maximum number of nights per booking [<a href=index.php?admin=mod_booking_packages>Define by Package</a>]');
INSERT INTO `aphs_vocabulary` VALUES (5219,'ru','_MS_MINIMUM_NIGHTS','Defines a minimum number of nights per booking [<a href=index.php?admin=mod_booking_packages>Define by Package</a>]');
INSERT INTO `aphs_vocabulary` VALUES (5220,'ru','_MS_NEWS_COUNT','Defines how many news will be shown in news block');
INSERT INTO `aphs_vocabulary` VALUES (5221,'ru','_MS_NEWS_HEADER_LENGTH','Defines a length of news header in block');
INSERT INTO `aphs_vocabulary` VALUES (5222,'ru','_MS_NEWS_RSS','Defines using of RSS for news');
INSERT INTO `aphs_vocabulary` VALUES (5223,'ru','_MS_ONLINE_CREDIT_CARD_REQUIRED','Specifies whether collecting of credit card info is required for \'On-line Orders\'');
INSERT INTO `aphs_vocabulary` VALUES (5224,'ru','_MS_PAYMENT_TYPE_2CO','Specifies whether to allow \'2CO\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (5225,'ru','_MS_PAYMENT_TYPE_AUTHORIZE','Specifies whether to allow \'Authorize.Net\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (5226,'ru','_MS_PAYMENT_TYPE_BANK_TRANSFER','Specifies whether to allow \'Bank Transfer\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (5227,'ru','_MS_PAYMENT_TYPE_ONLINE','Specifies whether to allow \'On-line Order\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (5228,'ru','_MS_PAYMENT_TYPE_PAYPAL','Specifies whether to allow \'PayPal\' payment type');
INSERT INTO `aphs_vocabulary` VALUES (5229,'ru','_MS_PAYMENT_TYPE_POA','Specifies whether to allow \'Pay on Arrival\' (POA) payment type');
INSERT INTO `aphs_vocabulary` VALUES (5230,'ru','_MS_PAYPAL_EMAIL','Specifies PayPal (business) email ');
INSERT INTO `aphs_vocabulary` VALUES (5231,'ru','_MS_PREPARING_ORDERS_TIMEOUT','Defines a timeout for \'preparing\' orders before automatic deleting (in hours)');
INSERT INTO `aphs_vocabulary` VALUES (5232,'ru','_MS_PRE_MODERATION_ALLOW','Specifies whether to allow pre-moderation for comments');
INSERT INTO `aphs_vocabulary` VALUES (5233,'ru','_MS_PRE_PAYMENT_TYPE','Defines a pre-payment type (full price, first night only, fixed sum or percentage)');
INSERT INTO `aphs_vocabulary` VALUES (5234,'ru','_MS_PRE_PAYMENT_VALUE','Defines a pre-payment value for \'fixed sum\' or \'percentage\' types');
INSERT INTO `aphs_vocabulary` VALUES (5235,'ru','_MS_REG_CONFIRMATION','Defines whether confirmation (which type of) is required for registration');
INSERT INTO `aphs_vocabulary` VALUES (5236,'ru','_MS_REMEMBER_ME','Specifies whether to allow Remember Me feature');
INSERT INTO `aphs_vocabulary` VALUES (5237,'ru','_MS_RESERVATION EXPIRED_ALERT','Specifies whether to send email alert to customer when reservation has expired');
INSERT INTO `aphs_vocabulary` VALUES (5238,'ru','_MS_RESERVATION_INITIAL_FEE','Start (initial) fee - the sum that will be added to each booking (fixed value in default currency)');
INSERT INTO `aphs_vocabulary` VALUES (5239,'ru','_MS_ROOMS_IN_SEARCH','Specifies what types of rooms to show in search result: all or available rooms only (without fully booked / unavailable)');
INSERT INTO `aphs_vocabulary` VALUES (5240,'ru','_MS_ROTATE_DELAY','Defines banners rotation delay in seconds');
INSERT INTO `aphs_vocabulary` VALUES (5241,'ru','_MS_ROTATION_TYPE','Different type of banner rotation');
INSERT INTO `aphs_vocabulary` VALUES (5242,'ru','_MS_SEARCH_AVAILABILITY_PAGE_SIZE','Specifies the number of rooms/hotels that will be displayed on one page in the search availability results');
INSERT INTO `aphs_vocabulary` VALUES (5243,'ru','_MS_SEND_ORDER_COPY_TO_ADMIN','Specifies whether to allow sending a copy of order to admin');
INSERT INTO `aphs_vocabulary` VALUES (5244,'ru','_MS_SHOW_BOOKING_STATUS_FORM','Specifies whether to show Booking Status Form on homepage or not');
INSERT INTO `aphs_vocabulary` VALUES (5245,'ru','_MS_SHOW_FULLY_BOOKED_ROOMS','Specifies whether to allow showing of fully booked/unavailable rooms in search');
INSERT INTO `aphs_vocabulary` VALUES (5246,'ru','_MS_SHOW_NEWSLETTER_SUBSCRIBE_BLOCK','Defines whether to show Newsletter Subscription block or not');
INSERT INTO `aphs_vocabulary` VALUES (5247,'ru','_MS_SHOW_NEWS_BLOCK','Defines whether to show News side block or not');
INSERT INTO `aphs_vocabulary` VALUES (5248,'ru','_MS_SHOW_RESERVATION_FORM','Specifies whether to show Reservation Form on homepage or not');
INSERT INTO `aphs_vocabulary` VALUES (5249,'ru','_MS_TESTIMONIALS_KEY','The keyword that will be replaced with a list of customer testimonials (copy and paste it into the page)');
INSERT INTO `aphs_vocabulary` VALUES (5250,'ru','_MS_TWO_CHECKOUT_VENDOR','Specifies 2CO Vendor ID');
INSERT INTO `aphs_vocabulary` VALUES (5251,'ru','_MS_USER_TYPE','Type of users, who can post comments');
INSERT INTO `aphs_vocabulary` VALUES (5252,'ru','_MS_VAT_INCLUDED_IN_PRICE','Specifies whether VAT fee is included in room and extras prices or not');
INSERT INTO `aphs_vocabulary` VALUES (5253,'ru','_MS_VAT_VALUE','Specifies default VAT value for order (in %) &nbsp;[<a href=index.php?admin=countries_management>Define by Country</a>]');
INSERT INTO `aphs_vocabulary` VALUES (5254,'ru','_MS_VIDEO_GALLERY_TYPE','Allowed types of Video Gallery');
INSERT INTO `aphs_vocabulary` VALUES (5255,'ru','_MUST_BE_LOGGED','You must be logged in to view this page! <a href=\'index.php?customer=login\'>Login</a> or <a href=\'index.php?customer=create_account\'>Create Account for free</a>.');
INSERT INTO `aphs_vocabulary` VALUES (5256,'ru','_MY_ACCOUNT','My Account');
INSERT INTO `aphs_vocabulary` VALUES (5257,'ru','_MY_BOOKINGS','My Bookings');
INSERT INTO `aphs_vocabulary` VALUES (5258,'ru','_MY_ORDERS','My Orders');
INSERT INTO `aphs_vocabulary` VALUES (5259,'ru','_NAME','Name');
INSERT INTO `aphs_vocabulary` VALUES (5260,'ru','_NEVER','never');
INSERT INTO `aphs_vocabulary` VALUES (5261,'ru','_NEWS','News');
INSERT INTO `aphs_vocabulary` VALUES (5262,'ru','_NEWSLETTER_PAGE_TEXT','<p>To receive newsletters from our site, simply enter your email and click on \"Subscribe\" button.</p><p>If you later decide to stop your subscription or change the type of news you receive, simply follow the link at the end of the latest newsletter and update your profile or unsubscribe by ticking the checkbox below.</p>');
INSERT INTO `aphs_vocabulary` VALUES (5263,'ru','_NEWSLETTER_PRE_SUBSCRIBE_ALERT','Please click on the \"Subscribe\" button to complete the process.');
INSERT INTO `aphs_vocabulary` VALUES (5264,'ru','_NEWSLETTER_PRE_UNSUBSCRIBE_ALERT','Please click on the \"Unsubscribe\" button to complete the process.');
INSERT INTO `aphs_vocabulary` VALUES (5265,'ru','_NEWSLETTER_SUBSCRIBERS','Newsletter Subscribers');
INSERT INTO `aphs_vocabulary` VALUES (5266,'ru','_NEWSLETTER_SUBSCRIBE_SUCCESS','Thank you for subscribing to our electronic newsletter. You will receive an e-mail to confirm your subscription.');
INSERT INTO `aphs_vocabulary` VALUES (5267,'ru','_NEWSLETTER_SUBSCRIBE_TEXT','<p>To receive newsletters from our site, simply enter your email and click on \"Subscribe\" button.</p><p>If you later decide to stop your subscription or change the type of news you receive, simply follow the link at the end of the latest newsletter and update your profile or unsubscribe by ticking the checkbox below.</p>');
INSERT INTO `aphs_vocabulary` VALUES (5268,'ru','_NEWSLETTER_SUBSCRIPTION_MANAGEMENT','Newsletter Subscription Management');
INSERT INTO `aphs_vocabulary` VALUES (5269,'ru','_NEWSLETTER_UNSUBSCRIBE_SUCCESS','You have been successfully unsubscribed from our newsletter!');
INSERT INTO `aphs_vocabulary` VALUES (5270,'ru','_NEWSLETTER_UNSUBSCRIBE_TEXT','<p>To unsubscribe from our newsletters, enter your email address below and click the unsubscribe button.</p>');
INSERT INTO `aphs_vocabulary` VALUES (5271,'ru','_NEWS_AND_EVENTS','News & Events');
INSERT INTO `aphs_vocabulary` VALUES (5272,'ru','_NEWS_MANAGEMENT','News Management');
INSERT INTO `aphs_vocabulary` VALUES (5273,'ru','_NEWS_SETTINGS','News Settings');
INSERT INTO `aphs_vocabulary` VALUES (5274,'ru','_NEXT','Next');
INSERT INTO `aphs_vocabulary` VALUES (5275,'ru','_NIGHT','Night');
INSERT INTO `aphs_vocabulary` VALUES (5276,'ru','_NIGHTS','Nights');
INSERT INTO `aphs_vocabulary` VALUES (5277,'ru','_NO','No');
INSERT INTO `aphs_vocabulary` VALUES (5278,'ru','_NONE','None');
INSERT INTO `aphs_vocabulary` VALUES (5279,'ru','_NOTICE_MODULES_CODE','To add available modules to this page just copy and paste into the text:');
INSERT INTO `aphs_vocabulary` VALUES (5280,'ru','_NOTIFICATION_MSG','Please send me information about specials and discounts!');
INSERT INTO `aphs_vocabulary` VALUES (5281,'ru','_NOTIFICATION_STATUS_CHANGED','Notification status changed');
INSERT INTO `aphs_vocabulary` VALUES (5282,'ru','_NOT_ALLOWED','Not Allowed');
INSERT INTO `aphs_vocabulary` VALUES (5283,'ru','_NOT_AUTHORIZED','You are not authorized to view this page.');
INSERT INTO `aphs_vocabulary` VALUES (5284,'ru','_NOT_AVAILABLE','N/A');
INSERT INTO `aphs_vocabulary` VALUES (5285,'ru','_NOT_PAID_YET','Not paid yet');
INSERT INTO `aphs_vocabulary` VALUES (5286,'ru','_NOVEMBER','November');
INSERT INTO `aphs_vocabulary` VALUES (5287,'ru','_NO_AVAILABLE','Not Available');
INSERT INTO `aphs_vocabulary` VALUES (5288,'ru','_NO_BOOKING_FOUND','The number of booking you\'ve entered was not found in our system! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5289,'ru','_NO_COMMENTS_YET','No comments yet.');
INSERT INTO `aphs_vocabulary` VALUES (5290,'ru','_NO_CUSTOMER_FOUND','No customer found!');
INSERT INTO `aphs_vocabulary` VALUES (5291,'ru','_NO_NEWS','No news');
INSERT INTO `aphs_vocabulary` VALUES (5292,'ru','_NO_PAYMENT_METHODS_ALERT','No payment methods available! Please contact our technical support.');
INSERT INTO `aphs_vocabulary` VALUES (5293,'ru','_NO_RECORDS_FOUND','No records found');
INSERT INTO `aphs_vocabulary` VALUES (5294,'ru','_NO_RECORDS_PROCESSED','No records found for processing!');
INSERT INTO `aphs_vocabulary` VALUES (5295,'ru','_NO_RECORDS_UPDATED','No records were updated!');
INSERT INTO `aphs_vocabulary` VALUES (5296,'ru','_NO_ROOMS_FOUND','Sorry, there are no rooms that match your search. Please change your search criteria to see more rooms.');
INSERT INTO `aphs_vocabulary` VALUES (5297,'ru','_NO_TEMPLATE','no template');
INSERT INTO `aphs_vocabulary` VALUES (5298,'ru','_NO_USER_EMAIL_EXISTS_ALERT','It seems that you already booked rooms with us! <br>Please click <a href=index.php?customer=reset_account>here</a> to reset your username and get a temporary password. ');
INSERT INTO `aphs_vocabulary` VALUES (5299,'ru','_NO_WRITE_ACCESS_ALERT','Please check you have write access to following directories:');
INSERT INTO `aphs_vocabulary` VALUES (5300,'ru','_OCCUPANCY','Occupancy');
INSERT INTO `aphs_vocabulary` VALUES (5301,'ru','_OCTOBER','October');
INSERT INTO `aphs_vocabulary` VALUES (5302,'ru','_OFF','Off');
INSERT INTO `aphs_vocabulary` VALUES (5303,'ru','_OFFLINE_LOGIN_ALERT','To log into Admin Panel when site is offline, type in your browser: http://{your_site_address}/index.php?admin=login');
INSERT INTO `aphs_vocabulary` VALUES (5304,'ru','_OFFLINE_MESSAGE','Offline Message');
INSERT INTO `aphs_vocabulary` VALUES (5305,'ru','_ON','On');
INSERT INTO `aphs_vocabulary` VALUES (5306,'ru','_ONLINE','Online');
INSERT INTO `aphs_vocabulary` VALUES (5307,'ru','_ONLINE_ORDER','On-line Order');
INSERT INTO `aphs_vocabulary` VALUES (5308,'ru','_ONLY','Only');
INSERT INTO `aphs_vocabulary` VALUES (5309,'ru','_OPEN','Open');
INSERT INTO `aphs_vocabulary` VALUES (5310,'ru','_OPEN_ALERT_WINDOW','Open Alert Window');
INSERT INTO `aphs_vocabulary` VALUES (5311,'ru','_OPERATION_BLOCKED','This operation is blocked in Demo Version!');
INSERT INTO `aphs_vocabulary` VALUES (5312,'ru','_OPERATION_COMMON_COMPLETED','The operation was successfully completed!');
INSERT INTO `aphs_vocabulary` VALUES (5313,'ru','_OPERATION_WAS_ALREADY_COMPLETED','This operation was already completed!');
INSERT INTO `aphs_vocabulary` VALUES (5314,'ru','_OR','or');
INSERT INTO `aphs_vocabulary` VALUES (5315,'ru','_ORDER','Order');
INSERT INTO `aphs_vocabulary` VALUES (5316,'ru','_ORDERS','Orders');
INSERT INTO `aphs_vocabulary` VALUES (5317,'ru','_ORDERS_COUNT','Orders count');
INSERT INTO `aphs_vocabulary` VALUES (5318,'ru','_ORDER_DATE','Order Date');
INSERT INTO `aphs_vocabulary` VALUES (5319,'ru','_ORDER_ERROR','Cannot complete your order! Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (5320,'ru','_ORDER_NOW','Order Now');
INSERT INTO `aphs_vocabulary` VALUES (5321,'ru','_ORDER_PLACED_MSG','Thank you! The order has been placed in our system and will be processed shortly. Your booking number is: _BOOKING_NUMBER_.');
INSERT INTO `aphs_vocabulary` VALUES (5322,'ru','_ORDER_PRICE','Order Price');
INSERT INTO `aphs_vocabulary` VALUES (5323,'ru','_OTHER','Other');
INSERT INTO `aphs_vocabulary` VALUES (5324,'ru','_OUR_LOCATION','Our location');
INSERT INTO `aphs_vocabulary` VALUES (5325,'ru','_OWNER','Owner');
INSERT INTO `aphs_vocabulary` VALUES (5326,'ru','_PACKAGES','Packages');
INSERT INTO `aphs_vocabulary` VALUES (5327,'ru','_PACKAGES_MANAGEMENT','Packages Management');
INSERT INTO `aphs_vocabulary` VALUES (5328,'ru','_PAGE','Page');
INSERT INTO `aphs_vocabulary` VALUES (5329,'ru','_PAGES','Pages');
INSERT INTO `aphs_vocabulary` VALUES (5330,'ru','_PAGE_ADD_NEW','Add New Page');
INSERT INTO `aphs_vocabulary` VALUES (5331,'ru','_PAGE_CREATED','Page was successfully created');
INSERT INTO `aphs_vocabulary` VALUES (5332,'ru','_PAGE_DELETED','Page was successfully deleted');
INSERT INTO `aphs_vocabulary` VALUES (5333,'ru','_PAGE_DELETE_WARNING','Are you sure you want to delete this page?');
INSERT INTO `aphs_vocabulary` VALUES (5334,'ru','_PAGE_EDIT_HOME','Edit Home Page');
INSERT INTO `aphs_vocabulary` VALUES (5335,'ru','_PAGE_EDIT_PAGES','Edit Pages');
INSERT INTO `aphs_vocabulary` VALUES (5336,'ru','_PAGE_EDIT_SYS_PAGES','Edit System Pages');
INSERT INTO `aphs_vocabulary` VALUES (5337,'ru','_PAGE_EXPIRED','The page you requested has expired!');
INSERT INTO `aphs_vocabulary` VALUES (5338,'ru','_PAGE_HEADER','Page Header');
INSERT INTO `aphs_vocabulary` VALUES (5339,'ru','_PAGE_HEADER_EMPTY','Page header cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (5340,'ru','_PAGE_KEY_EMPTY','Page key cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (5341,'ru','_PAGE_LINK_TOO_LONG','Menu link too long!');
INSERT INTO `aphs_vocabulary` VALUES (5342,'ru','_PAGE_MANAGEMENT','Pages Management');
INSERT INTO `aphs_vocabulary` VALUES (5343,'ru','_PAGE_NOT_CREATED','Page was not created!');
INSERT INTO `aphs_vocabulary` VALUES (5344,'ru','_PAGE_NOT_DELETED','Page was not deleted!');
INSERT INTO `aphs_vocabulary` VALUES (5345,'ru','_PAGE_NOT_EXISTS','The page you attempted to access does not exist');
INSERT INTO `aphs_vocabulary` VALUES (5346,'ru','_PAGE_NOT_FOUND','No Pages Found');
INSERT INTO `aphs_vocabulary` VALUES (5347,'ru','_PAGE_NOT_SAVED','Page was not saved!');
INSERT INTO `aphs_vocabulary` VALUES (5348,'ru','_PAGE_ORDER_CHANGED','Page order was successfully changed!');
INSERT INTO `aphs_vocabulary` VALUES (5349,'ru','_PAGE_REMOVED','Page was successfully removed!');
INSERT INTO `aphs_vocabulary` VALUES (5350,'ru','_PAGE_REMOVE_WARNING','Are you sure you want to move this page to the Trash?');
INSERT INTO `aphs_vocabulary` VALUES (5351,'ru','_PAGE_RESTORED','Page was successfully restored!');
INSERT INTO `aphs_vocabulary` VALUES (5352,'ru','_PAGE_RESTORE_WARNING','Are you sure you want to restore this page?');
INSERT INTO `aphs_vocabulary` VALUES (5353,'ru','_PAGE_SAVED','Page was successfully saved');
INSERT INTO `aphs_vocabulary` VALUES (5354,'ru','_PAGE_TEXT','Page text');
INSERT INTO `aphs_vocabulary` VALUES (5355,'ru','_PAGE_TITLE','Page Title');
INSERT INTO `aphs_vocabulary` VALUES (5356,'ru','_PAGE_UNKNOWN','Unknown page!');
INSERT INTO `aphs_vocabulary` VALUES (5357,'ru','_PARAMETER','Parameter');
INSERT INTO `aphs_vocabulary` VALUES (5358,'ru','_PARTIALLY_AVAILABLE','Partially Available');
INSERT INTO `aphs_vocabulary` VALUES (5359,'ru','_PARTIAL_PRICE','Partial Price');
INSERT INTO `aphs_vocabulary` VALUES (5360,'ru','_PASSWORD','Password');
INSERT INTO `aphs_vocabulary` VALUES (5361,'ru','_PASSWORD_ALREADY_SENT','Password was already sent to your email. Please try again later.');
INSERT INTO `aphs_vocabulary` VALUES (5362,'ru','_PASSWORD_CHANGED','Password was changed.');
INSERT INTO `aphs_vocabulary` VALUES (5363,'ru','_PASSWORD_DO_NOT_MATCH','Password and confirmation do not match!');
INSERT INTO `aphs_vocabulary` VALUES (5364,'ru','_PASSWORD_FORGOTTEN','Forgotten Password');
INSERT INTO `aphs_vocabulary` VALUES (5365,'ru','_PASSWORD_FORGOTTEN_PAGE_MSG','Use a valid administrator e-mail to restore your password to the Administrator Back-End.<br><br>Return to site <a href=\'index.php\'>Home Page</a><br><br><img align=\'center\' src=\'images/password.png\' alt=\'\' width=\'92px\'>');
INSERT INTO `aphs_vocabulary` VALUES (5366,'ru','_PASSWORD_IS_EMPTY','Passwords must not be empty and at least 6 characters!');
INSERT INTO `aphs_vocabulary` VALUES (5367,'ru','_PASSWORD_NOT_CHANGED','Password was not changed. Please try again!');
INSERT INTO `aphs_vocabulary` VALUES (5368,'ru','_PASSWORD_RECOVERY_MSG','To recover your password, please enter your e-mail address and a link will be emailed to you.');
INSERT INTO `aphs_vocabulary` VALUES (5369,'ru','_PASSWORD_SUCCESSFULLY_SENT','Your password has been successfully sent to the email address.');
INSERT INTO `aphs_vocabulary` VALUES (5370,'ru','_PAST_TIME_ALERT','You cannot perform reservation in the past! Please re-enter dates.');
INSERT INTO `aphs_vocabulary` VALUES (5371,'ru','_PAYED_BY','Payed by');
INSERT INTO `aphs_vocabulary` VALUES (5372,'ru','_PAYMENT','Payment');
INSERT INTO `aphs_vocabulary` VALUES (5373,'ru','_PAYMENTS','Payments');
INSERT INTO `aphs_vocabulary` VALUES (5374,'ru','_PAYMENT_COMPANY_ACCOUNT','Payment Company Account');
INSERT INTO `aphs_vocabulary` VALUES (5375,'ru','_PAYMENT_DATE','Payment Date');
INSERT INTO `aphs_vocabulary` VALUES (5376,'ru','_PAYMENT_DETAILS','Payment Details');
INSERT INTO `aphs_vocabulary` VALUES (5377,'ru','_PAYMENT_ERROR','Payment error');
INSERT INTO `aphs_vocabulary` VALUES (5378,'ru','_PAYMENT_METHOD','Payment Method');
INSERT INTO `aphs_vocabulary` VALUES (5379,'ru','_PAYMENT_REQUIRED','Payment Required');
INSERT INTO `aphs_vocabulary` VALUES (5380,'ru','_PAYMENT_SUM','Payment Sum');
INSERT INTO `aphs_vocabulary` VALUES (5381,'ru','_PAYMENT_TYPE','Payment Type');
INSERT INTO `aphs_vocabulary` VALUES (5382,'ru','_PAYPAL','PayPal');
INSERT INTO `aphs_vocabulary` VALUES (5383,'ru','_PAYPAL_NOTICE','Save time. Pay securely using your stored payment information.<br />Pay with <b>credit card</b>, <b>bank account</b> or <b>PayPal</b> account balance.');
INSERT INTO `aphs_vocabulary` VALUES (5384,'ru','_PAYPAL_ORDER','PayPal Order');
INSERT INTO `aphs_vocabulary` VALUES (5385,'ru','_PAY_ON_ARRIVAL','Pay on Arrival');
INSERT INTO `aphs_vocabulary` VALUES (5386,'ru','_PC_BILLING_INFORMATION_TEXT','billing information: address, city, country etc.');
INSERT INTO `aphs_vocabulary` VALUES (5387,'ru','_PC_BOOKING_DETAILS_TEXT','order details, list of purchased products etc.');
INSERT INTO `aphs_vocabulary` VALUES (5388,'ru','_PC_BOOKING_NUMBER_TEXT','the number of order');
INSERT INTO `aphs_vocabulary` VALUES (5389,'ru','_PC_EVENT_TEXT','the title of event');
INSERT INTO `aphs_vocabulary` VALUES (5390,'ru','_PC_FIRST_NAME_TEXT','the first name of customer or admin');
INSERT INTO `aphs_vocabulary` VALUES (5391,'ru','_PC_HOTEL_INFO_TEXT','information about hotel: name, address, telephone, fax etc.');
INSERT INTO `aphs_vocabulary` VALUES (5392,'ru','_PC_LAST_NAME_TEXT','the last name of customer or admin');
INSERT INTO `aphs_vocabulary` VALUES (5393,'ru','_PC_PERSONAL_INFORMATION_TEXT','personal information of customer: first name, last name etc.');
INSERT INTO `aphs_vocabulary` VALUES (5394,'ru','_PC_REGISTRATION_CODE_TEXT','confirmation code for new account');
INSERT INTO `aphs_vocabulary` VALUES (5395,'ru','_PC_STATUS_DESCRIPTION_TEXT','description of payment status');
INSERT INTO `aphs_vocabulary` VALUES (5396,'ru','_PC_USER_EMAIL_TEXT','email of user');
INSERT INTO `aphs_vocabulary` VALUES (5397,'ru','_PC_USER_NAME_TEXT','username (login) of user');
INSERT INTO `aphs_vocabulary` VALUES (5398,'ru','_PC_USER_PASSWORD_TEXT','password for customer or admin');
INSERT INTO `aphs_vocabulary` VALUES (5399,'ru','_PC_WEB_SITE_BASED_URL_TEXT','web site base url');
INSERT INTO `aphs_vocabulary` VALUES (5400,'ru','_PC_WEB_SITE_URL_TEXT','web site url');
INSERT INTO `aphs_vocabulary` VALUES (5401,'ru','_PC_YEAR_TEXT','current year in YYYY format');
INSERT INTO `aphs_vocabulary` VALUES (5402,'ru','_PENDING','Pending');
INSERT INTO `aphs_vocabulary` VALUES (5403,'ru','_PEOPLE_ARRIVING','People Arriving');
INSERT INTO `aphs_vocabulary` VALUES (5404,'ru','_PEOPLE_DEPARTING','People Departing');
INSERT INTO `aphs_vocabulary` VALUES (5405,'ru','_PEOPLE_STAYING','People Staying');
INSERT INTO `aphs_vocabulary` VALUES (5406,'ru','_PERFORM_OPERATION_COMMON_ALERT','Are you sure you want to perform this operation?');
INSERT INTO `aphs_vocabulary` VALUES (5407,'ru','_PERSONAL_DETAILS','Personal Details');
INSERT INTO `aphs_vocabulary` VALUES (5408,'ru','_PERSONAL_INFORMATION','Personal Information');
INSERT INTO `aphs_vocabulary` VALUES (5409,'ru','_PERSON_PER_NIGHT','Person/Per Night');
INSERT INTO `aphs_vocabulary` VALUES (5410,'ru','_PER_NIGHT','Per Night');
INSERT INTO `aphs_vocabulary` VALUES (5411,'ru','_PHONE','Phone');
INSERT INTO `aphs_vocabulary` VALUES (5412,'ru','_PHONE_EMPTY_ALERT','Phone field cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5413,'ru','_PICK_DATE','Open calendar and pick a date');
INSERT INTO `aphs_vocabulary` VALUES (5414,'ru','_PLACEMENT','Placement');
INSERT INTO `aphs_vocabulary` VALUES (5415,'ru','_PLACE_ORDER','Place Order');
INSERT INTO `aphs_vocabulary` VALUES (5416,'ru','_PLAY','Play');
INSERT INTO `aphs_vocabulary` VALUES (5417,'ru','_POPULARITY','Popularity');
INSERT INTO `aphs_vocabulary` VALUES (5418,'ru','_POPULAR_SEARCH','Popular Search');
INSERT INTO `aphs_vocabulary` VALUES (5419,'ru','_POSTED_ON','Posted on');
INSERT INTO `aphs_vocabulary` VALUES (5420,'ru','_POST_COM_REGISTERED_ALERT','Your need to be registered to post comments.');
INSERT INTO `aphs_vocabulary` VALUES (5421,'ru','_PREDEFINED_CONSTANTS','Predefined Constants');
INSERT INTO `aphs_vocabulary` VALUES (5422,'ru','_PREFERRED_LANGUAGE','Preferred Language');
INSERT INTO `aphs_vocabulary` VALUES (5423,'ru','_PREPARING','Preparing');
INSERT INTO `aphs_vocabulary` VALUES (5424,'ru','_PREVIEW','Preview');
INSERT INTO `aphs_vocabulary` VALUES (5425,'ru','_PREVIOUS','Previous');
INSERT INTO `aphs_vocabulary` VALUES (5426,'ru','_PRE_PAYMENT','Pre-Payment');
INSERT INTO `aphs_vocabulary` VALUES (5427,'ru','_PRICE','Price');
INSERT INTO `aphs_vocabulary` VALUES (5428,'ru','_PRICES','Prices');
INSERT INTO `aphs_vocabulary` VALUES (5429,'ru','_PRICE_EMPTY_ALERT','Field price cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5430,'ru','_PRICE_FORMAT','Price Format');
INSERT INTO `aphs_vocabulary` VALUES (5431,'ru','_PRICE_FORMAT_ALERT','Allows to display prices for visitor in appropriate format');
INSERT INTO `aphs_vocabulary` VALUES (5432,'ru','_PRINT','Print');
INSERT INTO `aphs_vocabulary` VALUES (5433,'ru','_PRIVILEGES','Privileges');
INSERT INTO `aphs_vocabulary` VALUES (5434,'ru','_PRIVILEGES_MANAGEMENT','Privileges Management');
INSERT INTO `aphs_vocabulary` VALUES (5435,'ru','_PRODUCT','Product');
INSERT INTO `aphs_vocabulary` VALUES (5436,'ru','_PRODUCTS','Products');
INSERT INTO `aphs_vocabulary` VALUES (5437,'ru','_PRODUCTS_COUNT','Products count');
INSERT INTO `aphs_vocabulary` VALUES (5438,'ru','_PRODUCTS_MANAGEMENT','Products Management');
INSERT INTO `aphs_vocabulary` VALUES (5439,'ru','_PRODUCT_DESCRIPTION','Product Description');
INSERT INTO `aphs_vocabulary` VALUES (5440,'ru','_PROMO_AND_DISCOUNTS','Promo and Discounts');
INSERT INTO `aphs_vocabulary` VALUES (5441,'ru','_PROMO_CODE_OR_COUPON','Promo Code or Discount Coupon');
INSERT INTO `aphs_vocabulary` VALUES (5442,'ru','_PROMO_COUPON_NOTICE','If you have a promo code or discount coupon please enter it here');
INSERT INTO `aphs_vocabulary` VALUES (5443,'ru','_PUBLIC','Public');
INSERT INTO `aphs_vocabulary` VALUES (5444,'ru','_PUBLISHED','Published');
INSERT INTO `aphs_vocabulary` VALUES (5445,'ru','_PUBLISH_YOUR_COMMENT','Publish your comment');
INSERT INTO `aphs_vocabulary` VALUES (5446,'ru','_QTY','Qty');
INSERT INTO `aphs_vocabulary` VALUES (5447,'ru','_QUANTITY','Quantity');
INSERT INTO `aphs_vocabulary` VALUES (5448,'ru','_QUESTION','Question');
INSERT INTO `aphs_vocabulary` VALUES (5449,'ru','_QUESTIONS','Questions');
INSERT INTO `aphs_vocabulary` VALUES (5450,'ru','_RATE','Rate');
INSERT INTO `aphs_vocabulary` VALUES (5451,'ru','_RATE_PER_NIGHT','Rate per night');
INSERT INTO `aphs_vocabulary` VALUES (5452,'ru','_RATE_PER_NIGHT_AVG','Average rate per night');
INSERT INTO `aphs_vocabulary` VALUES (5453,'ru','_REACTIVATION_EMAIL','Resend Activation Email');
INSERT INTO `aphs_vocabulary` VALUES (5454,'ru','_READY','Ready');
INSERT INTO `aphs_vocabulary` VALUES (5455,'ru','_READ_MORE','Read more');
INSERT INTO `aphs_vocabulary` VALUES (5456,'ru','_REASON','Reason');
INSERT INTO `aphs_vocabulary` VALUES (5457,'ru','_RECORD_WAS_DELETED_COMMON','The record was successfully deleted!');
INSERT INTO `aphs_vocabulary` VALUES (5458,'ru','_REFRESH','Refresh');
INSERT INTO `aphs_vocabulary` VALUES (5459,'ru','_REFUNDED','Refunded');
INSERT INTO `aphs_vocabulary` VALUES (5460,'ru','_REGISTERED','Registered');
INSERT INTO `aphs_vocabulary` VALUES (5461,'ru','_REGISTERED_FROM_IP','Registered from IP');
INSERT INTO `aphs_vocabulary` VALUES (5462,'ru','_REGISTRATIONS','Registrations');
INSERT INTO `aphs_vocabulary` VALUES (5463,'ru','_REGISTRATION_CODE','Registration code');
INSERT INTO `aphs_vocabulary` VALUES (5464,'ru','_REGISTRATION_CONFIRMATION','Registration Confirmation');
INSERT INTO `aphs_vocabulary` VALUES (5465,'ru','_REGISTRATION_FORM','Registration Form');
INSERT INTO `aphs_vocabulary` VALUES (5466,'ru','_REGISTRATION_NOT_COMPLETED','Your registration process is not yet complete! Please check again your email for further instructions or click <a href=index.php?customer=resend_activation>here</a> to resend them again.');
INSERT INTO `aphs_vocabulary` VALUES (5467,'ru','_REMEMBER_ME','Remember Me');
INSERT INTO `aphs_vocabulary` VALUES (5468,'ru','_REMOVE','Remove');
INSERT INTO `aphs_vocabulary` VALUES (5469,'ru','_REMOVED','Removed');
INSERT INTO `aphs_vocabulary` VALUES (5470,'ru','_REMOVE_ACCOUNT','Remove Account');
INSERT INTO `aphs_vocabulary` VALUES (5471,'ru','_REMOVE_ACCOUNT_ALERT','Are you sure you want to remove your account?');
INSERT INTO `aphs_vocabulary` VALUES (5472,'ru','_REMOVE_ACCOUNT_WARNING','If you don\'t think you will use this site again and would like your account deleted, we can take care of this for you. Keep in mind, that you will not be able to reactivate your account or retrieve any of the content or information that was added. If you would like your account deleted, then click Remove button');
INSERT INTO `aphs_vocabulary` VALUES (5473,'ru','_REMOVE_LAST_COUNTRY_ALERT','The country selected has not been deleted, because you must have at least one active country for correct work of the site!');
INSERT INTO `aphs_vocabulary` VALUES (5474,'ru','_REMOVE_ROOM_FROM_CART','Remove room from the cart');
INSERT INTO `aphs_vocabulary` VALUES (5475,'ru','_REPORTS','Reports');
INSERT INTO `aphs_vocabulary` VALUES (5476,'ru','_RESEND_ACTIVATION_EMAIL','Resend Activation Email');
INSERT INTO `aphs_vocabulary` VALUES (5477,'ru','_RESEND_ACTIVATION_EMAIL_MSG','Please enter your email address then click on Send button. You will receive the activation email shortly.');
INSERT INTO `aphs_vocabulary` VALUES (5478,'ru','_RESERVATION','Reservation');
INSERT INTO `aphs_vocabulary` VALUES (5479,'ru','_RESERVATIONS','Reservations');
INSERT INTO `aphs_vocabulary` VALUES (5480,'ru','_RESERVATION_CART','Reservation Cart');
INSERT INTO `aphs_vocabulary` VALUES (5481,'ru','_RESERVATION_CART_IS_EMPTY_ALERT','Your reservation cart is empty!');
INSERT INTO `aphs_vocabulary` VALUES (5482,'ru','_RESERVATION_DETAILS','Reservation Details');
INSERT INTO `aphs_vocabulary` VALUES (5483,'ru','_RESERVED','Reserved');
INSERT INTO `aphs_vocabulary` VALUES (5484,'ru','_RESET','Reset');
INSERT INTO `aphs_vocabulary` VALUES (5485,'ru','_RESET_ACCOUNT','Reset Account');
INSERT INTO `aphs_vocabulary` VALUES (5486,'ru','_RESTAURANT','Restaurant');
INSERT INTO `aphs_vocabulary` VALUES (5487,'ru','_RESTORE','Restore');
INSERT INTO `aphs_vocabulary` VALUES (5488,'ru','_RETYPE_PASSWORD','Retype Password');
INSERT INTO `aphs_vocabulary` VALUES (5489,'ru','_RIGHT','Right');
INSERT INTO `aphs_vocabulary` VALUES (5490,'ru','_RIGHT_TO_LEFT','RTL (right-to-left)');
INSERT INTO `aphs_vocabulary` VALUES (5491,'ru','_ROLES_AND_PRIVILEGES','Roles & Privileges');
INSERT INTO `aphs_vocabulary` VALUES (5492,'ru','_ROLES_MANAGEMENT','Roles Management');
INSERT INTO `aphs_vocabulary` VALUES (5493,'ru','_ROOMS','Rooms');
INSERT INTO `aphs_vocabulary` VALUES (5494,'ru','_ROOMS_AVAILABILITY','Rooms Availability');
INSERT INTO `aphs_vocabulary` VALUES (5495,'ru','_ROOMS_COUNT','Number of Rooms (in the Hotel)');
INSERT INTO `aphs_vocabulary` VALUES (5496,'ru','_ROOMS_FACILITIES','Rooms Facilities');
INSERT INTO `aphs_vocabulary` VALUES (5497,'ru','_ROOMS_LAST','last room');
INSERT INTO `aphs_vocabulary` VALUES (5498,'ru','_ROOMS_LEFT','rooms left');
INSERT INTO `aphs_vocabulary` VALUES (5499,'ru','_ROOMS_MANAGEMENT','Rooms Management');
INSERT INTO `aphs_vocabulary` VALUES (5500,'ru','_ROOMS_OCCUPANCY','Rooms Occupancy');
INSERT INTO `aphs_vocabulary` VALUES (5501,'ru','_ROOMS_RESERVATION','Rooms Reservation');
INSERT INTO `aphs_vocabulary` VALUES (5502,'ru','_ROOMS_SETTINGS','Rooms Settings');
INSERT INTO `aphs_vocabulary` VALUES (5503,'ru','_ROOM_AREA','Room Area');
INSERT INTO `aphs_vocabulary` VALUES (5504,'ru','_ROOM_DESCRIPTION','Room Description');
INSERT INTO `aphs_vocabulary` VALUES (5505,'ru','_ROOM_DETAILS','Room Details');
INSERT INTO `aphs_vocabulary` VALUES (5506,'ru','_ROOM_FACILITIES','Room Facilities');
INSERT INTO `aphs_vocabulary` VALUES (5507,'ru','_ROOM_FACILITIES_MANAGEMENT','Room Facilities Management');
INSERT INTO `aphs_vocabulary` VALUES (5508,'ru','_ROOM_NOT_FOUND','Room was not found!');
INSERT INTO `aphs_vocabulary` VALUES (5509,'ru','_ROOM_NUMBERS','Room Numbers');
INSERT INTO `aphs_vocabulary` VALUES (5510,'ru','_ROOM_PRICE','Room Price');
INSERT INTO `aphs_vocabulary` VALUES (5511,'ru','_ROOM_PRICES_WERE_ADDED','Room prices for new period were successfully added!');
INSERT INTO `aphs_vocabulary` VALUES (5512,'ru','_ROOM_TYPE','Room Type');
INSERT INTO `aphs_vocabulary` VALUES (5513,'ru','_ROOM_WAS_ADDED','Room was successfully added to your reservation!');
INSERT INTO `aphs_vocabulary` VALUES (5514,'ru','_ROOM_WAS_REMOVED','Selected room was successfully removed from your Reservation Cart!');
INSERT INTO `aphs_vocabulary` VALUES (5515,'ru','_ROWS','Rows');
INSERT INTO `aphs_vocabulary` VALUES (5516,'ru','_RSS_FEED_TYPE','RSS Feed Type');
INSERT INTO `aphs_vocabulary` VALUES (5517,'ru','_RSS_FILE_ERROR','Cannot open RSS file to add new item! Please check your access rights to <b>feeds/</b> directory or try again later.');
INSERT INTO `aphs_vocabulary` VALUES (5518,'ru','_RUN_CRON','Run cron');
INSERT INTO `aphs_vocabulary` VALUES (5519,'ru','_RUN_EVERY','Run every');
INSERT INTO `aphs_vocabulary` VALUES (5520,'ru','_SA','Sa');
INSERT INTO `aphs_vocabulary` VALUES (5521,'ru','_SAID','said');
INSERT INTO `aphs_vocabulary` VALUES (5522,'ru','_SAT','Sat');
INSERT INTO `aphs_vocabulary` VALUES (5523,'ru','_SATURDAY','Saturday');
INSERT INTO `aphs_vocabulary` VALUES (5524,'ru','_SEARCH','Search');
INSERT INTO `aphs_vocabulary` VALUES (5525,'ru','_SEARCH_KEYWORDS','search keywords');
INSERT INTO `aphs_vocabulary` VALUES (5526,'ru','_SEARCH_RESULT_FOR','Search Results for');
INSERT INTO `aphs_vocabulary` VALUES (5527,'ru','_SEARCH_ROOM_TIPS','<b>Find more rooms by expanding your search options</b>:<br>- Reduce the number of adults in room to get more results<br>- Reduce the number of children in room to get more results<br>- Change your Check-in/Check-out dates<br>');
INSERT INTO `aphs_vocabulary` VALUES (5528,'ru','_SEC','Sec');
INSERT INTO `aphs_vocabulary` VALUES (5529,'ru','_SELECT','select');
INSERT INTO `aphs_vocabulary` VALUES (5530,'ru','_SELECTED_ROOMS','Selected Rooms');
INSERT INTO `aphs_vocabulary` VALUES (5531,'ru','_SELECT_FILE_TO_UPLOAD','Select a file to upload');
INSERT INTO `aphs_vocabulary` VALUES (5532,'ru','_SELECT_HOTEL','Select Hotel');
INSERT INTO `aphs_vocabulary` VALUES (5533,'ru','_SELECT_LANG_TO_UPDATE','Select a language to update');
INSERT INTO `aphs_vocabulary` VALUES (5534,'ru','_SELECT_LOCATION','Select Location');
INSERT INTO `aphs_vocabulary` VALUES (5535,'ru','_SELECT_REPORT_ALERT','Please select a report type!');
INSERT INTO `aphs_vocabulary` VALUES (5536,'ru','_SEND','Send');
INSERT INTO `aphs_vocabulary` VALUES (5537,'ru','_SENDING','Sending');
INSERT INTO `aphs_vocabulary` VALUES (5538,'ru','_SEND_COPY_TO_ADMIN','Send a copy to admin');
INSERT INTO `aphs_vocabulary` VALUES (5539,'ru','_SEND_INVOICE','Send Invoice');
INSERT INTO `aphs_vocabulary` VALUES (5540,'ru','_SEO_LINKS_ALERT','If you select this option, make sure SEO Links Section uncommented in .htaccess file');
INSERT INTO `aphs_vocabulary` VALUES (5541,'ru','_SEO_URLS','SEO URLs');
INSERT INTO `aphs_vocabulary` VALUES (5542,'ru','_SEPTEMBER','September');
INSERT INTO `aphs_vocabulary` VALUES (5543,'ru','_SERVER_INFO','Server Info');
INSERT INTO `aphs_vocabulary` VALUES (5544,'ru','_SERVER_LOCALE','Server Locale');
INSERT INTO `aphs_vocabulary` VALUES (5545,'ru','_SERVICE','Service');
INSERT INTO `aphs_vocabulary` VALUES (5546,'ru','_SERVICES','Services');
INSERT INTO `aphs_vocabulary` VALUES (5547,'ru','_SETTINGS','Settings');
INSERT INTO `aphs_vocabulary` VALUES (5548,'ru','_SETTINGS_SAVED','Changes were saved! Please refresh the <a href=index.php>Home Page</a> to see the results.');
INSERT INTO `aphs_vocabulary` VALUES (5549,'ru','_SET_ADMIN','Set Admin');
INSERT INTO `aphs_vocabulary` VALUES (5550,'ru','_SET_DATE','Set date');
INSERT INTO `aphs_vocabulary` VALUES (5551,'ru','_SET_TIME','Set Time');
INSERT INTO `aphs_vocabulary` VALUES (5552,'ru','_SHORT_DESCRIPTION','Short Description');
INSERT INTO `aphs_vocabulary` VALUES (5553,'ru','_SHOW','Show');
INSERT INTO `aphs_vocabulary` VALUES (5554,'ru','_SHOW_IN_SEARCH','Show in Search');
INSERT INTO `aphs_vocabulary` VALUES (5555,'ru','_SHOW_META_TAGS','Show META tags');
INSERT INTO `aphs_vocabulary` VALUES (5556,'ru','_SIMPLE','Simple');
INSERT INTO `aphs_vocabulary` VALUES (5557,'ru','_SITE_DEVELOPMENT_MODE_ALERT','The site is running in Development Mode! To turn it off change <b>SITE_MODE</b> value in <b>inc/settings.inc.php</b>');
INSERT INTO `aphs_vocabulary` VALUES (5558,'ru','_SITE_INFO','Site Info');
INSERT INTO `aphs_vocabulary` VALUES (5559,'ru','_SITE_OFFLINE','Site Offline');
INSERT INTO `aphs_vocabulary` VALUES (5560,'ru','_SITE_OFFLINE_ALERT','Select whether access to the Site Front-end is available. If Yes, the Front-End will display the message below');
INSERT INTO `aphs_vocabulary` VALUES (5561,'ru','_SITE_OFFLINE_MESSAGE_ALERT','A message that displays in the Front-end if your site is offline');
INSERT INTO `aphs_vocabulary` VALUES (5562,'ru','_SITE_PREVIEW','Site Preview');
INSERT INTO `aphs_vocabulary` VALUES (5563,'ru','_SITE_RANKS','Site Ranks');
INSERT INTO `aphs_vocabulary` VALUES (5564,'ru','_SITE_RSS','Site RSS');
INSERT INTO `aphs_vocabulary` VALUES (5565,'ru','_SITE_SETTINGS','Site Settings');
INSERT INTO `aphs_vocabulary` VALUES (5566,'ru','_SMTP_HOST','SMTP Host');
INSERT INTO `aphs_vocabulary` VALUES (5567,'ru','_SMTP_PORT','SMTP Port');
INSERT INTO `aphs_vocabulary` VALUES (5568,'ru','_SMTP_SECURE','SMTP Secure');
INSERT INTO `aphs_vocabulary` VALUES (5569,'ru','_SORT_BY','Sort by');
INSERT INTO `aphs_vocabulary` VALUES (5570,'ru','_STANDARD','Standard');
INSERT INTO `aphs_vocabulary` VALUES (5571,'ru','_STANDARD_CAMPAIGN','Targeting Period Campaign');
INSERT INTO `aphs_vocabulary` VALUES (5572,'ru','_STANDARD_PRICE','Standard Price');
INSERT INTO `aphs_vocabulary` VALUES (5573,'ru','_STARS','Stars');
INSERT INTO `aphs_vocabulary` VALUES (5574,'ru','_STARS_1_5','1 star to 5 stars');
INSERT INTO `aphs_vocabulary` VALUES (5575,'ru','_STARS_5_1','5 stars to 1 star');
INSERT INTO `aphs_vocabulary` VALUES (5576,'ru','_START_DATE','Start Date');
INSERT INTO `aphs_vocabulary` VALUES (5577,'ru','_START_FINISH_DATE_ERROR','Finish date must be later than start date! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5578,'ru','_STATE','State');
INSERT INTO `aphs_vocabulary` VALUES (5579,'ru','_STATE_PROVINCE','State/Province');
INSERT INTO `aphs_vocabulary` VALUES (5580,'ru','_STATISTICS','Statistics');
INSERT INTO `aphs_vocabulary` VALUES (5581,'ru','_STATUS','Status');
INSERT INTO `aphs_vocabulary` VALUES (5582,'ru','_STOP','Stop');
INSERT INTO `aphs_vocabulary` VALUES (5583,'ru','_SU','Su');
INSERT INTO `aphs_vocabulary` VALUES (5584,'ru','_SUBJECT','Subject');
INSERT INTO `aphs_vocabulary` VALUES (5585,'ru','_SUBJECT_EMPTY_ALERT','Subject cannot be empty!');
INSERT INTO `aphs_vocabulary` VALUES (5586,'ru','_SUBMIT','Submit');
INSERT INTO `aphs_vocabulary` VALUES (5587,'ru','_SUBMIT_BOOKING','Submit Booking');
INSERT INTO `aphs_vocabulary` VALUES (5588,'ru','_SUBMIT_PAYMENT','Submit Payment');
INSERT INTO `aphs_vocabulary` VALUES (5589,'ru','_SUBSCRIBE','Subscribe');
INSERT INTO `aphs_vocabulary` VALUES (5590,'ru','_SUBSCRIBE_EMAIL_EXISTS_ALERT','Someone with such email has already been subscribed to our newsletter. Please choose another email address for subscription.');
INSERT INTO `aphs_vocabulary` VALUES (5591,'ru','_SUBSCRIBE_TO_NEWSLETTER','Newsletter Subscription');
INSERT INTO `aphs_vocabulary` VALUES (5592,'ru','_SUBSCRIPTION_ALREADY_SENT','You have already subscribed to our newsletter. Please try again later or wait _WAIT_ seconds.');
INSERT INTO `aphs_vocabulary` VALUES (5593,'ru','_SUBSCRIPTION_MANAGEMENT','Subscription Management');
INSERT INTO `aphs_vocabulary` VALUES (5594,'ru','_SUBTOTAL','Subtotal');
INSERT INTO `aphs_vocabulary` VALUES (5595,'ru','_SUN','Sun');
INSERT INTO `aphs_vocabulary` VALUES (5596,'ru','_SUNDAY','Sunday');
INSERT INTO `aphs_vocabulary` VALUES (5597,'ru','_SWITCH_TO_EXPORT','Switch to Export');
INSERT INTO `aphs_vocabulary` VALUES (5598,'ru','_SWITCH_TO_NORMAL','Switch to Normal');
INSERT INTO `aphs_vocabulary` VALUES (5599,'ru','_SYMBOL','Symbol');
INSERT INTO `aphs_vocabulary` VALUES (5600,'ru','_SYMBOL_PLACEMENT','Symbol Placement');
INSERT INTO `aphs_vocabulary` VALUES (5601,'ru','_SYSTEM','System');
INSERT INTO `aphs_vocabulary` VALUES (5602,'ru','_SYSTEM_EMAIL_DELETE_ALERT','This email template is used by the system and cannot be deleted!');
INSERT INTO `aphs_vocabulary` VALUES (5603,'ru','_SYSTEM_MODULE','System Module');
INSERT INTO `aphs_vocabulary` VALUES (5604,'ru','_SYSTEM_MODULES','System Modules');
INSERT INTO `aphs_vocabulary` VALUES (5605,'ru','_SYSTEM_MODULE_ACTIONS_BLOCKED','All operations with system module are blocked!');
INSERT INTO `aphs_vocabulary` VALUES (5606,'ru','_SYSTEM_TEMPLATE','System Template');
INSERT INTO `aphs_vocabulary` VALUES (5607,'ru','_TAG','Tag');
INSERT INTO `aphs_vocabulary` VALUES (5608,'ru','_TAG_TITLE_IS_EMPTY','Tag &lt;TITLE&gt; cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5609,'ru','_TARGET','Target');
INSERT INTO `aphs_vocabulary` VALUES (5610,'ru','_TARGET_GROUP','Target Group');
INSERT INTO `aphs_vocabulary` VALUES (5611,'ru','_TAXES','Taxes');
INSERT INTO `aphs_vocabulary` VALUES (5612,'ru','_TEMPLATES_STYLES','Templates & Styles');
INSERT INTO `aphs_vocabulary` VALUES (5613,'ru','_TEMPLATE_CODE','Template Code');
INSERT INTO `aphs_vocabulary` VALUES (5614,'ru','_TEMPLATE_IS_EMPTY','Template cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5615,'ru','_TERMS','Terms & Conditions');
INSERT INTO `aphs_vocabulary` VALUES (5616,'ru','_TESTIMONIALS','Testimonials');
INSERT INTO `aphs_vocabulary` VALUES (5617,'ru','_TESTIMONIALS_MANAGEMENT','Testimonials Management');
INSERT INTO `aphs_vocabulary` VALUES (5618,'ru','_TESTIMONIALS_SETTINGS','Testimonials Settings');
INSERT INTO `aphs_vocabulary` VALUES (5619,'ru','_TEST_EMAIL','Test Email');
INSERT INTO `aphs_vocabulary` VALUES (5620,'ru','_TEST_MODE_ALERT','Test Mode in Reservation Cart is turned ON! To change current mode click <a href=index.php?admin=mod_booking_settings>here</a>.');
INSERT INTO `aphs_vocabulary` VALUES (5621,'ru','_TEST_MODE_ALERT_SHORT','Attention: Reservation Cart is running in Test Mode!');
INSERT INTO `aphs_vocabulary` VALUES (5622,'ru','_TEXT','Text');
INSERT INTO `aphs_vocabulary` VALUES (5623,'ru','_TH','Th');
INSERT INTO `aphs_vocabulary` VALUES (5624,'ru','_THU','Thu');
INSERT INTO `aphs_vocabulary` VALUES (5625,'ru','_THUMBNAIL','Thumbnail');
INSERT INTO `aphs_vocabulary` VALUES (5626,'ru','_THURSDAY','Thursday');
INSERT INTO `aphs_vocabulary` VALUES (5627,'ru','_TIME_PERIOD_OVERLAPPING_ALERT','This period of time (fully or partially) was already selected! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (5628,'ru','_TIME_ZONE','Time Zone');
INSERT INTO `aphs_vocabulary` VALUES (5629,'ru','_TO','To');
INSERT INTO `aphs_vocabulary` VALUES (5630,'ru','_TODAY','Today');
INSERT INTO `aphs_vocabulary` VALUES (5631,'ru','_TOP','Top');
INSERT INTO `aphs_vocabulary` VALUES (5632,'ru','_TOTAL','Total');
INSERT INTO `aphs_vocabulary` VALUES (5633,'ru','_TOTAL_PRICE','Total Price');
INSERT INTO `aphs_vocabulary` VALUES (5634,'ru','_TOTAL_ROOMS','Total Rooms');
INSERT INTO `aphs_vocabulary` VALUES (5635,'ru','_TRANSACTION','Transaction');
INSERT INTO `aphs_vocabulary` VALUES (5636,'ru','_TRANSLATE_VIA_GOOGLE','Translate via Google');
INSERT INTO `aphs_vocabulary` VALUES (5637,'ru','_TRASH','Trash');
INSERT INTO `aphs_vocabulary` VALUES (5638,'ru','_TRASH_PAGES','Trash Pages');
INSERT INTO `aphs_vocabulary` VALUES (5639,'ru','_TRUNCATE_RELATED_TABLES','Truncate related tables?');
INSERT INTO `aphs_vocabulary` VALUES (5640,'ru','_TRY_LATER','An error occurred while executing. Please try again later!');
INSERT INTO `aphs_vocabulary` VALUES (5641,'ru','_TRY_SYSTEM_SUGGESTION','Try out system suggestion');
INSERT INTO `aphs_vocabulary` VALUES (5642,'ru','_TU','Tu');
INSERT INTO `aphs_vocabulary` VALUES (5643,'ru','_TUE','Tue');
INSERT INTO `aphs_vocabulary` VALUES (5644,'ru','_TUESDAY','Tuesday');
INSERT INTO `aphs_vocabulary` VALUES (5645,'ru','_TYPE','Type');
INSERT INTO `aphs_vocabulary` VALUES (5646,'ru','_TYPE_CHARS','Type the characters you see in the picture');
INSERT INTO `aphs_vocabulary` VALUES (5647,'ru','_UNCATEGORIZED','Uncategorized');
INSERT INTO `aphs_vocabulary` VALUES (5648,'ru','_UNDEFINED','undefined');
INSERT INTO `aphs_vocabulary` VALUES (5649,'ru','_UNINSTALL','Uninstall');
INSERT INTO `aphs_vocabulary` VALUES (5650,'ru','_UNITS','Units');
INSERT INTO `aphs_vocabulary` VALUES (5651,'ru','_UNIT_PRICE','Unit Price');
INSERT INTO `aphs_vocabulary` VALUES (5652,'ru','_UNKNOWN','Unknown');
INSERT INTO `aphs_vocabulary` VALUES (5653,'ru','_UNSUBSCRIBE','Unsubscribe');
INSERT INTO `aphs_vocabulary` VALUES (5654,'ru','_UP','Up');
INSERT INTO `aphs_vocabulary` VALUES (5655,'ru','_UPDATING_ACCOUNT','Updating Account');
INSERT INTO `aphs_vocabulary` VALUES (5656,'ru','_UPDATING_ACCOUNT_ERROR','An error occurred while updating your account! Please try again later or send information about this error to administration of the site.');
INSERT INTO `aphs_vocabulary` VALUES (5657,'ru','_UPDATING_OPERATION_COMPLETED','Updating operation was successfully completed!');
INSERT INTO `aphs_vocabulary` VALUES (5658,'ru','_UPLOAD','Upload');
INSERT INTO `aphs_vocabulary` VALUES (5659,'ru','_UPLOAD_AND_PROCCESS','Upload and Process');
INSERT INTO `aphs_vocabulary` VALUES (5660,'ru','_UPLOAD_FROM_FILE','Upload from File');
INSERT INTO `aphs_vocabulary` VALUES (5661,'ru','_URL','URL');
INSERT INTO `aphs_vocabulary` VALUES (5662,'ru','_USED_ON','Used On');
INSERT INTO `aphs_vocabulary` VALUES (5663,'ru','_USERNAME','Username');
INSERT INTO `aphs_vocabulary` VALUES (5664,'ru','_USERNAME_AND_PASSWORD','Username & Password');
INSERT INTO `aphs_vocabulary` VALUES (5665,'ru','_USERNAME_EMPTY_ALERT','Username cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5666,'ru','_USERNAME_LENGTH_ALERT','The length of username cannot be less than 4 characters! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5667,'ru','_USERS','Users');
INSERT INTO `aphs_vocabulary` VALUES (5668,'ru','_USER_EMAIL_EXISTS_ALERT','User with such email already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (5669,'ru','_USER_EXISTS_ALERT','User with such username already exists! Please choose another.');
INSERT INTO `aphs_vocabulary` VALUES (5670,'ru','_USER_NAME','User name');
INSERT INTO `aphs_vocabulary` VALUES (5671,'ru','_USE_THIS_PASSWORD','Use this password');
INSERT INTO `aphs_vocabulary` VALUES (5672,'ru','_VALUE','Value');
INSERT INTO `aphs_vocabulary` VALUES (5673,'ru','_VAT','VAT');
INSERT INTO `aphs_vocabulary` VALUES (5674,'ru','_VAT_PERCENT','VAT Percent');
INSERT INTO `aphs_vocabulary` VALUES (5675,'ru','_VERSION','Version');
INSERT INTO `aphs_vocabulary` VALUES (5676,'ru','_VIDEO','Video');
INSERT INTO `aphs_vocabulary` VALUES (5677,'ru','_VIEW_WORD','View');
INSERT INTO `aphs_vocabulary` VALUES (5678,'ru','_VISITOR','Visitor');
INSERT INTO `aphs_vocabulary` VALUES (5679,'ru','_VISUAL_SETTINGS','Visual Settings');
INSERT INTO `aphs_vocabulary` VALUES (5680,'ru','_VOCABULARY','Vocabulary');
INSERT INTO `aphs_vocabulary` VALUES (5681,'ru','_VOC_KEYS_UPDATED','Operation was successfully completed. Updated: _KEYS_ keys. Click <a href=\'index.php?admin=vocabulary&filter_by=A\'>here</a> to refresh the site.');
INSERT INTO `aphs_vocabulary` VALUES (5682,'ru','_VOC_KEY_UPDATED','Vocabulary key was successfully updated.');
INSERT INTO `aphs_vocabulary` VALUES (5683,'ru','_VOC_KEY_VALUE_EMPTY','Key value cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5684,'ru','_VOC_NOT_FOUND','No keys found');
INSERT INTO `aphs_vocabulary` VALUES (5685,'ru','_VOC_UPDATED','Vocabulary was successfully updated. Click <a href=index.php>here</a> to refresh the site.');
INSERT INTO `aphs_vocabulary` VALUES (5686,'ru','_WE','We');
INSERT INTO `aphs_vocabulary` VALUES (5687,'ru','_WEB_SITE','Web Site');
INSERT INTO `aphs_vocabulary` VALUES (5688,'ru','_WED','Wed');
INSERT INTO `aphs_vocabulary` VALUES (5689,'ru','_WEDNESDAY','Wednesday');
INSERT INTO `aphs_vocabulary` VALUES (5690,'ru','_WEEK_START_DAY','Week Start Day');
INSERT INTO `aphs_vocabulary` VALUES (5691,'ru','_WELCOME_CUSTOMER_TEXT','<p>Hello <b>_FIRST_NAME_ _LAST_NAME_</b>!</p>        \r\n<p>Welcome to Customer Account Panel, that allows you to view account status, manage your account settings and bookings.</p>\r\n<p>\r\n   _TODAY_<br />\r\n   _LAST_LOGIN_\r\n</p>				\r\n<p> <b>&#8226;</b> To view this account summary just click on a <a href=\'index.php?customer=home\'>Dashboard</a> link.</p>\r\n<p> <b>&#8226;</b> <a href=\'index.php?customer=my_account\'>Edit My Account</a> menu allows you to change your personal info and account data.</p>\r\n<p> <b>&#8226;</b> <a href=\'index.php?customer=my_bookings\'>My Bookings</a> contains information about your orders.</p>\r\n<p><br /></p>');
INSERT INTO `aphs_vocabulary` VALUES (5692,'ru','_WHAT_IS_CVV','What is CVV');
INSERT INTO `aphs_vocabulary` VALUES (5693,'ru','_WHOLE_SITE','Whole site');
INSERT INTO `aphs_vocabulary` VALUES (5694,'ru','_WITHOUT_ACCOUNT','without account');
INSERT INTO `aphs_vocabulary` VALUES (5695,'ru','_WRONG_BOOKING_NUMBER','The booking number you\'ve entered was not found! Please enter a valid booking number.');
INSERT INTO `aphs_vocabulary` VALUES (5696,'ru','_WRONG_CHECKOUT_DATE_ALERT','Wrong date selected! Please choose a valid check-out date.');
INSERT INTO `aphs_vocabulary` VALUES (5697,'ru','_WRONG_CODE_ALERT','Sorry, the code you have entered was invalid! Please try again.');
INSERT INTO `aphs_vocabulary` VALUES (5698,'ru','_WRONG_CONFIRMATION_CODE','Wrong confirmation code or your registration was already confirmed!');
INSERT INTO `aphs_vocabulary` VALUES (5699,'ru','_WRONG_COUPON_CODE','This coupon code is invalid or has expired!');
INSERT INTO `aphs_vocabulary` VALUES (5700,'ru','_WRONG_FILE_TYPE','Uploaded file is not a valid PHP vocabulary file! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5701,'ru','_WRONG_LOGIN','Wrong username or password!');
INSERT INTO `aphs_vocabulary` VALUES (5702,'ru','_WRONG_PARAMETER_PASSED','Wrong parameters passed - cannot complete operation!');
INSERT INTO `aphs_vocabulary` VALUES (5703,'ru','_WYSIWYG_EDITOR','WYSIWYG Editor');
INSERT INTO `aphs_vocabulary` VALUES (5704,'ru','_YEAR','Year');
INSERT INTO `aphs_vocabulary` VALUES (5705,'ru','_YES','Yes');
INSERT INTO `aphs_vocabulary` VALUES (5706,'ru','_YOUR_EMAIL','Your Email');
INSERT INTO `aphs_vocabulary` VALUES (5707,'ru','_YOUR_NAME','Your Name');
INSERT INTO `aphs_vocabulary` VALUES (5708,'ru','_YOU_ARE_LOGGED_AS','You are logged in as');
INSERT INTO `aphs_vocabulary` VALUES (5709,'ru','_ZIPCODE_EMPTY_ALERT','Zip/Postal code cannot be empty! Please re-enter.');
INSERT INTO `aphs_vocabulary` VALUES (5710,'ru','_ZIP_CODE','Zip/Postal code');
/*!40000 ALTER TABLE `aphs_vocabulary` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


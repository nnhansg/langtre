
RENAME TABLE  `<DB_PREFIX>hotel` TO  `<DB_PREFIX>hotels` ;
ALTER TABLE  `<DB_PREFIX>hotels` ADD  `is_active` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '1' AFTER  `map_code` ;
ALTER TABLE  `<DB_PREFIX>hotels` ADD  `priority_order` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `map_code`;
ALTER TABLE  `<DB_PREFIX>hotels` ADD  `is_default` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `priority_order` ;
ALTER TABLE  `<DB_PREFIX>hotels` CHANGE  `id`  `id` SMALLINT( 6 ) NOT NULL AUTO_INCREMENT ;
ALTER TABLE  `<DB_PREFIX>hotels` ADD PRIMARY KEY (  `id` ) ;
ALTER TABLE  `<DB_PREFIX>hotels` ADD  `hotel_image` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL  DEFAULT '' AFTER  `map_code` ;
ALTER TABLE  `<DB_PREFIX>hotels` ADD  `hotel_image_thumb` VARCHAR( 70 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' AFTER  `hotel_image` ;
ALTER TABLE  `<DB_PREFIX>hotels` ADD  `stars` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '3' AFTER  `hotel_image_thumb` ;
ALTER TABLE  `<DB_PREFIX>hotels` ADD  `hotel_location_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `id` , ADD INDEX (  `hotel_location_id` );
ALTER TABLE  `<DB_PREFIX>hotels` ADD  `email` VARCHAR( 70 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '' AFTER  `fax`;
ALTER TABLE  `<DB_PREFIX>hotels` CHANGE  `time_zone`  `time_zone` VARCHAR( 5 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;


RENAME TABLE  `<DB_PREFIX>hotel_description` TO  `<DB_PREFIX>hotels_description` ;
ALTER TABLE  `<DB_PREFIX>hotels_description` DROP INDEX  `id` ;
ALTER TABLE  `<DB_PREFIX>hotels_description` ADD INDEX (  `hotel_id` ,  `language_id` ) ;


ALTER TABLE  `<DB_PREFIX>rooms` ADD  `hotel_id` SMALLINT( 6 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `id` ;


INSERT INTO  `<DB_PREFIX>roles` (`id` ,`code` ,`name` ,`description`)VALUES (NULL ,  'hotelowner',  'Hotel Owner',  'The "Hotel Owner" is the owner of the hotel, has special privileges to the hotels/rooms he/she assigned to.' );
INSERT INTO  `<DB_PREFIX>privileges` (`id` ,`code` ,`name` ,`description`) VALUES (NULL ,  'edit_hotel_info',  'Manage Hotels',  'See and modify the hotels info'), (NULL ,  'edit_hotel_rooms',  'Manage Hotel Rooms',  'See and modify the hotel rooms info'), (NULL ,  'view_hotel_reports',  'See Hotel Reports',  'See only reports related to assigned hotel');
INSERT INTO  `<DB_PREFIX>role_privileges` (`id`, `role_id`, `privilege_id`, `is_active`) VALUES (NULL, '4', '7', '1'), (NULL, '4', '8', '1'), (NULL, '4', '9', '1');


ALTER TABLE  `<DB_PREFIX>accounts` CHANGE  `account_type`  `account_type` ENUM(  'owner',  'mainadmin',  'admin',  'hotelowner' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT  'mainadmin' ;
ALTER TABLE  `<DB_PREFIX>accounts` ADD  `hotels` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '' AFTER  `account_type` ;


UPDATE  `<DB_PREFIX>modules` SET  `management_access_by` =  'owner,mainadmin' WHERE  `name` = 'backup';
UPDATE  `<DB_PREFIX>modules` SET  `management_access_by` =  'owner,mainadmin' WHERE  `name` = 'banners';
UPDATE  `<DB_PREFIX>modules` SET  `module_tables` =  'rooms,rooms_availabilities,rooms_description,rooms_prices,room_facilities,room_facilities_description' WHERE  `name` = 'rooms';


UPDATE  `<DB_PREFIX>modules_settings` SET  `settings_value` =  'global', `key_display_type` =  'enum', `key_display_source` =  'front-end,back-end,global,no' WHERE  `id` =5;

INSERT INTO `<DB_PREFIX>modules_settings` (`id`, `module_name`, `settings_key`, `settings_value`, `settings_name`, `settings_description_const`, `key_display_type`, `key_is_required`, `key_display_source`) VALUES
(NULL, 'rooms', 'allow_children', 'yes', 'Allow Children in Room', '_MS_ALLOW_CHILDREN_IN_ROOM', 'yes/no', 1, ''),
(NULL, 'rooms', 'allow_guests', 'yes', 'Allow Guests in Room', '_MS_ALLOW_GUESTS_IN_ROOM', 'yes/no', 1, '');

DELETE FROM `<DB_PREFIX>modules_settings` WHERE `settings_key` = 'show_children_number';


ALTER TABLE  `<DB_PREFIX>bookings_rooms` ADD  `hotel_id` SMALLINT( 6 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `booking_number` , ADD INDEX (  `hotel_id` ) ;
ALTER TABLE  `<DB_PREFIX>bookings_rooms` ADD  `guests` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `price` ;
ALTER TABLE  `<DB_PREFIX>bookings_rooms` ADD  `guests_fee` DECIMAL( 10, 2 ) UNSIGNED NOT NULL DEFAULT  '0.00' AFTER  `guests` ;


ALTER TABLE  `<DB_PREFIX>countries` CHANGE  `abbrv`  `abbrv` VARCHAR( 2 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;


CREATE TABLE IF NOT EXISTS `<DB_PREFIX>hotels_locations` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `country_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `priority_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `<DB_PREFIX>hotels_locations_description`;
CREATE TABLE IF NOT EXISTS `<DB_PREFIX>hotels_locations_description` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `hotel_location_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hotel_location_id` (`hotel_location_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;


DROP TABLE IF EXISTS `<DB_PREFIX>room_facilities`;
CREATE TABLE IF NOT EXISTS `<DB_PREFIX>room_facilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `priority_order` smallint(6) unsigned NOT NULL DEFAULT '0',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

INSERT INTO `<DB_PREFIX>room_facilities` (`id`, `priority_order`, `is_active`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1),
(16, 16, 1),
(17, 17, 1),
(18, 18, 1),
(19, 19, 1);


DROP TABLE IF EXISTS `<DB_PREFIX>room_facilities_description`;
CREATE TABLE IF NOT EXISTS `<DB_PREFIX>room_facilities_description` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `room_facility_id` int(10) unsigned NOT NULL DEFAULT '0',
  `language_id` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=58 ;

INSERT INTO `<DB_PREFIX>room_facilities_description` (`id`, `room_facility_id`, `language_id`, `name`, `description`) VALUES
(1, 4, 'en', 'Smoking Allowed', ''),
(2, 4, 'es', 'Se permite fumar', ''),
(3, 4, 'de', 'Rauchen erlaubt', ''),
(4, 5, 'en', 'Elevator in Building', ''),
(5, 5, 'es', 'Ascensor en el Edificio', ''),
(6, 5, 'de', 'Aufzug im Gebäude', ''),
(7, 7, 'es', 'Whirlpool', ''),
(8, 7, 'en', 'Hot Tub', ''),
(9, 7, 'de', 'Jacuzzi', ''),
(10, 8, 'en', 'Pets allowed', ''),
(11, 8, 'es', 'Se admiten mascotas', ''),
(12, 8, 'de', 'Haustiere erlaubt', ''),
(13, 9, 'en', 'Handicap Accessible', ''),
(14, 9, 'es', 'Accesible para discapacitados', ''),
(15, 9, 'de', 'Behindertenzugang', ''),
(16, 10, 'en', 'Indoor Fireplace', ''),
(17, 10, 'es', 'Chimenea de interior', ''),
(18, 10, 'de', 'Indoor Kamin', ''),
(19, 11, 'en', 'TV', ''),
(20, 11, 'es', 'TV', ''),
(21, 11, 'de', 'Fernseher', ''),
(22, 12, 'en', 'Pool', ''),
(23, 12, 'es', 'Piscina', ''),
(24, 12, 'de', 'Schwimmbad', ''),
(25, 13, 'en', 'Buzzer/Wireless Intercom', ''),
(26, 13, 'es', 'Timbre/Interfono inalámbrico', ''),
(27, 13, 'de', 'Summer/Wireless Intercom', ''),
(28, 15, 'es', 'Televisión por cable', ''),
(29, 15, 'en', 'Cable TV', ''),
(30, 15, 'de', 'Kabelfernsehen', ''),
(31, 16, 'en', 'Kitchen', ''),
(32, 16, 'es', 'Cocina', ''),
(33, 16, 'de', 'Küche', ''),
(34, 17, 'en', 'Internet', ''),
(35, 17, 'es', 'Internet', ''),
(36, 17, 'de', 'Internet', ''),
(37, 18, 'en', 'Parking Included', ''),
(38, 18, 'es', 'Parking incluido', ''),
(39, 18, 'de', 'Parkplätze inklusive', ''),
(40, 19, 'en', 'Family/Kid Friendly', ''),
(41, 19, 'es', 'Family/Kid Friendly', ''),
(42, 19, 'de', 'Familien-/Kinderfreundlich', ''),
(43, 20, 'en', 'Wireless Internet', ''),
(44, 20, 'es', 'Internet inalámbrico', ''),
(45, 20, 'de', 'WLAN', ''),
(46, 21, 'en', 'Washer/Dryer', ''),
(47, 21, 'es', 'Lavadora/Secadora', ''),
(48, 21, 'de', 'Waschmaschine/Trockner', ''),
(49, 22, 'en', 'Suitable for Events', ''),
(50, 22, 'es', 'Apto para Eventos', ''),
(51, 22, 'de', 'Geeignet für Events', ''),
(52, 23, 'en', 'Air Conditioning', ''),
(53, 23, 'es', 'Aire acondicionado', ''),
(54, 23, 'de', 'Klimaanlage', ''),
(55, 24, 'en', 'Heating', ''),
(56, 24, 'es', 'Calefacción', ''),
(57, 24, 'de', 'Heizung', '');


ALTER TABLE  `<DB_PREFIX>settings` CHANGE  `time_zone`  `time_zone` VARCHAR( 5 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  '0';
ALTER TABLE  `<DB_PREFIX>settings` CHANGE  `smtp_username`  `smtp_username` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;
ALTER TABLE  `<DB_PREFIX>settings` ADD  `smtp_secure` ENUM(  'ssl',  'no' ) NOT NULL DEFAULT  'ssl' AFTER  `mailer_wysiwyg_type`;


ALTER TABLE  `<DB_PREFIX>meal_plans` ADD  `hotel_id` SMALLINT( 6 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `id`;


ALTER TABLE  `<DB_PREFIX>rooms` ADD  `max_guests` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `max_adults`;
ALTER TABLE  `<DB_PREFIX>rooms` ADD  `additional_guest_fee` DECIMAL( 10, 2 ) UNSIGNED NOT NULL AFTER  `default_price`;


ALTER TABLE  `<DB_PREFIX>rooms_prices` ADD  `adults` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `date_to`;
ALTER TABLE  `<DB_PREFIX>rooms_prices` ADD  `children` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `adults`;
ALTER TABLE  `<DB_PREFIX>rooms_prices` ADD  `guest_fee` DECIMAL( 10, 2 ) UNSIGNED NOT NULL DEFAULT  '0.00' AFTER  `children`;


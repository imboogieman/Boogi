/*
Navicat MySQL Data Transfer

Source Server         : manti.by
Source Server Version : 50531
Source Host           : localhost:3306
Source Database       : starway_dev

Target Server Type    : MYSQL
Target Server Version : 50531
File Encoding         : 65001

Date: 2014-01-14 12:30:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for artist
-- ----------------------------
DROP TABLE IF EXISTS `artist`;
CREATE TABLE `artist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `description` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `fb_id` bigint(20) DEFAULT '0' COMMENT 'Facebook ID',
  `sc_name` varchar(255) DEFAULT NULL COMMENT 'Soundcloud username',
  `tw_name` varchar(255) DEFAULT NULL COMMENT 'Twitter username',
  `mc_name` varchar(255) DEFAULT NULL COMMENT 'Mixcloud username',
  `gt_name` varchar(255) DEFAULT NULL COMMENT 'Gigatools username',
  `data_provider` varchar(32) DEFAULT 'facebook' COMMENT 'Gig data provider',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of artist
-- ----------------------------
INSERT INTO `artist` VALUES ('2', '', 'Maceo Plex', 'Miami', '2013-12-03 09:40:25', '40.714401', '-74.005997', '121776084502627', 'maceoplex', null, null, null, 'facebook');
INSERT INTO `artist` VALUES ('3', '', 'Solomun', 'Hamburg, Germany', '2013-12-04 09:14:23', '53.551102', '9.993700', '127959800604028', 'solomun', null, null, null, 'gigatools');
INSERT INTO `artist` VALUES ('4', '', 'Nicolas Jaar', null, '2013-12-04 09:27:09', '40.714401', '-74.005997', '15727540611', 'nicolas-jaar', null, null, null, 'custom');
INSERT INTO `artist` VALUES ('5', '', 'KOLLEKTIV TURMSTRASSE', null, '2013-12-03 09:44:26', '52.519199', '13.406100', '60920193415', 'kollektivturmstrasse', null, null, null, 'facebook');
INSERT INTO `artist` VALUES ('7', '', 'Boris Brejcha', 'Frankenthal, Germany', '2013-12-04 09:16:09', '49.549999', '8.350000', '56409148326', 'boris-brejcha', 'Boris_Brejcha', null, 'boris8000', 'gigatools');
INSERT INTO `artist` VALUES ('8', '', 'Robert Owens', 'Chicago, IL, USA', '2013-12-04 09:27:20', '41.878113', '-87.629799', '167358279947609', null, 'robertowens7927', null, null, 'custom');
INSERT INTO `artist` VALUES ('9', '', 'Stephan Bodzin', 'Lisbon, Portugal', '2013-12-04 09:17:13', '38.725300', '-9.150036', '14923366771', 'stephanbodzin', null, null, null, 'gigatools');
INSERT INTO `artist` VALUES ('10', '', 'Justin Martin', 'Weha, 95506 Kastl, Germany', '2013-12-04 09:17:29', '49.827766', '11.875106', '133990003325183', 'justin-martin-music', null, null, null, 'bandpage');
INSERT INTO `artist` VALUES ('11', '', 'Hot Since 82', 'Leeds, West Yorkshire, UK', '2013-12-03 09:47:58', '53.801277', '-1.548567', '169716129753913', 'hotsince-82', null, null, null, 'facebook');
INSERT INTO `artist` VALUES ('13', null, 'Soul Clap', 'Outer Drive, Cocoa, FL 32926, USA', '2013-12-04 09:18:11', '28.380301', '-80.809242', '21021702448', 'soulclap', null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('14', null, 'TONE of ARC', 'San Francisco, CA, USA', '2013-12-04 09:18:36', '37.774929', '-122.419418', '206988806053907', 'toneofarc', null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('15', null, 'Portable aka Bodycode', 'Berlin, Germany', '2013-12-04 09:18:58', '52.520008', '13.404954', '121545827886922', 'portable-aka-bodycode', null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('16', null, 'Onur Engin', 'Istanbul, Turkey', '2013-12-04 09:27:11', '41.005268', '28.976959', '124049130972868', 'onur-engin', null, null, null, 'custom');
INSERT INTO `artist` VALUES ('17', null, 'DJ Harvey', 'London Street, Los Angeles, CA 90026, USA', '2013-12-04 09:27:14', '34.076832', '-118.277840', '88409697422', null, null, null, null, 'custom');
INSERT INTO `artist` VALUES ('18', null, 'Mark E', 'Wolverhampton, West Midlands, UK', '2013-12-02 14:06:34', '52.586971', '-2.128820', '342707501038', null, null, null, null, 'facebook');
INSERT INTO `artist` VALUES ('19', null, 'Todd Terje', 'Oslo, Norway', '2013-12-04 09:27:01', '59.913868', '10.752245', '65492833412', null, null, null, null, 'custom');
INSERT INTO `artist` VALUES ('20', null, 'Morgan Geist', null, '2013-12-04 09:27:05', null, null, '11917214850', null, null, null, null, 'custom');
INSERT INTO `artist` VALUES ('21', null, 'Duke Dumont', 'England, UK', '2013-12-04 09:22:06', '52.355518', '-1.174320', '20220408026', null, null, null, null, 'gigatools');
INSERT INTO `artist` VALUES ('22', null, 'Disclosure', 'Reigate, Surrey, UK', '2013-12-04 09:22:39', '51.237274', '-0.205883', '137029526330648', null, null, null, null, 'songkick');
INSERT INTO `artist` VALUES ('23', null, 'Klaxons', 'London, UK', '2013-12-02 14:06:39', '51.511215', '-0.119824', '15106420351', null, null, null, null, 'facebook');
INSERT INTO `artist` VALUES ('24', null, 'The xx', 'London, UK', '2013-12-04 09:24:14', '51.511215', '-0.119824', '10429446003', null, null, null, null, 'crowdsurge');
INSERT INTO `artist` VALUES ('25', null, 'Dusky', null, '2013-12-04 09:25:03', null, null, '153915844674108', null, null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('26', null, 'DJ Zinc', 'London, UK', '2013-12-04 09:25:51', '51.511215', '-0.119824', '209393620820', null, null, null, null, 'gigatools');
INSERT INTO `artist` VALUES ('27', null, 'Boys Noize', 'Berlin, Germany', '2013-12-04 09:26:19', '52.520008', '13.404954', '12350780802', null, null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('28', null, 'Vitalic Official', null, '2013-12-04 09:26:59', null, null, '99885177076', null, null, null, null, 'custom');
INSERT INTO `artist` VALUES ('29', null, 'Tiga', null, '2013-12-02 14:06:46', null, null, '57755305836', null, null, null, null, 'facebook');
INSERT INTO `artist` VALUES ('30', null, 'Agoria', 'France', '2013-12-04 09:29:01', '46.227638', '2.213749', '20312443122', null, null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('31', null, 'Guy J', 'Tel Aviv, Israel', '2013-12-04 09:29:25', '32.066158', '34.777821', '47087533517', null, null, null, null, 'gigatools');
INSERT INTO `artist` VALUES ('32', null, 'Trentemøller', null, '2013-12-04 09:30:05', null, null, '22850309064', null, null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('34', null, 'Jimpster', null, '2013-12-04 09:30:27', null, null, '139035726133180', null, null, null, null, 'gigatools');
INSERT INTO `artist` VALUES ('35', null, 'Marco V', null, '2013-12-04 09:31:37', null, null, '151364708207493', null, null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('36', null, 'Sasse', 'Berlin, Germany', '2013-12-04 09:31:54', '52.520008', '13.404954', '149590818430671', null, null, null, null, 'gigatools');
INSERT INTO `artist` VALUES ('37', null, 'Marc Romboy', 'Mönchengladbach, Germany', '2013-12-04 09:32:06', '51.180458', '6.442804', '36962943568', null, null, null, null, 'gigatools');
INSERT INTO `artist` VALUES ('38', null, 'Rodriguez Jr', null, '2013-12-04 09:32:20', null, null, '32204721637', null, null, null, null, 'gigatools');
INSERT INTO `artist` VALUES ('47', null, 'King Krule', null, '2013-12-04 09:32:52', null, null, '266120763398451', null, null, null, null, 'custom');
INSERT INTO `artist` VALUES ('48', null, 'The Rapture', null, '2013-12-02 14:06:58', null, null, '133896639724', null, null, null, null, 'facebook');
INSERT INTO `artist` VALUES ('49', null, 'BONAPARTE', 'homeless, the world, st. helena', '2013-12-02 14:06:59', null, null, '44689108683', null, null, null, null, 'facebook');
INSERT INTO `artist` VALUES ('50', null, 'The Drums', null, '2013-12-04 09:33:59', null, null, '74425214853', null, null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('51', null, 'Ellen Allien Official Fanpage', 'Berlin, Germany', '2013-12-04 09:34:16', '52.520008', '13.404954', '259015572688', null, null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('52', null, 'Digitaria', 'Cydonia / Mars', '2013-12-04 09:34:37', null, null, '7011011039', null, null, null, null, 'gigatools');
INSERT INTO `artist` VALUES ('53', null, 'Kate Simko', 'Chicago, IL, USA', '2013-12-04 09:34:58', '41.878113', '-87.629799', '95289290299', null, null, null, null, 'bandsintown');
INSERT INTO `artist` VALUES ('54', null, 'Tania Vulcano (OFFICIAL)', 'Montevideo, Uruguay', '2013-12-04 09:36:12', '-34.883610', '-56.181946', '152902551435441', null, null, null, null, 'reverbnation');
INSERT INTO `artist` VALUES ('55', null, 'Timo Maas', null, '2013-12-04 09:37:35', null, null, '130089487611', null, null, null, null, 'bandpage');

-- ----------------------------
-- Table structure for artist_file
-- ----------------------------
DROP TABLE IF EXISTS `artist_file`;
CREATE TABLE `artist_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_artist_file_artist_id` (`artist_id`),
  KEY `fk_artist_file_file_id` (`file_id`),
  CONSTRAINT `fk_artist_file_artist_id` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_artist_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of artist_file
-- ----------------------------
INSERT INTO `artist_file` VALUES ('3', '2', '11', '2013-10-25 00:47:58');
INSERT INTO `artist_file` VALUES ('4', '3', '12', '2013-10-25 01:06:44');
INSERT INTO `artist_file` VALUES ('5', '4', '13', '2013-10-25 01:08:23');
INSERT INTO `artist_file` VALUES ('6', '5', '14', '2013-10-25 01:09:45');
INSERT INTO `artist_file` VALUES ('7', '6', '15', '2013-10-25 01:11:28');
INSERT INTO `artist_file` VALUES ('8', '7', '16', '2013-10-25 01:13:36');

-- ----------------------------
-- Table structure for artist_gig
-- ----------------------------
DROP TABLE IF EXISTS `artist_gig`;
CREATE TABLE `artist_gig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_artist_gig_artist_id` (`artist_id`),
  KEY `fk_artist_gig_gig_id` (`gig_id`),
  CONSTRAINT `fk_artist_gig_artist_id` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_artist_gig_gig_id` FOREIGN KEY (`gig_id`) REFERENCES `gig` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of artist_gig
-- ----------------------------
INSERT INTO `artist_gig` VALUES ('141', '5', '29', '2014-01-05 22:38:27');
INSERT INTO `artist_gig` VALUES ('170', '5', '31', '2014-01-06 18:41:43');
INSERT INTO `artist_gig` VALUES ('208', '5', '2', '2014-01-08 06:00:17');
INSERT INTO `artist_gig` VALUES ('209', '5', '3', '2014-01-08 06:00:19');
INSERT INTO `artist_gig` VALUES ('210', '5', '4', '2014-01-08 06:00:20');
INSERT INTO `artist_gig` VALUES ('211', '5', '5', '2014-01-08 06:00:21');
INSERT INTO `artist_gig` VALUES ('212', '5', '6', '2014-01-08 06:00:28');
INSERT INTO `artist_gig` VALUES ('213', '5', '7', '2014-01-08 06:00:34');
INSERT INTO `artist_gig` VALUES ('214', '5', '8', '2014-01-08 06:00:36');
INSERT INTO `artist_gig` VALUES ('215', '5', '9', '2014-01-08 06:00:37');
INSERT INTO `artist_gig` VALUES ('216', '5', '10', '2014-01-08 06:00:39');
INSERT INTO `artist_gig` VALUES ('217', '5', '11', '2014-01-08 06:00:41');
INSERT INTO `artist_gig` VALUES ('218', '5', '12', '2014-01-08 06:00:42');
INSERT INTO `artist_gig` VALUES ('219', '5', '13', '2014-01-08 06:00:43');
INSERT INTO `artist_gig` VALUES ('220', '5', '14', '2014-01-08 06:00:44');
INSERT INTO `artist_gig` VALUES ('221', '5', '15', '2014-01-08 06:00:45');
INSERT INTO `artist_gig` VALUES ('222', '5', '16', '2014-01-08 06:00:47');
INSERT INTO `artist_gig` VALUES ('223', '11', '32', '2014-01-08 06:00:55');
INSERT INTO `artist_gig` VALUES ('224', '11', '33', '2014-01-08 06:00:58');
INSERT INTO `artist_gig` VALUES ('225', '11', '34', '2014-01-08 06:00:59');
INSERT INTO `artist_gig` VALUES ('226', '11', '35', '2014-01-08 06:01:10');
INSERT INTO `artist_gig` VALUES ('227', '11', '36', '2014-01-08 06:01:11');
INSERT INTO `artist_gig` VALUES ('228', '11', '37', '2014-01-08 06:01:13');
INSERT INTO `artist_gig` VALUES ('229', '11', '38', '2014-01-08 06:01:14');
INSERT INTO `artist_gig` VALUES ('230', '11', '39', '2014-01-08 06:01:21');
INSERT INTO `artist_gig` VALUES ('231', '11', '17', '2014-01-08 06:01:22');
INSERT INTO `artist_gig` VALUES ('232', '11', '18', '2014-01-08 06:01:25');
INSERT INTO `artist_gig` VALUES ('233', '11', '40', '2014-01-08 06:01:26');
INSERT INTO `artist_gig` VALUES ('234', '11', '19', '2014-01-08 06:01:28');
INSERT INTO `artist_gig` VALUES ('235', '11', '20', '2014-01-08 06:01:35');
INSERT INTO `artist_gig` VALUES ('236', '11', '21', '2014-01-08 06:01:38');
INSERT INTO `artist_gig` VALUES ('237', '13', '30', '2014-01-08 06:01:40');
INSERT INTO `artist_gig` VALUES ('238', '29', '22', '2014-01-08 06:02:24');
INSERT INTO `artist_gig` VALUES ('239', '29', '23', '2014-01-08 06:02:25');
INSERT INTO `artist_gig` VALUES ('240', '49', '24', '2014-01-08 06:02:50');
INSERT INTO `artist_gig` VALUES ('241', '49', '25', '2014-01-08 06:02:51');
INSERT INTO `artist_gig` VALUES ('242', '49', '26', '2014-01-08 06:02:52');
INSERT INTO `artist_gig` VALUES ('243', '49', '27', '2014-01-08 06:02:53');
INSERT INTO `artist_gig` VALUES ('244', '55', '28', '2014-01-08 06:03:11');
INSERT INTO `artist_gig` VALUES ('245', '5', '41', '2014-01-13 14:54:46');
INSERT INTO `artist_gig` VALUES ('246', '5', '42', '2014-01-13 14:59:47');
INSERT INTO `artist_gig` VALUES ('247', '49', '43', '2014-01-13 15:01:50');

-- ----------------------------
-- Table structure for artist_promoter
-- ----------------------------
DROP TABLE IF EXISTS `artist_promoter`;
CREATE TABLE `artist_promoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) NOT NULL,
  `promoter_id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_artist_promoter_artist_id` (`artist_id`),
  KEY `fk_artist_promoter_promoter_id` (`promoter_id`),
  CONSTRAINT `fk_artist_promoter_artist_id` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_artist_promoter_promoter_id` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of artist_promoter
-- ----------------------------
INSERT INTO `artist_promoter` VALUES ('2', '7', '4', '2013-10-28 21:45:23');
INSERT INTO `artist_promoter` VALUES ('4', '8', '4', '2013-10-28 21:45:30');
INSERT INTO `artist_promoter` VALUES ('9', '3', '4', '2013-11-18 18:02:37');
INSERT INTO `artist_promoter` VALUES ('10', '10', '4', '2013-11-18 18:02:39');
INSERT INTO `artist_promoter` VALUES ('17', '22', '10', '2014-01-03 15:05:52');
INSERT INTO `artist_promoter` VALUES ('18', '19', '10', '2014-01-03 15:06:03');
INSERT INTO `artist_promoter` VALUES ('21', '5', '36', '2014-01-05 13:34:35');
INSERT INTO `artist_promoter` VALUES ('22', '49', '10', '2014-01-05 21:00:10');
INSERT INTO `artist_promoter` VALUES ('23', '5', '10', '2014-01-06 10:06:38');
INSERT INTO `artist_promoter` VALUES ('26', '11', '10', '2014-01-13 14:41:49');
INSERT INTO `artist_promoter` VALUES ('27', '5', '4', '2014-01-13 15:53:17');

-- ----------------------------
-- Table structure for country
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `iso2` varchar(2) NOT NULL,
  `iso3` varchar(3) NOT NULL,
  `numeric` int(3) unsigned NOT NULL,
  `standart` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO `country` VALUES ('1', 'Afghanistan', 'AF', 'AFG', '4', 'ISO 3166-2:AF');
INSERT INTO `country` VALUES ('2', 'Åland Islands', 'AX', 'ALA', '248', 'ISO 3166-2:AX');
INSERT INTO `country` VALUES ('3', 'Albania', 'AL', 'ALB', '8', 'ISO 3166-2:AL');
INSERT INTO `country` VALUES ('4', 'Algeria', 'DZ', 'DZA', '12', 'ISO 3166-2:DZ');
INSERT INTO `country` VALUES ('5', 'American Samoa', 'AS', 'ASM', '16', 'ISO 3166-2:AS');
INSERT INTO `country` VALUES ('6', 'Andorra', 'AD', 'AND', '20', 'ISO 3166-2:AD');
INSERT INTO `country` VALUES ('7', 'Angola', 'AO', 'AGO', '24', 'ISO 3166-2:AO');
INSERT INTO `country` VALUES ('8', 'Anguilla', 'AI', 'AIA', '660', 'ISO 3166-2:AI');
INSERT INTO `country` VALUES ('9', 'Antarctica', 'AQ', 'ATA', '10', 'ISO 3166-2:AQ');
INSERT INTO `country` VALUES ('10', 'Antigua and Barbuda', 'AG', 'ATG', '28', 'ISO 3166-2:AG');
INSERT INTO `country` VALUES ('11', 'Argentina', 'AR', 'ARG', '32', 'ISO 3166-2:AR');
INSERT INTO `country` VALUES ('12', 'Armenia', 'AM', 'ARM', '51', 'ISO 3166-2:AM');
INSERT INTO `country` VALUES ('13', 'Aruba', 'AW', 'ABW', '533', 'ISO 3166-2:AW');
INSERT INTO `country` VALUES ('14', 'Australia', 'AU', 'AUS', '36', 'ISO 3166-2:AU');
INSERT INTO `country` VALUES ('15', 'Austria', 'AT', 'AUT', '40', 'ISO 3166-2:AT');
INSERT INTO `country` VALUES ('16', 'Azerbaijan', 'AZ', 'AZE', '31', 'ISO 3166-2:AZ');
INSERT INTO `country` VALUES ('17', 'Bahamas', 'BS', 'BHS', '44', 'ISO 3166-2:BS');
INSERT INTO `country` VALUES ('18', 'Bahrain', 'BH', 'BHR', '48', 'ISO 3166-2:BH');
INSERT INTO `country` VALUES ('19', 'Bangladesh', 'BD', 'BGD', '50', 'ISO 3166-2:BD');
INSERT INTO `country` VALUES ('20', 'Barbados', 'BB', 'BRB', '52', 'ISO 3166-2:BB');
INSERT INTO `country` VALUES ('21', 'Belarus', 'BY', 'BLR', '112', 'ISO 3166-2:BY');
INSERT INTO `country` VALUES ('22', 'Belgium', 'BE', 'BEL', '56', 'ISO 3166-2:BE');
INSERT INTO `country` VALUES ('23', 'Belize', 'BZ', 'BLZ', '84', 'ISO 3166-2:BZ');
INSERT INTO `country` VALUES ('24', 'Benin', 'BJ', 'BEN', '204', 'ISO 3166-2:BJ');
INSERT INTO `country` VALUES ('25', 'Bermuda', 'BM', 'BMU', '60', 'ISO 3166-2:BM');
INSERT INTO `country` VALUES ('26', 'Bhutan', 'BT', 'BTN', '64', 'ISO 3166-2:BT');
INSERT INTO `country` VALUES ('27', 'Bolivia, Plurinational State of', 'BO', 'BOL', '68', 'ISO 3166-2:BO');
INSERT INTO `country` VALUES ('28', 'Bosnia and Herzegovina', 'BA', 'BIH', '70', 'ISO 3166-2:BA');
INSERT INTO `country` VALUES ('29', 'Botswana', 'BW', 'BWA', '72', 'ISO 3166-2:BW');
INSERT INTO `country` VALUES ('30', 'Bouvet Island', 'BV', 'BVT', '74', 'ISO 3166-2:BV');
INSERT INTO `country` VALUES ('31', 'Brazil', 'BR', 'BRA', '76', 'ISO 3166-2:BR');
INSERT INTO `country` VALUES ('32', 'British Indian Ocean Territory', 'IO', 'IOT', '86', 'ISO 3166-2:IO');
INSERT INTO `country` VALUES ('33', 'Brunei Darussalam', 'BN', 'BRN', '96', 'ISO 3166-2:BN');
INSERT INTO `country` VALUES ('34', 'Bulgaria', 'BG', 'BGR', '100', 'ISO 3166-2:BG');
INSERT INTO `country` VALUES ('35', 'Burkina Faso', 'BF', 'BFA', '854', 'ISO 3166-2:BF');
INSERT INTO `country` VALUES ('36', 'Burundi', 'BI', 'BDI', '108', 'ISO 3166-2:BI');
INSERT INTO `country` VALUES ('37', 'Cambodia', 'KH', 'KHM', '116', 'ISO 3166-2:KH');
INSERT INTO `country` VALUES ('38', 'Cameroon', 'CM', 'CMR', '120', 'ISO 3166-2:CM');
INSERT INTO `country` VALUES ('39', 'Canada', 'CA', 'CAN', '124', 'ISO 3166-2:CA');
INSERT INTO `country` VALUES ('40', 'Cape Verde', 'CV', 'CPV', '132', 'ISO 3166-2:CV');
INSERT INTO `country` VALUES ('41', 'Cayman Islands', 'KY', 'CYM', '136', 'ISO 3166-2:KY');
INSERT INTO `country` VALUES ('42', 'Central African Republic', 'CF', 'CAF', '140', 'ISO 3166-2:CF');
INSERT INTO `country` VALUES ('43', 'Chad', 'TD', 'TCD', '148', 'ISO 3166-2:TD');
INSERT INTO `country` VALUES ('44', 'Chile', 'CL', 'CHL', '152', 'ISO 3166-2:CL');
INSERT INTO `country` VALUES ('45', 'China', 'CN', 'CHN', '156', 'ISO 3166-2:CN');
INSERT INTO `country` VALUES ('46', 'Christmas Island', 'CX', 'CXR', '162', 'ISO 3166-2:CX');
INSERT INTO `country` VALUES ('47', 'Cocos (Keeling) Islands', 'CC', 'CCK', '166', 'ISO 3166-2:CC');
INSERT INTO `country` VALUES ('48', 'Colombia', 'CO', 'COL', '170', 'ISO 3166-2:CO');
INSERT INTO `country` VALUES ('49', 'Comoros', 'KM', 'COM', '174', 'ISO 3166-2:KM');
INSERT INTO `country` VALUES ('50', 'Congo', 'CG', 'COG', '178', 'ISO 3166-2:CG');
INSERT INTO `country` VALUES ('51', 'Congo, the Democratic Republic of the', 'CD', 'COD', '180', 'ISO 3166-2:CD');
INSERT INTO `country` VALUES ('52', 'Cook Islands', 'CK', 'COK', '184', 'ISO 3166-2:CK');
INSERT INTO `country` VALUES ('53', 'Costa Rica', 'CR', 'CRI', '188', 'ISO 3166-2:CR');
INSERT INTO `country` VALUES ('54', 'Côte d\'Ivoire', 'CI', 'CIV', '384', 'ISO 3166-2:CI');
INSERT INTO `country` VALUES ('55', 'Croatia', 'HR', 'HRV', '191', 'ISO 3166-2:HR');
INSERT INTO `country` VALUES ('56', 'Cuba', 'CU', 'CUB', '192', 'ISO 3166-2:CU');
INSERT INTO `country` VALUES ('57', 'Cyprus', 'CY', 'CYP', '196', 'ISO 3166-2:CY');
INSERT INTO `country` VALUES ('58', 'Czech Republic', 'CZ', 'CZE', '203', 'ISO 3166-2:CZ');
INSERT INTO `country` VALUES ('59', 'Denmark', 'DK', 'DNK', '208', 'ISO 3166-2:DK');
INSERT INTO `country` VALUES ('60', 'Djibouti', 'DJ', 'DJI', '262', 'ISO 3166-2:DJ');
INSERT INTO `country` VALUES ('61', 'Dominica', 'DM', 'DMA', '212', 'ISO 3166-2:DM');
INSERT INTO `country` VALUES ('62', 'Dominican Republic', 'DO', 'DOM', '214', 'ISO 3166-2:DO');
INSERT INTO `country` VALUES ('63', 'Ecuador', 'EC', 'ECU', '218', 'ISO 3166-2:EC');
INSERT INTO `country` VALUES ('64', 'Egypt', 'EG', 'EGY', '818', 'ISO 3166-2:EG');
INSERT INTO `country` VALUES ('65', 'El Salvador', 'SV', 'SLV', '222', 'ISO 3166-2:SV');
INSERT INTO `country` VALUES ('66', 'Equatorial Guinea', 'GQ', 'GNQ', '226', 'ISO 3166-2:GQ');
INSERT INTO `country` VALUES ('67', 'Eritrea', 'ER', 'ERI', '232', 'ISO 3166-2:ER');
INSERT INTO `country` VALUES ('68', 'Estonia', 'EE', 'EST', '233', 'ISO 3166-2:EE');
INSERT INTO `country` VALUES ('69', 'Ethiopia', 'ET', 'ETH', '231', 'ISO 3166-2:ET');
INSERT INTO `country` VALUES ('70', 'Falkland Islands (Malvinas)', 'FK', 'FLK', '238', 'ISO 3166-2:FK');
INSERT INTO `country` VALUES ('71', 'Faroe Islands', 'FO', 'FRO', '234', 'ISO 3166-2:FO');
INSERT INTO `country` VALUES ('72', 'Fiji', 'FJ', 'FJI', '242', 'ISO 3166-2:FJ');
INSERT INTO `country` VALUES ('73', 'Finland', 'FI', 'FIN', '246', 'ISO 3166-2:FI');
INSERT INTO `country` VALUES ('74', 'France', 'FR', 'FRA', '250', 'ISO 3166-2:FR');
INSERT INTO `country` VALUES ('75', 'French Guiana', 'GF', 'GUF', '254', 'ISO 3166-2:GF');
INSERT INTO `country` VALUES ('76', 'French Polynesia', 'PF', 'PYF', '258', 'ISO 3166-2:PF');
INSERT INTO `country` VALUES ('77', 'French Southern Territories', 'TF', 'ATF', '260', 'ISO 3166-2:TF');
INSERT INTO `country` VALUES ('78', 'Gabon', 'GA', 'GAB', '266', 'ISO 3166-2:GA');
INSERT INTO `country` VALUES ('79', 'Gambia', 'GM', 'GMB', '270', 'ISO 3166-2:GM');
INSERT INTO `country` VALUES ('80', 'Georgia', 'GE', 'GEO', '268', 'ISO 3166-2:GE');
INSERT INTO `country` VALUES ('81', 'Germany', 'DE', 'DEU', '276', 'ISO 3166-2:DE');
INSERT INTO `country` VALUES ('82', 'Ghana', 'GH', 'GHA', '288', 'ISO 3166-2:GH');
INSERT INTO `country` VALUES ('83', 'Gibraltar', 'GI', 'GIB', '292', 'ISO 3166-2:GI');
INSERT INTO `country` VALUES ('84', 'Greece', 'GR', 'GRC', '300', 'ISO 3166-2:GR');
INSERT INTO `country` VALUES ('85', 'Greenland', 'GL', 'GRL', '304', 'ISO 3166-2:GL');
INSERT INTO `country` VALUES ('86', 'Grenada', 'GD', 'GRD', '308', 'ISO 3166-2:GD');
INSERT INTO `country` VALUES ('87', 'Guadeloupe', 'GP', 'GLP', '312', 'ISO 3166-2:GP');
INSERT INTO `country` VALUES ('88', 'Guam', 'GU', 'GUM', '316', 'ISO 3166-2:GU');
INSERT INTO `country` VALUES ('89', 'Guatemala', 'GT', 'GTM', '320', 'ISO 3166-2:GT');
INSERT INTO `country` VALUES ('90', 'Guernsey', 'GG', 'GGY', '831', 'ISO 3166-2:GG');
INSERT INTO `country` VALUES ('91', 'Guinea', 'GN', 'GIN', '324', 'ISO 3166-2:GN');
INSERT INTO `country` VALUES ('92', 'Guinea-Bissau', 'GW', 'GNB', '624', 'ISO 3166-2:GW');
INSERT INTO `country` VALUES ('93', 'Guyana', 'GY', 'GUY', '328', 'ISO 3166-2:GY');
INSERT INTO `country` VALUES ('94', 'Haiti', 'HT', 'HTI', '332', 'ISO 3166-2:HT');
INSERT INTO `country` VALUES ('95', 'Heard Island and McDonald Islands', 'HM', 'HMD', '334', 'ISO 3166-2:HM');
INSERT INTO `country` VALUES ('96', 'Holy See (Vatican City State)', 'VA', 'VAT', '336', 'ISO 3166-2:VA');
INSERT INTO `country` VALUES ('97', 'Honduras', 'HN', 'HND', '340', 'ISO 3166-2:HN');
INSERT INTO `country` VALUES ('98', 'Hong Kong', 'HK', 'HKG', '344', 'ISO 3166-2:HK');
INSERT INTO `country` VALUES ('99', 'Hungary', 'HU', 'HUN', '348', 'ISO 3166-2:HU');
INSERT INTO `country` VALUES ('100', 'Iceland', 'IS', 'ISL', '352', 'ISO 3166-2:IS');
INSERT INTO `country` VALUES ('101', 'India', 'IN', 'IND', '356', 'ISO 3166-2:IN');
INSERT INTO `country` VALUES ('102', 'Indonesia', 'ID', 'IDN', '360', 'ISO 3166-2:ID');
INSERT INTO `country` VALUES ('103', 'Iran, Islamic Republic of', 'IR', 'IRN', '364', 'ISO 3166-2:IR');
INSERT INTO `country` VALUES ('104', 'Iraq', 'IQ', 'IRQ', '368', 'ISO 3166-2:IQ');
INSERT INTO `country` VALUES ('105', 'Ireland', 'IE', 'IRL', '372', 'ISO 3166-2:IE');
INSERT INTO `country` VALUES ('106', 'Isle of Man', 'IM', 'IMN', '833', 'ISO 3166-2:IM');
INSERT INTO `country` VALUES ('107', 'Israel', 'IL', 'ISR', '376', 'ISO 3166-2:IL');
INSERT INTO `country` VALUES ('108', 'Italy', 'IT', 'ITA', '380', 'ISO 3166-2:IT');
INSERT INTO `country` VALUES ('109', 'Jamaica', 'JM', 'JAM', '388', 'ISO 3166-2:JM');
INSERT INTO `country` VALUES ('110', 'Japan', 'JP', 'JPN', '392', 'ISO 3166-2:JP');
INSERT INTO `country` VALUES ('111', 'Jersey', 'JE', 'JEY', '832', 'ISO 3166-2:JE');
INSERT INTO `country` VALUES ('112', 'Jordan', 'JO', 'JOR', '400', 'ISO 3166-2:JO');
INSERT INTO `country` VALUES ('113', 'Kazakhstan', 'KZ', 'KAZ', '398', 'ISO 3166-2:KZ');
INSERT INTO `country` VALUES ('114', 'Kenya', 'KE', 'KEN', '404', 'ISO 3166-2:KE');
INSERT INTO `country` VALUES ('115', 'Kiribati', 'KI', 'KIR', '296', 'ISO 3166-2:KI');
INSERT INTO `country` VALUES ('116', 'Korea, Democratic People\'s Republic of', 'KP', 'PRK', '408', 'ISO 3166-2:KP');
INSERT INTO `country` VALUES ('117', 'Korea, Republic of', 'KR', 'KOR', '410', 'ISO 3166-2:KR');
INSERT INTO `country` VALUES ('118', 'Kuwait', 'KW', 'KWT', '414', 'ISO 3166-2:KW');
INSERT INTO `country` VALUES ('119', 'Kyrgyzstan', 'KG', 'KGZ', '417', 'ISO 3166-2:KG');
INSERT INTO `country` VALUES ('120', 'Lao People\'s Democratic Republic', 'LA', 'LAO', '418', 'ISO 3166-2:LA');
INSERT INTO `country` VALUES ('121', 'Latvia', 'LV', 'LVA', '428', 'ISO 3166-2:LV');
INSERT INTO `country` VALUES ('122', 'Lebanon', 'LB', 'LBN', '422', 'ISO 3166-2:LB');
INSERT INTO `country` VALUES ('123', 'Lesotho', 'LS', 'LSO', '426', 'ISO 3166-2:LS');
INSERT INTO `country` VALUES ('124', 'Liberia', 'LR', 'LBR', '430', 'ISO 3166-2:LR');
INSERT INTO `country` VALUES ('125', 'Libyan Arab Jamahiriya', 'LY', 'LBY', '434', 'ISO 3166-2:LY');
INSERT INTO `country` VALUES ('126', 'Liechtenstein', 'LI', 'LIE', '438', 'ISO 3166-2:LI');
INSERT INTO `country` VALUES ('127', 'Lithuania', 'LT', 'LTU', '440', 'ISO 3166-2:LT');
INSERT INTO `country` VALUES ('128', 'Luxembourg', 'LU', 'LUX', '442', 'ISO 3166-2:LU');
INSERT INTO `country` VALUES ('129', 'Macao', 'MO', 'MAC', '446', 'ISO 3166-2:MO');
INSERT INTO `country` VALUES ('130', 'Macedonia, the former Yugoslav Republic of', 'MK', 'MKD', '807', 'ISO 3166-2:MK');
INSERT INTO `country` VALUES ('131', 'Madagascar', 'MG', 'MDG', '450', 'ISO 3166-2:MG');
INSERT INTO `country` VALUES ('132', 'Malawi', 'MW', 'MWI', '454', 'ISO 3166-2:MW');
INSERT INTO `country` VALUES ('133', 'Malaysia', 'MY', 'MYS', '458', 'ISO 3166-2:MY');
INSERT INTO `country` VALUES ('134', 'Maldives', 'MV', 'MDV', '462', 'ISO 3166-2:MV');
INSERT INTO `country` VALUES ('135', 'Mali', 'ML', 'MLI', '466', 'ISO 3166-2:ML');
INSERT INTO `country` VALUES ('136', 'Malta', 'MT', 'MLT', '470', 'ISO 3166-2:MT');
INSERT INTO `country` VALUES ('137', 'Marshall Islands', 'MH', 'MHL', '584', 'ISO 3166-2:MH');
INSERT INTO `country` VALUES ('138', 'Martinique', 'MQ', 'MTQ', '474', 'ISO 3166-2:MQ');
INSERT INTO `country` VALUES ('139', 'Mauritania', 'MR', 'MRT', '478', 'ISO 3166-2:MR');
INSERT INTO `country` VALUES ('140', 'Mauritius', 'MU', 'MUS', '480', 'ISO 3166-2:MU');
INSERT INTO `country` VALUES ('141', 'Mayotte', 'YT', 'MYT', '175', 'ISO 3166-2:YT');
INSERT INTO `country` VALUES ('142', 'Mexico', 'MX', 'MEX', '484', 'ISO 3166-2:MX');
INSERT INTO `country` VALUES ('143', 'Micronesia, Federated States of', 'FM', 'FSM', '583', 'ISO 3166-2:FM');
INSERT INTO `country` VALUES ('144', 'Moldova, Republic of', 'MD', 'MDA', '498', 'ISO 3166-2:MD');
INSERT INTO `country` VALUES ('145', 'Monaco', 'MC', 'MCO', '492', 'ISO 3166-2:MC');
INSERT INTO `country` VALUES ('146', 'Mongolia', 'MN', 'MNG', '496', 'ISO 3166-2:MN');
INSERT INTO `country` VALUES ('147', 'Montenegro', 'ME', 'MNE', '499', 'ISO 3166-2:ME');
INSERT INTO `country` VALUES ('148', 'Montserrat', 'MS', 'MSR', '500', 'ISO 3166-2:MS');
INSERT INTO `country` VALUES ('149', 'Morocco', 'MA', 'MAR', '504', 'ISO 3166-2:MA');
INSERT INTO `country` VALUES ('150', 'Mozambique', 'MZ', 'MOZ', '508', 'ISO 3166-2:MZ');
INSERT INTO `country` VALUES ('151', 'Myanmar', 'MM', 'MMR', '104', 'ISO 3166-2:MM');
INSERT INTO `country` VALUES ('152', 'Namibia', 'NA', 'NAM', '516', 'ISO 3166-2:NA');
INSERT INTO `country` VALUES ('153', 'Nauru', 'NR', 'NRU', '520', 'ISO 3166-2:NR');
INSERT INTO `country` VALUES ('154', 'Nepal', 'NP', 'NPL', '524', 'ISO 3166-2:NP');
INSERT INTO `country` VALUES ('155', 'Netherlands', 'NL', 'NLD', '528', 'ISO 3166-2:NL');
INSERT INTO `country` VALUES ('156', 'Netherlands Antilles', 'AN', 'ANT', '530', 'ISO 3166-2:AN');
INSERT INTO `country` VALUES ('157', 'New Caledonia', 'NC', 'NCL', '540', 'ISO 3166-2:NC');
INSERT INTO `country` VALUES ('158', 'New Zealand', 'NZ', 'NZL', '554', 'ISO 3166-2:NZ');
INSERT INTO `country` VALUES ('159', 'Nicaragua', 'NI', 'NIC', '558', 'ISO 3166-2:NI');
INSERT INTO `country` VALUES ('160', 'Niger', 'NE', 'NER', '562', 'ISO 3166-2:NE');
INSERT INTO `country` VALUES ('161', 'Nigeria', 'NG', 'NGA', '566', 'ISO 3166-2:NG');
INSERT INTO `country` VALUES ('162', 'Niue', 'NU', 'NIU', '570', 'ISO 3166-2:NU');
INSERT INTO `country` VALUES ('163', 'Norfolk Island', 'NF', 'NFK', '574', 'ISO 3166-2:NF');
INSERT INTO `country` VALUES ('164', 'Northern Mariana Islands', 'MP', 'MNP', '580', 'ISO 3166-2:MP');
INSERT INTO `country` VALUES ('165', 'Norway', 'NO', 'NOR', '578', 'ISO 3166-2:NO');
INSERT INTO `country` VALUES ('166', 'Oman', 'OM', 'OMN', '512', 'ISO 3166-2:OM');
INSERT INTO `country` VALUES ('167', 'Pakistan', 'PK', 'PAK', '586', 'ISO 3166-2:PK');
INSERT INTO `country` VALUES ('168', 'Palau', 'PW', 'PLW', '585', 'ISO 3166-2:PW');
INSERT INTO `country` VALUES ('169', 'Palestinian Territory, Occupied', 'PS', 'PSE', '275', 'ISO 3166-2:PS');
INSERT INTO `country` VALUES ('170', 'Panama', 'PA', 'PAN', '591', 'ISO 3166-2:PA');
INSERT INTO `country` VALUES ('171', 'Papua New Guinea', 'PG', 'PNG', '598', 'ISO 3166-2:PG');
INSERT INTO `country` VALUES ('172', 'Paraguay', 'PY', 'PRY', '600', 'ISO 3166-2:PY');
INSERT INTO `country` VALUES ('173', 'Peru', 'PE', 'PER', '604', 'ISO 3166-2:PE');
INSERT INTO `country` VALUES ('174', 'Philippines', 'PH', 'PHL', '608', 'ISO 3166-2:PH');
INSERT INTO `country` VALUES ('175', 'Pitcairn', 'PN', 'PCN', '612', 'ISO 3166-2:PN');
INSERT INTO `country` VALUES ('176', 'Poland', 'PL', 'POL', '616', 'ISO 3166-2:PL');
INSERT INTO `country` VALUES ('177', 'Portugal', 'PT', 'PRT', '620', 'ISO 3166-2:PT');
INSERT INTO `country` VALUES ('178', 'Puerto Rico', 'PR', 'PRI', '630', 'ISO 3166-2:PR');
INSERT INTO `country` VALUES ('179', 'Qatar', 'QA', 'QAT', '634', 'ISO 3166-2:QA');
INSERT INTO `country` VALUES ('180', 'Réunion', 'RE', 'REU', '638', 'ISO 3166-2:RE');
INSERT INTO `country` VALUES ('181', 'Romania', 'RO', 'ROU', '642', 'ISO 3166-2:RO');
INSERT INTO `country` VALUES ('182', 'Russian Federation', 'RU', 'RUS', '643', 'ISO 3166-2:RU');
INSERT INTO `country` VALUES ('183', 'Rwanda', 'RW', 'RWA', '646', 'ISO 3166-2:RW');
INSERT INTO `country` VALUES ('184', 'Saint Barthélemy', 'BL', 'BLM', '652', 'ISO 3166-2:BL');
INSERT INTO `country` VALUES ('185', 'Saint Helena, Ascension and Tristan da Cunha', 'SH', 'SHN', '654', 'ISO 3166-2:SH');
INSERT INTO `country` VALUES ('186', 'Saint Kitts and Nevis', 'KN', 'KNA', '659', 'ISO 3166-2:KN');
INSERT INTO `country` VALUES ('187', 'Saint Lucia', 'LC', 'LCA', '662', 'ISO 3166-2:LC');
INSERT INTO `country` VALUES ('188', 'Saint Martin (French part)', 'MF', 'MAF', '663', 'ISO 3166-2:MF');
INSERT INTO `country` VALUES ('189', 'Saint Pierre and Miquelon', 'PM', 'SPM', '666', 'ISO 3166-2:PM');
INSERT INTO `country` VALUES ('190', 'Saint Vincent and the Grenadines', 'VC', 'VCT', '670', 'ISO 3166-2:VC');
INSERT INTO `country` VALUES ('191', 'Samoa', 'WS', 'WSM', '882', 'ISO 3166-2:WS');
INSERT INTO `country` VALUES ('192', 'San Marino', 'SM', 'SMR', '674', 'ISO 3166-2:SM');
INSERT INTO `country` VALUES ('193', 'Sao Tome and Principe', 'ST', 'STP', '678', 'ISO 3166-2:ST');
INSERT INTO `country` VALUES ('194', 'Saudi Arabia', 'SA', 'SAU', '682', 'ISO 3166-2:SA');
INSERT INTO `country` VALUES ('195', 'Senegal', 'SN', 'SEN', '686', 'ISO 3166-2:SN');
INSERT INTO `country` VALUES ('196', 'Serbia', 'RS', 'SRB', '688', 'ISO 3166-2:RS');
INSERT INTO `country` VALUES ('197', 'Seychelles', 'SC', 'SYC', '690', 'ISO 3166-2:SC');
INSERT INTO `country` VALUES ('198', 'Sierra Leone', 'SL', 'SLE', '694', 'ISO 3166-2:SL');
INSERT INTO `country` VALUES ('199', 'Singapore', 'SG', 'SGP', '702', 'ISO 3166-2:SG');
INSERT INTO `country` VALUES ('200', 'Slovakia', 'SK', 'SVK', '703', 'ISO 3166-2:SK');
INSERT INTO `country` VALUES ('201', 'Slovenia', 'SI', 'SVN', '705', 'ISO 3166-2:SI');
INSERT INTO `country` VALUES ('202', 'Solomon Islands', 'SB', 'SLB', '90', 'ISO 3166-2:SB');
INSERT INTO `country` VALUES ('203', 'Somalia', 'SO', 'SOM', '706', 'ISO 3166-2:SO');
INSERT INTO `country` VALUES ('204', 'South Africa', 'ZA', 'ZAF', '710', 'ISO 3166-2:ZA');
INSERT INTO `country` VALUES ('205', 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', '239', 'ISO 3166-2:GS');
INSERT INTO `country` VALUES ('206', 'Spain', 'ES', 'ESP', '724', 'ISO 3166-2:ES');
INSERT INTO `country` VALUES ('207', 'Sri Lanka', 'LK', 'LKA', '144', 'ISO 3166-2:LK');
INSERT INTO `country` VALUES ('208', 'Sudan', 'SD', 'SDN', '736', 'ISO 3166-2:SD');
INSERT INTO `country` VALUES ('209', 'Suriname', 'SR', 'SUR', '740', 'ISO 3166-2:SR');
INSERT INTO `country` VALUES ('210', 'Svalbard and Jan Mayen', 'SJ', 'SJM', '744', 'ISO 3166-2:SJ');
INSERT INTO `country` VALUES ('211', 'Swaziland', 'SZ', 'SWZ', '748', 'ISO 3166-2:SZ');
INSERT INTO `country` VALUES ('212', 'Sweden', 'SE', 'SWE', '752', 'ISO 3166-2:SE');
INSERT INTO `country` VALUES ('213', 'Switzerland', 'CH', 'CHE', '756', 'ISO 3166-2:CH');
INSERT INTO `country` VALUES ('214', 'Syrian Arab Republic', 'SY', 'SYR', '760', 'ISO 3166-2:SY');
INSERT INTO `country` VALUES ('215', 'Taiwan, Province of China', 'TW', 'TWN', '158', 'ISO 3166-2:TW');
INSERT INTO `country` VALUES ('216', 'Tajikistan', 'TJ', 'TJK', '762', 'ISO 3166-2:TJ');
INSERT INTO `country` VALUES ('217', 'Tanzania, United Republic of', 'TZ', 'TZA', '834', 'ISO 3166-2:TZ');
INSERT INTO `country` VALUES ('218', 'Thailand', 'TH', 'THA', '764', 'ISO 3166-2:TH');
INSERT INTO `country` VALUES ('219', 'Timor-Leste', 'TL', 'TLS', '626', 'ISO 3166-2:TL');
INSERT INTO `country` VALUES ('220', 'Togo', 'TG', 'TGO', '768', 'ISO 3166-2:TG');
INSERT INTO `country` VALUES ('221', 'Tokelau', 'TK', 'TKL', '772', 'ISO 3166-2:TK');
INSERT INTO `country` VALUES ('222', 'Tonga', 'TO', 'TON', '776', 'ISO 3166-2:TO');
INSERT INTO `country` VALUES ('223', 'Trinidad and Tobago', 'TT', 'TTO', '780', 'ISO 3166-2:TT');
INSERT INTO `country` VALUES ('224', 'Tunisia', 'TN', 'TUN', '788', 'ISO 3166-2:TN');
INSERT INTO `country` VALUES ('225', 'Turkey', 'TR', 'TUR', '792', 'ISO 3166-2:TR');
INSERT INTO `country` VALUES ('226', 'Turkmenistan', 'TM', 'TKM', '795', 'ISO 3166-2:TM');
INSERT INTO `country` VALUES ('227', 'Turks and Caicos Islands', 'TC', 'TCA', '796', 'ISO 3166-2:TC');
INSERT INTO `country` VALUES ('228', 'Tuvalu', 'TV', 'TUV', '798', 'ISO 3166-2:TV');
INSERT INTO `country` VALUES ('229', 'Uganda', 'UG', 'UGA', '800', 'ISO 3166-2:UG');
INSERT INTO `country` VALUES ('230', 'Ukraine', 'UA', 'UKR', '804', 'ISO 3166-2:UA');
INSERT INTO `country` VALUES ('231', 'United Arab Emirates', 'AE', 'ARE', '784', 'ISO 3166-2:AE');
INSERT INTO `country` VALUES ('232', 'United Kingdom', 'GB', 'GBR', '826', 'ISO 3166-2:GB');
INSERT INTO `country` VALUES ('233', 'United States', 'US', 'USA', '840', 'ISO 3166-2:US');
INSERT INTO `country` VALUES ('234', 'United States Minor Outlying Islands', 'UM', 'UMI', '581', 'ISO 3166-2:UM');
INSERT INTO `country` VALUES ('235', 'Uruguay', 'UY', 'URY', '858', 'ISO 3166-2:UY');
INSERT INTO `country` VALUES ('236', 'Uzbekistan', 'UZ', 'UZB', '860', 'ISO 3166-2:UZ');
INSERT INTO `country` VALUES ('237', 'Vanuatu', 'VU', 'VUT', '548', 'ISO 3166-2:VU');
INSERT INTO `country` VALUES ('238', 'Venezuela, Bolivarian Republic of', 'VE', 'VEN', '862', 'ISO 3166-2:VE');
INSERT INTO `country` VALUES ('239', 'Viet Nam', 'VN', 'VNM', '704', 'ISO 3166-2:VN');
INSERT INTO `country` VALUES ('240', 'Virgin Islands, British', 'VG', 'VGB', '92', 'ISO 3166-2:VG');
INSERT INTO `country` VALUES ('241', 'Virgin Islands, U.S.', 'VI', 'VIR', '850', 'ISO 3166-2:VI');
INSERT INTO `country` VALUES ('242', 'Wallis and Futuna', 'WF', 'WLF', '876', 'ISO 3166-2:WF');
INSERT INTO `country` VALUES ('243', 'Western Sahara', 'EH', 'ESH', '732', 'ISO 3166-2:EH');
INSERT INTO `country` VALUES ('244', 'Yemen', 'YE', 'YEM', '887', 'ISO 3166-2:YE');
INSERT INTO `country` VALUES ('245', 'Zambia', 'ZM', 'ZMB', '894', 'ISO 3166-2:ZM');
INSERT INTO `country` VALUES ('246', 'Zimbabwe', 'ZW', 'ZWE', '716', 'ISO 3166-2:ZW');

-- ----------------------------
-- Table structure for file
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of file
-- ----------------------------
INSERT INTO `file` VALUES ('4', 'images/venue/37b381ef9c.jpg', '2013-10-18 01:06:53');
INSERT INTO `file` VALUES ('5', 'images/promoter/197e178489.jpg', '2013-10-18 19:05:40');
INSERT INTO `file` VALUES ('6', 'images/promoter/4c31d1ebeb.jpg', '2013-10-21 23:21:12');
INSERT INTO `file` VALUES ('7', 'images/promoter/328e5ec9b4.jpg', '2013-10-21 23:54:40');
INSERT INTO `file` VALUES ('8', 'images/promoter/468a8468bb.jpg', '2013-10-22 22:05:54');
INSERT INTO `file` VALUES ('9', 'images/gig/1b6c7a8789.JPG', '2013-10-22 22:55:54');
INSERT INTO `file` VALUES ('10', 'images/gig/9a0ede6517.jpg', '2013-10-22 22:57:07');
INSERT INTO `file` VALUES ('11', 'images/artist/36a2da4a73.jpg', '2013-10-25 00:47:58');
INSERT INTO `file` VALUES ('12', 'images/artist/4c5760af6a.jpg', '2013-10-25 01:06:44');
INSERT INTO `file` VALUES ('13', 'images/artist/0d34b2e1f3.png', '2013-10-25 01:08:23');
INSERT INTO `file` VALUES ('14', 'images/artist/795cf0429f.png', '2013-10-25 01:09:45');
INSERT INTO `file` VALUES ('15', 'images/artist/7431556ca9.png', '2013-10-25 01:11:28');
INSERT INTO `file` VALUES ('16', 'images/artist/bd48059fe0.png', '2013-10-25 01:13:36');
INSERT INTO `file` VALUES ('17', 'images/venue/e881a4fd40.jpg', '2013-10-25 05:10:13');
INSERT INTO `file` VALUES ('18', 'images/temp/7546b2bc96.jpg', '2013-12-01 19:37:25');
INSERT INTO `file` VALUES ('19', 'images/promoter/9270a6fd2b.jpg', '2013-12-03 11:38:40');
INSERT INTO `file` VALUES ('20', 'images/promoter/104a116467.jpg', '2014-01-08 11:35:12');
INSERT INTO `file` VALUES ('21', 'images/temp/8d7299c6e3.jpg', '2014-01-13 15:54:00');

-- ----------------------------
-- Table structure for gig
-- ----------------------------
DROP TABLE IF EXISTS `gig`;
CREATE TABLE `gig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `venue_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ds_id` varchar(255) DEFAULT NULL,
  `from_venue_id` int(11) DEFAULT NULL,
  `capacity` tinyint(1) DEFAULT '1',
  `type` tinyint(1) DEFAULT '1',
  `accommodation` tinyint(1) DEFAULT '1',
  `transfer` tinyint(1) DEFAULT '1',
  `ds_type` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gig_venue_id` (`venue_id`),
  KEY `fk_gig_user_id` (`user_id`),
  CONSTRAINT `fk_gig_venue_id` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gig
-- ----------------------------
INSERT INTO `gig` VALUES ('2', null, '2', 'Kollektiv Turmstrasse @ Kugl Club, St. Gallen (CH)', '2014-05-17 21:55:00', '2', '2014-01-08 06:00:17', '483676615076879', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('3', null, '3', 'Kollektiv Turmstrasse @ Rote Sonne, Munich (DE)', '2014-04-20 21:55:00', '2', '2014-01-08 06:00:19', '130742773763108', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('4', null, '4', 'Kollektiv Turmstrasse @ DGTL Festival at NDSM Docklands, Amsterdam (NL)', '2014-04-19 21:55:00', '2', '2014-01-08 06:00:20', '1404563833121817', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('5', null, '5', 'Kollektiv Turmstrasse @  Friends of Spring at Helmut List Halle, Graz (AT)', '2014-04-05 21:55:00', '2', '2014-01-08 06:00:21', '242493182584612', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('6', null, '6', 'Kollektiv Turmstrasse @ La Rocca, Lier (BE)', '2014-03-16 22:55:00', '2', '2014-01-08 06:00:28', '195051304025503', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('7', null, '7', 'Kollektiv Turmstrasse @ Studio, Essen (DE) (Christian)', '2014-03-15 22:55:00', '2', '2014-01-08 06:00:34', '1382987531942485', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('8', null, '8', 'Kollektiv Turmstrasse@ Oval Space, London (UK)', '2014-03-06 23:55:00', '2', '2014-01-08 06:00:36', '168313200043769', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('9', null, '9', 'Kollektiv Turmtrasse @ Prozak 2.0, Krakow (PL)', '2014-03-01 22:55:00', '2', '2014-01-08 06:00:37', '735578133123452', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('10', null, '10', 'Kollektiv Turmstrasse @ 19 Jahre Dockland @ Fusion Club, Münster (DE) (Christian)', '2014-02-15 22:55:00', '2', '2014-01-08 06:00:39', '719369484759058', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('11', null, '11', 'Kollektiv Turmstrasse @ 50Grad, Mainz (DE)', '2014-02-07 22:55:00', '2', '2014-01-08 06:00:41', '578194285594321', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('12', null, '12', 'Kollektiv Turmstrasse @ Ego, Hamburg (DE)', '2014-01-31 22:55:00', '2', '2014-01-08 06:00:42', '1434112906806105', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('13', null, '13', 'Kollektiv Turmstrasse @ Blue Parrot, Playa del Carmen (MX) (Christian)', '2014-01-10 05:55:00', '2', '2014-01-08 06:00:43', '648250781862832', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('14', null, '14', 'Kollektiv Turmstrasse @ Frau Berger, Ulm (DE)', '2014-01-05 22:55:00', '2', '2014-01-08 06:00:44', '600318270028711', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('15', null, '15', 'Kollektiv Turmstrasse @ Komplex 457, Zurich (CH)', '2013-12-31 22:55:00', '2', '2014-01-08 06:00:45', '710710085607698', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('16', null, '16', 'Kollektiv Turmstrasse @ Next Monday\'s Hangover @ Het Sieraad, Amsterdam (NL)', '2013-12-28 22:55:00', '2', '2014-01-08 06:00:47', '1397398940491530', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('17', null, '48', 'Hot Since 82 @ Avalon, Los Angeles, US', '2014-01-11 00:00:00', '2', '2014-01-08 06:01:22', '357987761012178', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('18', null, '49', 'Hot Since 82 @ Spin, San Diego, US', '2014-01-09 00:00:00', '2', '2014-01-08 06:01:25', '554874931271872', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('19', null, '19', 'Hot Since 82 @ Opera, Atlanta, US', '2014-01-03 00:00:00', '2', '2014-01-08 06:01:28', '489942487788121', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('20', null, '20', 'Hot Since 82 @ Boxxed, Birmingham, UK', '2014-01-01 00:00:00', '2', '2014-01-08 06:01:35', '1393226800928908', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('21', null, '21', 'Hot Since 82 @ Moko Lounge, Harrogate, UK', '2013-12-26 00:00:00', '2', '2014-01-08 06:01:38', '1411230225777655', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('22', null, '22', 'Stereo, Montreal, Canada', '2013-12-28 00:00:00', '2', '2014-01-08 06:02:24', '185067515029618', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('23', null, '23', 'The Mid, Chicago, IL', '2013-12-27 00:00:00', '2', '2014-01-08 06:02:25', '1424253417805657', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('24', null, '24', 'D - MELT! FESTIVAL - PRE-PARTY 2014', '2014-07-17 00:00:00', '2', '2014-01-08 06:02:50', '591524900913666', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('25', null, '25', 'CH-Zurich - M4Music Festival, Schiffbau', '2014-03-29 00:00:00', '2', '2014-01-08 06:02:51', '1406258226283777', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('26', null, '26', 'D - Augsburg - Theater Augsburg, Brecht Festival', '2014-02-01 00:00:00', '2', '2014-01-08 06:02:52', '453849804715927', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('27', null, '27', 'CH-Laax - Rider\'s Palace', '2014-01-03 22:55:00', '2', '2014-01-08 06:02:53', '715185465167591', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('28', null, '51', 'Timo Maas Official Page at Rex Club', '2014-01-24 21:00:00', '2', '2014-01-08 06:03:11', '457736740998353', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('29', '38', '29', 'KOLLEKTIV TURMSTRASSE', '2014-01-15 00:00:00', '1', '2014-01-05 22:38:27', null, null, '1', '1', '1', '1', null);
INSERT INTO `gig` VALUES ('30', null, '50', 'Wolf + Lamb vs Soul Clap - Australian / New Zealand Tour', '2013-12-28 22:00:00', '2', '2014-01-08 06:01:40', '451748294929555', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('31', '38', '34', 'KOLLEKTIV TURMSTRASSE', '2014-02-18 00:00:00', '1', '2014-01-06 18:41:43', null, null, '1', '1', '1', '1', null);
INSERT INTO `gig` VALUES ('32', null, '35', 'Hot Since 82 @ Celebrities, Vancouver, Canada', '2014-02-15 00:00:00', '2', '2014-01-08 06:00:55', '230273603810980', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('33', null, '36', 'Hot Since 82 @ Sound Bar, Chicago, US', '2014-02-08 00:00:00', '2', '2014-01-08 06:00:58', '448306111959148', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('34', null, '37', 'Hot Since 82 @ Pacha, New York, US', '2014-02-07 00:00:00', '2', '2014-01-08 06:00:59', '1412466435659454', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('35', null, '38', 'Hot Since 82 @ Adore, Miami, US', '2014-02-06 00:00:00', '2', '2014-01-08 06:01:10', '564126480347259', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('36', null, '39', 'Hot Since 82 @ EFS Lounge, Toronta, Canada', '2014-02-05 00:00:00', '2', '2014-01-08 06:01:11', '612626865459926', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('37', null, '40', 'Hot Since 82 @ Brrrrr! Winter Music Festival, Toronta, Canada', '2014-02-01 00:00:00', '2', '2014-01-08 06:01:13', '800069273341702', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('38', null, '41', 'Hot Since 82 @ Igloofest, Montreal, Canada', '2014-01-31 00:00:00', '2', '2014-01-08 06:01:14', '1428690127366153', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('39', null, '42', 'Hot Since 82 @ Mint Warehouse, Leeds, UK', '2014-01-24 00:00:00', '2', '2014-01-08 06:01:21', '597254256994913', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('40', null, '45', 'Hot Since 82 @ Kool Beach, Playa Del Carmen, Mexico', '2014-01-07 22:00:00', '2', '2014-01-08 06:01:26', '401326403335441', null, '1', '1', '1', '1', '1');
INSERT INTO `gig` VALUES ('41', '12', '52', 'KOLLEKTIV TURMSTRASSE', '2014-03-02 00:00:00', '1', '2014-01-13 14:54:46', null, null, '3', '1', '4', '5', null);
INSERT INTO `gig` VALUES ('42', '12', '53', 'KOLLEKTIV TURMSTRASSE', '2014-03-02 00:00:00', '1', '2014-01-13 14:59:47', null, null, '3', '3', '3', '4', null);
INSERT INTO `gig` VALUES ('43', '12', '54', 'BONAPARTE', '2014-03-28 00:00:00', '1', '2014-01-13 15:01:50', null, null, '3', '2', '3', '4', null);

-- ----------------------------
-- Table structure for gig_file
-- ----------------------------
DROP TABLE IF EXISTS `gig_file`;
CREATE TABLE `gig_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gig_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_gig_file_gig_id` (`gig_id`),
  KEY `fk_gig_file_file_id` (`file_id`),
  CONSTRAINT `fk_gig_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_gig_file_gig_id` FOREIGN KEY (`gig_id`) REFERENCES `gig` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gig_file
-- ----------------------------

-- ----------------------------
-- Table structure for promoter
-- ----------------------------
DROP TABLE IF EXISTS `promoter`;
CREATE TABLE `promoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `description` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `radius` int(11) DEFAULT NULL,
  `fb_id` bigint(20) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_promoter_user_id` (`user_id`),
  CONSTRAINT `fk_promoter_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of promoter
-- ----------------------------
INSERT INTO `promoter` VALUES ('4', '4', 'Admin', 'Site admin', '2014-01-13 15:54:03', '52.900002', '21.500000', '500000', '0');
INSERT INTO `promoter` VALUES ('10', '12', 'MUZA', 'We gonna have party!', '2014-01-08 11:35:12', '53.898384', '27.602406', '268309', '0');
INSERT INTO `promoter` VALUES ('12', '14', 'Guru', 'Rostov is in the groove!', '2014-01-08 11:49:26', null, null, '1281701', '0');
INSERT INTO `promoter` VALUES ('13', '15', 'Loveis', 'St.P', '2013-12-01 19:49:01', null, null, null, '0');
INSERT INTO `promoter` VALUES ('14', '16', 'Dania', 'Dania From Dubai', '2013-12-01 19:49:35', null, null, null, '0');
INSERT INTO `promoter` VALUES ('15', '17', 'Max Starscev', 'Hooligan in Minsk!', '2013-12-01 19:50:16', null, null, null, '0');
INSERT INTO `promoter` VALUES ('16', '18', 'Kirrill Mad', 'Minsk Hard Bass Scene!', '2013-12-01 19:51:05', null, null, null, '0');
INSERT INTO `promoter` VALUES ('17', '19', 'Asolya', 'Warsaw is in the groove!', '2013-12-01 19:51:40', null, null, null, '0');
INSERT INTO `promoter` VALUES ('18', '20', 'Rogga', 'House is Deep!', '2013-12-01 19:52:19', null, null, null, '0');
INSERT INTO `promoter` VALUES ('19', '21', 'Mihas', 'Party Started!', '2013-12-01 19:53:58', null, null, null, '0');
INSERT INTO `promoter` VALUES ('20', '22', 'Mike Bufton', 'Dubai never sleeps!', '2013-12-01 19:57:11', null, null, null, '0');
INSERT INTO `promoter` VALUES ('21', '23', 'Infusion', 'We are Infusion!', '2013-12-01 19:57:36', null, null, null, '0');
INSERT INTO `promoter` VALUES ('36', '38', 'Александр Манти', 'https://www.facebook.com/manti.by', '2014-01-06 08:07:57', '52.344269', '21.062761', '407518', '100001230699137');
INSERT INTO `promoter` VALUES ('37', '39', 'Booga', null, '2013-12-07 10:21:23', null, null, null, '0');
INSERT INTO `promoter` VALUES ('38', '40', 'STARWAY', null, '2013-12-15 11:51:15', null, null, null, '0');
INSERT INTO `promoter` VALUES ('39', '47', 'TestP', '', '2014-01-09 08:58:52', '25.297647', '55.296532', '2364779', '0');

-- ----------------------------
-- Table structure for promoter_file
-- ----------------------------
DROP TABLE IF EXISTS `promoter_file`;
CREATE TABLE `promoter_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promoter_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_promoter_file_promoter_id` (`promoter_id`),
  KEY `fk_promoter_file_file_id` (`file_id`),
  CONSTRAINT `fk_promoter_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_promoter_file_promoter_id` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of promoter_file
-- ----------------------------
INSERT INTO `promoter_file` VALUES ('1', '10', '18', '2013-12-01 19:37:38');
INSERT INTO `promoter_file` VALUES ('2', '36', '19', '2013-12-03 11:38:40');
INSERT INTO `promoter_file` VALUES ('3', '10', '20', '2014-01-08 11:35:12');
INSERT INTO `promoter_file` VALUES ('4', '4', '21', '2014-01-13 15:54:03');

-- ----------------------------
-- Table structure for promoter_promoter
-- ----------------------------
DROP TABLE IF EXISTS `promoter_promoter`;
CREATE TABLE `promoter_promoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `promoter_id` int(11) NOT NULL,
  `follow_id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_promoter_promoter_id` (`promoter_id`),
  KEY `fk_promoter_follow_id` (`follow_id`),
  CONSTRAINT `fk_promoter_promoter_id` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_promoter_follow_id` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of promoter_promoter
-- ----------------------------
INSERT INTO `promoter_promoter` VALUES ('1', '4', '10', '2014-01-13 15:53:20');
INSERT INTO `promoter_promoter` VALUES ('2', '4', '14', '2014-01-13 15:53:22');
INSERT INTO `promoter_promoter` VALUES ('3', '4', '15', '2014-01-13 15:53:23');
INSERT INTO `promoter_promoter` VALUES ('4', '4', '36', '2014-01-13 15:54:14');

-- ----------------------------
-- Table structure for subscription
-- ----------------------------
DROP TABLE IF EXISTS `subscription`;
CREATE TABLE `subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `type` tinyint(1) DEFAULT '0',
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of subscription
-- ----------------------------

-- ----------------------------
-- Table structure for tbl_migration
-- ----------------------------
DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_migration
-- ----------------------------
INSERT INTO `tbl_migration` VALUES ('m000000_000000_base', '1381829995');
INSERT INTO `tbl_migration` VALUES ('m131015_091036_artist_table', '1381831189');
INSERT INTO `tbl_migration` VALUES ('m131015_091048_country_table', '1381831189');
INSERT INTO `tbl_migration` VALUES ('m131015_091051_gig_table', '1381831189');
INSERT INTO `tbl_migration` VALUES ('m131015_091100_user_table', '1381831189');
INSERT INTO `tbl_migration` VALUES ('m131015_091122_promoter_table', '1381831189');
INSERT INTO `tbl_migration` VALUES ('m131015_091143_venue_table', '1381831189');
INSERT INTO `tbl_migration` VALUES ('m131015_091231_country_data', '1381831189');
INSERT INTO `tbl_migration` VALUES ('m131015_110952_file_table', '1381835923');
INSERT INTO `tbl_migration` VALUES ('m131015_111251_artist_file', '1381835923');
INSERT INTO `tbl_migration` VALUES ('m131015_111301_promoter_file', '1381835923');
INSERT INTO `tbl_migration` VALUES ('m131015_140852_add_gig_status', '1381846696');
INSERT INTO `tbl_migration` VALUES ('m131015_195439_add_gig_venue_fk', '1381911633');
INSERT INTO `tbl_migration` VALUES ('m131015_200426_add_gig_user_id', '1381911633');
INSERT INTO `tbl_migration` VALUES ('m131015_200708_add_gig_user_fk', '1381911633');
INSERT INTO `tbl_migration` VALUES ('m131015_201229_new_migration', '1381911633');
INSERT INTO `tbl_migration` VALUES ('m131017_155226_venue_file', '1382439220');
INSERT INTO `tbl_migration` VALUES ('m131017_162014_gig_file', '1382439220');
INSERT INTO `tbl_migration` VALUES ('m131018_135756_update_password_length', '1382439220');
INSERT INTO `tbl_migration` VALUES ('m131021_204818_add_user_email_uk', '1382439220');
INSERT INTO `tbl_migration` VALUES ('m131022_202014_add_artist_gig_relation', '1382477936');
INSERT INTO `tbl_migration` VALUES ('m131028_191510_add_follow_link', '1382996352');
INSERT INTO `tbl_migration` VALUES ('m131028_191515_subscriptions', '1382996353');
INSERT INTO `tbl_migration` VALUES ('m131107_100812_artist_coords', '1384017941');
INSERT INTO `tbl_migration` VALUES ('m131118_200550_subscription_table', '1384936102');
INSERT INTO `tbl_migration` VALUES ('m131118_223258_promoter_coords', '1384936102');
INSERT INTO `tbl_migration` VALUES ('m131201_100140_add_artist_fbid', '1384936102');
INSERT INTO `tbl_migration` VALUES ('m131201_165120_add_promoter_fbid', '1384936102');
INSERT INTO `tbl_migration` VALUES ('m131203_123520_add_artist_ids', '1386063576');
INSERT INTO `tbl_migration` VALUES ('m131230_123520_gig_ds_id', '1388928339');
INSERT INTO `tbl_migration` VALUES ('m131230_123720_venue_ds_id', '1388928339');
INSERT INTO `tbl_migration` VALUES ('m140104_222841_fix_gig_user_id', '1388928339');
INSERT INTO `tbl_migration` VALUES ('m140104_235508_update_venue_rules', '1388928339');
INSERT INTO `tbl_migration` VALUES ('m140105_140143_additional_gig_fields', '1388961210');
INSERT INTO `tbl_migration` VALUES ('m140105_143937_add_ds_type', '1388961210');
INSERT INTO `tbl_migration` VALUES ('m140108_094708_update_venue_name', '1389180789');
INSERT INTO `tbl_migration` VALUES ('m140113_150316_promoter_promoter', '1389628371');
INSERT INTO `tbl_migration` VALUES ('m301203_123520_gig_ds_id', '1388394181');
INSERT INTO `tbl_migration` VALUES ('m301203_123720_venue_ds_id', '1388394222');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('2', 'cron@starway.pro', '1', '2013-12-03 11:03:23');
INSERT INTO `user` VALUES ('4', 'manti.by@gmail.com', '$2a$13$um/W8t7RDLsEAPhmt82Eo.FA6Asdk0.gy6.q4BL74QMxX5stI8vu.', '2014-01-13 15:54:03');
INSERT INTO `user` VALUES ('7', 'justin@justinbaird.com', '$2a$13$oYcpd6NVqVAiOemfCizl9ua3wkmrsQ8zfg.fB2GRCAJdBVKWLLxoS', '2013-10-26 10:39:31');
INSERT INTO `user` VALUES ('8', 'sunny.raeva@gmail.com', '$2a$13$1SvvLyYNseson761/mBzwO.VA0cJGlY37OihTJwO6D7ujgv0xySW.', '2013-11-26 12:35:45');
INSERT INTO `user` VALUES ('12', 'djchantcharmant@gmail.com', '$2a$13$3/3Uyp9xFHoFoSWK6HFltu8GMpYRuhy4J6w4aiSlV69PHrnTCe.au', '2014-01-13 14:24:40');
INSERT INTO `user` VALUES ('13', 'roman.gorbunov@i360accelerator.com', '$2a$13$MCeWeyMNUwM3IDAdWMbB2u2GzZ33n.57.9tQbisVpO4PK1rNZCgZK', '2013-12-01 19:46:54');
INSERT INTO `user` VALUES ('14', 'dj_guru@mail.ru', '$2a$13$nj06v0U6LeQl1BS9ize2ceOOmQxxOwduvVlxNWEioWaRaZvoqFOCW', '2014-01-08 11:49:26');
INSERT INTO `user` VALUES ('15', '9865883@gmail.com', '$2a$13$/2FJO39SND1ggJx1bVb/jufu7qwqtAYh/O4ZwVPysK/oY8Pqmok5y', '2013-12-01 19:49:01');
INSERT INTO `user` VALUES ('16', 'dania@electricdays.net', '$2a$13$oezHpwJo82rdMJzRtHsdQeBjtpsgjWSBzgAyTktAmLJ/D4C3OxGyu', '2013-12-01 19:49:35');
INSERT INTO `user` VALUES ('17', 'startsev.max@gmail.com', '$2a$13$UEDCFmIALy3Avy0b7AC9..Zf40mOtr7C0JtL0DHZViKkVZZrXTDfK', '2013-12-01 19:50:16');
INSERT INTO `user` VALUES ('18', 'mad_mouse@list.ru', '$2a$13$Kzf4UVT2WNqUUDX1hcGvReXu8Kbfx8.qpKpfDV46ts3eherv59fVi', '2013-12-01 19:51:05');
INSERT INTO `user` VALUES ('19', 'asolyashow@gmail.com', '$2a$13$fAkhRS8.4QFe8ahEN3bPGOJl7PqRDE8nkP/5705rC.wqH7nxcOi3e', '2013-12-01 19:51:40');
INSERT INTO `user` VALUES ('20', 'rogga@gmail.com', '$2a$13$zQpSlPH293n67Wy01IVz7.wX4osYIbNLnm5637xKBh.bmwBFUdUze', '2013-12-01 19:52:19');
INSERT INTO `user` VALUES ('21', 'Mihas@gmail.com', '$2a$13$cUPS3c0BNZS2Wie1J64APuHWSbZC4XNbcNbYp5o5A.6v6yPjkUXM2', '2013-12-01 19:53:58');
INSERT INTO `user` VALUES ('22', 'info@audiotonic.net', '$2a$13$FrwC2PLhbB/CXPTucw7TtOaqxhU1gFeDe1lhS75o3yfZ1HCZc58iC', '2013-12-01 19:57:11');
INSERT INTO `user` VALUES ('23', 'charlchaka@infusion.ae', '$2a$13$mXipanfrfNImAHDgiMTwK.1Q5g7yIv3Y4xn.4IZzO/ekoWUpUggkO', '2013-12-01 19:57:36');
INSERT INTO `user` VALUES ('38', 'marco.manti@gmail.com', '$2a$13$omV2i2tcdLhLfSrsx7OGpe8eIDIWsN7ico9HgWhM6fLT1GIf4gzAC', '2014-01-06 08:07:57');
INSERT INTO `user` VALUES ('39', 'roman@wemade.biz', '$2a$13$MB4TlAZSD3evLhZf7b8XAO6RMppx0JeN7bxKvlb5Xr//WIgXkyj5K', '2013-12-07 10:21:23');
INSERT INTO `user` VALUES ('40', 'info@starway.pro', '$2a$13$G/s/qXcARp14chCGw1q2gOp0EQTkwdtC70OBQ.cBQeExEQYWnSHLi', '2013-12-15 11:51:15');
INSERT INTO `user` VALUES ('47', 'testpromoter@mail.ru', '$2a$13$CX/pg6zVTei6gw6HgqCLau7LuDN1/28ck1.p8wIfCPmlihvcoXrKa', '2014-01-09 08:58:52');

-- ----------------------------
-- Table structure for venue
-- ----------------------------
DROP TABLE IF EXISTS `venue`;
CREATE TABLE `venue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `country_id` int(11) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `address` text,
  `latitude` float(10,6) DEFAULT NULL,
  `longitude` float(10,6) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ds_id` varchar(255) DEFAULT NULL,
  `ds_type` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_venue_country_id` (`country_id`),
  CONSTRAINT `fk_venue_country_id` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of venue
-- ----------------------------
INSERT INTO `venue` VALUES ('2', 'Switzerland / Sankt Gallen', null, '213', 'Sankt Gallen', '', '47.418827', '9.365060', '2014-01-08 11:33:09', '133473760037746', null);
INSERT INTO `venue` VALUES ('3', 'Germany / Munich', null, '81', 'Munich', 'Maximiliansplatz 5', '48.142090', '11.570022', '2014-01-08 11:33:09', '104431824712', null);
INSERT INTO `venue` VALUES ('4', 'Netherlands / Amsterdam', null, '155', 'Amsterdam', 'TT Neveritaweg 61', '52.400822', '4.891600', '2014-01-08 11:33:09', '134178166598046', null);
INSERT INTO `venue` VALUES ('5', 'Austria / Graz', null, '15', 'Graz', 'Waagner-Biro-Straße 98a', '47.079624', '15.411888', '2014-01-08 11:33:09', '115143478516329', null);
INSERT INTO `venue` VALUES ('6', 'Belgium / Lier', null, '22', 'Lier', 'Antwerpsesteenweg 384', '51.149517', '4.534131', '2014-01-08 11:33:09', '167588723255450', null);
INSERT INTO `venue` VALUES ('7', 'Germany / Essen', null, '81', 'Essen', 'Schützenbahn 31', '51.459873', '7.014825', '2014-01-08 11:33:09', '122776987790554', null);
INSERT INTO `venue` VALUES ('8', 'United Kingdom / London', null, '232', 'London', '29-32 The Oval, ', '51.533302', '-0.059275', '2014-01-08 11:33:09', '369904869696860', null);
INSERT INTO `venue` VALUES ('9', 'Poland / Kraków', null, '176', 'Kraków', 'pl. Dominikański 6', '50.059086', '19.937899', '2014-01-08 11:33:09', '413686155358806', null);
INSERT INTO `venue` VALUES ('10', 'Germany / Münster', null, '81', 'Münster', 'Am Hawerkamp 31', '51.944241', '7.639153', '2014-01-08 11:33:09', '117570597074', null);
INSERT INTO `venue` VALUES ('11', 'Germany / Mainz', null, '81', 'Mainz', '', '50.004620', '8.267888', '2014-01-08 11:33:09', '127899870645500', null);
INSERT INTO `venue` VALUES ('12', 'Germany / Hamburg', null, '81', 'Hamburg', 'Talstraße 9', '53.549946', '9.960092', '2014-01-08 11:33:09', '163688321836', null);
INSERT INTO `venue` VALUES ('13', 'Mexico / Playa del Carmen', null, '142', 'Playa del Carmen', 'Calle 12 entre 1a. Ave. y ZFM', '20.626663', '-87.070518', '2014-01-08 11:33:09', '121966144541671', null);
INSERT INTO `venue` VALUES ('14', 'Germany / Ulm', null, '81', 'Ulm', 'Ehingerstr. 19', '48.395218', '9.982124', '2014-01-08 11:33:09', '103430029738576', null);
INSERT INTO `venue` VALUES ('15', 'Switzerland / Zürich', null, '213', 'Zürich', 'Hohlstrasse 457', '47.387360', '8.499634', '2014-01-08 11:33:09', '176002482425032', null);
INSERT INTO `venue` VALUES ('16', 'Netherlands / Amsterdam', null, '155', 'Amsterdam', 'Postjesweg 1', '52.364414', '4.858812', '2014-01-08 11:33:09', '176790082338072', null);
INSERT INTO `venue` VALUES ('17', 'http://bit.ly/1cGvobp', null, null, '', '', null, null, '2014-01-05 13:26:24', null, null);
INSERT INTO `venue` VALUES ('18', 'Spin', null, null, '', '', null, null, '2014-01-05 13:26:26', null, null);
INSERT INTO `venue` VALUES ('19', 'United States / Atlanta', null, '233', 'Atlanta', '1150 Peachtree St. NE #B', '33.785912', '-84.383652', '2014-01-08 11:33:09', '373769119423269', null);
INSERT INTO `venue` VALUES ('20', 'United Kingdom / Birmingham', null, '232', 'Birmingham', '104 – 105 Floodgate Street,', '52.475952', '-1.884798', '2014-01-08 11:33:09', '547832695268888', null);
INSERT INTO `venue` VALUES ('21', 'United Kingdom / Harrogate', null, '232', 'Harrogate', '2 Kings Road ', '53.994629', '-1.543859', '2014-01-08 11:33:09', '33976825846', null);
INSERT INTO `venue` VALUES ('22', null, null, null, '', '', '45.500000', '-73.583298', '2014-01-08 11:33:09', '102184499823699', null);
INSERT INTO `venue` VALUES ('23', null, null, null, '', '', '41.849998', '-87.650002', '2014-01-08 11:33:09', '108659242498155', null);
INSERT INTO `venue` VALUES ('24', 'Germany / Gräfenhainchen', null, '81', 'Gräfenhainchen', '', '51.749557', '12.437821', '2014-01-08 11:33:09', '282061528916', null);
INSERT INTO `venue` VALUES ('25', 'Switzerland / Zürich', null, '213', 'Zürich', 'Schiffbaustrasse 4', '47.388798', '8.519220', '2014-01-08 11:33:09', '143399335704437', null);
INSERT INTO `venue` VALUES ('26', 'Germany / Augsburg', null, '81', 'Augsburg', 'Kasernstraße 4-6', '48.370220', '10.892044', '2014-01-08 11:33:09', '312002359643', null);
INSERT INTO `venue` VALUES ('27', 'Switzerland / Laax', null, '213', 'Laax', '', '46.817699', '9.265135', '2014-01-08 11:33:09', '169533519737941', null);
INSERT INTO `venue` VALUES ('28', 'Paris FR', null, null, '', '', null, null, '2014-01-05 13:27:33', null, null);
INSERT INTO `venue` VALUES ('29', 'The Loft', 'http://www.minsknightlife.net/loft.htm', '21', 'Minsk', 'улица Петруся Бровки, 22', '53.912373', '27.601471', '2014-01-05 22:38:27', 'eac0b10ee1b2fd1a850864db07418cfc011d6891', '2');
INSERT INTO `venue` VALUES ('30', 'http://bit.ly/1cGvobp', null, null, '', '', null, null, '2014-01-06 06:00:37', null, null);
INSERT INTO `venue` VALUES ('31', 'Spin', null, null, '', '', null, null, '2014-01-06 06:00:39', null, null);
INSERT INTO `venue` VALUES ('32', 'Australia / New Zealand', null, null, '', '', null, null, '2014-01-06 06:00:49', null, null);
INSERT INTO `venue` VALUES ('33', 'Paris FR', null, null, '', '', null, null, '2014-01-06 06:01:46', null, null);
INSERT INTO `venue` VALUES ('34', 'Chill Out', 'http://chill-out.relax.by/', '21', 'Minsk', 'Ploshcha Svabody, 4', '53.904095', '27.555365', '2014-01-06 18:41:43', 'c54d72becb13106116c656b01727909f3869df26', '2');
INSERT INTO `venue` VALUES ('35', 'Canada / Vancouver', null, '39', 'Vancouver', '1022 Davie Street', '49.279404', '-123.129959', '2014-01-08 11:33:09', '203201943026010', '1');
INSERT INTO `venue` VALUES ('36', 'United States / Chicago', null, '233', 'Chicago', '226 W. Ontario', '41.893253', '-87.635460', '2014-01-08 11:33:09', '125553790790481', '1');
INSERT INTO `venue` VALUES ('37', 'United States / New York', null, '233', 'New York', '618 W. 46th Street', '40.763813', '-73.997643', '2014-01-08 11:33:09', '38220197420', '1');
INSERT INTO `venue` VALUES ('38', 'United States / Miami Beach', null, '233', 'Miami Beach', '2000 Collins Ave', '25.795977', '-80.129349', '2014-01-08 11:33:09', '201962973290536', '1');
INSERT INTO `venue` VALUES ('39', 'Canada / Toronto', null, '39', 'Toronto', '647 KING STREET WEST', '43.643967', '-79.402351', '2014-01-08 11:33:09', '466009043473592', '1');
INSERT INTO `venue` VALUES ('40', 'Canada / Toronto', null, '39', 'Toronto', 'Echo Beach at Ontario Place - 955 Lakeshore Blvd West', '43.631798', '-79.412827', '2014-01-08 11:33:09', '539414652739845', '1');
INSERT INTO `venue` VALUES ('41', 'Canada / Montreal', null, '39', 'Montreal', '', '45.507053', '-73.549561', '2014-01-08 11:33:09', '545764472114800', '1');
INSERT INTO `venue` VALUES ('42', 'United Kingdom / Leeds', null, '232', 'Leeds', '175 Aquatite House, Water Lane', '53.790333', '-1.557664', '2014-01-08 11:33:09', '258669140841955', '1');
INSERT INTO `venue` VALUES ('43', 'http://bit.ly/1cGvobp', null, null, '', '', null, null, '2014-01-07 06:01:13', null, null);
INSERT INTO `venue` VALUES ('44', 'Spin', null, null, '', '', null, null, '2014-01-07 06:01:15', null, null);
INSERT INTO `venue` VALUES ('45', 'Mexico / Playa del Carmen', null, '142', 'Playa del Carmen', '', '20.630644', '-87.065384', '2014-01-08 11:33:09', '452790188115837', '1');
INSERT INTO `venue` VALUES ('46', 'Australia / New Zealand', null, null, '', '', null, null, '2014-01-07 06:01:26', null, null);
INSERT INTO `venue` VALUES ('47', 'Paris FR', null, null, '', '', null, null, '2014-01-07 06:03:09', null, null);
INSERT INTO `venue` VALUES ('48', 'http://bit.ly/1cGvobp', null, null, '', '', null, null, '2014-01-08 06:01:22', null, null);
INSERT INTO `venue` VALUES ('49', 'Spin', null, null, '', '', null, null, '2014-01-08 06:01:25', null, null);
INSERT INTO `venue` VALUES ('50', 'Australia / New Zealand', null, null, '', '', null, null, '2014-01-08 06:01:40', null, null);
INSERT INTO `venue` VALUES ('51', 'Paris FR', null, null, '', '', null, null, '2014-01-08 06:03:11', null, null);
INSERT INTO `venue` VALUES ('52', 'Chill Out', 'http://chill-out.relax.by/', '21', 'Minsk', 'Ploshcha Svabody, 4', null, null, '2014-01-13 14:54:46', 'c54d72becb13106116c656b01727909f3869df26', '2');
INSERT INTO `venue` VALUES ('53', 'The Loft', 'http://www.minsknightlife.net/loft.htm', '21', 'Minsk', 'улица Петруся Бровки, 22', null, null, '2014-01-13 14:59:47', 'eac0b10ee1b2fd1a850864db07418cfc011d6891', '2');
INSERT INTO `venue` VALUES ('54', 'Re:Public', null, '21', 'Minsk', 'Pritytskogo Street, 62', null, null, '2014-01-13 15:01:50', '751198964e2c8626ac273dfb71db364740afcd5d', '2');

-- ----------------------------
-- Table structure for venue_file
-- ----------------------------
DROP TABLE IF EXISTS `venue_file`;
CREATE TABLE `venue_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_venue_file_venue_id` (`venue_id`),
  KEY `fk_venue_file_file_id` (`file_id`),
  CONSTRAINT `fk_venue_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_venue_file_venue_id` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of venue_file
-- ----------------------------

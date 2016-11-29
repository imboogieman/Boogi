/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50525
Source Host           : localhost:3336
Source Database       : stg.starway.pro

Target Server Type    : MYSQL
Target Server Version : 50525
File Encoding         : 65001

Date: 2014-04-08 15:47:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for artist
-- ----------------------------
DROP TABLE IF EXISTS `artist`;
CREATE TABLE `artist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `alias` varchar(64) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of artist
-- ----------------------------
INSERT INTO `artist` VALUES ('2', 'Maceo Plex', 'Miami', '2014-04-08 15:27:37', '40.714401', '-74.005997', '121776084502627', 'maceoplex', null, null, null, 'facebook', '2-maceo-plex', '63');
INSERT INTO `artist` VALUES ('3', 'Solomun', 'Hamburg, Germany', '2014-04-08 15:39:41', '53.551102', '9.993700', '127959800604028', 'solomun', null, null, null, 'gigatools', '3-solomun', '71');
INSERT INTO `artist` VALUES ('4', 'Nicolas Jaar', null, '2014-04-08 15:29:17', '40.714401', '-74.005997', '15727540611', 'nicolas-jaar', null, null, null, 'custom', '4-nicolas-jaar', '66');
INSERT INTO `artist` VALUES ('5', 'KOLLEKTIV TURMSTRASSE', null, '2014-04-08 15:27:08', '52.519199', '13.406100', '60920193415', 'kollektivturmstrasse', null, null, null, 'facebook', '5-kollektiv-turmstrasse', '62');
INSERT INTO `artist` VALUES ('7', 'Boris Brejcha', 'Frankenthal, Germany', '2014-04-08 14:41:22', '49.549999', '8.350000', '56409148326', 'boris-brejcha', 'Boris_Brejcha', null, 'boris8000', 'gigatools', '7-boris-brejcha', '51');
INSERT INTO `artist` VALUES ('8', 'Robert Owens', 'Chicago, IL, USA', '2014-04-08 15:32:35', '41.878113', '-87.629799', '167358279947609', null, 'robertowens7927', null, null, 'custom', '8-robert-owens', '70');
INSERT INTO `artist` VALUES ('9', 'Stephan Bodzin', 'Lisbon, Portugal', '2014-04-08 15:40:37', '38.725300', '-9.150036', '14923366771', 'stephanbodzin', null, null, null, 'gigatools', '9-stephan-bodzin', '73');
INSERT INTO `artist` VALUES ('10', 'Justin Martin', 'Weha, 95506 Kastl, Germany', '2014-04-08 14:50:14', '49.827766', '11.875106', '133990003325183', 'justin-martin-music', null, null, null, 'bandpage', '10-justin-martin', '60');
INSERT INTO `artist` VALUES ('11', 'Hot Since 82', 'Leeds, West Yorkshire, UK', '2014-04-08 14:48:42', '53.801277', '-1.548567', '169716129753913', 'hotsince-82', null, null, null, 'facebook', '11-hot-since-82', '57');
INSERT INTO `artist` VALUES ('13', 'Soul Clap', 'Outer Drive, Cocoa, FL 32926, USA', '2014-04-08 15:40:12', '28.380301', '-80.809242', '21021702448', 'soulclap', null, null, null, 'bandsintown', '13-soul-clap', '72');
INSERT INTO `artist` VALUES ('14', 'TONE of ARC', 'San Francisco, CA, USA', '2014-04-08 15:42:46', '37.774929', '-122.419418', '206988806053907', 'toneofarc', null, null, null, 'bandsintown', '14-tone-of-arc', '77');
INSERT INTO `artist` VALUES ('15', 'Portable aka Bodycode', 'Berlin, Germany', '2014-04-08 15:31:38', '52.520008', '13.404954', '121545827886922', 'portable-aka-bodycode', null, null, null, 'bandsintown', '15-portable-aka-bodycode', '69');
INSERT INTO `artist` VALUES ('16', 'Onur Engin', 'Istanbul, Turkey', '2014-01-19 08:29:35', '41.005268', '28.976959', '124049130972868', 'onur-engin', null, null, null, 'custom', '16-onur-engin', null);
INSERT INTO `artist` VALUES ('17', 'DJ Harvey', 'London Street, Los Angeles, CA 90026, USA', '2014-04-08 14:46:27', '34.076832', '-118.277840', '88409697422', null, null, null, null, 'custom', '17-dj-harvey', '53');
INSERT INTO `artist` VALUES ('18', 'Mark E', 'Wolverhampton, West Midlands, UK', '2014-01-19 08:29:35', '52.586971', '-2.128820', '342707501038', null, null, null, null, 'facebook', '18-mark-e', null);
INSERT INTO `artist` VALUES ('19', 'Todd Terje', 'Oslo, Norway', '2014-01-19 08:29:35', '59.913868', '10.752245', '65492833412', null, null, null, null, 'custom', '19-todd-terje', null);
INSERT INTO `artist` VALUES ('20', 'Morgan Geist', null, '2014-04-08 15:28:52', null, null, '11917214850', null, null, null, null, 'custom', '20-morgan-geist', '65');
INSERT INTO `artist` VALUES ('21', 'Duke Dumont', 'England, UK', '2014-04-08 14:47:00', '52.355518', '-1.174320', '20220408026', null, null, null, null, 'gigatools', '21-duke-dumont', '54');
INSERT INTO `artist` VALUES ('22', 'Disclosure', 'Reigate, Surrey, UK', '2014-01-19 08:29:35', '51.237274', '-0.205883', '137029526330648', null, null, null, null, 'songkick', '22-disclosure', null);
INSERT INTO `artist` VALUES ('23', 'Klaxons', 'London, UK', '2014-04-08 15:26:37', '51.511215', '-0.119824', '15106420351', null, null, null, null, 'facebook', '23-klaxons', '61');
INSERT INTO `artist` VALUES ('24', 'The xx', 'London, UK', '2014-01-19 08:29:35', '51.511215', '-0.119824', '10429446003', null, null, null, null, 'crowdsurge', '24-the-xx', null);
INSERT INTO `artist` VALUES ('25', 'Dusky', null, '2014-01-19 08:29:35', null, null, '153915844674108', null, null, null, null, 'bandsintown', '25-dusky', null);
INSERT INTO `artist` VALUES ('26', 'DJ Zinc', 'London, UK', '2014-01-19 08:29:35', '51.511215', '-0.119824', '209393620820', null, null, null, null, 'gigatools', '26-dj-zinc', null);
INSERT INTO `artist` VALUES ('27', 'Boys Noize', 'Berlin, Germany', '2014-01-19 08:29:35', '52.520008', '13.404954', '12350780802', null, null, null, null, 'bandsintown', '27-boys-noize', null);
INSERT INTO `artist` VALUES ('28', 'Vitalic Official', null, '2014-01-19 08:29:35', null, null, '99885177076', null, null, null, null, 'custom', '28-vitalic-official', null);
INSERT INTO `artist` VALUES ('29', 'Tiga', null, '2014-01-19 08:29:35', null, null, '57755305836', null, null, null, null, 'facebook', '29-tiga', null);
INSERT INTO `artist` VALUES ('30', 'Agoria', 'France', '2014-01-19 08:29:35', '46.227638', '2.213749', '20312443122', null, null, null, null, 'bandsintown', '30-agoria', null);
INSERT INTO `artist` VALUES ('31', 'Guy J', 'Tel Aviv, Israel', '2014-01-19 08:29:35', '32.066158', '34.777821', '47087533517', null, null, null, null, 'gigatools', '31-guy-j', null);
INSERT INTO `artist` VALUES ('32', 'Trentemøller', null, '2014-01-19 08:29:35', null, null, '22850309064', null, null, null, null, 'bandsintown', '32-trentem-ller', null);
INSERT INTO `artist` VALUES ('34', 'Jimpster', null, '2014-04-08 14:49:36', null, null, '139035726133180', null, null, null, null, 'bandsintown', '34-jimpster', '59');
INSERT INTO `artist` VALUES ('35', 'Marco V', null, '2014-01-19 08:29:35', null, null, '151364708207493', null, null, null, null, 'bandsintown', '35-marco-v', null);
INSERT INTO `artist` VALUES ('36', 'Sasse', 'Berlin, Germany', '2014-01-19 08:29:35', '52.520008', '13.404954', '149590818430671', null, null, null, null, 'gigatools', '36-sasse', null);
INSERT INTO `artist` VALUES ('37', 'Marc Romboy', 'Mönchengladbach, Germany', '2014-01-19 08:29:35', '51.180458', '6.442804', '36962943568', null, null, null, null, 'gigatools', '37-marc-romboy', null);
INSERT INTO `artist` VALUES ('38', 'Rodriguez Jr', null, '2014-01-19 08:29:35', null, null, '32204721637', null, null, null, null, 'gigatools', '38-rodriguez-jr', null);
INSERT INTO `artist` VALUES ('47', 'King Krule', null, '2014-01-19 08:29:35', null, null, '266120763398451', null, null, null, null, 'custom', '47-king-krule', null);
INSERT INTO `artist` VALUES ('48', 'The Rapture', null, '2014-01-19 08:29:35', null, null, '133896639724', null, null, null, null, 'facebook', '48-the-rapture', null);
INSERT INTO `artist` VALUES ('49', 'BONAPARTE', 'homeless, the world, st. helena', '2014-01-19 08:29:35', null, null, '44689108683', null, null, null, null, 'facebook', '49-bonaparte', null);
INSERT INTO `artist` VALUES ('50', 'The Drums', null, '2014-01-19 08:29:35', null, null, '74425214853', null, null, null, null, 'bandsintown', '50-the-drums', null);
INSERT INTO `artist` VALUES ('51', 'Ellen Allien Official Fanpage', 'Berlin, Germany', '2014-01-19 08:29:35', '52.520008', '13.404954', '259015572688', null, null, null, null, 'bandsintown', '51-ellen-allien-official-fanpage', null);
INSERT INTO `artist` VALUES ('52', 'Digitaria', 'Cydonia / Mars', '2014-01-19 08:29:35', null, null, '7011011039', null, null, null, null, 'gigatools', '52-digitaria', null);
INSERT INTO `artist` VALUES ('53', 'Kate Simko', 'Chicago, IL, USA', '2014-01-19 08:29:35', '41.878113', '-87.629799', '95289290299', null, null, null, null, 'bandsintown', '53-kate-simko', null);
INSERT INTO `artist` VALUES ('54', 'Tania Vulcano (OFFICIAL)', 'Montevideo, Uruguay', '2014-01-19 08:29:35', '-34.883610', '-56.181946', '152902551435441', null, null, null, null, 'reverbnation', '54-tania-vulcano-(official)', null);
INSERT INTO `artist` VALUES ('55', 'Timo Maas', null, '2014-01-19 08:29:35', null, null, '130089487611', null, null, null, null, 'bandpage', '55-timo-maas', null);
INSERT INTO `artist` VALUES ('57', 'H.O.S.H.', '', '2014-04-08 14:48:09', null, null, '112491825448634', null, null, null, null, 'bandsintown', '57-h-o-s-h-', '56');
INSERT INTO `artist` VALUES ('58', 'David August', '', '2014-04-08 14:42:27', null, null, '119285798131339', null, null, null, null, 'bandsintown', '58-david-august', '52');
INSERT INTO `artist` VALUES ('59', 'Noir', '', '2014-04-08 15:31:07', null, null, '31435196627', null, null, null, null, 'bandsintown', '59-noir', '68');
INSERT INTO `artist` VALUES ('60', 'Tiefschwarz', '', '2014-04-08 15:41:09', null, null, '140062266027735', null, null, null, null, 'bandsintown', '60-tiefschwarz', '74');
INSERT INTO `artist` VALUES ('62', 'Nina Kraviz', '', '2014-04-08 15:30:24', null, null, '192110944137172', null, null, null, null, 'bandsintown', '62-nina-kraviz', '67');
INSERT INTO `artist` VALUES ('63', 'Minilogue', 'Malmo, Sweden', '2014-04-08 15:28:18', '55.582741', '13.009630', '100338050031475', null, null, null, null, 'facebook', '63-minilogue', '64');
INSERT INTO `artist` VALUES ('64', 'Ivan Dorn', 'Vanya', '2014-04-08 14:49:17', null, null, '308452399177666', null, null, null, null, 'bandpage', '64-ivan-dorn', '58');
INSERT INTO `artist` VALUES ('65', 'Dusty Kid', 'Paolo Alberto Lodde', '2014-04-08 14:47:37', '41.994854', '12.482813', '17089762220', null, null, null, null, 'facebook', '65-dusty-kid', '55');
INSERT INTO `artist` VALUES ('66', 'Roster', 'Im a supa-dupa dj!', '2014-03-31 21:36:51', '53.900002', '27.600000', '0', null, null, null, null, 'facebook', '66-roster', '48');
INSERT INTO `artist` VALUES ('67', 'test', null, '2014-04-08 14:39:32', '53.900002', '27.600000', '0', null, null, null, null, 'facebook', '67-test', '49');

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
  KEY `fk_artist_file_artist_id` (`artist_id`) USING BTREE,
  KEY `fk_artist_file_file_id` (`file_id`) USING BTREE,
  CONSTRAINT `artist_file_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `artist_file_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of artist_file
-- ----------------------------
INSERT INTO `artist_file` VALUES ('1', '66', '8', '2014-03-31 21:36:51');

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
  UNIQUE KEY `uk_artist_gig` (`artist_id`,`gig_id`) USING BTREE,
  KEY `fk_artist_gig_artist_id` (`artist_id`) USING BTREE,
  KEY `fk_artist_gig_gig_id` (`gig_id`) USING BTREE,
  CONSTRAINT `artist_gig_ibfk_1` FOREIGN KEY (`gig_id`) REFERENCES `gig` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `artist_gig_ibfk_2` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13214 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of artist_gig
-- ----------------------------
INSERT INTO `artist_gig` VALUES ('3', '2', '3', '2014-02-05 21:00:42');
INSERT INTO `artist_gig` VALUES ('4', '2', '4', '2014-02-05 21:00:42');
INSERT INTO `artist_gig` VALUES ('25', '11', '25', '2014-02-05 21:00:51');
INSERT INTO `artist_gig` VALUES ('39', '15', '39', '2014-02-05 21:00:54');
INSERT INTO `artist_gig` VALUES ('40', '15', '40', '2014-02-05 21:00:54');
INSERT INTO `artist_gig` VALUES ('42', '17', '42', '2014-02-05 21:00:55');
INSERT INTO `artist_gig` VALUES ('44', '19', '44', '2014-02-05 21:00:57');
INSERT INTO `artist_gig` VALUES ('45', '19', '45', '2014-02-05 21:00:57');
INSERT INTO `artist_gig` VALUES ('53', '21', '53', '2014-02-05 21:00:59');
INSERT INTO `artist_gig` VALUES ('72', '22', '72', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('73', '22', '73', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('74', '22', '74', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('75', '22', '75', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('76', '22', '76', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('77', '22', '77', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('78', '22', '78', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('79', '22', '79', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('80', '22', '25', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('81', '22', '80', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('82', '22', '81', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('83', '22', '82', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('84', '22', '83', '2014-02-05 21:01:02');
INSERT INTO `artist_gig` VALUES ('85', '22', '84', '2014-02-05 21:01:03');
INSERT INTO `artist_gig` VALUES ('86', '22', '85', '2014-02-05 21:01:03');
INSERT INTO `artist_gig` VALUES ('109', '25', '45', '2014-02-05 21:01:07');
INSERT INTO `artist_gig` VALUES ('113', '27', '111', '2014-02-05 21:01:12');
INSERT INTO `artist_gig` VALUES ('114', '27', '112', '2014-02-05 21:01:12');
INSERT INTO `artist_gig` VALUES ('118', '28', '116', '2014-02-05 21:01:13');
INSERT INTO `artist_gig` VALUES ('119', '28', '117', '2014-02-05 21:01:13');
INSERT INTO `artist_gig` VALUES ('123', '29', '53', '2014-02-05 21:01:15');
INSERT INTO `artist_gig` VALUES ('124', '29', '121', '2014-02-05 21:01:15');
INSERT INTO `artist_gig` VALUES ('141', '32', '138', '2014-02-05 21:01:18');
INSERT INTO `artist_gig` VALUES ('148', '49', '144', '2014-02-05 21:01:27');
INSERT INTO `artist_gig` VALUES ('166', '51', '162', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('167', '51', '163', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('168', '51', '164', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('169', '51', '165', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('170', '51', '166', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('171', '51', '167', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('172', '51', '168', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('173', '51', '169', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('174', '51', '170', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('175', '51', '171', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('176', '51', '172', '2014-02-05 21:01:31');
INSERT INTO `artist_gig` VALUES ('180', '53', '176', '2014-02-05 21:01:35');
INSERT INTO `artist_gig` VALUES ('187', '55', '183', '2014-02-05 21:01:36');
INSERT INTO `artist_gig` VALUES ('188', '55', '184', '2014-02-05 21:01:37');
INSERT INTO `artist_gig` VALUES ('189', '55', '185', '2014-02-05 21:01:37');
INSERT INTO `artist_gig` VALUES ('190', '55', '186', '2014-02-05 21:01:37');
INSERT INTO `artist_gig` VALUES ('191', '55', '187', '2014-02-05 21:01:37');
INSERT INTO `artist_gig` VALUES ('192', '55', '188', '2014-02-05 21:01:37');
INSERT INTO `artist_gig` VALUES ('193', '55', '189', '2014-02-05 21:01:37');
INSERT INTO `artist_gig` VALUES ('194', '55', '190', '2014-02-05 21:01:37');
INSERT INTO `artist_gig` VALUES ('195', '55', '191', '2014-02-05 21:01:37');
INSERT INTO `artist_gig` VALUES ('196', '5', '192', '2014-02-05 21:02:18');
INSERT INTO `artist_gig` VALUES ('197', '5', '193', '2014-02-05 21:02:18');
INSERT INTO `artist_gig` VALUES ('199', '5', '195', '2014-02-05 21:02:20');
INSERT INTO `artist_gig` VALUES ('200', '5', '196', '2014-02-05 21:02:20');
INSERT INTO `artist_gig` VALUES ('201', '5', '197', '2014-02-05 21:02:21');
INSERT INTO `artist_gig` VALUES ('202', '5', '198', '2014-02-05 21:02:21');
INSERT INTO `artist_gig` VALUES ('203', '5', '199', '2014-02-05 21:02:22');
INSERT INTO `artist_gig` VALUES ('204', '5', '200', '2014-02-05 21:02:22');
INSERT INTO `artist_gig` VALUES ('205', '5', '201', '2014-02-05 21:02:23');
INSERT INTO `artist_gig` VALUES ('206', '5', '202', '2014-02-05 21:02:23');
INSERT INTO `artist_gig` VALUES ('207', '5', '203', '2014-02-05 21:02:24');
INSERT INTO `artist_gig` VALUES ('208', '5', '204', '2014-02-05 21:02:24');
INSERT INTO `artist_gig` VALUES ('209', '5', '205', '2014-02-05 21:02:25');
INSERT INTO `artist_gig` VALUES ('226', '49', '222', '2014-02-05 21:03:00');
INSERT INTO `artist_gig` VALUES ('227', '49', '223', '2014-02-05 21:03:00');
INSERT INTO `artist_gig` VALUES ('727', '65', '230', '2014-02-07 01:46:18');
INSERT INTO `artist_gig` VALUES ('728', '65', '231', '2014-02-07 01:46:18');
INSERT INTO `artist_gig` VALUES ('729', '65', '232', '2014-02-07 01:46:18');
INSERT INTO `artist_gig` VALUES ('811', '22', '233', '2014-02-07 01:47:36');
INSERT INTO `artist_gig` VALUES ('1223', '23', '244', '2014-02-08 07:01:22');
INSERT INTO `artist_gig` VALUES ('1224', '23', '245', '2014-02-08 07:01:24');
INSERT INTO `artist_gig` VALUES ('1225', '23', '246', '2014-02-08 07:01:25');
INSERT INTO `artist_gig` VALUES ('1226', '23', '247', '2014-02-08 07:01:27');
INSERT INTO `artist_gig` VALUES ('1267', '13', '255', '2014-02-09 06:00:15');
INSERT INTO `artist_gig` VALUES ('1268', '13', '256', '2014-02-09 06:00:15');
INSERT INTO `artist_gig` VALUES ('1269', '13', '257', '2014-02-09 06:00:15');
INSERT INTO `artist_gig` VALUES ('1270', '13', '258', '2014-02-09 06:00:15');
INSERT INTO `artist_gig` VALUES ('1271', '13', '259', '2014-02-09 06:00:15');
INSERT INTO `artist_gig` VALUES ('1272', '13', '260', '2014-02-09 06:00:15');
INSERT INTO `artist_gig` VALUES ('1273', '13', '261', '2014-02-09 06:00:15');
INSERT INTO `artist_gig` VALUES ('1378', '32', '264', '2014-02-09 06:00:27');
INSERT INTO `artist_gig` VALUES ('1408', '51', '265', '2014-02-09 06:00:34');
INSERT INTO `artist_gig` VALUES ('1835', '27', '273', '2014-02-11 06:00:22');
INSERT INTO `artist_gig` VALUES ('1837', '27', '274', '2014-02-11 06:00:22');
INSERT INTO `artist_gig` VALUES ('1982', '10', '276', '2014-02-12 06:00:09');
INSERT INTO `artist_gig` VALUES ('2028', '21', '281', '2014-02-12 06:00:17');
INSERT INTO `artist_gig` VALUES ('2029', '21', '282', '2014-02-12 06:00:17');
INSERT INTO `artist_gig` VALUES ('2030', '21', '283', '2014-02-12 06:00:17');
INSERT INTO `artist_gig` VALUES ('2031', '21', '284', '2014-02-12 06:00:17');
INSERT INTO `artist_gig` VALUES ('2049', '22', '276', '2014-02-12 06:00:18');
INSERT INTO `artist_gig` VALUES ('2060', '22', '285', '2014-02-12 06:00:18');
INSERT INTO `artist_gig` VALUES ('2066', '22', '286', '2014-02-12 06:00:18');
INSERT INTO `artist_gig` VALUES ('2137', '47', '291', '2014-02-12 06:00:28');
INSERT INTO `artist_gig` VALUES ('2138', '47', '292', '2014-02-12 06:00:28');
INSERT INTO `artist_gig` VALUES ('2177', '55', '293', '2014-02-12 06:00:33');
INSERT INTO `artist_gig` VALUES ('2674', '32', '301', '2014-02-14 06:00:23');
INSERT INTO `artist_gig` VALUES ('3494', '27', '318', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3495', '27', '319', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3498', '27', '320', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3501', '27', '321', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3502', '27', '322', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3503', '27', '323', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3504', '27', '324', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3505', '27', '325', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3506', '27', '326', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3507', '27', '327', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3508', '27', '328', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3509', '27', '329', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3510', '27', '330', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3511', '27', '331', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3513', '27', '333', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3514', '27', '334', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3515', '27', '335', '2014-02-19 06:00:21');
INSERT INTO `artist_gig` VALUES ('3807', '27', '347', '2014-02-20 06:00:21');
INSERT INTO `artist_gig` VALUES ('3836', '32', '349', '2014-02-20 06:00:25');
INSERT INTO `artist_gig` VALUES ('3896', '5', '351', '2014-02-20 07:00:11');
INSERT INTO `artist_gig` VALUES ('3907', '5', '352', '2014-02-20 07:00:24');
INSERT INTO `artist_gig` VALUES ('3911', '5', '353', '2014-02-20 07:00:29');
INSERT INTO `artist_gig` VALUES ('3929', '23', '355', '2014-02-20 07:01:19');
INSERT INTO `artist_gig` VALUES ('3930', '23', '356', '2014-02-20 07:01:20');
INSERT INTO `artist_gig` VALUES ('4029', '9', '357', '2014-02-23 06:00:09');
INSERT INTO `artist_gig` VALUES ('4075', '18', '359', '2014-02-23 06:00:14');
INSERT INTO `artist_gig` VALUES ('4079', '19', '360', '2014-02-23 06:00:14');
INSERT INTO `artist_gig` VALUES ('4080', '20', '361', '2014-02-23 06:00:15');
INSERT INTO `artist_gig` VALUES ('4111', '22', '363', '2014-02-23 06:00:17');
INSERT INTO `artist_gig` VALUES ('4115', '22', '364', '2014-02-23 06:00:17');
INSERT INTO `artist_gig` VALUES ('4119', '22', '365', '2014-02-23 06:00:18');
INSERT INTO `artist_gig` VALUES ('4134', '23', '369', '2014-02-23 06:00:18');
INSERT INTO `artist_gig` VALUES ('4135', '23', '370', '2014-02-23 06:00:18');
INSERT INTO `artist_gig` VALUES ('4137', '23', '372', '2014-02-23 06:00:18');
INSERT INTO `artist_gig` VALUES ('4138', '23', '373', '2014-02-23 06:00:18');
INSERT INTO `artist_gig` VALUES ('4139', '23', '374', '2014-02-23 06:00:19');
INSERT INTO `artist_gig` VALUES ('4282', '55', '381', '2014-02-23 06:00:35');
INSERT INTO `artist_gig` VALUES ('4286', '55', '382', '2014-02-23 06:00:35');
INSERT INTO `artist_gig` VALUES ('4287', '55', '383', '2014-02-23 06:00:35');
INSERT INTO `artist_gig` VALUES ('4288', '55', '384', '2014-02-23 06:00:35');
INSERT INTO `artist_gig` VALUES ('4289', '55', '385', '2014-02-23 06:00:35');
INSERT INTO `artist_gig` VALUES ('4640', '2', '387', '2014-02-25 06:00:05');
INSERT INTO `artist_gig` VALUES ('4645', '4', '388', '2014-02-25 06:00:06');
INSERT INTO `artist_gig` VALUES ('4979', '23', '390', '2014-02-26 07:01:12');
INSERT INTO `artist_gig` VALUES ('5169', '22', '396', '2014-03-01 06:00:21');
INSERT INTO `artist_gig` VALUES ('5221', '25', '398', '2014-03-01 06:00:25');
INSERT INTO `artist_gig` VALUES ('5282', '32', '403', '2014-03-01 06:00:30');
INSERT INTO `artist_gig` VALUES ('5314', '51', '408', '2014-03-01 06:00:37');
INSERT INTO `artist_gig` VALUES ('5494', '19', '412', '2014-03-03 06:00:20');
INSERT INTO `artist_gig` VALUES ('5580', '25', '286', '2014-03-03 06:00:25');
INSERT INTO `artist_gig` VALUES ('5871', '15', '416', '2014-03-06 06:00:11');
INSERT INTO `artist_gig` VALUES ('5873', '15', '417', '2014-03-06 06:00:11');
INSERT INTO `artist_gig` VALUES ('5918', '22', '418', '2014-03-06 06:00:16');
INSERT INTO `artist_gig` VALUES ('5928', '22', '419', '2014-03-06 06:00:16');
INSERT INTO `artist_gig` VALUES ('6087', '23', '425', '2014-03-07 07:01:15');
INSERT INTO `artist_gig` VALUES ('6165', '13', '429', '2014-03-09 06:00:18');
INSERT INTO `artist_gig` VALUES ('6166', '13', '430', '2014-03-09 06:00:18');
INSERT INTO `artist_gig` VALUES ('6207', '21', '431', '2014-03-09 06:00:23');
INSERT INTO `artist_gig` VALUES ('6219', '22', '432', '2014-03-09 06:00:27');
INSERT INTO `artist_gig` VALUES ('6235', '22', '433', '2014-03-09 06:00:27');
INSERT INTO `artist_gig` VALUES ('6244', '22', '434', '2014-03-09 06:00:27');
INSERT INTO `artist_gig` VALUES ('6316', '27', '435', '2014-03-09 06:00:32');
INSERT INTO `artist_gig` VALUES ('6340', '32', '436', '2014-03-09 06:00:35');
INSERT INTO `artist_gig` VALUES ('6380', '53', '438', '2014-03-09 06:00:43');
INSERT INTO `artist_gig` VALUES ('6382', '53', '439', '2014-03-09 06:00:43');
INSERT INTO `artist_gig` VALUES ('6383', '53', '440', '2014-03-09 06:00:43');
INSERT INTO `artist_gig` VALUES ('6394', '55', '441', '2014-03-09 06:00:45');
INSERT INTO `artist_gig` VALUES ('6399', '55', '442', '2014-03-09 06:00:45');
INSERT INTO `artist_gig` VALUES ('6661', '27', '443', '2014-03-11 06:00:22');
INSERT INTO `artist_gig` VALUES ('6676', '29', '445', '2014-03-11 06:00:24');
INSERT INTO `artist_gig` VALUES ('6773', '11', '447', '2014-03-11 07:00:47');
INSERT INTO `artist_gig` VALUES ('6774', '11', '448', '2014-03-11 07:00:50');
INSERT INTO `artist_gig` VALUES ('6918', '21', '454', '2014-03-13 06:00:17');
INSERT INTO `artist_gig` VALUES ('6955', '22', '455', '2014-03-13 06:00:20');
INSERT INTO `artist_gig` VALUES ('7114', '63', '457', '2014-03-13 06:00:41');
INSERT INTO `artist_gig` VALUES ('7512', '15', '461', '2014-03-15 06:00:17');
INSERT INTO `artist_gig` VALUES ('7580', '23', '462', '2014-03-15 06:00:32');
INSERT INTO `artist_gig` VALUES ('7582', '23', '463', '2014-03-15 06:00:33');
INSERT INTO `artist_gig` VALUES ('7765', '23', '464', '2014-03-15 07:02:23');
INSERT INTO `artist_gig` VALUES ('8230', '49', '465', '2014-03-20 07:02:01');
INSERT INTO `artist_gig` VALUES ('8231', '49', '466', '2014-03-20 07:02:02');
INSERT INTO `artist_gig` VALUES ('8233', '49', '467', '2014-03-20 07:02:05');
INSERT INTO `artist_gig` VALUES ('8234', '49', '468', '2014-03-20 07:02:06');
INSERT INTO `artist_gig` VALUES ('8235', '49', '469', '2014-03-20 07:02:07');
INSERT INTO `artist_gig` VALUES ('8236', '49', '470', '2014-03-20 07:02:08');
INSERT INTO `artist_gig` VALUES ('8237', '49', '471', '2014-03-20 07:02:09');
INSERT INTO `artist_gig` VALUES ('8248', '10', '472', '2014-03-21 06:00:11');
INSERT INTO `artist_gig` VALUES ('8267', '13', '474', '2014-03-21 06:00:13');
INSERT INTO `artist_gig` VALUES ('8270', '13', '476', '2014-03-21 06:00:14');
INSERT INTO `artist_gig` VALUES ('8272', '13', '478', '2014-03-21 06:00:14');
INSERT INTO `artist_gig` VALUES ('8273', '13', '479', '2014-03-21 06:00:14');
INSERT INTO `artist_gig` VALUES ('8274', '13', '480', '2014-03-21 06:00:14');
INSERT INTO `artist_gig` VALUES ('8275', '13', '481', '2014-03-21 06:00:14');
INSERT INTO `artist_gig` VALUES ('8281', '14', '482', '2014-03-21 06:00:15');
INSERT INTO `artist_gig` VALUES ('8282', '14', '483', '2014-03-21 06:00:15');
INSERT INTO `artist_gig` VALUES ('8283', '14', '484', '2014-03-21 06:00:15');
INSERT INTO `artist_gig` VALUES ('8284', '14', '485', '2014-03-21 06:00:15');
INSERT INTO `artist_gig` VALUES ('8359', '23', '486', '2014-03-21 06:00:21');
INSERT INTO `artist_gig` VALUES ('8379', '25', '443', '2014-03-21 06:00:23');
INSERT INTO `artist_gig` VALUES ('8412', '27', '487', '2014-03-21 06:00:25');
INSERT INTO `artist_gig` VALUES ('8435', '32', '489', '2014-03-21 06:00:28');
INSERT INTO `artist_gig` VALUES ('8439', '34', '490', '2014-03-21 06:00:28');
INSERT INTO `artist_gig` VALUES ('8495', '55', '491', '2014-03-21 06:00:36');
INSERT INTO `artist_gig` VALUES ('8500', '65', '492', '2014-03-21 06:00:37');
INSERT INTO `artist_gig` VALUES ('8566', '7', '493', '2014-03-23 06:00:10');
INSERT INTO `artist_gig` VALUES ('8621', '19', '494', '2014-03-23 06:00:17');
INSERT INTO `artist_gig` VALUES ('8631', '21', '497', '2014-03-23 06:00:18');
INSERT INTO `artist_gig` VALUES ('8632', '21', '498', '2014-03-23 06:00:18');
INSERT INTO `artist_gig` VALUES ('8738', '29', '499', '2014-03-23 06:00:25');
INSERT INTO `artist_gig` VALUES ('9079', '29', '500', '2014-03-25 06:00:21');
INSERT INTO `artist_gig` VALUES ('9265', '23', '501', '2014-03-25 23:44:50');
INSERT INTO `artist_gig` VALUES ('9395', '59', '505', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9396', '59', '506', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9397', '59', '507', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9398', '59', '508', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9399', '59', '509', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9400', '59', '510', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9401', '59', '511', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9402', '59', '512', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9403', '59', '513', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9404', '59', '514', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9405', '59', '515', '2014-03-25 23:45:06');
INSERT INTO `artist_gig` VALUES ('9413', '62', '521', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9414', '62', '522', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9415', '62', '523', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9416', '62', '524', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9417', '62', '525', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9418', '62', '526', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9419', '62', '527', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9420', '62', '528', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9421', '62', '529', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9422', '62', '530', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9423', '62', '531', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9424', '62', '185', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9425', '62', '532', '2014-03-25 23:45:08');
INSERT INTO `artist_gig` VALUES ('9883', '32', '533', '2014-03-26 06:00:27');
INSERT INTO `artist_gig` VALUES ('10067', '49', '534', '2014-03-27 07:02:01');
INSERT INTO `artist_gig` VALUES ('10184', '21', '537', '2014-03-29 06:00:14');
INSERT INTO `artist_gig` VALUES ('10187', '22', '538', '2014-03-29 06:00:16');
INSERT INTO `artist_gig` VALUES ('10274', '29', '539', '2014-03-29 06:00:21');
INSERT INTO `artist_gig` VALUES ('10275', '29', '540', '2014-03-29 06:00:21');
INSERT INTO `artist_gig` VALUES ('10295', '32', '541', '2014-03-29 06:00:24');
INSERT INTO `artist_gig` VALUES ('10785', '2', '542', '2014-03-31 16:30:44');
INSERT INTO `artist_gig` VALUES ('10796', '10', '543', '2014-03-31 16:30:48');
INSERT INTO `artist_gig` VALUES ('10797', '11', '544', '2014-03-31 16:30:49');
INSERT INTO `artist_gig` VALUES ('10810', '13', '543', '2014-03-31 16:30:57');
INSERT INTO `artist_gig` VALUES ('10830', '17', '546', '2014-03-31 16:31:10');
INSERT INTO `artist_gig` VALUES ('10895', '23', '547', '2014-03-31 16:31:33');
INSERT INTO `artist_gig` VALUES ('10938', '31', '548', '2014-03-31 16:31:48');
INSERT INTO `artist_gig` VALUES ('11027', '13', '549', '2014-04-01 00:02:19');
INSERT INTO `artist_gig` VALUES ('11066', '49', '550', '2014-04-01 07:01:48');
INSERT INTO `artist_gig` VALUES ('11129', '19', '552', '2014-04-02 06:00:19');
INSERT INTO `artist_gig` VALUES ('11220', '27', '554', '2014-04-02 06:00:29');
INSERT INTO `artist_gig` VALUES ('11244', '37', '555', '2014-04-02 06:00:34');
INSERT INTO `artist_gig` VALUES ('11293', '59', '556', '2014-04-02 06:00:41');
INSERT INTO `artist_gig` VALUES ('11338', '11', '557', '2014-04-02 07:00:43');
INSERT INTO `artist_gig` VALUES ('11339', '11', '558', '2014-04-02 07:00:44');
INSERT INTO `artist_gig` VALUES ('11340', '11', '559', '2014-04-02 07:00:45');
INSERT INTO `artist_gig` VALUES ('11341', '11', '560', '2014-04-02 07:00:48');
INSERT INTO `artist_gig` VALUES ('11342', '11', '561', '2014-04-02 07:00:49');
INSERT INTO `artist_gig` VALUES ('11343', '11', '562', '2014-04-02 07:00:50');
INSERT INTO `artist_gig` VALUES ('11344', '11', '563', '2014-04-02 07:00:51');
INSERT INTO `artist_gig` VALUES ('11345', '11', '564', '2014-04-02 07:00:53');
INSERT INTO `artist_gig` VALUES ('11346', '11', '565', '2014-04-02 07:00:54');
INSERT INTO `artist_gig` VALUES ('11347', '11', '566', '2014-04-02 07:00:55');
INSERT INTO `artist_gig` VALUES ('11348', '11', '567', '2014-04-02 07:00:56');
INSERT INTO `artist_gig` VALUES ('11375', '22', '568', '2014-04-02 15:45:04');
INSERT INTO `artist_gig` VALUES ('11395', '11', '569', '2014-04-03 07:00:46');
INSERT INTO `artist_gig` VALUES ('11396', '11', '570', '2014-04-03 07:00:47');
INSERT INTO `artist_gig` VALUES ('11397', '11', '571', '2014-04-03 07:00:48');
INSERT INTO `artist_gig` VALUES ('11453', '13', '572', '2014-04-04 00:13:13');
INSERT INTO `artist_gig` VALUES ('11542', '25', '573', '2014-04-04 00:13:23');
INSERT INTO `artist_gig` VALUES ('11622', '55', '574', '2014-04-04 00:13:38');
INSERT INTO `artist_gig` VALUES ('11623', '55', '575', '2014-04-04 00:13:38');
INSERT INTO `artist_gig` VALUES ('11625', '55', '576', '2014-04-04 00:13:38');
INSERT INTO `artist_gig` VALUES ('11626', '55', '577', '2014-04-04 00:13:38');
INSERT INTO `artist_gig` VALUES ('11629', '55', '578', '2014-04-04 00:13:38');
INSERT INTO `artist_gig` VALUES ('11662', '62', '579', '2014-04-04 00:13:42');
INSERT INTO `artist_gig` VALUES ('12036', '55', '580', '2014-04-04 00:29:45');
INSERT INTO `artist_gig` VALUES ('12505', '5', '582', '2014-04-04 07:00:21');
INSERT INTO `artist_gig` VALUES ('12574', '13', '583', '2014-04-05 06:00:20');
INSERT INTO `artist_gig` VALUES ('12576', '13', '584', '2014-04-05 06:00:20');
INSERT INTO `artist_gig` VALUES ('12580', '13', '585', '2014-04-05 06:00:20');
INSERT INTO `artist_gig` VALUES ('12584', '13', '586', '2014-04-05 06:00:20');
INSERT INTO `artist_gig` VALUES ('12585', '13', '587', '2014-04-05 06:00:20');
INSERT INTO `artist_gig` VALUES ('12604', '17', '588', '2014-04-05 06:00:23');
INSERT INTO `artist_gig` VALUES ('12789', '62', '589', '2014-04-05 06:00:48');
INSERT INTO `artist_gig` VALUES ('12914', '2', '590', '2014-04-07 06:00:23');
INSERT INTO `artist_gig` VALUES ('12966', '21', '591', '2014-04-07 06:00:35');
INSERT INTO `artist_gig` VALUES ('12968', '21', '592', '2014-04-07 06:00:35');
INSERT INTO `artist_gig` VALUES ('12972', '21', '593', '2014-04-07 06:00:35');
INSERT INTO `artist_gig` VALUES ('12974', '21', '594', '2014-04-07 06:00:35');
INSERT INTO `artist_gig` VALUES ('12976', '21', '595', '2014-04-07 06:00:35');
INSERT INTO `artist_gig` VALUES ('12994', '22', '596', '2014-04-07 06:00:37');
INSERT INTO `artist_gig` VALUES ('13073', '47', '597', '2014-04-07 06:00:48');
INSERT INTO `artist_gig` VALUES ('13074', '47', '598', '2014-04-07 06:00:48');
INSERT INTO `artist_gig` VALUES ('13089', '51', '599', '2014-04-07 06:00:50');
INSERT INTO `artist_gig` VALUES ('13090', '51', '600', '2014-04-07 06:00:50');
INSERT INTO `artist_gig` VALUES ('13091', '51', '601', '2014-04-07 06:00:50');
INSERT INTO `artist_gig` VALUES ('13092', '51', '602', '2014-04-07 06:00:50');
INSERT INTO `artist_gig` VALUES ('13094', '51', '603', '2014-04-07 06:00:50');
INSERT INTO `artist_gig` VALUES ('13095', '51', '604', '2014-04-07 06:00:50');
INSERT INTO `artist_gig` VALUES ('13097', '51', '605', '2014-04-07 06:00:50');
INSERT INTO `artist_gig` VALUES ('13098', '51', '606', '2014-04-07 06:00:50');

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
  KEY `fk_artist_promoter_artist_id` (`artist_id`) USING BTREE,
  KEY `fk_artist_promoter_promoter_id` (`promoter_id`) USING BTREE,
  CONSTRAINT `artist_promoter_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `artist_promoter_ibfk_2` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of artist_promoter
-- ----------------------------
INSERT INTO `artist_promoter` VALUES ('2', '7', '4', '2013-10-29 04:45:23');
INSERT INTO `artist_promoter` VALUES ('9', '3', '4', '2013-11-19 02:02:37');
INSERT INTO `artist_promoter` VALUES ('10', '10', '4', '2013-11-19 02:02:39');
INSERT INTO `artist_promoter` VALUES ('18', '19', '10', '2014-01-03 23:06:03');
INSERT INTO `artist_promoter` VALUES ('27', '5', '4', '2014-01-13 23:53:17');
INSERT INTO `artist_promoter` VALUES ('35', '30', '18', '2014-01-21 01:54:04');
INSERT INTO `artist_promoter` VALUES ('36', '31', '18', '2014-01-21 01:54:08');
INSERT INTO `artist_promoter` VALUES ('37', '32', '18', '2014-01-21 01:54:15');
INSERT INTO `artist_promoter` VALUES ('38', '3', '18', '2014-01-21 01:54:53');
INSERT INTO `artist_promoter` VALUES ('39', '34', '18', '2014-01-21 01:55:14');
INSERT INTO `artist_promoter` VALUES ('40', '29', '18', '2014-01-21 01:55:20');
INSERT INTO `artist_promoter` VALUES ('41', '35', '18', '2014-01-21 01:55:26');
INSERT INTO `artist_promoter` VALUES ('42', '36', '18', '2014-01-21 01:55:42');
INSERT INTO `artist_promoter` VALUES ('43', '37', '18', '2014-01-21 01:55:48');
INSERT INTO `artist_promoter` VALUES ('44', '38', '18', '2014-01-21 01:55:56');
INSERT INTO `artist_promoter` VALUES ('45', '2', '19', '2014-01-21 01:58:53');
INSERT INTO `artist_promoter` VALUES ('46', '3', '19', '2014-01-21 01:58:59');
INSERT INTO `artist_promoter` VALUES ('47', '4', '19', '2014-01-21 01:59:01');
INSERT INTO `artist_promoter` VALUES ('48', '5', '19', '2014-01-21 01:59:07');
INSERT INTO `artist_promoter` VALUES ('49', '25', '19', '2014-01-21 01:59:19');
INSERT INTO `artist_promoter` VALUES ('50', '7', '19', '2014-01-21 01:59:38');
INSERT INTO `artist_promoter` VALUES ('51', '8', '19', '2014-01-21 02:00:08');
INSERT INTO `artist_promoter` VALUES ('52', '9', '19', '2014-01-21 02:00:12');
INSERT INTO `artist_promoter` VALUES ('53', '10', '19', '2014-01-21 02:00:25');
INSERT INTO `artist_promoter` VALUES ('54', '11', '19', '2014-01-21 02:00:32');
INSERT INTO `artist_promoter` VALUES ('55', '47', '15', '2014-01-21 02:02:21');
INSERT INTO `artist_promoter` VALUES ('56', '48', '15', '2014-01-21 02:02:44');
INSERT INTO `artist_promoter` VALUES ('57', '49', '15', '2014-01-21 02:02:51');
INSERT INTO `artist_promoter` VALUES ('58', '50', '15', '2014-01-21 02:03:03');
INSERT INTO `artist_promoter` VALUES ('59', '53', '15', '2014-01-21 02:04:38');
INSERT INTO `artist_promoter` VALUES ('60', '54', '15', '2014-01-21 02:05:02');
INSERT INTO `artist_promoter` VALUES ('61', '51', '15', '2014-01-21 02:05:04');
INSERT INTO `artist_promoter` VALUES ('62', '52', '15', '2014-01-21 02:05:31');
INSERT INTO `artist_promoter` VALUES ('63', '55', '15', '2014-01-21 02:05:38');
INSERT INTO `artist_promoter` VALUES ('64', '13', '17', '2014-01-21 02:12:08');
INSERT INTO `artist_promoter` VALUES ('65', '14', '17', '2014-01-21 02:12:25');
INSERT INTO `artist_promoter` VALUES ('66', '15', '17', '2014-01-21 02:12:29');
INSERT INTO `artist_promoter` VALUES ('67', '16', '17', '2014-01-21 02:12:42');
INSERT INTO `artist_promoter` VALUES ('68', '17', '17', '2014-01-21 02:12:47');
INSERT INTO `artist_promoter` VALUES ('69', '18', '17', '2014-01-21 02:13:08');
INSERT INTO `artist_promoter` VALUES ('70', '19', '17', '2014-01-21 02:13:09');
INSERT INTO `artist_promoter` VALUES ('71', '20', '17', '2014-01-21 02:13:10');
INSERT INTO `artist_promoter` VALUES ('81', '29', '16', '2014-01-21 02:18:24');
INSERT INTO `artist_promoter` VALUES ('82', '28', '16', '2014-01-21 02:18:27');
INSERT INTO `artist_promoter` VALUES ('83', '27', '16', '2014-01-21 02:18:39');
INSERT INTO `artist_promoter` VALUES ('84', '25', '16', '2014-01-21 02:18:40');
INSERT INTO `artist_promoter` VALUES ('85', '23', '16', '2014-01-21 02:18:54');
INSERT INTO `artist_promoter` VALUES ('86', '24', '16', '2014-01-21 02:18:55');
INSERT INTO `artist_promoter` VALUES ('87', '22', '16', '2014-01-21 02:18:58');
INSERT INTO `artist_promoter` VALUES ('88', '21', '16', '2014-01-21 02:19:00');
INSERT INTO `artist_promoter` VALUES ('89', '26', '16', '2014-01-21 02:19:03');
INSERT INTO `artist_promoter` VALUES ('90', '29', '12', '2014-01-21 02:21:36');
INSERT INTO `artist_promoter` VALUES ('91', '13', '12', '2014-01-21 02:21:38');
INSERT INTO `artist_promoter` VALUES ('92', '55', '12', '2014-01-21 02:21:39');
INSERT INTO `artist_promoter` VALUES ('93', '34', '12', '2014-01-21 02:21:42');
INSERT INTO `artist_promoter` VALUES ('94', '53', '12', '2014-01-21 02:21:47');
INSERT INTO `artist_promoter` VALUES ('95', '25', '12', '2014-01-21 02:21:52');
INSERT INTO `artist_promoter` VALUES ('96', '9', '12', '2014-01-21 02:21:58');
INSERT INTO `artist_promoter` VALUES ('97', '4', '12', '2014-01-21 02:22:01');
INSERT INTO `artist_promoter` VALUES ('98', '19', '12', '2014-01-21 02:22:14');
INSERT INTO `artist_promoter` VALUES ('99', '13', '10', '2014-01-22 06:19:17');
INSERT INTO `artist_promoter` VALUES ('100', '11', '4', '2014-01-24 01:23:15');
INSERT INTO `artist_promoter` VALUES ('102', '22', '10', '2014-01-29 14:22:58');
INSERT INTO `artist_promoter` VALUES ('103', '4', '10', '2014-01-29 14:29:49');
INSERT INTO `artist_promoter` VALUES ('104', '34', '10', '2014-01-29 14:29:54');
INSERT INTO `artist_promoter` VALUES ('106', '22', '4', '2014-03-22 15:50:39');
INSERT INTO `artist_promoter` VALUES ('107', '22', '21', '2014-03-31 21:54:28');
INSERT INTO `artist_promoter` VALUES ('108', '62', '10', '2014-03-31 23:57:38');
INSERT INTO `artist_promoter` VALUES ('109', '2', '10', '2014-03-31 23:57:47');
INSERT INTO `artist_promoter` VALUES ('110', '64', '10', '2014-03-31 23:58:01');
INSERT INTO `artist_promoter` VALUES ('111', '14', '4', '2014-04-02 15:39:05');
INSERT INTO `artist_promoter` VALUES ('112', '55', '4', '2014-04-04 00:40:25');

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
-- Table structure for event
-- ----------------------------
DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(32) unsigned NOT NULL,
  `init_type` varchar(64) NOT NULL,
  `init_id` int(11) NOT NULL,
  `target_type` varchar(64) NOT NULL,
  `target_id` int(11) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `creator_id` int(11) DEFAULT NULL,
  `creator_type` varchar(64) DEFAULT NULL,
  `email_status` tinyint(1) DEFAULT '0',
  `email_attempts` tinyint(1) DEFAULT '0',
  `init_name` varchar(64) DEFAULT NULL,
  `init_link` varchar(255) DEFAULT NULL,
  `target_name` varchar(64) DEFAULT NULL,
  `target_link` varchar(255) DEFAULT NULL,
  `creator_name` varchar(64) DEFAULT NULL,
  `creator_link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1347 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of event
-- ----------------------------
INSERT INTO `event` VALUES ('1346', '5', 'Artist', '51', 'Gig', '606', '2014-04-07 06:00:51', '15', 'Promoter', '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Lehman in Stuttgart, Germany', '#/gig/606-ellen-allien-@-lehman-in-stuttgart-germany', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1345', '6', 'Artist', '51', 'Gig', '606', '2014-04-07 06:00:51', null, null, '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Lehman in Stuttgart, Germany', '#/gig/606-ellen-allien-@-lehman-in-stuttgart-germany', null, null);
INSERT INTO `event` VALUES ('1344', '5', 'Artist', '51', 'Gig', '605', '2014-04-07 06:00:50', '15', 'Promoter', '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Traumschiff in Chiemsee, Germany', '#/gig/605-ellen-allien-@-traumschiff-in-chiemsee-germany', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1343', '6', 'Artist', '51', 'Gig', '605', '2014-04-07 06:00:50', null, null, '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Traumschiff in Chiemsee, Germany', '#/gig/605-ellen-allien-@-traumschiff-in-chiemsee-germany', null, null);
INSERT INTO `event` VALUES ('1342', '5', 'Artist', '51', 'Gig', '604', '2014-04-07 06:00:50', '15', 'Promoter', '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Klangkino in Gebesee, Germany', '#/gig/604-ellen-allien-@-klangkino-in-gebesee-germany', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1341', '6', 'Artist', '51', 'Gig', '604', '2014-04-07 06:00:50', null, null, '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Klangkino in Gebesee, Germany', '#/gig/604-ellen-allien-@-klangkino-in-gebesee-germany', null, null);
INSERT INTO `event` VALUES ('1340', '5', 'Artist', '51', 'Gig', '603', '2014-04-07 06:00:50', '15', 'Promoter', '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Opening Circoloco @ DC10 in Ibiza, Spain', '#/gig/603-ellen-allien-@-opening-circoloco-@-dc10-in-ibiza-spain', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1339', '6', 'Artist', '51', 'Gig', '603', '2014-04-07 06:00:50', null, null, '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Opening Circoloco @ DC10 in Ibiza, Spain', '#/gig/603-ellen-allien-@-opening-circoloco-@-dc10-in-ibiza-spain', null, null);
INSERT INTO `event` VALUES ('1338', '5', 'Artist', '51', 'Gig', '602', '2014-04-07 06:00:50', '15', 'Promoter', '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Douala in Ravensburg, Germany', '#/gig/602-ellen-allien-@-douala-in-ravensburg-germany', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1337', '6', 'Artist', '51', 'Gig', '602', '2014-04-07 06:00:50', null, null, '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Douala in Ravensburg, Germany', '#/gig/602-ellen-allien-@-douala-in-ravensburg-germany', null, null);
INSERT INTO `event` VALUES ('1336', '5', 'Artist', '51', 'Gig', '599', '2014-04-07 06:00:50', '15', 'Promoter', '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Troffler in Rotterdam, Netherlands', '#/gig/599-ellen-allien-@-troffler-in-rotterdam-netherlands', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1335', '6', 'Artist', '51', 'Gig', '599', '2014-04-07 06:00:50', null, null, '0', '0', 'Ellen Allien Official Fanpage', '#/artist/51-ellen-allien-official-fanpage', 'Ellen Allien @ Troffler in Rotterdam, Netherlands', '#/gig/599-ellen-allien-@-troffler-in-rotterdam-netherlands', null, null);
INSERT INTO `event` VALUES ('1334', '5', 'Artist', '47', 'Gig', '598', '2014-04-07 06:00:48', '15', 'Promoter', '0', '0', 'King Krule', '#/artist/47-king-krule', 'King Krule @ Heimathafen Neukoelln in Berlin, Germany', '#/gig/598-king-krule-@-heimathafen-neukoelln-in-berlin-germany', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1333', '6', 'Artist', '47', 'Gig', '598', '2014-04-07 06:00:48', null, null, '0', '0', 'King Krule', '#/artist/47-king-krule', 'King Krule @ Heimathafen Neukoelln in Berlin, Germany', '#/gig/598-king-krule-@-heimathafen-neukoelln-in-berlin-germany', null, null);
INSERT INTO `event` VALUES ('1332', '5', 'Artist', '47', 'Gig', '597', '2014-04-07 06:00:48', '15', 'Promoter', '0', '0', 'King Krule', '#/artist/47-king-krule', 'King Krule @ The Atomic Café in Munich, Germany', '#/gig/597-king-krule-@-the-atomic-caf-in-munich-germany', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1331', '6', 'Artist', '47', 'Gig', '597', '2014-04-07 06:00:48', null, null, '0', '0', 'King Krule', '#/artist/47-king-krule', 'King Krule @ The Atomic Café in Munich, Germany', '#/gig/597-king-krule-@-the-atomic-caf-in-munich-germany', null, null);
INSERT INTO `event` VALUES ('1330', '5', 'Artist', '22', 'Gig', '596', '2014-04-07 06:00:37', '21', 'Promoter', '0', '0', 'Disclosure', '#/artist/22-disclosure', 'Disclosure @ Eatons Hill Hotel in Brisbane, Australia', '#/gig/596-disclosure-@-eatons-hill-hotel-in-brisbane-australia', 'Infusion', '#/promoter/21-infusion');
INSERT INTO `event` VALUES ('1329', '5', 'Artist', '22', 'Gig', '596', '2014-04-07 06:00:37', '4', 'Promoter', '0', '0', 'Disclosure', '#/artist/22-disclosure', 'Disclosure @ Eatons Hill Hotel in Brisbane, Australia', '#/gig/596-disclosure-@-eatons-hill-hotel-in-brisbane-australia', 'Admin', '#/promoter/4-admin');
INSERT INTO `event` VALUES ('1328', '5', 'Artist', '22', 'Gig', '596', '2014-04-07 06:00:37', '10', 'Promoter', '0', '0', 'Disclosure', '#/artist/22-disclosure', 'Disclosure @ Eatons Hill Hotel in Brisbane, Australia', '#/gig/596-disclosure-@-eatons-hill-hotel-in-brisbane-australia', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1327', '5', 'Artist', '22', 'Gig', '596', '2014-04-07 06:00:37', '16', 'Promoter', '0', '0', 'Disclosure', '#/artist/22-disclosure', 'Disclosure @ Eatons Hill Hotel in Brisbane, Australia', '#/gig/596-disclosure-@-eatons-hill-hotel-in-brisbane-australia', 'Kirrill Mad', '#/promoter/16-kirrill-mad');
INSERT INTO `event` VALUES ('1326', '6', 'Artist', '22', 'Gig', '596', '2014-04-07 06:00:37', null, null, '0', '0', 'Disclosure', '#/artist/22-disclosure', 'Disclosure @ Eatons Hill Hotel in Brisbane, Australia', '#/gig/596-disclosure-@-eatons-hill-hotel-in-brisbane-australia', null, null);
INSERT INTO `event` VALUES ('1325', '5', 'Artist', '21', 'Gig', '595', '2014-04-07 06:00:35', '16', 'Promoter', '0', '0', 'Duke Dumont', '#/artist/21-duke-dumont', 'Duke Dumont @ London XOYO in London, United Kingdom', '#/gig/595-duke-dumont-@-london-xoyo-in-london-united-kingdom', 'Kirrill Mad', '#/promoter/16-kirrill-mad');
INSERT INTO `event` VALUES ('1324', '6', 'Artist', '21', 'Gig', '595', '2014-04-07 06:00:35', null, null, '0', '0', 'Duke Dumont', '#/artist/21-duke-dumont', 'Duke Dumont @ London XOYO in London, United Kingdom', '#/gig/595-duke-dumont-@-london-xoyo-in-london-united-kingdom', null, null);
INSERT INTO `event` VALUES ('1323', '5', 'Artist', '21', 'Gig', '593', '2014-04-07 06:00:35', '16', 'Promoter', '0', '0', 'Duke Dumont', '#/artist/21-duke-dumont', 'Duke Dumont @ The Arches in Glasgow, United Kingdom', '#/gig/593-duke-dumont-@-the-arches-in-glasgow-united-kingdom', 'Kirrill Mad', '#/promoter/16-kirrill-mad');
INSERT INTO `event` VALUES ('1322', '6', 'Artist', '21', 'Gig', '593', '2014-04-07 06:00:35', null, null, '0', '0', 'Duke Dumont', '#/artist/21-duke-dumont', 'Duke Dumont @ The Arches in Glasgow, United Kingdom', '#/gig/593-duke-dumont-@-the-arches-in-glasgow-united-kingdom', null, null);
INSERT INTO `event` VALUES ('1321', '5', 'Artist', '21', 'Gig', '592', '2014-04-07 06:00:35', '16', 'Promoter', '0', '0', 'Duke Dumont', '#/artist/21-duke-dumont', 'Duke Dumont @ Pacific Coliseum in Vancouver, Canada', '#/gig/592-duke-dumont-@-pacific-coliseum-in-vancouver-canada', 'Kirrill Mad', '#/promoter/16-kirrill-mad');
INSERT INTO `event` VALUES ('1320', '6', 'Artist', '21', 'Gig', '592', '2014-04-07 06:00:35', null, null, '0', '0', 'Duke Dumont', '#/artist/21-duke-dumont', 'Duke Dumont @ Pacific Coliseum in Vancouver, Canada', '#/gig/592-duke-dumont-@-pacific-coliseum-in-vancouver-canada', null, null);
INSERT INTO `event` VALUES ('1319', '5', 'Artist', '21', 'Gig', '591', '2014-04-07 06:00:35', '16', 'Promoter', '0', '0', 'Duke Dumont', '#/artist/21-duke-dumont', 'Duke Dumont @ SURFCOMBER HOTEL in Miami Beach, FL', '#/gig/591-duke-dumont-@-surfcomber-hotel-in-miami-beach-fl', 'Kirrill Mad', '#/promoter/16-kirrill-mad');
INSERT INTO `event` VALUES ('1318', '6', 'Artist', '21', 'Gig', '591', '2014-04-07 06:00:35', null, null, '0', '0', 'Duke Dumont', '#/artist/21-duke-dumont', 'Duke Dumont @ SURFCOMBER HOTEL in Miami Beach, FL', '#/gig/591-duke-dumont-@-surfcomber-hotel-in-miami-beach-fl', null, null);
INSERT INTO `event` VALUES ('1317', '5', 'Artist', '2', 'Gig', '590', '2014-04-07 06:00:23', '10', 'Promoter', '0', '0', 'Maceo Plex', '#/artist/2-maceo-plex', 'Maceo Plex @ Montreux Jazz Lab in Montreux, Switzerland', '#/gig/590-maceo-plex-@-montreux-jazz-lab-in-montreux-switzerland', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1316', '5', 'Artist', '2', 'Gig', '590', '2014-04-07 06:00:23', '19', 'Promoter', '0', '0', 'Maceo Plex', '#/artist/2-maceo-plex', 'Maceo Plex @ Montreux Jazz Lab in Montreux, Switzerland', '#/gig/590-maceo-plex-@-montreux-jazz-lab-in-montreux-switzerland', 'Mihas', '#/promoter/19-mihas');
INSERT INTO `event` VALUES ('1315', '6', 'Artist', '2', 'Gig', '590', '2014-04-07 06:00:23', null, null, '0', '0', 'Maceo Plex', '#/artist/2-maceo-plex', 'Maceo Plex @ Montreux Jazz Lab in Montreux, Switzerland', '#/gig/590-maceo-plex-@-montreux-jazz-lab-in-montreux-switzerland', null, null);
INSERT INTO `event` VALUES ('1314', '5', 'Artist', '62', 'Gig', '589', '2014-04-05 06:00:48', '10', 'Promoter', '0', '0', 'Nina Kraviz', '#/artist/62-nina-kraviz', 'Nina Kraviz @ Sound Nightclub in Los Angeles, CA', '#/gig/589-nina-kraviz-@-sound-nightclub-in-los-angeles-ca', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1313', '6', 'Artist', '62', 'Gig', '589', '2014-04-05 06:00:48', null, null, '0', '0', 'Nina Kraviz', '#/artist/62-nina-kraviz', 'Nina Kraviz @ Sound Nightclub in Los Angeles, CA', '#/gig/589-nina-kraviz-@-sound-nightclub-in-los-angeles-ca', null, null);
INSERT INTO `event` VALUES ('1312', '5', 'Artist', '17', 'Gig', '588', '2014-04-05 06:00:23', '17', 'Promoter', '0', '0', 'DJ Harvey', '#/artist/17-dj-harvey', 'DJ Harvey @ The London Wonderground in London, United Kingdom', '#/gig/588-dj-harvey-@-the-london-wonderground-in-london-united-kingdom', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1311', '6', 'Artist', '17', 'Gig', '588', '2014-04-05 06:00:23', null, null, '0', '0', 'DJ Harvey', '#/artist/17-dj-harvey', 'DJ Harvey @ The London Wonderground in London, United Kingdom', '#/gig/588-dj-harvey-@-the-london-wonderground-in-london-united-kingdom', null, null);
INSERT INTO `event` VALUES ('1310', '5', 'Artist', '13', 'Gig', '587', '2014-04-05 06:00:20', '10', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Electric Forest in Rothbury, MI', '#/gig/587-soul-clap-@-electric-forest-in-rothbury-mi', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1309', '5', 'Artist', '13', 'Gig', '587', '2014-04-05 06:00:20', '12', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Electric Forest in Rothbury, MI', '#/gig/587-soul-clap-@-electric-forest-in-rothbury-mi', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1308', '5', 'Artist', '13', 'Gig', '587', '2014-04-05 06:00:20', '17', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Electric Forest in Rothbury, MI', '#/gig/587-soul-clap-@-electric-forest-in-rothbury-mi', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1307', '6', 'Artist', '13', 'Gig', '587', '2014-04-05 06:00:20', null, null, '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Electric Forest in Rothbury, MI', '#/gig/587-soul-clap-@-electric-forest-in-rothbury-mi', null, null);
INSERT INTO `event` VALUES ('1306', '5', 'Artist', '13', 'Gig', '585', '2014-04-05 06:00:20', '10', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Piknik Electronik in Montreal, Canada', '#/gig/585-soul-clap-@-piknik-electronik-in-montreal-canada', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1305', '5', 'Artist', '13', 'Gig', '585', '2014-04-05 06:00:20', '12', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Piknik Electronik in Montreal, Canada', '#/gig/585-soul-clap-@-piknik-electronik-in-montreal-canada', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1304', '5', 'Artist', '13', 'Gig', '585', '2014-04-05 06:00:20', '17', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Piknik Electronik in Montreal, Canada', '#/gig/585-soul-clap-@-piknik-electronik-in-montreal-canada', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1303', '6', 'Artist', '13', 'Gig', '585', '2014-04-05 06:00:20', null, null, '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Piknik Electronik in Montreal, Canada', '#/gig/585-soul-clap-@-piknik-electronik-in-montreal-canada', null, null);
INSERT INTO `event` VALUES ('1302', '5', 'Artist', '13', 'Gig', '584', '2014-04-05 06:00:20', '10', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Bardot in Miami, FL', '#/gig/584-soul-clap-@-bardot-in-miami-fl', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1301', '5', 'Artist', '13', 'Gig', '584', '2014-04-05 06:00:20', '12', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Bardot in Miami, FL', '#/gig/584-soul-clap-@-bardot-in-miami-fl', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1300', '5', 'Artist', '13', 'Gig', '584', '2014-04-05 06:00:20', '17', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Bardot in Miami, FL', '#/gig/584-soul-clap-@-bardot-in-miami-fl', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1299', '6', 'Artist', '13', 'Gig', '584', '2014-04-05 06:00:20', null, null, '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Bardot in Miami, FL', '#/gig/584-soul-clap-@-bardot-in-miami-fl', null, null);
INSERT INTO `event` VALUES ('1298', '5', 'Artist', '13', 'Gig', '583', '2014-04-05 06:00:20', '10', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Studio 333 in London, United Kingdom', '#/gig/583-soul-clap-@-studio-333-in-london-united-kingdom', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1297', '5', 'Artist', '13', 'Gig', '583', '2014-04-05 06:00:20', '12', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Studio 333 in London, United Kingdom', '#/gig/583-soul-clap-@-studio-333-in-london-united-kingdom', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1296', '5', 'Artist', '13', 'Gig', '583', '2014-04-05 06:00:20', '17', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Studio 333 in London, United Kingdom', '#/gig/583-soul-clap-@-studio-333-in-london-united-kingdom', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1295', '6', 'Artist', '13', 'Gig', '583', '2014-04-05 06:00:20', null, null, '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Studio 333 in London, United Kingdom', '#/gig/583-soul-clap-@-studio-333-in-london-united-kingdom', null, null);
INSERT INTO `event` VALUES ('1294', '5', 'Artist', '55', 'Gig', '581', '2014-04-04 00:42:31', '4', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Mob in Milano, Italy', '#/gig/581-timo-maas-@-mob-in-milano-italy', 'Admin', '#/promoter/4-admin');
INSERT INTO `event` VALUES ('1293', '5', 'Artist', '55', 'Gig', '581', '2014-04-04 00:42:31', '12', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Mob in Milano, Italy', '#/gig/581-timo-maas-@-mob-in-milano-italy', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1292', '5', 'Artist', '55', 'Gig', '581', '2014-04-04 00:42:31', '15', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Mob in Milano, Italy', '#/gig/581-timo-maas-@-mob-in-milano-italy', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1291', '6', 'Artist', '55', 'Gig', '581', '2014-04-04 00:42:31', null, null, '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Mob in Milano, Italy', '#/gig/581-timo-maas-@-mob-in-milano-italy', null, null);
INSERT INTO `event` VALUES ('1290', '10', 'Promoter', '4', 'Artist', '55', '2014-04-04 00:40:25', null, null, '0', '0', 'Admin', '#/promoter/4-admin', 'Timo Maas', '#/artist/55-timo-maas', null, null);
INSERT INTO `event` VALUES ('1289', '5', 'Artist', '55', 'Gig', '580', '2014-04-04 00:29:45', '12', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Shine Nightclub in Ottawa, Canada', '#/gig/580-timo-maas-@-shine-nightclub-in-ottawa-canada', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1288', '5', 'Artist', '55', 'Gig', '580', '2014-04-04 00:29:45', '15', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Shine Nightclub in Ottawa, Canada', '#/gig/580-timo-maas-@-shine-nightclub-in-ottawa-canada', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1287', '6', 'Artist', '55', 'Gig', '580', '2014-04-04 00:29:45', null, null, '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Shine Nightclub in Ottawa, Canada', '#/gig/580-timo-maas-@-shine-nightclub-in-ottawa-canada', null, null);
INSERT INTO `event` VALUES ('1286', '5', 'Artist', '62', 'Gig', '579', '2014-04-04 00:13:42', '10', 'Promoter', '0', '0', 'Nina Kraviz', '#/artist/62-nina-kraviz', 'Nina Kraviz @ Coachella  in California, VA', '#/gig/579-nina-kraviz-@-coachella-in-california-va', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1285', '6', 'Artist', '62', 'Gig', '579', '2014-04-04 00:13:42', null, null, '0', '0', 'Nina Kraviz', '#/artist/62-nina-kraviz', 'Nina Kraviz @ Coachella  in California, VA', '#/gig/579-nina-kraviz-@-coachella-in-california-va', null, null);
INSERT INTO `event` VALUES ('1284', '5', 'Artist', '55', 'Gig', '578', '2014-04-04 00:13:38', '12', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Forsage Club in Kiev, Ukraine', '#/gig/578-timo-maas-@-forsage-club-in-kiev-ukraine', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1283', '5', 'Artist', '55', 'Gig', '578', '2014-04-04 00:13:38', '15', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Forsage Club in Kiev, Ukraine', '#/gig/578-timo-maas-@-forsage-club-in-kiev-ukraine', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1282', '6', 'Artist', '55', 'Gig', '578', '2014-04-04 00:13:38', null, null, '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Forsage Club in Kiev, Ukraine', '#/gig/578-timo-maas-@-forsage-club-in-kiev-ukraine', null, null);
INSERT INTO `event` VALUES ('1281', '5', 'Artist', '55', 'Gig', '577', '2014-04-04 00:13:38', '12', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ HABITAT in Montreal, Canada', '#/gig/577-timo-maas-@-habitat-in-montreal-canada', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1280', '5', 'Artist', '55', 'Gig', '577', '2014-04-04 00:13:38', '15', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ HABITAT in Montreal, Canada', '#/gig/577-timo-maas-@-habitat-in-montreal-canada', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1279', '6', 'Artist', '55', 'Gig', '577', '2014-04-04 00:13:38', null, null, '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ HABITAT in Montreal, Canada', '#/gig/577-timo-maas-@-habitat-in-montreal-canada', null, null);
INSERT INTO `event` VALUES ('1278', '5', 'Artist', '55', 'Gig', '576', '2014-04-04 00:13:38', '12', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Vinyl in Denver, CO', '#/gig/576-timo-maas-@-vinyl-in-denver-co', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1277', '5', 'Artist', '55', 'Gig', '576', '2014-04-04 00:13:38', '15', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Vinyl in Denver, CO', '#/gig/576-timo-maas-@-vinyl-in-denver-co', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1276', '6', 'Artist', '55', 'Gig', '576', '2014-04-04 00:13:38', null, null, '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Vinyl in Denver, CO', '#/gig/576-timo-maas-@-vinyl-in-denver-co', null, null);
INSERT INTO `event` VALUES ('1275', '5', 'Artist', '55', 'Gig', '575', '2014-04-04 00:13:38', '12', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Discolo in Barranquilla, Colombia', '#/gig/575-timo-maas-@-discolo-in-barranquilla-colombia', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1274', '5', 'Artist', '55', 'Gig', '575', '2014-04-04 00:13:38', '15', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Discolo in Barranquilla, Colombia', '#/gig/575-timo-maas-@-discolo-in-barranquilla-colombia', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1273', '6', 'Artist', '55', 'Gig', '575', '2014-04-04 00:13:38', null, null, '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Discolo in Barranquilla, Colombia', '#/gig/575-timo-maas-@-discolo-in-barranquilla-colombia', null, null);
INSERT INTO `event` VALUES ('1272', '5', 'Artist', '55', 'Gig', '574', '2014-04-04 00:13:38', '12', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Level 2 Lounge in Dysart, Canada', '#/gig/574-timo-maas-@-level-2-lounge-in-dysart-canada', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1271', '5', 'Artist', '55', 'Gig', '574', '2014-04-04 00:13:38', '15', 'Promoter', '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Level 2 Lounge in Dysart, Canada', '#/gig/574-timo-maas-@-level-2-lounge-in-dysart-canada', 'Max Starscev', '#/promoter/15-max-starscev');
INSERT INTO `event` VALUES ('1270', '6', 'Artist', '55', 'Gig', '574', '2014-04-04 00:13:38', null, null, '0', '0', 'Timo Maas', '#/artist/55-timo-maas', 'Timo Maas @ Level 2 Lounge in Dysart, Canada', '#/gig/574-timo-maas-@-level-2-lounge-in-dysart-canada', null, null);
INSERT INTO `event` VALUES ('1269', '5', 'Artist', '25', 'Gig', '573', '2014-04-04 00:13:23', '12', 'Promoter', '0', '0', 'Dusky', '#/artist/25-dusky', 'Dusky @ East Village Arts Club in Liverpool, United Kingdom', '#/gig/573-dusky-@-east-village-arts-club-in-liverpool-united-kingdom', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1268', '5', 'Artist', '25', 'Gig', '573', '2014-04-04 00:13:23', '16', 'Promoter', '0', '0', 'Dusky', '#/artist/25-dusky', 'Dusky @ East Village Arts Club in Liverpool, United Kingdom', '#/gig/573-dusky-@-east-village-arts-club-in-liverpool-united-kingdom', 'Kirrill Mad', '#/promoter/16-kirrill-mad');
INSERT INTO `event` VALUES ('1267', '5', 'Artist', '25', 'Gig', '573', '2014-04-04 00:13:23', '19', 'Promoter', '0', '0', 'Dusky', '#/artist/25-dusky', 'Dusky @ East Village Arts Club in Liverpool, United Kingdom', '#/gig/573-dusky-@-east-village-arts-club-in-liverpool-united-kingdom', 'Mihas', '#/promoter/19-mihas');
INSERT INTO `event` VALUES ('1266', '6', 'Artist', '25', 'Gig', '573', '2014-04-04 00:13:23', null, null, '0', '0', 'Dusky', '#/artist/25-dusky', 'Dusky @ East Village Arts Club in Liverpool, United Kingdom', '#/gig/573-dusky-@-east-village-arts-club-in-liverpool-united-kingdom', null, null);
INSERT INTO `event` VALUES ('1265', '5', 'Artist', '13', 'Gig', '572', '2014-04-04 00:13:13', '10', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Lonely C at OUTPUT in Brooklyn, NY', '#/gig/572-soul-clap-@-lonely-c-at-output-in-brooklyn-ny', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1264', '5', 'Artist', '13', 'Gig', '572', '2014-04-04 00:13:13', '12', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Lonely C at OUTPUT in Brooklyn, NY', '#/gig/572-soul-clap-@-lonely-c-at-output-in-brooklyn-ny', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1263', '5', 'Artist', '13', 'Gig', '572', '2014-04-04 00:13:13', '17', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Lonely C at OUTPUT in Brooklyn, NY', '#/gig/572-soul-clap-@-lonely-c-at-output-in-brooklyn-ny', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1262', '6', 'Artist', '13', 'Gig', '572', '2014-04-04 00:13:13', null, null, '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ Lonely C at OUTPUT in Brooklyn, NY', '#/gig/572-soul-clap-@-lonely-c-at-output-in-brooklyn-ny', null, null);
INSERT INTO `event` VALUES ('1261', '2', 'Promoter', '4', 'Gig', '568', '2014-04-02 15:45:04', '22', 'Artist', '0', '0', 'Admin', '#/promoter/4-admin', 'Disclosure', '#/gig/568-disclosure', 'Disclosure', '#/artist/22-disclosure');
INSERT INTO `event` VALUES ('1260', '10', 'Promoter', '4', 'Artist', '14', '2014-04-02 15:39:05', null, null, '0', '0', 'Admin', '#/promoter/4-admin', 'TONE of ARC', '#/artist/14-tone-of-arc', null, null);
INSERT INTO `event` VALUES ('1259', '11', 'Promoter', '4', 'Artist', '8', '2014-04-02 15:37:36', null, null, '0', '0', 'Admin', '#/promoter/4-admin', 'Robert Owens', '#/artist/8-robert-owens', null, null);
INSERT INTO `event` VALUES ('1258', '6', 'Artist', '59', 'Gig', '556', '2014-04-02 06:00:41', null, null, '0', '0', 'Noir', '#/artist/59-noir', 'Noir @ COMMA@Blender in Sofia, Bulgaria', '#/gig/556-noir-@-comma@blender-in-sofia-bulgaria', null, null);
INSERT INTO `event` VALUES ('1257', '5', 'Artist', '37', 'Gig', '555', '2014-04-02 06:00:34', '18', 'Promoter', '0', '0', 'Marc Romboy', '#/artist/37-marc-romboy', 'Marc Romboy @ MS Rheinenergie in Dusseldorf, Germany', '#/gig/555-marc-romboy-@-ms-rheinenergie-in-dusseldorf-germany', 'Rogga', '#/promoter/18-rogga');
INSERT INTO `event` VALUES ('1256', '6', 'Artist', '37', 'Gig', '555', '2014-04-02 06:00:34', null, null, '0', '0', 'Marc Romboy', '#/artist/37-marc-romboy', 'Marc Romboy @ MS Rheinenergie in Dusseldorf, Germany', '#/gig/555-marc-romboy-@-ms-rheinenergie-in-dusseldorf-germany', null, null);
INSERT INTO `event` VALUES ('1255', '5', 'Artist', '27', 'Gig', '554', '2014-04-02 06:00:29', '16', 'Promoter', '0', '0', 'Boys Noize', '#/artist/27-boys-noize', 'Boys Noize @ Mysteryland in Haarlemmermeer, Netherlands', '#/gig/554-boys-noize-@-mysteryland-in-haarlemmermeer-netherlands', 'Kirrill Mad', '#/promoter/16-kirrill-mad');
INSERT INTO `event` VALUES ('1254', '6', 'Artist', '27', 'Gig', '554', '2014-04-02 06:00:29', null, null, '0', '0', 'Boys Noize', '#/artist/27-boys-noize', 'Boys Noize @ Mysteryland in Haarlemmermeer, Netherlands', '#/gig/554-boys-noize-@-mysteryland-in-haarlemmermeer-netherlands', null, null);
INSERT INTO `event` VALUES ('1253', '5', 'Artist', '24', 'Gig', '553', '2014-04-02 06:00:26', '16', 'Promoter', '0', '0', 'The xx', '#/artist/24-the-xx', 'The xx @ The Lyric Oxford in Oxford, MS', '#/gig/553-the-xx-@-the-lyric-oxford-in-oxford-ms', 'Kirrill Mad', '#/promoter/16-kirrill-mad');
INSERT INTO `event` VALUES ('1252', '6', 'Artist', '24', 'Gig', '553', '2014-04-02 06:00:26', null, null, '0', '0', 'The xx', '#/artist/24-the-xx', 'The xx @ The Lyric Oxford in Oxford, MS', '#/gig/553-the-xx-@-the-lyric-oxford-in-oxford-ms', null, null);
INSERT INTO `event` VALUES ('1251', '5', 'Artist', '19', 'Gig', '552', '2014-04-02 06:00:19', '12', 'Promoter', '0', '0', 'Todd Terje', '#/artist/19-todd-terje', 'Todd Terje @ Le Fort de Saint Père in St Pere, France', '#/gig/552-todd-terje-@-le-fort-de-saint-p-re-in-st-pere-france', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1250', '5', 'Artist', '19', 'Gig', '552', '2014-04-02 06:00:19', '17', 'Promoter', '0', '0', 'Todd Terje', '#/artist/19-todd-terje', 'Todd Terje @ Le Fort de Saint Père in St Pere, France', '#/gig/552-todd-terje-@-le-fort-de-saint-p-re-in-st-pere-france', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1249', '5', 'Artist', '19', 'Gig', '552', '2014-04-02 06:00:19', '10', 'Promoter', '0', '0', 'Todd Terje', '#/artist/19-todd-terje', 'Todd Terje @ Le Fort de Saint Père in St Pere, France', '#/gig/552-todd-terje-@-le-fort-de-saint-p-re-in-st-pere-france', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1248', '6', 'Artist', '19', 'Gig', '552', '2014-04-02 06:00:19', null, null, '0', '0', 'Todd Terje', '#/artist/19-todd-terje', 'Todd Terje @ Le Fort de Saint Père in St Pere, France', '#/gig/552-todd-terje-@-le-fort-de-saint-p-re-in-st-pere-france', null, null);
INSERT INTO `event` VALUES ('1247', '5', 'Artist', '13', 'Gig', '551', '2014-04-02 06:00:15', '10', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ The Marcy Hotel in Brooklyn, NY', '#/gig/551-soul-clap-@-the-marcy-hotel-in-brooklyn-ny', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1246', '5', 'Artist', '13', 'Gig', '551', '2014-04-02 06:00:15', '12', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ The Marcy Hotel in Brooklyn, NY', '#/gig/551-soul-clap-@-the-marcy-hotel-in-brooklyn-ny', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1245', '5', 'Artist', '13', 'Gig', '551', '2014-04-02 06:00:15', '17', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ The Marcy Hotel in Brooklyn, NY', '#/gig/551-soul-clap-@-the-marcy-hotel-in-brooklyn-ny', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1244', '6', 'Artist', '13', 'Gig', '551', '2014-04-02 06:00:15', null, null, '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ The Marcy Hotel in Brooklyn, NY', '#/gig/551-soul-clap-@-the-marcy-hotel-in-brooklyn-ny', null, null);
INSERT INTO `event` VALUES ('1243', '2', 'Promoter', '10', 'Gig', '549', '2014-04-01 00:02:19', '13', 'Artist', '0', '0', 'MUZA', '#/promoter/10-muza', 'Soul Clap', '#/gig/549-soul-clap', 'Soul Clap', '#/artist/13-soul-clap');
INSERT INTO `event` VALUES ('1242', '10', 'Promoter', '10', 'Artist', '64', '2014-03-31 23:58:01', null, null, '0', '0', 'MUZA', '#/promoter/10-muza', 'Ivan Dorn', '#/artist/64-ivan-dorn', null, null);
INSERT INTO `event` VALUES ('1241', '11', 'Promoter', '10', 'Artist', '65', '2014-03-31 23:57:50', null, null, '0', '0', 'MUZA', '#/promoter/10-muza', 'Dusty Kid', '#/artist/65-dusty-kid', null, null);
INSERT INTO `event` VALUES ('1240', '10', 'Promoter', '10', 'Artist', '2', '2014-03-31 23:57:47', null, null, '0', '0', 'MUZA', '#/promoter/10-muza', 'Maceo Plex', '#/artist/2-maceo-plex', null, null);
INSERT INTO `event` VALUES ('1239', '10', 'Promoter', '10', 'Artist', '62', '2014-03-31 23:57:38', null, null, '0', '0', 'MUZA', '#/promoter/10-muza', 'Nina Kraviz', '#/artist/62-nina-kraviz', null, null);
INSERT INTO `event` VALUES ('1238', '8', 'Promoter', '10', 'Promoter', '13', '2014-03-31 23:57:01', null, null, '0', '0', 'MUZA', '#/promoter/10-muza', 'Loveis', '#/promoter/13-loveis', null, null);
INSERT INTO `event` VALUES ('1237', '8', 'Promoter', '10', 'Promoter', '17', '2014-03-31 23:56:53', null, null, '0', '0', 'MUZA', '#/promoter/10-muza', 'Asolya', '#/promoter/17-asolya', null, null);
INSERT INTO `event` VALUES ('1236', '10', 'Promoter', '21', 'Artist', '22', '2014-03-31 21:54:28', null, null, '0', '0', 'Infusion', '#/promoter/21-infusion', 'Disclosure', '#/artist/22-disclosure', null, null);
INSERT INTO `event` VALUES ('1235', '5', 'Artist', '31', 'Gig', '548', '2014-03-31 16:31:48', '18', 'Promoter', '0', '0', 'Guy J', '#/artist/31-guy-j', 'Guy J @ Verboten in Brooklyn, NY', '#/gig/548-guy-j-@-verboten-in-brooklyn-ny', 'Rogga', '#/promoter/18-rogga');
INSERT INTO `event` VALUES ('1234', '6', 'Artist', '31', 'Gig', '548', '2014-03-31 16:31:48', null, null, '0', '0', 'Guy J', '#/artist/31-guy-j', 'Guy J @ Verboten in Brooklyn, NY', '#/gig/548-guy-j-@-verboten-in-brooklyn-ny', null, null);
INSERT INTO `event` VALUES ('1233', '5', 'Artist', '23', 'Gig', '547', '2014-03-31 16:31:33', '16', 'Promoter', '0', '0', 'Klaxons', '#/artist/23-klaxons', 'Klaxons @ Jersey Live in Jersey, United Kingdom', '#/gig/547-klaxons-@-jersey-live-in-jersey-united-kingdom', 'Kirrill Mad', '#/promoter/16-kirrill-mad');
INSERT INTO `event` VALUES ('1232', '6', 'Artist', '23', 'Gig', '547', '2014-03-31 16:31:33', null, null, '0', '0', 'Klaxons', '#/artist/23-klaxons', 'Klaxons @ Jersey Live in Jersey, United Kingdom', '#/gig/547-klaxons-@-jersey-live-in-jersey-united-kingdom', null, null);
INSERT INTO `event` VALUES ('1231', '5', 'Artist', '17', 'Gig', '546', '2014-03-31 16:31:10', '17', 'Promoter', '0', '0', 'DJ Harvey', '#/artist/17-dj-harvey', 'DJ Harvey @ Bleu in Detroit, MI', '#/gig/546-dj-harvey-@-bleu-in-detroit-mi', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1230', '6', 'Artist', '17', 'Gig', '546', '2014-03-31 16:31:10', null, null, '0', '0', 'DJ Harvey', '#/artist/17-dj-harvey', 'DJ Harvey @ Bleu in Detroit, MI', '#/gig/546-dj-harvey-@-bleu-in-detroit-mi', null, null);
INSERT INTO `event` VALUES ('1229', '5', 'Artist', '13', 'Gig', '543', '2014-03-31 16:30:57', '10', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ BETHEL WOODS in Bethel, NY', '#/gig/543-justin-martin-@-bethel-woods-in-bethel-ny', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1228', '5', 'Artist', '13', 'Gig', '543', '2014-03-31 16:30:57', '12', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ BETHEL WOODS in Bethel, NY', '#/gig/543-justin-martin-@-bethel-woods-in-bethel-ny', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1227', '5', 'Artist', '13', 'Gig', '543', '2014-03-31 16:30:57', '17', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ BETHEL WOODS in Bethel, NY', '#/gig/543-justin-martin-@-bethel-woods-in-bethel-ny', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1226', '6', 'Artist', '13', 'Gig', '543', '2014-03-31 16:30:57', null, null, '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ BETHEL WOODS in Bethel, NY', '#/gig/543-justin-martin-@-bethel-woods-in-bethel-ny', null, null);
INSERT INTO `event` VALUES ('1225', '5', 'Artist', '13', 'Gig', '545', '2014-03-31 16:30:57', '10', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ OUTPUT in Brooklyn, NY', '#/gig/545-soul-clap-@-output-in-brooklyn-ny', 'MUZA', '#/promoter/10-muza');
INSERT INTO `event` VALUES ('1224', '5', 'Artist', '13', 'Gig', '545', '2014-03-31 16:30:57', '12', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ OUTPUT in Brooklyn, NY', '#/gig/545-soul-clap-@-output-in-brooklyn-ny', 'Guru', '#/promoter/12-guru');
INSERT INTO `event` VALUES ('1223', '5', 'Artist', '13', 'Gig', '545', '2014-03-31 16:30:57', '17', 'Promoter', '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ OUTPUT in Brooklyn, NY', '#/gig/545-soul-clap-@-output-in-brooklyn-ny', 'Asolya', '#/promoter/17-asolya');
INSERT INTO `event` VALUES ('1222', '6', 'Artist', '13', 'Gig', '545', '2014-03-31 16:30:57', null, null, '0', '0', 'Soul Clap', '#/artist/13-soul-clap', 'Soul Clap @ OUTPUT in Brooklyn, NY', '#/gig/545-soul-clap-@-output-in-brooklyn-ny', null, null);
INSERT INTO `event` VALUES ('1221', '5', 'Artist', '11', 'Gig', '544', '2014-03-31 16:30:49', '4', 'Promoter', '0', '0', 'Hot Since 82', '#/artist/11-hot-since-82', 'Hot Since 82 @ SPACE in Miami, FL', '#/gig/544-hot-since-82-@-space-in-miami-fl', 'Admin', '#/promoter/4-admin');
INSERT INTO `event` VALUES ('1220', '5', 'Artist', '11', 'Gig', '544', '2014-03-31 16:30:49', '19', 'Promoter', '0', '0', 'Hot Since 82', '#/artist/11-hot-since-82', 'Hot Since 82 @ SPACE in Miami, FL', '#/gig/544-hot-since-82-@-space-in-miami-fl', 'Mihas', '#/promoter/19-mihas');
INSERT INTO `event` VALUES ('1219', '6', 'Artist', '11', 'Gig', '544', '2014-03-31 16:30:49', null, null, '0', '0', 'Hot Since 82', '#/artist/11-hot-since-82', 'Hot Since 82 @ SPACE in Miami, FL', '#/gig/544-hot-since-82-@-space-in-miami-fl', null, null);
INSERT INTO `event` VALUES ('1218', '5', 'Artist', '10', 'Gig', '543', '2014-03-31 16:30:48', '19', 'Promoter', '0', '0', 'Justin Martin', '#/artist/10-justin-martin', 'Justin Martin @ BETHEL WOODS in Bethel, NY', '#/gig/543-justin-martin-@-bethel-woods-in-bethel-ny', 'Mihas', '#/promoter/19-mihas');
INSERT INTO `event` VALUES ('1217', '5', 'Artist', '10', 'Gig', '543', '2014-03-31 16:30:48', '4', 'Promoter', '0', '0', 'Justin Martin', '#/artist/10-justin-martin', 'Justin Martin @ BETHEL WOODS in Bethel, NY', '#/gig/543-justin-martin-@-bethel-woods-in-bethel-ny', 'Admin', '#/promoter/4-admin');
INSERT INTO `event` VALUES ('1216', '6', 'Artist', '10', 'Gig', '543', '2014-03-31 16:30:48', null, null, '0', '0', 'Justin Martin', '#/artist/10-justin-martin', 'Justin Martin @ BETHEL WOODS in Bethel, NY', '#/gig/543-justin-martin-@-bethel-woods-in-bethel-ny', null, null);
INSERT INTO `event` VALUES ('1215', '5', 'Artist', '2', 'Gig', '542', '2014-03-31 16:30:44', '19', 'Promoter', '0', '0', 'Maceo Plex', '#/artist/2-maceo-plex', 'Maceo Plex @ Lacuna Artist Lofts in Chicago, IL', '#/gig/542-maceo-plex-@-lacuna-artist-lofts-in-chicago-il', 'Mihas', '#/promoter/19-mihas');
INSERT INTO `event` VALUES ('1214', '6', 'Artist', '2', 'Gig', '542', '2014-03-31 16:30:44', null, null, '0', '0', 'Maceo Plex', '#/artist/2-maceo-plex', 'Maceo Plex @ Lacuna Artist Lofts in Chicago, IL', '#/gig/542-maceo-plex-@-lacuna-artist-lofts-in-chicago-il', null, null);

-- ----------------------------
-- Table structure for file
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of file
-- ----------------------------
INSERT INTO `file` VALUES ('1', null, '2014-02-07 02:05:59');
INSERT INTO `file` VALUES ('2', null, '2014-02-07 02:06:37');
INSERT INTO `file` VALUES ('3', 'images/temp/785f7ac66c.jpg', '2014-02-07 02:08:38');
INSERT INTO `file` VALUES ('4', 'images/promoter/2967965962.jpg', '2014-02-07 02:14:15');
INSERT INTO `file` VALUES ('5', 'images/promoter/24c471a8c0.jpg', '2014-03-18 18:09:07');
INSERT INTO `file` VALUES ('6', 'images/promoter/5721f8e7fb.jpg', '2014-03-18 18:13:42');
INSERT INTO `file` VALUES ('7', 'images/temp/d1daf98bb3.jpg', '2014-03-25 23:11:23');
INSERT INTO `file` VALUES ('8', 'images/temp/0dc7f131fd.jpg', '2014-03-31 21:32:48');

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
  `ds_type` tinyint(2) DEFAULT '0',
  `alias` varchar(64) DEFAULT NULL,
  `description` text,
  `currency` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_gig_venue_id` (`venue_id`) USING BTREE,
  KEY `fk_gig_user_id` (`user_id`) USING BTREE,
  CONSTRAINT `gig_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=607 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gig
-- ----------------------------
INSERT INTO `gig` VALUES ('3', null, '13201', 'Maceo Plex @ Public Works in San Francisco, CA', '2014-04-19 21:00:00', '2', '2014-04-08 06:00:03', '7617805', null, '1', '1', '1', '1', '3', '3-maceo-plex-@-public-works-in-san-francisco-ca', '', '1');
INSERT INTO `gig` VALUES ('4', null, '13202', 'Maceo Plex @ Spaarnwoude in Spaarndam, Netherlands', '2014-06-29 12:00:00', '2', '2014-04-08 06:00:03', '7622014', null, '1', '1', '1', '1', '3', '4-maceo-plex-@-spaarnwoude-in-spaarndam-netherlands', '', '1');
INSERT INTO `gig` VALUES ('25', null, '12987', 'Disclosure @ Damyns Hall Aerodrome in Upminster, United Kingdom', '2014-05-24 09:00:00', '2', '2014-04-07 06:00:37', '7445386', null, '1', '1', '1', '1', '3', '25-hot-since-82-@-damyns-hall-aerodrome-in-upminster-united-king', '', '1');
INSERT INTO `gig` VALUES ('39', null, '12940', 'Portable aka Bodycode @ Bix Jazz Club in Stuttgart, Germany', '2014-04-19 23:00:00', '2', '2014-04-07 06:00:30', '7646428', null, '1', '1', '1', '1', '3', '39-portable-aka-bodycode-@-bix-jazz-club-in-stuttgart-germany', '', '1');
INSERT INTO `gig` VALUES ('40', null, '12943', 'Portable aka Bodycode @ Mystic Gardens Festival @ Her Sloterpark in Amsterdam, Netherlands', '2014-06-21 23:00:00', '2', '2014-04-07 06:00:30', '7590085', null, '1', '1', '1', '1', '3', '40-portable-aka-bodycode-@-mystic-gardens-festival-@-her-sloterp', '', '1');
INSERT INTO `gig` VALUES ('42', null, '12945', 'DJ Harvey @ FESTIVAL SONAR in Barcelone, Spain', '2014-06-14 23:59:00', '2', '2014-04-07 06:00:31', '7606696', null, '1', '1', '1', '1', '3', '42-dj-harvey-@-festival-sonar-in-barcelone-spain', '', '1');
INSERT INTO `gig` VALUES ('44', null, '12948', 'Todd Terje @ The Button Factory in Dublin, Ireland', '2014-05-23 23:00:00', '2', '2014-04-07 06:00:32', '7635854', null, '1', '1', '1', '1', '3', '44-todd-terje-@-the-button-factory-in-dublin-ireland', '', '1');
INSERT INTO `gig` VALUES ('45', null, '13013', 'Dusky @ Victoria Park in London, United Kingdom', '2014-06-07 19:00:00', '2', '2014-04-07 06:00:40', '7380810', null, '1', '1', '1', '1', '3', '45-todd-terje-@-victoria-park-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('53', null, '13049', 'Tiga @ Damyns Hall Aerodrome in Upminster, United Kingdom', '2014-05-25 19:00:00', '2', '2014-04-07 06:00:42', '7350144', null, '1', '1', '1', '1', '3', '53-duke-dumont-@-damyns-hall-aerodrome-in-upminster-united-kingd', '', '1');
INSERT INTO `gig` VALUES ('72', null, '12972', 'Disclosure @ Empire Polo Field in Indio, CA', '2014-04-13 09:55:00', '2', '2014-04-07 06:00:37', '7130331', null, '1', '1', '1', '1', '3', '72-disclosure-@-empire-polo-field-in-indio-ca', '', '1');
INSERT INTO `gig` VALUES ('73', null, '12974', 'Disclosure @ Empire Polo Field in Indio, CA', '2014-04-20 09:55:00', '2', '2014-04-07 06:00:37', '7130326', null, '1', '1', '1', '1', '3', '73-disclosure-@-empire-polo-field-in-indio-ca', '', '1');
INSERT INTO `gig` VALUES ('74', null, '12976', 'Disclosure @ Oakbank Racecourse in Oakbank, Australia', '2014-04-25 19:00:00', '2', '2014-04-07 06:00:37', '7639186', null, '1', '1', '1', '1', '3', '74-disclosure-@-oakbank-racecourse-in-oakbank-australia', '', '1');
INSERT INTO `gig` VALUES ('75', null, '12977', 'Disclosure @ Maitland Showground in Maitland, Australia', '2014-04-26 19:00:00', '2', '2014-04-07 06:00:37', '7639411', null, '1', '1', '1', '1', '3', '75-disclosure-@-maitland-showground-in-maitland-australia', '', '1');
INSERT INTO `gig` VALUES ('76', null, '12978', 'Disclosure @ The Meadows, University of Canberra in Canberra, Australia', '2014-04-27 19:00:00', '2', '2014-04-07 06:00:37', '7639435', null, '1', '1', '1', '1', '3', '76-disclosure-@-the-meadows-university-of-canberra-in-canberra-a', '', '1');
INSERT INTO `gig` VALUES ('77', null, '12982', 'Disclosure @ Prince of Wales Showground in Bendigo, Australia', '2014-05-03 19:00:00', '2', '2014-04-07 06:00:37', '7639447', null, '1', '1', '1', '1', '3', '77-disclosure-@-prince-of-wales-showground-in-bendigo-australia', '', '1');
INSERT INTO `gig` VALUES ('78', null, '12983', 'Disclosure @ Murray Sports Complex in Townsville, Australia', '2014-05-04 11:00:00', '2', '2014-04-07 06:00:37', '7648892', null, '1', '1', '1', '1', '3', '78-disclosure-@-murray-sports-complex-in-townsville-australia', '', '1');
INSERT INTO `gig` VALUES ('79', null, '12985', 'Disclosure @ Hay Park in Bunbury, Australia', '2014-05-10 19:00:00', '2', '2014-04-07 06:00:37', '7639469', null, '1', '1', '1', '1', '3', '79-disclosure-@-hay-park-in-bunbury-australia', '', '1');
INSERT INTO `gig` VALUES ('80', null, '12989', 'Disclosure @ Union Transfer in Philadelphia, PA', '2014-06-09 20:30:00', '2', '2014-04-07 06:00:37', '7266303', null, '1', '1', '1', '1', '3', '80-disclosure-@-union-transfer-in-philadelphia-pa', '', '1');
INSERT INTO `gig` VALUES ('81', null, '12993', 'Disclosure @ La Citadelle in Arras, France', '2014-07-03 17:30:00', '2', '2014-04-07 06:00:37', '7467792', null, '1', '1', '1', '1', '3', '81-disclosure-@-la-citadelle-in-arras-france', '', '1');
INSERT INTO `gig` VALUES ('82', null, '12994', 'Disclosure @ La Citadelle in Arras, France', '2014-07-04 15:30:00', '2', '2014-04-07 06:00:37', '7467793', null, '1', '1', '1', '1', '3', '82-disclosure-@-la-citadelle-in-arras-france', '', '1');
INSERT INTO `gig` VALUES ('83', null, '12995', 'Disclosure @ La Citadelle in Arras, France', '2014-07-05 14:00:00', '2', '2014-04-07 06:00:37', '7467795', null, '1', '1', '1', '1', '3', '83-disclosure-@-la-citadelle-in-arras-france', '', '1');
INSERT INTO `gig` VALUES ('84', null, '12996', 'Disclosure @ La Citadelle in Arras, France', '2014-07-06 13:00:00', '2', '2014-04-07 06:00:37', '7467796', null, '1', '1', '1', '1', '3', '84-disclosure-@-la-citadelle-in-arras-france', '', '1');
INSERT INTO `gig` VALUES ('85', null, '12998', 'Disclosure @ ARENES PAUL LAURENT in Beaucaire, France', '2014-08-16 23:59:00', '2', '2014-04-07 06:00:37', '7599474', null, '1', '1', '1', '1', '3', '85-disclosure-@-ar`enes-de-beaucaire-in-beaucaire-france', '', '1');
INSERT INTO `gig` VALUES ('111', null, '13019', 'Boys Noize @ Panoramas Festival in Morlaix, France', '2014-04-18 19:00:00', '2', '2014-04-07 06:00:41', '7459326', null, '1', '1', '1', '1', '3', '111-boys-noize-@-panoramas-festival-in-morlaix-france', '', '1');
INSERT INTO `gig` VALUES ('112', null, '13022', 'Boys Noize @ Counterpoint Festival in Atlanta, GA', '2014-04-25 22:00:00', '2', '2014-04-07 06:00:41', '7567165', null, '1', '1', '1', '1', '3', '112-boys-noize-@-counterpoint-festival-in-atlanta-ga', '', '1');
INSERT INTO `gig` VALUES ('116', null, '13042', 'Vitalic @ Techno-Flash in Aranda De Duero, Spain', '2014-04-18 19:00:00', '2', '2014-04-07 06:00:42', '7640605', null, '1', '1', '1', '1', '3', '116-vitalic-@-techno-flash-in-aranda-de-duero-spain', '', '1');
INSERT INTO `gig` VALUES ('117', null, '13043', 'Vitalic @ Le Bikini in Ramonville-Saint-Agne, France', '2014-04-25 23:00:00', '2', '2014-04-07 06:00:42', '7479760', null, '1', '1', '1', '1', '3', '117-vitalic-@-le-bikini-in-ramonville-saint-agne-france', '', '1');
INSERT INTO `gig` VALUES ('121', null, '13050', 'Tiga @ Stradbally Hall in Stradbally, Ireland', '2014-08-31 09:00:00', '2', '2014-04-07 06:00:43', '7579355', null, '1', '1', '1', '1', '3', '121-tiga-@-stradbally-hall-in-stradbally-ireland', '', '1');
INSERT INTO `gig` VALUES ('138', null, '13057', 'Trentemøller @ Roskilde Festival in Roskilde, Denmark', '2014-07-04 19:00:00', '2', '2014-04-07 06:00:45', '7420063', null, '1', '1', '1', '1', '3', '138-trentemoller-@-roskilde-festival-in-roskilde-denmark', '', '1');
INSERT INTO `gig` VALUES ('144', null, '13067', 'Bonaparte @ Stadthalle Heidelberg in Heidelberg, Germany', '2014-04-29 20:00:00', '2', '2014-04-07 06:00:49', '7618498', null, '1', '1', '1', '1', '3', '144-bonaparte-@-stadthalle-heidelberg-in-heidelberg-germany', '', '1');
INSERT INTO `gig` VALUES ('162', null, '13068', 'Ellen Allien @ BPC Showcase @ Electric Brixton with Camea, Aérea Negrot, BabyG and Thomas Muller  in London, United Kingdom', '2014-04-11 19:00:00', '2', '2014-04-07 06:00:50', '7605625', null, '1', '1', '1', '1', '3', '162-ellen-allien-@-bpc-showcase-@-electric-brixton-with-camea-a-', '', '1');
INSERT INTO `gig` VALUES ('163', null, '13070', 'Ellen Allien @ Sub Club in Glasgow, United Kingdom', '2014-04-17 19:00:00', '2', '2014-04-07 06:00:50', '7605657', null, '1', '1', '1', '1', '3', '163-ellen-allien-@-sub-club-in-glasgow-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('164', null, '13071', 'Ellen Allien @ Gilda in Vicenza, Italy', '2014-04-19 19:00:00', '2', '2014-04-07 06:00:50', '7605684', null, '1', '1', '1', '1', '3', '164-ellen-allien-@-gilda-in-vicenza-italy', '', '1');
INSERT INTO `gig` VALUES ('165', null, '13072', 'Ellen Allien @ Electron Festival 11 @ Le Palladium in Geneva, Switzerland', '2014-04-20 19:00:00', '2', '2014-04-07 06:00:50', '7605878', null, '1', '1', '1', '1', '3', '165-ellen-allien-@-electron-festival-11-@-le-palladium-in-geneva', '', '1');
INSERT INTO `gig` VALUES ('166', null, '13074', 'Ellen Allien @ Vanilla Ninja in Moscow, Russian Federation', '2014-04-25 19:00:00', '2', '2014-04-07 06:00:50', '7605730', null, '1', '1', '1', '1', '3', '166-ellen-allien-@-vanilla-ninja-in-moscow-russian-federation', '', '1');
INSERT INTO `gig` VALUES ('167', null, '13075', 'Ellen Allien @ Bedrock Warehouse Party @ The Garage in Liverpool, United Kingdom', '2014-04-26 19:00:00', '2', '2014-04-07 06:00:50', '7647834', null, '1', '1', '1', '1', '3', '167-ellen-allien-@-bedrock-warehouse-party-@-the-garage-in-liver', '', '1');
INSERT INTO `gig` VALUES ('168', null, '13076', 'Ellen Allien @ Vox in Modena Mo, Italy', '2014-04-30 19:00:00', '2', '2014-04-07 06:00:50', '7605752', null, '1', '1', '1', '1', '3', '168-ellen-allien-@-vox-in-modena-mo-italy', '', '1');
INSERT INTO `gig` VALUES ('169', null, '13077', 'Ellen Allien @ Gewölbe in Cologne, Germany', '2014-05-02 19:00:00', '2', '2014-04-07 06:00:50', '7616330', null, '1', '1', '1', '1', '3', '169-ellen-allien-@-gew-olbe-in-cologne-germany', '', '1');
INSERT INTO `gig` VALUES ('170', null, '13078', 'Ellen Allien @ BPC Showcase @ Panoramabar in Berlin, Germany', '2014-05-03 19:00:00', '2', '2014-04-07 06:00:50', '7616337', null, '1', '1', '1', '1', '3', '170-ellen-allien-@-bpc-showcase-@-panoramabar-in-berlin-germany', '', '1');
INSERT INTO `gig` VALUES ('171', null, '13083', 'Ellen Allien @ WeAre Festival @ Damyns Hall Aerodrome  in Upminster, United Kingdom', '2014-05-25 19:00:00', '2', '2014-04-07 06:00:50', '7605868', null, '1', '1', '1', '1', '3', '171-ellen-allien-@-weare-festival-@-damyns-hall-aerodrome-in-upm', '', '1');
INSERT INTO `gig` VALUES ('172', null, '13086', 'Ellen Allien @ Uebel & Gefährlich in Hamburg, Germany', '2014-05-30 23:59:00', '2', '2014-04-07 06:00:50', '7395769', null, '1', '1', '1', '1', '3', '172-ellen-allien-@-uebel-&-gef-ahrlich-in-hamburg-germany', '', '1');
INSERT INTO `gig` VALUES ('176', null, '13090', 'Kate Simko @ The National Gallery in London, United Kingdom', '2014-06-06 19:00:00', '2', '2014-04-07 06:00:51', '7374811', null, '1', '1', '1', '1', '3', '176-kate-simko-@-the-national-gallery-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('183', null, '13093', 'Timo Maas @ WATERGATE BERLIN in Berlin, Germany', '2014-04-16 22:00:00', '2', '2014-04-07 06:00:53', '7609933', null, '1', '1', '1', '1', '3', '183-timo-maas-@-watergate-berlin-in-berlin-germany', '', '1');
INSERT INTO `gig` VALUES ('184', null, '13102', 'Timo Maas @ WATERGATE BERLIN in Berlin, Germany', '2014-05-16 22:00:00', '2', '2014-04-07 06:00:53', '7416914', null, '1', '1', '1', '1', '3', '184-timo-maas-@-watergate-berlin-in-berlin-germany', '', '1');
INSERT INTO `gig` VALUES ('185', null, '13142', 'Nina Kraviz @ We Are FSTVL in Upminster, United Kingdom', '2014-05-25 23:00:00', '2', '2014-04-07 06:00:58', '7416854', null, '1', '1', '1', '1', '3', '185-timo-maas-@-we-are-fstvl-in-upminster-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('186', null, '13105', 'Timo Maas @ Pollerwiesen Boat in Cologne, Italy', '2014-05-29 22:00:00', '2', '2014-04-07 06:00:53', '7648652', null, '1', '1', '1', '1', '3', '186-timo-maas-@-pollerwiesen-boat-in-cologne-italy', '', '1');
INSERT INTO `gig` VALUES ('187', null, '13111', 'Timo Maas @ Beat-Herder Festival in Lancaster, United Kingdom', '2014-07-19 22:00:00', '2', '2014-04-07 06:00:53', '7648235', null, '1', '1', '1', '1', '3', '187-timo-maas-@-beat-herder-festival-in-lancaster-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('188', null, '13112', 'Timo Maas @ Ushuaïa Ibiza Beach Hotel in Ibiza, Spain', '2014-07-26 22:00:00', '2', '2014-04-07 06:00:53', '7648997', null, '1', '1', '1', '1', '3', '188-timo-maas-@-ushuaia-beah-hotel-in-ibiza-spain', '', '1');
INSERT INTO `gig` VALUES ('189', null, '13113', 'Timo Maas @ Ushuaïa Ibiza Beach Hotel in Ibiza, Spain', '2014-08-09 22:00:00', '2', '2014-04-07 06:00:53', '7648490', null, '1', '1', '1', '1', '3', '189-timo-maas-@-ushuaia-beah-hotel-in-ibiza-spain', '', '1');
INSERT INTO `gig` VALUES ('190', null, '13115', 'Timo Maas @ Kesselhaus in Augsburg, Germany', '2014-08-30 10:00:00', '2', '2014-04-07 06:00:53', '7608597', null, '1', '1', '1', '1', '3', '190-timo-maas-@-kesselhaus-in-augsburg-germany', '', '1');
INSERT INTO `gig` VALUES ('191', null, '13116', 'Timo Maas @ Ushuaïa Ibiza Beach Hotel in Ibiza, Spain', '2014-09-13 22:00:00', '2', '2014-04-07 06:00:53', '7648718', null, '1', '1', '1', '1', '3', '191-timo-maas-@-ushuaia-beah-hotel-in-ibiza-spain', '', '1');
INSERT INTO `gig` VALUES ('192', null, '13146', 'Kollektiv Turmstrasse @ Sloterpark, Amsterdam (NL)', '2014-08-10 01:55:00', '2', '2014-04-07 07:00:11', '471766922935233', null, '1', '1', '1', '1', '1', '192-kollektiv-turmstrasse-@-sloterpark-amsterdam-(nl)', null, '1');
INSERT INTO `gig` VALUES ('193', null, '13148', 'Kollektiv Turmstrasse @ Maag Hall, Zurich (CH)', '2014-08-03 01:55:00', '2', '2014-04-07 07:00:13', '280675515415979', null, '1', '1', '1', '1', '1', '193-kollektiv-turmstrasse-@-maag-hall-zurich-(ch)', null, '1');
INSERT INTO `gig` VALUES ('195', null, '13149', 'Kollektiv Turmstrasse @ Hinterhof, Basel (CH)', '2014-06-07 01:55:00', '2', '2014-04-07 07:00:16', '1446079665621796', null, '1', '1', '1', '1', '1', '195-kollektiv-turmstrasse-@-hinterhof-basel-(ch)', null, '1');
INSERT INTO `gig` VALUES ('196', null, '13150', 'Musik Gewinnt Freunde @ Kollektiv Turmstrasse @ Odonien, Cologne (DE)', '2014-05-30 01:55:00', '2', '2014-04-07 07:00:18', '291050864382146', null, '1', '1', '1', '1', '1', '196-musik-gewinnt-freunde-@-kollektiv-turmstrasse-@-odonien-colo', null, '1');
INSERT INTO `gig` VALUES ('197', null, '13151', 'Musik Gewinnt Freunde @ Kollektiv Turmstrasse @ Odonien, Cologne (DE)', '2014-05-29 01:55:00', '2', '2014-04-07 07:00:19', '1431836840385093', null, '1', '1', '1', '1', '1', '197-musik-gewinnt-freunde-@-kollektiv-turmstrasse-@-odonien-colo', null, '1');
INSERT INTO `gig` VALUES ('198', null, '13153', 'Kollektiv Turmstrasse @ Kugl Club, St. Gallen (CH)', '2014-05-18 01:55:00', '2', '2014-04-07 07:00:22', '483676615076879', null, '1', '1', '1', '1', '1', '198-kollektiv-turmstrasse-@-kugl-club-st-gallen-(ch)', null, '1');
INSERT INTO `gig` VALUES ('199', null, '13154', 'Kollektiv Turmstrasse @  Kulturfabrik Kofmehl, Solothurn (CH)', '2014-05-17 01:55:00', '2', '2014-04-07 07:00:23', '588225441259433', null, '1', '1', '1', '1', '1', '199-kollektiv-turmstrasse-@-kulturfabrik-kofmehl-solothurn-(ch)', null, '1');
INSERT INTO `gig` VALUES ('200', null, '13155', 'Kollektiv Turmstrasse @ Chalet de la Porte Jaune, Paris (FR)', '2014-05-08 01:55:00', '2', '2014-04-07 07:00:24', '622650047783511', null, '1', '1', '1', '1', '1', '200-kollektiv-turmstrasse-@-chalet-de-la-porte-jaune-paris-(fr)', null, '1');
INSERT INTO `gig` VALUES ('201', null, '13156', 'Kollektiv Turmstrase @ Salzhaus, Winterthur (CH)', '2014-05-03 01:55:00', '2', '2014-04-07 07:00:25', '267240636774599', null, '1', '1', '1', '1', '1', '201-kollektiv-turmstrase-@-salzhaus-winterthur-(ch)', null, '1');
INSERT INTO `gig` VALUES ('202', null, '13157', 'Musik Gewinnt Freunde @ Kollektiv Turmstrasse @  Grelle Forelle, Vienna (AT)', '2014-05-01 01:55:00', '2', '2014-04-07 07:00:26', '722921984398190', null, '1', '1', '1', '1', '1', '202-musik-gewinnt-freunde-@-kollektiv-turmstrasse-@-grelle-forel', null, '1');
INSERT INTO `gig` VALUES ('203', null, '13159', 'Kollektiv Turmstrasse @ D! Club, Lausanne (FR)', '2014-04-26 01:55:00', '2', '2014-04-07 07:00:29', '1417519751822987', null, '1', '1', '1', '1', '1', '203-kollektiv-turmstrasse-@-d!-club-lausanne-(fr)', null, '1');
INSERT INTO `gig` VALUES ('204', null, '13160', 'Kollektiv Turmstrasse @ Rote Sonne, Munich (DE)', '2014-04-21 01:55:00', '2', '2014-04-07 07:00:30', '130742773763108', null, '1', '1', '1', '1', '1', '204-kollektiv-turmstrasse-@-rote-sonne-munich-(de)', null, '1');
INSERT INTO `gig` VALUES ('205', null, '13161', 'Kollektiv Turmstrasse @ DGTL Festival at NDSM Docklands, Amsterdam (NL)', '2014-04-20 01:55:00', '2', '2014-04-07 07:00:31', '1404563833121817', null, '1', '1', '1', '1', '1', '205-kollektiv-turmstrasse-@-dgtl-festival-at-ndsm-docklands-amst', null, '1');
INSERT INTO `gig` VALUES ('222', null, '13191', 'D - MELT! FESTIVAL - PRE-PARTY 2014', '2014-07-17 00:00:00', '2', '2014-04-07 07:02:16', '591524900913666', null, '1', '1', '1', '1', '1', '222-d-melt!-festival-pre-party-2014', null, '1');
INSERT INTO `gig` VALUES ('223', null, '13198', 'CH-Zurich - M4Music Festival, Schiffbau', '2014-03-29 00:00:00', '2', '2014-04-07 07:02:24', '1406258226283777', null, '1', '1', '1', '1', '1', '223-ch-zurich-m4music-festival-schiffbau', null, '1');
INSERT INTO `gig` VALUES ('230', '4', '717', 'DUSTY KID (live) - 8 ФЕВРАЛЯ @ МОН КАФЕ', '2014-02-08 00:00:00', '1', '2014-02-07 01:37:36', null, null, '1', '1', '7', '4', null, '230-dusty-kid-(live)-8-@-', 'DUSTY KID (live)\nSEVA K\nROGGA\nRICHY', '1');
INSERT INTO `gig` VALUES ('231', '4', '718', 'Dusty Kid @ Zig Zag', '2014-02-14 00:00:00', '1', '2014-02-07 01:44:23', null, null, '1', '1', '1', '1', null, '231-dusty-kid-@-zig-zag', '', '1');
INSERT INTO `gig` VALUES ('232', '4', '719', 'Dusty Kid @ Iboat', '2014-04-11 00:00:00', '1', '2014-02-07 01:45:11', null, null, '1', '1', '1', '1', null, '232-dusty-kid-@-iboat', '', '1');
INSERT INTO `gig` VALUES ('233', null, '12990', 'Disclosure @ Lincoln Park Zoo in Chicago, IL', '2014-06-11 17:30:00', '2', '2014-04-07 06:00:37', '7673389', null, '1', '1', '1', '1', '3', '233-disclosure-@-lincoln-park-zoo-in-chicago-il', '', '1');
INSERT INTO `gig` VALUES ('244', null, '13179', 'Grape Festival', '2014-08-16 00:00:00', '2', '2014-04-07 07:01:21', '739899699354133', null, '1', '1', '1', '1', '1', '244-grape-festival', null, '1');
INSERT INTO `gig` VALUES ('245', null, '13185', 'Printemps de Bourges Festival', '2014-04-26 00:00:00', '2', '2014-04-07 07:01:29', '1403523563237715', null, '1', '1', '1', '1', '1', '245-printemps-de-bourges-festival', null, '1');
INSERT INTO `gig` VALUES ('246', null, '13186', 'Chorus Hauts-De-Seine Festival', '2014-04-05 00:00:00', '2', '2014-04-07 07:01:30', '1521410488084779', null, '1', '1', '1', '1', '1', '246-chorus-hauts-de-seine-festival', null, '1');
INSERT INTO `gig` VALUES ('247', null, '13187', 'Rock The Pistes Festival', '2014-03-26 00:00:00', '2', '2014-04-07 07:01:31', '1402542313336115', null, '1', '1', '1', '1', '1', '247-rock-the-pistes-festival', null, '1');
INSERT INTO `gig` VALUES ('255', null, '12913', 'Soul Clap @ Block in Tel Aviv, Israel', '2014-04-10 22:00:00', '2', '2014-04-07 06:00:28', '7676346', null, '1', '1', '1', '1', '3', '255-soul-clap-@-block-in-tel-aviv-israel', '', '1');
INSERT INTO `gig` VALUES ('256', null, '12914', 'Soul Clap @ Crew Love at Watergate in Berlin, Germany', '2014-04-11 22:00:00', '2', '2014-04-07 06:00:28', '7676351', null, '1', '1', '1', '1', '3', '256-soul-clap-@-crew-love-at-watergate-in-berlin-germany', '', '1');
INSERT INTO `gig` VALUES ('257', null, '12915', 'Soul Clap @ Propaganda in Istanbul, Turkey', '2014-04-12 22:00:00', '2', '2014-04-07 06:00:28', '7676355', null, '1', '1', '1', '1', '3', '257-soul-clap-@-propaganda-in-istanbul-turkey', '', '1');
INSERT INTO `gig` VALUES ('258', null, '12916', 'Soul Clap @ Crew Love at Elita Fesival in Milan, Italy', '2014-04-13 14:00:00', '2', '2014-04-07 06:00:28', '7676361', null, '1', '1', '1', '1', '3', '258-soul-clap-@-crew-love-at-elita-fesival-in-milan-italy', '', '1');
INSERT INTO `gig` VALUES ('259', null, '12919', 'Soul Clap @ Crew Love at DGTL Festival in Amsterdam, Netherlands', '2014-04-19 12:00:00', '2', '2014-04-07 06:00:28', '7676366', null, '1', '1', '1', '1', '3', '259-soul-clap-@-crew-love-at-dgtl-festival-in-amsterdam-netherla', '', '1');
INSERT INTO `gig` VALUES ('260', null, '12921', 'Soul Clap @ Crew Love at Moog Fest in Asheville, NC', '2014-04-23 22:00:00', '2', '2014-04-07 06:00:29', '7676375', null, '1', '1', '1', '1', '3', '260-soul-clap-@-crew-love-at-moog-fest-in-asheville-nc', '', '1');
INSERT INTO `gig` VALUES ('261', null, '12924', 'Soul Clap @ Lost Beach Club in Montanita, Ecuador', '2014-05-10 20:00:00', '2', '2014-04-07 06:00:29', '7676377', null, '1', '1', '1', '1', '3', '261-soul-clap-@-crew-love-at-lost-beach-club-in-montanita-ecuado', '', '1');
INSERT INTO `gig` VALUES ('264', null, '13054', 'Trentemøller @ Optimus Primavera Sound in Porto, Portugal', '2014-06-06 20:00:00', '2', '2014-04-07 06:00:45', '7678181', null, '1', '1', '1', '1', '3', '264-trentem-ller-@-optimus-primavera-sound-in-porto-portugal', 'http://www.optimusprimaverasound.com/?lang=en', '1');
INSERT INTO `gig` VALUES ('265', null, '13073', 'Ellen Allien @ La Grotta in Palinuro, Italy', '2014-04-21 19:00:00', '2', '2014-04-07 06:00:50', '7676046', null, '1', '1', '1', '1', '3', '265-ellen-allien-@-la-grotta-in-palinuro-italy', '', '1');
INSERT INTO `gig` VALUES ('273', null, '13018', 'Boys Noize @ Bugged Out in London, United Kingdom', '2014-04-17 19:00:00', '2', '2014-04-07 06:00:41', '7683725', null, '1', '1', '1', '1', '3', '273-boys-noize-@-bugged-out-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('274', null, '13021', 'Boys Noize @ Paaspop Festival in Schijndel, Netherlands', '2014-04-20 19:00:00', '2', '2014-04-07 06:00:41', '7534593', null, '1', '1', '1', '1', '3', '274-boys-noize-@-paaspop-festival-in-schijndel-netherlands', '', '1');
INSERT INTO `gig` VALUES ('276', null, '12973', 'Disclosure @ Greek Theatre-U.C. Berkeley in Berkeley, CA', '2014-04-18 19:00:00', '2', '2014-04-07 06:00:37', '7685982', null, '1', '1', '1', '1', '3', '276-justin-martin-@-greek-theatre-u-c-berkeley-in-berkeley-ca', '', '1');
INSERT INTO `gig` VALUES ('281', null, '12955', 'Duke Dumont @ Kingdom Nightclub in Austin, TX', '2014-04-12 22:00:00', '2', '2014-04-07 06:00:35', '7689054', null, '1', '1', '1', '1', '3', '281-duke-dumont-@-kingdom-nightclub-in-austin-tx', '', '1');
INSERT INTO `gig` VALUES ('282', null, '12957', 'Duke Dumont @ Mezzanine in San Francisco, CA', '2014-04-17 21:00:00', '2', '2014-04-07 06:00:35', '7689107', null, '1', '1', '1', '1', '3', '282-duke-dumont-@-mezzanine-in-san-francisco-ca', '', '1');
INSERT INTO `gig` VALUES ('283', null, '12959', 'Duke Dumont @ Output in New York, NY', '2014-04-24 22:00:00', '2', '2014-04-07 06:00:35', '7689165', null, '1', '1', '1', '1', '3', '283-duke-dumont-@-output-in-new-york-ny', '', '1');
INSERT INTO `gig` VALUES ('284', null, '12960', 'Duke Dumont @ Coda in Toronto, Canada', '2014-04-26 22:00:00', '2', '2014-04-07 06:00:35', '7687062', null, '1', '1', '1', '1', '3', '284-duke-dumont-@-coda-in-toronto-canada', '', '1');
INSERT INTO `gig` VALUES ('285', null, '12992', 'Disclosure @ Club Papaya & Club Aquarius in Novalja, Croatia', '2014-06-30 22:00:00', '2', '2014-04-07 06:00:37', '7421221', null, '1', '1', '1', '1', '3', '285-disclosure-@-club-papaya-&-club-aquarius-in-novalja-croatia', '', '1');
INSERT INTO `gig` VALUES ('286', null, '13015', 'Dusky @ Robin Hill Country Park in Isle Of Wight, United Kingdom', '2014-09-04 10:00:00', '2', '2014-04-07 06:00:40', '7132244', null, '1', '1', '1', '1', '3', '286-disclosure-@-robin-hill-country-park-in-isle-of-wight-united', '', '1');
INSERT INTO `gig` VALUES ('291', null, '13065', 'King Krule @ Pumpehuset in Copenhagen, Denmark', '2014-04-11 21:00:00', '2', '2014-04-07 06:00:48', '7692457', null, '1', '1', '1', '1', '3', '291-king-krule-@-pumpehuset-in-copenhagen-denmark', '', '1');
INSERT INTO `gig` VALUES ('292', null, '13066', 'King Krule @ Debaser Strand in Stockholm, Sweden', '2014-04-13 20:00:00', '2', '2014-04-07 06:00:48', '7692417', null, '1', '1', '1', '1', '3', '292-king-krule-@-debaser-strand-in-stockholm-sweden', '', '1');
INSERT INTO `gig` VALUES ('293', null, '13094', 'Timo Maas @ Middlesex Lounge in Cambridge, MA', '2014-04-24 22:00:00', '2', '2014-04-07 06:00:53', '7695635', null, '1', '1', '1', '1', '3', '293-timo-maas-@-middlesex-lounge-in-cambridge-ma', '', '1');
INSERT INTO `gig` VALUES ('301', null, '13059', 'Trentemøller @ Ilosaarirock Festival 2014 in Joensuu, Finland', '2014-07-12 21:00:00', '2', '2014-04-07 06:00:45', '7705905', null, '1', '1', '1', '1', '3', '301-trentem-ller-@-ilosaarirock-festival-2014-in-joensuu-finland', '', '1');
INSERT INTO `gig` VALUES ('318', null, '13016', 'Boys Noize @ Reverse.La Riviera in Madrid, Spain', '2014-04-11 19:00:00', '2', '2014-04-07 06:00:41', '7729363', null, '1', '1', '1', '1', '3', '318-boys-noize-@-reverse-la-riviera-in-madrid-spain', '', '1');
INSERT INTO `gig` VALUES ('319', null, '13017', 'Boys Noize @ Florida 135 in Fraga, Spain', '2014-04-12 19:00:00', '2', '2014-04-07 06:00:41', '7729373', null, '1', '1', '1', '1', '3', '319-boys-noize-@-florida-135-in-fraga-spain', '', '1');
INSERT INTO `gig` VALUES ('320', null, '13020', 'Boys Noize @ Showcase in Paris, France', '2014-04-19 19:00:00', '2', '2014-04-07 06:00:41', '7729386', null, '1', '1', '1', '1', '3', '320-boys-noize-@-showcase-in-paris-france', '', '1');
INSERT INTO `gig` VALUES ('321', null, '13023', 'Boys Noize @ Royale Nightclub in Boston, MA', '2014-05-01 19:00:00', '2', '2014-04-07 06:00:41', '7729414', null, '1', '1', '1', '1', '3', '321-boys-noize-@-royale-nightclub-in-boston-ma', '', '1');
INSERT INTO `gig` VALUES ('322', null, '13024', 'Boys Noize @ The Hoxton in Toronto, Canada', '2014-05-02 19:00:00', '2', '2014-04-07 06:00:41', '7729418', null, '1', '1', '1', '1', '3', '322-boys-noize-@-the-hoxton-in-toronto-canada', '', '1');
INSERT INTO `gig` VALUES ('323', null, '13025', 'Boys Noize @ Telus Theatre in Montreal Metro Area, Canada', '2014-05-03 19:00:00', '2', '2014-04-07 06:00:41', '7729420', null, '1', '1', '1', '1', '3', '323-boys-noize-@-telus-theatre-in-montreal-metro-area-canada', '', '1');
INSERT INTO `gig` VALUES ('324', null, '13026', 'Boys Noize @ Monarch Theatre in Phoenix, AZ', '2014-05-07 19:00:00', '2', '2014-04-07 06:00:41', '7729423', null, '1', '1', '1', '1', '3', '324-boys-noize-@-monarch-theatre-in-phoenix-az', '', '1');
INSERT INTO `gig` VALUES ('325', null, '13027', 'Boys Noize @ Beta in Denver, CO', '2014-05-08 19:00:00', '2', '2014-04-07 06:00:41', '7729425', null, '1', '1', '1', '1', '3', '325-boys-noize-@-beta-in-denver-co', '', '1');
INSERT INTO `gig` VALUES ('326', null, '13028', 'Boys Noize @ The Mid in Chicago, IL', '2014-05-09 19:00:00', '2', '2014-04-07 06:00:41', '7729429', null, '1', '1', '1', '1', '3', '326-boys-noize-@-the-mid-in-chicago-il', '', '1');
INSERT INTO `gig` VALUES ('327', null, '13029', 'Boys Noize @ Firestone in Orlando, FL', '2014-05-15 19:00:00', '2', '2014-04-07 06:00:41', '7729437', null, '1', '1', '1', '1', '3', '327-boys-noize-@-firestone-in-orlando-fl', '', '1');
INSERT INTO `gig` VALUES ('328', null, '13030', 'Boys Noize @ Amphitheatre Event Facility in Tampa, FL', '2014-05-16 19:00:00', '2', '2014-04-07 06:00:41', '7729440', null, '1', '1', '1', '1', '3', '328-boys-noize-@-amphitheatre-event-facility-in-tampa-fl', '', '1');
INSERT INTO `gig` VALUES ('329', null, '13031', 'Boys Noize @ Tricky Falls in El Paso, TX', '2014-05-17 19:00:00', '2', '2014-04-07 06:00:41', '7729443', null, '1', '1', '1', '1', '3', '329-boys-noize-@-tricky-falls-in-el-paso-tx', '', '1');
INSERT INTO `gig` VALUES ('330', null, '13032', 'Boys Noize @ Hangout Music Festival in Gulf Shores, AL', '2014-05-18 22:00:00', '2', '2014-04-07 06:00:41', '7566815', null, '1', '1', '1', '1', '3', '330-boys-noize-@-hangout-music-festival-in-gulf-shores-al', '', '1');
INSERT INTO `gig` VALUES ('331', null, '13033', 'Boys Noize @ Union Hall in Edmonton, Canada', '2014-05-23 19:00:00', '2', '2014-04-07 06:00:41', '7729450', null, '1', '1', '1', '1', '3', '331-boys-noize-@-union-hall-in-edmonton-canada', '', '1');
INSERT INTO `gig` VALUES ('333', null, '13036', 'Boys Noize @ Movement Festival in Detroit, MI', '2014-05-26 19:00:00', '2', '2014-04-07 06:00:41', '7536574', null, '1', '1', '1', '1', '3', '333-boys-noize-@-movement-festival-in-detroit-mi', '', '1');
INSERT INTO `gig` VALUES ('334', null, '13037', 'Boys Noize @ Organic Dance Music Festival in Munich, Germany', '2014-05-31 19:00:00', '2', '2014-04-07 06:00:41', '7729475', null, '1', '1', '1', '1', '3', '334-boys-noize-@-organic-dance-music-festival-in-munich-germany', '', '1');
INSERT INTO `gig` VALUES ('335', null, '13039', 'Boys Noize @ Debaser Medis in Stockholm, Sweden', '2014-06-07 19:00:00', '2', '2014-04-07 06:00:41', '7729487', null, '1', '1', '1', '1', '3', '335-boys-noize-@-debaser-medis-in-stockholm-sweden', '', '1');
INSERT INTO `gig` VALUES ('347', null, '13038', 'Boys Noize @ Distortion 2014 in Copenhagen, Denmark', '2014-06-06 19:00:00', '2', '2014-04-07 06:00:41', '7734385', null, '1', '1', '1', '1', '3', '347-boys-noize-@-distortion-2014-in-copenhagen-denmark', '', '1');
INSERT INTO `gig` VALUES ('349', null, '13058', 'Trentemøller @ Rock Werchter 2014 in Werchter, Belgium', '2014-07-05 20:00:00', '2', '2014-04-07 06:00:45', '7733099', null, '1', '1', '1', '1', '3', '349-trentem-ller-@-rock-werchter-2014-in-werchter-belgium', '', '1');
INSERT INTO `gig` VALUES ('351', null, '13147', 'Kollektiv Turmstrasse @ SonneMondSterne, Saalburg-Ebersdorf (DE)', '2014-08-09 22:00:00', '2', '2014-04-07 07:00:12', '344569552349248', null, '1', '1', '1', '1', '1', '351-kollektiv-turmstrasse-@-sonnemondsterne-saalburg-ebersdorf-(', null, '1');
INSERT INTO `gig` VALUES ('352', null, '13158', 'Kollektiv Turmstrasse @ Wagenhallen, Stuttgart (DE)', '2014-04-27 01:55:00', '2', '2014-04-07 07:00:28', '293284477485990', null, '1', '1', '1', '1', '1', '352-kollektiv-turmstrasse-@-wagenhallen-stuttgart-(de)', null, '1');
INSERT INTO `gig` VALUES ('353', null, '13162', 'Kollektiv Turmstrasse @  Centrum Club, Erfurt (DE)', '2014-04-13 01:55:00', '2', '2014-04-07 07:00:32', '535638869884619', null, '1', '1', '1', '1', '1', '353-kollektiv-turmstrasse-@-centrum-club-erfurt-(de)', null, '1');
INSERT INTO `gig` VALUES ('355', null, '13180', 'Dour Festival', '2014-07-18 00:00:00', '2', '2014-04-07 07:01:23', '259516500874920', null, '1', '1', '1', '1', '1', '355-dour-festival', null, '1');
INSERT INTO `gig` VALUES ('356', null, '13183', 'For Festival', '2014-06-19 00:00:00', '2', '2014-04-07 07:01:27', '681094175276358', null, '1', '1', '1', '1', '1', '356-for-festival', null, '1');
INSERT INTO `gig` VALUES ('357', null, '12907', 'Stephan Bodzin @ Egg London in London, United Kingdom', '2014-04-26 23:00:00', '2', '2014-04-07 06:00:26', '7739659', null, '1', '1', '1', '1', '3', '357-stephan-bodzin-@-egg-london-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('359', null, '12947', 'Mark E @ Glasslands Gallery in Brooklyn, NY', '2014-04-12 23:30:00', '2', '2014-04-07 06:00:31', '7689057', null, '1', '1', '1', '1', '3', '359-mark-e-@-glasslands-gallery-in-brooklyn-ny', '', '1');
INSERT INTO `gig` VALUES ('360', null, '12950', 'Todd Terje @ Cabaret Sauvage in Paris, France', '2014-06-08 23:00:00', '2', '2014-04-07 06:00:32', '7746256', null, '1', '1', '1', '1', '3', '360-todd-terje-@-cabaret-sauvage-in-paris-france', '', '1');
INSERT INTO `gig` VALUES ('361', null, '12954', 'Morgan Geist @ The Twisted Pepper in Dublin, Ireland', '2014-06-21 22:30:00', '2', '2014-04-07 06:00:33', '7745451', null, '1', '1', '1', '1', '3', '361-morgan-geist-@-the-twisted-pepper-in-dublin-ireland', '', '1');
INSERT INTO `gig` VALUES ('363', null, '12975', 'Disclosure @ Hordern Pavilion in Sydney Nsw, Australia', '2014-04-24 20:00:00', '2', '2014-04-07 06:00:37', '7739344', null, '1', '1', '1', '1', '3', '363-disclosure-@-hordern-pavilion-in-sydney-nsw-australia', '', '1');
INSERT INTO `gig` VALUES ('364', null, '12980', 'Disclosure @ Forum Melbourne in Melbourne Vic, Australia', '2014-05-01 20:00:00', '2', '2014-04-07 06:00:37', '7737490', null, '1', '1', '1', '1', '3', '364-disclosure-@-forum-melbourne-in-melbourne-vic-australia', '', '1');
INSERT INTO `gig` VALUES ('365', null, '12986', 'Disclosure @ Studio Coast in Tokyo, Japan', '2014-05-15 18:00:00', '2', '2014-04-07 06:00:37', '7751379', null, '1', '1', '1', '1', '3', '365-disclosure-@-studio-coast-in-tokyo-japan', '', '1');
INSERT INTO `gig` VALUES ('369', null, '13001', 'Klaxons @ Printemps de Bourges Festival in Bourges, France', '2014-04-26 19:00:00', '2', '2014-04-07 06:00:38', '7737030', null, '1', '1', '1', '1', '3', '369-klaxons-@-printemps-de-bourges-festival-in-bourges-france', '', '1');
INSERT INTO `gig` VALUES ('370', null, '13003', 'Klaxons @ FOR Festival in Hvar, Croatia', '2014-06-19 19:00:00', '2', '2014-04-07 06:00:38', '7737038', null, '1', '1', '1', '1', '3', '370-klaxons-@-for-festival-in-hvar-croatia', '', '1');
INSERT INTO `gig` VALUES ('372', null, '13005', 'Klaxons @ Benicàssim Festival in Costa, Spain', '2014-07-17 19:00:00', '2', '2014-04-07 06:00:38', '7739008', null, '1', '1', '1', '1', '3', '372-klaxons-@-benic-ssim-festival-in-costa-spain', '', '1');
INSERT INTO `gig` VALUES ('373', null, '13007', 'Klaxons @ SZIGET FESTIVAL in Paris, France', '2014-08-15 19:00:00', '2', '2014-04-07 06:00:38', '7737119', null, '1', '1', '1', '1', '3', '373-klaxons-@-sziget-festival-in-paris-france', '', '1');
INSERT INTO `gig` VALUES ('374', null, '13008', 'Klaxons @ Grape Festival in Piestany, Slovakia (Slovak Republic)', '2014-08-16 19:00:00', '2', '2014-04-07 06:00:38', '7673902', null, '1', '1', '1', '1', '3', '374-klaxons-@-grape-festival-in-piestany-slovakia-(slovak-republ', '', '1');
INSERT INTO `gig` VALUES ('381', null, '13098', 'Timo Maas @ Treehouse in Miami, FL', '2014-05-01 22:00:00', '2', '2014-04-07 06:00:53', '7742603', null, '1', '1', '1', '1', '3', '381-timo-maas-@-treehouse-in-miami-fl', '', '1');
INSERT INTO `gig` VALUES ('382', null, '13106', 'Timo Maas @ Luft & Leibe Festival in Moers, Germany', '2014-06-08 22:00:00', '2', '2014-04-07 06:00:53', '7742675', null, '1', '1', '1', '1', '3', '382-timo-maas-@-luft-&-leibe-festival-in-moers-germany', '', '1');
INSERT INTO `gig` VALUES ('383', null, '13108', 'Timo Maas @ The Source Bar in Maidstone, United Kingdom', '2014-06-21 22:00:00', '2', '2014-04-07 06:00:53', '7741278', null, '1', '1', '1', '1', '3', '383-timo-maas-@-the-source-bar-in-maidstone-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('384', null, '13109', 'Timo Maas @ Electric Daisy Carnival in Milton Keynes, United Kingdom', '2014-07-12 22:00:00', '2', '2014-04-07 06:00:53', '7741562', null, '1', '1', '1', '1', '3', '384-timo-maas-@-electric-daisy-carnival-in-milton-keynes-united-', '', '1');
INSERT INTO `gig` VALUES ('385', null, '13110', 'Timo Maas @ Minsk Festival in Minsk, Belarus', '2014-07-18 22:00:00', '2', '2014-04-07 06:00:53', '7742499', null, '1', '1', '1', '1', '3', '385-timo-maas-@-minsk-festival-in-minsk-belarus', '', '1');
INSERT INTO `gig` VALUES ('387', null, '13200', 'Maceo Plex @ Monarch Theatre in Phoenix, AZ', '2014-04-16 21:00:00', '2', '2014-04-08 06:00:03', '7755506', null, '1', '1', '1', '1', '3', '387-maceo-plex-@-monarch-theatre-in-phoenix-az', '', '1');
INSERT INTO `gig` VALUES ('388', null, '12905', 'Nicolas Jaar @ Théâtre Silvain en plein air in Marseille, France', '2014-06-26 19:00:00', '2', '2014-04-07 06:00:24', '7701364', null, '1', '1', '1', '1', '3', '388-nicolas-jaar-@-th-tre-silvain-en-plein-air-in-marseille-fran', '', '1');
INSERT INTO `gig` VALUES ('390', null, '13181', 'Benicassim Festival', '2014-07-17 00:00:00', '2', '2014-04-07 07:01:25', '517235898391883', null, '1', '1', '1', '1', '1', '390-benicassim-festival', null, '1');
INSERT INTO `gig` VALUES ('396', null, '12981', 'Disclosure @ Forum Melbourne in Melbourne Vic, Australia', '2014-05-02 20:00:00', '2', '2014-04-07 06:00:37', '7760211', null, '1', '1', '1', '1', '3', '396-disclosure-@-forum-melbourne-in-melbourne-vic-australia', '', '1');
INSERT INTO `gig` VALUES ('398', null, '13014', 'Dusky @ STORY MIAMI in Miami Beach, FL', '2014-06-14 23:00:00', '2', '2014-04-07 06:00:40', '7760981', null, '1', '1', '1', '1', '3', '398-dusky-@-story-miami-in-miami-beach-fl', '', '1');
INSERT INTO `gig` VALUES ('403', null, '13052', 'Trentemøller @ Mezzanine in San Francisco, CA', '2014-04-06 19:00:00', '2', '2014-04-07 06:00:45', '7768993', null, '1', '1', '1', '1', '3', '403-trentem-ller-@-mezzanine-in-san-francisco-ca', '+ Special guest: T.O.M and his computer', '1');
INSERT INTO `gig` VALUES ('408', null, '13069', 'Ellen Allien @ Babylon in Istanbul, Turkey', '2014-04-12 19:00:00', '2', '2014-04-07 06:00:50', '7765676', null, '1', '1', '1', '1', '3', '408-ellen-allien-@-babylon-in-istanbul-turkey', '', '1');
INSERT INTO `gig` VALUES ('412', null, '12951', 'Todd Terje @ Pont du Gard in Vers-Pont-Du-Gard, France', '2014-07-11 18:00:00', '2', '2014-04-07 06:00:32', '7690063', null, '1', '1', '1', '1', '3', '412-todd-terje-@-pont-du-gard-in-vers-pont-du-gard-france', '', '1');
INSERT INTO `gig` VALUES ('416', null, '12939', 'Portable aka Bodycode @ veniceberg in Verona, Italy', '2014-04-18 23:00:00', '2', '2014-04-07 06:00:30', '7802296', null, '1', '1', '1', '1', '3', '416-portable-aka-bodycode-@-veniceberg-in-verona-italy', '', '1');
INSERT INTO `gig` VALUES ('417', null, '12941', 'Portable aka Bodycode @ Autumn Street Studios in London, United Kingdom', '2014-04-20 23:00:00', '2', '2014-04-07 06:00:30', '7802297', null, '1', '1', '1', '1', '3', '417-portable-aka-bodycode-@-autumn-street-studios-in-london-unit', '', '1');
INSERT INTO `gig` VALUES ('418', null, '12979', 'Disclosure @ Forum Melbourne in Melbourne Vic, Australia', '2014-04-30 20:00:00', '2', '2014-04-07 06:00:37', '7803650', null, '1', '1', '1', '1', '3', '418-disclosure-@-forum-melbourne-in-melbourne-vic-australia', '', '1');
INSERT INTO `gig` VALUES ('419', null, '12991', 'Disclosure @ The Pageant in St Louis, MO', '2014-06-12 20:00:00', '2', '2014-04-07 06:00:37', '7802572', null, '1', '1', '1', '1', '3', '419-disclosure-@-the-pageant-in-st-louis-mo', '', '1');
INSERT INTO `gig` VALUES ('425', null, '13184', 'Freeform Festival', '2014-05-09 00:00:00', '2', '2014-04-07 07:01:28', '1472786902933295', null, '1', '1', '1', '1', '1', '425-freeform-festival', null, '1');
INSERT INTO `gig` VALUES ('429', null, '12917', 'Soul Clap @ Sankeys in Manchester, United Kingdom', '2014-04-17 22:00:00', '2', '2014-04-07 06:00:28', '7773746', null, '1', '1', '1', '1', '3', '429-soul-clap-@-sankeys-in-manchester-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('430', null, '12918', 'Soul Clap @ Zig Zag in Paris, France', '2014-04-18 22:00:00', '2', '2014-04-07 06:00:28', '7767277', null, '1', '1', '1', '1', '3', '430-soul-clap-@-zig-zag-in-paris-france', '', '1');
INSERT INTO `gig` VALUES ('431', null, '12968', 'Duke Dumont @ Pen y Berth in Gwynedd, United Kingdom', '2014-07-11 16:00:00', '2', '2014-04-07 06:00:35', '7774879', null, '1', '1', '1', '1', '3', '431-duke-dumont-@-pen-y-berth-in-gwynedd-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('432', null, '12971', 'Disclosure @ Brooklyn Bowl Las Vegas in Las Vegas, NV', '2014-04-11 23:59:00', '2', '2014-04-07 06:00:37', '7647916', null, '1', '1', '1', '1', '3', '432-disclosure-@-brooklyn-bowl-las-vegas-in-las-vegas-nv', '', '1');
INSERT INTO `gig` VALUES ('433', null, '12988', 'Disclosure @ Union Transfer in Philadelphia, PA', '2014-06-06 20:30:00', '2', '2014-04-07 06:00:37', '7820608', null, '1', '1', '1', '1', '3', '433-disclosure-@-union-transfer-in-philadelphia-pa', '', '1');
INSERT INTO `gig` VALUES ('434', null, '12997', 'Disclosure @ Marlay Park in Dublin, Ireland', '2014-07-19 12:00:00', '2', '2014-04-07 06:00:37', '7800245', null, '1', '1', '1', '1', '3', '434-disclosure-@-marlay-park-in-dublin-ireland', '', '1');
INSERT INTO `gig` VALUES ('435', null, '13035', 'Boys Noize @ Electric Daisy Carnival in East Rutherford, NJ', '2014-05-25 19:00:00', '2', '2014-04-07 06:00:41', '7809800', null, '1', '1', '1', '1', '3', '435-boys-noize-@-electric-daisy-carnival-in-east-rutherford-nj', '', '1');
INSERT INTO `gig` VALUES ('436', null, '13053', 'Trentemøller @ Nuits Sonores Festival in Lyon, France', '2014-05-31 21:00:00', '2', '2014-04-07 06:00:45', '7794258', null, '1', '1', '1', '1', '3', '436-trentem-ller-@-nuits-sonores-festival-in-lyon-france', '', '1');
INSERT INTO `gig` VALUES ('438', null, '13089', 'Kate Simko @ Verboten in New York, NY', '2014-04-11 23:00:00', '2', '2014-04-07 06:00:51', '7804337', null, '1', '1', '1', '1', '3', '438-kate-simko-@-verboten-in-new-york-ny', '', '1');
INSERT INTO `gig` VALUES ('439', null, '13091', 'Kate Simko @ The Forge in London, United Kingdom', '2014-06-12 19:00:00', '2', '2014-04-07 06:00:52', '7804346', null, '1', '1', '1', '1', '3', '439-kate-simko-@-the-forge-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('440', null, '13092', 'Kate Simko @ Paradise @ DC-10 in Ibiza, Spain', '2014-07-23 23:00:00', '2', '2014-04-07 06:00:52', '7804354', null, '1', '1', '1', '1', '3', '440-kate-simko-@-paradise-@-dc-10-in-ibiza-spain', '', '1');
INSERT INTO `gig` VALUES ('441', null, '13101', 'Timo Maas @ SANKEYS NYC in New York, NY', '2014-05-10 22:00:00', '2', '2014-04-07 06:00:53', '7815588', null, '1', '1', '1', '1', '3', '441-timo-maas-@-sankeys-in-new-york-ny', '', '1');
INSERT INTO `gig` VALUES ('442', null, '13107', 'Timo Maas @ Terme di Agnano in Naples, Italy', '2014-06-20 22:00:00', '2', '2014-04-07 06:00:53', '7814678', null, '1', '1', '1', '1', '3', '442-timo-maas-@-terme-di-agnano-in-naples-italy', '', '1');
INSERT INTO `gig` VALUES ('443', null, '13034', 'Boys Noize @ MetLife Stadium in East Rutherford, NJ', '2014-05-24 19:00:00', '2', '2014-04-07 06:00:41', '7437899', null, '1', '1', '1', '1', '3', '443-boys-noize-@-metlife-stadium-in-east-rutherford-nj', '', '1');
INSERT INTO `gig` VALUES ('445', null, '13047', 'Tiga @ Tiga vs Audion at Berghain in Berlin, Germany', '2014-04-30 19:00:00', '2', '2014-04-07 06:00:42', '7827089', null, '1', '1', '1', '1', '3', '445-tiga-@-tiga-vs-audion-at-berghain-in-berlin-germany', '', '1');
INSERT INTO `gig` VALUES ('447', null, '13177', 'Hot Since 82 @ Coachella Festival, US', '2014-04-18 00:00:00', '2', '2014-04-07 07:01:04', '294867080670958', null, '1', '1', '1', '1', '1', '447-hot-since-82-@-coachella-festival-us', null, '1');
INSERT INTO `gig` VALUES ('448', null, '13178', 'Hot Since 82 @ Coachella, Festival, US', '2014-04-11 00:00:00', '2', '2014-04-07 07:01:06', '1413945688856032', null, '1', '1', '1', '1', '1', '448-hot-since-82-@-coachella-festival-us', null, '1');
INSERT INTO `gig` VALUES ('454', null, '12969', 'Duke Dumont @ Victoria Park in London, United Kingdom', '2014-07-18 14:00:00', '2', '2014-04-07 06:00:35', '7463868', null, '1', '1', '1', '1', '3', '454-duke-dumont-@-victoria-park-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('455', null, '12999', 'Disclosure @ Richfield Avenue in Reading, United Kingdom', '2014-08-22 11:00:00', '2', '2014-04-07 06:00:37', '7091956', null, '1', '1', '1', '1', '3', '455-disclosure-@-richfield-avenue-in-reading-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('457', null, '13144', 'Minilogue @ Output in New York, NY', '2014-04-11 22:00:00', '2', '2014-04-07 06:00:58', '7838997', null, '1', '1', '1', '1', '3', '457-minilogue-@-output-in-new-york-ny', '', '1');
INSERT INTO `gig` VALUES ('461', null, '12942', 'Portable aka Bodycode @ Panorama Bar in Berlin, Germany', '2014-05-23 23:00:00', '2', '2014-04-07 06:00:30', '7847429', null, '1', '1', '1', '1', '3', '461-portable-aka-bodycode-@-panorama-bar-in-berlin-germany', '', '1');
INSERT INTO `gig` VALUES ('462', null, '13002', 'Klaxons @ Freeform Festival in Warsaw, Poland', '2014-05-09 19:00:00', '2', '2014-04-07 06:00:38', '7847673', null, '1', '1', '1', '1', '3', '462-klaxons-@-freeform-festival-in-warsaw-poland', '', '1');
INSERT INTO `gig` VALUES ('463', null, '13004', 'Klaxons @ Kosmonaut Festival in Berlin, Germany', '2014-06-28 19:00:00', '2', '2014-04-07 06:00:38', '7847694', null, '1', '1', '1', '1', '3', '463-klaxons-@-kosmonaut-festival-in-berlin-germany', '', '1');
INSERT INTO `gig` VALUES ('464', null, '13182', 'Kosmonaut Festival', '2014-06-28 00:00:00', '2', '2014-04-07 07:01:26', '1412567525668917', null, '1', '1', '1', '1', '1', '464-kosmonaut-festival', null, '1');
INSERT INTO `gig` VALUES ('465', null, '13188', 'LUX-Bissen - Food For your Senses Festival', '2014-07-25 00:00:00', '2', '2014-04-07 07:02:12', '735842543113309', null, '1', '1', '1', '1', '1', '465-lux-bissen-food-for-your-senses-festival', null, '1');
INSERT INTO `gig` VALUES ('466', null, '13189', 'A-Feldkirch - Poolbar Festival Open Air', '2014-07-19 00:00:00', '2', '2014-04-07 07:02:13', '1475949642633075', null, '1', '1', '1', '1', '1', '466-a-feldkirch-poolbar-festival-open-air', null, '1');
INSERT INTO `gig` VALUES ('467', null, '13192', 'D-Scheessel - Hurricane Festival', '2014-06-22 00:00:00', '2', '2014-04-07 07:02:17', '694260043969482', null, '1', '1', '1', '1', '1', '467-d-scheessel-hurricane-festival', null, '1');
INSERT INTO `gig` VALUES ('468', null, '13193', 'D-Duisburg - Traumzeit Festival', '2014-06-21 00:00:00', '2', '2014-04-07 07:02:18', '1459378980960332', null, '1', '1', '1', '1', '1', '468-d-duisburg-traumzeit-festival', null, '1');
INSERT INTO `gig` VALUES ('469', null, '13194', 'D-Neuhausen ob Eck - Southside Festival', '2014-06-20 00:00:00', '2', '2014-04-07 07:02:19', '644842528903843', null, '1', '1', '1', '1', '1', '469-d-neuhausen-ob-eck-southside-festival', null, '1');
INSERT INTO `gig` VALUES ('470', null, '13195', 'D-Salching - Pfingst Open Air', '2014-06-07 00:00:00', '2', '2014-04-07 07:02:20', '542379999192546', null, '1', '1', '1', '1', '1', '470-d-salching-pfingst-open-air', null, '1');
INSERT INTO `gig` VALUES ('471', null, '13196', 'D-Berlin - Volksbühne - RECORD RELEASE SHOW', '2014-05-29 00:00:00', '2', '2014-04-07 07:02:21', '221172004757723', null, '1', '1', '1', '1', '1', '471-d-berlin-volksb-hne-record-release-show', null, '1');
INSERT INTO `gig` VALUES ('472', null, '12909', 'Justin Martin @ Verboten in Brooklyn, NY', '2014-05-02 23:00:00', '2', '2014-04-07 06:00:26', '7764713', null, '1', '1', '1', '1', '3', '472-justin-martin-@-verboten-in-brooklyn-ny', '', '1');
INSERT INTO `gig` VALUES ('474', null, '12923', 'Soul Clap @ Spy Bar in Chicago, IL', '2014-05-03 22:00:00', '2', '2014-04-07 06:00:29', '7871429', null, '1', '1', '1', '1', '3', '474-soul-clap-@-spy-bar-in-chicago-il', '', '1');
INSERT INTO `gig` VALUES ('476', null, '12928', 'Soul Clap @ BAR AMERICAS in Guadalajara, Mexico', '2014-05-30 19:00:00', '2', '2014-04-07 06:00:29', '7838593', null, '1', '1', '1', '1', '3', '476-soul-clap-@-bar-americas-in-guadalajara-mexico', '', '1');
INSERT INTO `gig` VALUES ('478', null, '12929', 'Soul Clap @ Sonar festival in Statella, Spain', '2014-06-13 22:00:00', '2', '2014-04-07 06:00:29', '7776932', null, '1', '1', '1', '1', '3', '478-soul-clap-@-sonar-festival-in-statella-spain', '', '1');
INSERT INTO `gig` VALUES ('479', null, '12932', 'Soul Clap @ Garden Fest in Zadar, Croatia', '2014-07-07 22:00:00', '2', '2014-04-07 06:00:29', '7871107', null, '1', '1', '1', '1', '3', '479-soul-clap-@-garden-fest-in-zadar-croatia', '', '1');
INSERT INTO `gig` VALUES ('480', null, '12933', 'Soul Clap @ Utopia in Neuss, Germany', '2014-07-13 22:00:00', '2', '2014-04-07 06:00:29', '7871235', null, '1', '1', '1', '1', '3', '480-soul-clap-@-utopia-in-neuss-germany', '', '1');
INSERT INTO `gig` VALUES ('481', null, '12934', 'Soul Clap @ Tunisee in Freiburg, Germany', '2014-07-20 22:00:00', '2', '2014-04-07 06:00:29', '7871671', null, '1', '1', '1', '1', '3', '481-soul-clap-@-tunisee-in-freiburg-germany', '', '1');
INSERT INTO `gig` VALUES ('482', null, '12935', 'TONE of ARC @ Bar 13 in Krasnodar, Russian Federation', '2014-04-11 19:00:00', '2', '2014-04-07 06:00:29', '7854148', null, '1', '1', '1', '1', '3', '482-tone-of-arc-@-bar-13-in-krasnodar-russian-federation', '', '1');
INSERT INTO `gig` VALUES ('483', null, '12936', 'TONE of ARC @ Fabric in London, United Kingdom', '2014-04-12 19:00:00', '2', '2014-04-07 06:00:29', '7849220', null, '1', '1', '1', '1', '3', '483-tone-of-arc-@-fabric-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('484', null, '12937', 'TONE of ARC @ Badaboum in Paris, France', '2014-04-17 19:00:00', '2', '2014-04-07 06:00:29', '7854151', null, '1', '1', '1', '1', '3', '484-tone-of-arc-@-badaboum-in-paris-france', '', '1');
INSERT INTO `gig` VALUES ('485', null, '12938', 'TONE of ARC @ Dom Pechati in Ekaterinburg, Russian Federation', '2014-04-25 19:00:00', '2', '2014-04-07 06:00:29', '7854153', null, '1', '1', '1', '1', '3', '485-tone-of-arc-@-dom-pechati-in-ekaterinburg-russian-federation', '', '1');
INSERT INTO `gig` VALUES ('486', null, '13009', 'Klaxons @ Reading and Leeds Festival in Reading, United Kingdom', '2014-08-22 19:00:00', '2', '2014-04-07 06:00:38', '7858478', null, '1', '1', '1', '1', '3', '486-klaxons-@-reading-and-leeds-festival-in-reading-united-kingd', '', '1');
INSERT INTO `gig` VALUES ('487', null, '13041', 'Boys Noize @ Bestival in Isle Of Wight, United Kingdom', '2014-09-05 19:00:00', '2', '2014-04-07 06:00:41', '7638073', null, '1', '1', '1', '1', '3', '487-boys-noize-@-bestival-in-isle-of-wight-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('489', null, '13056', 'Trentemøller @ Hovefestival in Arendal, Norway', '2014-07-02 23:59:00', '2', '2014-04-07 06:00:45', '7856533', null, '1', '1', '1', '1', '3', '489-trentem-ller-@-hovefestival-in-arendal-norway', '', '1');
INSERT INTO `gig` VALUES ('490', null, '13061', 'Jimpster @ Bermuda Triangle in Brighton, United Kingdom', '2014-04-11 19:00:00', '2', '2014-04-07 06:00:45', '7851341', null, '1', '1', '1', '1', '3', '490-jimpster-@-bermuda-triangle-in-brighton-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('491', null, '13114', 'Timo Maas @ Marx Bar in Hollerich, Luxembourg', '2014-08-22 22:00:00', '2', '2014-04-07 06:00:53', '7870488', null, '1', '1', '1', '1', '3', '491-timo-maas-@-marx-bar-in-hollerich-luxembourg', '', '1');
INSERT INTO `gig` VALUES ('492', null, '13145', 'Dusty Kid @ Perspectives on friskyRadio in New York, NY', '2014-04-16 16:00:00', '2', '2014-04-07 06:00:59', '7469351', null, '1', '1', '1', '1', '3', '492-dusty-kid-@-perspectives-on-friskyradio-in-new-york-ny', '', '1');
INSERT INTO `gig` VALUES ('493', null, '12906', 'Boris Brejcha @ Garorock Festival in Marmande, France', '2014-06-29 19:00:00', '2', '2014-04-07 06:00:25', '7804483', null, '1', '1', '1', '1', '3', '493-boris-brejcha-@-garorock-festival-in-marmande-france', '', '1');
INSERT INTO `gig` VALUES ('494', null, '12952', 'Todd Terje @ Tøyenparken in Oslo, Norway', '2014-08-09 13:00:00', '2', '2014-04-07 06:00:32', '7881761', null, '1', '1', '1', '1', '3', '494-todd-terje-@-t-yenparken-in-oslo-norway', '', '1');
INSERT INTO `gig` VALUES ('497', null, '12961', 'Duke Dumont @ The Forum in Aberdeen, United Kingdom', '2014-05-02 23:00:00', '2', '2014-04-07 06:00:35', '7881745', null, '1', '1', '1', '1', '3', '497-duke-dumont-@-the-forum-in-aberdeen-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('498', null, '12963', 'Duke Dumont @ Cabaret Voltaire in Edinburgh, United Kingdom', '2014-05-04 22:00:00', '2', '2014-04-07 06:00:35', '7768501', null, '1', '1', '1', '1', '3', '498-duke-dumont-@-cabaret-voltaire-in-edinburgh-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('499', null, '13046', 'Tiga @ Matthew Dear DJ at Verboten  in New York, NY', '2014-04-26 19:00:00', '2', '2014-04-07 06:00:42', '7880118', null, '1', '1', '1', '1', '3', '499-tiga-@-matthew-dear-dj-at-verboten-in-new-york-ny', '', '1');
INSERT INTO `gig` VALUES ('500', null, '13048', 'Tiga @ Audion Live at Oval Space  in London, United Kingdom', '2014-05-04 22:00:00', '2', '2014-04-07 06:00:42', '7889540', null, '1', '1', '1', '1', '3', '500-tiga-@-audion-live-at-oval-space-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('501', null, '13006', 'Klaxons @ Dour Festival in Dour, Belgium', '2014-07-18 19:00:00', '2', '2014-04-07 06:00:38', '7556462', null, '1', '1', '1', '1', '3', '501-klaxons-@-dour-festival-in-dour-belgium', '', '1');
INSERT INTO `gig` VALUES ('505', null, '13117', 'Noir @ DGTL Festival in Amsterdam, Netherlands', '2014-04-19 23:00:00', '2', '2014-04-07 06:00:56', '7510242', null, '1', '1', '1', '1', '3', '505-noir-@-dgtl-festival-in-amsterdam-netherlands', '', '1');
INSERT INTO `gig` VALUES ('506', null, '13118', 'Noir @ Noir Music @ Whoosah in Scheveningen, Netherlands', '2014-04-20 23:00:00', '2', '2014-04-07 06:00:56', '7590723', null, '1', '1', '1', '1', '3', '506-noir-@-noir-music-@-whoosah-in-scheveningen-netherlands', '', '1');
INSERT INTO `gig` VALUES ('507', null, '13120', 'Noir @ DITH15 @ Oval Space (Mixmag Live) in London, United Kingdom', '2014-05-02 23:00:00', '2', '2014-04-07 06:00:56', '7879101', null, '1', '1', '1', '1', '3', '507-noir-@-dith15-@-oval-space-(mixmag-live)-in-london-united-ki', '', '1');
INSERT INTO `gig` VALUES ('508', null, '13121', 'Noir @ DITH15 @ Sankeys in Manchester, United Kingdom', '2014-05-03 22:30:00', '2', '2014-04-07 06:00:56', '7879110', null, '1', '1', '1', '1', '3', '508-noir-@-dith15-@-sankeys-in-manchester-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('509', null, '13122', 'Noir @ DITH15 @ Sin in Dublin, Ireland', '2014-05-04 23:00:00', '2', '2014-04-07 06:00:56', '7879113', null, '1', '1', '1', '1', '3', '509-noir-@-dith15-@-sin-in-dublin-ireland', '', '1');
INSERT INTO `gig` VALUES ('510', null, '13123', 'Noir @ Indigo in Istanbul, Turkey', '2014-05-10 23:00:00', '2', '2014-04-07 06:00:56', '7848042', null, '1', '1', '1', '1', '3', '510-noir-@-indigo-in-istanbul-turkey', '', '1');
INSERT INTO `gig` VALUES ('511', null, '13124', 'Noir @ Extrema Festival in Houthalen, Belgium', '2014-06-07 23:00:00', '2', '2014-04-07 06:00:56', '7848097', null, '1', '1', '1', '1', '3', '511-noir-@-extrema-festival-in-houthalen-belgium', '', '1');
INSERT INTO `gig` VALUES ('512', null, '13125', 'Noir @ Found Festival in London, United Kingdom', '2014-06-14 23:00:00', '2', '2014-04-07 06:00:56', '7848110', null, '1', '1', '1', '1', '3', '512-noir-@-found-festival-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('513', null, '13126', 'Noir @ Wilde @ The Apartment in Barcelona, Spain', '2014-06-14 23:00:00', '2', '2014-04-07 06:00:56', '7848116', null, '1', '1', '1', '1', '3', '513-noir-@-wilde-@-the-apartment-in-barcelona-spain', '', '1');
INSERT INTO `gig` VALUES ('514', null, '13127', 'Noir @ Wilde @ Rooftop in Bucharest, Romania', '2014-06-21 23:00:00', '2', '2014-04-07 06:00:56', '7848137', null, '1', '1', '1', '1', '3', '514-noir-@-wilde-@-rooftop-in-bucharest-romania', '', '1');
INSERT INTO `gig` VALUES ('515', null, '13128', 'Noir @ Awekenings Festival in Amsterdam, Netherlands', '2014-06-28 23:00:00', '2', '2014-04-07 06:00:56', '7848141', null, '1', '1', '1', '1', '3', '515-noir-@-awekenings-festival-in-amsterdam-netherlands', '', '1');
INSERT INTO `gig` VALUES ('521', null, '13129', 'Nina Kraviz @ Snowbombing in Mayrhofen, Austria', '2014-04-09 23:00:00', '2', '2014-04-07 06:00:58', '7437888', null, '1', '1', '1', '1', '3', '521-nina-kraviz-@-snowbombing-in-mayrhofen-austria', '', '1');
INSERT INTO `gig` VALUES ('522', null, '13130', 'Nina Kraviz @ Output in New York, NY', '2014-04-10 22:00:00', '2', '2014-04-07 06:00:58', '7894781', null, '1', '1', '1', '1', '3', '522-nina-kraviz-@-output-in-new-york-ny', '', '1');
INSERT INTO `gig` VALUES ('523', null, '13131', 'Nina Kraviz @ Coachella  in California, VA', '2014-04-11 19:00:00', '2', '2014-04-07 06:00:58', '7659051', null, '1', '1', '1', '1', '3', '523-nina-kraviz-@-coachella-in-california-va', '', '1');
INSERT INTO `gig` VALUES ('524', null, '13134', 'Nina Kraviz @ Harlot in San Francisco, CA', '2014-04-19 22:00:00', '2', '2014-04-07 06:00:58', '7822366', null, '1', '1', '1', '1', '3', '524-nina-kraviz-@-harlot-in-san-francisco-ca', '', '1');
INSERT INTO `gig` VALUES ('525', null, '13135', 'Nina Kraviz @ Circus in Osaka-Shi, Japan', '2014-05-08 23:00:00', '2', '2014-04-07 06:00:58', '7831690', null, '1', '1', '1', '1', '3', '525-nina-kraviz-@-circus-in-osaka-shi-japan', '', '1');
INSERT INTO `gig` VALUES ('526', null, '13136', 'Nina Kraviz @ Mago in Nagoya, Japan', '2014-05-09 23:00:00', '2', '2014-04-07 06:00:58', '7831692', null, '1', '1', '1', '1', '3', '526-nina-kraviz-@-mago-in-nagoya-japan', '', '1');
INSERT INTO `gig` VALUES ('527', null, '13137', 'Nina Kraviz @ Womb in Tokyo, Japan', '2014-05-10 23:00:00', '2', '2014-04-07 06:00:58', '7831695', null, '1', '1', '1', '1', '3', '527-nina-kraviz-@-womb-in-tokyo-japan', '', '1');
INSERT INTO `gig` VALUES ('528', null, '13138', 'Nina Kraviz @ Robert Johnson in Offenbach, Germany', '2014-05-16 23:00:00', '2', '2014-04-07 06:00:58', '7766352', null, '1', '1', '1', '1', '3', '528-nina-kraviz-@-robert-johnson-in-offenbach-germany', '', '1');
INSERT INTO `gig` VALUES ('529', null, '13139', 'Nina Kraviz @ Red Bull Music Academy in Hamburg, Germany', '2014-05-17 19:00:00', '2', '2014-04-07 06:00:58', '7766408', null, '1', '1', '1', '1', '3', '529-nina-kraviz-@-red-bull-music-academy-in-hamburg-germany', '', '1');
INSERT INTO `gig` VALUES ('530', null, '13140', 'Nina Kraviz @ LIFE FESTIVAL in Dublin, Ireland', '2014-05-23 23:00:00', '2', '2014-04-07 06:00:58', '7766364', null, '1', '1', '1', '1', '3', '530-nina-kraviz-@-life-festival-in-dublin-ireland', '', '1');
INSERT INTO `gig` VALUES ('531', null, '13141', 'Nina Kraviz @ Loves Saves The Day in Bristol, United Kingdom', '2014-05-24 19:00:00', '2', '2014-04-07 06:00:58', '7766366', null, '1', '1', '1', '1', '3', '531-nina-kraviz-@-loves-saves-the-day-in-bristol-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('532', null, '13143', 'Nina Kraviz @ LA SUCRIERE in Lyon, France', '2014-05-29 14:30:00', '2', '2014-04-07 06:00:58', '7642048', null, '1', '1', '1', '1', '3', '532-nina-kraviz-@-la-sucriere-in-lyon-france', '', '1');
INSERT INTO `gig` VALUES ('533', null, '13055', 'Trentemøller @ Sonár by day in Barcelona, Spain', '2014-06-13 14:00:00', '2', '2014-04-07 06:00:45', '7897279', null, '1', '1', '1', '1', '3', '533-trentem-ller-@-son-r-by-day-in-barcelona-spain', '', '1');
INSERT INTO `gig` VALUES ('534', null, '13197', 'D-Cottbus - Laut gegen Nazis Campus Open Air', '2014-05-21 00:00:00', '2', '2014-04-07 07:02:22', '708862089165064', null, '1', '1', '1', '1', '1', '534-d-cottbus-laut-gegen-nazis-campus-open-air', null, '1');
INSERT INTO `gig` VALUES ('537', null, '12967', 'Duke Dumont @ Wollaton Park in Nottingham, United Kingdom', '2014-06-07 13:00:00', '2', '2014-04-07 06:00:35', '7716663', null, '1', '1', '1', '1', '3', '537-duke-dumont-@-wollaton-park-in-nottingham-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('538', null, '12970', 'Disclosure @ Club Nokia in Los Angeles, CA', '2014-04-10 21:00:00', '2', '2014-04-07 06:00:37', '7900521', null, '1', '1', '1', '1', '3', '538-disclosure-@-club-nokia-in-los-angeles-ca', '', '1');
INSERT INTO `gig` VALUES ('539', null, '13044', 'Tiga @ Coachella in Indio, CA', '2014-04-12 19:00:00', '2', '2014-04-07 06:00:42', '7534159', null, '1', '1', '1', '1', '3', '539-tiga-@-coachella-in-indio-ca', '', '1');
INSERT INTO `gig` VALUES ('540', null, '13045', 'Tiga @ Coachella in Indio, CA', '2014-04-19 19:00:00', '2', '2014-04-07 06:00:42', '7534162', null, '1', '1', '1', '1', '3', '540-tiga-@-coachella-in-indio-ca', '', '1');
INSERT INTO `gig` VALUES ('541', null, '13060', 'Trentemøller @ Colours of Ostrava Festival in Ostrava, Czech Republic', '2014-07-18 23:00:00', '2', '2014-04-07 06:00:45', '7782187', null, '1', '1', '1', '1', '3', '541-trentem-ller-@-colours-of-ostrava-festival-in-ostrava-czech-', '', '1');
INSERT INTO `gig` VALUES ('542', null, '13199', 'Maceo Plex @ Lacuna Artist Lofts in Chicago, IL', '2014-04-13 19:00:00', '2', '2014-04-08 06:00:03', '7921182', null, '1', '1', '1', '1', '3', '542-maceo-plex-@-lacuna-artist-lofts-in-chicago-il', '', '1');
INSERT INTO `gig` VALUES ('543', null, '12927', 'Soul Clap @ BETHEL WOODS in Bethel, NY', '2014-05-23 12:00:00', '2', '2014-04-07 06:00:29', '7843932', null, '1', '1', '1', '1', '3', '543-justin-martin-@-bethel-woods-in-bethel-ny', '', '1');
INSERT INTO `gig` VALUES ('544', null, '12911', 'Hot Since 82 @ SPACE in Miami, FL', '2014-04-12 23:00:00', '2', '2014-04-07 06:00:27', '7744585', null, '1', '1', '1', '1', '3', '544-hot-since-82-@-space-in-miami-fl', '', '1');
INSERT INTO `gig` VALUES ('546', null, '12944', 'DJ Harvey @ Bleu in Detroit, MI', '2014-05-23 21:00:00', '2', '2014-04-07 06:00:31', '7918240', null, '1', '1', '1', '1', '3', '546-dj-harvey-@-bleu-in-detroit-mi', '', '1');
INSERT INTO `gig` VALUES ('547', null, '13010', 'Klaxons @ Jersey Live in Jersey, United Kingdom', '2014-08-30 11:00:00', '2', '2014-04-07 06:00:38', '7922613', null, '1', '1', '1', '1', '3', '547-klaxons-@-jersey-live-in-jersey-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('548', null, '13051', 'Guy J @ Verboten in Brooklyn, NY', '2014-04-25 22:00:00', '2', '2014-04-07 06:00:44', '7920528', null, '1', '1', '1', '1', '3', '548-guy-j-@-verboten-in-brooklyn-ny', '', '1');
INSERT INTO `gig` VALUES ('549', '12', '11017', 'Soul Clap', '2014-05-27 00:00:00', '1', '2014-04-01 00:02:19', null, null, '3', '1', '6', '5', '0', '549-soul-clap', 'Hey, Soul Clap come and play!', '1');
INSERT INTO `gig` VALUES ('550', null, '13190', 'CH-Bern - Gurten Festival', '2014-07-18 00:00:00', '2', '2014-04-07 07:02:15', '1476076715940191', null, '1', '1', '1', '1', '1', '550-ch-bern-gurten-festival', null, '1');
INSERT INTO `gig` VALUES ('552', null, '12953', 'Todd Terje @ Le Fort de Saint Père in St Pere, France', '2014-08-16 18:00:00', '2', '2014-04-07 06:00:32', '7927715', null, '1', '1', '1', '1', '3', '552-todd-terje-@-le-fort-de-saint-p-re-in-st-pere-france', '', '1');
INSERT INTO `gig` VALUES ('554', null, '13040', 'Boys Noize @ Mysteryland in Haarlemmermeer, Netherlands', '2014-08-23 19:00:00', '2', '2014-04-07 06:00:41', '7924042', null, '1', '1', '1', '1', '3', '554-boys-noize-@-mysteryland-in-haarlemmermeer-netherlands', '', '1');
INSERT INTO `gig` VALUES ('555', null, '13062', 'Marc Romboy @ MS Rheinenergie in Dusseldorf, Germany', '2014-05-18 19:00:00', '2', '2014-04-07 06:00:47', '7922872', null, '1', '1', '1', '1', '3', '555-marc-romboy-@-ms-rheinenergie-in-dusseldorf-germany', '', '1');
INSERT INTO `gig` VALUES ('556', null, '13119', 'Noir @ COMMA@Blender in Sofia, Bulgaria', '2014-04-25 23:00:00', '2', '2014-04-07 06:00:56', '7927495', null, '1', '1', '1', '1', '3', '556-noir-@-comma@blender-in-sofia-bulgaria', '', '1');
INSERT INTO `gig` VALUES ('557', null, '13163', 'Hot Since 82 @ Life Festival, Dublin, Ireland', '2014-05-23 00:00:00', '2', '2014-04-07 07:00:43', '285085388336513', null, '1', '1', '1', '1', '1', '557-hot-since-82-@-life-festival-dublin-ireland', null, '1');
INSERT INTO `gig` VALUES ('558', null, '13164', 'Hot Since 82 @ Sankeys, Ibiza', '2014-05-22 00:00:00', '2', '2014-04-07 07:00:44', '812916382070197', null, '1', '1', '1', '1', '1', '558-hot-since-82-@-sankeys-ibiza', null, '1');
INSERT INTO `gig` VALUES ('559', null, '13168', 'Hot Since 82 @ El Row, Barcelona, Spain', '2014-05-11 00:00:00', '2', '2014-04-07 07:00:51', '456884584445080', null, '1', '1', '1', '1', '1', '559-hot-since-82-@-el-row-barcelona-spain', null, '1');
INSERT INTO `gig` VALUES ('560', null, '13169', 'Hot Since 82 @ Rainbow Warehouse, Birmingham, UK', '2014-05-04 00:00:00', '2', '2014-04-07 07:00:54', '624761237612260', null, '1', '1', '1', '1', '1', '560-hot-since-82-@-rainbow-warehouse-birmingham-uk', null, '1');
INSERT INTO `gig` VALUES ('561', null, '13170', 'Hot Since 82 @ Zenith, Montpellier, France', '2014-05-03 00:00:00', '2', '2014-04-07 07:00:55', '1398394397101043', null, '1', '1', '1', '1', '1', '561-hot-since-82-@-zenith-montpellier-france', null, '1');
INSERT INTO `gig` VALUES ('562', null, '13171', 'Hot Since 82 @ Industria, Porto, Portugal', '2014-05-02 00:00:00', '2', '2014-04-07 07:00:56', '137036076467127', null, '1', '1', '1', '1', '1', '562-hot-since-82-@-industria-porto-portugal', null, '1');
INSERT INTO `gig` VALUES ('563', null, '13172', 'Hot Since 82 @ Teknicolor, Mint Club, Leeds, UK', '2014-05-01 00:00:00', '2', '2014-04-07 07:00:57', '727989303898745', null, '1', '1', '1', '1', '1', '563-hot-since-82-@-teknicolor-mint-club-leeds-uk', null, '1');
INSERT INTO `gig` VALUES ('564', null, '13173', 'Hot Since 82 @ Social Club, Paris, France', '2014-04-30 00:00:00', '2', '2014-04-07 07:00:58', '773726542640563', null, '1', '1', '1', '1', '1', '564-hot-since-82-@-social-club-paris-france', null, '1');
INSERT INTO `gig` VALUES ('565', null, '13174', 'Hot Since 82 @ Replay Festival, Herentals, Belgium', '2014-04-26 00:00:00', '2', '2014-04-07 07:00:59', '518664711593299', null, '1', '1', '1', '1', '1', '565-hot-since-82-@-replay-festival-herentals-belgium', null, '1');
INSERT INTO `gig` VALUES ('566', null, '13175', 'Hot Since 82 @ Zimmer, Mannheim, Germany', '2014-04-25 00:00:00', '2', '2014-04-07 07:01:00', '1393999724210325', null, '1', '1', '1', '1', '1', '566-hot-since-82-@-zimmer-mannheim-germany', null, '1');
INSERT INTO `gig` VALUES ('567', null, '13176', 'Hot Since 82 @ Ministerium, Lisbon, Portugal', '2014-04-24 00:00:00', '2', '2014-04-07 07:01:02', '623899134362502', null, '1', '1', '1', '1', '1', '567-hot-since-82-@-ministerium-lisbon-portugal', null, '1');
INSERT INTO `gig` VALUES ('568', '4', '11365', 'Disclosure', '2014-04-17 00:00:00', '1', '2014-04-02 15:45:04', null, null, '1', '1', '1', '1', '0', '568-disclosure', '', '1');
INSERT INTO `gig` VALUES ('569', null, '13165', 'Hot Since 82 @ Mandarine Tent, Buenos Aires, Argentina', '2014-05-16 00:00:00', '2', '2014-04-07 07:00:47', '596976650380795', null, '1', '1', '1', '1', '1', '569-hot-since-82-@-crobar-buenos-aires-argentina', null, '1');
INSERT INTO `gig` VALUES ('570', null, '13166', 'Hot Since 82 @ In-Vitro, Cordaba, Argentina', '2014-05-15 00:00:00', '2', '2014-04-07 07:00:48', '450478715085066', null, '1', '1', '1', '1', '1', '570-hot-since-82-@-in-vitro-cordaba-argentina', null, '1');
INSERT INTO `gig` VALUES ('571', null, '13167', 'Hot Since 82 @ EX-OZ, Santiago, Chile', '2014-05-14 00:00:00', '2', '2014-04-07 07:00:49', '752239431482508', null, '1', '1', '1', '1', '1', '571-hot-since-82-@-casona-santos-dumont-santiago-chile', null, '1');
INSERT INTO `gig` VALUES ('572', null, '12925', 'Soul Clap @ Lonely C at OUTPUT in Brooklyn, NY', '2014-05-17 22:00:00', '2', '2014-04-07 06:00:29', '7936986', null, '1', '1', '1', '1', '3', '572-soul-clap-@-lonely-c-at-output-in-brooklyn-ny', '', '1');
INSERT INTO `gig` VALUES ('573', null, '13012', 'Dusky @ East Village Arts Club in Liverpool, United Kingdom', '2014-05-30 22:00:00', '2', '2014-04-07 06:00:40', '7940419', null, '1', '1', '1', '1', '3', '573-dusky-@-east-village-arts-club-in-liverpool-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('574', null, '13096', 'Timo Maas @ Level 2 Lounge in Dysart, Canada', '2014-04-26 22:00:00', '2', '2014-04-07 06:00:53', '7944329', null, '1', '1', '1', '1', '3', '574-timo-maas-@-level-2-lounge-in-dysart-canada', '', '1');
INSERT INTO `gig` VALUES ('575', null, '13097', 'Timo Maas @ Discolo in Barranquilla, Colombia', '2014-04-30 22:00:00', '2', '2014-04-07 06:00:53', '7942874', null, '1', '1', '1', '1', '3', '575-timo-maas-@-discolo-in-barranquilla-colombia', '', '1');
INSERT INTO `gig` VALUES ('576', null, '13099', 'Timo Maas @ Vinyl in Denver, CO', '2014-05-03 22:00:00', '2', '2014-04-07 06:00:53', '7942349', null, '1', '1', '1', '1', '3', '576-timo-maas-@-vinyl-in-denver-co', '', '1');
INSERT INTO `gig` VALUES ('577', null, '13100', 'Timo Maas @ HABITAT in Montreal, Canada', '2014-05-09 22:00:00', '2', '2014-04-07 06:00:53', '7942025', null, '1', '1', '1', '1', '3', '577-timo-maas-@-habitat-in-montreal-canada', '', '1');
INSERT INTO `gig` VALUES ('578', null, '13103', 'Timo Maas @ Forsage Club in Kiev, Ukraine', '2014-05-17 22:00:00', '2', '2014-04-07 06:00:53', '7944498', null, '1', '1', '1', '1', '3', '578-timo-maas-@-forsage-club-in-kiev-ukraine', '', '1');
INSERT INTO `gig` VALUES ('579', null, '13133', 'Nina Kraviz @ Coachella  in California, VA', '2014-04-18 19:00:00', '2', '2014-04-07 06:00:58', '7940717', null, '1', '1', '1', '1', '3', '579-nina-kraviz-@-coachella-in-california-va', '', '1');
INSERT INTO `gig` VALUES ('580', null, '13095', 'Timo Maas @ Shine Nightclub in Ottawa, Canada', '2014-04-25 22:00:00', '2', '2014-04-07 06:00:53', '7945418', null, '1', '1', '1', '1', '3', '580-timo-maas-@-shine-nightclub-in-ottawa-canada', '', '1');
INSERT INTO `gig` VALUES ('582', null, '13152', 'TREIBSTOFF KLUB mit KOLLEKTIV TURMSTRASSE // MUSIK GEWINNT FREUNDE', '2014-05-29 01:45:00', '2', '2014-04-07 07:00:20', '274312736069279', null, '1', '1', '1', '1', '1', '582-treibstoff-klub-mit-kollektiv-turmstrasse-musik-gewinnt-freu', null, '1');
INSERT INTO `gig` VALUES ('583', null, '12920', 'Soul Clap @ Studio 333 in London, United Kingdom', '2014-04-20 22:00:00', '2', '2014-04-07 06:00:28', '7947756', null, '1', '1', '1', '1', '3', '583-soul-clap-@-studio-333-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('584', null, '12922', 'Soul Clap @ Bardot in Miami, FL', '2014-05-01 22:00:00', '2', '2014-04-07 06:00:29', '7947759', null, '1', '1', '1', '1', '3', '584-soul-clap-@-bardot-in-miami-fl', '', '1');
INSERT INTO `gig` VALUES ('585', null, '12926', 'Soul Clap @ Piknik Electronik in Montreal, Canada', '2014-05-18 22:00:00', '2', '2014-04-07 06:00:29', '7775659', null, '1', '1', '1', '1', '3', '585-soul-clap-@-piknik-electronik-in-montreal-canada', '', '1');
INSERT INTO `gig` VALUES ('586', null, '12930', 'Soul Clap @ VIA DELLE SPEZIE in Reggio Nell\'emilia Reggio Nell\'emilia, Italy', '2014-06-21 22:00:00', '2', '2014-04-07 06:00:29', '7947532', null, '1', '1', '1', '1', '3', '586-soul-clap-@-via-delle-spezie-in-reggio-nell-emilia-reggio-ne', '', '1');
INSERT INTO `gig` VALUES ('587', null, '12931', 'Soul Clap @ Electric Forest in Rothbury, MI', '2014-06-28 22:00:00', '2', '2014-04-07 06:00:29', '7729407', null, '1', '1', '1', '1', '3', '587-soul-clap-@-electric-forest-in-rothbury-mi', '', '1');
INSERT INTO `gig` VALUES ('588', null, '12946', 'DJ Harvey @ The London Wonderground in London, United Kingdom', '2014-06-19 19:00:00', '2', '2014-04-07 06:00:31', '7949375', null, '1', '1', '1', '1', '3', '588-dj-harvey-@-the-london-wonderground-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('589', null, '13132', 'Nina Kraviz @ Sound Nightclub in Los Angeles, CA', '2014-04-17 21:30:00', '2', '2014-04-07 06:00:58', '7949633', null, '1', '1', '1', '1', '3', '589-nina-kraviz-@-sound-nightclub-in-los-angeles-ca', '', '1');
INSERT INTO `gig` VALUES ('590', null, '13203', 'Maceo Plex @ Montreux Jazz Lab in Montreux, Switzerland', '2014-07-11 21:30:00', '2', '2014-04-08 06:00:03', '7955619', null, '1', '1', '1', '1', '3', '590-maceo-plex-@-montreux-jazz-lab-in-montreux-switzerland', '', '1');
INSERT INTO `gig` VALUES ('591', null, '12956', 'Duke Dumont @ SURFCOMBER HOTEL in Miami Beach, FL', '2014-04-13 12:00:00', '2', '2014-04-07 06:00:35', '7954264', null, '1', '1', '1', '1', '3', '591-duke-dumont-@-surfcomber-hotel-in-miami-beach-fl', '', '1');
INSERT INTO `gig` VALUES ('592', null, '12958', 'Duke Dumont @ Pacific Coliseum in Vancouver, Canada', '2014-04-19 19:00:00', '2', '2014-04-07 06:00:35', '7687060', null, '1', '1', '1', '1', '3', '592-duke-dumont-@-pacific-coliseum-in-vancouver-canada', '', '1');
INSERT INTO `gig` VALUES ('593', null, '12962', 'Duke Dumont @ The Arches in Glasgow, United Kingdom', '2014-05-03 19:30:00', '2', '2014-04-07 06:00:35', '7652574', null, '1', '1', '1', '1', '3', '593-duke-dumont-@-the-arches-in-glasgow-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('594', null, '12964', 'Duke Dumont @ East Village Arts Club in Liverpool, United Kingdom', '2014-05-17 19:30:00', '2', '2014-04-07 06:00:35', '7812929', null, '1', '1', '1', '1', '3', '594-duke-dumont-@-east-village-arts-club-in-liverpool-united-kin', '', '1');
INSERT INTO `gig` VALUES ('595', null, '12966', 'Duke Dumont @ London XOYO in London, United Kingdom', '2014-05-30 21:00:00', '2', '2014-04-07 06:00:35', '7955566', null, '1', '1', '1', '1', '3', '595-duke-dumont-@-london-xoyo-in-london-united-kingdom', '', '1');
INSERT INTO `gig` VALUES ('596', null, '12984', 'Disclosure @ Eatons Hill Hotel in Brisbane, Australia', '2014-05-08 19:30:00', '2', '2014-04-07 06:00:37', '7955576', null, '1', '1', '1', '1', '3', '596-disclosure-@-eatons-hill-hotel-in-brisbane-australia', '', '1');
INSERT INTO `gig` VALUES ('597', null, '13063', 'King Krule @ The Atomic Café in Munich, Germany', '2014-04-08 21:00:00', '2', '2014-04-07 06:00:48', '7955675', null, '1', '1', '1', '1', '3', '597-king-krule-@-the-atomic-caf-in-munich-germany', '', '1');
INSERT INTO `gig` VALUES ('598', null, '13064', 'King Krule @ Heimathafen Neukoelln in Berlin, Germany', '2014-04-09 21:00:00', '2', '2014-04-07 06:00:48', '7955676', null, '1', '1', '1', '1', '3', '598-king-krule-@-heimathafen-neukoelln-in-berlin-germany', '', '1');
INSERT INTO `gig` VALUES ('599', null, '13079', 'Ellen Allien @ Troffler in Rotterdam, Netherlands', '2014-05-09 19:00:00', '2', '2014-04-07 06:00:50', '7956499', null, '1', '1', '1', '1', '3', '599-ellen-allien-@-troffler-in-rotterdam-netherlands', '', '1');
INSERT INTO `gig` VALUES ('600', null, '13080', 'Ellen Allien @ Special Case Daytime Rooftop @ Moskva City Restaurant Terrace in Saint Petersburg, Russian Federation', '2014-05-10 19:00:00', '2', '2014-04-07 06:00:50', '7956501', null, '1', '1', '1', '1', '3', '600-ellen-allien-@-special-case-daytime-rooftop-@-moskva-city-re', '', '1');
INSERT INTO `gig` VALUES ('601', null, '13081', 'Ellen Allien @ Emirates Golf Club Dubai in Dubai, United Arab Emirates', '2014-05-16 19:00:00', '2', '2014-04-07 06:00:50', '7956506', null, '1', '1', '1', '1', '3', '601-ellen-allien-@-emirates-golf-club-dubai-in-dubai-united-arab', '', '1');
INSERT INTO `gig` VALUES ('602', null, '13082', 'Ellen Allien @ Douala in Ravensburg, Germany', '2014-05-24 19:00:00', '2', '2014-04-07 06:00:50', '7956512', null, '1', '1', '1', '1', '3', '602-ellen-allien-@-douala-in-ravensburg-germany', '', '1');
INSERT INTO `gig` VALUES ('603', null, '13084', 'Ellen Allien @ Opening Circoloco @ DC10 in Ibiza, Spain', '2014-05-26 19:00:00', '2', '2014-04-07 06:00:50', '7956516', null, '1', '1', '1', '1', '3', '603-ellen-allien-@-opening-circoloco-@-dc10-in-ibiza-spain', '', '1');
INSERT INTO `gig` VALUES ('604', null, '13085', 'Ellen Allien @ Klangkino in Gebesee, Germany', '2014-05-29 19:00:00', '2', '2014-04-07 06:00:50', '7585515', null, '1', '1', '1', '1', '3', '604-ellen-allien-@-klangkino-in-gebesee-germany', '', '1');
INSERT INTO `gig` VALUES ('605', null, '13087', 'Ellen Allien @ Traumschiff in Chiemsee, Germany', '2014-05-31 19:00:00', '2', '2014-04-07 06:00:50', '7956519', null, '1', '1', '1', '1', '3', '605-ellen-allien-@-traumschiff-in-chiemsee-germany', '', '1');
INSERT INTO `gig` VALUES ('606', null, '13088', 'Ellen Allien @ Lehman in Stuttgart, Germany', '2014-05-31 19:00:00', '2', '2014-04-07 06:00:50', '7956522', null, '1', '1', '1', '1', '3', '606-ellen-allien-@-lehman-in-stuttgart-germany', '', '1');

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
  KEY `fk_gig_file_gig_id` (`gig_id`) USING BTREE,
  KEY `fk_gig_file_file_id` (`file_id`) USING BTREE,
  CONSTRAINT `gig_file_ibfk_1` FOREIGN KEY (`gig_id`) REFERENCES `gig` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gig_file_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `alias` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_promoter_user_id` (`user_id`) USING BTREE,
  CONSTRAINT `promoter_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of promoter
-- ----------------------------
INSERT INTO `promoter` VALUES ('4', '4', 'Admin', 'Admin', '2014-04-02 15:39:21', '47.447830', '6.294922', '500000', '0', '4-admin');
INSERT INTO `promoter` VALUES ('10', '12', 'MUZA', 'We gonna have party!', '2014-01-30 05:04:37', '53.898384', '27.602406', '564889', '225841540761001', '10-muza');
INSERT INTO `promoter` VALUES ('12', '14', 'Guru', 'Rostov is in the groove!', '2014-01-21 02:22:40', '47.233299', '39.700001', '843031', '0', '12-guru');
INSERT INTO `promoter` VALUES ('13', '15', 'Loveis', 'St.P', '2014-01-21 02:07:54', '53.900002', '27.566700', '1000', '0', '13-loveis');
INSERT INTO `promoter` VALUES ('14', '16', 'Dania', 'Dania From Dubai', '2014-01-21 02:04:07', '25.200001', '55.299999', '1000', '0', '14-dania');
INSERT INTO `promoter` VALUES ('15', '17', 'Max Starscev', 'Hooligan in Minsk!', '2014-01-21 02:01:50', '53.900002', '27.566700', '1000', '0', '15-max-starscev');
INSERT INTO `promoter` VALUES ('16', '18', 'Kirrill Mad', 'Minsk Hard Bass Scene!', '2014-01-21 02:14:19', '53.900002', '27.566700', null, '0', '16-kirrill-mad');
INSERT INTO `promoter` VALUES ('17', '19', 'Asolya', 'Warsaw is in the groove!', '2014-03-18 18:09:07', '52.233299', '21.016701', '1000', '0', '17-asolya');
INSERT INTO `promoter` VALUES ('18', '20', 'Rogga', 'House is Deep!', '2014-01-21 01:52:45', '53.900002', '27.566700', '1000', '0', '18-rogga');
INSERT INTO `promoter` VALUES ('19', '21', 'Mihas', 'Party Started!', '2014-01-21 01:57:56', '53.900002', '27.566700', '1000', '0', '19-mihas');
INSERT INTO `promoter` VALUES ('20', '22', 'Mike Bufton', 'Dubai never sleeps!', '2014-01-19 08:29:35', null, null, null, '0', '20-mike-bufton');
INSERT INTO `promoter` VALUES ('21', '23', 'Infusion', 'We are Infusion!', '2014-03-18 18:13:42', null, null, null, '0', '21-infusion');

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
  KEY `fk_promoter_file_promoter_id` (`promoter_id`) USING BTREE,
  KEY `fk_promoter_file_file_id` (`file_id`) USING BTREE,
  CONSTRAINT `promoter_file_ibfk_1` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `promoter_file_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of promoter_file
-- ----------------------------
INSERT INTO `promoter_file` VALUES ('2', '4', '4', '2014-02-07 02:14:15');
INSERT INTO `promoter_file` VALUES ('3', '4', '3', '2014-02-07 02:21:02');
INSERT INTO `promoter_file` VALUES ('4', '17', '5', '2014-03-18 18:09:07');
INSERT INTO `promoter_file` VALUES ('5', '21', '6', '2014-03-18 18:13:42');
INSERT INTO `promoter_file` VALUES ('6', '4', '7', '2014-03-25 23:11:28');

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
  KEY `fk_promoter_promoter_id` (`promoter_id`) USING BTREE,
  KEY `fk_promoter_follow_id` (`follow_id`) USING BTREE,
  CONSTRAINT `promoter_promoter_ibfk_1` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `promoter_promoter_ibfk_2` FOREIGN KEY (`promoter_id`) REFERENCES `promoter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of promoter_promoter
-- ----------------------------
INSERT INTO `promoter_promoter` VALUES ('1', '4', '10', '2014-03-13 15:17:59');
INSERT INTO `promoter_promoter` VALUES ('2', '4', '13', '2014-03-13 15:18:01');
INSERT INTO `promoter_promoter` VALUES ('3', '10', '17', '2014-03-31 23:56:53');
INSERT INTO `promoter_promoter` VALUES ('4', '10', '13', '2014-03-31 23:57:01');

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
INSERT INTO `tbl_migration` VALUES ('m131015_091036_artist_table', '1391613851');
INSERT INTO `tbl_migration` VALUES ('m131015_091048_country_table', '1391613851');
INSERT INTO `tbl_migration` VALUES ('m131015_091051_gig_table', '1391613852');
INSERT INTO `tbl_migration` VALUES ('m131015_091100_user_table', '1391613852');
INSERT INTO `tbl_migration` VALUES ('m131015_091122_promoter_table', '1391613852');
INSERT INTO `tbl_migration` VALUES ('m131015_091143_venue_table', '1391613852');
INSERT INTO `tbl_migration` VALUES ('m131015_091231_country_data', '1391613852');
INSERT INTO `tbl_migration` VALUES ('m131015_110952_file_table', '1391613852');
INSERT INTO `tbl_migration` VALUES ('m131015_111251_artist_file', '1391613852');
INSERT INTO `tbl_migration` VALUES ('m131015_111301_promoter_file', '1391613852');
INSERT INTO `tbl_migration` VALUES ('m131015_140852_add_gig_status', '1391613853');
INSERT INTO `tbl_migration` VALUES ('m131015_195439_add_gig_venue_fk', '1391613853');
INSERT INTO `tbl_migration` VALUES ('m131015_200426_add_gig_user_id', '1391613853');
INSERT INTO `tbl_migration` VALUES ('m131015_200708_add_gig_user_fk', '1391613853');
INSERT INTO `tbl_migration` VALUES ('m131017_155226_venue_file', '1391613853');
INSERT INTO `tbl_migration` VALUES ('m131017_162014_gig_file', '1391613853');
INSERT INTO `tbl_migration` VALUES ('m131018_135756_update_password_length', '1391613853');
INSERT INTO `tbl_migration` VALUES ('m131021_204818_add_user_email_uk', '1391613854');
INSERT INTO `tbl_migration` VALUES ('m131022_202014_add_artist_gig_relation', '1391613854');
INSERT INTO `tbl_migration` VALUES ('m131107_100812_artist_coords', '1391613854');
INSERT INTO `tbl_migration` VALUES ('m131118_200550_subscription_table', '1391613854');
INSERT INTO `tbl_migration` VALUES ('m131118_223258_promoter_coords', '1391613854');
INSERT INTO `tbl_migration` VALUES ('m131201_100140_add_artist_fbid', '1391613855');
INSERT INTO `tbl_migration` VALUES ('m131201_165120_add_promoter_fbid', '1391613855');
INSERT INTO `tbl_migration` VALUES ('m131203_123520_add_artist_ids', '1391613855');
INSERT INTO `tbl_migration` VALUES ('m131230_123520_gig_ds_id', '1391613855');
INSERT INTO `tbl_migration` VALUES ('m131230_123720_venue_ds_id', '1391613855');
INSERT INTO `tbl_migration` VALUES ('m140104_222841_fix_gig_user_id', '1391613856');
INSERT INTO `tbl_migration` VALUES ('m140104_235508_update_venue_rules', '1391613856');
INSERT INTO `tbl_migration` VALUES ('m140105_140143_additional_gig_fields', '1391613857');
INSERT INTO `tbl_migration` VALUES ('m140105_143937_add_ds_type', '1391613857');
INSERT INTO `tbl_migration` VALUES ('m140108_094708_update_venue_name', '1391613857');
INSERT INTO `tbl_migration` VALUES ('m140113_150316_promoter_promoter', '1391613857');
INSERT INTO `tbl_migration` VALUES ('m140114_111818_artist_promoter_table', '1391613857');
INSERT INTO `tbl_migration` VALUES ('m140115_115257_reset_password_hash', '1391613857');
INSERT INTO `tbl_migration` VALUES ('m140116_132652_add_aliases', '1391613858');
INSERT INTO `tbl_migration` VALUES ('m140118_122712_events', '1391613858');
INSERT INTO `tbl_migration` VALUES ('m140123_193919_gig_description', '1391613858');
INSERT INTO `tbl_migration` VALUES ('m140129_125840_change_event_type', '1391613858');
INSERT INTO `tbl_migration` VALUES ('m140129_134321_add_event_creator', '1391613858');
INSERT INTO `tbl_migration` VALUES ('m140129_140943_event_send_status', '1391613858');
INSERT INTO `tbl_migration` VALUES ('m140204_151751_artist_map_data_stored_proc', '1391613858');
INSERT INTO `tbl_migration` VALUES ('m140205_175448_add_artist_gig_uk', '1391623194');
INSERT INTO `tbl_migration` VALUES ('m140205_230431_fix_artist_gigs_ordering', '1391642078');
INSERT INTO `tbl_migration` VALUES ('m140212_142025_email_queue_fields', '1394709337');
INSERT INTO `tbl_migration` VALUES ('m140313_090944_add_gig_currency', '1394709337');
INSERT INTO `tbl_migration` VALUES ('m140324_193620_default_ds_type', '1395734798');
INSERT INTO `tbl_migration` VALUES ('m140326_092952_add_event_name_and_link', '1396268289');
INSERT INTO `tbl_migration` VALUES ('m140326_122257_remove_event_timestamp_update', '1396268289');
INSERT INTO `tbl_migration` VALUES ('m140328_194209_add_artist_user_id', '1396268289');
INSERT INTO `tbl_migration` VALUES ('m140329_131324_add_user_role', '1396268289');
INSERT INTO `tbl_migration` VALUES ('m140408_124510_remove_artist_email', '1396961189');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reset_hash` varchar(32) DEFAULT NULL,
  `reset_datetime` datetime DEFAULT NULL,
  `role` tinyint(2) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_user_email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('2', 'cron@starway.pro', '$2a$13$1sbfydxJFTO835M7S3Oeh.I6GU29.gJj6zFzyRMwWyTfPhWStGwLm', '2014-04-08 14:40:26', null, null, '1');
INSERT INTO `user` VALUES ('4', 'manti.by@gmail.com', '$2a$13$EwfmOvbVrTdvR3mCxDqNNelvjF0Jc5cJrFMXZzft/vixO.sLN.o0a', '2014-04-02 15:39:21', '1d3c7c2d6d80c64b68b70aadabc6dffe', '2014-02-13 15:16:33', '1');
INSERT INTO `user` VALUES ('7', 'justin@justinbaird.com', '$2a$13$oYcpd6NVqVAiOemfCizl9ua3wkmrsQ8zfg.fB2GRCAJdBVKWLLxoS', '2013-10-26 17:39:31', null, null, '1');
INSERT INTO `user` VALUES ('8', 'sunny.raeva@gmail.com', '$2a$13$1SvvLyYNseson761/mBzwO.VA0cJGlY37OihTJwO6D7ujgv0xySW.', '2013-11-26 20:35:45', null, null, '1');
INSERT INTO `user` VALUES ('12', 'djchantcharmant@gmail.com', '$2a$13$1sbfydxJFTO835M7S3Oeh.I6GU29.gJj6zFzyRMwWyTfPhWStGwLm', '2014-04-08 14:40:22', null, null, '1');
INSERT INTO `user` VALUES ('13', 'roman.gorbunov@i360accelerator.com', '$2a$13$MCeWeyMNUwM3IDAdWMbB2u2GzZ33n.57.9tQbisVpO4PK1rNZCgZK', '2013-12-02 03:46:54', null, null, '1');
INSERT INTO `user` VALUES ('14', 'dj_guru@mail.ru', '$2a$13$1sbfydxJFTO835M7S3Oeh.I6GU29.gJj6zFzyRMwWyTfPhWStGwLm', '2014-04-08 14:40:18', null, null, '1');
INSERT INTO `user` VALUES ('15', '9865883@gmail.com', '$2a$13$1sbfydxJFTO835M7S3Oeh.I6GU29.gJj6zFzyRMwWyTfPhWStGwLm', '2014-04-08 14:40:17', null, null, '1');
INSERT INTO `user` VALUES ('16', 'dania@electricdays.net', '$2a$13$oezHpwJo82rdMJzRtHsdQeBjtpsgjWSBzgAyTktAmLJ/D4C3OxGyu', '2014-01-21 02:04:07', null, null, '1');
INSERT INTO `user` VALUES ('17', 'startsev.max@gmail.com', '$2a$13$UEDCFmIALy3Avy0b7AC9..Zf40mOtr7C0JtL0DHZViKkVZZrXTDfK', '2014-01-21 02:01:50', null, null, '1');
INSERT INTO `user` VALUES ('18', 'mad_mouse@list.ru', '$2a$13$1sbfydxJFTO835M7S3Oeh.I6GU29.gJj6zFzyRMwWyTfPhWStGwLm', '2014-04-08 14:40:14', null, null, '1');
INSERT INTO `user` VALUES ('19', 'asolyashow@gmail.com', '$2a$13$1sbfydxJFTO835M7S3Oeh.I6GU29.gJj6zFzyRMwWyTfPhWStGwLm', '2014-04-08 14:40:13', null, null, '1');
INSERT INTO `user` VALUES ('20', 'rogga@gmail.com', '$2a$13$zQpSlPH293n67Wy01IVz7.wX4osYIbNLnm5637xKBh.bmwBFUdUze', '2014-01-21 01:52:45', null, null, '1');
INSERT INTO `user` VALUES ('21', 'djmihas@gmail.com', '$2a$13$1sbfydxJFTO835M7S3Oeh.I6GU29.gJj6zFzyRMwWyTfPhWStGwLm', '2014-04-08 14:40:15', null, null, '1');
INSERT INTO `user` VALUES ('22', 'info@audiotonic.net', '$2a$13$FrwC2PLhbB/CXPTucw7TtOaqxhU1gFeDe1lhS75o3yfZ1HCZc58iC', '2013-12-02 03:57:11', null, null, '1');
INSERT INTO `user` VALUES ('23', 'charlchaka@infusion.ae', '$2a$13$mXipanfrfNImAHDgiMTwK.1Q5g7yIv3Y4xn.4IZzO/ekoWUpUggkO', '2014-03-18 18:13:42', null, null, '1');
INSERT INTO `user` VALUES ('39', 'roman@wemade.biz', '$2a$13$MB4TlAZSD3evLhZf7b8XAO6RMppx0JeN7bxKvlb5Xr//WIgXkyj5K', '2013-12-07 18:21:23', null, null, '1');
INSERT INTO `user` VALUES ('40', 'info@starway.pro', '$2a$13$G/s/qXcARp14chCGw1q2gOp0EQTkwdtC70OBQ.cBQeExEQYWnSHLi', '2013-12-15 19:51:15', null, null, '1');
INSERT INTO `user` VALUES ('47', 'testpromoter@mail.ru', '$2a$13$CX/pg6zVTei6gw6HgqCLau7LuDN1/28ck1.p8wIfCPmlihvcoXrKa', '2014-01-09 16:58:52', null, null, '1');
INSERT INTO `user` VALUES ('48', 'ra_gee@tut.by', '$2a$13$lNtAJo0XifVuDIakVvucse53xDOmBbe7LTSF7T8fz6ywvlDFIy4TC', '2014-03-31 21:36:51', null, null, '2');
INSERT INTO `user` VALUES ('51', 'mail@borisbrejcha.de', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 14:42:58', null, null, '2');
INSERT INTO `user` VALUES ('52', 'davidaugustmusic@gmail.com ', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 14:43:00', null, null, '2');
INSERT INTO `user` VALUES ('53', 'djayharvey@gmail.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 14:46:53', null, null, '2');
INSERT INTO `user` VALUES ('54', 'dan@hardlivings.co.uk', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:42:14', null, null, '2');
INSERT INTO `user` VALUES ('55', 'davide@dustykid.it', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 14:47:32', null, null, '2');
INSERT INTO `user` VALUES ('56', 'info@diy-booking.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 14:48:00', null, null, '2');
INSERT INTO `user` VALUES ('57', 'jamesd@anglomanagement.co.uk', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 14:48:38', null, null, '2');
INSERT INTO `user` VALUES ('58', 'andrey@ivandorn.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 14:49:13', null, null, '2');
INSERT INTO `user` VALUES ('59', 'lou@freerangerecords.co.uk', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 14:49:31', null, null, '2');
INSERT INTO `user` VALUES ('60', 'sharen@sumimanagement.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 14:50:06', null, null, '2');
INSERT INTO `user` VALUES ('61', 'sophiamargerison@theagencygroup.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:26:30', null, null, '2');
INSERT INTO `user` VALUES ('62', 'ich@ronjaheidborn.de', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:26:57', null, null, '2');
INSERT INTO `user` VALUES ('63', 'dani@ellumaudio.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:27:26', null, null, '2');
INSERT INTO `user` VALUES ('64', 'miniloguebooking@outlook.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:28:10', null, null, '2');
INSERT INTO `user` VALUES ('65', 'alma@backroom-entertainment.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:28:47', null, null, '2');
INSERT INTO `user` VALUES ('66', 'x@clownandsunset.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:29:12', null, null, '2');
INSERT INTO `user` VALUES ('67', 'james@paramountartists.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:30:15', null, null, '2');
INSERT INTO `user` VALUES ('68', 'matt.jagger@colludedmanagement.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:30:59', null, null, '2');
INSERT INTO `user` VALUES ('69', 'bodycode@ghosty.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:31:40', null, null, '2');
INSERT INTO `user` VALUES ('70', 'sharron@mn2s.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:32:25', null, null, '2');
INSERT INTO `user` VALUES ('71', 'management@solomun.org', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:39:36', null, null, '2');
INSERT INTO `user` VALUES ('72', 'laetitia@decked-out.co.uk', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:40:04', null, null, '2');
INSERT INTO `user` VALUES ('73', 'ina@plantage13.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:40:32', null, null, '2');
INSERT INTO `user` VALUES ('74', 'patci@wilde-agency.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:41:01', null, null, '2');
INSERT INTO `user` VALUES ('77', 'toneofarc@gmail.com', '$2a$13$pAVWxzKLEDIuX1WqT1PVH.13txEvJA3V6lulo8.R6Mn408JSoF/fq', '2014-04-08 15:42:39', null, null, '2');

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
  `ds_type` tinyint(2) DEFAULT '0',
  `alias` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_venue_country_id` (`country_id`) USING BTREE,
  CONSTRAINT `venue_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13204 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of venue
-- ----------------------------
INSERT INTO `venue` VALUES ('717', 'Мон-кафе', 'http://mon-cafe.relax.by/', '21', 'Minsk', 'Rakaŭskaja vulica, ул. Мельникайте, 2-4', '53.906387', '27.542456', '2014-03-31 16:20:30', '22926705f17701db0a4505ae210a25faa6e79066', '2', '717');
INSERT INTO `venue` VALUES ('718', 'Zig Zag Café', null, '74', 'Paris', 'Boulevard Garibaldi, 58', '48.846169', '2.306843', '2014-03-31 16:20:30', '6097c85c07c29a2355fdead7f0479af4a2c6e582', '2', '718-zig-zag-caf-');
INSERT INTO `venue` VALUES ('719', 'I Boat', 'http://iboat.eu/main/', '74', 'Bordeaux', 'Quai Armand Lalande', '44.864826', '-0.557470', '2014-03-31 16:20:32', '791b6084f009b91e19bfdc5e1f4787b9e198976f', '2', '719-i-boat');
INSERT INTO `venue` VALUES ('11017', 'The Loft', 'http://www.minsknightlife.net/loft.htm', null, 'Минск', 'ул. Петруся Бровки, 22', null, null, '2014-04-01 00:02:19', 'eac0b10ee1b2fd1a850864db07418cfc011d6891', '2', '11017-the-loft');
INSERT INTO `venue` VALUES ('11365', 'The Loft', 'http://www.minsknightlife.net/loft.htm', null, 'Minsk', 'vulica Pietrusia Broŭki, 22', null, null, '2014-04-02 15:45:04', 'eac0b10ee1b2fd1a850864db07418cfc011d6891', '2', '11365-the-loft');
INSERT INTO `venue` VALUES ('12900', 'Lacuna Artist Lofts', null, '233', 'Chicago', 'Lacuna Artist Lofts', '41.849998', '-87.650002', '2014-04-07 06:00:23', '', '3', '12900-lacuna-artist-lofts');
INSERT INTO `venue` VALUES ('12901', 'Monarch Theatre', null, '233', 'Phoenix', 'Monarch Theatre', '33.448215', '-112.072166', '2014-04-07 06:00:23', '', '3', '12901-monarch-theatre');
INSERT INTO `venue` VALUES ('12902', 'Public Works', null, '233', 'San Francisco', 'Public Works', '37.769100', '-122.419411', '2014-04-07 06:00:23', '', '3', '12902-public-works');
INSERT INTO `venue` VALUES ('12903', 'Spaarnwoude', null, '155', 'Spaarndam', 'Spaarnwoude', '52.403999', '4.695030', '2014-04-07 06:00:23', '', '3', '12903-spaarnwoude');
INSERT INTO `venue` VALUES ('12904', 'Montreux Jazz Lab', null, '213', 'Montreux', 'Montreux Jazz Lab', '46.433334', '6.916667', '2014-04-07 06:00:23', '', '3', '12904-montreux-jazz-lab');
INSERT INTO `venue` VALUES ('12905', 'Théâtre Silvain en plein air', null, '74', 'Marseille', 'Théâtre Silvain en plein air', '43.283989', '5.354703', '2014-04-07 06:00:24', '', '3', '12905-th-tre-silvain-en-plein-air');
INSERT INTO `venue` VALUES ('12906', 'Garorock Festival', null, '74', 'Marmande', 'Garorock Festival', '44.500000', '0.166667', '2014-04-07 06:00:25', '', '3', '12906-garorock-festival');
INSERT INTO `venue` VALUES ('12907', 'Egg London', null, '232', 'London', 'Egg London', '51.542030', '-0.125119', '2014-04-07 06:00:26', '', '3', '12907-egg-london');
INSERT INTO `venue` VALUES ('12909', 'Verboten', null, '233', 'Brooklyn', 'Verboten', '40.721920', '-73.958885', '2014-04-07 06:00:26', '', '3', '12909-verboten');
INSERT INTO `venue` VALUES ('12911', 'SPACE', null, '233', 'Miami', 'SPACE', '25.784637', '-80.193474', '2014-04-07 06:00:27', '', '3', '12911-space');
INSERT INTO `venue` VALUES ('12913', 'Block', null, '107', 'Tel Aviv', 'Block', '32.066666', '34.766666', '2014-04-07 06:00:28', '', '3', '12913-block');
INSERT INTO `venue` VALUES ('12914', 'Crew Love at Watergate', null, '81', 'Berlin', 'Crew Love at Watergate', '52.516666', '13.400000', '2014-04-07 06:00:28', '', '3', '12914-crew-love-at-watergate');
INSERT INTO `venue` VALUES ('12915', 'Propaganda', null, '225', 'Istanbul', 'Propaganda', '40.995789', '28.917883', '2014-04-07 06:00:28', '', '3', '12915-propaganda');
INSERT INTO `venue` VALUES ('12916', 'Crew Love at Elita Fesival', null, '108', 'Milan', 'Crew Love at Elita Fesival', '45.466667', '9.200000', '2014-04-07 06:00:28', '', '3', '12916-crew-love-at-elita-fesival');
INSERT INTO `venue` VALUES ('12917', 'Sankeys', null, '232', 'Manchester', 'Sankeys', '53.485001', '-2.226100', '2014-04-07 06:00:28', '', '3', '12917-sankeys');
INSERT INTO `venue` VALUES ('12918', 'Zig Zag', null, '74', 'Paris', 'Zig Zag', '48.869434', '2.305102', '2014-04-07 06:00:28', '', '3', '12918-zig-zag');
INSERT INTO `venue` VALUES ('12919', 'Crew Love at DGTL Festival', null, '155', 'Amsterdam', 'Crew Love at DGTL Festival', '52.349998', '4.916667', '2014-04-07 06:00:28', '', '3', '12919-crew-love-at-dgtl-festival');
INSERT INTO `venue` VALUES ('12920', 'Studio 333', null, '232', 'London', 'Studio 333', '51.500000', '-0.116667', '2014-04-07 06:00:28', '', '3', '12920-studio-333');
INSERT INTO `venue` VALUES ('12921', 'Crew Love at Moog Fest', null, '233', 'Asheville', 'Crew Love at Moog Fest', '35.600834', '-82.554169', '2014-04-07 06:00:29', '', '3', '12921-crew-love-at-moog-fest');
INSERT INTO `venue` VALUES ('12922', 'Bardot', null, '233', 'Miami', 'Bardot', '25.773890', '-80.193886', '2014-04-07 06:00:29', '', '3', '12922-bardot');
INSERT INTO `venue` VALUES ('12923', 'Spy Bar', null, '233', 'Chicago', 'Spy Bar', '41.849998', '-87.650002', '2014-04-07 06:00:29', '', '3', '12923-spy-bar');
INSERT INTO `venue` VALUES ('12924', 'Lost Beach Club', null, '63', 'Montanita', 'Lost Beach Club', '-0.866667', '-80.266670', '2014-04-07 06:00:29', '', '3', '12924-lost-beach-club');
INSERT INTO `venue` VALUES ('12925', 'Lonely C at OUTPUT', null, '233', 'Brooklyn', 'Lonely C at OUTPUT', '40.650002', '-73.949997', '2014-04-07 06:00:29', '', '3', '12925-lonely-c-at-output');
INSERT INTO `venue` VALUES ('12926', 'Piknik Electronik', null, '39', 'Montreal', 'Piknik Electronik', '45.512287', '-73.554390', '2014-04-07 06:00:29', '', '3', '12926-piknik-electronik');
INSERT INTO `venue` VALUES ('12927', 'BETHEL WOODS', null, '233', 'Bethel', 'BETHEL WOODS', '41.696362', '-74.881828', '2014-04-07 06:00:29', '', '3', '12927-bethel-woods');
INSERT INTO `venue` VALUES ('12928', 'BAR AMERICAS', null, '142', 'Guadalajara', 'BAR AMERICAS', '20.694313', '-103.373497', '2014-04-07 06:00:29', '', '3', '12928-bar-americas');
INSERT INTO `venue` VALUES ('12929', 'Sonar festival', null, '206', 'Statella', 'Sonar festival', '42.386196', '-7.451570', '2014-04-07 06:00:29', '', '3', '12929-sonar-festival');
INSERT INTO `venue` VALUES ('12930', 'VIA DELLE SPEZIE', null, '108', 'Reggio Nell\'emilia Reggio Nell\'emilia', 'VIA DELLE SPEZIE', '44.695591', '10.641210', '2014-04-07 06:00:29', '', '3', '12930-via-delle-spezie');
INSERT INTO `venue` VALUES ('12931', 'Electric Forest', null, '233', 'Rothbury', 'Electric Forest', '43.507221', '-86.347504', '2014-04-07 06:00:29', '', '3', '12931-electric-forest');
INSERT INTO `venue` VALUES ('12932', 'Garden Fest', null, '55', 'Zadar', 'Garden Fest', '44.119720', '15.242222', '2014-04-07 06:00:29', '', '3', '12932-garden-fest');
INSERT INTO `venue` VALUES ('12933', 'Utopia', null, '81', 'Neuss', 'Utopia', '51.200001', '6.683333', '2014-04-07 06:00:29', '', '3', '12933-utopia');
INSERT INTO `venue` VALUES ('12934', 'Tunisee', null, '81', 'Freiburg', 'Tunisee', '48.057293', '7.809621', '2014-04-07 06:00:29', '', '3', '12934-tunisee');
INSERT INTO `venue` VALUES ('12935', 'Bar 13', null, '182', 'Krasnodar', 'Bar 13', '45.032780', '38.976944', '2014-04-07 06:00:29', '', '3', '12935-bar-13');
INSERT INTO `venue` VALUES ('12936', 'Fabric', null, '232', 'London', 'Fabric', '51.519619', '-0.102412', '2014-04-07 06:00:29', '', '3', '12936-fabric');
INSERT INTO `venue` VALUES ('12937', 'Badaboum', null, '74', 'Paris', 'Badaboum', '48.853428', '2.375699', '2014-04-07 06:00:29', '', '3', '12937-badaboum');
INSERT INTO `venue` VALUES ('12938', 'Dom Pechati', null, '182', 'Ekaterinburg', 'Dom Pechati', '56.837696', '60.597809', '2014-04-07 06:00:29', '', '3', '12938-dom-pechati');
INSERT INTO `venue` VALUES ('12939', 'veniceberg', null, '108', 'Verona', 'veniceberg', '45.450001', '11.000000', '2014-04-07 06:00:30', '', '3', '12939-veniceberg');
INSERT INTO `venue` VALUES ('12940', 'Bix Jazz Club', null, '81', 'Stuttgart', 'Bix Jazz Club', '48.772732', '9.180076', '2014-04-07 06:00:30', '', '3', '12940-bix-jazz-club');
INSERT INTO `venue` VALUES ('12941', 'Autumn Street Studios', null, '232', 'London', 'Autumn Street Studios', '51.535301', '-0.019700', '2014-04-07 06:00:30', '', '3', '12941-autumn-street-studios');
INSERT INTO `venue` VALUES ('12942', 'Panorama Bar', null, '81', 'Berlin', 'Panorama Bar', '52.516666', '13.400000', '2014-04-07 06:00:30', '', '3', '12942-panorama-bar');
INSERT INTO `venue` VALUES ('12943', 'Mystic Gardens Festival @ Her Sloterpark', null, '155', 'Amsterdam', 'Mystic Gardens Festival @ Her Sloterpark', '52.349998', '4.916667', '2014-04-07 06:00:30', '', '3', '12943-mystic-gardens-festival-@-her-sloterpark');
INSERT INTO `venue` VALUES ('12944', 'Bleu', null, '233', 'Detroit', 'Bleu', '42.335682', '-83.049370', '2014-04-07 06:00:31', '', '3', '12944-bleu');
INSERT INTO `venue` VALUES ('12945', 'FESTIVAL SONAR', null, '206', 'Barcelone', 'FESTIVAL SONAR', '41.379585', '2.168357', '2014-04-07 06:00:31', '', '3', '12945-festival-sonar');
INSERT INTO `venue` VALUES ('12946', 'The London Wonderground', null, '232', 'London', 'The London Wonderground', '51.500000', '-0.116667', '2014-04-07 06:00:31', '', '3', '12946-the-london-wonderground');
INSERT INTO `venue` VALUES ('12947', 'Glasslands Gallery', null, '233', 'Brooklyn', 'Glasslands Gallery', '40.714840', '-73.966721', '2014-04-07 06:00:31', '', '3', '12947-glasslands-gallery');
INSERT INTO `venue` VALUES ('12948', 'The Button Factory', null, '105', 'Dublin', 'The Button Factory', '53.344864', '-6.264599', '2014-04-07 06:00:32', '', '3', '12948-the-button-factory');
INSERT INTO `venue` VALUES ('12950', 'Cabaret Sauvage', null, '74', 'Paris', 'Cabaret Sauvage', '48.882370', '2.382250', '2014-04-07 06:00:32', '', '3', '12950-cabaret-sauvage');
INSERT INTO `venue` VALUES ('12951', 'Pont du Gard', null, '74', 'Vers-Pont-Du-Gard', 'Pont du Gard', '43.946827', '4.536059', '2014-04-07 06:00:32', '', '3', '12951-pont-du-gard');
INSERT INTO `venue` VALUES ('12952', 'Tøyenparken', null, '165', 'Oslo', 'Tøyenparken', '59.922081', '10.776800', '2014-04-07 06:00:32', '', '3', '12952-t-yenparken');
INSERT INTO `venue` VALUES ('12953', 'Le Fort de Saint Père', null, '74', 'St Pere', 'Le Fort de Saint Père', '48.588062', '-1.924559', '2014-04-07 06:00:32', '', '3', '12953-le-fort-de-saint-p-re');
INSERT INTO `venue` VALUES ('12954', 'The Twisted Pepper', null, '105', 'Dublin', 'The Twisted Pepper', '53.347958', '-6.262261', '2014-04-07 06:00:33', '', '3', '12954-the-twisted-pepper');
INSERT INTO `venue` VALUES ('12955', 'Kingdom Nightclub', null, '233', 'Austin', 'Kingdom Nightclub', '30.267099', '-97.742928', '2014-04-07 06:00:35', '', '3', '12955-kingdom-nightclub');
INSERT INTO `venue` VALUES ('12956', 'SURFCOMBER HOTEL', null, '233', 'Miami Beach', 'SURFCOMBER HOTEL', '25.792980', '-80.129646', '2014-04-07 06:00:35', '', '3', '12956-surfcomber-hotel');
INSERT INTO `venue` VALUES ('12957', 'Mezzanine', null, '233', 'San Francisco', 'Mezzanine', '37.782375', '-122.408211', '2014-04-07 06:00:35', '', '3', '12957-mezzanine');
INSERT INTO `venue` VALUES ('12958', 'Pacific Coliseum', null, '39', 'Vancouver', 'Pacific Coliseum', '49.260441', '-123.114037', '2014-04-07 06:00:35', '', '3', '12958-pacific-coliseum');
INSERT INTO `venue` VALUES ('12959', 'Output', null, '233', 'New York', 'Output', '40.722111', '-73.957603', '2014-04-07 06:00:35', '', '3', '12959-output');
INSERT INTO `venue` VALUES ('12960', 'Coda', null, '39', 'Toronto', 'Coda', '43.665321', '-79.411469', '2014-04-07 06:00:35', '', '3', '12960-coda');
INSERT INTO `venue` VALUES ('12961', 'The Forum', null, '232', 'Aberdeen', 'The Forum', '57.147316', '-2.107249', '2014-04-07 06:00:35', '', '3', '12961-the-forum');
INSERT INTO `venue` VALUES ('12962', 'The Arches', null, '232', 'Glasgow', 'The Arches', '55.858650', '-4.261500', '2014-04-07 06:00:35', '', '3', '12962-the-arches');
INSERT INTO `venue` VALUES ('12963', 'Cabaret Voltaire', null, '232', 'Edinburgh', 'Cabaret Voltaire', '55.948799', '-3.187350', '2014-04-07 06:00:35', '', '3', '12963-cabaret-voltaire');
INSERT INTO `venue` VALUES ('12964', 'East Village Arts Club', null, '232', 'Liverpool', 'East Village Arts Club', '53.401600', '-2.979490', '2014-04-07 06:00:35', '', '3', '12964-east-village-arts-club');
INSERT INTO `venue` VALUES ('12966', 'London XOYO', null, '232', 'London', 'London XOYO', '51.525501', '-0.085953', '2014-04-07 06:00:35', '', '3', '12966-london-xoyo');
INSERT INTO `venue` VALUES ('12967', 'Wollaton Park', null, '232', 'Nottingham', 'Wollaton Park', '52.947800', '-1.211000', '2014-04-07 06:00:35', '', '3', '12967-wollaton-park');
INSERT INTO `venue` VALUES ('12968', 'Pen y Berth', null, '232', 'Gwynedd', 'Pen y Berth', '52.877800', '-4.476400', '2014-04-07 06:00:35', '', '3', '12968-pen-y-berth');
INSERT INTO `venue` VALUES ('12969', 'Victoria Park', null, '232', 'London', 'Victoria Park', '51.537102', '-0.051500', '2014-04-07 06:00:35', '', '3', '12969-victoria-park');
INSERT INTO `venue` VALUES ('12970', 'Club Nokia', null, '233', 'Los Angeles', 'Club Nokia', '34.044937', '-118.264107', '2014-04-07 06:00:37', '', '3', '12970-club-nokia');
INSERT INTO `venue` VALUES ('12971', 'Brooklyn Bowl Las Vegas', null, '233', 'Las Vegas', 'Brooklyn Bowl Las Vegas', '36.117661', '-115.172783', '2014-04-07 06:00:37', '', '3', '12971-brooklyn-bowl-las-vegas');
INSERT INTO `venue` VALUES ('12972', 'Empire Polo Field', null, '233', 'Indio', 'Empire Polo Field', '33.720554', '-116.214722', '2014-04-07 06:00:37', '', '3', '12972-empire-polo-field');
INSERT INTO `venue` VALUES ('12973', 'Greek Theatre-U.C. Berkeley', null, '233', 'Berkeley', 'Greek Theatre-U.C. Berkeley', '37.873936', '-122.255447', '2014-04-07 06:00:37', '', '3', '12973-greek-theatre-u-c-berkeley');
INSERT INTO `venue` VALUES ('12974', 'Empire Polo Field', null, '233', 'Indio', 'Empire Polo Field', '33.720554', '-116.214722', '2014-04-07 06:00:37', '', '3', '12974-empire-polo-field');
INSERT INTO `venue` VALUES ('12975', 'Hordern Pavilion', null, '14', 'Sydney Nsw', 'Hordern Pavilion', '-33.895657', '151.223907', '2014-04-07 06:00:37', '', '3', '12975-hordern-pavilion');
INSERT INTO `venue` VALUES ('12976', 'Oakbank Racecourse', null, '14', 'Oakbank', 'Oakbank Racecourse', '-34.978603', '138.831787', '2014-04-07 06:00:37', '', '3', '12976-oakbank-racecourse');
INSERT INTO `venue` VALUES ('12977', 'Maitland Showground', null, '14', 'Maitland', 'Maitland Showground', '-34.383331', '137.666672', '2014-04-07 06:00:37', '', '3', '12977-maitland-showground');
INSERT INTO `venue` VALUES ('12978', 'The Meadows, University of Canberra', null, '14', 'Canberra', 'The Meadows, University of Canberra', '-35.283333', '149.216660', '2014-04-07 06:00:37', '', '3', '12978-the-meadows-university-of-canberra');
INSERT INTO `venue` VALUES ('12979', 'Forum Melbourne', null, '14', 'Melbourne Vic', 'Forum Melbourne', '-37.817532', '144.967148', '2014-04-07 06:00:37', '', '3', '12979-forum-melbourne');
INSERT INTO `venue` VALUES ('12980', 'Forum Melbourne', null, '14', 'Melbourne Vic', 'Forum Melbourne', '-37.817532', '144.967148', '2014-04-07 06:00:37', '', '3', '12980-forum-melbourne');
INSERT INTO `venue` VALUES ('12981', 'Forum Melbourne', null, '14', 'Melbourne Vic', 'Forum Melbourne', '-37.817532', '144.967148', '2014-04-07 06:00:37', '', '3', '12981-forum-melbourne');
INSERT INTO `venue` VALUES ('12982', 'Prince of Wales Showground', null, '14', 'Bendigo', 'Prince of Wales Showground', '-36.758713', '144.283752', '2014-04-07 06:00:37', '', '3', '12982-prince-of-wales-showground');
INSERT INTO `venue` VALUES ('12983', 'Murray Sports Complex', null, '14', 'Townsville', 'Murray Sports Complex', '-19.250000', '146.800003', '2014-04-07 06:00:37', '', '3', '12983-murray-sports-complex');
INSERT INTO `venue` VALUES ('12984', 'Eatons Hill Hotel', null, '14', 'Brisbane', 'Eatons Hill Hotel', '-27.336905', '152.960648', '2014-04-07 06:00:37', '', '3', '12984-eatons-hill-hotel');
INSERT INTO `venue` VALUES ('12985', 'Hay Park', null, '14', 'Bunbury', 'Hay Park', '-33.333332', '115.633331', '2014-04-07 06:00:37', '', '3', '12985-hay-park');
INSERT INTO `venue` VALUES ('12986', 'Studio Coast', null, '110', 'Tokyo', 'Studio Coast', '35.685001', '139.751389', '2014-04-07 06:00:37', '', '3', '12986-studio-coast');
INSERT INTO `venue` VALUES ('12987', 'Damyns Hall Aerodrome', null, '232', 'Upminster', 'Damyns Hall Aerodrome', '51.532318', '0.249657', '2014-04-07 06:00:37', '', '3', '12987-damyns-hall-aerodrome');
INSERT INTO `venue` VALUES ('12988', 'Union Transfer', null, '233', 'Philadelphia', 'Union Transfer', '39.961700', '-75.155502', '2014-04-07 06:00:37', '', '3', '12988-union-transfer');
INSERT INTO `venue` VALUES ('12989', 'Union Transfer', null, '233', 'Philadelphia', 'Union Transfer', '39.961700', '-75.155502', '2014-04-07 06:00:37', '', '3', '12989-union-transfer');
INSERT INTO `venue` VALUES ('12990', 'Lincoln Park Zoo', null, '233', 'Chicago', 'Lincoln Park Zoo', '41.918510', '-87.636032', '2014-04-07 06:00:37', '', '3', '12990-lincoln-park-zoo');
INSERT INTO `venue` VALUES ('12991', 'The Pageant', null, '233', 'St Louis', 'The Pageant', '38.655415', '-90.297997', '2014-04-07 06:00:37', '', '3', '12991-the-pageant');
INSERT INTO `venue` VALUES ('12992', 'Club Papaya & Club Aquarius', null, '55', 'Novalja', 'Club Papaya & Club Aquarius', '44.566540', '14.875500', '2014-04-07 06:00:37', '', '3', '12992-club-papaya-&-club-aquarius');
INSERT INTO `venue` VALUES ('12993', 'La Citadelle', null, '74', 'Arras', 'La Citadelle', '50.290989', '2.778910', '2014-04-07 06:00:37', '', '3', '12993-la-citadelle');
INSERT INTO `venue` VALUES ('12994', 'La Citadelle', null, '74', 'Arras', 'La Citadelle', '50.290989', '2.778910', '2014-04-07 06:00:37', '', '3', '12994-la-citadelle');
INSERT INTO `venue` VALUES ('12995', 'La Citadelle', null, '74', 'Arras', 'La Citadelle', '50.290989', '2.778910', '2014-04-07 06:00:37', '', '3', '12995-la-citadelle');
INSERT INTO `venue` VALUES ('12996', 'La Citadelle', null, '74', 'Arras', 'La Citadelle', '50.290989', '2.778910', '2014-04-07 06:00:37', '', '3', '12996-la-citadelle');
INSERT INTO `venue` VALUES ('12997', 'Marlay Park', null, '105', 'Dublin', 'Marlay Park', '53.300121', '-6.283730', '2014-04-07 06:00:37', '', '3', '12997-marlay-park');
INSERT INTO `venue` VALUES ('12998', 'ARENES PAUL LAURENT', null, '74', 'Beaucaire', 'ARENES PAUL LAURENT', '43.788200', '4.565702', '2014-04-07 06:00:37', '', '3', '12998-arenes-paul-laurent');
INSERT INTO `venue` VALUES ('12999', 'Richfield Avenue', null, '232', 'Reading', 'Richfield Avenue', '51.464405', '-0.982444', '2014-04-07 06:00:37', '', '3', '12999-richfield-avenue');
INSERT INTO `venue` VALUES ('13001', 'Printemps de Bourges Festival', null, '74', 'Bourges', 'Printemps de Bourges Festival', '47.083332', '2.400000', '2014-04-07 06:00:38', '', '3', '13001-printemps-de-bourges-festival');
INSERT INTO `venue` VALUES ('13002', 'Freeform Festival', null, '176', 'Warsaw', 'Freeform Festival', '52.226585', '21.036367', '2014-04-07 06:00:38', '', '3', '13002-freeform-festival');
INSERT INTO `venue` VALUES ('13003', 'FOR Festival', null, '55', 'Hvar', 'FOR Festival', '43.172501', '16.442778', '2014-04-07 06:00:38', '', '3', '13003-for-festival');
INSERT INTO `venue` VALUES ('13004', 'Kosmonaut Festival', null, '81', 'Berlin', 'Kosmonaut Festival', '52.516666', '13.400000', '2014-04-07 06:00:38', '', '3', '13004-kosmonaut-festival');
INSERT INTO `venue` VALUES ('13005', 'Benicàssim Festival', null, '206', 'Costa', 'Benicàssim Festival', '42.799999', '-8.700000', '2014-04-07 06:00:38', '', '3', '13005-benic-ssim-festival');
INSERT INTO `venue` VALUES ('13006', 'Dour Festival', null, '22', 'Dour', 'Dour Festival', '50.400002', '3.783333', '2014-04-07 06:00:38', '', '3', '13006-dour-festival');
INSERT INTO `venue` VALUES ('13007', 'SZIGET FESTIVAL', null, '74', 'Paris', 'SZIGET FESTIVAL', '48.876411', '2.327561', '2014-04-07 06:00:38', '', '3', '13007-sziget-festival');
INSERT INTO `venue` VALUES ('13008', 'Grape Festival', null, null, 'Piestany', 'Grape Festival', '48.589203', '17.834105', '2014-04-07 06:00:38', '', '3', '13008-grape-festival');
INSERT INTO `venue` VALUES ('13009', 'Reading and Leeds Festival', null, '232', 'Reading', 'Reading and Leeds Festival', '51.434471', '-0.937347', '2014-04-07 06:00:38', '', '3', '13009-reading-and-leeds-festival');
INSERT INTO `venue` VALUES ('13010', 'Jersey Live', null, '232', 'Jersey', 'Jersey Live', '49.212830', '-2.133170', '2014-04-07 06:00:38', '', '3', '13010-jersey-live');
INSERT INTO `venue` VALUES ('13012', 'East Village Arts Club', null, '232', 'Liverpool', 'East Village Arts Club', '53.401600', '-2.979490', '2014-04-07 06:00:40', '', '3', '13012-east-village-arts-club');
INSERT INTO `venue` VALUES ('13013', 'Victoria Park', null, '232', 'London', 'Victoria Park', '51.537102', '-0.051500', '2014-04-07 06:00:40', '', '3', '13013-victoria-park');
INSERT INTO `venue` VALUES ('13014', 'STORY MIAMI', null, '233', 'Miami Beach', 'STORY MIAMI', '25.770254', '-80.133957', '2014-04-07 06:00:40', '', '3', '13014-story-miami');
INSERT INTO `venue` VALUES ('13015', 'Robin Hill Country Park', null, '232', 'Isle Of Wight', 'Robin Hill Country Park', '50.671101', '-1.328630', '2014-04-07 06:00:40', '', '3', '13015-robin-hill-country-park');
INSERT INTO `venue` VALUES ('13016', 'Reverse.La Riviera', null, '206', 'Madrid', 'Reverse.La Riviera', '40.400002', '-3.683333', '2014-04-07 06:00:41', '', '3', '13016-reverse-la-riviera');
INSERT INTO `venue` VALUES ('13017', 'Florida 135', null, '206', 'Fraga', 'Florida 135', '41.519650', '0.348425', '2014-04-07 06:00:41', '', '3', '13017-florida-135');
INSERT INTO `venue` VALUES ('13018', 'Bugged Out', null, '232', 'London', 'Bugged Out', '51.500000', '-0.116667', '2014-04-07 06:00:41', '', '3', '13018-bugged-out');
INSERT INTO `venue` VALUES ('13019', 'Panoramas Festival', null, '74', 'Morlaix', 'Panoramas Festival', '48.583332', '-3.833333', '2014-04-07 06:00:41', '', '3', '13019-panoramas-festival');
INSERT INTO `venue` VALUES ('13020', 'Showcase', null, '74', 'Paris', 'Showcase', '48.877205', '2.317020', '2014-04-07 06:00:41', '', '3', '13020-showcase');
INSERT INTO `venue` VALUES ('13021', 'Paaspop Festival', null, '155', 'Schijndel', 'Paaspop Festival', '51.616669', '5.450000', '2014-04-07 06:00:41', '', '3', '13021-paaspop-festival');
INSERT INTO `venue` VALUES ('13022', 'Counterpoint Festival', null, '233', 'Atlanta', 'Counterpoint Festival', '33.748890', '-84.388054', '2014-04-07 06:00:41', '', '3', '13022-counterpoint-festival');
INSERT INTO `venue` VALUES ('13023', 'Royale Nightclub', null, '233', 'Boston', 'Royale Nightclub', '42.349892', '-71.065163', '2014-04-07 06:00:41', '', '3', '13023-royale-nightclub');
INSERT INTO `venue` VALUES ('13024', 'The Hoxton', null, '39', 'Toronto', 'The Hoxton', '43.643528', '-79.402519', '2014-04-07 06:00:41', '', '3', '13024-the-hoxton');
INSERT INTO `venue` VALUES ('13025', 'Telus Theatre', null, '39', 'Montreal Metro Area', 'Telus Theatre', '45.513542', '-73.560059', '2014-04-07 06:00:41', '', '3', '13025-telus-theatre');
INSERT INTO `venue` VALUES ('13026', 'Monarch Theatre', null, '233', 'Phoenix', 'Monarch Theatre', '33.448215', '-112.072166', '2014-04-07 06:00:41', '', '3', '13026-monarch-theatre');
INSERT INTO `venue` VALUES ('13027', 'Beta', null, '233', 'Denver', 'Beta', '39.753605', '-104.995430', '2014-04-07 06:00:41', '', '3', '13027-beta');
INSERT INTO `venue` VALUES ('13028', 'The Mid', null, '233', 'Chicago', 'The Mid', '41.887070', '-87.647507', '2014-04-07 06:00:41', '', '3', '13028-the-mid');
INSERT INTO `venue` VALUES ('13029', 'Firestone', null, '233', 'Orlando', 'Firestone', '28.550533', '-81.379311', '2014-04-07 06:00:41', '', '3', '13029-firestone');
INSERT INTO `venue` VALUES ('13030', 'Amphitheatre Event Facility', null, '233', 'Tampa', 'Amphitheatre Event Facility', '27.960279', '-82.441505', '2014-04-07 06:00:41', '', '3', '13030-amphitheatre-event-facility');
INSERT INTO `venue` VALUES ('13031', 'Tricky Falls', null, '233', 'El Paso', 'Tricky Falls', '31.757313', '-106.488930', '2014-04-07 06:00:41', '', '3', '13031-tricky-falls');
INSERT INTO `venue` VALUES ('13032', 'Hangout Music Festival', null, '233', 'Gulf Shores', 'Hangout Music Festival', '30.245832', '-87.700836', '2014-04-07 06:00:41', '', '3', '13032-hangout-music-festival');
INSERT INTO `venue` VALUES ('13033', 'Union Hall', null, '39', 'Edmonton', 'Union Hall', '53.553982', '-113.492401', '2014-04-07 06:00:41', '', '3', '13033-union-hall');
INSERT INTO `venue` VALUES ('13034', 'MetLife Stadium', null, '233', 'East Rutherford', 'MetLife Stadium', '40.834549', '-74.098351', '2014-04-07 06:00:41', '', '3', '13034-metlife-stadium');
INSERT INTO `venue` VALUES ('13035', 'Electric Daisy Carnival', null, '233', 'East Rutherford', 'Electric Daisy Carnival', '40.833889', '-74.097504', '2014-04-07 06:00:41', '', '3', '13035-electric-daisy-carnival');
INSERT INTO `venue` VALUES ('13036', 'Movement Festival', null, '233', 'Detroit', 'Movement Festival', '42.331390', '-83.045830', '2014-04-07 06:00:41', '', '3', '13036-movement-festival');
INSERT INTO `venue` VALUES ('13037', 'Organic Dance Music Festival', null, '81', 'Munich', 'Organic Dance Music Festival', '48.150002', '11.583333', '2014-04-07 06:00:41', '', '3', '13037-organic-dance-music-festival');
INSERT INTO `venue` VALUES ('13038', 'Distortion 2014', null, '59', 'Copenhagen', 'Distortion 2014', '55.666668', '12.583333', '2014-04-07 06:00:41', '', '3', '13038-distortion-2014');
INSERT INTO `venue` VALUES ('13039', 'Debaser Medis', null, '212', 'Stockholm', 'Debaser Medis', '59.314980', '18.072620', '2014-04-07 06:00:41', '', '3', '13039-debaser-medis');
INSERT INTO `venue` VALUES ('13040', 'Mysteryland', null, '155', 'Haarlemmermeer', 'Mysteryland', '52.299999', '4.700000', '2014-04-07 06:00:41', '', '3', '13040-mysteryland');
INSERT INTO `venue` VALUES ('13041', 'Bestival', null, '232', 'Isle Of Wight', 'Bestival', '50.671101', '-1.328630', '2014-04-07 06:00:41', '', '3', '13041-bestival');
INSERT INTO `venue` VALUES ('13042', 'Techno-Flash', null, '206', 'Aranda De Duero', 'Techno-Flash', '41.683334', '-3.683333', '2014-04-07 06:00:42', '', '3', '13042-techno-flash');
INSERT INTO `venue` VALUES ('13043', 'Le Bikini', null, '74', 'Ramonville-Saint-Agne', 'Le Bikini', '43.552280', '1.485347', '2014-04-07 06:00:42', '', '3', '13043-le-bikini');
INSERT INTO `venue` VALUES ('13044', 'Coachella', null, '233', 'Indio', 'Coachella', '33.721703', '-116.219421', '2014-04-07 06:00:42', '', '3', '13044-coachella');
INSERT INTO `venue` VALUES ('13045', 'Coachella', null, '233', 'Indio', 'Coachella', '33.721703', '-116.219421', '2014-04-07 06:00:42', '', '3', '13045-coachella');
INSERT INTO `venue` VALUES ('13046', 'Matthew Dear DJ at Verboten ', null, '233', 'New York', 'Matthew Dear DJ at Verboten ', '40.714169', '-74.006386', '2014-04-07 06:00:42', '', '3', '13046-matthew-dear-dj-at-verboten-');
INSERT INTO `venue` VALUES ('13047', 'Tiga vs Audion at Berghain', null, '81', 'Berlin', 'Tiga vs Audion at Berghain', '52.516666', '13.400000', '2014-04-07 06:00:42', '', '3', '13047-tiga-vs-audion-at-berghain');
INSERT INTO `venue` VALUES ('13048', 'Audion Live at Oval Space ', null, '232', 'London', 'Audion Live at Oval Space ', '51.500000', '-0.116667', '2014-04-07 06:00:42', '', '3', '13048-audion-live-at-oval-space-');
INSERT INTO `venue` VALUES ('13049', 'Damyns Hall Aerodrome', null, '232', 'Upminster', 'Damyns Hall Aerodrome', '51.532318', '0.249657', '2014-04-07 06:00:42', '', '3', '13049-damyns-hall-aerodrome');
INSERT INTO `venue` VALUES ('13050', 'Stradbally Hall', null, '105', 'Stradbally', 'Stradbally Hall', '53.012447', '-7.144665', '2014-04-07 06:00:43', '', '3', '13050-stradbally-hall');
INSERT INTO `venue` VALUES ('13051', 'Verboten', null, '233', 'Brooklyn', 'Verboten', '40.721920', '-73.958885', '2014-04-07 06:00:44', '', '3', '13051-verboten');
INSERT INTO `venue` VALUES ('13052', 'Mezzanine', null, '233', 'San Francisco', 'Mezzanine', '37.782375', '-122.408211', '2014-04-07 06:00:45', '', '3', '13052-mezzanine');
INSERT INTO `venue` VALUES ('13053', 'Nuits Sonores Festival', null, '74', 'Lyon', 'Nuits Sonores Festival', '45.759399', '4.828970', '2014-04-07 06:00:45', '', '3', '13053-nuits-sonores-festival');
INSERT INTO `venue` VALUES ('13054', 'Optimus Primavera Sound', null, '177', 'Porto', 'Optimus Primavera Sound', '41.159309', '-8.637549', '2014-04-07 06:00:45', '', '3', '13054-optimus-primavera-sound');
INSERT INTO `venue` VALUES ('13055', 'Sonár by day', null, '206', 'Barcelona', 'Sonár by day', '41.383331', '2.183333', '2014-04-07 06:00:45', '', '3', '13055-son-r-by-day');
INSERT INTO `venue` VALUES ('13056', 'Hovefestival', null, '165', 'Arendal', 'Hovefestival', '58.470070', '8.758720', '2014-04-07 06:00:45', '', '3', '13056-hovefestival');
INSERT INTO `venue` VALUES ('13057', 'Roskilde Festival', null, '59', 'Roskilde', 'Roskilde Festival', '55.630280', '12.083631', '2014-04-07 06:00:45', '', '3', '13057-roskilde-festival');
INSERT INTO `venue` VALUES ('13058', 'Rock Werchter 2014', null, '22', 'Werchter', 'Rock Werchter 2014', '50.970470', '4.694080', '2014-04-07 06:00:45', '', '3', '13058-rock-werchter-2014');
INSERT INTO `venue` VALUES ('13059', 'Ilosaarirock Festival 2014', null, '73', 'Joensuu', 'Ilosaarirock Festival 2014', '62.599998', '29.766666', '2014-04-07 06:00:45', '', '3', '13059-ilosaarirock-festival-2014');
INSERT INTO `venue` VALUES ('13060', 'Colours of Ostrava Festival', null, '58', 'Ostrava', 'Colours of Ostrava Festival', '49.833332', '18.283333', '2014-04-07 06:00:45', '', '3', '13060-colours-of-ostrava-festival');
INSERT INTO `venue` VALUES ('13061', 'Bermuda Triangle', null, '232', 'Brighton', 'Bermuda Triangle', '50.826508', '-0.125543', '2014-04-07 06:00:45', '', '3', '13061-bermuda-triangle');
INSERT INTO `venue` VALUES ('13062', 'MS Rheinenergie', null, '81', 'Dusseldorf', 'MS Rheinenergie', '51.216667', '6.766667', '2014-04-07 06:00:47', '', '3', '13062-ms-rheinenergie');
INSERT INTO `venue` VALUES ('13063', 'The Atomic Café', null, '81', 'Munich', 'The Atomic Café', '48.138100', '11.580919', '2014-04-07 06:00:48', '', '3', '13063-the-atomic-caf-');
INSERT INTO `venue` VALUES ('13064', 'Heimathafen Neukoelln', null, '81', 'Berlin', 'Heimathafen Neukoelln', '52.477036', '13.439249', '2014-04-07 06:00:48', '', '3', '13064-heimathafen-neukoelln');
INSERT INTO `venue` VALUES ('13065', 'Pumpehuset', null, '59', 'Copenhagen', 'Pumpehuset', '55.676956', '12.565127', '2014-04-07 06:00:48', '', '3', '13065-pumpehuset');
INSERT INTO `venue` VALUES ('13066', 'Debaser Strand', null, '212', 'Stockholm', 'Debaser Strand', '59.333332', '18.049999', '2014-04-07 06:00:48', '', '3', '13066-debaser-strand');
INSERT INTO `venue` VALUES ('13067', 'Stadthalle Heidelberg', null, '81', 'Heidelberg', 'Stadthalle Heidelberg', '49.412350', '8.699955', '2014-04-07 06:00:49', '', '3', '13067-stadthalle-heidelberg');
INSERT INTO `venue` VALUES ('13068', 'BPC Showcase @ Electric Brixton with Camea, Aérea Negrot, BabyG', null, '232', 'London', 'BPC Showcase @ Electric Brixton with Camea, Aérea Negrot, BabyG and Thomas Muller ', '51.500000', '-0.116667', '2014-04-07 06:00:50', '', '3', '13068-bpc-showcase-@-electric-brixton-with-camea-a-rea-negrot-ba');
INSERT INTO `venue` VALUES ('13069', 'Babylon', null, '225', 'Istanbul', 'Babylon', '41.018612', '28.964722', '2014-04-07 06:00:50', '', '3', '13069-babylon');
INSERT INTO `venue` VALUES ('13070', 'Sub Club', null, '232', 'Glasgow', 'Sub Club', '55.858093', '-4.257182', '2014-04-07 06:00:50', '', '3', '13070-sub-club');
INSERT INTO `venue` VALUES ('13071', 'Gilda', null, '108', 'Vicenza', 'Gilda', '45.525364', '11.498572', '2014-04-07 06:00:50', '', '3', '13071-gilda');
INSERT INTO `venue` VALUES ('13072', 'Electron Festival 11 @ Le Palladium', null, '213', 'Geneva', 'Electron Festival 11 @ Le Palladium', '46.200001', '6.166667', '2014-04-07 06:00:50', '', '3', '13072-electron-festival-11-@-le-palladium');
INSERT INTO `venue` VALUES ('13073', 'La Grotta', null, '108', 'Palinuro', 'La Grotta', '40.040447', '15.286310', '2014-04-07 06:00:50', '', '3', '13073-la-grotta');
INSERT INTO `venue` VALUES ('13074', 'Vanilla Ninja', null, '182', 'Moscow', 'Vanilla Ninja', '55.752220', '37.615555', '2014-04-07 06:00:50', '', '3', '13074-vanilla-ninja');
INSERT INTO `venue` VALUES ('13075', 'Bedrock Warehouse Party @ The Garage', null, '232', 'Liverpool', 'Bedrock Warehouse Party @ The Garage', '53.416668', '-3.000000', '2014-04-07 06:00:50', '', '3', '13075-bedrock-warehouse-party-@-the-garage');
INSERT INTO `venue` VALUES ('13076', 'Vox', null, '108', 'Modena Mo', 'Vox', '44.643116', '10.934080', '2014-04-07 06:00:50', '', '3', '13076-vox');
INSERT INTO `venue` VALUES ('13077', 'Gewölbe', null, '81', 'Cologne', 'Gewölbe', '50.943775', '6.933648', '2014-04-07 06:00:50', '', '3', '13077-gew-lbe');
INSERT INTO `venue` VALUES ('13078', 'BPC Showcase @ Panoramabar', null, '81', 'Berlin', 'BPC Showcase @ Panoramabar', '52.516666', '13.400000', '2014-04-07 06:00:50', '', '3', '13078-bpc-showcase-@-panoramabar');
INSERT INTO `venue` VALUES ('13079', 'Troffler', null, '155', 'Rotterdam', 'Troffler', '51.916668', '4.500000', '2014-04-07 06:00:50', '', '3', '13079-troffler');
INSERT INTO `venue` VALUES ('13080', 'Special Case Daytime Rooftop @ Moskva City Restaurant Terrace', null, '182', 'Saint Petersburg', 'Special Case Daytime Rooftop @ Moskva City Restaurant Terrace', '59.894444', '30.264168', '2014-04-07 06:00:50', '', '3', '13080-special-case-daytime-rooftop-@-moskva-city-restaurant-terr');
INSERT INTO `venue` VALUES ('13081', 'Emirates Golf Club Dubai', null, '231', 'Dubai', 'Emirates Golf Club Dubai', '25.252222', '55.279999', '2014-04-07 06:00:50', '', '3', '13081-emirates-golf-club-dubai');
INSERT INTO `venue` VALUES ('13082', 'Douala', null, '81', 'Ravensburg', 'Douala', '47.780033', '9.603835', '2014-04-07 06:00:50', '', '3', '13082-douala');
INSERT INTO `venue` VALUES ('13083', 'WeAre Festival @ Damyns Hall Aerodrome ', null, '232', 'Upminster', 'WeAre Festival @ Damyns Hall Aerodrome ', '51.557098', '0.249600', '2014-04-07 06:00:50', '', '3', '13083-weare-festival-@-damyns-hall-aerodrome-');
INSERT INTO `venue` VALUES ('13084', 'Opening Circoloco @ DC10', null, '206', 'Ibiza', 'Opening Circoloco @ DC10', '38.900002', '1.433333', '2014-04-07 06:00:50', '', '3', '13084-opening-circoloco-@-dc10');
INSERT INTO `venue` VALUES ('13085', 'Klangkino', null, '81', 'Gebesee', 'Klangkino', '51.116669', '10.933333', '2014-04-07 06:00:50', '', '3', '13085-klangkino');
INSERT INTO `venue` VALUES ('13086', 'Uebel & Gefährlich', null, '81', 'Hamburg', 'Uebel & Gefährlich', '53.557175', '9.969782', '2014-04-07 06:00:50', '', '3', '13086-uebel-&-gef-hrlich');
INSERT INTO `venue` VALUES ('13087', 'Traumschiff', null, '81', 'Chiemsee', 'Traumschiff', '47.866669', '12.416667', '2014-04-07 06:00:50', '', '3', '13087-traumschiff');
INSERT INTO `venue` VALUES ('13088', 'Lehman', null, '81', 'Stuttgart', 'Lehman', '48.766666', '9.183333', '2014-04-07 06:00:50', '', '3', '13088-lehman');
INSERT INTO `venue` VALUES ('13089', 'Verboten', null, '233', 'New York', 'Verboten', '40.722061', '-73.958626', '2014-04-07 06:00:51', '', '3', '13089-verboten');
INSERT INTO `venue` VALUES ('13090', 'The National Gallery', null, '232', 'London', 'The National Gallery', '51.500000', '-0.116667', '2014-04-07 06:00:51', '', '3', '13090-the-national-gallery');
INSERT INTO `venue` VALUES ('13091', 'The Forge', null, '232', 'London', 'The Forge', '51.536655', '-0.142773', '2014-04-07 06:00:52', '', '3', '13091-the-forge');
INSERT INTO `venue` VALUES ('13092', 'Paradise @ DC-10', null, '206', 'Ibiza', 'Paradise @ DC-10', '38.900002', '1.433333', '2014-04-07 06:00:52', '', '3', '13092-paradise-@-dc-10');
INSERT INTO `venue` VALUES ('13093', 'WATERGATE BERLIN', null, '81', 'Berlin', 'WATERGATE BERLIN', '52.498890', '13.389855', '2014-04-07 06:00:53', '', '3', '13093-watergate-berlin');
INSERT INTO `venue` VALUES ('13094', 'Middlesex Lounge', null, '233', 'Cambridge', 'Middlesex Lounge', '42.362221', '-71.098335', '2014-04-07 06:00:53', '', '3', '13094-middlesex-lounge');
INSERT INTO `venue` VALUES ('13095', 'Shine Nightclub', null, '39', 'Ottawa', 'Shine Nightclub', '45.368561', '-75.660789', '2014-04-07 06:00:53', '', '3', '13095-shine-nightclub');
INSERT INTO `venue` VALUES ('13096', 'Level 2 Lounge', null, '39', 'Dysart', 'Level 2 Lounge', '45.076698', '-78.413513', '2014-04-07 06:00:53', '', '3', '13096-level-2-lounge');
INSERT INTO `venue` VALUES ('13097', 'Discolo', null, '48', 'Barranquilla', 'Discolo', '10.963889', '-74.796387', '2014-04-07 06:00:53', '', '3', '13097-discolo');
INSERT INTO `venue` VALUES ('13098', 'Treehouse', null, '233', 'Miami', 'Treehouse', '25.773890', '-80.193886', '2014-04-07 06:00:53', '', '3', '13098-treehouse');
INSERT INTO `venue` VALUES ('13099', 'Vinyl', null, '233', 'Denver', 'Vinyl', '39.733414', '-104.987213', '2014-04-07 06:00:53', '', '3', '13099-vinyl');
INSERT INTO `venue` VALUES ('13100', 'HABITAT', null, '39', 'Montreal', 'HABITAT', '45.498470', '-73.576874', '2014-04-07 06:00:53', '', '3', '13100-habitat');
INSERT INTO `venue` VALUES ('13101', 'SANKEYS NYC', null, '233', 'New York', 'SANKEYS NYC', '40.750591', '-73.985077', '2014-04-07 06:00:53', '', '3', '13101-sankeys-nyc');
INSERT INTO `venue` VALUES ('13102', 'WATERGATE BERLIN', null, '81', 'Berlin', 'WATERGATE BERLIN', '52.498890', '13.389855', '2014-04-07 06:00:53', '', '3', '13102-watergate-berlin');
INSERT INTO `venue` VALUES ('13103', 'Forsage Club', null, '230', 'Kiev', 'Forsage Club', '50.429447', '30.546694', '2014-04-07 06:00:53', '', '3', '13103-forsage-club');
INSERT INTO `venue` VALUES ('13105', 'Pollerwiesen Boat', null, '108', 'Cologne', 'Pollerwiesen Boat', '45.583332', '9.933333', '2014-04-07 06:00:53', '', '3', '13105-pollerwiesen-boat');
INSERT INTO `venue` VALUES ('13106', 'Luft & Leibe Festival', null, '81', 'Moers', 'Luft & Leibe Festival', '51.450001', '6.650000', '2014-04-07 06:00:53', '', '3', '13106-luft-&-leibe-festival');
INSERT INTO `venue` VALUES ('13107', 'Terme di Agnano', null, '108', 'Naples', 'Terme di Agnano', '40.833332', '14.250000', '2014-04-07 06:00:53', '', '3', '13107-terme-di-agnano');
INSERT INTO `venue` VALUES ('13108', 'The Source Bar', null, '232', 'Maidstone', 'The Source Bar', '51.273899', '0.523985', '2014-04-07 06:00:53', '', '3', '13108-the-source-bar');
INSERT INTO `venue` VALUES ('13109', 'Electric Daisy Carnival', null, '232', 'Milton Keynes', 'Electric Daisy Carnival', '52.033333', '-0.700000', '2014-04-07 06:00:53', '', '3', '13109-electric-daisy-carnival');
INSERT INTO `venue` VALUES ('13110', 'Minsk Festival', null, '21', 'Minsk', 'Minsk Festival', '53.900002', '27.566668', '2014-04-07 06:00:53', '', '3', '13110-minsk-festival');
INSERT INTO `venue` VALUES ('13111', 'Beat-Herder Festival', null, '232', 'Lancaster', 'Beat-Herder Festival', '54.066666', '-2.833333', '2014-04-07 06:00:53', '', '3', '13111-beat-herder-festival');
INSERT INTO `venue` VALUES ('13112', 'Ushuaïa Ibiza Beach Hotel', null, '206', 'Ibiza', 'Ushuaïa Ibiza Beach Hotel', '38.900002', '1.433333', '2014-04-07 06:00:53', '', '3', '13112-ushua-a-ibiza-beach-hotel');
INSERT INTO `venue` VALUES ('13113', 'Ushuaïa Ibiza Beach Hotel', null, '206', 'Ibiza', 'Ushuaïa Ibiza Beach Hotel', '38.900002', '1.433333', '2014-04-07 06:00:53', '', '3', '13113-ushua-a-ibiza-beach-hotel');
INSERT INTO `venue` VALUES ('13114', 'Marx Bar', null, '128', 'Hollerich', 'Marx Bar', '49.602501', '6.124167', '2014-04-07 06:00:53', '', '3', '13114-marx-bar');
INSERT INTO `venue` VALUES ('13115', 'Kesselhaus', null, '81', 'Augsburg', 'Kesselhaus', '48.370331', '10.897890', '2014-04-07 06:00:53', '', '3', '13115-kesselhaus');
INSERT INTO `venue` VALUES ('13116', 'Ushuaïa Ibiza Beach Hotel', null, '206', 'Ibiza', 'Ushuaïa Ibiza Beach Hotel', '38.900002', '1.433333', '2014-04-07 06:00:53', '', '3', '13116-ushua-a-ibiza-beach-hotel');
INSERT INTO `venue` VALUES ('13117', 'DGTL Festival', null, '155', 'Amsterdam', 'DGTL Festival', '52.349998', '4.916667', '2014-04-07 06:00:56', '', '3', '13117-dgtl-festival');
INSERT INTO `venue` VALUES ('13118', 'Noir Music @ Whoosah', null, '155', 'Scheveningen', 'Noir Music @ Whoosah', '52.099998', '4.283333', '2014-04-07 06:00:56', '', '3', '13118-noir-music-@-whoosah');
INSERT INTO `venue` VALUES ('13119', 'COMMA@Blender', null, '34', 'Sofia', 'COMMA@Blender', '42.683334', '23.316668', '2014-04-07 06:00:56', '', '3', '13119-comma@blender');
INSERT INTO `venue` VALUES ('13120', 'DITH15 @ Oval Space (Mixmag Live)', null, '232', 'London', 'DITH15 @ Oval Space (Mixmag Live)', '51.500000', '-0.116667', '2014-04-07 06:00:56', '', '3', '13120-dith15-@-oval-space-(mixmag-live)');
INSERT INTO `venue` VALUES ('13121', 'DITH15 @ Sankeys', null, '232', 'Manchester', 'DITH15 @ Sankeys', '53.500000', '-2.216667', '2014-04-07 06:00:56', '', '3', '13121-dith15-@-sankeys');
INSERT INTO `venue` VALUES ('13122', 'DITH15 @ Sin', null, '105', 'Dublin', 'DITH15 @ Sin', '53.333057', '-6.248889', '2014-04-07 06:00:56', '', '3', '13122-dith15-@-sin');
INSERT INTO `venue` VALUES ('13123', 'Indigo', null, '225', 'Istanbul', 'Indigo', '41.018612', '28.964722', '2014-04-07 06:00:56', '', '3', '13123-indigo');
INSERT INTO `venue` VALUES ('13124', 'Extrema Festival', null, '22', 'Houthalen', 'Extrema Festival', '51.033916', '5.374294', '2014-04-07 06:00:56', '', '3', '13124-extrema-festival');
INSERT INTO `venue` VALUES ('13125', 'Found Festival', null, '232', 'London', 'Found Festival', '51.500000', '-0.116667', '2014-04-07 06:00:56', '', '3', '13125-found-festival');
INSERT INTO `venue` VALUES ('13126', 'Wilde @ The Apartment', null, '206', 'Barcelona', 'Wilde @ The Apartment', '41.383331', '2.183333', '2014-04-07 06:00:56', '', '3', '13126-wilde-@-the-apartment');
INSERT INTO `venue` VALUES ('13127', 'Wilde @ Rooftop', null, '181', 'Bucharest', 'Wilde @ Rooftop', '44.433334', '26.100000', '2014-04-07 06:00:56', '', '3', '13127-wilde-@-rooftop');
INSERT INTO `venue` VALUES ('13128', 'Awekenings Festival', null, '155', 'Amsterdam', 'Awekenings Festival', '52.349998', '4.916667', '2014-04-07 06:00:56', '', '3', '13128-awekenings-festival');
INSERT INTO `venue` VALUES ('13129', 'Snowbombing', null, '15', 'Mayrhofen', 'Snowbombing', '47.167068', '11.862428', '2014-04-07 06:00:58', '', '3', '13129-snowbombing');
INSERT INTO `venue` VALUES ('13130', 'Output', null, '233', 'New York', 'Output', '40.722111', '-73.957603', '2014-04-07 06:00:58', '', '3', '13130-output');
INSERT INTO `venue` VALUES ('13131', 'Coachella ', null, '233', 'California', 'Coachella ', '37.908890', '-79.587219', '2014-04-07 06:00:58', '', '3', '13131-coachella-');
INSERT INTO `venue` VALUES ('13132', 'Sound Nightclub', null, '233', 'Los Angeles', 'Sound Nightclub', '34.100990', '-118.336121', '2014-04-07 06:00:58', '', '3', '13132-sound-nightclub');
INSERT INTO `venue` VALUES ('13133', 'Coachella ', null, '233', 'California', 'Coachella ', '37.908890', '-79.587219', '2014-04-07 06:00:58', '', '3', '13133-coachella-');
INSERT INTO `venue` VALUES ('13134', 'Harlot', null, '233', 'San Francisco', 'Harlot', '37.775002', '-122.418335', '2014-04-07 06:00:58', '', '3', '13134-harlot');
INSERT INTO `venue` VALUES ('13135', 'Circus', null, '110', 'Osaka-Shi', 'Circus', '34.666668', '135.500000', '2014-04-07 06:00:58', '', '3', '13135-circus');
INSERT INTO `venue` VALUES ('13136', 'Mago', null, '110', 'Nagoya', 'Mago', '35.166668', '136.916672', '2014-04-07 06:00:58', '', '3', '13136-mago');
INSERT INTO `venue` VALUES ('13137', 'Womb', null, '110', 'Tokyo', 'Womb', '35.658867', '139.707520', '2014-04-07 06:00:58', '', '3', '13137-womb');
INSERT INTO `venue` VALUES ('13138', 'Robert Johnson', null, '81', 'Offenbach', 'Robert Johnson', '50.111580', '8.739014', '2014-04-07 06:00:58', '', '3', '13138-robert-johnson');
INSERT INTO `venue` VALUES ('13139', 'Red Bull Music Academy', null, '81', 'Hamburg', 'Red Bull Music Academy', '53.549999', '10.000000', '2014-04-07 06:00:58', '', '3', '13139-red-bull-music-academy');
INSERT INTO `venue` VALUES ('13140', 'LIFE FESTIVAL', null, '105', 'Dublin', 'LIFE FESTIVAL', '53.348068', '-6.248274', '2014-04-07 06:00:58', '', '3', '13140-life-festival');
INSERT INTO `venue` VALUES ('13141', 'Loves Saves The Day', null, '232', 'Bristol', 'Loves Saves The Day', '51.450001', '-2.583333', '2014-04-07 06:00:58', '', '3', '13141-loves-saves-the-day');
INSERT INTO `venue` VALUES ('13142', 'We Are FSTVL', null, '232', 'Upminster', 'We Are FSTVL', '51.555916', '0.248894', '2014-04-07 06:00:58', '', '3', '13142-we-are-fstvl');
INSERT INTO `venue` VALUES ('13143', 'LA SUCRIERE', null, '74', 'Lyon', 'LA SUCRIERE', '45.737537', '4.815254', '2014-04-07 06:00:58', '', '3', '13143-la-sucriere');
INSERT INTO `venue` VALUES ('13144', 'Output', null, '233', 'New York', 'Output', '40.722111', '-73.957603', '2014-04-07 06:00:58', '', '3', '13144-output');
INSERT INTO `venue` VALUES ('13145', 'Perspectives on friskyRadio', null, '233', 'New York', 'Perspectives on friskyRadio', '40.714550', '-74.007126', '2014-04-07 06:00:59', '', '3', '13145-perspectives-on-friskyradio');
INSERT INTO `venue` VALUES ('13146', 'NetherlandsAmsterdam', null, '155', 'Amsterdam', '', '52.366905', '4.811004', '2014-04-07 07:00:11', '192301757471510', '1', '13146-netherlandsamsterdam');
INSERT INTO `venue` VALUES ('13147', '', null, null, '', '', '50.514515', '11.734256', '2014-04-07 07:00:12', '512396648787067', '1', '13147');
INSERT INTO `venue` VALUES ('13148', 'SwitzerlandZürich', null, '213', 'Zürich', 'Hardstrasse 219', '47.386860', '8.516745', '2014-04-07 07:00:13', '147878375223343', '1', '13148-switzerlandz-rich');
INSERT INTO `venue` VALUES ('13149', 'SwitzerlandBasel', null, '213', 'Basel', 'Münchensteinerstrasse 81', '47.539944', '7.606642', '2014-04-07 07:00:16', '274760569275426', '1', '13149-switzerlandbasel');
INSERT INTO `venue` VALUES ('13150', 'GermanyCologne', null, '81', 'Cologne', 'Hornstraße 85', '50.954700', '6.937799', '2014-04-07 07:00:18', '213100655367870', '1', '13150-germanycologne');
INSERT INTO `venue` VALUES ('13151', 'GermanyCologne', null, '81', 'Cologne', 'Hornstraße 85', '50.954700', '6.937799', '2014-04-07 07:00:19', '213100655367870', '1', '13151-germanycologne');
INSERT INTO `venue` VALUES ('13152', 'GermanyCologne', null, '81', 'Cologne', 'Hornstraße 85', '50.954700', '6.937799', '2014-04-07 07:00:20', '213100655367870', '1', '13152-germanycologne');
INSERT INTO `venue` VALUES ('13153', 'SwitzerlandSankt Gallen', null, '213', 'Sankt Gallen', '', '47.418827', '9.365060', '2014-04-07 07:00:22', '133473760037746', '1', '13153-switzerlandsankt-gallen');
INSERT INTO `venue` VALUES ('13154', 'SwitzerlandSolothurn', null, '213', 'Solothurn', 'Kofmehlweg 1', '47.200642', '7.528405', '2014-04-07 07:00:23', '154873827862235', '1', '13154-switzerlandsolothurn');
INSERT INTO `venue` VALUES ('13155', 'FranceParis', null, '74', 'Paris', 'Bois de Vincennes, Avenue de Nogent', '48.838245', '2.459584', '2014-04-07 07:00:24', '111655205586370', '1', '13155-franceparis');
INSERT INTO `venue` VALUES ('13156', 'SwitzerlandWinterthur', null, '213', 'Winterthur', 'Untere Vogelsangstrasse 6', '47.497524', '8.722539', '2014-04-07 07:00:25', '156475614381188', '1', '13156-switzerlandwinterthur');
INSERT INTO `venue` VALUES ('13157', 'AustriaVienna', null, '15', 'Vienna', 'Spittelauer Lände 12', '48.234669', '16.361364', '2014-04-07 07:00:26', '224214104258989', '1', '13157-austriavienna');
INSERT INTO `venue` VALUES ('13158', 'GermanyStuttgart', null, '81', 'Stuttgart', 'Innerer Nordbahnhof 1', '48.799351', '9.185092', '2014-04-07 07:00:28', '118803817592', '1', '13158-germanystuttgart');
INSERT INTO `venue` VALUES ('13159', 'SwitzerlandLausanne', null, '213', 'Lausanne', 'place centrale ', '46.520794', '6.630784', '2014-04-07 07:00:29', '14387438604', '1', '13159-switzerlandlausanne');
INSERT INTO `venue` VALUES ('13160', 'GermanyMunich', null, '81', 'Munich', 'Maximiliansplatz 5', '48.142090', '11.570022', '2014-04-07 07:00:30', '104431824712', '1', '13160-germanymunich');
INSERT INTO `venue` VALUES ('13161', 'NetherlandsAmsterdam', null, '155', 'Amsterdam', 'TT Neveritaweg 61', '52.401459', '4.895979', '2014-04-07 07:00:31', '134178166598046', '1', '13161-netherlandsamsterdam');
INSERT INTO `venue` VALUES ('13162', 'GermanyErfurt', null, '81', 'Erfurt', 'Anger 7', '50.976128', '11.035702', '2014-04-07 07:00:32', '130613083652743', '1', '13162-germanyerfurt');
INSERT INTO `venue` VALUES ('13163', 'IrelandMullingar', null, '105', 'Mullingar', 'Belvedere House Park & Gardens', '53.472855', '-7.370599', '2014-04-07 07:00:43', '8332098685', '1', '13163-irelandmullingar');
INSERT INTO `venue` VALUES ('13164', 'SpainIbiza', null, '206', 'Ibiza', '5 Carrier De Les Alzines', '38.892914', '1.407052', '2014-04-07 07:00:44', '217585614933058', '1', '13164-spainibiza');
INSERT INTO `venue` VALUES ('13165', 'ArgentinaBuenos Aires', null, '11', 'Buenos Aires', 'Marcelino Freyre (Alt Av Del Libertador 3800) Paseo de la Infanta Palermo', '-34.616798', '-58.379959', '2014-04-07 07:00:47', '237118213069319', '1', '13165-argentinabuenos-aires');
INSERT INTO `venue` VALUES ('13166', 'ArgentinaCórdoba', null, '11', 'Córdoba', 'Marcelo T. de Alvear 605', '-31.421705', '-64.192299', '2014-04-07 07:00:48', '191819074361331', '1', '13166-argentinac-rdoba');
INSERT INTO `venue` VALUES ('13167', 'ChileSantiago', null, '44', 'Santiago', '', '-33.421791', '-70.647568', '2014-04-07 07:00:49', '215243228501700', '1', '13167-chilesantiago');
INSERT INTO `venue` VALUES ('13168', 'SpainBarcelona', null, '206', 'Barcelona', '', '41.377975', '2.173656', '2014-04-07 07:00:51', '523348624438931', '1', '13168-spainbarcelona');
INSERT INTO `venue` VALUES ('13169', 'United KingdomBirmingham', null, '232', 'Birmingham', '', '52.474712', '-1.880765', '2014-04-07 07:00:54', '163352193679378', '1', '13169-united-kingdombirmingham');
INSERT INTO `venue` VALUES ('13170', '', null, null, '', '', '43.612957', '3.930895', '2014-04-07 07:00:55', '215112921842209', '1', '13170');
INSERT INTO `venue` VALUES ('13171', 'PortugalPorto', null, '177', 'Porto', 'Av. Brasil, 843', '41.159134', '-8.683368', '2014-04-07 07:00:56', '134772079872136', '1', '13171-portugalporto');
INSERT INTO `venue` VALUES ('13172', 'United KingdomLeeds', null, '232', 'Leeds', '8a Harrison Street  ', '53.799664', '-1.541090', '2014-04-07 07:00:57', '127162823960945', '1', '13172-united-kingdomleeds');
INSERT INTO `venue` VALUES ('13173', 'FranceParis', null, '74', 'Paris', '142 rue Montmartre', '48.868904', '2.343252', '2014-04-07 07:00:58', '15720667841', '1', '13173-franceparis');
INSERT INTO `venue` VALUES ('13174', 'BelgiumHerentals', null, '22', 'Herentals', 'NETEPARK', '51.186691', '4.828865', '2014-04-07 07:00:59', '176798255701015', '1', '13174-belgiumherentals');
INSERT INTO `venue` VALUES ('13175', 'GermanyMannheim', null, '81', 'Mannheim', 'Q 5 Passage, 14-22', '49.487263', '8.470936', '2014-04-07 07:01:00', '111087715580609', '1', '13175-germanymannheim');
INSERT INTO `venue` VALUES ('13176', 'PortugalLisbon', null, '177', 'Lisbon', 'Terreiro do Paço', '38.708179', '-9.133609', '2014-04-07 07:01:02', '164432340364357', '1', '13176-portugallisbon');
INSERT INTO `venue` VALUES ('13177', 'United StatesIndio', null, '233', 'Indio', '81-800 Avenue 51 ', '33.683983', '-116.238220', '2014-04-07 07:01:04', '159227787472135', '1', '13177-united-statesindio');
INSERT INTO `venue` VALUES ('13178', 'United StatesIndio', null, '233', 'Indio', '81-800 Avenue 51 ', '33.683983', '-116.238220', '2014-04-07 07:01:06', '159227787472135', '1', '13178-united-statesindio');
INSERT INTO `venue` VALUES ('13179', '', null, null, '', '', '48.599998', '17.833300', '2014-04-07 07:01:21', '106095579429553', '1', '13179');
INSERT INTO `venue` VALUES ('13180', '', null, null, '', '', '50.400002', '3.783330', '2014-04-07 07:01:23', '104035676300234', '1', '13180');
INSERT INTO `venue` VALUES ('13181', '', null, null, '', '', '40.000000', '-4.000000', '2014-04-07 07:01:25', '113019615379046', '1', '13181');
INSERT INTO `venue` VALUES ('13182', '', null, null, '', '', '52.500599', '13.398900', '2014-04-07 07:01:26', '111175118906315', '1', '13182');
INSERT INTO `venue` VALUES ('13183', '', null, null, '', '', '43.170971', '16.441063', '2014-04-07 07:01:27', '104646139573573', '1', '13183');
INSERT INTO `venue` VALUES ('13184', '', null, null, '', '', '52.250000', '21.000000', '2014-04-07 07:01:28', '108126032553728', '1', '13184');
INSERT INTO `venue` VALUES ('13185', '', null, null, '', '', '47.083302', '2.400000', '2014-04-07 07:01:29', '104144552954355', '1', '13185');
INSERT INTO `venue` VALUES ('13186', '', null, null, '', '', '48.900002', '2.200000', '2014-04-07 07:01:30', '106472546054468', '1', '13186');
INSERT INTO `venue` VALUES ('13187', '', null, null, '', '', '46.199093', '6.787693', '2014-04-07 07:01:31', '172347099470904', '1', '13187');
INSERT INTO `venue` VALUES ('13188', '', null, null, '', '', '49.716759', '6.010380', '2014-04-07 07:02:12', '112608658817458', '1', '13188');
INSERT INTO `venue` VALUES ('13189', 'AustriaFeldkirch', null, '15', 'Feldkirch', 'Reichenfeldgasse 9', '47.234634', '9.594576', '2014-04-07 07:02:13', '87120100839', '1', '13189-austriafeldkirch');
INSERT INTO `venue` VALUES ('13190', '', null, null, '', '', '46.928627', '7.447008', '2014-04-07 07:02:15', '219319758111495', '1', '13190');
INSERT INTO `venue` VALUES ('13191', 'GermanyGräfenhainchen', null, '81', 'Gräfenhainchen', '', '51.749557', '12.437821', '2014-04-07 07:02:16', '282061528916', '1', '13191-germanygr-fenhainchen');
INSERT INTO `venue` VALUES ('13192', '', null, null, '', '', '53.157120', '9.520916', '2014-04-07 07:02:17', '175313575862635', '1', '13192');
INSERT INTO `venue` VALUES ('13193', 'GermanyDuisburg', null, '81', 'Duisburg', 'Emscherstraße 71', '51.480572', '6.782448', '2014-04-07 07:02:18', '118471148171871', '1', '13193-germanyduisburg');
INSERT INTO `venue` VALUES ('13194', '', null, null, '', '', '47.973476', '8.899998', '2014-04-07 07:02:19', '122294961188707', '1', '13194');
INSERT INTO `venue` VALUES ('13195', 'GermanySalching', null, '81', 'Salching', '', '48.822098', '12.572202', '2014-04-07 07:02:20', '351704394897051', '1', '13195-germanysalching');
INSERT INTO `venue` VALUES ('13196', 'GermanyBerlin', null, '81', 'Berlin', 'Linienstraße 227', '52.526821', '13.411818', '2014-04-07 07:02:21', '402392196496892', '1', '13196-germanyberlin');
INSERT INTO `venue` VALUES ('13197', 'GermanyCottbus', null, '81', 'Cottbus', 'Berliner Platz 6', '51.761494', '14.330479', '2014-04-07 07:02:22', '149789088435518', '1', '13197-germanycottbus');
INSERT INTO `venue` VALUES ('13198', 'SwitzerlandZürich', null, '213', 'Zürich', 'Schiffbaustrasse 4', '47.388798', '8.519220', '2014-04-07 07:02:24', '143399335704437', '1', '13198-switzerlandz-rich');
INSERT INTO `venue` VALUES ('13199', 'Lacuna Artist Lofts', null, '233', 'Chicago', 'Lacuna Artist Lofts', '41.849998', '-87.650002', '2014-04-08 06:00:03', '', '3', '13199-lacuna-artist-lofts');
INSERT INTO `venue` VALUES ('13200', 'Monarch Theatre', null, '233', 'Phoenix', 'Monarch Theatre', '33.448215', '-112.072166', '2014-04-08 06:00:03', '', '3', '13200-monarch-theatre');
INSERT INTO `venue` VALUES ('13201', 'Public Works', null, '233', 'San Francisco', 'Public Works', '37.769100', '-122.419411', '2014-04-08 06:00:03', '', '3', '13201-public-works');
INSERT INTO `venue` VALUES ('13202', 'Spaarnwoude', null, '155', 'Spaarndam', 'Spaarnwoude', '52.403999', '4.695030', '2014-04-08 06:00:03', '', '3', '13202-spaarnwoude');
INSERT INTO `venue` VALUES ('13203', 'Montreux Jazz Lab', null, '213', 'Montreux', 'Montreux Jazz Lab', '46.433334', '6.916667', '2014-04-08 06:00:03', '', '3', '13203-montreux-jazz-lab');

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
  KEY `fk_venue_file_venue_id` (`venue_id`) USING BTREE,
  KEY `fk_venue_file_file_id` (`file_id`) USING BTREE,
  CONSTRAINT `venue_file_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venue` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `venue_file_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of venue_file
-- ----------------------------

-- ----------------------------
-- Procedure structure for GET_ARTIST_MAP_DATA
-- ----------------------------
DROP PROCEDURE IF EXISTS `GET_ARTIST_MAP_DATA`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GET_ARTIST_MAP_DATA`(IN `_id` int)
BEGIN
                SELECT g.datetime, g.`name`, v.`name` as venue, v.latitude, v.longitude
                FROM artist_gig ag
                JOIN gig g ON g.id = ag.gig_id
                JOIN venue v ON v.id = g.venue_id
                WHERE ag.artist_id = _id
                ORDER BY g.datetime ASC;
            END
;;
DELIMITER ;

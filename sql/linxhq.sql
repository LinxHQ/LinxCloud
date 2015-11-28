-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 13, 2015 at 05:05 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hqaccounts_linxcircle`
--

-- --------------------------------------------------------

--
-- Table structure for table `linx_account`
--

CREATE TABLE IF NOT EXISTS `linx_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_username` char(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Email or username',
  `account_password` char(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'encrypted',
  `account_last_update` datetime NOT NULL,
  `account_created_date` datetime NOT NULL,
  `account_status` int(1) NOT NULL COMMENT '0 inactive, 1 active',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

--
-- Dumping data for table `linx_account`
--

INSERT INTO `linx_account` (`account_id`, `account_username`, `account_password`, `account_last_update`, `account_created_date`, `account_status`) VALUES
(1, 'admin', '$2a$13$/lsJhIQSmOWvgObq0844FuP1vbtxO6dYWgtlIrivzugjPTQyP3vqW', '0000-00-00 00:00:00', '2013-02-22 00:00:00', 1),
(40, 'joseph.pnc@lionsoftwaresolutions.com', '$2a$13$o1CFxHtQ98Zpz0Vimd29t.vLJ7t25n4BrCc0EdvIdSaVqF7Pib6fa', '0000-00-00 00:00:00', '2013-03-12 00:06:00', 1),
(41, 'useradmin1@linxhq.com', '$2a$13$HgX/kP6DQz5emVcKnHXmS.8k8EV7ab/b3cyNNuN/r9hjzV.HIWWSK', '2015-03-16 16:04:00', '2015-03-16 16:04:00', 1),
(42, 'useradmin2@linxhq.com', '$2a$13$19/dDaILStD/maaK/aZwxOSUgVj3erpjDHZ5LEJE.IfIReTAJgBMe', '2015-03-16 16:08:00', '2015-03-16 16:08:00', 1),
(43, 'useradmin3@linxhq.com', '$2a$13$2IFN9X8e3uVA.QDpfflFi.AjKBXYcpeYa5wsOe.p2L6rAH3DrpmHi', '2015-03-16 16:09:00', '2015-03-16 16:09:00', 1),
(44, 'useradmin4@linxhq.com.vn', '$2a$13$LkJ5SbLmf0f2kOdp0I6xg.kecOegTYecnRQFs3GUwBO/HQqqIWT1C', '2015-03-18 04:00:00', '2015-03-16 16:13:00', 1),
(45, 'usertest1@linxhq.com', '$2a$13$bwh44geEq3vzK0wFTo5f6.QRRgVY65sgqOJp38b49ae/GNfhBXOzG', '2015-03-16 16:14:00', '2015-03-16 16:14:00', 1),
(46, 'usertest2@linxhq.com', '$2a$13$ifsWnYsKKwfvrHOCVjnXuOzVx59vYZTb.NG9Xf3VH14EWH5ocXmKi', '2015-03-18 03:56:00', '2015-03-17 10:57:00', 1),
(47, 'usertest3@linxhq.com', '$2a$13$mkxRcVvg7DwZwukrzYkKq.d.jGDKTmQuNzdt6V6PXBHJjkmw9gccq', '2015-03-18 10:57:00', '2015-03-18 10:57:00', 1),
(48, 'usertest4@linxhq.com', '$2a$13$plfRGu9AtVIhIWIX7IgkJuJJKHIiywS5VJMFw9OB35/ACncdrD3Ui', '2015-03-18 10:57:00', '2015-03-18 10:57:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `linx_account_profile`
--

CREATE TABLE IF NOT EXISTS `linx_account_profile` (
  `account_profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL COMMENT 'FK',
  `account_profile_fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_profile_given_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_profile_surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_profile_dob` date DEFAULT NULL,
  PRIMARY KEY (`account_profile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `linx_account_profile`
--

INSERT INTO `linx_account_profile` (`account_profile_id`, `account_id`, `account_profile_fullname`, `account_profile_given_name`, `account_profile_surname`, `account_profile_dob`) VALUES
(4, 40, 'Joseph Pham', 'Joseph', 'Pham', '0000-00-00'),
(5, 1, 'Administrator', 'Mr', 'Admin', '0000-00-00'),
(6, 43, 'User Admin 3', 'User', 'Admin 3', NULL),
(7, 44, 'User Admin 4', 'User givename test', 'Admin 4 test', '0000-00-00'),
(8, 45, 'User Test 1', 'User', 'Test 1', NULL),
(9, 46, 'User Test 2', 'User', 'Test 2 updated by useradmin', '0000-00-00'),
(10, 47, 'User Test 3', 'User', 'Test 3', NULL),
(11, 48, 'User Test 4', 'User', 'Test 4', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `linx_app`
--

CREATE TABLE IF NOT EXISTS `linx_app` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_gui_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_short_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_secret_identity` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `app_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `linx_app`
--

INSERT INTO `linx_app` (`app_id`, `app_name`, `app_gui_name`, `app_short_description`, `app_secret_identity`, `app_url`) VALUES
(1, 'projects', 'Projects', 'Projects Management System', 'cfe077d021a66ac00eab6408003bc2a8', 'http://projects.linxcircle.com'),
(2, 'hrms', 'HRMS', 'Human Resource Management System', 'fce2c061bda48fafdc7ccf49e16402fb', 'http://people.linxcircle.com'),
(3, 'accounting', 'Accounting', 'Linx Accounting', '65d6cb590a49da6a33aebfbea06989f8', 'http://finance.linxcircle.com'),
(4, 'accounts', 'Accounts', 'Linx Accounts', '2c755f3b5ac1f2b6224cc8f2c083c7ac', 'http://hqaccounts.linxcircle.com'),
(5, 'crm', 'CRM', 'Linx CRM', '2c755f3b5ac1f2b6221234f2c083c7ac', 'http://crm.linxcircle.com');

-- --------------------------------------------------------

--
-- Table structure for table `linx_app_access_list`
--

CREATE TABLE IF NOT EXISTS `linx_app_access_list` (
  `al_id` int(11) NOT NULL AUTO_INCREMENT,
  `al_app_id` int(11) NOT NULL,
  `al_account_id` int(11) NOT NULL,
  `al_access_code` int(2) NOT NULL COMMENT '1: allowed, 0: not allowed',
  PRIMARY KEY (`al_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `linx_app_access_list`
--

INSERT INTO `linx_app_access_list` (`al_id`, `al_app_id`, `al_account_id`, `al_access_code`) VALUES
(2, 2, 44, 1),
(4, 3, 44, 1),
(5, 1, 46, 1),
(6, 1, 47, 1),
(7, 2, 47, 1),
(8, 2, 48, 1),
(9, 3, 48, 1),
(10, 1, 40, 1),
(11, 5, 40, 1),
(12, 2, 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `linx_config`
--

CREATE TABLE IF NOT EXISTS `linx_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lc_name` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `lc_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `linx_config`
--

INSERT INTO `linx_config` (`id`, `lc_name`, `lc_value`) VALUES
(1, 'LINXHQ_COOKIE_SECRET_VARIABLE_NAME', 'LINX_SESSION_VAR'),
(2, 'LINXHQ_ROOT_DOMAIN', '.linxcircle.com');

-- --------------------------------------------------------

--
-- Table structure for table `linx_permission`
--

CREATE TABLE IF NOT EXISTS `linx_permission` (
  `lp_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL COMMENT 'FK',
  `lp_permission_name` char(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '<model_action_ownership>: account_update_all, account_update_own, account_add, ....',
  `lp_permission_status` int(1) NOT NULL COMMENT '1: allowed, 0: not allowed',
  PRIMARY KEY (`lp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

--
-- Dumping data for table `linx_permission`
--

INSERT INTO `linx_permission` (`lp_id`, `account_id`, `lp_permission_name`, `lp_permission_status`) VALUES
(1, 40, 'account_add', 1),
(2, 44, 'account_list', 1),
(3, 44, 'account_view_any', 1),
(4, 44, 'account_update_own', 1),
(5, 44, 'account_add', 1),
(6, 44, 'account_update_any', 1),
(7, 45, 'account_list', 1),
(8, 45, 'account_view_any', 1),
(9, 45, 'account_update_own', 1),
(10, 46, 'account_list', 1),
(11, 46, 'account_view_any', 1),
(12, 46, 'account_profile_view_any', 1),
(13, 46, 'account_profile_view_own', 1),
(14, 44, 'account_profile_update_own', 1),
(15, 46, 'account_password_update_own', 1),
(16, 44, 'account_password_update_own', 1),
(17, 44, 'account_profile_view_any', 1),
(18, 44, 'account_password_update_any', 1),
(19, 44, 'account_profile_update_any', 1),
(20, 46, 'account_profile_update_own', 1),
(21, 47, 'account_list', 1),
(22, 47, 'account_view_any', 1),
(23, 47, 'account_password_update_own', 1),
(24, 47, 'account_profile_view_any', 1),
(25, 47, 'account_profile_view_own', 1),
(26, 47, 'account_profile_update_own', 1),
(27, 48, 'account_list', 1),
(28, 48, 'account_view_any', 1),
(29, 48, 'account_password_update_own', 1),
(30, 48, 'account_profile_view_any', 1),
(31, 48, 'account_profile_view_own', 1),
(32, 48, 'account_profile_update_own', 1);

-- --------------------------------------------------------

--
-- Table structure for table `linx_session`
--

CREATE TABLE IF NOT EXISTS `linx_session` (
  `id` char(32) NOT NULL,
  `session_cookie_secret_value` char(100) DEFAULT NULL,
  `start` int(11) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` blob,
  `account_id` int(11) DEFAULT NULL,
  `browser_info` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `linx_session`
--

INSERT INTO `linx_session` (`id`, `session_cookie_secret_value`, `start`, `expire`, `data`, `account_id`, `browser_info`) VALUES
('0mo1ooa2pmvm1mrti56tkits43', NULL, 1429090613, 1451036213, '', NULL, 'firefox 37.0 mac\n'),
('1fb2dc46cd0a3cfb01af56e8cb8550ff', '', 1426753527, 1448699127, '', NULL, 'chrome 537.36 mac\n'),
('3qr1brccgbrlvvtedp0phkqhf7', NULL, 1429169407, 1451115007, '', NULL, 'firefox 6.0 windows\n'),
('4jpl7l4li0vf0i74kh45nnjto4', NULL, 1431598760, 1453544360, '', NULL, 'firefox 37.0 mac\n'),
('50bedphle381vdmb04omujb4s6', NULL, 1431598762, 1453544362, '', NULL, 'firefox 37.0 mac\n'),
('6vq38396dd37b4km7cv7skvru1', NULL, 1430103092, 1452048692, '', NULL, 'firefox 6.0 windows\n'),
('7b4tk6eaiiin3ua8rc72dfoat7', NULL, 1428462537, 1450408137, '', NULL, 'firefox 6.0 windows\n'),
('84rbofuou364b70oe5p5ok98c0', NULL, 1431595921, 1453541521, '', NULL, 'firefox 37.0 mac\n'),
('8729681298760f8281e08afa59659a63', NULL, 1427429893, 1449375493, '', NULL, 'firefox 36.0 mac\n'),
('8n2ml82k1fr62uknmp3ugnfc42', NULL, 1429610747, 1451556347, '', NULL, 'firefox 6.0 windows\n'),
('a9b1v7aa8cq8p6p2uvf871l7s3', NULL, 1429002151, 1450947751, '', NULL, 'firefox 37.0 mac\n'),
('b0sm099lsarlno1odgmngku9m5', NULL, 1427516255, 1449461855, '', NULL, 'unrecognized unknown unrecognized\n'),
('b2cb4a91ce267bcc895cf32a604959b8', 'ee8edfd442ce5b7a5a411104e4f2c54c', 1426753757, 1448699357, 0x64386438653337393065383433653239633662333036623962663931336631305f5f69647c733a323a223438223b64386438653337393065383433653239633662333036623962663931336631305f5f6e616d657c733a32303a22757365727465737434406c696e7868712e636f6d223b64386438653337393065383433653239633662333036623962663931336631306163636f756e745f656d61696c7c733a32303a22757365727465737434406c696e7868712e636f6d223b64386438653337393065383433653239633662333036623962663931336631306163636f756e745f70726f66696c655f7375726e616d657c733a363a22546573742034223b64386438653337393065383433653239633662333036623962663931336631306163636f756e745f70726f66696c655f676976656e5f6e616d657c733a343a2255736572223b64386438653337393065383433653239633662333036623962663931336631306163636f756e745f70726f66696c655f66756c6c6e616d657c733a31313a225573657220546573742034223b64386438653337393065383433653239633662333036623962663931336631306163636f756e745f70726f66696c655f73686f72745f6e616d657c733a373a225573657220542e223b64386438653337393065383433653239633662333036623962663931336631305f5f7374617465737c613a353a7b733a31333a226163636f756e745f656d61696c223b623a313b733a32333a226163636f756e745f70726f66696c655f7375726e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f676976656e5f6e616d65223b623a313b733a32343a226163636f756e745f70726f66696c655f66756c6c6e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f73686f72745f6e616d65223b623a313b7d, 48, 'firefox 36.0 mac\n'),
('b765lekaifv8etk78di3i4b2g7', NULL, 1428392073, 1450337673, '', NULL, 'firefox 6.0 windows\n'),
('clqalanmra1cj3ucol2htck597', NULL, 1431598761, 1453544361, '', NULL, 'firefox 37.0 mac\n'),
('d1u9efk322c5b96jhgpfck10n2', '15a1cd76c7fe331021a0ece409368c91', 1429000082, 1450945682, 0x38323638353262363130653133643931656638323835303538393766626539395f5f69647c733a323a223430223b38323638353262363130653133643931656638323835303538393766626539395f5f6e616d657c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f656d61696c7c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f7375726e616d657c733a343a225068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f676976656e5f6e616d657c733a363a224a6f73657068223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f66756c6c6e616d657c733a31313a224a6f73657068205068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f73686f72745f6e616d657c733a393a224a6f7365706820502e223b38323638353262363130653133643931656638323835303538393766626539395f5f7374617465737c613a353a7b733a31333a226163636f756e745f656d61696c223b623a313b733a32333a226163636f756e745f70726f66696c655f7375726e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f676976656e5f6e616d65223b623a313b733a32343a226163636f756e745f70726f66696c655f66756c6c6e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f73686f72745f6e616d65223b623a313b7d, 40, 'chrome 537.36 mac\n'),
('etnegnr6g34cn4ftae99ut37p6', NULL, 1439454429, 1461400029, '', NULL, 'firefox 39.0 mac\n'),
('f3ps24dgpkugvkgd9p7a47dol6', '032a35a5e59a78308b3fca2e9bed63d5', 1429091323, 1451036923, 0x38323638353262363130653133643931656638323835303538393766626539395f5f69647c733a323a223430223b38323638353262363130653133643931656638323835303538393766626539395f5f6e616d657c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f656d61696c7c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f7375726e616d657c733a343a225068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f676976656e5f6e616d657c733a363a224a6f73657068223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f66756c6c6e616d657c733a31313a224a6f73657068205068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f73686f72745f6e616d657c733a393a224a6f7365706820502e223b38323638353262363130653133643931656638323835303538393766626539395f5f7374617465737c613a353a7b733a31333a226163636f756e745f656d61696c223b623a313b733a32333a226163636f756e745f70726f66696c655f7375726e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f676976656e5f6e616d65223b623a313b733a32343a226163636f756e745f70726f66696c655f66756c6c6e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f73686f72745f6e616d65223b623a313b7d, 40, 'firefox 37.0 mac\n'),
('gojhvo4c1n06bketjrah2eorr5', 'c2c959c3c4a28f672ddd54866115c240', 1429086207, 1451031807, 0x38323638353262363130653133643931656638323835303538393766626539395f5f69647c733a323a223430223b38323638353262363130653133643931656638323835303538393766626539395f5f6e616d657c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f656d61696c7c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f7375726e616d657c733a343a225068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f676976656e5f6e616d657c733a363a224a6f73657068223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f66756c6c6e616d657c733a31313a224a6f73657068205068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f73686f72745f6e616d657c733a393a224a6f7365706820502e223b38323638353262363130653133643931656638323835303538393766626539395f5f7374617465737c613a353a7b733a31333a226163636f756e745f656d61696c223b623a313b733a32333a226163636f756e745f70726f66696c655f7375726e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f676976656e5f6e616d65223b623a313b733a32343a226163636f756e745f70726f66696c655f66756c6c6e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f73686f72745f6e616d65223b623a313b7d, 40, 'firefox 37.0 mac\n'),
('gv3jg56og4dako08oifvdnrif7', NULL, 1427795067, 1449740666, '', NULL, 'firefox 6.0 windows\n'),
('hkffc0412glfk9jr4bt7e9k1a4', '1be40e62b8a1e55e814ca48d5b265170', 1429082510, 1451028110, 0x38323638353262363130653133643931656638323835303538393766626539395f5f69647c733a323a223430223b38323638353262363130653133643931656638323835303538393766626539395f5f6e616d657c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f656d61696c7c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f7375726e616d657c733a343a225068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f676976656e5f6e616d657c733a363a224a6f73657068223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f66756c6c6e616d657c733a31313a224a6f73657068205068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f73686f72745f6e616d657c733a393a224a6f7365706820502e223b38323638353262363130653133643931656638323835303538393766626539395f5f7374617465737c613a353a7b733a31333a226163636f756e745f656d61696c223b623a313b733a32333a226163636f756e745f70726f66696c655f7375726e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f676976656e5f6e616d65223b623a313b733a32343a226163636f756e745f70726f66696c655f66756c6c6e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f73686f72745f6e616d65223b623a313b7d, 40, 'chrome 537.36 mac\n'),
('inupuuaeltitqe4h12cmp4upi5', NULL, 1427688989, 1449634589, '', NULL, 'firefox 36.0 mac\n'),
('itrm3rmi6mi3vf5svlpna1tks5', NULL, 1429452984, 1451398584, '', NULL, 'firefox 6.0 windows\n'),
('j9ufmabj4u00m9lip3poeucb81', NULL, 1429860160, 1451805760, '', NULL, 'firefox 6.0 windows\n'),
('kgpis1ah52q1d04r7sm1uua2o5', NULL, 1429000670, 1450946270, '', NULL, 'firefox 6.0 windows\n'),
('ll97mnpb8a02c789pelu8d4uc0', '05f163940be9932c5b371e260458291f', 1429092032, 1451037632, 0x38323638353262363130653133643931656638323835303538393766626539395f5f69647c733a323a223430223b38323638353262363130653133643931656638323835303538393766626539395f5f6e616d657c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f656d61696c7c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f7375726e616d657c733a343a225068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f676976656e5f6e616d657c733a363a224a6f73657068223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f66756c6c6e616d657c733a31313a224a6f73657068205068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f73686f72745f6e616d657c733a393a224a6f7365706820502e223b38323638353262363130653133643931656638323835303538393766626539395f5f7374617465737c613a353a7b733a31333a226163636f756e745f656d61696c223b623a313b733a32333a226163636f756e745f70726f66696c655f7375726e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f676976656e5f6e616d65223b623a313b733a32343a226163636f756e745f70726f66696c655f66756c6c6e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f73686f72745f6e616d65223b623a313b7d, 40, 'firefox 37.0 mac\n'),
('m40t7kml8c16i13le4kkm8us75', NULL, 1427691551, 1449637151, '', NULL, 'firefox 6.0 windows\n'),
('m6ka8e6c4ea1iu22tut7nhdd90', NULL, 1429256233, 1451201833, '', NULL, 'firefox 6.0 windows\n'),
('mskd5fbjkntsr9d871fuh9u8s3', NULL, 1429725410, 1451671010, '', NULL, 'firefox 6.0 windows\n'),
('mvls97ira36l41hp14m81qd8u0', '86142aecf5ec2d66f55404ac23c5f6de', 1429091888, 1451037488, 0x38323638353262363130653133643931656638323835303538393766626539395f5f69647c733a323a223430223b38323638353262363130653133643931656638323835303538393766626539395f5f6e616d657c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f656d61696c7c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f7375726e616d657c733a343a225068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f676976656e5f6e616d657c733a363a224a6f73657068223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f66756c6c6e616d657c733a31313a224a6f73657068205068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f73686f72745f6e616d657c733a393a224a6f7365706820502e223b38323638353262363130653133643931656638323835303538393766626539395f5f7374617465737c613a353a7b733a31333a226163636f756e745f656d61696c223b623a313b733a32333a226163636f756e745f70726f66696c655f7375726e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f676976656e5f6e616d65223b623a313b733a32343a226163636f756e745f70726f66696c655f66756c6c6e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f73686f72745f6e616d65223b623a313b7d, 40, 'firefox 37.0 mac\n'),
('nil19u0uico517tqbhrqtgfc82', NULL, 1439454418, 1461400018, '', NULL, 'firefox 39.0 mac\n'),
('op2dqdom8p8iga8kdn9d7ivas5', 'a8e85c5ef95d50edcbac22d83bbd8fc6', 1429002433, 1450948033, 0x38323638353262363130653133643931656638323835303538393766626539395f5f69647c733a323a223430223b38323638353262363130653133643931656638323835303538393766626539395f5f6e616d657c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f656d61696c7c733a33363a226a6f736570682e706e63406c696f6e736f667477617265736f6c7574696f6e732e636f6d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f7375726e616d657c733a343a225068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f676976656e5f6e616d657c733a363a224a6f73657068223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f66756c6c6e616d657c733a31313a224a6f73657068205068616d223b38323638353262363130653133643931656638323835303538393766626539396163636f756e745f70726f66696c655f73686f72745f6e616d657c733a393a224a6f7365706820502e223b38323638353262363130653133643931656638323835303538393766626539395f5f7374617465737c613a353a7b733a31333a226163636f756e745f656d61696c223b623a313b733a32333a226163636f756e745f70726f66696c655f7375726e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f676976656e5f6e616d65223b623a313b733a32343a226163636f756e745f70726f66696c655f66756c6c6e616d65223b623a313b733a32363a226163636f756e745f70726f66696c655f73686f72745f6e616d65223b623a313b7d, 40, 'firefox 37.0 mac\n'),
('tp95of8virj4iad60vf2b4nrc1', NULL, 1430280709, 1452226309, '', NULL, 'firefox 6.0 windows\n'),
('vtubejqpntfeg5pv3mie85uii6', NULL, 1429690268, 1451635868, '', NULL, 'firefox 6.0 windows\n');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
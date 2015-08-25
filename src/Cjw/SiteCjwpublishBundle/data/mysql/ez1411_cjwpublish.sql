-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 25. Aug 2015 um 12:18
-- Server-Version: 5.5.42
-- PHP-Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ez1411_cjwpublish`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezapprove_items`
--

DROP TABLE IF EXISTS `ezapprove_items`;
CREATE TABLE IF NOT EXISTS `ezapprove_items` (
  `collaboration_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `workflow_process_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezbasket`
--

DROP TABLE IF EXISTS `ezbasket`;
CREATE TABLE IF NOT EXISTS `ezbasket` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `productcollection_id` int(11) NOT NULL DEFAULT '0',
  `session_id` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezbinaryfile`
--

DROP TABLE IF EXISTS `ezbinaryfile`;
CREATE TABLE IF NOT EXISTS `ezbinaryfile` (
  `contentobject_attribute_id` int(11) NOT NULL DEFAULT '0',
  `download_count` int(11) NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `mime_type` varchar(255) NOT NULL DEFAULT '',
  `original_filename` varchar(255) NOT NULL DEFAULT '',
  `version` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezbinaryfile`
--

INSERT INTO `ezbinaryfile` (`contentobject_attribute_id`, `download_count`, `filename`, `mime_type`, `original_filename`, `version`) VALUES
(292, 0, '08efab683c7d0982a3c3a97746ae5a18.pdf', 'application/pdf', 'DemoPDF.pdf', 1),
(292, 0, '08efab683c7d0982a3c3a97746ae5a18.pdf', 'application/pdf', 'DemoPDF.pdf', 2),
(295, 0, '08efab683c7d0982a3c3a97746ae5a18.pdf', 'application/pdf', 'DemoPDF.pdf', 3),
(292, 0, '08efab683c7d0982a3c3a97746ae5a18.pdf', 'application/pdf', 'DemoPDF.pdf', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcobj_state`
--

DROP TABLE IF EXISTS `ezcobj_state`;
CREATE TABLE IF NOT EXISTS `ezcobj_state` (
  `default_language_id` bigint(20) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `identifier` varchar(45) NOT NULL DEFAULT '',
  `language_mask` bigint(20) NOT NULL DEFAULT '0',
  `priority` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcobj_state`
--

INSERT INTO `ezcobj_state` (`default_language_id`, `group_id`, `id`, `identifier`, `language_mask`, `priority`) VALUES
(2, 2, 1, 'not_locked', 3, 0),
(2, 2, 2, 'locked', 3, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcobj_state_group`
--

DROP TABLE IF EXISTS `ezcobj_state_group`;
CREATE TABLE IF NOT EXISTS `ezcobj_state_group` (
  `default_language_id` bigint(20) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `identifier` varchar(45) NOT NULL DEFAULT '',
  `language_mask` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcobj_state_group`
--

INSERT INTO `ezcobj_state_group` (`default_language_id`, `id`, `identifier`, `language_mask`) VALUES
(2, 2, 'ez_lock', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcobj_state_group_language`
--

DROP TABLE IF EXISTS `ezcobj_state_group_language`;
CREATE TABLE IF NOT EXISTS `ezcobj_state_group_language` (
  `contentobject_state_group_id` int(11) NOT NULL DEFAULT '0',
  `description` longtext NOT NULL,
  `language_id` bigint(20) NOT NULL DEFAULT '0',
  `real_language_id` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(45) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcobj_state_group_language`
--

INSERT INTO `ezcobj_state_group_language` (`contentobject_state_group_id`, `description`, `language_id`, `real_language_id`, `name`) VALUES
(2, '', 3, 2, 'Lock');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcobj_state_language`
--

DROP TABLE IF EXISTS `ezcobj_state_language`;
CREATE TABLE IF NOT EXISTS `ezcobj_state_language` (
  `contentobject_state_id` int(11) NOT NULL DEFAULT '0',
  `description` longtext NOT NULL,
  `language_id` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(45) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcobj_state_language`
--

INSERT INTO `ezcobj_state_language` (`contentobject_state_id`, `description`, `language_id`, `name`) VALUES
(1, '', 3, 'Not locked'),
(2, '', 3, 'Locked');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcobj_state_link`
--

DROP TABLE IF EXISTS `ezcobj_state_link`;
CREATE TABLE IF NOT EXISTS `ezcobj_state_link` (
  `contentobject_id` int(11) NOT NULL DEFAULT '0',
  `contentobject_state_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcobj_state_link`
--

INSERT INTO `ezcobj_state_link` (`contentobject_id`, `contentobject_state_id`) VALUES
(1, 1),
(4, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(41, 1),
(42, 1),
(45, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(54, 1),
(56, 1),
(57, 1),
(58, 1),
(60, 1),
(61, 1),
(62, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcollab_group`
--

DROP TABLE IF EXISTS `ezcollab_group`;
CREATE TABLE IF NOT EXISTS `ezcollab_group` (
  `created` int(11) NOT NULL DEFAULT '0',
  `depth` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `is_open` int(11) NOT NULL DEFAULT '1',
  `modified` int(11) NOT NULL DEFAULT '0',
  `parent_group_id` int(11) NOT NULL DEFAULT '0',
  `path_string` varchar(255) NOT NULL DEFAULT '',
  `priority` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcollab_item`
--

DROP TABLE IF EXISTS `ezcollab_item`;
CREATE TABLE IF NOT EXISTS `ezcollab_item` (
  `created` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `data_float1` float NOT NULL DEFAULT '0',
  `data_float2` float NOT NULL DEFAULT '0',
  `data_float3` float NOT NULL DEFAULT '0',
  `data_int1` int(11) NOT NULL DEFAULT '0',
  `data_int2` int(11) NOT NULL DEFAULT '0',
  `data_int3` int(11) NOT NULL DEFAULT '0',
  `data_text1` longtext NOT NULL,
  `data_text2` longtext NOT NULL,
  `data_text3` longtext NOT NULL,
  `id` int(11) NOT NULL,
  `modified` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `type_identifier` varchar(40) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcollab_item_group_link`
--

DROP TABLE IF EXISTS `ezcollab_item_group_link`;
CREATE TABLE IF NOT EXISTS `ezcollab_item_group_link` (
  `collaboration_id` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_read` int(11) NOT NULL DEFAULT '0',
  `last_read` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcollab_item_message_link`
--

DROP TABLE IF EXISTS `ezcollab_item_message_link`;
CREATE TABLE IF NOT EXISTS `ezcollab_item_message_link` (
  `collaboration_id` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL DEFAULT '0',
  `message_type` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `participant_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcollab_item_participant_link`
--

DROP TABLE IF EXISTS `ezcollab_item_participant_link`;
CREATE TABLE IF NOT EXISTS `ezcollab_item_participant_link` (
  `collaboration_id` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_read` int(11) NOT NULL DEFAULT '0',
  `last_read` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `participant_id` int(11) NOT NULL DEFAULT '0',
  `participant_role` int(11) NOT NULL DEFAULT '1',
  `participant_type` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcollab_item_status`
--

DROP TABLE IF EXISTS `ezcollab_item_status`;
CREATE TABLE IF NOT EXISTS `ezcollab_item_status` (
  `collaboration_id` int(11) NOT NULL DEFAULT '0',
  `is_active` int(11) NOT NULL DEFAULT '1',
  `is_read` int(11) NOT NULL DEFAULT '0',
  `last_read` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcollab_notification_rule`
--

DROP TABLE IF EXISTS `ezcollab_notification_rule`;
CREATE TABLE IF NOT EXISTS `ezcollab_notification_rule` (
  `collab_identifier` varchar(255) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcollab_profile`
--

DROP TABLE IF EXISTS `ezcollab_profile`;
CREATE TABLE IF NOT EXISTS `ezcollab_profile` (
  `created` int(11) NOT NULL DEFAULT '0',
  `data_text1` longtext NOT NULL,
  `id` int(11) NOT NULL,
  `main_group` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcollab_simple_message`
--

DROP TABLE IF EXISTS `ezcollab_simple_message`;
CREATE TABLE IF NOT EXISTS `ezcollab_simple_message` (
  `created` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `data_float1` float NOT NULL DEFAULT '0',
  `data_float2` float NOT NULL DEFAULT '0',
  `data_float3` float NOT NULL DEFAULT '0',
  `data_int1` int(11) NOT NULL DEFAULT '0',
  `data_int2` int(11) NOT NULL DEFAULT '0',
  `data_int3` int(11) NOT NULL DEFAULT '0',
  `data_text1` longtext NOT NULL,
  `data_text2` longtext NOT NULL,
  `data_text3` longtext NOT NULL,
  `id` int(11) NOT NULL,
  `message_type` varchar(40) NOT NULL DEFAULT '',
  `modified` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentbrowsebookmark`
--

DROP TABLE IF EXISTS `ezcontentbrowsebookmark`;
CREATE TABLE IF NOT EXISTS `ezcontentbrowsebookmark` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `node_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentbrowserecent`
--

DROP TABLE IF EXISTS `ezcontentbrowserecent`;
CREATE TABLE IF NOT EXISTS `ezcontentbrowserecent` (
  `created` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `node_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentbrowserecent`
--

INSERT INTO `ezcontentbrowserecent` (`created`, `id`, `name`, `node_id`, `user_id`) VALUES
(1421101973, 1, 'eZ Publish', 2, 14),
(1437142935, 2, 'WWW Home', 59, 14),
(1439393094, 3, 'Test Ordner 1', 60, 14);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentclass`
--

DROP TABLE IF EXISTS `ezcontentclass`;
CREATE TABLE IF NOT EXISTS `ezcontentclass` (
  `always_available` int(11) NOT NULL DEFAULT '0',
  `contentobject_name` varchar(255) DEFAULT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `identifier` varchar(50) NOT NULL DEFAULT '',
  `initial_language_id` bigint(20) NOT NULL DEFAULT '0',
  `is_container` int(11) NOT NULL DEFAULT '0',
  `language_mask` bigint(20) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `modifier_id` int(11) NOT NULL DEFAULT '0',
  `remote_id` varchar(100) NOT NULL DEFAULT '',
  `serialized_description_list` longtext,
  `serialized_name_list` longtext,
  `sort_field` int(11) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '1',
  `url_alias_name` varchar(255) DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentclass`
--

INSERT INTO `ezcontentclass` (`always_available`, `contentobject_name`, `created`, `creator_id`, `id`, `identifier`, `initial_language_id`, `is_container`, `language_mask`, `modified`, `modifier_id`, `remote_id`, `serialized_description_list`, `serialized_name_list`, `sort_field`, `sort_order`, `url_alias_name`, `version`) VALUES
(1, '<short_name|name>', 1024392098, 14, 1, 'folder', 4, 1, 7, 1421095990, 14, 'a3d405b81be900468eb153d774f4f0d2', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:6:"Folder";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:6:"Folder";}', 1, 1, '', 0),
(0, '<short_title|title>', 1024392098, 14, 2, 'article', 4, 1, 7, 1421095908, 14, 'c15b600eb9198b1924063b5a68758232', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:7:"Article";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:7:"Article";}', 1, 1, '', 0),
(1, '<name>', 1024392098, 14, 3, 'user_group', 4, 1, 7, 1421096028, 14, '25b4268cdcd01921b808a0d854b877ef', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:10:"User group";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:10:"User group";}', 1, 1, '', 0),
(1, '<first_name> <last_name>', 1024392098, 14, 4, 'user', 4, 0, 7, 1421096060, 14, '40faa822edc579b02c25f6bb7beec3ad', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"User";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"User";}', 1, 1, '', 0),
(1, '<name>', 1031484992, 8, 5, 'image', 4, 0, 7, 1421096107, 14, 'f6df12aa74e36230eb675f364fccd25a', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:5:"Image";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Image";}', 1, 1, '', 0),
(0, '<name>', 1052385361, 14, 11, 'link', 4, 0, 7, 1421095859, 14, '74ec6507063150bc813549b22534ad48', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"Link";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Link";}', 1, 1, '', 0),
(1, '<name>', 1052385472, 14, 12, 'file', 4, 0, 7, 1421096145, 14, '637d58bfddf164627bdfd265733280a0', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"File";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"File";}', 1, 1, '', 0),
(0, '<subject>', 1052385685, 14, 13, 'comment', 4, 0, 7, 1421095954, 14, '000c14f4f475e9f2955dedab72799941', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:7:"Comment";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:7:"Comment";}', 1, 1, '', 0),
(1, '<name>', 1081858024, 14, 14, 'common_ini_settings', 4, 0, 7, 1421096219, 14, 'ffedf2e73b1ea0c3e630e42e2db9c900', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:19:"Common ini settings";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:19:"Common ini settings";}', 1, 1, '', 0),
(1, '<title>', 1081858045, 14, 15, 'template_look', 4, 0, 7, 1421096184, 14, '59b43cd9feaaf0e45ac974fb4bbd3f92', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:13:"Template look";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:13:"Template look";}', 1, 1, '', 0),
(0, '<short_title|title>', 1421096640, 14, 16, 'cjw_article', 4, 1, 7, 1439385445, 14, '8222824ff1b5eb9ac249a804a69a5c76', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:7:"Article";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:9:"CJW Seite";}', 8, 1, '<short_title|title>', 0),
(0, '<short_title|title>', 1421096652, 14, 17, 'cjw_folder', 4, 1, 7, 1439385413, 14, '509eafb48b74b8d53dec42f1fbc05e53', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:6:"Folder";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:10:"CJW Ordner";}', 8, 1, '<short_title|title>', 0),
(1, '<title>', 1421096740, 14, 18, 'cjw_file', 4, 0, 7, 1439386524, 14, '7c831557188d69f50a6cc963daf54c23', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:4:"File";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:9:"CJW Datei";}', 8, 1, '<title>', 0),
(1, '<title>', 1421096746, 14, 19, 'cjw_image', 4, 0, 7, 1439386508, 14, 'c12518329e5777e20ef3ebe7889014cc', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:5:"Image";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:8:"CJW Bild";}', 8, 1, '<title>', 0),
(1, '<short_title|title> ', 1421101456, 14, 20, 'cjw_folder_site', 4, 1, 7, 1439386252, 14, 'df6ac42988319bc1f5b65296d1cdd4f7', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:11:"Folder Site";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:15:"CJW Ordner Site";}', 8, 1, '<short_title|title> ', 0),
(0, '<short_title|title>', 1437142531, 14, 21, 'cjw_feedback_form', 4, 1, 7, 1437145838, 14, '96cfa1f16a2a0510b4ebfb4908ce5bd0', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:17:"CJW Feedback Form";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:10:"CJW Ordner";}', 8, 1, '', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentclassgroup`
--

DROP TABLE IF EXISTS `ezcontentclassgroup`;
CREATE TABLE IF NOT EXISTS `ezcontentclassgroup` (
  `created` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `modified` int(11) NOT NULL DEFAULT '0',
  `modifier_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentclassgroup`
--

INSERT INTO `ezcontentclassgroup` (`created`, `creator_id`, `id`, `modified`, `modifier_id`, `name`) VALUES
(1031216928, 14, 1, 1033922106, 14, 'Content'),
(1031216941, 14, 2, 1033922113, 14, 'Users'),
(1032009743, 14, 3, 1033922120, 14, 'Media'),
(1081858024, 14, 4, 1081858024, 14, 'Setup'),
(1421096571, 14, 5, 1421096578, 14, 'CJW');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentclass_attribute`
--

DROP TABLE IF EXISTS `ezcontentclass_attribute`;
CREATE TABLE IF NOT EXISTS `ezcontentclass_attribute` (
  `can_translate` int(11) DEFAULT '1',
  `category` varchar(25) NOT NULL DEFAULT '',
  `contentclass_id` int(11) NOT NULL DEFAULT '0',
  `data_float1` double DEFAULT NULL,
  `data_float2` double DEFAULT NULL,
  `data_float3` double DEFAULT NULL,
  `data_float4` double DEFAULT NULL,
  `data_int1` int(11) DEFAULT NULL,
  `data_int2` int(11) DEFAULT NULL,
  `data_int3` int(11) DEFAULT NULL,
  `data_int4` int(11) DEFAULT NULL,
  `data_text1` varchar(50) DEFAULT NULL,
  `data_text2` varchar(50) DEFAULT NULL,
  `data_text3` varchar(50) DEFAULT NULL,
  `data_text4` varchar(255) DEFAULT NULL,
  `data_text5` longtext,
  `data_type_string` varchar(50) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `identifier` varchar(50) NOT NULL DEFAULT '',
  `is_information_collector` int(11) NOT NULL DEFAULT '0',
  `is_required` int(11) NOT NULL DEFAULT '0',
  `is_searchable` int(11) NOT NULL DEFAULT '0',
  `placement` int(11) NOT NULL DEFAULT '0',
  `serialized_data_text` longtext,
  `serialized_description_list` longtext,
  `serialized_name_list` longtext NOT NULL,
  `version` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=215 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentclass_attribute`
--

INSERT INTO `ezcontentclass_attribute` (`can_translate`, `category`, `contentclass_id`, `data_float1`, `data_float2`, `data_float3`, `data_float4`, `data_int1`, `data_int2`, `data_int3`, `data_int4`, `data_text1`, `data_text2`, `data_text3`, `data_text4`, `data_text5`, `data_type_string`, `id`, `identifier`, `is_information_collector`, `is_required`, `is_searchable`, `placement`, `serialized_data_text`, `serialized_description_list`, `serialized_name_list`, `version`) VALUES
(1, '', 4, 0, 0, 0, 0, 1, 0, 0, 0, '', '', '', '', '', 'ezimage', 180, 'image', 0, 0, 0, 5, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:5:"Image";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Image";}', 0),
(1, '', 5, 0, 0, 0, 0, 10, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 117, 'caption', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:7:"Caption";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:7:"Caption";}', 0),
(1, '', 5, 0, 0, 0, 0, 2, 0, 0, 0, '', '', '', '', '', 'ezimage', 118, 'image', 0, 0, 0, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:5:"Image";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Image";}', 0),
(1, '', 3, 0, 0, 0, 0, 255, 0, 0, 0, '', '', '', '', '', 'ezstring', 6, 'name', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"Name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Name";}', 0),
(1, '', 13, 0, 0, 0, 0, 20, 0, 0, 0, '', '', '', '', '', 'eztext', 151, 'message', 0, 1, 1, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:7:"Message";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:7:"Message";}', 0),
(1, '', 13, 0, 0, 0, 0, 100, 0, 0, 0, '', '', '', '', '', 'ezstring', 149, 'subject', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:7:"Subject";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:7:"Subject";}', 0),
(1, '', 2, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezobjectrelation', 154, 'image', 0, 0, 1, 7, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:5:"Image";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Image";}', 0),
(0, '', 15, 0, 0, 0, 0, 1, 0, 0, 0, 'site.ini', 'SiteSettings', 'SiteURL', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 178, 'siteurl', 0, 0, 0, 7, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:8:"Site URL";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:8:"Site URL";}', 0),
(0, '', 1, 0, 0, 0, 0, 0, 0, 1, 0, '', '', '', '', '', 'ezboolean', 158, 'show_children', 0, 0, 0, 5, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:13:"Show children";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:13:"Show children";}', 0),
(1, '', 13, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezstring', 150, 'author', 0, 1, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:6:"Author";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:6:"Author";}', 0),
(1, '', 3, 0, 0, 0, 0, 255, 0, 0, 0, '', '', '', '', '', 'ezstring', 7, 'description', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:11:"Description";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:11:"Description";}', 0),
(0, '', 17, 0, 0, 0, 0, 0, 0, 1, 0, '', '', '', '', '', 'ezboolean', 192, 'show_children', 0, 0, 0, 5, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:13:"Show children";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:22:"Ordner Inhalt anzeigen";}', 0),
(0, '', 17, 0, 0, 0, 0, 8, 0, 0, 0, '', '', '', '', '', 'ezimage', 200, 'image', 0, 0, 0, 4, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"ger-DE";s:10:"Intro Bild";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:5:"Image";}', 0),
(1, '', 19, 0, 0, 0, 0, 150, 0, 0, 0, 'new Image', '', '', '', '', 'ezstring', 196, 'title', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:4:"Name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Name";}', 0),
(1, '', 17, 0, 0, 0, 0, 255, 0, 0, 0, 'neuer Ordner', '', '', '', '', 'ezstring', 188, 'title', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:4:"Name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:11:"Bezeichnung";}', 0),
(0, '', 14, 0, 0, 0, 0, 6, 0, 0, 0, 'image.ini', 'medium', 'Filters', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 170, 'imagemedium', 0, 0, 0, 12, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:17:"Image Medium Size";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:17:"Image Medium Size";}', 0),
(0, '', 14, 0, 0, 0, 0, 6, 0, 0, 0, 'image.ini', 'small', 'Filters', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 169, 'imagesmall', 0, 0, 0, 11, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:16:"Image Small Size";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:16:"Image Small Size";}', 0),
(1, '', 12, 0, 0, 0, 0, 10, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 147, 'description', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:11:"Description";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:11:"Description";}', 0),
(1, '', 11, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezurl', 145, 'location', 0, 0, 0, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:8:"Location";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:8:"Location";}', 0),
(1, '', 11, 0, 0, 0, 0, 20, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 144, 'description', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:11:"Description";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:11:"Description";}', 0),
(1, '', 11, 0, 0, 0, 0, 255, 0, 0, 0, '', '', '', '', '', 'ezstring', 143, 'name', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"Name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Name";}', 0),
(0, '', 2, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezboolean', 123, 'enable_comments', 0, 0, 0, 6, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:15:"Enable comments";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:15:"Enable comments";}', 0),
(1, '', 2, 0, 0, 0, 0, 20, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 121, 'body', 0, 0, 1, 5, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"Body";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Body";}', 0),
(1, '', 2, 0, 0, 0, 0, 10, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 120, 'intro', 0, 1, 1, 4, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:5:"Intro";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Intro";}', 0),
(1, '', 2, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezauthor', 153, 'author', 0, 0, 0, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:6:"Author";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:6:"Author";}', 0),
(1, '', 2, 0, 0, 0, 0, 255, 0, 0, 0, '', '', '', '', '', 'ezstring', 152, 'short_title', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:11:"Short title";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:11:"Short title";}', 0),
(1, '', 2, 0, 0, 0, 0, 255, 0, 0, 0, 'New article', '', '', '', '', 'ezstring', 1, 'title', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:5:"Title";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Title";}', 0),
(1, '', 1, 0, 0, 0, 0, 20, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 156, 'description', 0, 0, 1, 4, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:11:"Description";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:11:"Description";}', 0),
(1, '', 1, 0, 0, 0, 0, 5, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 119, 'short_description', 0, 0, 1, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:17:"Short description";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:17:"Short description";}', 0),
(1, '', 1, 0, 0, 0, 0, 100, 0, 0, 0, '', '', '', '', '', 'ezstring', 155, 'short_name', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:10:"Short name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:10:"Short name";}', 0),
(1, '', 1, 0, 0, 0, 0, 255, 0, 0, 0, 'Folder', '', '', '', '', 'ezstring', 4, 'name', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"Name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Name";}', 0),
(1, '', 12, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezbinaryfile', 148, 'file', 0, 1, 0, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"File";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"File";}', 0),
(1, '', 4, 0, 0, 0, 0, 10, 0, 0, 0, '', '', '', '', '', 'eztext', 179, 'signature', 0, 0, 1, 4, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:9:"Signature";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:9:"Signature";}', 0),
(0, '', 4, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezuser', 12, 'user_account', 0, 1, 1, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:12:"User account";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:12:"User account";}', 0),
(1, '', 4, 0, 0, 0, 0, 255, 0, 0, 0, '', '', '', '', '', 'ezstring', 9, 'last_name', 0, 1, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:9:"Last name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:9:"Last name";}', 0),
(1, '', 4, 0, 0, 0, 0, 255, 0, 0, 0, '', '', '', '', '', 'ezstring', 8, 'first_name', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:10:"First name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:10:"First name";}', 0),
(1, '', 5, 0, 0, 0, 0, 150, 0, 0, 0, '', '', '', '', '', 'ezstring', 116, 'name', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"Name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Name";}', 0),
(1, '', 12, 0, 0, 0, 0, 0, 0, 0, 0, 'New file', '', '', '', '', 'ezstring', 146, 'name', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"Name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Name";}', 0),
(0, '', 15, 0, 0, 0, 0, 1, 0, 0, 0, 'site.ini', 'MailSettings', 'AdminEmail', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 177, 'email', 0, 0, 0, 6, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:5:"Email";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Email";}', 0),
(1, '', 15, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezstring', 176, 'id', 0, 0, 1, 5, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:2:"id";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:2:"id";}', 0),
(1, '', 15, 0, 0, 0, 0, 0, 0, 0, 0, 'sitestyle', '', '', '', '', 'ezpackage', 175, 'sitestyle', 0, 0, 0, 4, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:9:"Sitestyle";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:9:"Sitestyle";}', 0),
(1, '', 15, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezimage', 174, 'image', 0, 0, 0, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:5:"Image";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Image";}', 0),
(0, '', 15, 0, 0, 0, 0, 6, 0, 0, 0, 'site.ini', 'SiteSettings', 'MetaDataArray', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 173, 'meta_data', 0, 0, 0, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:9:"Meta data";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:9:"Meta data";}', 0),
(0, '', 15, 0, 0, 0, 0, 1, 0, 0, 0, 'site.ini', 'SiteSettings', 'SiteName', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 172, 'title', 0, 0, 0, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:5:"Title";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Title";}', 0),
(0, '', 14, 0, 0, 0, 0, 6, 0, 0, 0, 'image.ini', 'large', 'Filters', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 171, 'imagelarge', 0, 0, 0, 13, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:16:"Image Large Size";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:16:"Image Large Size";}', 0),
(0, '', 14, 0, 0, 0, 0, 2, 0, 0, 0, 'site.ini', 'TemplateSettings', 'TemplateCompile', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 168, 'templatecompile', 0, 0, 0, 10, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:16:"Template Compile";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:16:"Template Compile";}', 0),
(0, '', 14, 0, 0, 0, 0, 2, 0, 0, 0, 'site.ini', 'TemplateSettings', 'TemplateCache', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 167, 'templatecache', 0, 0, 0, 9, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:14:"Template Cache";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:14:"Template Cache";}', 0),
(0, '', 14, 0, 0, 0, 0, 2, 0, 0, 0, 'site.ini', 'ContentSettings', 'ViewCaching', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 166, 'viewcaching', 0, 0, 0, 8, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:12:"View Caching";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:12:"View Caching";}', 0),
(0, '', 14, 0, 0, 0, 0, 2, 0, 0, 0, 'site.ini', 'DebugSettings', 'DebugRedirection', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 165, 'debugredirection', 0, 0, 0, 7, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:17:"Debug Redirection";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:17:"Debug Redirection";}', 0),
(0, '', 14, 0, 0, 0, 0, 6, 0, 0, 0, 'site.ini', 'DebugSettings', 'DebugIPList', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 164, 'debugiplist', 0, 0, 0, 6, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:13:"Debug IP List";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:13:"Debug IP List";}', 0),
(0, '', 14, 0, 0, 0, 0, 2, 0, 0, 0, 'site.ini', 'DebugSettings', 'DebugByIP', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 163, 'debugbyip', 0, 0, 0, 5, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:11:"Debug By IP";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:11:"Debug By IP";}', 0),
(0, '', 14, 0, 0, 0, 0, 2, 0, 0, 0, 'site.ini', 'DebugSettings', 'DebugOutput', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 162, 'debugoutput', 0, 0, 0, 4, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:12:"Debug Output";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:12:"Debug Output";}', 0),
(0, '', 14, 0, 0, 0, 0, 1, 0, 0, 0, 'site.ini', 'SiteSettings', 'DefaultPage', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 161, 'defaultpage', 0, 0, 0, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:12:"Default Page";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:12:"Default Page";}', 0),
(1, '', 14, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezstring', 159, 'name', 0, 0, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:4:"Name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Name";}', 0),
(0, '', 14, 0, 0, 0, 0, 1, 0, 0, 0, 'site.ini', 'SiteSettings', 'IndexPage', '0', 'override;cjw-network_admin;cjw-network_user', 'ezinisetting', 160, 'indexpage', 0, 0, 0, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"eng-GB";s:10:"Index Page";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:10:"Index Page";}', 0),
(0, '', 19, 0, 0, 0, 0, 8, 0, 0, 0, '', '', '', '', '', 'ezimage', 198, 'image', 0, 0, 0, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:5:"Image";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Image";}', 0),
(1, '', 17, 0, 0, 0, 0, 10, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 190, 'short_description', 0, 0, 1, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:17:"Short description";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:10:"Intro Text";}', 0),
(1, '', 21, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezstring', 214, 'sender_name', 1, 1, 0, 7, 'a:2:{s:6:"eng-GB";s:0:"";s:16:"always-available";s:6:"eng-GB";}', 'a:3:{s:6:"eng-GB";s:0:"";s:16:"always-available";s:6:"eng-GB";s:6:"ger-DE";s:0:"";}', 'a:3:{s:6:"eng-GB";s:11:"Sender Name";s:16:"always-available";s:6:"eng-GB";s:6:"ger-DE";s:16:"Name des Senders";}', 0),
(1, '', 18, 0, 0, 0, 0, 16, 0, 0, 0, '', '', '', '', '', 'ezbinaryfile', 195, 'file', 0, 1, 0, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:4:"File";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:5:"Datei";}', 0),
(1, '', 21, 0, 0, 0, 0, 10, 0, 0, 0, '', '', '', '', '', 'eztext', 213, 'message', 1, 1, 0, 6, 'a:2:{s:6:"eng-GB";s:0:"";s:16:"always-available";s:6:"eng-GB";}', 'a:3:{s:6:"eng-GB";s:0:"";s:16:"always-available";s:6:"eng-GB";s:6:"ger-DE";s:0:"";}', 'a:3:{s:6:"eng-GB";s:7:"Message";s:16:"always-available";s:6:"eng-GB";s:6:"ger-DE";s:9:"Nachricht";}', 0),
(1, '', 21, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', 'ezemail', 212, 'email', 1, 1, 0, 5, 'a:2:{s:6:"eng-GB";s:0:"";s:16:"always-available";s:6:"eng-GB";}', 'a:3:{s:6:"eng-GB";s:0:"";s:16:"always-available";s:6:"eng-GB";s:6:"ger-DE";s:0:"";}', 'a:3:{s:6:"eng-GB";s:6:"E-Mail";s:16:"always-available";s:6:"eng-GB";s:6:"ger-DE";s:6:"E-Mail";}', 0),
(0, '', 16, 0, 0, 0, 0, 8, 0, 0, 0, '', '', '', '', '', 'ezimage', 199, 'image', 0, 0, 0, 5, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"ger-DE";s:10:"Intro Bild";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:5:"Image";}', 0),
(1, '', 16, 0, 0, 0, 0, 15, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 185, 'description', 0, 0, 1, 4, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:4:"Body";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:9:"Body Text";}', 0),
(1, '', 16, 0, 0, 0, 0, 5, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 184, 'short_description', 0, 1, 1, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:5:"Intro";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:10:"Intro Text";}', 0),
(1, '', 16, 0, 0, 0, 0, 255, 0, 0, 0, 'neue Seite', '', '', '', '', 'ezstring', 181, 'title', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:5:"Title";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:11:"Bezeichnung";}', 0),
(1, '', 16, 0, 0, 0, 0, 255, 0, 0, 0, '', '', '', '', '', 'ezstring', 182, 'short_title', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:11:"Short title";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:17:"Kurz- Bezeichnung";}', 0),
(1, '', 18, 0, 0, 0, 0, 10, 0, 0, 0, '', 'mini', '', '', '', 'ezxmltext', 194, 'short_description', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:11:"Description";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:12:"Beschreibung";}', 0),
(0, '', 21, 0, 0, 0, 0, 8, 0, 0, 0, '', '', '', '', '', 'ezimage', 210, 'image', 0, 0, 0, 4, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"ger-DE";s:10:"Intro Bild";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:5:"Image";}', 0),
(1, '', 21, 0, 0, 0, 0, 255, 0, 0, 0, 'neuer Ordner', '', '', '', '', 'ezstring', 207, 'title', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:5:"Title";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:11:"Bezeichnung";}', 0),
(1, '', 21, 0, 0, 0, 0, 100, 0, 0, 0, '', '', '', '', '', 'ezstring', 208, 'short_title', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:11:"Short title";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:17:"Kurz- Bezeichnung";}', 0),
(1, '', 21, 0, 0, 0, 0, 10, 0, 0, 0, '', '', '', '', '', 'ezxmltext', 209, 'short_description', 0, 0, 1, 3, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:17:"Short description";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:10:"Intro Text";}', 0),
(1, '', 19, 0, 0, 0, 0, 5, 0, 0, 0, '', 'mini', '', '', '', 'ezxmltext', 197, 'short_description', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:7:"Caption";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:7:"Caption";}', 0),
(1, '', 18, 0, 0, 0, 0, 0, 0, 0, 0, 'neue Datei', '', '', '', '', 'ezstring', 193, 'title', 0, 1, 1, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:4:"Name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Name";}', 0),
(0, '', 20, 0, 0, 0, 0, 0, 0, 0, 0, 'Home Ordner', '', '', '', '', 'ezstring', 206, 'short_title', 0, 0, 0, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"ger-DE";s:11:"Bezeichnung";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:10:"Short Name";}', 0),
(0, '', 20, 0, 0, 0, 0, 255, 0, 0, 0, 'WWW Home', '', '', '', '', 'ezstring', 201, 'title', 0, 1, 0, 1, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:25:"Don''t change the name !!!";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:4:"Name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:4:"Name";}', 0),
(1, '', 17, 0, 0, 0, 0, 100, 0, 0, 0, '', '', '', '', '', 'ezstring', 189, 'short_title', 0, 0, 1, 2, 'a:2:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";}', 'a:3:{s:6:"ger-DE";s:0:"";s:16:"always-available";s:6:"ger-DE";s:6:"eng-GB";s:0:"";}', 'a:3:{s:6:"eng-GB";s:10:"Short name";s:16:"always-available";s:6:"ger-DE";s:6:"ger-DE";s:17:"Kurz- Bezeichnung";}', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentclass_classgroup`
--

DROP TABLE IF EXISTS `ezcontentclass_classgroup`;
CREATE TABLE IF NOT EXISTS `ezcontentclass_classgroup` (
  `contentclass_id` int(11) NOT NULL DEFAULT '0',
  `contentclass_version` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `group_name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentclass_classgroup`
--

INSERT INTO `ezcontentclass_classgroup` (`contentclass_id`, `contentclass_version`, `group_id`, `group_name`) VALUES
(1, 0, 1, 'Content'),
(2, 0, 1, 'Content'),
(3, 0, 2, 'Users'),
(4, 0, 2, 'Users'),
(5, 0, 3, 'Media'),
(11, 0, 1, 'Content'),
(12, 0, 3, 'Media'),
(13, 0, 1, 'Content'),
(14, 0, 4, 'Setup'),
(15, 0, 4, 'Setup'),
(17, 0, 5, 'CJW'),
(19, 0, 5, 'CJW'),
(16, 0, 5, 'CJW'),
(18, 0, 5, 'CJW'),
(20, 0, 5, 'CJW'),
(21, 0, 5, 'CJW');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentclass_name`
--

DROP TABLE IF EXISTS `ezcontentclass_name`;
CREATE TABLE IF NOT EXISTS `ezcontentclass_name` (
  `contentclass_id` int(11) NOT NULL DEFAULT '0',
  `contentclass_version` int(11) NOT NULL DEFAULT '0',
  `language_id` bigint(20) NOT NULL DEFAULT '0',
  `language_locale` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentclass_name`
--

INSERT INTO `ezcontentclass_name` (`contentclass_id`, `contentclass_version`, `language_id`, `language_locale`, `name`) VALUES
(1, 0, 2, 'eng-GB', 'Folder'),
(2, 0, 2, 'eng-GB', 'Article'),
(3, 0, 2, 'eng-GB', 'User group'),
(4, 0, 2, 'eng-GB', 'User'),
(5, 0, 2, 'eng-GB', 'Image'),
(11, 0, 2, 'eng-GB', 'Link'),
(12, 0, 2, 'eng-GB', 'File'),
(13, 0, 2, 'eng-GB', 'Comment'),
(14, 0, 2, 'eng-GB', 'Common ini settings'),
(15, 0, 2, 'eng-GB', 'Template look'),
(11, 0, 5, 'ger-DE', 'Link'),
(2, 0, 5, 'ger-DE', 'Article'),
(13, 0, 5, 'ger-DE', 'Comment'),
(1, 0, 5, 'ger-DE', 'Folder'),
(3, 0, 5, 'ger-DE', 'User group'),
(4, 0, 5, 'ger-DE', 'User'),
(5, 0, 5, 'ger-DE', 'Image'),
(12, 0, 5, 'ger-DE', 'File'),
(16, 0, 5, 'ger-DE', 'CJW Seite'),
(15, 0, 5, 'ger-DE', 'Template look'),
(14, 0, 5, 'ger-DE', 'Common ini settings'),
(16, 0, 2, 'eng-GB', 'Article'),
(17, 0, 5, 'ger-DE', 'CJW Ordner'),
(17, 0, 2, 'eng-GB', 'Folder'),
(18, 0, 5, 'ger-DE', 'CJW Datei'),
(18, 0, 2, 'eng-GB', 'File'),
(19, 0, 5, 'ger-DE', 'CJW Bild'),
(19, 0, 2, 'eng-GB', 'Image'),
(20, 0, 5, 'ger-DE', 'CJW Ordner Site'),
(20, 0, 2, 'eng-GB', 'Folder Site'),
(21, 0, 2, 'eng-GB', 'CJW Feedback Form'),
(21, 0, 5, 'ger-DE', 'CJW Ordner');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentobject`
--

DROP TABLE IF EXISTS `ezcontentobject`;
CREATE TABLE IF NOT EXISTS `ezcontentobject` (
  `contentclass_id` int(11) NOT NULL DEFAULT '0',
  `current_version` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `initial_language_id` bigint(20) NOT NULL DEFAULT '0',
  `language_mask` bigint(20) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '0',
  `remote_id` varchar(100) DEFAULT NULL,
  `section_id` int(11) NOT NULL DEFAULT '0',
  `status` int(11) DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentobject`
--

INSERT INTO `ezcontentobject` (`contentclass_id`, `current_version`, `id`, `initial_language_id`, `language_mask`, `modified`, `name`, `owner_id`, `published`, `remote_id`, `section_id`, `status`) VALUES
(1, 7, 1, 4, 7, 1421094778, 'eZ Publish', 14, 1033917596, '9459d3c29e15006e45197295722c7ade', 1, 1),
(3, 2, 4, 4, 7, 1421095463, 'Users', 14, 1033917596, 'f5c88a2209584891056f987fd965b0ba', 2, 1),
(4, 3, 10, 4, 7, 1421095664, 'Anonymous User', 14, 1033920665, 'faaeb9be3bd98ed09f606fc16d144eca', 2, 1),
(3, 2, 11, 4, 7, 1421095519, 'Guest accounts', 14, 1033920746, '5f7f0bdb3381d6a461d8c29ff53d908f', 2, 1),
(3, 2, 12, 4, 7, 1421095565, 'Administrator users', 14, 1033920775, '9b47a45624b023b1a76c73b74d704acf', 2, 1),
(3, 2, 13, 4, 7, 1421095587, 'Editors', 14, 1033920794, '3c160cca19fb135f83bd02d911f04db2', 2, 1),
(4, 4, 14, 4, 7, 1421095724, 'Administrator User', 14, 1033920830, '1bb4fe25487f05527efa8bfd394cecc7', 2, 1),
(1, 2, 41, 4, 7, 1421094823, 'Media', 14, 1060695457, 'a6e35cbcb7cd6ae4b691f3eee30cd262', 3, 1),
(3, 2, 42, 4, 7, 1421095609, 'Anonymous Users', 14, 1072180330, '15b256dbea2ae72418ff5facc999e8f9', 2, 1),
(1, 1, 45, 2, 3, 1079684190, 'Setup', 14, 1079684190, '241d538ce310074e602f29f49e44e938', 4, 1),
(1, 2, 49, 4, 7, 1421094903, 'Images', 14, 1080220197, 'e7ff633c6b8e0fd3531e74c6e712bead', 3, 1),
(1, 2, 50, 4, 7, 1421094857, 'Files', 14, 1080220220, '732a5acd01b51a6fe6eab448ad4138a9', 3, 1),
(1, 2, 51, 4, 7, 1421094959, 'Multimedia', 14, 1080220233, '09082deb98662a104f325aaa8c4933d3', 3, 1),
(14, 1, 52, 2, 2, 1082016591, 'Common INI settings', 14, 1082016591, '27437f3547db19cf81a33c92578b2c89', 4, 1),
(15, 2, 54, 2, 2, 1301062376, 'Plain site', 14, 1082016652, '8b8b22fe3c6061ed500fbd2b377b885f', 5, 1),
(1, 1, 56, 2, 3, 1103023132, 'Design', 14, 1103023132, '08799e609893f7aba22f10cb466d9cc8', 5, 1),
(20, 4, 57, 4, 5, 1421108516, 'WWW Home', 14, 1421101973, '4c4bf3aba9cb4267ccceed87e195e3b6', 1, 1),
(17, 5, 58, 4, 7, 1439387270, 'TEST Folder eng-GB', 14, 1421109393, '32b416e85a0a964a51788889f02fdf9f', 1, 1),
(16, 2, 60, 4, 4, 1439386774, 'Test Seite 1-1', 14, 1421109662, '56549d4ef62d7cf2d50424928611ef55', 1, 1),
(16, 2, 61, 4, 4, 1439386922, 'Test Seite 1-2', 14, 1421109748, 'aa38268c25b3e42664ebf21f4684b107', 1, 1),
(16, 2, 62, 4, 4, 1439387050, 'Test Seite 2-1', 14, 1421110056, 'f10e97f59e4f4b3267a88deadec02941', 1, 1),
(16, 2, 64, 4, 4, 1439387124, 'Test Seite 2-2', 14, 1421110148, '5c6107571954172c0052ff2949554e6b', 1, 1),
(21, 3, 66, 4, 6, 1437143010, 'Kontaktformular', 14, 1437142935, '6fdb8fde36a24faed57f7f4cd9867fef', 1, 1),
(17, 2, 65, 4, 4, 1437142202, 'Ordner 2 -  ger-DE', 14, 1437142061, '9cc331359058e45edbc3df0021548cb7', 1, 1),
(18, 3, 67, 2, 7, 1439556371, 'Demo File', 14, 1439393094, '5d290e45b64e967e8f785c538fbb9f1c', 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentobject_attribute`
--

DROP TABLE IF EXISTS `ezcontentobject_attribute`;
CREATE TABLE IF NOT EXISTS `ezcontentobject_attribute` (
  `attribute_original_id` int(11) DEFAULT '0',
  `contentclassattribute_id` int(11) NOT NULL DEFAULT '0',
  `contentobject_id` int(11) NOT NULL DEFAULT '0',
  `data_float` double DEFAULT NULL,
  `data_int` int(11) DEFAULT NULL,
  `data_text` longtext,
  `data_type_string` varchar(50) DEFAULT '',
  `id` int(11) NOT NULL,
  `language_code` varchar(20) NOT NULL DEFAULT '',
  `language_id` bigint(20) NOT NULL DEFAULT '0',
  `sort_key_int` int(11) NOT NULL DEFAULT '0',
  `sort_key_string` varchar(255) NOT NULL DEFAULT '',
  `version` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=296 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentobject_attribute`
--

INSERT INTO `ezcontentobject_attribute` (`attribute_original_id`, `contentclassattribute_id`, `contentobject_id`, `data_float`, `data_int`, `data_text`, `data_type_string`, `id`, `language_code`, `language_id`, `sort_key_int`, `sort_key_string`, `version`) VALUES
(0, 4, 1, 0, 0, 'Welcome to eZ Publish', 'ezstring', 1, 'eng-GB', 3, 0, 'welcome to ez publish', 6),
(0, 119, 1, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">This is eZ plain site package with a limited setup of the eZ Publish functionality. For a full blown eZ Publish please chose the Website Interface or the eZ Flow site package at the installation.</paragraph></section>\n', 'ezxmltext', 2, 'eng-GB', 3, 0, '', 6),
(0, 7, 4, NULL, NULL, 'Main group', 'ezstring', 7, 'eng-GB', 3, 0, '', 1),
(0, 6, 4, NULL, NULL, 'Users', 'ezstring', 8, 'eng-GB', 3, 0, '', 1),
(0, 8, 10, 0, 0, 'Anonymous', 'ezstring', 19, 'eng-GB', 3, 0, 'anonymous', 2),
(0, 9, 10, 0, 0, 'User', 'ezstring', 20, 'eng-GB', 3, 0, 'user', 2),
(0, 12, 10, 0, 0, '', 'ezuser', 21, 'eng-GB', 3, 0, '', 2),
(0, 6, 11, 0, 0, 'Guest accounts', 'ezstring', 22, 'eng-GB', 3, 0, '', 1),
(0, 7, 11, 0, 0, '', 'ezstring', 23, 'eng-GB', 3, 0, '', 1),
(0, 6, 12, 0, 0, 'Administrator users', 'ezstring', 24, 'eng-GB', 3, 0, '', 1),
(0, 7, 12, 0, 0, '', 'ezstring', 25, 'eng-GB', 3, 0, '', 1),
(0, 6, 13, 0, 0, 'Editors', 'ezstring', 26, 'eng-GB', 3, 0, '', 1),
(0, 7, 13, 0, 0, '', 'ezstring', 27, 'eng-GB', 3, 0, '', 1),
(0, 8, 14, 0, 0, 'Administrator', 'ezstring', 28, 'eng-GB', 3, 0, 'administrator', 3),
(0, 9, 14, 0, 0, 'User', 'ezstring', 29, 'eng-GB', 3, 0, 'user', 3),
(30, 12, 14, 0, 0, '', 'ezuser', 30, 'eng-GB', 3, 0, '', 3),
(0, 4, 41, 0, 0, 'Media', 'ezstring', 98, 'eng-GB', 3, 0, '', 1),
(0, 119, 41, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 99, 'eng-GB', 3, 0, '', 1),
(0, 6, 42, 0, 0, 'Anonymous Users', 'ezstring', 100, 'eng-GB', 3, 0, 'anonymous users', 1),
(0, 7, 42, 0, 0, 'User group for the anonymous user', 'ezstring', 101, 'eng-GB', 3, 0, 'user group for the anonymous user', 1),
(0, 155, 1, 0, 0, 'eZ Publish', 'ezstring', 102, 'eng-GB', 3, 0, 'ez publish', 6),
(0, 155, 41, 0, 0, '', 'ezstring', 103, 'eng-GB', 3, 0, '', 1),
(0, 156, 1, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">eZ Publish is a popular open source content management system and development framework. It allows the development of professional, customized and dynamic web solutions. It can be used to build anything from a personal homepage to a multinational corporate website with role based multiuser access, online shopping, discussion forums and other advanced functionality. In addition, because of its open nature, eZ Publish can easily be plugged into, communicate and coexist with existing IT-solutions.</paragraph><section><header>Documentation and guidance</header><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">The <link target="_blank" url_id="9">eZ Publish documentation</link> covers common topics related to the setup and daily use of the eZ Publish content management system/framework. In addition, it also covers some advanced topics. People who are unfamiliar with eZ Publish should at least read the "eZ Publish basics" chapter.</paragraph><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">If you''re unable to find an answer/solution to a specific question/problem within the documentation pages, you should make use of the official <link target="_blank" url_id="4">eZ Publish forum</link>. People who need professional help should purchase <link target="_blank" url_id="10">support</link> or <link target="_blank" url_id="11">consulting</link> services. It is also possible to sign up for various <link target="_blank" url_id="12">training sessions</link>.</paragraph><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">For more information about eZ Publish and other products/services from eZ Systems, please visit <link target="_blank" url_id="8">ez.no</link>.</paragraph></section><section><header>Tutorials</header><section><header><strong>New users</strong></header><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><ul><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="13">eZ Publish Administration Interface</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="14">eZ Publish Online Editor Video</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="15">eZ Flow Video Tutorial</link></paragraph></li></ul></paragraph></section><section><header>Experienced users</header><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><ul><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="16">How to develop eZ Publish Extensions</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="17">How to create custom workflow</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="18">How to use REST API interface</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="19">Asynchronous publishing</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="20">Upgrading to 4.5</link></paragraph></li></ul><line>Find more&amp;nbsp;<link target="_blank" url_id="21">tutorials</link>&amp;nbsp;and&amp;nbsp;<link target="_blank" url_id="22">videos</link> online.</line></paragraph></section></section></section>\n', 'ezxmltext', 104, 'eng-GB', 3, 0, '', 6),
(0, 156, 41, 0, 1045487555, '', 'ezxmltext', 105, 'eng-GB', 3, 0, '', 1),
(108, 158, 1, 0, 0, '', 'ezboolean', 108, 'eng-GB', 3, 0, '', 6),
(0, 158, 41, 0, 0, '', 'ezboolean', 109, 'eng-GB', 3, 0, '', 1),
(0, 4, 45, 0, 0, 'Setup', 'ezstring', 123, 'eng-GB', 3, 0, 'setup', 1),
(0, 155, 45, 0, 0, '', 'ezstring', 124, 'eng-GB', 3, 0, '', 1),
(0, 119, 45, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 125, 'eng-GB', 3, 0, '', 1),
(0, 156, 45, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 126, 'eng-GB', 3, 0, '', 1),
(0, 158, 45, 0, 0, '', 'ezboolean', 128, 'eng-GB', 3, 0, '', 1),
(0, 4, 49, 0, 0, 'Images', 'ezstring', 142, 'eng-GB', 3, 0, 'images', 1),
(0, 155, 49, 0, 0, '', 'ezstring', 143, 'eng-GB', 3, 0, '', 1),
(0, 119, 49, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 144, 'eng-GB', 3, 0, '', 1),
(0, 156, 49, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 145, 'eng-GB', 3, 0, '', 1),
(0, 158, 49, 0, 1, '', 'ezboolean', 146, 'eng-GB', 3, 1, '', 1),
(0, 4, 50, 0, 0, 'Files', 'ezstring', 147, 'eng-GB', 3, 0, 'files', 1),
(0, 155, 50, 0, 0, '', 'ezstring', 148, 'eng-GB', 3, 0, '', 1),
(0, 119, 50, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 149, 'eng-GB', 3, 0, '', 1),
(0, 156, 50, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 150, 'eng-GB', 3, 0, '', 1),
(0, 158, 50, 0, 1, '', 'ezboolean', 151, 'eng-GB', 3, 1, '', 1),
(0, 4, 51, 0, 0, 'Multimedia', 'ezstring', 152, 'eng-GB', 3, 0, 'multimedia', 1),
(0, 155, 51, 0, 0, '', 'ezstring', 153, 'eng-GB', 3, 0, '', 1),
(0, 119, 51, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 154, 'eng-GB', 3, 0, '', 1),
(0, 156, 51, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 155, 'eng-GB', 3, 0, '', 1),
(0, 158, 51, 0, 1, '', 'ezboolean', 156, 'eng-GB', 3, 1, '', 1),
(0, 159, 52, 0, 0, 'Common INI settings', 'ezstring', 157, 'eng-GB', 2, 0, 'common ini settings', 1),
(0, 160, 52, 0, 0, '/content/view/full/2/', 'ezinisetting', 158, 'eng-GB', 2, 0, '', 1),
(0, 161, 52, 0, 0, '/content/view/full/2', 'ezinisetting', 159, 'eng-GB', 2, 0, '', 1),
(0, 162, 52, 0, 0, 'disabled', 'ezinisetting', 160, 'eng-GB', 2, 0, '', 1),
(0, 163, 52, 0, 0, 'disabled', 'ezinisetting', 161, 'eng-GB', 2, 0, '', 1),
(0, 164, 52, 0, 0, '', 'ezinisetting', 162, 'eng-GB', 2, 0, '', 1),
(0, 165, 52, 0, 0, 'enabled', 'ezinisetting', 163, 'eng-GB', 2, 0, '', 1),
(0, 166, 52, 0, 0, 'disabled', 'ezinisetting', 164, 'eng-GB', 2, 0, '', 1),
(0, 167, 52, 0, 0, 'enabled', 'ezinisetting', 165, 'eng-GB', 2, 0, '', 1),
(0, 168, 52, 0, 0, 'enabled', 'ezinisetting', 166, 'eng-GB', 2, 0, '', 1),
(0, 169, 52, 0, 0, '=geometry/scale=100;100', 'ezinisetting', 167, 'eng-GB', 2, 0, '', 1),
(0, 170, 52, 0, 0, '=geometry/scale=200;200', 'ezinisetting', 168, 'eng-GB', 2, 0, '', 1),
(0, 171, 52, 0, 0, '=geometry/scale=300;300', 'ezinisetting', 169, 'eng-GB', 2, 0, '', 1),
(0, 172, 54, 0, 0, 'Plain site', 'ezinisetting', 170, 'eng-GB', 2, 0, '', 2),
(0, 173, 54, 0, 0, 'author=eZ Systems\ncopyright=eZ Systems\ndescription=Content Management System\nkeywords=cms, publish, e-commerce, content management, development framework', 'ezinisetting', 171, 'eng-GB', 2, 0, '', 2),
(0, 174, 54, 0, 0, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1082016632"><original attribute_id="172" attribute_version="2" attribute_language="eng-GB"/></ezimage>\n', 'ezimage', 172, 'eng-GB', 2, 0, '', 2),
(0, 175, 54, 0, 0, '0', 'ezpackage', 173, 'eng-GB', 2, 0, '0', 2),
(0, 176, 54, 0, 0, 'sitestyle_identifier', 'ezstring', 174, 'eng-GB', 2, 0, 'sitestyle_identifier', 2),
(0, 177, 54, 0, 0, 'nospam@ez.no', 'ezinisetting', 175, 'eng-GB', 2, 0, '', 2),
(0, 178, 54, 0, 0, 'ez.no', 'ezinisetting', 176, 'eng-GB', 2, 0, '', 2),
(0, 179, 10, 0, 0, '', 'eztext', 177, 'eng-GB', 3, 0, '', 2),
(0, 179, 14, 0, 0, '', 'eztext', 178, 'eng-GB', 3, 0, '', 3),
(0, 180, 10, 0, 0, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421095593"/>\n', 'ezimage', 179, 'eng-GB', 3, 0, '', 2),
(0, 180, 14, 0, 0, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1301057722"><original attribute_id="180" attribute_version="3" attribute_language="eng-GB"/></ezimage>\n', 'ezimage', 180, 'eng-GB', 3, 0, '', 3),
(0, 4, 56, 0, NULL, 'Design', 'ezstring', 181, 'eng-GB', 3, 0, 'design', 1),
(0, 155, 56, 0, NULL, '', 'ezstring', 182, 'eng-GB', 3, 0, '', 1),
(0, 119, 56, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 183, 'eng-GB', 3, 0, '', 1),
(0, 156, 56, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 184, 'eng-GB', 3, 0, '', 1),
(0, 158, 56, 0, 1, '', 'ezboolean', 185, 'eng-GB', 3, 1, '', 1),
(0, 4, 1, 0, 0, 'Welcome to eZ Publish', 'ezstring', 186, 'ger-DE', 5, 0, 'welcome to ez publish', 7),
(0, 155, 1, 0, 0, 'eZ Publish', 'ezstring', 187, 'ger-DE', 5, 0, 'ez publish', 7),
(0, 119, 1, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>This is eZ plain site package with a limited setup of the eZ Publish functionality. For a full blown eZ Publish please chose the Website Interface or the eZ Flow site package at the installation.</paragraph></section>\n', 'ezxmltext', 188, 'ger-DE', 5, 0, '', 7),
(0, 156, 1, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>eZ Publish is a popular open source content management system and development framework. It allows the development of professional, customized and dynamic web solutions. It can be used to build anything from a personal homepage to a multinational corporate website with role based multiuser access, online shopping, discussion forums and other advanced functionality. In addition, because of its open nature, eZ Publish can easily be plugged into, communicate and coexist with existing IT-solutions.</paragraph><section><header>Documentation and guidance</header><paragraph>The <link target="_blank" url_id="9">eZ Publish documentation</link> covers common topics related to the setup and daily use of the eZ Publish content management system/framework. In addition, it also covers some advanced topics. People who are unfamiliar with eZ Publish should at least read the "eZ Publish basics" chapter.</paragraph><paragraph>If you''re unable to find an answer/solution to a specific question/problem within the documentation pages, you should make use of the official <link target="_blank" url_id="4">eZ Publish forum</link>. People who need professional help should purchase <link target="_blank" url_id="10">support</link> or <link target="_blank" url_id="11">consulting</link> services. It is also possible to sign up for various <link target="_blank" url_id="12">training sessions</link>.</paragraph><paragraph>For more information about eZ Publish and other products/services from eZ Systems, please visit <link target="_blank" url_id="8">ez.no</link>.</paragraph></section><section><header>Tutorials</header><section><header><strong>New users</strong></header><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><ul><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="13">eZ Publish Administration Interface</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="14">eZ Publish Online Editor Video</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="15">eZ Flow Video Tutorial</link></paragraph></li></ul></paragraph></section><section><header>Experienced users</header><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><ul><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="16">How to develop eZ Publish Extensions</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="17">How to create custom workflow</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="18">How to use REST API interface</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="19">Asynchronous publishing</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="20">Upgrading to 4.5</link></paragraph></li></ul></paragraph><paragraph>Find more <link target="_blank" url_id="21">tutorials</link> and <link target="_blank" url_id="22">videos</link> online.</paragraph></section></section></section>\n', 'ezxmltext', 189, 'ger-DE', 5, 0, '', 7),
(0, 4, 1, 0, 0, 'Welcome to eZ Publish', 'ezstring', 1, 'eng-GB', 2, 0, 'welcome to ez publish', 7),
(0, 155, 1, 0, 0, 'eZ Publish', 'ezstring', 102, 'eng-GB', 2, 0, 'ez publish', 7),
(0, 119, 1, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">This is eZ plain site package with a limited setup of the eZ Publish functionality. For a full blown eZ Publish please chose the Website Interface or the eZ Flow site package at the installation.</paragraph></section>\n', 'ezxmltext', 2, 'eng-GB', 2, 0, '', 7),
(190, 158, 1, 0, 0, '', 'ezboolean', 190, 'ger-DE', 5, 0, '', 7),
(0, 156, 1, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">eZ Publish is a popular open source content management system and development framework. It allows the development of professional, customized and dynamic web solutions. It can be used to build anything from a personal homepage to a multinational corporate website with role based multiuser access, online shopping, discussion forums and other advanced functionality. In addition, because of its open nature, eZ Publish can easily be plugged into, communicate and coexist with existing IT-solutions.</paragraph><section><header>Documentation and guidance</header><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">The <link target="_blank" url_id="9">eZ Publish documentation</link> covers common topics related to the setup and daily use of the eZ Publish content management system/framework. In addition, it also covers some advanced topics. People who are unfamiliar with eZ Publish should at least read the "eZ Publish basics" chapter.</paragraph><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">If you''re unable to find an answer/solution to a specific question/problem within the documentation pages, you should make use of the official <link target="_blank" url_id="4">eZ Publish forum</link>. People who need professional help should purchase <link target="_blank" url_id="10">support</link> or <link target="_blank" url_id="11">consulting</link> services. It is also possible to sign up for various <link target="_blank" url_id="12">training sessions</link>.</paragraph><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">For more information about eZ Publish and other products/services from eZ Systems, please visit <link target="_blank" url_id="8">ez.no</link>.</paragraph></section><section><header>Tutorials</header><section><header><strong>New users</strong></header><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><ul><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="13">eZ Publish Administration Interface</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="14">eZ Publish Online Editor Video</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="15">eZ Flow Video Tutorial</link></paragraph></li></ul></paragraph></section><section><header>Experienced users</header><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><ul><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="16">How to develop eZ Publish Extensions</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="17">How to create custom workflow</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="18">How to use REST API interface</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" url_id="19">Asynchronous publishing</link></paragraph></li><li><paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/"><link target="_blank" xhtml:id="internal-source-marker_0.15448186383582652" url_id="20">Upgrading to 4.5</link></paragraph></li></ul><line>Find more&amp;nbsp;<link target="_blank" url_id="21">tutorials</link>&amp;nbsp;and&amp;nbsp;<link target="_blank" url_id="22">videos</link> online.</line></paragraph></section></section></section>\n', 'ezxmltext', 104, 'eng-GB', 2, 0, '', 7),
(190, 158, 1, 0, 0, '', 'ezboolean', 108, 'eng-GB', 2, 0, '', 7),
(0, 4, 41, 0, 0, 'Media', 'ezstring', 191, 'ger-DE', 5, 0, 'media', 2),
(0, 155, 41, 0, 0, '', 'ezstring', 192, 'ger-DE', 5, 0, '', 2),
(0, 119, 41, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 193, 'ger-DE', 5, 0, '', 2),
(0, 156, 41, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 194, 'ger-DE', 5, 0, '', 2),
(195, 158, 41, 0, 0, '', 'ezboolean', 195, 'ger-DE', 5, 0, '', 2),
(0, 4, 41, 0, 0, 'Media', 'ezstring', 98, 'eng-GB', 2, 0, 'media', 2),
(0, 155, 41, 0, 0, '', 'ezstring', 103, 'eng-GB', 2, 0, '', 2),
(0, 119, 41, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 99, 'eng-GB', 2, 0, '', 2),
(0, 156, 41, 0, 1045487555, '', 'ezxmltext', 105, 'eng-GB', 2, 0, '', 2),
(195, 158, 41, 0, 0, '', 'ezboolean', 109, 'eng-GB', 2, 0, '', 2),
(0, 4, 50, 0, 0, 'Files', 'ezstring', 196, 'ger-DE', 5, 0, 'files', 2),
(0, 155, 50, 0, 0, '', 'ezstring', 197, 'ger-DE', 5, 0, '', 2),
(0, 119, 50, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 198, 'ger-DE', 5, 0, '', 2),
(0, 156, 50, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 199, 'ger-DE', 5, 0, '', 2),
(200, 158, 50, 0, 1, '', 'ezboolean', 200, 'ger-DE', 5, 1, '', 2),
(0, 4, 50, 0, 0, 'Files', 'ezstring', 147, 'eng-GB', 2, 0, 'files', 2),
(0, 155, 50, 0, 0, '', 'ezstring', 148, 'eng-GB', 2, 0, '', 2),
(0, 119, 50, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 149, 'eng-GB', 2, 0, '', 2),
(0, 156, 50, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 150, 'eng-GB', 2, 0, '', 2),
(200, 158, 50, 0, 1, '', 'ezboolean', 151, 'eng-GB', 2, 1, '', 2),
(0, 4, 49, 0, 0, 'Images', 'ezstring', 201, 'ger-DE', 5, 0, 'images', 2),
(0, 155, 49, 0, 0, '', 'ezstring', 202, 'ger-DE', 5, 0, '', 2),
(0, 119, 49, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 203, 'ger-DE', 5, 0, '', 2),
(0, 156, 49, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 204, 'ger-DE', 5, 0, '', 2),
(205, 158, 49, 0, 1, '', 'ezboolean', 205, 'ger-DE', 5, 1, '', 2),
(0, 4, 49, 0, 0, 'Images', 'ezstring', 142, 'eng-GB', 2, 0, 'images', 2),
(0, 155, 49, 0, 0, '', 'ezstring', 143, 'eng-GB', 2, 0, '', 2),
(0, 119, 49, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 144, 'eng-GB', 2, 0, '', 2),
(0, 156, 49, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 145, 'eng-GB', 2, 0, '', 2),
(205, 158, 49, 0, 1, '', 'ezboolean', 146, 'eng-GB', 2, 1, '', 2),
(0, 4, 51, 0, 0, 'Multimedia', 'ezstring', 206, 'ger-DE', 5, 0, 'multimedia', 2),
(0, 155, 51, 0, 0, '', 'ezstring', 207, 'ger-DE', 5, 0, '', 2),
(0, 119, 51, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 208, 'ger-DE', 5, 0, '', 2),
(0, 156, 51, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 209, 'ger-DE', 5, 0, '', 2),
(210, 158, 51, 0, 1, '', 'ezboolean', 210, 'ger-DE', 5, 1, '', 2),
(0, 4, 51, 0, 0, 'Multimedia', 'ezstring', 152, 'eng-GB', 2, 0, 'multimedia', 2),
(0, 155, 51, 0, 0, '', 'ezstring', 153, 'eng-GB', 2, 0, '', 2),
(0, 119, 51, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 154, 'eng-GB', 2, 0, '', 2),
(0, 156, 51, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/"\n         xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/"\n         xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/" />', 'ezxmltext', 155, 'eng-GB', 2, 0, '', 2),
(210, 158, 51, 0, 1, '', 'ezboolean', 156, 'eng-GB', 2, 1, '', 2),
(0, 6, 4, 0, NULL, 'Users', 'ezstring', 211, 'ger-DE', 5, 0, 'users', 2),
(0, 7, 4, 0, NULL, 'Main group', 'ezstring', 212, 'ger-DE', 5, 0, 'main group', 2),
(0, 6, 4, 0, NULL, 'Users', 'ezstring', 8, 'eng-GB', 2, 0, 'users', 2),
(0, 7, 4, 0, NULL, 'Main group', 'ezstring', 7, 'eng-GB', 2, 0, 'main group', 2),
(0, 6, 11, 0, 0, 'Guest accounts', 'ezstring', 213, 'ger-DE', 5, 0, 'guest accounts', 2),
(0, 7, 11, 0, 0, '', 'ezstring', 214, 'ger-DE', 5, 0, '', 2),
(0, 6, 11, 0, 0, 'Guest accounts', 'ezstring', 22, 'eng-GB', 2, 0, 'guest accounts', 2),
(0, 7, 11, 0, 0, '', 'ezstring', 23, 'eng-GB', 2, 0, '', 2),
(0, 6, 12, 0, 0, 'Administrator users', 'ezstring', 215, 'ger-DE', 5, 0, 'administrator users', 2),
(0, 7, 12, 0, 0, '', 'ezstring', 216, 'ger-DE', 5, 0, '', 2),
(0, 6, 12, 0, 0, 'Administrator users', 'ezstring', 24, 'eng-GB', 2, 0, 'administrator users', 2),
(0, 7, 12, 0, 0, '', 'ezstring', 25, 'eng-GB', 2, 0, '', 2),
(0, 6, 13, 0, 0, 'Editors', 'ezstring', 217, 'ger-DE', 5, 0, 'editors', 2),
(0, 7, 13, 0, 0, '', 'ezstring', 218, 'ger-DE', 5, 0, '', 2),
(0, 6, 13, 0, 0, 'Editors', 'ezstring', 26, 'eng-GB', 2, 0, 'editors', 2),
(0, 7, 13, 0, 0, '', 'ezstring', 27, 'eng-GB', 2, 0, '', 2),
(0, 6, 42, 0, 0, 'Anonymous Users', 'ezstring', 219, 'ger-DE', 5, 0, 'anonymous users', 2),
(0, 7, 42, 0, 0, 'User group for the anonymous user', 'ezstring', 220, 'ger-DE', 5, 0, 'user group for the anonymous user', 2),
(0, 6, 42, 0, 0, 'Anonymous Users', 'ezstring', 100, 'eng-GB', 2, 0, 'anonymous users', 2),
(0, 7, 42, 0, 0, 'User group for the anonymous user', 'ezstring', 101, 'eng-GB', 2, 0, 'user group for the anonymous user', 2),
(0, 8, 10, 0, 0, 'Anonymous', 'ezstring', 221, 'ger-DE', 5, 0, 'anonymous', 3),
(0, 9, 10, 0, 0, 'User', 'ezstring', 222, 'ger-DE', 5, 0, 'user', 3),
(223, 12, 10, 0, 0, '{"login":"anonymous","password_hash":"4e6f6184135228ccd45f8233d72a0363","email":"nospam@ez.no","password_hash_type":"2"}', 'ezuser', 223, 'ger-DE', 5, 0, '', 3),
(0, 179, 10, 0, 0, '', 'eztext', 224, 'ger-DE', 5, 0, '', 3),
(0, 180, 10, 0, 0, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421095593"><original attribute_id="225" attribute_version="3" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 225, 'ger-DE', 5, 0, '', 3),
(0, 8, 10, 0, 0, 'Anonymous', 'ezstring', 19, 'eng-GB', 2, 0, 'anonymous', 3),
(0, 9, 10, 0, 0, 'User', 'ezstring', 20, 'eng-GB', 2, 0, 'user', 3),
(223, 12, 10, 0, 0, '{"login":"anonymous","password_hash":"4e6f6184135228ccd45f8233d72a0363","email":"nospam@ez.no","password_hash_type":"2"}', 'ezuser', 21, 'eng-GB', 2, 0, '', 3),
(0, 179, 10, 0, 0, '', 'eztext', 177, 'eng-GB', 2, 0, '', 3),
(0, 180, 10, 0, 0, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421095593"/>\n', 'ezimage', 179, 'eng-GB', 2, 0, '', 3),
(0, 8, 14, 0, 0, 'Administrator', 'ezstring', 226, 'ger-DE', 5, 0, 'administrator', 4),
(0, 9, 14, 0, 0, 'User', 'ezstring', 227, 'ger-DE', 5, 0, 'user', 4),
(228, 12, 14, 0, 0, '{"login":"admin","password_hash":"c78e3b0f3d9244ed8c6d1c29464bdff9","email":"nospam@ez.no","password_hash_type":"2"}', 'ezuser', 228, 'ger-DE', 5, 0, '', 4),
(0, 179, 14, 0, 0, '', 'eztext', 229, 'ger-DE', 5, 0, '', 4),
(0, 180, 14, 0, 0, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1301057722"><original attribute_id="180" attribute_version="3" attribute_language="eng-GB"/></ezimage>\n', 'ezimage', 230, 'ger-DE', 5, 0, '', 4),
(0, 8, 14, 0, 0, 'Administrator', 'ezstring', 28, 'eng-GB', 2, 0, 'administrator', 4),
(0, 9, 14, 0, 0, 'User', 'ezstring', 29, 'eng-GB', 2, 0, 'user', 4),
(228, 12, 14, 0, 0, '{"login":"admin","password_hash":"c78e3b0f3d9244ed8c6d1c29464bdff9","email":"nospam@ez.no","password_hash_type":"2"}', 'ezuser', 30, 'eng-GB', 2, 0, '', 4),
(0, 179, 14, 0, 0, '', 'eztext', 178, 'eng-GB', 2, 0, '', 4),
(0, 180, 14, 0, 0, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1301057722"><original attribute_id="180" attribute_version="3" attribute_language="eng-GB"/></ezimage>\n', 'ezimage', 180, 'eng-GB', 2, 0, '', 4),
(0, 201, 57, 0, NULL, 'WWW home', 'ezstring', 231, 'ger-DE', 5, 0, 'www home', 1),
(231, 201, 57, 0, NULL, 'WWW Home', 'ezstring', 231, 'ger-DE', 5, 0, 'www home', 2),
(0, 206, 57, NULL, NULL, NULL, 'ezstring', 233, 'ger-DE', 5, 0, '', 1),
(0, 206, 57, NULL, NULL, NULL, 'ezstring', 233, 'ger-DE', 5, 0, '', 2),
(231, 201, 57, 0, NULL, 'WWW Home', 'ezstring', 231, 'ger-DE', 5, 0, 'www home', 3),
(233, 206, 57, 0, NULL, 'Home Ordner', 'ezstring', 233, 'ger-DE', 5, 0, 'home ordner', 3),
(231, 201, 57, 0, NULL, 'WWW Home', 'ezstring', 231, 'ger-DE', 5, 0, 'www home', 4),
(233, 206, 57, 0, NULL, 'Home Ordner', 'ezstring', 233, 'ger-DE', 5, 0, 'home ordner', 4),
(0, 188, 58, 0, NULL, 'Test Ordner 1', 'ezstring', 234, 'ger-DE', 5, 0, 'test ordner 1', 1),
(0, 189, 58, 0, NULL, '', 'ezstring', 235, 'ger-DE', 5, 0, '', 1),
(0, 190, 58, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>--·- ····- ----· · ··· --· -··· ----- ·· --· ···-- ··--·· · ·· ··· -··- ---·· ·-·-·- - ----- ·---- ··- ·--- ----· ·-· ·· ··- ···-- --··-- ·- ·-· ·- ··-· -···· --··· -··· -·· ----- ·· ··· ·-- -- ·--- ----- ··-· --·· -· ·-- ·--· -··- ·- --- -· -··· ----· ·--</paragraph></section>\n', 'ezxmltext', 236, 'ger-DE', 5, 0, '', 1),
(237, 200, 58, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421109345"><original attribute_id="237" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 237, 'ger-DE', 5, 0, '', 1),
(238, 192, 58, 0, 1, '', 'ezboolean', 238, 'ger-DE', 5, 1, '', 1),
(0, 210, 66, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1437142899"><original attribute_id="279" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 279, 'ger-DE', 4, 0, '', 1),
(0, 212, 66, 0, NULL, '', 'ezemail', 280, 'ger-DE', 4, 0, '', 1),
(0, 213, 66, 0, NULL, '', 'eztext', 281, 'ger-DE', 4, 0, '', 1),
(0, 214, 66, 0, NULL, '', 'ezstring', 282, 'ger-DE', 4, 0, '', 1),
(0, 207, 66, 0, NULL, 'Kontaktformular', 'ezstring', 276, 'ger-DE', 4, 0, 'kontaktformular', 1),
(0, 208, 66, 0, NULL, '', 'ezstring', 277, 'ger-DE', 4, 0, '', 1),
(0, 209, 66, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Hier können Sie uns eine Nachricht schreiben</paragraph></section>\n', 'ezxmltext', 278, 'ger-DE', 4, 0, '', 1),
(0, 181, 60, 0, NULL, 'Test Seite 1-1', 'ezstring', 244, 'ger-DE', 4, 0, 'test seite 1-1', 1),
(0, 182, 60, 0, NULL, '', 'ezstring', 245, 'ger-DE', 4, 0, '', 1),
(0, 184, 60, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>· -·- ···- ···-- --··-- ·--- -···· ··· · --- -- ···· -··- ··--·· -- ···-- ····· --··-- -·- --·- ---·· ··--·· ··· -- ···· -··- ----· -·- ·· ···- ---·· ··- -- ··- · ···- ·---- ----· -- --- ·--- ···-- ·-·-·- ··--- --··-- -·- -- · ···- --··· ---·· ·-· ·--- --·- ----· ·-- -·</paragraph></section>\n', 'ezxmltext', 246, 'ger-DE', 4, 0, '', 1),
(0, 185, 60, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">· -·- ···- ···-- --··-- ·--- -···· ··· · --- -- ···· -··- ··--·· -- ···-- ····· --··-- -·- --·- ---·· ··--·· ··· -- ···· -··- ----· -·- ·· ···- ---·· ··- -- ··- · ···- ·---- ----· -- --- ·--- ···-- ·-·-·- ··--- --··-- -·- -- · ···- --··· ---·· ·-· ·--- --·- ----· ·-- -·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-·· ----· --··-- ·- ·-· -·-· ·-·· -·- -· ···· ----- · --· -·· ----· ·-- ·· --- ·· -·· ----· ·- ··- ··-· ·--- -···· - ···- ----- ·---- --- ··- ·· --·- ·-·-·- --··-- ··· ·--- -·-- ----- -</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">··· ·· -··· ----· ··--·· --· ·-·· ·---- - -·-· ····- ····· -- ··· --·- ---·· ··- -· ·-- ·· -··- --··· --··-- --- --·- --·· --··· ·- --- -·-· --·· ··--- ·· ·- --· ----- -···· --··-- ·-- -- ···- ··--- ··--··</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">·-- ·--· -···· - -·- ·- -·· ·-·-·- ··--·· ----- --··· ·-· - - -·-· ··-· ---·· ·-- ·-· -··· -·-· ···- -- ·-· -··· -·-· ··-· · ··· --·- ·-·-·- - ····· ·-·-·- ··· ·· ·--- ·---- --··· ··· -- ···· ·--- --·- ·-· ·· --·· ·-·-·- ·· ·-·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">--- --·- ···-- - --- ·· ·---- ····- -···· -·· -···· · ··- ·-· -··· ·--- -···· ·· --· --·- ----- --··-- · ·· ·-- -··· ···· ·--- ·-· -- ···· -··- ·---- --- ·· ·-·· --··-- ··--·· -··· ·--- ·-·· ·-- ·· -· ·-- ···· ·-·-·- --··--</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">··· - ·--- ·---- ··--·· --· -·-· ·--· ·---- ·- · ·-·· --··· ··· --- ·--- -·-- ··--·· - -·· --··· -· ··· · --· -··- ----· -··· ··-· ·-· -</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-- --· --·- ···- ----- · --- -··- ··--·· -·-- ·---- -·- -· -- -··· -·-· ····- ··· -·-- ···-- ··--·· --- - -··· ----- -· ·-- -· ·-· -·-· -·-- · ·---- ---·· -·-</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-· --· --·· ···-- ·-- ·--- ·-·-·- ··--·· -· ·- ·-· ·--- -·-- -·-· ·---- ····- --- · -··- ---·· ·· --- --· ···· -···· · ·· --·· --··· ·-· -- ···- --··-- ··- -· -··- ----- ··-</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">··- · ···- --··· ---·· ·-·· -··- --· -- - --- ····· ·-·-·- ··-· ··--- ·-·-·- -· --- · --- ··-· ·--- --··-- ·· ·---- --··-- ·-· --· · -··· ···- ·---- --· -·-· --·· ·---- ·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">· ··-· ···· ·-·· --- ··· -·-· --·- -···· - -- -·-- -···· ··- ·- ···· --·· ·-· ···· ··--·· ··- -· ·-· · --·· ····- ---·· --- · ···-- ····- ·-- ·- ···· ···- ---·· ··--·· -·- ·- ·- -·- ----- --··· ----·</line></paragraph></section>\n', 'ezxmltext', 247, 'ger-DE', 4, 0, '', 1),
(0, 199, 60, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421109606"><original attribute_id="248" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 248, 'ger-DE', 4, 0, '', 1),
(0, 181, 61, 0, NULL, 'Test Seite 1-2', 'ezstring', 249, 'ger-DE', 4, 0, 'test seite 1-2', 1),
(0, 182, 61, 0, NULL, '', 'ezstring', 250, 'ger-DE', 4, 0, '', 1),
(0, 184, 61, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>--- · --·- ···- ····- - ----- ···-- ··- ·· ··· -·-- --·· ····- -·- -·-· ···- ----- · ··· · ·--· --·- --··· ··· ··--- ···-- --··-- -· --· -- -··- ---·· -- -·· ·---- ·-·-·- --· -·-· ··-· ···- -·- --</paragraph></section>\n', 'ezxmltext', 251, 'ger-DE', 4, 0, '', 1),
(0, 185, 61, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">--- · --·- ···- ····- - ----- ···-- ··- ·· ··· -·-- --·· ····- -·- -·-· ···- ----- · ··· · ·--· --·- --··· ··· ··--- ···-- --··-- -· --· -- -··- ---·· -- -·· ·---- ·-·-·- --· -·-· ··-· ···- -·- --</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">·· ··-· ·--· ··· --- ·- ·---- ---·· --··-- -·-· ·--· -· --· ·-·· -···· -· -·- ··- ·-·· ····- ·- ·- ·-- ···- ----- ··--- ····· -···· --··· -- ·-- -- -·- ----- ·---- ·-· ···-- -···· ----· ·- ·-- ···· -···· -- -· ··· -·-- ---·· ·-·-·- --· -··- --··· - ·--· --·- ·-·-·- - --- ·-· ·- ···· ·-·-·- - --- ···-- ····· ---·· -··- --·· · -·- -- -·- ··--- ····- --··--</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">··· · ··-· -·-- ----· -·· ·---- --··-- ·- ··· ·-· - ···- -·-- ···-- -·-· -·· ···- -·- ·- ···· ···-- ·-- ·· --· · ·--· -···· - ···- --·· -·- ·- -·· ····- --··-- --· ·---- ·-·-·- --· -· -·· ··--- ·· ·-·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-·- --·· ····· ·-·-·- · -··- ·-·-·- -- --- -·-- ----· ·-- - ·· --· ·-·· ·---- -···· - ··· ··--- ····- ·-·-·- ·-·· ---·· ··--·· ·-- · -··· -·-- ···-- -·- ·- -··· -··- --··· -·- -· --· - ···- -··- --··-- -·- -- ----- ----·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">- ----- ····· -·- ··-· ----· ·-· - --- -·· ···-- · · -·- -·-- ··--·· ·--· ·---- ----· -- --- ·- ··-· ···· -··- ··· ··-· ···- ----· --- ·· -·-- --·· --··· --· -· · -·· ----· --· · ·-· ···· -··- ·-·· ----- ·-· -· -· ·-· ·-·· ·--· ·-·· --·· ··- -·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">--·· ····- --··· ··· -- ····· -···· ----· · --- --- ·--- ··--- - ·--· ····· --··-- ·-- - -··· ·-·· ····· -- ·-- ·--- ----- ·· ·-· -- -·-- ·---- --··-- -·-</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">·- -·-- ···-- ----· --· -·· ·-·· ----- --- -- ··- -·-· ·--- -·-- · -·-· ····· ·-·-·- --- ·· ··- ···· ····- -· ···· ----- ····· · --- -·· ··--·· --· -- --· ·- -··· ···- ··-· ·-·· --··-- ··- -· ·-· -· ·-·· ·--· ··--·· - ----- ·-·-·- ·--</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">··· · ···· ·-·· --·- ····· ·- --- -· -·- -·-- --··· ·--· --··-- ·- ·-- -· --·· ----- ·-- ----- --··· ·· ·-- ·-·· ----· ··- -· ·--- ·--· -·- · ·--- --·- ····- ·-- -- -- -··- ·---- ··--- --· --- - ·---- --··· ----·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">--· ·- ·-·· --·· ··--·· -- --· -···· ----· ···- ---·· -·- -· -·- --·· ---·· -· -· ··- -·· -·-- ·-·-·- --·· ·---- ···-- --- -- · -·· ----- ----· ·-- ·- --·- --··· ·-- · --· -·· ···· -·-- -· -·-· -·· ···- ··· ···-- -···· --- -· ··· -· ···- -·-- ····- ·-· -·· ··--·· ·- --- - ··-· ····· -···· - ··· ···· ··--·· --· - ···· ··--- ··-· --·- -- ·-·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-··- ----- --··· -·- -- --· -· ·-·· ·--· -·-- ·--- ···-- ··· ·· ·-- ·· ···· ···-- ----· ·--· ··--·· ·- ··· ··· -···· ·-·-·- --··-- ·- · ···-- -···· ---·· --· ····· ---·· ·-·-·- · ·-· ···-- ····· · ··· ··· ·-·· ··--- --··-- -· -- ··· -··· ---·· -· ·-· ··--- ····· --·· ····· ---·· ·· ···</line></paragraph></section>\n', 'ezxmltext', 252, 'ger-DE', 4, 0, '', 1),
(0, 199, 61, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421109681"><original attribute_id="253" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 253, 'ger-DE', 4, 0, '', 1),
(0, 182, 64, 0, NULL, '', 'ezstring', 262, 'ger-DE', 4, 0, '', 1),
(0, 185, 62, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-·- -· -·-- ·---- --··· ··· ···· --·· ·- ·-- ·· -··· --·- ---·· -·-- ··--·· · ··- -·- · -··- --·· ····- ·--· -···· ---·· ··· · ··- -·-· --··-- ··--·· ·- -- --·- ····- -···· --- ·--- ·-·-·- - ··· --· ···-- --··· ··--·· -· -··· ---·· ·- ·-· -·-· ·-·· ···- ·· ··- --· -· ···-- ····-</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-- -··- ·---- ··--- --- ·-·· ··--- --- ·- -- --- --·- ·---- ··--·· -··· -··- --· ·- ·--· --·· --··-- -·- · -·- - ···- ---·· --··-- ·· -·· ···· -·- ·--- --·- ·-·-·- -·- ·-</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">·--· ·---- -·- ·- · ··· ·-·· ····· -···· -·· --··-- ·- ·-- ·-- ·--· --·- ····- - -· ·--- ···-- ·-· · -··- -·-- -·- ·---- ---·· ··- --</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">··· -· -·· ····· ----· --· · ·-·· ··--·· ----- --··· ---·· ··- - · ··-· ···- -··- ·-- ·-·· ·--· ----· · ··- ----- -···· ·-- ·· - --·· --··· ··· ·-- -- ···- --··· --··-- ·-- ··--- ··--·· ·- ·--- ·---- -···· ·- --· ··· · -··· -·-· ----· -- ··--- ····- --··-- ·-·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">···- -··- --··-- --- ·· --·· ····· ·- -·- ··- ·· ·--- -···· -·-· --·- ·-·-·- ·-· · · -··· ··-· ···· ·-- ·· ·---- ---·· --- ··· ·· -·-· ·-·· --·- -·-· ····- -···· --· ·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">·-· ·- -·-- ····· -·· ····- ····· ··- -- ·---- ·-·-·- --··-- -- ··· ·- ··· ···· --·- ···-- ·--- -···· ·- ··· ·- --· -··· ·····</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">··- -- -··- ·---- ·· ···· ···-- ··- ·-· ···- ··--·· -· -·· --·- ·- ··· -- ···· ·--· --··-- --· --- -··· ·---- --··· · -·- · ·--· ···-- ··--·· ·- ·-· ···· ·---- -···· · ··· ···- --·· · --- ···- --·· ···-- ·· ·-- -·· -·-- ···--</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-··- --·· ·-·-·- - --- ··· ·- ·--- ····- --··-- · ----- --··-- ··· ··· -· ·--· -···· --· ·--· ···-- ----· · -- ···- ··--- ·-- ··· -··· ·--· ----· -- -- -·-· --··· ··- ··- ···· ····- ····· ·· ···· -··- --- ··</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-·-- --·· ··· -- --· ·- -·-· -·-- -···· --- -- -·· ·-·· --··· --- ··-· ·--· ····· · - -·- ·--- --·- -··- -- ·-- ···- ·-·-·- --··-- ·-· ···- ----- -···· -- -·- -- ···-- --··· ----· ··- ····· ··--·· -- · ·--· ·-·-·- ··--·· ··- ·-- ···- -··- ···-- -·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">· ·-· ----- ··--- ·-·-·- -·-- --·· ····· --· ·· - ·-- ···· ·--· ·-·-·- -· ····- ----· ·-·-·- ··- -· -·· --··-- ·-· ·-- ·-·· --·· ·-·-·- ·- - --· ·-·· --··· --··-- --- ··-· -··- -···· ·- ·--- --·· ··· -· ·· ·-· -··- ----- ···-- ·-· ··--- ····· ·</line></paragraph></section>\n', 'ezxmltext', 257, 'ger-DE', 4, 0, '', 1),
(0, 199, 62, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421109993"><original attribute_id="258" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 258, 'ger-DE', 4, 0, '', 1),
(0, 181, 62, 0, NULL, 'Test Seite 2-1', 'ezstring', 254, 'ger-DE', 4, 0, 'test seite 2-1', 1),
(0, 182, 62, 0, NULL, '', 'ezstring', 255, 'ger-DE', 4, 0, '', 1);
INSERT INTO `ezcontentobject_attribute` (`attribute_original_id`, `contentclassattribute_id`, `contentobject_id`, `data_float`, `data_int`, `data_text`, `data_type_string`, `id`, `language_code`, `language_id`, `sort_key_int`, `sort_key_string`, `version`) VALUES
(0, 184, 62, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>-·- -· -·-- ·---- --··· ··· ···· --·· ·- ·-- ·· -··· --·- ---·· -·-- ··--·· · ··- -·- · -··- --·· ····- ·--· -···· ---·· ··· · ··- -·-· --··-- ··--·· ·- -- --·- ····- -···· --- ·--- ·-·-·- - ··· --· ···-- --··· ··--·· -· -··· ---·· ·- ·-· -·-· ·-·· ···- ·· ··- --· -· ···-- ····-</paragraph></section>\n', 'ezxmltext', 256, 'ger-DE', 4, 0, '', 1),
(0, 181, 64, 0, NULL, 'Test Seite 2-2', 'ezstring', 261, 'ger-DE', 4, 0, 'test seite 2-2', 1),
(0, 184, 64, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>···- ····- --··· · --· ·-· ·- --··· ---·· ···· ····· -- ·-- ·· ·--- ·-·· ····· ··· · --·- ----- --· -- --· --·· --··-- --- - -·-· -·· ··--- -·-- ----- ····- -· ··- -· --- -··- ----- ····- ···- ··--- ·-·-·- - -·-</paragraph></section>\n', 'ezxmltext', 263, 'ger-DE', 4, 0, '', 1),
(0, 185, 64, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">···- ····- --··· · --· ·-· ·- --··· ---·· ···· ····· -- ·-- ·· ·--- ·-·· ····· ··· · --·- ----- --· -- --· --·· --··-- --- - -·-· -·· ··--- -·-- ----- ····- -· ··- -· --- -··- ----- ····- ···- ··--- ·-·-·- - -·-</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">··- -- ·--· ····- ---·· -··· --·- --··-- · ·-· ··- -··· ·--· - -· -·-- --·· ··--- --· -- -·· ··-· -·-- --- ·· ····- ---·· -·- ·-· -·· ----- ··--·· ·- -·- -·· ----- -· -·-· ··-· --- ·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">- --· ···· ----· ·-·-·- ·· ···- -··- ··- ·-· ----- ···-- - -·-· ··--- - ·-· -·· ··-· ----- - --- · ··· ··--- --··· - ··- ·-·· -·-- -·- ·--· ··--- ---·· ·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">·- ···· --··-- ··· -- --·· ····· --- - ·--- ·--· -···· ··- ·--- --·- -·-- - ·-- ·--- ·---- --· · ·-·· ····- --· · -·-- --·· ·-·-·- -· ·-·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-·- -· -·· ----- -·- -··· ·--· ----- -- -··· -··- ·- --- ·--- --··-- ··· ·- ··- --·- ---·· --··-- -· ·- -··· -·-- -···· --·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">···· -·-- ----· -· ··· -· ·-·· -···· ·-- ··· ·· ··--- ····· ·-·-·- ··· · -·· ····- ·- ·---- --··· -·- ·--- -·-- ··--·· - ··· -·- -· -··· ··-· --··· ·-·· --·- ··--- · ·-- -·-- ····- ····· --· - ·--· ·-·-·- --··-- -· --- --· · ··-· --·- ···· -··- · ·-- --- -··· ··-· -· ·· --·- ···-- ··- ·- ··· ·--· ····· ---·· ·-· -· ····· --··--</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-·- -- -·-· ·--- ·-·· --·· ····- ·-·-·- -·- -- ··· ·- -·-· --·- - ·---- ·-·-·- -·- ·-·· ····· ·-- -- -·- · -·-- ----- - ·-·· --·- ----· ·-- -- ·-· ··-· ----- -- -·- ···· ···- - ··· ·--· ···-</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-·- -··- -···· ·- -·-· ·---- ---·· ·- ·-· ····· ·-·-·- --··-- ··· ·- ·· ··- ····· ··--·· ··· ···· ··--- ·-·-·- -- -- ·-· -·· ···-- ·-·-·- -· --· ···-- ····- ····· -·· ·--- ···-- - --· · -··· -·-· ···- ·-· · --- ··-· ···-- --· ·---- ···-- ··--·· · --- -·-- ----· -</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-·- · -·-· -·-- · -·· ·--- --·- ··· ··- ·--· ····- ---·· - ··-· -··- --·· -· -·- ···- -·-- ··- · ·--· ··--·· -·- - --·- ·---- --· - - ·--- --·· ---·· --· ··· -···· --··-- ·</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">-·-· ···-- ---·· ·-- ·· -- -·- -··· -·· ····- -··· ···- --··-- ··· -- -·-· -·-- ···-- -· --- -··· ·---- --· ·- --- - ·-·· --··-- - --- ··--- -···· ··--·· · --·· --··-- ··- ·- -··· -···· ·--</line></paragraph></section>\n', 'ezxmltext', 264, 'ger-DE', 4, 0, '', 1),
(0, 199, 64, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421110109"><original attribute_id="265" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 265, 'ger-DE', 4, 0, '', 1),
(0, 188, 58, 0, NULL, 'TEST Folder eng-GB', 'ezstring', 266, 'eng-GB', 2, 0, 'test folder eng-gb', 2),
(0, 189, 58, 0, NULL, '', 'ezstring', 267, 'eng-GB', 2, 0, '', 2),
(0, 190, 58, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>This Folder is written in english eng-GB</paragraph></section>\n', 'ezxmltext', 268, 'eng-GB', 2, 0, '', 2),
(269, 200, 58, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421109345"><original attribute_id="237" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 269, 'eng-GB', 2, 0, '', 2),
(270, 192, 58, 0, 1, '', 'ezboolean', 270, 'eng-GB', 2, 1, '', 2),
(0, 188, 58, 0, NULL, 'Test Ordner 1', 'ezstring', 234, 'ger-DE', 5, 0, 'test ordner 1', 2),
(0, 189, 58, 0, NULL, '', 'ezstring', 235, 'ger-DE', 5, 0, '', 2),
(0, 190, 58, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>--·- ····- ----· · ··· --· -··· ----- ·· --· ···-- ··--·· · ·· ··· -··- ---·· ·-·-·- - ----- ·---- ··- ·--- ----· ·-· ·· ··- ···-- --··-- ·- ·-· ·- ··-· -···· --··· -··· -·· ----- ·· ··· ·-- -- ·--- ----- ··-· --·· -· ·-- ·--· -··- ·- --- -· -··· ----· ·--</paragraph></section>\n', 'ezxmltext', 236, 'ger-DE', 5, 0, '', 2),
(269, 200, 58, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421109345"><original attribute_id="237" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 237, 'ger-DE', 5, 0, '', 2),
(270, 192, 58, 0, 1, '', 'ezboolean', 238, 'ger-DE', 5, 1, '', 2),
(0, 188, 58, 0, NULL, 'Test Ordner 1 ger-DE', 'ezstring', 234, 'ger-DE', 5, 0, 'test ordner 1 ger-de', 3),
(0, 189, 58, 0, NULL, '', 'ezstring', 235, 'ger-DE', 5, 0, '', 3),
(0, 190, 58, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Dieser Ordner wurde in deutsch geschrieben ger-DE</paragraph></section>\n', 'ezxmltext', 236, 'ger-DE', 5, 0, '', 3),
(0, 188, 58, 0, NULL, 'TEST Folder eng-GB', 'ezstring', 266, 'eng-GB', 2, 0, 'test folder eng-gb', 3),
(0, 189, 58, 0, NULL, '', 'ezstring', 267, 'eng-GB', 2, 0, '', 3),
(0, 190, 58, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>This Folder is written in english eng-GB</paragraph></section>\n', 'ezxmltext', 268, 'eng-GB', 2, 0, '', 3),
(237, 200, 58, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421109345"><original attribute_id="237" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 237, 'ger-DE', 5, 0, '', 3),
(238, 192, 58, 0, 1, '', 'ezboolean', 238, 'ger-DE', 5, 1, '', 3),
(237, 200, 58, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421109345"><original attribute_id="237" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 269, 'eng-GB', 2, 0, '', 3),
(238, 192, 58, 0, 1, '', 'ezboolean', 270, 'eng-GB', 2, 1, '', 3),
(0, 192, 65, 0, 1, '', 'ezboolean', 275, 'ger-DE', 4, 1, '', 2),
(0, 188, 65, 0, NULL, 'Ordner 3 ger', 'ezstring', 271, 'ger-DE', 4, 0, 'ordner 3 ger', 1),
(0, 189, 65, 0, NULL, '', 'ezstring', 272, 'ger-DE', 4, 0, '', 1),
(0, 190, 65, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 273, 'ger-DE', 4, 0, '', 1),
(0, 189, 65, 0, NULL, '', 'ezstring', 272, 'ger-DE', 4, 0, '', 2),
(0, 190, 65, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Dieser Ordner ist in deutsch geschrieben</paragraph></section>\n', 'ezxmltext', 273, 'ger-DE', 4, 0, '', 2),
(0, 200, 65, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1437142053"><original attribute_id="274" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 274, 'ger-DE', 4, 0, '', 2),
(0, 188, 65, 0, NULL, 'Ordner 2 -  ger-DE', 'ezstring', 271, 'ger-DE', 4, 0, 'ordner 2 -  ger-de', 2),
(0, 200, 65, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1437142053"><original attribute_id="274" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 274, 'ger-DE', 4, 0, '', 1),
(0, 192, 65, 0, 1, '', 'ezboolean', 275, 'ger-DE', 4, 1, '', 1),
(0, 207, 66, 0, NULL, 'Kontaktformular', 'ezstring', 276, 'ger-DE', 4, 0, 'kontaktformular', 2),
(0, 208, 66, 0, NULL, '', 'ezstring', 277, 'ger-DE', 4, 0, '', 2),
(0, 209, 66, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Hier können Sie uns eine Nachricht schreiben</paragraph></section>\n', 'ezxmltext', 278, 'ger-DE', 4, 0, '', 2),
(0, 210, 66, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1437142899"><original attribute_id="279" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 279, 'ger-DE', 4, 0, '', 2),
(0, 212, 66, 0, NULL, '', 'ezemail', 280, 'ger-DE', 4, 0, '', 2),
(0, 213, 66, 0, NULL, '', 'eztext', 281, 'ger-DE', 4, 0, '', 2),
(0, 214, 66, 0, NULL, '', 'ezstring', 282, 'ger-DE', 4, 0, '', 2),
(0, 207, 66, 0, NULL, 'Feedbackform', 'ezstring', 283, 'eng-GB', 2, 0, 'feedbackform', 3),
(0, 208, 66, 0, NULL, '', 'ezstring', 284, 'eng-GB', 2, 0, '', 3),
(0, 209, 66, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Here you can send us a message :-)</paragraph></section>\n', 'ezxmltext', 285, 'eng-GB', 2, 0, '', 3),
(286, 210, 66, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1437142899"><original attribute_id="279" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 286, 'eng-GB', 2, 0, '', 3),
(0, 212, 66, 0, NULL, '', 'ezemail', 287, 'eng-GB', 2, 0, '', 3),
(0, 213, 66, 0, NULL, '', 'eztext', 288, 'eng-GB', 2, 0, '', 3),
(0, 214, 66, 0, NULL, '', 'ezstring', 289, 'eng-GB', 2, 0, '', 3),
(0, 207, 66, 0, NULL, 'Kontaktformular', 'ezstring', 276, 'ger-DE', 4, 0, 'kontaktformular', 3),
(0, 208, 66, 0, NULL, '', 'ezstring', 277, 'ger-DE', 4, 0, '', 3),
(0, 209, 66, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Hier können Sie uns eine Nachricht schreiben</paragraph></section>\n', 'ezxmltext', 278, 'ger-DE', 4, 0, '', 3),
(0, 210, 66, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1437142899"><original attribute_id="279" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 279, 'ger-DE', 4, 0, '', 3),
(0, 212, 66, 0, NULL, '', 'ezemail', 280, 'ger-DE', 4, 0, '', 3),
(0, 213, 66, 0, NULL, '', 'eztext', 281, 'ger-DE', 4, 0, '', 3),
(0, 214, 66, 0, NULL, '', 'ezstring', 282, 'ger-DE', 4, 0, '', 3),
(0, 181, 60, 0, NULL, 'Test Seite 1-1', 'ezstring', 244, 'ger-DE', 4, 0, 'test seite 1-1', 2),
(0, 182, 60, 0, NULL, '', 'ezstring', 245, 'ger-DE', 4, 0, '', 2),
(0, 184, 60, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Ich bin ein Blindtext. Von Geburt an. Es hat sehr lange gedauert, bis ich begriffen habe, was es bedeutet, ein blinder Text zu sein: Man macht keinen Sinn. </paragraph></section>\n', 'ezxmltext', 246, 'ger-DE', 4, 0, '', 2),
(0, 185, 60, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Man wirkt hier und da aus dem Zusammenhang gerissen. Oft wird man gar nicht erst gelesen. Aber bin ich deswegen ein schlechter Text? Ich weiss, dass ich niemals die Chance habe in einer grossen Zeitung zu erscheinen. Aber bin ich deswegen weniger wichtig? Ich bin blind! Aber ich bin gerne ein Text.</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Und sollten Sie mich jetzt dennoch zu ende lesen, dann habe ich etwas geschafft, was den meisten normalen Texten nicht gelingt.</line></paragraph><section><header>Ich bin ein Blindtext.</header><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Von Geburt an. Es hat sehr lange gedauert, bis ich begriffen habe, was es bedeutet, ein blinder Text zu sein: Man macht keinen Sinn. Man wirkt hier und da aus dem Zusammenhang gerissen. Oft wird man gar nicht erst gelesen. Aber bin ich deswegen ein schlechter Text? Ich weiss, dass ich niemals die Chance habe in einer grossen Zeitung zu erscheinen. Aber bin ich deswegen weniger wichtig? Ich bin blind! Aber ich bin gerne ein Text.</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Und sollten Sie mich jetzt dennoch zu ende lesen, dann habe ich etwas geschafft, was den meisten normalen Texten nicht gelingt.</line></paragraph></section></section>\n', 'ezxmltext', 247, 'ger-DE', 4, 0, '', 2),
(0, 199, 60, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="1" filename="Test-Seite-1-1.jpg" suffix="jpg" basename="Test-Seite-1-1" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-1/248-2-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-1/248-2-ger-DE/Test-Seite-1-1.jpg" original_filename="IMG_0362.jpg" mime_type="image/jpeg" width="1170" height="878" alternative_text="Dahlie" alias_key="1293033771" timestamp="1439386774"><original attribute_id="248" attribute_version="2" attribute_language="ger-DE"/><information Height="878" Width="1170" IsColor="1" ByteOrderMotorola="1" CCDWidth="2mm" ApertureFNumber="f/4.9" Thumbnail.FileType="2" Thumbnail.MimeType="image/jpeg"><serialized name="ifd0" data="a:15:{s:10:&quot;ImageWidth&quot;;i:3648;s:11:&quot;ImageLength&quot;;i:2736;s:13:&quot;BitsPerSample&quot;;a:3:{i:0;i:8;i:1;i:8;i:2;i:8;}s:25:&quot;PhotometricInterpretation&quot;;i:2;s:16:&quot;ImageDescription&quot;;s:31:&quot;                               &quot;;s:4:&quot;Make&quot;;s:5:&quot;Canon&quot;;s:5:&quot;Model&quot;;s:19:&quot;Canon PowerShot S90&quot;;s:11:&quot;Orientation&quot;;i:1;s:15:&quot;SamplesPerPixel&quot;;i:3;s:11:&quot;XResolution&quot;;s:13:&quot;1800000/10000&quot;;s:11:&quot;YResolution&quot;;s:13:&quot;1800000/10000&quot;;s:14:&quot;ResolutionUnit&quot;;i:2;s:8:&quot;Software&quot;;s:31:&quot;Adobe Photoshop CS5.1 Macintosh&quot;;s:8:&quot;DateTime&quot;;s:19:&quot;2015:08:12 15:12:20&quot;;s:16:&quot;Exif_IFD_Pointer&quot;;i:328;}"/><array name="exif"><item key="ExposureTime" base64="1">MS8yNTA=</item><item key="FNumber" base64="1">NDkvMTA=</item><item key="ISOSpeedRatings" base64="1">ODA=</item><item key="ExifVersion" base64="1">MDIyMQ==</item><item key="DateTimeOriginal" base64="1">MjAxMzowOToyOSAxNDoyMzozMQ==</item><item key="DateTimeDigitized" base64="1">MjAxMzowOToyOSAxNDoyMzozMQ==</item><item key="ComponentsConfiguration" base64="1">AQIDAA==</item><item key="CompressedBitsPerPixel" base64="1">My8x</item><item key="ShutterSpeedValue" base64="1">MjU1LzMy</item><item key="ApertureValue" base64="1">MTQ3LzMy</item><item key="ExposureBiasValue" base64="1">MC8x</item><item key="MaxApertureValue" base64="1">MTQ3LzMy</item><item key="MeteringMode" base64="1">NQ==</item><item key="Flash" base64="1">MTY=</item><item key="FocalLength" base64="1">NDUvMg==</item><item key="FlashPixVersion" base64="1">MDEwMA==</item><item key="ColorSpace" base64="1">MQ==</item><item key="ExifImageWidth" base64="1">MTE3MA==</item><item key="ExifImageLength" base64="1">ODc4</item><item key="FocalPlaneXResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneYResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneResolutionUnit" base64="1">Mg==</item><item key="SensingMethod" base64="1">Mg==</item><item key="FileSource" base64="1">Aw==</item><item key="CustomRendered" base64="1">MA==</item><item key="ExposureMode" base64="1">MA==</item><item key="WhiteBalance" base64="1">MA==</item><item key="DigitalZoomRatio" base64="1">MS8x</item><item key="SceneCaptureType" base64="1">MA==</item></array></information><alias name="reference" filename="Test-Seite-1-1_reference.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-1/248-2-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-1/248-2-ger-DE/Test-Seite-1-1_reference.jpg" mime_type="image/jpeg" width="600" height="450" alias_key="2605465115" timestamp="1439393039" is_valid="1"/><alias name="small" filename="Test-Seite-1-1_small.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-1/248-2-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-1/248-2-ger-DE/Test-Seite-1-1_small.jpg" mime_type="image/jpeg" width="120" height="90" alias_key="4099042024" timestamp="1439393039" is_valid="1"/></ezimage>\n', 'ezimage', 248, 'ger-DE', 4, 0, '', 2),
(0, 181, 61, 0, NULL, 'Test Seite 1-2', 'ezstring', 249, 'ger-DE', 4, 0, 'test seite 1-2', 2),
(0, 182, 61, 0, NULL, '', 'ezstring', 250, 'ger-DE', 4, 0, '', 2),
(0, 184, 61, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Seite 2: Ich bin ein Blindtext. Von Geburt an. Es hat sehr lange gedauert, bis ich begriffen habe, was es bedeutet, ein blinder Text zu sein: Man macht keinen Sinn.</paragraph></section>\n', 'ezxmltext', 251, 'ger-DE', 4, 0, '', 2),
(0, 181, 62, 0, NULL, 'Test Seite 2-1', 'ezstring', 254, 'ger-DE', 4, 0, 'test seite 2-1', 2),
(0, 185, 61, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Seite 2: Man wirkt hier und da aus dem Zusammenhang gerissen. Oft wird man gar nicht erst gelesen. Aber bin ich deswegen ein schlechter Text? Ich weiss, dass ich niemals die Chance habe in einer grossen Zeitung zu erscheinen. Aber bin ich deswegen weniger wichtig? Ich bin blind! Aber ich bin gerne ein Text.</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Und sollten Sie mich jetzt dennoch zu ende lesen, dann habe ich etwas geschafft, was den meisten normalen Texten nicht gelingt.</line></paragraph><section><header>Header 1 Seite 2</header><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Ich bin ein Blindtext. Von Geburt an. Es hat sehr lange gedauert, bis ich begriffen habe, was es bedeutet, ein blinder Text zu sein: Man macht keinen Sinn. Man wirkt hier und da aus dem Zusammenhang gerissen. Oft wird man gar nicht erst gelesen. Aber bin ich deswegen ein schlechter Text? Ich weiss, dass ich niemals die Chance habe in einer grossen Zeitung zu erscheinen. Aber bin ich deswegen weniger wichtig? Ich bin blind! Aber ich bin gerne ein Text.</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Und sollten Sie mich jetzt dennoch zu ende lesen, dann habe ich etwas geschafft, was den meisten normalen Texten nicht gelingt.</line></paragraph></section></section>\n', 'ezxmltext', 252, 'ger-DE', 4, 0, '', 2),
(0, 182, 62, 0, NULL, '', 'ezstring', 255, 'ger-DE', 4, 0, '', 2),
(0, 184, 62, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Seite 2-1: Ich bin ein Blindtext. Von Geburt an. Es hat sehr lange gedauert, bis ich begriffen habe, was es bedeutet, ein blinder Text zu sein: Man macht keinen Sinn. </paragraph></section>\n', 'ezxmltext', 256, 'ger-DE', 4, 0, '', 2),
(0, 185, 62, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Man wirkt hier und da aus dem Zusammenhang gerissen. Oft wird man gar nicht erst gelesen. Aber bin ich deswegen ein schlechter Text? Ich weiss, dass ich niemals die Chance habe in einer grossen Zeitung zu erscheinen. Aber bin ich deswegen weniger wichtig? Ich bin blind! Aber ich bin gerne ein Text.</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Und sollten Sie mich jetzt dennoch zu ende lesen, dann habe ich etwas geschafft, was den meisten normalen Texten nicht gelingt.</line></paragraph><section><header>Header 1 Seite 2-1</header><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Ich bin ein Blindtext. Von Geburt an. Es hat sehr lange gedauert, bis ich begriffen habe, was es bedeutet, ein blinder Text zu sein: Man macht keinen Sinn. Man wirkt hier und da aus dem Zusammenhang gerissen. Oft wird man gar nicht erst gelesen. Aber bin ich deswegen ein schlechter Text? Ich weiss, dass ich niemals die Chance habe in einer grossen Zeitung zu erscheinen. Aber bin ich deswegen weniger wichtig? Ich bin blind! Aber ich bin gerne ein Text.</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Und sollten Sie mich jetzt dennoch zu ende lesen, dann habe ich etwas geschafft, was den meisten normalen Texten nicht gelingt.</line></paragraph></section></section>\n', 'ezxmltext', 257, 'ger-DE', 4, 0, '', 2),
(0, 199, 61, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="1" filename="Test-Seite-1-2.jpg" suffix="jpg" basename="Test-Seite-1-2" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-2/253-2-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-2/253-2-ger-DE/Test-Seite-1-2.jpg" original_filename="IMG_0252.jpg" mime_type="image/jpeg" width="1170" height="878" alternative_text="Dahlie" alias_key="1293033771" timestamp="1439386922"><original attribute_id="253" attribute_version="2" attribute_language="ger-DE"/><information Height="878" Width="1170" IsColor="1" ByteOrderMotorola="1" CCDWidth="2mm" ApertureFNumber="f/4.0" Thumbnail.FileType="2" Thumbnail.MimeType="image/jpeg"><serialized name="ifd0" data="a:15:{s:10:&quot;ImageWidth&quot;;i:3648;s:11:&quot;ImageLength&quot;;i:2736;s:13:&quot;BitsPerSample&quot;;a:3:{i:0;i:8;i:1;i:8;i:2;i:8;}s:25:&quot;PhotometricInterpretation&quot;;i:2;s:16:&quot;ImageDescription&quot;;s:31:&quot;                               &quot;;s:4:&quot;Make&quot;;s:5:&quot;Canon&quot;;s:5:&quot;Model&quot;;s:19:&quot;Canon PowerShot S90&quot;;s:11:&quot;Orientation&quot;;i:1;s:15:&quot;SamplesPerPixel&quot;;i:3;s:11:&quot;XResolution&quot;;s:13:&quot;1800000/10000&quot;;s:11:&quot;YResolution&quot;;s:13:&quot;1800000/10000&quot;;s:14:&quot;ResolutionUnit&quot;;i:2;s:8:&quot;Software&quot;;s:31:&quot;Adobe Photoshop CS5.1 Macintosh&quot;;s:8:&quot;DateTime&quot;;s:19:&quot;2015:08:12 15:09:59&quot;;s:16:&quot;Exif_IFD_Pointer&quot;;i:328;}"/><array name="exif"><item key="ExposureTime" base64="1">MS8xMDA=</item><item key="FNumber" base64="1">NC8x</item><item key="ISOSpeedRatings" base64="1">ODA=</item><item key="ExifVersion" base64="1">MDIyMQ==</item><item key="DateTimeOriginal" base64="1">MjAxMzowOToyOSAxMzoyMjoyNg==</item><item key="DateTimeDigitized" base64="1">MjAxMzowOToyOSAxMzoyMjoyNg==</item><item key="ComponentsConfiguration" base64="1">AQIDAA==</item><item key="CompressedBitsPerPixel" base64="1">My8x</item><item key="ShutterSpeedValue" base64="1">MjEzLzMy</item><item key="ApertureValue" base64="1">NC8x</item><item key="ExposureBiasValue" base64="1">MC8x</item><item key="MaxApertureValue" base64="1">MTA3LzMy</item><item key="MeteringMode" base64="1">NQ==</item><item key="Flash" base64="1">MTY=</item><item key="FocalLength" base64="1">MTA3MDEvMTAwMA==</item><item key="FlashPixVersion" base64="1">MDEwMA==</item><item key="ColorSpace" base64="1">MQ==</item><item key="ExifImageWidth" base64="1">MTE3MA==</item><item key="ExifImageLength" base64="1">ODc4</item><item key="FocalPlaneXResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneYResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneResolutionUnit" base64="1">Mg==</item><item key="SensingMethod" base64="1">Mg==</item><item key="FileSource" base64="1">Aw==</item><item key="CustomRendered" base64="1">MA==</item><item key="ExposureMode" base64="1">MA==</item><item key="WhiteBalance" base64="1">MA==</item><item key="DigitalZoomRatio" base64="1">MS8x</item><item key="SceneCaptureType" base64="1">MA==</item></array></information><alias name="reference" filename="Test-Seite-1-2_reference.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-2/253-2-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-2/253-2-ger-DE/Test-Seite-1-2_reference.jpg" mime_type="image/jpeg" width="600" height="450" alias_key="2605465115" timestamp="1439393039" is_valid="1"/><alias name="small" filename="Test-Seite-1-2_small.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-2/253-2-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-2/253-2-ger-DE/Test-Seite-1-2_small.jpg" mime_type="image/jpeg" width="120" height="90" alias_key="4099042024" timestamp="1439393039" is_valid="1"/></ezimage>\n', 'ezimage', 253, 'ger-DE', 4, 0, '', 2),
(0, 199, 62, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="1" filename="Test-Seite-2-1.jpg" suffix="jpg" basename="Test-Seite-2-1" dirpath="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-1/258-2-ger-DE" url="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-1/258-2-ger-DE/Test-Seite-2-1.jpg" original_filename="IMG_0270.jpg" mime_type="image/jpeg" width="1170" height="878" alternative_text="Dahlie" alias_key="1293033771" timestamp="1439387050"><original attribute_id="258" attribute_version="2" attribute_language="ger-DE"/><information Height="878" Width="1170" IsColor="1" ByteOrderMotorola="1" CCDWidth="2mm" ApertureFNumber="f/6.3" Thumbnail.FileType="2" Thumbnail.MimeType="image/jpeg"><serialized name="ifd0" data="a:15:{s:10:&quot;ImageWidth&quot;;i:3648;s:11:&quot;ImageLength&quot;;i:2736;s:13:&quot;BitsPerSample&quot;;a:3:{i:0;i:8;i:1;i:8;i:2;i:8;}s:25:&quot;PhotometricInterpretation&quot;;i:2;s:16:&quot;ImageDescription&quot;;s:31:&quot;                               &quot;;s:4:&quot;Make&quot;;s:5:&quot;Canon&quot;;s:5:&quot;Model&quot;;s:19:&quot;Canon PowerShot S90&quot;;s:11:&quot;Orientation&quot;;i:1;s:15:&quot;SamplesPerPixel&quot;;i:3;s:11:&quot;XResolution&quot;;s:13:&quot;1800000/10000&quot;;s:11:&quot;YResolution&quot;;s:13:&quot;1800000/10000&quot;;s:14:&quot;ResolutionUnit&quot;;i:2;s:8:&quot;Software&quot;;s:31:&quot;Adobe Photoshop CS5.1 Macintosh&quot;;s:8:&quot;DateTime&quot;;s:19:&quot;2015:08:12 15:11:18&quot;;s:16:&quot;Exif_IFD_Pointer&quot;;i:328;}"/><array name="exif"><item key="ExposureTime" base64="1">MS81MDA=</item><item key="FNumber" base64="1">NjMvMTA=</item><item key="ISOSpeedRatings" base64="1">MTI1</item><item key="ExifVersion" base64="1">MDIyMQ==</item><item key="DateTimeOriginal" base64="1">MjAxMzowOToyOSAxMzoyODowMQ==</item><item key="DateTimeDigitized" base64="1">MjAxMzowOToyOSAxMzoyODowMQ==</item><item key="ComponentsConfiguration" base64="1">AQIDAA==</item><item key="CompressedBitsPerPixel" base64="1">My8x</item><item key="ShutterSpeedValue" base64="1">Mjg3LzMy</item><item key="ApertureValue" base64="1">ODUvMTY=</item><item key="ExposureBiasValue" base64="1">MC8x</item><item key="MaxApertureValue" base64="1">MTQ3LzMy</item><item key="MeteringMode" base64="1">NQ==</item><item key="Flash" base64="1">MTY=</item><item key="FocalLength" base64="1">NDUvMg==</item><item key="FlashPixVersion" base64="1">MDEwMA==</item><item key="ColorSpace" base64="1">MQ==</item><item key="ExifImageWidth" base64="1">MTE3MA==</item><item key="ExifImageLength" base64="1">ODc4</item><item key="FocalPlaneXResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneYResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneResolutionUnit" base64="1">Mg==</item><item key="SensingMethod" base64="1">Mg==</item><item key="FileSource" base64="1">Aw==</item><item key="CustomRendered" base64="1">MA==</item><item key="ExposureMode" base64="1">MA==</item><item key="WhiteBalance" base64="1">MA==</item><item key="DigitalZoomRatio" base64="1">MS8x</item><item key="SceneCaptureType" base64="1">MA==</item></array></information><alias name="reference" filename="Test-Seite-2-1_reference.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-1/258-2-ger-DE" url="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-1/258-2-ger-DE/Test-Seite-2-1_reference.jpg" mime_type="image/jpeg" width="600" height="450" alias_key="2605465115" timestamp="1439387056" is_valid="1"/><alias name="small" filename="Test-Seite-2-1_small.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-1/258-2-ger-DE" url="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-1/258-2-ger-DE/Test-Seite-2-1_small.jpg" mime_type="image/jpeg" width="120" height="90" alias_key="4099042024" timestamp="1439387056" is_valid="1"/></ezimage>\n', 'ezimage', 258, 'ger-DE', 4, 0, '', 2),
(0, 181, 64, 0, NULL, 'Test Seite 2-2', 'ezstring', 261, 'ger-DE', 4, 0, 'test seite 2-2', 2),
(0, 182, 64, 0, NULL, '', 'ezstring', 262, 'ger-DE', 4, 0, '', 2),
(0, 184, 64, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Ich bin ein Blindtext. Von Geburt an. Es hat sehr lange gedauert, bis ich begriffen habe, was es bedeutet, ein blinder Text zu sein: Man macht keinen Sinn. </paragraph></section>\n', 'ezxmltext', 263, 'ger-DE', 4, 0, '', 2),
(0, 185, 64, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Seite 2-2: Man wirkt hier und da aus dem Zusammenhang gerissen. Oft wird man gar nicht erst gelesen. Aber bin ich deswegen ein schlechter Text? Ich weiss, dass ich niemals die Chance habe in einer grossen Zeitung zu erscheinen. Aber bin ich deswegen weniger wichtig? Ich bin blind! Aber ich bin gerne ein Text.</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Und sollten Sie mich jetzt dennoch zu ende lesen, dann habe ich etwas geschafft, was den meisten normalen Texten nicht gelingt.</line></paragraph><section><header>Header 1 Seite 2-2</header><paragraph><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Ich bin ein Blindtext. Von Geburt an. Es hat sehr lange gedauert, bis ich begriffen habe, was es bedeutet, ein blinder Text zu sein: Man macht keinen Sinn. Man wirkt hier und da aus dem Zusammenhang gerissen. Oft wird man gar nicht erst gelesen. Aber bin ich deswegen ein schlechter Text? Ich weiss, dass ich niemals die Chance habe in einer grossen Zeitung zu erscheinen. Aber bin ich deswegen weniger wichtig? Ich bin blind! Aber ich bin gerne ein Text.</line><line xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">Und sollten Sie mich jetzt dennoch zu ende lesen, dann habe ich etwas geschafft, was den meisten normalen Texten nicht gelingt.</line></paragraph></section></section>\n', 'ezxmltext', 264, 'ger-DE', 4, 0, '', 2),
(0, 199, 64, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="1" filename="Test-Seite-2-2.jpg" suffix="jpg" basename="Test-Seite-2-2" dirpath="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-2/265-2-ger-DE" url="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-2/265-2-ger-DE/Test-Seite-2-2.jpg" original_filename="IMG_0329.jpg" mime_type="image/jpeg" width="1170" height="878" alternative_text="Dahlie" alias_key="1293033771" timestamp="1439387124"><original attribute_id="265" attribute_version="2" attribute_language="ger-DE"/><information Height="878" Width="1170" IsColor="1" ByteOrderMotorola="1" CCDWidth="2mm" ApertureFNumber="f/5.0" Thumbnail.FileType="2" Thumbnail.MimeType="image/jpeg"><serialized name="ifd0" data="a:15:{s:10:&quot;ImageWidth&quot;;i:3648;s:11:&quot;ImageLength&quot;;i:2736;s:13:&quot;BitsPerSample&quot;;a:3:{i:0;i:8;i:1;i:8;i:2;i:8;}s:25:&quot;PhotometricInterpretation&quot;;i:2;s:16:&quot;ImageDescription&quot;;s:31:&quot;                               &quot;;s:4:&quot;Make&quot;;s:5:&quot;Canon&quot;;s:5:&quot;Model&quot;;s:19:&quot;Canon PowerShot S90&quot;;s:11:&quot;Orientation&quot;;i:1;s:15:&quot;SamplesPerPixel&quot;;i:3;s:11:&quot;XResolution&quot;;s:13:&quot;1800000/10000&quot;;s:11:&quot;YResolution&quot;;s:13:&quot;1800000/10000&quot;;s:14:&quot;ResolutionUnit&quot;;i:2;s:8:&quot;Software&quot;;s:31:&quot;Adobe Photoshop CS5.1 Macintosh&quot;;s:8:&quot;DateTime&quot;;s:19:&quot;2015:08:12 15:12:07&quot;;s:16:&quot;Exif_IFD_Pointer&quot;;i:328;}"/><array name="exif"><item key="ExposureTime" base64="1">MS81MDA=</item><item key="FNumber" base64="1">NS8x</item><item key="ISOSpeedRatings" base64="1">MTI1</item><item key="ExifVersion" base64="1">MDIyMQ==</item><item key="DateTimeOriginal" base64="1">MjAxMzowOToyOSAxMzo1OTo0MQ==</item><item key="DateTimeDigitized" base64="1">MjAxMzowOToyOSAxMzo1OTo0MQ==</item><item key="ComponentsConfiguration" base64="1">AQIDAA==</item><item key="CompressedBitsPerPixel" base64="1">My8x</item><item key="ShutterSpeedValue" base64="1">Mjg3LzMy</item><item key="ApertureValue" base64="1">MTQ5LzMy</item><item key="ExposureBiasValue" base64="1">MC8x</item><item key="MaxApertureValue" base64="1">MjkvOA==</item><item key="MeteringMode" base64="1">NQ==</item><item key="Flash" base64="1">MTY=</item><item key="FocalLength" base64="1">MjU2OS8yMDA=</item><item key="FlashPixVersion" base64="1">MDEwMA==</item><item key="ColorSpace" base64="1">MQ==</item><item key="ExifImageWidth" base64="1">MTE3MA==</item><item key="ExifImageLength" base64="1">ODc4</item><item key="FocalPlaneXResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneYResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneResolutionUnit" base64="1">Mg==</item><item key="SensingMethod" base64="1">Mg==</item><item key="FileSource" base64="1">Aw==</item><item key="CustomRendered" base64="1">MA==</item><item key="ExposureMode" base64="1">MA==</item><item key="WhiteBalance" base64="1">MA==</item><item key="DigitalZoomRatio" base64="1">MS8x</item><item key="SceneCaptureType" base64="1">MA==</item></array></information><alias name="reference" filename="Test-Seite-2-2_reference.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-2/265-2-ger-DE" url="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-2/265-2-ger-DE/Test-Seite-2-2_reference.jpg" mime_type="image/jpeg" width="600" height="450" alias_key="2605465115" timestamp="1439387130" is_valid="1"/><alias name="small" filename="Test-Seite-2-2_small.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-2/265-2-ger-DE" url="var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-2/265-2-ger-DE/Test-Seite-2-2_small.jpg" mime_type="image/jpeg" width="120" height="90" alias_key="4099042024" timestamp="1439387130" is_valid="1"/></ezimage>\n', 'ezimage', 265, 'ger-DE', 4, 0, '', 2),
(0, 188, 58, 0, NULL, 'TEST Folder eng-GB', 'ezstring', 266, 'eng-GB', 2, 0, 'test folder eng-gb', 4),
(0, 189, 58, 0, NULL, '', 'ezstring', 267, 'eng-GB', 2, 0, '', 4),
(0, 190, 58, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>This folder is written in english eng-GB</paragraph></section>\n', 'ezxmltext', 268, 'eng-GB', 2, 0, '', 4),
(269, 200, 58, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421109345"><original attribute_id="237" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 269, 'eng-GB', 2, 0, '', 4),
(270, 192, 58, 0, 1, '', 'ezboolean', 270, 'eng-GB', 2, 1, '', 4),
(0, 188, 58, 0, NULL, 'Test Ordner 1 ger-DE', 'ezstring', 234, 'ger-DE', 5, 0, 'test ordner 1 ger-de', 4),
(0, 189, 58, 0, NULL, '', 'ezstring', 235, 'ger-DE', 5, 0, '', 4),
(0, 190, 58, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Dieser Ordner wurde in deutsch geschrieben ger-DE</paragraph></section>\n', 'ezxmltext', 236, 'ger-DE', 5, 0, '', 4),
(269, 200, 58, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="" filename="" suffix="" basename="" dirpath="" url="" original_filename="" mime_type="" width="" height="" alternative_text="" alias_key="1293033771" timestamp="1421109345"><original attribute_id="237" attribute_version="1" attribute_language="ger-DE"/></ezimage>\n', 'ezimage', 237, 'ger-DE', 5, 0, '', 4),
(270, 192, 58, 0, 1, '', 'ezboolean', 238, 'ger-DE', 5, 1, '', 4),
(0, 188, 58, 0, NULL, 'Test Ordner 1 ger-DE', 'ezstring', 234, 'ger-DE', 5, 0, 'test ordner 1 ger-de', 5),
(0, 189, 58, 0, NULL, '', 'ezstring', 235, 'ger-DE', 5, 0, '', 5),
(0, 190, 58, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>Dieser Ordner wurde in deutsch geschrieben ger-DE</paragraph></section>\n', 'ezxmltext', 236, 'ger-DE', 5, 0, '', 5),
(237, 200, 58, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="1" filename="Test-Ordner-1-ger-DE.jpg" suffix="jpg" basename="Test-Ordner-1-ger-DE" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE.jpg" original_filename="IMG_0277.jpg" mime_type="image/jpeg" width="1170" height="878" alternative_text="Dahlie" alias_key="1293033771" timestamp="1439387270"><original attribute_id="237" attribute_version="5" attribute_language="ger-DE"/><information Height="878" Width="1170" IsColor="1" ByteOrderMotorola="1" CCDWidth="2mm" ApertureFNumber="f/4.0" Thumbnail.FileType="2" Thumbnail.MimeType="image/jpeg"><serialized name="ifd0" data="a:15:{s:10:&quot;ImageWidth&quot;;i:3648;s:11:&quot;ImageLength&quot;;i:2736;s:13:&quot;BitsPerSample&quot;;a:3:{i:0;i:8;i:1;i:8;i:2;i:8;}s:25:&quot;PhotometricInterpretation&quot;;i:2;s:16:&quot;ImageDescription&quot;;s:31:&quot;                               &quot;;s:4:&quot;Make&quot;;s:5:&quot;Canon&quot;;s:5:&quot;Model&quot;;s:19:&quot;Canon PowerShot S90&quot;;s:11:&quot;Orientation&quot;;i:1;s:15:&quot;SamplesPerPixel&quot;;i:3;s:11:&quot;XResolution&quot;;s:13:&quot;1800000/10000&quot;;s:11:&quot;YResolution&quot;;s:13:&quot;1800000/10000&quot;;s:14:&quot;ResolutionUnit&quot;;i:2;s:8:&quot;Software&quot;;s:31:&quot;Adobe Photoshop CS5.1 Macintosh&quot;;s:8:&quot;DateTime&quot;;s:19:&quot;2015:08:12 15:11:24&quot;;s:16:&quot;Exif_IFD_Pointer&quot;;i:328;}"/><array name="exif"><item key="ExposureTime" base64="1">MS80MDA=</item><item key="FNumber" base64="1">NC8x</item><item key="ISOSpeedRatings" base64="1">ODA=</item><item key="ExifVersion" base64="1">MDIyMQ==</item><item key="DateTimeOriginal" base64="1">MjAxMzowOToyOSAxMzozMTo0OA==</item><item key="DateTimeDigitized" base64="1">MjAxMzowOToyOSAxMzozMTo0OA==</item><item key="ComponentsConfiguration" base64="1">AQIDAA==</item><item key="CompressedBitsPerPixel" base64="1">My8x</item><item key="ShutterSpeedValue" base64="1">Mjc3LzMy</item><item key="ApertureValue" base64="1">NC8x</item><item key="ExposureBiasValue" base64="1">MC8x</item><item key="MaxApertureValue" base64="1">MjkvOA==</item><item key="MeteringMode" base64="1">NQ==</item><item key="Flash" base64="1">MTY=</item><item key="FocalLength" base64="1">MjU2OS8yMDA=</item><item key="FlashPixVersion" base64="1">MDEwMA==</item><item key="ColorSpace" base64="1">MQ==</item><item key="ExifImageWidth" base64="1">MTE3MA==</item><item key="ExifImageLength" base64="1">ODc4</item><item key="FocalPlaneXResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneYResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneResolutionUnit" base64="1">Mg==</item><item key="SensingMethod" base64="1">Mg==</item><item key="FileSource" base64="1">Aw==</item><item key="CustomRendered" base64="1">MA==</item><item key="ExposureMode" base64="1">MA==</item><item key="WhiteBalance" base64="1">MA==</item><item key="DigitalZoomRatio" base64="1">MS8x</item><item key="SceneCaptureType" base64="1">MA==</item></array></information><alias name="reference" filename="Test-Ordner-1-ger-DE_reference.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE_reference.jpg" mime_type="image/jpeg" width="600" height="450" alias_key="2605465115" timestamp="1439556305" is_valid="1"/><alias name="large" filename="Test-Ordner-1-ger-DE_large.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE_large.jpg" mime_type="image/jpeg" width="600" height="450" alias_key="4125281826" timestamp="1439556305" is_valid="1"/></ezimage>\n', 'ezimage', 237, 'ger-DE', 5, 0, '', 5),
(238, 192, 58, 0, 1, '', 'ezboolean', 238, 'ger-DE', 5, 1, '', 5),
(0, 188, 58, 0, NULL, 'TEST Folder eng-GB', 'ezstring', 266, 'eng-GB', 2, 0, 'test folder eng-gb', 5),
(0, 189, 58, 0, NULL, '', 'ezstring', 267, 'eng-GB', 2, 0, '', 5),
(0, 190, 58, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"><paragraph>This folder is written in english eng-GB</paragraph></section>\n', 'ezxmltext', 268, 'eng-GB', 2, 0, '', 5);
INSERT INTO `ezcontentobject_attribute` (`attribute_original_id`, `contentclassattribute_id`, `contentobject_id`, `data_float`, `data_int`, `data_text`, `data_type_string`, `id`, `language_code`, `language_id`, `sort_key_int`, `sort_key_string`, `version`) VALUES
(237, 200, 58, 0, NULL, '<?xml version="1.0" encoding="utf-8"?>\n<ezimage serial_number="1" is_valid="1" filename="Test-Ordner-1-ger-DE.jpg" suffix="jpg" basename="Test-Ordner-1-ger-DE" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE.jpg" original_filename="IMG_0277.jpg" mime_type="image/jpeg" width="1170" height="878" alternative_text="Dahlie" alias_key="1293033771" timestamp="1439387270"><original attribute_id="237" attribute_version="5" attribute_language="ger-DE"/><information Height="878" Width="1170" IsColor="1" ByteOrderMotorola="1" CCDWidth="2mm" ApertureFNumber="f/4.0" Thumbnail.FileType="2" Thumbnail.MimeType="image/jpeg"><serialized name="ifd0" data="a:15:{s:10:&quot;ImageWidth&quot;;i:3648;s:11:&quot;ImageLength&quot;;i:2736;s:13:&quot;BitsPerSample&quot;;a:3:{i:0;i:8;i:1;i:8;i:2;i:8;}s:25:&quot;PhotometricInterpretation&quot;;i:2;s:16:&quot;ImageDescription&quot;;s:31:&quot;                               &quot;;s:4:&quot;Make&quot;;s:5:&quot;Canon&quot;;s:5:&quot;Model&quot;;s:19:&quot;Canon PowerShot S90&quot;;s:11:&quot;Orientation&quot;;i:1;s:15:&quot;SamplesPerPixel&quot;;i:3;s:11:&quot;XResolution&quot;;s:13:&quot;1800000/10000&quot;;s:11:&quot;YResolution&quot;;s:13:&quot;1800000/10000&quot;;s:14:&quot;ResolutionUnit&quot;;i:2;s:8:&quot;Software&quot;;s:31:&quot;Adobe Photoshop CS5.1 Macintosh&quot;;s:8:&quot;DateTime&quot;;s:19:&quot;2015:08:12 15:11:24&quot;;s:16:&quot;Exif_IFD_Pointer&quot;;i:328;}"/><array name="exif"><item key="ExposureTime" base64="1">MS80MDA=</item><item key="FNumber" base64="1">NC8x</item><item key="ISOSpeedRatings" base64="1">ODA=</item><item key="ExifVersion" base64="1">MDIyMQ==</item><item key="DateTimeOriginal" base64="1">MjAxMzowOToyOSAxMzozMTo0OA==</item><item key="DateTimeDigitized" base64="1">MjAxMzowOToyOSAxMzozMTo0OA==</item><item key="ComponentsConfiguration" base64="1">AQIDAA==</item><item key="CompressedBitsPerPixel" base64="1">My8x</item><item key="ShutterSpeedValue" base64="1">Mjc3LzMy</item><item key="ApertureValue" base64="1">NC8x</item><item key="ExposureBiasValue" base64="1">MC8x</item><item key="MaxApertureValue" base64="1">MjkvOA==</item><item key="MeteringMode" base64="1">NQ==</item><item key="Flash" base64="1">MTY=</item><item key="FocalLength" base64="1">MjU2OS8yMDA=</item><item key="FlashPixVersion" base64="1">MDEwMA==</item><item key="ColorSpace" base64="1">MQ==</item><item key="ExifImageWidth" base64="1">MTE3MA==</item><item key="ExifImageLength" base64="1">ODc4</item><item key="FocalPlaneXResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneYResolution" base64="1">MjQ5ODYzLzIw</item><item key="FocalPlaneResolutionUnit" base64="1">Mg==</item><item key="SensingMethod" base64="1">Mg==</item><item key="FileSource" base64="1">Aw==</item><item key="CustomRendered" base64="1">MA==</item><item key="ExposureMode" base64="1">MA==</item><item key="WhiteBalance" base64="1">MA==</item><item key="DigitalZoomRatio" base64="1">MS8x</item><item key="SceneCaptureType" base64="1">MA==</item></array></information><alias name="reference" filename="Test-Ordner-1-ger-DE_reference.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE_reference.jpg" mime_type="image/jpeg" width="600" height="450" alias_key="2605465115" timestamp="1439393026" is_valid="1"/><alias name="small" filename="Test-Ordner-1-ger-DE_small.jpg" suffix="jpg" dirpath="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE" url="var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE_small.jpg" mime_type="image/jpeg" width="120" height="90" alias_key="4099042024" timestamp="1439393026" is_valid="1"/></ezimage>\n', 'ezimage', 269, 'eng-GB', 2, 0, '', 5),
(238, 192, 58, 0, 1, '', 'ezboolean', 270, 'eng-GB', 2, 1, '', 5),
(0, 193, 67, 0, NULL, 'neue DateiNew File', 'ezstring', 290, 'eng-GB', 3, 0, 'neue dateinew file', 1),
(0, 194, 67, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 291, 'eng-GB', 3, 0, '', 1),
(0, 195, 67, 0, NULL, '', 'ezbinaryfile', 292, 'eng-GB', 3, 0, '', 1),
(0, 193, 67, 0, NULL, 'Demo File', 'ezstring', 290, 'eng-GB', 3, 0, 'demo file', 2),
(0, 194, 67, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 291, 'eng-GB', 3, 0, '', 2),
(0, 195, 67, 0, NULL, '', 'ezbinaryfile', 292, 'eng-GB', 3, 0, '', 2),
(0, 193, 67, 0, NULL, 'Demo Datei', 'ezstring', 293, 'ger-DE', 4, 0, 'demo datei', 3),
(0, 194, 67, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 294, 'ger-DE', 4, 0, '', 3),
(0, 195, 67, 0, NULL, '', 'ezbinaryfile', 295, 'ger-DE', 4, 0, '', 3),
(0, 193, 67, 0, NULL, 'Demo File', 'ezstring', 290, 'eng-GB', 3, 0, 'demo file', 3),
(0, 194, 67, 0, 1045487555, '<?xml version="1.0" encoding="utf-8"?>\n<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/"/>\n', 'ezxmltext', 291, 'eng-GB', 3, 0, '', 3),
(0, 195, 67, 0, NULL, '', 'ezbinaryfile', 292, 'eng-GB', 3, 0, '', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentobject_link`
--

DROP TABLE IF EXISTS `ezcontentobject_link`;
CREATE TABLE IF NOT EXISTS `ezcontentobject_link` (
  `contentclassattribute_id` int(11) NOT NULL DEFAULT '0',
  `from_contentobject_id` int(11) NOT NULL DEFAULT '0',
  `from_contentobject_version` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `relation_type` int(11) NOT NULL DEFAULT '1',
  `to_contentobject_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentobject_name`
--

DROP TABLE IF EXISTS `ezcontentobject_name`;
CREATE TABLE IF NOT EXISTS `ezcontentobject_name` (
  `content_translation` varchar(20) NOT NULL DEFAULT '',
  `content_version` int(11) NOT NULL DEFAULT '0',
  `contentobject_id` int(11) NOT NULL DEFAULT '0',
  `language_id` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `real_translation` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentobject_name`
--

INSERT INTO `ezcontentobject_name` (`content_translation`, `content_version`, `contentobject_id`, `language_id`, `name`, `real_translation`) VALUES
('eng-GB', 6, 1, 3, 'eZ Publish', 'eng-GB'),
('eng-GB', 1, 4, 3, 'Users', 'eng-GB'),
('eng-GB', 2, 10, 3, 'Anonymous User', 'eng-GB'),
('eng-GB', 1, 11, 3, 'Guest accounts', 'eng-GB'),
('eng-GB', 1, 12, 3, 'Administrator users', 'eng-GB'),
('eng-GB', 1, 13, 3, 'Editors', 'eng-GB'),
('eng-GB', 3, 14, 3, 'Administrator User', 'eng-GB'),
('eng-GB', 1, 41, 3, 'Media', 'eng-GB'),
('eng-GB', 1, 42, 3, 'Anonymous Users', 'eng-GB'),
('eng-GB', 1, 45, 3, 'Setup', 'eng-GB'),
('eng-GB', 1, 49, 3, 'Images', 'eng-GB'),
('eng-GB', 1, 50, 3, 'Files', 'eng-GB'),
('eng-GB', 1, 51, 3, 'Multimedia', 'eng-GB'),
('eng-GB', 1, 52, 2, 'Common INI settings', 'eng-GB'),
('eng-GB', 2, 54, 2, 'Plain site', 'eng-GB'),
('eng-GB', 1, 56, 3, 'Design', 'eng-GB'),
('ger-DE', 7, 1, 5, 'eZ Publish', 'ger-DE'),
('eng-GB', 7, 1, 2, 'eZ Publish', 'eng-GB'),
('ger-DE', 2, 41, 5, 'Media', 'ger-DE'),
('eng-GB', 2, 41, 2, 'Media', 'eng-GB'),
('ger-DE', 2, 50, 5, 'Files', 'ger-DE'),
('eng-GB', 2, 50, 2, 'Files', 'eng-GB'),
('ger-DE', 2, 49, 5, 'Images', 'ger-DE'),
('eng-GB', 2, 49, 2, 'Images', 'eng-GB'),
('ger-DE', 2, 51, 5, 'Multimedia', 'ger-DE'),
('eng-GB', 2, 51, 2, 'Multimedia', 'eng-GB'),
('ger-DE', 2, 4, 5, 'Users', 'ger-DE'),
('eng-GB', 2, 4, 2, 'Users', 'eng-GB'),
('ger-DE', 2, 11, 5, 'Guest accounts', 'ger-DE'),
('eng-GB', 2, 11, 2, 'Guest accounts', 'eng-GB'),
('ger-DE', 2, 12, 5, 'Administrator users', 'ger-DE'),
('eng-GB', 2, 12, 2, 'Administrator users', 'eng-GB'),
('ger-DE', 2, 13, 5, 'Editors', 'ger-DE'),
('eng-GB', 2, 13, 2, 'Editors', 'eng-GB'),
('ger-DE', 2, 42, 5, 'Anonymous Users', 'ger-DE'),
('eng-GB', 2, 42, 2, 'Anonymous Users', 'eng-GB'),
('ger-DE', 3, 10, 5, 'Anonymous User', 'ger-DE'),
('eng-GB', 3, 10, 2, 'Anonymous User', 'eng-GB'),
('ger-DE', 4, 14, 5, 'Administrator User', 'ger-DE'),
('eng-GB', 4, 14, 2, 'Administrator User', 'eng-GB'),
('ger-DE', 1, 57, 5, 'WWW home', 'ger-DE'),
('ger-DE', 2, 57, 5, 'WWW Home', 'ger-DE'),
('ger-DE', 3, 57, 5, 'Home Ordner', 'ger-DE'),
('ger-DE', 4, 57, 5, 'WWW Home', 'ger-DE'),
('ger-DE', 1, 58, 5, 'Test Ordner 1', 'ger-DE'),
('ger-DE', 1, 66, 4, '', 'ger-DE'),
('ger-DE', 1, 60, 4, 'Test Seite 1-1', 'ger-DE'),
('ger-DE', 1, 61, 4, 'Test Seite 1-2', 'ger-DE'),
('ger-DE', 1, 62, 4, 'Test Seite 2-1', 'ger-DE'),
('ger-DE', 1, 64, 4, 'Test Seite 2-2', 'ger-DE'),
('eng-GB', 2, 58, 2, 'TEST Folder eng-GB', 'eng-GB'),
('ger-DE', 2, 58, 5, 'Test Ordner 1', 'ger-DE'),
('ger-DE', 3, 58, 5, 'Test Ordner 1 ger-DE', 'ger-DE'),
('eng-GB', 3, 58, 2, 'TEST Folder eng-GB', 'eng-GB'),
('ger-DE', 2, 65, 4, 'Ordner 2 -  ger-DE', 'ger-DE'),
('ger-DE', 1, 65, 4, 'Ordner 3 ger', 'ger-DE'),
('ger-DE', 2, 66, 4, 'Kontaktformular', 'ger-DE'),
('eng-GB', 3, 66, 2, 'Feedbackform', 'eng-GB'),
('ger-DE', 3, 66, 4, 'Kontaktformular', 'ger-DE'),
('ger-DE', 2, 60, 4, 'Test Seite 1-1', 'ger-DE'),
('ger-DE', 2, 61, 4, 'Test Seite 1-2', 'ger-DE'),
('ger-DE', 2, 62, 4, 'Test Seite 2-1', 'ger-DE'),
('ger-DE', 2, 64, 4, 'Test Seite 2-2', 'ger-DE'),
('eng-GB', 4, 58, 2, 'TEST Folder eng-GB', 'eng-GB'),
('ger-DE', 4, 58, 5, 'Test Ordner 1 ger-DE', 'ger-DE'),
('ger-DE', 5, 58, 5, 'Test Ordner 1 ger-DE', 'ger-DE'),
('eng-GB', 5, 58, 2, 'TEST Folder eng-GB', 'eng-GB'),
('eng-GB', 1, 67, 3, 'neue DateiNew File', 'eng-GB'),
('eng-GB', 2, 67, 3, 'Demo File', 'eng-GB'),
('ger-DE', 3, 67, 4, 'Demo Datei', 'ger-DE'),
('eng-GB', 3, 67, 3, 'Demo File', 'eng-GB');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentobject_trash`
--

DROP TABLE IF EXISTS `ezcontentobject_trash`;
CREATE TABLE IF NOT EXISTS `ezcontentobject_trash` (
  `contentobject_id` int(11) DEFAULT NULL,
  `contentobject_version` int(11) DEFAULT NULL,
  `depth` int(11) NOT NULL DEFAULT '0',
  `is_hidden` int(11) NOT NULL DEFAULT '0',
  `is_invisible` int(11) NOT NULL DEFAULT '0',
  `main_node_id` int(11) DEFAULT NULL,
  `modified_subnode` int(11) DEFAULT '0',
  `node_id` int(11) NOT NULL DEFAULT '0',
  `parent_node_id` int(11) NOT NULL DEFAULT '0',
  `path_identification_string` longtext,
  `path_string` varchar(255) NOT NULL DEFAULT '',
  `priority` int(11) NOT NULL DEFAULT '0',
  `remote_id` varchar(100) NOT NULL DEFAULT '',
  `sort_field` int(11) DEFAULT '1',
  `sort_order` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentobject_tree`
--

DROP TABLE IF EXISTS `ezcontentobject_tree`;
CREATE TABLE IF NOT EXISTS `ezcontentobject_tree` (
  `contentobject_id` int(11) DEFAULT NULL,
  `contentobject_is_published` int(11) DEFAULT NULL,
  `contentobject_version` int(11) DEFAULT NULL,
  `depth` int(11) NOT NULL DEFAULT '0',
  `is_hidden` int(11) NOT NULL DEFAULT '0',
  `is_invisible` int(11) NOT NULL DEFAULT '0',
  `main_node_id` int(11) DEFAULT NULL,
  `modified_subnode` int(11) DEFAULT '0',
  `node_id` int(11) NOT NULL,
  `parent_node_id` int(11) NOT NULL DEFAULT '0',
  `path_identification_string` longtext,
  `path_string` varchar(255) NOT NULL DEFAULT '',
  `priority` int(11) NOT NULL DEFAULT '0',
  `remote_id` varchar(100) NOT NULL DEFAULT '',
  `sort_field` int(11) DEFAULT '1',
  `sort_order` int(11) DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentobject_tree`
--

INSERT INTO `ezcontentobject_tree` (`contentobject_id`, `contentobject_is_published`, `contentobject_version`, `depth`, `is_hidden`, `is_invisible`, `main_node_id`, `modified_subnode`, `node_id`, `parent_node_id`, `path_identification_string`, `path_string`, `priority`, `remote_id`, `sort_field`, `sort_order`) VALUES
(0, 1, 1, 0, 0, 0, 1, 1439556371, 1, 1, '', '/1/', 0, '629709ba256fe317c3ddcee35453a96a', 1, 1),
(1, 1, 7, 1, 0, 0, 2, 1439556371, 2, 1, '', '/1/2/', 0, 'f3e90596361e31d496d4026eb624c983', 8, 1),
(4, 1, 2, 1, 0, 0, 5, 1421095734, 5, 1, 'users', '/1/5/', 0, '3f6d92f8044aed134f32153517850f5a', 1, 1),
(11, 1, 2, 2, 0, 0, 12, 1421095532, 12, 5, 'users/guest_accounts', '/1/5/12/', 0, '602dcf84765e56b7f999eaafd3821dd3', 1, 1),
(12, 1, 2, 2, 0, 0, 13, 1421095734, 13, 5, 'users/administrator_users', '/1/5/13/', 0, '769380b7aa94541679167eab817ca893', 1, 1),
(13, 1, 2, 2, 0, 0, 14, 1421095631, 14, 5, 'users/editors', '/1/5/14/', 0, 'f7dda2854fc68f7c8455d9cb14bd04a9', 1, 1),
(14, 1, 4, 3, 0, 0, 15, 1421095734, 15, 13, 'users/administrator_users/administrator_user', '/1/5/13/15/', 0, 'e5161a99f733200b9ed4e80f9c16187b', 1, 1),
(41, 1, 2, 1, 0, 0, 43, 1421094968, 43, 1, 'media', '/1/43/', 0, '75c715a51699d2d309a924eca6a95145', 9, 1),
(42, 1, 2, 2, 0, 0, 44, 1421095680, 44, 5, 'users/anonymous_users', '/1/5/44/', 0, '4fdf0072da953bb276c0c7e0141c5c9b', 9, 1),
(10, 1, 3, 3, 0, 0, 45, 1421095680, 45, 44, 'users/anonymous_users/anonymous_user', '/1/5/44/45/', 0, '2cf8343bee7b482bab82b269d8fecd76', 9, 1),
(45, 1, 1, 1, 0, 0, 48, 1184592117, 48, 1, 'setup2', '/1/48/', 0, '182ce1b5af0c09fa378557c462ba2617', 9, 1),
(49, 1, 2, 2, 0, 0, 51, 1421094929, 51, 43, 'media/images', '/1/43/51/', 0, '1b26c0454b09bb49dfb1b9190ffd67cb', 9, 1),
(50, 1, 2, 2, 0, 0, 52, 1421094877, 52, 43, 'media/files', '/1/43/52/', 0, '0b113a208f7890f9ad3c24444ff5988c', 9, 1),
(51, 1, 2, 2, 0, 0, 53, 1421094968, 53, 43, 'media/multimedia', '/1/43/53/', 0, '4f18b82c75f10aad476cae5adf98c11f', 9, 1),
(52, 1, 1, 2, 0, 0, 54, 1184592117, 54, 48, 'setup2/common_ini_settings', '/1/48/54/', 0, 'fa9f3cff9cf90ecfae335718dcbddfe2', 1, 1),
(54, 1, 2, 2, 0, 0, 56, 1301062376, 56, 58, 'design/plain_site', '/1/58/56/', 0, '772da20ecf88b3035d73cbdfcea0f119', 1, 1),
(56, 1, 1, 1, 0, 0, 58, 1301062376, 58, 1, 'design', '/1/58/', 0, '79f2d67372ab56f59b5d65bb9e0ca3b9', 2, 0),
(57, 1, 4, 2, 0, 0, 59, 1439556371, 59, 2, 'www_home', '/1/2/59/', 0, '042674aaac414e8dfc3f780359011c9a', 8, 1),
(58, 1, 5, 3, 0, 0, 60, 1439556371, 60, 59, 'www_home/test_ordner_1_ger_de', '/1/2/59/60/', 0, 'f6d9fbcd0fd8738e5f0a82100984fceb', 8, 1),
(66, 1, 3, 3, 0, 0, 67, 1437143010, 67, 59, 'www_home/kontaktformular', '/1/2/59/67/', 0, '2cc30cbdbca580d9dd4a3b6f7cb64430', 8, 1),
(60, 1, 2, 4, 0, 0, 62, 1439386774, 62, 60, 'www_home/test_ordner_1_ger_de/test_seite_1_1', '/1/2/59/60/62/', 10, '32074651924dc60ddb512e5d1d054b38', 8, 1),
(61, 1, 2, 4, 0, 0, 63, 1439386922, 63, 60, 'www_home/test_ordner_1_ger_de/test_seite_1_2', '/1/2/59/60/63/', 20, 'ab034e5d96d906ce56b6046d36de5add', 8, 1),
(62, 1, 2, 4, 0, 0, 64, 1439387050, 64, 66, 'www_home/ordner_2_ger_de/test_seite_2_1', '/1/2/59/66/64/', 0, 'e98bae5619efc4c5694fd7ee42d734c5', 8, 1),
(64, 1, 2, 4, 0, 0, 65, 1439387124, 65, 66, 'www_home/ordner_2_ger_de/test_seite_2_2', '/1/2/59/66/65/', 0, '535a571ebc853aedc4859155c044f200', 8, 1),
(65, 1, 2, 3, 0, 0, 66, 1439387124, 66, 59, 'www_home/ordner_2_ger_de', '/1/2/59/66/', 0, '6baf89f569698eb93e8b434b090aff66', 8, 1),
(67, 1, 3, 4, 0, 0, 68, 1439556371, 68, 60, 'www_home/test_ordner_1_ger_de/demo_file', '/1/2/59/60/68/', 20, 'd085b1e8d68acb766bb45177b2340e5f', 8, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontentobject_version`
--

DROP TABLE IF EXISTS `ezcontentobject_version`;
CREATE TABLE IF NOT EXISTS `ezcontentobject_version` (
  `contentobject_id` int(11) DEFAULT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `initial_language_id` bigint(20) NOT NULL DEFAULT '0',
  `language_mask` bigint(20) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `version` int(11) NOT NULL DEFAULT '0',
  `workflow_event_pos` int(11) DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=545 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontentobject_version`
--

INSERT INTO `ezcontentobject_version` (`contentobject_id`, `created`, `creator_id`, `id`, `initial_language_id`, `language_mask`, `modified`, `status`, `user_id`, `version`, `workflow_event_pos`) VALUES
(4, 0, 14, 4, 2, 3, 0, 3, 0, 1, 1),
(11, 1033920737, 14, 439, 2, 3, 1033920746, 3, 0, 1, 0),
(12, 1033920760, 14, 440, 2, 3, 1033920775, 3, 0, 1, 0),
(13, 1033920786, 14, 441, 2, 3, 1033920794, 3, 0, 1, 0),
(41, 1060695450, 14, 472, 2, 3, 1060695457, 3, 0, 1, 0),
(42, 1072180278, 14, 473, 2, 3, 1072180330, 3, 0, 1, 0),
(10, 1072180337, 14, 474, 2, 3, 1072180405, 3, 0, 2, 0),
(45, 1079684084, 14, 477, 2, 3, 1079684190, 1, 0, 1, 0),
(49, 1080220181, 14, 488, 2, 3, 1080220197, 3, 0, 1, 0),
(50, 1080220211, 14, 489, 2, 3, 1080220220, 3, 0, 1, 0),
(51, 1080220225, 14, 490, 2, 3, 1080220233, 3, 0, 1, 0),
(52, 1082016497, 14, 491, 2, 3, 1082016591, 1, 0, 1, 0),
(56, 1103023120, 14, 495, 2, 3, 1103023120, 1, 0, 1, 0),
(14, 1301061783, 14, 499, 2, 3, 1301062024, 3, 0, 3, 0),
(54, 1301062300, 14, 500, 2, 3, 1301062375, 1, 0, 2, 0),
(1, 1301072647, 14, 503, 2, 3, 1301073466, 3, 0, 6, 1),
(1, 1421094768, 14, 504, 4, 7, 1421094778, 1, 0, 7, 1),
(41, 1421094817, 14, 505, 4, 7, 1421094822, 1, 0, 2, 0),
(50, 1421094852, 14, 506, 4, 7, 1421094857, 1, 0, 2, 0),
(49, 1421094894, 14, 507, 4, 7, 1421094903, 1, 0, 2, 0),
(51, 1421094951, 14, 508, 4, 7, 1421094959, 1, 0, 2, 0),
(4, 1421095456, 14, 509, 4, 7, 1421095463, 1, 0, 2, 1),
(11, 1421095512, 14, 510, 4, 7, 1421095519, 1, 0, 2, 0),
(12, 1421095558, 14, 511, 4, 7, 1421095565, 1, 0, 2, 0),
(13, 1421095581, 14, 512, 4, 7, 1421095587, 1, 0, 2, 0),
(42, 1421095603, 14, 513, 4, 7, 1421095609, 1, 0, 2, 0),
(10, 1421095658, 14, 514, 4, 7, 1421095664, 1, 0, 3, 0),
(14, 1421095719, 14, 515, 4, 7, 1421095724, 1, 0, 4, 0),
(57, 1421101955, 14, 516, 4, 5, 1421101973, 3, 0, 1, 0),
(57, 1421102533, 14, 517, 4, 5, 1421102543, 3, 0, 2, 0),
(57, 1421108007, 14, 518, 4, 5, 1421108034, 3, 0, 3, 0),
(57, 1421108502, 14, 519, 4, 5, 1421108516, 1, 0, 4, 0),
(58, 1421109343, 14, 520, 4, 5, 1421109393, 3, 0, 1, 0),
(66, 1437142899, 14, 533, 4, 5, 1437142935, 3, 0, 1, 0),
(60, 1421109605, 14, 522, 4, 5, 1421109662, 3, 0, 1, 0),
(61, 1421109680, 14, 523, 4, 5, 1421109748, 3, 0, 1, 0),
(62, 1421109992, 14, 525, 4, 5, 1421110056, 3, 0, 1, 0),
(64, 1421110109, 14, 527, 4, 5, 1421110148, 3, 0, 1, 0),
(58, 1437140625, 14, 528, 2, 7, 1437140647, 3, 0, 2, 0),
(58, 1437140654, 14, 529, 4, 7, 1437140672, 3, 0, 3, 0),
(65, 1437142184, 14, 532, 4, 5, 1437142202, 1, 0, 2, 0),
(65, 1437142053, 14, 531, 4, 5, 1437142061, 3, 0, 1, 0),
(66, 1437142971, 14, 534, 4, 5, 1437142974, 3, 0, 2, 0),
(66, 1437142984, 14, 535, 2, 7, 1437143010, 1, 0, 3, 0),
(60, 1439386618, 14, 536, 4, 5, 1439386774, 1, 0, 2, 0),
(61, 1439386810, 14, 537, 4, 5, 1439386922, 1, 0, 2, 0),
(62, 1439386978, 14, 538, 4, 5, 1439387050, 1, 0, 2, 0),
(64, 1439387061, 14, 539, 4, 5, 1439387124, 1, 0, 2, 0),
(58, 1439387199, 14, 540, 2, 7, 1439387217, 3, 0, 4, 0),
(58, 1439387228, 14, 541, 4, 7, 1439387270, 1, 0, 5, 0),
(67, 1439393050, 14, 542, 2, 3, 1439393094, 3, 0, 1, 0),
(67, 1439556323, 14, 543, 2, 3, 1439556338, 3, 0, 2, 0),
(67, 1439556358, 14, 544, 4, 7, 1439556371, 1, 0, 3, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcontent_language`
--

DROP TABLE IF EXISTS `ezcontent_language`;
CREATE TABLE IF NOT EXISTS `ezcontent_language` (
  `disabled` int(11) NOT NULL DEFAULT '0',
  `id` bigint(20) NOT NULL DEFAULT '0',
  `locale` varchar(20) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezcontent_language`
--

INSERT INTO `ezcontent_language` (`disabled`, `id`, `locale`, `name`) VALUES
(0, 2, 'eng-GB', 'English (United Kingdom)'),
(0, 4, 'ger-DE', 'German');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezcurrencydata`
--

DROP TABLE IF EXISTS `ezcurrencydata`;
CREATE TABLE IF NOT EXISTS `ezcurrencydata` (
  `auto_rate_value` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `code` varchar(4) NOT NULL DEFAULT '',
  `custom_rate_value` decimal(10,5) NOT NULL DEFAULT '0.00000',
  `id` int(11) NOT NULL,
  `locale` varchar(255) NOT NULL DEFAULT '',
  `rate_factor` decimal(10,5) NOT NULL DEFAULT '1.00000',
  `status` int(11) NOT NULL DEFAULT '1',
  `symbol` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezdiscountrule`
--

DROP TABLE IF EXISTS `ezdiscountrule`;
CREATE TABLE IF NOT EXISTS `ezdiscountrule` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezdiscountsubrule`
--

DROP TABLE IF EXISTS `ezdiscountsubrule`;
CREATE TABLE IF NOT EXISTS `ezdiscountsubrule` (
  `discount_percent` float DEFAULT NULL,
  `discountrule_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `limitation` char(1) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezdiscountsubrule_value`
--

DROP TABLE IF EXISTS `ezdiscountsubrule_value`;
CREATE TABLE IF NOT EXISTS `ezdiscountsubrule_value` (
  `discountsubrule_id` int(11) NOT NULL DEFAULT '0',
  `issection` int(11) NOT NULL DEFAULT '0',
  `value` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezenumobjectvalue`
--

DROP TABLE IF EXISTS `ezenumobjectvalue`;
CREATE TABLE IF NOT EXISTS `ezenumobjectvalue` (
  `contentobject_attribute_id` int(11) NOT NULL DEFAULT '0',
  `contentobject_attribute_version` int(11) NOT NULL DEFAULT '0',
  `enumelement` varchar(255) NOT NULL DEFAULT '',
  `enumid` int(11) NOT NULL DEFAULT '0',
  `enumvalue` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezenumvalue`
--

DROP TABLE IF EXISTS `ezenumvalue`;
CREATE TABLE IF NOT EXISTS `ezenumvalue` (
  `contentclass_attribute_id` int(11) NOT NULL DEFAULT '0',
  `contentclass_attribute_version` int(11) NOT NULL DEFAULT '0',
  `enumelement` varchar(255) NOT NULL DEFAULT '',
  `enumvalue` varchar(255) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `placement` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezforgot_password`
--

DROP TABLE IF EXISTS `ezforgot_password`;
CREATE TABLE IF NOT EXISTS `ezforgot_password` (
  `hash_key` varchar(32) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezgeneral_digest_user_settings`
--

DROP TABLE IF EXISTS `ezgeneral_digest_user_settings`;
CREATE TABLE IF NOT EXISTS `ezgeneral_digest_user_settings` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `day` varchar(255) NOT NULL DEFAULT '',
  `digest_type` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `receive_digest` int(11) NOT NULL DEFAULT '0',
  `time` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezimagefile`
--

DROP TABLE IF EXISTS `ezimagefile`;
CREATE TABLE IF NOT EXISTS `ezimagefile` (
  `contentobject_attribute_id` int(11) NOT NULL DEFAULT '0',
  `filepath` longtext NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezimagefile`
--

INSERT INTO `ezimagefile` (`contentobject_attribute_id`, `filepath`, `id`) VALUES
(248, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-1/248-2-ger-DE/Test-Seite-1-1.jpg', 2),
(248, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-1/248-2-ger-DE/Test-Seite-1-1_reference.jpg', 3),
(248, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-1/248-2-ger-DE/Test-Seite-1-1_small.jpg', 4),
(253, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-2/253-2-ger-DE/Test-Seite-1-2.jpg', 6),
(253, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-2/253-2-ger-DE/Test-Seite-1-2_reference.jpg', 7),
(253, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/test-seite-1-2/253-2-ger-DE/Test-Seite-1-2_small.jpg', 8),
(258, 'var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-1/258-2-ger-DE/Test-Seite-2-1.jpg', 10),
(258, 'var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-1/258-2-ger-DE/Test-Seite-2-1_reference.jpg', 11),
(258, 'var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-1/258-2-ger-DE/Test-Seite-2-1_small.jpg', 12),
(265, 'var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-2/265-2-ger-DE/Test-Seite-2-2.jpg', 14),
(265, 'var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-2/265-2-ger-DE/Test-Seite-2-2_reference.jpg', 15),
(265, 'var/cjwpublish/storage/images/www-home/ordner-2-ger-de/test-seite-2-2/265-2-ger-DE/Test-Seite-2-2_small.jpg', 16),
(237, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE.jpg', 18),
(269, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE.jpg', 19),
(269, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE_reference.jpg', 20),
(269, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE_small.jpg', 21),
(237, 'var/cjwpublish/storage/images/www-home/test-folder-eng-gb/237-5-ger-DE/Test-Ordner-1-ger-DE_large.jpg', 22);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezinfocollection`
--

DROP TABLE IF EXISTS `ezinfocollection`;
CREATE TABLE IF NOT EXISTS `ezinfocollection` (
  `contentobject_id` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `modified` int(11) DEFAULT '0',
  `user_identifier` varchar(34) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezinfocollection`
--

INSERT INTO `ezinfocollection` (`contentobject_id`, `created`, `creator_id`, `id`, `modified`, `user_identifier`) VALUES
(66, 1437145048, 10, 1, 1437145048, ''),
(66, 1437145220, 10, 2, 1437145220, ''),
(66, 1437145340, 10, 3, 1437145340, ''),
(66, 1437145814, 10, 4, 1437145814, ''),
(66, 1437145869, 10, 5, 1437145869, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezinfocollection_attribute`
--

DROP TABLE IF EXISTS `ezinfocollection_attribute`;
CREATE TABLE IF NOT EXISTS `ezinfocollection_attribute` (
  `contentclass_attribute_id` int(11) NOT NULL DEFAULT '0',
  `contentobject_attribute_id` int(11) DEFAULT NULL,
  `contentobject_id` int(11) DEFAULT NULL,
  `data_float` float DEFAULT NULL,
  `data_int` int(11) DEFAULT NULL,
  `data_text` longtext,
  `id` int(11) NOT NULL,
  `informationcollection_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezinfocollection_attribute`
--

INSERT INTO `ezinfocollection_attribute` (`contentclass_attribute_id`, `contentobject_attribute_id`, `contentobject_id`, `data_float`, `data_int`, `data_text`, `id`, `informationcollection_id`) VALUES
(212, 280, 66, 0, 0, 'felix@test.de', 1, 1),
(213, 281, 66, 0, 0, 'meine nachricht', 2, 1),
(214, 282, 66, 0, 0, 'Felix Woldt', 3, 1),
(212, 280, 66, 0, 0, 'felix@test.de', 4, 2),
(213, 281, 66, 0, 0, 'meine nachricht', 5, 2),
(214, 282, 66, 0, 0, 'Felix Woldt', 6, 2),
(212, 280, 66, 0, 0, 'felix@test.de', 7, 3),
(213, 281, 66, 0, 0, 'meine nachricht', 8, 3),
(214, 282, 66, 0, 0, 'Felix Woldt', 9, 3),
(212, 280, 66, 0, 0, '', 10, 4),
(213, 281, 66, 0, 0, '', 11, 4),
(214, 282, 66, 0, 0, '', 12, 4),
(212, 280, 66, 0, 0, 'felix@test.de', 13, 5),
(213, 281, 66, 0, 0, 'tts', 14, 5),
(214, 282, 66, 0, 0, 'sdfdsfdfs', 15, 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezisbn_group`
--

DROP TABLE IF EXISTS `ezisbn_group`;
CREATE TABLE IF NOT EXISTS `ezisbn_group` (
  `description` varchar(255) NOT NULL DEFAULT '',
  `group_number` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=210 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezisbn_group`
--

INSERT INTO `ezisbn_group` (`description`, `group_number`, `id`) VALUES
('English language', 0, 1),
('English language', 1, 2),
('French language', 2, 3),
('German language', 3, 4),
('Japan', 4, 5),
('Russian Federation and former USSR', 5, 6),
('Iran', 600, 7),
('Kazakhstan', 601, 8),
('Indonesia', 602, 9),
('Saudi Arabia', 603, 10),
('Vietnam', 604, 11),
('Turkey', 605, 12),
('Romania', 606, 13),
('Mexico', 607, 14),
('Macedonia', 608, 15),
('Lithuania', 609, 16),
('Thailand', 611, 17),
('Peru', 612, 18),
('Mauritius', 613, 19),
('Lebanon', 614, 20),
('Hungary', 615, 21),
('Thailand', 616, 22),
('Ukraine', 617, 23),
('China, People''s Republic', 7, 24),
('Czech Republic and Slovakia', 80, 25),
('India', 81, 26),
('Norway', 82, 27),
('Poland', 83, 28),
('Spain', 84, 29),
('Brazil', 85, 30),
('Serbia and Montenegro', 86, 31),
('Denmark', 87, 32),
('Italy', 88, 33),
('Korea, Republic', 89, 34),
('Netherlands', 90, 35),
('Sweden', 91, 36),
('International NGO Publishers and EC Organizations', 92, 37),
('India', 93, 38),
('Netherlands', 94, 39),
('Argentina', 950, 40),
('Finland', 951, 41),
('Finland', 952, 42),
('Croatia', 953, 43),
('Bulgaria', 954, 44),
('Sri Lanka', 955, 45),
('Chile', 956, 46),
('Taiwan', 957, 47),
('Colombia', 958, 48),
('Cuba', 959, 49),
('Greece', 960, 50),
('Slovenia', 961, 51),
('Hong Kong, China', 962, 52),
('Hungary', 963, 53),
('Iran', 964, 54),
('Israel', 965, 55),
('Ukraine', 966, 56),
('Malaysia', 967, 57),
('Mexico', 968, 58),
('Pakistan', 969, 59),
('Mexico', 970, 60),
('Philippines', 971, 61),
('Portugal', 972, 62),
('Romania', 973, 63),
('Thailand', 974, 64),
('Turkey', 975, 65),
('Caribbean Community', 976, 66),
('Egypt', 977, 67),
('Nigeria', 978, 68),
('Indonesia', 979, 69),
('Venezuela', 980, 70),
('Singapore', 981, 71),
('South Pacific', 982, 72),
('Malaysia', 983, 73),
('Bangladesh', 984, 74),
('Belarus', 985, 75),
('Taiwan', 986, 76),
('Argentina', 987, 77),
('Hong Kong, China', 988, 78),
('Portugal', 989, 79),
('Qatar', 9927, 80),
('Albania', 9928, 81),
('Guatemala', 9929, 82),
('Costa Rica', 9930, 83),
('Algeria', 9931, 84),
('Lao People''s Democratic Republic', 9932, 85),
('Syria', 9933, 86),
('Latvia', 9934, 87),
('Iceland', 9935, 88),
('Afghanistan', 9936, 89),
('Nepal', 9937, 90),
('Tunisia', 9938, 91),
('Armenia', 9939, 92),
('Montenegro', 9940, 93),
('Georgia', 9941, 94),
('Ecuador', 9942, 95),
('Uzbekistan', 9943, 96),
('Turkey', 9944, 97),
('Dominican Republic', 9945, 98),
('Korea, P.D.R.', 9946, 99),
('Algeria', 9947, 100),
('United Arab Emirates', 9948, 101),
('Estonia', 9949, 102),
('Palestine', 9950, 103),
('Kosova', 9951, 104),
('Azerbaijan', 9952, 105),
('Lebanon', 9953, 106),
('Morocco', 9954, 107),
('Lithuania', 9955, 108),
('Cameroon', 9956, 109),
('Jordan', 9957, 110),
('Bosnia and Herzegovina', 9958, 111),
('Libya', 9959, 112),
('Saudi Arabia', 9960, 113),
('Algeria', 9961, 114),
('Panama', 9962, 115),
('Cyprus', 9963, 116),
('Ghana', 9964, 117),
('Kazakhstan', 9965, 118),
('Kenya', 9966, 119),
('Kyrgyz Republic', 9967, 120),
('Costa Rica', 9968, 121),
('Uganda', 9970, 122),
('Singapore', 9971, 123),
('Peru', 9972, 124),
('Tunisia', 9973, 125),
('Uruguay', 9974, 126),
('Moldova', 9975, 127),
('Tanzania', 9976, 128),
('Costa Rica', 9977, 129),
('Ecuador', 9978, 130),
('Iceland', 9979, 131),
('Papua New Guinea', 9980, 132),
('Morocco', 9981, 133),
('Zambia', 9982, 134),
('Gambia', 9983, 135),
('Latvia', 9984, 136),
('Estonia', 9985, 137),
('Lithuania', 9986, 138),
('Tanzania', 9987, 139),
('Ghana', 9988, 140),
('Macedonia', 9989, 141),
('Bahrain', 99901, 142),
('Gabon', 99902, 143),
('Mauritius', 99903, 144),
('Netherlands Antilles and Aruba', 99904, 145),
('Bolivia', 99905, 146),
('Kuwait', 99906, 147),
('Malawi', 99908, 148),
('Malta', 99909, 149),
('Sierra Leone', 99910, 150),
('Lesotho', 99911, 151),
('Botswana', 99912, 152),
('Andorra', 99913, 153),
('Suriname', 99914, 154),
('Maldives', 99915, 155),
('Namibia', 99916, 156),
('Brunei Darussalam', 99917, 157),
('Faroe Islands', 99918, 158),
('Benin', 99919, 159),
('Andorra', 99920, 160),
('Qatar', 99921, 161),
('Guatemala', 99922, 162),
('El Salvador', 99923, 163),
('Nicaragua', 99924, 164),
('Paraguay', 99925, 165),
('Honduras', 99926, 166),
('Albania', 99927, 167),
('Georgia', 99928, 168),
('Mongolia', 99929, 169),
('Armenia', 99930, 170),
('Seychelles', 99931, 171),
('Malta', 99932, 172),
('Nepal', 99933, 173),
('Dominican Republic', 99934, 174),
('Haiti', 99935, 175),
('Bhutan', 99936, 176),
('Macau', 99937, 177),
('Srpska, Republic of', 99938, 178),
('Guatemala', 99939, 179),
('Georgia', 99940, 180),
('Armenia', 99941, 181),
('Sudan', 99942, 182),
('Albania', 99943, 183),
('Ethiopia', 99944, 184),
('Namibia', 99945, 185),
('Nepal', 99946, 186),
('Tajikistan', 99947, 187),
('Eritrea', 99948, 188),
('Mauritius', 99949, 189),
('Cambodia', 99950, 190),
('Congo', 99951, 191),
('Mali', 99952, 192),
('Paraguay', 99953, 193),
('Bolivia', 99954, 194),
('Srpska, Republic of', 99955, 195),
('Albania', 99956, 196),
('Malta', 99957, 197),
('Bahrain', 99958, 198),
('Luxembourg', 99959, 199),
('Malawi', 99960, 200),
('El Salvador', 99961, 201),
('Mongolia', 99962, 202),
('Cambodia', 99963, 203),
('Nicaragua', 99964, 204),
('Macau', 99965, 205),
('Kuwait', 99966, 206),
('Paraguay', 99967, 207),
('Botswana', 99968, 208),
('France', 10, 209);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezisbn_group_range`
--

DROP TABLE IF EXISTS `ezisbn_group_range`;
CREATE TABLE IF NOT EXISTS `ezisbn_group_range` (
  `from_number` int(11) NOT NULL DEFAULT '0',
  `group_from` varchar(32) NOT NULL DEFAULT '',
  `group_length` int(11) NOT NULL DEFAULT '0',
  `group_to` varchar(32) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `to_number` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezisbn_group_range`
--

INSERT INTO `ezisbn_group_range` (`from_number`, `group_from`, `group_length`, `group_to`, `id`, `to_number`) VALUES
(0, '0', 1, '5', 1, 59999),
(60000, '600', 3, '649', 2, 64999),
(70000, '7', 1, '7', 3, 79999),
(80000, '80', 2, '94', 4, 94999),
(95000, '950', 3, '989', 5, 98999),
(99000, '9900', 4, '9989', 6, 99899),
(99900, '99900', 5, '99999', 7, 99999),
(10000, '10', 2, '10', 8, 10999);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezisbn_registrant_range`
--

DROP TABLE IF EXISTS `ezisbn_registrant_range`;
CREATE TABLE IF NOT EXISTS `ezisbn_registrant_range` (
  `from_number` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `isbn_group_id` int(11) NOT NULL DEFAULT '0',
  `registrant_from` varchar(32) NOT NULL DEFAULT '',
  `registrant_length` int(11) NOT NULL DEFAULT '0',
  `registrant_to` varchar(32) NOT NULL DEFAULT '',
  `to_number` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=927 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezisbn_registrant_range`
--

INSERT INTO `ezisbn_registrant_range` (`from_number`, `id`, `isbn_group_id`, `registrant_from`, `registrant_length`, `registrant_to`, `to_number`) VALUES
(0, 1, 1, '00', 2, '19', 19999),
(20000, 2, 1, '200', 3, '699', 69999),
(70000, 3, 1, '7000', 4, '8499', 84999),
(85000, 4, 1, '85000', 5, '89999', 89999),
(90000, 5, 1, '900000', 6, '949999', 94999),
(95000, 6, 1, '9500000', 7, '9999999', 99999),
(0, 7, 2, '00', 2, '09', 9999),
(10000, 8, 2, '100', 3, '399', 39999),
(40000, 9, 2, '4000', 4, '5499', 54999),
(55000, 10, 2, '55000', 5, '86979', 86979),
(86980, 11, 2, '869800', 6, '998999', 99899),
(99900, 12, 2, '9990000', 7, '9999999', 99999),
(0, 13, 3, '00', 2, '19', 19999),
(20000, 14, 3, '200', 3, '349', 34999),
(35000, 15, 3, '35000', 5, '39999', 39999),
(40000, 16, 3, '400', 3, '699', 69999),
(70000, 17, 3, '7000', 4, '8399', 83999),
(84000, 18, 3, '84000', 5, '89999', 89999),
(90000, 19, 3, '900000', 6, '949999', 94999),
(95000, 20, 3, '9500000', 7, '9999999', 99999),
(0, 21, 4, '00', 2, '02', 2999),
(3000, 22, 4, '030', 3, '033', 3399),
(3400, 23, 4, '0340', 4, '0369', 3699),
(3700, 24, 4, '03700', 5, '03999', 3999),
(4000, 25, 4, '04', 2, '19', 19999),
(20000, 26, 4, '200', 3, '699', 69999),
(70000, 27, 4, '7000', 4, '8499', 84999),
(85000, 28, 4, '85000', 5, '89999', 89999),
(90000, 29, 4, '900000', 6, '949999', 94999),
(95000, 30, 4, '9500000', 7, '9539999', 95399),
(95400, 31, 4, '95400', 5, '96999', 96999),
(97000, 32, 4, '9700000', 7, '9899999', 98999),
(99000, 33, 4, '99000', 5, '99499', 99499),
(99500, 34, 4, '99500', 5, '99999', 99999),
(0, 35, 5, '00', 2, '19', 19999),
(20000, 36, 5, '200', 3, '699', 69999),
(70000, 37, 5, '7000', 4, '8499', 84999),
(85000, 38, 5, '85000', 5, '89999', 89999),
(90000, 39, 5, '900000', 6, '949999', 94999),
(95000, 40, 5, '9500000', 7, '9999999', 99999),
(0, 41, 6, '00', 2, '19', 19999),
(20000, 42, 6, '200', 3, '420', 42099),
(42100, 43, 6, '4210', 4, '4299', 42999),
(43000, 44, 6, '430', 3, '430', 43099),
(43100, 45, 6, '4310', 4, '4399', 43999),
(44000, 46, 6, '440', 3, '440', 44099),
(44100, 47, 6, '4410', 4, '4499', 44999),
(45000, 48, 6, '450', 3, '699', 69999),
(70000, 49, 6, '7000', 4, '8499', 84999),
(85000, 50, 6, '85000', 5, '89999', 89999),
(90000, 51, 6, '900000', 6, '909999', 90999),
(91000, 52, 6, '91000', 5, '91999', 91999),
(92000, 53, 6, '9200', 4, '9299', 92999),
(93000, 54, 6, '93000', 5, '94999', 94999),
(95000, 55, 6, '9500000', 7, '9500999', 95009),
(95010, 56, 6, '9501', 4, '9799', 97999),
(98000, 57, 6, '98000', 5, '98999', 98999),
(99000, 58, 6, '9900000', 7, '9909999', 99099),
(99100, 59, 6, '9910', 4, '9999', 99999),
(0, 60, 7, '00', 2, '09', 9999),
(10000, 61, 7, '100', 3, '499', 49999),
(50000, 62, 7, '5000', 4, '8999', 89999),
(90000, 63, 7, '90000', 5, '99999', 99999),
(0, 64, 8, '00', 2, '19', 19999),
(20000, 65, 8, '200', 3, '699', 69999),
(70000, 66, 8, '7000', 4, '7999', 79999),
(80000, 67, 8, '80000', 5, '84999', 84999),
(85000, 68, 8, '85', 2, '99', 99999),
(0, 69, 9, '00', 2, '19', 19999),
(20000, 70, 9, '200', 3, '799', 79999),
(80000, 71, 9, '8000', 4, '9499', 94999),
(95000, 72, 9, '95000', 5, '99999', 99999),
(0, 73, 10, '00', 2, '04', 4999),
(5000, 74, 10, '05', 2, '49', 49999),
(50000, 75, 10, '500', 3, '799', 79999),
(80000, 76, 10, '8000', 4, '8999', 89999),
(90000, 77, 10, '90000', 5, '99999', 99999),
(0, 78, 11, '0', 1, '4', 49999),
(50000, 79, 11, '50', 2, '89', 89999),
(90000, 80, 11, '900', 3, '979', 97999),
(98000, 81, 11, '9800', 4, '9999', 99999),
(1000, 82, 12, '01', 2, '09', 9999),
(10000, 83, 12, '100', 3, '399', 39999),
(40000, 84, 12, '4000', 4, '5999', 59999),
(60000, 85, 12, '60000', 5, '89999', 89999),
(90000, 86, 12, '90', 2, '99', 99999),
(0, 87, 13, '0', 1, '0', 9999),
(10000, 88, 13, '10', 2, '49', 49999),
(50000, 89, 13, '500', 3, '799', 79999),
(80000, 90, 13, '8000', 4, '9199', 91999),
(92000, 91, 13, '92000', 5, '99999', 99999),
(0, 92, 14, '00', 2, '39', 39999),
(40000, 93, 14, '400', 3, '749', 74999),
(75000, 94, 14, '7500', 4, '9499', 94999),
(95000, 95, 14, '95000', 5, '99999', 99999),
(0, 96, 15, '0', 1, '0', 9999),
(10000, 97, 15, '10', 2, '19', 19999),
(20000, 98, 15, '200', 3, '449', 44999),
(45000, 99, 15, '4500', 4, '6499', 64999),
(65000, 100, 15, '65000', 5, '69999', 69999),
(70000, 101, 15, '7', 1, '9', 99999),
(0, 102, 16, '00', 2, '39', 39999),
(40000, 103, 16, '400', 3, '799', 79999),
(80000, 104, 16, '8000', 4, '9499', 94999),
(95000, 105, 16, '95000', 5, '99999', 99999),
(0, 106, 18, '00', 2, '29', 29999),
(30000, 107, 18, '300', 3, '399', 39999),
(40000, 108, 18, '4000', 4, '4499', 44999),
(45000, 109, 18, '45000', 5, '49999', 49999),
(50000, 110, 18, '50', 2, '99', 99999),
(0, 111, 19, '0', 1, '9', 99999),
(0, 112, 20, '00', 2, '39', 39999),
(40000, 113, 20, '400', 3, '799', 79999),
(80000, 114, 20, '8000', 4, '9499', 94999),
(95000, 115, 20, '95000', 5, '99999', 99999),
(0, 116, 21, '00', 2, '09', 9999),
(10000, 117, 21, '100', 3, '499', 49999),
(50000, 118, 21, '5000', 4, '7999', 79999),
(80000, 119, 21, '80000', 5, '89999', 89999),
(0, 120, 22, '00', 2, '19', 19999),
(20000, 121, 22, '200', 3, '699', 69999),
(70000, 122, 22, '7000', 4, '8999', 89999),
(90000, 123, 22, '90000', 5, '99999', 99999),
(0, 124, 23, '00', 2, '49', 49999),
(50000, 125, 23, '500', 3, '699', 69999),
(70000, 126, 23, '7000', 4, '8999', 89999),
(90000, 127, 23, '90000', 5, '99999', 99999),
(0, 128, 24, '00', 2, '09', 9999),
(10000, 129, 24, '100', 3, '499', 49999),
(50000, 130, 24, '5000', 4, '7999', 79999),
(80000, 131, 24, '80000', 5, '89999', 89999),
(90000, 132, 24, '900000', 6, '999999', 99999),
(0, 133, 25, '00', 2, '19', 19999),
(20000, 134, 25, '200', 3, '699', 69999),
(70000, 135, 25, '7000', 4, '8499', 84999),
(85000, 136, 25, '85000', 5, '89999', 89999),
(90000, 137, 25, '900000', 6, '999999', 99999),
(0, 138, 26, '00', 2, '19', 19999),
(20000, 139, 26, '200', 3, '699', 69999),
(70000, 140, 26, '7000', 4, '8499', 84999),
(85000, 141, 26, '85000', 5, '89999', 89999),
(90000, 142, 26, '900000', 6, '999999', 99999),
(0, 143, 27, '00', 2, '19', 19999),
(20000, 144, 27, '200', 3, '699', 69999),
(70000, 145, 27, '7000', 4, '8999', 89999),
(90000, 146, 27, '90000', 5, '98999', 98999),
(99000, 147, 27, '990000', 6, '999999', 99999),
(0, 148, 28, '00', 2, '19', 19999),
(20000, 149, 28, '200', 3, '599', 59999),
(60000, 150, 28, '60000', 5, '69999', 69999),
(70000, 151, 28, '7000', 4, '8499', 84999),
(85000, 152, 28, '85000', 5, '89999', 89999),
(90000, 153, 28, '900000', 6, '999999', 99999),
(0, 154, 29, '00', 2, '14', 14999),
(15000, 155, 29, '15000', 5, '19999', 19999),
(20000, 156, 29, '200', 3, '699', 69999),
(70000, 157, 29, '7000', 4, '8499', 84999),
(85000, 158, 29, '85000', 5, '89999', 89999),
(90000, 159, 29, '9000', 4, '9199', 91999),
(92000, 160, 29, '920000', 6, '923999', 92399),
(92400, 161, 29, '92400', 5, '92999', 92999),
(93000, 162, 29, '930000', 6, '949999', 94999),
(95000, 163, 29, '95000', 5, '96999', 96999),
(97000, 164, 29, '9700', 4, '9999', 99999),
(0, 165, 30, '00', 2, '19', 19999),
(20000, 166, 30, '200', 3, '599', 59999),
(60000, 167, 30, '60000', 5, '69999', 69999),
(70000, 168, 30, '7000', 4, '8499', 84999),
(85000, 169, 30, '85000', 5, '89999', 89999),
(90000, 170, 30, '900000', 6, '979999', 97999),
(98000, 171, 30, '98000', 5, '99999', 99999),
(0, 172, 31, '00', 2, '29', 29999),
(30000, 173, 31, '300', 3, '599', 59999),
(60000, 174, 31, '6000', 4, '7999', 79999),
(80000, 175, 31, '80000', 5, '89999', 89999),
(90000, 176, 31, '900000', 6, '999999', 99999),
(0, 177, 32, '00', 2, '29', 29999),
(40000, 178, 32, '400', 3, '649', 64999),
(70000, 179, 32, '7000', 4, '7999', 79999),
(85000, 180, 32, '85000', 5, '94999', 94999),
(97000, 181, 32, '970000', 6, '999999', 99999),
(0, 182, 33, '00', 2, '19', 19999),
(20000, 183, 33, '200', 3, '599', 59999),
(60000, 184, 33, '6000', 4, '8499', 84999),
(85000, 185, 33, '85000', 5, '89999', 89999),
(90000, 186, 33, '900000', 6, '949999', 94999),
(95000, 187, 33, '95000', 5, '99999', 99999),
(0, 188, 34, '00', 2, '24', 24999),
(25000, 189, 34, '250', 3, '549', 54999),
(55000, 190, 34, '5500', 4, '8499', 84999),
(85000, 191, 34, '85000', 5, '94999', 94999),
(95000, 192, 34, '950000', 6, '969999', 96999),
(97000, 193, 34, '97000', 5, '98999', 98999),
(99000, 194, 34, '990', 3, '999', 99999),
(0, 195, 35, '00', 2, '19', 19999),
(20000, 196, 35, '200', 3, '499', 49999),
(50000, 197, 35, '5000', 4, '6999', 69999),
(70000, 198, 35, '70000', 5, '79999', 79999),
(80000, 199, 35, '800000', 6, '849999', 84999),
(85000, 200, 35, '8500', 4, '8999', 89999),
(90000, 201, 35, '90', 2, '90', 90999),
(91000, 202, 35, '910000', 6, '939999', 93999),
(94000, 203, 35, '94', 2, '94', 94999),
(95000, 204, 35, '950000', 6, '999999', 99999),
(0, 205, 36, '0', 1, '1', 19999),
(20000, 206, 36, '20', 2, '49', 49999),
(50000, 207, 36, '500', 3, '649', 64999),
(70000, 208, 36, '7000', 4, '7999', 79999),
(85000, 209, 36, '85000', 5, '94999', 94999),
(97000, 210, 36, '970000', 6, '999999', 99999),
(0, 211, 37, '0', 1, '5', 59999),
(60000, 212, 37, '60', 2, '79', 79999),
(80000, 213, 37, '800', 3, '899', 89999),
(90000, 214, 37, '9000', 4, '9499', 94999),
(95000, 215, 37, '95000', 5, '98999', 98999),
(99000, 216, 37, '990000', 6, '999999', 99999),
(0, 217, 38, '00', 2, '09', 9999),
(10000, 218, 38, '100', 3, '499', 49999),
(50000, 219, 38, '5000', 4, '7999', 79999),
(80000, 220, 38, '80000', 5, '94999', 94999),
(95000, 221, 38, '950000', 6, '999999', 99999),
(0, 222, 39, '000', 3, '599', 59999),
(60000, 223, 39, '6000', 4, '8999', 89999),
(90000, 224, 39, '90000', 5, '99999', 99999),
(0, 225, 40, '00', 2, '49', 49999),
(50000, 226, 40, '500', 3, '899', 89999),
(90000, 227, 40, '9000', 4, '9899', 98999),
(99000, 228, 40, '99000', 5, '99999', 99999),
(0, 229, 41, '0', 1, '1', 19999),
(20000, 230, 41, '20', 2, '54', 54999),
(55000, 231, 41, '550', 3, '889', 88999),
(89000, 232, 41, '8900', 4, '9499', 94999),
(95000, 233, 41, '95000', 5, '99999', 99999),
(0, 234, 42, '00', 2, '19', 19999),
(20000, 235, 42, '200', 3, '499', 49999),
(50000, 236, 42, '5000', 4, '5999', 59999),
(60000, 237, 42, '60', 2, '65', 65999),
(66000, 238, 42, '6600', 4, '6699', 66999),
(67000, 239, 42, '67000', 5, '69999', 69999),
(70000, 240, 42, '7000', 4, '7999', 79999),
(80000, 241, 42, '80', 2, '94', 94999),
(95000, 242, 42, '9500', 4, '9899', 98999),
(99000, 243, 42, '99000', 5, '99999', 99999),
(0, 244, 43, '0', 1, '0', 9999),
(10000, 245, 43, '10', 2, '14', 14999),
(15000, 246, 43, '150', 3, '549', 54999),
(55000, 247, 43, '55000', 5, '59999', 59999),
(60000, 248, 43, '6000', 4, '9499', 94999),
(95000, 249, 43, '95000', 5, '99999', 99999),
(0, 250, 44, '00', 2, '28', 28999),
(29000, 251, 44, '2900', 4, '2999', 29999),
(30000, 252, 44, '300', 3, '799', 79999),
(80000, 253, 44, '8000', 4, '8999', 89999),
(90000, 254, 44, '90000', 5, '92999', 92999),
(93000, 255, 44, '9300', 4, '9999', 99999),
(0, 256, 45, '0000', 4, '1999', 19999),
(20000, 257, 45, '20', 2, '49', 49999),
(50000, 258, 45, '50000', 5, '54999', 54999),
(55000, 259, 45, '550', 3, '799', 79999),
(80000, 260, 45, '8000', 4, '9499', 94999),
(95000, 261, 45, '95000', 5, '99999', 99999),
(0, 262, 46, '00', 2, '19', 19999),
(20000, 263, 46, '200', 3, '699', 69999),
(70000, 264, 46, '7000', 4, '9999', 99999),
(0, 265, 47, '00', 2, '02', 2999),
(3000, 266, 47, '0300', 4, '0499', 4999),
(5000, 267, 47, '05', 2, '19', 19999),
(20000, 268, 47, '2000', 4, '2099', 20999),
(21000, 269, 47, '21', 2, '27', 27999),
(28000, 270, 47, '28000', 5, '30999', 30999),
(31000, 271, 47, '31', 2, '43', 43999),
(44000, 272, 47, '440', 3, '819', 81999),
(82000, 273, 47, '8200', 4, '9699', 96999),
(97000, 274, 47, '97000', 5, '99999', 99999),
(0, 275, 48, '00', 2, '56', 56999),
(57000, 276, 48, '57000', 5, '59999', 59999),
(60000, 277, 48, '600', 3, '799', 79999),
(80000, 278, 48, '8000', 4, '9499', 94999),
(95000, 279, 48, '95000', 5, '99999', 99999),
(0, 280, 49, '00', 2, '19', 19999),
(20000, 281, 49, '200', 3, '699', 69999),
(70000, 282, 49, '7000', 4, '8499', 84999),
(85000, 283, 49, '85000', 5, '99999', 99999),
(0, 284, 50, '00', 2, '19', 19999),
(20000, 285, 50, '200', 3, '659', 65999),
(66000, 286, 50, '6600', 4, '6899', 68999),
(69000, 287, 50, '690', 3, '699', 69999),
(70000, 288, 50, '7000', 4, '8499', 84999),
(85000, 289, 50, '85000', 5, '92999', 92999),
(93000, 290, 50, '93', 2, '93', 93999),
(94000, 291, 50, '9400', 4, '9799', 97999),
(98000, 292, 50, '98000', 5, '99999', 99999),
(0, 293, 51, '00', 2, '19', 19999),
(20000, 294, 51, '200', 3, '599', 59999),
(60000, 295, 51, '6000', 4, '8999', 89999),
(90000, 296, 51, '90000', 5, '94999', 94999),
(0, 297, 52, '00', 2, '19', 19999),
(20000, 298, 52, '200', 3, '699', 69999),
(70000, 299, 52, '7000', 4, '8499', 84999),
(85000, 300, 52, '85000', 5, '86999', 86999),
(87000, 301, 52, '8700', 4, '8999', 89999),
(90000, 302, 52, '900', 3, '999', 99999),
(0, 303, 53, '00', 2, '19', 19999),
(20000, 304, 53, '200', 3, '699', 69999),
(70000, 305, 53, '7000', 4, '8499', 84999),
(85000, 306, 53, '85000', 5, '89999', 89999),
(90000, 307, 53, '9000', 4, '9999', 99999),
(0, 308, 54, '00', 2, '14', 14999),
(15000, 309, 54, '150', 3, '249', 24999),
(25000, 310, 54, '2500', 4, '2999', 29999),
(30000, 311, 54, '300', 3, '549', 54999),
(55000, 312, 54, '5500', 4, '8999', 89999),
(90000, 313, 54, '90000', 5, '96999', 96999),
(97000, 314, 54, '970', 3, '989', 98999),
(99000, 315, 54, '9900', 4, '9999', 99999),
(0, 316, 55, '00', 2, '19', 19999),
(20000, 317, 55, '200', 3, '599', 59999),
(70000, 318, 55, '7000', 4, '7999', 79999),
(90000, 319, 55, '90000', 5, '99999', 99999),
(0, 320, 56, '00', 2, '14', 14999),
(15000, 321, 56, '1500', 4, '1699', 16999),
(17000, 322, 56, '170', 3, '199', 19999),
(20000, 323, 56, '2000', 4, '2999', 29999),
(30000, 324, 56, '300', 3, '699', 69999),
(70000, 325, 56, '7000', 4, '8999', 89999),
(90000, 326, 56, '90000', 5, '99999', 99999),
(0, 327, 57, '00', 2, '00', 999),
(1000, 328, 57, '0100', 4, '0999', 9999),
(10000, 329, 57, '10000', 5, '19999', 19999),
(30000, 330, 57, '300', 3, '499', 49999),
(50000, 331, 57, '5000', 4, '5999', 59999),
(60000, 332, 57, '60', 2, '89', 89999),
(90000, 333, 57, '900', 3, '989', 98999),
(99000, 334, 57, '9900', 4, '9989', 99899),
(99900, 335, 57, '99900', 5, '99999', 99999),
(1000, 336, 58, '01', 2, '39', 39999),
(40000, 337, 58, '400', 3, '499', 49999),
(50000, 338, 58, '5000', 4, '7999', 79999),
(80000, 339, 58, '800', 3, '899', 89999),
(90000, 340, 58, '9000', 4, '9999', 99999),
(0, 341, 59, '0', 1, '1', 19999),
(20000, 342, 59, '20', 2, '39', 39999),
(40000, 343, 59, '400', 3, '799', 79999),
(80000, 344, 59, '8000', 4, '9999', 99999),
(1000, 345, 60, '01', 2, '59', 59999),
(60000, 346, 60, '600', 3, '899', 89999),
(90000, 347, 60, '9000', 4, '9099', 90999),
(91000, 348, 60, '91000', 5, '96999', 96999),
(97000, 349, 60, '9700', 4, '9999', 99999),
(0, 350, 61, '000', 3, '015', 1599),
(1600, 351, 61, '0160', 4, '0199', 1999),
(2000, 352, 61, '02', 2, '02', 2999),
(3000, 353, 61, '0300', 4, '0599', 5999),
(6000, 354, 61, '06', 2, '09', 9999),
(10000, 355, 61, '10', 2, '49', 49999),
(50000, 356, 61, '500', 3, '849', 84999),
(85000, 357, 61, '8500', 4, '9099', 90999),
(91000, 358, 61, '91000', 5, '98999', 98999),
(99000, 359, 61, '9900', 4, '9999', 99999),
(0, 360, 62, '0', 1, '1', 19999),
(20000, 361, 62, '20', 2, '54', 54999),
(55000, 362, 62, '550', 3, '799', 79999),
(80000, 363, 62, '8000', 4, '9499', 94999),
(95000, 364, 62, '95000', 5, '99999', 99999),
(0, 365, 63, '0', 1, '0', 9999),
(10000, 366, 63, '100', 3, '169', 16999),
(17000, 367, 63, '1700', 4, '1999', 19999),
(20000, 368, 63, '20', 2, '54', 54999),
(55000, 369, 63, '550', 3, '759', 75999),
(76000, 370, 63, '7600', 4, '8499', 84999),
(85000, 371, 63, '85000', 5, '88999', 88999),
(89000, 372, 63, '8900', 4, '9499', 94999),
(95000, 373, 63, '95000', 5, '99999', 99999),
(0, 374, 64, '00', 2, '19', 19999),
(20000, 375, 64, '200', 3, '699', 69999),
(70000, 376, 64, '7000', 4, '8499', 84999),
(85000, 377, 64, '85000', 5, '89999', 89999),
(90000, 378, 64, '90000', 5, '94999', 94999),
(95000, 379, 64, '9500', 4, '9999', 99999),
(0, 380, 65, '00000', 5, '01999', 1999),
(2000, 381, 65, '02', 2, '24', 24999),
(25000, 382, 65, '250', 3, '599', 59999),
(60000, 383, 65, '6000', 4, '9199', 91999),
(92000, 384, 65, '92000', 5, '98999', 98999),
(99000, 385, 65, '990', 3, '999', 99999),
(0, 386, 66, '0', 1, '3', 39999),
(40000, 387, 66, '40', 2, '59', 59999),
(60000, 388, 66, '600', 3, '799', 79999),
(80000, 389, 66, '8000', 4, '9499', 94999),
(95000, 390, 66, '95000', 5, '99999', 99999),
(0, 391, 67, '00', 2, '19', 19999),
(20000, 392, 67, '200', 3, '499', 49999),
(50000, 393, 67, '5000', 4, '6999', 69999),
(70000, 394, 67, '700', 3, '999', 99999),
(0, 395, 68, '000', 3, '199', 19999),
(20000, 396, 68, '2000', 4, '2999', 29999),
(30000, 397, 68, '30000', 5, '79999', 79999),
(80000, 398, 68, '8000', 4, '8999', 89999),
(90000, 399, 68, '900', 3, '999', 99999),
(0, 400, 69, '000', 3, '099', 9999),
(10000, 401, 69, '1000', 4, '1499', 14999),
(15000, 402, 69, '15000', 5, '19999', 19999),
(20000, 403, 69, '20', 2, '29', 29999),
(30000, 404, 69, '3000', 4, '3999', 39999),
(40000, 405, 69, '400', 3, '799', 79999),
(80000, 406, 69, '8000', 4, '9499', 94999),
(95000, 407, 69, '95000', 5, '99999', 99999),
(0, 408, 70, '00', 2, '19', 19999),
(20000, 409, 70, '200', 3, '599', 59999),
(60000, 410, 70, '6000', 4, '9999', 99999),
(0, 411, 71, '00', 2, '11', 11999),
(12000, 412, 71, '1200', 4, '1999', 19999),
(20000, 413, 71, '200', 3, '289', 28999),
(29000, 414, 71, '2900', 4, '9999', 99999),
(0, 415, 72, '00', 2, '09', 9999),
(10000, 416, 72, '100', 3, '699', 69999),
(70000, 417, 72, '70', 2, '89', 89999),
(90000, 418, 72, '9000', 4, '9799', 97999),
(98000, 419, 72, '98000', 5, '99999', 99999),
(0, 420, 73, '00', 2, '01', 1999),
(2000, 421, 73, '020', 3, '199', 19999),
(20000, 422, 73, '2000', 4, '3999', 39999),
(40000, 423, 73, '40000', 5, '44999', 44999),
(45000, 424, 73, '45', 2, '49', 49999),
(50000, 425, 73, '50', 2, '79', 79999),
(80000, 426, 73, '800', 3, '899', 89999),
(90000, 427, 73, '9000', 4, '9899', 98999),
(99000, 428, 73, '99000', 5, '99999', 99999),
(0, 429, 74, '00', 2, '39', 39999),
(40000, 430, 74, '400', 3, '799', 79999),
(80000, 431, 74, '8000', 4, '8999', 89999),
(90000, 432, 74, '90000', 5, '99999', 99999),
(0, 433, 75, '00', 2, '39', 39999),
(40000, 434, 75, '400', 3, '599', 59999),
(60000, 435, 75, '6000', 4, '8999', 89999),
(90000, 436, 75, '90000', 5, '99999', 99999),
(0, 437, 76, '00', 2, '11', 11999),
(12000, 438, 76, '120', 3, '559', 55999),
(56000, 439, 76, '5600', 4, '7999', 79999),
(80000, 440, 76, '80000', 5, '99999', 99999),
(0, 441, 77, '00', 2, '09', 9999),
(10000, 442, 77, '1000', 4, '1999', 19999),
(20000, 443, 77, '20000', 5, '29999', 29999),
(30000, 444, 77, '30', 2, '49', 49999),
(50000, 445, 77, '500', 3, '899', 89999),
(90000, 446, 77, '9000', 4, '9499', 94999),
(95000, 447, 77, '95000', 5, '99999', 99999),
(0, 448, 78, '00', 2, '14', 14999),
(15000, 449, 78, '15000', 5, '16999', 16999),
(17000, 450, 78, '17000', 5, '19999', 19999),
(20000, 451, 78, '200', 3, '799', 79999),
(80000, 452, 78, '8000', 4, '9699', 96999),
(97000, 453, 78, '97000', 5, '99999', 99999),
(0, 454, 79, '0', 1, '1', 19999),
(20000, 455, 79, '20', 2, '54', 54999),
(55000, 456, 79, '550', 3, '799', 79999),
(80000, 457, 79, '8000', 4, '9499', 94999),
(95000, 458, 79, '95000', 5, '99999', 99999),
(0, 459, 80, '00', 2, '09', 9999),
(10000, 460, 80, '100', 3, '399', 39999),
(40000, 461, 80, '4000', 4, '4999', 49999),
(0, 462, 81, '00', 2, '09', 9999),
(10000, 463, 81, '100', 3, '399', 39999),
(40000, 464, 81, '4000', 4, '4999', 49999),
(0, 465, 82, '0', 1, '3', 39999),
(40000, 466, 82, '40', 2, '54', 54999),
(55000, 467, 82, '550', 3, '799', 79999),
(80000, 468, 82, '8000', 4, '9999', 99999),
(0, 469, 83, '00', 2, '49', 49999),
(50000, 470, 83, '500', 3, '939', 93999),
(94000, 471, 83, '9400', 4, '9999', 99999),
(0, 472, 84, '00', 2, '29', 29999),
(30000, 473, 84, '300', 3, '899', 89999),
(90000, 474, 84, '9000', 4, '9999', 99999),
(0, 475, 85, '00', 2, '39', 39999),
(40000, 476, 85, '400', 3, '849', 84999),
(85000, 477, 85, '8500', 4, '9999', 99999),
(0, 478, 86, '0', 1, '0', 9999),
(10000, 479, 86, '10', 2, '39', 39999),
(40000, 480, 86, '400', 3, '899', 89999),
(90000, 481, 86, '9000', 4, '9999', 99999),
(0, 482, 87, '0', 1, '0', 9999),
(10000, 483, 87, '10', 2, '49', 49999),
(50000, 484, 87, '500', 3, '799', 79999),
(80000, 485, 87, '8000', 4, '9999', 99999),
(0, 486, 88, '0', 1, '0', 9999),
(10000, 487, 88, '10', 2, '39', 39999),
(40000, 488, 88, '400', 3, '899', 89999),
(90000, 489, 88, '9000', 4, '9999', 99999),
(0, 490, 89, '0', 1, '1', 19999),
(20000, 491, 89, '20', 2, '39', 39999),
(40000, 492, 89, '400', 3, '799', 79999),
(80000, 493, 89, '8000', 4, '9999', 99999),
(0, 494, 90, '0', 1, '2', 29999),
(30000, 495, 90, '30', 2, '49', 49999),
(50000, 496, 90, '500', 3, '799', 79999),
(80000, 497, 90, '8000', 4, '9999', 99999),
(0, 498, 91, '00', 2, '79', 79999),
(80000, 499, 91, '800', 3, '949', 94999),
(95000, 500, 91, '9500', 4, '9999', 99999),
(0, 501, 92, '0', 1, '4', 49999),
(50000, 502, 92, '50', 2, '79', 79999),
(80000, 503, 92, '800', 3, '899', 89999),
(90000, 504, 92, '9000', 4, '9999', 99999),
(0, 505, 93, '0', 1, '1', 19999),
(20000, 506, 93, '20', 2, '49', 49999),
(50000, 507, 93, '500', 3, '899', 89999),
(90000, 508, 93, '9000', 4, '9999', 99999),
(0, 509, 94, '0', 1, '0', 9999),
(10000, 510, 94, '10', 2, '39', 39999),
(40000, 511, 94, '400', 3, '899', 89999),
(90000, 512, 94, '9000', 4, '9999', 99999),
(0, 513, 95, '00', 2, '89', 89999),
(90000, 514, 95, '900', 3, '984', 98499),
(98500, 515, 95, '9850', 4, '9999', 99999),
(0, 516, 96, '00', 2, '29', 29999),
(30000, 517, 96, '300', 3, '399', 39999),
(40000, 518, 96, '4000', 4, '9999', 99999),
(0, 519, 97, '0000', 4, '0999', 9999),
(10000, 520, 97, '100', 3, '499', 49999),
(50000, 521, 97, '5000', 4, '5999', 59999),
(60000, 522, 97, '60', 2, '69', 69999),
(70000, 523, 97, '700', 3, '799', 79999),
(80000, 524, 97, '80', 2, '89', 89999),
(90000, 525, 97, '900', 3, '999', 99999),
(0, 526, 98, '00', 2, '00', 999),
(1000, 527, 98, '010', 3, '079', 7999),
(8000, 528, 98, '08', 2, '39', 39999),
(40000, 529, 98, '400', 3, '569', 56999),
(57000, 530, 98, '57', 2, '57', 57999),
(58000, 531, 98, '580', 3, '849', 84999),
(85000, 532, 98, '8500', 4, '9999', 99999),
(0, 533, 99, '0', 1, '1', 19999),
(20000, 534, 99, '20', 2, '39', 39999),
(40000, 535, 99, '400', 3, '899', 89999),
(90000, 536, 99, '9000', 4, '9999', 99999),
(0, 537, 100, '0', 1, '1', 19999),
(20000, 538, 100, '20', 2, '79', 79999),
(80000, 539, 100, '800', 3, '999', 99999),
(0, 540, 101, '00', 2, '39', 39999),
(40000, 541, 101, '400', 3, '849', 84999),
(85000, 542, 101, '8500', 4, '9999', 99999),
(0, 543, 102, '0', 1, '0', 9999),
(10000, 544, 102, '10', 2, '39', 39999),
(40000, 545, 102, '400', 3, '899', 89999),
(90000, 546, 102, '9000', 4, '9999', 99999),
(0, 547, 103, '00', 2, '29', 29999),
(30000, 548, 103, '300', 3, '849', 84999),
(85000, 549, 103, '8500', 4, '9999', 99999),
(0, 550, 104, '00', 2, '39', 39999),
(40000, 551, 104, '400', 3, '849', 84999),
(85000, 552, 104, '8500', 4, '9999', 99999),
(0, 553, 105, '0', 1, '1', 19999),
(20000, 554, 105, '20', 2, '39', 39999),
(40000, 555, 105, '400', 3, '799', 79999),
(80000, 556, 105, '8000', 4, '9999', 99999),
(0, 557, 106, '0', 1, '0', 9999),
(10000, 558, 106, '10', 2, '39', 39999),
(40000, 559, 106, '400', 3, '599', 59999),
(60000, 560, 106, '60', 2, '89', 89999),
(90000, 561, 106, '9000', 4, '9999', 99999),
(0, 562, 107, '0', 1, '1', 19999),
(20000, 563, 107, '20', 2, '39', 39999),
(40000, 564, 107, '400', 3, '799', 79999),
(80000, 565, 107, '8000', 4, '9999', 99999),
(0, 566, 108, '00', 2, '39', 39999),
(40000, 567, 108, '400', 3, '929', 92999),
(93000, 568, 108, '9300', 4, '9999', 99999),
(0, 569, 109, '0', 1, '0', 9999),
(10000, 570, 109, '10', 2, '39', 39999),
(40000, 571, 109, '400', 3, '899', 89999),
(90000, 572, 109, '9000', 4, '9999', 99999),
(0, 573, 110, '00', 2, '39', 39999),
(40000, 574, 110, '400', 3, '699', 69999),
(70000, 575, 110, '70', 2, '84', 84999),
(85000, 576, 110, '8500', 4, '8799', 87999),
(88000, 577, 110, '88', 2, '99', 99999),
(0, 578, 111, '0', 1, '0', 9999),
(10000, 579, 111, '10', 2, '18', 18999),
(19000, 580, 111, '1900', 4, '1999', 19999),
(20000, 581, 111, '20', 2, '49', 49999),
(50000, 582, 111, '500', 3, '899', 89999),
(90000, 583, 111, '9000', 4, '9999', 99999),
(0, 584, 112, '0', 1, '1', 19999),
(20000, 585, 112, '20', 2, '79', 79999),
(80000, 586, 112, '800', 3, '949', 94999),
(95000, 587, 112, '9500', 4, '9999', 99999),
(0, 588, 113, '00', 2, '59', 59999),
(60000, 589, 113, '600', 3, '899', 89999),
(90000, 590, 113, '9000', 4, '9999', 99999),
(0, 591, 114, '0', 1, '2', 29999),
(30000, 592, 114, '30', 2, '69', 69999),
(70000, 593, 114, '700', 3, '949', 94999),
(95000, 594, 114, '9500', 4, '9999', 99999),
(0, 595, 115, '00', 2, '54', 54999),
(55000, 596, 115, '5500', 4, '5599', 55999),
(56000, 597, 115, '56', 2, '59', 59999),
(60000, 598, 115, '600', 3, '849', 84999),
(85000, 599, 115, '8500', 4, '9999', 99999),
(0, 600, 116, '0', 1, '2', 29999),
(30000, 601, 116, '30', 2, '54', 54999),
(55000, 602, 116, '550', 3, '734', 73499),
(73500, 603, 116, '7350', 4, '7499', 74999),
(75000, 604, 116, '7500', 4, '9999', 99999),
(0, 605, 117, '0', 1, '6', 69999),
(70000, 606, 117, '70', 2, '94', 94999),
(95000, 607, 117, '950', 3, '999', 99999),
(0, 608, 118, '00', 2, '39', 39999),
(40000, 609, 118, '400', 3, '899', 89999),
(90000, 610, 118, '9000', 4, '9999', 99999),
(0, 611, 119, '000', 3, '149', 14999),
(15000, 612, 119, '1500', 4, '1999', 19999),
(20000, 613, 119, '20', 2, '69', 69999),
(70000, 614, 119, '7000', 4, '7499', 74999),
(75000, 615, 119, '750', 3, '959', 95999),
(96000, 616, 119, '9600', 4, '9999', 99999),
(0, 617, 120, '00', 2, '39', 39999),
(40000, 618, 120, '400', 3, '899', 89999),
(90000, 619, 120, '9000', 4, '9999', 99999),
(0, 620, 121, '00', 2, '49', 49999),
(50000, 621, 121, '500', 3, '939', 93999),
(94000, 622, 121, '9400', 4, '9999', 99999),
(0, 623, 122, '00', 2, '39', 39999),
(40000, 624, 122, '400', 3, '899', 89999),
(90000, 625, 122, '9000', 4, '9999', 99999),
(0, 626, 123, '0', 1, '5', 59999),
(60000, 627, 123, '60', 2, '89', 89999),
(90000, 628, 123, '900', 3, '989', 98999),
(99000, 629, 123, '9900', 4, '9999', 99999),
(0, 630, 124, '00', 2, '09', 9999),
(10000, 631, 124, '1', 1, '1', 19999),
(20000, 632, 124, '200', 3, '249', 24999),
(25000, 633, 124, '2500', 4, '2999', 29999),
(30000, 634, 124, '30', 2, '59', 59999),
(60000, 635, 124, '600', 3, '899', 89999),
(90000, 636, 124, '9000', 4, '9999', 99999),
(0, 637, 125, '00', 2, '05', 5999),
(6000, 638, 125, '060', 3, '089', 8999),
(9000, 639, 125, '0900', 4, '0999', 9999),
(10000, 640, 125, '10', 2, '69', 69999),
(70000, 641, 125, '700', 3, '969', 96999),
(97000, 642, 125, '9700', 4, '9999', 99999),
(0, 643, 126, '0', 1, '2', 29999),
(30000, 644, 126, '30', 2, '54', 54999),
(55000, 645, 126, '550', 3, '749', 74999),
(75000, 646, 126, '7500', 4, '9499', 94999),
(95000, 647, 126, '95', 2, '99', 99999),
(0, 648, 127, '0', 1, '0', 9999),
(10000, 649, 127, '100', 3, '399', 39999),
(40000, 650, 127, '4000', 4, '4499', 44999),
(45000, 651, 127, '45', 2, '89', 89999),
(90000, 652, 127, '900', 3, '949', 94999),
(95000, 653, 127, '9500', 4, '9999', 99999),
(0, 654, 128, '0', 1, '5', 59999),
(60000, 655, 128, '60', 2, '89', 89999),
(90000, 656, 128, '900', 3, '989', 98999),
(99000, 657, 128, '9900', 4, '9999', 99999),
(0, 658, 129, '00', 2, '89', 89999),
(90000, 659, 129, '900', 3, '989', 98999),
(99000, 660, 129, '9900', 4, '9999', 99999),
(0, 661, 130, '00', 2, '29', 29999),
(30000, 662, 130, '300', 3, '399', 39999),
(40000, 663, 130, '40', 2, '94', 94999),
(95000, 664, 130, '950', 3, '989', 98999),
(99000, 665, 130, '9900', 4, '9999', 99999),
(0, 666, 131, '0', 1, '4', 49999),
(50000, 667, 131, '50', 2, '64', 64999),
(65000, 668, 131, '650', 3, '659', 65999),
(66000, 669, 131, '66', 2, '75', 75999),
(76000, 670, 131, '760', 3, '899', 89999),
(90000, 671, 131, '9000', 4, '9999', 99999),
(0, 672, 132, '0', 1, '3', 39999),
(40000, 673, 132, '40', 2, '89', 89999),
(90000, 674, 132, '900', 3, '989', 98999),
(99000, 675, 132, '9900', 4, '9999', 99999),
(0, 676, 133, '00', 2, '09', 9999),
(10000, 677, 133, '100', 3, '159', 15999),
(16000, 678, 133, '1600', 4, '1999', 19999),
(20000, 679, 133, '20', 2, '79', 79999),
(80000, 680, 133, '800', 3, '949', 94999),
(95000, 681, 133, '9500', 4, '9999', 99999),
(0, 682, 134, '00', 2, '79', 79999),
(80000, 683, 134, '800', 3, '989', 98999),
(99000, 684, 134, '9900', 4, '9999', 99999),
(80000, 685, 135, '80', 2, '94', 94999),
(95000, 686, 135, '950', 3, '989', 98999),
(99000, 687, 135, '9900', 4, '9999', 99999),
(0, 688, 136, '00', 2, '49', 49999),
(50000, 689, 136, '500', 3, '899', 89999),
(90000, 690, 136, '9000', 4, '9999', 99999),
(0, 691, 137, '0', 1, '4', 49999),
(50000, 692, 137, '50', 2, '79', 79999),
(80000, 693, 137, '800', 3, '899', 89999),
(90000, 694, 137, '9000', 4, '9999', 99999),
(0, 695, 138, '00', 2, '39', 39999),
(40000, 696, 138, '400', 3, '899', 89999),
(90000, 697, 138, '9000', 4, '9399', 93999),
(94000, 698, 138, '940', 3, '969', 96999),
(97000, 699, 138, '97', 2, '99', 99999),
(0, 700, 139, '00', 2, '39', 39999),
(40000, 701, 139, '400', 3, '879', 87999),
(88000, 702, 139, '8800', 4, '9999', 99999),
(0, 703, 140, '0', 1, '2', 29999),
(30000, 704, 140, '30', 2, '54', 54999),
(55000, 705, 140, '550', 3, '749', 74999),
(75000, 706, 140, '7500', 4, '9999', 99999),
(0, 707, 141, '0', 1, '0', 9999),
(10000, 708, 141, '100', 3, '199', 19999),
(20000, 709, 141, '2000', 4, '2999', 29999),
(30000, 710, 141, '30', 2, '59', 59999),
(60000, 711, 141, '600', 3, '949', 94999),
(95000, 712, 141, '9500', 4, '9999', 99999),
(0, 713, 142, '00', 2, '49', 49999),
(50000, 714, 142, '500', 3, '799', 79999),
(80000, 715, 142, '80', 2, '99', 99999),
(0, 716, 144, '0', 1, '1', 19999),
(20000, 717, 144, '20', 2, '89', 89999),
(90000, 718, 144, '900', 3, '999', 99999),
(0, 719, 145, '0', 1, '5', 59999),
(60000, 720, 145, '60', 2, '89', 89999),
(90000, 721, 145, '900', 3, '999', 99999),
(0, 722, 146, '0', 1, '3', 39999),
(40000, 723, 146, '40', 2, '79', 79999),
(80000, 724, 146, '800', 3, '999', 99999),
(0, 725, 147, '0', 1, '2', 29999),
(30000, 726, 147, '30', 2, '59', 59999),
(60000, 727, 147, '600', 3, '699', 69999),
(70000, 728, 147, '70', 2, '89', 89999),
(90000, 729, 147, '90', 2, '94', 94999),
(95000, 730, 147, '950', 3, '999', 99999),
(0, 731, 148, '0', 1, '0', 9999),
(10000, 732, 148, '10', 2, '89', 89999),
(90000, 733, 148, '900', 3, '999', 99999),
(0, 734, 149, '0', 1, '3', 39999),
(40000, 735, 149, '40', 2, '94', 94999),
(95000, 736, 149, '950', 3, '999', 99999),
(0, 737, 150, '0', 1, '2', 29999),
(30000, 738, 150, '30', 2, '89', 89999),
(90000, 739, 150, '900', 3, '999', 99999),
(0, 740, 151, '00', 2, '59', 59999),
(60000, 741, 151, '600', 3, '999', 99999),
(0, 742, 152, '0', 1, '3', 39999),
(40000, 743, 152, '400', 3, '599', 59999),
(60000, 744, 152, '60', 2, '89', 89999),
(90000, 745, 152, '900', 3, '999', 99999),
(0, 746, 153, '0', 1, '2', 29999),
(30000, 747, 153, '30', 2, '35', 35999),
(60000, 748, 153, '600', 3, '604', 60499),
(0, 749, 154, '0', 1, '4', 49999),
(50000, 750, 154, '50', 2, '89', 89999),
(90000, 751, 154, '900', 3, '999', 99999),
(0, 752, 155, '0', 1, '4', 49999),
(50000, 753, 155, '50', 2, '79', 79999),
(80000, 754, 155, '800', 3, '999', 99999),
(0, 755, 156, '0', 1, '2', 29999),
(30000, 756, 156, '30', 2, '69', 69999),
(70000, 757, 156, '700', 3, '999', 99999),
(0, 758, 157, '0', 1, '2', 29999),
(30000, 759, 157, '30', 2, '89', 89999),
(90000, 760, 157, '900', 3, '999', 99999),
(0, 761, 158, '0', 1, '3', 39999),
(40000, 762, 158, '40', 2, '79', 79999),
(80000, 763, 158, '800', 3, '999', 99999),
(0, 764, 159, '0', 1, '2', 29999),
(30000, 765, 159, '300', 3, '399', 39999),
(40000, 766, 159, '40', 2, '69', 69999),
(90000, 767, 159, '900', 3, '999', 99999),
(0, 768, 160, '0', 1, '4', 49999),
(50000, 769, 160, '50', 2, '89', 89999),
(90000, 770, 160, '900', 3, '999', 99999),
(0, 771, 161, '0', 1, '1', 19999),
(20000, 772, 161, '20', 2, '69', 69999),
(70000, 773, 161, '700', 3, '799', 79999),
(80000, 774, 161, '8', 1, '8', 89999),
(90000, 775, 161, '90', 2, '99', 99999),
(0, 776, 162, '0', 1, '3', 39999),
(40000, 777, 162, '40', 2, '69', 69999),
(70000, 778, 162, '700', 3, '999', 99999),
(0, 779, 163, '0', 1, '1', 19999),
(20000, 780, 163, '20', 2, '79', 79999),
(80000, 781, 163, '800', 3, '999', 99999),
(0, 782, 164, '0', 1, '1', 19999),
(20000, 783, 164, '20', 2, '79', 79999),
(80000, 784, 164, '800', 3, '999', 99999),
(0, 785, 165, '0', 1, '3', 39999),
(40000, 786, 165, '40', 2, '79', 79999),
(80000, 787, 165, '800', 3, '999', 99999),
(0, 788, 166, '0', 1, '0', 9999),
(10000, 789, 166, '10', 2, '59', 59999),
(60000, 790, 166, '600', 3, '999', 99999),
(0, 791, 167, '0', 1, '2', 29999),
(30000, 792, 167, '30', 2, '59', 59999),
(60000, 793, 167, '600', 3, '999', 99999),
(0, 794, 168, '0', 1, '0', 9999),
(10000, 795, 168, '10', 2, '79', 79999),
(80000, 796, 168, '800', 3, '999', 99999),
(0, 797, 169, '0', 1, '4', 49999),
(50000, 798, 169, '50', 2, '79', 79999),
(80000, 799, 169, '800', 3, '999', 99999),
(0, 800, 170, '0', 1, '4', 49999),
(50000, 801, 170, '50', 2, '79', 79999),
(80000, 802, 170, '800', 3, '999', 99999),
(0, 803, 171, '0', 1, '4', 49999),
(50000, 804, 171, '50', 2, '79', 79999),
(80000, 805, 171, '800', 3, '999', 99999),
(0, 806, 172, '0', 1, '0', 9999),
(10000, 807, 172, '10', 2, '59', 59999),
(60000, 808, 172, '600', 3, '699', 69999),
(70000, 809, 172, '7', 1, '7', 79999),
(80000, 810, 172, '80', 2, '99', 99999),
(0, 811, 173, '0', 1, '2', 29999),
(30000, 812, 173, '30', 2, '59', 59999),
(60000, 813, 173, '600', 3, '999', 99999),
(0, 814, 174, '0', 1, '1', 19999),
(20000, 815, 174, '20', 2, '79', 79999),
(80000, 816, 174, '800', 3, '999', 99999),
(0, 817, 175, '0', 1, '2', 29999),
(30000, 818, 175, '30', 2, '59', 59999),
(60000, 819, 175, '600', 3, '699', 69999),
(70000, 820, 175, '7', 1, '8', 89999),
(90000, 821, 175, '90', 2, '99', 99999),
(0, 822, 176, '0', 1, '0', 9999),
(10000, 823, 176, '10', 2, '59', 59999),
(60000, 824, 176, '600', 3, '999', 99999),
(0, 825, 177, '0', 1, '1', 19999),
(20000, 826, 177, '20', 2, '59', 59999),
(60000, 827, 177, '600', 3, '999', 99999),
(0, 828, 178, '0', 1, '1', 19999),
(20000, 829, 178, '20', 2, '59', 59999),
(60000, 830, 178, '600', 3, '899', 89999),
(90000, 831, 178, '90', 2, '99', 99999),
(0, 832, 179, '0', 1, '5', 59999),
(60000, 833, 179, '60', 2, '89', 89999),
(90000, 834, 179, '900', 3, '999', 99999),
(0, 835, 180, '0', 1, '0', 9999),
(10000, 836, 180, '10', 2, '69', 69999),
(70000, 837, 180, '700', 3, '999', 99999),
(0, 838, 181, '0', 1, '2', 29999),
(30000, 839, 181, '30', 2, '79', 79999),
(80000, 840, 181, '800', 3, '999', 99999),
(0, 841, 182, '0', 1, '4', 49999),
(50000, 842, 182, '50', 2, '79', 79999),
(80000, 843, 182, '800', 3, '999', 99999),
(0, 844, 183, '0', 1, '2', 29999),
(30000, 845, 183, '30', 2, '59', 59999),
(60000, 846, 183, '600', 3, '999', 99999),
(0, 847, 184, '0', 1, '4', 49999),
(50000, 848, 184, '50', 2, '79', 79999),
(80000, 849, 184, '800', 3, '999', 99999),
(0, 850, 185, '0', 1, '5', 59999),
(60000, 851, 185, '60', 2, '89', 89999),
(90000, 852, 185, '900', 3, '999', 99999),
(0, 853, 186, '0', 1, '2', 29999),
(30000, 854, 186, '30', 2, '59', 59999),
(60000, 855, 186, '600', 3, '999', 99999),
(0, 856, 187, '0', 1, '2', 29999),
(30000, 857, 187, '30', 2, '69', 69999),
(70000, 858, 187, '700', 3, '999', 99999),
(0, 859, 188, '0', 1, '4', 49999),
(50000, 860, 188, '50', 2, '79', 79999),
(80000, 861, 188, '800', 3, '999', 99999),
(0, 862, 189, '0', 1, '1', 19999),
(20000, 863, 189, '20', 2, '89', 89999),
(90000, 864, 189, '900', 3, '999', 99999),
(0, 865, 190, '0', 1, '4', 49999),
(50000, 866, 190, '50', 2, '79', 79999),
(80000, 867, 190, '800', 3, '999', 99999),
(0, 868, 192, '0', 1, '4', 49999),
(50000, 869, 192, '50', 2, '79', 79999),
(80000, 870, 192, '800', 3, '999', 99999),
(0, 871, 193, '0', 1, '2', 29999),
(30000, 872, 193, '30', 2, '79', 79999),
(80000, 873, 193, '800', 3, '939', 93999),
(94000, 874, 193, '94', 2, '99', 99999),
(0, 875, 194, '0', 1, '2', 29999),
(30000, 876, 194, '30', 2, '69', 69999),
(70000, 877, 194, '700', 3, '999', 99999),
(0, 878, 195, '0', 1, '1', 19999),
(20000, 879, 195, '20', 2, '59', 59999),
(60000, 880, 195, '600', 3, '799', 79999),
(80000, 881, 195, '80', 2, '89', 89999),
(90000, 882, 195, '90', 2, '99', 99999),
(0, 883, 196, '00', 2, '59', 59999),
(60000, 884, 196, '600', 3, '859', 85999),
(86000, 885, 196, '86', 2, '99', 99999),
(0, 886, 197, '0', 1, '1', 19999),
(20000, 887, 197, '20', 2, '79', 79999),
(80000, 888, 197, '800', 3, '999', 99999),
(0, 889, 198, '0', 1, '4', 49999),
(50000, 890, 198, '50', 2, '94', 94999),
(95000, 891, 198, '950', 3, '999', 99999),
(0, 892, 199, '0', 1, '2', 29999),
(30000, 893, 199, '30', 2, '59', 59999),
(60000, 894, 199, '600', 3, '999', 99999),
(0, 895, 200, '0', 1, '0', 9999),
(10000, 896, 200, '10', 2, '94', 94999),
(95000, 897, 200, '950', 3, '999', 99999),
(0, 898, 201, '0', 1, '3', 39999),
(40000, 899, 201, '40', 2, '89', 89999),
(90000, 900, 201, '900', 3, '999', 99999),
(0, 901, 202, '0', 1, '4', 49999),
(50000, 902, 202, '50', 2, '79', 79999),
(80000, 903, 202, '800', 3, '999', 99999),
(0, 904, 203, '00', 2, '49', 49999),
(50000, 905, 203, '500', 3, '999', 99999),
(0, 906, 204, '0', 1, '1', 19999),
(20000, 907, 204, '20', 2, '79', 79999),
(80000, 908, 204, '800', 3, '999', 99999),
(0, 909, 205, '0', 1, '3', 39999),
(40000, 910, 205, '40', 2, '79', 79999),
(80000, 911, 205, '800', 3, '999', 99999),
(0, 912, 206, '0', 1, '2', 29999),
(30000, 913, 206, '30', 2, '69', 69999),
(70000, 914, 206, '700', 3, '799', 79999),
(0, 915, 207, '0', 1, '1', 19999),
(20000, 916, 207, '20', 2, '59', 59999),
(60000, 917, 207, '600', 3, '899', 89999),
(0, 918, 208, '0', 1, '3', 39999),
(40000, 919, 208, '400', 3, '599', 59999),
(60000, 920, 208, '60', 2, '89', 89999),
(90000, 921, 208, '900', 3, '999', 99999),
(0, 922, 209, '00', 2, '19', 19999),
(20000, 923, 209, '200', 3, '699', 69999),
(70000, 924, 209, '7000', 4, '8999', 89999),
(90000, 925, 209, '90000', 5, '97599', 97599),
(97600, 926, 209, '976000', 6, '999999', 99999);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezkeyword`
--

DROP TABLE IF EXISTS `ezkeyword`;
CREATE TABLE IF NOT EXISTS `ezkeyword` (
  `class_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `keyword` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezkeyword_attribute_link`
--

DROP TABLE IF EXISTS `ezkeyword_attribute_link`;
CREATE TABLE IF NOT EXISTS `ezkeyword_attribute_link` (
  `id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL DEFAULT '0',
  `objectattribute_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezmedia`
--

DROP TABLE IF EXISTS `ezmedia`;
CREATE TABLE IF NOT EXISTS `ezmedia` (
  `contentobject_attribute_id` int(11) NOT NULL DEFAULT '0',
  `controls` varchar(50) DEFAULT NULL,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `has_controller` int(11) DEFAULT '0',
  `height` int(11) DEFAULT NULL,
  `is_autoplay` int(11) DEFAULT '0',
  `is_loop` int(11) DEFAULT '0',
  `mime_type` varchar(50) NOT NULL DEFAULT '',
  `original_filename` varchar(255) NOT NULL DEFAULT '',
  `pluginspage` varchar(255) DEFAULT NULL,
  `quality` varchar(50) DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0',
  `width` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezmessage`
--

DROP TABLE IF EXISTS `ezmessage`;
CREATE TABLE IF NOT EXISTS `ezmessage` (
  `body` longtext,
  `destination_address` varchar(50) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `is_sent` int(11) NOT NULL DEFAULT '0',
  `send_method` varchar(50) NOT NULL DEFAULT '',
  `send_time` varchar(50) NOT NULL DEFAULT '',
  `send_weekday` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezmodule_run`
--

DROP TABLE IF EXISTS `ezmodule_run`;
CREATE TABLE IF NOT EXISTS `ezmodule_run` (
  `function_name` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `module_data` longtext,
  `module_name` varchar(255) DEFAULT NULL,
  `workflow_process_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezmultipricedata`
--

DROP TABLE IF EXISTS `ezmultipricedata`;
CREATE TABLE IF NOT EXISTS `ezmultipricedata` (
  `contentobject_attr_id` int(11) NOT NULL DEFAULT '0',
  `contentobject_attr_version` int(11) NOT NULL DEFAULT '0',
  `currency_code` varchar(4) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `value` decimal(15,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eznode_assignment`
--

DROP TABLE IF EXISTS `eznode_assignment`;
CREATE TABLE IF NOT EXISTS `eznode_assignment` (
  `contentobject_id` int(11) DEFAULT NULL,
  `contentobject_version` int(11) DEFAULT NULL,
  `from_node_id` int(11) DEFAULT '0',
  `id` int(11) NOT NULL,
  `is_main` int(11) NOT NULL DEFAULT '0',
  `op_code` int(11) NOT NULL DEFAULT '0',
  `parent_node` int(11) DEFAULT NULL,
  `parent_remote_id` varchar(100) NOT NULL DEFAULT '',
  `remote_id` varchar(100) NOT NULL DEFAULT '0',
  `sort_field` int(11) DEFAULT '1',
  `sort_order` int(11) DEFAULT '1',
  `priority` int(11) NOT NULL DEFAULT '0',
  `is_hidden` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `eznode_assignment`
--

INSERT INTO `eznode_assignment` (`contentobject_id`, `contentobject_version`, `from_node_id`, `id`, `is_main`, `op_code`, `parent_node`, `parent_remote_id`, `remote_id`, `sort_field`, `sort_order`, `priority`, `is_hidden`) VALUES
(8, 2, 0, 4, 1, 2, 5, '', '0', 1, 1, 0, 0),
(42, 1, 0, 5, 1, 2, 5, '', '0', 9, 1, 0, 0),
(10, 2, -1, 6, 1, 2, 44, '', '0', 9, 1, 0, 0),
(4, 1, 0, 7, 1, 2, 1, '', '0', 1, 1, 0, 0),
(12, 1, 0, 8, 1, 2, 5, '', '0', 1, 1, 0, 0),
(13, 1, 0, 9, 1, 2, 5, '', '0', 1, 1, 0, 0),
(41, 1, 0, 11, 1, 2, 1, '', '0', 1, 1, 0, 0),
(11, 1, 0, 12, 1, 2, 5, '', '0', 1, 1, 0, 0),
(45, 1, -1, 16, 1, 2, 1, '', '0', 9, 1, 0, 0),
(49, 1, 0, 27, 1, 2, 43, '', '0', 9, 1, 0, 0),
(50, 1, 0, 28, 1, 2, 43, '', '0', 9, 1, 0, 0),
(51, 1, 0, 29, 1, 2, 43, '', '0', 9, 1, 0, 0),
(52, 1, 0, 30, 1, 2, 48, '', '0', 1, 1, 0, 0),
(56, 1, 0, 34, 1, 2, 1, '', '0', 2, 0, 0, 0),
(14, 3, -1, 38, 1, 2, 13, '', '0', 1, 1, 0, 0),
(54, 2, -1, 39, 1, 2, 58, '', '0', 1, 1, 0, 0),
(1, 6, -1, 42, 1, 2, 1, '', '0', 8, 1, 0, 0),
(1, 7, -1, 43, 1, 2, 1, 'f3e90596361e31d496d4026eb624c983', '0', 8, 1, 0, 0),
(41, 2, -1, 44, 1, 2, 1, '75c715a51699d2d309a924eca6a95145', '0', 9, 1, 0, 0),
(50, 2, -1, 45, 1, 2, 43, '0b113a208f7890f9ad3c24444ff5988c', '0', 9, 1, 0, 0),
(49, 2, -1, 46, 1, 2, 43, '1b26c0454b09bb49dfb1b9190ffd67cb', '0', 9, 1, 0, 0),
(51, 2, -1, 47, 1, 2, 43, '4f18b82c75f10aad476cae5adf98c11f', '0', 9, 1, 0, 0),
(4, 2, -1, 48, 1, 2, 1, '3f6d92f8044aed134f32153517850f5a', '0', 1, 1, 0, 0),
(11, 2, -1, 49, 1, 2, 5, '602dcf84765e56b7f999eaafd3821dd3', '0', 1, 1, 0, 0),
(12, 2, -1, 50, 1, 2, 5, '769380b7aa94541679167eab817ca893', '0', 1, 1, 0, 0),
(13, 2, -1, 51, 1, 2, 5, 'f7dda2854fc68f7c8455d9cb14bd04a9', '0', 1, 1, 0, 0),
(42, 2, -1, 52, 1, 2, 5, '4fdf0072da953bb276c0c7e0141c5c9b', '0', 9, 1, 0, 0),
(10, 3, -1, 53, 1, 2, 44, '2cf8343bee7b482bab82b269d8fecd76', '0', 9, 1, 0, 0),
(14, 4, -1, 54, 1, 2, 13, 'e5161a99f733200b9ed4e80f9c16187b', '0', 1, 1, 0, 0),
(57, 1, 0, 55, 1, 2, 2, '042674aaac414e8dfc3f780359011c9a', '0', 8, 1, 0, 0),
(57, 2, -1, 56, 1, 2, 2, '042674aaac414e8dfc3f780359011c9a', '0', 8, 1, 0, 0),
(57, 3, -1, 57, 1, 2, 2, '042674aaac414e8dfc3f780359011c9a', '0', 8, 1, 0, 0),
(57, 4, -1, 58, 1, 2, 2, '042674aaac414e8dfc3f780359011c9a', '0', 8, 1, 0, 0),
(58, 1, 0, 59, 1, 2, 59, 'f6d9fbcd0fd8738e5f0a82100984fceb', '0', 8, 1, 0, 0),
(66, 1, 0, 72, 1, 2, 59, '2cc30cbdbca580d9dd4a3b6f7cb64430', '0', 8, 1, 0, 0),
(60, 1, 0, 61, 1, 2, 60, '32074651924dc60ddb512e5d1d054b38', '0', 8, 1, 0, 0),
(61, 1, 0, 62, 1, 2, 60, 'ab034e5d96d906ce56b6046d36de5add', '0', 8, 1, 0, 0),
(62, 1, 0, 64, 1, 5, 66, 'e98bae5619efc4c5694fd7ee42d734c5', '0', 8, 1, 0, 0),
(64, 1, 0, 66, 1, 5, 66, '535a571ebc853aedc4859155c044f200', '0', 8, 1, 0, 0),
(58, 2, -1, 67, 1, 2, 59, 'f6d9fbcd0fd8738e5f0a82100984fceb', '0', 8, 1, 0, 0),
(58, 3, -1, 68, 1, 2, 59, 'f6d9fbcd0fd8738e5f0a82100984fceb', '0', 8, 1, 0, 0),
(65, 2, -1, 71, 1, 2, 59, '6baf89f569698eb93e8b434b090aff66', '0', 8, 1, 0, 0),
(65, 1, 0, 70, 1, 2, 59, '6baf89f569698eb93e8b434b090aff66', '0', 8, 1, 0, 0),
(66, 2, -1, 73, 1, 2, 59, '2cc30cbdbca580d9dd4a3b6f7cb64430', '0', 8, 1, 0, 0),
(66, 3, -1, 74, 1, 2, 59, '2cc30cbdbca580d9dd4a3b6f7cb64430', '0', 8, 1, 0, 0),
(60, 2, -1, 75, 1, 2, 60, '32074651924dc60ddb512e5d1d054b38', '0', 8, 1, 0, 0),
(61, 2, -1, 76, 1, 2, 60, 'ab034e5d96d906ce56b6046d36de5add', '0', 8, 1, 0, 0),
(62, 2, -1, 77, 1, 2, 66, 'e98bae5619efc4c5694fd7ee42d734c5', '0', 8, 1, 0, 0),
(64, 2, -1, 78, 1, 2, 66, '535a571ebc853aedc4859155c044f200', '0', 8, 1, 0, 0),
(58, 4, -1, 79, 1, 2, 59, 'f6d9fbcd0fd8738e5f0a82100984fceb', '0', 8, 1, 0, 0),
(58, 5, -1, 80, 1, 2, 59, 'f6d9fbcd0fd8738e5f0a82100984fceb', '0', 8, 1, 0, 0),
(67, 1, 0, 81, 1, 2, 60, 'd085b1e8d68acb766bb45177b2340e5f', '0', 8, 1, 0, 0),
(67, 2, -1, 82, 1, 2, 60, 'd085b1e8d68acb766bb45177b2340e5f', '0', 8, 1, 0, 0),
(67, 3, -1, 83, 1, 2, 60, 'd085b1e8d68acb766bb45177b2340e5f', '0', 8, 1, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eznotificationcollection`
--

DROP TABLE IF EXISTS `eznotificationcollection`;
CREATE TABLE IF NOT EXISTS `eznotificationcollection` (
  `data_subject` longtext NOT NULL,
  `data_text` longtext NOT NULL,
  `event_id` int(11) NOT NULL DEFAULT '0',
  `handler` varchar(255) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `transport` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eznotificationcollection_item`
--

DROP TABLE IF EXISTS `eznotificationcollection_item`;
CREATE TABLE IF NOT EXISTS `eznotificationcollection_item` (
  `address` varchar(255) NOT NULL DEFAULT '',
  `collection_id` int(11) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `send_date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eznotificationevent`
--

DROP TABLE IF EXISTS `eznotificationevent`;
CREATE TABLE IF NOT EXISTS `eznotificationevent` (
  `data_int1` int(11) NOT NULL DEFAULT '0',
  `data_int2` int(11) NOT NULL DEFAULT '0',
  `data_int3` int(11) NOT NULL DEFAULT '0',
  `data_int4` int(11) NOT NULL DEFAULT '0',
  `data_text1` longtext NOT NULL,
  `data_text2` longtext NOT NULL,
  `data_text3` longtext NOT NULL,
  `data_text4` longtext NOT NULL,
  `event_type_string` varchar(255) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `eznotificationevent`
--

INSERT INTO `eznotificationevent` (`data_int1`, `data_int2`, `data_int3`, `data_int4`, `data_text1`, `data_text2`, `data_text3`, `data_text4`, `event_type_string`, `id`, `status`) VALUES
(1, 7, 0, 0, '', '', '', '', 'ezpublish', 1, 0),
(41, 2, 0, 0, '', '', '', '', 'ezpublish', 2, 0),
(50, 2, 0, 0, '', '', '', '', 'ezpublish', 3, 0),
(49, 2, 0, 0, '', '', '', '', 'ezpublish', 4, 0),
(51, 2, 0, 0, '', '', '', '', 'ezpublish', 5, 0),
(4, 2, 0, 0, '', '', '', '', 'ezpublish', 6, 0),
(11, 2, 0, 0, '', '', '', '', 'ezpublish', 7, 0),
(12, 2, 0, 0, '', '', '', '', 'ezpublish', 8, 0),
(13, 2, 0, 0, '', '', '', '', 'ezpublish', 9, 0),
(42, 2, 0, 0, '', '', '', '', 'ezpublish', 10, 0),
(10, 3, 0, 0, '', '', '', '', 'ezpublish', 11, 0),
(14, 4, 0, 0, '', '', '', '', 'ezpublish', 12, 0),
(57, 1, 0, 0, '', '', '', '', 'ezpublish', 13, 0),
(57, 2, 0, 0, '', '', '', '', 'ezpublish', 14, 0),
(57, 3, 0, 0, '', '', '', '', 'ezpublish', 15, 0),
(57, 4, 0, 0, '', '', '', '', 'ezpublish', 16, 0),
(58, 1, 0, 0, '', '', '', '', 'ezpublish', 17, 0),
(59, 1, 0, 0, '', '', '', '', 'ezpublish', 18, 0),
(60, 1, 0, 0, '', '', '', '', 'ezpublish', 19, 0),
(61, 1, 0, 0, '', '', '', '', 'ezpublish', 20, 0),
(62, 1, 0, 0, '', '', '', '', 'ezpublish', 21, 0),
(64, 1, 0, 0, '', '', '', '', 'ezpublish', 22, 0),
(58, 2, 0, 0, '', '', '', '', 'ezpublish', 23, 0),
(58, 3, 0, 0, '', '', '', '', 'ezpublish', 24, 0),
(59, 2, 0, 0, '', '', '', '', 'ezpublish', 25, 0),
(65, 1, 0, 0, '', '', '', '', 'ezpublish', 26, 0),
(65, 2, 0, 0, '', '', '', '', 'ezpublish', 27, 0),
(66, 1, 0, 0, '', '', '', '', 'ezpublish', 28, 0),
(66, 2, 0, 0, '', '', '', '', 'ezpublish', 29, 0),
(66, 3, 0, 0, '', '', '', '', 'ezpublish', 30, 0),
(60, 2, 0, 0, '', '', '', '', 'ezpublish', 31, 0),
(61, 2, 0, 0, '', '', '', '', 'ezpublish', 32, 0),
(62, 2, 0, 0, '', '', '', '', 'ezpublish', 33, 0),
(64, 2, 0, 0, '', '', '', '', 'ezpublish', 34, 0),
(58, 4, 0, 0, '', '', '', '', 'ezpublish', 35, 0),
(58, 5, 0, 0, '', '', '', '', 'ezpublish', 36, 0),
(67, 1, 0, 0, '', '', '', '', 'ezpublish', 37, 0),
(67, 2, 0, 0, '', '', '', '', 'ezpublish', 38, 0),
(67, 3, 0, 0, '', '', '', '', 'ezpublish', 39, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezoperation_memento`
--

DROP TABLE IF EXISTS `ezoperation_memento`;
CREATE TABLE IF NOT EXISTS `ezoperation_memento` (
  `id` int(11) NOT NULL,
  `main` int(11) NOT NULL DEFAULT '0',
  `main_key` varchar(32) NOT NULL DEFAULT '',
  `memento_data` longtext NOT NULL,
  `memento_key` varchar(32) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezorder`
--

DROP TABLE IF EXISTS `ezorder`;
CREATE TABLE IF NOT EXISTS `ezorder` (
  `account_identifier` varchar(100) NOT NULL DEFAULT 'default',
  `created` int(11) NOT NULL DEFAULT '0',
  `data_text_1` longtext,
  `data_text_2` longtext,
  `email` varchar(150) DEFAULT '',
  `id` int(11) NOT NULL,
  `ignore_vat` int(11) NOT NULL DEFAULT '0',
  `is_archived` int(11) NOT NULL DEFAULT '0',
  `is_temporary` int(11) NOT NULL DEFAULT '1',
  `order_nr` int(11) NOT NULL DEFAULT '0',
  `productcollection_id` int(11) NOT NULL DEFAULT '0',
  `status_id` int(11) DEFAULT '0',
  `status_modified` int(11) DEFAULT '0',
  `status_modifier_id` int(11) DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezorder_item`
--

DROP TABLE IF EXISTS `ezorder_item`;
CREATE TABLE IF NOT EXISTS `ezorder_item` (
  `description` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `is_vat_inc` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `price` float DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `vat_value` float NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezorder_nr_incr`
--

DROP TABLE IF EXISTS `ezorder_nr_incr`;
CREATE TABLE IF NOT EXISTS `ezorder_nr_incr` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezorder_status`
--

DROP TABLE IF EXISTS `ezorder_status`;
CREATE TABLE IF NOT EXISTS `ezorder_status` (
  `id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL DEFAULT '',
  `status_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezorder_status`
--

INSERT INTO `ezorder_status` (`id`, `is_active`, `name`, `status_id`) VALUES
(1, 1, 'Pending', 1),
(2, 1, 'Processing', 2),
(3, 1, 'Delivered', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezorder_status_history`
--

DROP TABLE IF EXISTS `ezorder_status_history`;
CREATE TABLE IF NOT EXISTS `ezorder_status_history` (
  `id` int(11) NOT NULL,
  `modified` int(11) NOT NULL DEFAULT '0',
  `modifier_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `status_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezpackage`
--

DROP TABLE IF EXISTS `ezpackage`;
CREATE TABLE IF NOT EXISTS `ezpackage` (
  `id` int(11) NOT NULL,
  `install_date` int(11) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `version` varchar(30) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezpackage`
--

INSERT INTO `ezpackage` (`id`, `install_date`, `name`, `version`) VALUES
(1, 1301057838, 'plain_site_data', '1.0-1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezpaymentobject`
--

DROP TABLE IF EXISTS `ezpaymentobject`;
CREATE TABLE IF NOT EXISTS `ezpaymentobject` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `payment_string` varchar(255) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '0',
  `workflowprocess_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezpdf_export`
--

DROP TABLE IF EXISTS `ezpdf_export`;
CREATE TABLE IF NOT EXISTS `ezpdf_export` (
  `created` int(11) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `export_classes` varchar(255) DEFAULT NULL,
  `export_structure` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `intro_text` longtext,
  `modified` int(11) DEFAULT NULL,
  `modifier_id` int(11) DEFAULT NULL,
  `pdf_filename` varchar(255) DEFAULT NULL,
  `show_frontpage` int(11) DEFAULT NULL,
  `site_access` varchar(255) DEFAULT NULL,
  `source_node_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `sub_text` longtext,
  `title` varchar(255) DEFAULT NULL,
  `version` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezpending_actions`
--

DROP TABLE IF EXISTS `ezpending_actions`;
CREATE TABLE IF NOT EXISTS `ezpending_actions` (
  `id` int(11) NOT NULL,
  `action` varchar(64) NOT NULL DEFAULT '',
  `created` int(11) DEFAULT NULL,
  `param` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezpolicy`
--

DROP TABLE IF EXISTS `ezpolicy`;
CREATE TABLE IF NOT EXISTS `ezpolicy` (
  `function_name` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `module_name` varchar(255) DEFAULT NULL,
  `original_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=339 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezpolicy`
--

INSERT INTO `ezpolicy` (`function_name`, `id`, `module_name`, `original_id`, `role_id`) VALUES
('*', 308, '*', 0, 2),
('*', 317, 'content', 0, 3),
('login', 319, 'user', 0, 3),
('*', 330, 'ezoe', 0, 3),
('read', 336, 'content', 0, 1),
('login', 338, 'user', 0, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezpolicy_limitation`
--

DROP TABLE IF EXISTS `ezpolicy_limitation`;
CREATE TABLE IF NOT EXISTS `ezpolicy_limitation` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL DEFAULT '',
  `policy_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=263 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezpolicy_limitation`
--

INSERT INTO `ezpolicy_limitation` (`id`, `identifier`, `policy_id`) VALUES
(259, 'Section', 336),
(262, 'SiteAccess', 338);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezpolicy_limitation_value`
--

DROP TABLE IF EXISTS `ezpolicy_limitation_value`;
CREATE TABLE IF NOT EXISTS `ezpolicy_limitation_value` (
  `id` int(11) NOT NULL,
  `limitation_id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=490 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezpolicy_limitation_value`
--

INSERT INTO `ezpolicy_limitation_value` (`id`, `limitation_id`, `value`) VALUES
(485, 259, '1'),
(488, 262, '666961987'),
(489, 262, '2835931274');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezpreferences`
--

DROP TABLE IF EXISTS `ezpreferences`;
CREATE TABLE IF NOT EXISTS `ezpreferences` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `value` longtext
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezpreferences`
--

INSERT INTO `ezpreferences` (`id`, `name`, `user_id`, `value`) VALUES
(1, 'admin_navigation_class_translations', 14, '1'),
(2, 'admin_navigation_class_groups', 14, '1'),
(3, 'admin_left_menu_size', 14, '15.00000000em'),
(4, 'admin_navigation_content', 14, '1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezprest_authcode`
--

DROP TABLE IF EXISTS `ezprest_authcode`;
CREATE TABLE IF NOT EXISTS `ezprest_authcode` (
  `client_id` varchar(200) NOT NULL DEFAULT '',
  `expirytime` bigint(20) NOT NULL DEFAULT '0',
  `id` varchar(200) NOT NULL DEFAULT '',
  `scope` varchar(200) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezprest_authorized_clients`
--

DROP TABLE IF EXISTS `ezprest_authorized_clients`;
CREATE TABLE IF NOT EXISTS `ezprest_authorized_clients` (
  `created` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `rest_client_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezprest_clients`
--

DROP TABLE IF EXISTS `ezprest_clients`;
CREATE TABLE IF NOT EXISTS `ezprest_clients` (
  `client_id` varchar(200) DEFAULT NULL,
  `client_secret` varchar(200) DEFAULT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `description` longtext,
  `endpoint_uri` varchar(200) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `owner_id` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  `version` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezprest_token`
--

DROP TABLE IF EXISTS `ezprest_token`;
CREATE TABLE IF NOT EXISTS `ezprest_token` (
  `client_id` varchar(200) NOT NULL DEFAULT '',
  `expirytime` bigint(20) NOT NULL DEFAULT '0',
  `id` varchar(200) NOT NULL DEFAULT '',
  `refresh_token` varchar(200) NOT NULL DEFAULT '',
  `scope` varchar(200) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezproductcategory`
--

DROP TABLE IF EXISTS `ezproductcategory`;
CREATE TABLE IF NOT EXISTS `ezproductcategory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezproductcollection`
--

DROP TABLE IF EXISTS `ezproductcollection`;
CREATE TABLE IF NOT EXISTS `ezproductcollection` (
  `created` int(11) DEFAULT NULL,
  `currency_code` varchar(4) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezproductcollection_item`
--

DROP TABLE IF EXISTS `ezproductcollection_item`;
CREATE TABLE IF NOT EXISTS `ezproductcollection_item` (
  `contentobject_id` int(11) NOT NULL DEFAULT '0',
  `discount` float DEFAULT NULL,
  `id` int(11) NOT NULL,
  `is_vat_inc` int(11) DEFAULT NULL,
  `item_count` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `price` float DEFAULT '0',
  `productcollection_id` int(11) NOT NULL DEFAULT '0',
  `vat_value` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezproductcollection_item_opt`
--

DROP TABLE IF EXISTS `ezproductcollection_item_opt`;
CREATE TABLE IF NOT EXISTS `ezproductcollection_item_opt` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `object_attribute_id` int(11) DEFAULT NULL,
  `option_item_id` int(11) NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezpublishingqueueprocesses`
--

DROP TABLE IF EXISTS `ezpublishingqueueprocesses`;
CREATE TABLE IF NOT EXISTS `ezpublishingqueueprocesses` (
  `created` int(11) DEFAULT NULL,
  `ezcontentobject_version_id` int(11) NOT NULL DEFAULT '0',
  `finished` int(11) DEFAULT NULL,
  `pid` int(8) DEFAULT NULL,
  `started` int(11) DEFAULT NULL,
  `status` int(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezrole`
--

DROP TABLE IF EXISTS `ezrole`;
CREATE TABLE IF NOT EXISTS `ezrole` (
  `id` int(11) NOT NULL,
  `is_new` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` char(1) DEFAULT NULL,
  `version` int(11) DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezrole`
--

INSERT INTO `ezrole` (`id`, `is_new`, `name`, `value`, `version`) VALUES
(1, 0, 'Anonymous', '', 0),
(2, 0, 'Administrator', '*', 0),
(3, 0, 'Editor', '', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezrss_export`
--

DROP TABLE IF EXISTS `ezrss_export`;
CREATE TABLE IF NOT EXISTS `ezrss_export` (
  `access_url` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `description` longtext,
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `main_node_only` int(11) NOT NULL DEFAULT '1',
  `modified` int(11) DEFAULT NULL,
  `modifier_id` int(11) DEFAULT NULL,
  `node_id` int(11) DEFAULT NULL,
  `number_of_objects` int(11) NOT NULL DEFAULT '0',
  `rss_version` varchar(255) DEFAULT NULL,
  `site_access` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezrss_export_item`
--

DROP TABLE IF EXISTS `ezrss_export_item`;
CREATE TABLE IF NOT EXISTS `ezrss_export_item` (
  `category` varchar(255) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `enclosure` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `rssexport_id` int(11) DEFAULT NULL,
  `source_node_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `subnodes` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezrss_import`
--

DROP TABLE IF EXISTS `ezrss_import`;
CREATE TABLE IF NOT EXISTS `ezrss_import` (
  `active` int(11) DEFAULT NULL,
  `class_description` varchar(255) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `class_title` varchar(255) DEFAULT NULL,
  `class_url` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `destination_node_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `import_description` longtext NOT NULL,
  `modified` int(11) DEFAULT NULL,
  `modifier_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `object_owner_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `url` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezscheduled_script`
--

DROP TABLE IF EXISTS `ezscheduled_script`;
CREATE TABLE IF NOT EXISTS `ezscheduled_script` (
  `command` varchar(255) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `last_report_timestamp` int(11) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `process_id` int(11) NOT NULL DEFAULT '0',
  `progress` int(3) DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezsearch_object_word_link`
--

DROP TABLE IF EXISTS `ezsearch_object_word_link`;
CREATE TABLE IF NOT EXISTS `ezsearch_object_word_link` (
  `contentclass_attribute_id` int(11) NOT NULL DEFAULT '0',
  `contentclass_id` int(11) NOT NULL DEFAULT '0',
  `contentobject_id` int(11) NOT NULL DEFAULT '0',
  `frequency` float NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `identifier` varchar(255) NOT NULL DEFAULT '',
  `integer_value` int(11) NOT NULL DEFAULT '0',
  `next_word_id` int(11) NOT NULL DEFAULT '0',
  `placement` int(11) NOT NULL DEFAULT '0',
  `prev_word_id` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '0',
  `section_id` int(11) NOT NULL DEFAULT '0',
  `word_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=6345 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezsearch_object_word_link`
--

INSERT INTO `ezsearch_object_word_link` (`contentclass_attribute_id`, `contentclass_id`, `contentobject_id`, `frequency`, `id`, `identifier`, `integer_value`, `next_word_id`, `placement`, `prev_word_id`, `published`, `section_id`, `word_id`) VALUES
(156, 1, 1, 0, 4907, 'description', 0, 970, 208, 1060, 1033917596, 1, 1061),
(156, 1, 1, 0, 4906, 'description', 0, 1061, 207, 1059, 1033917596, 1, 1060),
(156, 1, 1, 0, 4905, 'description', 0, 1060, 206, 1058, 1033917596, 1, 1059),
(156, 1, 1, 0, 4904, 'description', 0, 1059, 205, 1057, 1033917596, 1, 1058),
(156, 1, 1, 0, 4903, 'description', 0, 1058, 204, 1056, 1033917596, 1, 1057),
(156, 1, 1, 0, 4902, 'description', 0, 1057, 203, 972, 1033917596, 1, 1056),
(156, 1, 1, 0, 4901, 'description', 0, 1056, 202, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4900, 'description', 0, 972, 201, 814, 1033917596, 1, 971),
(156, 1, 1, 0, 4899, 'description', 0, 971, 200, 1055, 1033917596, 1, 814),
(156, 1, 1, 0, 4898, 'description', 0, 814, 199, 1054, 1033917596, 1, 1055),
(156, 1, 1, 0, 4897, 'description', 0, 1055, 198, 991, 1033917596, 1, 1054),
(156, 1, 1, 0, 4896, 'description', 0, 1054, 197, 1053, 1033917596, 1, 991),
(156, 1, 1, 0, 4895, 'description', 0, 991, 196, 972, 1033917596, 1, 1053),
(156, 1, 1, 0, 4894, 'description', 0, 1053, 195, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4893, 'description', 0, 972, 194, 978, 1033917596, 1, 971),
(156, 1, 1, 0, 4892, 'description', 0, 971, 193, 1052, 1033917596, 1, 978),
(156, 1, 1, 0, 4891, 'description', 0, 978, 192, 1051, 1033917596, 1, 1052),
(156, 1, 1, 0, 4890, 'description', 0, 1052, 191, 1050, 1033917596, 1, 1051),
(156, 1, 1, 0, 4889, 'description', 0, 1051, 190, 1049, 1033917596, 1, 1050),
(156, 1, 1, 0, 4888, 'description', 0, 1050, 189, 1043, 1033917596, 1, 1049),
(156, 1, 1, 0, 4887, 'description', 0, 1049, 188, 1028, 1033917596, 1, 1043),
(156, 1, 1, 0, 4886, 'description', 0, 1043, 187, 1048, 1033917596, 1, 1028),
(156, 1, 1, 0, 4885, 'description', 0, 1028, 186, 1042, 1033917596, 1, 1048),
(156, 1, 1, 0, 4884, 'description', 0, 1048, 185, 1047, 1033917596, 1, 1042),
(156, 1, 1, 0, 4883, 'description', 0, 1042, 184, 1002, 1033917596, 1, 1047),
(156, 1, 1, 0, 4882, 'description', 0, 1047, 183, 1030, 1033917596, 1, 1002),
(156, 1, 1, 0, 4881, 'description', 0, 1002, 182, 1029, 1033917596, 1, 1030),
(156, 1, 1, 0, 4880, 'description', 0, 1030, 181, 1001, 1033917596, 1, 1029),
(156, 1, 1, 0, 4879, 'description', 0, 1029, 180, 998, 1033917596, 1, 1001),
(156, 1, 1, 0, 4878, 'description', 0, 1001, 179, 997, 1033917596, 1, 998),
(156, 1, 1, 0, 4877, 'description', 0, 998, 178, 996, 1033917596, 1, 997),
(156, 1, 1, 0, 4876, 'description', 0, 997, 177, 972, 1033917596, 1, 996),
(156, 1, 1, 0, 4875, 'description', 0, 996, 176, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4874, 'description', 0, 972, 175, 814, 1033917596, 1, 971),
(156, 1, 1, 0, 4873, 'description', 0, 971, 174, 981, 1033917596, 1, 814),
(156, 1, 1, 0, 4872, 'description', 0, 814, 173, 1046, 1033917596, 1, 981),
(156, 1, 1, 0, 4871, 'description', 0, 981, 172, 1045, 1033917596, 1, 1046),
(156, 1, 1, 0, 4870, 'description', 0, 1046, 171, 999, 1033917596, 1, 1045),
(156, 1, 1, 0, 4869, 'description', 0, 1045, 170, 812, 1033917596, 1, 999),
(156, 1, 1, 0, 4868, 'description', 0, 999, 169, 814, 1033917596, 1, 812),
(156, 1, 1, 0, 4867, 'description', 0, 812, 168, 970, 1033917596, 1, 814),
(156, 1, 1, 0, 4866, 'description', 0, 814, 167, 1044, 1033917596, 1, 970),
(156, 1, 1, 0, 4865, 'description', 0, 970, 166, 1043, 1033917596, 1, 1044),
(156, 1, 1, 0, 4864, 'description', 0, 1044, 165, 877, 1033917596, 1, 1043),
(156, 1, 1, 0, 4863, 'description', 0, 1043, 164, 1042, 1033917596, 1, 877),
(156, 1, 1, 0, 4862, 'description', 0, 877, 163, 1040, 1033917596, 1, 1042),
(156, 1, 1, 0, 4861, 'description', 0, 1042, 162, 972, 1033917596, 1, 1040),
(156, 1, 1, 0, 4860, 'description', 0, 1040, 161, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4859, 'description', 0, 972, 160, 814, 1033917596, 1, 971),
(156, 1, 1, 0, 4858, 'description', 0, 971, 159, 1041, 1033917596, 1, 814),
(156, 1, 1, 0, 4857, 'description', 0, 814, 158, 999, 1033917596, 1, 1041),
(156, 1, 1, 0, 4856, 'description', 0, 1041, 157, 1040, 1033917596, 1, 999),
(156, 1, 1, 0, 4855, 'description', 0, 999, 156, 1008, 1033917596, 1, 1040),
(156, 1, 1, 0, 4854, 'description', 0, 1040, 155, 1002, 1033917596, 1, 1008),
(156, 1, 1, 0, 4853, 'description', 0, 1008, 154, 1039, 1033917596, 1, 1002),
(156, 1, 1, 0, 4852, 'description', 0, 1002, 153, 978, 1033917596, 1, 1039),
(156, 1, 1, 0, 4851, 'description', 0, 1039, 152, 1038, 1033917596, 1, 978),
(156, 1, 1, 0, 4850, 'description', 0, 978, 151, 999, 1033917596, 1, 1038),
(156, 1, 1, 0, 4849, 'description', 0, 1038, 150, 1037, 1033917596, 1, 999),
(156, 1, 1, 0, 4848, 'description', 0, 999, 149, 1036, 1033917596, 1, 1037),
(156, 1, 1, 0, 4847, 'description', 0, 1037, 148, 1035, 1033917596, 1, 1036),
(156, 1, 1, 0, 4846, 'description', 0, 1036, 147, 1010, 1033917596, 1, 1035),
(156, 1, 1, 0, 4845, 'description', 0, 1035, 146, 1034, 1033917596, 1, 1010),
(156, 1, 1, 0, 4844, 'description', 0, 1010, 145, 1009, 1033917596, 1, 1034),
(156, 1, 1, 0, 4843, 'description', 0, 1034, 144, 972, 1033917596, 1, 1009),
(156, 1, 1, 0, 4842, 'description', 0, 1009, 143, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4841, 'description', 0, 972, 142, 1033, 1033917596, 1, 971),
(156, 1, 1, 0, 4840, 'description', 0, 971, 141, 994, 1033917596, 1, 1033),
(156, 1, 1, 0, 4839, 'description', 0, 1033, 140, 1032, 1033917596, 1, 994),
(156, 1, 1, 0, 4838, 'description', 0, 994, 139, 981, 1033917596, 1, 1032),
(156, 1, 1, 0, 4837, 'description', 0, 1032, 138, 1031, 1033917596, 1, 981),
(156, 1, 1, 0, 4836, 'description', 0, 981, 137, 1030, 1033917596, 1, 1031),
(156, 1, 1, 0, 4835, 'description', 0, 1031, 136, 1029, 1033917596, 1, 1030),
(156, 1, 1, 0, 4834, 'description', 0, 1030, 135, 982, 1033917596, 1, 1029),
(156, 1, 1, 0, 4833, 'description', 0, 1029, 134, 1028, 1033917596, 1, 982),
(156, 1, 1, 0, 4832, 'description', 0, 982, 133, 1027, 1033917596, 1, 1028),
(156, 1, 1, 0, 4831, 'description', 0, 1028, 132, 999, 1033917596, 1, 1027),
(156, 1, 1, 0, 4830, 'description', 0, 1027, 131, 1026, 1033917596, 1, 999),
(156, 1, 1, 0, 4829, 'description', 0, 999, 130, 1025, 1033917596, 1, 1026),
(156, 1, 1, 0, 4828, 'description', 0, 1026, 129, 1024, 1033917596, 1, 1025),
(156, 1, 1, 0, 4827, 'description', 0, 1025, 128, 1023, 1033917596, 1, 1024),
(156, 1, 1, 0, 4826, 'description', 0, 1024, 127, 1022, 1033917596, 1, 1023),
(156, 1, 1, 0, 4825, 'description', 0, 1023, 126, 1021, 1033917596, 1, 1022),
(156, 1, 1, 0, 4824, 'description', 0, 1022, 125, 1020, 1033917596, 1, 1021),
(156, 1, 1, 0, 4823, 'description', 0, 1021, 124, 1019, 1033917596, 1, 1020),
(156, 1, 1, 0, 4822, 'description', 0, 1020, 123, 978, 1033917596, 1, 1019),
(156, 1, 1, 0, 4821, 'description', 0, 1019, 122, 987, 1033917596, 1, 978),
(156, 1, 1, 0, 4820, 'description', 0, 978, 121, 1018, 1033917596, 1, 987),
(156, 1, 1, 0, 4819, 'description', 0, 987, 120, 1017, 1033917596, 1, 1018),
(156, 1, 1, 0, 4818, 'description', 0, 1018, 119, 979, 1033917596, 1, 1017),
(156, 1, 1, 0, 4817, 'description', 0, 1017, 118, 970, 1033917596, 1, 979),
(156, 1, 1, 0, 4816, 'description', 0, 979, 117, 1016, 1033917596, 1, 970),
(156, 1, 1, 0, 4815, 'description', 0, 970, 116, 1015, 1033917596, 1, 1016),
(156, 1, 1, 0, 4814, 'description', 0, 1016, 115, 979, 1033917596, 1, 1015),
(156, 1, 1, 0, 4813, 'description', 0, 1015, 114, 1014, 1033917596, 1, 979),
(156, 1, 1, 0, 4812, 'description', 0, 979, 113, 1013, 1033917596, 1, 1014),
(156, 1, 1, 0, 4811, 'description', 0, 1014, 112, 1012, 1033917596, 1, 1013),
(156, 1, 1, 0, 4810, 'description', 0, 1013, 111, 970, 1033917596, 1, 1012),
(156, 1, 1, 0, 4809, 'description', 0, 1012, 110, 1011, 1033917596, 1, 970),
(156, 1, 1, 0, 4808, 'description', 0, 970, 109, 1010, 1033917596, 1, 1011),
(156, 1, 1, 0, 4807, 'description', 0, 1011, 108, 1009, 1033917596, 1, 1010),
(156, 1, 1, 0, 4806, 'description', 0, 1010, 107, 1002, 1033917596, 1, 1009),
(156, 1, 1, 0, 4805, 'description', 0, 1009, 106, 1008, 1033917596, 1, 1002),
(156, 1, 1, 0, 4804, 'description', 0, 1002, 105, 1007, 1033917596, 1, 1008),
(156, 1, 1, 0, 4803, 'description', 0, 1008, 104, 1006, 1033917596, 1, 1007),
(156, 1, 1, 0, 4802, 'description', 0, 1007, 103, 999, 1033917596, 1, 1006),
(156, 1, 1, 0, 4801, 'description', 0, 1006, 102, 1005, 1033917596, 1, 999),
(156, 1, 1, 0, 4800, 'description', 0, 999, 101, 1004, 1033917596, 1, 1005),
(156, 1, 1, 0, 4799, 'description', 0, 1005, 100, 981, 1033917596, 1, 1004),
(156, 1, 1, 0, 4798, 'description', 0, 1004, 99, 1000, 1033917596, 1, 981),
(156, 1, 1, 0, 4797, 'description', 0, 981, 98, 814, 1033917596, 1, 1000),
(156, 1, 1, 0, 4796, 'description', 0, 1000, 97, 1003, 1033917596, 1, 814),
(156, 1, 1, 0, 4795, 'description', 0, 814, 96, 1002, 1033917596, 1, 1003),
(156, 1, 1, 0, 4794, 'description', 0, 1003, 95, 1001, 1033917596, 1, 1002),
(156, 1, 1, 0, 4793, 'description', 0, 1002, 94, 1000, 1033917596, 1, 1001),
(156, 1, 1, 0, 4792, 'description', 0, 1001, 93, 999, 1033917596, 1, 1000),
(156, 1, 1, 0, 4791, 'description', 0, 1000, 92, 998, 1033917596, 1, 999),
(156, 1, 1, 0, 4790, 'description', 0, 999, 91, 997, 1033917596, 1, 998),
(156, 1, 1, 0, 4789, 'description', 0, 998, 90, 996, 1033917596, 1, 997),
(156, 1, 1, 0, 4788, 'description', 0, 997, 89, 995, 1033917596, 1, 996),
(156, 1, 1, 0, 4787, 'description', 0, 996, 88, 994, 1033917596, 1, 995),
(156, 1, 1, 0, 4786, 'description', 0, 995, 87, 993, 1033917596, 1, 994),
(156, 1, 1, 0, 4785, 'description', 0, 994, 86, 979, 1033917596, 1, 993),
(156, 1, 1, 0, 4784, 'description', 0, 993, 85, 974, 1033917596, 1, 979),
(156, 1, 1, 0, 4783, 'description', 0, 979, 84, 972, 1033917596, 1, 974),
(156, 1, 1, 0, 4782, 'description', 0, 974, 83, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4781, 'description', 0, 972, 82, 992, 1033917596, 1, 971),
(119, 1, 1, 0, 4780, 'short_description', 0, 971, 81, 814, 1033917596, 1, 992),
(119, 1, 1, 0, 4779, 'short_description', 0, 992, 80, 991, 1033917596, 1, 814),
(119, 1, 1, 0, 4778, 'short_description', 0, 814, 79, 977, 1033917596, 1, 991),
(119, 1, 1, 0, 4777, 'short_description', 0, 991, 78, 976, 1033917596, 1, 977),
(119, 1, 1, 0, 4776, 'short_description', 0, 977, 77, 990, 1033917596, 1, 976),
(119, 1, 1, 0, 4775, 'short_description', 0, 976, 76, 971, 1033917596, 1, 990),
(119, 1, 1, 0, 4774, 'short_description', 0, 990, 75, 814, 1033917596, 1, 971),
(119, 1, 1, 0, 4773, 'short_description', 0, 971, 74, 989, 1033917596, 1, 814),
(119, 1, 1, 0, 4772, 'short_description', 0, 814, 73, 988, 1033917596, 1, 989),
(119, 1, 1, 0, 4771, 'short_description', 0, 989, 72, 987, 1033917596, 1, 988),
(119, 1, 1, 0, 4770, 'short_description', 0, 988, 71, 814, 1033917596, 1, 987),
(119, 1, 1, 0, 4769, 'short_description', 0, 987, 70, 986, 1033917596, 1, 814),
(119, 1, 1, 0, 4768, 'short_description', 0, 814, 69, 985, 1033917596, 1, 986),
(119, 1, 1, 0, 4767, 'short_description', 0, 986, 68, 972, 1033917596, 1, 985),
(119, 1, 1, 0, 4766, 'short_description', 0, 985, 67, 971, 1033917596, 1, 972),
(119, 1, 1, 0, 4765, 'short_description', 0, 972, 66, 984, 1033917596, 1, 971),
(119, 1, 1, 0, 4764, 'short_description', 0, 971, 65, 983, 1033917596, 1, 984),
(119, 1, 1, 0, 4763, 'short_description', 0, 984, 64, 979, 1033917596, 1, 983),
(119, 1, 1, 0, 4762, 'short_description', 0, 983, 63, 816, 1033917596, 1, 979),
(119, 1, 1, 0, 4761, 'short_description', 0, 979, 62, 982, 1033917596, 1, 816),
(119, 1, 1, 0, 4760, 'short_description', 0, 816, 61, 972, 1033917596, 1, 982),
(119, 1, 1, 0, 4759, 'short_description', 0, 982, 60, 971, 1033917596, 1, 972),
(119, 1, 1, 0, 4758, 'short_description', 0, 972, 59, 814, 1033917596, 1, 971),
(119, 1, 1, 0, 4757, 'short_description', 0, 971, 58, 981, 1033917596, 1, 814),
(119, 1, 1, 0, 4756, 'short_description', 0, 814, 57, 812, 1033917596, 1, 981),
(119, 1, 1, 0, 4755, 'short_description', 0, 981, 56, 980, 1033917596, 1, 812),
(119, 1, 1, 0, 4754, 'short_description', 0, 812, 55, 979, 1033917596, 1, 980),
(119, 1, 1, 0, 4753, 'short_description', 0, 980, 54, 978, 1033917596, 1, 979),
(119, 1, 1, 0, 4752, 'short_description', 0, 979, 53, 977, 1033917596, 1, 978),
(119, 1, 1, 0, 4751, 'short_description', 0, 978, 52, 976, 1033917596, 1, 977),
(119, 1, 1, 0, 4750, 'short_description', 0, 977, 51, 975, 1033917596, 1, 976),
(119, 1, 1, 0, 4749, 'short_description', 0, 976, 50, 971, 1033917596, 1, 975),
(119, 1, 1, 0, 4748, 'short_description', 0, 975, 49, 974, 1033917596, 1, 971),
(119, 1, 1, 0, 4747, 'short_description', 0, 971, 48, 973, 1033917596, 1, 974),
(119, 1, 1, 0, 4746, 'short_description', 0, 974, 47, 992, 1033917596, 1, 973),
(119, 1, 1, 0, 4745, 'short_description', 0, 973, 46, 814, 1033917596, 1, 992),
(119, 1, 1, 0, 4744, 'short_description', 0, 992, 45, 991, 1033917596, 1, 814),
(119, 1, 1, 0, 4743, 'short_description', 0, 814, 44, 977, 1033917596, 1, 991),
(119, 1, 1, 0, 4742, 'short_description', 0, 991, 43, 976, 1033917596, 1, 977),
(119, 1, 1, 0, 4741, 'short_description', 0, 977, 42, 990, 1033917596, 1, 976),
(119, 1, 1, 0, 4740, 'short_description', 0, 976, 41, 971, 1033917596, 1, 990),
(119, 1, 1, 0, 4739, 'short_description', 0, 990, 40, 814, 1033917596, 1, 971),
(119, 1, 1, 0, 4738, 'short_description', 0, 971, 39, 989, 1033917596, 1, 814),
(119, 1, 1, 0, 4737, 'short_description', 0, 814, 38, 988, 1033917596, 1, 989),
(119, 1, 1, 0, 4736, 'short_description', 0, 989, 37, 987, 1033917596, 1, 988),
(119, 1, 1, 0, 4735, 'short_description', 0, 988, 36, 814, 1033917596, 1, 987),
(119, 1, 1, 0, 4734, 'short_description', 0, 987, 35, 986, 1033917596, 1, 814),
(119, 1, 1, 0, 4733, 'short_description', 0, 814, 34, 985, 1033917596, 1, 986),
(119, 1, 1, 0, 4732, 'short_description', 0, 986, 33, 972, 1033917596, 1, 985),
(119, 1, 1, 0, 4731, 'short_description', 0, 985, 32, 971, 1033917596, 1, 972),
(119, 1, 1, 0, 4730, 'short_description', 0, 972, 31, 984, 1033917596, 1, 971),
(119, 1, 1, 0, 4729, 'short_description', 0, 971, 30, 983, 1033917596, 1, 984),
(119, 1, 1, 0, 4728, 'short_description', 0, 984, 29, 979, 1033917596, 1, 983),
(119, 1, 1, 0, 4727, 'short_description', 0, 983, 28, 816, 1033917596, 1, 979),
(119, 1, 1, 0, 4726, 'short_description', 0, 979, 27, 982, 1033917596, 1, 816),
(119, 1, 1, 0, 4725, 'short_description', 0, 816, 26, 972, 1033917596, 1, 982),
(119, 1, 1, 0, 4724, 'short_description', 0, 982, 25, 971, 1033917596, 1, 972),
(119, 1, 1, 0, 4723, 'short_description', 0, 972, 24, 814, 1033917596, 1, 971),
(119, 1, 1, 0, 4722, 'short_description', 0, 971, 23, 981, 1033917596, 1, 814),
(119, 1, 1, 0, 4721, 'short_description', 0, 814, 22, 812, 1033917596, 1, 981),
(119, 1, 1, 0, 4720, 'short_description', 0, 981, 21, 980, 1033917596, 1, 812),
(119, 1, 1, 0, 4719, 'short_description', 0, 812, 20, 979, 1033917596, 1, 980),
(119, 1, 1, 0, 4718, 'short_description', 0, 980, 19, 978, 1033917596, 1, 979),
(119, 1, 1, 0, 4717, 'short_description', 0, 979, 18, 977, 1033917596, 1, 978),
(119, 1, 1, 0, 4716, 'short_description', 0, 978, 17, 976, 1033917596, 1, 977),
(119, 1, 1, 0, 4715, 'short_description', 0, 977, 16, 975, 1033917596, 1, 976),
(119, 1, 1, 0, 4714, 'short_description', 0, 976, 15, 971, 1033917596, 1, 975),
(119, 1, 1, 0, 4713, 'short_description', 0, 975, 14, 974, 1033917596, 1, 971),
(119, 1, 1, 0, 4712, 'short_description', 0, 971, 13, 973, 1033917596, 1, 974),
(119, 1, 1, 0, 4711, 'short_description', 0, 974, 12, 972, 1033917596, 1, 973),
(155, 1, 1, 0, 4710, 'short_name', 0, 973, 11, 971, 1033917596, 1, 972),
(155, 1, 1, 0, 4709, 'short_name', 0, 972, 10, 972, 1033917596, 1, 971),
(155, 1, 1, 0, 4708, 'short_name', 0, 971, 9, 971, 1033917596, 1, 972),
(155, 1, 1, 0, 4707, 'short_name', 0, 972, 8, 972, 1033917596, 1, 971),
(4, 1, 1, 0, 4706, 'name', 0, 971, 7, 971, 1033917596, 1, 972),
(4, 1, 1, 0, 4705, 'name', 0, 972, 6, 970, 1033917596, 1, 971),
(4, 1, 1, 0, 4704, 'name', 0, 971, 5, 969, 1033917596, 1, 970),
(4, 1, 1, 0, 4703, 'name', 0, 970, 4, 972, 1033917596, 1, 969),
(4, 1, 1, 0, 4702, 'name', 0, 969, 3, 971, 1033917596, 1, 972),
(4, 1, 1, 0, 4701, 'name', 0, 972, 2, 970, 1033917596, 1, 971),
(4, 1, 1, 0, 4700, 'name', 0, 971, 1, 969, 1033917596, 1, 970),
(4, 1, 1, 0, 4699, 'name', 0, 970, 0, 0, 1033917596, 1, 969),
(7, 3, 4, 0, 5267, 'description', 0, 952, 2, 930, 1033917596, 2, 1118),
(6, 3, 4, 0, 5266, 'name', 0, 1118, 1, 930, 1033917596, 2, 930),
(6, 3, 4, 0, 5265, 'name', 0, 930, 0, 0, 1033917596, 2, 930),
(12, 4, 10, 0, 5301, 'user_account', 0, 955, 4, 954, 1033920665, 2, 953),
(9, 4, 10, 0, 5300, 'last_name', 0, 953, 3, 954, 1033920665, 2, 954),
(9, 4, 10, 0, 5299, 'last_name', 0, 954, 2, 953, 1033920665, 2, 954),
(8, 4, 10, 0, 5298, 'first_name', 0, 954, 1, 953, 1033920665, 2, 953),
(8, 4, 10, 0, 5297, 'first_name', 0, 953, 0, 0, 1033920665, 2, 953),
(6, 3, 11, 0, 5272, 'name', 0, 1119, 1, 1119, 1033920746, 2, 1120),
(6, 3, 11, 0, 5271, 'name', 0, 1120, 0, 0, 1033920746, 2, 1119),
(6, 3, 12, 0, 5276, 'name', 0, 958, 1, 958, 1033920775, 2, 930),
(6, 3, 12, 0, 5275, 'name', 0, 930, 0, 0, 1033920775, 2, 958),
(6, 3, 13, 0, 5279, 'name', 0, 1121, 0, 0, 1033920794, 2, 1121),
(12, 4, 14, 0, 5311, 'user_account', 0, 955, 4, 954, 1033920830, 2, 1122),
(9, 4, 14, 0, 5310, 'last_name', 0, 1122, 3, 954, 1033920830, 2, 954),
(9, 4, 14, 0, 5309, 'last_name', 0, 954, 2, 958, 1033920830, 2, 954),
(8, 4, 14, 0, 5308, 'first_name', 0, 954, 1, 958, 1033920830, 2, 958),
(8, 4, 14, 0, 5307, 'first_name', 0, 958, 0, 0, 1033920830, 2, 958),
(4, 1, 41, 0, 5257, 'name', 0, 1114, 0, 0, 1060695457, 3, 1114),
(7, 3, 42, 0, 5287, 'description', 0, 814, 6, 952, 1072180330, 2, 816),
(7, 3, 42, 0, 5286, 'description', 0, 816, 5, 954, 1072180330, 2, 952),
(7, 3, 42, 0, 5285, 'description', 0, 952, 4, 930, 1072180330, 2, 954),
(6, 3, 42, 0, 5284, 'name', 0, 954, 3, 953, 1072180330, 2, 930),
(6, 3, 42, 0, 5283, 'name', 0, 930, 2, 930, 1072180330, 2, 953),
(6, 3, 42, 0, 5282, 'name', 0, 953, 1, 953, 1072180330, 2, 930),
(6, 3, 42, 0, 5281, 'name', 0, 930, 0, 0, 1072180330, 2, 953),
(4, 1, 45, 0, 4690, 'name', 0, 0, 0, 0, 1079684190, 4, 812),
(4, 1, 49, 0, 5261, 'name', 0, 1116, 0, 0, 1080220197, 3, 1116),
(4, 1, 50, 0, 5259, 'name', 0, 1115, 0, 0, 1080220220, 3, 1115),
(4, 1, 51, 0, 5263, 'name', 0, 1117, 0, 0, 1080220233, 3, 1117),
(159, 14, 52, 0, 4694, 'name', 0, 965, 0, 0, 1082016591, 4, 877),
(159, 14, 52, 0, 4695, 'name', 0, 966, 1, 877, 1082016591, 4, 965),
(159, 14, 52, 0, 4696, 'name', 0, 0, 2, 965, 1082016591, 4, 966),
(176, 15, 54, 0, 4697, 'id', 0, 0, 0, 0, 1082016652, 5, 967),
(4, 1, 56, 0, 4698, 'name', 0, 0, 0, 0, 1103023132, 5, 968),
(156, 1, 1, 0, 4908, 'description', 0, 1062, 209, 1061, 1033917596, 1, 970),
(156, 1, 1, 0, 4909, 'description', 0, 1063, 210, 970, 1033917596, 1, 1062),
(156, 1, 1, 0, 4910, 'description', 0, 1064, 211, 1062, 1033917596, 1, 1063),
(156, 1, 1, 0, 4911, 'description', 0, 1065, 212, 1063, 1033917596, 1, 1064),
(156, 1, 1, 0, 4912, 'description', 0, 970, 213, 1064, 1033917596, 1, 1065),
(156, 1, 1, 0, 4913, 'description', 0, 979, 214, 1065, 1033917596, 1, 970),
(156, 1, 1, 0, 4914, 'description', 0, 1066, 215, 970, 1033917596, 1, 979),
(156, 1, 1, 0, 4915, 'description', 0, 1067, 216, 979, 1033917596, 1, 1066),
(156, 1, 1, 0, 4916, 'description', 0, 1068, 217, 1066, 1033917596, 1, 1067),
(156, 1, 1, 0, 4917, 'description', 0, 1069, 218, 1067, 1033917596, 1, 1068),
(156, 1, 1, 0, 4918, 'description', 0, 814, 219, 1068, 1033917596, 1, 1069),
(156, 1, 1, 0, 4919, 'description', 0, 1040, 220, 1069, 1033917596, 1, 814),
(156, 1, 1, 0, 4920, 'description', 0, 1070, 221, 814, 1033917596, 1, 1040),
(156, 1, 1, 0, 4921, 'description', 0, 1059, 222, 1040, 1033917596, 1, 1070),
(156, 1, 1, 0, 4922, 'description', 0, 1053, 223, 1070, 1033917596, 1, 1059),
(156, 1, 1, 0, 4923, 'description', 0, 1071, 224, 1059, 1033917596, 1, 1053),
(156, 1, 1, 0, 4924, 'description', 0, 1046, 225, 1053, 1033917596, 1, 1071),
(156, 1, 1, 0, 4925, 'description', 0, 981, 226, 1071, 1033917596, 1, 1046),
(156, 1, 1, 0, 4926, 'description', 0, 814, 227, 1046, 1033917596, 1, 981),
(156, 1, 1, 0, 4927, 'description', 0, 1072, 228, 981, 1033917596, 1, 814),
(156, 1, 1, 0, 4928, 'description', 0, 971, 229, 814, 1033917596, 1, 1072),
(156, 1, 1, 0, 4929, 'description', 0, 972, 230, 1072, 1033917596, 1, 971),
(156, 1, 1, 0, 4930, 'description', 0, 1073, 231, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4931, 'description', 0, 1049, 232, 972, 1033917596, 1, 1073),
(156, 1, 1, 0, 4932, 'description', 0, 1050, 233, 1073, 1033917596, 1, 1049),
(156, 1, 1, 0, 4933, 'description', 0, 1074, 234, 1049, 1033917596, 1, 1050),
(156, 1, 1, 0, 4934, 'description', 0, 1004, 235, 1050, 1033917596, 1, 1074),
(156, 1, 1, 0, 4935, 'description', 0, 1075, 236, 1074, 1033917596, 1, 1004),
(156, 1, 1, 0, 4936, 'description', 0, 1053, 237, 1004, 1033917596, 1, 1075),
(156, 1, 1, 0, 4937, 'description', 0, 1076, 238, 1075, 1033917596, 1, 1053),
(156, 1, 1, 0, 4938, 'description', 0, 1077, 239, 1053, 1033917596, 1, 1076),
(156, 1, 1, 0, 4939, 'description', 0, 989, 240, 1076, 1033917596, 1, 1077),
(156, 1, 1, 0, 4940, 'description', 0, 1078, 241, 1077, 1033917596, 1, 989),
(156, 1, 1, 0, 4941, 'description', 0, 1079, 242, 989, 1033917596, 1, 1078),
(156, 1, 1, 0, 4942, 'description', 0, 1002, 243, 1078, 1033917596, 1, 1079),
(156, 1, 1, 0, 4943, 'description', 0, 974, 244, 1079, 1033917596, 1, 1002),
(156, 1, 1, 0, 4944, 'description', 0, 1047, 245, 1002, 1033917596, 1, 974),
(156, 1, 1, 0, 4945, 'description', 0, 1080, 246, 974, 1033917596, 1, 1047),
(156, 1, 1, 0, 4946, 'description', 0, 970, 247, 1047, 1033917596, 1, 1080),
(156, 1, 1, 0, 4947, 'description', 0, 1081, 248, 1080, 1033917596, 1, 970),
(156, 1, 1, 0, 4948, 'description', 0, 1082, 249, 970, 1033917596, 1, 1081),
(156, 1, 1, 0, 4949, 'description', 0, 816, 250, 1081, 1033917596, 1, 1082),
(156, 1, 1, 0, 4950, 'description', 0, 1083, 251, 1082, 1033917596, 1, 816),
(156, 1, 1, 0, 4951, 'description', 0, 1084, 252, 816, 1033917596, 1, 1083),
(156, 1, 1, 0, 4952, 'description', 0, 1085, 253, 1083, 1033917596, 1, 1084),
(156, 1, 1, 0, 4953, 'description', 0, 816, 254, 1084, 1033917596, 1, 1085),
(156, 1, 1, 0, 4954, 'description', 0, 1086, 255, 1085, 1033917596, 1, 816),
(156, 1, 1, 0, 4955, 'description', 0, 1087, 256, 816, 1033917596, 1, 1086),
(156, 1, 1, 0, 4956, 'description', 0, 1088, 257, 1086, 1033917596, 1, 1087),
(156, 1, 1, 0, 4957, 'description', 0, 971, 258, 1087, 1033917596, 1, 1088),
(156, 1, 1, 0, 4958, 'description', 0, 972, 259, 1088, 1033917596, 1, 971),
(156, 1, 1, 0, 4959, 'description', 0, 999, 260, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4960, 'description', 0, 1027, 261, 972, 1033917596, 1, 999),
(156, 1, 1, 0, 4961, 'description', 0, 1089, 262, 999, 1033917596, 1, 1027),
(156, 1, 1, 0, 4962, 'description', 0, 1079, 263, 1027, 1033917596, 1, 1089),
(156, 1, 1, 0, 4963, 'description', 0, 1014, 264, 1089, 1033917596, 1, 1079),
(156, 1, 1, 0, 4964, 'description', 0, 971, 265, 1079, 1033917596, 1, 1014),
(156, 1, 1, 0, 4965, 'description', 0, 1090, 266, 1014, 1033917596, 1, 971),
(156, 1, 1, 0, 4966, 'description', 0, 985, 267, 971, 1033917596, 1, 1090),
(156, 1, 1, 0, 4967, 'description', 0, 1091, 268, 1090, 1033917596, 1, 985),
(156, 1, 1, 0, 4968, 'description', 0, 927, 269, 985, 1033917596, 1, 1091),
(156, 1, 1, 0, 4969, 'description', 0, 1092, 270, 1091, 1033917596, 1, 927),
(156, 1, 1, 0, 4970, 'description', 0, 1093, 271, 927, 1033917596, 1, 1092),
(156, 1, 1, 0, 4971, 'description', 0, 930, 272, 1092, 1033917596, 1, 1093),
(156, 1, 1, 0, 4972, 'description', 0, 971, 273, 1093, 1033917596, 1, 930),
(156, 1, 1, 0, 4973, 'description', 0, 972, 274, 930, 1033917596, 1, 971),
(156, 1, 1, 0, 4974, 'description', 0, 1094, 275, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4975, 'description', 0, 988, 276, 972, 1033917596, 1, 1094),
(156, 1, 1, 0, 4976, 'description', 0, 971, 277, 1094, 1033917596, 1, 988),
(156, 1, 1, 0, 4977, 'description', 0, 972, 278, 988, 1033917596, 1, 971),
(156, 1, 1, 0, 4978, 'description', 0, 1023, 279, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4979, 'description', 0, 1095, 280, 972, 1033917596, 1, 1023),
(156, 1, 1, 0, 4980, 'description', 0, 1096, 281, 1023, 1033917596, 1, 1095),
(156, 1, 1, 0, 4981, 'description', 0, 971, 282, 1095, 1033917596, 1, 1096),
(156, 1, 1, 0, 4982, 'description', 0, 990, 283, 1096, 1033917596, 1, 971),
(156, 1, 1, 0, 4983, 'description', 0, 1096, 284, 971, 1033917596, 1, 990),
(156, 1, 1, 0, 4984, 'description', 0, 1097, 285, 990, 1033917596, 1, 1096),
(156, 1, 1, 0, 4985, 'description', 0, 1098, 286, 1096, 1033917596, 1, 1097),
(156, 1, 1, 0, 4986, 'description', 0, 930, 287, 1097, 1033917596, 1, 1098),
(156, 1, 1, 0, 4987, 'description', 0, 1099, 288, 1098, 1033917596, 1, 930),
(156, 1, 1, 0, 4988, 'description', 0, 970, 289, 930, 1033917596, 1, 1099),
(156, 1, 1, 0, 4989, 'description', 0, 1100, 290, 1099, 1033917596, 1, 970),
(156, 1, 1, 0, 4990, 'description', 0, 971, 291, 970, 1033917596, 1, 1100),
(156, 1, 1, 0, 4991, 'description', 0, 972, 292, 1100, 1033917596, 1, 971),
(156, 1, 1, 0, 4992, 'description', 0, 1101, 293, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 4993, 'description', 0, 1099, 294, 972, 1033917596, 1, 1101),
(156, 1, 1, 0, 4994, 'description', 0, 970, 295, 1101, 1033917596, 1, 1099),
(156, 1, 1, 0, 4995, 'description', 0, 1102, 296, 1099, 1033917596, 1, 970),
(156, 1, 1, 0, 4996, 'description', 0, 1103, 297, 970, 1033917596, 1, 1102),
(156, 1, 1, 0, 4997, 'description', 0, 1104, 298, 1102, 1033917596, 1, 1103),
(156, 1, 1, 0, 4998, 'description', 0, 1099, 299, 1103, 1033917596, 1, 1104),
(156, 1, 1, 0, 4999, 'description', 0, 970, 300, 1104, 1033917596, 1, 1099),
(156, 1, 1, 0, 5000, 'description', 0, 1046, 301, 1099, 1033917596, 1, 970),
(156, 1, 1, 0, 5001, 'description', 0, 1105, 302, 970, 1033917596, 1, 1046),
(156, 1, 1, 0, 5002, 'description', 0, 1106, 303, 1046, 1033917596, 1, 1105),
(156, 1, 1, 0, 5003, 'description', 0, 988, 304, 1105, 1033917596, 1, 1106),
(156, 1, 1, 0, 5004, 'description', 0, 1107, 305, 1106, 1033917596, 1, 988),
(156, 1, 1, 0, 5005, 'description', 0, 1108, 306, 988, 1033917596, 1, 1107),
(156, 1, 1, 0, 5006, 'description', 0, 1109, 307, 1107, 1033917596, 1, 1108),
(156, 1, 1, 0, 5007, 'description', 0, 970, 308, 1108, 1033917596, 1, 1109),
(156, 1, 1, 0, 5008, 'description', 0, 1110, 309, 1109, 1033917596, 1, 970),
(156, 1, 1, 0, 5009, 'description', 0, 1062, 310, 970, 1033917596, 1, 1110),
(156, 1, 1, 0, 5010, 'description', 0, 1086, 311, 1110, 1033917596, 1, 1062),
(156, 1, 1, 0, 5011, 'description', 0, 1111, 312, 1062, 1033917596, 1, 1086),
(156, 1, 1, 0, 5012, 'description', 0, 1112, 313, 1086, 1033917596, 1, 1111),
(156, 1, 1, 0, 5013, 'description', 0, 1092, 314, 1111, 1033917596, 1, 1112),
(156, 1, 1, 0, 5014, 'description', 0, 1111, 315, 1112, 1033917596, 1, 1092),
(156, 1, 1, 0, 5015, 'description', 0, 1112, 316, 1092, 1033917596, 1, 1111),
(156, 1, 1, 0, 5016, 'description', 0, 999, 317, 1111, 1033917596, 1, 1112),
(156, 1, 1, 0, 5017, 'description', 0, 1111, 318, 1112, 1033917596, 1, 999),
(156, 1, 1, 0, 5018, 'description', 0, 1112, 319, 999, 1033917596, 1, 1111),
(156, 1, 1, 0, 5019, 'description', 0, 1113, 320, 1111, 1033917596, 1, 1112),
(156, 1, 1, 0, 5020, 'description', 0, 1023, 321, 1112, 1033917596, 1, 1113),
(156, 1, 1, 0, 5021, 'description', 0, 971, 322, 1113, 1033917596, 1, 1023),
(156, 1, 1, 0, 5022, 'description', 0, 972, 323, 1023, 1033917596, 1, 971),
(156, 1, 1, 0, 5023, 'description', 0, 974, 324, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5024, 'description', 0, 979, 325, 972, 1033917596, 1, 974),
(156, 1, 1, 0, 5025, 'description', 0, 993, 326, 974, 1033917596, 1, 979),
(156, 1, 1, 0, 5026, 'description', 0, 994, 327, 979, 1033917596, 1, 993),
(156, 1, 1, 0, 5027, 'description', 0, 995, 328, 993, 1033917596, 1, 994),
(156, 1, 1, 0, 5028, 'description', 0, 996, 329, 994, 1033917596, 1, 995),
(156, 1, 1, 0, 5029, 'description', 0, 997, 330, 995, 1033917596, 1, 996),
(156, 1, 1, 0, 5030, 'description', 0, 998, 331, 996, 1033917596, 1, 997),
(156, 1, 1, 0, 5031, 'description', 0, 999, 332, 997, 1033917596, 1, 998),
(156, 1, 1, 0, 5032, 'description', 0, 1000, 333, 998, 1033917596, 1, 999),
(156, 1, 1, 0, 5033, 'description', 0, 1001, 334, 999, 1033917596, 1, 1000),
(156, 1, 1, 0, 5034, 'description', 0, 1002, 335, 1000, 1033917596, 1, 1001),
(156, 1, 1, 0, 5035, 'description', 0, 1003, 336, 1001, 1033917596, 1, 1002),
(156, 1, 1, 0, 5036, 'description', 0, 814, 337, 1002, 1033917596, 1, 1003),
(156, 1, 1, 0, 5037, 'description', 0, 1000, 338, 1003, 1033917596, 1, 814),
(156, 1, 1, 0, 5038, 'description', 0, 981, 339, 814, 1033917596, 1, 1000),
(156, 1, 1, 0, 5039, 'description', 0, 1004, 340, 1000, 1033917596, 1, 981),
(156, 1, 1, 0, 5040, 'description', 0, 1005, 341, 981, 1033917596, 1, 1004),
(156, 1, 1, 0, 5041, 'description', 0, 999, 342, 1004, 1033917596, 1, 1005),
(156, 1, 1, 0, 5042, 'description', 0, 1006, 343, 1005, 1033917596, 1, 999),
(156, 1, 1, 0, 5043, 'description', 0, 1007, 344, 999, 1033917596, 1, 1006),
(156, 1, 1, 0, 5044, 'description', 0, 1008, 345, 1006, 1033917596, 1, 1007),
(156, 1, 1, 0, 5045, 'description', 0, 1002, 346, 1007, 1033917596, 1, 1008),
(156, 1, 1, 0, 5046, 'description', 0, 1009, 347, 1008, 1033917596, 1, 1002),
(156, 1, 1, 0, 5047, 'description', 0, 1010, 348, 1002, 1033917596, 1, 1009),
(156, 1, 1, 0, 5048, 'description', 0, 1011, 349, 1009, 1033917596, 1, 1010),
(156, 1, 1, 0, 5049, 'description', 0, 970, 350, 1010, 1033917596, 1, 1011),
(156, 1, 1, 0, 5050, 'description', 0, 1012, 351, 1011, 1033917596, 1, 970),
(156, 1, 1, 0, 5051, 'description', 0, 1013, 352, 970, 1033917596, 1, 1012),
(156, 1, 1, 0, 5052, 'description', 0, 1014, 353, 1012, 1033917596, 1, 1013),
(156, 1, 1, 0, 5053, 'description', 0, 979, 354, 1013, 1033917596, 1, 1014),
(156, 1, 1, 0, 5054, 'description', 0, 1015, 355, 1014, 1033917596, 1, 979),
(156, 1, 1, 0, 5055, 'description', 0, 1016, 356, 979, 1033917596, 1, 1015),
(156, 1, 1, 0, 5056, 'description', 0, 970, 357, 1015, 1033917596, 1, 1016),
(156, 1, 1, 0, 5057, 'description', 0, 979, 358, 1016, 1033917596, 1, 970),
(156, 1, 1, 0, 5058, 'description', 0, 1017, 359, 970, 1033917596, 1, 979),
(156, 1, 1, 0, 5059, 'description', 0, 1018, 360, 979, 1033917596, 1, 1017),
(156, 1, 1, 0, 5060, 'description', 0, 987, 361, 1017, 1033917596, 1, 1018),
(156, 1, 1, 0, 5061, 'description', 0, 978, 362, 1018, 1033917596, 1, 987),
(156, 1, 1, 0, 5062, 'description', 0, 1019, 363, 987, 1033917596, 1, 978),
(156, 1, 1, 0, 5063, 'description', 0, 1020, 364, 978, 1033917596, 1, 1019),
(156, 1, 1, 0, 5064, 'description', 0, 1021, 365, 1019, 1033917596, 1, 1020),
(156, 1, 1, 0, 5065, 'description', 0, 1022, 366, 1020, 1033917596, 1, 1021),
(156, 1, 1, 0, 5066, 'description', 0, 1023, 367, 1021, 1033917596, 1, 1022),
(156, 1, 1, 0, 5067, 'description', 0, 1024, 368, 1022, 1033917596, 1, 1023),
(156, 1, 1, 0, 5068, 'description', 0, 1025, 369, 1023, 1033917596, 1, 1024),
(156, 1, 1, 0, 5069, 'description', 0, 1026, 370, 1024, 1033917596, 1, 1025),
(156, 1, 1, 0, 5070, 'description', 0, 999, 371, 1025, 1033917596, 1, 1026),
(156, 1, 1, 0, 5071, 'description', 0, 1027, 372, 1026, 1033917596, 1, 999),
(156, 1, 1, 0, 5072, 'description', 0, 1028, 373, 999, 1033917596, 1, 1027),
(156, 1, 1, 0, 5073, 'description', 0, 982, 374, 1027, 1033917596, 1, 1028),
(156, 1, 1, 0, 5074, 'description', 0, 1029, 375, 1028, 1033917596, 1, 982),
(156, 1, 1, 0, 5075, 'description', 0, 1030, 376, 982, 1033917596, 1, 1029),
(156, 1, 1, 0, 5076, 'description', 0, 1031, 377, 1029, 1033917596, 1, 1030),
(156, 1, 1, 0, 5077, 'description', 0, 981, 378, 1030, 1033917596, 1, 1031),
(156, 1, 1, 0, 5078, 'description', 0, 1032, 379, 1031, 1033917596, 1, 981),
(156, 1, 1, 0, 5079, 'description', 0, 994, 380, 981, 1033917596, 1, 1032),
(156, 1, 1, 0, 5080, 'description', 0, 1033, 381, 1032, 1033917596, 1, 994),
(156, 1, 1, 0, 5081, 'description', 0, 971, 382, 994, 1033917596, 1, 1033),
(156, 1, 1, 0, 5082, 'description', 0, 972, 383, 1033, 1033917596, 1, 971),
(156, 1, 1, 0, 5083, 'description', 0, 1009, 384, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5084, 'description', 0, 1034, 385, 972, 1033917596, 1, 1009),
(156, 1, 1, 0, 5085, 'description', 0, 1010, 386, 1009, 1033917596, 1, 1034),
(156, 1, 1, 0, 5086, 'description', 0, 1035, 387, 1034, 1033917596, 1, 1010),
(156, 1, 1, 0, 5087, 'description', 0, 1036, 388, 1010, 1033917596, 1, 1035),
(156, 1, 1, 0, 5088, 'description', 0, 1037, 389, 1035, 1033917596, 1, 1036),
(156, 1, 1, 0, 5089, 'description', 0, 999, 390, 1036, 1033917596, 1, 1037),
(156, 1, 1, 0, 5090, 'description', 0, 1038, 391, 1037, 1033917596, 1, 999),
(156, 1, 1, 0, 5091, 'description', 0, 978, 392, 999, 1033917596, 1, 1038),
(156, 1, 1, 0, 5092, 'description', 0, 1039, 393, 1038, 1033917596, 1, 978),
(156, 1, 1, 0, 5093, 'description', 0, 1002, 394, 978, 1033917596, 1, 1039),
(156, 1, 1, 0, 5094, 'description', 0, 1008, 395, 1039, 1033917596, 1, 1002),
(156, 1, 1, 0, 5095, 'description', 0, 1040, 396, 1002, 1033917596, 1, 1008),
(156, 1, 1, 0, 5096, 'description', 0, 999, 397, 1008, 1033917596, 1, 1040),
(156, 1, 1, 0, 5097, 'description', 0, 1041, 398, 1040, 1033917596, 1, 999),
(156, 1, 1, 0, 5098, 'description', 0, 814, 399, 999, 1033917596, 1, 1041),
(156, 1, 1, 0, 5099, 'description', 0, 971, 400, 1041, 1033917596, 1, 814),
(156, 1, 1, 0, 5100, 'description', 0, 972, 401, 814, 1033917596, 1, 971),
(156, 1, 1, 0, 5101, 'description', 0, 1040, 402, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5102, 'description', 0, 1042, 403, 972, 1033917596, 1, 1040),
(156, 1, 1, 0, 5103, 'description', 0, 877, 404, 1040, 1033917596, 1, 1042),
(156, 1, 1, 0, 5104, 'description', 0, 1043, 405, 1042, 1033917596, 1, 877),
(156, 1, 1, 0, 5105, 'description', 0, 1044, 406, 877, 1033917596, 1, 1043),
(156, 1, 1, 0, 5106, 'description', 0, 970, 407, 1043, 1033917596, 1, 1044),
(156, 1, 1, 0, 5107, 'description', 0, 814, 408, 1044, 1033917596, 1, 970),
(156, 1, 1, 0, 5108, 'description', 0, 812, 409, 970, 1033917596, 1, 814),
(156, 1, 1, 0, 5109, 'description', 0, 999, 410, 814, 1033917596, 1, 812),
(156, 1, 1, 0, 5110, 'description', 0, 1045, 411, 812, 1033917596, 1, 999),
(156, 1, 1, 0, 5111, 'description', 0, 1046, 412, 999, 1033917596, 1, 1045),
(156, 1, 1, 0, 5112, 'description', 0, 981, 413, 1045, 1033917596, 1, 1046),
(156, 1, 1, 0, 5113, 'description', 0, 814, 414, 1046, 1033917596, 1, 981),
(156, 1, 1, 0, 5114, 'description', 0, 971, 415, 981, 1033917596, 1, 814),
(156, 1, 1, 0, 5115, 'description', 0, 972, 416, 814, 1033917596, 1, 971),
(156, 1, 1, 0, 5116, 'description', 0, 996, 417, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5117, 'description', 0, 997, 418, 972, 1033917596, 1, 996),
(156, 1, 1, 0, 5118, 'description', 0, 998, 419, 996, 1033917596, 1, 997),
(156, 1, 1, 0, 5119, 'description', 0, 1001, 420, 997, 1033917596, 1, 998),
(156, 1, 1, 0, 5120, 'description', 0, 1029, 421, 998, 1033917596, 1, 1001),
(156, 1, 1, 0, 5121, 'description', 0, 1030, 422, 1001, 1033917596, 1, 1029),
(156, 1, 1, 0, 5122, 'description', 0, 1002, 423, 1029, 1033917596, 1, 1030),
(156, 1, 1, 0, 5123, 'description', 0, 1047, 424, 1030, 1033917596, 1, 1002),
(156, 1, 1, 0, 5124, 'description', 0, 1042, 425, 1002, 1033917596, 1, 1047),
(156, 1, 1, 0, 5125, 'description', 0, 1048, 426, 1047, 1033917596, 1, 1042),
(156, 1, 1, 0, 5126, 'description', 0, 1028, 427, 1042, 1033917596, 1, 1048),
(156, 1, 1, 0, 5127, 'description', 0, 1043, 428, 1048, 1033917596, 1, 1028),
(156, 1, 1, 0, 5128, 'description', 0, 1049, 429, 1028, 1033917596, 1, 1043),
(156, 1, 1, 0, 5129, 'description', 0, 1050, 430, 1043, 1033917596, 1, 1049),
(156, 1, 1, 0, 5130, 'description', 0, 1051, 431, 1049, 1033917596, 1, 1050),
(156, 1, 1, 0, 5131, 'description', 0, 1052, 432, 1050, 1033917596, 1, 1051),
(156, 1, 1, 0, 5132, 'description', 0, 978, 433, 1051, 1033917596, 1, 1052),
(156, 1, 1, 0, 5133, 'description', 0, 971, 434, 1052, 1033917596, 1, 978),
(156, 1, 1, 0, 5134, 'description', 0, 972, 435, 978, 1033917596, 1, 971),
(156, 1, 1, 0, 5135, 'description', 0, 1053, 436, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5136, 'description', 0, 991, 437, 972, 1033917596, 1, 1053),
(156, 1, 1, 0, 5137, 'description', 0, 1054, 438, 1053, 1033917596, 1, 991),
(156, 1, 1, 0, 5138, 'description', 0, 1055, 439, 991, 1033917596, 1, 1054),
(156, 1, 1, 0, 5139, 'description', 0, 814, 440, 1054, 1033917596, 1, 1055),
(156, 1, 1, 0, 5140, 'description', 0, 971, 441, 1055, 1033917596, 1, 814),
(156, 1, 1, 0, 5141, 'description', 0, 972, 442, 814, 1033917596, 1, 971),
(156, 1, 1, 0, 5142, 'description', 0, 1056, 443, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5143, 'description', 0, 1057, 444, 972, 1033917596, 1, 1056),
(156, 1, 1, 0, 5144, 'description', 0, 1058, 445, 1056, 1033917596, 1, 1057),
(156, 1, 1, 0, 5145, 'description', 0, 1059, 446, 1057, 1033917596, 1, 1058),
(156, 1, 1, 0, 5146, 'description', 0, 1060, 447, 1058, 1033917596, 1, 1059),
(156, 1, 1, 0, 5147, 'description', 0, 1061, 448, 1059, 1033917596, 1, 1060),
(156, 1, 1, 0, 5148, 'description', 0, 970, 449, 1060, 1033917596, 1, 1061),
(156, 1, 1, 0, 5149, 'description', 0, 1062, 450, 1061, 1033917596, 1, 970),
(156, 1, 1, 0, 5150, 'description', 0, 1063, 451, 970, 1033917596, 1, 1062),
(156, 1, 1, 0, 5151, 'description', 0, 1064, 452, 1062, 1033917596, 1, 1063),
(156, 1, 1, 0, 5152, 'description', 0, 1065, 453, 1063, 1033917596, 1, 1064),
(156, 1, 1, 0, 5153, 'description', 0, 970, 454, 1064, 1033917596, 1, 1065),
(156, 1, 1, 0, 5154, 'description', 0, 979, 455, 1065, 1033917596, 1, 970),
(156, 1, 1, 0, 5155, 'description', 0, 1066, 456, 970, 1033917596, 1, 979),
(156, 1, 1, 0, 5156, 'description', 0, 1067, 457, 979, 1033917596, 1, 1066),
(156, 1, 1, 0, 5157, 'description', 0, 1068, 458, 1066, 1033917596, 1, 1067),
(156, 1, 1, 0, 5158, 'description', 0, 1069, 459, 1067, 1033917596, 1, 1068),
(156, 1, 1, 0, 5159, 'description', 0, 814, 460, 1068, 1033917596, 1, 1069),
(156, 1, 1, 0, 5160, 'description', 0, 1040, 461, 1069, 1033917596, 1, 814),
(156, 1, 1, 0, 5161, 'description', 0, 1070, 462, 814, 1033917596, 1, 1040),
(156, 1, 1, 0, 5162, 'description', 0, 1059, 463, 1040, 1033917596, 1, 1070),
(156, 1, 1, 0, 5163, 'description', 0, 1053, 464, 1070, 1033917596, 1, 1059),
(156, 1, 1, 0, 5164, 'description', 0, 1071, 465, 1059, 1033917596, 1, 1053),
(156, 1, 1, 0, 5165, 'description', 0, 1046, 466, 1053, 1033917596, 1, 1071),
(156, 1, 1, 0, 5166, 'description', 0, 981, 467, 1071, 1033917596, 1, 1046),
(156, 1, 1, 0, 5167, 'description', 0, 814, 468, 1046, 1033917596, 1, 981),
(156, 1, 1, 0, 5168, 'description', 0, 1072, 469, 981, 1033917596, 1, 814),
(156, 1, 1, 0, 5169, 'description', 0, 971, 470, 814, 1033917596, 1, 1072),
(156, 1, 1, 0, 5170, 'description', 0, 972, 471, 1072, 1033917596, 1, 971),
(156, 1, 1, 0, 5171, 'description', 0, 1073, 472, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5172, 'description', 0, 1049, 473, 972, 1033917596, 1, 1073),
(156, 1, 1, 0, 5173, 'description', 0, 1050, 474, 1073, 1033917596, 1, 1049),
(156, 1, 1, 0, 5174, 'description', 0, 1074, 475, 1049, 1033917596, 1, 1050),
(156, 1, 1, 0, 5175, 'description', 0, 1004, 476, 1050, 1033917596, 1, 1074),
(156, 1, 1, 0, 5176, 'description', 0, 1075, 477, 1074, 1033917596, 1, 1004),
(156, 1, 1, 0, 5177, 'description', 0, 1053, 478, 1004, 1033917596, 1, 1075),
(156, 1, 1, 0, 5178, 'description', 0, 1076, 479, 1075, 1033917596, 1, 1053),
(156, 1, 1, 0, 5179, 'description', 0, 1077, 480, 1053, 1033917596, 1, 1076),
(156, 1, 1, 0, 5180, 'description', 0, 989, 481, 1076, 1033917596, 1, 1077),
(156, 1, 1, 0, 5181, 'description', 0, 1078, 482, 1077, 1033917596, 1, 989),
(156, 1, 1, 0, 5182, 'description', 0, 1079, 483, 989, 1033917596, 1, 1078),
(156, 1, 1, 0, 5183, 'description', 0, 1002, 484, 1078, 1033917596, 1, 1079),
(156, 1, 1, 0, 5184, 'description', 0, 974, 485, 1079, 1033917596, 1, 1002),
(156, 1, 1, 0, 5185, 'description', 0, 1047, 486, 1002, 1033917596, 1, 974),
(156, 1, 1, 0, 5186, 'description', 0, 1080, 487, 974, 1033917596, 1, 1047),
(156, 1, 1, 0, 5187, 'description', 0, 970, 488, 1047, 1033917596, 1, 1080),
(156, 1, 1, 0, 5188, 'description', 0, 1081, 489, 1080, 1033917596, 1, 970),
(156, 1, 1, 0, 5189, 'description', 0, 1082, 490, 970, 1033917596, 1, 1081),
(156, 1, 1, 0, 5190, 'description', 0, 816, 491, 1081, 1033917596, 1, 1082),
(156, 1, 1, 0, 5191, 'description', 0, 1083, 492, 1082, 1033917596, 1, 816),
(156, 1, 1, 0, 5192, 'description', 0, 1084, 493, 816, 1033917596, 1, 1083),
(156, 1, 1, 0, 5193, 'description', 0, 1085, 494, 1083, 1033917596, 1, 1084),
(156, 1, 1, 0, 5194, 'description', 0, 816, 495, 1084, 1033917596, 1, 1085),
(156, 1, 1, 0, 5195, 'description', 0, 1086, 496, 1085, 1033917596, 1, 816),
(156, 1, 1, 0, 5196, 'description', 0, 1087, 497, 816, 1033917596, 1, 1086),
(156, 1, 1, 0, 5197, 'description', 0, 1088, 498, 1086, 1033917596, 1, 1087),
(156, 1, 1, 0, 5198, 'description', 0, 971, 499, 1087, 1033917596, 1, 1088),
(156, 1, 1, 0, 5199, 'description', 0, 972, 500, 1088, 1033917596, 1, 971),
(156, 1, 1, 0, 5200, 'description', 0, 999, 501, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5201, 'description', 0, 1027, 502, 972, 1033917596, 1, 999),
(156, 1, 1, 0, 5202, 'description', 0, 1089, 503, 999, 1033917596, 1, 1027),
(156, 1, 1, 0, 5203, 'description', 0, 1079, 504, 1027, 1033917596, 1, 1089),
(156, 1, 1, 0, 5204, 'description', 0, 1014, 505, 1089, 1033917596, 1, 1079),
(156, 1, 1, 0, 5205, 'description', 0, 971, 506, 1079, 1033917596, 1, 1014),
(156, 1, 1, 0, 5206, 'description', 0, 1090, 507, 1014, 1033917596, 1, 971),
(156, 1, 1, 0, 5207, 'description', 0, 985, 508, 971, 1033917596, 1, 1090),
(156, 1, 1, 0, 5208, 'description', 0, 1091, 509, 1090, 1033917596, 1, 985),
(156, 1, 1, 0, 5209, 'description', 0, 927, 510, 985, 1033917596, 1, 1091),
(156, 1, 1, 0, 5210, 'description', 0, 1092, 511, 1091, 1033917596, 1, 927),
(156, 1, 1, 0, 5211, 'description', 0, 1093, 512, 927, 1033917596, 1, 1092),
(156, 1, 1, 0, 5212, 'description', 0, 930, 513, 1092, 1033917596, 1, 1093),
(156, 1, 1, 0, 5213, 'description', 0, 971, 514, 1093, 1033917596, 1, 930),
(156, 1, 1, 0, 5214, 'description', 0, 972, 515, 930, 1033917596, 1, 971),
(156, 1, 1, 0, 5215, 'description', 0, 1094, 516, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5216, 'description', 0, 988, 517, 972, 1033917596, 1, 1094),
(156, 1, 1, 0, 5217, 'description', 0, 971, 518, 1094, 1033917596, 1, 988),
(156, 1, 1, 0, 5218, 'description', 0, 972, 519, 988, 1033917596, 1, 971),
(156, 1, 1, 0, 5219, 'description', 0, 1023, 520, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5220, 'description', 0, 1095, 521, 972, 1033917596, 1, 1023),
(156, 1, 1, 0, 5221, 'description', 0, 1096, 522, 1023, 1033917596, 1, 1095),
(156, 1, 1, 0, 5222, 'description', 0, 971, 523, 1095, 1033917596, 1, 1096),
(156, 1, 1, 0, 5223, 'description', 0, 990, 524, 1096, 1033917596, 1, 971),
(156, 1, 1, 0, 5224, 'description', 0, 1096, 525, 971, 1033917596, 1, 990),
(156, 1, 1, 0, 5225, 'description', 0, 1097, 526, 990, 1033917596, 1, 1096),
(156, 1, 1, 0, 5226, 'description', 0, 1098, 527, 1096, 1033917596, 1, 1097),
(156, 1, 1, 0, 5227, 'description', 0, 930, 528, 1097, 1033917596, 1, 1098),
(156, 1, 1, 0, 5228, 'description', 0, 1099, 529, 1098, 1033917596, 1, 930),
(156, 1, 1, 0, 5229, 'description', 0, 970, 530, 930, 1033917596, 1, 1099),
(156, 1, 1, 0, 5230, 'description', 0, 1100, 531, 1099, 1033917596, 1, 970),
(156, 1, 1, 0, 5231, 'description', 0, 971, 532, 970, 1033917596, 1, 1100),
(156, 1, 1, 0, 5232, 'description', 0, 972, 533, 1100, 1033917596, 1, 971),
(156, 1, 1, 0, 5233, 'description', 0, 1101, 534, 971, 1033917596, 1, 972),
(156, 1, 1, 0, 5234, 'description', 0, 1099, 535, 972, 1033917596, 1, 1101),
(156, 1, 1, 0, 5235, 'description', 0, 970, 536, 1101, 1033917596, 1, 1099),
(156, 1, 1, 0, 5236, 'description', 0, 1102, 537, 1099, 1033917596, 1, 970),
(156, 1, 1, 0, 5237, 'description', 0, 1103, 538, 970, 1033917596, 1, 1102),
(156, 1, 1, 0, 5238, 'description', 0, 1104, 539, 1102, 1033917596, 1, 1103),
(156, 1, 1, 0, 5239, 'description', 0, 1099, 540, 1103, 1033917596, 1, 1104),
(156, 1, 1, 0, 5240, 'description', 0, 970, 541, 1104, 1033917596, 1, 1099),
(156, 1, 1, 0, 5241, 'description', 0, 1046, 542, 1099, 1033917596, 1, 970),
(156, 1, 1, 0, 5242, 'description', 0, 1105, 543, 970, 1033917596, 1, 1046),
(156, 1, 1, 0, 5243, 'description', 0, 1106, 544, 1046, 1033917596, 1, 1105),
(156, 1, 1, 0, 5244, 'description', 0, 988, 545, 1105, 1033917596, 1, 1106),
(156, 1, 1, 0, 5245, 'description', 0, 1107, 546, 1106, 1033917596, 1, 988),
(156, 1, 1, 0, 5246, 'description', 0, 1108, 547, 988, 1033917596, 1, 1107),
(156, 1, 1, 0, 5247, 'description', 0, 1109, 548, 1107, 1033917596, 1, 1108),
(156, 1, 1, 0, 5248, 'description', 0, 970, 549, 1108, 1033917596, 1, 1109),
(156, 1, 1, 0, 5249, 'description', 0, 1110, 550, 1109, 1033917596, 1, 970),
(156, 1, 1, 0, 5250, 'description', 0, 1062, 551, 970, 1033917596, 1, 1110),
(156, 1, 1, 0, 5251, 'description', 0, 1086, 552, 1110, 1033917596, 1, 1062),
(156, 1, 1, 0, 5252, 'description', 0, 1092, 553, 1062, 1033917596, 1, 1086),
(156, 1, 1, 0, 5253, 'description', 0, 999, 554, 1086, 1033917596, 1, 1092),
(156, 1, 1, 0, 5254, 'description', 0, 1113, 555, 1092, 1033917596, 1, 999),
(156, 1, 1, 0, 5255, 'description', 0, 1023, 556, 999, 1033917596, 1, 1113),
(156, 1, 1, 0, 5256, 'description', 0, 0, 557, 1113, 1033917596, 1, 1023),
(4, 1, 41, 0, 5258, 'name', 0, 0, 1, 1114, 1060695457, 3, 1114),
(4, 1, 50, 0, 5260, 'name', 0, 0, 1, 1115, 1080220220, 3, 1115),
(4, 1, 49, 0, 5262, 'name', 0, 0, 1, 1116, 1080220197, 3, 1116),
(4, 1, 51, 0, 5264, 'name', 0, 0, 1, 1117, 1080220233, 3, 1117),
(7, 3, 4, 0, 5268, 'description', 0, 1118, 3, 1118, 1033917596, 2, 952),
(7, 3, 4, 0, 5269, 'description', 0, 952, 4, 952, 1033917596, 2, 1118),
(7, 3, 4, 0, 5270, 'description', 0, 0, 5, 1118, 1033917596, 2, 952),
(6, 3, 11, 0, 5273, 'name', 0, 1120, 2, 1120, 1033920746, 2, 1119),
(6, 3, 11, 0, 5274, 'name', 0, 0, 3, 1119, 1033920746, 2, 1120),
(6, 3, 12, 0, 5277, 'name', 0, 930, 2, 930, 1033920775, 2, 958),
(6, 3, 12, 0, 5278, 'name', 0, 0, 3, 958, 1033920775, 2, 930),
(6, 3, 13, 0, 5280, 'name', 0, 0, 1, 1121, 1033920794, 2, 1121),
(7, 3, 42, 0, 5288, 'description', 0, 953, 7, 816, 1072180330, 2, 814),
(7, 3, 42, 0, 5289, 'description', 0, 954, 8, 814, 1072180330, 2, 953),
(7, 3, 42, 0, 5290, 'description', 0, 954, 9, 953, 1072180330, 2, 954),
(7, 3, 42, 0, 5291, 'description', 0, 952, 10, 954, 1072180330, 2, 954),
(7, 3, 42, 0, 5292, 'description', 0, 816, 11, 954, 1072180330, 2, 952),
(7, 3, 42, 0, 5293, 'description', 0, 814, 12, 952, 1072180330, 2, 816),
(7, 3, 42, 0, 5294, 'description', 0, 953, 13, 816, 1072180330, 2, 814),
(7, 3, 42, 0, 5295, 'description', 0, 954, 14, 814, 1072180330, 2, 953),
(7, 3, 42, 0, 5296, 'description', 0, 0, 15, 953, 1072180330, 2, 954),
(12, 4, 10, 0, 5302, 'user_account', 0, 927, 5, 953, 1033920665, 2, 955),
(12, 4, 10, 0, 5303, 'user_account', 0, 953, 6, 955, 1033920665, 2, 927),
(12, 4, 10, 0, 5304, 'user_account', 0, 955, 7, 927, 1033920665, 2, 953),
(12, 4, 10, 0, 5305, 'user_account', 0, 927, 8, 953, 1033920665, 2, 955),
(12, 4, 10, 0, 5306, 'user_account', 0, 0, 9, 955, 1033920665, 2, 927),
(12, 4, 14, 0, 5312, 'user_account', 0, 927, 5, 1122, 1033920830, 2, 955),
(12, 4, 14, 0, 5313, 'user_account', 0, 1122, 6, 955, 1033920830, 2, 927),
(12, 4, 14, 0, 5314, 'user_account', 0, 955, 7, 927, 1033920830, 2, 1122),
(12, 4, 14, 0, 5315, 'user_account', 0, 927, 8, 1122, 1033920830, 2, 955),
(12, 4, 14, 0, 5316, 'user_account', 0, 0, 9, 955, 1033920830, 2, 927),
(190, 17, 58, 0, 6335, 'short_description', 0, 0, 24, 1254, 1421109393, 1, 1255),
(190, 17, 58, 0, 6334, 'short_description', 0, 1255, 23, 1258, 1421109393, 1, 1254),
(209, 21, 66, 0, 5428, 'short_description', 0, 1173, 6, 1171, 1437142935, 1, 1172),
(209, 21, 66, 0, 5429, 'short_description', 0, 1174, 7, 1172, 1437142935, 1, 1173),
(181, 16, 60, 0, 5441, 'title', 0, 1179, 3, 1127, 1421109662, 1, 1127),
(181, 16, 60, 0, 5440, 'title', 0, 1127, 2, 1129, 1421109662, 1, 1127),
(181, 16, 60, 0, 5439, 'title', 0, 1127, 1, 1125, 1421109662, 1, 1129),
(181, 16, 60, 0, 5438, 'title', 0, 1129, 0, 0, 1421109662, 1, 1125),
(181, 16, 61, 0, 5647, 'title', 0, 1129, 3, 1127, 1421109748, 1, 1128),
(181, 16, 61, 0, 5646, 'title', 0, 1128, 2, 1129, 1421109748, 1, 1127),
(181, 16, 61, 0, 5645, 'title', 0, 1127, 1, 1125, 1421109748, 1, 1129),
(181, 16, 61, 0, 5644, 'title', 0, 1129, 0, 0, 1421109748, 1, 1125),
(181, 16, 62, 0, 5861, 'title', 0, 1129, 3, 1128, 1421110056, 1, 1127),
(181, 16, 62, 0, 5860, 'title', 0, 1127, 2, 1129, 1421110056, 1, 1128),
(181, 16, 62, 0, 5859, 'title', 0, 1128, 1, 1125, 1421110056, 1, 1129),
(181, 16, 62, 0, 5858, 'title', 0, 1129, 0, 0, 1421110056, 1, 1125),
(181, 16, 64, 0, 6075, 'title', 0, 1179, 3, 1128, 1421110148, 1, 1128),
(181, 16, 64, 0, 6074, 'title', 0, 1128, 2, 1129, 1421110148, 1, 1128),
(181, 16, 64, 0, 6073, 'title', 0, 1128, 1, 1125, 1421110148, 1, 1129),
(181, 16, 64, 0, 6072, 'title', 0, 1129, 0, 0, 1421110148, 1, 1125),
(190, 17, 58, 0, 6332, 'short_description', 0, 1258, 21, 1257, 1421109393, 1, 1029),
(190, 17, 58, 0, 6333, 'short_description', 0, 1254, 22, 1029, 1421109393, 1, 1258),
(190, 17, 58, 0, 6331, 'short_description', 0, 1029, 20, 974, 1421109393, 1, 1257),
(190, 17, 58, 0, 6330, 'short_description', 0, 1257, 19, 1253, 1421109393, 1, 974),
(190, 17, 58, 0, 6329, 'short_description', 0, 974, 18, 973, 1421109393, 1, 1253),
(190, 17, 58, 0, 6328, 'short_description', 0, 1253, 17, 1136, 1421109393, 1, 973),
(190, 17, 58, 0, 6327, 'short_description', 0, 973, 16, 1135, 1421109393, 1, 1136),
(190, 17, 58, 0, 6326, 'short_description', 0, 1136, 15, 1143, 1421109393, 1, 1135),
(190, 17, 58, 0, 6325, 'short_description', 0, 1135, 14, 1142, 1421109393, 1, 1143),
(190, 17, 58, 0, 6324, 'short_description', 0, 1143, 13, 1029, 1421109393, 1, 1142),
(190, 17, 58, 0, 6323, 'short_description', 0, 1142, 12, 1256, 1421109393, 1, 1029),
(190, 17, 58, 0, 6322, 'short_description', 0, 1029, 11, 1126, 1421109393, 1, 1256),
(190, 17, 58, 0, 6321, 'short_description', 0, 1256, 10, 1140, 1421109393, 1, 1126),
(190, 17, 58, 0, 6320, 'short_description', 0, 1126, 9, 1255, 1421109393, 1, 1140),
(188, 17, 58, 0, 6319, 'title', 0, 1140, 8, 1254, 1421109393, 1, 1255),
(188, 17, 58, 0, 6318, 'title', 0, 1255, 7, 1253, 1421109393, 1, 1254),
(188, 17, 58, 0, 6317, 'title', 0, 1254, 6, 1125, 1421109393, 1, 1253),
(188, 17, 58, 0, 6316, 'title', 0, 1253, 5, 1136, 1421109393, 1, 1125),
(190, 17, 65, 0, 5405, 'short_description', 0, 0, 9, 1142, 1437142061, 1, 1143),
(190, 17, 65, 0, 5404, 'short_description', 0, 1143, 8, 1029, 1437142061, 1, 1142),
(190, 17, 65, 0, 5403, 'short_description', 0, 1142, 7, 1149, 1437142061, 1, 1029),
(190, 17, 65, 0, 5402, 'short_description', 0, 1029, 6, 1126, 1437142061, 1, 1149),
(190, 17, 65, 0, 5401, 'short_description', 0, 1149, 5, 1140, 1437142061, 1, 1126),
(190, 17, 65, 0, 5400, 'short_description', 0, 1126, 4, 1136, 1437142061, 1, 1140),
(188, 17, 65, 0, 5399, 'name', 0, 1140, 3, 1135, 1437142061, 1, 1136);
INSERT INTO `ezsearch_object_word_link` (`contentclass_attribute_id`, `contentclass_id`, `contentobject_id`, `frequency`, `id`, `identifier`, `integer_value`, `next_word_id`, `placement`, `prev_word_id`, `published`, `section_id`, `word_id`) VALUES
(188, 17, 65, 0, 5398, 'name', 0, 1136, 2, 1128, 1437142061, 1, 1135),
(188, 17, 65, 0, 5397, 'name', 0, 1135, 1, 1126, 1437142061, 1, 1128),
(188, 17, 65, 0, 5396, 'name', 0, 1128, 0, 0, 1437142061, 1, 1126),
(209, 21, 66, 0, 5427, 'short_description', 0, 1172, 5, 1170, 1437142935, 1, 1171),
(209, 21, 66, 0, 5426, 'short_description', 0, 1171, 4, 1169, 1437142935, 1, 1170),
(209, 21, 66, 0, 5425, 'short_description', 0, 1170, 3, 1168, 1437142935, 1, 1169),
(209, 21, 66, 0, 5424, 'short_description', 0, 1169, 2, 1167, 1437142935, 1, 1168),
(207, 21, 66, 0, 5423, 'title', 0, 1168, 1, 1166, 1437142935, 1, 1167),
(207, 21, 66, 0, 5422, 'title', 0, 1167, 0, 0, 1437142935, 1, 1166),
(209, 21, 66, 0, 5430, 'short_description', 0, 1175, 8, 1173, 1437142935, 1, 1174),
(209, 21, 66, 0, 5431, 'short_description', 0, 1059, 9, 1174, 1437142935, 1, 1175),
(209, 21, 66, 0, 5432, 'short_description', 0, 1009, 10, 1175, 1437142935, 1, 1059),
(209, 21, 66, 0, 5433, 'short_description', 0, 1176, 11, 1059, 1437142935, 1, 1009),
(209, 21, 66, 0, 5434, 'short_description', 0, 1177, 12, 1009, 1437142935, 1, 1176),
(209, 21, 66, 0, 5435, 'short_description', 0, 979, 13, 1176, 1437142935, 1, 1177),
(209, 21, 66, 0, 5436, 'short_description', 0, 1178, 14, 1177, 1437142935, 1, 979),
(209, 21, 66, 0, 5437, 'short_description', 0, 0, 15, 979, 1437142935, 1, 1178),
(184, 16, 60, 0, 5442, 'short_description', 0, 1180, 4, 1127, 1421109662, 1, 1179),
(184, 16, 60, 0, 5443, 'short_description', 0, 1181, 5, 1179, 1421109662, 1, 1180),
(184, 16, 60, 0, 5444, 'short_description', 0, 1182, 6, 1180, 1421109662, 1, 1181),
(184, 16, 60, 0, 5445, 'short_description', 0, 1183, 7, 1181, 1421109662, 1, 1182),
(184, 16, 60, 0, 5446, 'short_description', 0, 1184, 8, 1182, 1421109662, 1, 1183),
(184, 16, 60, 0, 5447, 'short_description', 0, 1063, 9, 1183, 1421109662, 1, 1184),
(184, 16, 60, 0, 5448, 'short_description', 0, 1185, 10, 1184, 1421109662, 1, 1063),
(184, 16, 60, 0, 5449, 'short_description', 0, 1186, 11, 1063, 1421109662, 1, 1185),
(184, 16, 60, 0, 5450, 'short_description', 0, 1187, 12, 1185, 1421109662, 1, 1186),
(184, 16, 60, 0, 5451, 'short_description', 0, 1188, 13, 1186, 1421109662, 1, 1187),
(184, 16, 60, 0, 5452, 'short_description', 0, 1189, 14, 1187, 1421109662, 1, 1188),
(184, 16, 60, 0, 5453, 'short_description', 0, 1190, 15, 1188, 1421109662, 1, 1189),
(184, 16, 60, 0, 5454, 'short_description', 0, 1179, 16, 1189, 1421109662, 1, 1190),
(184, 16, 60, 0, 5455, 'short_description', 0, 1191, 17, 1190, 1421109662, 1, 1179),
(184, 16, 60, 0, 5456, 'short_description', 0, 1192, 18, 1179, 1421109662, 1, 1191),
(184, 16, 60, 0, 5457, 'short_description', 0, 1193, 19, 1191, 1421109662, 1, 1192),
(184, 16, 60, 0, 5458, 'short_description', 0, 1185, 20, 1192, 1421109662, 1, 1193),
(184, 16, 60, 0, 5459, 'short_description', 0, 1194, 21, 1193, 1421109662, 1, 1185),
(184, 16, 60, 0, 5460, 'short_description', 0, 1181, 22, 1185, 1421109662, 1, 1194),
(184, 16, 60, 0, 5461, 'short_description', 0, 1195, 23, 1194, 1421109662, 1, 1181),
(184, 16, 60, 0, 5462, 'short_description', 0, 1196, 24, 1181, 1421109662, 1, 1195),
(184, 16, 60, 0, 5463, 'short_description', 0, 1197, 25, 1195, 1421109662, 1, 1196),
(184, 16, 60, 0, 5464, 'short_description', 0, 1198, 26, 1196, 1421109662, 1, 1197),
(184, 16, 60, 0, 5465, 'short_description', 0, 1199, 27, 1197, 1421109662, 1, 1198),
(184, 16, 60, 0, 5466, 'short_description', 0, 1200, 28, 1198, 1421109662, 1, 1199),
(184, 16, 60, 0, 5467, 'short_description', 0, 1201, 29, 1199, 1421109662, 1, 1200),
(184, 16, 60, 0, 5468, 'short_description', 0, 1202, 30, 1200, 1421109662, 1, 1201),
(184, 16, 60, 0, 5469, 'short_description', 0, 1199, 31, 1201, 1421109662, 1, 1202),
(185, 16, 60, 0, 5470, 'description', 0, 1203, 32, 1202, 1421109662, 1, 1199),
(185, 16, 60, 0, 5471, 'description', 0, 1168, 33, 1199, 1421109662, 1, 1203),
(185, 16, 60, 0, 5472, 'description', 0, 1204, 34, 1203, 1421109662, 1, 1168),
(185, 16, 60, 0, 5473, 'description', 0, 1205, 35, 1168, 1421109662, 1, 1204),
(185, 16, 60, 0, 5474, 'description', 0, 1206, 36, 1204, 1421109662, 1, 1205),
(185, 16, 60, 0, 5475, 'description', 0, 1207, 37, 1205, 1421109662, 1, 1206),
(185, 16, 60, 0, 5476, 'description', 0, 1208, 38, 1206, 1421109662, 1, 1207),
(185, 16, 60, 0, 5477, 'description', 0, 1209, 39, 1207, 1421109662, 1, 1208),
(185, 16, 60, 0, 5478, 'description', 0, 1210, 40, 1208, 1421109662, 1, 1209),
(185, 16, 60, 0, 5479, 'description', 0, 1211, 41, 1209, 1421109662, 1, 1210),
(185, 16, 60, 0, 5480, 'description', 0, 1199, 42, 1210, 1421109662, 1, 1211),
(185, 16, 60, 0, 5481, 'description', 0, 1212, 43, 1211, 1421109662, 1, 1199),
(185, 16, 60, 0, 5482, 'description', 0, 1213, 44, 1199, 1421109662, 1, 1212),
(185, 16, 60, 0, 5483, 'description', 0, 1214, 45, 1212, 1421109662, 1, 1213),
(185, 16, 60, 0, 5484, 'description', 0, 1215, 46, 1213, 1421109662, 1, 1214),
(185, 16, 60, 0, 5485, 'description', 0, 1216, 47, 1214, 1421109662, 1, 1215),
(185, 16, 60, 0, 5486, 'description', 0, 1180, 48, 1215, 1421109662, 1, 1216),
(185, 16, 60, 0, 5487, 'description', 0, 1179, 49, 1216, 1421109662, 1, 1180),
(185, 16, 60, 0, 5488, 'description', 0, 1217, 50, 1180, 1421109662, 1, 1179),
(185, 16, 60, 0, 5489, 'description', 0, 1181, 51, 1179, 1421109662, 1, 1217),
(185, 16, 60, 0, 5490, 'description', 0, 1218, 52, 1217, 1421109662, 1, 1181),
(185, 16, 60, 0, 5491, 'description', 0, 1196, 53, 1181, 1421109662, 1, 1218),
(185, 16, 60, 0, 5492, 'description', 0, 1179, 54, 1218, 1421109662, 1, 1196),
(185, 16, 60, 0, 5493, 'description', 0, 1219, 55, 1196, 1421109662, 1, 1179),
(185, 16, 60, 0, 5494, 'description', 0, 1220, 56, 1179, 1421109662, 1, 1219),
(185, 16, 60, 0, 5495, 'description', 0, 1179, 57, 1219, 1421109662, 1, 1220),
(185, 16, 60, 0, 5496, 'description', 0, 1221, 58, 1220, 1421109662, 1, 1179),
(185, 16, 60, 0, 5497, 'description', 0, 1222, 59, 1179, 1421109662, 1, 1221),
(185, 16, 60, 0, 5498, 'description', 0, 1223, 60, 1221, 1421109662, 1, 1222),
(185, 16, 60, 0, 5499, 'description', 0, 1192, 61, 1222, 1421109662, 1, 1223),
(185, 16, 60, 0, 5500, 'description', 0, 1029, 62, 1223, 1421109662, 1, 1192),
(185, 16, 60, 0, 5501, 'description', 0, 1224, 63, 1192, 1421109662, 1, 1029),
(185, 16, 60, 0, 5502, 'description', 0, 1225, 64, 1029, 1421109662, 1, 1224),
(185, 16, 60, 0, 5503, 'description', 0, 1226, 65, 1224, 1421109662, 1, 1225),
(185, 16, 60, 0, 5504, 'description', 0, 1197, 66, 1225, 1421109662, 1, 1226),
(185, 16, 60, 0, 5505, 'description', 0, 1227, 67, 1226, 1421109662, 1, 1197),
(185, 16, 60, 0, 5506, 'description', 0, 1216, 68, 1197, 1421109662, 1, 1227),
(185, 16, 60, 0, 5507, 'description', 0, 1180, 69, 1227, 1421109662, 1, 1216),
(185, 16, 60, 0, 5508, 'description', 0, 1179, 70, 1216, 1421109662, 1, 1180),
(185, 16, 60, 0, 5509, 'description', 0, 1217, 71, 1180, 1421109662, 1, 1179),
(185, 16, 60, 0, 5510, 'description', 0, 1228, 72, 1179, 1421109662, 1, 1217),
(185, 16, 60, 0, 5511, 'description', 0, 1229, 73, 1217, 1421109662, 1, 1228),
(185, 16, 60, 0, 5512, 'description', 0, 1179, 74, 1228, 1421109662, 1, 1229),
(185, 16, 60, 0, 5513, 'description', 0, 1180, 75, 1229, 1421109662, 1, 1179),
(185, 16, 60, 0, 5514, 'description', 0, 1230, 76, 1179, 1421109662, 1, 1180),
(185, 16, 60, 0, 5515, 'description', 0, 1216, 77, 1180, 1421109662, 1, 1230),
(185, 16, 60, 0, 5516, 'description', 0, 1179, 78, 1230, 1421109662, 1, 1216),
(185, 16, 60, 0, 5517, 'description', 0, 1180, 79, 1216, 1421109662, 1, 1179),
(185, 16, 60, 0, 5518, 'description', 0, 1231, 80, 1179, 1421109662, 1, 1180),
(185, 16, 60, 0, 5519, 'description', 0, 1181, 81, 1180, 1421109662, 1, 1231),
(185, 16, 60, 0, 5520, 'description', 0, 1196, 82, 1231, 1421109662, 1, 1181),
(185, 16, 60, 0, 5521, 'description', 0, 1204, 83, 1181, 1421109662, 1, 1196),
(185, 16, 60, 0, 5522, 'description', 0, 1232, 84, 1196, 1421109662, 1, 1204),
(185, 16, 60, 0, 5523, 'description', 0, 1170, 85, 1204, 1421109662, 1, 1232),
(185, 16, 60, 0, 5524, 'description', 0, 1233, 86, 1232, 1421109662, 1, 1170),
(185, 16, 60, 0, 5525, 'description', 0, 1234, 87, 1170, 1421109662, 1, 1233),
(185, 16, 60, 0, 5526, 'description', 0, 1235, 88, 1233, 1421109662, 1, 1234),
(185, 16, 60, 0, 5527, 'description', 0, 1197, 89, 1234, 1421109662, 1, 1235),
(185, 16, 60, 0, 5528, 'description', 0, 1236, 90, 1235, 1421109662, 1, 1197),
(185, 16, 60, 0, 5529, 'description', 0, 1237, 91, 1197, 1421109662, 1, 1236),
(185, 16, 60, 0, 5530, 'description', 0, 1238, 92, 1236, 1421109662, 1, 1237),
(185, 16, 60, 0, 5531, 'description', 0, 1192, 93, 1237, 1421109662, 1, 1238),
(185, 16, 60, 0, 5532, 'description', 0, 1179, 94, 1238, 1421109662, 1, 1192),
(185, 16, 60, 0, 5533, 'description', 0, 1239, 95, 1192, 1421109662, 1, 1179),
(185, 16, 60, 0, 5534, 'description', 0, 1240, 96, 1179, 1421109662, 1, 1239),
(185, 16, 60, 0, 5535, 'description', 0, 1193, 97, 1239, 1421109662, 1, 1240),
(185, 16, 60, 0, 5536, 'description', 0, 1241, 98, 1240, 1421109662, 1, 1193),
(185, 16, 60, 0, 5537, 'description', 0, 1242, 99, 1193, 1421109662, 1, 1241),
(185, 16, 60, 0, 5538, 'description', 0, 1243, 100, 1241, 1421109662, 1, 1242),
(185, 16, 60, 0, 5539, 'description', 0, 1244, 101, 1242, 1421109662, 1, 1243),
(185, 16, 60, 0, 5540, 'description', 0, 1213, 102, 1243, 1421109662, 1, 1244),
(185, 16, 60, 0, 5541, 'description', 0, 1245, 103, 1244, 1421109662, 1, 1213),
(185, 16, 60, 0, 5542, 'description', 0, 1179, 104, 1213, 1421109662, 1, 1245),
(185, 16, 60, 0, 5543, 'description', 0, 1180, 105, 1245, 1421109662, 1, 1179),
(185, 16, 60, 0, 5544, 'description', 0, 1181, 106, 1179, 1421109662, 1, 1180),
(185, 16, 60, 0, 5545, 'description', 0, 1182, 107, 1180, 1421109662, 1, 1181),
(185, 16, 60, 0, 5546, 'description', 0, 1183, 108, 1181, 1421109662, 1, 1182),
(185, 16, 60, 0, 5547, 'description', 0, 1184, 109, 1182, 1421109662, 1, 1183),
(185, 16, 60, 0, 5548, 'description', 0, 1063, 110, 1183, 1421109662, 1, 1184),
(185, 16, 60, 0, 5549, 'description', 0, 1185, 111, 1184, 1421109662, 1, 1063),
(185, 16, 60, 0, 5550, 'description', 0, 1186, 112, 1063, 1421109662, 1, 1185),
(185, 16, 60, 0, 5551, 'description', 0, 1187, 113, 1185, 1421109662, 1, 1186),
(185, 16, 60, 0, 5552, 'description', 0, 1188, 114, 1186, 1421109662, 1, 1187),
(185, 16, 60, 0, 5553, 'description', 0, 1189, 115, 1187, 1421109662, 1, 1188),
(185, 16, 60, 0, 5554, 'description', 0, 1190, 116, 1188, 1421109662, 1, 1189),
(185, 16, 60, 0, 5555, 'description', 0, 1179, 117, 1189, 1421109662, 1, 1190),
(185, 16, 60, 0, 5556, 'description', 0, 1191, 118, 1190, 1421109662, 1, 1179),
(185, 16, 60, 0, 5557, 'description', 0, 1192, 119, 1179, 1421109662, 1, 1191),
(185, 16, 60, 0, 5558, 'description', 0, 1193, 120, 1191, 1421109662, 1, 1192),
(185, 16, 60, 0, 5559, 'description', 0, 1185, 121, 1192, 1421109662, 1, 1193),
(185, 16, 60, 0, 5560, 'description', 0, 1194, 122, 1193, 1421109662, 1, 1185),
(185, 16, 60, 0, 5561, 'description', 0, 1181, 123, 1185, 1421109662, 1, 1194),
(185, 16, 60, 0, 5562, 'description', 0, 1195, 124, 1194, 1421109662, 1, 1181),
(185, 16, 60, 0, 5563, 'description', 0, 1196, 125, 1181, 1421109662, 1, 1195),
(185, 16, 60, 0, 5564, 'description', 0, 1197, 126, 1195, 1421109662, 1, 1196),
(185, 16, 60, 0, 5565, 'description', 0, 1198, 127, 1196, 1421109662, 1, 1197),
(185, 16, 60, 0, 5566, 'description', 0, 1199, 128, 1197, 1421109662, 1, 1198),
(185, 16, 60, 0, 5567, 'description', 0, 1200, 129, 1198, 1421109662, 1, 1199),
(185, 16, 60, 0, 5568, 'description', 0, 1201, 130, 1199, 1421109662, 1, 1200),
(185, 16, 60, 0, 5569, 'description', 0, 1202, 131, 1200, 1421109662, 1, 1201),
(185, 16, 60, 0, 5570, 'description', 0, 1199, 132, 1201, 1421109662, 1, 1202),
(185, 16, 60, 0, 5571, 'description', 0, 1203, 133, 1202, 1421109662, 1, 1199),
(185, 16, 60, 0, 5572, 'description', 0, 1168, 134, 1199, 1421109662, 1, 1203),
(185, 16, 60, 0, 5573, 'description', 0, 1204, 135, 1203, 1421109662, 1, 1168),
(185, 16, 60, 0, 5574, 'description', 0, 1205, 136, 1168, 1421109662, 1, 1204),
(185, 16, 60, 0, 5575, 'description', 0, 1206, 137, 1204, 1421109662, 1, 1205),
(185, 16, 60, 0, 5576, 'description', 0, 1207, 138, 1205, 1421109662, 1, 1206),
(185, 16, 60, 0, 5577, 'description', 0, 1208, 139, 1206, 1421109662, 1, 1207),
(185, 16, 60, 0, 5578, 'description', 0, 1209, 140, 1207, 1421109662, 1, 1208),
(185, 16, 60, 0, 5579, 'description', 0, 1210, 141, 1208, 1421109662, 1, 1209),
(185, 16, 60, 0, 5580, 'description', 0, 1211, 142, 1209, 1421109662, 1, 1210),
(185, 16, 60, 0, 5581, 'description', 0, 1199, 143, 1210, 1421109662, 1, 1211),
(185, 16, 60, 0, 5582, 'description', 0, 1212, 144, 1211, 1421109662, 1, 1199),
(185, 16, 60, 0, 5583, 'description', 0, 1213, 145, 1199, 1421109662, 1, 1212),
(185, 16, 60, 0, 5584, 'description', 0, 1214, 146, 1212, 1421109662, 1, 1213),
(185, 16, 60, 0, 5585, 'description', 0, 1215, 147, 1213, 1421109662, 1, 1214),
(185, 16, 60, 0, 5586, 'description', 0, 1216, 148, 1214, 1421109662, 1, 1215),
(185, 16, 60, 0, 5587, 'description', 0, 1180, 149, 1215, 1421109662, 1, 1216),
(185, 16, 60, 0, 5588, 'description', 0, 1179, 150, 1216, 1421109662, 1, 1180),
(185, 16, 60, 0, 5589, 'description', 0, 1217, 151, 1180, 1421109662, 1, 1179),
(185, 16, 60, 0, 5590, 'description', 0, 1181, 152, 1179, 1421109662, 1, 1217),
(185, 16, 60, 0, 5591, 'description', 0, 1218, 153, 1217, 1421109662, 1, 1181),
(185, 16, 60, 0, 5592, 'description', 0, 1196, 154, 1181, 1421109662, 1, 1218),
(185, 16, 60, 0, 5593, 'description', 0, 1179, 155, 1218, 1421109662, 1, 1196),
(185, 16, 60, 0, 5594, 'description', 0, 1219, 156, 1196, 1421109662, 1, 1179),
(185, 16, 60, 0, 5595, 'description', 0, 1220, 157, 1179, 1421109662, 1, 1219),
(185, 16, 60, 0, 5596, 'description', 0, 1179, 158, 1219, 1421109662, 1, 1220),
(185, 16, 60, 0, 5597, 'description', 0, 1221, 159, 1220, 1421109662, 1, 1179),
(185, 16, 60, 0, 5598, 'description', 0, 1222, 160, 1179, 1421109662, 1, 1221),
(185, 16, 60, 0, 5599, 'description', 0, 1223, 161, 1221, 1421109662, 1, 1222),
(185, 16, 60, 0, 5600, 'description', 0, 1192, 162, 1222, 1421109662, 1, 1223),
(185, 16, 60, 0, 5601, 'description', 0, 1029, 163, 1223, 1421109662, 1, 1192),
(185, 16, 60, 0, 5602, 'description', 0, 1224, 164, 1192, 1421109662, 1, 1029),
(185, 16, 60, 0, 5603, 'description', 0, 1225, 165, 1029, 1421109662, 1, 1224),
(185, 16, 60, 0, 5604, 'description', 0, 1226, 166, 1224, 1421109662, 1, 1225),
(185, 16, 60, 0, 5605, 'description', 0, 1197, 167, 1225, 1421109662, 1, 1226),
(185, 16, 60, 0, 5606, 'description', 0, 1227, 168, 1226, 1421109662, 1, 1197),
(185, 16, 60, 0, 5607, 'description', 0, 1216, 169, 1197, 1421109662, 1, 1227),
(185, 16, 60, 0, 5608, 'description', 0, 1180, 170, 1227, 1421109662, 1, 1216),
(185, 16, 60, 0, 5609, 'description', 0, 1179, 171, 1216, 1421109662, 1, 1180),
(185, 16, 60, 0, 5610, 'description', 0, 1217, 172, 1180, 1421109662, 1, 1179),
(185, 16, 60, 0, 5611, 'description', 0, 1228, 173, 1179, 1421109662, 1, 1217),
(185, 16, 60, 0, 5612, 'description', 0, 1229, 174, 1217, 1421109662, 1, 1228),
(185, 16, 60, 0, 5613, 'description', 0, 1179, 175, 1228, 1421109662, 1, 1229),
(185, 16, 60, 0, 5614, 'description', 0, 1180, 176, 1229, 1421109662, 1, 1179),
(185, 16, 60, 0, 5615, 'description', 0, 1230, 177, 1179, 1421109662, 1, 1180),
(185, 16, 60, 0, 5616, 'description', 0, 1216, 178, 1180, 1421109662, 1, 1230),
(185, 16, 60, 0, 5617, 'description', 0, 1179, 179, 1230, 1421109662, 1, 1216),
(185, 16, 60, 0, 5618, 'description', 0, 1180, 180, 1216, 1421109662, 1, 1179),
(185, 16, 60, 0, 5619, 'description', 0, 1231, 181, 1179, 1421109662, 1, 1180),
(185, 16, 60, 0, 5620, 'description', 0, 1181, 182, 1180, 1421109662, 1, 1231),
(185, 16, 60, 0, 5621, 'description', 0, 1196, 183, 1231, 1421109662, 1, 1181),
(185, 16, 60, 0, 5622, 'description', 0, 1204, 184, 1181, 1421109662, 1, 1196),
(185, 16, 60, 0, 5623, 'description', 0, 1232, 185, 1196, 1421109662, 1, 1204),
(185, 16, 60, 0, 5624, 'description', 0, 1170, 186, 1204, 1421109662, 1, 1232),
(185, 16, 60, 0, 5625, 'description', 0, 1233, 187, 1232, 1421109662, 1, 1170),
(185, 16, 60, 0, 5626, 'description', 0, 1234, 188, 1170, 1421109662, 1, 1233),
(185, 16, 60, 0, 5627, 'description', 0, 1235, 189, 1233, 1421109662, 1, 1234),
(185, 16, 60, 0, 5628, 'description', 0, 1197, 190, 1234, 1421109662, 1, 1235),
(185, 16, 60, 0, 5629, 'description', 0, 1236, 191, 1235, 1421109662, 1, 1197),
(185, 16, 60, 0, 5630, 'description', 0, 1237, 192, 1197, 1421109662, 1, 1236),
(185, 16, 60, 0, 5631, 'description', 0, 1238, 193, 1236, 1421109662, 1, 1237),
(185, 16, 60, 0, 5632, 'description', 0, 1192, 194, 1237, 1421109662, 1, 1238),
(185, 16, 60, 0, 5633, 'description', 0, 1179, 195, 1238, 1421109662, 1, 1192),
(185, 16, 60, 0, 5634, 'description', 0, 1239, 196, 1192, 1421109662, 1, 1179),
(185, 16, 60, 0, 5635, 'description', 0, 1240, 197, 1179, 1421109662, 1, 1239),
(185, 16, 60, 0, 5636, 'description', 0, 1193, 198, 1239, 1421109662, 1, 1240),
(185, 16, 60, 0, 5637, 'description', 0, 1241, 199, 1240, 1421109662, 1, 1193),
(185, 16, 60, 0, 5638, 'description', 0, 1242, 200, 1193, 1421109662, 1, 1241),
(185, 16, 60, 0, 5639, 'description', 0, 1243, 201, 1241, 1421109662, 1, 1242),
(185, 16, 60, 0, 5640, 'description', 0, 1244, 202, 1242, 1421109662, 1, 1243),
(185, 16, 60, 0, 5641, 'description', 0, 1213, 203, 1243, 1421109662, 1, 1244),
(185, 16, 60, 0, 5642, 'description', 0, 1245, 204, 1244, 1421109662, 1, 1213),
(185, 16, 60, 0, 5643, 'description', 0, 0, 205, 1213, 1421109662, 1, 1245),
(184, 16, 61, 0, 5648, 'short_description', 0, 1128, 4, 1128, 1421109748, 1, 1129),
(184, 16, 61, 0, 5649, 'short_description', 0, 1179, 5, 1129, 1421109748, 1, 1128),
(184, 16, 61, 0, 5650, 'short_description', 0, 1180, 6, 1128, 1421109748, 1, 1179),
(184, 16, 61, 0, 5651, 'short_description', 0, 1181, 7, 1179, 1421109748, 1, 1180),
(184, 16, 61, 0, 5652, 'short_description', 0, 1182, 8, 1180, 1421109748, 1, 1181),
(184, 16, 61, 0, 5653, 'short_description', 0, 1183, 9, 1181, 1421109748, 1, 1182),
(184, 16, 61, 0, 5654, 'short_description', 0, 1184, 10, 1182, 1421109748, 1, 1183),
(184, 16, 61, 0, 5655, 'short_description', 0, 1063, 11, 1183, 1421109748, 1, 1184),
(184, 16, 61, 0, 5656, 'short_description', 0, 1185, 12, 1184, 1421109748, 1, 1063),
(184, 16, 61, 0, 5657, 'short_description', 0, 1186, 13, 1063, 1421109748, 1, 1185),
(184, 16, 61, 0, 5658, 'short_description', 0, 1187, 14, 1185, 1421109748, 1, 1186),
(184, 16, 61, 0, 5659, 'short_description', 0, 1188, 15, 1186, 1421109748, 1, 1187),
(184, 16, 61, 0, 5660, 'short_description', 0, 1189, 16, 1187, 1421109748, 1, 1188),
(184, 16, 61, 0, 5661, 'short_description', 0, 1190, 17, 1188, 1421109748, 1, 1189),
(184, 16, 61, 0, 5662, 'short_description', 0, 1179, 18, 1189, 1421109748, 1, 1190),
(184, 16, 61, 0, 5663, 'short_description', 0, 1191, 19, 1190, 1421109748, 1, 1179),
(184, 16, 61, 0, 5664, 'short_description', 0, 1192, 20, 1179, 1421109748, 1, 1191),
(184, 16, 61, 0, 5665, 'short_description', 0, 1193, 21, 1191, 1421109748, 1, 1192),
(184, 16, 61, 0, 5666, 'short_description', 0, 1185, 22, 1192, 1421109748, 1, 1193),
(184, 16, 61, 0, 5667, 'short_description', 0, 1194, 23, 1193, 1421109748, 1, 1185),
(184, 16, 61, 0, 5668, 'short_description', 0, 1181, 24, 1185, 1421109748, 1, 1194),
(184, 16, 61, 0, 5669, 'short_description', 0, 1195, 25, 1194, 1421109748, 1, 1181),
(184, 16, 61, 0, 5670, 'short_description', 0, 1196, 26, 1181, 1421109748, 1, 1195),
(184, 16, 61, 0, 5671, 'short_description', 0, 1197, 27, 1195, 1421109748, 1, 1196),
(184, 16, 61, 0, 5672, 'short_description', 0, 1198, 28, 1196, 1421109748, 1, 1197),
(184, 16, 61, 0, 5673, 'short_description', 0, 1199, 29, 1197, 1421109748, 1, 1198),
(184, 16, 61, 0, 5674, 'short_description', 0, 1200, 30, 1198, 1421109748, 1, 1199),
(184, 16, 61, 0, 5675, 'short_description', 0, 1201, 31, 1199, 1421109748, 1, 1200),
(184, 16, 61, 0, 5676, 'short_description', 0, 1202, 32, 1200, 1421109748, 1, 1201),
(184, 16, 61, 0, 5677, 'short_description', 0, 1129, 33, 1201, 1421109748, 1, 1202),
(185, 16, 61, 0, 5678, 'description', 0, 1128, 34, 1202, 1421109748, 1, 1129),
(185, 16, 61, 0, 5679, 'description', 0, 1199, 35, 1129, 1421109748, 1, 1128),
(185, 16, 61, 0, 5680, 'description', 0, 1203, 36, 1128, 1421109748, 1, 1199),
(185, 16, 61, 0, 5681, 'description', 0, 1168, 37, 1199, 1421109748, 1, 1203),
(185, 16, 61, 0, 5682, 'description', 0, 1204, 38, 1203, 1421109748, 1, 1168),
(185, 16, 61, 0, 5683, 'description', 0, 1205, 39, 1168, 1421109748, 1, 1204),
(185, 16, 61, 0, 5684, 'description', 0, 1206, 40, 1204, 1421109748, 1, 1205),
(185, 16, 61, 0, 5685, 'description', 0, 1207, 41, 1205, 1421109748, 1, 1206),
(185, 16, 61, 0, 5686, 'description', 0, 1208, 42, 1206, 1421109748, 1, 1207),
(185, 16, 61, 0, 5687, 'description', 0, 1209, 43, 1207, 1421109748, 1, 1208),
(185, 16, 61, 0, 5688, 'description', 0, 1210, 44, 1208, 1421109748, 1, 1209),
(185, 16, 61, 0, 5689, 'description', 0, 1211, 45, 1209, 1421109748, 1, 1210),
(185, 16, 61, 0, 5690, 'description', 0, 1199, 46, 1210, 1421109748, 1, 1211),
(185, 16, 61, 0, 5691, 'description', 0, 1212, 47, 1211, 1421109748, 1, 1199),
(185, 16, 61, 0, 5692, 'description', 0, 1213, 48, 1199, 1421109748, 1, 1212),
(185, 16, 61, 0, 5693, 'description', 0, 1214, 49, 1212, 1421109748, 1, 1213),
(185, 16, 61, 0, 5694, 'description', 0, 1215, 50, 1213, 1421109748, 1, 1214),
(185, 16, 61, 0, 5695, 'description', 0, 1216, 51, 1214, 1421109748, 1, 1215),
(185, 16, 61, 0, 5696, 'description', 0, 1180, 52, 1215, 1421109748, 1, 1216),
(185, 16, 61, 0, 5697, 'description', 0, 1179, 53, 1216, 1421109748, 1, 1180),
(185, 16, 61, 0, 5698, 'description', 0, 1217, 54, 1180, 1421109748, 1, 1179),
(185, 16, 61, 0, 5699, 'description', 0, 1181, 55, 1179, 1421109748, 1, 1217),
(185, 16, 61, 0, 5700, 'description', 0, 1218, 56, 1217, 1421109748, 1, 1181),
(185, 16, 61, 0, 5701, 'description', 0, 1196, 57, 1181, 1421109748, 1, 1218),
(185, 16, 61, 0, 5702, 'description', 0, 1179, 58, 1218, 1421109748, 1, 1196),
(185, 16, 61, 0, 5703, 'description', 0, 1219, 59, 1196, 1421109748, 1, 1179),
(185, 16, 61, 0, 5704, 'description', 0, 1220, 60, 1179, 1421109748, 1, 1219),
(185, 16, 61, 0, 5705, 'description', 0, 1179, 61, 1219, 1421109748, 1, 1220),
(185, 16, 61, 0, 5706, 'description', 0, 1221, 62, 1220, 1421109748, 1, 1179),
(185, 16, 61, 0, 5707, 'description', 0, 1222, 63, 1179, 1421109748, 1, 1221),
(185, 16, 61, 0, 5708, 'description', 0, 1223, 64, 1221, 1421109748, 1, 1222),
(185, 16, 61, 0, 5709, 'description', 0, 1192, 65, 1222, 1421109748, 1, 1223),
(185, 16, 61, 0, 5710, 'description', 0, 1029, 66, 1223, 1421109748, 1, 1192),
(185, 16, 61, 0, 5711, 'description', 0, 1224, 67, 1192, 1421109748, 1, 1029),
(185, 16, 61, 0, 5712, 'description', 0, 1225, 68, 1029, 1421109748, 1, 1224),
(185, 16, 61, 0, 5713, 'description', 0, 1226, 69, 1224, 1421109748, 1, 1225),
(185, 16, 61, 0, 5714, 'description', 0, 1197, 70, 1225, 1421109748, 1, 1226),
(185, 16, 61, 0, 5715, 'description', 0, 1227, 71, 1226, 1421109748, 1, 1197),
(185, 16, 61, 0, 5716, 'description', 0, 1216, 72, 1197, 1421109748, 1, 1227),
(185, 16, 61, 0, 5717, 'description', 0, 1180, 73, 1227, 1421109748, 1, 1216),
(185, 16, 61, 0, 5718, 'description', 0, 1179, 74, 1216, 1421109748, 1, 1180),
(185, 16, 61, 0, 5719, 'description', 0, 1217, 75, 1180, 1421109748, 1, 1179),
(185, 16, 61, 0, 5720, 'description', 0, 1228, 76, 1179, 1421109748, 1, 1217),
(185, 16, 61, 0, 5721, 'description', 0, 1229, 77, 1217, 1421109748, 1, 1228),
(185, 16, 61, 0, 5722, 'description', 0, 1179, 78, 1228, 1421109748, 1, 1229),
(185, 16, 61, 0, 5723, 'description', 0, 1180, 79, 1229, 1421109748, 1, 1179),
(185, 16, 61, 0, 5724, 'description', 0, 1230, 80, 1179, 1421109748, 1, 1180),
(185, 16, 61, 0, 5725, 'description', 0, 1216, 81, 1180, 1421109748, 1, 1230),
(185, 16, 61, 0, 5726, 'description', 0, 1179, 82, 1230, 1421109748, 1, 1216),
(185, 16, 61, 0, 5727, 'description', 0, 1180, 83, 1216, 1421109748, 1, 1179),
(185, 16, 61, 0, 5728, 'description', 0, 1231, 84, 1179, 1421109748, 1, 1180),
(185, 16, 61, 0, 5729, 'description', 0, 1181, 85, 1180, 1421109748, 1, 1231),
(185, 16, 61, 0, 5730, 'description', 0, 1196, 86, 1231, 1421109748, 1, 1181),
(185, 16, 61, 0, 5731, 'description', 0, 1204, 87, 1181, 1421109748, 1, 1196),
(185, 16, 61, 0, 5732, 'description', 0, 1232, 88, 1196, 1421109748, 1, 1204),
(185, 16, 61, 0, 5733, 'description', 0, 1170, 89, 1204, 1421109748, 1, 1232),
(185, 16, 61, 0, 5734, 'description', 0, 1233, 90, 1232, 1421109748, 1, 1170),
(185, 16, 61, 0, 5735, 'description', 0, 1234, 91, 1170, 1421109748, 1, 1233),
(185, 16, 61, 0, 5736, 'description', 0, 1235, 92, 1233, 1421109748, 1, 1234),
(185, 16, 61, 0, 5737, 'description', 0, 1197, 93, 1234, 1421109748, 1, 1235),
(185, 16, 61, 0, 5738, 'description', 0, 1236, 94, 1235, 1421109748, 1, 1197),
(185, 16, 61, 0, 5739, 'description', 0, 1237, 95, 1197, 1421109748, 1, 1236),
(185, 16, 61, 0, 5740, 'description', 0, 1238, 96, 1236, 1421109748, 1, 1237),
(185, 16, 61, 0, 5741, 'description', 0, 1192, 97, 1237, 1421109748, 1, 1238),
(185, 16, 61, 0, 5742, 'description', 0, 1179, 98, 1238, 1421109748, 1, 1192),
(185, 16, 61, 0, 5743, 'description', 0, 1239, 99, 1192, 1421109748, 1, 1179),
(185, 16, 61, 0, 5744, 'description', 0, 1240, 100, 1179, 1421109748, 1, 1239),
(185, 16, 61, 0, 5745, 'description', 0, 1193, 101, 1239, 1421109748, 1, 1240),
(185, 16, 61, 0, 5746, 'description', 0, 1241, 102, 1240, 1421109748, 1, 1193),
(185, 16, 61, 0, 5747, 'description', 0, 1242, 103, 1193, 1421109748, 1, 1241),
(185, 16, 61, 0, 5748, 'description', 0, 1243, 104, 1241, 1421109748, 1, 1242),
(185, 16, 61, 0, 5749, 'description', 0, 1244, 105, 1242, 1421109748, 1, 1243),
(185, 16, 61, 0, 5750, 'description', 0, 1213, 106, 1243, 1421109748, 1, 1244),
(185, 16, 61, 0, 5751, 'description', 0, 1245, 107, 1244, 1421109748, 1, 1213),
(185, 16, 61, 0, 5752, 'description', 0, 1246, 108, 1213, 1421109748, 1, 1245),
(185, 16, 61, 0, 5753, 'description', 0, 1127, 109, 1245, 1421109748, 1, 1246),
(185, 16, 61, 0, 5754, 'description', 0, 1129, 110, 1246, 1421109748, 1, 1127),
(185, 16, 61, 0, 5755, 'description', 0, 1128, 111, 1127, 1421109748, 1, 1129),
(185, 16, 61, 0, 5756, 'description', 0, 1179, 112, 1129, 1421109748, 1, 1128),
(185, 16, 61, 0, 5757, 'description', 0, 1180, 113, 1128, 1421109748, 1, 1179),
(185, 16, 61, 0, 5758, 'description', 0, 1181, 114, 1179, 1421109748, 1, 1180),
(185, 16, 61, 0, 5759, 'description', 0, 1182, 115, 1180, 1421109748, 1, 1181),
(185, 16, 61, 0, 5760, 'description', 0, 1183, 116, 1181, 1421109748, 1, 1182),
(185, 16, 61, 0, 5761, 'description', 0, 1184, 117, 1182, 1421109748, 1, 1183),
(185, 16, 61, 0, 5762, 'description', 0, 1063, 118, 1183, 1421109748, 1, 1184),
(185, 16, 61, 0, 5763, 'description', 0, 1185, 119, 1184, 1421109748, 1, 1063),
(185, 16, 61, 0, 5764, 'description', 0, 1186, 120, 1063, 1421109748, 1, 1185),
(185, 16, 61, 0, 5765, 'description', 0, 1187, 121, 1185, 1421109748, 1, 1186),
(185, 16, 61, 0, 5766, 'description', 0, 1188, 122, 1186, 1421109748, 1, 1187),
(185, 16, 61, 0, 5767, 'description', 0, 1189, 123, 1187, 1421109748, 1, 1188),
(185, 16, 61, 0, 5768, 'description', 0, 1190, 124, 1188, 1421109748, 1, 1189),
(185, 16, 61, 0, 5769, 'description', 0, 1179, 125, 1189, 1421109748, 1, 1190),
(185, 16, 61, 0, 5770, 'description', 0, 1191, 126, 1190, 1421109748, 1, 1179),
(185, 16, 61, 0, 5771, 'description', 0, 1192, 127, 1179, 1421109748, 1, 1191),
(185, 16, 61, 0, 5772, 'description', 0, 1193, 128, 1191, 1421109748, 1, 1192),
(185, 16, 61, 0, 5773, 'description', 0, 1185, 129, 1192, 1421109748, 1, 1193),
(185, 16, 61, 0, 5774, 'description', 0, 1194, 130, 1193, 1421109748, 1, 1185),
(185, 16, 61, 0, 5775, 'description', 0, 1181, 131, 1185, 1421109748, 1, 1194),
(185, 16, 61, 0, 5776, 'description', 0, 1195, 132, 1194, 1421109748, 1, 1181),
(185, 16, 61, 0, 5777, 'description', 0, 1196, 133, 1181, 1421109748, 1, 1195),
(185, 16, 61, 0, 5778, 'description', 0, 1197, 134, 1195, 1421109748, 1, 1196),
(185, 16, 61, 0, 5779, 'description', 0, 1198, 135, 1196, 1421109748, 1, 1197),
(185, 16, 61, 0, 5780, 'description', 0, 1199, 136, 1197, 1421109748, 1, 1198),
(185, 16, 61, 0, 5781, 'description', 0, 1200, 137, 1198, 1421109748, 1, 1199),
(185, 16, 61, 0, 5782, 'description', 0, 1201, 138, 1199, 1421109748, 1, 1200),
(185, 16, 61, 0, 5783, 'description', 0, 1202, 139, 1200, 1421109748, 1, 1201),
(185, 16, 61, 0, 5784, 'description', 0, 1199, 140, 1201, 1421109748, 1, 1202),
(185, 16, 61, 0, 5785, 'description', 0, 1203, 141, 1202, 1421109748, 1, 1199),
(185, 16, 61, 0, 5786, 'description', 0, 1168, 142, 1199, 1421109748, 1, 1203),
(185, 16, 61, 0, 5787, 'description', 0, 1204, 143, 1203, 1421109748, 1, 1168),
(185, 16, 61, 0, 5788, 'description', 0, 1205, 144, 1168, 1421109748, 1, 1204),
(185, 16, 61, 0, 5789, 'description', 0, 1206, 145, 1204, 1421109748, 1, 1205),
(185, 16, 61, 0, 5790, 'description', 0, 1207, 146, 1205, 1421109748, 1, 1206),
(185, 16, 61, 0, 5791, 'description', 0, 1208, 147, 1206, 1421109748, 1, 1207),
(185, 16, 61, 0, 5792, 'description', 0, 1209, 148, 1207, 1421109748, 1, 1208),
(185, 16, 61, 0, 5793, 'description', 0, 1210, 149, 1208, 1421109748, 1, 1209),
(185, 16, 61, 0, 5794, 'description', 0, 1211, 150, 1209, 1421109748, 1, 1210),
(185, 16, 61, 0, 5795, 'description', 0, 1199, 151, 1210, 1421109748, 1, 1211),
(185, 16, 61, 0, 5796, 'description', 0, 1212, 152, 1211, 1421109748, 1, 1199),
(185, 16, 61, 0, 5797, 'description', 0, 1213, 153, 1199, 1421109748, 1, 1212),
(185, 16, 61, 0, 5798, 'description', 0, 1214, 154, 1212, 1421109748, 1, 1213),
(185, 16, 61, 0, 5799, 'description', 0, 1215, 155, 1213, 1421109748, 1, 1214),
(185, 16, 61, 0, 5800, 'description', 0, 1216, 156, 1214, 1421109748, 1, 1215),
(185, 16, 61, 0, 5801, 'description', 0, 1180, 157, 1215, 1421109748, 1, 1216),
(185, 16, 61, 0, 5802, 'description', 0, 1179, 158, 1216, 1421109748, 1, 1180),
(185, 16, 61, 0, 5803, 'description', 0, 1217, 159, 1180, 1421109748, 1, 1179),
(185, 16, 61, 0, 5804, 'description', 0, 1181, 160, 1179, 1421109748, 1, 1217),
(185, 16, 61, 0, 5805, 'description', 0, 1218, 161, 1217, 1421109748, 1, 1181),
(185, 16, 61, 0, 5806, 'description', 0, 1196, 162, 1181, 1421109748, 1, 1218),
(185, 16, 61, 0, 5807, 'description', 0, 1179, 163, 1218, 1421109748, 1, 1196),
(185, 16, 61, 0, 5808, 'description', 0, 1219, 164, 1196, 1421109748, 1, 1179),
(185, 16, 61, 0, 5809, 'description', 0, 1220, 165, 1179, 1421109748, 1, 1219),
(185, 16, 61, 0, 5810, 'description', 0, 1179, 166, 1219, 1421109748, 1, 1220),
(185, 16, 61, 0, 5811, 'description', 0, 1221, 167, 1220, 1421109748, 1, 1179),
(185, 16, 61, 0, 5812, 'description', 0, 1222, 168, 1179, 1421109748, 1, 1221),
(185, 16, 61, 0, 5813, 'description', 0, 1223, 169, 1221, 1421109748, 1, 1222),
(185, 16, 61, 0, 5814, 'description', 0, 1192, 170, 1222, 1421109748, 1, 1223),
(185, 16, 61, 0, 5815, 'description', 0, 1029, 171, 1223, 1421109748, 1, 1192),
(185, 16, 61, 0, 5816, 'description', 0, 1224, 172, 1192, 1421109748, 1, 1029),
(185, 16, 61, 0, 5817, 'description', 0, 1225, 173, 1029, 1421109748, 1, 1224),
(185, 16, 61, 0, 5818, 'description', 0, 1226, 174, 1224, 1421109748, 1, 1225),
(185, 16, 61, 0, 5819, 'description', 0, 1197, 175, 1225, 1421109748, 1, 1226),
(185, 16, 61, 0, 5820, 'description', 0, 1227, 176, 1226, 1421109748, 1, 1197),
(185, 16, 61, 0, 5821, 'description', 0, 1216, 177, 1197, 1421109748, 1, 1227),
(185, 16, 61, 0, 5822, 'description', 0, 1180, 178, 1227, 1421109748, 1, 1216),
(185, 16, 61, 0, 5823, 'description', 0, 1179, 179, 1216, 1421109748, 1, 1180),
(185, 16, 61, 0, 5824, 'description', 0, 1217, 180, 1180, 1421109748, 1, 1179),
(185, 16, 61, 0, 5825, 'description', 0, 1228, 181, 1179, 1421109748, 1, 1217),
(185, 16, 61, 0, 5826, 'description', 0, 1229, 182, 1217, 1421109748, 1, 1228),
(185, 16, 61, 0, 5827, 'description', 0, 1179, 183, 1228, 1421109748, 1, 1229),
(185, 16, 61, 0, 5828, 'description', 0, 1180, 184, 1229, 1421109748, 1, 1179),
(185, 16, 61, 0, 5829, 'description', 0, 1230, 185, 1179, 1421109748, 1, 1180),
(185, 16, 61, 0, 5830, 'description', 0, 1216, 186, 1180, 1421109748, 1, 1230),
(185, 16, 61, 0, 5831, 'description', 0, 1179, 187, 1230, 1421109748, 1, 1216),
(185, 16, 61, 0, 5832, 'description', 0, 1180, 188, 1216, 1421109748, 1, 1179),
(185, 16, 61, 0, 5833, 'description', 0, 1231, 189, 1179, 1421109748, 1, 1180),
(185, 16, 61, 0, 5834, 'description', 0, 1181, 190, 1180, 1421109748, 1, 1231),
(185, 16, 61, 0, 5835, 'description', 0, 1196, 191, 1231, 1421109748, 1, 1181),
(185, 16, 61, 0, 5836, 'description', 0, 1204, 192, 1181, 1421109748, 1, 1196),
(185, 16, 61, 0, 5837, 'description', 0, 1232, 193, 1196, 1421109748, 1, 1204),
(185, 16, 61, 0, 5838, 'description', 0, 1170, 194, 1204, 1421109748, 1, 1232),
(185, 16, 61, 0, 5839, 'description', 0, 1233, 195, 1232, 1421109748, 1, 1170),
(185, 16, 61, 0, 5840, 'description', 0, 1234, 196, 1170, 1421109748, 1, 1233),
(185, 16, 61, 0, 5841, 'description', 0, 1235, 197, 1233, 1421109748, 1, 1234),
(185, 16, 61, 0, 5842, 'description', 0, 1197, 198, 1234, 1421109748, 1, 1235),
(185, 16, 61, 0, 5843, 'description', 0, 1236, 199, 1235, 1421109748, 1, 1197),
(185, 16, 61, 0, 5844, 'description', 0, 1237, 200, 1197, 1421109748, 1, 1236),
(185, 16, 61, 0, 5845, 'description', 0, 1238, 201, 1236, 1421109748, 1, 1237),
(185, 16, 61, 0, 5846, 'description', 0, 1192, 202, 1237, 1421109748, 1, 1238),
(185, 16, 61, 0, 5847, 'description', 0, 1179, 203, 1238, 1421109748, 1, 1192),
(185, 16, 61, 0, 5848, 'description', 0, 1239, 204, 1192, 1421109748, 1, 1179),
(185, 16, 61, 0, 5849, 'description', 0, 1240, 205, 1179, 1421109748, 1, 1239),
(185, 16, 61, 0, 5850, 'description', 0, 1193, 206, 1239, 1421109748, 1, 1240),
(185, 16, 61, 0, 5851, 'description', 0, 1241, 207, 1240, 1421109748, 1, 1193),
(185, 16, 61, 0, 5852, 'description', 0, 1242, 208, 1193, 1421109748, 1, 1241),
(185, 16, 61, 0, 5853, 'description', 0, 1243, 209, 1241, 1421109748, 1, 1242),
(185, 16, 61, 0, 5854, 'description', 0, 1244, 210, 1242, 1421109748, 1, 1243),
(185, 16, 61, 0, 5855, 'description', 0, 1213, 211, 1243, 1421109748, 1, 1244),
(185, 16, 61, 0, 5856, 'description', 0, 1245, 212, 1244, 1421109748, 1, 1213),
(185, 16, 61, 0, 5857, 'description', 0, 0, 213, 1213, 1421109748, 1, 1245),
(184, 16, 62, 0, 5862, 'short_description', 0, 1128, 4, 1127, 1421110056, 1, 1129),
(184, 16, 62, 0, 5863, 'short_description', 0, 1127, 5, 1129, 1421110056, 1, 1128),
(184, 16, 62, 0, 5864, 'short_description', 0, 1179, 6, 1128, 1421110056, 1, 1127),
(184, 16, 62, 0, 5865, 'short_description', 0, 1180, 7, 1127, 1421110056, 1, 1179),
(184, 16, 62, 0, 5866, 'short_description', 0, 1181, 8, 1179, 1421110056, 1, 1180),
(184, 16, 62, 0, 5867, 'short_description', 0, 1182, 9, 1180, 1421110056, 1, 1181),
(184, 16, 62, 0, 5868, 'short_description', 0, 1183, 10, 1181, 1421110056, 1, 1182),
(184, 16, 62, 0, 5869, 'short_description', 0, 1184, 11, 1182, 1421110056, 1, 1183),
(184, 16, 62, 0, 5870, 'short_description', 0, 1063, 12, 1183, 1421110056, 1, 1184),
(184, 16, 62, 0, 5871, 'short_description', 0, 1185, 13, 1184, 1421110056, 1, 1063),
(184, 16, 62, 0, 5872, 'short_description', 0, 1186, 14, 1063, 1421110056, 1, 1185),
(184, 16, 62, 0, 5873, 'short_description', 0, 1187, 15, 1185, 1421110056, 1, 1186),
(184, 16, 62, 0, 5874, 'short_description', 0, 1188, 16, 1186, 1421110056, 1, 1187),
(184, 16, 62, 0, 5875, 'short_description', 0, 1189, 17, 1187, 1421110056, 1, 1188),
(184, 16, 62, 0, 5876, 'short_description', 0, 1190, 18, 1188, 1421110056, 1, 1189),
(184, 16, 62, 0, 5877, 'short_description', 0, 1179, 19, 1189, 1421110056, 1, 1190),
(184, 16, 62, 0, 5878, 'short_description', 0, 1191, 20, 1190, 1421110056, 1, 1179),
(184, 16, 62, 0, 5879, 'short_description', 0, 1192, 21, 1179, 1421110056, 1, 1191),
(184, 16, 62, 0, 5880, 'short_description', 0, 1193, 22, 1191, 1421110056, 1, 1192),
(184, 16, 62, 0, 5881, 'short_description', 0, 1185, 23, 1192, 1421110056, 1, 1193),
(184, 16, 62, 0, 5882, 'short_description', 0, 1194, 24, 1193, 1421110056, 1, 1185),
(184, 16, 62, 0, 5883, 'short_description', 0, 1181, 25, 1185, 1421110056, 1, 1194),
(184, 16, 62, 0, 5884, 'short_description', 0, 1195, 26, 1194, 1421110056, 1, 1181),
(184, 16, 62, 0, 5885, 'short_description', 0, 1196, 27, 1181, 1421110056, 1, 1195),
(184, 16, 62, 0, 5886, 'short_description', 0, 1197, 28, 1195, 1421110056, 1, 1196),
(184, 16, 62, 0, 5887, 'short_description', 0, 1198, 29, 1196, 1421110056, 1, 1197),
(184, 16, 62, 0, 5888, 'short_description', 0, 1199, 30, 1197, 1421110056, 1, 1198),
(184, 16, 62, 0, 5889, 'short_description', 0, 1200, 31, 1198, 1421110056, 1, 1199),
(184, 16, 62, 0, 5890, 'short_description', 0, 1201, 32, 1199, 1421110056, 1, 1200),
(184, 16, 62, 0, 5891, 'short_description', 0, 1202, 33, 1200, 1421110056, 1, 1201),
(184, 16, 62, 0, 5892, 'short_description', 0, 1199, 34, 1201, 1421110056, 1, 1202),
(185, 16, 62, 0, 5893, 'description', 0, 1203, 35, 1202, 1421110056, 1, 1199),
(185, 16, 62, 0, 5894, 'description', 0, 1168, 36, 1199, 1421110056, 1, 1203),
(185, 16, 62, 0, 5895, 'description', 0, 1204, 37, 1203, 1421110056, 1, 1168),
(185, 16, 62, 0, 5896, 'description', 0, 1205, 38, 1168, 1421110056, 1, 1204),
(185, 16, 62, 0, 5897, 'description', 0, 1206, 39, 1204, 1421110056, 1, 1205),
(185, 16, 62, 0, 5898, 'description', 0, 1207, 40, 1205, 1421110056, 1, 1206),
(185, 16, 62, 0, 5899, 'description', 0, 1208, 41, 1206, 1421110056, 1, 1207),
(185, 16, 62, 0, 5900, 'description', 0, 1209, 42, 1207, 1421110056, 1, 1208),
(185, 16, 62, 0, 5901, 'description', 0, 1210, 43, 1208, 1421110056, 1, 1209),
(185, 16, 62, 0, 5902, 'description', 0, 1211, 44, 1209, 1421110056, 1, 1210),
(185, 16, 62, 0, 5903, 'description', 0, 1199, 45, 1210, 1421110056, 1, 1211),
(185, 16, 62, 0, 5904, 'description', 0, 1212, 46, 1211, 1421110056, 1, 1199),
(185, 16, 62, 0, 5905, 'description', 0, 1213, 47, 1199, 1421110056, 1, 1212),
(185, 16, 62, 0, 5906, 'description', 0, 1214, 48, 1212, 1421110056, 1, 1213),
(185, 16, 62, 0, 5907, 'description', 0, 1215, 49, 1213, 1421110056, 1, 1214),
(185, 16, 62, 0, 5908, 'description', 0, 1216, 50, 1214, 1421110056, 1, 1215),
(185, 16, 62, 0, 5909, 'description', 0, 1180, 51, 1215, 1421110056, 1, 1216),
(185, 16, 62, 0, 5910, 'description', 0, 1179, 52, 1216, 1421110056, 1, 1180),
(185, 16, 62, 0, 5911, 'description', 0, 1217, 53, 1180, 1421110056, 1, 1179),
(185, 16, 62, 0, 5912, 'description', 0, 1181, 54, 1179, 1421110056, 1, 1217),
(185, 16, 62, 0, 5913, 'description', 0, 1218, 55, 1217, 1421110056, 1, 1181),
(185, 16, 62, 0, 5914, 'description', 0, 1196, 56, 1181, 1421110056, 1, 1218),
(185, 16, 62, 0, 5915, 'description', 0, 1179, 57, 1218, 1421110056, 1, 1196),
(185, 16, 62, 0, 5916, 'description', 0, 1219, 58, 1196, 1421110056, 1, 1179),
(185, 16, 62, 0, 5917, 'description', 0, 1220, 59, 1179, 1421110056, 1, 1219),
(185, 16, 62, 0, 5918, 'description', 0, 1179, 60, 1219, 1421110056, 1, 1220),
(185, 16, 62, 0, 5919, 'description', 0, 1221, 61, 1220, 1421110056, 1, 1179),
(185, 16, 62, 0, 5920, 'description', 0, 1222, 62, 1179, 1421110056, 1, 1221),
(185, 16, 62, 0, 5921, 'description', 0, 1223, 63, 1221, 1421110056, 1, 1222),
(185, 16, 62, 0, 5922, 'description', 0, 1192, 64, 1222, 1421110056, 1, 1223),
(185, 16, 62, 0, 5923, 'description', 0, 1029, 65, 1223, 1421110056, 1, 1192),
(185, 16, 62, 0, 5924, 'description', 0, 1224, 66, 1192, 1421110056, 1, 1029),
(185, 16, 62, 0, 5925, 'description', 0, 1225, 67, 1029, 1421110056, 1, 1224),
(185, 16, 62, 0, 5926, 'description', 0, 1226, 68, 1224, 1421110056, 1, 1225),
(185, 16, 62, 0, 5927, 'description', 0, 1197, 69, 1225, 1421110056, 1, 1226),
(185, 16, 62, 0, 5928, 'description', 0, 1227, 70, 1226, 1421110056, 1, 1197),
(185, 16, 62, 0, 5929, 'description', 0, 1216, 71, 1197, 1421110056, 1, 1227),
(185, 16, 62, 0, 5930, 'description', 0, 1180, 72, 1227, 1421110056, 1, 1216),
(185, 16, 62, 0, 5931, 'description', 0, 1179, 73, 1216, 1421110056, 1, 1180),
(185, 16, 62, 0, 5932, 'description', 0, 1217, 74, 1180, 1421110056, 1, 1179),
(185, 16, 62, 0, 5933, 'description', 0, 1228, 75, 1179, 1421110056, 1, 1217),
(185, 16, 62, 0, 5934, 'description', 0, 1229, 76, 1217, 1421110056, 1, 1228),
(185, 16, 62, 0, 5935, 'description', 0, 1179, 77, 1228, 1421110056, 1, 1229),
(185, 16, 62, 0, 5936, 'description', 0, 1180, 78, 1229, 1421110056, 1, 1179),
(185, 16, 62, 0, 5937, 'description', 0, 1230, 79, 1179, 1421110056, 1, 1180),
(185, 16, 62, 0, 5938, 'description', 0, 1216, 80, 1180, 1421110056, 1, 1230),
(185, 16, 62, 0, 5939, 'description', 0, 1179, 81, 1230, 1421110056, 1, 1216),
(185, 16, 62, 0, 5940, 'description', 0, 1180, 82, 1216, 1421110056, 1, 1179),
(185, 16, 62, 0, 5941, 'description', 0, 1231, 83, 1179, 1421110056, 1, 1180),
(185, 16, 62, 0, 5942, 'description', 0, 1181, 84, 1180, 1421110056, 1, 1231),
(185, 16, 62, 0, 5943, 'description', 0, 1196, 85, 1231, 1421110056, 1, 1181),
(185, 16, 62, 0, 5944, 'description', 0, 1204, 86, 1181, 1421110056, 1, 1196),
(185, 16, 62, 0, 5945, 'description', 0, 1232, 87, 1196, 1421110056, 1, 1204),
(185, 16, 62, 0, 5946, 'description', 0, 1170, 88, 1204, 1421110056, 1, 1232),
(185, 16, 62, 0, 5947, 'description', 0, 1233, 89, 1232, 1421110056, 1, 1170),
(185, 16, 62, 0, 5948, 'description', 0, 1234, 90, 1170, 1421110056, 1, 1233),
(185, 16, 62, 0, 5949, 'description', 0, 1235, 91, 1233, 1421110056, 1, 1234),
(185, 16, 62, 0, 5950, 'description', 0, 1197, 92, 1234, 1421110056, 1, 1235),
(185, 16, 62, 0, 5951, 'description', 0, 1236, 93, 1235, 1421110056, 1, 1197),
(185, 16, 62, 0, 5952, 'description', 0, 1237, 94, 1197, 1421110056, 1, 1236),
(185, 16, 62, 0, 5953, 'description', 0, 1238, 95, 1236, 1421110056, 1, 1237),
(185, 16, 62, 0, 5954, 'description', 0, 1192, 96, 1237, 1421110056, 1, 1238),
(185, 16, 62, 0, 5955, 'description', 0, 1179, 97, 1238, 1421110056, 1, 1192),
(185, 16, 62, 0, 5956, 'description', 0, 1239, 98, 1192, 1421110056, 1, 1179),
(185, 16, 62, 0, 5957, 'description', 0, 1240, 99, 1179, 1421110056, 1, 1239),
(185, 16, 62, 0, 5958, 'description', 0, 1193, 100, 1239, 1421110056, 1, 1240),
(185, 16, 62, 0, 5959, 'description', 0, 1241, 101, 1240, 1421110056, 1, 1193),
(185, 16, 62, 0, 5960, 'description', 0, 1242, 102, 1193, 1421110056, 1, 1241),
(185, 16, 62, 0, 5961, 'description', 0, 1243, 103, 1241, 1421110056, 1, 1242),
(185, 16, 62, 0, 5962, 'description', 0, 1244, 104, 1242, 1421110056, 1, 1243),
(185, 16, 62, 0, 5963, 'description', 0, 1213, 105, 1243, 1421110056, 1, 1244),
(185, 16, 62, 0, 5964, 'description', 0, 1245, 106, 1244, 1421110056, 1, 1213),
(185, 16, 62, 0, 5965, 'description', 0, 1246, 107, 1213, 1421110056, 1, 1245),
(185, 16, 62, 0, 5966, 'description', 0, 1127, 108, 1245, 1421110056, 1, 1246),
(185, 16, 62, 0, 5967, 'description', 0, 1129, 109, 1246, 1421110056, 1, 1127),
(185, 16, 62, 0, 5968, 'description', 0, 1128, 110, 1127, 1421110056, 1, 1129),
(185, 16, 62, 0, 5969, 'description', 0, 1127, 111, 1129, 1421110056, 1, 1128),
(185, 16, 62, 0, 5970, 'description', 0, 1179, 112, 1128, 1421110056, 1, 1127),
(185, 16, 62, 0, 5971, 'description', 0, 1180, 113, 1127, 1421110056, 1, 1179),
(185, 16, 62, 0, 5972, 'description', 0, 1181, 114, 1179, 1421110056, 1, 1180),
(185, 16, 62, 0, 5973, 'description', 0, 1182, 115, 1180, 1421110056, 1, 1181),
(185, 16, 62, 0, 5974, 'description', 0, 1183, 116, 1181, 1421110056, 1, 1182),
(185, 16, 62, 0, 5975, 'description', 0, 1184, 117, 1182, 1421110056, 1, 1183),
(185, 16, 62, 0, 5976, 'description', 0, 1063, 118, 1183, 1421110056, 1, 1184),
(185, 16, 62, 0, 5977, 'description', 0, 1185, 119, 1184, 1421110056, 1, 1063),
(185, 16, 62, 0, 5978, 'description', 0, 1186, 120, 1063, 1421110056, 1, 1185),
(185, 16, 62, 0, 5979, 'description', 0, 1187, 121, 1185, 1421110056, 1, 1186),
(185, 16, 62, 0, 5980, 'description', 0, 1188, 122, 1186, 1421110056, 1, 1187),
(185, 16, 62, 0, 5981, 'description', 0, 1189, 123, 1187, 1421110056, 1, 1188),
(185, 16, 62, 0, 5982, 'description', 0, 1190, 124, 1188, 1421110056, 1, 1189),
(185, 16, 62, 0, 5983, 'description', 0, 1179, 125, 1189, 1421110056, 1, 1190),
(185, 16, 62, 0, 5984, 'description', 0, 1191, 126, 1190, 1421110056, 1, 1179),
(185, 16, 62, 0, 5985, 'description', 0, 1192, 127, 1179, 1421110056, 1, 1191),
(185, 16, 62, 0, 5986, 'description', 0, 1193, 128, 1191, 1421110056, 1, 1192),
(185, 16, 62, 0, 5987, 'description', 0, 1185, 129, 1192, 1421110056, 1, 1193),
(185, 16, 62, 0, 5988, 'description', 0, 1194, 130, 1193, 1421110056, 1, 1185),
(185, 16, 62, 0, 5989, 'description', 0, 1181, 131, 1185, 1421110056, 1, 1194),
(185, 16, 62, 0, 5990, 'description', 0, 1195, 132, 1194, 1421110056, 1, 1181),
(185, 16, 62, 0, 5991, 'description', 0, 1196, 133, 1181, 1421110056, 1, 1195),
(185, 16, 62, 0, 5992, 'description', 0, 1197, 134, 1195, 1421110056, 1, 1196),
(185, 16, 62, 0, 5993, 'description', 0, 1198, 135, 1196, 1421110056, 1, 1197),
(185, 16, 62, 0, 5994, 'description', 0, 1199, 136, 1197, 1421110056, 1, 1198),
(185, 16, 62, 0, 5995, 'description', 0, 1200, 137, 1198, 1421110056, 1, 1199),
(185, 16, 62, 0, 5996, 'description', 0, 1201, 138, 1199, 1421110056, 1, 1200),
(185, 16, 62, 0, 5997, 'description', 0, 1202, 139, 1200, 1421110056, 1, 1201),
(185, 16, 62, 0, 5998, 'description', 0, 1199, 140, 1201, 1421110056, 1, 1202),
(185, 16, 62, 0, 5999, 'description', 0, 1203, 141, 1202, 1421110056, 1, 1199),
(185, 16, 62, 0, 6000, 'description', 0, 1168, 142, 1199, 1421110056, 1, 1203),
(185, 16, 62, 0, 6001, 'description', 0, 1204, 143, 1203, 1421110056, 1, 1168),
(185, 16, 62, 0, 6002, 'description', 0, 1205, 144, 1168, 1421110056, 1, 1204),
(185, 16, 62, 0, 6003, 'description', 0, 1206, 145, 1204, 1421110056, 1, 1205),
(185, 16, 62, 0, 6004, 'description', 0, 1207, 146, 1205, 1421110056, 1, 1206),
(185, 16, 62, 0, 6005, 'description', 0, 1208, 147, 1206, 1421110056, 1, 1207),
(185, 16, 62, 0, 6006, 'description', 0, 1209, 148, 1207, 1421110056, 1, 1208),
(185, 16, 62, 0, 6007, 'description', 0, 1210, 149, 1208, 1421110056, 1, 1209),
(185, 16, 62, 0, 6008, 'description', 0, 1211, 150, 1209, 1421110056, 1, 1210),
(185, 16, 62, 0, 6009, 'description', 0, 1199, 151, 1210, 1421110056, 1, 1211),
(185, 16, 62, 0, 6010, 'description', 0, 1212, 152, 1211, 1421110056, 1, 1199),
(185, 16, 62, 0, 6011, 'description', 0, 1213, 153, 1199, 1421110056, 1, 1212),
(185, 16, 62, 0, 6012, 'description', 0, 1214, 154, 1212, 1421110056, 1, 1213),
(185, 16, 62, 0, 6013, 'description', 0, 1215, 155, 1213, 1421110056, 1, 1214),
(185, 16, 62, 0, 6014, 'description', 0, 1216, 156, 1214, 1421110056, 1, 1215),
(185, 16, 62, 0, 6015, 'description', 0, 1180, 157, 1215, 1421110056, 1, 1216),
(185, 16, 62, 0, 6016, 'description', 0, 1179, 158, 1216, 1421110056, 1, 1180),
(185, 16, 62, 0, 6017, 'description', 0, 1217, 159, 1180, 1421110056, 1, 1179),
(185, 16, 62, 0, 6018, 'description', 0, 1181, 160, 1179, 1421110056, 1, 1217),
(185, 16, 62, 0, 6019, 'description', 0, 1218, 161, 1217, 1421110056, 1, 1181),
(185, 16, 62, 0, 6020, 'description', 0, 1196, 162, 1181, 1421110056, 1, 1218),
(185, 16, 62, 0, 6021, 'description', 0, 1179, 163, 1218, 1421110056, 1, 1196),
(185, 16, 62, 0, 6022, 'description', 0, 1219, 164, 1196, 1421110056, 1, 1179),
(185, 16, 62, 0, 6023, 'description', 0, 1220, 165, 1179, 1421110056, 1, 1219),
(185, 16, 62, 0, 6024, 'description', 0, 1179, 166, 1219, 1421110056, 1, 1220),
(185, 16, 62, 0, 6025, 'description', 0, 1221, 167, 1220, 1421110056, 1, 1179),
(185, 16, 62, 0, 6026, 'description', 0, 1222, 168, 1179, 1421110056, 1, 1221),
(185, 16, 62, 0, 6027, 'description', 0, 1223, 169, 1221, 1421110056, 1, 1222),
(185, 16, 62, 0, 6028, 'description', 0, 1192, 170, 1222, 1421110056, 1, 1223),
(185, 16, 62, 0, 6029, 'description', 0, 1029, 171, 1223, 1421110056, 1, 1192),
(185, 16, 62, 0, 6030, 'description', 0, 1224, 172, 1192, 1421110056, 1, 1029),
(185, 16, 62, 0, 6031, 'description', 0, 1225, 173, 1029, 1421110056, 1, 1224),
(185, 16, 62, 0, 6032, 'description', 0, 1226, 174, 1224, 1421110056, 1, 1225),
(185, 16, 62, 0, 6033, 'description', 0, 1197, 175, 1225, 1421110056, 1, 1226),
(185, 16, 62, 0, 6034, 'description', 0, 1227, 176, 1226, 1421110056, 1, 1197),
(185, 16, 62, 0, 6035, 'description', 0, 1216, 177, 1197, 1421110056, 1, 1227),
(185, 16, 62, 0, 6036, 'description', 0, 1180, 178, 1227, 1421110056, 1, 1216),
(185, 16, 62, 0, 6037, 'description', 0, 1179, 179, 1216, 1421110056, 1, 1180),
(185, 16, 62, 0, 6038, 'description', 0, 1217, 180, 1180, 1421110056, 1, 1179),
(185, 16, 62, 0, 6039, 'description', 0, 1228, 181, 1179, 1421110056, 1, 1217),
(185, 16, 62, 0, 6040, 'description', 0, 1229, 182, 1217, 1421110056, 1, 1228),
(185, 16, 62, 0, 6041, 'description', 0, 1179, 183, 1228, 1421110056, 1, 1229),
(185, 16, 62, 0, 6042, 'description', 0, 1180, 184, 1229, 1421110056, 1, 1179),
(185, 16, 62, 0, 6043, 'description', 0, 1230, 185, 1179, 1421110056, 1, 1180),
(185, 16, 62, 0, 6044, 'description', 0, 1216, 186, 1180, 1421110056, 1, 1230),
(185, 16, 62, 0, 6045, 'description', 0, 1179, 187, 1230, 1421110056, 1, 1216),
(185, 16, 62, 0, 6046, 'description', 0, 1180, 188, 1216, 1421110056, 1, 1179),
(185, 16, 62, 0, 6047, 'description', 0, 1231, 189, 1179, 1421110056, 1, 1180),
(185, 16, 62, 0, 6048, 'description', 0, 1181, 190, 1180, 1421110056, 1, 1231),
(185, 16, 62, 0, 6049, 'description', 0, 1196, 191, 1231, 1421110056, 1, 1181),
(185, 16, 62, 0, 6050, 'description', 0, 1204, 192, 1181, 1421110056, 1, 1196),
(185, 16, 62, 0, 6051, 'description', 0, 1232, 193, 1196, 1421110056, 1, 1204),
(185, 16, 62, 0, 6052, 'description', 0, 1170, 194, 1204, 1421110056, 1, 1232),
(185, 16, 62, 0, 6053, 'description', 0, 1233, 195, 1232, 1421110056, 1, 1170),
(185, 16, 62, 0, 6054, 'description', 0, 1234, 196, 1170, 1421110056, 1, 1233),
(185, 16, 62, 0, 6055, 'description', 0, 1235, 197, 1233, 1421110056, 1, 1234),
(185, 16, 62, 0, 6056, 'description', 0, 1197, 198, 1234, 1421110056, 1, 1235),
(185, 16, 62, 0, 6057, 'description', 0, 1236, 199, 1235, 1421110056, 1, 1197),
(185, 16, 62, 0, 6058, 'description', 0, 1237, 200, 1197, 1421110056, 1, 1236),
(185, 16, 62, 0, 6059, 'description', 0, 1238, 201, 1236, 1421110056, 1, 1237),
(185, 16, 62, 0, 6060, 'description', 0, 1192, 202, 1237, 1421110056, 1, 1238),
(185, 16, 62, 0, 6061, 'description', 0, 1179, 203, 1238, 1421110056, 1, 1192),
(185, 16, 62, 0, 6062, 'description', 0, 1239, 204, 1192, 1421110056, 1, 1179),
(185, 16, 62, 0, 6063, 'description', 0, 1240, 205, 1179, 1421110056, 1, 1239),
(185, 16, 62, 0, 6064, 'description', 0, 1193, 206, 1239, 1421110056, 1, 1240),
(185, 16, 62, 0, 6065, 'description', 0, 1241, 207, 1240, 1421110056, 1, 1193),
(185, 16, 62, 0, 6066, 'description', 0, 1242, 208, 1193, 1421110056, 1, 1241),
(185, 16, 62, 0, 6067, 'description', 0, 1243, 209, 1241, 1421110056, 1, 1242);
INSERT INTO `ezsearch_object_word_link` (`contentclass_attribute_id`, `contentclass_id`, `contentobject_id`, `frequency`, `id`, `identifier`, `integer_value`, `next_word_id`, `placement`, `prev_word_id`, `published`, `section_id`, `word_id`) VALUES
(185, 16, 62, 0, 6068, 'description', 0, 1244, 210, 1242, 1421110056, 1, 1243),
(185, 16, 62, 0, 6069, 'description', 0, 1213, 211, 1243, 1421110056, 1, 1244),
(185, 16, 62, 0, 6070, 'description', 0, 1245, 212, 1244, 1421110056, 1, 1213),
(185, 16, 62, 0, 6071, 'description', 0, 0, 213, 1213, 1421110056, 1, 1245),
(184, 16, 64, 0, 6076, 'short_description', 0, 1180, 4, 1128, 1421110148, 1, 1179),
(184, 16, 64, 0, 6077, 'short_description', 0, 1181, 5, 1179, 1421110148, 1, 1180),
(184, 16, 64, 0, 6078, 'short_description', 0, 1182, 6, 1180, 1421110148, 1, 1181),
(184, 16, 64, 0, 6079, 'short_description', 0, 1183, 7, 1181, 1421110148, 1, 1182),
(184, 16, 64, 0, 6080, 'short_description', 0, 1184, 8, 1182, 1421110148, 1, 1183),
(184, 16, 64, 0, 6081, 'short_description', 0, 1063, 9, 1183, 1421110148, 1, 1184),
(184, 16, 64, 0, 6082, 'short_description', 0, 1185, 10, 1184, 1421110148, 1, 1063),
(184, 16, 64, 0, 6083, 'short_description', 0, 1186, 11, 1063, 1421110148, 1, 1185),
(184, 16, 64, 0, 6084, 'short_description', 0, 1187, 12, 1185, 1421110148, 1, 1186),
(184, 16, 64, 0, 6085, 'short_description', 0, 1188, 13, 1186, 1421110148, 1, 1187),
(184, 16, 64, 0, 6086, 'short_description', 0, 1189, 14, 1187, 1421110148, 1, 1188),
(184, 16, 64, 0, 6087, 'short_description', 0, 1190, 15, 1188, 1421110148, 1, 1189),
(184, 16, 64, 0, 6088, 'short_description', 0, 1179, 16, 1189, 1421110148, 1, 1190),
(184, 16, 64, 0, 6089, 'short_description', 0, 1191, 17, 1190, 1421110148, 1, 1179),
(184, 16, 64, 0, 6090, 'short_description', 0, 1192, 18, 1179, 1421110148, 1, 1191),
(184, 16, 64, 0, 6091, 'short_description', 0, 1193, 19, 1191, 1421110148, 1, 1192),
(184, 16, 64, 0, 6092, 'short_description', 0, 1185, 20, 1192, 1421110148, 1, 1193),
(184, 16, 64, 0, 6093, 'short_description', 0, 1194, 21, 1193, 1421110148, 1, 1185),
(184, 16, 64, 0, 6094, 'short_description', 0, 1181, 22, 1185, 1421110148, 1, 1194),
(184, 16, 64, 0, 6095, 'short_description', 0, 1195, 23, 1194, 1421110148, 1, 1181),
(184, 16, 64, 0, 6096, 'short_description', 0, 1196, 24, 1181, 1421110148, 1, 1195),
(184, 16, 64, 0, 6097, 'short_description', 0, 1197, 25, 1195, 1421110148, 1, 1196),
(184, 16, 64, 0, 6098, 'short_description', 0, 1198, 26, 1196, 1421110148, 1, 1197),
(184, 16, 64, 0, 6099, 'short_description', 0, 1199, 27, 1197, 1421110148, 1, 1198),
(184, 16, 64, 0, 6100, 'short_description', 0, 1200, 28, 1198, 1421110148, 1, 1199),
(184, 16, 64, 0, 6101, 'short_description', 0, 1201, 29, 1199, 1421110148, 1, 1200),
(184, 16, 64, 0, 6102, 'short_description', 0, 1202, 30, 1200, 1421110148, 1, 1201),
(184, 16, 64, 0, 6103, 'short_description', 0, 1129, 31, 1201, 1421110148, 1, 1202),
(185, 16, 64, 0, 6104, 'description', 0, 1128, 32, 1202, 1421110148, 1, 1129),
(185, 16, 64, 0, 6105, 'description', 0, 1128, 33, 1129, 1421110148, 1, 1128),
(185, 16, 64, 0, 6106, 'description', 0, 1199, 34, 1128, 1421110148, 1, 1128),
(185, 16, 64, 0, 6107, 'description', 0, 1203, 35, 1128, 1421110148, 1, 1199),
(185, 16, 64, 0, 6108, 'description', 0, 1168, 36, 1199, 1421110148, 1, 1203),
(185, 16, 64, 0, 6109, 'description', 0, 1204, 37, 1203, 1421110148, 1, 1168),
(185, 16, 64, 0, 6110, 'description', 0, 1205, 38, 1168, 1421110148, 1, 1204),
(185, 16, 64, 0, 6111, 'description', 0, 1206, 39, 1204, 1421110148, 1, 1205),
(185, 16, 64, 0, 6112, 'description', 0, 1207, 40, 1205, 1421110148, 1, 1206),
(185, 16, 64, 0, 6113, 'description', 0, 1208, 41, 1206, 1421110148, 1, 1207),
(185, 16, 64, 0, 6114, 'description', 0, 1209, 42, 1207, 1421110148, 1, 1208),
(185, 16, 64, 0, 6115, 'description', 0, 1210, 43, 1208, 1421110148, 1, 1209),
(185, 16, 64, 0, 6116, 'description', 0, 1211, 44, 1209, 1421110148, 1, 1210),
(185, 16, 64, 0, 6117, 'description', 0, 1199, 45, 1210, 1421110148, 1, 1211),
(185, 16, 64, 0, 6118, 'description', 0, 1212, 46, 1211, 1421110148, 1, 1199),
(185, 16, 64, 0, 6119, 'description', 0, 1213, 47, 1199, 1421110148, 1, 1212),
(185, 16, 64, 0, 6120, 'description', 0, 1214, 48, 1212, 1421110148, 1, 1213),
(185, 16, 64, 0, 6121, 'description', 0, 1215, 49, 1213, 1421110148, 1, 1214),
(185, 16, 64, 0, 6122, 'description', 0, 1216, 50, 1214, 1421110148, 1, 1215),
(185, 16, 64, 0, 6123, 'description', 0, 1180, 51, 1215, 1421110148, 1, 1216),
(185, 16, 64, 0, 6124, 'description', 0, 1179, 52, 1216, 1421110148, 1, 1180),
(185, 16, 64, 0, 6125, 'description', 0, 1217, 53, 1180, 1421110148, 1, 1179),
(185, 16, 64, 0, 6126, 'description', 0, 1181, 54, 1179, 1421110148, 1, 1217),
(185, 16, 64, 0, 6127, 'description', 0, 1218, 55, 1217, 1421110148, 1, 1181),
(185, 16, 64, 0, 6128, 'description', 0, 1196, 56, 1181, 1421110148, 1, 1218),
(185, 16, 64, 0, 6129, 'description', 0, 1179, 57, 1218, 1421110148, 1, 1196),
(185, 16, 64, 0, 6130, 'description', 0, 1219, 58, 1196, 1421110148, 1, 1179),
(185, 16, 64, 0, 6131, 'description', 0, 1220, 59, 1179, 1421110148, 1, 1219),
(185, 16, 64, 0, 6132, 'description', 0, 1179, 60, 1219, 1421110148, 1, 1220),
(185, 16, 64, 0, 6133, 'description', 0, 1221, 61, 1220, 1421110148, 1, 1179),
(185, 16, 64, 0, 6134, 'description', 0, 1222, 62, 1179, 1421110148, 1, 1221),
(185, 16, 64, 0, 6135, 'description', 0, 1223, 63, 1221, 1421110148, 1, 1222),
(185, 16, 64, 0, 6136, 'description', 0, 1192, 64, 1222, 1421110148, 1, 1223),
(185, 16, 64, 0, 6137, 'description', 0, 1029, 65, 1223, 1421110148, 1, 1192),
(185, 16, 64, 0, 6138, 'description', 0, 1224, 66, 1192, 1421110148, 1, 1029),
(185, 16, 64, 0, 6139, 'description', 0, 1225, 67, 1029, 1421110148, 1, 1224),
(185, 16, 64, 0, 6140, 'description', 0, 1226, 68, 1224, 1421110148, 1, 1225),
(185, 16, 64, 0, 6141, 'description', 0, 1197, 69, 1225, 1421110148, 1, 1226),
(185, 16, 64, 0, 6142, 'description', 0, 1227, 70, 1226, 1421110148, 1, 1197),
(185, 16, 64, 0, 6143, 'description', 0, 1216, 71, 1197, 1421110148, 1, 1227),
(185, 16, 64, 0, 6144, 'description', 0, 1180, 72, 1227, 1421110148, 1, 1216),
(185, 16, 64, 0, 6145, 'description', 0, 1179, 73, 1216, 1421110148, 1, 1180),
(185, 16, 64, 0, 6146, 'description', 0, 1217, 74, 1180, 1421110148, 1, 1179),
(185, 16, 64, 0, 6147, 'description', 0, 1228, 75, 1179, 1421110148, 1, 1217),
(185, 16, 64, 0, 6148, 'description', 0, 1229, 76, 1217, 1421110148, 1, 1228),
(185, 16, 64, 0, 6149, 'description', 0, 1179, 77, 1228, 1421110148, 1, 1229),
(185, 16, 64, 0, 6150, 'description', 0, 1180, 78, 1229, 1421110148, 1, 1179),
(185, 16, 64, 0, 6151, 'description', 0, 1230, 79, 1179, 1421110148, 1, 1180),
(185, 16, 64, 0, 6152, 'description', 0, 1216, 80, 1180, 1421110148, 1, 1230),
(185, 16, 64, 0, 6153, 'description', 0, 1179, 81, 1230, 1421110148, 1, 1216),
(185, 16, 64, 0, 6154, 'description', 0, 1180, 82, 1216, 1421110148, 1, 1179),
(185, 16, 64, 0, 6155, 'description', 0, 1231, 83, 1179, 1421110148, 1, 1180),
(185, 16, 64, 0, 6156, 'description', 0, 1181, 84, 1180, 1421110148, 1, 1231),
(185, 16, 64, 0, 6157, 'description', 0, 1196, 85, 1231, 1421110148, 1, 1181),
(185, 16, 64, 0, 6158, 'description', 0, 1204, 86, 1181, 1421110148, 1, 1196),
(185, 16, 64, 0, 6159, 'description', 0, 1232, 87, 1196, 1421110148, 1, 1204),
(185, 16, 64, 0, 6160, 'description', 0, 1170, 88, 1204, 1421110148, 1, 1232),
(185, 16, 64, 0, 6161, 'description', 0, 1233, 89, 1232, 1421110148, 1, 1170),
(185, 16, 64, 0, 6162, 'description', 0, 1234, 90, 1170, 1421110148, 1, 1233),
(185, 16, 64, 0, 6163, 'description', 0, 1235, 91, 1233, 1421110148, 1, 1234),
(185, 16, 64, 0, 6164, 'description', 0, 1197, 92, 1234, 1421110148, 1, 1235),
(185, 16, 64, 0, 6165, 'description', 0, 1236, 93, 1235, 1421110148, 1, 1197),
(185, 16, 64, 0, 6166, 'description', 0, 1237, 94, 1197, 1421110148, 1, 1236),
(185, 16, 64, 0, 6167, 'description', 0, 1238, 95, 1236, 1421110148, 1, 1237),
(185, 16, 64, 0, 6168, 'description', 0, 1192, 96, 1237, 1421110148, 1, 1238),
(185, 16, 64, 0, 6169, 'description', 0, 1179, 97, 1238, 1421110148, 1, 1192),
(185, 16, 64, 0, 6170, 'description', 0, 1239, 98, 1192, 1421110148, 1, 1179),
(185, 16, 64, 0, 6171, 'description', 0, 1240, 99, 1179, 1421110148, 1, 1239),
(185, 16, 64, 0, 6172, 'description', 0, 1193, 100, 1239, 1421110148, 1, 1240),
(185, 16, 64, 0, 6173, 'description', 0, 1241, 101, 1240, 1421110148, 1, 1193),
(185, 16, 64, 0, 6174, 'description', 0, 1242, 102, 1193, 1421110148, 1, 1241),
(185, 16, 64, 0, 6175, 'description', 0, 1243, 103, 1241, 1421110148, 1, 1242),
(185, 16, 64, 0, 6176, 'description', 0, 1244, 104, 1242, 1421110148, 1, 1243),
(185, 16, 64, 0, 6177, 'description', 0, 1213, 105, 1243, 1421110148, 1, 1244),
(185, 16, 64, 0, 6178, 'description', 0, 1245, 106, 1244, 1421110148, 1, 1213),
(185, 16, 64, 0, 6179, 'description', 0, 1246, 107, 1213, 1421110148, 1, 1245),
(185, 16, 64, 0, 6180, 'description', 0, 1127, 108, 1245, 1421110148, 1, 1246),
(185, 16, 64, 0, 6181, 'description', 0, 1129, 109, 1246, 1421110148, 1, 1127),
(185, 16, 64, 0, 6182, 'description', 0, 1128, 110, 1127, 1421110148, 1, 1129),
(185, 16, 64, 0, 6183, 'description', 0, 1128, 111, 1129, 1421110148, 1, 1128),
(185, 16, 64, 0, 6184, 'description', 0, 1179, 112, 1128, 1421110148, 1, 1128),
(185, 16, 64, 0, 6185, 'description', 0, 1180, 113, 1128, 1421110148, 1, 1179),
(185, 16, 64, 0, 6186, 'description', 0, 1181, 114, 1179, 1421110148, 1, 1180),
(185, 16, 64, 0, 6187, 'description', 0, 1182, 115, 1180, 1421110148, 1, 1181),
(185, 16, 64, 0, 6188, 'description', 0, 1183, 116, 1181, 1421110148, 1, 1182),
(185, 16, 64, 0, 6189, 'description', 0, 1184, 117, 1182, 1421110148, 1, 1183),
(185, 16, 64, 0, 6190, 'description', 0, 1063, 118, 1183, 1421110148, 1, 1184),
(185, 16, 64, 0, 6191, 'description', 0, 1185, 119, 1184, 1421110148, 1, 1063),
(185, 16, 64, 0, 6192, 'description', 0, 1186, 120, 1063, 1421110148, 1, 1185),
(185, 16, 64, 0, 6193, 'description', 0, 1187, 121, 1185, 1421110148, 1, 1186),
(185, 16, 64, 0, 6194, 'description', 0, 1188, 122, 1186, 1421110148, 1, 1187),
(185, 16, 64, 0, 6195, 'description', 0, 1189, 123, 1187, 1421110148, 1, 1188),
(185, 16, 64, 0, 6196, 'description', 0, 1190, 124, 1188, 1421110148, 1, 1189),
(185, 16, 64, 0, 6197, 'description', 0, 1179, 125, 1189, 1421110148, 1, 1190),
(185, 16, 64, 0, 6198, 'description', 0, 1191, 126, 1190, 1421110148, 1, 1179),
(185, 16, 64, 0, 6199, 'description', 0, 1192, 127, 1179, 1421110148, 1, 1191),
(185, 16, 64, 0, 6200, 'description', 0, 1193, 128, 1191, 1421110148, 1, 1192),
(185, 16, 64, 0, 6201, 'description', 0, 1185, 129, 1192, 1421110148, 1, 1193),
(185, 16, 64, 0, 6202, 'description', 0, 1194, 130, 1193, 1421110148, 1, 1185),
(185, 16, 64, 0, 6203, 'description', 0, 1181, 131, 1185, 1421110148, 1, 1194),
(185, 16, 64, 0, 6204, 'description', 0, 1195, 132, 1194, 1421110148, 1, 1181),
(185, 16, 64, 0, 6205, 'description', 0, 1196, 133, 1181, 1421110148, 1, 1195),
(185, 16, 64, 0, 6206, 'description', 0, 1197, 134, 1195, 1421110148, 1, 1196),
(185, 16, 64, 0, 6207, 'description', 0, 1198, 135, 1196, 1421110148, 1, 1197),
(185, 16, 64, 0, 6208, 'description', 0, 1199, 136, 1197, 1421110148, 1, 1198),
(185, 16, 64, 0, 6209, 'description', 0, 1200, 137, 1198, 1421110148, 1, 1199),
(185, 16, 64, 0, 6210, 'description', 0, 1201, 138, 1199, 1421110148, 1, 1200),
(185, 16, 64, 0, 6211, 'description', 0, 1202, 139, 1200, 1421110148, 1, 1201),
(185, 16, 64, 0, 6212, 'description', 0, 1199, 140, 1201, 1421110148, 1, 1202),
(185, 16, 64, 0, 6213, 'description', 0, 1203, 141, 1202, 1421110148, 1, 1199),
(185, 16, 64, 0, 6214, 'description', 0, 1168, 142, 1199, 1421110148, 1, 1203),
(185, 16, 64, 0, 6215, 'description', 0, 1204, 143, 1203, 1421110148, 1, 1168),
(185, 16, 64, 0, 6216, 'description', 0, 1205, 144, 1168, 1421110148, 1, 1204),
(185, 16, 64, 0, 6217, 'description', 0, 1206, 145, 1204, 1421110148, 1, 1205),
(185, 16, 64, 0, 6218, 'description', 0, 1207, 146, 1205, 1421110148, 1, 1206),
(185, 16, 64, 0, 6219, 'description', 0, 1208, 147, 1206, 1421110148, 1, 1207),
(185, 16, 64, 0, 6220, 'description', 0, 1209, 148, 1207, 1421110148, 1, 1208),
(185, 16, 64, 0, 6221, 'description', 0, 1210, 149, 1208, 1421110148, 1, 1209),
(185, 16, 64, 0, 6222, 'description', 0, 1211, 150, 1209, 1421110148, 1, 1210),
(185, 16, 64, 0, 6223, 'description', 0, 1199, 151, 1210, 1421110148, 1, 1211),
(185, 16, 64, 0, 6224, 'description', 0, 1212, 152, 1211, 1421110148, 1, 1199),
(185, 16, 64, 0, 6225, 'description', 0, 1213, 153, 1199, 1421110148, 1, 1212),
(185, 16, 64, 0, 6226, 'description', 0, 1214, 154, 1212, 1421110148, 1, 1213),
(185, 16, 64, 0, 6227, 'description', 0, 1215, 155, 1213, 1421110148, 1, 1214),
(185, 16, 64, 0, 6228, 'description', 0, 1216, 156, 1214, 1421110148, 1, 1215),
(185, 16, 64, 0, 6229, 'description', 0, 1180, 157, 1215, 1421110148, 1, 1216),
(185, 16, 64, 0, 6230, 'description', 0, 1179, 158, 1216, 1421110148, 1, 1180),
(185, 16, 64, 0, 6231, 'description', 0, 1217, 159, 1180, 1421110148, 1, 1179),
(185, 16, 64, 0, 6232, 'description', 0, 1181, 160, 1179, 1421110148, 1, 1217),
(185, 16, 64, 0, 6233, 'description', 0, 1218, 161, 1217, 1421110148, 1, 1181),
(185, 16, 64, 0, 6234, 'description', 0, 1196, 162, 1181, 1421110148, 1, 1218),
(185, 16, 64, 0, 6235, 'description', 0, 1179, 163, 1218, 1421110148, 1, 1196),
(185, 16, 64, 0, 6236, 'description', 0, 1219, 164, 1196, 1421110148, 1, 1179),
(185, 16, 64, 0, 6237, 'description', 0, 1220, 165, 1179, 1421110148, 1, 1219),
(185, 16, 64, 0, 6238, 'description', 0, 1179, 166, 1219, 1421110148, 1, 1220),
(185, 16, 64, 0, 6239, 'description', 0, 1221, 167, 1220, 1421110148, 1, 1179),
(185, 16, 64, 0, 6240, 'description', 0, 1222, 168, 1179, 1421110148, 1, 1221),
(185, 16, 64, 0, 6241, 'description', 0, 1223, 169, 1221, 1421110148, 1, 1222),
(185, 16, 64, 0, 6242, 'description', 0, 1192, 170, 1222, 1421110148, 1, 1223),
(185, 16, 64, 0, 6243, 'description', 0, 1029, 171, 1223, 1421110148, 1, 1192),
(185, 16, 64, 0, 6244, 'description', 0, 1224, 172, 1192, 1421110148, 1, 1029),
(185, 16, 64, 0, 6245, 'description', 0, 1225, 173, 1029, 1421110148, 1, 1224),
(185, 16, 64, 0, 6246, 'description', 0, 1226, 174, 1224, 1421110148, 1, 1225),
(185, 16, 64, 0, 6247, 'description', 0, 1197, 175, 1225, 1421110148, 1, 1226),
(185, 16, 64, 0, 6248, 'description', 0, 1227, 176, 1226, 1421110148, 1, 1197),
(185, 16, 64, 0, 6249, 'description', 0, 1216, 177, 1197, 1421110148, 1, 1227),
(185, 16, 64, 0, 6250, 'description', 0, 1180, 178, 1227, 1421110148, 1, 1216),
(185, 16, 64, 0, 6251, 'description', 0, 1179, 179, 1216, 1421110148, 1, 1180),
(185, 16, 64, 0, 6252, 'description', 0, 1217, 180, 1180, 1421110148, 1, 1179),
(185, 16, 64, 0, 6253, 'description', 0, 1228, 181, 1179, 1421110148, 1, 1217),
(185, 16, 64, 0, 6254, 'description', 0, 1229, 182, 1217, 1421110148, 1, 1228),
(185, 16, 64, 0, 6255, 'description', 0, 1179, 183, 1228, 1421110148, 1, 1229),
(185, 16, 64, 0, 6256, 'description', 0, 1180, 184, 1229, 1421110148, 1, 1179),
(185, 16, 64, 0, 6257, 'description', 0, 1230, 185, 1179, 1421110148, 1, 1180),
(185, 16, 64, 0, 6258, 'description', 0, 1216, 186, 1180, 1421110148, 1, 1230),
(185, 16, 64, 0, 6259, 'description', 0, 1179, 187, 1230, 1421110148, 1, 1216),
(185, 16, 64, 0, 6260, 'description', 0, 1180, 188, 1216, 1421110148, 1, 1179),
(185, 16, 64, 0, 6261, 'description', 0, 1231, 189, 1179, 1421110148, 1, 1180),
(185, 16, 64, 0, 6262, 'description', 0, 1181, 190, 1180, 1421110148, 1, 1231),
(185, 16, 64, 0, 6263, 'description', 0, 1196, 191, 1231, 1421110148, 1, 1181),
(185, 16, 64, 0, 6264, 'description', 0, 1204, 192, 1181, 1421110148, 1, 1196),
(185, 16, 64, 0, 6265, 'description', 0, 1232, 193, 1196, 1421110148, 1, 1204),
(185, 16, 64, 0, 6266, 'description', 0, 1170, 194, 1204, 1421110148, 1, 1232),
(185, 16, 64, 0, 6267, 'description', 0, 1233, 195, 1232, 1421110148, 1, 1170),
(185, 16, 64, 0, 6268, 'description', 0, 1234, 196, 1170, 1421110148, 1, 1233),
(185, 16, 64, 0, 6269, 'description', 0, 1235, 197, 1233, 1421110148, 1, 1234),
(185, 16, 64, 0, 6270, 'description', 0, 1197, 198, 1234, 1421110148, 1, 1235),
(185, 16, 64, 0, 6271, 'description', 0, 1236, 199, 1235, 1421110148, 1, 1197),
(185, 16, 64, 0, 6272, 'description', 0, 1237, 200, 1197, 1421110148, 1, 1236),
(185, 16, 64, 0, 6273, 'description', 0, 1238, 201, 1236, 1421110148, 1, 1237),
(185, 16, 64, 0, 6274, 'description', 0, 1192, 202, 1237, 1421110148, 1, 1238),
(185, 16, 64, 0, 6275, 'description', 0, 1179, 203, 1238, 1421110148, 1, 1192),
(185, 16, 64, 0, 6276, 'description', 0, 1239, 204, 1192, 1421110148, 1, 1179),
(185, 16, 64, 0, 6277, 'description', 0, 1240, 205, 1179, 1421110148, 1, 1239),
(185, 16, 64, 0, 6278, 'description', 0, 1193, 206, 1239, 1421110148, 1, 1240),
(185, 16, 64, 0, 6279, 'description', 0, 1241, 207, 1240, 1421110148, 1, 1193),
(185, 16, 64, 0, 6280, 'description', 0, 1242, 208, 1193, 1421110148, 1, 1241),
(185, 16, 64, 0, 6281, 'description', 0, 1243, 209, 1241, 1421110148, 1, 1242),
(185, 16, 64, 0, 6282, 'description', 0, 1244, 210, 1242, 1421110148, 1, 1243),
(185, 16, 64, 0, 6283, 'description', 0, 1213, 211, 1243, 1421110148, 1, 1244),
(185, 16, 64, 0, 6284, 'description', 0, 1245, 212, 1244, 1421110148, 1, 1213),
(185, 16, 64, 0, 6285, 'description', 0, 0, 213, 1213, 1421110148, 1, 1245),
(188, 17, 58, 0, 6315, 'title', 0, 1125, 4, 1135, 1421109393, 1, 1136),
(188, 17, 58, 0, 6314, 'title', 0, 1136, 3, 1127, 1421109393, 1, 1135),
(188, 17, 58, 0, 6313, 'title', 0, 1135, 2, 1126, 1421109393, 1, 1127),
(188, 17, 58, 0, 6312, 'title', 0, 1127, 1, 1125, 1421109393, 1, 1126),
(188, 17, 58, 0, 6311, 'title', 0, 1126, 0, 0, 1421109393, 1, 1125),
(193, 18, 67, 0, 6343, 'title', 0, 1266, 2, 1265, 1439393094, 1, 1264),
(193, 18, 67, 0, 6342, 'title', 0, 1264, 1, 1264, 1439393094, 1, 1265),
(193, 18, 67, 0, 6341, 'title', 0, 1265, 0, 0, 1439393094, 1, 1264),
(193, 18, 67, 0, 6344, 'title', 0, 0, 3, 1264, 1439393094, 1, 1266);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezsearch_return_count`
--

DROP TABLE IF EXISTS `ezsearch_return_count`;
CREATE TABLE IF NOT EXISTS `ezsearch_return_count` (
  `count` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `phrase_id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezsearch_search_phrase`
--

DROP TABLE IF EXISTS `ezsearch_search_phrase`;
CREATE TABLE IF NOT EXISTS `ezsearch_search_phrase` (
  `id` int(11) NOT NULL,
  `phrase` varchar(250) DEFAULT NULL,
  `phrase_count` int(11) DEFAULT '0',
  `result_count` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezsearch_word`
--

DROP TABLE IF EXISTS `ezsearch_word`;
CREATE TABLE IF NOT EXISTS `ezsearch_word` (
  `id` int(11) NOT NULL,
  `object_count` int(11) NOT NULL DEFAULT '0',
  `word` varchar(150) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1267 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezsearch_word`
--

INSERT INTO `ezsearch_word` (`id`, `object_count`, `word`) VALUES
(1086, 1, 'more'),
(1085, 1, 'sessions'),
(1084, 1, 'training'),
(1083, 1, 'various'),
(1082, 1, 'up'),
(1081, 1, 'sign'),
(1080, 1, 'possible'),
(1079, 1, 'services'),
(812, 2, 'setup'),
(1078, 1, 'consulting'),
(814, 2, 'the'),
(1077, 1, 'support'),
(816, 2, 'for'),
(1076, 1, 'purchase'),
(1075, 1, 'help'),
(1074, 1, 'need'),
(1073, 1, 'forum'),
(1072, 1, 'official'),
(1071, 1, 'make'),
(1070, 1, 'pages'),
(1069, 1, 'within'),
(1068, 1, 'problem'),
(1067, 1, 'question'),
(1066, 1, 'specific'),
(1065, 1, 'solution'),
(1064, 1, 'answer'),
(1063, 5, 'an'),
(1062, 1, 'find'),
(1061, 1, 'unable'),
(1060, 1, 're'),
(1059, 2, 'you'),
(1058, 1, 'if'),
(1057, 1, 'chapter'),
(1056, 1, 'basics'),
(1055, 1, 'read'),
(1054, 1, 'least'),
(1053, 1, 'should'),
(1052, 1, 'unfamiliar'),
(1051, 1, 'are'),
(1050, 1, 'who'),
(1049, 1, 'people'),
(1048, 1, 'some'),
(1047, 1, 'also'),
(1046, 1, 'use'),
(1045, 1, 'daily'),
(1044, 1, 'related'),
(1043, 1, 'topics'),
(1042, 1, 'covers'),
(1041, 1, 'guidance'),
(1040, 1, 'documentation'),
(1039, 1, 'existing'),
(1038, 1, 'coexist'),
(1037, 1, 'communicate'),
(1036, 1, 'into'),
(1035, 1, 'plugged'),
(1034, 1, 'easily'),
(1033, 1, 'nature'),
(1032, 1, 'its'),
(1031, 1, 'because'),
(1030, 1, 'addition'),
(1029, 7, 'in'),
(1028, 1, 'advanced'),
(1027, 1, 'other'),
(1026, 1, 'forums'),
(877, 2, 'common'),
(1025, 1, 'discussion'),
(1024, 1, 'shopping'),
(1023, 1, 'online'),
(1022, 1, 'access'),
(1021, 1, 'multiuser'),
(1020, 1, 'based'),
(1019, 1, 'role'),
(1018, 1, 'corporate'),
(1017, 1, 'multinational'),
(1016, 1, 'homepage'),
(1015, 1, 'personal'),
(1014, 1, 'from'),
(1013, 1, 'anything'),
(1012, 1, 'build'),
(1011, 1, 'used'),
(1010, 1, 'be'),
(1009, 2, 'can'),
(1008, 1, 'solutions'),
(1007, 1, 'web'),
(1006, 1, 'dynamic'),
(1005, 1, 'customized'),
(1004, 1, 'professional'),
(1003, 1, 'allows'),
(1002, 1, 'it'),
(1001, 1, 'framework'),
(1000, 1, 'development'),
(999, 1, 'and'),
(998, 1, 'system'),
(997, 1, 'management'),
(996, 1, 'content'),
(995, 1, 'source'),
(994, 1, 'open'),
(993, 1, 'popular'),
(992, 1, 'installation'),
(991, 1, 'at'),
(990, 1, 'flow'),
(989, 1, 'or'),
(988, 1, 'interface'),
(927, 3, 'ez.no'),
(987, 1, 'website'),
(930, 4, 'users'),
(986, 1, 'chose'),
(985, 1, 'please'),
(984, 1, 'blown'),
(983, 1, 'full'),
(982, 1, 'functionality'),
(981, 1, 'of'),
(980, 1, 'limited'),
(979, 2, 'a'),
(978, 1, 'with'),
(977, 1, 'package'),
(976, 1, 'site'),
(975, 1, 'plain'),
(974, 2, 'is'),
(973, 2, 'this'),
(972, 1, 'publish'),
(971, 1, 'ez'),
(970, 1, 'to'),
(969, 1, 'welcome'),
(1118, 1, 'main'),
(952, 2, 'group'),
(953, 2, 'anonymous'),
(954, 3, 'user'),
(955, 2, 'nospam'),
(1120, 1, 'accounts'),
(1119, 1, 'guest'),
(958, 2, 'administrator'),
(1121, 1, 'editors'),
(1122, 1, 'admin'),
(1114, 1, 'media'),
(1116, 1, 'images'),
(1115, 1, 'files'),
(1117, 1, 'multimedia'),
(965, 1, 'ini'),
(966, 1, 'settings'),
(967, 1, 'sitestyle_identifier'),
(968, 1, 'design'),
(1087, 1, 'information'),
(1088, 1, 'about'),
(1089, 1, 'products'),
(1090, 1, 'systems'),
(1091, 1, 'visit'),
(1092, 1, 'tutorials'),
(1093, 1, 'new'),
(1094, 1, 'administration'),
(1095, 1, 'editor'),
(1096, 1, 'video'),
(1097, 1, 'tutorial'),
(1098, 1, 'experienced'),
(1099, 1, 'how'),
(1100, 1, 'develop'),
(1101, 1, 'extensions'),
(1102, 1, 'create'),
(1103, 1, 'custom'),
(1104, 1, 'workflow'),
(1105, 1, 'rest'),
(1106, 1, 'api'),
(1107, 1, 'asynchronous'),
(1108, 1, 'publishing'),
(1109, 1, 'upgrading'),
(1110, 1, '4.5'),
(1111, 1, 'amp'),
(1112, 1, 'nbsp'),
(1113, 1, 'videos'),
(1126, 2, 'ordner'),
(1125, 5, 'test'),
(1127, 5, '1'),
(1128, 4, '2'),
(1129, 4, 'seite'),
(1258, 1, 'english'),
(1257, 1, 'written'),
(1136, 2, 'de'),
(1135, 2, 'ger'),
(1140, 2, 'dieser'),
(1256, 1, 'wurde'),
(1142, 2, 'deutsch'),
(1143, 2, 'geschrieben'),
(1255, 1, 'gb'),
(1254, 1, 'eng'),
(1171, 1, 'uns'),
(1149, 1, 'ist'),
(1170, 5, 'sie'),
(1169, 1, 'konnen'),
(1168, 5, 'hier'),
(1167, 1, 'feedbackform'),
(1166, 1, 'kontaktformular'),
(1172, 1, 'eine'),
(1173, 1, 'nachricht'),
(1174, 1, 'schreiben'),
(1175, 1, 'here'),
(1176, 1, 'send'),
(1177, 1, 'us'),
(1178, 1, 'message'),
(1179, 4, 'ich'),
(1180, 4, 'bin'),
(1181, 4, 'ein'),
(1182, 4, 'blindtext'),
(1183, 4, 'von'),
(1184, 4, 'geburt'),
(1185, 4, 'es'),
(1186, 4, 'hat'),
(1187, 4, 'sehr'),
(1188, 4, 'lange'),
(1189, 4, 'gedauert'),
(1190, 4, 'bis'),
(1191, 4, 'begriffen'),
(1192, 4, 'habe'),
(1193, 4, 'was'),
(1194, 4, 'bedeutet'),
(1195, 4, 'blinder'),
(1196, 4, 'text'),
(1197, 4, 'zu'),
(1198, 4, 'sein'),
(1199, 4, 'man'),
(1200, 4, 'macht'),
(1201, 4, 'keinen'),
(1202, 4, 'sinn'),
(1203, 4, 'wirkt'),
(1204, 4, 'und'),
(1205, 4, 'da'),
(1206, 4, 'aus'),
(1207, 4, 'dem'),
(1208, 4, 'zusammenhang'),
(1209, 4, 'gerissen'),
(1210, 4, 'oft'),
(1211, 4, 'wird'),
(1212, 4, 'gar'),
(1213, 4, 'nicht'),
(1214, 4, 'erst'),
(1215, 4, 'gelesen'),
(1216, 4, 'aber'),
(1217, 4, 'deswegen'),
(1218, 4, 'schlechter'),
(1219, 4, 'weiss'),
(1220, 4, 'dass'),
(1221, 4, 'niemals'),
(1222, 4, 'die'),
(1223, 4, 'chance'),
(1224, 4, 'einer'),
(1225, 4, 'grossen'),
(1226, 4, 'zeitung'),
(1227, 4, 'erscheinen'),
(1228, 4, 'weniger'),
(1229, 4, 'wichtig'),
(1230, 4, 'blind'),
(1231, 4, 'gerne'),
(1232, 4, 'sollten'),
(1233, 4, 'mich'),
(1234, 4, 'jetzt'),
(1235, 4, 'dennoch'),
(1236, 4, 'ende'),
(1237, 4, 'lesen'),
(1238, 4, 'dann'),
(1239, 4, 'etwas'),
(1240, 4, 'geschafft'),
(1241, 4, 'den'),
(1242, 4, 'meisten'),
(1243, 4, 'normalen'),
(1244, 4, 'texten'),
(1245, 4, 'gelingt'),
(1246, 3, 'header'),
(1253, 1, 'folder'),
(1266, 1, 'datei'),
(1265, 1, 'file'),
(1264, 1, 'demo');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezsection`
--

DROP TABLE IF EXISTS `ezsection`;
CREATE TABLE IF NOT EXISTS `ezsection` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) DEFAULT NULL,
  `locale` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `navigation_part_identifier` varchar(100) DEFAULT 'ezcontentnavigationpart'
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezsection`
--

INSERT INTO `ezsection` (`id`, `identifier`, `locale`, `name`, `navigation_part_identifier`) VALUES
(1, 'standard', '', 'Standard', 'ezcontentnavigationpart'),
(2, 'users', '', 'Users', 'ezusernavigationpart'),
(3, 'media', '', 'Media', 'ezmedianavigationpart'),
(4, 'setup', '', 'Setup', 'ezsetupnavigationpart'),
(5, 'design', '', 'Design', 'ezvisualnavigationpart');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezsession`
--

DROP TABLE IF EXISTS `ezsession`;
CREATE TABLE IF NOT EXISTS `ezsession` (
  `data` longtext NOT NULL,
  `expiration_time` int(11) NOT NULL DEFAULT '0',
  `session_key` varchar(32) NOT NULL DEFAULT '',
  `user_hash` varchar(32) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezsite_data`
--

DROP TABLE IF EXISTS `ezsite_data`;
CREATE TABLE IF NOT EXISTS `ezsite_data` (
  `name` varchar(60) NOT NULL DEFAULT '',
  `value` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezsite_data`
--

INSERT INTO `ezsite_data` (`name`, `value`) VALUES
('ezpublish-release', '1'),
('ezpublish-version', '5.3.0alpha1');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezsubtree_notification_rule`
--

DROP TABLE IF EXISTS `ezsubtree_notification_rule`;
CREATE TABLE IF NOT EXISTS `ezsubtree_notification_rule` (
  `id` int(11) NOT NULL,
  `node_id` int(11) NOT NULL DEFAULT '0',
  `use_digest` int(11) DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eztipafriend_counter`
--

DROP TABLE IF EXISTS `eztipafriend_counter`;
CREATE TABLE IF NOT EXISTS `eztipafriend_counter` (
  `count` int(11) NOT NULL DEFAULT '0',
  `node_id` int(11) NOT NULL DEFAULT '0',
  `requested` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eztipafriend_request`
--

DROP TABLE IF EXISTS `eztipafriend_request`;
CREATE TABLE IF NOT EXISTS `eztipafriend_request` (
  `created` int(11) NOT NULL DEFAULT '0',
  `email_receiver` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `eztrigger`
--

DROP TABLE IF EXISTS `eztrigger`;
CREATE TABLE IF NOT EXISTS `eztrigger` (
  `connect_type` char(1) NOT NULL DEFAULT '',
  `function_name` varchar(200) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `module_name` varchar(200) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  `workflow_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezurl`
--

DROP TABLE IF EXISTS `ezurl`;
CREATE TABLE IF NOT EXISTS `ezurl` (
  `created` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `is_valid` int(11) NOT NULL DEFAULT '1',
  `last_checked` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `original_url_md5` varchar(32) NOT NULL DEFAULT '',
  `url` longtext
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezurl`
--

INSERT INTO `ezurl` (`created`, `id`, `is_valid`, `last_checked`, `modified`, `original_url_md5`, `url`) VALUES
(1082368571, 4, 1, 0, 1082368571, '41caff1d7f5ad51e70ad46abbcf28fb7', 'http://ez.no/community/forum'),
(1082368571, 8, 1, 0, 1082368571, 'dfcdb471b240d964dc3f57b998eb0533', 'http://ez.no'),
(1301057834, 9, 1, 0, 1301057834, 'bb9c47d334fd775f1c54c45d460e6b2a', 'http://doc.ez.no/'),
(1301057834, 10, 1, 0, 1301057834, 'ae76fd1d17de21067cf13101f11689b1', 'http://ez.no/eZPublish/eZ-Publish-Enterprise-Subscription/Support-Services'),
(1301057834, 11, 1, 0, 1301057834, '0c098a23ef9c7cae63ee8f85cf504b2d', 'http://ez.no/Requests/Contact-Sales'),
(1301057834, 12, 1, 0, 1301057834, '6d8c164dd30423d9dcbc3fae1d64e25c', 'http://ez.no/eZPublish/Training-and-Certification'),
(1301057836, 13, 1, 0, 1301057836, 'b13f5ff5cdcad2a4efb461e4edf6f718', 'http://ez.no/Demos-videos/eZ-Publish-Administration-Interface-Video-Tutorial'),
(1301057836, 14, 1, 0, 1301057836, '7b133bbdf1d039979a973e5a697e3743', 'http://ez.no/Demos-videos/eZ-Publish-Online-Editor-Video-Tutorial'),
(1301057836, 15, 1, 0, 1301057836, '4e75c83ab35d461f109ec959aa1c5e1d', 'http://ez.no/Demos-videos/eZ-Flow-Video-Tutorial'),
(1301057836, 16, 1, 0, 1301057836, '215310c57a3d54ef1356c20855510357', 'http://share.ez.no/learn/ez-publish/an-introduction-to-developing-ez-publish-extensions'),
(1301057836, 17, 1, 0, 1301057836, '9ba078c54f33985da5bd1348a8f39741', 'http://share.ez.no/learn/ez-publish/creating-a-simple-custom-workflow-event'),
(1301057836, 18, 1, 0, 1301057836, 'eb3d19c36acbd41176094024d8fccfd5', 'http://www.slideshare.net/ezcommunity/ole-marius-smestad-rest-api-how-to-turn-ez-publish-into-a-multichannel-machine'),
(1301057836, 19, 1, 0, 1301057836, '1fea0fead02dfc550fbefa5c17acc94f', 'http://www.slideshare.net/BertrandDunogier/presentation-winter-conference-2011-e-z-asynchronous-publishing'),
(1301057836, 20, 1, 0, 1301057836, 'af8f8bdc5fac2f3ada6ad337adab04cb', 'http://doc.ez.no/eZ-Publish/Upgrading/Upgrading-to-4.5'),
(1301057836, 21, 1, 0, 1301057836, '3c6d6cfc2642951e9a946b697f84a306', 'http://share.ez.no/learn'),
(1301057836, 22, 1, 0, 1301057836, 'ac3ba54b44950b2d77fa42cc57dab914', 'http://ez.no/Demos-videos');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezurlalias`
--

DROP TABLE IF EXISTS `ezurlalias`;
CREATE TABLE IF NOT EXISTS `ezurlalias` (
  `destination_url` longtext NOT NULL,
  `forward_to_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `is_imported` int(11) NOT NULL DEFAULT '0',
  `is_internal` int(11) NOT NULL DEFAULT '1',
  `is_wildcard` int(11) NOT NULL DEFAULT '0',
  `source_md5` varchar(32) DEFAULT NULL,
  `source_url` longtext NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezurlalias`
--

INSERT INTO `ezurlalias` (`destination_url`, `forward_to_id`, `id`, `is_imported`, `is_internal`, `is_wildcard`, `source_md5`, `source_url`) VALUES
('content/view/full/2', 0, 12, 1, 1, 0, 'd41d8cd98f00b204e9800998ecf8427e', ''),
('content/view/full/5', 0, 13, 1, 1, 0, '9bc65c2abec141778ffaa729489f3e87', 'users'),
('content/view/full/12', 0, 15, 1, 1, 0, '02d4e844e3a660857a3f81585995ffe1', 'users/guest_accounts'),
('content/view/full/13', 0, 16, 1, 1, 0, '1b1d79c16700fd6003ea7be233e754ba', 'users/administrator_users'),
('content/view/full/14', 0, 17, 1, 1, 0, '0bb9dd665c96bbc1cf36b79180786dea', 'users/editors'),
('content/view/full/15', 0, 18, 1, 1, 0, 'f1305ac5f327a19b451d82719e0c3f5d', 'users/administrator_users/administrator_user'),
('content/view/full/43', 0, 20, 1, 1, 0, '62933a2951ef01f4eafd9bdf4d3cd2f0', 'media'),
('content/view/full/44', 0, 21, 1, 1, 0, '3ae1aac958e1c82013689d917d34967a', 'users/anonymous_users'),
('content/view/full/45', 0, 22, 1, 1, 0, 'aad93975f09371695ba08292fd9698db', 'users/anonymous_users/anonymous_user'),
('content/view/full/48', 0, 25, 1, 1, 0, 'a0f848942ce863cf53c0fa6cc684007d', 'setup'),
('content/view/full/50', 0, 27, 1, 1, 0, 'c60212835de76414f9bfd21eecb8f221', 'foo_bar_folder/images/vbanner'),
('content/view/full/51', 0, 28, 1, 1, 0, '38985339d4a5aadfc41ab292b4527046', 'media/images'),
('content/view/full/52', 0, 29, 1, 1, 0, 'ad5a8c6f6aac3b1b9df267fe22e7aef6', 'media/files'),
('content/view/full/53', 0, 30, 1, 1, 0, '562a0ac498571c6c3529173184a2657c', 'media/multimedia'),
('content/view/full/54', 0, 31, 1, 1, 0, 'e501fe6c81ed14a5af2b322d248102d8', 'setup/common_ini_settings'),
('content/view/full/56', 0, 32, 1, 1, 0, '2dd3db5dc7122ea5f3ee539bb18fe97d', 'design/ez_publish'),
('content/view/full/58', 0, 33, 1, 1, 0, '31c13f47ad87dd7baa2d558a91e0fbb9', 'design');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezurlalias_ml`
--

DROP TABLE IF EXISTS `ezurlalias_ml`;
CREATE TABLE IF NOT EXISTS `ezurlalias_ml` (
  `action` longtext NOT NULL,
  `action_type` varchar(32) NOT NULL DEFAULT '',
  `alias_redirects` int(11) NOT NULL DEFAULT '1',
  `id` int(11) NOT NULL DEFAULT '0',
  `is_alias` int(11) NOT NULL DEFAULT '0',
  `is_original` int(11) NOT NULL DEFAULT '0',
  `lang_mask` bigint(20) NOT NULL DEFAULT '0',
  `link` int(11) NOT NULL DEFAULT '0',
  `parent` int(11) NOT NULL DEFAULT '0',
  `text` longtext NOT NULL,
  `text_md5` varchar(32) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezurlalias_ml`
--

INSERT INTO `ezurlalias_ml` (`action`, `action_type`, `alias_redirects`, `id`, `is_alias`, `is_original`, `lang_mask`, `link`, `parent`, `text`, `text_md5`) VALUES
('nop:', 'nop', 1, 14, 0, 0, 1, 14, 0, 'foo_bar_folder', '0288b6883046492fa92e4a84eb67acc9'),
('eznode:58', 'eznode', 1, 25, 0, 1, 3, 25, 0, 'Design', '31c13f47ad87dd7baa2d558a91e0fbb9'),
('eznode:48', 'eznode', 1, 13, 0, 1, 3, 13, 0, 'Setup2', '475e97c0146bfb1c490339546d9e72ee'),
('nop:', 'nop', 1, 17, 0, 0, 1, 17, 0, 'media2', '50e2736330de124f6edea9b008556fe6'),
('eznode:43', 'eznode', 1, 9, 0, 1, 7, 9, 0, 'Media', '62933a2951ef01f4eafd9bdf4d3cd2f0'),
('nop:', 'nop', 1, 21, 0, 0, 1, 21, 0, 'setup3', '732cefcf28bf4547540609fb1a786a30'),
('nop:', 'nop', 1, 3, 0, 0, 1, 3, 0, 'users2', '86425c35a33507d479f71ade53a669aa'),
('eznode:5', 'eznode', 1, 2, 0, 1, 7, 2, 0, 'Users', '9bc65c2abec141778ffaa729489f3e87'),
('eznode:2', 'eznode', 1, 1, 0, 1, 7, 1, 0, '', 'd41d8cd98f00b204e9800998ecf8427e'),
('eznode:14', 'eznode', 1, 6, 0, 1, 7, 6, 2, 'Editors', 'a147e136bfa717592f2bd70bd4b53b17'),
('eznode:44', 'eznode', 1, 10, 0, 1, 7, 10, 2, 'Anonymous-Users', 'c2803c3fa1b0b5423237b4e018cae755'),
('eznode:12', 'eznode', 1, 4, 0, 1, 7, 4, 2, 'Guest-accounts', 'e57843d836e3af8ab611fde9e2139b3a'),
('eznode:13', 'eznode', 1, 5, 0, 1, 7, 5, 2, 'Administrator-users', 'f89fad7f8a3abc8c09e1deb46a420007'),
('nop:', 'nop', 1, 11, 0, 0, 1, 11, 3, 'anonymous_users2', '505e93077a6dde9034ad97a14ab022b1'),
('eznode:12', 'eznode', 1, 26, 0, 0, 0, 4, 3, 'guest_accounts', '70bb992820e73638731aa8de79b3329e'),
('eznode:14', 'eznode', 1, 29, 0, 0, 0, 6, 3, 'editors', 'a147e136bfa717592f2bd70bd4b53b17'),
('nop:', 'nop', 1, 7, 0, 0, 1, 7, 3, 'administrator_users2', 'a7da338c20bf65f9f789c87296379c2a'),
('eznode:13', 'eznode', 1, 27, 0, 0, 0, 5, 3, 'administrator_users', 'aeb8609aa933b0899aa012c71139c58c'),
('eznode:44', 'eznode', 1, 30, 0, 0, 0, 10, 3, 'anonymous_users', 'e9e5ad0c05ee1a43715572e5cc545926'),
('eznode:15', 'eznode', 1, 8, 0, 1, 7, 8, 5, 'Administrator-User', '5a9d7b0ec93173ef4fedee023209cb61'),
('eznode:15', 'eznode', 1, 28, 0, 0, 0, 8, 7, 'administrator_user', 'a3cca2de936df1e2f805710399989971'),
('eznode:53', 'eznode', 1, 20, 0, 1, 7, 20, 9, 'Multimedia', '2e5bc8831f7ae6a29530e7f1bbf2de9c'),
('eznode:52', 'eznode', 1, 19, 0, 1, 7, 19, 9, 'Files', '45b963397aa40d4a0063e0d85e4fe7a1'),
('eznode:51', 'eznode', 1, 18, 0, 1, 7, 18, 9, 'Images', '59b514174bffe4ae402b3d63aad79fe0'),
('eznode:45', 'eznode', 1, 12, 0, 1, 7, 12, 10, 'Anonymous-User', 'ccb62ebca03a31272430bc414bd5cd5b'),
('eznode:45', 'eznode', 1, 31, 0, 0, 0, 12, 11, 'anonymous_user', 'c593ec85293ecb0e02d50d4c5c6c20eb'),
('eznode:54', 'eznode', 1, 22, 0, 1, 2, 22, 13, 'Common-INI-settings', '4434993ac013ae4d54bb1f51034d6401'),
('nop:', 'nop', 1, 15, 0, 0, 1, 15, 14, 'images', '59b514174bffe4ae402b3d63aad79fe0'),
('eznode:50', 'eznode', 1, 16, 0, 1, 2, 16, 15, 'vbanner', 'c54e2d1b93642e280bdc5d99eab2827d'),
('eznode:53', 'eznode', 1, 34, 0, 0, 0, 20, 17, 'multimedia', '2e5bc8831f7ae6a29530e7f1bbf2de9c'),
('eznode:52', 'eznode', 1, 33, 0, 0, 0, 19, 17, 'files', '45b963397aa40d4a0063e0d85e4fe7a1'),
('eznode:51', 'eznode', 1, 32, 0, 0, 0, 18, 17, 'images', '59b514174bffe4ae402b3d63aad79fe0'),
('eznode:54', 'eznode', 1, 35, 0, 0, 1, 22, 21, 'common_ini_settings', 'e59d6834e86cee752ed841f9cd8d5baf'),
('eznode:56', 'eznode', 1, 37, 0, 0, 2, 24, 25, 'eZ-publish', '10e4c3cb527fb9963258469986c16240'),
('eznode:56', 'eznode', 1, 24, 0, 1, 2, 24, 25, 'Plain-site', '49a39d99a955d95aa5d636275656a07a'),
('eznode:59', 'eznode', 1, 38, 0, 1, 5, 38, 0, 'WWW-Home', '54e53d37299f06ea66e9fb260d816e60'),
('eznode:59', 'eznode', 1, 40, 0, 0, 5, 38, 0, 'Home-Ordner', '4bcd94b2d6ac9a11e77b5ecb82a9f860'),
('eznode:60', 'eznode', 1, 47, 0, 0, 5, 41, 38, 'Test-Ordner-1', 'd4360b554e7efdffc4916b717628d631'),
('eznode:67', 'eznode', 1, 54, 0, 0, 4, 53, 38, 'node_67', 'a280d958395afe05f3a456a4be630f12'),
('eznode:62', 'eznode', 1, 43, 0, 1, 4, 43, 41, 'Test-Seite-1-1', '1dcd8414268282410b2f99672a32e768'),
('eznode:63', 'eznode', 1, 44, 0, 1, 4, 44, 41, 'Test-Seite-1-2', '389c270e2d8d92015010aabaffb2ce20'),
('eznode:64', 'eznode', 1, 45, 0, 0, 4, 50, 42, 'Test-Seite-2-1', 'f9a272b3ff9d0696ca7736d48b70b7b3'),
('eznode:65', 'eznode', 1, 46, 0, 0, 4, 51, 42, 'Test-Seite-2-2', '8cd30e15643e7add1aada69274ae4636'),
('eznode:60', 'eznode', 1, 41, 0, 1, 3, 41, 38, 'TEST-Folder-eng-GB', 'e6abfce4c2ab77243f3bc6ec571666af'),
('eznode:60', 'eznode', 1, 41, 0, 1, 5, 41, 38, 'Test-Ordner-1-ger-DE', '3f2275d1ece320fe04b3f409853e061e'),
('eznode:66', 'eznode', 1, 49, 0, 1, 4, 49, 38, 'Ordner-2-ger-DE', '116aff52e8a6a3f17e82e60a6d825f26'),
('eznode:66', 'eznode', 1, 52, 0, 0, 4, 49, 38, 'Ordner-3-ger', 'ec22170f7248d6fc5d4b030738c3dcd6'),
('eznode:64', 'eznode', 1, 50, 0, 1, 4, 50, 49, 'Test-Seite-2-1', 'f9a272b3ff9d0696ca7736d48b70b7b3'),
('eznode:65', 'eznode', 1, 51, 0, 1, 4, 51, 49, 'Test-Seite-2-2', '8cd30e15643e7add1aada69274ae4636'),
('eznode:67', 'eznode', 1, 53, 0, 1, 4, 53, 38, 'Kontaktformular', 'c7ec67c74104a45bde479c5d666bdc75'),
('eznode:67', 'eznode', 1, 53, 0, 1, 2, 53, 38, 'Feedbackform', 'f5421f02e6bb1ae14ce5f9d759dca23a'),
('eznode:68', 'eznode', 1, 56, 0, 0, 3, 55, 41, 'neue-DateiNew-File', '5ed7187b27c56f9837738f8f42d9a863'),
('eznode:68', 'eznode', 1, 55, 0, 1, 3, 55, 41, 'Demo-File', 'c30f1a935efd24aec7d62eb2c88b6d2e'),
('eznode:68', 'eznode', 1, 55, 0, 1, 5, 55, 41, 'Demo-Datei', 'e8aadd495af88dffda794124494ba76c');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezurlalias_ml_incr`
--

DROP TABLE IF EXISTS `ezurlalias_ml_incr`;
CREATE TABLE IF NOT EXISTS `ezurlalias_ml_incr` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezurlalias_ml_incr`
--

INSERT INTO `ezurlalias_ml_incr` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34),
(35),
(36),
(37),
(38),
(39),
(40),
(41),
(42),
(43),
(44),
(45),
(46),
(47),
(48),
(49),
(50),
(51),
(52),
(53),
(54),
(55),
(56);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezurlwildcard`
--

DROP TABLE IF EXISTS `ezurlwildcard`;
CREATE TABLE IF NOT EXISTS `ezurlwildcard` (
  `destination_url` longtext NOT NULL,
  `id` int(11) NOT NULL,
  `source_url` longtext NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezurl_object_link`
--

DROP TABLE IF EXISTS `ezurl_object_link`;
CREATE TABLE IF NOT EXISTS `ezurl_object_link` (
  `contentobject_attribute_id` int(11) NOT NULL DEFAULT '0',
  `contentobject_attribute_version` int(11) NOT NULL DEFAULT '0',
  `url_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezurl_object_link`
--

INSERT INTO `ezurl_object_link` (`contentobject_attribute_id`, `contentobject_attribute_version`, `url_id`) VALUES
(104, 6, 9),
(104, 6, 4),
(104, 6, 10),
(104, 6, 11),
(104, 6, 12),
(104, 6, 8),
(104, 6, 13),
(104, 6, 14),
(104, 6, 15),
(104, 6, 16),
(104, 6, 17),
(104, 6, 18),
(104, 6, 19),
(104, 6, 20),
(104, 6, 21),
(104, 6, 22),
(189, 7, 9),
(189, 7, 4),
(189, 7, 10),
(189, 7, 11),
(189, 7, 12),
(189, 7, 8),
(189, 7, 13),
(189, 7, 14),
(189, 7, 15),
(189, 7, 16),
(189, 7, 17),
(189, 7, 18),
(189, 7, 19),
(189, 7, 20),
(189, 7, 21),
(189, 7, 22),
(104, 7, 9),
(104, 7, 4),
(104, 7, 10),
(104, 7, 11),
(104, 7, 12),
(104, 7, 8),
(104, 7, 13),
(104, 7, 14),
(104, 7, 15),
(104, 7, 16),
(104, 7, 17),
(104, 7, 18),
(104, 7, 19),
(104, 7, 20),
(104, 7, 21),
(104, 7, 22);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezuser`
--

DROP TABLE IF EXISTS `ezuser`;
CREATE TABLE IF NOT EXISTS `ezuser` (
  `contentobject_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(150) NOT NULL DEFAULT '',
  `login` varchar(150) NOT NULL DEFAULT '',
  `password_hash` varchar(50) DEFAULT NULL,
  `password_hash_type` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezuser`
--

INSERT INTO `ezuser` (`contentobject_id`, `email`, `login`, `password_hash`, `password_hash_type`) VALUES
(10, 'nospam@ez.no', 'anonymous', '4e6f6184135228ccd45f8233d72a0363', 2),
(14, 'nospam@ez.no', 'admin', 'c78e3b0f3d9244ed8c6d1c29464bdff9', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezuservisit`
--

DROP TABLE IF EXISTS `ezuservisit`;
CREATE TABLE IF NOT EXISTS `ezuservisit` (
  `current_visit_timestamp` int(11) NOT NULL DEFAULT '0',
  `failed_login_attempts` int(11) NOT NULL DEFAULT '0',
  `last_visit_timestamp` int(11) NOT NULL DEFAULT '0',
  `login_count` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezuservisit`
--

INSERT INTO `ezuservisit` (`current_visit_timestamp`, `failed_login_attempts`, `last_visit_timestamp`, `login_count`, `user_id`) VALUES
(1439551763, 0, 1438011678, 9, 14);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezuser_accountkey`
--

DROP TABLE IF EXISTS `ezuser_accountkey`;
CREATE TABLE IF NOT EXISTS `ezuser_accountkey` (
  `hash_key` varchar(32) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezuser_discountrule`
--

DROP TABLE IF EXISTS `ezuser_discountrule`;
CREATE TABLE IF NOT EXISTS `ezuser_discountrule` (
  `contentobject_id` int(11) DEFAULT NULL,
  `discountrule_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezuser_role`
--

DROP TABLE IF EXISTS `ezuser_role`;
CREATE TABLE IF NOT EXISTS `ezuser_role` (
  `contentobject_id` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `limit_identifier` varchar(255) DEFAULT '',
  `limit_value` varchar(255) DEFAULT '',
  `role_id` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezuser_role`
--

INSERT INTO `ezuser_role` (`contentobject_id`, `id`, `limit_identifier`, `limit_value`, `role_id`) VALUES
(12, 25, '', '', 2),
(11, 28, '', '', 1),
(42, 31, '', '', 1),
(13, 32, 'Subtree', '/1/2/', 3),
(13, 33, 'Subtree', '/1/43/', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezuser_setting`
--

DROP TABLE IF EXISTS `ezuser_setting`;
CREATE TABLE IF NOT EXISTS `ezuser_setting` (
  `is_enabled` int(11) NOT NULL DEFAULT '0',
  `max_login` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezuser_setting`
--

INSERT INTO `ezuser_setting` (`is_enabled`, `max_login`, `user_id`) VALUES
(1, 1000, 10),
(1, 10, 14);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezvatrule`
--

DROP TABLE IF EXISTS `ezvatrule`;
CREATE TABLE IF NOT EXISTS `ezvatrule` (
  `country_code` varchar(255) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `vat_type` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezvatrule_product_category`
--

DROP TABLE IF EXISTS `ezvatrule_product_category`;
CREATE TABLE IF NOT EXISTS `ezvatrule_product_category` (
  `product_category_id` int(11) NOT NULL DEFAULT '0',
  `vatrule_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezvattype`
--

DROP TABLE IF EXISTS `ezvattype`;
CREATE TABLE IF NOT EXISTS `ezvattype` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `percentage` float DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezvattype`
--

INSERT INTO `ezvattype` (`id`, `name`, `percentage`) VALUES
(1, 'Std', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezview_counter`
--

DROP TABLE IF EXISTS `ezview_counter`;
CREATE TABLE IF NOT EXISTS `ezview_counter` (
  `count` int(11) NOT NULL DEFAULT '0',
  `node_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezwaituntildatevalue`
--

DROP TABLE IF EXISTS `ezwaituntildatevalue`;
CREATE TABLE IF NOT EXISTS `ezwaituntildatevalue` (
  `contentclass_attribute_id` int(11) NOT NULL DEFAULT '0',
  `contentclass_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `workflow_event_id` int(11) NOT NULL DEFAULT '0',
  `workflow_event_version` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezwishlist`
--

DROP TABLE IF EXISTS `ezwishlist`;
CREATE TABLE IF NOT EXISTS `ezwishlist` (
  `id` int(11) NOT NULL,
  `productcollection_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezworkflow`
--

DROP TABLE IF EXISTS `ezworkflow`;
CREATE TABLE IF NOT EXISTS `ezworkflow` (
  `created` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `is_enabled` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `modifier_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `version` int(11) NOT NULL DEFAULT '0',
  `workflow_type_string` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezworkflow_assign`
--

DROP TABLE IF EXISTS `ezworkflow_assign`;
CREATE TABLE IF NOT EXISTS `ezworkflow_assign` (
  `access_type` int(11) NOT NULL DEFAULT '0',
  `as_tree` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `node_id` int(11) NOT NULL DEFAULT '0',
  `workflow_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezworkflow_event`
--

DROP TABLE IF EXISTS `ezworkflow_event`;
CREATE TABLE IF NOT EXISTS `ezworkflow_event` (
  `data_int1` int(11) DEFAULT NULL,
  `data_int2` int(11) DEFAULT NULL,
  `data_int3` int(11) DEFAULT NULL,
  `data_int4` int(11) DEFAULT NULL,
  `data_text1` varchar(255) DEFAULT NULL,
  `data_text2` varchar(255) DEFAULT NULL,
  `data_text3` varchar(255) DEFAULT NULL,
  `data_text4` varchar(255) DEFAULT NULL,
  `data_text5` longtext,
  `description` varchar(50) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL,
  `placement` int(11) NOT NULL DEFAULT '0',
  `version` int(11) NOT NULL DEFAULT '0',
  `workflow_id` int(11) NOT NULL DEFAULT '0',
  `workflow_type_string` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezworkflow_group`
--

DROP TABLE IF EXISTS `ezworkflow_group`;
CREATE TABLE IF NOT EXISTS `ezworkflow_group` (
  `created` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `modified` int(11) NOT NULL DEFAULT '0',
  `modifier_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `ezworkflow_group`
--

INSERT INTO `ezworkflow_group` (`created`, `creator_id`, `id`, `modified`, `modifier_id`, `name`) VALUES
(1024392098, 14, 1, 1024392098, 14, 'Standard');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezworkflow_group_link`
--

DROP TABLE IF EXISTS `ezworkflow_group_link`;
CREATE TABLE IF NOT EXISTS `ezworkflow_group_link` (
  `group_id` int(11) NOT NULL DEFAULT '0',
  `group_name` varchar(255) DEFAULT NULL,
  `workflow_id` int(11) NOT NULL DEFAULT '0',
  `workflow_version` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ezworkflow_process`
--

DROP TABLE IF EXISTS `ezworkflow_process`;
CREATE TABLE IF NOT EXISTS `ezworkflow_process` (
  `activation_date` int(11) DEFAULT NULL,
  `content_id` int(11) NOT NULL DEFAULT '0',
  `content_version` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT '0',
  `event_position` int(11) NOT NULL DEFAULT '0',
  `event_state` int(11) DEFAULT NULL,
  `event_status` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL,
  `last_event_id` int(11) NOT NULL DEFAULT '0',
  `last_event_position` int(11) NOT NULL DEFAULT '0',
  `last_event_status` int(11) NOT NULL DEFAULT '0',
  `memento_key` varchar(32) DEFAULT NULL,
  `modified` int(11) NOT NULL DEFAULT '0',
  `node_id` int(11) NOT NULL DEFAULT '0',
  `parameters` longtext,
  `process_key` varchar(32) NOT NULL DEFAULT '',
  `session_key` varchar(32) NOT NULL DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `workflow_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ezapprove_items`
--
ALTER TABLE `ezapprove_items`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezbasket`
--
ALTER TABLE `ezbasket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezbasket_session_id` (`session_id`);

--
-- Indizes für die Tabelle `ezbinaryfile`
--
ALTER TABLE `ezbinaryfile`
  ADD PRIMARY KEY (`contentobject_attribute_id`,`version`);

--
-- Indizes für die Tabelle `ezcobj_state`
--
ALTER TABLE `ezcobj_state`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ezcobj_state_identifier` (`group_id`,`identifier`),
  ADD KEY `ezcobj_state_lmask` (`language_mask`),
  ADD KEY `ezcobj_state_priority` (`priority`);

--
-- Indizes für die Tabelle `ezcobj_state_group`
--
ALTER TABLE `ezcobj_state_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ezcobj_state_group_identifier` (`identifier`),
  ADD KEY `ezcobj_state_group_lmask` (`language_mask`);

--
-- Indizes für die Tabelle `ezcobj_state_group_language`
--
ALTER TABLE `ezcobj_state_group_language`
  ADD PRIMARY KEY (`contentobject_state_group_id`,`real_language_id`);

--
-- Indizes für die Tabelle `ezcobj_state_language`
--
ALTER TABLE `ezcobj_state_language`
  ADD PRIMARY KEY (`contentobject_state_id`,`language_id`);

--
-- Indizes für die Tabelle `ezcobj_state_link`
--
ALTER TABLE `ezcobj_state_link`
  ADD PRIMARY KEY (`contentobject_id`,`contentobject_state_id`);

--
-- Indizes für die Tabelle `ezcollab_group`
--
ALTER TABLE `ezcollab_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezcollab_group_depth` (`depth`),
  ADD KEY `ezcollab_group_path` (`path_string`);

--
-- Indizes für die Tabelle `ezcollab_item`
--
ALTER TABLE `ezcollab_item`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezcollab_item_group_link`
--
ALTER TABLE `ezcollab_item_group_link`
  ADD PRIMARY KEY (`collaboration_id`,`group_id`,`user_id`);

--
-- Indizes für die Tabelle `ezcollab_item_message_link`
--
ALTER TABLE `ezcollab_item_message_link`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezcollab_item_participant_link`
--
ALTER TABLE `ezcollab_item_participant_link`
  ADD PRIMARY KEY (`collaboration_id`,`participant_id`);

--
-- Indizes für die Tabelle `ezcollab_item_status`
--
ALTER TABLE `ezcollab_item_status`
  ADD PRIMARY KEY (`collaboration_id`,`user_id`);

--
-- Indizes für die Tabelle `ezcollab_notification_rule`
--
ALTER TABLE `ezcollab_notification_rule`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezcollab_profile`
--
ALTER TABLE `ezcollab_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezcollab_simple_message`
--
ALTER TABLE `ezcollab_simple_message`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezcontentbrowsebookmark`
--
ALTER TABLE `ezcontentbrowsebookmark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezcontentbrowsebookmark_user` (`user_id`);

--
-- Indizes für die Tabelle `ezcontentbrowserecent`
--
ALTER TABLE `ezcontentbrowserecent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezcontentbrowserecent_user` (`user_id`);

--
-- Indizes für die Tabelle `ezcontentclass`
--
ALTER TABLE `ezcontentclass`
  ADD PRIMARY KEY (`id`,`version`),
  ADD KEY `ezcontentclass_version` (`version`);

--
-- Indizes für die Tabelle `ezcontentclassgroup`
--
ALTER TABLE `ezcontentclassgroup`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezcontentclass_attribute`
--
ALTER TABLE `ezcontentclass_attribute`
  ADD PRIMARY KEY (`id`,`version`),
  ADD KEY `ezcontentclass_attr_ccid` (`contentclass_id`);

--
-- Indizes für die Tabelle `ezcontentclass_classgroup`
--
ALTER TABLE `ezcontentclass_classgroup`
  ADD PRIMARY KEY (`contentclass_id`,`contentclass_version`,`group_id`);

--
-- Indizes für die Tabelle `ezcontentclass_name`
--
ALTER TABLE `ezcontentclass_name`
  ADD PRIMARY KEY (`contentclass_id`,`contentclass_version`,`language_id`);

--
-- Indizes für die Tabelle `ezcontentobject`
--
ALTER TABLE `ezcontentobject`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ezcontentobject_remote_id` (`remote_id`),
  ADD KEY `ezcontentobject_classid` (`contentclass_id`),
  ADD KEY `ezcontentobject_currentversion` (`current_version`),
  ADD KEY `ezcontentobject_lmask` (`language_mask`),
  ADD KEY `ezcontentobject_owner` (`owner_id`),
  ADD KEY `ezcontentobject_pub` (`published`),
  ADD KEY `ezcontentobject_status` (`status`);

--
-- Indizes für die Tabelle `ezcontentobject_attribute`
--
ALTER TABLE `ezcontentobject_attribute`
  ADD PRIMARY KEY (`id`,`version`),
  ADD KEY `ezcontentobject_attribute_co_id_ver_lang_code` (`contentobject_id`,`version`,`language_code`),
  ADD KEY `ezcontentobject_attribute_language_code` (`language_code`),
  ADD KEY `ezcontentobject_classattr_id` (`contentclassattribute_id`),
  ADD KEY `sort_key_int` (`sort_key_int`),
  ADD KEY `sort_key_string` (`sort_key_string`);

--
-- Indizes für die Tabelle `ezcontentobject_link`
--
ALTER TABLE `ezcontentobject_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezco_link_from` (`from_contentobject_id`,`from_contentobject_version`,`contentclassattribute_id`),
  ADD KEY `ezco_link_to_co_id` (`to_contentobject_id`);

--
-- Indizes für die Tabelle `ezcontentobject_name`
--
ALTER TABLE `ezcontentobject_name`
  ADD PRIMARY KEY (`contentobject_id`,`content_version`,`content_translation`),
  ADD KEY `ezcontentobject_name_cov_id` (`content_version`),
  ADD KEY `ezcontentobject_name_lang_id` (`language_id`),
  ADD KEY `ezcontentobject_name_name` (`name`);

--
-- Indizes für die Tabelle `ezcontentobject_trash`
--
ALTER TABLE `ezcontentobject_trash`
  ADD PRIMARY KEY (`node_id`),
  ADD KEY `ezcobj_trash_co_id` (`contentobject_id`),
  ADD KEY `ezcobj_trash_depth` (`depth`),
  ADD KEY `ezcobj_trash_modified_subnode` (`modified_subnode`),
  ADD KEY `ezcobj_trash_p_node_id` (`parent_node_id`),
  ADD KEY `ezcobj_trash_path` (`path_string`),
  ADD KEY `ezcobj_trash_path_ident` (`path_identification_string`(50));

--
-- Indizes für die Tabelle `ezcontentobject_tree`
--
ALTER TABLE `ezcontentobject_tree`
  ADD PRIMARY KEY (`node_id`),
  ADD KEY `ezcontentobject_tree_co_id` (`contentobject_id`),
  ADD KEY `ezcontentobject_tree_depth` (`depth`),
  ADD KEY `ezcontentobject_tree_p_node_id` (`parent_node_id`),
  ADD KEY `ezcontentobject_tree_path` (`path_string`),
  ADD KEY `ezcontentobject_tree_path_ident` (`path_identification_string`(50)),
  ADD KEY `modified_subnode` (`modified_subnode`);

--
-- Indizes für die Tabelle `ezcontentobject_version`
--
ALTER TABLE `ezcontentobject_version`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezcobj_version_creator_id` (`creator_id`),
  ADD KEY `ezcobj_version_status` (`status`),
  ADD KEY `idx_object_version_objver` (`contentobject_id`,`version`);

--
-- Indizes für die Tabelle `ezcontent_language`
--
ALTER TABLE `ezcontent_language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezcontent_language_name` (`name`);

--
-- Indizes für die Tabelle `ezcurrencydata`
--
ALTER TABLE `ezcurrencydata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezcurrencydata_code` (`code`);

--
-- Indizes für die Tabelle `ezdiscountrule`
--
ALTER TABLE `ezdiscountrule`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezdiscountsubrule`
--
ALTER TABLE `ezdiscountsubrule`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezdiscountsubrule_value`
--
ALTER TABLE `ezdiscountsubrule_value`
  ADD PRIMARY KEY (`discountsubrule_id`,`value`,`issection`);

--
-- Indizes für die Tabelle `ezenumobjectvalue`
--
ALTER TABLE `ezenumobjectvalue`
  ADD PRIMARY KEY (`contentobject_attribute_id`,`contentobject_attribute_version`,`enumid`);

--
-- Indizes für die Tabelle `ezenumvalue`
--
ALTER TABLE `ezenumvalue`
  ADD PRIMARY KEY (`id`,`contentclass_attribute_id`,`contentclass_attribute_version`),
  ADD KEY `ezenumvalue_co_cl_attr_id_co_class_att_ver` (`contentclass_attribute_id`,`contentclass_attribute_version`);

--
-- Indizes für die Tabelle `ezforgot_password`
--
ALTER TABLE `ezforgot_password`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezforgot_password_user` (`user_id`);

--
-- Indizes für die Tabelle `ezgeneral_digest_user_settings`
--
ALTER TABLE `ezgeneral_digest_user_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ezgeneral_digest_user_id` (`user_id`);

--
-- Indizes für die Tabelle `ezimagefile`
--
ALTER TABLE `ezimagefile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezimagefile_coid` (`contentobject_attribute_id`),
  ADD KEY `ezimagefile_file` (`filepath`(200));

--
-- Indizes für die Tabelle `ezinfocollection`
--
ALTER TABLE `ezinfocollection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezinfocollection_co_id_created` (`contentobject_id`,`created`);

--
-- Indizes für die Tabelle `ezinfocollection_attribute`
--
ALTER TABLE `ezinfocollection_attribute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezinfocollection_attr_cca_id` (`contentclass_attribute_id`),
  ADD KEY `ezinfocollection_attr_co_id` (`contentobject_id`),
  ADD KEY `ezinfocollection_attr_coa_id` (`contentobject_attribute_id`),
  ADD KEY `ezinfocollection_attr_ic_id` (`informationcollection_id`);

--
-- Indizes für die Tabelle `ezisbn_group`
--
ALTER TABLE `ezisbn_group`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezisbn_group_range`
--
ALTER TABLE `ezisbn_group_range`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezisbn_registrant_range`
--
ALTER TABLE `ezisbn_registrant_range`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezkeyword`
--
ALTER TABLE `ezkeyword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezkeyword_keyword` (`keyword`);

--
-- Indizes für die Tabelle `ezkeyword_attribute_link`
--
ALTER TABLE `ezkeyword_attribute_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezkeyword_attr_link_kid_oaid` (`keyword_id`,`objectattribute_id`),
  ADD KEY `ezkeyword_attr_link_oaid` (`objectattribute_id`);

--
-- Indizes für die Tabelle `ezmedia`
--
ALTER TABLE `ezmedia`
  ADD PRIMARY KEY (`contentobject_attribute_id`,`version`);

--
-- Indizes für die Tabelle `ezmessage`
--
ALTER TABLE `ezmessage`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezmodule_run`
--
ALTER TABLE `ezmodule_run`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ezmodule_run_workflow_process_id_s` (`workflow_process_id`);

--
-- Indizes für die Tabelle `ezmultipricedata`
--
ALTER TABLE `ezmultipricedata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezmultipricedata_coa_id` (`contentobject_attr_id`),
  ADD KEY `ezmultipricedata_coa_version` (`contentobject_attr_version`),
  ADD KEY `ezmultipricedata_currency_code` (`currency_code`);

--
-- Indizes für die Tabelle `eznode_assignment`
--
ALTER TABLE `eznode_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `eznode_assignment_co_version` (`contentobject_version`),
  ADD KEY `eznode_assignment_coid_cov` (`contentobject_id`,`contentobject_version`),
  ADD KEY `eznode_assignment_is_main` (`is_main`),
  ADD KEY `eznode_assignment_parent_node` (`parent_node`);

--
-- Indizes für die Tabelle `eznotificationcollection`
--
ALTER TABLE `eznotificationcollection`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `eznotificationcollection_item`
--
ALTER TABLE `eznotificationcollection_item`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `eznotificationevent`
--
ALTER TABLE `eznotificationevent`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezoperation_memento`
--
ALTER TABLE `ezoperation_memento`
  ADD PRIMARY KEY (`id`,`memento_key`),
  ADD KEY `ezoperation_memento_memento_key_main` (`memento_key`,`main`);

--
-- Indizes für die Tabelle `ezorder`
--
ALTER TABLE `ezorder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezorder_is_archived` (`is_archived`),
  ADD KEY `ezorder_is_tmp` (`is_temporary`);

--
-- Indizes für die Tabelle `ezorder_item`
--
ALTER TABLE `ezorder_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezorder_item_order_id` (`order_id`),
  ADD KEY `ezorder_item_type` (`type`);

--
-- Indizes für die Tabelle `ezorder_nr_incr`
--
ALTER TABLE `ezorder_nr_incr`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezorder_status`
--
ALTER TABLE `ezorder_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezorder_status_active` (`is_active`),
  ADD KEY `ezorder_status_name` (`name`),
  ADD KEY `ezorder_status_sid` (`status_id`);

--
-- Indizes für die Tabelle `ezorder_status_history`
--
ALTER TABLE `ezorder_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezorder_status_history_mod` (`modified`),
  ADD KEY `ezorder_status_history_oid` (`order_id`),
  ADD KEY `ezorder_status_history_sid` (`status_id`);

--
-- Indizes für die Tabelle `ezpackage`
--
ALTER TABLE `ezpackage`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezpaymentobject`
--
ALTER TABLE `ezpaymentobject`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezpdf_export`
--
ALTER TABLE `ezpdf_export`
  ADD PRIMARY KEY (`id`,`version`);

--
-- Indizes für die Tabelle `ezpending_actions`
--
ALTER TABLE `ezpending_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezpending_actions_action` (`action`),
  ADD KEY `ezpending_actions_created` (`created`);

--
-- Indizes für die Tabelle `ezpolicy`
--
ALTER TABLE `ezpolicy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezpolicy_original_id` (`original_id`);

--
-- Indizes für die Tabelle `ezpolicy_limitation`
--
ALTER TABLE `ezpolicy_limitation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `policy_id` (`policy_id`);

--
-- Indizes für die Tabelle `ezpolicy_limitation_value`
--
ALTER TABLE `ezpolicy_limitation_value`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezpolicy_limitation_value_val` (`value`);

--
-- Indizes für die Tabelle `ezpreferences`
--
ALTER TABLE `ezpreferences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezpreferences_name` (`name`),
  ADD KEY `ezpreferences_user_id_idx` (`user_id`,`name`);

--
-- Indizes für die Tabelle `ezprest_authcode`
--
ALTER TABLE `ezprest_authcode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authcode_client_id` (`client_id`);

--
-- Indizes für die Tabelle `ezprest_authorized_clients`
--
ALTER TABLE `ezprest_authorized_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_user` (`rest_client_id`,`user_id`);

--
-- Indizes für die Tabelle `ezprest_clients`
--
ALTER TABLE `ezprest_clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_id_unique` (`client_id`,`version`);

--
-- Indizes für die Tabelle `ezprest_token`
--
ALTER TABLE `ezprest_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token_client_id` (`client_id`);

--
-- Indizes für die Tabelle `ezproductcategory`
--
ALTER TABLE `ezproductcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezproductcollection`
--
ALTER TABLE `ezproductcollection`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezproductcollection_item`
--
ALTER TABLE `ezproductcollection_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezproductcollection_item_contentobject_id` (`contentobject_id`),
  ADD KEY `ezproductcollection_item_productcollection_id` (`productcollection_id`);

--
-- Indizes für die Tabelle `ezproductcollection_item_opt`
--
ALTER TABLE `ezproductcollection_item_opt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezproductcollection_item_opt_item_id` (`item_id`);

--
-- Indizes für die Tabelle `ezpublishingqueueprocesses`
--
ALTER TABLE `ezpublishingqueueprocesses`
  ADD PRIMARY KEY (`ezcontentobject_version_id`);

--
-- Indizes für die Tabelle `ezrole`
--
ALTER TABLE `ezrole`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezrss_export`
--
ALTER TABLE `ezrss_export`
  ADD PRIMARY KEY (`id`,`status`);

--
-- Indizes für die Tabelle `ezrss_export_item`
--
ALTER TABLE `ezrss_export_item`
  ADD PRIMARY KEY (`id`,`status`),
  ADD KEY `ezrss_export_rsseid` (`rssexport_id`);

--
-- Indizes für die Tabelle `ezrss_import`
--
ALTER TABLE `ezrss_import`
  ADD PRIMARY KEY (`id`,`status`);

--
-- Indizes für die Tabelle `ezscheduled_script`
--
ALTER TABLE `ezscheduled_script`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezscheduled_script_timestamp` (`last_report_timestamp`);

--
-- Indizes für die Tabelle `ezsearch_object_word_link`
--
ALTER TABLE `ezsearch_object_word_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezsearch_object_word_link_frequency` (`frequency`),
  ADD KEY `ezsearch_object_word_link_identifier` (`identifier`),
  ADD KEY `ezsearch_object_word_link_integer_value` (`integer_value`),
  ADD KEY `ezsearch_object_word_link_object` (`contentobject_id`),
  ADD KEY `ezsearch_object_word_link_word` (`word_id`);

--
-- Indizes für die Tabelle `ezsearch_return_count`
--
ALTER TABLE `ezsearch_return_count`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezsearch_return_cnt_ph_id_cnt` (`phrase_id`,`count`);

--
-- Indizes für die Tabelle `ezsearch_search_phrase`
--
ALTER TABLE `ezsearch_search_phrase`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ezsearch_search_phrase_phrase` (`phrase`),
  ADD KEY `ezsearch_search_phrase_count` (`phrase_count`);

--
-- Indizes für die Tabelle `ezsearch_word`
--
ALTER TABLE `ezsearch_word`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezsearch_word_obj_count` (`object_count`),
  ADD KEY `ezsearch_word_word_i` (`word`);

--
-- Indizes für die Tabelle `ezsection`
--
ALTER TABLE `ezsection`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezsession`
--
ALTER TABLE `ezsession`
  ADD PRIMARY KEY (`session_key`),
  ADD KEY `expiration_time` (`expiration_time`),
  ADD KEY `ezsession_user_id` (`user_id`);

--
-- Indizes für die Tabelle `ezsite_data`
--
ALTER TABLE `ezsite_data`
  ADD PRIMARY KEY (`name`);

--
-- Indizes für die Tabelle `ezsubtree_notification_rule`
--
ALTER TABLE `ezsubtree_notification_rule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezsubtree_notification_rule_user_id` (`user_id`);

--
-- Indizes für die Tabelle `eztipafriend_counter`
--
ALTER TABLE `eztipafriend_counter`
  ADD PRIMARY KEY (`node_id`,`requested`);

--
-- Indizes für die Tabelle `eztipafriend_request`
--
ALTER TABLE `eztipafriend_request`
  ADD KEY `eztipafriend_request_created` (`created`),
  ADD KEY `eztipafriend_request_email_rec` (`email_receiver`);

--
-- Indizes für die Tabelle `eztrigger`
--
ALTER TABLE `eztrigger`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `eztrigger_def_id` (`module_name`(50),`function_name`(50),`connect_type`),
  ADD KEY `eztrigger_fetch` (`name`(25),`module_name`(50),`function_name`(50));

--
-- Indizes für die Tabelle `ezurl`
--
ALTER TABLE `ezurl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezurl_url` (`url`(255));

--
-- Indizes für die Tabelle `ezurlalias`
--
ALTER TABLE `ezurlalias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezurlalias_desturl` (`destination_url`(200)),
  ADD KEY `ezurlalias_forward_to_id` (`forward_to_id`),
  ADD KEY `ezurlalias_imp_wcard_fwd` (`is_imported`,`is_wildcard`,`forward_to_id`),
  ADD KEY `ezurlalias_source_md5` (`source_md5`),
  ADD KEY `ezurlalias_source_url` (`source_url`(255)),
  ADD KEY `ezurlalias_wcard_fwd` (`is_wildcard`,`forward_to_id`);

--
-- Indizes für die Tabelle `ezurlalias_ml`
--
ALTER TABLE `ezurlalias_ml`
  ADD PRIMARY KEY (`parent`,`text_md5`),
  ADD KEY `ezurlalias_ml_act_org` (`action`(32),`is_original`),
  ADD KEY `ezurlalias_ml_actt_org_al` (`action_type`,`is_original`,`is_alias`),
  ADD KEY `ezurlalias_ml_id` (`id`),
  ADD KEY `ezurlalias_ml_par_act_id_lnk` (`action`(32),`id`,`link`,`parent`),
  ADD KEY `ezurlalias_ml_par_lnk_txt` (`parent`,`text`(32),`link`),
  ADD KEY `ezurlalias_ml_text` (`text`(32),`id`,`link`),
  ADD KEY `ezurlalias_ml_text_lang` (`text`(32),`lang_mask`,`parent`);

--
-- Indizes für die Tabelle `ezurlalias_ml_incr`
--
ALTER TABLE `ezurlalias_ml_incr`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezurlwildcard`
--
ALTER TABLE `ezurlwildcard`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezurl_object_link`
--
ALTER TABLE `ezurl_object_link`
  ADD KEY `ezurl_ol_coa_id` (`contentobject_attribute_id`),
  ADD KEY `ezurl_ol_coa_version` (`contentobject_attribute_version`),
  ADD KEY `ezurl_ol_url_id` (`url_id`);

--
-- Indizes für die Tabelle `ezuser`
--
ALTER TABLE `ezuser`
  ADD PRIMARY KEY (`contentobject_id`),
  ADD KEY `ezuser_login` (`login`);

--
-- Indizes für die Tabelle `ezuservisit`
--
ALTER TABLE `ezuservisit`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `ezuservisit_co_visit_count` (`current_visit_timestamp`,`login_count`);

--
-- Indizes für die Tabelle `ezuser_accountkey`
--
ALTER TABLE `ezuser_accountkey`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hash_key` (`hash_key`);

--
-- Indizes für die Tabelle `ezuser_discountrule`
--
ALTER TABLE `ezuser_discountrule`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezuser_role`
--
ALTER TABLE `ezuser_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezuser_role_contentobject_id` (`contentobject_id`),
  ADD KEY `ezuser_role_role_id` (`role_id`);

--
-- Indizes für die Tabelle `ezuser_setting`
--
ALTER TABLE `ezuser_setting`
  ADD PRIMARY KEY (`user_id`);

--
-- Indizes für die Tabelle `ezvatrule`
--
ALTER TABLE `ezvatrule`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezvatrule_product_category`
--
ALTER TABLE `ezvatrule_product_category`
  ADD PRIMARY KEY (`vatrule_id`,`product_category_id`);

--
-- Indizes für die Tabelle `ezvattype`
--
ALTER TABLE `ezvattype`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezview_counter`
--
ALTER TABLE `ezview_counter`
  ADD PRIMARY KEY (`node_id`);

--
-- Indizes für die Tabelle `ezwaituntildatevalue`
--
ALTER TABLE `ezwaituntildatevalue`
  ADD PRIMARY KEY (`id`,`workflow_event_id`,`workflow_event_version`),
  ADD KEY `ezwaituntildateevalue_wf_ev_id_wf_ver` (`workflow_event_id`,`workflow_event_version`);

--
-- Indizes für die Tabelle `ezwishlist`
--
ALTER TABLE `ezwishlist`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezworkflow`
--
ALTER TABLE `ezworkflow`
  ADD PRIMARY KEY (`id`,`version`);

--
-- Indizes für die Tabelle `ezworkflow_assign`
--
ALTER TABLE `ezworkflow_assign`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezworkflow_event`
--
ALTER TABLE `ezworkflow_event`
  ADD PRIMARY KEY (`id`,`version`),
  ADD KEY `wid_version_placement` (`workflow_id`,`version`,`placement`);

--
-- Indizes für die Tabelle `ezworkflow_group`
--
ALTER TABLE `ezworkflow_group`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ezworkflow_group_link`
--
ALTER TABLE `ezworkflow_group_link`
  ADD PRIMARY KEY (`workflow_id`,`group_id`,`workflow_version`);

--
-- Indizes für die Tabelle `ezworkflow_process`
--
ALTER TABLE `ezworkflow_process`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ezworkflow_process_process_key` (`process_key`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ezapprove_items`
--
ALTER TABLE `ezapprove_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezbasket`
--
ALTER TABLE `ezbasket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezcobj_state`
--
ALTER TABLE `ezcobj_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `ezcobj_state_group`
--
ALTER TABLE `ezcobj_state_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `ezcollab_group`
--
ALTER TABLE `ezcollab_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezcollab_item`
--
ALTER TABLE `ezcollab_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezcollab_item_message_link`
--
ALTER TABLE `ezcollab_item_message_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezcollab_notification_rule`
--
ALTER TABLE `ezcollab_notification_rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezcollab_profile`
--
ALTER TABLE `ezcollab_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezcollab_simple_message`
--
ALTER TABLE `ezcollab_simple_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezcontentbrowsebookmark`
--
ALTER TABLE `ezcontentbrowsebookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezcontentbrowserecent`
--
ALTER TABLE `ezcontentbrowserecent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `ezcontentclass`
--
ALTER TABLE `ezcontentclass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT für Tabelle `ezcontentclassgroup`
--
ALTER TABLE `ezcontentclassgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `ezcontentclass_attribute`
--
ALTER TABLE `ezcontentclass_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=215;
--
-- AUTO_INCREMENT für Tabelle `ezcontentobject`
--
ALTER TABLE `ezcontentobject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT für Tabelle `ezcontentobject_attribute`
--
ALTER TABLE `ezcontentobject_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=296;
--
-- AUTO_INCREMENT für Tabelle `ezcontentobject_link`
--
ALTER TABLE `ezcontentobject_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezcontentobject_tree`
--
ALTER TABLE `ezcontentobject_tree`
  MODIFY `node_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT für Tabelle `ezcontentobject_version`
--
ALTER TABLE `ezcontentobject_version`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=545;
--
-- AUTO_INCREMENT für Tabelle `ezcurrencydata`
--
ALTER TABLE `ezcurrencydata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezdiscountrule`
--
ALTER TABLE `ezdiscountrule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezdiscountsubrule`
--
ALTER TABLE `ezdiscountsubrule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezenumvalue`
--
ALTER TABLE `ezenumvalue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezforgot_password`
--
ALTER TABLE `ezforgot_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezgeneral_digest_user_settings`
--
ALTER TABLE `ezgeneral_digest_user_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezimagefile`
--
ALTER TABLE `ezimagefile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT für Tabelle `ezinfocollection`
--
ALTER TABLE `ezinfocollection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `ezinfocollection_attribute`
--
ALTER TABLE `ezinfocollection_attribute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT für Tabelle `ezisbn_group`
--
ALTER TABLE `ezisbn_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=210;
--
-- AUTO_INCREMENT für Tabelle `ezisbn_group_range`
--
ALTER TABLE `ezisbn_group_range`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT für Tabelle `ezisbn_registrant_range`
--
ALTER TABLE `ezisbn_registrant_range`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=927;
--
-- AUTO_INCREMENT für Tabelle `ezkeyword`
--
ALTER TABLE `ezkeyword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezkeyword_attribute_link`
--
ALTER TABLE `ezkeyword_attribute_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezmessage`
--
ALTER TABLE `ezmessage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezmodule_run`
--
ALTER TABLE `ezmodule_run`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezmultipricedata`
--
ALTER TABLE `ezmultipricedata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `eznode_assignment`
--
ALTER TABLE `eznode_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT für Tabelle `eznotificationcollection`
--
ALTER TABLE `eznotificationcollection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `eznotificationcollection_item`
--
ALTER TABLE `eznotificationcollection_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `eznotificationevent`
--
ALTER TABLE `eznotificationevent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT für Tabelle `ezoperation_memento`
--
ALTER TABLE `ezoperation_memento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezorder`
--
ALTER TABLE `ezorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezorder_item`
--
ALTER TABLE `ezorder_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezorder_nr_incr`
--
ALTER TABLE `ezorder_nr_incr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezorder_status`
--
ALTER TABLE `ezorder_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT für Tabelle `ezorder_status_history`
--
ALTER TABLE `ezorder_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezpackage`
--
ALTER TABLE `ezpackage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `ezpaymentobject`
--
ALTER TABLE `ezpaymentobject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezpdf_export`
--
ALTER TABLE `ezpdf_export`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezpending_actions`
--
ALTER TABLE `ezpending_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezpolicy`
--
ALTER TABLE `ezpolicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=339;
--
-- AUTO_INCREMENT für Tabelle `ezpolicy_limitation`
--
ALTER TABLE `ezpolicy_limitation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=263;
--
-- AUTO_INCREMENT für Tabelle `ezpolicy_limitation_value`
--
ALTER TABLE `ezpolicy_limitation_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=490;
--
-- AUTO_INCREMENT für Tabelle `ezpreferences`
--
ALTER TABLE `ezpreferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT für Tabelle `ezprest_authorized_clients`
--
ALTER TABLE `ezprest_authorized_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezprest_clients`
--
ALTER TABLE `ezprest_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezproductcategory`
--
ALTER TABLE `ezproductcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezproductcollection`
--
ALTER TABLE `ezproductcollection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezproductcollection_item`
--
ALTER TABLE `ezproductcollection_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezproductcollection_item_opt`
--
ALTER TABLE `ezproductcollection_item_opt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezrole`
--
ALTER TABLE `ezrole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `ezrss_export`
--
ALTER TABLE `ezrss_export`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezrss_export_item`
--
ALTER TABLE `ezrss_export_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezrss_import`
--
ALTER TABLE `ezrss_import`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezscheduled_script`
--
ALTER TABLE `ezscheduled_script`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezsearch_object_word_link`
--
ALTER TABLE `ezsearch_object_word_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6345;
--
-- AUTO_INCREMENT für Tabelle `ezsearch_return_count`
--
ALTER TABLE `ezsearch_return_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezsearch_search_phrase`
--
ALTER TABLE `ezsearch_search_phrase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezsearch_word`
--
ALTER TABLE `ezsearch_word`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1267;
--
-- AUTO_INCREMENT für Tabelle `ezsection`
--
ALTER TABLE `ezsection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `ezsubtree_notification_rule`
--
ALTER TABLE `ezsubtree_notification_rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `eztrigger`
--
ALTER TABLE `eztrigger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezurl`
--
ALTER TABLE `ezurl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT für Tabelle `ezurlalias`
--
ALTER TABLE `ezurlalias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT für Tabelle `ezurlalias_ml_incr`
--
ALTER TABLE `ezurlalias_ml_incr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT für Tabelle `ezurlwildcard`
--
ALTER TABLE `ezurlwildcard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezuser_accountkey`
--
ALTER TABLE `ezuser_accountkey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezuser_discountrule`
--
ALTER TABLE `ezuser_discountrule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezuser_role`
--
ALTER TABLE `ezuser_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT für Tabelle `ezvatrule`
--
ALTER TABLE `ezvatrule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezvattype`
--
ALTER TABLE `ezvattype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `ezwaituntildatevalue`
--
ALTER TABLE `ezwaituntildatevalue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezwishlist`
--
ALTER TABLE `ezwishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezworkflow`
--
ALTER TABLE `ezworkflow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezworkflow_assign`
--
ALTER TABLE `ezworkflow_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezworkflow_event`
--
ALTER TABLE `ezworkflow_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `ezworkflow_group`
--
ALTER TABLE `ezworkflow_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `ezworkflow_process`
--
ALTER TABLE `ezworkflow_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

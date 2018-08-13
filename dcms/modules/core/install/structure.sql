--
DROP TABLE IF EXISTS #PX#_core_settings_types;
--
CREATE TABLE #PX#_core_settings_types (
setting_id VARCHAR(50) NOT NULL DEFAULT '' COMMENT "Setting ID, may include english letters,digits, dot and -",
lng  VARCHAR(50) NOT NULL DEFAULT '' COMMENT "Language message code for setting",
visibility ENUM('global','object') NOT NULL DEFAULT 'global' COMMENT "Setting visibility, global - only one setting of this type, object - for specific objects",
type VARCHAR(10) NOT NULL DEFAULT '' COMMENT "Setting type, for example int,string, bool and so",
validator TEXT COMMENT "Setting validator rules",
PRIMARY KEY(setting_id)
) ENGINE='INNODB';
--                
DROP TABLE IF EXISTS #PX#_core_settings_values;
--
CREATE TABLE #PX#_core_settings_values ( 
setting_id VARCHAR(50) NOT NULL DEFAULT '', /* идентификатор типа настройки */
object_id VARCHAR(90) NOT NULL DEFAULT '', /* идентификатор объекта к которому относится данная настройка */
value TEXT, /* значение переменной */
PRIMARY KEY (setting_id,object_id)
) ENGINE='INNODB' COMMENT="Existed site settings";
-- 
DROP TABLE IF EXISTS #PX#_core_messages;
-- 
CREATE TABLE #PX#_core_messages ( 
msg_code varchar(90) NOT NULL DEFAULT '' COMMENT "Message code, only capital english letters, _ and digits",
lang VARCHAR(2) NOT NULL DEFAULT 0 COMMENT "Language code, for example ru or en",
module VARCHAR(9) NOT NULL DEFAULT '' COMMENT "Module, which imports this message",
msg_text TEXT COMMENT "Message text",
upd_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Message last update time",
html BOOL NOT NULL DEFAULT FALSE,
javascript BOOL NOT NULL DEFAULT FALSE,
PRIMARY KEY (msg_code,lang)
) ENGINE='INNODB' COMMENT="Site language messages";

DROP TABLE IF EXISTS xn_core_i18n_project;
CREATE TABLE xn_core_i18n_project (pid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Project uniq ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Project add time",
code VARCHAR(100) NOT NULL DEFAULT 'NO_CODE' COMMENT "Original message code",
price DOUBLE(10,2) NOT NULL DEFAULT 0.0 COMMENT "Order price",
lang_from CHAR(3) NOT NULL DEFAULT '' COMMENT "Source text language",
lang_to   CHAR(3) NOT NULL DEFAULT '' COMMENT "Target language",
source TEXT COMMENT "Source text value",
result TEXT COMMENT "Result text",
export CHAR(32) NOT NULL DEFAULT 'NO_CODE') COMMENT="Localization projects";


CREATE TABLE IF NOT EXISTS `#PX#_core_iblocks` (
  `block_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sid` smallint(5) NOT NULL DEFAULT '0',
  `module_name` varchar(200) NOT NULL,
  `class_name` varchar(200) NOT NULL,
  `descr` varchar(500) NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`block_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Categories List' AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `#PX#_core_iblocks_properties` (
  `prop_id` int(11) NOT NULL AUTO_INCREMENT,
  `block_id` int(11) NOT NULL,
  `prop_code` varchar(50) NOT NULL,
  `prop_name` varchar(50) NOT NULL DEFAULT '',
  `prop_type` int(10) NOT NULL DEFAULT '0',
  `prop_length` int(11) NOT NULL DEFAULT '0',
  `prop_unit` varchar(50) NOT NULL,
  `default` varchar(100) NOT NULL,
  `descr` date NOT NULL,
  `priority` int(2) NOT NULL,
  `prop_key` tinyint(1) NOT NULL DEFAULT '0',
  `increment` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`prop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Prod_properties' AUTO_INCREMENT=22 ;

CREATE TABLE IF NOT EXISTS `#PX#_core_sections` (
  `sid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `section_name` varchar(200) NOT NULL DEFAULT '',
  `section_key` varchar(200) NOT NULL,
  `module_name` varchar(200) NOT NULL,
  `image` varchar(50) NOT NULL,
  `descr` text NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `priority` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Categories List' AUTO_INCREMENT=5 ;
--
DROP TABLE IF EXISTS #PX#_core_triggers;
--
CREATE TABLE #PX#_core_triggers ( namehash CHAR(32) NOT NULL DEFAULT '' COMMENT "Uniq name hash",
marker CHAR(6) NOT NULL DEFAULT 'aaaaaa' COMMENT "Uniq marker",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "When this trigger was added",
exp_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Average expire time",
INDEX(namehash),
PRIMARY KEY (namehash, marker)) ENGINE='INNODB' COMMENT 'Site triggers for any long stuff';
--
DROP TABLE IF EXISTS #PX#_core_ipc_messages;
--
CREATE TABLE #PX#_core_ipc_messages (msgid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT  COMMENT "Uniq message ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Message add text",
msg VARCHAR(16984) COMMENT "Message content",
stream CHAR(32) NOT NULL DEFAULT '') ENGINE='MEMORY' COMMENT "IPC messages";
--
DROP TABLE IF EXISTS #PX#_core_ipc_big_messages;
--
DROP TABLE IF EXISTS #PX#_core_events;
--
CREATE TABLE #PX#_core_events (
eid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Uniq log ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Log add time",
object_hash CHAR(32) NOT NULL DEFAULT '',
msg VARCHAR(250) NOT NULL DEFAULT '' COMMENT "Message content") ENGINE='INNODB' COMMENT='Objects Logs';
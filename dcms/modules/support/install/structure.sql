--
DROP TABLE IF EXISTS #PX#_support_topics;
--
CREATE TABLE #PX#_support_topics (tid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Ticket ID",
subject TEXT COMMENT "Ticket subject",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Ticket add time",
upd_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Ticket upd time",
dept SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Department ID",
active BOOL NOT NULL DEFAULT 0,
author VARCHAR(255) NOT NULL DEFAULT '',
account VARCHAR(40) NOT NULL DEFAULT '',
code CHAR(10) NOT NULL DEFAULT '' COMMENT "Uniq code to identifiy this topic",
msg TEXT COMMENT "Raw e-mail message"
) ENGINE='INNODB' COMMENT='Support tickets';
--
DROP TABLE IF EXISTS #PX#_support_messages;
--
CREATE TABLE #PX#_support_messages (msgid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Uniq message ID",
msg_raw TEXT COMMENT "Raw E-Mail message",
msg TEXT COMMENT "Parsed E-Mail message",
add_time INT UNSIGNED NOT NULL DEFAULT 0,
subject TEXT COMMENT "Message subject",
tid BIGINT UNSIGNED NOT NULL DEFAULT 0,
mtype CHAR(2) NOT NULL DEFAULT ''
) ENGINE='INNODB' COMMENT='Ticket messages';
--
DROP TABLE IF EXISTS #PX#_support_ignores;
--
CREATE TABLE xn_support_ignores (fid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Filter ID",
account VARCHAR(40) NOT NULL DEFAULT '' COMMENT "Support account",
field VARCHAR(40) NOT NULL DEFAULT '' COMMENT "Field name",
rule VARCHAR(130) NOT NULL DEFAULT '' COMMENT "Rule content") ENGINE='INNODB';
 
--
DROP TABLE IF EXISTS #PX#_support_chatmsg;
--
CREATE TABLE #PX#_support_chatmsg (msgid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Uniq message ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0,
upd_time INT UNSIGNED NOT NULL DEFAULT 0,
client VARCHAR(100) NOT NULL DEFAULT '' COMMENT "Client address",
stream VARCHAR(10) NOT NULL DEFAULT '' COMMENT "Stream name",
operator VARCHAR(100) NOT NULL DEFAULT 'none@link.com' COMMENT "Operator name",
type CHAR(3) NOT NULL DEFAULT 'in',
ip CHAR(128) NOT NULL DEFAULT '0.0.0.0' COMMENT "Client IP address",
msg TEXT) COMMENT='Support chat messages';

--
DROP TABLE IF EXISTS #PX#_support_chat_logs;
--
CREATE TABLE #PX#_support_chat_logs (msgid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Message add time",
client VARCHAR(100) NOT NULL DEFAULT '' COMMENT "Client username",
stream VARCHAR(10) NOT NULL DEFAULT 'web' COMMENT "Stream",
type CHAR(3) NOT NULL DEFAULT 'in',
msg TEXT COMMENT "Message content") ENGINE='INNODB';
--
DROP TABLE IF EXISTS #PX#_support_chat_status;
--
CREATE TABLE #PX#_support_chat_status (operator VARCHAR(100) NOT NULL DEFAULT '' PRIMARY KEY,
status TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Operator status",
upd_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Last state update") ENGINE='INNODB' COMMENT='Operators statuses';
--
DROP TABLE IF EXISTS #PX#_support_chat_session;
--
CREATE TABLE #PX#_support_chat_session (client CHAR(100) NOT NULL DEFAULT '' PRIMARY KEY,
operator VARCHAR(100) NOT NULL DEFAULT 'none@link.com' COMMENT "Operator",
upd_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Last update time") ENGINE='INNODB' COMMENT='Chat sessions';
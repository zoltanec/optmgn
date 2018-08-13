--
DROP TABLE IF EXISTS #PX#_notify_delivery;
--
CREATE TABLE #PX#_notify_delivery (did INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Delivery uniq ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0,
name CHAR(50) NOT NULL DEFAULT '' COMMENT "Delivery name",
mode CHAR(10) NOT NULL DEFAULT '' COMMENT "Delivery mode, like sms, email, icq or other",
lid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Users list",
msg TEXT COMMENT "Delivery text");
--
DROP TABLE IF EXISTS #PX#_notify_delivery_messages;
--
CREATE TABLE #PX#_notify_delivery_messages (msgid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Message ID",
address CHAR(50) NOT NULL DEFAULT '' COMMENT "Client address",
did INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Delivery ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0,
status BOOL NOT NULL DEFAULT 0 COMMENT "Is this message sended",
mode CHAR(10) NOT NULL DEFAULT "" COMMENT "message send mode",
id TEXT COMMENT "ID from send system if exists",
lid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Users list",
msg TEXT COMMENT "Message text") COMMENT='Messages to send';
--
DROP TABLE IF EXISTS #PX#_notify_delivery_lists;
--
CREATE TABLE #PX#_notify_delivery_lists ( lid SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "List ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "List add time",
upd_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Last upd time",
name VARCHAR(100) NOT NULL DEFAULT '') ENGINE='INNODB' COMMENT='Lists of addresses';
--
DROP TABLE IF EXISTS #PX#_notify_delivery_listitems;
--
CREATE TABLE #PX#_notify_delivery_listitems (address VARCHAR(200) NOT NULL DEFAULT 0 COMMENT "Client address",
lid SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "List ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0,
PRIMARY KEY (address, lid)) ENGINE='INNODB' COMMENT "Items from this list";
DROP TABLE IF EXISTS #PX#_comments_all;
--
CREATE TABLE #PX#_comments_all (
comid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Comment id",
object_hash CHAR(32) NOT NULL DEFAULT '' COMMENT "Object hash to which this comment belongs",
uid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Sender UID",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Comment add time, unixtime",
upd_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Last comment update time", 
title VARCHAR(400) NOT NULL DEFAULT '' COMMENT "Comment title",
content TEXT COMMENT "Comment content",
plus SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Comment positive rates", 
minus SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Comment negative rates",
moderator_note TEXT COMMENT "Moderator additional text", 
ip INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Comment sender IP",
approved BOOL NOT NULL DEFAULT TRUE COMMENT "Is this comment approved by moderator or not",
INDEX(object_hash),
INDEX(add_time))
ENGINE='INNODB' COMMENT="All comments on site";
--
DROP TABLE IF EXISTS #PX#_comments_abuses;
--
CREATE TABLE #PX#_comments_abuses (
comid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Bad comment id", 
uid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Abuse sender UID",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Abuse add time",
reason VARCHAR(250) NOT NULL DEFAULT '' COMMENT "Abuse message reason",
PRIMARY KEY (comid, uid))
ENGINE='INNODB' COMMENT='Comments abuses from users.';
--
DROP TABLE IF EXISTS #PX#_comments_meta;
-- 
CREATE TABLE #PX#_comments_meta ( 
object_hash CHAR(32) NOT NULL DEFAULT '' COMMENT "Comment object hash",
object_id   CHAR(80) NOT NULL DEFAULT '' COMMENT "Object full path",
first INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "First commend id",
last TIMESTAMP COMMENT "Last comment add time",
lastcomid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Last comment ID",
count INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Total messages for this object",
template VARCHAR(50) NOT NULL DEFAULT '' COMMENT "Custom comments template for this object",
premoderate BOOL NOT NULL DEFAULT FALSE COMMENT "Premoderate mode for object",
PRIMARY KEY (object_hash))
ENGINE='INNODB' COMMENT="All comments objects meta information";
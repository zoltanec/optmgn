--
DROP TABLE IF EXISTS #PX#_news;
--
CREATE TABLE #PX#_news (
nid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, COMMENT "идентификатор новости"
sid SMALLINT UNSIGNED NOT NULL DEFAULT 0, COMMENT "идентификатор раздла новости"
uid INT UNSIGNED NOT NULL DEFAULT 0, COMMENT "идентификатор пользователя оставившего запись"
icon VARCHAR(45) NOT NULL DEFAULT '', COMMENT "иконка новости"
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "News add time, unix seconds",
upd_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Last news update time, unix seconds", 
pub_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Time when we need to publish this news, unix seconds", 
title VARCHAR(255) NOT NULL DEFAULT '', COMMENT "заголовок новости"
author VARCHAR(100) NOT NULL DEFAULT '', COMMENT "автор новости"
source VARCHAR(100) NOT NULL DEFAULT '', COMMENT "источник новости, например ЗАО рога и копыта"
tags VARCHAR(400) NOT NULL DEFAULT '', COMMENT "теги к данной новости"
mode VARCHAR(6) NOT NULL DEFAULT 'html', COMMENT "идентификатор режима"
image VARCHAR(50) NOT NULL DEFAULT '', COMMENT "картинка новости"
active BOOL NOT NULL DEFAULT TRUE, COMMENT "флаг активности новости, 1 значит новость размещена и доступна всем"
ontop BOOL NOT NULL DEFAULT FALSE, COMMENT "поддерживать новость в выводе поверх других"
comments_status BOOL NOT NULL DEFAULT 1, COMMENT "включены ли комментарии, 1 включены, 0 отключены"
content_preview VARCHAR(300) NOT NULL DEFAULT '', COMMENT "содержимое новости"
priority TINYINT UNSIGNED NOT NULL DEFAULT 0, COMMENT "приоритет новости"
publish_delay BOOL NOT NULL DEFAULT FALSE COMMENT "задержать новость от публикации"
) ENGINE='INNODB' COMMENT="Site news";
--
DROP TABLE IF EXISTS #PX#_news_sections;
--
CREATE TABLE #PX#_news_sections ( 
sid SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "News section identification ID",
section_name VARCHAR(90) NOT NULL DEFAULT ''     COMMENT "Current section name, may include any characters",
section_key VARCHAR(90) NOT NULL DEFAULT ''      COMMENT "Unique key, may include only english letters and digits, for HRU",
descr TEXT COMMENT "Section description",
public BOOL NOT NULL DEFAULT TRUE COMMENT "Is this section visible for all site users or not",
active BOOL NOT NULL DEFAULT FALSE COMMENT "Is this section active and visible",
priority SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Sort priority for section, from min to max"
) ENGINE=INNODB;
-- 
DROP TABLE IF EXISTS #PX#_news_stat;
-- 
CREATE TABLE #PX#_news_stat (
nid INT UNSIGNED PRIMARY KEY COMMENT "News ID",
readed INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "How many times this news was readed",
comments INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "News comments count"
) ENGINE="INNODB";
--
DROP TABLE IF EXISTS #PX#_news_tags;
--
CREATE TABLE #PX#_news_tags (
tag CHAR(90) NOT NULL DEFAULT '' COMMENT "Tag value",
nid INT UnSIGNED NOT NULL DEFAULT 0 COMMENT "News ID which have this tag",
PRIMARY KEY (tag,nid)
) ENGINE='INNODB' COMMENT="List of all tags in news ";
--
DROP TABLE IF EXISTS #PX#_news_recomendations;
--
CREATE TABLE #PX#_news_recomendations (
nid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "News ID",
good_news INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Other news ID which is recommended for nid news"
) ENGINE='INNODB' COMMENT="News recomendations";
--
DROP TABLE IF EXISTS #PX#_news_content;
--
CREATE TABLE #PX#_news_content (
nid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "News ID",
content TEXT COMMENT "news content body",
PRIMARY KEY (nid)) ENGINE='INNODB' COMMENT='Stores news content to prevent';
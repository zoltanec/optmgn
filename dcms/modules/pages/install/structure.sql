--
DROP TABLE IF EXISTS #PX#_static_pages;
--
CREATE TABLE #PX#_static_pages ( content_id SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "идентификатор контента",
content_name VARCHAR(50) NOT NULL DEFAULT '' COMMENT "уникальное имя документа",
content_type VARCHAR(30) NOT NULL DEFAULT 'text/html' COMMENT "тип контента",
lang VARCHAR(2) NOT NULL DEFAULT '' COMMENT "язык документа",
furl VARCHAR(30) NOT NULL DEFAULT '' ,
title VARCHAR(255) NOT NULL DEFAULT '' COMMENT "заголовок окна страницы",
description VARCHAR(655) NOT NULL DEFAULT '' COMMENT "описание страницы",
content TEXT NOT NULL DEFAULT '' COMMENT "содержимое страницы",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "время добавления страницы",
upd_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "время обновления",
uid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "идентификатор пользователя добавившего страницу",
keywords VARCHAR(100) NOT NULL DEFAULT '' COMMENT "ключевые слова",
metatags VARCHAR(100) NOT NULL DEFAULT '' COMMENT "мета теги",
active BOOL NOT NULL DEFAULT FALSE COMMENT "активна ли страница",
comments BOOL NOT NULL DEFAULT FALSE COMMENT "используются ли комментарии к странице",
stat_mode TINYINT UNSIGNED NOT NULL DEFAULT 1 COMMENT "режим статистики",
INDEX(content_name)) ENGINE=INNODB COMMENT='Static pages';
--
DROP TABLE IF EXISTS #PX#_static_pages_reads;
--
CREATE TABLE #PX#_static_pages_reads ( content_id SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "идентификатор контента",
last_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "время последнего доступа",
readed INT UNSIGNED NOT NULL DEFAULT 1 COMMENT "количество прочтений",
PRIMARY KEY (content_id)) ENGINE='INNODB' COMMENT='Static content agregated stat';
--
DROP TABLE IF EXISTS #PX#_static_pages_reads_detailed;
--
CREATE TABLE #PX#_static_pages_reads_detailed (ip INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "IP пользователя",
content_id SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "идентификатор контента",
read_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "время прочтения") ENGINE='INNODB' COMMENT='Static content reads details';
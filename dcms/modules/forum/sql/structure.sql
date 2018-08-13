/*Список разделов форума*/
DROP TABLE IF EXISTS vpn_forum_sections;
CREATE TABLE vpn_forum_sections ( sid TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,/*идентификатор раздела*/
                                  name CHAR(70) NOT NULL, /*название раздела*/ 
                                  code VARCHAR(25) NOT NULL DEFAULT '',/* код раздела для указания в URL*/
                                  parent TINYINT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор родительского раздела*/
                                  descr CHAR(255) NOT NULL DEFAULT '',/*описание раздела*/
                                  cid TINYINT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор категории*/
                                  readonly BOOL NOT NULL DEFAULT FALSE,/*можно ли в разделе создавать новые топики*/
                                  active BOOL NOT NULL DEFAULT TRUE,/*активен ли раздел и отображается ли в списке разделов*/
                                  sort TINYINT UNSIGNED NOT NULL DEFAULT 0,/*порядок сортировки элементов*/
                                  PRIMARY KEY (sid)) ENGINE=INNODB COMMENT='All forum sections.';

/*последние сообщения в разделах*/
DROP TABLE IF EXISTS vpn_forum_sections_stat;
CREATE TABLE vpn_forum_sections_stat ( sid TINYINT UNSIGNED NOT NULL, /*идентификатор раздела*/
                              topics SMALLINT UNSIGNED NOT NULL DEFAULT 0,/*количество тем в разделе*/
                              messages MEDIUMINT UNSIGNED NOT NULL DEFAULT 0,/*количество сообщений в разделе*/
                              lastuid int unsigned NOT NULL,/*идентификатор пользователя оставившего сообщение*/
                              lastusername char(40) NOT NULL,/*имя пользователя оставившего сообщение*/
                              lastupdate int UNSIGNED NOT NULL,/*время размещения сообщения*/
                              lasttitle CHAR(60) NOT NULL DEFAULT '',/*заголовок последнего топика*/
                              lasttid MEDIUMINT UNSIGNED  NOT NULL, /*идентификатор топика*/
                              lastcomid INT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор последнего комментария*/
                              PRIMARY KEY (sid)) ENGINE=INNODB COMMENT='Sections stat. Last/total messages';

/*модераторы разделов*/
DROP TABLE IF EXISTS vpn_forum_sections_moderators;
CREATE TABLE vpn_forum_sections_moderators (sid TINYINT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор раздела*/
                                            uid INT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор пользователя*/
                                            PRIMARY KEY (sid,uid)) ENGINE=INNODB COMMENT='Forum moderators';
                              
/*топики в разделе*/
DROP TABLE IF EXISTS vpn_forum_topics;
CREATE TABLE vpn_forum_topics ( tid MEDIUMINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /*идентификатор топика*/
                                sid TINYINT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор раздела в котором находится тема*/
                                add_time INT UNSIGNED NOT NULL DEFAULT 0,/*время создания темы*/
                                upd_time INT UNSIGNED NOT NULL DEFAULT 0,/*время последнего изменения*/
                                title CHAR(200) NOT NULL DEFAULT '',/*заголовок темы*/
                                descr CHAR(140) NOT NULL DEFAULT '',/*небольшое текстовое описание темы, будет выведено как подсказка*/
                                short char(200) NOT NULL DEFAULT '',/*короткое описание темы*/
                                date TIMESTAMP,/*время последнего изменения в теме*/
                                uid INT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор пользователя*/
                                username CHAR(40) NOT NULL DEFAULT '',/*имя пользователя разместившего топик*/
                                icon CHAR(32) NOT NULL DEFAULT '',/*иконка топика*/
                                readonly BOOL NOT NULL DEFAULT FALSE,/*топик доступен только для чтения*/
                                sticked BOOL NOT NULL DEFAULT FALSE,/*является ли топик прикрепленным, он будет отображатся поверх всех*/
                                INDEX (sid)) ENGINE=INNODB COMMENT='All forum topics. Meta information.';
              
/*статистика прочтения топиков и их комментирования*/
DROP TABLE IF EXISTS vpn_forum_topics_stat;
CREATE TABLE vpn_forum_topics_stat (tid MEDIUMINT UNSIGNED PRIMARY KEY NOT NULL DEFAULT 0, /*идентификатор топика*/
                                    readed MEDIUMINT UNSIGNED NOT NULL DEFAULT 0, /*количество прочтений*/
                                    messages MEDIUMINT UNSIGNED NOT NULL DEFAULT 0,/*количество сообщений в топике*/
                                    lastupdate INT UNSIGNED NOT NULL DEFAULT 0, /*время последнего обновления*/
                                    lastuid MEDIUMINT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор пользователя обновившего топик*/
                                    lastusername CHAR(50) NOT NULL DEFAULT '',/*имя пользователя который последний раз оставлял сообщение*/
                                    lastcomid INT UNSIGNED NOT NULL DEFAULT 0 /* идентификатор последнего каммента*/)
                                    ENGINE=INNODB COMMENT='Forum topics statistic.';
/*содержимое топиков*/
DROP TABLE IF EXISTS vpn_forum_topics_content;
CREATE TABLE vpn_forum_topics_content ( tid MEDIUMINT UNSIGNED PRIMARY KEY NOT NULL DEFAULT 0,/*идентификатор топика*/
                                        content text/*содержимое темы*/) ENGINE=INNODB COMMENT='Topics content.';
									
/*деление разделов на категории*/
DROP TABLE IF EXISTS vpn_forum_categories;
CREATE TABLE vpn_forum_categories ( cid TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,/*идентификатор категории*/
                                    sid TINYINT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор родительского раздела, в котором расположены эти категории*/   
                                    name CHAR(40) NOT NULL DEFAULT ''/*название раздела*/) ENGINE=INNODB COMMENT='Forums sections categories.';
                                    
INSERT INTO mmg_forum_categories (sid,name) VALUES (1,'Сайт Металлург.ру'), (1,'Новости'), (1, 'Голосование за лучшего игрока'), (1, 'Хоккей');   
UPDATE mmg_forum_sections SET cid = 3 WHERE name LIKE 'Лучший игрок%' or sid in (21,29);
UPDATE mmg_forum_sections SET cid = 1 WHERE sid IN (3,4,6,19,30);
UPDATE mmg_forum_sections SET active = 0 WHERE sid = 7;
UPDATE mmg_forum_sections SET active = 0 WHERE sid IN (22,23,24,25);
/*а тут у нас всякий стаф для переноса данных из старого форума в новый*/
TRUNCATE mmg_forum_sections;
INSERT INTO mmg_forum_sections (sid,parent,name) VALUES (1,0,'Корневой раздел');
INSERT INTO mmg_forum_sections (sid,parent,name,descr) SELECT forum_id +1 , parent_id +1, forum_name,  forum_desc FROM phpbb4.phpbb_forums;

TRUNCATE mmg_forum_topics;
INSERT INTO mmg_forum_topics (tid,sid,title,date,uid) SELECT topic_id, forum_id + 1, topic_title, FROM_UNIXTIME(topic_time), topic_poster FROM phpbb4.phpbb_topics;
INSERT INTO mmg_forum_topics_content (tid,content) SELECT a.topic_id, replace(post_text,concat(':',bbcode_uid,']'),']') FROM phpbb4.phpbb_topics a LEFT OUTER JOIN phpbb4.phpbb_posts b ON (a.topic_first_post_id = b.post_id);
TRUNCATE mmg_forum_topics_stat;
INSERT INTO mmg_forum_topics_stat (tid) SELECT tid FROM mmg_forum_topics;
UPDATE mmg_forum_topics_stat a SET a.readed = ( SELECT b.topic_views FROM phpbb4.phpbb_topics b WHERE b.topic_id = a.tid );
UPDATE mmg_forum_topics_stat a SET a.messages = ( SELECT COUNT(1) FROM phpbb4.phpbb_posts b WHERE b.topic_id = a.tid);
UPDATE mmg_forum_topics_stat a SET a.lastupdate = (SELECT MAX(b.addtime) FROM mmg_comments b WHERE b.object_id = md5(CONCAT('forum-forumtopic-',a.tid)));
UPDATE mmg_forum_topics_stat a SET a.lastuid = (SELECT b.uid FROM mmg_comments b WHERE b.object_id = md5(CONCAT('forum-forumtopic-',a.tid)) ORDER BY b.addtime DESC LIMIT 1);
UPDATE mmg_forum_topics_stat a SET a.lastusername = (SELECT b.username FROM mmg_users b WHERE b.uid = a.lastuid );

DELETE FROM mmg_comments WHERE comid > 874948;
INSERT INTO mmg_comments (object_id,uid,addtime,content) 
SELECT MD5(CONCAT('forum-forumtopic-',topic_id)), poster_id, post_time, replace(post_text,concat(':',bbcode_uid,']'),']') 
FROM phpbb4.phpbb_posts WHERE post_approved = 1;

INSERT INTO mmg_comments_all (object_hash, object_id) SELECT MD5(CONCAT('forum-forumtopic-',tid)),CONCAT('forum-forumtopic-',tid) FROM mmg_forum_topics;
UPDATE mmg_comments_all a SET a.count = (SELECT COUNT(1) FROM mmg_comments b WHERE b.object_id = a.object_hash ), 
                              a.first = (SELECT MIN(c.addtime) FROM mmg_comments c WHERE c.object_id = a.object_hash),
                              a.last = FROM_UNIXTIME((SELECT MAX(d.addtime) FROM mmg_comments d WHERE d.object_id = a.object_hash));
                              
        
UPDATE mmg_forum_topics a SET a.username = (SELECT b.username FROM mmg_users b WHERE b.uid = a.uid);

INSERT INTO mmg_forum_sections_stat (sid) SELECT sid FROM mmg_forum_sections;
UPDATE mmg_forum_sections_stat a SET a.topics = (SELECT COUNT(1) FROM mmg_forum_topics b WHERE b.sid = a.sid);
UPDATE mmg_forum_sections_stat a SET a.messages = (SELECT SUM(b.messages) FROM mmg_forum_topics c  LEFT OUTER JOIN mmg_forum_topics_stat b USING (tid) WHERE c.sid = a.sid);


-- удаляем первый комментарий
DELETE FROM mmg_comments WHERE comid IN (
INSERT INTO tmp_mmg 
       SELECT MIN(b.comid) FROM mmg_comments_all c 
       LEFT OUTER JOIN mmg_comments b ON (c.object_hash = b.object_id ) 
       WHERE c.object_id LIKE 'forum-%' GROUP BY b.object_id ;
































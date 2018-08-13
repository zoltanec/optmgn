DROP TABLE IF EXISTS vpn_comments;
CREATE TABLE vpn_comments (
    comid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,/*идентификатор комментария*/
    object_id CHAR(32) NOT NULL DEFAULT '',/*идентификатор контента к которому привязан данный комментарий*/
    uid INT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор пользователя разместившего комментарий*/
    addtime INT UNSIGNED NOT NULL DEFAULT 0,/*время добавления комментария*/
    updtime INT UNSIGNED NOT NULL DEFAULT 0,/*время последнего обновления комментария*/
    title VARCHAR(400) NOT NULL DEFAULT '',/*заголовок комментария*/
    content TEXT, /*сам комментарий*/
    
    plus SMALLINT UNSIGNED NOT NULL DEFAULT 0,/*количество плюсов в карму*/
    minus SMALLINT UNSIGNED NOT NULL DEFAULT 0,/*количество минусов посту*/
    
    moderator_note TEXT, /* примечание модератора пользователю*/
    
    ip INT UNSIGNED NOT NULL DEFAULT 0,/*ип с которого юзер отправил сообщение*/
    
    INDEX(object_id),
    INDEX(addtime)) ENGINE=INNODB COMMENT='All comments on site';

DROP TABLE vpn_comments_abuses;
CREATE TABLE vpn_comments_abuses (comid INT UNSIGNED NOT NULL DEFAULT 0, /*идентификатор комментария*/
                                  uid INT UNSIGNED NOT NULL DEFAULT 0,/* идентификатор пользователя*/
                                  add_time INT UNSIGNED NOT NULL DEFAULT 0, /*время добавления абузы*/
                                  reason VARCHAR(250) NOT NULL DEFAULT '', /*причина жалобы*/
                                  PRIMARY KEY (comid, uid)) ENGINE=INNODB COMMENT='Comments abuses from users.';
                                  

DROP TABLE IF EXISTS vpn_comments_all;
CREATE TABLE vpn_comments_all ( object_hash CHAR(32) NOT NULL DEFAULT '',/*идентификатор*/
                                object_id CHAR(60) NOT NULL DEFAULT '',/*путь к объекту*/
                                first INT UNSIGNED NOT NULL DEFAULT 0,/*первый комментарий*/
                                last TIMESTAMP,/*время добавления последнего комментария*/
                                lastcomid INT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор последнего комментария*/ 
                                count INT UNSIGNED NOT NULL DEFAULT 0,/*количество сообщений в базе данных*/
                                template VARCHAR(50) NOT NULL DEFAULT '', /*имя шаблона используемого для рендеринга*/
                                PRIMARY KEY (object_hash));
                                
ALTER TABLE mmg_comments_all add column  template VARCHAR(50) NOT NULL DEFAULT '';
DESC mmg_comments_all;
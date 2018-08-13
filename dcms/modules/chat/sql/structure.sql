DROP TABLE IF EXISTS mmg_chat_users;
CREATE TABLE mmg_chat_users ( add_time INT UNSIGNED NOT NULL DEFAULT 0,/*время добавления пользователя в чат*/
uid INT UNSIGNED NOT NULL DEFAULT 0, /*идентификатор пользователя*/
rim SMALLINT UNSIGNED NOT NULL DEFAULT 0, /* идентификатор комнаты */
visible_name VARCHAR(40) NOT NULL DEFAULT '', /*видимое имя пользователя*/
avatar VARCHAR(40) NOT NULL DEFAULT '',/*аватарка пользователя*/
user_status VARCHAR(90) NOT NULL DEFAULT '', /*текстовый статус пользователя*/
user_status_type TINYINT NOT NULL DEFAULT 0,/*тип статуса пользователя */
color INT UNSIGNED NOT NULL DEFAULT 0, /* цвет пользователя*/
upd_time INT UNSIGNED NOT NULL DEFAULT 0, /* время когда пользователь последний раз замечен*/
PRIMARY KEY (uid,rim)) ENGINE=MEMORY COMMENT='Chat online users';

DROP TABLE IF EXISTS mmg_chat_messages;
CREATE TABLE mmg_chat_messages ( msgid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор последнего сообщения*/
rim SMALLINT UNSIGNED NOT NULL DEFAULT 0,/* идентификатор чат комнаты */
add_time INT UNSIGNED NOT NULL DEFAULT 0,
uid INT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор пользователя*/
uid_to INT UNSIGNED NOT NULL DEFAULT 0, /* идентификатор пользователя которому предназначено личное сообщение*/
type TINYINT UNSIGNED NOT NULL DEFAULT 0,/* тип сообщения чата*/
message VARCHAR(500) NOT NULL DEFAULT ''/*сообщение пользователя*/
) ENGINE=MEMORY COMMENT='Users messages';

DELIMITER //
DROP TRIGGER IF EXISTS chat_delete_inactive;
CREATE TRIGGER chat_delete_inactive AFTER DELETE ON mmg_chat_users
FOR EACH ROW begin
	INSERT INTO mmg_chat_messages (uid,rim,add_time,type) VALUES (OLD.uid, OLD.rim, UNIX_TIMESTAMP(),4);
end 

DROP TABLE IF EXISTS mmg_chat_rooms;
CREATE TABLE mmg_chat_rooms (rid SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор комнаты */
                             name VARCHAR(100) NOT NULL DEFAULT '',/* название комнаты */
                             topic VARCHAR(150) NOT NULL DEFAULT '', /* тема комнаты */
                             descr VARCHAR(200) NOT NULL DEFAULT '' /* описание чат комнаты */) ENGINE='INNODB';
								 
Типы сообщений:
1 - это новое сообщение пользователя
2 - пользователь сменил статус, новый статус пользователя в сообщений
3 - пользователь зашел в чат
4 - пользователь вышел из чата, последнее сообщение пользователя указано в сообщении
5 - пользователь сменил цвет своих сообщений
6 - удалено сообщение пользователя

Типы статусов пользователей:
1 - в сети
2 - недоступен
3 - занят 

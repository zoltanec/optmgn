--
DROP TABLE IF EXISTS #PX#_users;
-- 
CREATE TABLE #PX#_users (
uid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Site user ID",
gid SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "User main group ID", 
reg_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "User registration time",
username VARCHAR(60) NOT NULL DEFAULT '' COMMENT "Username",
password VARCHAR(32) NOT NULL DEFAULT '' COMMENT "Password hash",
avatar VARCHAR(30) NOT NULL DEFAULT '' COMMENT "User avatar",
confirm_code VARCHAR(6) NOT NULL DEFAULT 'ABCDEF' COMMENT "Registration confirm code", 
active tinyint(1) NOT NULL DEFAULT '1' COMMENT "User activity flag",
active_from INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "User active from time",
user_from VARCHAR(25) NOT NULL DEFAULT '' COMMENT "Where are this user from",
interests VARCHAR(50) NOT NULL DEFAULT '' COMMENT "User interests", 
messages INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Messages on site",
karma SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "User karma",
karma_update INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Last karma update time",
sex CHAR(1) NOT NULL DEFAULT 'M' COMMENT "User sex",
birth DATE NOT NULL DEFAULT '0000-00-00' COMMENT "Birth date",
birth_visibility BOOL NOT NULL DEFAULT true COMMENT "Show user birth date or not",
about VARCHAR(400) NOT NULL DEFAULT '' COMMENT "Short info about user",
sign VARCHAR(200) NOT NULL DEFAULT '' COMMENT "User messages sign"
) ENGINE=INNODB COMMENT="CMS Users List";
--
DROP TABLE IF EXISTS #PX#_users_sessions;
--
CREATE TABLE #PX#_users_sessions ( 
session_id CHAR(32) NOT NULL DEFAULT '',/*идентификатор пользовательской сессии*/
first INT UNSIGNED NOT NULL DEFAULT 0,/*начало сессии*/
last TIMESTAMP,/*время последней активности*/
uid INT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор пользователя если пользователь выполнил авторизацию*/
name CHAR(25) NOT NULL DEFAULT 0,/*имя пользователя, отображаемое*/
ip INT UNSIGNED NOT NULL DEFAULT 0,/*IP пользователя*/
module CHAR(20) NOT NULL DEFAULT 'index',/*текущий модуль в котором находится пользователь*/
object_hash CHAR(32) NOT NULL DEFAULT '',/*хэш объекта в котором находится пользователь сейчас*/
PRIMARY KEY (session_id)
) ENGINE=MEMORY;
--                              
DROP TABLE IF EXISTS #PX#_users_groups;
--
CREATE TABLE #PX#_users_groups (
gid SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор группы */
group_name VARCHAR(30) NOT NULL DEFAULT 'GroupName', /*имя группы*/
group_color MEDIUMINT UNSIGNED NOT NULL DEFAULT 0) ENGINE=INNODB COMMENT='Users ACL';
--
DROP TABLE IF EXISTS #PX#_users_warnings;
-- 
CREATE TABLE #PX#_users_warnings (
wid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Warning ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Warning add time",
uid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "To who this warning was sended",
msg	VARCHAR(400) NOT NULL DEFAULT '' COMMENT "Moderator message",  
moderator_uid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Moderator UID"
) ENGINE='INNODB' COMMENT="Site users warnings";
--
DROP TABLE IF EXISTS #PX#_users_private_chats;
--
CREATE TABLE #PX#_users_private_chats (
chatid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор чата */ 
owner INT UNSIGNED NOT NULL DEFAULT 0, /* владелец чата */
recipient INT UNSIGNED NOT NULL DEFAULT 0, /* получатель сообщений чата */
last_message CHAR(47) NOT NULL DEFAULT '', /* последнее сообщение в этом чате */
messages MEDIUMINT UNSIGNED NOT NULL DEFAULT 0, /* количество сообщений в данном потоке */
upd_time INT UNSIGNED NOT NULL DEFAULT 0, /* время последнего обновления в данном чате */
unread SMALLINT UNSIGNED NOT NULL DEFAULT 0, /* количество не прочитанных сообщений */
outgoing BOOL NOT NULL DEFAULT FALSE
) ENGINE='INNODB' COMMENT="User chats";
--
DROP TABLE IF EXISTS #PX#_users_private_messages;
--
CREATE TABLE #PX#_users_private_messages ( 
msgid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор сообщения*/
chatid_A INT UNSIGNED NOT NULL DEFAULT 0, /* идентификатор чата */
chatid_B INT UNSIGNED NOT NULL DEFAULT 0, 
add_time INT UNSIGNED NOT NULL DEFAULT 0, /*  время отправления сообщения */
sender INT UNSIGNED NOT NULL DEFAULT 0, /* отправитель сообщения */
content TEXT, 
active_flag TINYINT UNSIGNED NOT NULL DEFAULT 3 /* активно и для отправителя и для получателя */
) ENGINE='INNODB' COMMENT="Users private mails";
--
DROP TABLE IF EXISTS #PX#_users_cookies;
--
CREATE TABLE #PX#_users_cookies ( 
cookie_session VARCHAR(32) NOT NULL DEFAULT '' COMMENT "User session id",
uid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "User ID",
browser CHAR(32) NOT NULL DEFAULT '' COMMENT "Browser identification hash",
act_time TIMESTAMP COMMENT "Last time when somebody access this session",
PRIMARY KEY (cookie_session)
) ENGINE=INNODB COMMENT="Store authorization cookies";
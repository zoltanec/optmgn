DROP TABLE IF EXISTS mmg_users_pm;
CREATE TABLE mmg_users_pm ( msgid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,/*идентификатор сообщения*/
                            uid_from INT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор первого пользователя*/
                            uid_to INT UNSIGNED NOT NULL DEFAULT 0,/*идентификатор второго пользователя*/
                            update_time INT UNSIGNED NOT NULL DEFAULT 0, /*время последнего сообщения*/
                            create_time INT UNSIGNED NOT NULL DEFAULT 0, /*время создания*/
                            title VARCHAR(250) NOT NULL DEFAULT '',/*заголовок*/
                            readed BOOL NOT NULL DEFAULT FALSE, /* прочел ли адресат сообщение*/
                            message TEXT) ENGINE=INNODB COMMENT='Users private mail.';
                            
DROP TABLE IF EXISTS mmg_users;
CREATE TABLE mmg_users (uid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,/*идентификатор пользователя*/
                        regtime INT UNSIGNED NOT NULL DEFAULT 0,/*время регистрации пользователя*/
                        username VARCHAR(60) NOT NULL DEFAULT '',/*имя пользователя*/
                        password VARCHAR(32) NOT NULL DEFAULT '',/*пароль пользователя*/
                        password_joomla VARCHAR(100) NOT NULL DEFAULT '',/*пароль пользователя из джумлы*/
                        password_phpbb VARCHAR(100) NOT NULL DEFAULT '',/*пароль пользователя из phpbb*/
                        email VARCHAR(80) NOT NULL DEFAULT '',/*емейл пользователя*/
                        icq VARCHAR(100) NOT NULL DEFAULT '',/*номер аськи*/
                        avatar VARCHAR(30) NOT NULL DEFAULT '',/*аватарка пользователя*/
                        
                        user_from VARCHAR(25) NOT NULL DEFAULT '',/*откуда пользователь*/ 
                        skype VARCHAR(35) NOT NULL DEFAULT '',/*скайп пользователя*/
                        interests VARCHAR(50) NOT NULL DEFAULT '',/*интересы*/
                        
                        messages INT UNSIGNED NOT NULL DEFAULT 0,/*количество*/
                        karma SMALLINT UNSIGNED NOT NULL DEFAULT 0,/* карма пользователя*/
                        karma_update INT UNSIGNED NOT NULL DEFAULT 0,/*время последнего использования кармы*/
                        
                        sex CHAR(1) NOT NULL DEFAULT 'M', /*пол человека*/
                        birth DATE NOT NULL DEFAULT '0000-00-00',/*дата рождения*/
                        birth_visibility BOOL NOT NULL DEFAULT true,/* отображать ли дату рождения*/
                        
                        warnings TINYINT UNSIGNED NOT NULL DEFAULT 0,/*количество предупреждений пользователю*/
                        
                        about TEXT,/*небольшая информация пользователя о себе*/
) ENGINE=INNODB COMMENT='CMS Users List';

DROP TABLE IF EXISTS mmg_users_private_chats;
CREATE TABLE mmg_users_private_chats (chatid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор чата */ 
                                      owner INT UNSIGNED NOT NULL DEFAULT 0, /* владелец чата */
                                      recipient INT UNSIGNED NOT NULL DEFAULT 0, /* получатель сообщений чата */
                                      last_message CHAR(47) NOT NULL DEFAULT '', /* последнее сообщение в этом чате */
                                      messages MEDIUMINT UNSIGNED NOT NULL DEFAULT 0, /* количество сообщений в данном потоке */
                                      upd_time INT UNSIGNED NOT NULL DEFAULT 0, /* время последнего обновления в данном чате */
                                      outgoing BOOL NOT NULL DEFAULT FALSE) ENGINE='INNODB' COMMENT='User chats';


DROP TABLE IF EXISTS mmg_users_private_messages;
CREATE TABLE mmg_users_private_messages ( msgid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор сообщения*/
                                      chatid_A INT UNSIGNED NOT NULL DEFAULT 0, /* идентификатор чата */
                                      chatid_B INT UNSIGNED NOT NULL DEFAULT 0, 
                                      add_time INT UNSIGNED NOT NULL DEFAULT 0, /*  время отправления сообщения */
                                      sender INT UNSIGNED NOT NULL DEFAULT 0, /* отправитель сообщения */
                                      content TEXT, 
                                      active_flag TINYINT UNSIGNED NOT NULL DEFAULT 3 /* активно и для отправителя и для получателя */
                                      ) ENGINE='INNODB' COMMENT='Users private mails';
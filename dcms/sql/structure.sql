DROP TABLE IF EXISTS mmg_comments_meta;
CREATE TABLE mmg_comments_meta (object_hash CHAR(32) NOT NULL DEFAULT '',/*идентификатор*/
                                object_id CHAR(60) NOT NULL DEFAULT '',/*путь к объекту*/
                                first INT UNSIGNED NOT NULL DEFAULT 0,/*первый комментарий*/
                                readonly BOOL NOT NULL DEFAULT FALSE, /*комментарии только для просмотра*/
                                editable BOOL NOT NULL DEFAULT TRUE, /*можно ли редактировать комментарии у данного объекта*/
                                lastchange TIMESTAMP,/*время добавления последнего комментария*/
                                comments INT UNSIGNED NOT NULL DEFAULT 0,/*количество сообщений в базе данных*/
                                PRIMARY KEY (object_hash));
                                
                             

                                  
                                  
                                
DROP TABLE IF EXISTS mmg_site_log;

ALTER TABLE mmg_lng_messages ADD column javascript BOOL NOT NULL DEFAULT FALSE;
DROP TABLE IF EXISTS vpn_static_pages;
CREATE TABLE sb_static_pages ( content_id SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор контента */
                                content_name VARCHAR(50) NOT NULL DEFAULT '', /* идентификатор документа */
                                content_type VARCHAR(30) NOT NULL DEFAULT 'text/html',   /* тип контента */
                                lang VARCHAR(2) NOT NULL DEFAULT '', /* язык документа*/
                                furl VARCHAR(30) NOT NULL DEFAULT '' ,
                                title VARCHAR(255) NOT NULL DEFAULT '', /* заголовок страницы */
                                description VARCHAR(655) NOT NULL DEFAULT '', /* описание страницы */
                                content TEXT,
                                add_time INT UNSIGNED NOT NULL DEFAULT 0, /* время добавления страницы */
                                upd_time INT UNSIGNED NOT NULL DEFAULT 0, /* время обновления */
                                uid INT UNSIGNED NOT NULL DEFAULT 0, /* идентификатор пользователя добавившего страницу */
                                keywords VARCHAR(100) NOT NULL DEFAULT '', /* ключевые слова */
                                metatags VARCHAR(100) NOT NULL DEFAULT '', /* мета теги */
                                active BOOL NOT NULL DEFAULT FALSE,/* активна ли страница */
                                comments BOOL NOT NULL DEFAULT FALSE, /* используются ли комментарии к странице */
                                stat_mode TINYINT UNSIGNED NOT NULL DEFAULT 1, /* режим статистики */
                                INDEX(content_name)) ENGINE=INNODB COMMENT='Static content data.';
                                
DROP TABLE IF EXISTS vpn_static_pages_reads;
CREATE TABLE sb_static_pages_reads ( content_id SMALLINT UNSIGNED NOT NULL DEFAULT 0, /* идентификатор контента */
                                      last_time INT UNSIGNED NOT NULL DEFAULT 0, /* время последнего доступа */
                                      readed INT UNSIGNED NOT NULL DEFAULT 1, /* количество прочтений*/
                                      PRIMARY KEY (content_id)) ENGINE='INNODB' COMMENT='Static content agregated stat.';
                                      
DROP TABLE IF EXISTS vpn_static_pages_reads_detailed;
CREATE TABLE sb_static_pages_reads_detailed (ip INT UNSIGNED NOT NULL DEFAULT 0, /* IP пользователя */
                                              content_id SMALLINT UNSIGNED NOT NULL DEFAULT 0, /* идентификатор контента */
                                              read_time INT UNSIGNED NOT NULL DEFAULT 0 /* время прочтения */) ENGINE='INNODB' COMMENT='Static content reads details.';
DROP TABLE IF EXISTS uszn_children;
CREATE TABLE uszn_children (cid TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* номер ребенка в базе */
							cname VARCHAR(50) NOT NULL DEFAULT '', /* имя ребенка */
							birthdate INT NOT NULL DEFAULT 0, /* дата рождения */
							eyes_color SMALLINT(10) NOT NULL DEFAULT 0,/* цвет глаз */
							hair_color SMALLINT(10) NOT NULL DEFAULT 0,/* цвет бровей */
							kindred SMALLINT(1) NOT NULL DEFAULT 0, /* 1-есть братья и сестры, 0-нет*/
							sex SMALLINT(1) NOT NULL DEFAULT 0, /* пол ребенка 0-девочка, 1-мальчик */
                            form_adoption SMALLINT(1) NOT NULL DEFAULT 0, /* юридическая форма усыновления(удочерения) */
                            description VARCHAR(15) NOT NULL DEFAULT '', /* характеристика */
                            videopassport SMALLINT(1) NOT NULL DEFAULT 0 /* наличие видеопаспорта */) ENGINE=INNODB COMMENT='children base'; 
                            

INSERT INTO uszn_children (cname, birthdate, description) VALUES ('Иванова Танечка',1236416463,'Очень смешной карапуз');

CREATE TABLE uszn_children_photo ( fileid TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* номер файла */
									cid TINYINT UNSIGNED NOT NULL DEFAULT 0, /* номер ребенка в базе */
									filename VARCHAR(50) NOT NULL DEFAULT '', /* имя файла */
									priority TINYINT(100) UNSIGNED NOT NULL DEFAULT 0, /* приоритет показа */
									) ENGINE=INNODB;
CREATE TABLE uszn_children_media ( fileid TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* номер файла */
									cid TINYINT UNSIGNED NOT NULL DEFAULT 0, /* номер ребенка в базе */
									filename VARCHAR(50) NOT NULL DEFAULT '', /* имя файла */
									filetype VARCHAR(6) NOT NULL DEFAULT 'flv', /* тип файла */
									filecont VARCHAR(50) NOT NULL DEFAULT '', /* содержимое файла */
									flag VARCHAR(20) NOT NULL DEFAULT 'downloaded' /* этапы обработки */
									) ENGINE=INNODB;								
									     
DROP TABLE IF EXISTS uszn_faq_section;
CREATE TABLE uszn_faq_section (sid TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор раздела*/
						       sname VARCHAR(50) NOT NULL DEFAULT ''/* имя раздела */) ENGINE=INNODB COMMENT='faq_section';
                                                                                 
INSERT INTO uszn_faq_section (sname) VALUES 
('О социальной помощи'), ('Дотации государства'), ('Пенсионный фонд');

DROP TABLE IF EXISTS uszn_faq;
CREATE TABLE uszn_faq (qid TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор вопроса*/
 							   sid TINYINT UNSIGNED NOT NULL DEFAULT 0, /* идентификатор раздела*/
							   pid TINYINT UNSIGNED NOT NULL DEFAULT 0, /* идентификатор отца*/
						       qname VARCHAR(600) NOT NULL DEFAULT '',/*вопрос*/
						       qcontent TEXT NOT NULL DEFAULT '',/*ответ*/
						       views INT UNSIGNED NOT NULL DEFAULT 0,
						       rank TINYINT UNSIGNED NOT NULL DEFAULT 0) ENGINE=INNODB COMMENT='faq';
                                                                                 
INSERT INTO uszn_faq (sid,pid,qname) VALUES 
(1,0,'Сколько можно издеваться над народом?'), (2,0,'Всех на кол?'), (1,0,'Пенсионный фонд, как влияет инфляция?'),
(1,1,'Сколько можно издеваться над народом?'), (1,3,'Всех на кол?'), (3,1,'Пенсионный фонд, как влияет инфляция?');
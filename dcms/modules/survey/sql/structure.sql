/**
 * Список обследований
 * */
DROP TABLE IF EXISTS mmg_surveys_all;
CREATE TABLE mmg_surveys_all (sid SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор обследования */
                              name VARCHAR(50) NOT NULL DEFAULT '', /* название обследования */
                              descr TEXT /* описание опроса */
                             ) ENGINE='INNODB' COMMENT='All surveys';
INSERT INTO mmg_surveys_all (sid,name,descr) VALUES (1,'Опрос о работе сервиса', 'Я что то хотел у вас спросить но что уже не помню');
                             
/**
 * Список возможных режимов вопросов:
 * 0 - пользователь вводит текст в данное поле;
 * 1 - checkbox - пользователь может выбрать несколько вариантов, без возможности указать свой вариант;
 * 2 - checkbox + свой вариант.
 * 3 - radio , пользователь выбирает вариант, без ввода своего варианта;
 * 4 - radio + свой вариант;
 * 5 - пользователь сам вводит текст ответа;
 */                             
/**
 * Список вопросов для обследования
 */
DROP TABLE IF EXISTS mmg_surveys_questions;
CREATE TABLE mmg_surveys_questions (qid MEDIUMINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор вопроса */
                                    sid SMALLINT UNSIGNED NOT NULL DEFAULT 0, /* идентификатор опроса */
                                    question VARCHAR(400) NOT NULL DEFAULT '', /* непосредственно сам вопрос */
                                    mode TINYINT UNSIGNED NOT NULL DEFAULT 0, /* типы вопроса */
                                    input_tip VARCHAR(200) NOT NULL DEFAULT 0, /* подсказка поля ввода */
                                    variants TEXT /* варианты ответа */
) ENGINE='INNODB' COMMENT='All questions list';
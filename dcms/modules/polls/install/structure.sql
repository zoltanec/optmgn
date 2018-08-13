--
DROP TABLE IF EXISTS #PX#_polls_list;
--
CREATE TABLE #PX#_polls_list (poll_id MEDIUMINT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Unique PollID",
name VARCHAR(70) NOT NULL DEFAULT 'Empty name' COMMENT "Poll name",
active BOOL NOT NULL DEFAULT FALSE COMMENT "Is this poll is active or not",
descr VARCHAR(400) NOT NULL DEFAULT '' COMMENT "Short description of this poll",
priority INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Poll sorting priority, biggest on top",
final_message VARCHAR(400) NOT NULL DEFAULT '' COMMENT "Poll final message"
) ENGINE='INNODB' COMMENT "List of all poll in module";
--
DROP TABLE IF EXISTS #PX#_polls_questions;
--
CREATE TABLE #PX#_polls_questions (qid MEDIUMINT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Unique question ID",
poll_id MEDIUMINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "PollID, which this question belongs to",
catid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Category ID for this question",
question VARCHAR(400) NOT NULL DEFAULT '' COMMENT "Question body",
help VARCHAR(400) NOT NULL DEFAULT '' COMMENT "Question help text",
mode TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Question answers mode",
answers TEXT COMMENT "Answers for this question",
priority INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Sorting priority",
active BOOL NOT NULL DEFAULT FALSE COMMENT "Activity flag"
) ENGINE='INNODB' COMMENT="Polls questions list";
--
DROP TABLE IF EXISTS #PX#_polls_stat;
--
CREATE TABLE #PX#_polls_stat (poll_id MEDIUMINT UNSIGNED PRIMARY KEY COMMENT "Poll id",
starts INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "How many times this poll was started",
finished INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "How many polls was finished"
) ENGINE='INNODB' COMMENT="Polls full stat";
--
DROP TABLE IF EXISTS #PX#_polls_useranswers;
--
CREATE TABLE #PX#_polls_useranswers (
aid MEDIUMINT UNSIGNED AUTO_INCREMENT COMMENT "Answer id for mode unique ids",
qid MEDIUMINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Question ID",
poll_id MEDIUMINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Poll_id of this question, only for speed up",
uid INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "User ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "When this answer was maked",
think_time SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "How many time user thinks on this question first time",
answers_list VARCHAR(300) NOT NULL DEFAULT '' COMMENT "List of answers maked by user",
own_answer TEXT COMMENT "Entered by user answer",
PRIMARY KEY (aid,qid,uid)
) ENGINE='INNODB' COMMENT="Answers for questions";
--
DROP VIEW IF EXISTS #PX#_polls_answers_for_polls;
--
CREATE OR REPLACE VIEW #PX#_polls_answers_for_polls AS
SELECT c.poll_id, b.uid, b.about, b.sex, b.username, b.birth, b.user_from, CONCAT(c.poll_id,'-',b.uid) AS t_key, count(1) AS answers, MAX(a.add_time) AS last_time 
FROM #PX#_polls_list c 
LEFT OUTER JOIN #PX#_polls_useranswers a USING (poll_id)
LEFT OUTER JOIN #PX#_users b USING (uid)
WHERE  a.uid IS NOT NULL
GROUP BY t_key;
--
DROP TABLE IF EXISTS #PX#_polls_questions_categories;
--
CREATE TABLE #PX#_polls_questions_categories (catid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Category ID",
poll_id MEDIUMINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Poll to which this category belongs",
name VARCHAR(100) NOT NULL DEFAULT '' COMMENT "Category name",
descr TEXT COMMENT "Category descriptions"
) ENGINE='INNODB' COMMENT="Questions categories";
--
DROP TABLE IF EXISTS #PX#_polls_links;
--
CREATE TABLE #PX#_polls_links (lid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Link ID",
object_id VARCHAR(100) COMMENT "Some AnswerObject or other id.",
resource_id VARCHAR(100) COMMENT "Human readable url-identificator"
) ENGINE='INNODB' COMMENT="Polls links";

--
DROP TABLE #PX#_analytics_vars;
--
CREATE TABLE xn_analytics_vars (var CHAR(200) NOT NULL DEFAULT 'EMPTY' COMMENT "Variable name",
tdate DATE NOT NULL DEFAULT '1970-01-01' COMMENT "When this variable was calculated",
version SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Variable version",
val VARCHAR(100) NOT NULL DEFAULT '' COMMENT "Variable stored value",
PRIMARY KEY (var,tdate,version)) ENGINE='INNODB' COMMENT "Analytics variables";
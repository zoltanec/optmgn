---
DROP TABLE IF EXISTS #PX#_slider_slideshow;
---
CREATE TABLE #PX#_slider_slideshow (
	ssid INT(10) unsigned NOT NULL AUTO_INCREMENT COMMENT "Uniq slide ID",
	slider_id int(10) unsigned NOT NULL DEFAULT 0 COMMENT "ID of slider",
	add_time INT(10) unsigned NOT NULL DEFAULT '0' COMMENT "Slide add time",
	active tinyint(1) NOT NULL DEFAULT '1',
	title VARCHAR(100) NOT NULL DEFAULT '',
	video tinyint(1) NOT NULL DEFAULT '0' COMMENT "Is this a video slide",
	short varchar(200) NOT NULL DEFAULT '' COMMENT "Short slide description",
	url varchar(100) NOT NULL DEFAULT '' COMMENT "Url to which this slide redirects",
	priority smallint(6) NOT NULL DEFAULT '0',
	image varchar(70) NOT NULL DEFAULT '' COMMENT "Image file",
	PRIMARY KEY (ssid)
)ENGINE='InnoDB' DEFAULT CHARSET='utf8';
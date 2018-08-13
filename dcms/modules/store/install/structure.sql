
--
DROP TABLE IF EXISTS #PX#_store_products;
--
CREATE TABLE #PX#_store_products (
prod_id int(10) unsigned NOT NULL AUTO_INCREMENT,
prod_code varchar(100) NOT NULL,
export_code CHAR(32) NOT NULL DEFAULT '' COMMENT "MD5 for foreign export ID's",
article_id int(10) unsigned DEFAULT '0',
category_id smallint(5) unsigned NOT NULL DEFAULT '0',
available int(10) unsigned NOT NULL DEFAULT '0',
prod_name varchar(100) NOT NULL DEFAULT '',
short_name VARCHAR(100) NOT NULL DEFAULT '' COMMENT "Product short name",
price smallint(10) unsigned NOT NULL DEFAULT '0',
priority SMALLINT NOT NULL DEFAULT 0,
active BOOL NOT NULL DEFAULT TRUE,
producer_id smallint(10) unsigned NOT NULL DEFAULT '0',
discount_id smallint(10) unsigned NOT NULL DEFAULT '0',
rate tinyint(1) unsigned NOT NULL DEFAULT '0',
descr text NOT NULL,
units varchar(100) NOT NULL DEFAULT '',
delivery tinyint(1) NOT NULL DEFAULT '1',
bestseller tinyint(1) NOT NULL DEFAULT '0',
psc INT NOT NULL DEFAULT 6 COMMENT "Количесво в порции (psc=pieces))",
mix TEXT COMMENT "Product mix",
weight INT UNSIGNED NOT NULL DEFAULT 0,
add_time int(10) NOT NULL DEFAULT '0',
upd_time int(10) NOT NULL DEFAULT '0',
title VARCHAR(400) NOT NULL DEFAULT '' COMMENT "Page title",
PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
--
DROP TABLE IF EXISTS #PX#_store_products_units;
--
CREATE TABLE #PX#_store_products_units (
unit_id int(10) unsigned NOT NULL AUTO_INCREMENT,
unit_name varchar(100) NOT NULL,
PRIMARY KEY (unit_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
--
DROP TABLE IF EXISTS #PX#_store_products_units;
--
CREATE TABLE #PX#_store_products_units (
unit_id int(10) unsigned NOT NULL AUTO_INCREMENT,
unit_name varchar(100) NOT NULL DEFAULT '',
PRIMARY KEY (unit_id)) ENGINE=InnoDB;
--
DROP TABLE IF EXISTS #PX#_store_categories;
--
CREATE TABLE #PX#_store_categories (
category_id smallint(5) unsigned NOT NULL AUTO_INCREMENT,
category_pid smallint(5) unsigned NOT NULL DEFAULT '0',
category_name varchar(40) NOT NULL DEFAULT '',
descr varchar(500) NOT NULL DEFAULT '',
active BOOL NOT NULL DEFAULT FALSE,
category_code varchar(100) NOT NULL,
category_logo varchar(100) NOT NULL,
export_code CHAR(32) NOT NULL DEFAULT '' COMMENT "MD5 Hash for outside export",
priority MEDIUMINT NOT NULL DEFAULT 0,
custom_tpl BOOL NOT NULL DEFAULT FALSE COMMENT "Does this category use custom template",
PRIMARY KEY (category_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Categories List' AUTO_INCREMENT=7 ;
--
DROP TABLE IF EXISTS #PX#_store_categories_fields;
--
CREATE TABLE #PX#_store_categories_fields (catid SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Category field",
code VARCHAR(30) NOT NULL DEFAULT '' COMMENT "Property code",
ptype CHAR(5) NOT NULL DEFAULT 'list',
data TEXT COMMENT "List values or any other such info"
) ENGINE='INNODB' COMMENT="Additional fields";
--
DROP TABLE IF EXISTS #PX#_store_categories_fields_values;
--
CREATE TABLE #PX#_store_categories_fields_values (
prod_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Product ID",
code VARCHAR(30) NOT NULL DEFAULT "Property code",
content TEXT COMMENT "Properties content"
) ENGINE='INNODB';
--
DROP TABLE IF EXISTS #PX#_store_producers;
--
CREATE TABLE #PX#_store_producers (
  `producer_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` smallint(5) unsigned DEFAULT '0',
  `producer_name` varchar(50) NOT NULL DEFAULT '',
  `descr` text NOT NULL,
  PRIMARY KEY (`producer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Producer List';
--
DROP TABLE IF EXISTS #PX#_store_users;
--
CREATE TABLE #PX#_store_users (
uid int(10) unsigned PRIMARY KEY AUTO_INCREMENT,
fullname varchar(200) NOT NULL DEFAULT '',
address varchar(250) NOT NULL DEFAULT '',
subscribe BOOL NOT NULL DEFAULT 0,
delivery INT UNSIGNED NOT NULL DEFAULT 0,
phone VARCHAR(12) NOT NULL DEFAULT ''
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Users List';
--
DROP TABLE IF EXISTS #PX#_store_order_contains;
--
CREATE TABLE #PX#_store_order_contains (
order_id int(10) unsigned NOT NULL,
pack_id INT unsigned NOT NULL COMMENT "Packet with stuff identificator",
hash VARCHAR(50) NOT NULL DEFAULT '' COMMENT "Product hash",
prod_id int(10) unsigned NOT NULL,
quantity int(10) unsigned NOT NULL DEFAULT 1,
meta TEXT COMMENT "Base64 serialized data of products",
price DOUBLE(7,2) NOT NULL DEFAULT 0.0 COMMENT "Order item price", 
 descr VARCHAR(100) NOT NULL DEFAULT '' COMMENT "Item description",
PRIMARY KEY (order_id, pack_id, hash)) ENGINE=InnoDB;
--
DROP TABLE IF EXISTS #PX#_store_orders;
--
CREATE TABLE #PX#_store_orders (
order_id int(10) unsigned NOT NULL AUTO_INCREMENT,
active tinyint(1) unsigned NOT NULL DEFAULT '1',
order_name varchar(500) NOT NULL,
order_address varchar(500) NOT NULL,
order_phone varchar(100) NOT NULL,
uid INT UNSIGNED NOT NULL DEFAULT 0,
add_time int(11) NOT NULL DEFAULT 0,
upd_time INT UNSIGNED NOT NULL DEFAULT 0,
status SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Current execution status",
description TEXT COMMENT "Additional information about client order",
delivery INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Delivery mode, 0 means self delivery",
payment INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Payment mode",
code VARCHAR(10) NOT NULL DEFAULT 'AAAAA' COMMENT "Order code",
PRIMARY KEY (`order_id`)) ENGINE='INNODB' COMMENT="List of site orders";
--
DROP TABLE IF EXISTS #PX#_store_lists;
--
CREATE TABLE #PX#_store_lists (prod_id  INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Product ID",
name CHAR(30) NOT NULL DEFAULT '' COMMENT "List name",
priority SMALLINT NOT NULL DEFAULT 0 COMMENT "Sorting priority",
PRIMARY KEY (prod_id, name)) ENGINE='INNODB' COMMENT 'Lists of products by text ID';
--
DROP TABLE IF EXISTS #PX#_store_bids_sessions;
--
CREATE TABLE #PX#_store_bids_sessions (prod_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Product ID",
str_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Auction start time",
cls_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Auction close time",
status INT UNSIGNED NOT NULL DEFAULT 0,
start_price DOUBLE(7,2) NOT NULL DEFAULT 0.0 COMMENT "Start price",
last_price  DOUBLE(7,2) NOT NULL DEFAULT 0.0 COMMENT "Last stake",
step DOUBLE(7,2) NOT NULL DEFAULT 0.0 COMMENT "Stakes step",
PRIMARY KEY (prod_id)) ENGINE='INNODB'; 
--
DROP TABLE IF EXISTS #PX#_store_bids_stakes;
--
CREATE TABLE #PX#_store_bids_stakes (stid BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
prod_id INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Product ID",
owner VARCHAR(30) NOT NULL DEFAULT 'xxxx',
price DOUBLE(7,2) NOT NULL DEFAULT 0.0 COMMENT "Stake price",
add_time INT UNSIGNED NOT NULL DEFAULT 0) ENGINE='INNODB';
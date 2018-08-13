--
DROP TABLE IF EXISTS #PX#_payments_orders;
--
CREATE TABLE #PX#_payments_orders (ordid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Payment order id",
uri TEXT COMMENT "CMS object ID",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Order add time",
upd_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Order update time",
status TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Order status",
psys VARCHAR(20) NOT NULL DEFAULT '' COMMENT "Payment system",
sum DOUBLE(8,3) NOT NULL DEFAULT 0 COMMENT "Invoce amount",
userdescr TEXT COMMENT "Some information about this order",
descr TEXT COMMENT "Additional order information from payment systems") ENGINE='INNODB';
--
DROP TABLE IF EXISTS #PX#_payments_callbacks;
--
CREATE TABLE #PX#_payments_callbacks (cbid INT UNSIGNED PRIMARY KEY AUTO_INCREMENT COMMENT "Callback uniq ID",
psys VARCHAR(20) NOT NULL DEFAULT '' COMMENT "Paysystem name",
add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Callback execution time",
data TEXT COMMENT "Callback content") ENGINE='INNODB' COMMENT='Paysystems callbacks dumps';
---
---Migration PAGES from v0.1.2 to v0.1.3
---
ALTER TABLE  #PX#_static_pages ADD parent_id SMALLINT UNSIGNED NOT NULL DEFAULT '0' COMMENT "айди родительского документа" AFTER content_id;
ALTER TABLE  #PX#_static_pages ADD pagetitle VARCHAR( 100 ) NOT NULL DEFAULT '' COMMENT "заголовок страницы" AFTER description;
ALTER TABLE  #PX#_static_pages ADD menutitle VARCHAR( 50 ) NOT NULL DEFAULT '' COMMENT "заголовок в меню" AFTER pagetitle;
ALTER TABLE  #PX#_static_pages ADD priority SMALLINT(6) NOT NULL DEFAULT '0' COMMENT "приоритет" AFTER active;
ALTER TABLE  #PX#_static_pages ADD link_attributes VARCHAR( 100 ) NOT NULL COMMENT "аттрибуты ссылки" AFTER  metatags;
ALTER TABLE  #PX#_static_pages ADD template  VARCHAR( 50 ) NOT NULL DEFAULT '' COMMENT "приоритет" AFTER link_attributes;
ALTER TABLE  #PX#_static_pages ADD menu  TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT "показывать документ в меню сайта(фронтенд)" AFTER active;
ALTER TABLE  #PX#_static_pages ADD redirect TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT "Ссылка через редирект" AFTER link_attributes;
ALTER TABLE  #PX#_static_pages CHANGE  content_name  alias VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '';
---
---Migration MEDIA from v0.1.1 to v0.1.2
---
ALTER TABLE #PX#_media_dirs ADD COLUMN title varchar(255) NOT NULL DEFAULT '' COMMENT "заголовок окна страницы дирректории" AFTER descr;
ALTER TABLE #PX#_media_dirs ADD COLUMN description varchar(655) NOT NULL DEFAULT '' COMMENT "описание страницы файла" AFTER title;
ALTER TABLE #PX#_media_dirs ADD COLUMN keywords VARCHAR(100) NOT NULL DEFAULT '' COMMENT "ключевые слова" AFTER upd_time;
ALTER TABLE #PX#_media_dirs ADD COLUMN metatags VARCHAR(100) NOT NULL DEFAULT '' COMMENT "мета теги" AFTER keywords;
---
ALTER TABLE #PX#_media_files ADD COLUMN title varchar(255) NOT NULL DEFAULT '' COMMENT "заголовок окна страницы файла" AFTER descr;
ALTER TABLE #PX#_media_files ADD COLUMN description varchar(655) NOT NULL DEFAULT '' COMMENT "описание страницы файла" AFTER title;
ALTER TABLE #PX#_media_files ADD COLUMN keywords VARCHAR(100) NOT NULL DEFAULT '' COMMENT "ключевые слова" AFTER upd_time;
ALTER TABLE #PX#_media_files ADD COLUMN metatags VARCHAR(100) NOT NULL DEFAULT '' COMMENT "мета теги" AFTER keywords;
ALTER TABLE #PX#_media_files ADD COLUMN variants TEXT AFTER priority;
ALTER TABLE #PX#_media_files ADD COLUMN file_alt VARCHAR(50) COMMENT "тег альт изображения" AFTER description;
ALTER TABLE #PX#_media_files ADD COLUMN file_title VARCHAR(50) COMMENT "тег тайтл изображения" AFTER file_alt;
---
---Migration MEDIA from v0.0.1 to v0.1.2
---
ALTER TABLE  #PX#_media_files CHANGE  addtime  add_time INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0'
ALTER TABLE  #PX#_media_files CHANGE  updtime  upd_time INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0'

UPDATE  #PX#_media_dirs SET  parentid =  'site' WHERE  dirid =  'root' LIMIT 1
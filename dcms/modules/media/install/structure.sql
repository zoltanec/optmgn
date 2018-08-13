--
DROP TABLE IF EXISTS #PX#_media_dirs;
--
CREATE TABLE IF NOT EXISTS #PX#_media_dirs (
dirid varchar(100) NOT NULL DEFAULT '' COMMENT "уникальный идентификатор, Media dir unique ID",
parentid varchar(100) NOT NULL DEFAULT 'root' COMMENT "идентификатор родителя, Parent media dir ID",
dirname varchar(60) NOT NULL DEFAULT '' COMMENT "имя директории",
descr varchar(400) NOT NULL DEFAULT '' COMMENT "описание дирректории",
add_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT "время добавления",
upd_time int(10) unsigned NOT NULL DEFAULT '0' COMMENT "время обновления",
active tinyint(1) NOT NULL DEFAULT '1' COMMENT "активность дирректории",
priority SMALLINT NOT NULL DEFAULT 0 COMMENT "приоритет директории",
watermark_enable tinyint(1) NOT NULL DEFAULT '1' COMMENT "водяной знак",
template VARCHAR(45) NOT NULL DEFAULT '' COMMENT "шаблон отображения для директории",
PRIMARY KEY (dirid)
) ENGINE='InnoDB' COMMENT="Site media";
--
INSERT INTO #PX#_media_dirs (dirid, parentid, dirname, addtime, updtime, descr, active, watermark_enable) VALUES
('root', 'site', 'Галерея', 0, 0, '', 1, 0);
--
DROP TABLE IF EXISTS #PX#_media_files;
--
CREATE TABLE IF NOT EXISTS #PX#_media_files (
fileid varchar(100) NOT NULL DEFAULT 'empty' COMMENT "уникальный идентификатор файла и имя в ФС",
parentid varchar(100) NOT NULL DEFAULT 'root' COMMENT "уникальный идентификатор родительской директории",
filename varchar(100) NOT NULL DEFAULT '' COMMENT "название файла используется как подпись к файлу",
filesize int(10) unsigned NOT NULL DEFAULT '0' COMMENT "размер файла в байтах",
descr text COMMENT "Описание файла",
add_time int(10) unsigned NOT NULL DEFAULT '0',
upd_time int(10) unsigned NOT NULL DEFAULT '0',
preview varchar(40) NOT NULL DEFAULT '',
active tinyint(1) NOT NULL DEFAULT '1' COMMENT "активное состояние файла",
type varchar(10) NOT NULL COMMENT "тип файла: картинка, звук, видео",
priority smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT "приоритет директории",
PRIMARY KEY (fileid,parentid)
) ENGINE='InnoDB' COMMENT="Site media";
--
DROP TABLE IF EXISTS #PX#_media_dirs_stat;
--
CREATE TABLE #PX#_media_dirs_stat (
dirid VARCHAR(100) NOT NULL DEFAULT '' COMMENT "уникальный идентификатор директории",
pictures_count MEDIUMINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "количество картинок",
videos_count MEDIUMINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "количество видео",
audios_count MEDIUMINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "количество звуков",
subdirs_count SMALLINT UNSIGNED NOT NULL DEFAULT 0 COMMENT "количество вложенных каталогов",
PRIMARY KEY(dirid)
) ENGINE='INNODB' COMMENT='Media dirs statistics';
--
DROP TABLE IF EXISTS #PX#_media_files_stat;
--
CREATE TABLE IF NOT EXISTS #PX#_media_files_stat (
fileid char(32) NOT NULL,
show int(10) unsigned NOT NULL DEFAULT '0',
comments int(10) unsigned NOT NULL DEFAULT '0',
UNIQUE KEY fileid (fileid)
) ENGINE='InnoDB' ROW_FORMAT=FIXED COMMENT='Media files statistics';
--
DROP TABLE IF EXISTS #PX#_media_dirs_updates;
--
CREATE TABLE #PX#_media_dirs_updates (
dirid VARCHAR(100) NOT NULL DEFAULT '' COMMENT "в какой директории было обновление",
updated_dirid VARCHAR(100) NOT NULL DEFAULT '' COMMENT "какая вложенная директория получила апдейт",
updated_fileid varchar(100) NOT NULL DEFAULT '' COMMENT "какой файл был обновлен"
) ENGINE='INNODB' COMMENT='Media dirs updates';
--
DROP TABLE #PX#_media_files_convert;
--
CREATE TABLE #PX#_media_files_convert (
convert_id INT PRIMARY KEY AUTO_INCREMENT,
input VARCHAR(150) NOT NULL DEFAULT '',
output VARCHAR(150) NOT NULL DEFAULT '',
type VARCHAR(10) NOT NULL DEFAULT 'flv' COMMENT "тип в который конвертируем"
) ENGINE='INNODB' COMMENT='Dirs convert file';
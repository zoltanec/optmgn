DROP TABLE mmg_uploader_files;
CREATE TABLE mmg_uploader_files (fid MEDIUMINT UNSIGNED PRIMARY KEY AUTO_INCREMENT, /* идентификатор файла */
                                 size INT UNSIGNED NOT NULL DEFAULT 0, 
)
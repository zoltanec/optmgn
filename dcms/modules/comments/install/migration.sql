ALTER TABLE mmg_users ADD COLUMN reg_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "User registration time";
UPDATE mmg_users SET reg_time = regtime;
ALTER TABLE mmg_comments_all ADD COLUMN add_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Comment add time, unixtime";
ALTER TABLE mmg_comments_all ADD upd_time INT UNSIGNED NOT NULL DEFAULT 0 COMMENT "Last comment update time";
UPDATE mmg_comments_all SET upd_time = updtime, addtime = add_time;
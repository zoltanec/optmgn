CREATE TABLE IF NOT EXISTS `uszn_tree` (
  `did` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `pid` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `dname` text NOT NULL,
  `dcontent` text NOT NULL,
  `priority` smallint(4) NOT NULL,
  PRIMARY KEY (`did`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='docs list' AUTO_INCREMENT=149 ;
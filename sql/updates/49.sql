ALTER TABLE `f_forums` CHANGE `quick_reply` `quick_reply` TINYINT( 1 ) NOT NULL DEFAULT '0';
UPDATE `f_forums` SET `quick_reply` = 0 ;

CREATE TABLE `f_attachs` (
  `attach_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attach_file` varchar(255) CHARACTER SET cp1251 NOT NULL,
  `attach_location` varchar(255) CHARACTER SET cp1251 NOT NULL,
  `attach_hits` int(10) NOT NULL DEFAULT '0',
  `attach_date` int(10) NOT NULL,
  `attach_tid` int(10) unsigned NOT NULL DEFAULT '0',
  `attach_member_id` int(8) unsigned NOT NULL,
  `attach_filesize` int(10) unsigned NOT NULL,
  PRIMARY KEY (`attach_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

ALTER TABLE `account_groups` ADD `g_use_attach` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `g_delete_own_topics` ;
UPDATE `account_groups` SET `g_use_attach` = '1' WHERE `account_groups`.`g_id` =2 LIMIT 1 ;
UPDATE `account_groups` SET `g_use_attach` = '1' WHERE `account_groups`.`g_id` =3 LIMIT 1 ;
UPDATE `account_groups` SET `g_use_attach` = '1' WHERE `account_groups`.`g_id` =4 LIMIT 1 ;

INSERT INTO `site_settings` (`key`, `value`, `desc`, `type`) VALUES 
('attachs_path', 'images/attachs/', 'attachs dir', 'string'),
('max_attachs_size', '10485760', 'space for attachs per each user', 'int'),
('allowed_attachs', 'jpg|gif|png|rar|zip|doc|txt|pdf|chm|torrent', 'alowed attach ext', 'string');
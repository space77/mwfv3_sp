DROP TABLE IF EXISTS `f_categories`;
DROP TABLE IF EXISTS `f_forums`;
DROP TABLE IF EXISTS `f_markread`;
DROP TABLE IF EXISTS `f_posts`;
DROP TABLE IF EXISTS `f_topics`;
DROP TABLE IF EXISTS `online`;
DROP TABLE IF EXISTS `pms`;
DROP TABLE IF EXISTS `site_regkeys`;
DROP TABLE IF EXISTS `site_settings`;

ALTER TABLE realmlist ADD `dbinfo` varchar(255) DEFAULT NULL;

CREATE TABLE `f_categories` (
  `cat_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL DEFAULT 'New Category',
  `cat_disp_position` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `f_forums` (
  `forum_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `forum_name` varchar(255) NOT NULL DEFAULT 'New forum',
  `forum_desc` varchar(255) DEFAULT NULL,
  `redirect_url` varchar(200) DEFAULT NULL,
  `moderators` varchar(255) DEFAULT NULL,
  `num_topics` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `num_posts` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `last_topic_id` int(10) unsigned DEFAULT NULL,
  `disp_position` smallint(6) NOT NULL DEFAULT '0',
  `quick_reply` tinyint(1) NOT NULL DEFAULT '0',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `hidden` tinyint(1) NOT NULL DEFAULT '0',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`forum_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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

CREATE TABLE `f_markread` (
  `marker_member_id` int(8) unsigned NOT NULL DEFAULT '0',
  `marker_forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  `marker_last_update` int(10) unsigned NOT NULL DEFAULT '0',
  `marker_unread` smallint(5) NOT NULL DEFAULT '0',
  `marker_topics_read` text NOT NULL,
  `marker_last_cleared` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `marker_forum_id` (`marker_forum_id`,`marker_member_id`),
  KEY `marker_member_id` (`marker_member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `f_posts` (
  `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poster` varchar(30) NOT NULL,
  `poster_id` int(8) unsigned NOT NULL DEFAULT '0',
  `poster_ip` varchar(15) DEFAULT NULL,
  `message` text NOT NULL,
  `posted` int(10) unsigned NOT NULL DEFAULT '0',
  `edited` int(10) unsigned DEFAULT NULL,
  `edited_by` varchar(30) DEFAULT NULL,
  `topic_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `f_topics` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `topic_poster_id` int(8) unsigned NOT NULL,
  `topic_name` varchar(255) NOT NULL,
  `topic_posted` int(10) unsigned NOT NULL DEFAULT '0',
  `last_post` int(10) unsigned NOT NULL DEFAULT '0',
  `last_post_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_poster` varchar(200) DEFAULT NULL,
  `num_views` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `num_replies` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `closed` tinyint(1) NOT NULL DEFAULT '0',
  `sticky` tinyint(1) NOT NULL DEFAULT '0',
  `redirect_url` varchar(200) DEFAULT NULL,
  `forum_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `online` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user_name` varchar(200) NOT NULL DEFAULT 'Guest',
  `user_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `logged` int(10) NOT NULL DEFAULT '0',
  `currenturl` varchar(255) NOT NULL DEFAULT './',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `pms` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(8) unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) NOT NULL,
  `message` text,
  `sender_id` int(8) unsigned NOT NULL DEFAULT '0',
  `posted` int(10) unsigned NOT NULL DEFAULT '0',
  `sender_ip` varchar(15) DEFAULT '0.0.0.0',
  `showed` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `site_regkeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(40) NOT NULL,
  `used` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `site_settings` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'string',
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `site_settings` (`key`, `value`, `desc`, `type`) VALUES 
('max_accounts_per_ip', '0', 'desc', 'int'),
('req_reg_invite', '0', 'desc', 'int'),
('posts_per_page', '12', 'desc', 'int'),
('topics_per_page', '16', 'desc', 'int'),
('users_per_page', '30', 'desc', 'int'),
('posts_per_star1', '1', 'desc', 'int'),
('posts_per_star2', '30', 'desc', 'int'),
('posts_per_star3', '120', 'desc', 'int'),
('posts_per_star4', '250', 'desc', 'int'),
('posts_per_star5', '500', 'desc', 'int'),
('site_title', 'WoW site', 'desc', 'string'),
('site_encoding', 'utf-8', 'desc', 'string'),
('site_cookie', 'wowuservarsv3', 'desc', 'string'),
('site_email', 'email@yourdomain.net', 'desc', 'string'),
('smtp_adress', '', 'desc', 'string'),
('smtp_username', '', 'desc', 'string'),
('smtp_password', '', 'desc', 'string'),
('max_avatar_size', '64x64', 'desc', 'string'),
('max_avatar_file', '102400', 'desc', 'string'),
('change_email', '1', 'desc', 'bool'),
('change_pass', '0', 'desc', 'bool'),
('req_reg_key', '0', 'desc', 'bool'),
('req_reg_act', '0', 'desc', 'bool'),
('change_template', '0', 'desc', 'bool'),
('default_component', 'frontpage', 'desc', 'string'),
('avatar_path', 'images/avatars/', 'desc', 'string'),
('smiles_path', 'images/smiles/', 'desc', 'string'),
('debuginfo', '0', 'desc', 'bool'),
('onlinelist_on', '0', 'desc', 'bool'),
('attachs_path', 'images/attachs/', 'attachs dir', 'string'),
('max_attachs_size', '10485760', 'space for attachs per each user', 'int'),
('allowed_attachs', 'jpg|gif|png|rar|zip|doc|txt|pdf|chm|torrent', 'alowed attach ext', 'string');
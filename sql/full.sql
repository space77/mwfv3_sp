-- Создание новых таблиц --
DROP TABLE IF EXISTS `account_extend`;
CREATE TABLE `account_extend` (                              
  `account_id` int(11) unsigned NOT NULL,                    
  `g_id` smallint(5) unsigned NOT NULL DEFAULT '2',          
  `avatar` varchar(60) DEFAULT NULL,                         
  `gender` tinyint(4) NOT NULL DEFAULT '0',                  
  `homepage` varchar(100) DEFAULT NULL,                      
  `icq` varchar(12) DEFAULT NULL,                            
  `location` varchar(50) DEFAULT NULL,                       
  `signature` text,                                          
  `hideemail` tinyint(1) NOT NULL DEFAULT '1',               
  `hideprofile` tinyint(1) NOT NULL DEFAULT '0',             
  `theme` smallint(5) unsigned NOT NULL DEFAULT '0',         
  `forum_posts` int(10) unsigned NOT NULL DEFAULT '0',       
  `registration_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',  
  `activation_code` varchar(40) DEFAULT NULL,                
  `userbar` varchar(100) DEFAULT NULL,                       
  PRIMARY KEY (`account_id`)                                 
) ENGINE=MyISAM DEFAULT CHARSET=utf8;    
INSERT INTO `account_extend` (`account_id`) SELECT account.id FROM account;

DROP TABLE IF EXISTS `account_groups`;
CREATE TABLE `account_groups` (                         
  `g_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,  
  `g_title` varchar(32) NOT NULL,                       
  `g_prefix` char(6) DEFAULT NULL,                      
  `g_is_admin` tinyint(1) DEFAULT '0',                  
  `g_is_supadmin` tinyint(1) DEFAULT '0',               
  `g_use_search` tinyint(1) DEFAULT '0',                
  `g_view_profile` tinyint(1) DEFAULT '0',              
  `g_post_new_topics` tinyint(1) DEFAULT '0',           
  `g_reply_other_topics` tinyint(1) DEFAULT '0',        
  `g_edit_own_posts` tinyint(1) DEFAULT '0',            
  `g_delete_own_posts` tinyint(1) DEFAULT '0',          
  `g_delete_own_topics` tinyint(1) DEFAULT '0',         
  `g_use_attach` tinyint(1) NOT NULL DEFAULT '0',       
  `g_forum_moderate` tinyint(1) NOT NULL DEFAULT '0',   
  `g_use_pm` tinyint(1) DEFAULT '0',                    
  `g_gal_view` tinyint(1) NOT NULL DEFAULT '0',         
  `g_gal_upload` tinyint(1) DEFAULT '0',                
  `g_gal_download` tinyint(1) DEFAULT '0',              
  `g_gal_moderate` tinyint(1) DEFAULT '0',              
  `g_gal_balanceon` tinyint(1) NOT NULL DEFAULT '0',    
  PRIMARY KEY (`g_id`)                                  
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
INSERT INTO `account_groups` (`g_id`, `g_title`, `g_prefix`, `g_is_admin`, `g_is_supadmin`, `g_use_search`, `g_view_profile`, `g_post_new_topics`, `g_reply_other_topics`, `g_edit_own_posts`, `g_delete_own_posts`, `g_delete_own_topics`, `g_use_attach`, `g_forum_moderate`, `g_use_pm`, `g_gal_view`, `g_gal_upload`, `g_gal_download`, `g_gal_moderate`, `g_gal_balanceon`) VALUES 
(1, 'Guests', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(2, 'Members', NULL, 0, 0, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 1, 1, 0, 1),
(3, 'Administrators', '+', 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(4, 'Root Admins', '&#165;', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(5, 'Banned', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

DROP TABLE IF EXISTS `f_attachs`;
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
) ENGINE=MyISAM AUTO_INCREMENT=129 DEFAULT CHARSET=utf8; 

DROP TABLE IF EXISTS `f_categories`;
CREATE TABLE `f_categories` (                               
  `cat_id` smallint(5) NOT NULL AUTO_INCREMENT,             
  `cat_name` varchar(255) NOT NULL DEFAULT 'New Category',  
  `cat_disp_position` int(10) NOT NULL DEFAULT '0',         
  PRIMARY KEY (`cat_id`)                                    
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `f_forums`;
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
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;  

DROP TABLE IF EXISTS `f_markread`;
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

DROP TABLE IF EXISTS `f_posts`;
f_posts  CREATE TABLE `f_posts` (                                   
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
) ENGINE=MyISAM AUTO_INCREMENT=15504 DEFAULT CHARSET=utf8;  

DROP TABLE IF EXISTS `f_topics`;
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
) ENGINE=MyISAM AUTO_INCREMENT=2135 DEFAULT CHARSET=utf8; 

DROP TABLE IF EXISTS `gallery_scr`;
CREATE TABLE `gallery_scr` (                                               
  `id` int(3) NOT NULL AUTO_INCREMENT,                                      
  `img` text NOT NULL,                                                      
  `orgfname` text NOT NULL,                                                 
  `comment` text NOT NULL,                                                  
  `autor` text NOT NULL,                                                    
  `autorid` bigint(20) unsigned NOT NULL,                                   
  `date` date NOT NULL,                                                     
  UNIQUE KEY `id` (`id`)                                                    
) ENGINE=MyISAM AUTO_INCREMENT=188 DEFAULT CHARSET=utf8;   

DROP TABLE IF EXISTS `gallery_wallp`;
CREATE TABLE `gallery_wallp` (                                             
  `id` int(3) NOT NULL AUTO_INCREMENT,                                     
  `img` text NOT NULL,                                                     
  `orgfname` text NOT NULL,                                                
  `autor` text NOT NULL,                                                   
  `autorid` bigint(20) unsigned NOT NULL,                                  
  `date` date NOT NULL,                                                    
  UNIQUE KEY `id` (`id`)                                                   
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;  

DROP TABLE IF EXISTS `online`;
CREATE TABLE `online` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `user_name` varchar(200) NOT NULL DEFAULT 'Guest',
  `user_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `logged` int(10) NOT NULL DEFAULT '0',
  `currenturl` varchar(255) NOT NULL DEFAULT './',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `pms`;
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
) ENGINE=MyISAM AUTO_INCREMENT=1248 DEFAULT CHARSET=utf8;  

DROP TABLE IF EXISTS `site_regkeys`;
CREATE TABLE `site_regkeys` (            
  `id` int(11) NOT NULL AUTO_INCREMENT,  
  `key` varchar(40) NOT NULL,            
  `used` tinyint(1) DEFAULT '0',         
  PRIMARY KEY (`id`)                     
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `site_settings`;
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
('allowed_attachs', 'jpg|gif|png|rar|zip|doc|txt|pdf|chm|torrent', 'alowed attach ext', 'string'),
('show_location','0','desc','bool'),
('used_userbar','1','desc','bool'),
('chars_rename_enable','1','desc','bool'),
('chars_rename_cost','1000000','desc','int'),
('chars_rename_hdiff','720','desc','int'),
('chars_changesex_enable','1','desc','bool'),
('chars_changesex_cost','1000000','desc','int'),
('chars_changesex_hdiff','720','desc','int'),
('chars_move_enable','0','desc','bool'),
('chars_move_cost','1000000','desc','int'),
('chars_change_enable','0','desc','bool'),
('chars_change_cost','1000000','desc','int');

CREATE TABLE `mwfe3_ban_actions` (                                                       
  `id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Global Unique Identifier',         
  `name` varchar(256) NOT NULL DEFAULT '' COMMENT 'Character Global Unique Identifier',  
  `ip` varchar(32) NOT NULL DEFAULT '0.0.0.0',
  `timeaction` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',                         
  `action` varchar(256) NOT NULL DEFAULT '',                                             
  `type` varchar(256) NOT NULL DEFAULT '',                                               
  `typeval` varchar(256) NOT NULL DEFAULT '',                                            
  `result` varchar(11) NOT NULL DEFAULT '',                                              
  `resultmsg` longtext                                                                   
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='MWFE3 SYSTEM';

-- Модификация существующих таблиц --
alter table `realmlist`
  add column `CharacterDatabaseInfo` varchar (255) DEFAULT '127.0.0.1;3306;root;mangos;characters' NULL  COLLATE utf8_general_ci, 
	add column `WorldDatabaseInfo` varchar (255) DEFAULT '127.0.0.1;3306;root;mangos;mangos' NULL  COLLATE utf8_general_ci,
  add column `Version` int (11) DEFAULT '243' NULL  after `WorldDatabaseInfo`,
  add column `WowdCharInfoLink` varchar (255)  NULL  after `Version`,
  add column `cloneid` int(11)  DEFAULT '-1' NOT NULL after `WowdCharInfoLink`,
  add column `raport` int(11) DEFAULT '3443' NOT NULL after `cloneid`;	
	

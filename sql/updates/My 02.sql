DROP TABLE IF EXISTS `gallery_scr`;
CREATE TABLE `gallery_scr` (                                               
  `id` int(3) NOT NULL auto_increment,                                     
  `img` text NOT NULL,                                                     
  `orgfname` text NOT NULL,                                                
  `comment` text NOT NULL,                                                 
  `autor` text NOT NULL,                                                   
  `autorid` bigint(20) unsigned NOT NULL,                                  
   `date` date NOT NULL,                                                    
   UNIQUE KEY `id` (`id`)                                                   
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC  


DROP TABLE IF EXISTS `gallery_wallp`;
CREATE TABLE IF NOT EXISTS `gallery_wallp` (
  `id` int(3) NOT NULL auto_increment,
  `img` text NOT NULL,
  `orgfname` text NOT NULL,
  `autor` text NOT NULL,
  `autorid` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=3 ;

DROP TABLE IF EXISTS  `mwfe3_ban_actions`;
CREATE TABLE `mwfe3_ban_actions` (                                                       
                     `id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Global Unique Identifier',         
                     `name` varchar(256) NOT NULL DEFAULT '' COMMENT 'Character Global Unique Identifier',  
                     `timeaction` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',                         
                     `action` varchar(256) NOT NULL DEFAULT '',                                             
                     `type` varchar(256) NOT NULL DEFAULT '',                                               
                     `typeval` varchar(256) NOT NULL DEFAULT '',                                            
                     `result` varchar(11) NOT NULL DEFAULT '',                                              
                     `resultmsg` longtext                                                                   
                   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='MWFE3 SYSTEM';

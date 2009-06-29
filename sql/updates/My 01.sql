alter table `realmlist`
	change `dbinfo` `CharacterDatabaseInfo` varchar (255) DEFAULT '127.0.0.1;3306;root;mangos;characters' NULL  COLLATE utf8_general_ci 

alter table `realmlist` 
	add column `WorldDatabaseInfo` varchar (255) DEFAULT '127.0.0.1;3306;root;mangos;mangos' NULL  COLLATE utf8_general_ci  after `CharacterDatabaseInfo`
	
replace into `site_settings`(`key`,`value`,`desc`,`type`) values ( 'show_location','1','desc','bool')

alter table `mwfe3_ban_actions` add column `ip` varchar(32) CHARSET utf8 COLLATE utf8_general_ci DEFAULT '0.0.0.0' NOT NULL after `name`;
